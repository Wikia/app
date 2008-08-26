<?php
/**
 * Translations of Translate extension.
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$messages = array();

/** English
 * @author Nike
 */
$messages['en'] = array(
	'translate'         => 'Translate',
	'translate-desc'    => '[[Special:Translate|Special page]] for translating MediaWiki and beyond',
	'translate-edit'    => 'edit',
	'translate-talk'    => 'talk',
	'translate-history' => 'history',

	'translate-task-view'           => 'View all messages from',
	'translate-task-untranslated'   => 'View all untranslated messages from',
	'translate-task-optional'       => 'View optional messages from',
	'translate-task-problematic'    => 'View messages that have problems',
	'translate-task-review'         => 'Review changes to',
	'translate-task-reviewall'      => 'Review all translated messages in',
	'translate-task-export'         => 'Export translations from',
	'translate-task-export-to-file' => 'Export translation to file from',
	'translate-task-export-as-po'   => 'Export translation in Gettext format',
	'translate-task-export-to-xliff'=> 'Export translation in Xliff format',

	'translate-page-no-such-language' => 'Specified language was invalid.',
	'translate-page-no-such-task'     => 'Specified task was invalid.',
	'translate-page-no-such-group'    => 'Specified group was invalid.',

	'translate-page-disabled'  => "Translations to this language in this group has been disabled. Reason:

''$1''",

	'translate-page-settings-legend' => 'Settings',
	'translate-page-task'            => 'I want to',
	'translate-page-group'           => 'Group',
	'translate-page-language'        => 'Language',
	'translate-page-limit'           => 'Limit',
	'translate-page-limit-option'    => '$1 {{PLURAL:$1|message|messages}} per page',
	'translate-submit'               => 'Fetch',

	'translate-page-navigation-legend' => 'Navigation',
	'translate-page-showing'           => 'Showing messages from $1 to $2 of $3.',
	'translate-page-showing-all'       => 'Showing $1 {{PLURAL:$1|message|messages}}.',
	'translate-page-showing-none'      => 'No messages to show.',
	'translate-page-paging-links'      => '[ $1 ] [ $2 ]',
	'translate-next'                   => 'Next page',
	'translate-prev'                   => 'Previous page',

	'translate-page-description-legend' => 'Information about the group',
	'translate-page-edit'               => 'edit',

	'translate-optional' => '(optional)',
	'translate-ignored'  => '(ignored)',

	'translate-edit-definition'         => 'Message definition',
	'translate-edit-contribute'         => 'contribute',
	'translate-edit-no-information'     => "''This message has no documentation.
If you know where or how this message is used, you can help other translators by adding documentation to this message.''",
	'translate-edit-information'        => 'Information about this message ($1)',
	'translate-edit-in-other-languages' => 'Message in other languages',
	'translate-edit-committed'          => 'Current translation in software',
	'translate-edit-warnings'           => 'Warnings about incomplete translations',

	'translate-edit-goto-no-prev'       => 'No previous message',
	'translate-edit-goto-no-next'       => 'No next message',
	'translate-edit-goto-prev'          => 'Edit previous message',
	'translate-edit-goto-next'          => 'Edit next message',
	'translate-edit-goto-list'          => 'Back to the list',

	'translate-magic-pagename'    => 'Extended MediaWiki translation',
	'translate-magic-help'        => 'You can translate special pages aliases, magic words, skin names and namespace names.

In magic words you need to include English translations or they stop working.
Also leave the first item (0 or 1) as it is.

Special page aliases and magic words can have multiple translations.
Translations are seperated by a comma (,).
Skin names and namespaces can have only one translation.

In namespace translations <tt>$1 talk</tt> is special. <tt>$1</tt> is replaced with sitename (for example <tt>{{SITENAME}} talk</tt>).
If it is not possible in your language to form valid expression without changing sitename, please contact a developer.

You need to be in the translators group to save changes.
Changes are not saved until you click save button below.',
	'translate-magic-module'      => 'Module:',
	'translate-magic-submit'      => 'Fetch',
	'translate-magic-cm-export'   => 'Export', // cm- should be removed

	'translate-magic-cm-to-be'    => 'To-be',
	'translate-magic-cm-current'  => 'Current',
	'translate-magic-cm-original' => 'Original',

	'translate-magic-cm-comment' => 'Comment:',
	'translate-magic-cm-save'    => 'Save',

	'translate-magic-cm-updatedusing' => 'Updated using [[Special:Magic]]',
	'translate-magic-cm-savefailed'   => 'Save failed',

	'translate-magic-special'   => 'Special page aliases',
	'translate-magic-words'     => 'Magic words',
	'translate-magic-skin'      => 'Skins name',
	'translate-magic-namespace' => 'Namespace names',

	'translationchanges'        => 'Translation changes',
	'translationchanges-export' => 'export',
	'translationchanges-change' => '$1: $2 by $3',

	'translate-checks-parameters'         => 'Following {{PLURAL:$2|parameter is|parameters are}} not used:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown' => 'Following {{PLURAL:$2|parameter is|parameters are}} unknown:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'            => 'There is uneven amount of {{PLURAL:$2|parentheses|parentheses}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'              => 'Following {{PLURAL:$2|link is|$2 links are}} problematic:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'              => 'Please replace the following {{PLURAL:$2|tag|tags}} with correct ones:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'             => 'Definition uses <nowiki>{{PLURAL:}}</nowiki> but translation does not.',
	'translate-checks-pagename'           => 'Namespace changed from the definition',

	'tog-translate-nonewsletter' => 'Do not send me e-mail newsletters (relevant only for users with a confirmed e-mail address)',
	'right-translate'            => 'Edit using the translate interface',

	'translate-rc-translation-filter' => 'Filter translations:',
	'translate-rc-translation-filter-no' => 'Do nothing',
	'translate-rc-translation-filter-only' => 'Show translations only',
	'translate-rc-translation-filter-filter' => 'Filter out translations',
	'translate-rc-translation-filter-site' => 'Changes to site messages only',

	'translationstats' => 'Translation statistics',

	'translate-stats-edits' => 'Edits',
	'translate-stats-users' => 'Translators',

	'translate-statsf-intro' => 'You can generate simple statistics with this form. All values have upper and lower limits.',
	'translate-statsf-options' => 'Graph options',
	'translate-statsf-width' => 'Width in pixels',
	'translate-statsf-height' => 'Height in pixels',
	'translate-statsf-days' => 'Time period in days',
	'translate-statsf-scale' => 'Granularity',
	'translate-statsf-scale-days' => 'Days',
	'translate-statsf-scale-hours' => 'Hours',
	'translate-statsf-count' => 'Measure',
	'translate-statsf-count-edits' => 'Number of edits',
	'translate-statsf-count-users' => 'Active translators',
	'translate-statsf-language' => 'Comma seperated list of language codes',
	'translate-statsf-group' => 'Comma separated list of group codes',
	'translate-statsf-submit' => 'Preview',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'translate-edit'      => "a'tū'ạki",
	'translate-talk'      => 'hạifäeaga',
	'translate-page-edit' => "a'tū'ạki",
);

/** Karelian (Karjala)
 * @author Flrn
 */
$messages['krl'] = array(
	'translate-edit'                   => 'muokkaus',
	'translate-talk'                   => 'pagin',
	'translate-page-navigation-legend' => 'Valličy',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'translate-talk'             => 'каҥашымаш',
	'translate-magic-cm-save'    => 'Аралаш',
	'tog-translate-nonewsletter' => 'Увер бюллетеньым электрон почто дене мылам колташ огыл (ушнышо-влаклан тергыме электрон почто адресышт дене гына)',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'translate-edit'                   => 'fakahakohako',
	'translate-history'                => 'liu onoono atu ki tua',
	'translate-page-navigation-legend' => 'Navikati',
);

/** Afrikaans (Afrikaans)
 * @author SPQRobin
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'translate'                         => 'Vertaal',
	'translate-desc'                    => '[[Special:Translate|Spesiale bladsy]] vir vertaal van MediaWiki en meer',
	'translate-edit'                    => 'wysig',
	'translate-talk'                    => 'bespreking',
	'translate-history'                 => 'geskiedenis',
	'translate-task-view'               => 'alle boodskappe bekyk van',
	'translate-task-untranslated'       => 'alle onvertaalde boodskappe bekyk van',
	'translate-task-optional'           => 'opsionele boodskappe bekyk van',
	'translate-task-problematic'        => 'boodskappe met probleme bekyk',
	'translate-task-review'             => 'Hersien wysigings aan',
	'translate-task-reviewall'          => 'Hersien alle vertalings in',
	'translate-page-settings-legend'    => 'Verstellings',
	'translate-page-task'               => 'Ek wil',
	'translate-page-group'              => 'Groep',
	'translate-page-language'           => 'Taal',
	'translate-page-limit'              => 'Limiet',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|boodskap|boodskappe}} per bladsy',
	'translate-submit'                  => 'Gaan haal',
	'translate-page-navigation-legend'  => 'Navigasie',
	'translate-page-showing'            => 'Wys boodskappe van $1 tot $2 uit $3.',
	'translate-page-showing-all'        => 'Wys $1 {{PLURAL:$1|boodskap|boodskappe}}.',
	'translate-page-showing-none'       => 'Geen boodskappe om te wys nie.',
	'translate-next'                    => 'Volgende bladsy',
	'translate-prev'                    => 'Vorige bladsy',
	'translate-page-description-legend' => 'Inligting oor hierdie groep',
	'translate-page-edit'               => 'wysig',
	'translate-optional'                => '(opsioneel)',
	'translate-ignored'                 => '(geïgnoreer)',
	'translate-edit-definition'         => 'Boodskap definisie',
	'translate-edit-contribute'         => 'wysig',
	'translate-edit-information'        => 'Inligting oor hierdie boodskap ($1)',
	'translate-edit-in-other-languages' => 'Boodskap in andere tale',
	'translate-edit-committed'          => 'Huidige vertaling in sagteware',
	'translate-edit-warnings'           => 'Waarskuwings oor onvoltooide vertalings',
	'translate-edit-goto-no-prev'       => 'Geen vorige boodskap',
	'translate-edit-goto-no-next'       => 'Geen volgende boodskap',
	'translate-edit-goto-prev'          => 'Wysig vorige boodskap',
	'translate-edit-goto-next'          => 'Wysig volgende boodkap',
	'translate-edit-goto-list'          => 'Terug na die lys',
	'translate-magic-module'            => 'Module:',
	'translate-magic-submit'            => 'Gaan haal',
	'translate-magic-cm-export'         => 'Eksporteer',
	'translate-magic-cm-current'        => 'Huidig',
	'translate-magic-cm-original'       => 'Oorspronklik',
	'translate-magic-cm-comment'        => 'Samevatting:',
	'translate-magic-cm-save'           => 'Stoor',
	'translate-magic-cm-updatedusing'   => 'Opgedateer deur [[Special:Magic]] te gebruik',
	'translate-magic-namespace'         => 'Naamruimtenamen',
	'translationchanges'                => 'Vertaling wysigings',
	'translationchanges-export'         => 'eksporteer',
	'translate-stats-edits'             => 'Wysigings per dag:',
	'translate-statsf-scale-days'       => 'Dae',
	'translate-statsf-scale-hours'      => 'Ure',
	'translate-statsf-submit'           => 'Voorskou',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 * @author Siebrand
 */
$messages['an'] = array(
	'translate'                         => 'Traduzir',
	'translate-edit'                    => 'editar',
	'translate-talk'                    => 'descutir',
	'translate-history'                 => 'istorial',
	'translate-task-view'               => 'Beyer toz os mensaches de',
	'translate-task-untranslated'       => 'Beyer toz os mensaches sin traduzir de',
	'translate-task-optional'           => 'Beyer os mensaches opzionals de',
	'translate-task-review'             => 'Rebisar cambeos en',
	'translate-task-reviewall'          => 'Rebisar todas as traduzions en',
	'translate-task-export'             => 'Esportar traduzions de',
	'translate-task-export-to-file'     => 'Esportar á un archibo as traduzions de',
	'translate-task-export-as-po'       => 'Esportar traduzión en formato Gettext',
	'translate-page-no-such-language'   => 'O codigo de idioma furnito no ye balido',
	'translate-page-no-such-task'       => 'A faina espezificata no ye correuta.',
	'translate-page-no-such-group'      => 'A colla de mensaches espezificata no ye correuta.',
	'translate-page-settings-legend'    => 'Achustes',
	'translate-page-task'               => 'Quiero',
	'translate-page-group'              => 'Colla',
	'translate-page-language'           => 'Luenga',
	'translate-page-limit'              => 'Limite',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|mensache|mensaches}} por pachina',
	'translate-submit'                  => 'Ir á escar-los',
	'translate-page-navigation-legend'  => 'Nabegazión',
	'translate-page-showing'            => "Amostrando os mensaches $1 á $2 d'un total de $3.",
	'translate-page-showing-all'        => 'Amostrando $1 {{PLURAL:$1|mensache|mensaches}}.',
	'translate-page-showing-none'       => 'No bi ha garra mensache ta amostrar.',
	'translate-next'                    => 'Pachina siguient',
	'translate-prev'                    => 'Pachina anterior',
	'translate-page-description-legend' => 'Informazión sobre a colla de mensaches',
	'translate-optional'                => '(opzional)',
	'translate-ignored'                 => '(no considerato)',
	'translate-magic-pagename'          => 'Traduzión ixamplata de MediaWiki',
	'translate-magic-help'              => "Puede traduzir os \"alias\" d'as pachinas espezials, as palabras machicas, os nombres d'as aparenzias y os espazios de nombres.

En as palabras machicas, ha d'encluyir a traduzión en anglés, porque si no lo fa, no funzionarán bien. Deixe tamién o primer elemento (0 u 1) sin cambiar.

Os alias d'as pachinas espezials y as parabras machicas pueden tener barias traduzions. As traduzions se deseparan por una coma (,). Os nombres d'as aparenzias y d'os espazios de nombres no pueden tener que una unica traduzión.

En as traduzions d'os espazios de nombres <tt>\$1 talk</tt> ye espezial. <tt>\$1</tt> ye escambiata por o nombre d'o sitio (por exemplo <tt>{{SITENAME}} talk</tt>). Si no ye posible en a suya luenga formar una esprisión correuta sin cambiar o nombre d'o sitio, contaute con un programador.

Ha de pertenexer á la colla de tradutors ta alzar os cambeos. Ístos no quedan rechistratos dica que no se puncha en o botón \"Alzar pachina\" que ye en o cobaxo d'a pachina.",
	'translate-magic-submit'            => 'Ir á escar',
	'translate-magic-cm-export'         => 'Esportar',
	'translate-magic-cm-to-be'          => 'Esdebiene',
	'translate-magic-cm-current'        => 'Autual',
	'translate-magic-cm-original'       => 'Orichinal',
	'translate-magic-cm-comment'        => 'Comentario:',
	'translate-magic-cm-save'           => 'Alzar',
	'translate-magic-cm-updatedusing'   => 'Esbiellato usando [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => 'No se podió alzar a pachina',
	'translate-magic-special'           => 'Alias de pachinas espezials',
	'translate-magic-words'             => 'Parabras machicas',
	'translate-magic-skin'              => "Nombres d'aparenzias",
	'translate-magic-namespace'         => 'Espazios de nombres',
	'translationchanges'                => 'Cambeos en a traduzión',
	'translationchanges-export'         => 'esportar',
	'translationchanges-change'         => '$1: $2 por $3',
);

/** Old English (Anglo-Saxon)
 * @author SPQRobin
 */
$messages['ang'] = array(
	'translate-edit'    => 'ādihtan',
	'translate-talk'    => 'mōtung',
	'translate-history' => 'stǣr',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Alnokta
 * @author Siebrand
 * @author ترجمان05
 * @author OsamaK
 */
$messages['ar'] = array(
	'translate'                              => 'ترجمة',
	'translate-desc'                         => '[[Special:Translate|صفحة خاصة]] لترجمة الميدياويكي وما بعده',
	'translate-edit'                         => 'عدل',
	'translate-talk'                         => 'نقاش',
	'translate-history'                      => 'تاريخ',
	'translate-task-view'                    => 'عرض كل الرسائل من',
	'translate-task-untranslated'            => 'عرض كل الرسائل غير المترجمة من',
	'translate-task-optional'                => 'اعرض الرسائل الاختيارية من',
	'translate-task-problematic'             => 'اعرض الرسائل التي بها مشاكل',
	'translate-task-review'                  => 'عرض التغييرات ل',
	'translate-task-reviewall'               => 'عرض كل الترجمات في',
	'translate-task-export'                  => 'صدر الترجمات من',
	'translate-task-export-to-file'          => 'صدر الترجمة لملف من',
	'translate-task-export-as-po'            => 'صدر الترجمة بصيغة جت تكست',
	'translate-task-export-to-xliff'         => 'صدر الترجمة في هيئة Xliff',
	'translate-page-no-such-language'        => 'كود لغة غير صحيح تم توفيره',
	'translate-page-no-such-task'            => 'المهمة المحددة كانت غير صحيحة.',
	'translate-page-no-such-group'           => 'المجموعة المحددة كانت غير صحيحة.',
	'translate-page-disabled'                => "لقد عطّلت التّرجمات إلى هذه اللّغة بالنسبة لهذه المجموعة. السّبب::

''$1''",
	'translate-page-settings-legend'         => 'الإعدادات',
	'translate-page-task'                    => 'أريد',
	'translate-page-group'                   => 'المجموعة',
	'translate-page-language'                => 'اللغة',
	'translate-page-limit'                   => 'الحد',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|رسالة|رسالة}} للصفحة',
	'translate-submit'                       => 'إيجاد',
	'translate-page-navigation-legend'       => 'الإبحار',
	'translate-page-showing'                 => 'عرض الرسائل من $1 إلى $2 ل $3.',
	'translate-page-showing-all'             => 'عرض $1 {{PLURAL:$1|رسالة|رسالة}}.',
	'translate-page-showing-none'            => 'لا رسائل للعرض.',
	'translate-next'                         => 'الصفحة التالية',
	'translate-prev'                         => 'الصفحة السابقة',
	'translate-page-description-legend'      => 'معلومات حول المجموعة',
	'translate-page-edit'                    => 'عدل',
	'translate-optional'                     => '(اختياري)',
	'translate-ignored'                      => '(متجاهل)',
	'translate-edit-definition'              => 'تعريف الرسالة',
	'translate-edit-contribute'              => 'ساهم',
	'translate-edit-no-information'          => "''هذه الرسالة ليس لديها توثيق. لو كنت تعرف أين أو كيف يتم استخدام هذه الرسالة، يمكنك مساعدة المترجمين الآخرين بواسطة إضافة توثيق إلى هذه الرسالة.''",
	'translate-edit-information'             => 'معلومات حول هذه الرسالة ($1)',
	'translate-edit-in-other-languages'      => 'الرسالة بلغات أخرى',
	'translate-edit-committed'               => 'الترجمة الحالية في البرنامج',
	'translate-edit-warnings'                => 'التحذيرات حول الترجمات غير المكتملة',
	'translate-edit-goto-no-prev'            => 'لا رسالة سابقة',
	'translate-edit-goto-no-next'            => 'لا رسالة قادمة',
	'translate-edit-goto-prev'               => 'عدل الرسالة السابقة',
	'translate-edit-goto-next'               => 'عدل الرسالة القادمة',
	'translate-edit-goto-list'               => 'الرجوع إلى القائمة',
	'translate-magic-pagename'               => 'ترجمة الميدياويكي الممتدة',
	'translate-magic-help'                   => 'يمكنك ترجمة أسماء الصفحات الخاصة، الكلمات السحرية، أسماء الواجهات وأسماء النطاقات.

في الكلمات السحرية تحتاج إلى إضافة الترجمات الإنجليزية أو فستتوقف عن العمل.
أيضا اترك المدخل الأول (0 أو 1) كما هو.

أسماء الصفحات الخاصة والكلمات السحرية يمكن أن يكون لها ترجمات متعددة.
الترجمات تفصل بواسطة فاصلة (,).
أسماء الواجهات والنطاقات يمكن أن يكون لها ترجمة واحدة فقط.

في ترجمات النطاقات <tt>$1 talk</tt> خاص. <tt>$1</tt> يتم استبدالها باسم الموقع (على سبيل المثال <tt>{{SITENAME}} talk</tt>).
لو أنه من غير الممكن في لغتك صياغة تعبير صحيح بدون تغيير اسم الموقع، من فضلك اتصل بمطور.

تحتاج إلى أن تكون في مجموعة المترجمين لحفظ التغييرات.
التغييرات لن يتم حفظها حتى تضغط زر الحفظ بالأسفل.',
	'translate-magic-module'                 => 'النوع:',
	'translate-magic-submit'                 => 'إيجاد',
	'translate-magic-cm-export'              => 'تصدير',
	'translate-magic-cm-to-be'               => 'لتصبح',
	'translate-magic-cm-current'             => 'الحالي',
	'translate-magic-cm-original'            => 'الأصلي',
	'translate-magic-cm-comment'             => 'تعليق:',
	'translate-magic-cm-save'                => 'حفظ',
	'translate-magic-cm-updatedusing'        => 'حدث باستخدام [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'الحفظ فشل',
	'translate-magic-special'                => 'أسماء الصفحات الخاصة',
	'translate-magic-words'                  => 'كلمات سحرية',
	'translate-magic-skin'                   => 'أسماء الواجهات',
	'translate-magic-namespace'              => 'أسماء النطاقات',
	'translationchanges'                     => 'تغييرات الترجمة',
	'translationchanges-export'              => 'تصدير',
	'translationchanges-change'              => '$1: $2 بواسطة $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|المحدد التالي غير مستخدم|المحددات التالية غير مستخدمة}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|المحدد التالي غير معروف|المحددات التالية غير معروفة}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'يوجد عدد غير زوجي من {{PLURAL:$2|الأقواس|الأقواس}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|الوصلة|ال$2 وصلة}} التالية بها مشاكل:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'من فضلك استبدل {{PLURAL:$2|بالوسم التالي|بالوسوم التالية}} الوسوم الصحيحة:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'التعريف يستخدم <nowiki>{{PLURAL:}}</nowiki> لكن الترجمة لا.',
	'translate-checks-pagename'              => 'النطاق تغير من التعريف',
	'tog-translate-nonewsletter'             => 'لا ترسل لي إخطارات بريدية بالبريد الإلكتروني (متعلقة فقط بالمستخدمين الذين يمتلكون عنوان بريد الإلكتروني مؤكد)',
	'right-translate'                        => 'التعديل باستخدام واجهة المترجم',
	'translate-rc-translation-filter'        => 'فلتر الترجمات:',
	'translate-rc-translation-filter-no'     => 'لا تفعل شيئا',
	'translate-rc-translation-filter-only'   => 'اعرض الترجمات فقط',
	'translate-rc-translation-filter-filter' => 'فلتر الترجمات',
	'translate-rc-translation-filter-site'   => 'التغييرات لرسائل الموقع فقط',
	'translationstats'                       => 'إحصاءات الترجمة',
	'translate-stats-edits'                  => 'تعديل يوميا',
	'translate-stats-users'                  => 'المترجمون',
	'translate-statsf-intro'                 => 'يمكنك توليد إحصاءات بسيطة بهذه الاستمارة. كل القيم لها حدود عليا وسفلى.',
	'translate-statsf-options'               => 'خيارات الرسم',
	'translate-statsf-width'                 => 'العرض بالبكسل',
	'translate-statsf-height'                => 'الارتفاع بالبكسل',
	'translate-statsf-days'                  => 'فترة زمنية باليوم',
	'translate-statsf-scale'                 => 'التدريج',
	'translate-statsf-scale-days'            => 'أيام',
	'translate-statsf-scale-hours'           => 'ساعات',
	'translate-statsf-count'                 => 'قياس',
	'translate-statsf-count-edits'           => 'عدد التعديلات',
	'translate-statsf-count-users'           => 'المترجمون النشطون',
	'translate-statsf-language'              => 'فاصلة فصلت قائمة أكواد اللغات',
	'translate-statsf-group'                 => 'فاصلة فصلت قائمة أكواد المجموعات',
	'translate-statsf-submit'                => 'عرض مسبق',
);

/** Araucanian (Mapudungun)
 * @author Poquil
 */
$messages['arn'] = array(
	'translate-talk'                => 'dungun',
	'translate-page-showing'        => 'adkintun mensajes del $1 al $2 de $3',
	'translate-page-showing-all'    => 'adkintun $1 {{PLURAL:$1|message|messages}}.',
	'translate-edit-contribute'     => 'ñma',
	'translate-magic-cm-original'   => 'kuse',
	'translate-magic-cm-save'       => 'elkünun',
	'translate-magic-cm-savefailed' => 'elkünun weda',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Siebrand
 */
$messages['ast'] = array(
	'translate'                         => 'Traducir',
	'translate-desc'                    => '[[Special:Translate|Páxina especial]] pa traducir Mediawiki y más',
	'translate-edit'                    => 'editar',
	'translate-talk'                    => 'alderique',
	'translate-history'                 => 'historial',
	'translate-task-view'               => 'Ver tolos mensaxes del',
	'translate-task-untranslated'       => 'Ver tolos mensaxes non traducíos del',
	'translate-task-optional'           => 'Ver los mensaxes opcionales del',
	'translate-task-review'             => 'Revisar los cambeos nel',
	'translate-task-reviewall'          => 'Revisar toles traducciones del',
	'translate-task-export'             => 'Esportar les traducciones del',
	'translate-task-export-to-file'     => 'Esportar a un archivu les traducciones del',
	'translate-task-export-as-po'       => 'Esportar les traducciones en formatu Gettext',
	'translate-page-no-such-language'   => 'La llingua especificada nun foi válida.',
	'translate-page-no-such-task'       => 'El llabor especificáu nun foi válidu.',
	'translate-page-no-such-group'      => 'El grupu especificáu nun foi válidu.',
	'translate-page-settings-legend'    => 'Configuración',
	'translate-page-task'               => 'Quiero',
	'translate-page-group'              => 'Grupu',
	'translate-page-language'           => 'Llingua',
	'translate-page-limit'              => 'Llímite',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|mensaxe|mensaxes}} per páxina',
	'translate-submit'                  => 'Amosar',
	'translate-page-navigation-legend'  => 'Navegación',
	'translate-page-showing'            => 'Amosando mensaxes del $1 al $2 de $3.',
	'translate-page-showing-all'        => 'Amosando $1 {{PLURAL:$1|mensaxe|mensaxes}}.',
	'translate-page-showing-none'       => "Nun hai mensaxes qu'amosar.",
	'translate-next'                    => 'Páxina siguiente',
	'translate-prev'                    => 'Páxina anterior',
	'translate-page-description-legend' => 'Información del grupu',
	'translate-optional'                => '(opcional)',
	'translate-ignored'                 => '(inoráu)',
	'translate-edit-definition'         => 'Definición del mensaxe',
	'translate-edit-contribute'         => 'contribuyir',
	'translate-edit-no-information'     => "''Esti mensaxe nun tien documentación. Si sabes ú o cómo s'usa esti mensaxe, pues aidar a otros traductores amestando documentación a esti mensaxe.''",
	'translate-edit-information'        => 'Información sobre esti mensaxe ($1)',
	'translate-edit-in-other-languages' => "Mensaxe n'otres llingües",
	'translate-edit-committed'          => 'Traducción actual nel software',
	'translate-edit-warnings'           => 'Avisos sobre traducciones incompletes',
	'translate-magic-pagename'          => 'Traducción estendida de MediaWiki',
	'translate-magic-help'              => "Pues traducir los nomes de les páxines especiales, les pallabres máxiques, los nomes de les pieles y los nomes de los espacios de nome.

Nes pallabres máxiques necesites incluyir les traducciones ingleses, o dexarán de furrular. Dexa tamién el primer elementu (0 ó 1) como ta.

Los nomes de les páxines especiales y les pallabres máxiques puen tener múltiples traducciones. Les traducciones sepárense con una coma (,). Los nomes de les pieles y los espacios de nome namái puen tener una traducción.

Nes traducciones de los espacios de nome <tt>$1 talk</tt> ye especial <tt>$1</tt> ye sustituyíu pol nome del sitiu (por exemplu <tt>{{SITENAME}} talk</tt>). Si na to llingua nun ye posible formar una espresión válida ensin camudar el nome del sitiu, por favor contauta con un desenrollador.

Necesites tar nel grupu de traductores pa guardar los cambeos. Los cambeos nun se graben hasta que calques nel botón guardar d'abaxo.",
	'translate-magic-submit'            => 'Amosar',
	'translate-magic-cm-export'         => 'Esportar',
	'translate-magic-cm-to-be'          => 'Propuesta',
	'translate-magic-cm-current'        => 'Actual',
	'translate-magic-cm-original'       => 'Orixinal',
	'translate-magic-cm-comment'        => 'Comentariu:',
	'translate-magic-cm-save'           => 'Guardar',
	'translate-magic-cm-updatedusing'   => 'Actualizao usando [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => "Falló'l guardáu",
	'translate-magic-special'           => 'Nomes de páxines especiales',
	'translate-magic-words'             => 'Pallabres máxiques',
	'translate-magic-skin'              => 'Nomes de pieles',
	'translate-magic-namespace'         => "Nomes d'espacios de nome",
	'translationchanges'                => 'Cambeos de traducción',
	'translationchanges-export'         => 'esportar',
	'translationchanges-change'         => '$1: $2 por $3',
	'translate-checks-parameters'       => "Los siguientes parámetros nun s'usen: <strong>$1</strong>",
	'translate-checks-balance'          => 'Hai un númberu impar de paréntesis: <strong>$1</strong>',
	'translate-checks-links'            => 'Los siguientes enllaces son problemáticos: <strong>$1</strong>',
	'translate-checks-xhtml'            => 'Por favor sustitúi les siguientes etiquetes coles correutes: <strong>$1</strong>',
	'translate-checks-plural'           => 'La definición usa <nowiki>{{PLURAL:}}</nowiki> pero la traducción non.',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'translate-checks-parameters' => 'ای پارامتران استفاده نه بیتگن: <strong>$1</strong>',
	'translate-checks-links'      => 'جهلگی لینکانء مشکل اش هست: <strong>$1</strong>',
	'translate-checks-xhtml'      => 'لطفا ای جهلگی برچسپانء گون درستین ان جاه په جاه کنیت: <strong>$1</strong>',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'translate'                     => 'Sangliân',
	'translate-edit'                => 'hirahón',
	'translate-talk'                => 'magtaram',
	'translate-history'             => 'historya',
	'translate-task-view'           => 'Hilingón an gabos na mga mensahe poon',
	'translate-task-untranslated'   => 'Hilingón an gabos na mga dai nasangliân na mensahe poon',
	'translate-task-review'         => 'Reparohon an mga pagbabâgo sa',
	'translate-task-reviewall'      => 'Reparohon an gabos na mga pagsanglî sa',
	'translate-task-export'         => 'Ipadara an mga pagsanglî halî sa',
	'translate-task-export-to-file' => 'Ipadara an pagsanglî sa file halî sa',
	'translate-submit'              => 'Kûanón',
	'translate-next'                => 'Sunod na páhina',
	'translate-prev'                => 'Nakaaging páhina',
	'translate-optional'            => '(opsyonal)',
	'translate-magic-submit'        => 'Kûanón',
	'translate-magic-cm-export'     => 'Ipadara',
	'translate-magic-cm-current'    => 'Presente',
	'translate-magic-cm-original'   => 'Orihinal',
	'translate-magic-cm-save'       => 'Itagama',
	'translate-magic-cm-savefailed' => 'Bigô an pagtagama',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'translate'                            => 'Пераклад',
	'translate-edit'                       => 'рэдагаваць',
	'translate-talk'                       => 'абмеркаваньне',
	'translate-history'                    => 'гісторыя',
	'translate-task-export'                => 'Экспартаваць пераклады',
	'translate-task-export-to-file'        => 'Экспартаваць пераклады ў файл',
	'translate-task-export-as-po'          => 'Экспартаваць пераклады ў фармаце gettext',
	'translate-page-task'                  => 'Я хачу',
	'translate-page-group'                 => 'Група',
	'translate-page-language'              => 'Мова',
	'translate-page-limit-option'          => '$1 {{PLURAL:$1|паведамленьне|паведамленьні|паведамленьняў}} на старонцы',
	'translate-page-navigation-legend'     => 'Навігацыя',
	'translate-next'                       => 'Наступная старонка',
	'translate-prev'                       => 'Папярэдняя старонка',
	'translate-page-description-legend'    => 'Інфармацыя пра групу',
	'translate-edit-information'           => 'Інфармацыя пра гэтае паведамленьне ($1)',
	'translate-edit-in-other-languages'    => 'Паведамленьне на іншых мовах',
	'translate-edit-goto-prev'             => 'Рэдагаваць папярэдняе паведамленьне',
	'translate-edit-goto-next'             => 'Рэдагаваць наступнае паведамленьне',
	'translate-magic-cm-comment'           => 'Камэнтар:',
	'translate-rc-translation-filter-only' => 'Паказваць толькі пераклады',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Siebrand
 */
$messages['bg'] = array(
	'translate'                              => 'Превеждане',
	'translate-desc'                         => '[[Special:Translate|Специална страница]] за превеждане на Mediawiki и др.',
	'translate-edit'                         => 'редактиране',
	'translate-talk'                         => 'беседа',
	'translate-history'                      => 'история',
	'translate-task-view'                    => 'Преглед на всички съобщения от',
	'translate-task-untranslated'            => 'Преглед на всички непреведени съобщения от',
	'translate-task-optional'                => 'Преглед на незадължителните съобщения от',
	'translate-task-problematic'             => 'Преглед на съобщенията, които имат проблем',
	'translate-task-review'                  => 'Преглед на променените съобщения в',
	'translate-task-reviewall'               => 'Преглед на всички преводи в',
	'translate-task-export'                  => 'Изнасяне на преводите от',
	'translate-task-export-to-file'          => 'Изнасяне във файл на преведените съобщения от',
	'translate-task-export-as-po'            => 'Изнасяне на превода в Gettext формат',
	'translate-task-export-to-xliff'         => 'Изнасяне на превода в Xliff формат',
	'translate-page-no-such-language'        => 'Избраният език е невалиден.',
	'translate-page-no-such-task'            => 'Избраната задача е невалидна.',
	'translate-page-no-such-group'           => 'Избраната група е невалидна',
	'translate-page-disabled'                => "Преводите на този език в тази група са изключени. Причина:

''$1''",
	'translate-page-settings-legend'         => 'Настройки',
	'translate-page-task'                    => 'Действие:',
	'translate-page-group'                   => 'Група:',
	'translate-page-language'                => 'Език:',
	'translate-page-limit'                   => 'Показване на:',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|съобщение|съобщения}} на страница',
	'translate-submit'                       => 'Извличане',
	'translate-page-navigation-legend'       => 'Навигация',
	'translate-page-showing'                 => 'Показани са съобщения от $1 до $2 от общо $3.',
	'translate-page-showing-all'             => '{{PLURAL:$1|Показано е 1 съобщение|Показани са $1 съобщения}}.',
	'translate-page-showing-none'            => 'Няма съобщения, които да бъдат показани.',
	'translate-next'                         => 'Следваща страница',
	'translate-prev'                         => 'Предишна страница',
	'translate-page-description-legend'      => 'Информация за групата',
	'translate-page-edit'                    => 'редактиране',
	'translate-optional'                     => '(незадължително)',
	'translate-ignored'                      => '(пренебрегнато)',
	'translate-edit-definition'              => 'Оригинално съобщение',
	'translate-edit-contribute'              => 'добавяне на документация',
	'translate-edit-no-information'          => 'За това съобщение няма документация. Ако знаете къде и как се използва, можете да помогнете на останалите преводачи като добавите документация за това съобщение.',
	'translate-edit-information'             => 'Информация за това съобщение ($1)',
	'translate-edit-in-other-languages'      => 'Това съобщение на други езици',
	'translate-edit-committed'               => 'Текущ превод в софтуера',
	'translate-edit-warnings'                => 'Забележки за непълни преводи',
	'translate-edit-goto-no-prev'            => 'Няма предишно съобщение',
	'translate-edit-goto-no-next'            => 'Няма следващо съобщение',
	'translate-edit-goto-prev'               => 'Редактиране на предишното съобщение',
	'translate-edit-goto-next'               => 'Редактиране на следващото съобщение',
	'translate-edit-goto-list'               => 'Връщане към списъка',
	'translate-magic-pagename'               => 'Разширено превеждане на МедияУики',
	'translate-magic-module'                 => 'Модул:',
	'translate-magic-submit'                 => 'Извличане',
	'translate-magic-cm-export'              => 'Изнасяне',
	'translate-magic-cm-to-be'               => 'Желано',
	'translate-magic-cm-current'             => 'Текущо',
	'translate-magic-cm-original'            => 'Оригинално',
	'translate-magic-cm-comment'             => 'Коментар:',
	'translate-magic-cm-save'                => 'Съхранение',
	'translate-magic-cm-updatedusing'        => 'Обновено чрез [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Съхраняването беше неуспешно',
	'translate-magic-words'                  => 'Вълшебни думички',
	'translate-magic-skin'                   => 'Имена на облици',
	'translate-magic-namespace'              => 'Имена на именни пространства',
	'translationchanges'                     => 'Промени в преводите',
	'translationchanges-export'              => 'изнасяне',
	'translationchanges-change'              => '$1: $2 от $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|Следният параметър не се използва|Следните параметри не се използват}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|Следният параметър е непознат|Следните параметри са непознати}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Съобщението съдържа необичаен брой {{PLURAL:$2|скоби|скоби}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|Следната препратка е проблемна|Следните $2 препратки са проблемни}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Необходимо е заместване на {{PLURAL:$2|посочения етикет с правилен|посочените етикети с правилни}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'Оригиналното съобщение използва <nowiki>{{PLURAL:}}</nowiki>, а преводът — не.',
	'tog-translate-nonewsletter'             => 'Без получаване на бюлетин по е-поща (за потребители с потвърден адрес за е-поща)',
	'right-translate'                        => 'Редактиране чрез интерфейса за превод',
	'translate-rc-translation-filter'        => 'Филтриране на преводите:',
	'translate-rc-translation-filter-no'     => 'Без действие',
	'translate-rc-translation-filter-only'   => 'Само на преводите',
	'translate-rc-translation-filter-filter' => 'Филтриране на преводите',
	'translate-rc-translation-filter-site'   => 'Промени само в съобщенията за сайта',
	'translationstats'                       => 'Статистики за преводите',
	'translate-stats-edits'                  => 'Редакции',
	'translate-stats-users'                  => 'Преводачи',
	'translate-statsf-intro'                 => 'Формулярът по-долу слуижи за създаване на статистика. Всички възможности имат минимални и максимални стойности.',
	'translate-statsf-options'               => 'Графични настройки',
	'translate-statsf-width'                 => 'Ширина в пиксели',
	'translate-statsf-height'                => 'Височина в пиксели',
	'translate-statsf-days'                  => 'Времеви период в дни',
	'translate-statsf-scale-days'            => 'Дни',
	'translate-statsf-scale-hours'           => 'Часове',
	'translate-statsf-count-edits'           => 'Брой редакции',
	'translate-statsf-count-users'           => 'Активни преводачи',
	'translate-statsf-language'              => 'Списък с езикови кодове, разделени със запетаи',
	'translate-statsf-group'                 => 'Списък с групови кодове, разделени със запетаи',
	'translate-statsf-submit'                => 'Преглед',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'translate'                     => 'অনুবাদ করুন',
	'translate-edit'                => 'সম্পাদনা',
	'translate-talk'                => 'আলোচনা',
	'translate-history'             => 'ইতিহাস',
	'translate-task-view'           => 'সমস্ত বার্তা',
	'translate-task-untranslated'   => 'অনুবাদ হয়নি এমন সব বার্তা',
	'translate-task-review'         => 'পরিবর্তনসমূহ পুনর্বিবেচনা',
	'translate-task-reviewall'      => 'সমস্ত অনুবাদ পুনর্বিবেচনা',
	'translate-task-export'         => 'অনুবাদসমুহ প্রেরণ',
	'translate-task-export-to-file' => 'অনুবাদসমূহ ফাইলে প্রেরণ',
	'translate-page-task'           => 'আমি চাই',
	'translate-submit'              => 'বের করো',
	'translate-next'                => 'পরবর্তী পাতা',
	'translate-prev'                => 'পূর্ববর্তী পাতা',
	'translate-optional'            => '(ঐচ্ছিক)',
	'translate-ignored'             => '(উপেক্ষিত)',
);

/** Bishnupriya (ইমার ঠার/বিষ্ণুপ্রিয়া মণিপুরী)
 * @author Usingha
 */
$messages['bpy'] = array(
	'translate' => 'অনুবাদ করিক',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Siebrand
 */
$messages['br'] = array(
	'translate'                              => 'Treiñ',
	'translate-desc'                         => "[[Special:Translate|Pajenn zibar]] evit treiñ Mediawiki ha pelloc'h",
	'translate-edit'                         => 'kemmañ',
	'translate-talk'                         => 'kaozeal',
	'translate-history'                      => 'istor',
	'translate-task-view'                    => 'Welet an holl gemennadennoù evit',
	'translate-task-untranslated'            => 'Welet an holl gemennadennoù didro evit',
	'translate-task-optional'                => 'Welet an holl gemennadennoù diret evit',
	'translate-task-problematic'             => "Gwelet ar c'hemennoù kudennek",
	'translate-task-review'                  => "Adwelet ma c'hemmoù evit",
	'translate-task-reviewall'               => 'Adwelet an holl droidigezhioù evit',
	'translate-task-export'                  => 'Ezporzhiañ an troidigezhioù evit',
	'translate-task-export-to-file'          => 'Ezporzhiañ an troidigezhioù en ur restr adal',
	'translate-task-export-as-po'            => 'Ezporzhiañ an troidigezhioù er furmad Gettext',
	'translate-task-export-to-xliff'         => 'Ezporzhiañ an troidigezhioù er furmad Xliff',
	'translate-page-no-such-language'        => "Merket ez eus bet ur c'hod yezh direizh",
	'translate-page-no-such-task'            => 'Merket ez eus bet un ober direizh',
	'translate-page-no-such-group'           => 'Merket ez eus bet ur strollad direizh',
	'translate-page-disabled'                => "Harpet eo bet an troidigezhioù er yezh-mañ evit ar strollad-mañ. Abeg :

''$1''",
	'translate-page-settings-legend'         => 'Dibaboù',
	'translate-page-task'                    => "C'hoant am eus da",
	'translate-page-group'                   => 'Strollad',
	'translate-page-language'                => 'Yezh',
	'translate-page-limit'                   => 'Bevenn',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|gemennadenn|kemennadenn}} dre bajenn',
	'translate-submit'                       => 'Mont',
	'translate-page-navigation-legend'       => 'Merdeiñ',
	'translate-page-showing'                 => 'O tiskouez kemennadennoù adal $1 betek $2 diwar $3.',
	'translate-page-showing-all'             => 'War wel $1 {{PLURAL:$1|gemennadenn|kemennadenn}}',
	'translate-page-showing-none'            => 'Netra da ziskouez.',
	'translate-next'                         => 'Pajenn da-heul',
	'translate-prev'                         => 'Pajenn gent',
	'translate-page-description-legend'      => 'Titouroù diwar-benn ar strollad',
	'translate-page-edit'                    => 'kemmañ',
	'translate-optional'                     => '(diret)',
	'translate-ignored'                      => '(laosket a-gostez)',
	'translate-edit-definition'              => 'Termenadur ar gemennadenn',
	'translate-edit-contribute'              => 'kemer perzh',
	'translate-edit-no-information'          => "''N'eus tamm titour ebet diwar-benn ar gemennadenn-mañ. Ma ouzit pelec'h pe benaos emañ da vezañ implijet e c'hallit harpañ troourien all en ur ouzhpennañ titouroù diwar he fenn.''",
	'translate-edit-information'             => 'Titouroù diwar-benn ar gemennadenn-mañ ($1)',
	'translate-edit-in-other-languages'      => 'Kemennadenn e yezhoù all',
	'translate-edit-committed'               => 'Troidigezh zo er meziant bremañ',
	'translate-edit-warnings'                => 'Kemennoù diwall diwar-benn an troidigezhioù diglok',
	'translate-edit-goto-no-prev'            => 'Kemennadenn ebet a-raok',
	'translate-edit-goto-no-next'            => "Kemennadenn ebet war-lerc'h",
	'translate-edit-goto-prev'               => "Mont d'ar gemennadenn a-raok",
	'translate-edit-goto-next'               => "Mont d'ar gemennadenn war-lerc'h",
	'translate-edit-goto-list'               => "Distreiñ d'ar roll :",
	'translate-magic-pagename'               => 'Troidigezh Mediawiki astennet',
	'translate-magic-help'                   => "Gallout a rit treiñ aliasoù ar pajennoù dibar, ar gerioù burzhudus, anvioù an etrefasoù hag anvioù an esaouennoù anv.

Evit ar pezh a sell ouzh ar gerioù burzhudus e vo ret deoc'h ouzhpennañ an droidigezh saoznek pe ne'z aint ket en-dro ken. 
Dalc'hit ivez an elfenn gentañ (0 pe 1) evel m'emañ.

Aliasoù ar pajennoù dibar hag ar gerioù burzhudus a c'hall kaout meur a droidigezh. 
Dispartiet eo an troidigezhioù dre skejoù (,). 
N'hall anvioù an etrefasoù ha re an esaouennoù anv nemet kaout un droidigezh hepken.

E troidigezhioù an esaouennoù anv eo dibar <tt>$1 talk</tt>. Erlec'hiet eo <tt>$1</tt> gant anv al lec'hienn (da skouer <tt>{{SITENAME}} talk</tt>). 
Ma n'haller ket sevel lavarennoù reizh en ho yezh hep kemmañ anv al lec'hienn, kit e darempred gant un diorroer.

Ret eo deoc'h bezañ ezel eus ur strollad troerien evit enrollañ ar c'hemmoù. 
Ne vo ket enrollet ar c'hemmoù e-keit ha ne vo ket bet pouezet war ar bouton dindan.",
	'translate-magic-module'                 => 'Modulenn :',
	'translate-magic-submit'                 => 'Mont',
	'translate-magic-cm-export'              => 'Ezporzhiañ',
	'translate-magic-cm-to-be'               => 'A zeu da vezañ',
	'translate-magic-cm-current'             => 'Bremañ',
	'translate-magic-cm-original'            => 'Orin',
	'translate-magic-cm-comment'             => 'Notenn :',
	'translate-magic-cm-save'                => 'Enrollañ',
	'translate-magic-cm-updatedusing'        => 'Hizivaet en ur implijout [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => "C'hwitet enrollañ",
	'translate-magic-special'                => 'Aliasoù pajenn zibar',
	'translate-magic-words'                  => 'Gerioù burzhudus',
	'translate-magic-skin'                   => 'Anvioù an etrefasoù',
	'translate-magic-namespace'              => 'Anv an esaouennoù anv',
	'translationchanges'                     => 'Troidigezhioù bet adwelet',
	'translationchanges-export'              => 'Ezporzhiañ',
	'translationchanges-change'              => '$1: $2 gant $3',
	'translate-checks-parameters'            => 'Ne vez ket graet gant an {{PLURAL:$2|arventenn|arventennoù}} da-heul : <strong>$1</strong>',
	'translate-checks-parameters-unknown'    => 'Dianav eo an {{PLURAL:$2|arventenn|arventennoù}} da-heul :
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Ampar eo an niver a {{PLURAL:$2|grommelloù|grommelloù}} : <strong>$1</strong>',
	'translate-checks-links'                 => 'Kudennek eo al {{PLURAL:$2|liammoù|liammoù}} da-heul : <strong>$1</strong>',
	'translate-checks-xhtml'                 => "Erlec'hiit ar {{PLURAL:$2|valizenn|balizennoù}} da-heul gant ar re a zegouezh mar plij : <strong>$1</strong>",
	'translate-checks-plural'                => 'Ober a ra an termenadur gant <nowiki>{{PLURAL:}}</nowiki> padal an droidigezh ne ra ket.',
	'tog-translate-nonewsletter'             => "Arabat kas din kelc'hlizheroù dre bostel (ne den nemet d'ar re o deus kadarnaet o chomlec'h postel)",
	'right-translate'                        => 'Kemmañ en ur ober gant an etrefas treiñ',
	'translate-rc-translation-filter'        => 'Silañ an troidigezhioù :',
	'translate-rc-translation-filter-no'     => 'Na ober seurt ebet',
	'translate-rc-translation-filter-only'   => 'Diskouez an troidigezhioù hepken',
	'translate-rc-translation-filter-filter' => 'Lakaat an troidigezhioù er-maez',
	'translate-rc-translation-filter-site'   => "Kemmoù da gemennoù al lec'hienn hepken",
	'translate-stats-edits'                  => 'Kemmoù dre zevezh',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'translate-prev' => 'Prethodna stranica',
);

/** Catalan (Català)
 * @author SMP
 * @author Toniher
 * @author Siebrand
 */
$messages['ca'] = array(
	'translate'                         => 'Tradueix',
	'translate-desc'                    => '[[Special:Translate|Pàgina especial]] per a traduir el Mediawiki i altres coses',
	'translate-edit'                    => 'edita',
	'translate-talk'                    => 'discussió',
	'translate-history'                 => 'historial',
	'translate-task-view'               => 'veure tots els missatges de',
	'translate-task-untranslated'       => 'veure els missatges no traduïts de',
	'translate-task-optional'           => 'veure els missatges opcionals de',
	'translate-task-review'             => 'revisar els canvis a',
	'translate-task-reviewall'          => 'revisar les traduccions de',
	'translate-task-export'             => 'exportar les traduccions de',
	'translate-task-export-to-file'     => 'exportar a un fitxer de',
	'translate-task-export-as-po'       => 'exportar en format Gettext',
	'translate-page-no-such-language'   => 'La llengua especificada no és vàlida.',
	'translate-page-no-such-task'       => 'La tasca especificada no és vàlida.',
	'translate-page-no-such-group'      => 'El grup especificat no és vàlid.',
	'translate-page-settings-legend'    => 'Preferències',
	'translate-page-task'               => 'Vull',
	'translate-page-group'              => 'Grup',
	'translate-page-language'           => 'Llengua',
	'translate-page-limit'              => 'Límit',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|missatge|missatges}} per pàgina',
	'translate-submit'                  => 'Mostra',
	'translate-page-navigation-legend'  => 'Navegació',
	'translate-page-showing'            => 'Mostrant missatges del $1 al $2 de $3.',
	'translate-page-showing-all'        => 'Mostrant $1 {{PLURAL:$1|missatge|missatges}}.',
	'translate-page-showing-none'       => 'No hi ha missatges a mostrar.',
	'translate-next'                    => 'Pàgina següent',
	'translate-prev'                    => 'Pàgina anterior',
	'translate-page-description-legend' => 'Informació del grup',
	'translate-optional'                => '(opcional)',
	'translate-ignored'                 => '(ignorat)',
	'translate-edit-definition'         => 'Definició del missatge',
	'translate-edit-contribute'         => 'contribueix',
	'translate-edit-no-information'     => "''Aquest missatge no té documentació. Si sabeu on o com és usat aquest missatge podeu ajudar la resta de traductors afegint-hi la documentació.''",
	'translate-edit-information'        => 'Informació sobre el missatge ($1)',
	'translate-edit-in-other-languages' => 'Missatge en altres llengües',
	'translate-edit-committed'          => 'Traducció utilitzada actualment pel programa',
	'translate-edit-warnings'           => 'Avisos de traducció incompleta',
	'translate-magic-pagename'          => 'Traducció ampliada del MediaWiki',
	'translate-magic-help'              => "Aquí podeu traduir els noms de les pàgines especials, les paraules màgiques, els noms dels estils de pell (''skins'') i els títols dels diferents espais de noms (''namespaces'').

A les paraules màgiques cal que hi incloeu les traduccions en anglès per a que continuïn funcionant. També cal que deixeu el primer ítem (0 o 1) igual que a l'original.

Els títols de les pàgines especials i les paraules màgiques poden tenir múltiples traduccions. Separeu-les per una coma (,) i un espai. Els estils i els espais de noms només poden tenir una traducció.

Dins les traduccions dels espais de noms, la <tt>$1 talk</tt> és especial. <tt>$1</tt> es substitueix pel nom del projecte (per exemple <tt>{{SITENAME}} talk</tt>). Si no és possible fer-ho així en el vostre idioma sense canviar la forma gramatical del nom del projecte, contacteu amb un programador.

Heu de tenir permisos de traductor per a desar els canvis, que no es guardaran fins que no cliqueu el botó corresponent.",
	'translate-magic-submit'            => 'Mostra',
	'translate-magic-cm-export'         => 'Exporta',
	'translate-magic-cm-to-be'          => 'Serà',
	'translate-magic-cm-current'        => 'Actual',
	'translate-magic-cm-original'       => 'Original',
	'translate-magic-cm-comment'        => 'Comentari:',
	'translate-magic-cm-save'           => 'Desa',
	'translate-magic-cm-updatedusing'   => 'Actualitzat amb [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => 'Error al desar',
	'translate-magic-special'           => 'Noms de les pàgines especials',
	'translate-magic-words'             => 'Paraules màgiques',
	'translate-magic-skin'              => 'Noms dels estils',
	'translate-magic-namespace'         => 'Noms dels espais de noms',
	'translationchanges'                => 'Canvis a la traducció',
	'translationchanges-export'         => 'exporta',
	'translationchanges-change'         => '$1:$2 per $3',
	'translate-checks-parameters'       => "Els paràmetres següents no s'estan usant:
<strong><nowiki>$1</nowiki></strong>",
	'translate-checks-balance'          => 'El format dels parèntesis no és correcte:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'            => 'Els enllaços següents són problemàtics:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'            => 'Reemplaceu les etiquetes següents amb les correctes:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'           => 'La definició utilitza <nowiki>{{PLURAL:}}</nowiki> i en canvi la traducció no.',
	'tog-translate-nonewsletter'        => "No m'enviïs per correu electrònic el recull de notícies (només per a usuaris amb adreça electrònica)",
	'right-translate'                   => 'Editar fent servir la interfície de traducció',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 * @author Gadao01
 */
$messages['ch'] = array(
	'translate-edit'                   => 'tulaika',
	'translate-talk'                   => 'kuentusi',
	'translate-page-navigation-legend' => 'Nabegasion',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Siebrand
 * @author Danny B.
 * @author Mormegil
 */
$messages['cs'] = array(
	'translate'                         => 'Přeložit',
	'translate-desc'                    => '[[Special:Translate|Speciální stránka]] zjednodušující překládání systémových hlášení MediaWiki',
	'translate-edit'                    => 'editovat',
	'translate-talk'                    => 'diskuse',
	'translate-history'                 => 'historie',
	'translate-task-view'               => 'Zobrazit všechny zprávy z',
	'translate-task-untranslated'       => 'Zobrazit všechny nepřeložené zprávy z',
	'translate-task-optional'           => 'Zobrazit volitelné zprávy z',
	'translate-task-review'             => 'Porovnat změny v',
	'translate-task-reviewall'          => 'Porovnat všechny překlady v',
	'translate-task-export'             => 'Exportovat překlady z',
	'translate-task-export-to-file'     => 'Exportovat do souboru překlady z',
	'translate-task-export-as-po'       => 'Exportovat překlad do formátu Gettext',
	'translate-page-no-such-language'   => 'Zadaný kód jazyka není platný',
	'translate-page-no-such-task'       => 'Zadaná úloha byla neplatná.',
	'translate-page-no-such-group'      => 'Zadaná skupina byla neplatná.',
	'translate-page-settings-legend'    => 'Nastavení',
	'translate-page-task'               => 'Chci',
	'translate-page-group'              => 'skupina',
	'translate-page-language'           => 'v&nbsp;jazyce',
	'translate-page-limit'              => 's&nbsp;omezením',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|zpráva|zprávy|zpráv}} na stránce',
	'translate-submit'                  => 'Ukázat',
	'translate-page-navigation-legend'  => 'Navigace',
	'translate-page-showing'            => 'Zobrazeny zprávy $1 až $2 z $3.',
	'translate-page-showing-all'        => '{{PLURAL:$1|Zobrazena $1 zpráva|Zobrazeny $1 zprávy|Zobrazeno $1 zpráv}}.',
	'translate-page-showing-none'       => 'Požadavku neodpovídají žádné zprávy.',
	'translate-next'                    => 'Další stránka',
	'translate-prev'                    => 'Předchozí stránka',
	'translate-page-description-legend' => 'Informace o skupině',
	'translate-optional'                => '(volitelné)',
	'translate-ignored'                 => '(ignorované)',
	'translate-edit-definition'         => 'Zdroj zprávy',
	'translate-edit-contribute'         => 'přispět',
	'translate-edit-no-information'     => "''K této zprávě není dokumentace. Pokud víte, kde nebo jak se zpráva používá, můžete pomoci dalším překladatelům tím, že přidáte dokumentaci k této zprávě.''",
	'translate-edit-information'        => 'Informace o této zprávě ($1)',
	'translate-edit-in-other-languages' => 'Zpráva v jiných jazycích',
	'translate-edit-committed'          => 'Současný překlad v úložišti',
	'translate-edit-warnings'           => 'Upozornění na neúplný překlad',
	'translate-magic-pagename'          => 'Rozšířená možnost překladu Mediawiki',
	'translate-magic-submit'            => 'Zobrazit',
	'translate-magic-cm-export'         => 'Exportovat',
	'translate-magic-cm-to-be'          => 'nové',
	'translate-magic-cm-current'        => 'současné',
	'translate-magic-cm-original'       => 'původní',
	'translate-magic-cm-comment'        => 'Komentář:',
	'translate-magic-cm-save'           => 'Uložit',
	'translate-magic-cm-updatedusing'   => 'Aktualizovat pomocí [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => 'Uložení se nepovedlo',
	'translate-magic-special'           => 'Alternativní jména speciálních stránek',
	'translate-magic-words'             => 'Kouzelná slůvka',
	'translate-magic-skin'              => 'Názvy stylů',
	'translate-magic-namespace'         => 'Názvy jmenných prostorů',
	'translationchanges'                => 'Změny překladů',
	'translationchanges-export'         => 'exportovat',
	'translationchanges-change'         => '$1: $2 ($3)',
	'translate-checks-parameters'       => 'Tyto parametry nejsou použity: <strong>$1</strong>',
	'translate-checks-balance'          => 'Vyskytuje se lichý počet závorek: <strong>$1</strong>',
	'translate-checks-links'            => 'Následující odkazy jsou problematické: <strong>$1</strong>',
	'translate-checks-xhtml'            => 'Opravte následující značky: <strong>$1</strong>',
	'translate-checks-plural'           => 'Zdroj používá <nowiki>{{PLURAL:}}</nowiki>, ale překlad nikoliv.',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'translate-page-language' => 'ѩꙁꙑ́къ',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'translate-edit' => 'golygu',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'translate-edit'                   => 'redigér',
	'translate-talk'                   => 'dsikussion',
	'translate-history'                => 'historik',
	'translate-page-group'             => 'Gruppe',
	'translate-page-language'          => 'Sprog',
	'translate-page-navigation-legend' => 'Navigation',
	'translate-next'                   => 'Næste side',
	'translate-prev'                   => 'Forrige side',
	'translate-magic-cm-current'       => 'Nuværende',
);

/** German (Deutsch)
 * @author Raimond Spekking
 * @author Purodha
 * @author Siebrand
 */
$messages['de'] = array(
	'translate'                              => 'Übersetze',
	'translate-desc'                         => '[[Special:Translate|Spezialseite]] für die Übersetzung von MediaWiki-Systemnachrichten',
	'translate-edit'                         => 'Bearbeiten',
	'translate-talk'                         => 'Diskussion',
	'translate-history'                      => 'Versionen',
	'translate-task-view'                    => 'Zeige alle Systemnachrichten der',
	'translate-task-untranslated'            => 'Zeige alle nicht übersetzten Systemnachrichten der',
	'translate-task-optional'                => 'Zeige optionale Systemnachrichten der',
	'translate-task-problematic'             => 'Zeige Systemnachrichten mit Problemen',
	'translate-task-review'                  => 'Prüfe Änderungen der',
	'translate-task-reviewall'               => 'Prüfe alle Übersetzungen der',
	'translate-task-export'                  => 'Exportiere alle Übersetzungen der',
	'translate-task-export-to-file'          => 'Exportiere alle Übersetzungen in eine Datei der',
	'translate-task-export-as-po'            => 'Exportiere alle Übersetzungen in das Gettext-Format der',
	'translate-task-export-to-xliff'         => 'Exportiere alle Übersetzungen in das Xliff-Formatt',
	'translate-page-no-such-language'        => 'Die angegebene Sprache ist ungültig.',
	'translate-page-no-such-task'            => 'Die angegebene Aufgabe ist ungültig.',
	'translate-page-no-such-group'           => 'Die angegebene Gruppe ist ungültig.',
	'translate-page-disabled'                => "Übersetzungen in dieser Sprache in dieser Gruppe wurde deaktiviert. Grund:

''$1''",
	'translate-page-settings-legend'         => 'Einstellungen',
	'translate-page-task'                    => 'Aufgabe',
	'translate-page-group'                   => 'Gruppe',
	'translate-page-language'                => 'Sprache',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|Systemnachricht|Systemnachrichten}} pro Seite',
	'translate-submit'                       => 'Hole',
	'translate-page-showing'                 => 'Systemnachrichten $1 bis $2 von insgesamt $3.',
	'translate-page-showing-all'             => '$1 {{PLURAL:$1|Systemnachricht|Systemnachrichten}}.',
	'translate-page-showing-none'            => 'Keine Systemnachrichten zur Anzeige vorhanden.',
	'translate-next'                         => 'Nächste Seite',
	'translate-prev'                         => 'Vorherige Seite',
	'translate-page-description-legend'      => 'Informationen über diese Gruppe',
	'translate-page-edit'                    => 'bearbeiten',
	'translate-ignored'                      => '(ignoriert)',
	'translate-edit-definition'              => 'Systemnachricht im Original',
	'translate-edit-contribute'              => 'bearbeiten',
	'translate-edit-no-information'          => "''Diese Systemnachricht hat noch keine Dokumentation. Wenn du weißt, wo und welchem Zusammenhang sie benutzt wird, kannst du anderen Übersetzern helfen, indem du eine Dokumentation hinzufügst.''",
	'translate-edit-information'             => 'Information über diese Systemnachricht ($1)',
	'translate-edit-in-other-languages'      => 'Systemnachricht in anderer Sprache',
	'translate-edit-committed'               => 'Aktuelle Übersetzung',
	'translate-edit-warnings'                => 'Warnung über unvollständige Übersetzungen',
	'translate-edit-goto-no-prev'            => 'Keine vorherige Systemnachricht',
	'translate-edit-goto-no-next'            => 'Keine weitere Systemnachricht',
	'translate-edit-goto-prev'               => 'Vorherige Systemnachricht bearbeiten',
	'translate-edit-goto-next'               => 'Nächste Systemnachricht bearbeiten',
	'translate-edit-goto-list'               => 'Zurück zur Liste',
	'translate-magic-pagename'               => 'Erweiterte MediaWiki-Übersetzung',
	'translate-magic-help'                   => 'Du kannst hier Aliase für Spezialseiten, magische Wörter, Skinnamen und Namensraumnamen übersetzen.

Bei den magischen Wörtern muss das englische Original bestehen bleiben, auch die erste Zahl (0 oder 1) darf nicht verändert werden.

Spezialseiten und magische Wörter können mehrere Übersetzungen haben, sie werden jeweils durch ein Komma (,) getrennt. Skinnamen und Namensraumnamen dürfen nur je eine Übersetzung haben.

In der Übersetzung eines Namensraumnamens hat <tt>$1 talk</tt> eine spezielle Bedeutung. <tt>$1</tt> wird durch den Projektnamen ersetzt (zum Beispiel <tt>{{SITENAME}} talk</tt>). Wenn es in Deiner Sprache nicht möglich ist, eine grammatikalisch korrekte Form davon zu bilden ohne den Projektnamen zu verändern, kontaktiere bitte einen Systemadministrator.

Du musst in der Übersetzer-Gruppe sein, um Änderungen zu speichern. Änderungen werden erst beim Klick auf den Speichern-Button gespeichert.',
	'translate-magic-module'                 => 'Modul:',
	'translate-magic-submit'                 => 'Hole',
	'translate-magic-cm-to-be'               => 'Sollte sein',
	'translate-magic-cm-current'             => 'Aktuell',
	'translate-magic-cm-comment'             => 'Kommentar:',
	'translate-magic-cm-save'                => 'Speichern',
	'translate-magic-cm-updatedusing'        => 'Aktualisiert durch Special:Magic',
	'translate-magic-cm-savefailed'          => 'Speichern fehlgeschlagen',
	'translate-magic-special'                => 'Spezialseiten-Aliase',
	'translate-magic-words'                  => 'Magische Wörter',
	'translate-magic-skin'                   => 'Skins',
	'translate-magic-namespace'              => 'Namensraum-Namen',
	'translationchanges'                     => 'Übersetzungsänderungen',
	'translationchanges-export'              => 'exportieren',
	'translationchanges-change'              => '$1: $2 durch $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|Der folgende Parameter wird|Die folgenden Parameter werden}} nicht benutzt: <strong>$1</strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|Der folgende Parameter ist|Die folgenden Parameter sind}} unbekannt: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Die {{PLURAL:$2|folgende Klammersetzung ist|folgenden Klammersetzungen sind}} nicht ausgeglichen: <strong>$1</strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|Der folgende Link ist|Die folgenden Links sind}} sind problematisch: <strong>$1</strong>',
	'translate-checks-xhtml'                 => 'Bitte ersetze {{PLURAL:$2|den folgenden Tag|die folgenden Tags}} durch die korrekten: <strong>$1</strong>',
	'translate-checks-plural'                => 'Das Original benutzt <nowiki>{{PLURAL:}}</nowiki>, die Übersetzung aber nicht.',
	'tog-translate-nonewsletter'             => 'Sende mir keine E-Mail-Newsletter zu (nur für Benutzer für bestätigten E-Mail-Adressen relevant)',
	'right-translate'                        => 'Benutzung des Übersetzen-Interfaces',
	'translate-rc-translation-filter'        => 'Übersetzungen filtern:',
	'translate-rc-translation-filter-no'     => 'nichts',
	'translate-rc-translation-filter-only'   => 'Zeige nur Übersetzungen',
	'translate-rc-translation-filter-filter' => 'Übersetzungen filtern',
	'translate-rc-translation-filter-site'   => 'Nur Änderungen an Systemnachrichten der Site',
	'translate-stats-edits'                  => 'Bearbeitungen pro Tag',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 * @author Siebrand
 * @author Dundak
 */
$messages['dsb'] = array(
	'translate'                              => 'Pśełožyś',
	'translate-desc'                         => '[[Special:Translate|Specialny bok]] za pśełožowanje Mediawiki a druge',
	'translate-edit'                         => 'wobźěłaś',
	'translate-talk'                         => 'Diskusija',
	'translate-history'                      => 'Wersije',
	'translate-task-view'                    => 'Wšykne powěsći pokazaś',
	'translate-task-untranslated'            => 'Njepśełožone powěsći pokazaś',
	'translate-task-optional'                => 'Opcionelne powěsći pokazaś',
	'translate-task-problematic'             => 'Powěsći pokazaś, kótarež maju problemy',
	'translate-task-review'                  => 'Změny pśeglědaś',
	'translate-task-reviewall'               => 'Wšykne pśełožki pśeglědaś',
	'translate-task-export'                  => 'Pśełožki eksportěrowaś',
	'translate-task-export-to-file'          => 'Pśełožk do dataje eksportěrowaś',
	'translate-task-export-as-po'            => 'Pśełožk we formaśe Gettext eksportěrowaś',
	'translate-task-export-to-xliff'         => 'Pśełožk do formata Xliff eksportěrowaś',
	'translate-page-no-such-language'        => 'Pódana rěc jo njepłaśiwa była.',
	'translate-page-no-such-task'            => 'Pódany nadawk jo njepłaśiwy był.',
	'translate-page-no-such-group'           => 'Pódana kupka jo njepłaśiwa była.',
	'translate-page-disabled'                => "Pśełožki w toś tej rěcy w toś tej kupce su se znjemóžnili. Pśicyna:

''$1''",
	'translate-page-settings-legend'         => 'Nastajenja',
	'translate-page-task'                    => 'Cu',
	'translate-page-group'                   => 'Kupka',
	'translate-page-language'                => 'Rěc',
	'translate-page-limit'                   => 'Licba powěsćow',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|powěsć|powěsći|powěsći|powěsćow}} na bok',
	'translate-submit'                       => 'Pokazaś',
	'translate-page-navigation-legend'       => 'Nawigacija',
	'translate-page-showing'                 => 'Pokazuju se powěsći wót $1 až $2 z $3.',
	'translate-page-showing-all'             => '{{PLURAL:$1|Pokazujo|Pokazujotej|Pokazuju|Pokazujo}} se $1 {{PLURAL:$1|powěsć|powěsći|powěsći|powěsćow}}.',
	'translate-page-showing-none'            => 'Njedaju powěsći.',
	'translate-next'                         => 'Pśiducy bok',
	'translate-prev'                         => 'Slědny bok',
	'translate-page-description-legend'      => 'Informacije wó kupce',
	'translate-page-edit'                    => 'wobźěłaś',
	'translate-optional'                     => '(opcionalny)',
	'translate-ignored'                      => '(ignorěrowany)',
	'translate-edit-definition'              => 'Definicija powěsći',
	'translate-edit-contribute'              => 'pśinosowaś',
	'translate-edit-no-information'          => "''Toś ta powěsć njama dokumentaciju. Jolic wěš, źož abo kak toś ta powěsć se wužywa, móžoš drugim pśełožowarjam pomagaś, z tym až dokumentaciju k toś tej powěsći pśidawaš.''",
	'translate-edit-information'             => 'Informacije wó toś tej powěsći ($1)',
	'translate-edit-in-other-languages'      => 'Powěsć w drugich rěcach',
	'translate-edit-committed'               => 'Aktualny pśełožk w software',
	'translate-edit-warnings'                => 'Warnowanja wó njedopołnych pśełožkach',
	'translate-edit-goto-no-prev'            => 'Žedna pśedchadna powěsć',
	'translate-edit-goto-no-next'            => 'Žedna pśiduca powěsć',
	'translate-edit-goto-prev'               => 'Pśedchadnu powěsć wobźěłaś',
	'translate-edit-goto-next'               => 'Pśiducu powěsć wobźěłaś',
	'translate-edit-goto-list'               => 'Slědk k lisćinje',
	'translate-magic-pagename'               => 'Rozšyrjony pśełožk MediaWiki',
	'translate-magic-help'                   => 'Móžoš aliasy specialnych bokow, magiske słowa, mjenja šatow a mjenja mjenjowych rumow pśełožyś.

Pla magiskich słow dejš engelske wurazy zapśimjeś, howac juž njefunkcioněruju. Wóstaj teke prědny zapisk (0 abo 1) kaž jo.

Aliasy specialnych bokow a magiske słowa mógu někotare pśełožki měś. Pśełožki se pśez komu (,) źěle. Mjenja šatow a mjenjowe rumy mógu jano jaden pśełožk měś.

Mjazy pśełožkami mjenjowych rumow <tt>$1 diskusija</tt> jo wósebny. <tt>$1</tt> se pśez mjenjom sedła wuměnja (na pśikład <tt>{{SITENAME}} diskusija</tt>). Jolic w twójej rěcy njejo móžno płaśiwy wuraz formowaś, mimo až dejš mě sedła změniš, staj se pšosym z wuwiwarjom do zwiska.

Musyš w kupce pśełožowarjow byś, aby změny cyniś mógł. Změny se njeskładuju, až njekliknjoš tłocanko "Składowaś" dołojce.',
	'translate-magic-module'                 => 'Modul:',
	'translate-magic-submit'                 => 'Pokazaś',
	'translate-magic-cm-export'              => 'Eksportěrowaś',
	'translate-magic-cm-to-be'               => 'Ma byś',
	'translate-magic-cm-current'             => 'aktualne',
	'translate-magic-cm-original'            => 'Original',
	'translate-magic-cm-comment'             => 'Komentar',
	'translate-magic-cm-save'                => 'Składowaś',
	'translate-magic-cm-updatedusing'        => 'Z pomocu [[Special:Magic]] zaktualizěrowany',
	'translate-magic-cm-savefailed'          => 'Składowanje jo se njeraźiło',
	'translate-magic-special'                => 'Aliasy specialnych bokow',
	'translate-magic-words'                  => 'Magiske słowa',
	'translate-magic-skin'                   => 'Mě šatow',
	'translate-magic-namespace'              => 'Mjenja mjenjowych rumow',
	'translationchanges'                     => 'Změny pśełožka',
	'translationchanges-export'              => 'eksportěrowaś',
	'translationchanges-change'              => '$1: $2 pśez $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|Slědujucy parameter|Slědujucej parametra|Slědujuce parametry|Slědujucych parametrow}}  se {{PLURAL:$2|njewužywa|njewužywatej|njewužywaju|njwužywa}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|Slědujucy parameter jo njeznaty|Slědujucej parametra stej njeznatej|Slědujuce parametry su njeznate|Slědujucych parametrow jo njeznate}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Jo njerowna licba {{PLURAL:$2|spinka|spinkow}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|Slědujucy wótkaz jo problematiski|Slědujucej wótkaza stej problematiskej|Slědujuce wótkaze su problematiske|Slědujucych wótkazow jo problematiske}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Wuměń pšosym {{PLURAL:$2|Slědujucy tag|slědujucej taga|slědujuce tagi|slědujuce tagi}} pśez {{PLURAL:$2|korektny|korektnej|korektne|korektne}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'Definicija <nowiki>{{PLURAL:}}</nowiki> wužywa, pśełožk pak nic.',
	'tog-translate-nonewsletter'             => 'Njesćelśo mě emailowy list nowosćow (jano za wužywarjow z wobkšuśoneju emailoweju adresu relewantny)',
	'right-translate'                        => 'Z pomocu pśełožowańskego pówjercha wobźěłaś',
	'translate-rc-translation-filter'        => 'Pśełožki filtrowaś:',
	'translate-rc-translation-filter-no'     => 'Njecyń nic',
	'translate-rc-translation-filter-only'   => 'Jano pśełožki pokazaś',
	'translate-rc-translation-filter-filter' => 'Pśełožki wufiltrowaś',
	'translate-rc-translation-filter-site'   => 'Jano změny sedłowych powěsćow',
	'translate-stats-edits'                  => 'Změny na źeń',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Siebrand
 */
$messages['el'] = array(
	'translate'                         => 'Μεταφράστε',
	'translate-edit'                    => 'επεξεργασία',
	'translate-talk'                    => 'Συζήτηση',
	'translate-history'                 => 'Ιστορικό',
	'translate-task-view'               => 'όλα τα μηνύματα από το',
	'translate-task-untranslated'       => 'όλα τα αμετάφραστα μηνύματα από το',
	'translate-task-optional'           => 'τα προαιρετικά μηνύματα από το',
	'translate-task-review'             => 'τις αλλαγές των επεξεργασιών από το',
	'translate-task-reviewall'          => 'όλες τις αλλαγές των μεταφράσεων στο',
	'translate-page-settings-legend'    => 'Ρυθμίσεις',
	'translate-page-task'               => 'Θέλω',
	'translate-page-group'              => 'Ομάδα',
	'translate-page-language'           => 'Γλώσσα',
	'translate-page-limit'              => 'Όριο',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|μήνυμα|μηνύματα}} ανά σελίδα',
	'translate-submit'                  => 'Πηγαίνετε',
	'translate-page-navigation-legend'  => 'Πλοήγηση',
	'translate-page-showing'            => 'Εμφάνιση μηνυμάτων από $1 έως $2 στα $3.',
	'translate-page-showing-all'        => 'Παρουσίαση $1 {{PLURAL:$1|μηνύματος|μηνυμάτων}}.',
	'translate-next'                    => 'Επόμενη σελίδα',
	'translate-prev'                    => 'Προηγούμενη σελίδα',
	'translate-page-description-legend' => 'Πληροφορίες σχετικά με την ομάδα',
	'translate-optional'                => '(προαιρετικά)',
	'translate-ignored'                 => '(αγνοήστε)',
	'translate-edit-information'        => 'Πληροφορίες σχετικά με αυτό το μήνυμα ($1)',
	'translate-edit-in-other-languages' => 'Το Μήνυμα σε άλλες γλώσσες',
	'translate-magic-module'            => 'Ενότητα:',
	'translate-magic-submit'            => 'Πηγαίνετε',
	'translate-magic-cm-comment'        => 'Σχόλιο:',
	'translate-magic-special'           => 'Πρόσθετα ψευδώνυμα σελίδων',
	'translationchanges'                => 'Αλλαγές μετάφρασης',
	'translationchanges-change'         => '$1: $2 από $3',
	'translate-checks-parameters'       => 'Οι παράμετροι που ακολουθούν δεν χρησιμοποιούνται:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'            => 'Οι Ακόλουθοι σύνδεσμοι είναι προβληματικοί:
<strong><nowiki>$1</nowiki></strong>',
);

/** Esperanto (Esperanto)
 * @author Michawiki
 * @author Tlustulimu
 * @author Yekrats
 * @author Siebrand
 */
$messages['eo'] = array(
	'translate'                              => 'Tradukado',
	'translate-desc'                         => '[[Special:Translate|Speciala paĝo]] por traduki Mediawiki kaj alia',
	'translate-edit'                         => 'redakti',
	'translate-talk'                         => 'diskuto',
	'translate-history'                      => 'historio',
	'translate-task-view'                    => 'Rigardi ĉiujn mesaĝojn de',
	'translate-task-untranslated'            => 'Rigardi ĉiujn netradukitajn mesaĝojn de',
	'translate-task-optional'                => 'Rigardi laŭvolajn mesaĝojn',
	'translate-task-problematic'             => 'Rigardi mesaĝojn kun problemoj',
	'translate-task-review'                  => 'Rekontroli ŝanĝojn al',
	'translate-task-reviewall'               => 'Rekontroli ĉiujn tradukojn en',
	'translate-task-export'                  => 'Eksporti tradukojn de',
	'translate-task-export-to-file'          => 'Eksporti tradukon en dosieron de',
	'translate-task-export-as-po'            => 'Eksporti tradukon al la formato Gettext',
	'translate-task-export-to-xliff'         => 'Eksporti tradukadon laŭ formato Xliff',
	'translate-page-no-such-language'        => 'Specifita lingvo estas malvalida.',
	'translate-page-no-such-task'            => 'Specifita tasko estis malvalida.',
	'translate-page-no-such-group'           => 'Specifita grupo estas malvalida.',
	'translate-page-disabled'                => "Tradukoj al ĉi tiu lingvo en ĉi tiu grupo estis malebligita. Kialo:

''$1''",
	'translate-page-settings-legend'         => 'Agordoj',
	'translate-page-task'                    => 'Mi volas',
	'translate-page-group'                   => 'Grupo',
	'translate-page-language'                => 'Lingvo',
	'translate-page-limit'                   => 'Nombro de mesaĝoj',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|mesaĝo|mesaĝoj}} po paĝo',
	'translate-submit'                       => 'Alportu',
	'translate-page-navigation-legend'       => 'Navigado',
	'translate-page-showing'                 => 'Estas motrataj mesaĝoj $1 ĝis $2 el $3.',
	'translate-page-showing-all'             => 'Estas montrataj $1 {{PLURAL:$1|mesaĝo|mesaĝoj}}.',
	'translate-page-showing-none'            => 'Ne estas mesaĝoj por montri.',
	'translate-next'                         => 'Sekva paĝo',
	'translate-prev'                         => 'Antaŭa paĝo',
	'translate-page-description-legend'      => 'Informoj pri la grupo',
	'translate-page-edit'                    => 'redakti',
	'translate-optional'                     => '(nedeviga)',
	'translate-ignored'                      => '(ignorata)',
	'translate-edit-definition'              => 'Mesaĝa difino',
	'translate-edit-contribute'              => 'kontribui',
	'translate-edit-no-information'          => "''Ĉi tiu mesago ne havas dokumentaron. Se vi scias, kie aŭ kiel ĉi tiu mesaĝo estas uzata, vi povas helpi al aliaj tradukantoj aldonante la dokumentaron al ĉi tiu mesaĝo.''",
	'translate-edit-information'             => 'Informoj pri ĉi tiu mesaĝo ($1)',
	'translate-edit-in-other-languages'      => 'Mesaĝo en aliaj lingvoj',
	'translate-edit-committed'               => 'Aktuala traduko en programaro',
	'translate-edit-warnings'                => 'Avertoj pri nekompletaj tradukoj',
	'translate-edit-goto-no-prev'            => 'Neniu antaŭa mesaĝo',
	'translate-edit-goto-no-next'            => 'Neniu posta mesaĝo',
	'translate-edit-goto-prev'               => 'Redakti antaŭan mesaĝon',
	'translate-edit-goto-next'               => 'Redakti postan mesaĝon',
	'translate-edit-goto-list'               => 'Reiri al la listo',
	'translate-magic-pagename'               => 'Etendita traduko de MediaWiki',
	'translate-magic-help'                   => 'Vi povas traduki specialajn paĝojn, magiajn vortojn, nomojn de etosoj kaj nomojn de nomspacoj.

En la magiajn vortojn vi devas inkludi la anglajn esprimojn aŭ ili ne plu funkcios. Lasu ankaŭ la unuan enskribon (0 aŭ 1) kiel ĝi estas.

La kromnomoj de specialaj paĝoj povas havi plurajn tradukojn. La tradukoj estas disigataj per komo (,). Nomoj de etosoj kaj nomspacoj povas havi nur unu tradukon.

En tradukoj de nomspacoj <tt>$1 diskuto</tt> estas speciala. <tt>$1</tt> estas anstataŭigata per la reteja nomo (ekzemple <tt>{{SITENAME}} diskuto</tt>). Se ne estas eble en via lingvo formi validan esprimon sen ŝanĝi la retejan nomon, bonvolu kontakti programiston.

Vi devas esti en la grupo de tradukantoj por konservi ŝanĝojn. Ŝanĝoj ne estos konservataj, ĝis vi alklakis la butonon Konservu malsupre.',
	'translate-magic-module'                 => 'Modjulo:',
	'translate-magic-submit'                 => 'Montri',
	'translate-magic-cm-export'              => 'Eksportu',
	'translate-magic-cm-to-be'               => 'Estu',
	'translate-magic-cm-current'             => 'Nuntempe',
	'translate-magic-cm-original'            => 'Originalo',
	'translate-magic-cm-comment'             => 'Komento:',
	'translate-magic-cm-save'                => 'Konservi',
	'translate-magic-cm-updatedusing'        => 'Ĝisdatigita pere de [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Konservado malsukcesis',
	'translate-magic-special'                => 'Kromnomoj de specialaj paĝoj',
	'translate-magic-words'                  => 'Magiaj vortoj',
	'translate-magic-skin'                   => 'Nomoj de etosoj',
	'translate-magic-namespace'              => 'Nomoj de nomspacoj',
	'translationchanges'                     => 'Tradukŝanĝoj',
	'translationchanges-export'              => 'eksportu',
	'translationchanges-change'              => '$1: $2 de $3',
	'translate-checks-parameters'            => 'Jenaj parametroj ne estas uzataj: <strong>$1</strong>',
	'translate-checks-parameters-unknown'    => 'Jenaj {{PLURAL:$2|parametro|parametroj}} estas nekonataj:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Estas nepara nombro de krampoj: <strong>$1</strong>',
	'translate-checks-links'                 => 'Jenaj ligiloj estas problemaj: <strong>$1</strong>',
	'translate-checks-xhtml'                 => 'Bonvolu anstataŭigi jenajn etikedojn per la korektaj: <strong>$1</strong>',
	'translate-checks-plural'                => 'Difino uzas <nowiki>{{PLURAL:}}</nowiki>, sed traduko ne.',
	'right-translate'                        => 'Redakti per la traduka interfaco',
	'translate-rc-translation-filter'        => 'Filtri tradukojn:',
	'translate-rc-translation-filter-no'     => 'Fari nenion',
	'translate-rc-translation-filter-only'   => 'Montri nur tradukojn',
	'translate-rc-translation-filter-filter' => 'Forfiltri tradukojn',
	'translate-rc-translation-filter-site'   => 'Ŝanĝoj nur al mesaĝoj de la retejo',
);

/** Spanish (Español)
 * @author Lin linao
 */
$messages['es'] = array(
	'translate'                         => 'Traducir',
	'translate-edit'                    => 'editar',
	'translate-talk'                    => 'discusión',
	'translate-history'                 => 'historial',
	'translate-task-view'               => 'Ver todos los mensajes de',
	'translate-task-untranslated'       => 'Ver todos los mensajes sin traducir de',
	'translate-task-optional'           => 'Ver los mensajes opcionales de',
	'translate-task-problematic'        => 'Ver los mensajes que tienen problemas',
	'translate-task-review'             => 'Revisar cambios en',
	'translate-task-reviewall'          => 'Revisar todas las traducciones en',
	'translate-task-export'             => 'Exportar traducciones desde',
	'translate-task-export-as-po'       => 'Exportar traducción en formato Gettext',
	'translate-task-export-to-xliff'    => 'Exportar traducción en formato Xliff',
	'translate-page-settings-legend'    => 'Preferencias',
	'translate-page-task'               => 'Deseo',
	'translate-page-group'              => 'Grupo',
	'translate-page-language'           => 'Idioma',
	'translate-page-limit'              => 'Límite',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|mensaje|mensajes}} por página',
	'translate-page-navigation-legend'  => 'Navegación',
	'translate-page-showing'            => 'Mostrando mensajes del $1 al $2 de $3',
	'translate-page-showing-all'        => 'Mostrando $1 {{PLURAL:$1|mensaje|mensajes}}.',
	'translate-page-showing-none'       => 'No hay mensajes para mostrar',
	'translate-next'                    => 'Página siguiente',
	'translate-prev'                    => 'Página anterior',
	'translate-page-description-legend' => 'Información acerca del grupo',
	'translate-optional'                => '(opcional)',
	'translate-edit-no-information'     => "''No hay datos para este mensaje. Si sabes dónde o cómo se usa, puedes ayudar a otros traductores añadiéndole datos.''",
	'translate-edit-information'        => 'Información acerca de este mensaje ($1)',
	'translate-edit-in-other-languages' => 'Mensaje en otros idiomas',
	'translate-edit-warnings'           => 'Advertencias acerca de traducciones incompletas',
	'translate-edit-goto-list'          => 'Volver a la lista',
	'translate-magic-cm-export'         => 'Exportar',
	'translate-magic-cm-current'        => 'Actual',
	'translate-magic-cm-original'       => 'Original',
	'translate-magic-cm-save'           => 'Guardar',
	'translationchanges-export'         => 'exportar',
	'translate-checks-links'            => 'Los siguientes enlaces son problemáticos: <strong>$1</strong>',
);

/** Basque (Euskara)
 * @author Theklan
 * @author SPQRobin
 */
$messages['eu'] = array(
	'translate'                      => 'Itzuli',
	'translate-edit'                 => 'aldatu',
	'translate-talk'                 => 'eztabaida',
	'translate-history'              => 'historia',
	'translate-page-settings-legend' => 'Hobespenak',
	'translate-page-group'           => 'Taldea',
	'translate-page-limit'           => 'Muga',
	'translate-next'                 => 'Hurrengo orrialdea',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'translate'                     => 'Traucil',
	'translate-edit'                => 'eital',
	'translate-talk'                => 'caraba',
	'translate-history'             => 'estorial',
	'translate-task-view'           => 'Vel tolos mensahis endi',
	'translate-task-untranslated'   => 'Vel tolos mensahis sin traucil endi',
	'translate-task-export'         => 'Esporteal traucionis endi',
	'translate-task-export-to-file' => 'Esporteal traución a un archivu endi',
	'translate-next'                => 'Siguienti páhina',
	'translate-prev'                => 'Páhina anteriol',
	'translate-optional'            => '(ocional)',
	'translate-ignored'             => '(inorau)',
	'translate-magic-cm-export'     => 'Esporteal',
	'translate-magic-cm-save'       => 'Emburacal',
	'translate-magic-words'         => 'Parabras máhicas',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'translate'                         => 'ترجمه',
	'translate-desc'                    => '[[Special:Translate|صفحهٔ ویژه‌ای]] برای ترجمهٔ مدیاویکی و فراتر از آن',
	'translate-edit'                    => 'ویرایش',
	'translate-talk'                    => 'بحث',
	'translate-history'                 => 'تاریخچه',
	'translate-task-view'               => 'نمایش تمام پیغام‌ها',
	'translate-task-untranslated'       => 'نمایش تمام پیغام‌های ترجمه نشده',
	'translate-task-optional'           => 'نمایش پیغام‌های اختیاری',
	'translate-task-review'             => 'بازبینی تغییرها',
	'translate-task-reviewall'          => 'بازبینی تمام ترجمه‌ها',
	'translate-task-export'             => 'صدور ترجمه‌ها',
	'translate-task-export-to-file'     => 'صدور ترجمه‌ها به یک پرونده',
	'translate-task-export-as-po'       => 'صدور ترجمه‌ها در قالب Gettext',
	'translate-page-no-such-language'   => 'زبان مورد نظر غیر مجاز است.',
	'translate-page-no-such-task'       => 'عمل مورد نظر غیر مجاز است.',
	'translate-page-no-such-group'      => 'گروه مورد نظر غیر مجاز است.',
	'translate-page-settings-legend'    => 'تنظیمات',
	'translate-page-task'               => 'دستور',
	'translate-page-group'              => 'گروه',
	'translate-page-language'           => 'زبان',
	'translate-page-limit'              => 'تعداد',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|پیغام|پیغام}} در هر صفحه',
	'translate-submit'                  => 'بیاور',
	'translate-page-navigation-legend'  => 'گشتن',
	'translate-page-showing'            => 'نمایش پیغام‌های $1 تا $2 از $3.',
	'translate-page-showing-all'        => 'نمایش $1 {{PLURAL:$1|پیغام|پیغام}}.',
	'translate-page-showing-none'       => 'پیغامی برای نمایش وجود ندارد.',
	'translate-next'                    => 'صفحهٔ بعدی',
	'translate-prev'                    => 'صفحهٔ قبلی',
	'translate-page-description-legend' => 'اطلاعات در مورد گروه',
	'translate-optional'                => '(اختیاری)',
	'translate-ignored'                 => '(نادیده گرفته شده)',
	'translate-edit-definition'         => 'تعریف پیغام',
	'translate-edit-contribute'         => 'مشارکت',
	'translate-edit-no-information'     => "''این پیغام دارای توضیحات نیست. اگر شما می‌دانید که این پیغام چگونه یا در کجا استفاده می‌شود، شما می‌توانید با اضافه کردن توضیحات به دیگر ترجمه‌کنندگان کمک کنید.''",
	'translate-edit-information'        => 'اطلاعات در مورد این پیغام ($1)',
	'translate-edit-in-other-languages' => 'همین پیغام در دیگر زبان‌ها',
	'translate-edit-committed'          => 'ترجمهٔ فعلی در نرم‌افزار',
	'translate-edit-warnings'           => 'هشدار در مورد ترجمه‌های ناکامل',
	'translate-magic-pagename'          => 'ترجمهٔ گسترش یافتهٔ مدیاویکی',
	'translate-magic-help'              => 'شما می‌توانید نام مستعار صفحه‌های ویژه، واژه‌های جادویی، نام پوسته‌ها و نام فضاهای نام را ترجمه کنید.

در مورد واژه‌های جادویی ترجمهٔ شما باید شامل معادل انگلیسی هم باشد وگرنه واژهٔ جادویی کار نخواهد کرد. هم‌چنین، اولین بخش (0 یا 1) را تغییر ندهید.

نام‌های مستعار صفحه‌های ویژه و واژه‌های جادویی می‌توانند بیش از یک ترجمه داشته باشند. ترجمه‌ها با یک کامای انگلیسی (,) از هم جدا می‌شوند. نام پوسته‌ها و فضاهای نام تنها می‌تواند یک ترجمه داشته باشد.

در ترجمهٔ نام فضاهای نام <tt>$1 talk</tt> خاص است. <tt>$1</tt> توسط نام وبگاه جایگزین می‌شود (مانند <tt>{{SITENAME}} talk</tt>). اگر در زبان شما امکان ایجاد چنین عبارتی بدون تغییر دادن نام وبگاه وجود ندارد، لطفاً با یکی از توسعه‌دهندگان نرم‌افزار تماس بگیرید.

برای ذخیره کردن تغییرها باید عضو گروه ترجمه‌کنندگان باشید. تغییرات زمانی ذخیره می‌شوند که دکمهٔ ذخیره را در پایین صفحه فشار دهید.',
	'translate-magic-submit'            => 'بیاور',
	'translate-magic-cm-export'         => 'صدور',
	'translate-magic-cm-to-be'          => 'آینده',
	'translate-magic-cm-current'        => 'اخیر',
	'translate-magic-cm-original'       => 'اصلی',
	'translate-magic-cm-comment'        => 'توضیحات:',
	'translate-magic-cm-save'           => 'ذخیره',
	'translate-magic-cm-updatedusing'   => 'به روز شده توسط Special:Magic',
	'translate-magic-cm-savefailed'     => 'شکست در ذخیره کردن اطلاعات',
	'translate-magic-special'           => 'نام مستعار صفحه‌های ویژه',
	'translate-magic-words'             => 'واژه‌های جادویی',
	'translate-magic-skin'              => 'اسم پوسته‌ها',
	'translate-magic-namespace'         => 'اسم فضاهای نام',
	'translationchanges'                => 'تغییرهای ترجمه',
	'translationchanges-export'         => 'صدور',
	'translationchanges-change'         => '$1: $2 توسط $3',
	'translate-checks-parameters'       => 'این پارامترها استفاده نشده‌اند: <strong>$1</strong>',
	'translate-checks-balance'          => 'تعداد پرانتزها زوج نیست: <strong>$1</strong>',
	'translate-checks-links'            => 'پیوندهایی که در ادامه می‌آیند مشکل‌ساز هستند: <strong>$1</strong>',
	'translate-checks-xhtml'            => 'لطفاً این برچسب‌ها را با موارد درست جایگزین کنید: <strong>$1</strong>',
	'translate-checks-plural'           => 'تعریف از <nowiki>{{PLURAL:}}</nowiki> استفاده می‌کند اما ترجمه از آن استفاده نمی‌کند.',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Crt
 */
$messages['fi'] = array(
	'translate'                              => 'Käännä',
	'translate-desc'                         => '[[Special:Translate|Toimintosivu]], jolla voi kääntää MediaWikiä ja muutakin',
	'translate-edit'                         => 'muokkaa',
	'translate-talk'                         => 'keskustelu',
	'translate-history'                      => 'historia',
	'translate-task-view'                    => 'nähdä kaikki viestit',
	'translate-task-untranslated'            => 'nähdä kaikki kääntämättömät viestit',
	'translate-task-optional'                => 'nähdä valinnaiset viestit',
	'translate-task-review'                  => 'tarkistaa muutokset',
	'translate-task-reviewall'               => 'tarkistaa kaikki käännökset',
	'translate-task-export'                  => 'viedä käännökset',
	'translate-task-export-to-file'          => 'viedä käännökset tiedostoon',
	'translate-task-export-as-po'            => 'viedä käännökset Gettext-muodossa',
	'translate-page-no-such-language'        => 'Määritelty kieli ei ollut kelvollinen.',
	'translate-page-no-such-task'            => 'Määritelty tehtävä ei ollut kelvollinen.',
	'translate-page-no-such-group'           => 'Määritelty ryhmä ei ollut kelvollinen.',
	'translate-page-settings-legend'         => 'Asetukset',
	'translate-page-task'                    => 'Haluan',
	'translate-page-group'                   => 'Ryhmä',
	'translate-page-language'                => 'Kieli',
	'translate-page-limit'                   => 'Rajoitus',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|viesti|viestiä}} sivulla',
	'translate-submit'                       => 'Hae',
	'translate-page-navigation-legend'       => 'Selaus',
	'translate-page-showing'                 => 'Alla on viestit $1–$2; yhteensä $3.',
	'translate-page-showing-all'             => 'Näytetään $1 {{PLURAL:$1|viesti|viestiä}}.',
	'translate-page-showing-none'            => 'Ei näytettäviä viestejä.',
	'translate-next'                         => 'Seuraava sivu',
	'translate-prev'                         => 'Edellinen sivu',
	'translate-page-description-legend'      => 'Tietoja ryhmästä',
	'translate-page-edit'                    => 'muokkaa',
	'translate-optional'                     => '(valinnainen)',
	'translate-ignored'                      => '(ei-käännettävä)',
	'translate-edit-definition'              => 'Viestin määritelmä',
	'translate-edit-contribute'              => 'auta dokumentoinnissa',
	'translate-edit-no-information'          => "''Tätä viestiä ei ole dokumentoitu. Jos tiedät missä tai miten tätä viestiä käytetään, voit auttaa muita kääntäjiä lisäämällä kommentteja tähän viestiin.''",
	'translate-edit-information'             => 'Tietoja viestistä ($1)',
	'translate-edit-in-other-languages'      => 'Viesti muilla kielillä',
	'translate-edit-committed'               => 'Nykyinen ohjelmiston käyttämä käännös',
	'translate-edit-warnings'                => 'Varoituksia virheellisestä käännöksestä',
	'translate-edit-goto-no-prev'            => 'Ei edellistä viestiä',
	'translate-edit-goto-no-next'            => 'Ei seuraavaa viestiä',
	'translate-edit-goto-prev'               => 'Muokkaa edellistä viestiä',
	'translate-edit-goto-next'               => 'Muokkaa seuraavaa viestiä',
	'translate-edit-goto-list'               => 'Takaisin listaan',
	'translate-magic-pagename'               => 'Laajennettu MediaWikin kääntäminen',
	'translate-magic-cm-export'              => 'Vie',
	'translate-magic-cm-current'             => 'Nykyinen',
	'translate-magic-cm-original'            => 'Alkuperäinen',
	'translate-magic-cm-comment'             => 'Yhteenveto',
	'translate-magic-cm-save'                => 'Tallenna',
	'translate-magic-cm-savefailed'          => 'Tallennus epäonnistui',
	'translate-magic-special'                => 'Toimintosivujen nimet',
	'translate-magic-skin'                   => 'Ulkoasujen nimet',
	'translate-magic-namespace'              => 'Nimiavaruuksien nimet',
	'translationchanges'                     => 'Käännösmuutokset',
	'translationchanges-export'              => 'vie',
	'translationchanges-change'              => '$1: Käyttäjä $3 muutti sivua $2',
	'translate-rc-translation-filter'        => 'Käännösten suodatus',
	'translate-rc-translation-filter-no'     => 'ei toimenpidettä',
	'translate-rc-translation-filter-only'   => 'näytä vain käännökset',
	'translate-rc-translation-filter-filter' => 'piilota käännökset',
	'translate-rc-translation-filter-site'   => 'vain muutokset sivuston viesteihin',
	'translate-stats-edits'                  => 'Muokkauksia',
);

/** French (Français)
 * @author Grondin
 * @author Urhixidur
 * @author Dereckson
 * @author IAlex
 * @author Verdy p
 * @author Sherbrooke
 * @author Seb35
 * @author Siebrand
 * @author ChrisPtDe
 * @author Louperivois
 */
$messages['fr'] = array(
	'translate'                              => 'Traduire',
	'translate-desc'                         => '[[Special:Translate|Page spéciale]] pour traduire Mediawiki et même plus encore.',
	'translate-edit'                         => 'éditer',
	'translate-talk'                         => 'discuter',
	'translate-history'                      => 'historique',
	'translate-task-view'                    => 'Voir tous les messages du',
	'translate-task-untranslated'            => 'Voir tous les messages non traduits du',
	'translate-task-optional'                => 'Voir tous les messages facultatifs du',
	'translate-task-problematic'             => 'Voir les messages ayant des problèmes',
	'translate-task-review'                  => 'Revoir mes changements au',
	'translate-task-reviewall'               => 'Revoir toutes les traductions du',
	'translate-task-export'                  => 'Exporter les traductions du',
	'translate-task-export-to-file'          => 'Exporter dans un fichier les traductions du',
	'translate-task-export-as-po'            => 'Exporter au format Gettext les traductions du',
	'translate-task-export-to-xliff'         => 'Exporter les traductions au format Xliff',
	'translate-page-no-such-language'        => 'Un code langage invalide a été indiqué.',
	'translate-page-no-such-task'            => 'La tâche spécifiée est invalide.',
	'translate-page-no-such-group'           => 'Le groupe spécifié est invalide.',
	'translate-page-disabled'                => "Les traductions dans cette langue ont été désactivées pour ce groupe. Motif :

''$1''",
	'translate-page-settings-legend'         => 'Configuration',
	'translate-page-task'                    => 'Je veux',
	'translate-page-group'                   => 'Groupe',
	'translate-page-language'                => 'Langue',
	'translate-page-limit'                   => 'Limite',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|message|messages}} par page',
	'translate-submit'                       => 'Atteindre',
	'translate-page-navigation-legend'       => 'Navigation',
	'translate-page-showing'                 => 'Visualisation des messages de $1 à $2 sur $3.',
	'translate-page-showing-all'             => 'Visualisation de $1 {{PLURAL:$1|message|messages}}',
	'translate-page-showing-none'            => 'Aucun message à visualiser.',
	'translate-next'                         => 'Page suivante',
	'translate-prev'                         => 'Page précédente',
	'translate-page-description-legend'      => 'Information à propos du groupe',
	'translate-page-edit'                    => 'modifier',
	'translate-optional'                     => '(facultatif)',
	'translate-ignored'                      => '(ignoré)',
	'translate-edit-definition'              => 'Définition du message',
	'translate-edit-contribute'              => 'contribuer',
	'translate-edit-no-information'          => "Ce message n'est actuellement pas documenté. Si vous savez où ou comment ce message est utilisé, vous pouvez aider les autres traducteurs en documentant ce message.",
	'translate-edit-information'             => 'Informations concernant ce message ($1)',
	'translate-edit-in-other-languages'      => 'Message dans les autres langues',
	'translate-edit-committed'               => 'Traduction courante',
	'translate-edit-warnings'                => 'Avertissements concernant les traductions incomplètes',
	'translate-edit-goto-no-prev'            => 'Aucun message précédent',
	'translate-edit-goto-no-next'            => 'Aucun message suivant',
	'translate-edit-goto-prev'               => 'Éditer le message précédent',
	'translate-edit-goto-next'               => 'Éditer le message suivant',
	'translate-edit-goto-list'               => 'Retour à la liste',
	'translate-magic-pagename'               => 'Traduction de MediaWiki étendue',
	'translate-magic-help'                   => 'Vous pouvez traduire les alias de pages spéciales, les mots magiques, les noms d’habillages et les noms d’espaces de noms.

Dans les mots magiques, vous devez inclure la traduction en anglais ou ça ne fonctionnera plus. De plus, laissez le premier article (0 ou 1) tel quel.

Les alias de pages spéciales et les mots magiques peuvent avoir plusieurs traductions. Les traductions sont séparées par une virgule (,). Les noms d’habillages et d’espaces de noms ne peuvent avoir qu’une traduction.

Dans les traductions d’espaces de noms, <tt>$1 talk</tt> est spécial. <tt>$1</tt> est remplacé par le nom du site (par exemple <tt>{{SITENAME}} talk</tt>). S’il n’est pas possible d’obtenir une expression valide dans votre langue sans changer le nom du site, veuillez contacter un développeur.

Vous devez appartenir au groupe des traducteurs pour sauvegarder les changements. Les changements ne seront pas sauvegardés tant que vous n’aurez pas cliqué sur le bouton « Sauvegarder ».',
	'translate-magic-module'                 => 'Module :',
	'translate-magic-submit'                 => 'Aller',
	'translate-magic-cm-export'              => 'Exporter',
	'translate-magic-cm-to-be'               => 'Devient',
	'translate-magic-cm-current'             => 'Actuel',
	'translate-magic-cm-original'            => 'Original',
	'translate-magic-cm-comment'             => 'Commentaire :',
	'translate-magic-cm-save'                => 'Sauvegarder',
	'translate-magic-cm-updatedusing'        => 'Mise à jour en utilisant Special:Magic',
	'translate-magic-cm-savefailed'          => 'Échec de la sauvegarde',
	'translate-magic-special'                => 'Alias des pages spéciales',
	'translate-magic-words'                  => 'Mots magiques',
	'translate-magic-skin'                   => 'Nom des interfaces',
	'translate-magic-namespace'              => 'Intitulé des espaces de nommage',
	'translationchanges'                     => 'Traductions modifiées',
	'translationchanges-export'              => 'exporter',
	'translationchanges-change'              => '$1: $2 par $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|La paramètre suivant n’est pas utilisé|Les paramètres suivants ne sont pas utilisés}} : <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|La paramètre suivant est inconnu|Les paramètres suivants sont inconnus}} : <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Il y a un nombre non pair de {{PLURAL:$2|parenthèses|parenthèses}} : <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|Le lien suivant cause problèmes|Les liens suivants causent}} : <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Vous êtes invité à corriger {{PLURAL:$2|la balise suivante|les balises suivantes}} : <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'La définition utilise <nowiki>{{PLURAL:}}</nowiki> mais pas la traduction.',
	'translate-checks-pagename'              => 'Nom d’espace modifié depuis la définition',
	'tog-translate-nonewsletter'             => 'Ne m’envoyez pas la lettre d’information par courrier (ne concerne que les utilisateurs qui disposent d’une adresse courriel confirmée)',
	'right-translate'                        => "Modifier en utilisant l'interface de traduction",
	'translate-rc-translation-filter'        => 'Filtrer les traductions :',
	'translate-rc-translation-filter-no'     => 'Ne rien faire',
	'translate-rc-translation-filter-only'   => 'Afficher uniquement les traductions',
	'translate-rc-translation-filter-filter' => 'Éliminer les traductions',
	'translate-rc-translation-filter-site'   => 'Seulement les changements de messages du site',
	'translationstats'                       => 'Statistiques de traduction',
	'translate-stats-edits'                  => 'Éditions par jour',
	'translate-stats-users'                  => 'Traducteurs',
	'translate-statsf-intro'                 => 'Vous pouvez créer des statistiques simples avec ce formulaire. Toutes les valeurs ont des limites maximales et minimales.',
	'translate-statsf-options'               => 'Options du graphique',
	'translate-statsf-width'                 => 'Largeur en pixels',
	'translate-statsf-height'                => 'Hauteur en pixels',
	'translate-statsf-days'                  => 'Période de temps en jours',
	'translate-statsf-scale'                 => 'Granularité',
	'translate-statsf-scale-days'            => 'Jours',
	'translate-statsf-scale-hours'           => 'Heures',
	'translate-statsf-count'                 => 'Mesure',
	'translate-statsf-count-edits'           => "Nombre d'éditions",
	'translate-statsf-count-users'           => 'Traducteurs actifs',
	'translate-statsf-language'              => 'Liste de codes de langues, séparés de virgules',
	'translate-statsf-group'                 => 'Liste de codes de groupes, séparés de virgules',
	'translate-statsf-submit'                => 'Prévisualiser',
);

/** Cajun French (Français cadien)
 * @author RoyAlcatraz
 */
$messages['frc'] = array(
	'translate'                     => 'Traduire',
	'translate-edit'                => 'changer',
	'translate-talk'                => 'discussion',
	'translate-history'             => 'changements',
	'translate-task-view'           => 'voir tous les messages',
	'translate-task-untranslated'   => 'voir tous les messages pas traduits',
	'translate-task-review'         => 'regarder les changements',
	'translate-task-reviewall'      => 'regarder toutes les traductions',
	'translate-task-export'         => 'exporter les traductions',
	'translate-task-export-to-file' => 'exporter les traductions au dossier',
	'translate-submit'              => 'Charcher',
	'translate-next'                => 'Page suivante',
	'translate-prev'                => 'Page avant',
	'translate-optional'            => '(de choix)',
	'translate-ignored'             => '(ignoré)',
	'translationchanges'            => 'Modification des traductions',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 * @author Siebrand
 */
$messages['frp'] = array(
	'translate'                         => 'Traduire',
	'translate-desc'                    => '[[Special:Translate|Pâge spèciâla]] por traduire MediaWiki et mémo ples oncor.',
	'translate-edit'                    => 'èditar',
	'translate-talk'                    => 'discutar',
	'translate-history'                 => 'historico',
	'translate-task-view'               => 'Vêre tôs los mèssâjos dês',
	'translate-task-untranslated'       => 'Vêre tôs los mèssâjos pas traduits dês',
	'translate-task-optional'           => 'Vêre tôs los mèssâjos u chouèx dês',
	'translate-task-review'             => 'Revêre mos changements dês',
	'translate-task-reviewall'          => 'Revêre totes les traduccions dens',
	'translate-task-export'             => 'Èxportar les traduccions dês',
	'translate-task-export-to-file'     => 'Èxportar les traduccions dens un fichiér dês',
	'translate-task-export-as-po'       => 'Èxportar les traduccions u format gettext',
	'translate-page-no-such-language'   => 'Un code lengâjo envalido at étâ endicâ.',
	'translate-page-no-such-task'       => 'L’ovrâjo spècefiâ est envalido.',
	'translate-page-no-such-group'      => 'Lo groupe spècefiâ est envalido.',
	'translate-page-settings-legend'    => 'Configuracion',
	'translate-page-task'               => 'Vuel',
	'translate-page-group'              => 'Groupe',
	'translate-page-language'           => 'Lengoua',
	'translate-page-limit'              => 'Limita',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|mèssâjo|mèssâjos}} per pâge',
	'translate-submit'                  => 'Avengiér',
	'translate-page-navigation-legend'  => 'Navigacion',
	'translate-page-showing'            => 'Visualisacion des mèssâjos de $1 a $2 sur $3.',
	'translate-page-showing-all'        => 'Visualisacion de $1 {{PLURAL:$1|mèssâjo|mèssâjos}}.',
	'translate-page-showing-none'       => 'Nion mèssâjo a visualisar.',
	'translate-next'                    => 'Pâge siuventa',
	'translate-prev'                    => 'Pâge prècèdenta',
	'translate-page-description-legend' => 'Enformacion a propôs du groupe',
	'translate-optional'                => '(u chouèx)',
	'translate-ignored'                 => '(ignorâ)',
	'translate-edit-definition'         => 'Dèfinicion du mèssâjo',
	'translate-edit-contribute'         => 'contribuar',
	'translate-edit-no-information'     => "''Orendrêt, ceti mèssâjo est pas documentâ. Se vos sâde yô ou coment ceti mèssâjo est utilisâ, vos pouede édiér los ôtros traductors en documentent ceti mèssâjo.''",
	'translate-edit-information'        => 'Enformacions regardent ceti mèssâjo ($1)',
	'translate-edit-in-other-languages' => 'Mèssâjo dens les ôtres lengoues',
	'translate-edit-committed'          => 'Traduccion d’ora ja dens la programeria',
	'translate-edit-warnings'           => 'Avèrtissements regardent les traduccions pas complètes',
	'translate-magic-pagename'          => 'Traduccion de MediaWiki ètendua',
	'translate-magic-help'              => 'Vos pouede traduire los noms de les pâges spèciâles, los mots magicos, los noms de les entèrfaces et los titros des èspâços de nom.

Dens los mots magicos, vos dête encllure la traduccion en anglès ou cen fonccionerat pas més. Et pués, lèssiéd lo premiér èlèment (0 ou ben 1) coment il est.

Los noms de les pâges spèciâles et los mots magicos pôvont avêr plusiors traduccions. Les traduccions sont sèparâs per una virgula (,). Los noms de les entèrfaces et los titros des èspâços de nom pôvont avêr ren que yona traduccion.

Dens les traduccions des èspâços de nom, <tt>$1 talk</tt> est spèciâl. <tt>$1</tt> est remplaciê per lo nom du seto (per ègzemplo <tt>{{SITENAME}} talk</tt>). S’o est pas possiblo d’obtegnir una èxprèssion valida dens voutra lengoua sen changiér lo nom du seto, volyéd vos veriér vers un dèvelopior.

Vos dête apartegnir a la tropa des traductors por sôvar los changements. Los changements seront pas sôvâs devant que vos clicâd sur lo boton « Sôvar » d’avâl.',
	'translate-magic-submit'            => 'Alar',
	'translate-magic-cm-export'         => 'Èxportar',
	'translate-magic-cm-to-be'          => 'Vint',
	'translate-magic-cm-current'        => 'Ora',
	'translate-magic-cm-original'       => 'Originâl',
	'translate-magic-cm-comment'        => 'Comentèro :',
	'translate-magic-cm-save'           => 'Sôvar',
	'translate-magic-cm-updatedusing'   => 'Betâ a jorn en utilisent [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => 'Falyita de la sôvegouârda',
	'translate-magic-special'           => 'Noms de les pâges spèciâles',
	'translate-magic-words'             => 'Mots magicos',
	'translate-magic-skin'              => 'Noms de les entèrfaces',
	'translate-magic-namespace'         => 'Titros des èspâços de nom',
	'translationchanges'                => 'Traduccions modifiâs',
	'translationchanges-export'         => 'èxportar',
	'translationchanges-change'         => '$1 : $2 per $3',
	'translate-checks-parameters'       => 'Los paramètres siuvents sont pas utilisâs : <strong>$1</strong>',
	'translate-checks-balance'          => 'Y at un nombro fôx de parentèses : <strong>$1</strong>',
	'translate-checks-links'            => 'Los lims siuvents sont pas de sûr : <strong>$1</strong>',
	'translate-checks-xhtml'            => 'Vos éte envitâ a remetre en place les balises siuventes avouéc celes que sont corrèctes : <strong>$1</strong>',
	'translate-checks-plural'           => 'La dèfinicion utilise <nowiki>{{PLURAL:}}</nowiki> mas pas la traduccion.',
);

/** Irish (Gaeilge)
 * @author Moilleadóir
 */
$messages['ga'] = array(
	'translate-page-navigation-legend' => 'Nascleanúint',
);

/** Galician (Galego)
 * @author Toliño
 * @author Alma
 * @author Xosé
 * @author Siebrand
 */
$messages['gl'] = array(
	'translate'                              => 'Traducir',
	'translate-desc'                         => '[[Special:Translate|Páxina especial]] para traducir MediaWiki e outras extensións',
	'translate-edit'                         => 'editar',
	'translate-talk'                         => 'conversa',
	'translate-history'                      => 'historial',
	'translate-task-view'                    => 'Ver todas as mensaxes de',
	'translate-task-untranslated'            => 'Ver todas as mensaxes sen traducir de',
	'translate-task-optional'                => 'Ver as mensaxes opcionais de',
	'translate-task-problematic'             => 'Ver as mensaxes que teñen problemas en',
	'translate-task-review'                  => 'Revisar os cambios en',
	'translate-task-reviewall'               => 'Revisar todas as traducións en',
	'translate-task-export'                  => 'Exportar as traducións de',
	'translate-task-export-to-file'          => 'Exportar a un ficheiro a tradución de',
	'translate-task-export-as-po'            => 'Exportar a tradución en formato Gettext',
	'translate-task-export-to-xliff'         => 'Exportar a tradución en formato Xliff',
	'translate-page-no-such-language'        => 'O código de lingua especificado non é válido.',
	'translate-page-no-such-task'            => 'A tarefa especificada non é válida.',
	'translate-page-no-such-group'           => 'O grupo especificado non é válido.',
	'translate-page-disabled'                => "As traducións desta lingua neste grupo foron deshabilitadas. Razón:

''$1''",
	'translate-page-settings-legend'         => 'Configuracións',
	'translate-page-task'                    => 'Quero',
	'translate-page-group'                   => 'Grupo',
	'translate-page-language'                => 'Lingua',
	'translate-page-limit'                   => 'Límite',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|mensaxe|mensaxes}} por páxina',
	'translate-submit'                       => 'Amosar',
	'translate-page-navigation-legend'       => 'Navegación',
	'translate-page-showing'                 => 'Amosando as mensaxes da $1 á $2, dun total de $3.',
	'translate-page-showing-all'             => 'Amosando {{PLURAL:$1|unha mensaxe|$1 mensaxes}}.',
	'translate-page-showing-none'            => 'Non hai mensaxes para amosar.',
	'translate-next'                         => 'Páxina seguinte',
	'translate-prev'                         => 'Páxina anterior',
	'translate-page-description-legend'      => 'Información acerca do grupo',
	'translate-page-edit'                    => 'editar',
	'translate-optional'                     => '(opcional)',
	'translate-ignored'                      => '(ignorado)',
	'translate-edit-definition'              => 'Definición da mensaxe',
	'translate-edit-contribute'              => 'contribuír',
	'translate-edit-no-information'          => "''Esta mensaxe non ten documentación.''
''Se sabe onde ou como se usa esta mensaxe, pode axudar a outros tradutores engadíndolle datos.''",
	'translate-edit-information'             => 'Información acerca desta mensaxe ($1)',
	'translate-edit-in-other-languages'      => 'Mensaxe noutras linguas',
	'translate-edit-committed'               => 'Tradución actual no software',
	'translate-edit-warnings'                => 'Avisos acerca de traducións incompletas',
	'translate-edit-goto-no-prev'            => 'Non hai mensaxe previa',
	'translate-edit-goto-no-next'            => 'Non hai mensaxe seguinte',
	'translate-edit-goto-prev'               => 'Editar a mensaxe previa',
	'translate-edit-goto-next'               => 'Editar a mensaxe seguinte',
	'translate-edit-goto-list'               => 'Voltar á lista',
	'translate-magic-pagename'               => 'Tradución estendida de MediaWiki',
	'translate-magic-help'                   => 'Pode traducir os alias das páxinas especiais, as palabras máxicas, os nomes das aparencias e os nomes dos espazos de nomes.

Nas páxinas máxicas ten que incluír as traducións en inglés ou non funcionarán. Deixe tamén o primeiro elemento (0 ou 1) tal e como está.

Os alias de páxinas especiais e as palabras máxicas poden ter varias traducións. As traducións sepáranse mediante unha vírgula (,). Os nomes das aparencias e dos espazos de nomes só poden ter unha tradución.

Nas traducións dos espazos de nomes, <tt>$1 talk</tt> é especial. <tt>$1</tt> substitúese polo nome do sitio (por exemplo <tt>{{SITENAME}} talk</tt>). Se na súa lingua non resulta posíbel formar unha expresión válida sen mudar o nome do sitio, contacte cun programador.',
	'translate-magic-module'                 => 'Módulo:',
	'translate-magic-submit'                 => 'Amosar',
	'translate-magic-cm-export'              => 'Exportar',
	'translate-magic-cm-to-be'               => 'Será',
	'translate-magic-cm-current'             => 'Actual',
	'translate-magic-cm-original'            => 'Orixinal',
	'translate-magic-cm-comment'             => 'Comentario:',
	'translate-magic-cm-save'                => 'Gardar',
	'translate-magic-cm-updatedusing'        => 'Actualizado mediante [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Fallou o gardado',
	'translate-magic-special'                => 'Alias de páxinas especiais',
	'translate-magic-words'                  => 'Palabras máxicas',
	'translate-magic-skin'                   => 'Nome das aparencias',
	'translate-magic-namespace'              => 'Nomes dos espazos de nomes',
	'translationchanges'                     => 'Modificacións nas traducións',
	'translationchanges-export'              => 'exportar',
	'translationchanges-change'              => '$1: $2 por $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|O seguinte parámetro non é usado|Os seguintes parámetros non son usados}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|O seguinte parámetro é descoñecido|Os seguintes parámetros son descoñecidos}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Hai unha cantidade irregular de {{PLURAL:$2|parénteses|parénteses}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|A seguinte ligazón é problemática|As seguintes ligazóns son problemáticas}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Por favor, substitúa {{PLURAL:$2|a seguinte etiqueta pola correcta|as seguintes etiquetas polas correctas}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'A definición usa <nowiki>{{PLURAL:}}</nowiki>, pero a tradución non.',
	'translate-checks-pagename'              => 'O espazo de nomes cambiou desde a definición',
	'tog-translate-nonewsletter'             => 'Non me enviedes follas informativas ao meu correo electrónico (só relevante para os usuarios cun enderezo de correo electrónico confirmado)',
	'right-translate'                        => 'Editar usando a interface de tradución',
	'translate-rc-translation-filter'        => 'Filtrar as traducións:',
	'translate-rc-translation-filter-no'     => 'Non facer nada',
	'translate-rc-translation-filter-only'   => 'Amosar só as traducións',
	'translate-rc-translation-filter-filter' => 'Amosar o que non sexan traducións',
	'translate-rc-translation-filter-site'   => 'Amosar só os cambios nas mensaxes do sitio',
	'translationstats'                       => 'Estatísticas das traducións',
	'translate-stats-edits'                  => 'Edicións ao día',
	'translate-stats-users'                  => 'Tradutores',
	'translate-statsf-intro'                 => 'Pode xerar estatísticas de forma sinxela con este formulario. Todos os valores teñen límites máximos e mínimos.',
	'translate-statsf-options'               => 'Opcións da gráfica',
	'translate-statsf-width'                 => 'Ancho en píxeles',
	'translate-statsf-height'                => 'Altura en píxeles',
	'translate-statsf-days'                  => 'Período de tempo en días',
	'translate-statsf-scale'                 => 'Escala',
	'translate-statsf-scale-days'            => 'Días',
	'translate-statsf-scale-hours'           => 'Horas',
	'translate-statsf-count'                 => 'Medida',
	'translate-statsf-count-edits'           => 'Número de edicións',
	'translate-statsf-count-users'           => 'Tradutores activos',
	'translate-statsf-language'              => 'Lista dos códigos de lingua (separados por comas)',
	'translate-statsf-group'                 => 'Lista dos códigos dos grupos de mensaxes (separados por comas)',
	'translate-statsf-submit'                => 'Vista previa',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'translate'                         => 'Dy hyndaa',
	'translate-edit'                    => 'reaghey',
	'translate-history'                 => 'shennaghys',
	'translate-page-group'              => 'Possan',
	'translate-page-language'           => 'Çhengey',
	'translate-page-limit'              => 'Jeoraght',
	'translate-edit-in-other-languages' => 'Çhaghteraght ayns çhengaghyn elley',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'translate-edit' => 'phiên-chho',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 * @author Kalani
 */
$messages['haw'] = array(
	'translate'         => 'Unuhi',
	'translate-edit'    => 'e ho‘opololei',
	'translate-history' => 'mo‘olelo',
);

/** Hebrew (עברית)
 * @author Agbad
 * @author Rotemliss
 */
$messages['he'] = array(
	'translate'                         => 'תרגום',
	'translate-desc'                    => '[[Special:Translate|דף מיוחד]] לתרגום מדיה־ויקי ומעבר לכך',
	'translate-edit'                    => 'עריכה',
	'translate-talk'                    => 'שיחה',
	'translate-history'                 => 'היסטוריה',
	'translate-task-view'               => 'הצגת כל ההודעות מתוך',
	'translate-task-untranslated'       => 'הצגת כל ההודעות שאינן מתורגמות מתוך',
	'translate-task-problematic'        => 'הצגת הודעות עם בעיות',
	'translate-task-review'             => 'הצגת שינויים בתוך',
	'translate-task-reviewall'          => 'הצגת שינויים בכל ההודעות שתורגמו בתוך',
	'translate-task-export'             => 'ייצוא תרגומים מתוך',
	'translate-task-export-to-file'     => 'ייצוא תרגומים לקובץ מתוך',
	'translate-page-task'               => 'תצוגה',
	'translate-page-group'              => 'קבוצה',
	'translate-page-language'           => 'שפה',
	'translate-page-limit'              => 'הגבלה',
	'translate-page-limit-option'       => 'עד {{PLURAL:$1|הודעה אחת|$1 הודעות}} בדף',
	'translate-submit'                  => 'הצגה',
	'translate-page-navigation-legend'  => 'ניווט',
	'translate-page-showing'            => 'הצגת הודעות מ־$1 עד $2 מתוך $3.',
	'translate-page-showing-all'        => 'הצגת {{PLURAL:$1|הודעה אחת|$1 הודעות}}.',
	'translate-page-showing-none'       => 'אין הודעות להצגה.',
	'translate-next'                    => 'לדף הבא',
	'translate-prev'                    => 'לדף הקודם',
	'translate-page-description-legend' => 'מידע על הקבוצה',
	'translate-page-edit'               => 'עריכה',
	'translate-edit-contribute'         => 'תרומה',
	'translate-edit-information'        => 'מידע על ההודעה ($1)',
	'translate-edit-goto-no-prev'       => 'אין הודעה קודמת',
	'translate-edit-goto-no-next'       => 'אין הודעה באה',
	'translate-edit-goto-prev'          => 'עריכת ההודעה הקודמת',
	'translate-edit-goto-next'          => 'עריכת ההודעה הבאה',
	'translate-edit-goto-list'          => 'חזרה לרשימה',
	'translate-magic-submit'            => 'הצגה',
	'translate-magic-cm-export'         => 'ייצוא',
	'translate-magic-cm-to-be'          => 'עתידיים',
	'translate-magic-cm-current'        => 'נוכחיים',
	'translate-magic-cm-original'       => 'מקורי',
	'translate-magic-cm-comment'        => 'סיבה:',
	'translate-magic-cm-save'           => 'שמירה',
	'translate-magic-special'           => 'שמות דפים מיוחדים',
	'translate-magic-words'             => 'מילות קסם',
	'translate-magic-skin'              => 'שמות רקעים',
	'translate-magic-namespace'         => 'שמות מרחבי שם',
	'translationchanges'                => 'שינויים בתרגום',
	'translationchanges-export'         => 'ייצוא',
);

/** Hindi (हिन्दी)
 * @author Ashishbhatnagar72
 * @author Kaustubh
 */
$messages['hi'] = array(
	'translate'                        => 'अनुवाद',
	'translate-edit'                   => 'संपादन',
	'translate-talk'                   => 'वार्ता',
	'translate-history'                => 'इतिहास',
	'translate-task-view'              => 'से सभी संदेश देखें',
	'translate-task-untranslated'      => 'से सभी अननुवादित संदेश देखें',
	'translate-task-optional'          => 'से वैकल्पिक संदेश देखें',
	'translate-task-review'            => 'बदलावों का पुनरावलोकन',
	'translate-task-reviewall'         => 'में सभी अनुवादों का पुनरावलिकन करें',
	'translate-task-export'            => 'से अनुवाद आयात करें.',
	'translate-page-disabled'          => "इस भा्षा के इस समूह में अनुवाद बंद हैं. कारण:
''$1''",
	'translate-page-language'          => 'भाषा',
	'translate-page-navigation-legend' => 'नैविगेशन',
	'translate-page-showing'           => '$3 में से $1 से $2  तक संदेश दर्शित हैं.',
	'translate-optional'               => '(वैकल्पिक)',
	'translate-magic-submit'           => 'ढूंढे',
	'translate-magic-cm-export'        => 'निर्यात',
	'translate-magic-cm-comment'       => 'टिप्पणी:',
	'translate-magic-cm-save'          => 'संजोयें',
	'translationchanges-export'        => 'निर्यात',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'translate-edit'                   => 'ilisan',
	'translate-talk'                   => 'hisayranay',
	'translate-history'                => 'saysay',
	'translate-page-navigation-legend' => 'Nabigayson',
);

/** Croatian (Hrvatski)
 * @author Dnik
 * @author SpeedyGonsales
 * @author Siebrand
 */
$messages['hr'] = array(
	'translate'                         => 'Prijevodi sistemskih poruka',
	'translate-edit'                    => 'uredi',
	'translate-talk'                    => 'razgovor',
	'translate-history'                 => 'povijest',
	'translate-task-view'               => 'Vidjeti sve poruke u prostoru',
	'translate-task-untranslated'       => 'Vidjeti sve neprevedene poruke u prostoru',
	'translate-task-optional'           => 'Vidjeti dodatne (optional) poruke u prostoru',
	'translate-task-review'             => 'Vidjeti promjene u prostoru',
	'translate-task-reviewall'          => 'Vidjeti sve prijevode u prostoru',
	'translate-task-export'             => 'Izvesti (export) prijevode iz prostora',
	'translate-task-export-to-file'     => 'Izvesti (export) u datoteku prijevode iz prostora',
	'translate-task-export-as-po'       => 'Izvesti (export) prijevod u formatu Gettext',
	'translate-page-no-such-language'   => 'Unešen je nevaljani kod jezika',
	'translate-page-settings-legend'    => 'Postavke',
	'translate-page-task'               => 'Želim',
	'translate-page-group'              => 'Grupa',
	'translate-page-language'           => 'Jezik',
	'translate-page-limit'              => 'Prikaži maks.',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|poruka|poruke|poruka}} po stranici',
	'translate-submit'                  => 'Nađi',
	'translate-page-navigation-legend'  => 'Navigacija',
	'translate-page-showing'            => 'Prikazane poruke od $1 do $2 od ukupno $3.',
	'translate-page-showing-all'        => 'Prikazano: $1 {{PLURAL:$1|poruka|poruke|poruka}}.',
	'translate-page-showing-none'       => 'Nema traženih poruka.',
	'translate-next'                    => 'Slijedeća stranica',
	'translate-prev'                    => 'Prethodna stranica',
	'translate-page-description-legend' => 'Podaci o grupi',
	'translate-optional'                => '(opcionalno)',
	'translate-ignored'                 => '(zanemareno)',
	'translate-edit-definition'         => 'Definicija poruke',
	'translate-edit-contribute'         => 'dodaj',
	'translate-edit-no-information'     => "''Ova poruka nema dokumentacije. Ako znate gdje ili kako se koristi poruka, možete pomoći drugim prevoditeljima dodavajući dokumentaciju ovoj poruci.''",
	'translate-edit-information'        => 'Informacije o ovoj poruci ($1)',
	'translate-edit-in-other-languages' => 'Poruka u drugim jezicima',
	'translate-edit-warnings'           => 'Upozorenja o nepotpunim prijevodima',
	'translate-magic-submit'            => 'Dohvati',
	'translate-magic-cm-export'         => 'Izvezi',
	'translate-magic-cm-to-be'          => 'Budući',
	'translate-magic-cm-current'        => 'Trenutni',
	'translate-magic-cm-original'       => 'Izvornik',
	'translate-magic-cm-save'           => 'Snimi',
	'translate-magic-cm-updatedusing'   => 'Osvježeno uporabom [[Special:Magic]] stranice',
	'translate-magic-cm-savefailed'     => 'Snimanje nije uspjelo',
	'translate-magic-special'           => 'Alijasi posebnih stranica',
	'translate-magic-words'             => 'Magične riječi (stringovi)',
	'translate-magic-skin'              => 'Imena skinova',
	'translate-magic-namespace'         => 'Imena imenskih prostora',
	'translationchanges'                => 'Prevoditeljske promjene',
	'translationchanges-export'         => 'izvedi (export)',
	'translate-checks-parameters'       => 'Sljedeći parametri se ne koriste:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'          => 'Nejednak broj zagrada:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'            => 'Sljedeće poveznice su problematične:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'           => 'Definicija koristi <nowiki>{{PLURAL:}}</nowiki>, ali prijevod ne.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 * @author Siebrand
 * @author Dundak
 */
$messages['hsb'] = array(
	'translate'                              => 'Přełožić',
	'translate-desc'                         => '[[Special:Translate|Specialna strona]] za přełožowanje Mediawiki a druheho',
	'translate-edit'                         => 'wobdźěłać',
	'translate-talk'                         => 'diskusija',
	'translate-history'                      => 'stawizny',
	'translate-task-view'                    => 'Pokazaj wšě zdźělenki',
	'translate-task-untranslated'            => 'Pokazaj njepřełožene zdźělenki',
	'translate-task-optional'                => 'Pokazaj opcionalne zdźělenki',
	'translate-task-problematic'             => 'Zdźělenki pokazać, kotrež maja problemy',
	'translate-task-review'                  => 'Přepruwuj změny za',
	'translate-task-reviewall'               => 'Přepruwuj wšě přełožki w',
	'translate-task-export'                  => 'Eksportuj přełožki',
	'translate-task-export-to-file'          => 'Eksportuj přełožk do dataje',
	'translate-task-export-as-po'            => 'Přełožk we formaće Gettext eksportować',
	'translate-task-export-to-xliff'         => 'Přełožk do formata Xliff eksportować',
	'translate-page-no-such-language'        => 'Njepłaćiwy rěčny kod podaty',
	'translate-page-no-such-task'            => 'Podaty nadawk bě njepłaćiwy.',
	'translate-page-no-such-group'           => 'Podata skupina bě njepłaćiwa.',
	'translate-page-disabled'                => "Přełožki do tuteje rěče w tutej skupinje buchu znjemóžnjene. Přičina:

''$1''",
	'translate-page-settings-legend'         => 'Nastajenja',
	'translate-page-task'                    => 'Akcija',
	'translate-page-group'                   => 'Skupina',
	'translate-page-language'                => 'Rěč',
	'translate-page-limit'                   => 'Ličba zdźělenkow',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|zdźělenka|zdźělence|zdźělenki|zdźělenkow}} na stronu',
	'translate-submit'                       => 'Pokazać',
	'translate-page-navigation-legend'       => 'Nawigacija',
	'translate-page-showing'                 => 'Zdźělenki wot $1 do $2 z $3 pokazać.',
	'translate-page-showing-all'             => '{{PLURAL:$1|Pokazuje so|Pokazujetej so|Pokazuja so|Pokazuje so}} $1 {{PLURAL:$1|zdźělenka|zdźělence|zdźělenki|zdźělenkow}}.',
	'translate-page-showing-none'            => 'Njejsu zdźělenki, kotrež hodźa so pokazać.',
	'translate-next'                         => 'Přichodna strona',
	'translate-prev'                         => 'Předchadna strona',
	'translate-page-description-legend'      => 'Informacije wo skupinje',
	'translate-page-edit'                    => 'wobdźěłać',
	'translate-optional'                     => '(opcionalny)',
	'translate-ignored'                      => '(ignorowany)',
	'translate-edit-definition'              => 'Definicija zdźělenki',
	'translate-edit-contribute'              => 'přinošować',
	'translate-edit-no-information'          => "''Tuta zdźělenka dokumentaciju nima, Jeli wěš, hdźež tuta zdźělenka so wužiwa, móžeš druhim přełožowarjam pomhać přidawajo dokumentaciju k tutej zdźělence.''",
	'translate-edit-information'             => 'Informacije wo tutej zdźělence ($1)',
	'translate-edit-in-other-languages'      => 'Zdźělenka w druhich rěčach',
	'translate-edit-committed'               => 'Aktualny přełožk w softwarje',
	'translate-edit-warnings'                => 'Warnowanja wo njedospołnych přełožkach',
	'translate-edit-goto-no-prev'            => 'Žana předchadna zdźělenka',
	'translate-edit-goto-no-next'            => 'Žana přichodna zdźělenka',
	'translate-edit-goto-prev'               => 'Předchadnu zdźělenku wobdźěłać',
	'translate-edit-goto-next'               => 'Přichodnu zdźělenku wobdźěłać',
	'translate-edit-goto-list'               => 'Wróćo k lisćinje',
	'translate-magic-pagename'               => 'Rozšěrjeny přełožk MediaWiki',
	'translate-magic-help'                   => 'Móžěs aliasy specialnych stronow, magiske słowa, mjena šatow a mjena mjenowych rumow přełožić.

W magiskich słowach dyrbiš jendźelske přełožki zapřijeć abo hižo njebudu fungować. Wostaj tež prěni zapisk (0 abo 1) kaž je.

Aliasy specialnych stronow a magiske słowa móža wjacore přełožki měć. Přełožki so přez komy (,) wotdźěleja. Mjeno šatow a mjenowe rumy móže jenož jedyn přełožk měć.

W přełožkach mjenowych rumow <tt>$1 diskusija</tt> je specialna. <tt>$1</tt> so přez mjeno strony, na př. <tt>{{SITENAME}} diskusija</tt> naruna. Jeli w twojej rěči njeje móžno płaćiwy wuraz tworić, bjeztoho zo by so mjeno strony změniło, skontaktuj prošu wuwiwarja.

Dyrbiš w skupinje přełožowarjow być, zo by změny składował. Změny so njeskładuja, doniž  składowanske tłóčatko njekliknješ.',
	'translate-magic-module'                 => 'Modul:',
	'translate-magic-submit'                 => 'Pokazać',
	'translate-magic-cm-export'              => 'Eksportować',
	'translate-magic-cm-to-be'               => 'Ma być:',
	'translate-magic-cm-current'             => 'Tuchwilu',
	'translate-magic-cm-original'            => 'Original',
	'translate-magic-cm-comment'             => 'Komentar:',
	'translate-magic-cm-save'                => 'Składować',
	'translate-magic-cm-updatedusing'        => 'Z [[Special:Magic]] zaktualizowany',
	'translate-magic-cm-savefailed'          => 'Składowanje njeporadźiło',
	'translate-magic-special'                => 'Aliasy specialnych stronow',
	'translate-magic-words'                  => 'Magiske słowa',
	'translate-magic-skin'                   => 'Mjeno šatow',
	'translate-magic-namespace'              => 'Mjena mjenowych rumow',
	'translationchanges'                     => 'Přełožowanske změny',
	'translationchanges-export'              => 'eksportować',
	'translationchanges-change'              => '$1: $2 wot $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|Slědowacy parameter|Slědowacej parametraj|Slědowace parametry|Slědowacych parametrow}} so {{PLURAL:$2|njewužiwa|njewužiwatej|njewužiwaja|njewužiwa}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|Slědowacy parameter je njeznaty|Slědowacej parametraj stej njeznatej|Slědowace parametry su njeznate|Slědowacych parametrow je njeznate}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Je njeruna ličba {{PLURAL:$2|spinka|spinkow|spinkow|spinkow}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|Slědowacy wotkaz je problematiski|Slědowacej wotkazaj stej problematiskej|Slědowace wotkazy wotkazy su problematiske|Slědowacych wotkazow je problematiske}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Narunaj prošu {{PLURAL:$2|slědowacu tafličku|slědowacej tafličce|slědowace taflički|slědowacych tafličkow}} přez {{PLURAL:$2|korektnu|korektnej|korektne|korektne}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'Definicija wužiwa <nowiki>{{PLURAL:}}</nowiki>, přełožk pak nic.',
	'tog-translate-nonewsletter'             => 'Njepósćel mi žadyn e-mejlowy dopis nowinkow (jenož za wužiwarjow z wobkrućenej e-mejlowej adresu relewantny)',
	'right-translate'                        => 'Z pomocu powjercha přełožowanja wobdźěłać',
	'translate-rc-translation-filter'        => 'Přełožki filtrować:',
	'translate-rc-translation-filter-no'     => 'Ničo nječinić',
	'translate-rc-translation-filter-only'   => 'Jenož přełožki pokazać',
	'translate-rc-translation-filter-filter' => 'Přełožki wufiltrować',
	'translate-rc-translation-filter-site'   => 'Jenož změny sydłowych zdźělenkow',
	'translate-stats-edits'                  => 'Změny na dźeń',
);

/** Haitian (Kreyòl ayisyen)
 * @author Jvm
 * @author Masterches
 */
$messages['ht'] = array(
	'translate'                         => 'Tradui',
	'translate-desc'                    => '[[Special:Translate|Paj espesyal]] pou tradui MediaWiki e plis ankò.',
	'translate-edit'                    => 'edite',
	'translate-talk'                    => 'pale',
	'translate-history'                 => 'istwa',
	'translate-task-view'               => 'Wè tout mesaj soti nan',
	'translate-task-untranslated'       => 'Wè tout mesaj ki pa tradui soti nan',
	'translate-task-optional'           => 'Wè mesaj optional soti nan',
	'translate-task-review'             => 'Revize chanjman nan',
	'translate-task-reviewall'          => 'Revize tout tradiksyon yo nan',
	'translate-task-export'             => 'Ekspòte tradiksyon yo nan',
	'translate-task-export-to-file'     => 'Ekspòte tradisyon a nan yon fichye depi',
	'translate-task-export-as-po'       => 'Ekspòte nan fòma Gettext tradiksyon pou',
	'translate-page-no-such-language'   => 'Langaj espesifye-a envalid.',
	'translate-page-no-such-task'       => 'Tach espesifye-a envalid.',
	'translate-page-no-such-group'      => 'Group espesifye-a invalid',
	'translate-page-settings-legend'    => 'Konfigirasyon, preferans',
	'translate-page-task'               => 'Mwen vle',
	'translate-page-group'              => 'Gwoup',
	'translate-page-language'           => 'Lang',
	'translate-page-limit'              => 'Limit',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|mesaj|mesaj}} nan chak paj',
	'translate-submit'                  => 'Ale, fouye',
	'translate-page-navigation-legend'  => 'Navigasyon',
	'translate-page-showing'            => 'Moutre mesaj $1 a $2 sou $3.',
	'translate-page-showing-all'        => 'Moutre $1 {{PLURAL:$1|message|mesaj}}.',
	'translate-page-showing-none'       => 'Pa genyen pyès mesaj pou montre.',
	'translate-next'                    => 'Paj swivan',
	'translate-prev'                    => 'Paj presedan',
	'translate-page-description-legend' => 'Enfòmasyon sou group la',
	'translate-optional'                => '(opsyonal)',
	'translate-ignored'                 => '(ignore)',
	'translate-edit-definition'         => 'Mesaj definisyon',
	'translate-edit-contribute'         => 'kontribiye',
	'translate-edit-no-information'     => "''Mesaj sa pa dokimante.
Si w konnen ki kote mesaj sa itilize, ou kapab ede lòt tradiktè pa ajoute dokimantasyon pou mesaj sa.''",
	'translate-edit-information'        => 'Enfòmasyon konsène mesaj sa ($1)',
	'translate-edit-in-other-languages' => 'Mesaj nan lòt langaj yo',
	'translate-edit-committed'          => 'Trandiksyon kouran nan logisye',
	'translate-edit-warnings'           => 'Kosyon konsène tradiksyon enkonplete yo',
	'translate-magic-pagename'          => 'MediaWiki tradiksyon prolonje',
	'translate-magic-help'              => 'Ou kapab tradui alias paj especial yo, mo majik, non po yo ak non nonespas yo.

Nan mo majik yo ou bezwen enkli tradiksyon angle oubyen yo sispann travay.
Epi kite premye bagay la (0 or 1) kòm li ye.

Alias paj espesyal yo ak mo majik yo kapab gen miltip tradiksyon.
Tradiksyon yo separe pa yon vigil (,).
Non po ak nonespas kapab gen yon sèl tradiksyon.

Nan nonespas tradiksyon yo <tt>$1 pale</tt> espesyal. <tt>$1</tt> ranplase pa nonsitwèb (pa ekzanp <tt>{{SITENAME}} pale</tt>).
Si li pa posib nan langaj ou pou fòme expresyon valid san ou pa chanje nonsitwèb, souple kontakte yon devlopè.

Fò ke ou nan yon group tradiktè pou ou kapab sove chanjman.
Chanjman yo pa sove tou pandan ou pa klike sou bouton sove anba.',
	'translate-magic-submit'            => 'Mande',
	'translate-magic-cm-export'         => 'Expòte',
	'translate-magic-cm-to-be'          => "Ap vin'",
	'translate-magic-cm-current'        => 'Aktyèl',
	'translate-magic-cm-original'       => 'Orijinal',
	'translate-magic-cm-comment'        => 'Kòmantè:',
	'translate-magic-cm-save'           => 'Sove',
	'translate-magic-cm-updatedusing'   => 'Met an kouran itilize [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => 'Sove chwe',
	'translate-magic-special'           => 'Alias paj espesyal yo',
	'translate-magic-words'             => 'Mo majik yo',
	'translate-magic-skin'              => 'Non po',
	'translate-magic-namespace'         => 'Non nonespas yo',
	'translationchanges'                => 'Tradiksyon chanjman',
	'translationchanges-export'         => 'expòte',
	'translationchanges-change'         => '$1: $2 pa $3',
	'translate-checks-parameters'       => 'Paramèt swivan yo pa itilize: <strong>$1</strong>',
	'translate-checks-balance'          => 'Genyen yon kantite paramè enpè: <strong>$1</strong>',
	'translate-checks-links'            => 'Chèn swivan yo problèmatik: <strong>$1</strong>',
	'translate-checks-xhtml'            => 'Souple ranplase tag swivan yo avèk sa ki kòrèk yo: <strong>$1</strong>',
	'translate-checks-plural'           => 'Definisyon itilize <nowiki>{{PLURAL:}}</nowiki> men pa tradiksyon.',
	'tog-translate-nonewsletter'        => 'Piga voye e-mèl korespondans ban mwen (relevan sèlman pou itilizatè avèk yon adrès e-mèl valide)',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Siebrand
 */
$messages['hu'] = array(
	'translate'                         => 'Fordítás',
	'translate-edit'                    => 'szerk',
	'translate-talk'                    => 'vita',
	'translate-history'                 => 'laptörténet',
	'translate-task-view'               => 'Összes üzenet megtekintése',
	'translate-task-untranslated'       => 'Összes fordítatlan üzenet megtekintése',
	'translate-task-optional'           => 'Nem kötelező üzenetek megtekintése',
	'translate-task-review'             => 'Változások áttekintése',
	'translate-task-reviewall'          => 'Összes fordítás áttekintése',
	'translate-task-export'             => 'Fordítások kimentése',
	'translate-task-export-to-file'     => 'Fordítások kimentése fájlba',
	'translate-task-export-as-po'       => 'Fordítás kimentése Gettext formátumba',
	'translate-page-no-such-language'   => 'A megadott nyelv érvénytelen',
	'translate-page-no-such-task'       => 'A megadott művelet érvénytelen',
	'translate-page-no-such-group'      => 'A megadott csoport érvénytelen',
	'translate-page-settings-legend'    => 'Beállítások',
	'translate-page-task'               => 'Elvégzendő művelet',
	'translate-page-group'              => 'Csoport',
	'translate-page-language'           => 'Nyelv',
	'translate-page-limit'              => 'Megjelenítendő elemek',
	'translate-page-limit-option'       => '$1 üzenet/oldal',
	'translate-submit'                  => 'Megjelenítés',
	'translate-page-navigation-legend'  => 'Navigáció',
	'translate-page-showing'            => 'Üzenetek: $1–$2 (összesen $3)',
	'translate-page-showing-all'        => '$1 üzenet megjelenítve',
	'translate-page-showing-none'       => 'Nincs a keresési feltételeknek megfelelő üzenet',
	'translate-next'                    => 'következő',
	'translate-prev'                    => 'előző',
	'translate-page-description-legend' => 'Információk a csoportról',
	'translate-optional'                => '(nem kötelező)',
	'translate-ignored'                 => '(figyelmen kívül hagyva)',
	'translate-edit-definition'         => 'Alapértelmezett érték',
	'translate-edit-contribute'         => 'szerkesztés',
	'translate-edit-no-information'     => "''Ehhez az üzenethez még nincs leírás. Ha tudod, hogy hogyan kell használni, akkor segítheted a többi fordítót a dokumentálásával.''",
	'translate-edit-information'        => 'Használat ($1)',
	'translate-edit-in-other-languages' => 'Az üzenet más nyelveken',
	'translate-edit-committed'          => 'Jelenlegi fordítás',
	'translate-edit-warnings'           => 'Hiányosságok a fordításban',
	'translate-magic-submit'            => 'Lekérés',
	'translate-magic-cm-export'         => 'Exportálás',
	'translate-magic-cm-to-be'          => 'Leendő',
	'translate-magic-cm-current'        => 'Jelenlegi',
	'translate-magic-cm-original'       => 'Eredeti',
	'translate-magic-cm-save'           => 'Mentés',
	'translate-magic-cm-updatedusing'   => 'Frissítve a [[Special:Magic]] használatával',
	'translate-magic-cm-savefailed'     => 'Mentés sikertelen',
	'translate-magic-special'           => 'Speciális lapok álnevei',
	'translate-magic-skin'              => 'Felületek nevei',
	'translate-magic-namespace'         => 'Névterek nevei',
	'translationchanges'                => 'Változások a fordításokban',
	'translationchanges-export'         => 'kimentés',
	'translationchanges-change'         => '$1: $2 $3 által',
	'translate-checks-parameters'       => 'A következő paraméterek nincsenek használva: <strong>$1</strong>',
	'translate-checks-balance'          => 'Nem egyenlő számban vannak használva a nyitó- és zárójelek: <strong>$1</strong>',
	'translate-checks-links'            => 'A következő linkek nem megfelelőek: <strong>$1</strong>',
	'translate-checks-xhtml'            => 'A következő tag-eket cseréld le a megfelelőekre: <strong>$1</strong>',
	'translate-checks-plural'           => 'Az alapértelmezett változatban van <nowiki>{{PLURAL:}}</nowiki> forma, míg a fordításban nincs (magyar nyelv esetén ez nem feltétlenül probléma!).',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'translate-edit'                   => 'modificar',
	'translate-page-group'             => 'Gruppo',
	'translate-page-navigation-legend' => 'Navigation',
	'translate-magic-cm-export'        => 'Exportar',
	'translate-magic-cm-comment'       => 'Commento:',
	'translate-magic-cm-save'          => 'Immagazinar',
	'translationchanges-export'        => 'exportar',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Rex
 * @author Irwangatot
 * @author Meursault2004
 * @author Siebrand
 */
$messages['id'] = array(
	'translate'                              => 'Terjemahan',
	'translate-desc'                         => '[[Special:Translate|Halaman istimewa]] untuk menerjemahkan Mediawiki',
	'translate-edit'                         => 'sunting',
	'translate-talk'                         => 'bicara',
	'translate-history'                      => 'versi',
	'translate-task-view'                    => 'Tampilkan semua pesan dari',
	'translate-task-untranslated'            => 'Tampilkan semua pesan yang belum diterjemahkan dari',
	'translate-task-optional'                => 'Tampilkan pesan opsional dari',
	'translate-task-problematic'             => 'Tampilkan pesan-pesan bermasalah',
	'translate-task-review'                  => 'Tinjau perubahan dari',
	'translate-task-reviewall'               => 'Tinjau semua perubahan pada',
	'translate-task-export'                  => 'Ekspor terjemahan dari',
	'translate-task-export-to-file'          => 'Ekspor terjemahan ke berkas dari',
	'translate-task-export-as-po'            => 'Ekspor terjemahan ke format Gettext dari',
	'translate-task-export-to-xliff'         => 'Ekspor terjemahan dalam format Xliff',
	'translate-page-no-such-language'        => 'Bahasa yang dipilih tak valid.',
	'translate-page-no-such-task'            => 'Operasi yang dipilih tak valid.',
	'translate-page-no-such-group'           => 'Grup yang dipilih tak valid.',
	'translate-page-disabled'                => "Penerjemahan dalam bahasa ini telah dinon-aktifkan. Alasan:

''$1''",
	'translate-page-settings-legend'         => 'Pengaturan',
	'translate-page-task'                    => 'Saya ingin',
	'translate-page-group'                   => 'Kelompok',
	'translate-page-language'                => 'Bahasa',
	'translate-page-limit'                   => 'Batasan',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|pesan|pesan}} per halaman',
	'translate-submit'                       => 'Ambil',
	'translate-page-navigation-legend'       => 'Navigasi',
	'translate-page-showing'                 => 'Menampilkan pesan $1 hingga $2 dari $3.',
	'translate-page-showing-all'             => 'Menampilkan $1 {{PLURAL:$1|pesan|pesan}}.',
	'translate-page-showing-none'            => 'Tak ada pesan yang dapat ditampilkan.',
	'translate-next'                         => 'Halaman selanjutnya',
	'translate-prev'                         => 'Halaman sebelumnya',
	'translate-page-description-legend'      => 'Informasi mengenai grup',
	'translate-page-edit'                    => 'sunting',
	'translate-optional'                     => '(opsional)',
	'translate-ignored'                      => '(diabaikan)',
	'translate-edit-definition'              => 'Definisi pesan',
	'translate-edit-contribute'              => 'berkontribusi',
	'translate-edit-no-information'          => "''Pesan ini tak memiliki dokumentasi. Jika Anda tahu di mana dan bagaimana pesan ini digunakan, Anda dapat menolong penerjemah lain dengan menambahkan dokumentasi bagi pesan ini.''",
	'translate-edit-information'             => 'Informasi mengenai pesan ini ($1)',
	'translate-edit-in-other-languages'      => 'Pesan dalam bahasa lain',
	'translate-edit-committed'               => 'Terjemahan terkini yang ada di perangkat lunak',
	'translate-edit-warnings'                => 'Peringatan mengenai terjemahan yang tak lengkap',
	'translate-edit-goto-no-prev'            => 'Tidak ada pesan sebelumnya',
	'translate-edit-goto-no-next'            => 'Tidak ada pesan berikutnya',
	'translate-edit-goto-prev'               => 'Sunting pesan sebelumnya',
	'translate-edit-goto-next'               => 'Sunting pesan berikutnya',
	'translate-edit-goto-list'               => 'Kembali ke daftar',
	'translate-magic-pagename'               => 'Perluasan terjemahan Mediawiki',
	'translate-magic-help'                   => 'Anda dapat menerjemahkan alias untuk halaman istimewa, kata magis, nama kulit, dan nama ruang nama.

Untuk kata magis, Anda perlu mencantumkan pula terjemahan bahasa Inggris atau akan terjadi kesalahan. Juga biarkan item pertama (0 atau 1) tercantum apa adanya.

Alias untuk halaman istimewa dan kata magis dapat memiliki lebih dari satu terjemahan.
Masing-masing harus dipisahkan dengan sebuah tanda koma (,).
Nama kulit dan ruang nama hanya dapat memiliki satu terjemahan.

Dalam menerjemahkan, ruang nama <tt>$1 talk</tt> harus diperlakukan khusus. <tt>$1</tt> digantikan dengan nama situs (contohnya <tt>{{SITENAME}} talk</tt>).
Jika bahasa Anda tidak memungkinkan untuk membentuk suatu ekspresi yang valid tanpa mengganti nama situs, silakan kontak salah seorang pengembang.

Anda perlu menjadi anggota kelompok penerjemah untuk menyimpan perubahan.
Perubahan tak akan disimpan hingga Anda mengklik tombol simpan di bawah.',
	'translate-magic-module'                 => 'Modul:',
	'translate-magic-submit'                 => 'Ambil',
	'translate-magic-cm-export'              => 'Ekspor',
	'translate-magic-cm-to-be'               => 'Menjadi',
	'translate-magic-cm-current'             => 'Kini',
	'translate-magic-cm-original'            => 'Asal',
	'translate-magic-cm-comment'             => 'Komentar:',
	'translate-magic-cm-save'                => 'Simpan',
	'translate-magic-cm-updatedusing'        => 'Diperbaharui menggunakan [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Penyimpanan gagal',
	'translate-magic-special'                => 'Alias halaman istimewa',
	'translate-magic-words'                  => 'Kata magis',
	'translate-magic-skin'                   => 'Nama kulit',
	'translate-magic-namespace'              => 'Nama ruang nama',
	'translationchanges'                     => 'Perubahan terjemahan',
	'translationchanges-export'              => 'ekspor',
	'translationchanges-change'              => '$1: $2 oleh $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|Parameter|Parameter-parameter}} berikut tidak digunakan:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|Parameter|Parameter-parameter}} berikut tidak dikenal:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Jumlah {{PLURAL:$2|pengapit|pengapit-pengapit}} tak seimbang:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|Pranala|Pranala-pranala}} berikut bermasalah:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Harap ganti {{PLURAL:$2|tag|tag-tag}} berikut dengan tag yang tepat:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'Definisi menggunakan <nowiki>{{PLURAL:}}</nowiki> tapi terjemahannya tidak.',
	'tog-translate-nonewsletter'             => 'Jangan kirimkan saya e-mail berita (hanya untuk pengguna dengan alamat surat-e yang sudah dikonfirmasi)',
	'right-translate'                        => 'Sunting menggunakan antarmuka penerjemahan',
	'translate-rc-translation-filter'        => 'Filter terjemahan:',
	'translate-rc-translation-filter-no'     => 'Tidak difilter',
	'translate-rc-translation-filter-only'   => 'Tampilkan hanya terjemahan',
	'translate-rc-translation-filter-filter' => 'Tampilkan selain terjemahan',
	'translate-rc-translation-filter-site'   => 'Hanya perubahan ke pesan situs',
	'translate-stats-edits'                  => 'Jumlah suntingan per hari',
);

/** Iloko (Ilokano)
 * @author Saluyot
 */
$messages['ilo'] = array(
	'translate' => 'Ipatarus',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author Jóna Þórunn
 */
$messages['is'] = array(
	'translate'                         => 'Þýða',
	'translate-edit'                    => 'breyta',
	'translate-talk'                    => 'spjall',
	'translate-history'                 => 'breytingaskrá',
	'translate-task-view'               => 'Skoða allar meldingar frá',
	'translate-task-untranslated'       => 'Skoða allar óþýddar meldingar frá',
	'translate-task-optional'           => 'Skoða valfrjálsar meldingar frá',
	'translate-task-review'             => 'Kanna breytingar á',
	'translate-task-reviewall'          => 'Kanna allar breytingar á',
	'translate-page-no-such-language'   => 'Tilgreinda tungumálið var ógilt.',
	'translate-page-no-such-task'       => 'Tilgreinda verkefnið var ógilt.',
	'translate-page-no-such-group'      => 'Tilgreindur hópur var ógildur.',
	'translate-page-settings-legend'    => 'Stillingar',
	'translate-page-task'               => 'Ég vil',
	'translate-page-group'              => 'Hópur',
	'translate-page-language'           => 'Tungumál',
	'translate-page-limit'              => 'Takmark',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|melding|meldingar}} á hverri síðu',
	'translate-submit'                  => 'Sækja',
	'translate-page-navigation-legend'  => 'Flakk',
	'translate-page-showing'            => 'Sýni meldingar frá $1 til $2 af $3.',
	'translate-page-showing-all'        => 'Sýni $1 {{PLURAL:$1|melding|meldingar}}.',
	'translate-page-showing-none'       => 'Engar meldingar til að sýna.',
	'translate-next'                    => 'Næsta síða',
	'translate-prev'                    => 'Fyrri síða',
	'translate-page-description-legend' => 'Upplýsingar um hópinn',
	'translate-optional'                => '(valfrjálst)',
	'translate-ignored'                 => '(hunsað)',
	'translate-edit-definition'         => 'Útskýring á meldingu',
	'translate-edit-contribute'         => 'breyta',
	'translate-edit-no-information'     => "''Þessi melding hefur enga skjölun.
Ef þú veist hvar eða hvernig meldingin er notuð getur þú hjálpað öðrum þýðendum með því að bæta skjölun við hana.''",
	'translate-edit-information'        => 'Upplýsingar um þessa meldingu ($1)',
	'translate-edit-in-other-languages' => 'Melding á öðrum tungumálum',
	'translate-edit-committed'          => 'Núverandi þýðing í hugbúnaðinum',
	'translate-edit-warnings'           => 'Viðvaranir vegna ókláraðar þýðinga',
	'translate-magic-submit'            => 'Sækja',
	'translate-magic-cm-export'         => 'Flytja',
	'translate-magic-cm-to-be'          => 'Verðandi',
	'translate-magic-cm-current'        => 'Núverandi',
	'translate-magic-cm-original'       => 'Upprunalega',
	'translate-magic-cm-comment'        => 'Athugasemd:',
	'translate-magic-cm-save'           => 'Vista',
	'translate-magic-cm-savefailed'     => 'Vistun mistókst',
	'translate-magic-special'           => 'Aukanefni kerfissíðna',
	'translate-magic-skin'              => 'Heiti þema',
	'translate-magic-namespace'         => 'Heiti nafnrýma',
	'translationchanges'                => 'Breytingar þýðinga',
	'translationchanges-export'         => 'flytja',
	'translationchanges-change'         => '$1: $2 eftir $3',
	'translate-checks-parameters'       => 'Eftirfarandi færibreytur eru ekki notaðar: <strong>$1</strong>',
	'translate-checks-links'            => 'Eftirfarandi tenglar eru vafasamir: <strong>$1</strong>',
	'translate-checks-xhtml'            => 'Gjörðu svo vel og skiptu út eftirfarandi tögum fyrir þau réttu: <strong>$1</strong>',
	'translate-checks-plural'           => 'Skilgreiningin notar <nowiki>{{PLURAL:}}</nowiki> en ekki þýðingin.',
	'tog-translate-nonewsletter'        => 'Ekki senda mér rafrænt fréttabréf (aðeins fyrir notendur með staðfest netföng)',
);

/** Italian (Italiano)
 * @author Pietrodn
 * @author Darth Kule
 * @author Melos
 */
$messages['it'] = array(
	'translate'                              => 'Traduzione',
	'translate-desc'                         => '[[Special:Translate|Pagina speciale]] per tradurre MediaWiki e oltre',
	'translate-edit'                         => 'modifica',
	'translate-talk'                         => 'discussione',
	'translate-history'                      => 'cronologia',
	'translate-task-view'                    => 'Visualizzare tutti i messaggi dal',
	'translate-task-untranslated'            => 'Visualizzare tutti i messaggi non tradotti dal',
	'translate-task-optional'                => 'Visualizzare i messaggi opzionali dal',
	'translate-task-problematic'             => 'Visualizzare messaggi che hanno problemi',
	'translate-task-review'                  => 'Revisionare i cambiamenti al',
	'translate-task-reviewall'               => 'Revisionare tutti i messaggi tradotti nel',
	'translate-task-export'                  => 'Esportare le traduzioni dal',
	'translate-task-export-to-file'          => 'Esportare la traduzione in un file dal',
	'translate-task-export-as-po'            => 'Esportare la traduzione nel formato Gettext',
	'translate-task-export-to-xliff'         => 'Esportare la traduzione nel formato Xliff',
	'translate-page-no-such-language'        => 'Il linguaggio specificato non è valido.',
	'translate-page-no-such-task'            => "L'azione specificata non è valida.",
	'translate-page-no-such-group'           => 'Il gruppo specificato non è valido.',
	'translate-page-disabled'                => "Le traduzioni in questa lingua in questo gruppo sono state disabilitate. Motivo:

''$1''",
	'translate-page-settings-legend'         => 'Impostazioni',
	'translate-page-task'                    => 'Voglio',
	'translate-page-group'                   => 'Gruppo',
	'translate-page-language'                => 'Lingua',
	'translate-page-limit'                   => 'Limite',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|messaggio|messaggi}} per pagina',
	'translate-submit'                       => 'Ottieni',
	'translate-page-navigation-legend'       => 'Navigazione',
	'translate-page-showing'                 => 'Mostro i messaggi da $1 a $2 di $3.',
	'translate-page-showing-all'             => 'Mostro $1 {{PLURAL:$1|messaggio|messaggi}}.',
	'translate-page-showing-none'            => 'Nessun messaggio da mostrare.',
	'translate-next'                         => 'Pagina successiva',
	'translate-prev'                         => 'Pagina precedente',
	'translate-page-description-legend'      => 'Informazioni sul gruppo',
	'translate-page-edit'                    => 'modifica',
	'translate-optional'                     => '(opzionale)',
	'translate-ignored'                      => '(ignorato)',
	'translate-edit-definition'              => 'Definizione del messaggio',
	'translate-edit-contribute'              => 'contribuisci',
	'translate-edit-no-information'          => "''Questo messaggio non ha documentazione.
Se sai dove o come è usato questo messaggio, puoi aiutare gli altri traduttori aggiungendo la documentazione a questo messaggio.''",
	'translate-edit-information'             => 'Informazioni su questo messaggio ($1)',
	'translate-edit-in-other-languages'      => 'Messaggio in altre lingue',
	'translate-edit-committed'               => 'Traduzione attuale nel software',
	'translate-edit-warnings'                => 'Avvisi sulle traduzioni incomplete',
	'translate-edit-goto-no-prev'            => 'Nessun messaggio precedente',
	'translate-edit-goto-no-next'            => 'Nessun messaggio successivo',
	'translate-edit-goto-prev'               => 'Modifica il messaggio precedente',
	'translate-edit-goto-next'               => 'Modifica il messaggio successivo',
	'translate-edit-goto-list'               => "Torna all'elenco",
	'translate-magic-pagename'               => 'Traduzione estesa di MediaWiki',
	'translate-magic-help'                   => 'Puoi tradurre gli alias delle pagine speciali, le parole magiche, i nomi delle skin e i nomi dei namespace.

Nelle parole magiche devi includere le traduzioni inglesi o non funzioneranno.
Lascia anche il primo elemento (0 o 1) com\'è.

Gli alias delle pagine speciali e le parole magiche possono avere più traduzioni.
Le traduzioni sono separate da una virgola (,).
I nomi delle skin e i namespace possono avere solo una traduzione.

Nelle traduzioni dei namespace <tt>$1 talk</tt> è speciale. <tt>$1</tt> viene rimpiazzato con il nome del sito (per esempio <tt>{{SITENAME}} talk</tt>).
Se non è possibile formare un\'espressione valida nella tua lingua senza cambiare il nome del sito, per favore contatta uno sviluppatore.

Devi essere nel gruppo dei traduttori per salvare le modifiche.
Le modifiche non vengono salvate finché non clicchi sul bottone "Salva" sotto.',
	'translate-magic-module'                 => 'Modulo:',
	'translate-magic-submit'                 => 'Ottieni',
	'translate-magic-cm-export'              => 'Esporta',
	'translate-magic-cm-to-be'               => 'Nuovo',
	'translate-magic-cm-current'             => 'Attuale',
	'translate-magic-cm-original'            => 'Originale',
	'translate-magic-cm-comment'             => 'Commento:',
	'translate-magic-cm-save'                => 'Salva',
	'translate-magic-cm-updatedusing'        => 'Aggiornato usando [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Salvataggio fallito',
	'translate-magic-special'                => 'Alias delle pagine speciali',
	'translate-magic-words'                  => 'Parole magiche',
	'translate-magic-skin'                   => 'Nomi delle skin',
	'translate-magic-namespace'              => 'Nomi dei namespace',
	'translationchanges'                     => 'Cambiamenti delle traduzioni',
	'translationchanges-export'              => 'esporta',
	'translate-checks-parameters'            => '{{PLURAL:$2|Il seguente parametro non è usato|I seguenti parametri non sono usati}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|Il seguente parametro è sconosciuto|I seguenti parametri sono sconosciuti}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => "C'è un numero di {{PLURAL:$2|parentesi|parentesi}} dispari: <strong><nowiki>$1</nowiki></strong>",
	'translate-checks-links'                 => '{{PLURAL:$2|Il seguente collegamento è problematico|I seguenti $2 collegamenti sono problematici}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Per favore sostituisci {{PLURAL:$2|il tag seguente|i tag seguenti}} con quelli corretti: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'La definizione usa <nowiki>{{PLURAL:}}</nowiki> ma la traduzione no.',
	'tog-translate-nonewsletter'             => 'Non mandarmi le newsletter per e-mail (importante solo per gli utenti con un indirizzo e-mail confermato)',
	'right-translate'                        => "Modifica usando l'interfaccia di traduzione",
	'translate-rc-translation-filter'        => 'Filtra le traduzioni:',
	'translate-rc-translation-filter-no'     => 'Non fare niente',
	'translate-rc-translation-filter-only'   => 'Mostra solo le traduzioni',
	'translate-rc-translation-filter-filter' => 'Elimina le traduzioni',
	'translate-rc-translation-filter-site'   => 'Solo i cambiamenti ai messaggi del sito',
	'translate-stats-edits'                  => 'Edit per giorno',
);

/** Japanese (日本語)
 * @author JtFuruhata
 * @author Marine-Blue
 * @author Siebrand
 */
$messages['ja'] = array(
	'translate'                         => 'ソフトウェアメッセージの翻訳',
	'translate-desc'                    => 'MediaWikiをはじめとするソフトウェアのメッセージを翻訳するための[[Special:Translate|特別ページ]]',
	'translate-edit'                    => '編集',
	'translate-talk'                    => 'ノート',
	'translate-history'                 => '履歴',
	'translate-task-view'               => 'すべてのメッセージ',
	'translate-task-untranslated'       => '未翻訳メッセージ',
	'translate-task-optional'           => '任意翻訳のメッセージ',
	'translate-task-review'             => '更新反映待ちのメッセージ',
	'translate-task-reviewall'          => '翻訳済みメッセージ',
	'translate-task-export'             => '翻訳された PHP コードをテキストエリアに出力',
	'translate-task-export-to-file'     => '翻訳された PHP コードをファイルとしてエクスポート',
	'translate-task-export-as-po'       => '翻訳された PHP コードを gettext 形式でエクスポート',
	'translate-page-no-such-language'   => '言語指定が不正です',
	'translate-page-no-such-task'       => '絞り込みの指定が不正です',
	'translate-page-no-such-group'      => '種類の指定が不正です',
	'translate-page-settings-legend'    => '設定',
	'translate-page-task'               => '絞込み',
	'translate-page-group'              => '種類',
	'translate-page-language'           => '言語',
	'translate-page-limit'              => '表示数',
	'translate-page-limit-option'       => 'ページごとに $1 項目',
	'translate-submit'                  => '再表示',
	'translate-page-navigation-legend'  => 'ナビゲーション',
	'translate-page-showing'            => '全 $3 件中 $1 件目から $2 件目まで表示しています',
	'translate-page-showing-all'        => '全 $1 件を表示しています',
	'translate-page-showing-none'       => '該当する項目はありません。',
	'translate-next'                    => '次のページ',
	'translate-prev'                    => '前のページ',
	'translate-page-description-legend' => 'このグループについて',
	'translate-optional'                => '（任意翻訳）',
	'translate-ignored'                 => '（翻訳無効）',
	'translate-edit-definition'         => '元のメッセージ',
	'translate-edit-contribute'         => '寄稿する',
	'translate-edit-no-information'     => "''このメッセージに関する説明はありません。もし、このメッセージがどこでどのように使われているかご存知でしたら、他の翻訳者のために説明を寄稿してください。なお、このメッセージは多言語共通の表示となりますので、翻訳者全員が理解できる言語（MediaWikiでは英語）での記述をお願いします。''",
	'translate-edit-information'        => 'このメッセージに関する説明（$1）',
	'translate-edit-in-other-languages' => '他言語でのメッセージ',
	'translate-edit-committed'          => '現在ソフトウェア上で採用されている翻訳メッセージ',
	'translate-edit-warnings'           => '不完全な翻訳に対する警告',
	'translate-magic-pagename'          => 'MediaWiki拡張項目の翻訳',
	'translate-magic-help'              => '特別ページへのエイリアス、マジックワード、スキン名、名前空間名も翻訳できます。

マジックワードを翻訳する際には、英語のものも含めておく必要があることに注意してください。さもなくば、それらは動作しなくなります。また、最初の項目（0か1）はそのままにしておいてください。

特別ページへのエイリアスとマジックワードは、コンマ（,）で区切ることにより、複数の翻訳メッセージを持つことができます。スキン名と名前空間名は単一の翻訳メッセージのみを持ちます。

名前空間を翻訳する際、<tt>$1 talk</tt> には特別な注意事項があります。それは、<tt>$1</tt> がサイト名に変更される点です（例えば<tt>{{SITENAME}} talk</tt>の様に）。あなたが翻訳しようとしている言語において、サイト名の変更なしには正しい形式で表現できない場合、開発者に相談してください。

変更を保存できるのは、翻訳者グループに属する利用者のみです。{{int:translate-magic-cm-save}}ボタンを押すまで変更は保存されません。',
	'translate-magic-submit'            => '再表示',
	'translate-magic-cm-export'         => 'エクスポート',
	'translate-magic-cm-to-be'          => '変更後',
	'translate-magic-cm-current'        => '変更前',
	'translate-magic-cm-original'       => '元の内容',
	'translate-magic-cm-comment'        => '編集内容の要約:',
	'translate-magic-cm-save'           => '保存',
	'translate-magic-cm-updatedusing'   => '[[Special:Magic]] による更新に成功しました',
	'translate-magic-cm-savefailed'     => '保存に失敗しました',
	'translate-magic-special'           => '特別ページへのエイリアス',
	'translate-magic-words'             => 'マジックワード',
	'translate-magic-skin'              => 'スキン名',
	'translate-magic-namespace'         => '名前空間名',
	'translationchanges'                => '翻訳変更状況',
	'translationchanges-export'         => 'エクスポート',
	'translationchanges-change'         => '$1: $2 翻訳者-$3',
	'translate-checks-parameters'       => '次のパラメータが利用されていません:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'          => '括弧の数が一致していません:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'            => 'リンクに問題があります:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'            => '正しいタグに修正してください:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'           => '元のメッセージでは <nowiki>{{PLURAL:}}</nowiki> を使用していますが、翻訳の中にはありません。',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'translate'                         => 'Pertalna/Terjemahna',
	'translate-desc'                    => '[[Special:Translate|Kaca astaméwa]] kanggo mertal Mediawiki lan liyané',
	'translate-edit'                    => 'sunting',
	'translate-talk'                    => 'wicara',
	'translate-history'                 => 'sajarah/vèrsi',
	'translate-task-view'               => 'Tuduhna kabèh pesen saka',
	'translate-task-untranslated'       => 'Tuduhna kabèh pesen sing durung dipertal saka',
	'translate-task-optional'           => 'Tuduhna pesen opsional saka',
	'translate-task-review'             => 'Tinjo owah-owahan saka',
	'translate-task-reviewall'          => 'Tinjo kabèh owah-owahan ing',
	'translate-task-export'             => 'Èkspor pertalan saka',
	'translate-task-export-to-file'     => 'Èkspor pertalan menyang berkas saka',
	'translate-task-export-as-po'       => 'Èkspor pertalan ing format Gettext',
	'translate-page-no-such-language'   => 'Basa sing dipilih ora absah.',
	'translate-page-no-such-task'       => 'Operasi sing dipilih ora absah.',
	'translate-page-no-such-group'      => 'Grup sing dipilih ora absah.',
	'translate-page-settings-legend'    => 'Pangaturan',
	'translate-page-task'               => 'Aku kepéngin',
	'translate-page-group'              => 'Kelompok',
	'translate-page-language'           => 'Basa',
	'translate-page-limit'              => 'Limit (wates)',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|pesen|pesen}} per kaca',
	'translate-submit'                  => 'Jupuk',
	'translate-page-navigation-legend'  => 'Navigasi',
	'translate-page-showing'            => 'Nuduhaké pesen $1 nganti $2 saka $3.',
	'translate-page-showing-all'        => 'Nuduhaké $1 {{PLURAL:$1|pesen|pesen}}.',
	'translate-page-showing-none'       => 'Ora ana pesen sing bisa dituduhaké.',
	'translate-next'                    => 'Kaca sabanjuré',
	'translate-prev'                    => 'Kaca sadurungé',
	'translate-page-description-legend' => 'Informasi ngenani grup utawa kelompok',
	'translate-optional'                => '(opsional)',
	'translate-ignored'                 => '(dilirwakaké)',
	'translate-edit-definition'         => 'Définisi pesen',
	'translate-edit-contribute'         => 'awèh kontribusi',
	'translate-edit-no-information'     => "''Pesen iki ora nduwé dokumèntasi. Menawa panjenengan ngerti kepriyé pesen iki dienggo, mangga panjenengan bisa nulungi para panerjemah liyané mawa nambahaké dokumentasi ing pesen iki.''",
	'translate-edit-information'        => 'Informasi perkara pesen iki ($1)',
	'translate-edit-in-other-languages' => 'Pesen ing basa liya',
	'translate-edit-committed'          => 'Pertalan saiki ing perangkat lunak',
	'translate-edit-warnings'           => 'Pèngetan perkara pertalan sing ora pepak',
	'translate-magic-pagename'          => 'Pangambanan pertalan MediaWiki',
	'translate-magic-submit'            => 'Jupuk',
	'translate-magic-cm-export'         => 'Èkspor',
	'translate-magic-cm-current'        => 'Saiki',
	'translate-magic-cm-original'       => 'Asli',
	'translate-magic-cm-comment'        => 'Komentar:',
	'translate-magic-cm-save'           => 'Simpen',
	'translate-magic-cm-updatedusing'   => 'Dimutakiraké nganggo [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => 'Gagal disimpen',
	'translate-magic-words'             => 'Tembung-tembung magis',
	'translate-magic-skin'              => 'Jeneng kulit',
	'translate-magic-namespace'         => 'Jeneng bilik nama',
	'translationchanges-export'         => 'èkspor',
	'translationchanges-change'         => '$1: $2 déning $3',
	'translate-checks-parameters'       => 'Paramèter-paramèter ing ngisor iki ora dienggo: <strong>$1</strong>',
	'tog-translate-nonewsletter'        => 'Aja ngirimi aku jurnal warta e-mail (namung rélévan kanggo para panganggo sing wis konfirmasi alamat e-mailé)',
	'right-translate'                   => 'Nyunting nganggo antarmuka pertalan',
);

/** Georgian (ქართული)
 * @author Malafaya
 * @author Sopho
 */
$messages['ka'] = array(
	'translate-edit'          => 'რედაქტირება',
	'translate-talk'          => 'განხილვა',
	'translate-history'       => 'ისტორია',
	'translate-page-group'    => 'ჯგუფი',
	'translate-page-language' => 'ენა',
);

/** Kara-Kalpak (Qaraqalpaqsha)
 * @author Atabek
 */
$messages['kaa'] = array(
	'translate'                         => 'Awdarıw',
	'translate-edit'                    => "o'zgertiw",
	'translate-talk'                    => "sa'wbet",
	'translate-history'                 => 'tariyxı',
	'translate-task-view'               => 'Barlıq xabarlardı qaraw',
	'translate-task-untranslated'       => "Barlıq awdarılmag'an xabarlardı qaraw",
	'translate-task-optional'           => "Sha'rt emes xabarlardı qaraw",
	'translate-task-review'             => "O'zgerislerdi qarap shıg'ıw",
	'translate-task-reviewall'          => "Barlıq awdarılg'anlardı qarap shıg'ıw",
	'translate-task-export'             => "Awdarılg'anlardı eksport qılıw",
	'translate-task-export-to-file'     => "Awdarılg'anlardı faylg'a eksport qılıw",
	'translate-task-export-as-po'       => "Awdarılg'anlardı Gettext formatında eksport qılıw",
	'translate-page-no-such-language'   => 'Keltirilgen til jaramsız',
	'translate-page-no-such-task'       => 'Keltirilgen tapsırma jaramsız',
	'translate-page-no-such-group'      => 'Keltirilgen topar jaramsız',
	'translate-page-disabled'           => "Bul toparda usı tilge awdarıwlar toqtatılg'an. Sebep:

''$1''",
	'translate-page-settings-legend'    => 'Sazlawlar',
	'translate-page-task'               => 'Talabım:',
	'translate-page-group'              => 'Xabar toparı',
	'translate-page-language'           => 'Til',
	'translate-page-limit'              => 'Sheklew',
	'translate-page-limit-option'       => "ha'r bette {{PLURAL:$1|1|$1}} xabar",
	'translate-submit'                  => "Ko'rset",
	'translate-page-navigation-legend'  => 'Navigatsiya',
	'translate-page-showing'            => "Ko'rsetilgen xabarlar aralıg'ı: $1 - $2 (barlıg'ı $3).",
	'translate-page-showing-all'        => "{{PLURAL:$1|1|$1}} xabar ko'rsetilmekte",
	'translate-page-showing-none'       => "Ko'rsetiwge hesh qanday xabar joq.",
	'translate-next'                    => 'Keyingi bet',
	'translate-prev'                    => "Aldıng'ı bet",
	'translate-page-description-legend' => "Topar haqqında mag'lıwmat",
	'translate-optional'                => "(sha'rt emes)",
	'translate-ignored'                 => "(itibar berilmeytug'ın)",
	'translate-edit-definition'         => "Xabardın' anıqlaması",
	'translate-edit-contribute'         => "u'les qosıw",
	'translate-edit-no-information'     => "''Bul xabardın' hu'jjet mag'lıwmatı joq. Eger siz bul xabar qayerde yamasa qalay paydalang'anın bilsen'iz, basqa awdarıwshılıwg'a usı xabardın' hu'jjet mag'lıwmatın ko'rsetip ja'rdem beriwin'iz mu'mkin.''",
	'translate-edit-information'        => "Bul xabar haqqında mag'lıwmat ($1)",
	'translate-edit-in-other-languages' => 'Bul xabar basqa tillerde',
	'translate-edit-committed'          => "Bag'darlamadag'ı ha'zirgi awdarması",
	'translate-edit-warnings'           => "Tolıq awdarılmag'an xabarlar haqqında esletpeler",
	'translate-magic-pagename'          => "Ken'eytilgen MediaWiki awdarması",
	'translate-magic-submit'            => "Ko'rset",
	'translate-magic-cm-export'         => 'Eksport qılıw',
	'translate-magic-cm-to-be'          => 'Bolıwı kerek',
	'translate-magic-cm-current'        => "Ha'zirgisi",
	'translate-magic-cm-original'       => 'Original',
	'translate-magic-cm-comment'        => 'Kommentariy:',
	'translate-magic-cm-save'           => 'Saqla',
	'translate-magic-cm-updatedusing'   => "[[Special:Magic]] qollanıp saqlang'an",
	'translate-magic-cm-savefailed'     => "Saqlaw sa'tsiz tamamlandı",
	'translate-magic-special'           => 'Arnawlı bet laqabı',
	'translate-magic-words'             => "Sıyqırlı so'zler",
	'translate-magic-skin'              => 'Skin atları',
	'translate-magic-namespace'         => "İsimler ko'pligi atları",
	'translationchanges'                => "Awdarma o'zgerisleri",
	'translationchanges-export'         => 'eksport qılıw',
	'translationchanges-change'         => '$1: $2 ($3 boyınsha)',
	'translate-checks-parameters'       => "To'mendegi parametrler qollanılmag'an: <strong>$1</strong>",
	'translate-checks-balance'          => "Qawıslardın' sanı jup emes: <strong>$1</strong>",
	'translate-checks-links'            => "To'mendegi siltewler jaramsız: <strong>$1</strong>",
	'translate-checks-xhtml'            => "To'mendegi teglerdi durıslıları menen o'zgertin': <strong>$1</strong>",
	'translate-checks-plural'           => "Anıqlamada <nowiki>{{PLURAL:}}</nowiki> paydalanılg'an, biraq awdarmada bul joq.",
	'tog-translate-nonewsletter'        => "Mag'an e-mail boyınsha jan'alıqlardı jibermen' (tek e-mail adresin tastıyıqlag'an paydalanıwshılarg'a tiyisli)",
	'right-translate'                   => "Awdarma interfeysi ja'rdeminde o'zgertiw",
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬)
 * @author AlefZet
 * @author Siebrand
 */
$messages['kk-arab'] = array(
	'translate'                         => 'اۋدارۋ',
	'translate-edit'                    => 'وڭدەۋ',
	'translate-talk'                    => 'تالقىلاۋ',
	'translate-history'                 => 'تارىيحى',
	'translate-task-view'               => 'بارلىق حابارىن قاراۋ',
	'translate-task-untranslated'       => 'اۋدارىلماعان بارلىق حابارىن قاراۋ',
	'translate-task-optional'           => 'مىندەتتى ەمەس حابارلارىن قاراۋ',
	'translate-task-review'             => 'وزگەرىستەرىن قاراپ شىعۋ',
	'translate-task-reviewall'          => 'بارلىق اۋدارمالارىن قاراپ شىعۋ',
	'translate-task-export'             => 'اۋدارمالارىن سىرتقا بەرۋ',
	'translate-task-export-to-file'     => 'اۋدارمالارىن فايلمەن سىرتقا بەرۋ',
	'translate-task-export-as-po'       => 'اۋدارمالارىن Gettext پٸشٸمٸمەن سىرتقا بەرۋ',
	'translate-page-no-such-language'   => 'كەلتىرىلگەن ٴتىل بەلگىلەمەسى جارامسىز',
	'translate-page-no-such-task'       => 'ەنگىزىلگەن تاپسىرما جارامسىز.',
	'translate-page-no-such-group'      => 'ەنگىزىلگەن توب جارامسىز.',
	'translate-page-settings-legend'    => 'باپتاۋ',
	'translate-page-task'               => 'تالابىم:',
	'translate-page-group'              => 'حابار توبى',
	'translate-page-language'           => 'ٴتىلى',
	'translate-page-limit'              => 'شەكتەمى',
	'translate-page-limit-option'       => 'بەت سايىن  {{PLURAL:$1|1|$1}} حابار',
	'translate-submit'                  => 'كەلتىر!',
	'translate-page-navigation-legend'  => 'باعىتتاۋ',
	'translate-page-showing'            => 'كورسەتىلگەن حابار اۋقىمى: $1 — $2 (نە بارلىعى $3).',
	'translate-page-showing-all'        => 'كورسەتىلۋى: {{PLURAL:$1|1|$1}} حابار.',
	'translate-page-showing-none'       => 'كورسەتىلەتىن ەش حابار جوق.',
	'translate-next'                    => 'كەلەسى بەت',
	'translate-prev'                    => 'الدىڭعى بەت',
	'translate-page-description-legend' => 'بۇل توپ تۋرالى مالىمەت',
	'translate-optional'                => '(مىندەتتى ەمەس)',
	'translate-ignored'                 => '(ەلەمەيتىن)',
	'translate-edit-definition'         => 'حاباردىڭ انىقتالىمى',
	'translate-edit-contribute'         => 'ۇلەس بەر',
	'translate-edit-no-information'     => "''بۇل حابار قۇجاتتاماسىز. ەگەر وسى حاباردىڭ قايدا نەمەسە قالاي قولدانعانىن بىلسەڭىز, بۇل حابارعا قۇجاتتاما كەلتىرىپ, باسقا اۋدارۋشىلارعا كومەكتەسە الاسىز.''",
	'translate-edit-information'        => 'بۇل حابار تۋرالى مالىمەت ($1)',
	'translate-edit-in-other-languages' => 'حابار باسقا تىلدەردە',
	'translate-edit-committed'          => 'باعدارلاماداعى اعىمدىق اۋدارما',
	'translate-edit-warnings'           => 'تولىق اۋدارىلماعان حابارلار تۋرالى اڭعارتپالار',
	'translate-magic-pagename'          => 'كەڭەيتىلگەن MediaWiki اۋدارۋى',
	'translate-magic-help'              => 'ارنايى بەت بۇركەمەلەرىن, سىيقىرلى سوزدەرىن, بەزەندىرۋ مانەر اتاۋلارىن جانە ەسىم ايا اتاۋلارىن اۋدارا الاسىز.

سىيقىرلى سوزدەردە اعىلشىنشا نۇسقاسىن كىرگىزۋىڭىز ٴجون, ايتپەسە قىزمەتى توقتالادى. تاعى دا ٴبىرىنشى بابىن (0 نە 1) ٴاردايىم قالدىرىڭىز.

ارنايى بەت بۇركەمەلەرىندە جانە سىيقىرلى سوزدەرىندە بىرنەشە اۋدارما بولۋى مۇمكىن. اۋدارمالار ۇتىرمەن (,) بولىكتەنەدى. بەزەندىرۋ مانەر جانە ەسىم ايا اتاۋلارىندا تەك ٴبىر اۋدارما بولۋى ٴتىيىس.

ەسىم ايا اۋدارمالارىندا <tt>$1_talk</tt> دەگەن ارنايى كەلتىرىلەدى. <tt>$1</tt> دەگەن اينالمالى وزدىكتىك توراپ اتاۋىمەن الماستىرىلادى (مىسالى, <tt>{{SITENAME}} تالقىلاۋى</tt>). ەگەر ٴسىزدىڭ تىلىڭىزدە توراپ اتاۋىن وزگەرتپەي دۇرىس سويلەم قۇرىلماسا, دامىتۋشىلارعا حابارلاسىڭىز.',
	'translate-magic-submit'            => 'كەلتىر',
	'translate-magic-cm-export'         => 'سىرتقا بەر',
	'translate-magic-cm-to-be'          => 'بولۋعا ٴتىيىستىسى',
	'translate-magic-cm-current'        => 'اعىمداعىسى',
	'translate-magic-cm-original'       => 'تۇپنۇسقاسى',
	'translate-magic-cm-save'           => 'ساقتا!',
	'translate-magic-cm-updatedusing'   => 'Special:Magic دەگەندى قولدانىپ ساقتالعان',
	'translate-magic-cm-savefailed'     => 'ساقتاۋ ٴساتسىز بولدى',
	'translate-magic-special'           => 'ارنايى بەت بۇركەمەلەرى',
	'translate-magic-words'             => 'سىيقىر سوزدەر',
	'translate-magic-skin'              => 'بەزەندىرۋ مانەرى اتاۋلارى',
	'translate-magic-namespace'         => 'ەسىم ايا اتاۋلارى',
	'translationchanges'                => 'اۋدارما وزگەرىستەرى',
	'translationchanges-export'         => 'سىرتقا بەرۋ',
	'translationchanges-change'         => '$1: $2 ($3 ٸستەگەن)',
	'translate-checks-parameters'       => 'كەلەسى باپتالىمدار پايدالانىلماعان: <strong>$1</strong>',
	'translate-checks-balance'          => 'مىندا جاقشالاردىڭ بارلىق سانى جۇپ ەمەس: <strong>$1</strong>',
	'translate-checks-links'            => 'كەلەسى سىلتەمەلەر جارامسىز: <strong>$1</strong>',
	'translate-checks-xhtml'            => 'كەلەسى بەلگىلەمەلەردى دۇرىستارىمەن الماستىرىڭىز: <strong>$1</strong>',
	'translate-checks-plural'           => 'انىقتالىمدا <nowiki>{{PLURAL:}} پايدالانىلعان, بىراق اۋدارمادا بۇل جوق.',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic))
 * @author AlefZet
 * @author Siebrand
 */
$messages['kk-cyrl'] = array(
	'translate'                              => 'Аудару',
	'translate-desc'                         => 'MediaWiki дегенді және бұнан тыстарды аудару үшін арналған [[Special:Translate|арнайы бет]]',
	'translate-edit'                         => 'өңдеу',
	'translate-talk'                         => 'талқылау',
	'translate-history'                      => 'тарихы',
	'translate-task-view'                    => 'барлық хабарын қарау',
	'translate-task-untranslated'            => 'аударылмаған барлық хабарын қарау',
	'translate-task-optional'                => 'міндетті емес хабарларын қарау',
	'translate-task-review'                  => 'өзгерістерін шолып шығу',
	'translate-task-reviewall'               => 'барлық аудармаларын қарап шығу',
	'translate-task-export'                  => 'аудармаларын сыртқа беру',
	'translate-task-export-to-file'          => 'аудармаларын файлмен сыртқа беру',
	'translate-task-export-as-po'            => 'аудармаларын Gettext пішімімен сыртқа беру',
	'translate-page-no-such-language'        => 'Келтірілген тіл жарамсыз',
	'translate-page-no-such-task'            => 'Келтірілген тапсырма жарамсыз.',
	'translate-page-no-such-group'           => 'Келтірілген топ жарамсыз.',
	'translate-page-disabled'                => "Осы топтағы бұл тілге аударуы өшірілген. Себебі:

''$1''",
	'translate-page-settings-legend'         => 'Бапталымдар',
	'translate-page-task'                    => 'Талабым:',
	'translate-page-group'                   => 'Хабар тобы',
	'translate-page-language'                => 'Тілі',
	'translate-page-limit'                   => 'Шектемі',
	'translate-page-limit-option'            => 'бет сайын $1 хабар',
	'translate-submit'                       => 'Келтір!',
	'translate-page-navigation-legend'       => 'Бағыттау',
	'translate-page-showing'                 => 'Көрсетілген хабар ауқымы: $1 — $2 (не барлығы $3).',
	'translate-page-showing-all'             => 'Көрсетілуі: $1 хабар.',
	'translate-page-showing-none'            => 'Көрсетілетін еш хабар жоқ.',
	'translate-next'                         => 'Келесі бет',
	'translate-prev'                         => 'Алдыңғы бет',
	'translate-page-description-legend'      => 'Бұл топ туралы мәлімет',
	'translate-optional'                     => '(міндетті емес)',
	'translate-ignored'                      => '(елемейтін)',
	'translate-edit-definition'              => 'Хабар анықтауы',
	'translate-edit-contribute'              => 'үлес бер',
	'translate-edit-no-information'          => "''Бұл хабар құжаттамасыз.
Егер бұл хабардың қайда немесе қалай қолданғанын білсеңіз, бұл хабарға құжаттама келтіріп, басқа аударушыларға көмектесе аласыз.''",
	'translate-edit-information'             => 'Бұл хабар туралы мәлімет ($1)',
	'translate-edit-in-other-languages'      => 'Хабар басқа тілдерде',
	'translate-edit-committed'               => 'Бағдарлама жасақтамадағы ағымдақ аударма',
	'translate-edit-warnings'                => 'Толық аударылмаған хабарлар туралы құлақтандырулар',
	'translate-magic-pagename'               => 'Кеңейтілген MediaWiki аударуы',
	'translate-magic-help'                   => 'Арнайы бет бүркеме аттарын, сиқырлы сөздерді, мәнер атауларын және есім ая атауларын аудара аласыз.

Сиқырлы сөздерде ағылшынша нұсқасын кіргізуіңіз жөн, әйтпесе қызметі тоқталады.
Тағы да бірінші бабын (0 не 1) әрдайым қалдырыңыз.

Арнайы бет бүркеме аттарында және сиқырлы сөздерде бірнеше аударма болуы мүмкін.
Аудармалар үтірмен (,) бөлінеді.
Мәнер және есім ая атауларында тек бір аударма болуы мүмкін.

Есім ая аудармаларында <tt>$1_talk</tt> деген арнайы боп табылады. <tt>$1</tt> айналмалысы торап атауымен алмастырылады (мысалы, <tt>{{SITENAME}} талқылауы</tt>).
Егер сіздің тіліңізде торап атауын өзгертпей дұрыс айтылым құрылмаса, дамытушыға хабарласыңыз.

Өзгерістерді сақтау үшін аудармашылар тобына кіруіңіз жөн.
Сақтау батырмасын нұқығанша дейін өзгерістер сақталмайды.',
	'translate-magic-submit'                 => 'Келтір',
	'translate-magic-cm-export'              => 'Сыртқа бер',
	'translate-magic-cm-to-be'               => 'Болуға тиістісі',
	'translate-magic-cm-current'             => 'Ағымдағысы',
	'translate-magic-cm-original'            => 'Түпнұсқасы',
	'translate-magic-cm-comment'             => 'Мәндеме:',
	'translate-magic-cm-save'                => 'Сақта!',
	'translate-magic-cm-updatedusing'        => 'Special:Magic дегенді қолданып сақталған',
	'translate-magic-cm-savefailed'          => 'Сақтау сәтсіз болды',
	'translate-magic-special'                => 'Арнайы бет бүркеме аттары',
	'translate-magic-words'                  => 'Сиқыр сөздер',
	'translate-magic-skin'                   => 'Мәнер атаулары',
	'translate-magic-namespace'              => 'Есім ая атаулары',
	'translationchanges'                     => 'Аударма өзгерістері',
	'translationchanges-export'              => 'сыртқа беру',
	'translationchanges-change'              => '$1: $2 ($3 істеген)',
	'translate-checks-parameters'            => 'Келесі бапталымдар пайдаланылмаған: <strong>$1</strong>',
	'translate-checks-balance'               => 'Мында жақшалардың бүкіл саны жұп емес: <strong>$1</strong>',
	'translate-checks-links'                 => 'Келесі сілтемелер жарамсыз: <strong>$1</strong>',
	'translate-checks-xhtml'                 => 'Келесі белгілемелерді дұрыстарымен алмастырыңыз: <strong>$1</strong>',
	'translate-checks-plural'                => 'Анықталымда <nowiki>{{PLURAL:}}</nowiki> пайдаланылған, бірақ аудармада бұл жоқ.',
	'tog-translate-nonewsletter'             => 'Жаңалық хаттарды маған жіберме (тек құпталған е-пошта жайы бар қатысушыларға тиісті)',
	'right-translate'                        => 'Аудару тілдесуін қолданып өңдеу',
	'translate-rc-translation-filter'        => 'Аудармаларды сүзгілеу:',
	'translate-rc-translation-filter-no'     => 'Ештеңе істемеу',
	'translate-rc-translation-filter-only'   => 'Тек аудармаларды көрсету',
	'translate-rc-translation-filter-filter' => 'Аудармаларды сүзгілеп тастау',
	'translate-rc-translation-filter-site'   => 'Тек торап хабарларының өзгерістері',
);

/** Kazakh (Latin) (Қазақша (Latin))
 * @author AlefZet
 * @author Siebrand
 * @author Atabek
 */
$messages['kk-latn'] = array(
	'translate'                         => 'Awdarıw',
	'translate-edit'                    => 'öñdew',
	'translate-talk'                    => 'talqılaw',
	'translate-history'                 => 'tarïxı',
	'translate-task-view'               => 'barlıq xabarın qaraw',
	'translate-task-untranslated'       => 'awdarılmağan barlıq xabarın qaraw',
	'translate-task-optional'           => 'mindetti emes xabarların qaraw',
	'translate-task-review'             => 'özgeristerin qarap şığw',
	'translate-task-reviewall'          => 'barlıq awdarmaların qarap şığw',
	'translate-task-export'             => 'awdarmaların sırtqa berw',
	'translate-task-export-to-file'     => 'awdarmaların faýlmen sırtqa berw',
	'translate-task-export-as-po'       => 'awdarmaların Gettext pişimimen sırtqa berw',
	'translate-page-no-such-language'   => 'Keltirilgen til belgilemesi jaramsız',
	'translate-page-no-such-task'       => 'Engizilgen tapsırma jaramsız.',
	'translate-page-no-such-group'      => 'Engizilgen tob jaramsız.',
	'translate-page-settings-legend'    => 'Baptaw',
	'translate-page-task'               => 'Talabım:',
	'translate-page-group'              => 'Xabar tobı',
	'translate-page-language'           => 'Tili',
	'translate-page-limit'              => 'Şektemi',
	'translate-page-limit-option'       => 'bet saýın  {{PLURAL:$1|1|$1}} xabar',
	'translate-submit'                  => 'Keltir!',
	'translate-page-navigation-legend'  => 'Bağıttaw',
	'translate-page-showing'            => 'Körsetilgen xabar awqımı: $1 - $2 (ne barlığı $3).',
	'translate-page-showing-all'        => 'Körsetilwi: {{PLURAL:$1|1|$1}} xabar.',
	'translate-page-showing-none'       => 'Körsetiletin eş xabar joq.',
	'translate-next'                    => 'Kelesi bet',
	'translate-prev'                    => 'Aldıñğı bet',
	'translate-page-description-legend' => 'Bul top twralı mälimet',
	'translate-optional'                => '(mindetti emes)',
	'translate-ignored'                 => '(elemeýtin)',
	'translate-edit-definition'         => 'Xabardıñ anıqtalımı',
	'translate-edit-contribute'         => 'üles ber',
	'translate-edit-no-information'     => "''Bul xabar qujattamasız. Eger osı xabardıñ qaýda nemese qalaý qoldanğanın bilseñiz, bul xabarğa qujattama keltirip, basqa awdarwşılarğa kömektese alasız.''",
	'translate-edit-information'        => 'Bul xabar twralı mälimet ($1)',
	'translate-edit-in-other-languages' => 'Xabar basqa tilderde',
	'translate-edit-committed'          => 'Bağdarlamadağı ağımdıq awdarma',
	'translate-edit-warnings'           => 'Tolıq awdarılmağan xabarlar twralı añğartpalar',
	'translate-magic-pagename'          => 'Keñeýtilgen MediaWiki awdarwı',
	'translate-magic-help'              => 'Arnaýı bet bürkemelerin, sïqırlı sözderin, bezendirw mäner atawların jäne esim aya atawların awdara alasız.

Sïqırlı sözderde ağılşınşa nusqasın kirgizwiñiz jön, äýtpese qızmeti toqtaladı. Tağı da birinşi babın (0 ne 1) ärdaýım qaldırıñız.

Arnaýı bet bürkemelerinde jäne sïqırlı sözderinde birneşe awdarma bolwı mümkin. Awdarmalar ütirmen (,) böliktenedi. Bezendirw mäner jäne esim aya atawlarında tek bir awdarma bolwı tïis.

Esim aya awdarmalarında <tt>$1_talk</tt> degen arnaýı keltiriledi. <tt>$1</tt> degen aýnalmalı özdiktik torap atawımen almastırıladı (mısalı, <tt>{{SITENAME}} talqılawı</tt>). Eger sizdiñ tiliñizde torap atawın özgertpeý durıs söýlem qurılmasa, damıtwşılarğa xabarlasıñız.',
	'translate-magic-submit'            => 'Keltir',
	'translate-magic-cm-export'         => 'Sırtqa ber',
	'translate-magic-cm-to-be'          => 'Bolwğa tïistisi',
	'translate-magic-cm-current'        => 'Ağımdağısı',
	'translate-magic-cm-original'       => 'Tüpnusqası',
	'translate-magic-cm-save'           => 'Saqta!',
	'translate-magic-cm-updatedusing'   => 'Special:Magic degendi qoldanıp saqtalğan',
	'translate-magic-cm-savefailed'     => 'Saqtaw sätsiz boldı',
	'translate-magic-special'           => 'Arnaýı bet bürkemeleri',
	'translate-magic-words'             => 'Sïqır sözder',
	'translate-magic-skin'              => 'Bezendirw mäneri atawları',
	'translate-magic-namespace'         => 'Esim aya atawları',
	'translationchanges'                => 'Awdarma özgeristeri',
	'translationchanges-export'         => 'sırtqa berw',
	'translationchanges-change'         => '$1: $2 ($3 istegen)',
	'translate-checks-parameters'       => 'Kelesi baptalımdar paýdalanılmağan: <strong>$1</strong>',
	'translate-checks-balance'          => 'Mında jaqşalardıñ barlıq sanı jup emes:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'            => 'Kelesi siltemeler jaramsız:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'            => 'Kelesi belgilemelerdi durıstarımen almastırıñız:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'           => 'Anıqtalımda <nowiki>{{PLURAL:}}</nowiki> paýdalanılğan, biraq awdarmada bul joq.',
);

/** Kazakh (Kazakhstan) (‪Қазақша (Қазақстан)‬)
 * @author AlefZet
 * @author Siebrand
 */
$messages['kk-kz'] = array(
	'translate'                       => 'Аудару',
	'translate-edit'                  => 'өңдеу',
	'translate-talk'                  => 'талқылау',
	'translate-history'               => 'тарихы',
	'translate-task-view'             => 'барлық хабарын қарау',
	'translate-task-untranslated'     => 'аударылмаған барлық хабарын қарау',
	'translate-task-optional'         => 'міндетті емес хабарларын қарау',
	'translate-task-review'           => 'өзгерістерін қарап шығу',
	'translate-task-reviewall'        => 'барлық аудармаларын қарап шығу',
	'translate-task-export'           => 'аудармаларын сыртқа беру',
	'translate-task-export-to-file'   => 'аудармаларын файлмен сыртқа беру',
	'translate-page-no-such-language' => 'Келтірілген тіл белгілемесі жарамсыз',
	'translate-submit'                => 'Келтір!',
	'translate-next'                  => 'Келесі бет',
	'translate-prev'                  => 'Алдыңғы бет',
	'translate-optional'              => '(міндетті емес)',
	'translate-ignored'               => '(елемейтін)',
	'translate-magic-pagename'        => 'Кеңейтілген MediaWiki аударуы',
	'translate-magic-help'            => 'Арнайы бет бүркемелерін, сиқырлы сөздерін, безендіру мәнер атауларын және есім ая атауларын аудара аласыз.

Сиқырлы сөздерде ағылшынша нұсқасын кіргізуіңіз жөн, әйтпесе қызметі тоқталады. Тағы да бірінші бабын (0 не 1) әрдайым қалдырыңыз.

Арнайы бет бүркемелерінде және сиқырлы сөздерінде бірнеше аударма болуы мүмкін. Аудармалар үтірмен (,) бөліктенеді. Безендіру мәнер және есім ая атауларында тек бір аударма болуы тиіс.

Есім ая аудармаларында <tt>$1_talk</tt> деген арнайы келтіріледі. <tt>$1</tt> деген айналмалы өздіктік торап атауымен алмастырылады (мысалы, <tt>{{SITENAME}} талқылауы</tt>). Егер сіздің тіліңізде торап атауын өзгертпей дұрыс сөйлем құрылмаса, дамытушыларға хабарласыңыз.',
	'translate-magic-submit'          => 'Келтір',
	'translate-magic-cm-export'       => 'Сыртқа бер',
	'translate-magic-cm-to-be'        => 'Болуға тиісті',
	'translate-magic-cm-current'      => 'Ағымдағы',
	'translate-magic-cm-original'     => 'Түпнұсқасы',
	'translate-magic-cm-save'         => 'Сақта!',
	'translate-magic-cm-updatedusing' => '[[Special:Magic]] дегенді қолданып сақталған',
	'translate-magic-cm-savefailed'   => 'Сақтау сәтсіз болды',
	'translate-magic-special'         => 'Арнайы бет бүркемелері',
	'translate-magic-words'           => 'Сиқыр сөздер',
	'translate-magic-skin'            => 'Безендіру мәнері атаулары',
	'translate-magic-namespace'       => 'Есім ая атаулары',
	'translationchanges'              => 'Аударма өзгерістері',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author Chhorran
 * @author Lovekhmer
 * @author Siebrand
 */
$messages['km'] = array(
	'translate'                            => 'បកប្រែ',
	'translate-desc'                       => '[[Special:Translate|ទំព័រ​ពិសេស]] សំរាប់ប្រែសំរួល​មេឌាវិគី​ និង របស់​ផ្សេងទៀត',
	'translate-edit'                       => 'កែប្រែ',
	'translate-talk'                       => 'ពិភាក្សា',
	'translate-history'                    => 'ប្រវត្តិ',
	'translate-task-view'                  => 'មើល​គ្រប់សារពី',
	'translate-task-untranslated'          => 'មើល​គ្រប់​សារដែល​មិនទាន់ប្រែសំរួលពី',
	'translate-task-optional'              => 'មើល​សារដែលបានជ្រើសរើសពី',
	'translate-task-problematic'           => 'មើលសារដែលមានបញ្ហា',
	'translate-task-review'                => 'មើល​ឡើងវិញ​នូវបំលាស់ប្តូរ​នានា​ចំពោះ',
	'translate-task-reviewall'             => 'មើល​ឡើងវិញ​បទប្រែសំរួល​ទាំងអស់​ក្នុង',
	'translate-task-export'                => 'នាំចេញ​បទប្រែសំរួលពី',
	'translate-task-export-to-file'        => 'នាំចេញបទប្រែសំរួលជាឯកសារពី',
	'translate-task-export-as-po'          => 'នាំចេញ​បទប្រែសំរួល​ជា​ទំរង់ អក្សរសុទ្ធ',
	'translate-page-no-such-language'      => 'ភាសាដែលបានសំដៅ គ្មានសុពលភាព ។',
	'translate-page-no-such-task'          => 'កិច្ចការដែលបានសំដៅ គ្មានសុពលភាព ។',
	'translate-page-no-such-group'         => 'ក្រុមដែលបានសំដៅ គ្មានសុពលភាព ។',
	'translate-page-disabled'              => "ការបកប្រែសំរាប់ភាសានេះក្នុងក្រុមនេះមិនត្រូវបានអនុញ្ញាតទេ។ មូលហេតុ:

''$1''",
	'translate-page-settings-legend'       => 'ការកំនត់យក',
	'translate-page-task'                  => 'ខ្ញុំចង់',
	'translate-page-group'                 => 'ក្រុម',
	'translate-page-language'              => 'ភាសា',
	'translate-page-limit'                 => 'កំរិត',
	'translate-page-limit-option'          => '$1 {{PLURAL:$1|សារ}} ក្នុងមួយទំព័រ',
	'translate-submit'                     => 'នាំមក​បង្ហាញ',
	'translate-page-navigation-legend'     => 'ទិសដៅ',
	'translate-page-showing'               => 'កំពុងបង្ហាញ​សារ​តាមលំដាប់ ពី $1 ដល់ $2 នៃ $3 ។',
	'translate-page-showing-all'           => 'កំពុងបង្ហាញ $1 {{PLURAL:$1|សារ}}។',
	'translate-page-showing-none'          => 'មិនមានសារ​ត្រូវបង្ហាញទេ។',
	'translate-next'                       => 'ទំព័របន្ទាប់',
	'translate-prev'                       => 'ទំព័រមុន',
	'translate-page-description-legend'    => 'ពត៌មាន​អំពី​ក្រុម',
	'translate-page-edit'                  => 'កែប្រែ',
	'translate-optional'                   => '(ជំរើស)',
	'translate-ignored'                    => '(បានបោះបង់)',
	'translate-edit-definition'            => 'និយមន័យ​របស់​សារ',
	'translate-edit-contribute'            => 'រួមចំនែក',
	'translate-edit-no-information'        => "''សារនេះមិនមានពត៌មានបន្ថែមទេ។ ប្រសិនបើអ្នកដឹងពីទីកន្លែងនិងរបៀបប្រើប្រាស់សារនេះ អ្នកអាចជួយអ្នកបកប្រែផ្សេងទៀតតាមរយៈការដាក់បន្ថែមពត៌មានទាំងនោះមកអោយសារនេះ។",
	'translate-edit-information'           => 'ពត៌មាន​អំពី​សារនេះ ($1)',
	'translate-edit-in-other-languages'    => 'សារ​ជាភាសា​ដទៃទៀត',
	'translate-edit-committed'             => 'បទប្រែសំរួល​បច្ចុប្បន្ន​ក្នុងផ្នែកទន់',
	'translate-edit-warnings'              => 'ការព្រមាន​អំពី​បទប្រែសំរួលមិនពេញលេញ',
	'translate-edit-goto-no-prev'          => 'គ្មានសារមុនទេ',
	'translate-edit-goto-no-next'          => 'គ្មានសារបន្ទាប់ទេ',
	'translate-edit-goto-prev'             => 'កែប្រែសារមុន',
	'translate-edit-goto-next'             => 'កែប្រែសារបន្ទាប់',
	'translate-edit-goto-list'             => 'ត្រលប់ទៅកាន់បញ្ជីវិញ',
	'translate-magic-pagename'             => 'ការបកប្រែ​មេឌាវិគី​បន្ថែម',
	'translate-magic-help'                 => "អ្នកអាចប្រែសំរួលឈ្មោះផ្សេងៗទៀតនៃទំព័រពិសេស ពាក្យទិព្វ ឈ្មោះសំបក និងឈ្មោះនៃលំហឈ្មោះ។


ក្នុងពាក្យទិព្វ អ្នកចាំបាច់ត្រូវដាក់រួមទាំងបទប្រែសំរួលជាភាសាអង់គ្លេស បើមិនដូច្នោះវាលែងដំណើរការ។ 
ដាក់ផងដែរនូវលេខរៀងដំបូង(0 ឬ 1)តាមដែលវាមាន។


ឈ្មោះផ្សេងទៀតនៃទំព័រពិសេស និងពាក្យទិព្វ អាចមានច្រើនបទប្រែសំរួល ។ បទប្រែសំរួលត្រូវបានខណ្ឌដោយសញ្ញាក្បៀស(,)។ ឈ្មោះសំបក និងលំហឈ្មោះអាចមានត្រឹមតែ មួយបទប្រែសំរួលប៉ុណ្ណោះ ។


ក្នុងការបកប្រែលំហឈ្មោះ <tt>ការពិភាក្សាអំពី$1</tt> ជាករណីពិសេស។ <tt>$1</tt> ត្រូវបានជំនួសដោយឈ្មោះវិបសាយ(ឧទាហរណ៍៖ <tt>ការពិភាក្សាអំពី{{SITENAME}}</tt>)។ 

ប្រសិនបើភាសារបស់អ្នកមិនបានបង្ហាញត្រឹមត្រូវដោយមិនប្តូរឈ្មោះវិបសាយទេ សូមទាក់ទងអ្នកអភិវឌ្ឍ(អ្នករចនាវិបសាយ)។


អ្នកចាំបាច់ត្រូវតែស្ថិតក្នុងក្រុមអ្នកប្រែសំរួល ទើបអាចរក្សាទុកបំលាស់ប្តូរបាន។ បំលាស់ប្តូរនឹងមិនត្រូវបានរក្សាទុកទេ លើកលែងតែអ្នកបានចុចប្រអប់ 'រក្សាទំព័រទុក' ខាងក្រោម ។",
	'translate-magic-module'               => 'ម៉ូឌុល:',
	'translate-magic-submit'               => 'នាំមក​បង្ហាញ',
	'translate-magic-cm-export'            => 'នាំចេញ',
	'translate-magic-cm-to-be'             => 'ទៅជា',
	'translate-magic-cm-current'           => 'បច្ចុប្បន្ន',
	'translate-magic-cm-original'          => 'ដើម',
	'translate-magic-cm-comment'           => 'យោបល់៖',
	'translate-magic-cm-save'              => 'រក្សាទុក',
	'translate-magic-cm-updatedusing'      => 'បានបន្ទាន់សម័យ​ដោយប្រើប្រាស់ [[Special:Magic]]',
	'translate-magic-cm-savefailed'        => 'រក្សាទុកមិនបានសំរេច',
	'translate-magic-special'              => 'ឈ្មោះផ្សេងទៀតនៃទំព័រពិសេស',
	'translate-magic-words'                => 'ពាក្យទិព្វ',
	'translate-magic-skin'                 => 'ឈ្មោះសំបក',
	'translate-magic-namespace'            => 'ឈ្មោះនៃលំហឈ្មោះ',
	'translationchanges'                   => 'បំលាស់ប្តូរនៃការបកប្រែ',
	'translationchanges-export'            => 'នាំចេញ',
	'translationchanges-change'            => '$1:$2 ដោយ $3',
	'translate-checks-parameters'          => '{{PLURAL:$2|ប៉ារ៉ាម៉ែត្រ|ប៉ារ៉ាម៉ែត្រ}}ខាងក្រោមនេះមិនត្រូវបានគេប្រើទេ៖ 

<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'  => 'ប៉ារ៉ាម៉ែត្រចំនួន$2ខាងក្រោមនេះមិនត្រូវបានស្គាល់ទេ៖
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'             => 'មាន{{PLURAL:$2|វង់ក្រចក|វង់ក្រចក}}​ដែលមិន​មាន​គូ៖ 

<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'               => '{{PLURAL:$2|តំនភ្ជាប់|តំនភ្ជាប់}}ខាងក្រោមនេះ​មានបញ្ហា៖ <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'               => 'សូម​ជំនួស​ប្លាកទាំងនេះ​ដោយ​ប្លាកដែលត្រឹមត្រូវ ៖ <strong>$1</strong>',
	'translate-checks-plural'              => 'និយមន័យ​ប្រើប្រាស់ <nowiki>{{PLURAL:}}</nowiki> ប៉ុន្តែ​បទប្រែសំរួល​មិនមាន ។',
	'translate-rc-translation-filter-only' => 'បង្ហាញតែការបកប្រែប៉ុណ្ណោះ',
	'translate-stats-edits'                => 'ចំនួនកំនែប្រែក្នុងមួយថ្ងៃ',
);

/** Korean (한국어)
 * @author ToePeu
 */
$messages['ko'] = array(
	'translate-edit'    => '편집',
	'translate-talk'    => '토론',
	'translate-history' => '역사',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'translate-edit'    => 'iislan',
	'translate-talk'    => 'wakal',
	'translate-history' => 'Kasaysayan',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 * @author Siebrand
 */
$messages['ksh'] = array(
	'translate'                              => 'Övversäze',
	'translate-desc'                         => '[[Special:Translate|Söndersigk]] för et Översäze fon MediaWiki sing Meldonge, un mieh',
	'translate-edit'                         => 'Änndere',
	'translate-talk'                         => 'Klaaf',
	'translate-history'                      => 'Versione',
	'translate-task-view'                    => 'Zeijsh all de Nohreschte fon',
	'translate-task-untranslated'            => 'Zeijsh all de nit övversäzte Nohreschte fon',
	'translate-task-optional'                => "Zeijsh all de 'nit esu nüüdijje' Nohreschte fon",
	'translate-task-problematic'             => 'Zeijsh de probleemattesche Nohreschte fon',
	'translate-task-review'                  => 'Donn de Ännderonge prööfe fon',
	'translate-task-reviewall'               => 'Donn de Övversäzzonge prööfe fon',
	'translate-task-export'                  => 'Donn de Övversäzzonge Äxpochteere fon',
	'translate-task-export-to-file'          => 'Donn de Övversäzzonge en_en Datteij Äxpochteere, fon',
	'translate-task-export-as-po'            => 'Donn de Övversäzzonge en et Jettäx Fommaat Äxpochteere, fon',
	'translate-task-export-to-xliff'         => 'De Översetzunge em Xliff Fomaat äxpochteere, fon',
	'translate-page-no-such-language'        => 'De aanjejoove Shprooch känne me nit.',
	'translate-page-no-such-task'            => 'De aanjejoove Opjav känne me nit.',
	'translate-page-no-such-group'           => 'De aanjejoove Jrop känne me nit.',
	'translate-page-disabled'                => "Övversezonge sen affjeschalldt för di Jropp un Shprooch, weil:

''$1''",
	'translate-page-settings-legend'         => 'Ennshtellonge',
	'translate-page-task'                    => 'Opjaav',
	'translate-page-group'                   => 'Jrupp',
	'translate-page-language'                => 'Shprooch',
	'translate-page-limit'                   => 'Ömfang',
	'translate-page-limit-option'            => '{{PLURAL:$1|Eijn Noherscht|$1 Nohreschte|Nix aan Nohreschte}} pro Sigk',
	'translate-submit'                       => 'Loß Jonn!',
	'translate-page-navigation-legend'       => 'Aanzahl',
	'translate-page-showing'                 => 'De Nohreshte fon Nommer $1 aff, beß $2, fon ennßjesammp $3.',
	'translate-page-showing-all'             => '{{PLURAL:$1|Eijn_Nohresch|$1 Nohreschte|Keijn_esu_e_Nohreschte}}.',
	'translate-page-showing-none'            => 'Nix för Aan_ze_zeije.',
	'translate-next'                         => 'Näx Sigk',
	'translate-prev'                         => 'Förrije Sigk',
	'translate-page-description-legend'      => 'Enfommazjohne övver di Jrop',
	'translate-page-edit'                    => 'Änndere',
	'translate-optional'                     => '(nit esu nüüdesch)',
	'translate-ignored'                      => '(övverjange)',
	'translate-edit-definition'              => 'De Ojinaal Nohresch',
	'translate-edit-contribute'              => 'beijdraare',
	'translate-edit-no-information'          => "''Mer han kein Beschrievong oddo Dokementazjohn för dat Täxshtöck. Wann De weijß, wann un woh dit Shtöck jenou jebruch weed, dann kanns De de Anndere hellefe, un en Äklierong för_et ennjävve.''",
	'translate-edit-information'             => 'Ennfommazjohne övver hee di Nohresch  ($1)',
	'translate-edit-in-other-languages'      => 'Di Noresch in annder Shprooche',
	'translate-edit-committed'               => 'Es aktowäll övversaz met',
	'translate-edit-warnings'                => 'Warnonge wääje unkomplätte Övversäzonge',
	'translate-edit-goto-no-prev'            => 'Keine Tëx doför',
	'translate-edit-goto-no-next'            => 'Keine Tëx donoh',
	'translate-edit-goto-prev'               => 'Dä Tëx doför zëije',
	'translate-edit-goto-next'               => 'Dä Tëx donoh zëije',
	'translate-edit-goto-list'               => 'Op de Lėß zoröckjonn',
	'translate-magic-pagename'               => 'MediaWiki sing Extras övversäze',
	'translate-magic-help'                   => 'Hee kanns_De Zweijtname fö Söndersigge, Zauberwööter, Name för Ovverfläshe, un de Appachtemangname översäze.

Beij de Zauberwööter darrfß_De dat Ojjinaal (op änglesch) nit aanpake,
un och di Zahl am Aanfang (0 odder 1) darfß_De nit änndere, sönß sonn se nit mieh.

Söndersigge ier Zweijtname, un de Zauberwööter könne mieh wi eijn Övversäzong han.
Dozwesche shteijt jeeweijls_e "," (Komma).
Ovverfläshename un de Name fö_de Appachtemangs könne nur eijn Övversätzong han.

Beij de Övversäzonge för de Appachtemangs ier Name hät „<tt>$1 talk</tt>“ ene shpezjälle Senn.
Dat „<tt>$1</tt>“ shteijt doh als enne Plazhallder för dä Projäkname (zem Beijshpöll dat „<tt>{{SITENAME}}</tt>“ en: „<tt>Övver {{SITENAME}} Klaafe</tt>“).
Wann Ding Shprooch ed nit heerjitt, dat_De ene grammatesch reschtejje Forrem henkreßß, ohne an dämm Projetname ändere zo mößße, dann donn ene Äntwecklor do drop aansäzze.

Do moß en de Jrop „Övversäzer“ sen, för hee Änderonge maache ze könne.
Änderongen weede ehts bem Klicke op dä Knopp förr_et Seschere faßjehallde.',
	'translate-magic-module'                 => 'Dat Modul:',
	'translate-magic-submit'                 => 'Loß jonn!',
	'translate-magic-cm-export'              => 'Äxpocht aanfange',
	'translate-magic-cm-to-be'               => 'Soll wääde',
	'translate-magic-cm-current'             => 'Eß jäz',
	'translate-magic-cm-original'            => 'Orrijinaal',
	'translate-magic-cm-comment'             => 'Koot zesamme jefaß, Quell',
	'translate-magic-cm-save'                => 'Seschere',
	'translate-magic-cm-updatedusing'        => 'Övver [[Special:Magic]] jeänndert.',
	'translate-magic-cm-savefailed'          => 'Et Seschere eß donäve jejange',
	'translate-magic-special'                => 'Zweijtname för Söndersigge',
	'translate-magic-words'                  => 'Zauberwööter',
	'translate-magic-skin'                   => 'Name för Ovverfläshe',
	'translate-magic-namespace'              => 'Appachtemang_Name',
	'translationchanges'                     => 'Neu Övversäzonge',
	'translationchanges-export'              => 'Äxpochteere',
	'translationchanges-change'              => '$1: $2 fum $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|Dä Parrammeeter hee eß|Di Parrammeetere hee sen|dat Jedrißße hee iß}} nit jebruch woode: <strong>$1</strong>',
	'translate-checks-parameters-unknown'    => 'Hee {{PLURAL:$2|dä Parrammeeter|di Parrammeetere|dat Jedrißße}} kënne mer nit:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Do {{PLURAL:$2|jëijd_en Klammer nit op odder|jonn ongerscheedlish fill Klammere op un|eß Dreß}} zoh: <strong>$1</strong>',
	'translate-checks-links'                 => 'Hee {{PLURAL:$2|dä Lengk eß|di Lengks senn|dat Jedrißße}} problemattesch: <strong>$1</strong>',
	'translate-checks-xhtml'                 => 'Donn hee {{PLURAL:$2|dat Kommando|di Kommandose|dat Jedrißße}} ußtuusche, un schriif de reschtije do för hen: <strong>$1</strong>',
	'translate-checks-plural'                => 'De Ojjinaal-Nohresch bruch <nowiki>{{PLURAL:}}</nowiki>, ävver de Övversäzong deijt dat nit?',
	'tog-translate-nonewsletter'             => 'Donn mer keijn Rondschriive övver de eläktronesche Poß scheke (nor för Medmaacher med beschtäteschte Addräß för de e-mail)',
	'right-translate'                        => 'Med dä Schnettshtäll zom Övverseze ärrbeide',
	'translate-rc-translation-filter'        => 'Övversëzonge:',
	'translate-rc-translation-filter-no'     => 'Alles aanzeije',
	'translate-rc-translation-filter-only'   => 'Don noor de Övversëzonge zëije',
	'translate-rc-translation-filter-filter' => 'Don de Övversëzonge fott lohße',
	'translate-rc-translation-filter-site'   => 'Nor de Änderonge för hee dat Wiki',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'translate'               => 'Traducere',
	'translate-edit'          => 'recensere',
	'translate-talk'          => 'disputatio',
	'translate-history'       => 'historia',
	'translate-next'          => 'Pagina proxima',
	'translate-prev'          => 'Pagina superior',
	'translate-magic-cm-save' => 'Servare',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 * @author Siebrand
 */
$messages['lb'] = array(
	'translate'                              => 'Iwwersetzt',
	'translate-desc'                         => "[[Special:Translate|Spezialsäit]] fir d'Iwwersetzung vu MediaWiki-Systemmessagen a fir Aneres",
	'translate-edit'                         => 'änneren',
	'translate-talk'                         => 'Diskussioun',
	'translate-history'                      => 'Versiounen',
	'translate-task-view'                    => 'All Systemmessagen uweisen',
	'translate-task-untranslated'            => 'All net iwwersate Systemmessagen uweisen',
	'translate-task-optional'                => 'Optional Messagen uweisen',
	'translate-task-problematic'             => 'Systemmessage weisen wou et Problemer gëtt',
	'translate-task-review'                  => 'Ännerungen uweisen',
	'translate-task-reviewall'               => 'All Iwwersetzungen nokucken',
	'translate-task-export'                  => 'All Iwwersetzunge exportéieren',
	'translate-task-export-to-file'          => "D'Iwwersetzung an e Fichier exportéieren",
	'translate-task-export-as-po'            => "Iwwersetzung an de ''Gettext Format'' exportéieren",
	'translate-task-export-to-xliff'         => 'Iwwersetzungen an den Xliff-Format exportéieren',
	'translate-page-no-such-language'        => 'Ongëltege Sproochcode benotzt',
	'translate-page-no-such-task'            => 'Déi gefroten Aufgab gëtt et net.',
	'translate-page-no-such-group'           => 'Déi Gefrote Grupp gëtt et net.',
	'translate-page-disabled'                => "Iwwersetzungen an dës Sprooch goufen an dësem Grupp ausgeschalt. Grond:

''$1''",
	'translate-page-settings-legend'         => 'Astellungen',
	'translate-page-task'                    => 'Ech wëll',
	'translate-page-group'                   => 'Grupp',
	'translate-page-language'                => 'Sprooch',
	'translate-page-limit'                   => 'Maximum',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|Message|Message}} pro Säit',
	'translate-submit'                       => 'Uweisen',
	'translate-page-navigation-legend'       => 'Navigatioun',
	'translate-page-showing'                 => "D'Message vun $1 bis $2 vun am Ganzen $3 gi gewisen.",
	'translate-page-showing-all'             => '$1 {{PLURAL:$1|Message gëtt|Message gi}} gewisen',
	'translate-page-showing-none'            => 'Kee Message fir ze weisen',
	'translate-next'                         => 'Nächst Säit',
	'translate-prev'                         => 'Säit virdrun',
	'translate-page-description-legend'      => 'Informatiounen iwwert de Grupp',
	'translate-page-edit'                    => 'änneren',
	'translate-optional'                     => '(optional)',
	'translate-ignored'                      => '(ignoréiert)',
	'translate-edit-definition'              => 'Definitioun vum Message',
	'translate-edit-contribute'              => 'mathëllefen',
	'translate-edit-no-information'          => 'Dëse Message huet keng Dokumentatioun. Wann Dir wësst wou oder wéi dëse Message gebraucht gëtt, da kënnt Dir aneren Iwwersetzer hëllefen an dem dir Informatiounen iwwert dëse Message gitt.',
	'translate-edit-information'             => 'Informatioun iwwert dëse Message ($1)',
	'translate-edit-in-other-languages'      => 'Message an anere Sproochen',
	'translate-edit-committed'               => 'Aktuell Iwwersetzung an der Software',
	'translate-edit-warnings'                => 'Warnunge virun onkompletten Iwwersetzungen',
	'translate-edit-goto-no-prev'            => 'Kee virege Message',
	'translate-edit-goto-no-next'            => 'Keen nächste Message',
	'translate-edit-goto-prev'               => 'Virege Message änneren',
	'translate-edit-goto-next'               => 'Nächste Message änneren',
	'translate-edit-goto-list'               => "Zréck op d'Lëscht",
	'translate-magic-pagename'               => 'Erweidert MediaWiki Iwwersetzung',
	'translate-magic-help'                   => "Dir kënnt Spezialsäiten, magesch Wierder, Nimm vu Skins an Nummraum Nimm iwwersetzen.

Bäi de magesche Wierder (Magic words) musst Dir déi englesch Iwwersetzung abannen, soss fonctionéieren se net méi.
Och den Ufank (0 oder 1) musst Dir onverännert loossen.

Spezial Säit ''Aliasen'' a ''magesch Wierder'' kënne méi Iwwersetzungen hunn.
Iwwersetzungen gi mat engem Komma (,) getrennt.
Skin Nimm a Nummraim kënne nëmmen eng Iwwersetzung hunn.

Am Nummraum Iwwersetzungen ass <tt>$1 Diskussioun</tt> speziell. <tt>$1</tt> gëtt duerch ''sitename'' ersat (zum Beispill <tt>{{SITENAME}} Diskussioun</tt>).
Wann et an àrer Sprooch net méiglech ass fir e gëltegen Ausdrock ze maachen ouni ''sitename'' z'änneren, da kontaktéiert w.e.g. en Entwéckler (developer).

Dir musst am Grupp vun den Iwwersetzer si fir Ännerungen ofspäicheren ze kënnen.
Ännerunge ginn net gespäichert bis Dir op ''Säit späicheren'' geklickt hutt.",
	'translate-magic-module'                 => 'Modul:',
	'translate-magic-submit'                 => 'Weisen',
	'translate-magic-cm-export'              => 'Export',
	'translate-magic-cm-to-be'               => 'Gëtt',
	'translate-magic-cm-current'             => 'Aktuell',
	'translate-magic-cm-original'            => 'Original',
	'translate-magic-cm-comment'             => 'Bemierkung:',
	'translate-magic-cm-save'                => 'Späicheren',
	'translate-magic-cm-updatedusing'        => 'Geännert ma Hëllef vu [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Späicheren huet net fonktionéiert',
	'translate-magic-special'                => "Spezialsäit vun den 'Aliasnimm'",
	'translate-magic-words'                  => 'Magesch Wierder',
	'translate-magic-skin'                   => 'Numm vum Interface (Skin)',
	'translate-magic-namespace'              => 'Nummraum Nimm',
	'translationchanges'                     => 'Iwwersetzung ännert',
	'translationchanges-export'              => 'exportéieren',
	'translationchanges-change'              => '$1: $2 vun $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|Dëse Parameter gëtt|Dës Parameter ginn}} net benotzt:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|Dëse Parameter ass|Dës Parameter sinn }} onbekannt:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Et gëtt eng ongerued Zuel vu {{PLURAL:$2|Klammere|Klammere}} benotzt:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|Dëse Link ass|Dës Linke si}} problematesch: 
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Ersetzt {{PLURAL:$2|dësen Tag|dës Tagen}} w.e.g. duerch déi korrekt:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => "D'Definitioun benotzt <nowiki>{{PLURAL:}}</nowiki> awer d'Iwwersetzung mécht dat net.",
	'tog-translate-nonewsletter'             => 'Schéckt mir keng E-Mail-Newsletter. (nëmme relevant fir Benotzer mat enger confirméierter e-Mailadress)',
	'right-translate'                        => 'Mat dem Iwwersetzungs Tool änneren',
	'translate-rc-translation-filter'        => 'Iwwersetzunge filteren:',
	'translate-rc-translation-filter-no'     => 'Näischt maachen',
	'translate-rc-translation-filter-only'   => 'Nëmmen Iwwersetzunge weisen',
	'translate-rc-translation-filter-filter' => 'Iwwersetzunge filteren',
	'translate-rc-translation-filter-site'   => 'Nëmmen Ännerunge vu Messagen vum Site',
	'translate-stats-edits'                  => 'Ännerunge pro Dag',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'translate'                     => 'Vertale',
	'translate-edit'                => 'bewèrk',
	'translate-talk'                => 'euverlèk',
	'translate-history'             => 'gesjiedenis',
	'translate-task-view'           => 'Laot alle berichter zeen van',
	'translate-task-untranslated'   => 'Laot alle ónvertäölde berichter zeen van',
	'translate-task-optional'       => 'optioneel berich bekieke',
	'translate-task-review'         => 'verangeringe keterlieëre',
	'translate-task-reviewall'      => 'alle vertalinge keterlieëre',
	'translate-task-export'         => 'vertalinge exportieëre',
	'translate-task-export-to-file' => 'vertalinge nao bestandj exportieëre',
	'translate-task-export-as-po'   => 'vertalinge nao Gettext-formaat exportieëre',
	'translate-page-task'           => 'Ich wil',
	'translate-page-group'          => 'Groep',
	'translate-page-language'       => 'Taal',
	'translate-page-limit'          => 'Maximaal',
	'translate-submit'              => 'Ophaole',
	'translate-next'                => 'Volgende pazjena',
	'translate-prev'                => 'Vörge pazjena',
	'translate-optional'            => '(optioneel)',
	'translationchanges-export'     => 'exportieëre',
);

/** Lao (ລາວ)
 * @author Passawuth
 */
$messages['lo'] = array(
	'translate'      => 'ແປ',
	'translate-desc' => '[[Special:Translate|ໜ້າພິເສດ]]ສຳຫຼັບແປມີເດຍວິກິແລະອື່ນ າ',
);

/** Lithuanian (Lietuvių)
 * @author Vpovilaitis
 * @author Garas
 * @author Siebrand
 */
$messages['lt'] = array(
	'translate'                         => 'Vertimas',
	'translate-edit'                    => 'redaguoti',
	'translate-talk'                    => 'aptarimas',
	'translate-history'                 => 'istorija',
	'translate-task-view'               => 'Pažiūrėti visus pranešimus iš',
	'translate-task-untranslated'       => 'Pažiūrėti visus neišverstus pranešimus iš',
	'translate-task-optional'           => 'Pažiūrėti nebūtinus pranešimus iš',
	'translate-task-review'             => 'Peržiūrėti pakeitimus iš',
	'translate-task-reviewall'          => 'Peržiūrėti visus vertimus iš',
	'translate-task-export'             => 'Eksportuoti vertimus iš',
	'translate-task-export-to-file'     => 'Eksportuoti į failą vertimus iš',
	'translate-task-export-as-po'       => 'Eksportuoti vertimą Gettext formatu',
	'translate-page-no-such-language'   => 'Buvo nurodytas klaidingas kalbos kodas',
	'translate-page-settings-legend'    => 'Nustatymai',
	'translate-page-task'               => 'Aš noriu',
	'translate-page-group'              => 'Grupė',
	'translate-page-language'           => 'Kalba',
	'translate-page-limit'              => 'Limitas',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|pranešimas|pranešimai|pranešimų}} puslapyje',
	'translate-submit'                  => 'Išrinkti',
	'translate-page-navigation-legend'  => 'Navigacija',
	'translate-page-showing'            => 'Rodomi pranešimai nuo $1 iki $2 iš $3.',
	'translate-page-showing-all'        => '{{PLURAL:$1|Rodomas $1 pranešimas|Rodomi $1 pranešimai|Rodoma $1 pranešimų}}.',
	'translate-page-showing-none'       => 'Nėra pranešimų rodymui.',
	'translate-next'                    => 'Kitas puslapis',
	'translate-prev'                    => 'Ankstesnis puslapis',
	'translate-page-description-legend' => 'Informacija apie grupę',
	'translate-optional'                => '(nebūtinas)',
	'translate-ignored'                 => '(ignoruojamas)',
	'translate-edit-definition'         => 'Pranešimo aprašymas',
	'translate-edit-contribute'         => 'papildyti',
	'translate-edit-no-information'     => "''Šis pranešimas dar neturi dokumentacijos. Jei žinote kur ar kaip šis pranešimas naudojamas, jūs galite padėti kitiems vertėjams pridėdami dokumentacijos į šį pranešimą.''",
	'translate-edit-information'        => 'Informacija apie šį pranešimą ($1)',
	'translate-magic-pagename'          => 'MediaWiki išplėtimų vertimas',
	'translate-magic-help'              => 'Jūs galite išversti specialių puslapių pavadinimus, magiškus žodžius, apvalkalų pavadinimus ir vardų sričių pavadinimus.

Magiško žodžio vertimuose nurodykite ir vertimą į anglų kalbą, kitaip jis nustos veikti. Taip pat palikite pirmąjį elementą (0 arba 1) tokį koks jis yra.

Specialiojo puslapio pavadinimo ir magiško žodžio vertimai gali būti keli. Vertimai yra skiriami kableliu (,). Apvalkalo ir vardų srities pavadinimas gali turėti tik vieną vertimą.

Vardų sričių vertimuose <tt>$1 aptarimas</tt> yra specialus. <tt>$1</tt> yra pakeičiamas svetainės pavadinimu (Pavyzdžiui <tt>{{SITENAME}} aptarimas</tt>). Jei nėra galimybės Jūsų kalboje suformuoti teisingos išraiškos su svetainės pavadinimo pakeitimu, prašome kreiptis į kūrėjus. 

Jūs turite priklausyti vertėjų grupei, kad galėtumėte išsaugoti pakeitimus. Pakeitimai nebus išsaugoti iki Jūs nuspausite išsaugojimo butoną apačioje.',
	'translate-magic-submit'            => 'Išrinkti',
	'translate-magic-cm-export'         => 'Eksportuoti',
	'translate-magic-cm-to-be'          => 'Turi būti',
	'translate-magic-cm-current'        => 'Einamasis',
	'translate-magic-cm-original'       => 'Originalas',
	'translate-magic-cm-save'           => 'Išsaugoti',
	'translate-magic-cm-updatedusing'   => 'Atnaujintas, naudojant [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => 'Nepavyko išsaugoti',
	'translate-magic-special'           => 'Specialių puslapių pavadinimai',
	'translate-magic-words'             => 'Magiški žodžiai',
	'translate-magic-skin'              => 'Apvalkalų pavadinimai',
	'translate-magic-namespace'         => 'Vardų srities pavadinimai',
	'translationchanges'                => 'Vertimo pakeitimai',
	'translationchanges-export'         => 'eksportuoti',
	'translationchanges-change'         => '$1: $2 pagal $3',
	'translate-checks-parameters'       => 'Šie parametrai nepanaudoti: <strong>$1</strong>',
	'translate-checks-plural'           => 'Aprašymas naudoja <nowiki>{{PLURAL:}}</nowiki>, bet vertimas ne.',
);

/** Latvian (Latviešu)
 * @author Yyy
 */
$messages['lv'] = array(
	'translate-next' => 'Nākamā lapa',
	'translate-prev' => 'Iepriekšējā lapa',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 * @author Jacob.jose
 */
$messages['ml'] = array(
	'translate'                         => 'വിവര്‍ത്തനം ചെയ്യുക',
	'translate-edit'                    => 'തിരുത്തുക',
	'translate-talk'                    => 'സം‌വാദം',
	'translate-history'                 => 'നാള്‍വഴി',
	'translate-task-view'               => 'എല്ലാ സന്ദേശങ്ങളും കാണണം',
	'translate-task-untranslated'       => 'പരിഭാഷപ്പെടുത്തിയിട്ടില്ലാത്ത സന്ദേശങ്ങള്‍ കാണണം',
	'translate-task-optional'           => 'പരിഭാഷ നിര്‍ബന്ധമില്ലാത്തെ സന്ദേശങ്ങള്‍ കാണണം',
	'translate-task-review'             => 'മാറ്റങ്ങള്‍ വന്ന സന്ദേശങ്ങള്‍ കാണണം',
	'translate-task-reviewall'          => 'പരിഭാഷ ചെയ്തവ സംശോധനം ചെയ്യണം',
	'translate-page-no-such-language'   => 'തിരഞ്ഞെടുത്ത ഭാഷ അസാധുവാണ്‌.',
	'translate-page-no-such-task'       => 'തിരഞ്ഞെടുത്ത ടാസ്ക് അസാധുവാണ്‌.',
	'translate-page-no-such-group'      => 'തിരഞ്ഞെടുത്ത ഗ്രൂപ്പ് അസാധുവാണ്‌.',
	'translate-page-disabled'           => "ഈ ഗ്രൂപ്പിലുള്ള സന്ദേശങ്ങള്‍ക്ക് ഈ ഭാഷയിലുള്ള പരിഭാഷ നിരോധിച്ചിരിക്കുന്നു. കാരണം:

''$1''",
	'translate-page-settings-legend'    => 'ക്രമീകരണങ്ങള്‍',
	'translate-page-task'               => 'എനിക്ക്',
	'translate-page-group'              => 'ഗ്രൂപ്പ്',
	'translate-page-language'           => 'ഭാഷ',
	'translate-page-limit'              => 'പരിധി',
	'translate-page-limit-option'       => 'ഒരു താളില്‍ $1 {{PLURAL:$1|സന്ദേശം|സന്ദേശങ്ങള്‍}}',
	'translate-submit'                  => 'സമര്‍പ്പിക്കുക',
	'translate-page-showing'            => '$3 സന്ദേശങ്ങളുള്ളതില്‍ $1 മുതല്‍ $2 വരെയുള്ളവ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്നു',
	'translate-page-showing-all'        => '$1 {{PLURAL:$1|സന്ദേശം|സന്ദേശങ്ങള്‍}} പ്രദര്‍ശിപ്പിക്കുന്നു.',
	'translate-page-showing-none'       => 'പ്രദര്‍ശിപ്പിക്കുവാന്‍ സന്ദേശങ്ങളില്ല.',
	'translate-next'                    => 'അടുത്ത താള്‍',
	'translate-prev'                    => 'മുന്‍പത്തെ താള്‍',
	'translate-page-description-legend' => 'ഗ്രൂപ്പിനെപ്പറ്റിയുള്ള വിവരങ്ങള്‍',
	'translate-optional'                => '(നിര്‍ബന്ധമില്ല)',
	'translate-edit-definition'         => 'സന്ദേശത്തിന്റെ നിര്‍‌വചനം',
	'translate-edit-contribute'         => 'സംഭാവന ചെയ്യുക',
	'translate-edit-no-information'     => "''ഈ സന്ദേശത്തിനു ഡോക്കുമെന്റേഷന്‍ ഇല്ല.
ഈ സന്ദേശം എങ്ങനെയാണു ഉപയോഗിക്കപ്പെടുന്നത് എന്ന് നിങ്ങള്‍ക്ക് അറിയാമെങ്കില്‍, അതിനെകുറിച്ചുള്ള ഡോക്കുമെന്റേഷന്‍ ചേര്‍ത്ത് താങ്കള്‍ക്ക് മറ്റുള്ള പരിഭാഷകര്‍ക്കു സഹായമേകാം.''",
	'translate-edit-information'        => 'ഈ സന്ദേശത്തെക്കുറിച്ചുള്ള വിവരണം ($1)',
	'translate-edit-in-other-languages' => 'സന്ദേശം മറ്റുള്ള ഭാഷകളില്‍',
	'translate-edit-committed'          => 'സന്ദേശത്തിന്റെ നിലവിലുള്ള പരിഭാഷ',
	'translate-edit-warnings'           => 'അപൂര്‍ണ്ണമായ പരിഭാഷയെക്കുറിച്ചുള്ള മുന്നറിയിപ്പ്',
	'translate-magic-submit'            => 'സമര്‍പ്പിക്കുക',
	'translate-magic-cm-export'         => 'എക്സ്പോര്‍ട്ട്',
	'translate-magic-cm-current'        => 'നിലവിലുള്ളത്',
	'translate-magic-cm-original'       => 'മൂലകൃതി',
	'translate-magic-cm-comment'        => 'അഭിപ്രായം:',
	'translate-magic-cm-save'           => 'സേവ് ചെയ്യുക',
	'translate-magic-cm-savefailed'     => 'സേവ് ചെയ്യാന്‍ പറ്റിയില്ല',
	'translate-magic-special'           => 'പ്രത്യേക താളുകളുടെ അലിയാസുകള്‍',
	'translate-magic-namespace'         => 'നേംസ്പേസ് നാമങ്ങള്‍',
	'translationchanges'                => 'പരിഭാഷയിലെ മാറ്റങ്ങള്‍',
	'translationchanges-export'         => 'എക്സ്പോര്‍ട്ട്',
	'translationchanges-change'         => '$1: $2 ചെയ്തത് $3',
	'translate-checks-plural'           => 'നിര്‍‌വചനം <nowiki>{{PLURAL:}}</nowiki> ഉപയോഗിക്കുന്നു, പക്ഷെ പരിഭാഷ ഉപയോഗിക്കുന്നില്ല.',
);

/** Marathi (मराठी)
 * @author Mahitgar
 * @author Kaustubh
 * @author Siebrand
 */
$messages['mr'] = array(
	'translate'                         => 'भाषांतर करा',
	'translate-desc'                    => 'मिडीयाविकि आणि त्या पलीकडील भाषांतरणे करण्याकरिता [[Special:Translate|विशेष पान]]',
	'translate-edit'                    => 'संपादन',
	'translate-talk'                    => 'चर्चा',
	'translate-history'                 => 'इतिहास',
	'translate-task-view'               => 'खालीलवर्गाचे सारे सदेश बघावे',
	'translate-task-untranslated'       => 'मधील सर्व अभाषांतरीत संदेश बघावे',
	'translate-task-optional'           => 'चे पर्यायी संदेश बघावे',
	'translate-task-review'             => 'चे बदल तपासा',
	'translate-task-reviewall'          => 'मधील सर्व भाषांतरणे तपासा',
	'translate-task-export'             => 'कडून भाषांतरणे निर्यात करा',
	'translate-task-export-to-file'     => 'भाषांतराची संचिका निर्यात करा',
	'translate-task-export-as-po'       => 'भाषांतरणे Gettext रुपरेषेत निर्यात करा',
	'translate-page-no-such-language'   => 'दिलेली भाषा अयोग्य आहे.',
	'translate-page-no-such-task'       => 'दिलेले कार्य अयोग्य आहे.',
	'translate-page-no-such-group'      => 'दिलेला गट अयोग्य आहे.',
	'translate-page-settings-legend'    => 'सेटिंग',
	'translate-page-task'               => 'मी इच्छीतो की',
	'translate-page-group'              => 'गट',
	'translate-page-language'           => 'भाषा',
	'translate-page-limit'              => 'मर्यादा',
	'translate-page-limit-option'       => 'प्रतिपान {{PLURAL:$1|संदेश|संदेश}}$1',
	'translate-submit'                  => 'शेंदा(ओढा)',
	'translate-page-navigation-legend'  => 'सुचालन',
	'translate-page-showing'            => '$3चे $1पासून $2पर्यंत संदेश दाखवत आहे.',
	'translate-page-showing-all'        => '$1 {{PLURAL:$1|संदेश|संदेश}} दाखवत आहे .',
	'translate-page-showing-none'       => 'दाखविण्यासाठी संदेश नाहीत.',
	'translate-next'                    => 'पुढील पान',
	'translate-prev'                    => 'मागील पान',
	'translate-page-description-legend' => 'गटाबद्दल माहिती',
	'translate-optional'                => '(वैकल्पिक)',
	'translate-ignored'                 => '(दुर्लक्षीत)',
	'translate-edit-definition'         => 'संदेश व्याख्या',
	'translate-edit-contribute'         => 'योगदान करा',
	'translate-edit-no-information'     => "''या संदेशाकरिता कोणतेही नोंदीकरण(डॉक्यूमेंटेशन) नाही. हा संदेश कुठे आणि कसा वापरला आहे हे तुम्हाला ठावूक असेल तर, या पानाचे नोंदीकरण(डॉक्यूमेंटेशन) करून तुम्ही इतर भाषांतरकारांना मदत करू शकता.''",
	'translate-edit-information'        => '($1)या संदेशाबद्दल माहिती',
	'translate-edit-in-other-languages' => 'इतर भाषातील संदेश',
	'translate-edit-committed'          => 'संकेतन प्रणालीमधील सध्याचे भाषांतरण',
	'translate-edit-warnings'           => 'अर्धवट भाषांतरांसाठीचे इशारे',
	'translate-magic-pagename'          => 'वाढीव मीडियाविकि भाषांतर',
	'translate-magic-submit'            => 'ओढा',
	'translate-magic-cm-export'         => 'नीर्यात',
	'translate-magic-cm-to-be'          => 'अपेक्षीत',
	'translate-magic-cm-current'        => 'सद्य',
	'translate-magic-cm-original'       => 'मूळ',
	'translate-magic-cm-comment'        => 'प्रतिक्रीया',
	'translate-magic-cm-save'           => 'जतन करा',
	'translate-magic-cm-updatedusing'   => '[[Special:Magic]] वापरून बदलले',
	'translate-magic-cm-savefailed'     => 'जतन अयशस्वी',
	'translate-magic-special'           => 'विशेष पान टोपणनावे',
	'translate-magic-words'             => 'जादूई शब्द',
	'translate-magic-skin'              => 'त्वचेचे नाव',
	'translate-magic-namespace'         => 'नामविश्व नावे',
	'translationchanges'                => 'भाषांतरांमधील बदल',
	'translationchanges-export'         => 'नीर्यात',
	'translationchanges-change'         => '$1: $2 ने $3',
	'translate-checks-parameters'       => 'खालील पॅरॅमीटर्स वापरलेले नाहीत:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'          => 'चुकीची कंस संख्या:
<strong><nowiki>$1</nowiki></strong>',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'translate'                   => 'Traduzzjoni',
	'translate-desc'              => '[[Special:Translate|Pagina speciale]] biex tittraduċi MediaWiki u iktar',
	'translate-edit'              => 'modifika',
	'translate-talk'              => 'diskussjoni',
	'translate-history'           => 'kronoloġija',
	'translate-task-view'         => 'Uri l-messaġġi kollha minn',
	'translate-task-untranslated' => 'Uri l-messaġġi kollha li għadhom ma ġewx tradotti minn',
	'translate-task-optional'     => 'Uri messaġġi opzjonali minn',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'translate-edit'                    => 'ticpatlāz',
	'translate-talk'                    => 'tēixnāmiquiliztli',
	'translate-history'                 => 'tlahcuilōlloh',
	'translate-page-task'               => 'Niquiēlēhuia',
	'translate-page-group'              => 'Olōlli',
	'translate-page-language'           => 'Tlahtōlli',
	'translate-next'                    => 'Niman zāzanilli',
	'translate-prev'                    => 'Achto zāzanilli',
	'translate-page-description-legend' => 'Olōltechopa',
	'translate-page-edit'               => 'ticpatlāz',
	'translate-edit-in-other-languages' => 'Tlahcuilōltzin occequīntīn tlahtōlcopa',
	'translate-edit-goto-prev'          => 'Ticpatlāz niman tlahcuilōltzin',
	'translate-edit-goto-next'          => 'Ticpatlāz achtopa tlahcuilōltzin',
	'translate-magic-cm-current'        => 'Āxcān',
	'translate-magic-cm-save'           => 'Ticpiyāz',
	'translate-stats-edits'             => 'Tlapatlaliztli',
);

/** Neapolitan (Nnapulitano)
 * @author SPQRobin
 */
$messages['nap'] = array(
	'translate-edit'    => 'càgna',
	'translate-talk'    => 'chiàcchiera',
	'translate-history' => 'cronologgia',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'translate'                   => 'Översetten',
	'translate-edit'              => 'ännern',
	'translate-talk'              => 'Diskuschoon',
	'translate-history'           => 'Historie',
	'translate-page-task'         => 'Ik will',
	'translate-page-group'        => 'Grupp',
	'translate-page-language'     => 'Spraak',
	'translate-magic-cm-original' => 'Original',
	'translate-magic-cm-comment'  => 'Kommentar:',
	'translate-magic-cm-save'     => 'Spiekern',
	'translate-magic-special'     => 'Spezialsieden-Alternativnaams',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'translate-edit' => 'bewark',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 */
$messages['nl'] = array(
	'translate'                              => 'Vertalen',
	'translate-desc'                         => '[[Special:Translate|Speciale pagina]] voor het vertalen van MediaWiki en meer',
	'translate-edit'                         => 'bewerken',
	'translate-talk'                         => 'overleg',
	'translate-history'                      => 'geschiedenis',
	'translate-task-view'                    => 'alle berichten bekijken',
	'translate-task-untranslated'            => 'alle onvertaalde berichten bekijken',
	'translate-task-optional'                => 'optionele berichten bekijken',
	'translate-task-problematic'             => 'vertalingen met problemen bekijken',
	'translate-task-review'                  => 'wijzigingen controleren',
	'translate-task-reviewall'               => 'alle vertalingen controleren',
	'translate-task-export'                  => 'vertalingen exporteren',
	'translate-task-export-to-file'          => 'vertalingen naar bestand exporteren',
	'translate-task-export-as-po'            => 'vertalingen naar Gettext-formaat exporteren',
	'translate-task-export-to-xliff'         => 'vertalingen naar Xliff-formaat exporteren',
	'translate-page-no-such-language'        => 'Er is een ongeldige taalcode opgegeven',
	'translate-page-no-such-task'            => 'De aangegeven functie bestaat niet.',
	'translate-page-no-such-group'           => 'De aangegeven groep bestaat niet.',
	'translate-page-disabled'                => "Vertalingen in deze taal voor deze groep zijn uitgeschakeld. Reden:

''$1''",
	'translate-page-settings-legend'         => 'Instellingen',
	'translate-page-task'                    => 'Ik wil',
	'translate-page-group'                   => 'Groep',
	'translate-page-language'                => 'Taal',
	'translate-page-limit'                   => 'Maximaal',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|bericht|berichten}} per pagina',
	'translate-submit'                       => 'Ophalen',
	'translate-page-navigation-legend'       => 'Navigatie',
	'translate-page-showing'                 => 'De berichten $1 tot $2 van $3 worden weergegeven.',
	'translate-page-showing-all'             => 'Er {{PLURAL:$1|wordt 1 bericht|worden $1 berichten}} weergegeven.',
	'translate-page-showing-none'            => 'Er zijn geen berichten in deze selectie.',
	'translate-next'                         => 'volgende',
	'translate-prev'                         => 'vorige',
	'translate-page-description-legend'      => 'Informatie over de groep',
	'translate-page-edit'                    => 'bewerken',
	'translate-optional'                     => '(optioneel)',
	'translate-ignored'                      => '(genegeerd)',
	'translate-edit-definition'              => 'Berichtdefinitie',
	'translate-edit-contribute'              => 'bijdragen',
	'translate-edit-no-information'          => "''Dit bericht heeft geen documentatie.
Als u weet waar dit bericht wordt gebruikt, dan kunt u andere gebruikers helpen door documentatie voor dit bericht toe te voegen.''",
	'translate-edit-information'             => 'Informatie over dit bericht ($1)',
	'translate-edit-in-other-languages'      => 'Bericht in andere talen',
	'translate-edit-committed'               => 'Huidig bericht in software',
	'translate-edit-warnings'                => 'Waarschuwingen over onjuiste vertalingen',
	'translate-edit-goto-no-prev'            => 'Geen vorig bericht',
	'translate-edit-goto-no-next'            => 'Geen volgend bericht',
	'translate-edit-goto-prev'               => 'Vorige bericht bewerken',
	'translate-edit-goto-next'               => 'Volgende bericht bewerken',
	'translate-edit-goto-list'               => 'Terug naar de lijst',
	'translate-magic-pagename'               => 'Uitgebreide MediaWiki-vertaling',
	'translate-magic-help'                   => 'U kunt alternatieven voor speciale pagina\'s, magische woorden, skinnamen en naamruimtebenamingen vertalen.

In magische woorden moet u de Engelstalige vertalingen opnemen, omdat ze anders niet meer werken. Laat ook de eerste cijfers (0 of 1) ongewijzigd.

Alternatieven voor speciale pagina\'s en magische woorden kunnen meerdere vertalingen hebben. Scheid vertalingen met een komma (,). Skinnamen en naamruimtebenamingen kunnen slechts één vertaling hebben.

In naamruimtebenamingen is <tt>$1 talk</tt> een uitzondering. <tt>$1</tt> wordt vervangen door de sitenaam (bijvoorbeeld <tt>{{SITENAME}} talk</tt>). Als het in uw taal niet mogelijk is een geldige uitdrukking te vormen zonder de sitenaam te wijzigen, neem dan contact op met een ontwikkelaar.

Om wijzigingen op te slaan moet u lid zijn van de groep vertalers. Wijzigingen worden niet bewaard totdat u op "Pagina opslaan" hebt geklikt.',
	'translate-magic-module'                 => 'Module:',
	'translate-magic-submit'                 => 'Ophalen',
	'translate-magic-cm-export'              => 'Exporteren',
	'translate-magic-cm-to-be'               => 'Toekomstig',
	'translate-magic-cm-current'             => 'Huidig',
	'translate-magic-cm-original'            => 'Oorspronkelijk',
	'translate-magic-cm-comment'             => 'Samenvatting:',
	'translate-magic-cm-save'                => 'Opslaan',
	'translate-magic-cm-updatedusing'        => 'Bijgewerkt via [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Opslaan mislukt',
	'translate-magic-special'                => "Alternatieven speciale pagina's",
	'translate-magic-words'                  => 'Magische woorden',
	'translate-magic-skin'                   => 'Skinnamen',
	'translate-magic-namespace'              => 'Naamruimtebenamingen',
	'translationchanges'                     => 'Vertalingen',
	'translationchanges-export'              => 'exporteren',
	'translationchanges-change'              => '$1: $2 door $3',
	'translate-checks-parameters'            => 'De volgende {{PLURAL:$2|parameter wordt|parameters worden}} niet gebruikt:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => 'De volgende {{PLURAL:$2|parameter is|parameters zijn}} onbekend:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Er wordt een oneven {{PLURAL:$2|aantal haakjes|aantal haakjes}} gebruikt:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => 'De volgende {{PLURAL:$2|verwijzing is|verwijzingen zijn}} problematisch:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Vervang de volgende {{PLURAL:$2|tag|tags}} door de juiste:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'De definitie bevat <nowiki>{{PLURAL:}}</nowiki>, maar de vertaling niet.',
	'translate-checks-pagename'              => 'Afwijkende naamruimte vergeleken met de brontekst',
	'tog-translate-nonewsletter'             => 'Mij geen nieuwsbrieven per e-mail sturen (alleen relevant voor gebruikers met een bevestigd e-mailadres)',
	'right-translate'                        => 'Bewerken via de vertaalinterface',
	'translate-rc-translation-filter'        => 'Vertalingen filteren:',
	'translate-rc-translation-filter-no'     => 'Niets doen',
	'translate-rc-translation-filter-only'   => 'Alleen vertalingen weergeven',
	'translate-rc-translation-filter-filter' => 'Vertalingen wegfilteren',
	'translate-rc-translation-filter-site'   => 'Alleen wijzigingen aan plaatselijke systeemberichten',
	'translationstats'                       => 'Vertaalstatistieken',
	'translate-stats-edits'                  => 'Bewerkingen per dag',
	'translate-stats-users'                  => 'Vertalers',
	'translate-statsf-intro'                 => 'U kunt via dit formulier eenvoudige statistieken samenstellen.
Alle waarden hebben een limiet aan de boven- en onderzijde.',
	'translate-statsf-options'               => 'Grafiekopties',
	'translate-statsf-width'                 => 'Breedte in pixels',
	'translate-statsf-height'                => 'Hoogte in pixels',
	'translate-statsf-days'                  => 'Periode in dagen',
	'translate-statsf-scale'                 => 'Granulariteit',
	'translate-statsf-scale-days'            => 'Dagen',
	'translate-statsf-scale-hours'           => 'Uren',
	'translate-statsf-count'                 => 'Eenheid',
	'translate-statsf-count-edits'           => 'Aantal bewerkingen',
	'translate-statsf-count-users'           => 'Actieve vertalers',
	'translate-statsf-language'              => 'Kommagescheiden lijst van taalcodes',
	'translate-statsf-group'                 => 'Kommagescheiden lijst van groepscodes',
	'translate-statsf-submit'                => 'Ter controle bekijken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'translate-edit'                   => 'endre',
	'translate-talk'                   => 'diskusjon',
	'translate-history'                => 'historikk',
	'translate-page-group'             => 'Gruppe',
	'translate-page-language'          => 'Språk',
	'translate-page-navigation-legend' => 'Navigering',
	'translate-next'                   => 'Neste side',
	'translate-prev'                   => 'Førre side',
	'translate-optional'               => '(valfri)',
	'translate-magic-cm-export'        => 'Eksporter',
	'translate-magic-cm-current'       => 'Noverande',
	'translate-magic-cm-comment'       => 'Kommentar:',
	'translate-magic-cm-save'          => 'Lagre',
	'translationchanges-export'        => 'eksporter',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Siebrand
 */
$messages['no'] = array(
	'translate'                              => 'Oversett',
	'translate-desc'                         => '[[Special:Translate|Spesialside]] for oversettelse av MediaWiki o.a.',
	'translate-edit'                         => 'rediger',
	'translate-talk'                         => 'diskusjon',
	'translate-history'                      => 'historikk',
	'translate-task-view'                    => 'se alle beskjeder',
	'translate-task-untranslated'            => 'se alle uoversatte beskjeder',
	'translate-task-optional'                => 'se valgfrie beskjeder',
	'translate-task-problematic'             => 'Vis beskjeder som har problemer',
	'translate-task-review'                  => 'gå gjennom endringer',
	'translate-task-reviewall'               => 'gå gjennom oversettelser',
	'translate-task-export'                  => 'eksportere oversettelser',
	'translate-task-export-to-file'          => 'eksportere oversettelser til fil',
	'translate-task-export-as-po'            => 'eksportere oversettelser i Gettext-format',
	'translate-task-export-to-xliff'         => 'Eksporter oversettelser i Xliff-format',
	'translate-page-no-such-language'        => 'Ugyldig språkkode angitt.',
	'translate-page-no-such-task'            => 'Ugyldig oppgave angitt.',
	'translate-page-no-such-group'           => 'Ugyldig gruppe angitt.',
	'translate-page-disabled'                => "Oversettelser til dette språket i denne gruppen er blitt slått av. Årsak:

''$1''",
	'translate-page-settings-legend'         => 'Innstillinger',
	'translate-page-task'                    => 'Jeg vil',
	'translate-page-group'                   => 'Gruppe',
	'translate-page-language'                => 'Språk',
	'translate-page-limit'                   => 'Grense',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|beskjed|beskjeder}} per side',
	'translate-submit'                       => 'Hent',
	'translate-page-navigation-legend'       => 'Navigasjon',
	'translate-page-showing'                 => 'Viser beskjeder fra $1 til $2 av $3.',
	'translate-page-showing-all'             => 'Viser {{PLURAL:$1|én beskjed|$1 beskjeder}}.',
	'translate-page-showing-none'            => 'Ingen beskjeder å vise.',
	'translate-next'                         => 'Neste side',
	'translate-prev'                         => 'Forrige side',
	'translate-page-description-legend'      => 'Informasjon om gruppen',
	'translate-page-edit'                    => 'rediger',
	'translate-optional'                     => '(valgfri)',
	'translate-ignored'                      => '(ignorert)',
	'translate-edit-definition'              => 'Beskjeden som skal oversettes',
	'translate-edit-contribute'              => 'bidra',
	'translate-edit-no-information'          => "''Denne beskjeden har ikke dokumentasjon. Om du vet hvor eller hvordan denne beskjeden brukes, kan du hjelpe andre oversettere ved å legge inn dokumentasjon til denne beskjeden.''",
	'translate-edit-information'             => 'Informasjon om denne beskjeden ($1)',
	'translate-edit-in-other-languages'      => 'Beskjeden på andre språk',
	'translate-edit-committed'               => 'Nåværende oversettelse',
	'translate-edit-warnings'                => 'Advarsler om ufullstendige oversettelser',
	'translate-edit-goto-no-prev'            => 'Ingen beskjeder før denne',
	'translate-edit-goto-no-next'            => 'Ingen beskjeder etter denne',
	'translate-edit-goto-prev'               => 'Rediger forrige beskjed',
	'translate-edit-goto-next'               => 'Rediger neste beskjed',
	'translate-edit-goto-list'               => 'Tilbake til listen',
	'translate-magic-pagename'               => 'Utvidet MediaWiki-oversettelse',
	'translate-magic-help'                   => 'Du kan oversette spesialsidenavn, magiske ord, utseendenavn og navneromnavn.

I magiske ord må du inkludere engelskspråklige oversettelser, ellers vil de ikke fungere. La også det første punktet (0 eller 1) være som det er.

Spesialsidenavn og magiske ord kan ha flere oversettelser. Oversettelser skilles med et komma (,). Utseendenavn og navnerom kan kun ha én oversettelse.

I navneromoversettelsene er <tt>$1 talk</tt> spesiell. <tt>$1</tt> erstattes med sidens navn (for eksempel <tt>{{SITENAME}}</tt>). Om det ikke er mulig å få til et gyldig uttrykk på ditt språk her uten å endre sidenavnet, kontakt en utvikler.

Du må være i oversettergruppa for å lagre endringer. Endringer lagres ikke før du klikker på lagre-knappen nedenfor.',
	'translate-magic-module'                 => 'Modul:',
	'translate-magic-submit'                 => 'Hent',
	'translate-magic-cm-export'              => 'Eksporter',
	'translate-magic-cm-to-be'               => 'Framtidig',
	'translate-magic-cm-current'             => 'Nåværende',
	'translate-magic-cm-original'            => 'Opprinnelig',
	'translate-magic-cm-comment'             => 'Kommentar:',
	'translate-magic-cm-save'                => 'Lagre',
	'translate-magic-cm-updatedusing'        => 'Oppdatert vha. [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Lagring mislyktes',
	'translate-magic-special'                => 'Spesialsidenavn',
	'translate-magic-words'                  => 'Magiske ord',
	'translate-magic-skin'                   => 'Utseendenavn',
	'translate-magic-namespace'              => 'Navneromnavn',
	'translationchanges'                     => 'Oversettelsesendringer',
	'translationchanges-export'              => 'eksporter',
	'translationchanges-change'              => '$1: $2 av $3',
	'translate-checks-parameters'            => 'Følgende {{PLURAL:$2|parameter|parametere}} brukes ikke:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => 'Følgende {{PLURAL:$2|parameter er ukjent|parametere er ukjente}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => '{{PLURAL:$2|Det|Det}} er et ujevnt antall parenteser:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => 'Følgende {{PLURAL:$1|lenke er problematisk|$2 lenker er problematiske}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Erstatt følgende {{PLURAL:$2|tagg|tagger}} med de korrekte:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'Definisjonen bruker <nowiki>{{PLURAL:}}</nowiki>, men oversettelsen gjør ikke det.',
	'tog-translate-nonewsletter'             => 'Ikke send meg nyhetsbrev (gjelder kun brukere med bekreftet e-postadresse)',
	'right-translate'                        => 'Redigere med oversettingsgrensesnittet',
	'translate-rc-translation-filter'        => 'Filtrer oversettelser:',
	'translate-rc-translation-filter-no'     => 'Ikke gjør noe',
	'translate-rc-translation-filter-only'   => 'Vis bare oversettelser',
	'translate-rc-translation-filter-filter' => 'Filtrer bort oversettelser',
	'translate-rc-translation-filter-site'   => 'Kun endringer i {{SITENAME}}-beskjeder',
	'translate-stats-edits'                  => 'Redigeringer per dag',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author ChrisPtDe
 * @author Siebrand
 */
$messages['oc'] = array(
	'translate'                              => 'Traduire',
	'translate-desc'                         => '[[Special:Translate|Pagina especiala]] per traduire Mediawiki e quitament mai encara.',
	'translate-edit'                         => 'Edicion',
	'translate-talk'                         => 'Discussion',
	'translate-history'                      => 'Istoric',
	'translate-task-view'                    => 'Veire totes los messatges dempuèi',
	'translate-task-untranslated'            => 'Veire totes los messatges pas tradusits dempuèi',
	'translate-task-optional'                => 'Veire totes los messatges facultatius dempuèi',
	'translate-task-problematic'             => "Veire los messatges qu'an de problèmas",
	'translate-task-review'                  => 'Tornar veire mos cambiaments dempuèi',
	'translate-task-reviewall'               => 'Tornar veire totas las traduccions dins',
	'translate-task-export'                  => 'Exportar las traduccions dempuèi',
	'translate-task-export-to-file'          => 'Exportar las traduccions dins un fiquièr dempuèi',
	'translate-task-export-as-po'            => 'Exportar las traduccions al format Gettext',
	'translate-task-export-to-xliff'         => 'Exportar las traduccions al format Xliff',
	'translate-page-no-such-language'        => 'Un còde de lengatge invalid es estat indicat',
	'translate-page-no-such-task'            => 'Lo prètzfach especificat es invalid.',
	'translate-page-no-such-group'           => 'Lo grop especificat es invalid.',
	'translate-page-disabled'                => "Las traduccions dins aquesta lenga dins aqueste grop son estadas desactivadas. Motiu :

''$1''",
	'translate-page-settings-legend'         => 'Configuracion',
	'translate-page-task'                    => 'Vòli',
	'translate-page-group'                   => 'Grop',
	'translate-page-language'                => 'Lenga',
	'translate-page-limit'                   => 'Limit',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|messatge|messatges}} per pagina',
	'translate-submit'                       => 'Aténher',
	'translate-page-navigation-legend'       => 'Navigacion',
	'translate-page-showing'                 => 'Visualizacion dels messatges de $1 a $2 sus $3.',
	'translate-page-showing-all'             => 'Visualizacion de $1 {{PLURAL:$1|messatge|messatges}}.',
	'translate-page-showing-none'            => 'Cap de messatge de visualizar.',
	'translate-next'                         => 'Pagina seguenta',
	'translate-prev'                         => 'Pagina precedenta',
	'translate-page-description-legend'      => 'Entresenha a prepaus del grop',
	'translate-optional'                     => '(opcional)',
	'translate-ignored'                      => '(ignorat)',
	'translate-edit-definition'              => 'Definicion del messatge',
	'translate-edit-contribute'              => 'contribuir',
	'translate-edit-no-information'          => 'Actualament, aqueste messatge es pas documentat. Se sabètz ont o cossí aqueste messatge es utilizat, podètz ajudar los autres traductors en documentant aqueste messatge.',
	'translate-edit-information'             => 'Entresenhas concernent aqueste messatge ($1)',
	'translate-edit-in-other-languages'      => 'Messatge dins las autras lengas',
	'translate-edit-committed'               => 'Traduccions actualas ja dins lo logicial',
	'translate-edit-warnings'                => 'Avertiments concernent las traduccions incomplètas',
	'translate-magic-pagename'               => 'Traduccion de MediaWiki espandida',
	'translate-magic-help'                   => "Podètz traduire los aliases de paginas especialas, los mots magics, los noms de skins e los noms d'espacis de noms.

Dins los mots magics, vos cal enclure la traduccion en anglés o aquò foncionarà pas mai. E mai, daissatz lo primièr item (0 o 1) coma es.

Los aliases de paginas especialas e los mots magics pòdon aver mantuna traduccion. Las traduccions son separadas per una virgula (,).
Los noms de skins e d'espacis de noms pòdon pas aver qu'una traduccion.

Dins las traduccions d'espacis de noms, <tt>$1 talk</tt> es especial. <tt>$1</tt> es remplaçat pel nom del sit (per exemple <tt>{{SITENAME}} talk</tt>).
Se es pas possible d'obténer una expression valida dins vòstra lenga sens cambiar lo nom del sit, contactatz un desvolopaire.

Vos cal aparténer al grop dels traductors per salvar los cambiaments. Los cambiaments seràn pas salvats abans que cliquèssetz sul boton Salvar en bas.",
	'translate-magic-module'                 => 'Modul :',
	'translate-magic-submit'                 => 'Anar',
	'translate-magic-cm-export'              => 'Exportar',
	'translate-magic-cm-to-be'               => 'Desven',
	'translate-magic-cm-current'             => 'Actual',
	'translate-magic-cm-original'            => 'Original',
	'translate-magic-cm-comment'             => 'Comentari :',
	'translate-magic-cm-save'                => 'Salvagadar',
	'translate-magic-cm-updatedusing'        => 'Mesa a jorn en utilizant [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Lo salvament a pas capitat',
	'translate-magic-special'                => 'Pagina especiala d’aliases',
	'translate-magic-words'                  => 'Mots magics',
	'translate-magic-skin'                   => 'Nom de las interfàcias',
	'translate-magic-namespace'              => 'Intitolat dels espacis de nomenatge',
	'translationchanges'                     => 'Traduccions modificadas',
	'translationchanges-export'              => 'exportar',
	'translationchanges-change'              => '$1: $2 per $3',
	'translate-checks-parameters'            => 'Los paramètres seguents son pas utilizats : <strong>$1</strong',
	'translate-checks-balance'               => 'I a un nombre incorrècte de parentèsis : <strong>$1</strong>',
	'translate-checks-links'                 => 'Los ligams seguents son dobtoses : <strong>$1</strong',
	'translate-checks-xhtml'                 => 'Sètz convidats a tornar metre en plaça las balisas seguentas amb las que son corrèctas :
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'La definicion utiliza <nowiki>{{PLURAL:}}</nowiki> mas pas la traduccion',
	'tog-translate-nonewsletter'             => 'Me mandetz pas la letra d’informacion per corrièr (concernís pas que les utilizaires que dispausan d’una adreça de corrièr electronic confirmada)',
	'right-translate'                        => "Modificar en utilizant l'interfàcia de traduccion",
	'translate-rc-translation-filter'        => 'Filtrar las traduccions :',
	'translate-rc-translation-filter-no'     => 'Far pas res',
	'translate-rc-translation-filter-only'   => 'Afichar unicament las traduccions',
	'translate-rc-translation-filter-filter' => 'Eliminar las traduccions',
	'translate-rc-translation-filter-site'   => 'Solament los cambiaments de messatges del sit',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'translate-edit'             => 'баив æй',
	'translate-page-language'    => 'Æвзаг',
	'translate-magic-cm-current' => 'Нырыккон',
);

/** Polish (Polski)
 * @author Wpedzich
 * @author Sp5uhe
 * @author McMonster
 * @author Dodek
 */
$messages['pl'] = array(
	'translate'                              => 'Przetłumacz',
	'translate-desc'                         => '[[Special:Translate|Strona specjalna]] umożliwiająca tłumaczenie MediaWiki oraz innych programów',
	'translate-edit'                         => 'edytuj',
	'translate-talk'                         => 'dyskusja',
	'translate-history'                      => 'historia',
	'translate-task-view'                    => 'zobaczyć wszystkie komunikaty',
	'translate-task-untranslated'            => 'zobaczyć wszystkie nieprzetłumaczone komunikaty',
	'translate-task-optional'                => 'zobaczyć opcjonalne komunikaty',
	'translate-task-problematic'             => 'zobaczyć problematyczne komunikaty',
	'translate-task-review'                  => 'sprawdzić zmiany',
	'translate-task-reviewall'               => 'przejrzeć wszystkie tłumaczenia',
	'translate-task-export'                  => 'wyeksportować tłumaczenie',
	'translate-task-export-to-file'          => 'wyeksportować tłumaczenie do pliku',
	'translate-task-export-as-po'            => 'wyeksportować tłumaczenie w formacie Gettext',
	'translate-task-export-to-xliff'         => 'wyeksportować tłumaczenie w formacie Xliff',
	'translate-page-no-such-language'        => 'Podano nieprawidłowy język.',
	'translate-page-no-such-task'            => 'Podano nieprawidłowe zadanie.',
	'translate-page-no-such-group'           => 'Podano nieprawidłową grupę.',
	'translate-page-disabled'                => "Tłumaczenia na ten język, w tej grupie, zostały wstrzymane z następującego powodu:

''$1''",
	'translate-page-settings-legend'         => 'Ustawienia',
	'translate-page-task'                    => 'Chcę',
	'translate-page-group'                   => 'Grupa',
	'translate-page-language'                => 'Język',
	'translate-page-limit'                   => 'Ograniczenie',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|komunikat|komunikaty|komunikatów}} na stronę',
	'translate-submit'                       => 'Wyświetl',
	'translate-page-navigation-legend'       => 'Nawigacja',
	'translate-page-showing'                 => 'Wyświetlone komunikaty od $1 do $2 z $3.',
	'translate-page-showing-all'             => 'Wyświetlono $1 {{PLURAL:$1|komunikat|komunikaty|komunikatów}}.',
	'translate-page-showing-none'            => 'Brak komunikatów do wyświetlenia.',
	'translate-next'                         => 'Następna strona',
	'translate-prev'                         => 'Poprzednia strona',
	'translate-page-description-legend'      => 'Informacje na temat grupy',
	'translate-page-edit'                    => 'edytuj',
	'translate-optional'                     => '(dodatkowe)',
	'translate-ignored'                      => '(zignorowane)',
	'translate-edit-definition'              => 'Tekst źródłowy komunikatu',
	'translate-edit-contribute'              => 'prześlij',
	'translate-edit-no-information'          => "''Ten komunikat nie posiada dokumentacji. Jeśli wiesz gdzie lub jak ten komunikat jest używany, możesz pomóc innym tłumaczom przez dodanie dokumentacji do tego komunikatu.''",
	'translate-edit-information'             => 'Informacja na temat tego komunikatu ($1)',
	'translate-edit-in-other-languages'      => 'Komunikaty w innych językach',
	'translate-edit-committed'               => 'Aktualne tłumaczenie oprogramowania',
	'translate-edit-warnings'                => 'Ostrzeżenia o niedokończonych tłumaczeniach',
	'translate-edit-goto-no-prev'            => 'Brak poprzedniego komunikatu',
	'translate-edit-goto-no-next'            => 'Brak następnego komunikatu',
	'translate-edit-goto-prev'               => 'Edycja poprzedniego komunikatu',
	'translate-edit-goto-next'               => 'Edycja następnego komunikatu',
	'translate-edit-goto-list'               => 'Powrót do listy komunikatów',
	'translate-magic-pagename'               => 'Rozszerzone tłumaczenie MediaWiki',
	'translate-magic-help'                   => 'Możliwe jest tłumaczenie aliasów stron specjalnych, magicznych słów, nazw motywów i nazw poszczególnych przestrzeni.

Do magicznych słów należy dołączyć wersje angielskie, gdyż w przeciwnym razie przestaną one działać.
Pierwszy wpis należy pozostawić w takim stanie, w jakim on występuje (0 lub 1).

Aliasy stron specjalnych i magiczne słowa mogą mieć wiele tłumaczeń, które oddziela się przecinkiem (,).
Nazwy motywów i przestrzeni mogą mieć tylko po jednym tłumaczeniu.

Podczas tłumaczenia nazw specjalne znaczenie ma zapis <tt>Dyskusja $1</tt>, gdzie <tt>$1</tt> zamieniane jest w nazwę serwisu – na przykład <tt>Dyskusja {{SITENAME}}</tt>.
Jeśli w danym języku niemożliwe jest sformułowanie prawidłowego wpisu bez zmiany nazwy serwisu, należy skontaktować się z deweloperem.

Zapisanie zmian jest możliwe tylko dla członków grupy tłumaczy.
Zmiany nie są zapisywane, dopóki użytkownik nie naciśnie umieszczonego poniżej przycisku „Zapisz”.',
	'translate-magic-module'                 => 'Moduł',
	'translate-magic-submit'                 => 'Wyświetl',
	'translate-magic-cm-export'              => 'Eksportuj',
	'translate-magic-cm-to-be'               => 'Przyszły',
	'translate-magic-cm-current'             => 'Aktualny',
	'translate-magic-cm-original'            => 'Początkowy',
	'translate-magic-cm-comment'             => 'Opis zmian:',
	'translate-magic-cm-save'                => 'Zapisz',
	'translate-magic-cm-updatedusing'        => 'Uaktualniane za pomocą strony [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Zapis nieudany',
	'translate-magic-special'                => 'Aliasy stron specjalnych',
	'translate-magic-words'                  => 'Magiczne słowa',
	'translate-magic-skin'                   => 'Nazwy motywów',
	'translate-magic-namespace'              => 'Nazwy przestrzeni nazw',
	'translationchanges'                     => 'Zmiany w tłumaczeniu',
	'translationchanges-export'              => 'eksportuj',
	'translationchanges-change'              => '$1: $2 przez $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|Następujący parametr nie jest wykorzystywany|Następujące parametry nie są wykorzystywane}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|Następujący parametr nie jest zdefiniowany|Następujące parametry nie są zdefiniowane}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'W wyrażeniu napotkano {{PLURAL:$2|niedomknięty nawias|nieparzystą liczbę nawiasów}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|Następujący link jest problematyczny|Następujące $2 linki są problematyczne|Następujących $2 linków jest problematycznych}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Zastąp {{PLURAL:$2|następujący znacznik prawidłowym|następujące znaczniki prawidłowymi}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'Definicja wykorzystuje funkcję <nowiki>{{PLURAL:}}</nowiki>, lecz w tłumaczeniu nie została ona użyta.',
	'tog-translate-nonewsletter'             => 'Nie wysyłaj do mnie biuletynów pocztą elektroniczną (dotyczy tylko użytkowników z potwierdzonym adresem e-mail)',
	'right-translate'                        => 'Edycja z użyciem interfejsu tłumaczeń',
	'translate-rc-translation-filter'        => 'Filtruj tłumaczenia:',
	'translate-rc-translation-filter-no'     => 'Nic nie rób',
	'translate-rc-translation-filter-only'   => 'Pokaż tylko tłumaczenia',
	'translate-rc-translation-filter-filter' => 'Pokaż wszystkie bez tłumaczeń',
	'translate-rc-translation-filter-site'   => 'Zmiany w komunikatach wyłącznie tej witryny',
	'translate-stats-edits'                  => 'Edycji dziennie',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Siebrand
 */
$messages['pms'] = array(
	'translate'                       => 'Viragi',
	'translate-edit'                  => 'modìfica',
	'translate-talk'                  => 'discussion',
	'translate-history'               => 'stòria',
	'translate-task-view'             => 'smon-e tuti ij messagi ëd',
	'translate-task-untranslated'     => 'Smon-e tuti ij messagi nen virà ëd',
	'translate-task-optional'         => 'Smon-e ij messagi opsionaj ëd',
	'translate-task-review'           => 'Controlé le modìfiche a',
	'translate-task-reviewall'        => 'Controlé tuti ij viragi ëd',
	'translate-task-export'           => 'Esporté ij viragi ëd',
	'translate-task-export-to-file'   => "Esporté ij viragi ant n'archivi da",
	'translate-submit'                => 'Smon-e',
	'translate-next'                  => 'Pàgina anans',
	'translate-prev'                  => 'Pàgina andré',
	'translate-optional'              => '(opsional)',
	'translate-ignored'               => '(ignorà)',
	'translate-magic-pagename'        => 'Viragi estèis ëd MediaWiki',
	'translate-magic-help'            => "A peul viré j'àlias dle pàgine speciaj, le paròle màgiche, ij nòm dle facie e coj djë spassi nominaj. Con le paròle màgiche a venta ch'a buta ëdcò ël viragi n'anglèis, che dësnò a travajo pa pì. Ch'a vardo ëdcò dë lassé ël prim element (0 or 1) tanme ch'a lo treuva. J'àlias dle pàgine soeciaj e le paròle màgiche a peulo avej pì che un viragi. Ij viragi a son separà da vìrgole (,). Ij nòm dle facie e djë spassi nominaj a peulo avej mach un viragi. Ant ël viragi djë spassi nominaj ël cas ëd <tt>$1 talk</tt> a l'é special. <tt>$1</tt> a ven arpiassà col nòm dël sit (pr'esempi <tt>{{SITENAME}} talk</tt>). Se sòn as peul nen fesse an soa lenga për rivé a n'espression bon-a sensa cambié ël nòm dël sit, për piasì, ch'as buta an contat con un programista. A venta ch'a sia ant la partìa dij tradutor për podej salvé soe modìfiche. Le modìfiche as salvo nen fin ch'a-i da nen un colp ansima al al boton ambelessì sota.",
	'translate-magic-submit'          => 'Smon-e',
	'translate-magic-cm-export'       => 'Esporté',
	'translate-magic-cm-to-be'        => 'da esse',
	'translate-magic-cm-current'      => 'Corent',
	'translate-magic-cm-original'     => 'Original',
	'translate-magic-cm-save'         => 'Salvé',
	'translate-magic-cm-updatedusing' => 'Agiornà ën dovrand [[Special:Magic]]',
	'translate-magic-cm-savefailed'   => 'Salvatagi falì',
	'translate-magic-special'         => 'Àlias dle pàgine speciaj',
	'translate-magic-words'           => 'Paròle màgiche',
	'translate-magic-skin'            => 'Nòm dle facie',
	'translate-magic-namespace'       => 'Nòm djë spassi nominaj',
	'translationchanges'              => 'Modìfiche ëd viragi',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'translate'                         => 'ژباړل',
	'translate-talk'                    => 'خبرې اترې',
	'translate-history'                 => 'پېښليک',
	'translate-task-view'               => 'ټول هغه پيغامونه چې دي په',
	'translate-task-untranslated'       => 'ټول هغه ناژباړلي پيغامونه چې دي په',
	'translate-page-task'               => 'زه غواړم چې',
	'translate-page-group'              => 'ډله',
	'translate-page-language'           => 'ژبه',
	'translate-page-limit'              => 'بريد',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|پيغام|پيغامونه}} په يوه مخ کې',
	'translate-submit'                  => 'راغونډول',
	'translate-page-navigation-legend'  => 'ګرځښت',
	'translate-page-description-legend' => 'د ډلې په اړه مالومات',
	'translate-edit-contribute'         => 'ونډه اخيستل',
	'translate-edit-information'        => 'د همدې پيغام په اړه مالومات ($1)',
	'translate-edit-in-other-languages' => 'پيغام په نورو ژبو کې',
	'translate-magic-submit'            => 'راغونډول',
	'translate-magic-cm-current'        => 'اوسنی',
	'translate-magic-cm-original'       => 'آرنی',
	'translate-magic-cm-save'           => 'خوندي کول',
	'translate-magic-words'             => 'کوډګريز وييونه',
	'translationchanges'                => 'د ژباړې بدلونونه',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 * @author Siebrand
 */
$messages['pt'] = array(
	'translate'                         => 'Traduzir',
	'translate-desc'                    => '[[Special:Translate|Página especial]] para traduzir o MediaWiki e mais',
	'translate-edit'                    => 'editar',
	'translate-talk'                    => 'disc',
	'translate-history'                 => 'histórico',
	'translate-task-view'               => 'Ver todas as mensagens de',
	'translate-task-untranslated'       => 'Ver todas as mensagens não traduzidas de',
	'translate-task-optional'           => 'Ver mensagens opcionais de',
	'translate-task-problematic'        => 'Ver mensagens com problemas',
	'translate-task-review'             => 'Rever alterações em',
	'translate-task-reviewall'          => 'Rever todas as traduções em',
	'translate-task-export'             => 'Exportar traduções de',
	'translate-task-export-to-file'     => 'Exportar para ficheiro as traduções de',
	'translate-task-export-as-po'       => 'Exportar tradução em formato Gettext',
	'translate-task-export-to-xliff'    => 'Exportar tradução em formato Xliff',
	'translate-page-no-such-language'   => 'A língua especificada é inválida',
	'translate-page-no-such-task'       => 'A tarefa especificada é inválida',
	'translate-page-no-such-group'      => 'O grupo especificado é inválido.',
	'translate-page-disabled'           => "As traduções para este idioma, neste grupo, foram desabilitadas. Motivo:

''$1''",
	'translate-page-settings-legend'    => 'Configurações',
	'translate-page-task'               => 'Eu desejo',
	'translate-page-group'              => 'Grupo',
	'translate-page-language'           => 'Língua',
	'translate-page-limit'              => 'Limite',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|mensagem|mensagens}} por página',
	'translate-submit'                  => 'Trazer',
	'translate-page-navigation-legend'  => 'Navegação',
	'translate-page-showing'            => 'Exibindo mensagens de $1 a $2 de $3.',
	'translate-page-showing-all'        => 'Exibindo $1 {{PLURAL:$1|mensagem|mensagens}}.',
	'translate-page-showing-none'       => 'Não há mensagens a serem exibidas.',
	'translate-next'                    => 'Página seguinte',
	'translate-prev'                    => 'Página anterior',
	'translate-page-description-legend' => 'Informação sobre o grupo',
	'translate-page-edit'               => 'editar',
	'translate-optional'                => '(opcional)',
	'translate-ignored'                 => '(ignorada)',
	'translate-edit-definition'         => 'Definição da mensagem',
	'translate-edit-contribute'         => 'contribua',
	'translate-edit-no-information'     => "''Esta mensagem ainda não foi documentada. Caso você saiba onde ou como ela é utilizada poderá ajudar outros tradutores adicionando dados sobre esta mensagem.''",
	'translate-edit-information'        => 'Informações sobre esta mensagem ($1)',
	'translate-edit-in-other-languages' => 'Mensagem em outros idiomas',
	'translate-edit-committed'          => 'Tradução actualmente disponível no software',
	'translate-edit-warnings'           => 'Avisos sobre traduções incompletas',
	'translate-magic-pagename'          => 'Tradução extra do MediaWiki',
	'translate-magic-help'              => 'Você pode traduzir alias de páginas especiais, palavras mágicas, nomes de temas (skins) e nomes de espaços nominais.

É necessário incluir os termos em Inglês para as palavras mágicas, ou elas pararão de funcionar. Mantenha também o primeiro item (0 ou 1) da forma como se encontra.

Os alias de páginas especiais e palavras mágicas podem receber múltiplas traduções, separadas por vírgulas (,).
Nomes de temas e espaços nominais podem receber apenas uma tradução.

Nas traduções de espaços nominais a partícula <tt>$1 talk</tt> é especial. <tt>$1</tt> é trocada pelo nome do sítio (por exemplo, <tt>{{SITENAME}} talk</tt>). Se não é possível formar em seu idioma expressões válidas sem mexer com o nome do sítio, por gentileza, procure um desenvolvedor.

É necessário pertencer ao grupo de tradutores para conseguir salvar as alterações.
As alterações não serão salvas até que você clique no botão de salvar.',
	'translate-magic-module'            => 'Módulo:',
	'translate-magic-submit'            => 'Trazer',
	'translate-magic-cm-export'         => 'Exportar',
	'translate-magic-cm-to-be'          => 'Novo',
	'translate-magic-cm-current'        => 'Actual',
	'translate-magic-cm-original'       => 'Original',
	'translate-magic-cm-comment'        => 'Comentário:',
	'translate-magic-cm-save'           => 'Guardar',
	'translate-magic-cm-updatedusing'   => 'Actualizado usando [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => 'Erro ao salvar',
	'translate-magic-special'           => 'Alias de páginas especiais',
	'translate-magic-words'             => 'Palavras mágicas',
	'translate-magic-skin'              => 'Nomes dos temas',
	'translate-magic-namespace'         => 'Nomes de espaços nominais',
	'translationchanges'                => 'Alterações às traduções',
	'translationchanges-export'         => 'exportar',
	'translationchanges-change'         => '$1: $2 por $3',
	'translate-checks-parameters'       => '{{PLURAL:$2|O seguinte parâmetro não é|Os seguintes parâmetros não são usados}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'          => 'Há {{PLURAL:$2|um parênteses irregular|$2 parênteses irregulares}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'            => '{{PLURAL:$2|O seguinte link possui|Os $2 seguintes links possuem}} problemas: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'            => 'Por gentileza, troque {{PLURAL:$2|a seguinte tag pela correta|as seguintes tags pelas corretas}}:
<strong>$1</strong>',
	'translate-checks-plural'           => 'A definição usa <nowiki>{{PLURAL:}}</nowiki>, mas a tradução não.',
	'tog-translate-nonewsletter'        => 'Não me enviar newsletters por e-mail (relevante apenas para utilizadores com um endereço de e-mail confirmado)',
	'right-translate'                   => 'Editar usando a interface de tradução',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'translate-edit'                   => 'arri',
	'translate-talk'                   => 'awal',
	'translate-history'                => 'amzruy',
	'translate-page-navigation-legend' => 'Asari',
	'translate-page-edit'              => 'arri',
);

/** Rhaeto-Romance (Rumantsch)
 * @author SPQRobin
 */
$messages['rm'] = array(
	'translate-edit'    => 'editar',
	'translate-talk'    => 'discussiun',
	'translate-history' => 'versiuns',
	'translate-next'    => 'Proxima pagina',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'translate'                  => 'Traducere',
	'translate-edit'             => 'modifică',
	'translate-history'          => 'istoric',
	'translate-page-group'       => 'Grup',
	'translate-page-language'    => 'Limbă',
	'translate-page-edit'        => 'modifică',
	'translate-magic-cm-comment' => 'Comentariu:',
	'translate-magic-cm-save'    => 'Salvează',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 * @author Ahonc
 * @author Siebrand
 * @author MaxSem
 */
$messages['ru'] = array(
	'translate'                              => 'Перевод',
	'translate-desc'                         => '[[Special:Translate|Служебная страница]] для перевода Mediawiki и прочих программ',
	'translate-edit'                         => 'править',
	'translate-talk'                         => 'обсуждение',
	'translate-history'                      => 'история',
	'translate-task-view'                    => 'Просмотреть все сообщения',
	'translate-task-untranslated'            => 'Просмотреть непереведённые сообщения',
	'translate-task-optional'                => 'Просмотреть необязательные сообщения',
	'translate-task-problematic'             => 'Просмотреть проблемные сообщения',
	'translate-task-review'                  => 'Проверить изменения',
	'translate-task-reviewall'               => 'Проверить все переводы',
	'translate-task-export'                  => 'Выгрузить переводы',
	'translate-task-export-to-file'          => 'Выгрузить переводы в файл',
	'translate-task-export-as-po'            => 'Выгрузить переводы в формате gettext',
	'translate-task-export-to-xliff'         => 'Экспортировать перевод в формате Xliff',
	'translate-page-no-such-language'        => 'Передан неверный код языка',
	'translate-page-no-such-task'            => 'Неверно указана задача.',
	'translate-page-no-such-group'           => 'Неверно указана группа.',
	'translate-page-settings-legend'         => 'Параметры',
	'translate-page-task'                    => 'Я хочу',
	'translate-page-group'                   => 'Группа',
	'translate-page-language'                => 'Язык',
	'translate-page-limit'                   => 'Ограничение',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|сообщение|сообщения|сообщений}} на страницу',
	'translate-submit'                       => 'Вывести',
	'translate-page-navigation-legend'       => 'Навигация',
	'translate-page-showing'                 => 'Выведены сообщения с $1 по $2 из $3.',
	'translate-page-showing-all'             => 'Выведено $1 {{PLURAL:$1|сообщение|сообщения|сообщений}}.',
	'translate-page-showing-none'            => 'Нет сообщений для отображения.',
	'translate-next'                         => 'следующая страница',
	'translate-prev'                         => 'предыдущая страница',
	'translate-page-description-legend'      => 'Информация о группе',
	'translate-page-edit'                    => 'Править',
	'translate-optional'                     => '(необязательное)',
	'translate-ignored'                      => '(игнорируемое)',
	'translate-edit-definition'              => 'Формулировка сообщения',
	'translate-edit-contribute'              => 'править',
	'translate-edit-no-information'          => "''Это сообщение не имеет описания. Если вы знаете, где или как это сообщение используется, то вы можете помочь другим переводчикам, добавив описание к этому сообщению''",
	'translate-edit-information'             => 'Информация об этом сообщении ($1)',
	'translate-edit-in-other-languages'      => 'Сообщение на других языках',
	'translate-edit-committed'               => 'Текущий перевод в программе',
	'translate-edit-warnings'                => 'Предупреждения о неполных переводах',
	'translate-edit-goto-prev'               => 'Править предыдущее сообщение',
	'translate-edit-goto-next'               => 'Править следующее сообщение',
	'translate-magic-pagename'               => 'Углублённый перевод MediaWiki',
	'translate-magic-help'                   => 'Вы можете переводить псевдонимы служебных страниц, магические слова, названия тем оформления и пространств имён.

При редактировании магических слов, желательно оставить английский вариант, иначе он не будет работать. Также стоит оставить первое значение (цифра 0 или 1) таким, какое оно есть.

Псевдонимы служебных страниц и магические слова могут иметь несколько вариантов перевода, они разделяются запятой (,). Названия тем оформления и пространства имён могут иметь только один вариант перевода.

В переводах пространств имён строка «Обсуждение $1» обрабатывается особо, «$1» будет заменено на имя сайта (например «Обсуждение {{SITENAME}}»). Свяжитесь с разработчиками, если подобная грамматическая конструкция неверна для вашего языка.

Чтобы сохранить изменения вы должны входить в группу переводчиков. Изменения не будут сохранены, пока вы не нажмёте кнопку ниже.',
	'translate-magic-module'                 => 'Модуль:',
	'translate-magic-submit'                 => 'Вывести',
	'translate-magic-cm-export'              => 'Выгрузить',
	'translate-magic-cm-to-be'               => 'Должно быть',
	'translate-magic-cm-current'             => 'Текущее',
	'translate-magic-cm-original'            => 'Исходное',
	'translate-magic-cm-comment'             => 'Примечание:',
	'translate-magic-cm-save'                => 'Сохранить',
	'translate-magic-cm-updatedusing'        => 'Обновлено с помощью [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Сохранение не удалось',
	'translate-magic-special'                => 'Псевдонимы служебных страниц',
	'translate-magic-words'                  => 'Магические слова',
	'translate-magic-skin'                   => 'Названия тем оформления',
	'translate-magic-namespace'              => 'Пространства имён',
	'translationchanges'                     => 'Изменения в переводах',
	'translationchanges-export'              => 'выгрузить',
	'translationchanges-change'              => '$1: $2 $3',
	'translate-checks-parameters'            => 'Следующие параметры не используются:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Непарное количество открывающих и закрывающих скобок:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => 'Следующие ссылки вызывают проблемы:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Пожалуйста, исправьте следующие теги:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'Оригинал использует <nowiki>{{PLURAL:}}</nowiki>, а перевод — нет.',
	'tog-translate-nonewsletter'             => 'Не отправлять мне информационный бюллетень по электронной почте (только для участников с подтверждёнными почтовыми адресами)',
	'right-translate'                        => 'правка с использованием интерфейса перевода',
	'translate-rc-translation-filter-only'   => 'Показать только переводы',
	'translate-rc-translation-filter-filter' => 'Скрыть переводы',
	'translate-stats-edits'                  => 'Правок',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 * @author Bert Jickty
 */
$messages['sah'] = array(
	'translate'                   => 'Тылбаас',
	'translate-edit'              => 'көннөрүү',
	'translate-talk'              => 'ырытыы',
	'translate-history'           => 'историята',
	'translate-task-view'         => 'Этиилэрин барытын',
	'translate-task-untranslated' => 'Тылбаастамматах этиилэрин',
	'translate-submit'            => 'Тал',
	'translate-next'              => 'Аныгыскы сирэй',
	'translate-prev'              => 'Иннинээҕи сирэй',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Siebrand
 */
$messages['sk'] = array(
	'translate'                              => 'Preložiť',
	'translate-desc'                         => '[[Special:Translate|Špeciálna stránka]] na preklad MediaWiki a iného',
	'translate-edit'                         => 'upraviť',
	'translate-talk'                         => 'diskusia',
	'translate-history'                      => 'história',
	'translate-task-view'                    => 'Zobraziť všetky správy z',
	'translate-task-untranslated'            => 'Zobraziť všetky nepreložené správy z',
	'translate-task-optional'                => 'Zobraziť voliteľné správy z',
	'translate-task-problematic'             => 'Zobraziť problematické správy',
	'translate-task-review'                  => 'Skontrolovať zmeny v',
	'translate-task-reviewall'               => 'Skontrolovať všetky preklady v',
	'translate-task-export'                  => 'Exportovať preklady z',
	'translate-task-export-to-file'          => 'Exportovať preklad do súboru z',
	'translate-task-export-as-po'            => 'Exportovať preklad vo formáte Gettext z',
	'translate-task-export-to-xliff'         => 'Exportovať preklad vo formáte Xliff',
	'translate-page-no-such-language'        => 'Zadaný jazyk bol neplatný.',
	'translate-page-no-such-task'            => 'Zadaná úloha bola neplatná.',
	'translate-page-no-such-group'           => 'Zadaná skupina bola neplatná.',
	'translate-page-disabled'                => "Preklady v tejto skupine do tohto jazyka boli zakázané. Dôvod:

''$1''",
	'translate-page-settings-legend'         => 'Nastavenia',
	'translate-page-task'                    => 'Chcem',
	'translate-page-group'                   => 'Skupina',
	'translate-page-language'                => 'Jazyk',
	'translate-page-limit'                   => 'Limit',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|správa|správy|správ}} na stránku',
	'translate-submit'                       => 'Vykonať',
	'translate-page-navigation-legend'       => 'Navigácia',
	'translate-page-showing'                 => 'Zobrazujú sa správy od $1 do $2 z $3.',
	'translate-page-showing-all'             => '{{PLURAL:$1|Zobrazuje sa $1 správa|Zobrazujú sa $1 správy|Zobrazuje sa $1 správ}}.',
	'translate-page-showing-none'            => 'Žiadne správy.',
	'translate-next'                         => 'Ďalšia stránka',
	'translate-prev'                         => 'Predošlá stránka',
	'translate-page-description-legend'      => 'Informácie o skupine',
	'translate-page-edit'                    => 'upraviť',
	'translate-optional'                     => '(voliteľné)',
	'translate-ignored'                      => '(ignorované)',
	'translate-edit-definition'              => 'Definícia správy',
	'translate-edit-contribute'              => 'prispejte',
	'translate-edit-no-information'          => "''Táto správa nie je zdokumentovaná. Ak viete kde alebo ako je táto správa použitá, môžete pomôcť ostatným prekladateľom tým, že jej pridáte dokumentáciu.''",
	'translate-edit-information'             => 'Informácie o tejto správe ($1)',
	'translate-edit-in-other-languages'      => 'Správa v iných jazykoch',
	'translate-edit-committed'               => 'Aktuálny preklad v softvéri',
	'translate-edit-warnings'                => 'Upozornenia na neúplné preklady',
	'translate-edit-goto-no-prev'            => 'Žiadna predošlá správa',
	'translate-edit-goto-no-next'            => 'Žiadna ďalšia správa',
	'translate-edit-goto-prev'               => 'Upraviť predošlú správu',
	'translate-edit-goto-next'               => 'Upraviť ďalšiu správu',
	'translate-edit-goto-list'               => 'Späť na zoznam',
	'translate-magic-pagename'               => 'Rozšírený preklad MediaWiki',
	'translate-magic-help'                   => 'Môžete prekladať aliasy špeciálnych stránok, magické slová, názvy tém vzhľadu a názvy menných priestorov.

V magických slovách musíte zahrnúť aj anglické preklady, inak prestanú fungovať. Tiež ponechajte nezmenenú prvú položku (0 alebo 1).

Aliasy špeciálnych stránok a magických slov môžu mať viacero prekladov. Preklady sa oddeľujú čiarkami („,“). Názvy tém vzhľadu a názvy menných priestorov môžu mať iba jeden preklad.

V prekladoch menných priestorov je <tt>$1 talk</tt> špeciálne. <tt>$1</tt> sa nahradí názvom webovej lokality (napr. <tt>{{SITENAME}} talk</tt>). Ak vo vašom jazyku nie je možné vytvoriť zmysluplný výraz bez zmeny názvu webovej lokality, prosím, kontaktujte vývojára.

Aby ste mohli ukladať zmeny, musíte byť členom skupiny translators. Zmeny sa neuložia, kým nekliknete na tlačidlo Uložiť dolu.',
	'translate-magic-module'                 => 'Modul:',
	'translate-magic-submit'                 => 'Vykonať',
	'translate-magic-cm-export'              => 'Exportovať',
	'translate-magic-cm-to-be'               => 'Byť',
	'translate-magic-cm-current'             => 'Aktuálna',
	'translate-magic-cm-original'            => 'Pôvodná',
	'translate-magic-cm-comment'             => 'Komentár:',
	'translate-magic-cm-save'                => 'Uložiť',
	'translate-magic-cm-updatedusing'        => 'Aktualizované pomocou [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Uloženie sa nepodarilo',
	'translate-magic-special'                => 'Aliasy špeciálnych stránok',
	'translate-magic-words'                  => 'Magické slová',
	'translate-magic-skin'                   => 'Názvy tém vzhľadu',
	'translate-magic-namespace'              => 'Názvy menných priestorov',
	'translationchanges'                     => 'Zmeny v preklade',
	'translationchanges-export'              => 'export',
	'translationchanges-change'              => '$1: $2 ($3)',
	'translate-checks-parameters'            => '{{PLURAL:$2|Nasledovný parameter nie je použitý|Nasledovné parametre nie sú použité}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|Nasledovný parameter je neznámy|Nasledovné parametre sú neznáme}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Nevyvážené počty {{PLURAL:$2|zátvoriek|zátvoriek}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|Nasledovný odkaz je problematický|Nasledovné odkazy sú problematické}}: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Prosím, nahraďte {{PLURAL:$2|nasledovnú značku správnou|nasledovné značky správnymi}}: 
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => 'Definícia používa <nowiki>{{PLURAL:}}</nowiki>, ale preklad nie.',
	'translate-checks-pagename'              => 'Oproti definícii sa zmenil menný priestor',
	'tog-translate-nonewsletter'             => 'Neposielať mi novinky emailom (týka sa iba používateľov s potvrdenou emailovou adresou)',
	'right-translate'                        => 'Vykonávať úpravy pomocou rozhrania Preložiť',
	'translate-rc-translation-filter'        => 'Preklady filtrov:',
	'translate-rc-translation-filter-no'     => 'Nevykonávať nič',
	'translate-rc-translation-filter-only'   => 'Iba zobraziť preklady',
	'translate-rc-translation-filter-filter' => 'Vyfiltrovať preklady',
	'translate-rc-translation-filter-site'   => 'Iba zmeny oznamu lokality',
	'translationstats'                       => 'Štatistiky prekladov',
	'translate-stats-edits'                  => 'Úprav za deň',
	'translate-stats-users'                  => 'Prekladatelia',
	'translate-statsf-intro'                 => 'Pomocou tohto formulára môžete tvoriť jednoduché štatistiky. Všetky hodnoty majú hornú a spodnú hranicu.',
	'translate-statsf-options'               => 'Možnosti grafu',
	'translate-statsf-width'                 => 'Šírka v pixeloch',
	'translate-statsf-height'                => 'Výška v pixeloch',
	'translate-statsf-days'                  => 'Časový interval v dňoch',
	'translate-statsf-scale'                 => 'Granularita',
	'translate-statsf-scale-days'            => 'Dni',
	'translate-statsf-scale-hours'           => 'Hodiny',
	'translate-statsf-count'                 => 'Meranie',
	'translate-statsf-count-edits'           => 'Počet úprav',
	'translate-statsf-count-users'           => 'Aktívni prekladatelia',
	'translate-statsf-language'              => 'Čiarkami oddelený zoznam kódov jazykov',
	'translate-statsf-group'                 => 'Čiarkami oddelený zoznam kódov skupín',
	'translate-statsf-submit'                => 'Náhľad',
);

/** Somali (Soomaaliga)
 * @author Mimursal
 */
$messages['so'] = array(
	'translate' => 'Tarjun',
);

/** Albanian (Shqip)
 * @author Dori
 */
$messages['sq'] = array(
	'translate' => 'Përkthime',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'translate'                         => 'Превод',
	'translate-edit'                    => 'уреди',
	'translate-talk'                    => 'разговор',
	'translate-history'                 => 'историја',
	'translate-page-settings-legend'    => 'Подешавања',
	'translate-page-task'               => 'Желим да',
	'translate-page-group'              => 'Група',
	'translate-page-language'           => 'Језик',
	'translate-page-limit'              => 'Граница',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|порука|поруке|порука}} по страни',
	'translate-submit'                  => 'Добави',
	'translate-page-navigation-legend'  => 'Навигација',
	'translate-next'                    => 'Следећа страна',
	'translate-prev'                    => 'Претходна страна',
	'translate-edit-in-other-languages' => 'Порука на другим језицима',
	'translate-magic-cm-export'         => 'Извоз',
	'translate-magic-cm-current'        => 'Тренутно',
	'translate-magic-cm-original'       => 'Оригинал',
	'translate-magic-cm-comment'        => 'Коментар:',
	'translate-magic-cm-save'           => 'Сачувај',
	'translationchanges-export'         => 'извоз',
);

/** latinica (latinica) */
$messages['sr-el'] = array(
	'translate' => 'Prevod',
);

/** Swati (SiSwati)
 * @author MF-Warburg
 * @author Jatrobat
 */
$messages['ss'] = array(
	'translate'         => 'Kuhúmusha',
	'translate-edit'    => 'kúhlela',
	'translate-history' => 'umlandvo',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 * @author Maartenvdbent
 */
$messages['stq'] = array(
	'translate'                     => 'Uursät',
	'translate-edit'                => 'Beoarbaidje',
	'translate-talk'                => 'Diskussion',
	'translate-history'             => 'Versione',
	'translate-task-view'           => 'Wies aal Systemättergjuchte fon',
	'translate-task-untranslated'   => 'Wies aal nit uursätte Systemättergjuchte fon',
	'translate-task-optional'       => 'Bekiek optionoale Ättergjuchte fon',
	'translate-task-review'         => 'Wröigje Annerengen bit',
	'translate-task-reviewall'      => 'Wröigje aal Uursättengen in',
	'translate-task-export'         => 'Exportier aal Uursättengen fon',
	'translate-task-export-to-file' => 'Exportier aal Uursättengen in ne Doatäi fon',
	'translate-submit'              => 'Hoal',
	'translate-next'                => 'Naiste Siede',
	'translate-prev'                => 'Foarige Siede',
	'translate-optional'            => '(optional)',
	'translate-ignored'             => '(ignorierd)',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 * @author Siebrand
 */
$messages['su'] = array(
	'translate'                         => 'Alih basakeun',
	'translate-desc'                    => '[[Special:Translate|Kaca husus]] keur narjamahkeun Mediawiki',
	'translate-edit'                    => 'édit',
	'translate-talk'                    => 'sawala',
	'translate-history'                 => 'Jujutan',
	'translate-task-view'               => 'Tembongkeun kabeh talatah ti',
	'translate-task-untranslated'       => 'Tembongkeun talatah nu acan ditarjamahkeun ti',
	'translate-task-optional'           => 'Tembongkeun talatah piliheun ti',
	'translate-task-review'             => 'Témbongkeun parobahan ti',
	'translate-task-reviewall'          => 'Témbongkeun kabeh parobahan dina',
	'translate-task-export'             => 'Ékspor tarjamahan ti',
	'translate-task-export-to-file'     => 'Ékspor tarjamahan ka koropak ti',
	'translate-task-export-as-po'       => 'Ékspor tarjamahan ka format Gettext ti',
	'translate-page-no-such-language'   => 'Basa anu dipilih teu kaci.',
	'translate-page-no-such-task'       => 'Gaweun anu dipilih teu kaci.',
	'translate-page-no-such-group'      => 'Jumplukan nu dipilih teu kaci.',
	'translate-page-disabled'           => "Narjamahkeun dina basa ieu geus dinon-aktifkeun. Alesana:

''$1''",
	'translate-page-settings-legend'    => 'Pangatur',
	'translate-page-task'               => 'Kuring hayang',
	'translate-page-group'              => 'Jumplukan',
	'translate-page-language'           => 'Basa',
	'translate-page-limit'              => 'Batesan',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|talatah|talatah}} per kaca',
	'translate-submit'                  => 'Kintun',
	'translate-page-navigation-legend'  => 'Pituduh',
	'translate-page-showing'            => 'Tembongan talatah $1 nepi $2 ti $3.',
	'translate-page-showing-all'        => 'Tembongan $1 {{PLURAL:$1|talatah|talatah}}.',
	'translate-page-showing-none'       => 'Teu aya talatah nu tiasa ditembongkeun.',
	'translate-next'                    => 'Kaca salajengna',
	'translate-prev'                    => 'Kaca saméméhna',
	'translate-page-description-legend' => 'Informasi ngeunaan grup',
	'translate-optional'                => '(piliheun)',
	'translate-edit-definition'         => 'Definisi talatah',
	'translate-edit-contribute'         => 'milu ngédit',
	'translate-edit-no-information'     => "''Talatah ieu teu ngabogaan dokuméntasi. Lamun Anjeun nyaho di mana sarta kumaha talatah ieu dipaké, Anjeun bisa nulungan panarjamah séjén kalawan nambahan dokuméntasi pikeun talatah ieu.''",
	'translate-edit-information'        => 'Informasi ngeunaan talatah ieu ($1)',
	'translate-edit-in-other-languages' => 'Talatah dina basa séjén',
	'translate-edit-committed'          => 'Parobahan anu aya di pakakas',
	'translate-edit-warnings'           => 'Panginget ngeunaan tarjamahan anu teu pepek',
	'translate-magic-pagename'          => 'Landian tarjamahan Mediawiki',
	'translate-magic-help'              => "Anjeun bisa narjamahkuen landian pikeun kaca husus, kecap magis, ngaran kulit, sarta ngaran ''ngaranspasi''.

Pikeun kecap magis, Anjeun perlu nyantumkeun ogé tarjamahan basa Inggris atawa baris lumangsung kasalahan. Ogé tetep nyantumkeun item kahiji (0 atawa 1) kitu waé.

Landian pikeun halaman husus sarta kecap magis bisa ngabogaan leuwih ti hiji tarjamahan anu lainna dipisahkan ku koma (,). Ngaran kulit sarta ngaranspasi ngan bisa ngabogaan hiji tarjamahan.

Dina tarjamahan ngaranspasi <tt>$1 talk</tt> diperlakukan husus. <tt>$1</tt>  digantikeun kalawan ngaran loka (contona {{SITENAME}} talk).
Lamun basa Anjeun henteu matak bisa pikeun nyieun hiji ekspresi anu valid tanpa ngaganti ngaran loka, sumangga kontak salah saurang pengembang.

Anjeun perlu jadi anggota grup panarjamah pikeun nyimpen parobahan. Parobahan moal disimpen nepi ka Anjeun ngaklik tombol simpen di handapeun.",
	'translate-magic-submit'            => 'Kintun',
	'translate-magic-cm-export'         => 'Ekspor',
	'translate-magic-cm-to-be'          => 'Jadina',
	'translate-magic-cm-current'        => 'Kiwari',
	'translate-magic-cm-comment'        => 'Kamandang:',
	'translate-magic-cm-save'           => 'Simpen',
	'translate-magic-cm-updatedusing'   => 'Dirobah ngagunakeun [[Special:Magic]]',
	'translate-magic-special'           => 'Landian kaca husus',
	'translate-magic-words'             => 'Kecap magis',
	'translate-magic-skin'              => 'Ngaran kulit',
	'translate-magic-namespace'         => 'Ngaran ngaranspasi',
	'translationchanges'                => 'Parobahan tarjamahan',
	'translationchanges-change'         => '$1: $2 ku $3',
	'translate-checks-xhtml'            => 'Sok ganti tag-tag ieu kalawan tag anu pas:<strong>$1</strong>',
	'right-translate'                   => 'Édit migunakeun antarmuka panarjamah',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author Sannab
 * @author M.M.S.
 * @author Siebrand
 * @author Boivie
 */
$messages['sv'] = array(
	'translate'                              => 'Översätt',
	'translate-desc'                         => '[[Special:Translate|Specialsida]] för översättning av Mediawiki och annat',
	'translate-edit'                         => 'redigera',
	'translate-talk'                         => 'diskussion',
	'translate-history'                      => 'historik',
	'translate-task-view'                    => 'se alla meddelanden från',
	'translate-task-untranslated'            => 'se alla oöversatta meddelanden från',
	'translate-task-optional'                => 'se valfria systemmeddelanden från',
	'translate-task-problematic'             => 'visa meddelanden som har problem',
	'translate-task-review'                  => 'granska ändringar av',
	'translate-task-reviewall'               => 'granska alla översättningar av',
	'translate-task-export'                  => 'exportera översättningar från',
	'translate-task-export-to-file'          => 'exportera översättningar till fil från',
	'translate-task-export-as-po'            => 'exportera översättningar i Gettext-format från',
	'translate-task-export-to-xliff'         => 'exportera översättningar i Xliff-format',
	'translate-page-no-such-language'        => 'Det angivna språket är inte giltigt.',
	'translate-page-no-such-task'            => 'Den angivna åtgärden är inte giltig.',
	'translate-page-no-such-group'           => 'Den angivna gruppen är inte giltig.',
	'translate-page-disabled'                => "Översättningar till det här språket i den här gruppen har stängts av. Anledning:

''$1''",
	'translate-page-settings-legend'         => 'Inställningar',
	'translate-page-task'                    => 'Jag vill',
	'translate-page-group'                   => 'Grupp',
	'translate-page-language'                => 'Språk',
	'translate-page-limit'                   => 'Antal',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|meddelande|meddelanden}} per sida',
	'translate-submit'                       => 'Hämta',
	'translate-page-navigation-legend'       => 'Navigering',
	'translate-page-showing'                 => 'Visar meddelande $1 till $2 av $3.',
	'translate-page-showing-all'             => 'Visar $1 {{PLURAL:$1|meddelande|meddelanden}}.',
	'translate-page-showing-none'            => 'Det finns inga meddelanden att visa.',
	'translate-next'                         => 'Nästa sida',
	'translate-prev'                         => 'Föregående sida',
	'translate-page-description-legend'      => 'Information om gruppen',
	'translate-page-edit'                    => 'redigera',
	'translate-optional'                     => '(valfritt)',
	'translate-ignored'                      => '(används ej)',
	'translate-edit-definition'              => 'Definition av meddelandet',
	'translate-edit-contribute'              => 'bidra',
	'translate-edit-no-information'          => "''Det här meddelandet har ingen dokumentation. Om du vet var eller hur detta meddelande används, så kan du hjälpa andra översättare genom att skriva dokumentation för meddelandet.''",
	'translate-edit-information'             => 'Information om detta meddelande ($1)',
	'translate-edit-in-other-languages'      => 'Meddelandet på andra språk',
	'translate-edit-committed'               => 'Nuvarande översättning i mjukvaran',
	'translate-edit-warnings'                => 'Varningar om fel i översättningen',
	'translate-edit-goto-no-prev'            => 'Inget föregående meddelande',
	'translate-edit-goto-no-next'            => 'Inget nästa meddelande',
	'translate-edit-goto-prev'               => 'Redigera föregående meddelande',
	'translate-edit-goto-next'               => 'Redigera nästa meddelande',
	'translate-edit-goto-list'               => 'Tillbaka till listan',
	'translate-magic-pagename'               => 'Utökad MediaWiki-översättning',
	'translate-magic-help'                   => 'Du kan översätta alias för specialsidor, magiska ord, skin-namn och namnrymdsnamn.

För magiska ord så måste du inkludera engelska översättningar eller så slutar de att fungera. Lämna också det första (0 eller 1) som det är.

Alias för specialsidor och magiska ord kan ha flera översättningar. Översättningar skiljs åt av ett komma (,). Skin-namn och namnrymder kan enbart ha en översättning.

Vid översättning av namnrymder så är <tt>$1 talk</tt> speciellt. <tt>$1</tt> ersätts med webbplatsens namn (till exempel <tt>{{SITENAME}} talk</tt>). Om det inte är möjligt att skapa en giltig översättning till ditt språk utan att ändra webbplatsens namn, så ta kontakt med en utvecklare.

För att kunna spara ändringar så behöver du tillhöra översättargruppen. Ändringar sparas inte förrän du klickar på spara-knappen nedan.',
	'translate-magic-module'                 => 'Modul:',
	'translate-magic-submit'                 => 'Hämta',
	'translate-magic-cm-export'              => 'Exportera',
	'translate-magic-cm-to-be'               => 'Att-bli',
	'translate-magic-cm-current'             => 'Nuvarande',
	'translate-magic-cm-original'            => 'Original',
	'translate-magic-cm-comment'             => 'Kommentar:',
	'translate-magic-cm-save'                => 'Spara',
	'translate-magic-cm-updatedusing'        => 'Uppdaterad med hjälp av [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Det gick ej att spara',
	'translate-magic-special'                => 'Alias till specialsidor',
	'translate-magic-words'                  => 'Magiska ord',
	'translate-magic-skin'                   => 'Skin-namn',
	'translate-magic-namespace'              => 'Namnrymdsnamn',
	'translationchanges'                     => 'Ändrade översättningar',
	'translationchanges-export'              => 'exportera',
	'translationchanges-change'              => '$1: $2 av $3',
	'translate-checks-parameters'            => 'Följande {{PLURAL:$2|parameter|parametrar}} används inte: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => 'Följande {{PLURAL:$2|parameter är okänd|parametrar är okända}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Det är ett ojämnt antal parenteser:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => 'Följande {{PLURAL:$2|länk|länkar}} är problematiska: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'                 => 'Följande felaktiga {{PLURAL:$2|tagg|taggar}} bör ersättas: <strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'                => '<nowiki>{{PLURAL:}}</nowiki> används i definitionen, men inte i översättningen.',
	'translate-checks-pagename'              => 'Namnrymden ändrad från definitionen',
	'tog-translate-nonewsletter'             => 'Sänd mig inte nyhetsbrev (gäller endast användare med bekräftad e-postadress)',
	'right-translate'                        => 'Redigera genom översättningsgränssnittet',
	'translate-rc-translation-filter'        => 'Filtrera översättningar:',
	'translate-rc-translation-filter-no'     => 'Gör ingenting',
	'translate-rc-translation-filter-only'   => 'Visa endast översättningar',
	'translate-rc-translation-filter-filter' => 'Filtrera bort översättningar',
	'translate-rc-translation-filter-site'   => 'Endast ändringar till {{SITENAME}}-meddelanden',
	'translationstats'                       => 'Översättningsstatistik',
	'translate-stats-edits'                  => 'Redigeringar per dag',
	'translate-stats-users'                  => 'Översättare',
	'translate-statsf-intro'                 => 'Du kan generera enkel statistik genom detta formulär. Alla värden ska ha övre och nedre gränser.',
	'translate-statsf-options'               => 'Diagramalternativ',
	'translate-statsf-width'                 => 'Bredd i pixlar',
	'translate-statsf-height'                => 'Höjd i pixlar',
	'translate-statsf-days'                  => 'Tidsperiod i dagar',
	'translate-statsf-scale'                 => 'Kornighet',
	'translate-statsf-scale-days'            => 'Dagar',
	'translate-statsf-scale-hours'           => 'Timmar',
	'translate-statsf-count'                 => 'Storlek',
	'translate-statsf-count-edits'           => 'Antal redigeringar',
	'translate-statsf-count-users'           => 'Aktiva översättare',
	'translate-statsf-language'              => 'Kommaseparerad lista över språkkoder',
	'translate-statsf-group'                 => 'Kommaseparerad lista över gruppkoder',
	'translate-statsf-submit'                => 'Förhandsgranska',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 * @author Pimke
 */
$messages['szl'] = array(
	'translate-edit'    => 'sprowjéj',
	'translate-history' => 'historjo',
	'translate-next'    => 'Nostympno zajta',
	'translate-prev'    => 'Popředńo zajta',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'translate'                       => 'மொழிப்பெயர்ப்பு',
	'translate-edit'                  => 'தொகு',
	'translate-talk'                  => 'உரையாடல்',
	'translate-history'               => 'வரலாறு',
	'translate-page-no-such-language' => 'குறித்த மொழி செல்லுபடியற்றதாகும்.',
	'translate-page-language'         => 'மொழி',
	'translate-next'                  => 'அடுத்தப் பக்கம்',
	'translate-prev'                  => 'முந்தைய பக்கம்',
	'translate-magic-cm-save'         => 'பக்கத்தை சேமி',
	'translate-magic-cm-savefailed'   => 'சேமிப்பு தோல்வி',
	'translationchanges-export'       => 'ஏற்றுமதி',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'translate'                            => 'అనువదించు',
	'translate-desc'                       => 'మీడియావికీ మరియు ఆపైవాటిని అనువదించడానికి [[Special:Translate|ప్రత్యేక పేజీ]]',
	'translate-edit'                       => 'మార్చు',
	'translate-talk'                       => 'చర్చ',
	'translate-history'                    => 'చరిత్ర',
	'translate-task-view'                  => 'అన్ని సందేశాలు చూడాలనుకుంటున్నాను',
	'translate-task-untranslated'          => 'అన్ని అనువాదంకాని సందేశాలు చూడాలనుకుంటున్నాను',
	'translate-task-optional'              => 'ఐచ్చిక సందేశాలు చూడాలనుకుంటున్నాను',
	'translate-task-review'                => 'మార్పులని సమీక్షించాలనుకుంటున్నాను',
	'translate-task-reviewall'             => 'అన్ని అనువాదాలనూ సమీక్షించాలనుకుంటున్నాను',
	'translate-task-export'                => 'అనువాదాలని ఎగుమతి చేయాలి',
	'translate-page-no-such-language'      => 'ఎంచుకున్న భాష సరైనది కాదు.',
	'translate-page-no-such-task'          => 'ఎంచుకున్న పని సరైనది కాదు.',
	'translate-page-no-such-group'         => 'ఇచ్చిన సమూహం సరైనది కాదు.',
	'translate-page-settings-legend'       => 'అమరికలు',
	'translate-page-task'                  => 'నేను',
	'translate-page-group'                 => 'సమూహం',
	'translate-page-language'              => 'భాష',
	'translate-page-limit'                 => 'పరిమితి',
	'translate-page-limit-option'          => 'పేజీకి $1 {{PLURAL:$1|సందేశం|సందేశాలు}}',
	'translate-submit'                     => 'తీసుకురా',
	'translate-page-navigation-legend'     => 'మార్గదర్శకం',
	'translate-page-showing'               => 'మొత్తం $3 సందేశాల్లో $1 నుండి $2 వరకు చూపిస్తున్నాం.',
	'translate-page-showing-all'           => '$1 {{PLURAL:$1|సందేశాన్ని|సందేశాలను}} చూపిస్తున్నాం.',
	'translate-page-showing-none'          => 'ఇంక సందేశాలేమీ లేవు.',
	'translate-next'                       => 'తర్వాతి పేజీ',
	'translate-prev'                       => 'క్రితం పేజీ',
	'translate-page-description-legend'    => 'ఈ సమూహం గురించిన సమాచారం',
	'translate-optional'                   => '(ఐచ్ఛికం)',
	'translate-ignored'                    => '(ఉపేక్షించినది)',
	'translate-edit-definition'            => 'సందేశ నిర్వచనం',
	'translate-edit-no-information'        => "''ఈ సందేశానికి సహాయ సమాచారం లేదు. ఈ సందేశాన్ని ఎక్కడ లేదా ఎలా ఉపయోగిస్తారో మీకు తెలిస్తే, దీనికి తగిన సమాచారం చేర్చి ఇతర అనువాదకులకు తొడ్పడవచ్చు.''",
	'translate-edit-information'           => 'ఈ సందేశం గురించి సమాచారం ($1)',
	'translate-edit-in-other-languages'    => 'ఇతర భాషలలోని సందేశాలు',
	'translate-edit-committed'             => 'సాఫ్ట్&zwnj;వేర్&zwnj;లో ప్రస్తుతమున్న అనువాదం',
	'translate-edit-warnings'              => 'అసంపూర్తి అనువాదాల గురించి హెచ్చరికలు',
	'translate-edit-goto-no-prev'          => 'గత సందేశాలేమీ లేవు',
	'translate-edit-goto-no-next'          => 'తర్వాత సందేశాలు లేవు',
	'translate-edit-goto-prev'             => 'గత సందేశానికి',
	'translate-edit-goto-next'             => 'తర్వాతి సందేశానికి',
	'translate-edit-goto-list'             => 'తిరిగి జాబితాకి',
	'translate-magic-submit'               => 'తీసుకురా',
	'translate-magic-cm-export'            => 'ఎగుమతి చేయండి',
	'translate-magic-cm-current'           => 'ప్రస్తుత',
	'translate-magic-cm-original'          => 'అసలు',
	'translate-magic-cm-comment'           => 'వ్యాఖ్య:',
	'translate-magic-cm-save'              => 'భద్రపరచు',
	'translate-magic-special'              => 'ప్రత్యేక పేజీల మారుపేర్లు',
	'translate-magic-words'                => 'మాయా పదాలు',
	'translationchanges'                   => 'అనువాద మార్పులు',
	'translationchanges-export'            => 'ఎగుమతించు',
	'translationchanges-change'            => '$1: $3 చే $2',
	'translate-checks-parameters'          => 'ఈ {{PLURAL:$2|పారామీటరుని|పారామీటర్లని}} వాడనేలేదు:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'  => 'ఈ {{PLURAL:$2|పారామీటరు|పారామీటర్లు}} తెలియనివి:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'             => 'బ్రాకెట్లు సరి సంఖ్యలో లేవు: <strong>$1</strong>',
	'translate-checks-links'               => 'ఈ {{PLURAL:$2|లింకు సమస్యాత్మకంగా ఉంది|$2 లింకులు సమస్యాత్మకంగా ఉన్నాయి}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'               => 'ఈ {{PLURAL:$2|టాగుని సరైన దానితో|టాగులని సరైన వాటితో}} మార్చండి:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'              => 'అసలు సందేశంలో <nowiki>{{PLURAL:}}</nowiki> అనివుంది కానీ అనువాదంలో లేదు.',
	'translate-rc-translation-filter'      => 'అనువాదాల పడపోత:',
	'translate-rc-translation-filter-only' => 'అనువాదాలు మాత్రమే చూపించు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'translate'                         => 'Tradús',
	'translate-edit'                    => 'edita',
	'translate-talk'                    => 'diskusaun',
	'translate-history'                 => 'istória',
	'translate-task-view'               => 'Haree mensajen hotu husi',
	'translate-page-task'               => "Ha'u hakarak",
	'translate-page-group'              => 'Lubu',
	'translate-page-language'           => 'Lian',
	'translate-submit'                  => 'Hola',
	'translate-page-showing-all'        => 'Dalan $1 mensajen.',
	'translate-next'                    => 'Pájina oinmai',
	'translate-page-description-legend' => 'Informasaun kona-ba lubu',
	'translate-edit-in-other-languages' => 'Mensajen iha lian seluk',
	'translate-magic-submit'            => 'Hola',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 * @author Siebrand
 */
$messages['tg-cyrl'] = array(
	'translate'                         => 'Тарҷума',
	'translate-desc'                    => '[[Special:Translate|Саҳифаи вижа]] барои тарҷумаи МедиаВики ва бартар аз он',
	'translate-edit'                    => 'вироиш',
	'translate-talk'                    => 'баҳс',
	'translate-history'                 => 'таърих',
	'translate-task-view'               => 'Намоиши тамоми пайғомҳо аз',
	'translate-task-untranslated'       => 'Намоиши тамоми пайғомҳои тарҷуманашуда аз',
	'translate-task-optional'           => 'Намоиши пайғомҳои ихтиёрӣ аз',
	'translate-task-review'             => 'Бозбинии тағйирот',
	'translate-task-reviewall'          => 'Бозбинии тамоми тарҷумаҳо дар',
	'translate-task-export'             => 'Судури тарҷумаҳо аз',
	'translate-task-export-to-file'     => 'Судури тарҷумаҳо ба як парванда аз',
	'translate-task-export-as-po'       => 'Судури тарҷумаҳо дар қолаби Gettext',
	'translate-page-no-such-language'   => 'Забони мушаххасшуда ғайримиҷоз аст.',
	'translate-page-no-such-task'       => 'Амали мушаххасшуда ғайримиҷоз аст.',
	'translate-page-no-such-group'      => 'Гурӯҳи мушаххасшуда ғайримиҷоз аст.',
	'translate-page-settings-legend'    => 'Танзимот',
	'translate-page-task'               => 'Ман мехоҳам',
	'translate-page-group'              => 'Гурӯҳ',
	'translate-page-language'           => 'Забон',
	'translate-page-limit'              => 'Ҳудуд',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|пайғом|пайғомҳо}} дар ҳар саҳифа',
	'translate-submit'                  => 'Вокашидан',
	'translate-page-navigation-legend'  => 'Гаштан',
	'translate-page-showing'            => 'Намоиши пайғомҳои $3 аз $1 то $2.',
	'translate-page-showing-all'        => 'Намоиши $1 {{PLURAL:$1|пайғом|пайғомҳо}}.',
	'translate-page-showing-none'       => 'Пайғоме барои намоиши вуҷуд надорад.',
	'translate-next'                    => 'Саҳифаи баъдӣ',
	'translate-prev'                    => 'Саҳифаи қаблӣ',
	'translate-page-description-legend' => 'Иттилоот дар бораи гурӯҳ',
	'translate-optional'                => '(ихтиёрӣ)',
	'translate-ignored'                 => '(нодида гирифташуда)',
	'translate-edit-definition'         => 'Таърифи пайғом',
	'translate-edit-contribute'         => 'ҳиссагузорӣ',
	'translate-edit-no-information'     => "''Ин пайғом дорои тавзеҳот нест. 
Агар шумо медонед ин пағом чигуна ё дар куҷо истифода мешавад, шумо метавонед бо изофа кардани тавзеҳот ба ин пайғом ба дигар тарҷумакунандагон кӯмак кунед.''",
	'translate-edit-information'        => 'Иттилоот дар мавриди ин пайғом ($1)',
	'translate-edit-in-other-languages' => 'Ҳамин пайғом дар дигар забонҳо',
	'translate-edit-committed'          => 'Тарҷумаи феълӣ дар нармафзор',
	'translate-edit-warnings'           => 'Ҳушдор дар мавриди тарҷумаҳои нокомил',
	'translate-magic-pagename'          => 'Тарҷумаи густаришёфтаи МедиаВики',
	'translate-magic-submit'            => 'Вокашидан',
	'translate-magic-cm-export'         => 'Судур',
	'translate-magic-cm-to-be'          => 'Будан',
	'translate-magic-cm-current'        => 'Кунунӣ',
	'translate-magic-cm-original'       => 'Аслӣ',
	'translate-magic-cm-comment'        => 'Тавзеҳот:',
	'translate-magic-cm-save'           => 'Захира',
	'translate-magic-cm-updatedusing'   => 'Барӯз шуд тавассути [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => 'Шикаст дар захира кардан',
	'translate-magic-words'             => 'Калимаҳои ҷодуӣ',
	'translate-magic-skin'              => 'Исми пӯстаҳо',
	'translate-magic-namespace'         => 'Исми фазоҳои ном',
	'translationchanges'                => 'Тағйироти тарҷума',
	'translationchanges-export'         => 'судур',
	'translationchanges-change'         => '$1: $2 аз тарафи $3',
	'translate-checks-parameters'       => 'Параметрҳои зерин истифода нашудаанд: <strong>$1</strong>',
);

/** Thai (ไทย)
 * @author Ans
 * @author Passawuth
 * @author Siebrand
 */
$messages['th'] = array(
	'translate'                              => 'แปล',
	'translate-desc'                         => '[[Special:Translate|หน้าพิเศษ]]สำหรับแปลมีเดียวิกิและอื่น ๆ',
	'translate-edit'                         => 'แก้ไข',
	'translate-talk'                         => 'พูดคุย',
	'translate-history'                      => 'ประวัติ',
	'translate-task-view'                    => 'ดูข้อความทั้งหมด จาก',
	'translate-task-untranslated'            => 'ดูข้อความทั้งหมดที่ยังไม่ได้แปล จาก',
	'translate-task-optional'                => 'ดูข้อความที่สามารถเลือกได้จาก',
	'translate-task-problematic'             => 'ดูข้อความที่มีปัญหา',
	'translate-task-review'                  => 'ตรวจดูสิ่งที่เปลี่ยนแปลง ใน',
	'translate-task-reviewall'               => 'ตรวจดูข้อความทั้งหมดที่แปลแล้ว ใน',
	'translate-task-export'                  => 'ส่งงานแปลออกมา (export) จาก',
	'translate-task-export-to-file'          => 'ส่งงานแปลออกมา (export) เป็นไฟล์ จาก',
	'translate-task-export-as-po'            => 'ส่งงานแปลออกมา (export) ในรูปแบบ Gettext จาก',
	'translate-page-no-such-language'        => 'ใส่รหัสภาษา (language) ไม่ถูกต้อง',
	'translate-page-no-such-task'            => 'ใส่ชื่อ task ไม่ถูกต้อง',
	'translate-page-no-such-group'           => 'ใส่ชื่อกลุ่ม (group) ไม่ถูกต้อง',
	'translate-page-settings-legend'         => 'กำหนดค่า',
	'translate-page-task'                    => 'ต้องการ',
	'translate-page-group'                   => 'กลุ่มของ',
	'translate-page-language'                => 'ภาษา',
	'translate-page-limit'                   => 'ไม่เกิน',
	'translate-page-limit-option'            => '$1 ข้อความต่อหน้า',
	'translate-submit'                       => 'ดึงข้อมูล',
	'translate-page-navigation-legend'       => 'แถบนำทาง',
	'translate-page-showing'                 => 'แสดงตั้งแต่ข้อความที่ $1 ถึง $2 จากทั้งหมด $3 ข้อความ',
	'translate-page-showing-all'             => 'แสดง $1 ข้อความ',
	'translate-page-showing-none'            => 'ไม่มีข้อความแสดง',
	'translate-next'                         => 'หน้าถัดไป',
	'translate-prev'                         => 'หน้าก่อน',
	'translate-page-description-legend'      => 'ข้อมูลเกี่ยวกับกลุ่มข้อความ',
	'translate-page-edit'                    => 'แก้ไข',
	'translate-optional'                     => '(สามารถเลือกได้)',
	'translate-ignored'                      => '(เพิกเฉย)',
	'translate-edit-definition'              => 'นิยามข้อความ',
	'translate-edit-contribute'              => 'ช่วยเขียน',
	'translate-edit-no-information'          => "''ข้อความนี้ไม่มีคำอธิบายการใช้งาน.  ถ้าคุณทราบว่าข้อความนี้ใช้ตรงส่วนไหนหรือใช้อย่างไร, คุณสามารถช่วยเพิ่มคำอธิบายการใช้งานของข้อความนี้ เพื่อเป็นประโยชน์แก่ผู้แปลคนอื่นๆ ได้.''",
	'translate-edit-information'             => 'ข้อมูลเกี่ยวกับข้อความนี้ ($1)',
	'translate-edit-in-other-languages'      => 'ข้อความนี้ในภาษาอื่นๆ',
	'translate-edit-committed'               => 'ข้อความแปลที่ฝังอยู่ในตัวโปรแกรม',
	'translate-edit-warnings'                => 'คำเตือนเกี่ยวกับงานแปลที่ยังไม่เสร็จสมบูรณ์',
	'translate-edit-goto-no-prev'            => 'ไม่มีข้อความก่อนหน้านี้',
	'translate-edit-goto-no-next'            => 'ไม่มีข้อความถัดไป',
	'translate-edit-goto-prev'               => 'แก้ไขข้อความก่อนหน้านี้',
	'translate-edit-goto-next'               => 'แก้ไขข้อความถัดไป',
	'translate-edit-goto-list'               => 'กลับไปที่รายชื่อ',
	'translate-magic-pagename'               => 'ส่วนขยายการแปลในมีเดียวิกิ',
	'translate-magic-help'                   => 'คุณสามารถแปลชื่อหน้าพิเศษต่าง ๆ, ตัวแปรพิเศษ, ชื่อแบบหน้าตา และ ชื่อเนมสเปซ

ในตัวแปรพิเศษ กรุณาใส่คำแปลภาษาอังกฤษไปด้วยเช่นเดียวกัน มิฉะนั้นมันจะหยุดทำงาน กรุณาเว้นอันแรก (0 หรือ 1) อย่างที่มันเป็น

ชื่อหน้าพิเศษและตัวแปรพิเศษสามารถมีคำแปลได้หลายอย่าง 
คำแปลจะแยกโดยการใช้ จุลภาค (,) 
ชื่อแบบหน้าตาและเนมสเปซสามารถมีคำแปลได้แค่คำเดียว

ในคำแปลชื่อเนมสเปซ <tt>คุยเรื่อง$1</tt> ต้องระวังเป็นพิเศษ <tt>$1</tt> จะถูกแทนที่โดยชื่อเว็บไซต์ (เช่น <tt>คุยเรื่อง{{SITENAME}}</tt>) 
ถ้าไม่สามารถกระทำการดังกล่าวได้ในภาษาของคุณ, กรุณาติดต่อผู้ดูแลระบบขั้นสูง

คุณต้องอยู่ในกลุ่มคนแปลเพื่อที่จะบันทึกข้อมูลได้ 
ข้อมูลจะไม่ถูกบันทึกตราบใดที่คุณยังไม่กด "บันทึก"',
	'translate-magic-module'                 => 'โมดูล:',
	'translate-magic-submit'                 => 'ดึงข้อมูล',
	'translate-magic-cm-export'              => 'ส่งออกมา (export)',
	'translate-magic-cm-to-be'               => 'แก้เป็น',
	'translate-magic-cm-current'             => 'ปัจจุบัน',
	'translate-magic-cm-original'            => 'ต้นฉบับ',
	'translate-magic-cm-comment'             => 'หมายเหตุ:',
	'translate-magic-cm-save'                => 'บันทึก',
	'translate-magic-cm-updatedusing'        => 'แก้ไขด้วย [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'บันทึกไม่สำเร็จ',
	'translate-magic-special'                => 'ชื่อ alias ของหน้าพิเศษ',
	'translate-magic-words'                  => 'ตัวแปรพิเศษ',
	'translate-magic-skin'                   => 'ชื่อแบบหน้าตา',
	'translate-magic-namespace'              => 'ชื่อเนมสเปซ',
	'translationchanges'                     => 'สิ่งที่เปลี่ยนแปลงในงานแปล',
	'translationchanges-export'              => 'ส่งออกมา (export)',
	'translationchanges-change'              => '$1: $2 โดย $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|ตัวแปร|ตัวแปร}}ต่อไปนี้ไม่ได้รับการใช้งาน: <strong>$1</strong>',
	'translate-checks-balance'               => 'จับคู่วงเล็บไม่ครบคู่: <strong>$1</strong>',
	'translate-checks-links'                 => 'ลิงก์ต่อไปนี้ทำให้เกิดปัญหา: <strong>$1</strong>',
	'translate-checks-xhtml'                 => 'tag เหล่านี้ไม่ถูกต้อง กรุณาแก้ไขโดยใช้ tag ที่ถูกต้อง: <strong>$1</strong>',
	'translate-checks-plural'                => 'ข้อความต้นฉบับใช้ <nowiki>{{PLURAL:}}</nowiki> ในขณะที่ข้อความที่แปลแล้วไม่ได้ใช้',
	'translate-rc-translation-filter'        => 'ที่กรองการแปล:',
	'translate-rc-translation-filter-no'     => 'ไม่ทำอะไรทั้งสิ้น',
	'translate-rc-translation-filter-only'   => 'แสดงงานแปลเท่านั้น',
	'translate-rc-translation-filter-filter' => 'เอางานแปลออก',
	'translate-stats-edits'                  => 'การแก้ไขต่อหนึ่งวัน',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Srhat
 */
$messages['tr'] = array(
	'translate'                      => 'Çeviri',
	'translate-edit'                 => 'Değiştir',
	'translate-talk'                 => 'tartışma',
	'translate-history'              => 'Geçmiş',
	'translate-page-settings-legend' => 'Ayarlar',
	'translate-page-task'            => 'Seç',
	'translate-page-group'           => 'Grup',
	'translate-page-language'        => 'Dil',
	'translate-page-limit'           => 'Sınır',
	'translate-submit'               => 'Getir',
	'translate-next'                 => 'İleri',
	'translate-prev'                 => 'Geri',
	'translate-optional'             => '(isteğe bağlı)',
	'translate-ignored'              => '(yok sayılan)',
	'translate-edit-contribute'      => 'Katkıda bulun',
	'translate-magic-submit'         => 'Getir',
	'translate-magic-cm-to-be'       => 'Yap',
	'translate-magic-cm-current'     => 'Güncelle',
	'translate-magic-cm-original'    => 'Orjinal',
	'translate-magic-cm-comment'     => 'Açıklama :',
	'translate-magic-cm-save'        => 'Kaydet',
);

/** Tatar (Cyrillic) (Tatarça/Татарча (Cyrillic))
 * @author Himiq Dzyu
 */
$messages['tt-cyrl'] = array(
	'translate'      => 'Тәрҗемә',
	'translate-desc' => '[[Special:Translate|Махсус бит]] MediaWiki һәм башка программлар тәрҗемә итү өчен',
	'translate-edit' => 'үзгәртү',
);

/** Uighur (Uyghurche‎ / ئۇيغۇرچە)
 * @author SPQRobin
 */
$messages['ug'] = array(
	'translate-edit'    => 'uzgartish',
	'translate-talk'    => 'monazire',
	'translate-history' => 'tarih',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author AS
 * @author Siebrand
 */
$messages['uk'] = array(
	'translate'                              => 'Переклад',
	'translate-desc'                         => '[[Special:Translate|Спеціальна сторінка]] для перекладу Mediawiki та інших програм',
	'translate-edit'                         => 'редагувати',
	'translate-talk'                         => 'обговорення',
	'translate-history'                      => 'історія',
	'translate-task-view'                    => 'Переглянути всі повідомлення',
	'translate-task-untranslated'            => 'Переглянути неперекладені повідомлення',
	'translate-task-optional'                => "Переглянути необов'язкові повідомлення",
	'translate-task-problematic'             => 'Переглянути проблемні повідомлення',
	'translate-task-review'                  => 'Перевірити зміни',
	'translate-task-reviewall'               => 'Перевірити всі переклади',
	'translate-task-export'                  => 'Експортувати переклади',
	'translate-task-export-to-file'          => 'Експортувати переклади до файлу',
	'translate-task-export-as-po'            => 'Експортувати переклади у форматі gettext',
	'translate-task-export-to-xliff'         => 'Експортувати переклад у форматі Xliff',
	'translate-page-no-such-language'        => 'Зазначена неправильна мова.',
	'translate-page-no-such-task'            => 'Зазначене неправильне завдання.',
	'translate-page-no-such-group'           => 'Зазначена неправильна група.',
	'translate-page-disabled'                => "Переклади на цю мову в цій групі вимкнені. Причина:

''$1''",
	'translate-page-settings-legend'         => 'Параметри',
	'translate-page-task'                    => 'Я хочу',
	'translate-page-group'                   => 'Група',
	'translate-page-language'                => 'Мова',
	'translate-page-limit'                   => 'Обмеження',
	'translate-page-limit-option'            => '$1 {{PLURAL:$1|повідомлення|повідомлення|повідомлень}} на сторінку',
	'translate-submit'                       => 'Вивести',
	'translate-page-navigation-legend'       => 'Навігація',
	'translate-page-showing'                 => 'Показані повідомлення з $1 по $2 із $3.',
	'translate-page-showing-all'             => '{{PLURAL:$1|Показане $1 повідомлення|Показані $1 повідомлення|Показані $1 повідомлень}}.',
	'translate-page-showing-none'            => 'Нема повідомлень для відображення.',
	'translate-next'                         => 'наступна сторінка',
	'translate-prev'                         => 'попередня сторінка',
	'translate-page-description-legend'      => 'Інформація про групу',
	'translate-page-edit'                    => 'редагувати',
	'translate-optional'                     => "(необов'язкове)",
	'translate-ignored'                      => '(ігнорується)',
	'translate-edit-definition'              => 'Текст повідомлення',
	'translate-edit-contribute'              => 'редагувати',
	'translate-edit-no-information'          => "''Це повідомлення не має опису.
Якщо ви знаєте, де чи як воно використовується, ви можете допомогти іншим перекладачам, додавши опис для цього повідомлення.''",
	'translate-edit-information'             => 'Інформація про це повідомлення ($1)',
	'translate-edit-in-other-languages'      => 'Повідомлення іншими мовами',
	'translate-edit-committed'               => 'Поточний переклад у програмі',
	'translate-edit-warnings'                => 'Попередження про неповні переклади',
	'translate-edit-goto-no-prev'            => 'Немає попереднього повідомлення',
	'translate-edit-goto-no-next'            => 'Немає наступного повідомлення',
	'translate-edit-goto-prev'               => 'Редагувати попереднє повідомлення',
	'translate-edit-goto-next'               => 'Редагувати наступне повідомлення',
	'translate-edit-goto-list'               => 'Назад до списку',
	'translate-magic-pagename'               => 'Поглиблений переклад MediaWiki',
	'translate-magic-help'                   => "Ви можете перекладати псевдоніми спеціальних сторінок, магічні слова, назви тем оформлення і просторів назв.

Для магічних слів треба включати англомовні версії, інакше магічні слова не працюватимуть.
Також не змінюйте перші елементи (0 чи 1).

Псевдоніми спеціальних сторінок і магічні слова можуть мати декілька варіантів перекладу, які розділяються комою (,).
Назви тем оформлення та простори назв мажуть мати тільки один переклад.

У перекладах просторів назв рядок <tt>Обговорення $1</tt> обробляється по-особливому. <tt>$1</tt> буде замінено на назву сайта (наприклад <tt>Обговорення {{SITENAME}}</tt>). Зв'яжіться з розробниками, якщо подібна граматична конструкція невірна для вашої мови.

Щоб зберегти зміни, ви повинні належати до групи перекладачів.
Зміни не будуть збережені, поки ви не натиснете кнопку нижче.",
	'translate-magic-module'                 => 'Модуль:',
	'translate-magic-submit'                 => 'Вивести',
	'translate-magic-cm-export'              => 'Експортувати',
	'translate-magic-cm-to-be'               => 'Має бути',
	'translate-magic-cm-current'             => 'Поточне',
	'translate-magic-cm-original'            => 'Вихідне',
	'translate-magic-cm-comment'             => 'Коментар:',
	'translate-magic-cm-save'                => 'Зберегти',
	'translate-magic-cm-updatedusing'        => 'Оновлено за допомогою [[Special:Magic]]',
	'translate-magic-cm-savefailed'          => 'Не вдалося зберегти',
	'translate-magic-special'                => 'Псевдоніми спеціальних сторінок',
	'translate-magic-words'                  => 'Магічні слова',
	'translate-magic-skin'                   => 'Назви тем оформлення',
	'translate-magic-namespace'              => 'Простори назв',
	'translationchanges'                     => 'Зміни в перекладах',
	'translationchanges-export'              => 'експортувати',
	'translationchanges-change'              => '$1: $2 $3',
	'translate-checks-parameters'            => '{{PLURAL:$2|Наступний параметр не використовується|Наступні параметри не використовуються}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '{{PLURAL:$2|Наступний параметр невідомий|Наступні параметри невідомі}}:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => 'Непарна кількість відкритих і закритих дужок:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'                 => '{{PLURAL:$2|Наступне посилання проблематичне|Наступні посилання проблематичні}} : <strong>$1</strong>',
	'translate-checks-xhtml'                 => 'Будь ласка, виправте {{PLURAL:$2|наступний тег|наступні теги}}: <strong>$1</strong>',
	'translate-checks-plural'                => 'Оригінал використовує <nowiki>{{PLURAL:}}</nowiki>, а переклад — ні.',
	'tog-translate-nonewsletter'             => 'Не надсилати мені інформаційні бюлетені (тільки для користувачів з підтвердженими адресами електронної пошти)',
	'right-translate'                        => 'Редагування з використанням інтерфейсу перекладу',
	'translate-rc-translation-filter'        => 'Фільтр перекладів:',
	'translate-rc-translation-filter-no'     => 'Немає',
	'translate-rc-translation-filter-only'   => 'Показати тільки переклади',
	'translate-rc-translation-filter-filter' => 'Без перекладів',
	'translate-rc-translation-filter-site'   => 'Повідомлення сайта',
	'translate-stats-edits'                  => 'Редагувань за день',
);

/** Vèneto (Vèneto)
 * @author Candalua
 * @author Siebrand
 */
$messages['vec'] = array(
	'translate'                         => 'Tradussion',
	'translate-desc'                    => '[[Special:Translate|Pagina speciale]] par tradur MediaWiki e altro',
	'translate-edit'                    => 'modifica',
	'translate-talk'                    => 'discussion',
	'translate-history'                 => 'storia',
	'translate-task-view'               => 'Vardar tuti i messagi de',
	'translate-task-untranslated'       => 'Vardar tuti i messagi non tradoti de',
	'translate-task-optional'           => 'Vardar i messagi opsionali de',
	'translate-task-review'             => 'Rivardar i canbiamenti a',
	'translate-task-reviewall'          => 'Rivardar tute le tradussion in',
	'translate-task-export'             => 'Esportar le tradussion da',
	'translate-task-export-to-file'     => 'Esportar in un file le tradussion da',
	'translate-task-export-as-po'       => 'Esportar le tradussion in formato Gettext',
	'translate-page-no-such-language'   => 'La lengua indicà no la xe valida.',
	'translate-page-no-such-task'       => "L'azion indicà no la xe valida.",
	'translate-page-no-such-group'      => "El grupo indicà no'l xe valido.",
	'translate-page-settings-legend'    => 'Inpostassion',
	'translate-page-task'               => 'Mi vôi',
	'translate-page-group'              => 'Grupo',
	'translate-page-language'           => 'Lengua',
	'translate-page-limit'              => 'Limite',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|messagio|messagi}} par pagina',
	'translate-submit'                  => 'Mostra',
	'translate-page-navigation-legend'  => 'Navigassion',
	'translate-page-showing'            => 'Sti qua i xe i messagi da $1 a $2 de $3.',
	'translate-page-showing-all'        => 'Ghe xe $1 {{PLURAL:$1|messagio|messagi}}.',
	'translate-page-showing-none'       => 'Nissun messagio da far védar.',
	'translate-next'                    => 'Pagina sucessiva',
	'translate-prev'                    => 'Pagina preçedente',
	'translate-page-description-legend' => 'Informassion sul grupo',
	'translate-optional'                => '(opsionale)',
	'translate-ignored'                 => '(ignorà)',
	'translate-edit-definition'         => 'Definission del messagio',
	'translate-edit-contribute'         => 'contribuìssi',
	'translate-edit-no-information'     => "''Sto messagio no'l gà documentassion.
Se te sè dove o come sto messagio el vien doparà, te podi jutar altri tradutori zontando documentassion a sto messagio.''",
	'translate-edit-information'        => 'Informassion su sto messagio ($1)',
	'translate-edit-in-other-languages' => 'Sto messagio in altre lengue',
	'translate-edit-committed'          => 'Tradussion atuale del software',
	'translate-edit-warnings'           => 'Avertimenti su tradussion incomplete',
	'translate-magic-pagename'          => 'Tradussion estesa de MediaWiki',
	'translate-magic-help'              => "Te pol tradur i alias de le pagine speciali, le parole magiche, i nomi de le skin e i nomi dei namespace.

In te le parole magiche te ghè da inserir le version in Inglese senò no le va più.
Lassa inoltre el primo elemento (0 o 1) cussita come l'è.

I alias e le parole magiche le pol verghe più tradussion.
Le tradussion le xe separà da na virgola (,).
I nomi de le skin e dei namespace i pol verghe na tradussion sola.

In te le tradussion dei namespace <tt>$1 talk</tt> el xe speciale. <tt>$1</tt> el vien sostituìo col nome del sito (par esenpio <tt>{{SITENAME}} talk</tt>).
Se ne la to lengua no se riesse a scrivar na espression valida sensa canbiar el nome del sito, par piaser contata un svilupador.

Te ghè da èssar nel grupo dei tradutori par salvar i canbiamenti.
I canbiamenti no i xe salvà finché no te struchi el boton qua soto.",
	'translate-magic-submit'            => 'Mostra',
	'translate-magic-cm-export'         => 'Esporta',
	'translate-magic-cm-to-be'          => 'Nova',
	'translate-magic-cm-current'        => 'Atuale',
	'translate-magic-cm-original'       => 'Originàl',
	'translate-magic-cm-comment'        => 'Comento:',
	'translate-magic-cm-save'           => 'Salva',
	'translate-magic-cm-updatedusing'   => 'Agiornà doparando [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => 'Salvatagio mìa riussìo',
	'translate-magic-special'           => 'Nomi alternativi de le pagine speciali',
	'translate-magic-words'             => 'Parole magiche',
	'translate-magic-skin'              => 'Nomi de le skin',
	'translate-magic-namespace'         => 'Nomi dei namespace',
	'translationchanges'                => 'Modifiche a le tradussion',
	'translationchanges-export'         => 'esporta',
	'translationchanges-change'         => '$1: $2 da $3',
	'translate-checks-parameters'       => 'I seguenti parametri no i xe mìa doparà: <strong>$1</strong>',
	'translate-checks-balance'          => 'Ghe xe un nùmaro dispari de paréntesi:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'            => 'I colegamenti seguenti i pol causar problemi:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'            => 'Par piaser, sostituìssi i seguenti tag con quei giusti:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'           => 'La definission la dòpara <nowiki>{{PLURAL:}}</nowiki> ma la tradussion no.',
	'tog-translate-nonewsletter'        => 'No stà mandarme notiziari par e-mail (solo utenti che gà un indirisso e-mail convalidà)',
	'right-translate'                   => "Modifica doparando l'interfacia de tradussion",
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 * @author Siebrand
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'translate'                         => 'Biên dịch',
	'translate-desc'                    => '[[Special:Translate|Trang đặc biệt]] dùng để dịch Mediawiki và các thứ khác',
	'translate-edit'                    => 'sửa đổi',
	'translate-talk'                    => 'thảo luận',
	'translate-history'                 => 'lịch sử',
	'translate-task-view'               => 'Xem tất cả các thông điệp từ',
	'translate-task-untranslated'       => 'Xem tất cả các thông điệp chưa dịch từ',
	'translate-task-optional'           => 'Xem các thông điệp tùy chọn từ',
	'translate-task-review'             => 'Kiểm lại các thay đổi trong',
	'translate-task-reviewall'          => 'Kiểm lại tất cả các bản dịch trong',
	'translate-task-export'             => 'Xuất các bản dịch từ',
	'translate-task-export-to-file'     => 'Xuất bản dịch ra tập tin từ',
	'translate-task-export-as-po'       => 'Xuất bản dịch theo dạng Gettext',
	'translate-page-no-such-language'   => 'Ngôn ngữ chỉ định không đúng.',
	'translate-page-no-such-task'       => 'Tác vụ chỉ định không đúng.',
	'translate-page-no-such-group'      => 'Nhóm chỉ định không đúng.',
	'translate-page-settings-legend'    => 'Thiết lập',
	'translate-page-task'               => 'Tôi muốn',
	'translate-page-group'              => 'Nhóm',
	'translate-page-language'           => 'Ngôn ngữ',
	'translate-page-limit'              => 'Giới hạn',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|thông điệp|thông điệp}} mỗi trang',
	'translate-submit'                  => 'Xem',
	'translate-page-navigation-legend'  => 'Điều khiển',
	'translate-page-showing'            => 'Đang hiển thị thông điệp có thứ tự từ $1 đến $2 trong tổng số $3 thông điệp.',
	'translate-page-showing-all'        => 'Đang hiển thị $1 {{PLURAL:$1|thông điệp|thông điệp}}.',
	'translate-page-showing-none'       => 'Không có thông điệp nào.',
	'translate-next'                    => 'Trang sau',
	'translate-prev'                    => 'Trang trước',
	'translate-page-description-legend' => 'Thông tin về nhóm',
	'translate-optional'                => '(tùy chọn)',
	'translate-ignored'                 => '(đã bỏ)',
	'translate-edit-definition'         => 'Định nghĩa thông điệp',
	'translate-edit-contribute'         => 'đóng góp',
	'translate-edit-no-information'     => "''Thông điệp này hiện chưa có tài liệu hướng dẫn. Nếu bạn biết thông điệp này dùng ở đâu và dùng như thế nào, bạn có thể giúp những biên dịch viên khác bằng cách thêm tài liệu hướng dẫn cho nó.''",
	'translate-edit-information'        => 'Thông tin về thông điệp này ($1)',
	'translate-edit-in-other-languages' => 'Thông điệp bằng thứ tiếng khác',
	'translate-edit-committed'          => 'Bản dịch hiện tại trong phần mềm',
	'translate-edit-warnings'           => 'Các cảnh báo về các bản dịch chưa hoàn thành',
	'translate-magic-pagename'          => 'Bản dịch MediaWiki mở rộng',
	'translate-magic-help'              => 'Bạn có thể dịch bí danh của các trang đặc biệt, thần chú, tên hình dạng giao diện và tên của không gian tên.

Trong các từ thần chú bạn cần phải ghi kèm các bản dịch tiếng Anh, nếu không chúng sẽ không hoạt động. Cũng nhớ giữ nguyên, đừng thay đổi mục đầu tiên (0 hoặc 1).

Bí danh của các trang đặc biệt và từ thần chú có thể có nhiều bản dịch. Các bản dịch phân cách nhau bằng dấu phẩy (,). Tên hình dạng giao diện và không gian tên chỉ có thể có một bản dịch.

Trong các bản dịch không gian tên, <tt>$1 talk</tt> có đặc biệt hơn. <tt>$1</tt> được thay thế bằng tên trang (ví dụ <tt>{{SITENAME}} talk</tt>). Nếu ngôn ngữ của bạn không thể hiển thị đúng nếu không đổi tên trang (SITENAME), xin hãy liên hệ với một lập trình viên.

Bạn cần phải thuộc nhóm biên dịch viên để có thể lưu các thay đổi. Các thay đổi sẽ không được lưu lại đến khi nào bạn nhấn vào nút lưu ở dưới.',
	'translate-magic-submit'            => 'Xem',
	'translate-magic-cm-export'         => 'Xuất',
	'translate-magic-cm-to-be'          => 'Trở thành',
	'translate-magic-cm-current'        => 'Hiện hành',
	'translate-magic-cm-original'       => 'Bản gốc',
	'translate-magic-cm-comment'        => 'Tóm lược:',
	'translate-magic-cm-save'           => 'Lưu',
	'translate-magic-cm-updatedusing'   => 'Đã cập nhật bằng [[Special:Magic]]',
	'translate-magic-cm-savefailed'     => 'Lưu thất bại',
	'translate-magic-special'           => 'Bí danh của các trang đặc biệt',
	'translate-magic-words'             => 'Từ thần chú',
	'translate-magic-skin'              => 'Tên hình dạng giao diện',
	'translate-magic-namespace'         => 'Tên của không gian tên',
	'translationchanges'                => 'Các thay đổi bản dịch',
	'translationchanges-export'         => 'xuất',
	'translationchanges-change'         => '$1: $2 bởi $3',
	'translate-checks-parameters'       => '{{PLURAL:$2|Tham số|Những tham số}} sau không sử dụng:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'          => 'Số dấu ngoặc bị lẻ:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'            => '{{PLURAL:$2|Liên kết|Các liên kết}} sau có vấn đề:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'            => 'Xin thay thế{{PLURAL:$2|| các}} thẻ sau bằng thẻ đúng:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'           => 'Định nghĩa sử dụng <nowiki>{{PLURAL:}}</nowiki> nhưng bản dịch không có.',
);

/** Volapük (Volapük)
 * @author Smeira
 * @author Malafaya
 * @author Siebrand
 */
$messages['vo'] = array(
	'translate'                         => 'Tradutön',
	'translate-edit'                    => 'redakön',
	'translate-talk'                    => 'bespik',
	'translate-history'                 => 'jenotem',
	'translate-task-view'               => 'logön nunis valik in',
	'translate-task-untranslated'       => 'logön nunis no petradutölis valikis in',
	'translate-page-no-such-language'   => 'Pük pevälöl no dabinon.',
	'translate-page-no-such-task'       => 'Vobod pevilöl no dabinon.',
	'translate-page-no-such-group'      => 'Grup pevälöl no dabinon.',
	'translate-page-settings-legend'    => 'Paramets',
	'translate-page-task'               => 'Vilob',
	'translate-page-group'              => 'Grup:',
	'translate-page-language'           => 'Pük:',
	'translate-page-limit'              => 'Mied:',
	'translate-page-limit-option'       => '{{PLURAL:$1|nun|nuns}} $1 a pad',
	'translate-submit'                  => 'Getolöd',
	'translate-page-navigation-legend'  => 'Nafam',
	'translate-page-showing'            => 'Nuns de nüm: $1 ad $2 (se $3).',
	'translate-page-showing-all'        => '{{PLURAL:$1|Nun|Nuns}} $1 {{PLURAL:$1|pajonon|pajonons}}.',
	'translate-page-showing-none'       => 'Nuns jonabik no dabinons.',
	'translate-next'                    => 'Pad sököl',
	'translate-prev'                    => 'Pad büik',
	'translate-page-description-legend' => 'Nüns tefü grup',
	'translate-ignored'                 => '(penedemöl)',
	'translate-edit-definition'         => 'Miedet nuna',
	'translate-edit-contribute'         => 'keblünön',
	'translate-edit-no-information'     => 'Nun at no peplänon. If sevol, kiöpo u lio nun at pagebon, kanol yufön tradutanis votik medä penol pläni gudik dö geb onik.',
	'translate-edit-information'        => 'Plän nuna at ($1)',
	'translate-edit-in-other-languages' => 'Nun in püks votik',
	'translate-edit-warnings'           => 'Nüneds tefü tradutods no lölöfiks',
	'translate-magic-cm-to-be'          => 'Ovedon',
	'translate-magic-cm-original'       => 'Rigik',
	'translate-magic-cm-save'           => 'Dakipön',
	'translate-magic-cm-savefailed'     => 'Dakip no eplöpon',
	'translate-magic-words'             => 'Vöds magivik',
	'translate-magic-namespace'         => 'Nems nemaspadas',
	'translationchanges-change'         => '$1: $2 fa $3',
	'translate-checks-parameters'       => 'Paramets sököl no pagebons:
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'            => 'Yüms sököl binons säkädiks:
<strong><nowiki>$1</nowiki></strong>',
);

/** Walloon (Walon)
 * @author Srtxg
 */
$messages['wa'] = array(
	'translate'                     => 'Ratourner',
	'translate-edit'                => 'candjî',
	'translate-talk'                => 'copene',
	'translate-history'             => 'istwere',
	'translate-task-view'           => 'Vey tos les messaedjes',
	'translate-task-untranslated'   => 'Vey tos les messaedjes nén ratournés',
	'translate-task-review'         => 'Verifyî les candjmints',
	'translate-task-reviewall'      => 'Verifyî tos les ratournaedjes',
	'translate-task-export'         => 'Copyî foû les ratournaedjes',
	'translate-task-export-to-file' => 'Copyî foû viè on fitchî les ratournaedjes',
	'translate-submit'              => 'I va',
	'translate-next'                => 'Pådje shuvante',
	'translate-prev'                => 'Pådje di dvant',
	'translate-optional'            => '(opcionel)',
	'translate-ignored'             => '(ignoré)',
);

/** Mingrelian (მარგალური)
 * @author Malafaya
 */
$messages['xmf'] = array(
	'translate-page-language' => 'ნინა',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'translate'                         => 'פֿארטײַטשן',
	'translate-desc'                    => '[[Special:Translate|באזונדערער בלאט]] פֿאר פֿארטײַטשן מעדיעוויקי און ווײַטער',
	'translate-edit'                    => 'רעדאקטירן',
	'translate-talk'                    => 'רעדן',
	'translate-history'                 => 'היסטאריע',
	'translate-task-view'               => 'ווײַז אלע מעלדונגען פֿון',
	'translate-task-untranslated'       => 'ווײַז אלע נישט פֿארטײַטשטע מעלדונגען פֿון',
	'translate-page-task'               => 'איך וויל',
	'translate-page-group'              => 'גרופע',
	'translate-page-language'           => 'שפראך',
	'translate-page-limit-option'       => '$1 {{PLURAL:$1|מעלדונג|מעלדונגען}} אין א בלאט',
	'translate-page-navigation-legend'  => 'נאוויגאציע',
	'translate-page-showing'            => 'ווײַזן מעלדונגען $1 ביז $2 פֿון $3.',
	'translate-page-showing-all'        => 'ווײַזן $1 {{PLURAL:$1|מעלדונג|מעלדונגען}}.',
	'translate-next'                    => 'קומענדיגער בלאט',
	'translate-prev'                    => 'פֿריערדיגער בלאט',
	'translate-page-description-legend' => 'אינפֿארמאציע וועגן דער גרופע',
	'translate-edit-contribute'         => 'בײַשטײַערן',
	'translate-edit-information'        => 'אינפֿארמאציע וועגן דער מעלדונג ($1)',
	'translate-edit-goto-prev'          => 'רעדאקטירן די פֿריערדיגע מעלדונג',
	'translate-edit-goto-next'          => 'רעדאקטירן די קומענדיגע מעלדונג',
	'translate-edit-goto-list'          => 'צוריק צו דער ליסטע',
	'translate-magic-cm-updatedusing'   => 'דערהײַנטיגט מיט [[Special:Magic]]',
	'translationchanges-export'         => 'עקספארט',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'translate'                         => '翻譯',
	'translate-desc'                    => '翻譯MediaWiki同其它嘢嘅[[Special:Translate|特別頁]]',
	'translate-edit'                    => '編輯',
	'translate-talk'                    => '對話',
	'translate-history'                 => '歷史',
	'translate-task-view'               => '去睇全部信息自',
	'translate-task-untranslated'       => '去睇全部未翻譯好嘅信息自',
	'translate-task-optional'           => '去睇可選用嘅信息自',
	'translate-task-review'             => '睇番嗰度嘅更改',
	'translate-task-reviewall'          => '睇番響嗰度嘅全部翻譯',
	'translate-task-export'             => '倒出翻譯自',
	'translate-task-export-to-file'     => '倒出翻譯到檔案自',
	'translate-task-export-as-po'       => '倒出翻譯到 Gettext 格式',
	'translate-page-no-such-language'   => '所指定嘅語言唔正確。',
	'translate-page-no-such-task'       => '所指定嘅工作唔正確。',
	'translate-page-no-such-group'      => '所指定嘅組唔正確。',
	'translate-page-settings-legend'    => '設定',
	'translate-page-task'               => '我想去',
	'translate-page-group'              => '組',
	'translate-page-language'           => '語言',
	'translate-page-limit'              => '上限',
	'translate-page-limit-option'       => '每一版有$1個信息',
	'translate-submit'                  => '擷取',
	'translate-page-navigation-legend'  => '導航',
	'translate-page-showing'            => '顯示緊由 $1到$2 ，總共 $3 個信息。',
	'translate-page-showing-all'        => '顯示緊 $1個信息。',
	'translate-page-showing-none'       => '無信息可顯示。',
	'translate-next'                    => '下一版',
	'translate-prev'                    => '上一版',
	'translate-page-description-legend' => '有關嗰組嘅信息',
	'translate-optional'                => '(可選)',
	'translate-ignored'                 => '(已略過)',
	'translate-edit-definition'         => '信息定義',
	'translate-edit-contribute'         => '貢獻',
	'translate-edit-no-information'     => "''呢句信息無註解。
如果你知道呢句信息響邊同埋點用，你可以加註解去呢個信息去幫其他嘅翻譯者。''",
	'translate-edit-information'        => '呢句信息嘅資料 ($1)',
	'translate-edit-in-other-languages' => '其它語言嘅信息',
	'translate-edit-committed'          => '而家響軟件嘅翻譯',
	'translate-edit-warnings'           => '有關未譯好嘅警告',
	'translate-magic-pagename'          => '延伸MediaWiki翻譯',
	'translate-magic-help'              => '你可以翻譯特別頁替身、魔術字、皮名同埋名空間嘅名。

響魔術字度你係要同時包括英文嘅翻譯，唔係嘅話就會唔能夠運作。
同時保持第一個項目 (0或1) 不變。

特別頁替身同埋魔術字可以有多個翻譯。
翻譯係以逗號 (,) 分隔。
皮名同埋空間名只可以有一項翻譯。

響空間名翻譯度， <tt>$1 talk</tt> 係特別嘅。 <tt>$1</tt> 會由網名代替咗（例如<tt>{{SITENAME}} talk</tt>）。
如果你嘅語言組合唔能夠響網站名唔改嘅情況之下去組合成你嘅意思，請聯絡技術員。

你需要係翻譯組嘅組員去儲存嘅啲信息。
響你撳下面嘅儲存擊之前，啲改動唔會儲存落來。',
	'translate-magic-submit'            => '擷取',
	'translate-magic-cm-export'         => '倒出',
	'translate-magic-cm-to-be'          => '翻譯',
	'translate-magic-cm-current'        => '現時',
	'translate-magic-cm-original'       => '原本',
	'translate-magic-cm-comment'        => '註解:',
	'translate-magic-cm-save'           => '保存',
	'translate-magic-cm-updatedusing'   => '用[[Special:Magic]]更新咗',
	'translate-magic-cm-savefailed'     => '保存失敗',
	'translate-magic-special'           => '特別頁替身',
	'translate-magic-words'             => '魔術字',
	'translate-magic-skin'              => '皮名',
	'translate-magic-namespace'         => '名空間名',
	'translationchanges'                => '翻譯更改',
	'translationchanges-export'         => '倒出',
	'translationchanges-change'         => '$1: $2 由 $3',
	'translate-checks-parameters'       => '下面嘅參數係無用到嘅: <strong>$1</strong>',
	'translate-checks-balance'          => '插入字嘅數量唔均等: <strong>$1</strong>',
	'translate-checks-links'            => '下面嘅連結有問題: <strong>$1</strong>',
	'translate-checks-xhtml'            => '請改下面嘅標籤去正確嘅: <strong>$1</strong>',
	'translate-checks-plural'           => '用 <nowiki>{{PLURAL:}}</nowiki> 嘅解解釋但係翻譯無用到。',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Alexsh
 * @author Siebrand
 */
$messages['zh-hans'] = array(
	'translate'                         => '翻译',
	'translate-desc'                    => '翻译MediaWiki介面信息的[[Special:Translate|特殊页面]]',
	'translate-edit'                    => '编辑',
	'translate-talk'                    => '对话',
	'translate-history'                 => '历史',
	'translate-task-view'               => '查看全部信息',
	'translate-task-untranslated'       => '查看尚未翻译的信息',
	'translate-task-optional'           => '查看可选的信息',
	'translate-task-review'             => '检查该处的更改',
	'translate-task-reviewall'          => '检查该群组的翻译',
	'translate-task-export'             => '导出翻译',
	'translate-task-export-to-file'     => '导出翻译至文件',
	'translate-task-export-as-po'       => '以纯文字格式导出翻译',
	'translate-page-no-such-language'   => '选择的语言错误',
	'translate-page-no-such-task'       => '选择的功能错误',
	'translate-page-no-such-group'      => '选择的群组错误',
	'translate-page-settings-legend'    => '设置',
	'translate-page-task'               => '选择功能',
	'translate-page-group'              => '群组',
	'translate-page-language'           => '语言',
	'translate-page-limit'              => '每页显示',
	'translate-page-limit-option'       => '$1个信息',
	'translate-submit'                  => '撷取',
	'translate-page-navigation-legend'  => '导航',
	'translate-page-showing'            => '显示第 $1 到第 $2 个信息，总共有 $3 个',
	'translate-page-showing-all'        => '显示 $1 个信息',
	'translate-page-showing-none'       => '没有任何信息',
	'translate-next'                    => '下一页',
	'translate-prev'                    => '上一页',
	'translate-page-description-legend' => '关于本群组',
	'translate-optional'                => '(可选)',
	'translate-ignored'                 => '(已略过)',
	'translate-edit-definition'         => '信息原文',
	'translate-edit-contribute'         => '贡献',
	'translate-edit-no-information'     => "''本介面信息没有任何说明信息
如果您知道这个信息是使用在哪个地方，您可以增加说明信息以协助其他翻译者''",
	'translate-edit-information'        => '关于本介面信息的信息 ($1)',
	'translate-edit-in-other-languages' => '其他语言的信息',
	'translate-edit-committed'          => '当前翻译',
	'translate-edit-warnings'           => '未完成翻译的警告',
	'translate-magic-pagename'          => '延伸的MediaWiki翻译',
	'translate-magic-help'              => "您可以使用本特殊页面翻译'''特殊页面别名'''、'''魔术字'''、'''面板名称'''以及'''名字空间名称'''。

翻译魔术字时，新的名称必需含有英文，否则无法生效。第一个字元也请避免0或1这两个字元

特殊页面别名以及魔术字可以使用复数的翻译，请使用逗号(,)分隔。面板名称以及名字空间名称只能有一个翻译。

名字空间名称中，要注意<tt>$1 讨论</tt>这个空间名称在翻译时，<tt>$1</tt>会受到网站名称影响(例如<tt>{{SITENAME}} talk</tt>)。
如果您的翻译没有更动网站名称，但无法正确显示的话，请联络MediaWiki开发者。

您必需属于翻译者群组才能保存这些更改。在按下保存之前，这些更改均不会被更动。",
	'translate-magic-submit'            => '撷取',
	'translate-magic-cm-export'         => '导出',
	'translate-magic-cm-to-be'          => '翻译',
	'translate-magic-cm-current'        => '目前',
	'translate-magic-cm-original'       => '原始信息',
	'translate-magic-cm-comment'        => '原因：',
	'translate-magic-cm-save'           => '保存',
	'translate-magic-cm-updatedusing'   => '已使用[[Special:Magic]]更新',
	'translate-magic-cm-savefailed'     => '保存失败',
	'translate-magic-special'           => '特殊页面别名',
	'translate-magic-words'             => '魔术字',
	'translate-magic-skin'              => '面板名称',
	'translate-magic-namespace'         => '名字空间名称',
	'translationchanges'                => '翻译更改',
	'translationchanges-export'         => '{{int:translate-magic-cm-export}}',
	'translationchanges-change'         => '$1: $2 由$3翻译',
	'translate-checks-parameters'       => '以下参数没有使用到：
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'          => '括号的数量不一致：
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-links'            => '以下的连结可能有问题：
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-xhtml'            => '请修正以下的标签：
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-plural'           => '原始信息使用于<nowiki>{{PLURAL:}}</nowiki>中，并没有用于翻译。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Siebrand
 */
$messages['zh-hant'] = array(
	'translate'                              => '翻譯',
	'translate-desc'                         => '翻譯MediaWiki介面訊息的[[Special:Translate|特殊頁面]]',
	'translate-edit'                         => '編輯',
	'translate-talk'                         => '對話',
	'translate-history'                      => '歷史',
	'translate-task-view'                    => '檢視全部訊息',
	'translate-task-untranslated'            => '檢視尚未翻譯的訊息',
	'translate-task-optional'                => '檢視可選的訊息',
	'translate-task-problematic'             => '檢視有問題的訊息',
	'translate-task-review'                  => '檢查該處的更改',
	'translate-task-reviewall'               => '檢查該群組的翻譯',
	'translate-task-export'                  => '匯出翻譯',
	'translate-task-export-to-file'          => '匯出翻譯至檔案',
	'translate-task-export-as-po'            => '以純文字格式匯出翻譯',
	'translate-task-export-to-xliff'         => '以Xliff格式匯出翻譯',
	'translate-page-no-such-language'        => '選擇的語言錯誤',
	'translate-page-no-such-task'            => '選擇的功能錯誤',
	'translate-page-no-such-group'           => '選擇的群組錯誤',
	'translate-page-disabled'                => "翻譯至這個語言已於本群組停用，原因如下：

''$1''",
	'translate-page-settings-legend'         => '設定',
	'translate-page-task'                    => '選擇功能',
	'translate-page-group'                   => '群組',
	'translate-page-language'                => '語言',
	'translate-page-limit'                   => '每頁顯示',
	'translate-page-limit-option'            => '$1個訊息',
	'translate-submit'                       => '擷取',
	'translate-page-navigation-legend'       => '導航',
	'translate-page-showing'                 => '顯示第 $1 到第 $2 個訊息，總共有 $3 個',
	'translate-page-showing-all'             => '顯示 $1 個訊息',
	'translate-page-showing-none'            => '沒有任何訊息',
	'translate-next'                         => '下一頁',
	'translate-prev'                         => '上一頁',
	'translate-page-description-legend'      => '關於本群組',
	'translate-page-edit'                    => '編輯',
	'translate-optional'                     => '(可選)',
	'translate-ignored'                      => '(已略過)',
	'translate-edit-definition'              => '訊息原文',
	'translate-edit-contribute'              => '貢獻',
	'translate-edit-no-information'          => "''本介面訊息沒有任何說明資訊
如果您知道這個訊息是使用在哪個地方，您可以增加說明資訊以協助其他翻譯者''",
	'translate-edit-information'             => '關於本介面訊息的資訊 ($1)',
	'translate-edit-in-other-languages'      => '其他語言的訊息',
	'translate-edit-committed'               => '當前翻譯',
	'translate-edit-warnings'                => '未完成翻譯的警告',
	'translate-edit-goto-no-prev'            => '沒有前一個訊息',
	'translate-edit-goto-no-next'            => '沒有次一個訊息',
	'translate-edit-goto-prev'               => '編輯前一個訊息',
	'translate-edit-goto-next'               => '編輯次一個訊息',
	'translate-edit-goto-list'               => '回到清單',
	'translate-magic-pagename'               => '延伸的MediaWiki翻譯',
	'translate-magic-help'                   => "您可以使用本特殊頁面翻譯'''特殊頁面別名'''、'''魔術字'''、'''面板名稱'''以及'''名字空間名稱'''。

翻譯魔術字時，新的名稱必需含有英文，否則無法生效。第一個字元也請避免0或1這兩個字元

特殊頁面別名以及魔術字可以使用複數的翻譯，請使用逗號(,)分隔。面板名稱以及名字空間名稱只能有一個翻譯。

名字空間名稱中，要注意<tt>$1 討論</tt>這個空間名稱在翻譯時，<tt>$1</tt>會受到網站名稱影響(例如<tt>{{SITENAME}} talk</tt>)。
如果您的翻譯沒有更動網站名稱，但無法正確顯示的話，請聯絡MediaWiki開發者。

您必需屬於翻譯者群組才能保存這些更改。在按下保存之前，這些更改均不會被更動。",
	'translate-magic-module'                 => '模組：',
	'translate-magic-submit'                 => '擷取',
	'translate-magic-cm-export'              => '匯出',
	'translate-magic-cm-to-be'               => '翻譯',
	'translate-magic-cm-current'             => '目前',
	'translate-magic-cm-original'            => '原始訊息',
	'translate-magic-cm-comment'             => '原因：',
	'translate-magic-cm-save'                => '保存',
	'translate-magic-cm-updatedusing'        => '已使用[[Special:Magic]]更新',
	'translate-magic-cm-savefailed'          => '保存失敗',
	'translate-magic-special'                => '特殊頁面別名',
	'translate-magic-words'                  => '魔術字',
	'translate-magic-skin'                   => '面板名稱',
	'translate-magic-namespace'              => '名字空間名稱',
	'translationchanges'                     => '翻譯更改',
	'translationchanges-export'              => '{{int:translate-magic-cm-export}}',
	'translationchanges-change'              => '$1: $2 由$3翻譯',
	'translate-checks-parameters'            => '以下參數沒有使用到：
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-parameters-unknown'    => '以下參數為未知參數：
<strong><nowiki>$1</nowiki></strong>',
	'translate-checks-balance'               => '括號的數量不一致：<strong>$1</strong>',
	'translate-checks-links'                 => '以下的連結可能有問題：<strong>$1</strong>',
	'translate-checks-xhtml'                 => '請修正以下的標籤：<strong>$1</strong>',
	'translate-checks-plural'                => '原始訊息使用於<nowiki>{{PLURAL:}}</nowiki>中，並沒有用於翻譯。',
	'tog-translate-nonewsletter'             => '不要傳送電子報 (只適用已確認過電子郵件的用戶)',
	'right-translate'                        => '使用翻譯介面編輯',
	'translate-rc-translation-filter'        => '篩選翻譯：',
	'translate-rc-translation-filter-no'     => '不篩選',
	'translate-rc-translation-filter-only'   => '只顯示翻譯',
	'translate-rc-translation-filter-filter' => '排除',
	'translate-rc-translation-filter-site'   => '只有網站訊息的更動',
	'translate-stats-edits'                  => '日編輯數',
);

