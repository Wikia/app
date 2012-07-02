<?php
/**
 * Internationalisation file for MassEditRegex extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Adam Nielsen
 */
$messages['en'] = array(
	'action-masseditregex' => 'perform a bulk edit',
	'masseditregex' => 'Mass edit using regular expressions',
	'masseditregex-desc' => 'Use regular expressions to [[Special:MassEditRegex|edit many pages in one operation]]',
	'masseditregextext' => 'Enter one or more regular expressions (one per line) for matching, and one or more expressions to replace each match with.
The first match-expression, if successful, will be replaced with the first replace-expression, and so on.
See [http://php.net/manual/en/function.preg-replace.php the PHP function preg_replace()] for details.',
	'masseditregex-pagelisttxt' => 'Pages to edit (do not use a namespace: prefix):',
	'masseditregex-matchtxt' => 'Search for:',
	'masseditregex-replacetxt' => 'Replace with:',
	'masseditregex-executebtn' => 'Execute',
	'masseditregex-err-nopages' => 'You must specify at least one page to change.',

	'masseditregex-before' => 'Before',
	'masseditregex-after' => 'After',
	'masseditregex-max-preview-diffs' => 'Preview has been limited to the first $1 {{PLURAL:$1|match|matches}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|change|changes}}',
	'masseditregex-page-not-exists' => '$1 does not exist',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|page|pages}} edited',
	'masseditregex-view-full-summary' => 'View full edit summary',

	'masseditregex-hint-intro' => 'Here are some hints and examples for accomplishing common tasks:',
	'masseditregex-hint-headmatch' => 'Match',
	'masseditregex-hint-headreplace' => 'Replace',
	'masseditregex-hint-headeffect' => 'Effect',
	'masseditregex-hint-toappend' => 'Append some text to the end of the page - great for adding pages to categories',
	'masseditregex-hint-remove' => 'Remove some text from all the pages in the list',
	'masseditregex-hint-removecat' => 'Remove all categories from a page (note the escaping of the square brackets in the wikicode.)
The replacement values should not be escaped.',

	'masseditregex-listtype-intro' => 'This is a list of:',
	'masseditregex-listtype-pagenames' => 'Page names (edit these pages)',
	'masseditregex-listtype-pagename-prefixes' => 'Page name prefixes (edit pages having names beginning with this text)',
	'masseditregex-listtype-categories' => 'Category names (edit each page within these categories; namespace selection is ignored)',
	'masseditregex-listtype-backlinks' => 'Backlinks (edit pages that link to these ones)',
	'masseditregex-namespace-intro' => 'All these pages are in this namespace:',
	'masseditregex-exprnomatch' => 'The expression "$1" matched no pages.',
	'masseditregex-badregex' => 'Invalid regex:',
	'masseditregex-editfailed' => 'Edit failed:',
	'masseditregex-tooltip-execute' => 'Apply these changes to each page',

	'right-masseditregex' => 'Replace page contents using regular expressions',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Kghbln
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'action-masseditregex' => '{{doc-action|masseditregex}}',
	'masseditregex-desc' => '{{desc}}',
	'masseditregextext' => 'Replace <code>/en/</code> in the middle in link <code>http://php.net/manual/en/function.preg-replace.php</code> with your language code between slashes, if that page exists. Otherwise leave it as is to link to the English documentation, or choose an appropriate fallback language code.',
	'masseditregex-hint-headmatch' => "Noun. This is a column header for the 'match' regexes.",
	'masseditregex-hint-headreplace' => '{{Identical|Replace}}',
	'right-masseditregex' => '{{doc-right|masseditregex}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'masseditregex' => 'Wysig baie bladsye met behulp van gereelde uitdrukkings',
	'masseditregex-pagelisttxt' => 'Bladsye om te wysig:',
	'masseditregex-matchtxt' => 'Soek vir:',
	'masseditregex-replacetxt' => 'Vervang met:',
	'masseditregex-executebtn' => 'Uitvoer',
	'masseditregex-err-nopages' => 'U moet ten minste een bladsy spesifiseer om te verander.',
	'masseditregex-before' => 'Voor',
	'masseditregex-after' => 'Na',
	'masseditregex-max-preview-diffs' => 'Voorskou is beperk tot die eerste $1 {{PLURAL:$1|ooreenkoms|ooreenkomste}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|wysiging|wysigings}}',
	'masseditregex-page-not-exists' => '$1 bestaan nie',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|bladsy|bladsye}} gewysig',
	'masseditregex-view-full-summary' => 'Sien samevatting van wysigings',
	'masseditregex-hint-intro' => "Hier is 'n paar wenke en voorbeelde vir die uitvoer van algemene take:",
	'masseditregex-hint-headmatch' => 'Seleksie',
	'masseditregex-hint-headreplace' => 'Vervang',
	'masseditregex-hint-headeffect' => 'Effek',
	'masseditregex-hint-remove' => 'Verwyder teks uit al die bladsye in die lys',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'masseditregex' => 'Mass redakto duke përdorur shprehjet e rregullta',
	'masseditregex-desc' => 'Përdorni shprehje të rregullta për të [[Special:MassEditRegex|redakto shumë faqe në një operacion]]',
	'masseditregextext' => 'Shkruani një ose më shumë shprehjet e rregullta (një për çdo rresht) për matching, dhe një ose më shumë shprehje për të zëvendësuar çdo ndeshje me të. Parë ndeshjen shprehjes-, në qoftë se e suksesshme, do të zëvendësohet me-zëvendësuar shprehjen e parë, dhe kështu me radhë. Shihni [http://php.net/manual/en/function.preg-replace.php  funksion PHP preg_replace()] për hollësi të mëtejshme.',
	'masseditregex-pagelisttxt' => 'Faqet e për të redaktuar (mos përdorni një hapësira: parashtesë):',
	'masseditregex-matchtxt' => 'Kërko për:',
	'masseditregex-replacetxt' => 'Replace me:',
	'masseditregex-executebtn' => 'Kryej',
	'masseditregex-err-nopages' => 'Ju duhet të caktoni të paktën një faqe të ndryshojë.',
	'masseditregex-before' => 'Para',
	'masseditregex-after' => 'Pas',
	'masseditregex-max-preview-diffs' => 'Preview ka qenë e kufizuar në të parë $1 {{PLURAL:$1|ndeshje|ndeshje}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2 |ndryshim|ndryshime}}',
	'masseditregex-page-not-exists' => '$1 nuk ekziston',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|faqe|faqe}} redaktuar',
	'masseditregex-view-full-summary' => 'Shiko redakto përmbledhje të plotë',
	'masseditregex-hint-intro' => 'Këtu janë disa këshilla dhe shembuj për kryerjen e detyrave të përbashkëta:',
	'masseditregex-hint-headmatch' => 'Ndeshje',
	'masseditregex-hint-headreplace' => 'Replace',
	'masseditregex-hint-headeffect' => 'Efekt',
	'masseditregex-hint-toappend' => 'Append tekst në fund të faqes - e madhe për shtimin e faqeve të kategorive',
	'masseditregex-hint-remove' => 'Hiq një tekst nga të gjitha faqet në listë',
	'masseditregex-hint-removecat' => 'Hiq të gjitha kategoritë nga një faqe (vini re ikin e kllapa katrore në wikicode.) Vlerat zëvendësimin nuk duhet të shpëtuar.',
	'masseditregex-listtype-intro' => 'Kjo është një listë e:',
	'masseditregex-listtype-pagenames' => 'emrat Page (edit këto faqe)',
	'masseditregex-listtype-pagename-prefixes' => 'Emri prefikset e faqes (redaktuar faqe që emrat që fillojnë me këtë tekst)',
	'masseditregex-listtype-categories' => 'emrat e Kategorise (redakto çdo faqe në kuadër të këtyre kategorive; përzgjedhjes hapësira është injoruar)',
	'masseditregex-listtype-backlinks' => 'Backlinks (redaktuar faqe që lidhen me këto ato)',
	'masseditregex-namespace-intro' => 'Të gjitha këto faqe janë në këtë hapësirën:',
	'masseditregex-exprnomatch' => 'Shprehja "$1" përputhet me asnjë faqe.',
	'masseditregex-badregex' => 'regex pavlefshme:',
	'masseditregex-editfailed' => 'Edit dështoi:',
	'masseditregex-tooltip-execute' => 'Aplikoni këto ndryshime në çdo faqe',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'masseditregex' => 'تعديل كمي باستخدام التعبيرات المنتظمة',
	'masseditregex-desc' => 'استخدم التعبيرات القياسية [[Special:MassEditRegex|لتعديل صفحات كثيرة في عملية واحدة]]',
	'masseditregextext' => 'أدخل تعبيرا نتظما واحدا أو أكثر (واحد لكل سطر) للمطابقة, وتعبير واحد أو أكثر لاستبدال كل مطابقة به.
أول مطابقة تعبير، لو كان ناجحا، سيتم استبداله بأول تعبير استبدال، وهكذا.
انظر [http://php.net/manual/en/function.preg-replace.php وظيفة PHP preg_replace()] للتفاصيل.',
	'masseditregex-pagelisttxt' => 'الصفحات للتعديل (لا تستخدم بادئة نطاق:):',
	'masseditregex-matchtxt' => 'ابحث عن:',
	'masseditregex-replacetxt' => 'استبدل بـ:',
	'masseditregex-executebtn' => 'شغّل',
	'masseditregex-err-nopages' => 'يجب أن تحدّد صفحة واحدة على الأقل لتغييرها.',
	'masseditregex-before' => 'قبل',
	'masseditregex-after' => 'بعد',
	'masseditregex-max-preview-diffs' => 'المعاينة تم قصرها على أول $1 {{PLURAL:$1|مطابقة|مطابقات}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|تغيير|تغييرات}}',
	'masseditregex-page-not-exists' => '$1 غير موجود',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|صفحة|صفحات}} تم تعديلها',
	'masseditregex-view-full-summary' => 'عرض ملخص التعديل الكامل',
	'masseditregex-hint-intro' => 'هنا بعض النصائح والأمثلة لتنفيذ المهام الشائعة:',
	'masseditregex-hint-headmatch' => 'مطابقة',
	'masseditregex-hint-headreplace' => 'استبدل',
	'masseditregex-hint-headeffect' => 'تأثير',
	'masseditregex-hint-toappend' => 'أضف بعض النصوص إلى نهاية الصفحة - رائع لإضافة الصفحات إلى التصنيفات',
	'masseditregex-hint-remove' => 'أزل بعض النصوص من كل الصفحات في القائمة',
	'masseditregex-hint-removecat' => 'أزل كل التصنيفات من صفحة (لاحظ هروب الأقواس المربعة في كود الويكي.)
قيم الاستبدال لا ينبغي تهريبها.',
	'masseditregex-listtype-intro' => 'هذه قائمة بـ:',
	'masseditregex-listtype-pagenames' => 'أسماء الصفحات (عدل هذه الصفحات)',
	'masseditregex-listtype-pagename-prefixes' => 'بادئات أسماء الصفحات (عدل الصفحات بأسماء تبدأ بهذا النص)',
	'masseditregex-listtype-categories' => 'أسماء التصنيفات (عدل كل صفحة في هذه التصنيفات؛ اختيار النطاق يتم تجاهله)',
	'masseditregex-listtype-backlinks' => 'الوصلات الراجعة (عدل الصفحات التي تصل إلى هذه الصفحات)',
	'masseditregex-namespace-intro' => 'كل هذه الصفحات في هذا النطاق:',
	'masseditregex-exprnomatch' => 'التعبير "$1" لم يطابق أي صفحة.',
	'masseditregex-badregex' => 'عبارة منطقية غير صالحة:',
	'masseditregex-editfailed' => 'التعديل فشل:',
	'masseditregex-tooltip-execute' => 'طبق هذه التغييرات على كل صفحة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'masseditregex-matchtxt' => 'ܒܨܝ ܥܠ:',
	'masseditregex-before' => 'ܩܕܡ',
	'masseditregex-after' => 'ܒܬܪ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'masseditregex' => 'تعديل كمى باستخدام التعبيرات المنتظمة',
	'masseditregex-desc' => 'استخدم التعبيرات القياسيه [[Special:MassEditRegex|لتعديل صفحات كثيره فى عمليه واحدة]]',
	'masseditregextext' => 'أدخل تعبيرا نتظما واحدا أو أكثر (واحد لكل سطر) للمطابقة, وتعبير واحد أو أكثر لاستبدال كل مطابقه به.
أول مطابقه تعبير، لو كان ناجحا، سيتم استبداله بأول تعبير استبدال، وهكذا.
انظر [http://php.net/manual/en/function.preg-replace.php وظيفه PHP preg_replace()] للتفاصيل.',
	'masseditregex-pagelisttxt' => 'الصفحات للتعديل (لا تستخدم بادئه نطاق:):',
	'masseditregex-matchtxt' => 'ابحث عن:',
	'masseditregex-replacetxt' => 'استبدل بـ:',
	'masseditregex-executebtn' => 'شغّل',
	'masseditregex-err-nopages' => 'يجب أن تحدّد صفحه واحده على الأقل لتغييرها.',
	'masseditregex-before' => 'قبل',
	'masseditregex-after' => 'بعد',
	'masseditregex-max-preview-diffs' => 'المعاينه تم قصرها على أول $1 {{PLURAL:$1|مطابقة|مطابقات}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|تغيير|تغييرات}}',
	'masseditregex-page-not-exists' => '$1 غير موجود',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|صفحة|صفحات}} تم تعديلها',
	'masseditregex-view-full-summary' => 'عرض ملخص التعديل الكامل',
	'masseditregex-hint-intro' => 'هنا بعض النصائح والأمثله لتنفيذ المهام الشائعة:',
	'masseditregex-hint-headmatch' => 'مطابقة',
	'masseditregex-hint-headreplace' => 'استبدل',
	'masseditregex-hint-headeffect' => 'تأثير',
	'masseditregex-hint-toappend' => 'أضف بعض النصوص إلى نهايه الصفحه - رائع لإضافه الصفحات إلى التصنيفات',
	'masseditregex-hint-remove' => 'أزل بعض النصوص من كل الصفحات فى القائمة',
	'masseditregex-hint-removecat' => 'أزل كل التصنيفات من صفحه (لاحظ هروب الأقواس المربعه فى كود الويكى.)
قيم الاستبدال لا ينبغى تهريبها.',
	'masseditregex-listtype-intro' => 'هذه قائمه بـ:',
	'masseditregex-listtype-pagenames' => 'أسماء الصفحات (عدل هذه الصفحات)',
	'masseditregex-listtype-pagename-prefixes' => 'بادئات أسماء الصفحات (عدل الصفحات بأسماء تبدأ بهذا النص)',
	'masseditregex-listtype-categories' => 'أسماء التصنيفات (عدل كل صفحه فى هذه التصنيفات؛ اختيار النطاق يتم تجاهله)',
	'masseditregex-listtype-backlinks' => 'الوصلات الراجعه (عدل الصفحات التى تصل إلى هذه الصفحات)',
	'masseditregex-namespace-intro' => 'كل هذه الصفحات فى هذا النطاق:',
	'masseditregex-exprnomatch' => 'التعبير "$1" لم يطابق أى صفحه.',
	'masseditregex-badregex' => 'عباره منطقيه غير صالحة:',
	'masseditregex-editfailed' => 'التعديل فشل:',
	'masseditregex-tooltip-execute' => 'طبق هذه التغييرات على كل صفحة',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'masseditregex-matchtxt' => 'Axtarış üçün:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'action-masseditregex' => 'выкананьне масавага рэдагаваньня',
	'masseditregex' => 'Масавае рэдагаваньне з выкарыстаньнем рэгулярных выразаў',
	'masseditregex-desc' => 'Выкарыстаньне рэгулярных выразаў для [[Special:MassEditRegex|рэдагаваньня некалькіх старонак за адно дзеяньне]]',
	'masseditregextext' => 'Увядзіце адзін альбо некалькі рэгулярных выразаў (адзін на радок) для пошуку супадзеньняў, і адзін альбо некалькі выразаў для замены кожнага супадзеньня.
Першы пасьпяховае супадзеньне з выразам будзе замененае на першы выраз для замены і гэтак далей. Глядзіце падрабязнасьці пра функцыю [http://php.net/manual/en/function.preg-replace.php PHP preg_replace()].',
	'masseditregex-pagelisttxt' => 'Старонкі для рэдагаваньня (не выкарыстоўвайце прэфікс прастора назваў:):',
	'masseditregex-matchtxt' => 'Пошук:',
	'masseditregex-replacetxt' => 'Замяніць на:',
	'masseditregex-executebtn' => 'Выканаць',
	'masseditregex-err-nopages' => 'Вам неабходна пазначыць хаця б адну старонку для рэдагаваньня.',
	'masseditregex-before' => 'Перад',
	'masseditregex-after' => 'Пасьля',
	'masseditregex-max-preview-diffs' => 'Папярэдні прагляд абмежаваны $1 {{PLURAL:$1|першым супадзеньнем|першымі супадзеньнямі|першымі супадзеньнямі}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|зьмена|зьмены|зьменаў}}',
	'masseditregex-page-not-exists' => '$1 не існуе',
	'masseditregex-num-articles-changed' => '{{PLURAL:$1|адрэдагаваная|адрэдагаваныя|адрэдагаваныя}} $1 {{PLURAL:$1|старонка|старонкі|старонак}}',
	'masseditregex-view-full-summary' => 'Паказаць поўнае апісаньне зьменаў',
	'masseditregex-hint-intro' => 'Тут пададзеныя некалькі падказак і прыкладаў для выкананьня агульных заданьняў:',
	'masseditregex-hint-headmatch' => 'Супадзеньне',
	'masseditregex-hint-headreplace' => 'Замена',
	'masseditregex-hint-headeffect' => 'Вынік',
	'masseditregex-hint-toappend' => 'Далучыць нейкі тэкст да канца старонкі —- выдатна пасуе для даданьня катэгорыяў у старонкі',
	'masseditregex-hint-remove' => 'Выдаліць некаторы тэкст з усіх старонак у сьпісе',
	'masseditregex-hint-removecat' => 'Выдаліць усе катэгорыі са старонкі (заўважце, што выдаляюцца толькі квадратныя дужкі з вікі-коду.)
Значэньні да замяшчэньня не павінны быць уключаныя ў двукосьсі альбо апострафы.',
	'masseditregex-listtype-intro' => 'Гэта сьпіс:',
	'masseditregex-listtype-pagenames' => 'Назвы старонак (рэдагаваць гэтыя старонкі)',
	'masseditregex-listtype-pagename-prefixes' => 'Прэфіксы назваў старонак (рэдагаваць старонкі, назвы якіх пачынаюцца з гэтага тэксту)',
	'masseditregex-listtype-categories' => 'Назвы катэгорыяў (рэдагаваць кожную старонку ў гэтых катэгорыях; прасторы назваў не ўлічваюцца)',
	'masseditregex-listtype-backlinks' => 'Адваротныя спасылкі (рэдагаваць старонкі, якія спасылаюцца на гэтую)',
	'masseditregex-namespace-intro' => 'Усе гэтыя старонкі знаходзяцца ў гэтай прасторы назваў:',
	'masseditregex-exprnomatch' => 'Выраз «$1» не адпавядае ні адной старонцы.',
	'masseditregex-badregex' => 'Няслушны рэгулярны выраз:',
	'masseditregex-editfailed' => 'Рэдагаваньне не атрымалася:',
	'masseditregex-tooltip-execute' => 'Прыняць гэтыя зьмены для кожнай старонкі',
	'right-masseditregex' => 'замена зьместу старонак з дапамогай рэгулярных выразаў',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'masseditregex-matchtxt' => 'Търсене за:',
	'masseditregex-replacetxt' => 'Заместване с:',
	'masseditregex-executebtn' => 'Изпълняване',
	'masseditregex-before' => 'Преди',
	'masseditregex-after' => 'След',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|промяна|промени}}',
	'masseditregex-page-not-exists' => '$1 не съществува',
	'masseditregex-hint-headreplace' => 'Заместване',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'masseditregex' => 'রেগুলার এক্সপ্রেশন ব্যবহার করে গণ সম্পাদনা',
	'masseditregex-matchtxt' => 'অনুসন্ধান:',
	'masseditregex-replacetxt' => 'যা দিয়ে প্রতিস্থাপিত হবে:',
	'masseditregex-executebtn' => 'এক্সকিউট',
	'masseditregex-err-nopages' => 'আপনাকে অবশ্যই পরিবর্তনের জন্য কমপক্ষে একটি পাতা নির্বাচন করতে হবে।',
	'masseditregex-before' => 'পূর্বে',
	'masseditregex-after' => 'পরে',
	'masseditregex-view-full-summary' => 'সম্পূর্ণ সম্পাদনা সারাংশ পরিদর্শন',
	'masseditregex-hint-headmatch' => 'সাদৃশ্য',
	'masseditregex-hint-headreplace' => 'প্রতিস্থাপিত',
	'masseditregex-hint-headeffect' => 'প্রভাব',
	'masseditregex-listtype-intro' => 'এটি যার তালিকা:',
	'masseditregex-listtype-pagenames' => 'পাতার নাম (এই পাতাগুলি সম্পাদনা করুন)',
	'masseditregex-badregex' => 'ত্রুটিপূর্ণ রিজেক্স:',
	'masseditregex-editfailed' => 'সম্পাদনা ব্যর্থ:',
	'masseditregex-tooltip-execute' => 'প্রতিটি পাতায় এই পরিবর্তন প্রয়োগ করো',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'masseditregex' => 'Kemmoù a-vras gant sikour eztaoladennoù poellel',
	'masseditregex-desc' => 'Implijout an eztaoladennoù poellel evit [[Special:MassEditRegex|kemmañ un toullad pajennoù en un taol]]',
	'masseditregextext' => "Merkañ ur jedad poellek pe meur a hini (unan dre linenn) da glask hag ur jedad pe meur a hini da erlec'hiañ disoc'hoù pep hini gantañ.
Erlec'hiet e vo ar jedad kavet da gentañ gant ar jedad erlec'hiañ kentañ ha kement-all da-heul.
Gwelet [http://php.net/manual/en/function.preg-replace.php the PHP function preg_replace()] da c'houzout hiroc'h.",
	'masseditregex-pagelisttxt' => 'Pajennoù da gemmañ (hep rakger an esaouenn anvioù) :',
	'masseditregex-matchtxt' => 'Klask :',
	'masseditregex-replacetxt' => "Erlec'hiañ gant :",
	'masseditregex-executebtn' => 'Seveniñ',
	'masseditregex-err-nopages' => "Rankout a rit menegiñ ur bajenn da gemm d'an nebeutañ.",
	'masseditregex-before' => 'A-raok',
	'masseditregex-after' => 'Goude',
	'masseditregex-max-preview-diffs' => "Bevennet eo ar rakweladenn d'{{PLURAL:$1|an disoc'h kentañ|ar $1 disoc'h kentañ}}.",
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|kemm|kemm}}',
	'masseditregex-page-not-exists' => "N'eus ket eus $1",
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|pennad|pennad}} kemmet',
	'masseditregex-view-full-summary' => "Gwelet diverrañ klok ar c'hemmoù",
	'masseditregex-hint-intro' => 'Setu amañ titouroù ha skouerioù evit ober war-dro an trevelloù boaz :',
	'masseditregex-hint-headmatch' => 'Klotadenn',
	'masseditregex-hint-headreplace' => "Erlec'hiañ",
	'masseditregex-hint-headeffect' => 'Efed',
	'masseditregex-hint-toappend' => "Ensoc'hañ un tamm testenn e fin ar bajenn - efedus evit ouzhpennañ pajennoù e rummadoù",
	'masseditregex-hint-remove' => 'Tennañ kuit un tamm destenn eus holl bajennoù ar roll',
	'masseditregex-hint-removecat' => "Lemel kuit an holl rummadoù zo en ur pennad (notit e vez lezet ar c'hrochedoù er-maez er chod wiki).
N'haller ket lezel er-maez an talvoudennoù erlec'hiañ.",
	'masseditregex-listtype-intro' => 'Setu ur roll :',
	'masseditregex-listtype-pagenames' => 'Anv ar bajennoù (kemmañ ar bajennoù-se)',
	'masseditregex-listtype-pagename-prefixes' => 'Rakger anvioù pajennoù (aozañ ar pajennoù a grog o anv gant an destenn-se)',
	'masseditregex-listtype-categories' => "Anv ar rummadoù (kemmañ pep pajenn a zo er rummadoù-se ; graet 'vez van eus diuzadenn an esaouenn anv)",
	'masseditregex-listtype-backlinks' => 'Pajennoù liammet (kemmañ ar pajennoù enno ul liamm davet houmañ)',
	'masseditregex-namespace-intro' => 'Emañ an holl bajennoù-mañ en esaouenn anv :',
	'masseditregex-exprnomatch' => 'N\'eo bet kavet ar jedad "$1" e pajenn ebet.',
	'masseditregex-badregex' => "N'eo ket mat ar regex :",
	'masseditregex-editfailed' => "C'hwitet an aozañ :",
	'masseditregex-tooltip-execute' => "Arloañ ar c'hemmoù-se da bep pajenn",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'masseditregex-desc' => 'Korištenje regularnih izraza za [[Special:MassEditRegex|uređivanje više stranica u jednoj operaciji]]',
	'masseditregex-pagelisttxt' => 'Stranice za uređivanje (ne koristite imenski prostor: prefiks):',
	'masseditregex-matchtxt' => 'Traži:',
	'masseditregex-replacetxt' => 'Zamijeni sa:',
	'masseditregex-executebtn' => 'Izvrši',
	'masseditregex-err-nopages' => 'Morate navesti barem jednu stranicu koja se treba mijenjati.',
	'masseditregex-before' => 'Prije',
	'masseditregex-after' => 'Poslije',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|izmjena|izmjene|izmjena}}',
	'masseditregex-page-not-exists' => '$1 ne postoji',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|stranica|stranice|stranica}} uređeno',
	'masseditregex-view-full-summary' => 'Pogledaj puni sažetak izmjene',
	'masseditregex-hint-headmatch' => 'Slaganja',
	'masseditregex-hint-headreplace' => 'Zamjena',
	'masseditregex-hint-headeffect' => 'Efekat',
	'masseditregex-listtype-intro' => 'Ovo je spisak:',
	'masseditregex-listtype-pagenames' => 'Nazivi stranica (uredite ove stranice)',
	'masseditregex-editfailed' => 'Uređivanje neuspjelo:',
	'masseditregex-tooltip-execute' => 'Primijeni ove izmjene na svaku stranicu',
);

/** Catalan (Català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'masseditregex' => 'Edició massiva utilitzant expressions regulars',
	'masseditregex-matchtxt' => 'Cerca:',
	'masseditregex-replacetxt' => 'Reemplaça per:',
	'masseditregex-before' => 'Abans',
	'masseditregex-after' => 'Després',
	'masseditregex-hint-headreplace' => 'Reemplaça',
	'masseditregex-listtype-intro' => 'Això és una llista de:',
	'masseditregex-listtype-pagenames' => 'Noms de les pàgines (editeu aquestes pàgines)',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'masseditregex-matchtxt' => 'Najít:',
	'masseditregex-replacetxt' => 'Nahradit za:',
	'masseditregex-before' => 'Před',
	'masseditregex-after' => 'Po',
	'masseditregex-hint-headreplace' => 'Nahradit',
);

/** German (Deutsch)
 * @author Imre
 * @author Kghbln
 * @author LWChris
 * @author Pill
 * @author SVG
 * @author Tbleher
 */
$messages['de'] = array(
	'action-masseditregex' => 'eine Sammelbearbeitung mithilfe regulärer Ausdrücke durchzuführen',
	'masseditregex' => 'Sammelbearbeitung mithilfe regulärer Ausdrücke',
	'masseditregex-desc' => 'Ermöglicht die Nutzung regulärer Ausdrücke zur Sammelbearbeitung [[Special:MassEditRegex|vieler Seiten auf einmal]]',
	'masseditregextext' => 'Gib einen oder mehrere reguläre Ausdrücke (eine pro Zeile) für die Suche an, und einen oder mehrere Ausdrücke um einen jeweiligen Treffer zu ersetzen. Der erste Such-Ausdruck wird bei Übereinstimmung durch den ersten Ersatz-Ausdruck ersetzt, und so weiter. Siehe [http://php.net/manual/de/function.preg-replace.php die Dokumentation der PHP-Funktion preg_replace ()] für Details.',
	'masseditregex-pagelisttxt' => 'Zu bearbeitende Seiten (kein Namensraum-Prefix benutzen):',
	'masseditregex-matchtxt' => 'Suchen nach:',
	'masseditregex-replacetxt' => 'Ersetzen durch:',
	'masseditregex-executebtn' => 'Ausführen',
	'masseditregex-err-nopages' => 'Du musst mindestens eine Seite festlegen, die geändert werden soll.',
	'masseditregex-before' => 'Vorher',
	'masseditregex-after' => 'Nachher',
	'masseditregex-max-preview-diffs' => 'Die Vorschau wurde auf {{PLURAL:$1|den|die}} ersten $1 Treffer begrenzt.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|Änderung|Änderungen}}',
	'masseditregex-page-not-exists' => '$1 existiert nicht',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|Seite|Seiten}} bearbeitet',
	'masseditregex-view-full-summary' => 'Vollständigen Bearbeitungskommentar anzeigen',
	'masseditregex-hint-intro' => 'Hier sind einige Hinweise und Beispiele, um allgemeine Aufgaben durchzuführen:',
	'masseditregex-hint-headmatch' => 'Treffer',
	'masseditregex-hint-headreplace' => 'Ersetzen',
	'masseditregex-hint-headeffect' => 'Effekt',
	'masseditregex-hint-toappend' => 'Text an das Ende der Seite anhängen - großartig um Seiten Kategorien hinzuzufügen',
	'masseditregex-hint-remove' => 'Text von allen Seiten in der Liste entfernen',
	'masseditregex-hint-removecat' => 'Alle Kategorien von einer Seite entfernen (bitte beachten, dass die eckigen Klammern im Wikicode ausgelassen werden).
Die Ersetzungswerte sollten nicht ausgelassen werden.',
	'masseditregex-listtype-intro' => 'Dies ist eine Liste von:',
	'masseditregex-listtype-pagenames' => 'Seitennamen (diese Seiten bearbeiten)',
	'masseditregex-listtype-pagename-prefixes' => 'Seitennamen-Präfixe (Seiten bearbeiten, die mit diesem Text beginnen)',
	'masseditregex-listtype-categories' => 'Kategorienamen (jede Seite innerhalb dieser Kategorien bearbeiten; Namensraumauswahl wird ignoriert)',
	'masseditregex-listtype-backlinks' => 'Rückverweise (Seiten bearbeiten, die auf diese verlinken)',
	'masseditregex-namespace-intro' => 'All diese Seiten sind in diesem Namensraum:',
	'masseditregex-exprnomatch' => 'Der Ausdruck „$1“ ergab keinen Treffer.',
	'masseditregex-badregex' => 'Ungültiger regulärer Ausdruck:',
	'masseditregex-editfailed' => 'Bearbeitung fehlgeschlagen:',
	'masseditregex-tooltip-execute' => 'Diese Änderungen an jeder Seite durchführen',
	'right-masseditregex' => 'Textersetzungen mit regulären Ausdrücken durchführen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author LWChris
 */
$messages['de-formal'] = array(
	'masseditregextext' => 'Geben Sie einen oder mehrere reguläre Ausdrücke (eine pro Zeile) für die Suche an, und einen oder mehrere Ausdrücke um einen jeweiligen Treffer zu ersetzen. Der erste Such-Ausdruck wird bei Übereinstimmung durch den ersten Ersatz-Ausdruck ersetzt, und so weiter. Siehe [ http://php.net/manual/de/function.preg-replace.php der PHP-Funktion preg_replace ()] für Details.',
	'masseditregex-err-nopages' => 'Sie müssen mindestens eine Seite festlegen, die geändert werden soll.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'action-masseditregex' => 'masowe wobźěłanje pśewjasć',
	'masseditregex' => 'Masowe wobźěłanje z pomocu regularnych wurazow',
	'masseditregex-desc' => 'Regularne wuraze wužywaś, aby se [[Special:MassEditRegex|wjele bokow w jadnej opberaciji wobźěłało]]',
	'masseditregextext' => 'Zapódaj jaden regularny wuraz abo wěcej regularnych wurazow (jaden na smužku) za pytanje a jaden wuraz abo wěcej wurazow, kótarež maju kuždy wótpowědnik wuměniś.
Prědny pytański wuraz buźo se, jolic namakany, pśez prědny wuměneński wuraz wuměniś atd.
Glědaj [http://php.net/manual/de/function.preg-replace.php the PHP function preg_replace()] za drobnostki.',
	'masseditregex-pagelisttxt' => 'Boki, kótarež maju se wobźěłaś (njewužyj prefiks mjenjowego ruma):',
	'masseditregex-matchtxt' => 'Pytaś za:',
	'masseditregex-replacetxt' => 'Wuměniś pśez:',
	'masseditregex-executebtn' => 'Wuwjasć',
	'masseditregex-err-nopages' => 'Musyš nanejmjenjej jaden bok pódaś, kótaryž ma se změniś.',
	'masseditregex-before' => 'Do togo',
	'masseditregex-after' => 'Pótom',
	'masseditregex-max-preview-diffs' => 'Pśeglěd jo na {{PLURAL:$1|prědny wótpowědnik|prědnej $1 wótpowědnika|prědne $1 wótpowědniki|prědnych $1 wótpowědnikow}} wobgranicowany.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|změna|změnje|změny|změnow}}',
	'masseditregex-page-not-exists' => '$1 njeeksistěrujo',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|bok wobźěłany|boka wobźěłanej|boki wobźěłane|bokow wobźěłanych}}',
	'masseditregex-view-full-summary' => 'Połne wobźěłowańske zespominanje se woglědaś',
	'masseditregex-hint-intro' => 'How su někotare pokazki a pśikłady za pśewjeźenje powšyknych nadawkow:',
	'masseditregex-hint-headmatch' => 'Wótpowědnik',
	'masseditregex-hint-headreplace' => 'Wuměniś',
	'masseditregex-hint-headeffect' => 'Efekt',
	'masseditregex-hint-toappend' => 'Tekst ku kóńcoju boka pśipowjesyś - dobre za pśidawanje bokow kategorijam',
	'masseditregex-hint-remove' => 'Tekst ze wšyknych w lisćinje wótpóraś',
	'masseditregex-hint-removecat' => 'Wšykne kategorije z boka wótpóraś (źiwaj na maskěrowanje rožkatych spinkow we wikikoźe.) Wuměnjeńske gódnoty njeby se měli maskěrowaś.',
	'masseditregex-listtype-intro' => 'To jo lisćina wót:',
	'masseditregex-listtype-pagenames' => 'Mjenja bokow (toś te boki wobźěłaś)',
	'masseditregex-listtype-pagename-prefixes' => 'Prefikse mjenjow bokow (boki wobźěłaś, kótarychž mjenja zachopiju se toś tym tekstom)',
	'masseditregex-listtype-categories' => 'Kategorijowe mjenja (kuždy bok w toś tych kategorijach wobźěłaś; wubrany mjenjowy rum se ignorěrujo)',
	'masseditregex-listtype-backlinks' => 'Slědkwótkaze (boki wobźěłaś, kótarež na tos te wótkazuju)',
	'masseditregex-namespace-intro' => 'Wšykne toś te boki su w toś tom mjenjowem rumje:',
	'masseditregex-exprnomatch' => 'Wuraz "$1" njegóźi se na žedne boki.',
	'masseditregex-badregex' => 'Njepłaśiwy regularny wuraz:',
	'masseditregex-editfailed' => 'Wobźěłanje jo se njeraźiło:',
	'masseditregex-tooltip-execute' => 'Toś te změny na kuždy bok nałožyś',
	'right-masseditregex' => 'Wopśimjeśe boka z pomocu regularnych wurazow wuměniś',
);

/** Greek (Ελληνικά)
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'masseditregex' => 'Μαζική επεξεργασία με χρήση τακτικών εκφράσεων',
	'masseditregex-matchtxt' => 'Αναζήτηση για:',
	'masseditregex-replacetxt' => 'Αντικατάσταση με:',
	'masseditregex-executebtn' => 'Εκτέλεση',
	'masseditregex-before' => 'Πριν',
	'masseditregex-after' => 'Μετά',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|αλλαγή|αλλαγές}}',
	'masseditregex-page-not-exists' => '$1 δεν υπάρχει',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|σελίδα|σελίδες}} επεξεργασμένες',
	'masseditregex-hint-headreplace' => 'Αντικατάσταση',
	'masseditregex-hint-headeffect' => 'Αποτέλεσμα',
	'masseditregex-listtype-intro' => 'Αυτή είναι μια λίστα από:',
	'masseditregex-editfailed' => 'Αποτυχία επεξεργασίας:',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'masseditregex-matchtxt' => 'Serĉi',
	'masseditregex-replacetxt' => 'Anstataŭigi kun:',
	'masseditregex-editfailed' => 'Redakto malsukcesis:',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dferg
 * @author Translationista
 */
$messages['es'] = array(
	'masseditregex' => 'Edición en masa usando expresiones regulares',
	'masseditregex-desc' => 'Utilice expresiones regulares para [[Special:MassEditRegex|editar varias páginas en una sola operación]]',
	'masseditregextext' => 'Introduzca una o más expresiones regulares (una por línea) para lograr coincidencias, y una o más expresiones con las que sustituir cada coincidencia. Si se logra con éxito, la primera expresión de coincidencia se reemplazará con la primera expresión de sustitución, y así sucesivamente. Si deseas conocer más detales, consulta [http://php.net/manual/en/function.preg-replace.php la función PHPpreg_replace()]',
	'masseditregex-pagelisttxt' => 'Páginas a editar (no usar un espacio de nombre: prefijo):',
	'masseditregex-matchtxt' => 'Buscar:',
	'masseditregex-replacetxt' => 'Reemplazar con:',
	'masseditregex-executebtn' => 'Ejecutar',
	'masseditregex-err-nopages' => 'Debes especificar al menos una página a cambiar.',
	'masseditregex-before' => 'Antes',
	'masseditregex-after' => 'Después',
	'masseditregex-max-preview-diffs' => 'La previsualización se ha limitado a la primera $1 {{PLURAL:$1|coincidencia|coincidencias}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|cambio|cambios}}',
	'masseditregex-page-not-exists' => '$1 no existe',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|página|páginas}} editadas',
	'masseditregex-view-full-summary' => 'Ver resumen de edición completo',
	'masseditregex-hint-intro' => 'Aquí encontrarás algunas pistas y ejemplos de cómo lograr tareas comunes:',
	'masseditregex-hint-headmatch' => 'Coincidencia',
	'masseditregex-hint-headreplace' => 'Reemplazar',
	'masseditregex-hint-headeffect' => 'Efecto',
	'masseditregex-hint-toappend' => 'Añade texto al final de la página. Excelente para añadir páginas a categorías',
	'masseditregex-hint-remove' => 'Eliminar algún texto de todas las páginas del listado',
	'masseditregex-hint-removecat' => 'Eliminar todas las categorías de una página (nota la exclusión de los corchetes en el código wiki.) 
Los valores de reposición no deben excluirse.',
	'masseditregex-listtype-intro' => 'Esta es una lista de:',
	'masseditregex-listtype-pagenames' => 'Nombres de página (edita estas páginas)',
	'masseditregex-listtype-pagename-prefixes' => 'Prefijos de nombre de página (edita páginas con nombres que comienzan con este texto)',
	'masseditregex-listtype-categories' => 'Nombres de categorías (editar cada página incluida en estas categorías; se ignora la selección del espacio de nombre)',
	'masseditregex-listtype-backlinks' => 'Vínculos de retorno (edita páginas de se vinculen a éstas)',
	'masseditregex-namespace-intro' => 'Todas estas páginas están en este espacio de nombre:',
	'masseditregex-exprnomatch' => 'La expresión $1 no coincidió con ninguna página.',
	'masseditregex-badregex' => 'Expresión regular inválida:',
	'masseditregex-editfailed' => 'Edición fallida:',
	'masseditregex-tooltip-execute' => 'Aplicar estos cambios a cada página',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Str4nd
 */
$messages['fi'] = array(
	'masseditregex-executebtn' => 'Suorita',
	'masseditregex-before' => 'Ennen',
	'masseditregex-after' => 'Jälkeen',
	'masseditregex-view-full-summary' => 'Näytä koko muokkausyhteenveto',
	'masseditregex-hint-headmatch' => 'Osuma',
	'masseditregex-hint-headreplace' => 'Korvaa',
	'masseditregex-editfailed' => 'Muokkaus epäonnistui:',
	'masseditregex-tooltip-execute' => 'Käytä näitä muutoksia joka sivuun',
);

/** French (Français)
 * @author Gomoko
 * @author IAlex
 * @author Peter17
 * @author PieRRoMaN
 * @author Quentinv57
 * @author Urhixidur
 * @author Zetud
 */
$messages['fr'] = array(
	'action-masseditregex' => 'effectuer une modification en masse',
	'masseditregex' => "Modification en masse à l'aide des expressions rationnelles",
	'masseditregex-desc' => 'Utiliser les expressions rationnelles pour [[Special:MassEditRegex|modifier de nombreuses pages en une opération]]',
	'masseditregextext' => 'Entrer une ou plusieurs expressions rationnelles (une par ligne) à rechercher, et une ou plusieurs expressions par lesquelles remplacer les résultats. La première expression trouvée sera remplacée par la première expression de remplacement, et ainsi de suite. Voir la description de la [http://php.net/manual/en/function.preg-replace.php fonction PHP preg_replace()] pour plus de détails.',
	'masseditregex-pagelisttxt' => "Pages à modifier (sans le préfixe de l'espace de noms) :",
	'masseditregex-matchtxt' => 'Rechercher :',
	'masseditregex-replacetxt' => 'Remplacer par :',
	'masseditregex-executebtn' => 'Exécuter',
	'masseditregex-err-nopages' => 'Vous devez spécifier au moins une page à modifier.',
	'masseditregex-before' => 'Avant',
	'masseditregex-after' => 'Après',
	'masseditregex-max-preview-diffs' => 'La prévisualisation a été limitée {{PLURAL:$1|au premier résultat|aux $1 premiers résultats}}.',
	'masseditregex-num-changes' => '$1 : $2 {{PLURAL:$2|modification|modifications}}',
	'masseditregex-page-not-exists' => "$1 n'existe pas",
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|article modifié|articles modifiés}}',
	'masseditregex-view-full-summary' => 'Voir le résumé complet des modifications',
	'masseditregex-hint-intro' => 'Voici quelques indications et exemples pour réaliser les tâches usuelles :',
	'masseditregex-hint-headmatch' => 'Correspondance',
	'masseditregex-hint-headreplace' => 'Remplacer',
	'masseditregex-hint-headeffect' => 'Effet',
	'masseditregex-hint-toappend' => "Insère du texte à la fin de l'article - pratique pour ajouter les pages à des catégories",
	'masseditregex-hint-remove' => 'Retirer du texte de toutes les pages de la liste',
	'masseditregex-hint-removecat' => "Supprime toutes les catégories de l'article (notez que les crochets dans le wikicode sont échappés.) Les valeurs de remplacement ne doivent pas être échappées.",
	'masseditregex-listtype-intro' => 'Voici une liste de :',
	'masseditregex-listtype-pagenames' => 'Nom des pages (éditer ces pages)',
	'masseditregex-listtype-pagename-prefixes' => 'Préfixe des noms de pages (éditer les pages dont les noms commencent par ce texte)',
	'masseditregex-listtype-categories' => "Nom des catégories (éditer chaque page présente dans ces catégories ; la sélection de l'espace de noms est ignorée)",
	'masseditregex-listtype-backlinks' => 'Pages liées (éditer les pages qui contiennent un lien vers celles-ci)',
	'masseditregex-namespace-intro' => 'Toutes ces pages sont dans cet espace de noms:',
	'masseditregex-exprnomatch' => 'L’expression « $1 » n’a été trouvée dans aucune page.',
	'masseditregex-badregex' => 'Regex invalide:',
	'masseditregex-editfailed' => "Erreur lors de l'édition :",
	'masseditregex-tooltip-execute' => 'Appliquer ces changements à chaque page',
	'right-masseditregex' => 'Remplacer le contenu de la page en utilisant des expressions régulières',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'masseditregex-matchtxt' => 'Rechèrchiér :',
	'masseditregex-replacetxt' => 'Remplaciér avouéc :',
	'masseditregex-executebtn' => 'Ègzécutar',
	'masseditregex-before' => 'Devant',
	'masseditregex-after' => 'Aprés',
	'masseditregex-num-changes' => '$1 : $2 changement{{PLURAL:$2||s}}',
	'masseditregex-page-not-exists' => '$1 ègziste pas',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|pâge changiê|pâges changiês}}',
	'masseditregex-hint-headmatch' => 'Corrèspondance',
	'masseditregex-hint-headreplace' => 'Remplaciér',
	'masseditregex-hint-headeffect' => 'Èfèt',
	'masseditregex-listtype-intro' => 'Vê-que una lista de :',
	'masseditregex-listtype-pagenames' => 'Nom de les pâges (changiér cetes pâges)',
	'masseditregex-badregex' => 'Èxprèssion racionèla fôssa :',
	'masseditregex-editfailed' => 'Èrror pendent l’èdicion :',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'action-masseditregex' => 'realizar edicións en masa',
	'masseditregex' => 'Edición en masa usando expresións regulares',
	'masseditregex-desc' => 'Usa expresións regulares para [[Special:MassEditRegex|editar moitas páxinas nunha única operación]]',
	'masseditregextext' => 'Insira unha ou máis expresións regulares (un por liña) para facer coincidir, e unha ou máis expresións para substituír cada coincidencia. Se a primeira expresión coincidente é correcta, substituirase pola primeira expresión substituta, e así sucesivamente. Olle a [http://php.net/manual/en/function.preg-replace.php función PHP preg_replace()] para obter máis información.',
	'masseditregex-pagelisttxt' => 'Páxinas a editar (sen o prefixo do espazo de nomes):',
	'masseditregex-matchtxt' => 'Procurar por:',
	'masseditregex-replacetxt' => 'Substituír por:',
	'masseditregex-executebtn' => 'Executar',
	'masseditregex-err-nopages' => 'Debe especificar, polo menos, unha páxina a modificar.',
	'masseditregex-before' => 'Antes',
	'masseditregex-after' => 'Despois',
	'masseditregex-max-preview-diffs' => 'A vista previa limitouse {{PLURAL:$1|á primeira coincidencia|ás $1 primeiras coincidencias}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|cambio|cambios}}',
	'masseditregex-page-not-exists' => '"$1" non existe',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|artigo editado|artigos editados}}',
	'masseditregex-view-full-summary' => 'Ollar o resumo de edición ao completo',
	'masseditregex-hint-intro' => 'Aquí hai algúns consellos e exemplos para a realización de tarefas comúns:',
	'masseditregex-hint-headmatch' => 'Buscar as coincidencias',
	'masseditregex-hint-headreplace' => 'Substituír',
	'masseditregex-hint-headeffect' => 'Levar a cabo',
	'masseditregex-hint-toappend' => 'Engade algo de texto ao final do artigo; útil para engadir páxinas a categorías',
	'masseditregex-hint-remove' => 'Elimina algún texto de todas as páxinas da lista',
	'masseditregex-hint-removecat' => 'Elimina todas as categorías dun artigo (teña en conta o escape dos corchetes no formato wiki). Os valores de substitución non deberían escapar.',
	'masseditregex-listtype-intro' => 'Esta é unha lista de:',
	'masseditregex-listtype-pagenames' => 'Nomes de páxina (editar estas páxinas)',
	'masseditregex-listtype-pagename-prefixes' => 'Prefixos de nome de páxina (editar as páxinas con nomes que comecen con este texto)',
	'masseditregex-listtype-categories' => 'Nomes de categoría (editar cada páxina dentro destas categorías; ignórase a selección de espazo de nomes)',
	'masseditregex-listtype-backlinks' => 'Ligazóns de retorno (editar as páxinas que ligan con elas)',
	'masseditregex-namespace-intro' => 'Todas estas páxinas están neste espazo de nomes:',
	'masseditregex-exprnomatch' => 'A expresión "$1" non coincide con ningunha páxina.',
	'masseditregex-badregex' => 'Expresión regular non válida:',
	'masseditregex-editfailed' => 'Fallou a edición:',
	'masseditregex-tooltip-execute' => 'Aplicar estes cambios a cada páxina',
	'right-masseditregex' => 'Substituír os contidos das páxinas por expresións regulares',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'masseditregex' => 'Greßeri Aazahl vu Syte glychzytig ändere iber reguläri Uusdruck.',
	'masseditregex-desc' => 'Reguläri Uusdruck bruch go [[Special:MassEditRegex|vili Syte in eim Schritt bearbeite]]',
	'masseditregextext' => 'Gib ein oder meh reguläri Uusdruck as Suechuusdruck yy (eine pro Zyylete) un ein oder meh Uusdruck as Ersatzuusdruck.
Dr erscht Suechuusdruck wird, wänn er gfunde wore isch, dur dr erscht Ersatzuusdruck ersetzt usw.
Lueg d [http://php.net/manual/en/function.preg-replace.php PHP-Funktion preg_replace()] fir Details.',
	'masseditregex-pagelisttxt' => 'Syte, wu bearbeitet solle wäre (verwänd kei Namensruum: Präfix):',
	'masseditregex-matchtxt' => 'Suech no:',
	'masseditregex-replacetxt' => 'Ersetze dur:',
	'masseditregex-executebtn' => 'Uusfiere',
	'masseditregex-err-nopages' => 'Du muesch zmindescht ei Syte aagee, wu gänderet soll wäre.',
	'masseditregex-before' => 'Vorhär',
	'masseditregex-after' => 'Nocher',
	'masseditregex-max-preview-diffs' => 'D Vorschau isch uf {{PLURAL:$1|uf dr erscht Träffer|di erschte $1 Träffer}} yygschränkt wore',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|Aänderig|Anderige}}',
	'masseditregex-page-not-exists' => '$1 git s nit',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|Syte|Syte}} bearbeitet',
	'masseditregex-view-full-summary' => 'Di ganz Zämmefassig aaluege',
	'masseditregex-hint-intro' => 'Do het s e paar Hiwys un Byschpil, wie mer gängigi Ufgabe cha uusfiere:',
	'masseditregex-hint-headmatch' => 'Träffer',
	'masseditregex-hint-headreplace' => 'Ersetze',
	'masseditregex-hint-headeffect' => 'Effäkt',
	'masseditregex-hint-toappend' => 'Täxt am Änd vu dr Syte yyfiege - ideal go Syte ere Kategorie zuefiege',
	'masseditregex-hint-remove' => 'Text us allene Syte in dr Lischt uuseneh',
	'masseditregex-hint-removecat' => 'Alli Kategorie us ere Syte uuseneh (gib Acht uf d Richtig vu dr eckige Chlammere im Wikicode).
Bim Text, wu yygsetzt wird, isch d Richtig nit relevant.',
	'masseditregex-listtype-intro' => 'Des isch e Lischt vu:',
	'masseditregex-listtype-pagenames' => 'Sytenäme (die Syte bearbeite)',
	'masseditregex-listtype-pagename-prefixes' => 'Sytenämepräfix (Syte bearbeite, wu mit däm Text aafange)',
	'masseditregex-listtype-categories' => 'Kategoriinäme (e jedi Syte in däre Kategorii bearbeite; Namensruum-Uuswahl wird ignoriert)',
	'masseditregex-listtype-backlinks' => 'Retur-Links (Syte bearbeite, wu uf die verwyse)',
	'masseditregex-namespace-intro' => 'Alli die Syte sin in däm Namensruum:',
	'masseditregex-exprnomatch' => 'Fir dr Uusdruck „$1“ git s kei Träffer uf Syte.',
	'masseditregex-badregex' => 'Nit giltige reguläre Uusdruck:',
	'masseditregex-editfailed' => 'Bearbeitige sin fähl gschlaa:',
	'masseditregex-tooltip-execute' => 'Die Änderige in jedere Syte vorneh',
	'right-masseditregex' => 'Syteinhalt mit reguläre Ussdrugg ersetze',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author YaronSh
 * @author ערן
 */
$messages['he'] = array(
	'masseditregex' => 'עריכה המונית באמצעות ביטויים רגולאריים',
	'masseditregex-desc' => 'שימוש בביטויים רגלואריים כדי [[Special:MassEditRegex|לערוך דפים רבים בבת אחת]]',
	'masseditregextext' => 'הכניסו ביטוי רגולרי אחד או יותר (אחד בכל שורה) לחיפוש התאמות, וביטוי אחד או יותר שבו יוחלפו המחרוזות המתאימות שתימצאנה.
,ביטוי החיפוש הראשון, אם יימצא, יוחלף בביטוי ההחלפה הראשון וכולי.
ר\' [http://php.net/manual/en/function.preg-replace.php את תיעוד הפונקציה <span dir="ltr">preg_replace()</span> של PHP] למידע נוסף.',
	'masseditregex-pagelisttxt' => 'דפים לעריכה (אין להשתמש בקידומת שם המרחב:):',
	'masseditregex-matchtxt' => 'חיפוש אחר:',
	'masseditregex-replacetxt' => 'החלפה ב־:',
	'masseditregex-executebtn' => 'הפעלה',
	'masseditregex-err-nopages' => 'עליך לציין לפחות דף אחד לשינוי.',
	'masseditregex-before' => 'לפני',
	'masseditregex-after' => 'אחרי',
	'masseditregex-max-preview-diffs' => 'התצוגה המקדימה הוגבלה ל{{PLURAL:$1|תוצאה הראשונה|־$1 התוצאות הראשונות}}.',
	'masseditregex-num-changes' => '$1: {{PLURAL:$2|שינוי אחד|$2 שינויים}}',
	'masseditregex-page-not-exists' => '$1 לא קיים',
	'masseditregex-num-articles-changed' => '{{PLURAL:$1|דף אחד נערך|$1 דפים נערכו}}',
	'masseditregex-view-full-summary' => 'צפייה בתקציר העריכה המלא',
	'masseditregex-hint-intro' => 'להלן כמה עצות ודוגמאות להשלמת משימות נפוצות:',
	'masseditregex-hint-headmatch' => 'התאמה',
	'masseditregex-hint-headreplace' => 'החלפה',
	'masseditregex-hint-headeffect' => 'אפקט',
	'masseditregex-hint-toappend' => 'הוספת טקסט כלשהו לסוף הדף - מעולה לצורך הוספת דפים לקטגוריות',
	'masseditregex-hint-remove' => 'הסרת טקסט כלשהו מכל הדפים שברשימה',
	'masseditregex-hint-removecat' => 'להסיר את כל הקטגוריות מהדף (שימו לב לחילוף הסוגריים המרובעים בקוד ויקי).
אין להוסיף תווי חילוף לערכים להחלפה.',
	'masseditregex-listtype-intro' => 'זוהי רשימה של:',
	'masseditregex-listtype-pagenames' => 'שמות הדפים (עריכת דפים אלה)',
	'masseditregex-listtype-pagename-prefixes' => 'קידומות שמות הדפים (עריכת דפים ששמם מתחיל בטקסט זה)',
	'masseditregex-listtype-categories' => 'שמות קטגוריות (עריכת כל הדפים בקטגוריות האלו; אין חשיבות לבחירה לפי מרחב שמות)',
	'masseditregex-listtype-backlinks' => 'דפים המקשרים אל הדף (עריכת דפים שמקשרים לדפים האלה)',
	'masseditregex-namespace-intro' => 'כל דפים אלו הם במרחב שם זה:',
	'masseditregex-exprnomatch' => 'הביטוי "$1" אינו תואם לאף דף.',
	'masseditregex-badregex' => 'ביטוי רגולארי שגוי:',
	'masseditregex-editfailed' => 'העריכה נכשלה:',
	'masseditregex-tooltip-execute' => 'החלת שינויים אלה לכל דף',
	'right-masseditregex' => 'החלפת תוכן הדף באמצעות ביטויים רגולריים',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'action-masseditregex' => 'masowe wobdźěłanje přewjesć',
	'masseditregex' => 'Masowe wobdźěłanje z pomocu regularnych wurazow',
	'masseditregex-desc' => 'Regularne wurazy za [[Special:MassEditRegex|wobdźěłowanje wjele stronow w jednej operaciji]] wužiwać',
	'masseditregextext' => 'Zapodaj jedyn regularny wuraz abo wjace regularnych wurazow (jedyn na linku) za pytanje a jedyn wuraz abo wjace wurazow, přez kotryž ma so kóždy wuslědk narunać.
Prěni pytanski wuraz budźe, jeli namakany, so přez prěni narunanski wuraz narunować atd.
Hlej [http://php.net/manual/de/function.preg-replace.php the PHP function preg_replace()] za podrobnosće.',
	'masseditregex-pagelisttxt' => 'Strony, kotrež maja so wobdźěłać (njewužij prefiks mjenoweho ruma):',
	'masseditregex-matchtxt' => 'Pytać za:',
	'masseditregex-replacetxt' => 'Narunać přez:',
	'masseditregex-executebtn' => 'Wuwjesć',
	'masseditregex-err-nopages' => 'Dyrbiš znajmjeńša jednu stronu podać, kotraž ma so změnić.',
	'masseditregex-before' => 'Prjedy',
	'masseditregex-after' => 'Po tym',
	'masseditregex-max-preview-diffs' => 'Přehlad je na {{PLURAL:$1|prěnju wotpowědnik|prěnjej $1 wotpowědnikaj|prěnje $1 wotpowědniki|prěnich $1 wotpowědnikow}} wobmjezowany.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|změna|změnje|změny|změnow}}',
	'masseditregex-page-not-exists' => '$1 njeeksistuje',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|nastawk wobdźěłany|nastawkaj wobdźěłanej|nastawki wobdźěłane|nastawkow wobdźěłanych}}',
	'masseditregex-view-full-summary' => 'Dospołne wobdźěłowanske zjeće pokazać',
	'masseditregex-hint-intro' => 'Tu su někotre pokiwy a přikłady za přewjedźenje powšitkownych nadawkow:',
	'masseditregex-hint-headmatch' => 'Wotpowědnik',
	'masseditregex-hint-headreplace' => 'Narunać',
	'masseditregex-hint-headeffect' => 'Efekt',
	'masseditregex-hint-toappend' => 'Tekst ke kóncej nastawka připowěsnyć - jara dobre za přidawanje stronow kategorijam',
	'masseditregex-hint-remove' => 'Tekst ze wšěch stronow w lisćinje wotstronić',
	'masseditregex-hint-removecat' => 'Wšě kategorije ze strony wotstronić (dźiwaj na maskěrowanje róžkatych spinkow we wikikodźe.) Narunanske hódnoty njeměli so maskěrować.',
	'masseditregex-listtype-intro' => 'To je lisćina wot:',
	'masseditregex-listtype-pagenames' => 'Mjena stronow (tute strony wobdźěłać)',
	'masseditregex-listtype-pagename-prefixes' => 'Prefiksy mjenow stronow (strony wobdźěłać, kotrychž mjena so z tutym tekstom započinaja)',
	'masseditregex-listtype-categories' => 'Kategorijowe mjena (kóždu stronu znutřka tutych kategorijow wobdźěłać; wubrany mjenowy rum so ignoruje)',
	'masseditregex-listtype-backlinks' => 'Wróćowotkazy (strony wobdźěłać, kotrež na tute wotkazuja)',
	'masseditregex-namespace-intro' => 'Wšě tute strony su w tutym mjenowym rumje:',
	'masseditregex-exprnomatch' => 'Wuraz "$1" njehodźi so na žane strony.',
	'masseditregex-badregex' => 'Njepłaćiwy regularny wuraz:',
	'masseditregex-editfailed' => 'Wobdźěłanje je so njeporadźiło:',
	'masseditregex-tooltip-execute' => 'Tute změny na kóždu stronu nałožić',
	'right-masseditregex' => 'Wobsah strony z pomocu regularnych wurazow wuměnić',
);

/** Hungarian (Magyar)
 * @author Dj
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'action-masseditregex' => 'tömeges szerkesztés végrehajtása',
	'masseditregex' => 'Tömeges szerkesztés reguláris kifejezések használatával',
	'masseditregex-desc' => 'Reguláris kifejezések használata [[Special:MassEditRegex|sok lap szerkesztéséhez egy művelettel]]',
	'masseditregextext' => 'Adj meg egy vagy több reguláris kifejezést a kereséshez (soronként egyet), és egy vagy több kifejezést amire a találatokat ki szeretnéd cserélni.
Az első találati-kifejezés (ha van találat) ki lesz cserélve az első csere-kifejezéssel, és így tovább.
Lásd [http://php.net/manual/en/function.preg-replace.php a PHP preg_replace() függvényét] további információkért.',
	'masseditregex-pagelisttxt' => 'Szerkesztendő lapok (ne használd a névtér: előtagot):',
	'masseditregex-matchtxt' => 'Keresendő szöveg:',
	'masseditregex-replacetxt' => 'Csere erre:',
	'masseditregex-executebtn' => 'Végrehajtás',
	'masseditregex-err-nopages' => 'Meg kell adnod legalább egy megváltoztatandó lapot.',
	'masseditregex-before' => 'Előtte',
	'masseditregex-after' => 'Utána',
	'masseditregex-max-preview-diffs' => 'Ez előnézet korlátozva van az első $1 találatra.',
	'masseditregex-num-changes' => '$1: $2 változtatás',
	'masseditregex-page-not-exists' => '$1 nem létezik',
	'masseditregex-num-articles-changed' => '$1 szerkesztett lap',
	'masseditregex-view-full-summary' => 'Teljes szerkesztési összefoglaló megjelenítése',
	'masseditregex-hint-intro' => 'Itt láthatsz pár ötletet és példát általános feladatok elvégzésére:',
	'masseditregex-hint-headmatch' => 'Találat',
	'masseditregex-hint-headreplace' => 'Csere',
	'masseditregex-hint-headeffect' => 'Hatás',
	'masseditregex-hint-toappend' => 'Szöveg hozzáfűzése a lap végéhez – jól használható lapok kategorizálásához',
	'masseditregex-hint-remove' => 'Szövegrészek eltávolítása a listában található összes lapról',
	'masseditregex-hint-removecat' => 'Az összes kategória eltávolítása egy lapról (figyelj a szögletes zárójelek feloldójelezésére a wikikódban).
A csere értékeket nem kell feloldójellel ellátni.',
	'masseditregex-listtype-intro' => 'A felsorolása ennek:',
	'masseditregex-listtype-pagenames' => 'Lapok nevei (ezeket a lapokat szerkeszd)',
	'masseditregex-listtype-pagename-prefixes' => 'Lapnév előtagok (lapok szerkesztése, amelyeknek a neve ezzel a szöveggel kezdődik)',
	'masseditregex-listtype-categories' => 'Kategórianevek (minden lap szerkesztése a megadott kategóriákban, a névtér-kiválasztás figyelmen kívül hagyásával)',
	'masseditregex-listtype-backlinks' => 'Visszamutató hivatkozások (lapok szerkesztése, amelyek ezekre hivatkoznak)',
	'masseditregex-namespace-intro' => 'Ezek a lapok mind a következő névtérben vannak:',
	'masseditregex-exprnomatch' => 'A(z) „$1” kifejezés nem adott egy találatot sem.',
	'masseditregex-badregex' => 'Érvénytelen reguláris kifejezés:',
	'masseditregex-editfailed' => 'A szerkesztés sikertelen:',
	'masseditregex-tooltip-execute' => 'Változtatások alkalmazása mindegyik lapra',
	'right-masseditregex' => 'Lap tartalmának lecserélése reguláris kifejezés segítségével',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'action-masseditregex' => 'exequer un modification in massa',
	'masseditregex' => 'Modification in massa con expressiones regular',
	'masseditregex-desc' => 'Usar expressiones regular pro [[Special:MassEditRegex|modificar multe paginas in un operation]]',
	'masseditregextext' => 'Entra un o plus expressiones regular (un per linea) a cercar, e un o plus expressiones pro reimplaciar cata resultato.
Le prime expression a cercar, si trovate, essera reimplaciate per le prime expression de reimplaciamento, et cetera.
Vide [http://php.net/manual/en/function.preg-replace.php le function PHP preg_replace()] pro detalios.',
	'masseditregex-pagelisttxt' => "Paginas a modificar (non usa un 'prefixo:' de spatio de nomines):",
	'masseditregex-matchtxt' => 'Cercar:',
	'masseditregex-replacetxt' => 'Reimplaciar per:',
	'masseditregex-executebtn' => 'Executar',
	'masseditregex-err-nopages' => 'Tu debe specificar al minus un pagina a modificar.',
	'masseditregex-before' => 'Ante',
	'masseditregex-after' => 'Post',
	'masseditregex-max-preview-diffs' => 'Le previsualisation ha essite limitate al prime {{PLURAL:$1|resultato|$1 resultatos}}.',
	'masseditregex-num-changes' => '$1 : $2 {{PLURAL:$2|modification|modificationes}}',
	'masseditregex-page-not-exists' => '$1 non existe',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|pagina|paginas}} modificate',
	'masseditregex-view-full-summary' => 'Vider le summario de modification complete',
	'masseditregex-hint-intro' => 'Ecce alcun avisos e exemplos pro realisar cargas commun:',
	'masseditregex-hint-headmatch' => 'Correspondentia',
	'masseditregex-hint-headreplace' => 'Reimplaciar',
	'masseditregex-hint-headeffect' => 'Effecto',
	'masseditregex-hint-toappend' => 'Adjunger alcun texto al fin del pagina - bon pro adder paginas a categorias',
	'masseditregex-hint-remove' => 'Remover alcun texto de tote le paginas in le lista',
	'masseditregex-hint-removecat' => 'Remover tote le categorias de un pagina (nota le escappamento del parentheses quadrate in le wikicodice).
Le valores de reimplaciamento non debe esser escappate.',
	'masseditregex-listtype-intro' => 'Isto es un lista de:',
	'masseditregex-listtype-pagenames' => 'Nomines de paginas (modificar iste paginas)',
	'masseditregex-listtype-pagename-prefixes' => 'Prefixos de nomines de paginas (modificar paginas con nomines comenciante per iste texto)',
	'masseditregex-listtype-categories' => 'Nomines de categorias (modificar cata pagina presente in iste categorias; le selection de spatio de nomines es ignorate)',
	'masseditregex-listtype-backlinks' => 'Retroligamines (modificar paginas que liga a istes)',
	'masseditregex-namespace-intro' => 'Tote iste paginas es in iste spatio de nomines:',
	'masseditregex-exprnomatch' => 'Le expression "$1" non ha essite trovate in alcun pagina.',
	'masseditregex-badregex' => 'Regex invalide:',
	'masseditregex-editfailed' => 'Modification falleva:',
	'masseditregex-tooltip-execute' => 'Applicar iste modificationes a cata pagina',
	'right-masseditregex' => 'Reimplaciar le contento de paginas usante expressiones regular',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 */
$messages['id'] = array(
	'masseditregex' => 'Penyuntingan massal dengan menggunakan ekspresi reguler',
	'masseditregex-desc' => 'Menggunakan ekspresi reguler untuk [[Special:MassEditRegex|menyunting banyak halaman sekaligus]]',
	'masseditregextext' => 'Masukkan satu atau lebih ekspresi reguler (satu per baris) untuk dicocokkan, dan satu atau lebih ekspresi untuk mengganti setiap kecocokan.
Ekspresi kecocokan pertama, jika berhasil akan diganti dengan ekspresi penggantian pertama, dan seterusnya.
Lihat [http://php.net/manual/en/function.preg-replace.php fungsi preg_replace() PHP] untuk detailnya.',
	'masseditregex-pagelisttxt' => 'Halaman untuk disunting (jangan gunakan suatu awalan ruang nama):',
	'masseditregex-matchtxt' => 'Cari:',
	'masseditregex-replacetxt' => 'Ganti dengan:',
	'masseditregex-executebtn' => 'Laksanakan',
	'masseditregex-err-nopages' => 'Anda harus memberikan paling tidak satu halaman untuk diganti.',
	'masseditregex-before' => 'Sebelum',
	'masseditregex-after' => 'Setelah',
	'masseditregex-max-preview-diffs' => 'Pratayang dibatasi untuk $1 {{PLURAL:$1|kecocokan|kecocokan}} pertama.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|perubahan|perubahan}}',
	'masseditregex-page-not-exists' => '$1 tidak ada',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|halaman|halaman}} disunting',
	'masseditregex-view-full-summary' => 'Lihat ringkasan suntingan lengkap',
	'masseditregex-hint-intro' => 'Berikut beberapa petunjuk dan contoh untuk menyelesaikan tugas umum:',
	'masseditregex-hint-headmatch' => 'Kecocokan',
	'masseditregex-hint-headreplace' => 'Penggantian',
	'masseditregex-hint-headeffect' => 'Efek',
	'masseditregex-hint-toappend' => 'Tambahkan beberapa teks ke akhir halaman - bagus untuk memasukkan halaman ke dalam kategori',
	'masseditregex-hint-remove' => 'Hapus beberapa teks dari semua halaman dalam daftar',
	'masseditregex-hint-removecat' => 'Hapus semua kategori dari suatu halaman (perhatikan penyertaan kurung siku dalam kode wiki.)
Nilai pengganti tidak boleh diloloskan.',
	'masseditregex-listtype-intro' => 'Ini adalah daftar:',
	'masseditregex-listtype-pagenames' => 'Nama halaman (sunting halaman ini)',
	'masseditregex-listtype-pagename-prefixes' => 'Awalan nama halaman (sunting halaman dengan nama yang diawali teks ini)',
	'masseditregex-listtype-categories' => 'Nama kategori (sunting tiap halaman dalam kategori ini; pemilihan ruang nama diabaikan)',
	'masseditregex-listtype-backlinks' => 'Pranala balik (sunting halaman yang bertaut ke halaman-halaman ini)',
	'masseditregex-namespace-intro' => 'Semua halaman ini berada dalam ruang nama ini:',
	'masseditregex-exprnomatch' => 'Ekspresi "$1" tidak cocok dengan halaman apa pun.',
	'masseditregex-badregex' => 'Regex tidak valid:',
	'masseditregex-editfailed' => 'Penyuntingan gagal.',
	'masseditregex-tooltip-execute' => 'Terapkan perubahan ini ke setiap halaman',
);

/** Italian (Italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'masseditregex-matchtxt' => 'Cerca per:',
	'masseditregex-replacetxt' => 'Sostituisci con:',
	'masseditregex-executebtn' => 'Esegui',
	'masseditregex-before' => 'Prima del',
	'masseditregex-after' => 'Dopo il',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|modifica|modifiche}}',
	'masseditregex-page-not-exists' => '$1 non esiste',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|pagina|pagine}} modificate',
	'masseditregex-hint-headreplace' => 'Sostituisci',
	'masseditregex-tooltip-execute' => 'Applica queste modifiche ad ogni pagina',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Whym
 * @author 青子守歌
 */
$messages['ja'] = array(
	'masseditregex' => '正規表現を使用した大量編集',
	'masseditregex-desc' => '正規表現を使って[[Special:MassEditRegex|大量のページを一度の操作で編集する]]',
	'masseditregextext' => '一致用に1つ以上の正規表現（1行に1つ）と、置換用に1つ以上の正規表現を入力してください。1番目の一致用正規表現が一致に成功すると、1番目の置換用正規表現で置換されます。2番目以降も同様です。詳細は [http://php.net/manual/ja/function.preg-replace.php PHP 関数 preg_replace()] を参照してください。',
	'masseditregex-pagelisttxt' => '編集するページ (名前空間接頭辞は使わず):',
	'masseditregex-matchtxt' => '一致用:',
	'masseditregex-replacetxt' => '置換用:',
	'masseditregex-executebtn' => '実行',
	'masseditregex-err-nopages' => '少なくとも1つ、編集するページを指定しなければなりません。',
	'masseditregex-before' => '前',
	'masseditregex-after' => '後',
	'masseditregex-max-preview-diffs' => 'プレビューは最初の$1件の一致に限定されています。',
	'masseditregex-num-changes' => '$1： $2件の変更',
	'masseditregex-page-not-exists' => '$1 は存在しません',
	'masseditregex-num-articles-changed' => '$1個のページが編集されました',
	'masseditregex-view-full-summary' => '完全な編集要約を表示',
	'masseditregex-hint-intro' => 'よくある課題を達成するためのヒントと使用例を示します:',
	'masseditregex-hint-headmatch' => '一致用',
	'masseditregex-hint-headreplace' => '置換用',
	'masseditregex-hint-headeffect' => '効果',
	'masseditregex-hint-toappend' => '記事末尾に文章を追記する。ページにカテゴリーを加えるにの便利です',
	'masseditregex-hint-remove' => '指定したすべてのページからある文章を除去する',
	'masseditregex-hint-removecat' => '記事からすべてのカテゴリーを除去する (ウィキテキスト中の角括弧のエスケープに注意)。置換する値はエスケープしません。',
	'masseditregex-listtype-intro' => 'これは次のリストです:',
	'masseditregex-listtype-pagenames' => 'ページ名 (これらのページを編集する)',
	'masseditregex-listtype-pagename-prefixes' => 'ページ名の先頭部 (この文字列から始まる名前をもつページを編集する)',
	'masseditregex-listtype-categories' => 'カテゴリー名 (これらのカテゴリーにあるページすべてを編集する。名前空間の選択は無視されます)',
	'masseditregex-listtype-backlinks' => 'リンク元 (これらにリンクしているページを編集する)',
	'masseditregex-namespace-intro' => 'これらのページはすべて、この名前空間に属しています:',
	'masseditregex-exprnomatch' => '正規表現「$1」に一致したページはありません。',
	'masseditregex-badregex' => '無効な正規表現:',
	'masseditregex-editfailed' => '編集失敗:',
	'masseditregex-tooltip-execute' => 'これらの変更を各ページに適用する',
);

/** Colognian (Ripoarisch)
 * @author Als-Holder
 * @author Purodha
 */
$messages['ksh'] = array(
	'masseditregex' => 'Donn Sigge em Pöngel ändere, un dat övver <i lang="en">regular expressions</i>.',
	'masseditregex-desc' => 'Deiht Sigge [[Special:MassEditRegex|em Pöngel en einem Rötsch ändere]], un dat övver <i lang="en">regular expressions</i>.',
	'masseditregextext' => 'Jif ein <i lang="en">regular expression</i> pro Reih en, esu vill wi nüüdesch. Dohenger en desellve Reih schriif hen, woh jäähje dat jetuusch wääde sull, wat op di <i lang="en">regular expression</i> paß. De [http://de.php.net/manual/de/function.preg-replace.php Funxjuhn <code lang="en">preg_replace()</code> en dä Projammeer_Shprooch <i lang="en">PHP</i>] weed doför jebruch, un doh kam_mer och de Einzelheite janz jenou nohlässe.',
	'masseditregex-pagelisttxt' => 'De Sigge zom Ändere, der_oohne en Appachtemang dovör:',
	'masseditregex-matchtxt' => 'Söhk noh:',
	'masseditregex-replacetxt' => 'Tuusch dat jäje:',
	'masseditregex-executebtn' => 'Lohß Jonn!',
	'masseditregex-err-nopages' => 'Winneschßdens ein Sigg för zem Ändere moß de ald aanjävve:',
	'masseditregex-before' => 'Förher',
	'masseditregex-after' => 'Hengerher',
	'masseditregex-max-preview-diffs' => 'De Vör-Aanseesch es op  {{PLURAL:$1|dä eetste Träffer|de eetste $1 Träffer|nix}} bejränz.',
	'masseditregex-num-changes' => '$1: {{PLURAL:$2|ein Änderung|$2 Änderunge|kein Änderung}}',
	'masseditregex-page-not-exists' => '$1 jidd_et nit',
	'masseditregex-num-articles-changed' => '{{PLURAL:$1|Ein Sigg|$1 Sigge|Kein Sigg wood}} jeändert',
	'masseditregex-view-full-summary' => 'De kumplätte Zosammefassung udder Quäll aanloore',
	'masseditregex-hint-intro' => 'Hee sen e paa Henwieß un Beispöll, wi mer üblesche Aufjaabe jedonn kritt:',
	'masseditregex-hint-headmatch' => 'Träffer',
	'masseditregex-hint-headreplace' => 'Ußtuusche',
	'masseditregex-hint-headeffect' => 'Wat eruß kütt',
	'masseditregex-hint-toappend' => 'Donn e Täx-Shtöck aam Engk vun dä Sigg aanhange — wunderbaa för Sigge en Saachjroppe ze donn',
	'masseditregex-hint-remove' => 'Donn e Shtöck vum Täx vun alle Sigge en dä Leß fott nämme',
	'masseditregex-hint-removecat' => 'Donn alle Enndrääsch för Saachjroppe us en Sigg eruß schmiiße — jev Aach op et <i lang="en">Escaping</i> vun de äkijje Klammere em Wiki_Kood. Wat beim Tuusche för dä ahle Täx ennjesaz weed, darf mer ävver nit <i lang="en">escape</i>.',
	'masseditregex-listtype-intro' => 'Dat es en Leß vun:',
	'masseditregex-listtype-pagenames' => 'Name vun Sigge för zem Ändere',
	'masseditregex-listtype-pagename-prefixes' => 'Aanfäng vun Siggetittelle (Alsu donn di Sigge ändere, dänne ier Tittelle met däm Täx heh aanfange)',
	'masseditregex-listtype-categories' => 'Saachjruppe-Name (Dunn all de Sigge en dä Saachjroppe ändere. Wat onger Appachtemang aanjejovve es, schpellt derbei kei Roll)',
	'masseditregex-listtype-backlinks' => 'Lengks retuur (Alsu dunn Sigge ändere, di ene Lengk op heh di Sigg han)',
	'masseditregex-namespace-intro' => 'All di Sigge sin en däm Appachtemang heh:',
	'masseditregex-exprnomatch' => 'De <i lang="en">regular expression</i> „$1“ hät keine Träfer, op keine vun dä Sigge.',
	'masseditregex-badregex' => 'Dat es en onjöltejje <i lang="en">regular expression</i>:',
	'masseditregex-editfailed' => 'Dat Ändere is donevve jejange:',
	'masseditregex-tooltip-execute' => 'Donn di Änderunge op jede Sigg maache',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'masseditregex' => 'Ännerung vun enger grousser Zuel vu Säite mat Hëllef vu regulären Ausdréck',
	'masseditregex-desc' => "Regulär Ausdréck benotze fir [[Special:MassEditRegex|vill Säiten an enger Operatioun z'änneren]]",
	'masseditregex-pagelisttxt' => "Säite fir z'änneren (benotzt den Nummraum-Prefix net):",
	'masseditregex-matchtxt' => 'Sichen no:',
	'masseditregex-replacetxt' => 'Eretzen duerch:',
	'masseditregex-executebtn' => 'Ausféieren',
	'masseditregex-err-nopages' => "Dir musst mindestens eng Säit ugi fir z'änneren.",
	'masseditregex-before' => 'Virdrun',
	'masseditregex-after' => 'Duerno',
	'masseditregex-num-changes' => '$1 : $2 {{PLURAL:$2|Ännerung|Ännerungen}}',
	'masseditregex-page-not-exists' => '$1 gëtt et net',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|Säit|Säite}} geännert',
	'masseditregex-view-full-summary' => 'De ganze Resumé vun der Ännerung weisen',
	'masseditregex-hint-headmatch' => 'Resultat',
	'masseditregex-hint-headreplace' => 'Ersetzen',
	'masseditregex-hint-headeffect' => 'Resultat',
	'masseditregex-hint-toappend' => "Text un d'Ënn vun der Säit bäisetzen - gutt fir Säiten a Kategorien derbäizesetzen",
	'masseditregex-hint-remove' => 'Text vun alle Säiten op der Lëscht erofhuelen',
	'masseditregex-listtype-intro' => 'Dëst ass eng Lëscht vun:',
	'masseditregex-listtype-pagenames' => 'Numm vun de Säiten (dës Säiten änneren)',
	'masseditregex-listtype-categories' => "Kategoriennimm (all Säit an dëse Kategorien änneren;d'Wiel vum Nummraum gëtt ignoréiert)",
	'masseditregex-listtype-backlinks' => 'Linken heihinn (Säiten änneren déi op dës linken)',
	'masseditregex-namespace-intro' => 'All dës Säite sinn an dësem Nummraum:',
	'masseditregex-exprnomatch' => 'Den Ausdrock "$1" huet keng Resultater erginn.',
	'masseditregex-editfailed' => 'Feeler beim änneren:',
	'masseditregex-tooltip-execute' => 'Dës Ännerungen op all Säit uwenden',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'action-masseditregex' => 'изврши групно уредување',
	'masseditregex' => 'Групно уредување со помош на регуларни изрази',
	'masseditregex-desc' => 'Користете регуларни изрази за да [[Special:MassEditRegex|уредите многу страници во една операција]]',
	'masseditregextext' => 'Внесете еден или повеќе регуларни изрази (по еден во секој ред) за наоѓање ан совпаѓања, и еден или повеќе изрази кои би го замениле најденото.
Првиот совпаднат израз, ако е успешно најден, ќе биде заменет со првиот израз за замена, и тн.
Погледајте го [http://php.net/manual/en/function.preg-replace.php описот на PHP-функцијата preg_replace()] за повеќе детали.',
	'masseditregex-pagelisttxt' => 'Страници за уредување (не користете префикс со именски простор):',
	'masseditregex-matchtxt' => 'Пребарај:',
	'masseditregex-replacetxt' => 'Замени со:',
	'masseditregex-executebtn' => 'Изврши',
	'masseditregex-err-nopages' => 'Мора да наведете барем една страница за менување.',
	'masseditregex-before' => 'Пред',
	'masseditregex-after' => 'По',
	'masseditregex-max-preview-diffs' => 'Прегледот е ограничен на {{PLURAL:$1|првото $1 совпаѓање|првите $1 совпаѓања}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|промена|промени}}',
	'masseditregex-page-not-exists' => '$1 не постои',
	'masseditregex-num-articles-changed' => '{{PLURAL:$1|Уредена е една $1 страница|Уредени се $1 страници}}',
	'masseditregex-view-full-summary' => 'Целосен опис на уредувањето',
	'masseditregex-hint-intro' => 'Еве некои совети и примери за извршување на најчестите задачи:',
	'masseditregex-hint-headmatch' => 'Совпаѓање',
	'masseditregex-hint-headreplace' => 'Замена',
	'masseditregex-hint-headeffect' => 'Резултат',
	'masseditregex-hint-toappend' => 'Приложете некој текст на крајот на страницата - одлично за додавање страници во категории',
	'masseditregex-hint-remove' => 'Отстранување на извесен текст од сите страници на списокот',
	'masseditregex-hint-removecat' => 'Отстранете ги сите категории од една страница (обратете внимание на исклучувањето на квадратните загради од викикодот.)
Вредностите за заменување не треба да се исклучуваат.',
	'masseditregex-listtype-intro' => 'Ова е список на:',
	'masseditregex-listtype-pagenames' => 'Имиња на страниците (уредете ги тие страници)',
	'masseditregex-listtype-pagename-prefixes' => 'Префикси на имиња на страници (уредете ги страниците чие име започнува со овој текст)',
	'masseditregex-listtype-categories' => 'Имиња на категориите (уредете ја секоја страница во тие категории; изборот на именски простори се занемарува)',
	'masseditregex-listtype-backlinks' => 'Обратни врски (уредете страници кои имаат врски до овие)',
	'masseditregex-namespace-intro' => 'Сите овие страници се наоѓаат во именскиот простор:',
	'masseditregex-exprnomatch' => 'На изразот „$1“ не му соодветствува ниту една страница.',
	'masseditregex-badregex' => 'Неважечки регуларен израз:',
	'masseditregex-editfailed' => 'Уредувањето не успеа:',
	'masseditregex-tooltip-execute' => 'Примени ги истите промени во секоја страница',
	'right-masseditregex' => 'Замена на содржини на страници користејќи регуларни изрази',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'masseditregex' => 'Masseredigering ved bruk av regulære uttrykk',
	'masseditregex-desc' => 'Bruk regulære uttrykk for å [[Special:MassEditRegex|redigere mange sider i en handling]]',
	'masseditregextext' => 'Skriv inn ett eller fler regulære uttrykk (en per linje) for treff, og ett eller flere uttrykk å erstatte hvert treff med.
Det første treff-uttrykket, om vellykket, vil bli erstattet med det første erstatt-uttrykket, og så videre.
Se [http://php.net/manual/en/function.preg-replace.php PHP-funksjonen preg_replace()] for detaljer.',
	'masseditregex-pagelisttxt' => 'Sider å redigere (ikke bruk et navnerom: prefiks):',
	'masseditregex-matchtxt' => 'Søk etter:',
	'masseditregex-replacetxt' => 'Erstatt med:',
	'masseditregex-executebtn' => 'Utfør',
	'masseditregex-err-nopages' => 'Du må oppgi minst en side å endre.',
	'masseditregex-before' => 'Før',
	'masseditregex-after' => 'Etter',
	'masseditregex-max-preview-diffs' => 'Forhåndsvisning har blitt begrenset til {{PLURAL:$1|det første treffet|de $1 første treffene}}.',
	'masseditregex-num-changes' => '$1: {{PLURAL:$2|én endring|$2 endringer}}',
	'masseditregex-page-not-exists' => '$1 finnes ikke',
	'masseditregex-num-articles-changed' => '{{PLURAL:$1|én side|$1 sider}} endret',
	'masseditregex-view-full-summary' => 'Vis fullstendig endringssammendrag',
	'masseditregex-hint-intro' => 'Her er noen hint og eksempler for utføring av vanlige oppgaver:',
	'masseditregex-hint-headmatch' => 'Treff',
	'masseditregex-hint-headreplace' => 'Erstatt',
	'masseditregex-hint-headeffect' => 'Effekt',
	'masseditregex-hint-toappend' => 'Legg til noe tekst på slutten av siden - flott for å legge sider til i kategorier',
	'masseditregex-hint-remove' => 'Fjern noe tekst fra alle sidene i listen',
	'masseditregex-hint-removecat' => 'Fjern alle kategorier fra en side (merk at hakeparantesene i wikikoden unnslipper.)
Erstatningsverdiene bør ikke unnslippes.',
	'masseditregex-listtype-intro' => 'Dette er en liste over:',
	'masseditregex-listtype-pagenames' => 'Sidenavn (endre disse sidene)',
	'masseditregex-listtype-pagename-prefixes' => 'Sidenavnprefiks (endre sider som har navn som begynner med denne teksten)',
	'masseditregex-listtype-categories' => 'Kategorinavn (endre hver side innen disse kategoriene; navneromvalg ignoreres)',
	'masseditregex-listtype-backlinks' => 'Lenker hit (rediger sider som lenker til disse)',
	'masseditregex-namespace-intro' => 'Alle disse sidene er i dette navnerommet:',
	'masseditregex-exprnomatch' => 'Uttrykket «$1» traff ingen sider.',
	'masseditregex-badregex' => 'Ugyldig regulært uttrykk:',
	'masseditregex-editfailed' => 'Endring feilet:',
	'masseditregex-tooltip-execute' => 'Utfør disse endringene på hver side',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'action-masseditregex' => "meerdere pagina's tegelijkertijd te bewerken",
	'masseditregex' => "Meerdere pagina's tegelijk bewerken met reguliere expressies",
	'masseditregex-desc' => "Reguliere expressies gebruiken om [[Special:MassEditRegex|meerdere pagina's in één handeling te bewerken]]",
	'masseditregextext' => 'Geef een of meer reguliere expressies op (één per regel) voor de selectie van tekst en een of meer reguliere expressies om de selectie door te vervangen.
De selectie uit de eerste selectie-expressie wordt vervangen door de eerste vervang-expressie, en zo verder.
Zie de [http://php.net/manual/en/function.preg-replace.php PHP-functie preg_replace()] voor details.',
	'masseditregex-pagelisttxt' => "Te bewerken pagina's (gebruik geen naamruimtevoorvoegsel):",
	'masseditregex-matchtxt' => 'Zoeken naar:',
	'masseditregex-replacetxt' => 'Vervangen door:',
	'masseditregex-executebtn' => 'Uitvoeren',
	'masseditregex-err-nopages' => 'Geef tenminste één te wijzigen pagina op.',
	'masseditregex-before' => 'Voor',
	'masseditregex-after' => 'Na',
	'masseditregex-max-preview-diffs' => 'Alleen de eerste {{PLURAL:$1|te maken wijziging|$1 te maken wijzigingen}} worden weergegeven.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|wijziging|wijzigingen}}',
	'masseditregex-page-not-exists' => '$1 bestaat niet',
	'masseditregex-num-articles-changed' => "$1 {{PLURAL:$1|pagina|pagina's}} bewerkt",
	'masseditregex-view-full-summary' => 'Bewerkingssamenvatting bekijken',
	'masseditregex-hint-intro' => 'Hints en voorbeelden voor het uitvoeren van veel voorkomende taken:',
	'masseditregex-hint-headmatch' => 'Selectie',
	'masseditregex-hint-headreplace' => 'Vervangen',
	'masseditregex-hint-headeffect' => 'Effect',
	'masseditregex-hint-toappend' => "Voeg tekst toe aan het einde van de pagina.
Ideaal voor het toevoegen van pagina's aan een categorie.",
	'masseditregex-hint-remove' => "Tekst verwijderen van alle pagina's in de lijst",
	'masseditregex-hint-removecat' => 'Alle categorieën verwijderen van een pagina.
Let op het escapen van de blokhaken in de wikitekst.
Voor de te vervangen tekst is escapen niet nodig.',
	'masseditregex-listtype-intro' => 'Dit is een lijst van:',
	'masseditregex-listtype-pagenames' => "Paginanamen (deze pagina's bewerken)",
	'masseditregex-listtype-pagename-prefixes' => "Paginanaamvoorvoegsels (pagina's bewerken die namen hebben die beginnen met deze tekst)",
	'masseditregex-listtype-categories' => 'Categorienamen (bewerk iedere pagina binnen deze categorieën; naamruimteselectie wordt genegeerd)',
	'masseditregex-listtype-backlinks' => "Terugverwijzingen (pagina's bewerken die verwijzen naar deze pagina's)",
	'masseditregex-namespace-intro' => "Alle pagina's in deze naamruimte:",
	'masseditregex-exprnomatch' => 'De expressie "$1" was op geen enkele pagina van toepassing.',
	'masseditregex-badregex' => 'Ongeldige reguliere expressie:',
	'masseditregex-editfailed' => 'Bewerking mislukt:',
	'masseditregex-tooltip-execute' => 'Deze wijzigingen op iedere pagina toepassen',
	'right-masseditregex' => 'Pagina-inhoud vervangen met behulp van reguliere expressies',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'masseditregex' => "Modificacion en massa amb l'ajuda de las expressions racionalas",
	'masseditregex-desc' => 'Utilizar las expressions racionalas per [[Special:MassEditRegex|modificar de paginas nombrosas en una operacion]]',
	'masseditregextext' => 'Entrar una o mantuna expression racionala (una per linha) de recercar, e una o mantuna expression per las qualas remplaçar los resultats. La primièra expression trobada serà remplaçada per la primièra expression de remplaçament, e atal encara. Veire la descripcion de la [http://php.net/manual/en/function.preg-replace.php foncion PHP preg_replace()] per mai de detalhs.',
	'masseditregex-pagelisttxt' => "Paginas de modificar (sens lo prefix de l'espaci de noms) :",
	'masseditregex-matchtxt' => 'Recercar :',
	'masseditregex-replacetxt' => 'Remplaçar per :',
	'masseditregex-executebtn' => 'Executar',
	'masseditregex-err-nopages' => 'Vos cal especificar al mens una pagina de modificar.',
	'masseditregex-before' => 'Abans',
	'masseditregex-after' => 'Aprèp',
	'masseditregex-max-preview-diffs' => 'La previsualizacion es estada limitada {{PLURAL:$1|al primièr resultat|als $1 primièrs resultats}}.',
	'masseditregex-num-changes' => '$1 : $2 {{PLURAL:$2|modificacion|modificacions}}',
	'masseditregex-page-not-exists' => '$1 existís pas',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|article modificat|articles modificats}}',
	'masseditregex-view-full-summary' => 'Veire lo resumit complet de las modificacions',
	'masseditregex-hint-intro' => 'Vaquí qualques indicacions e exemples per realizar los prètzfaches usuals :',
	'masseditregex-hint-headmatch' => 'Correspondéncia',
	'masseditregex-hint-headreplace' => 'Remplaçar',
	'masseditregex-hint-headeffect' => 'Efièch',
	'masseditregex-hint-toappend' => "Inserís de tèxte a la fin de l'article - practic per apondre las paginas a de categorias",
	'masseditregex-hint-remove' => 'Levar de tèxte de totas las paginas de la lista',
	'masseditregex-hint-removecat' => "Suprimís totas las categorias de l'article (notatz que los croquets dins lo wikicòde son escapats.) Las valors de remplaçament devon pas èsser escapadas.",
	'masseditregex-listtype-intro' => 'Vaquí una lista de :',
	'masseditregex-listtype-pagenames' => 'Nom de las paginas (editar aquestas paginas)',
	'masseditregex-listtype-pagename-prefixes' => 'Prefix dels noms de paginas (editar las paginas que los noms començan per aqueste tèxte)',
	'masseditregex-listtype-categories' => "Nom de las categorias (editar cada pagina presenta dins aquestas categorias ; la seleccion de l'espaci de noms es ignorada)",
	'masseditregex-listtype-backlinks' => 'Paginas ligadas (editar las paginas que contenon un ligam cap a aquelas)',
	'masseditregex-namespace-intro' => 'Totas aquestas paginas son dins aqueste espaci de noms :',
	'masseditregex-exprnomatch' => 'L\'expression "$1" es pas estada trobada dins cap de pagina.',
	'masseditregex-badregex' => 'Regex invalid :',
	'masseditregex-editfailed' => "Error al moment de l'edicion :",
	'masseditregex-tooltip-execute' => 'Aplicar aquestes cambiaments a cada pagina',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'masseditregex-matchtxt' => 'Uffgucke nooch:',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'masseditregex' => 'Masowe edytowanie z użyciem wyrażeń regularnych',
	'masseditregex-desc' => 'Pozwala użyć wyrażeń regularnych do [[Special:MassEditRegex|do wprowadzenia zmian na wielu stronach w jednej operacji]]',
	'masseditregextext' => 'Wstaw jedno lub więcej wyrażenie regularne (jedno w linii) do wyszukania oraz jedno lub więcej wyrażeń, którym mają być zastąpione.
Jeśli pierwsze wyrażenie zostanie odnalezione zostanie zastąpione pierwszym wyrażeniem itd.
Zobacz [http://php.net/manual/pl/function.preg-replace.php opis funkcji preg_replace() napisanej w PHP] jeśli chcesz dowiedzieć się więcej na ten temat.',
	'masseditregex-pagelisttxt' => 'Strony do edycji (nie dodawaj przedrostka przestrzeni nazw z dwukropkiem)',
	'masseditregex-matchtxt' => 'Szukaj',
	'masseditregex-replacetxt' => 'Zastąp przez',
	'masseditregex-executebtn' => 'Wykonaj',
	'masseditregex-err-nopages' => 'Musisz wskazać co najmniej jedną stronę do wykonania zmian.',
	'masseditregex-before' => 'Przed',
	'masseditregex-after' => 'Później',
	'masseditregex-max-preview-diffs' => 'Podgląd został ograniczony do {{PLURAL:$1|jednego wystąpienia|pierwszych $1 wystąpień}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|zmiana|zmiany|zmian}}',
	'masseditregex-page-not-exists' => '$1 nie istnieje',
	'masseditregex-num-articles-changed' => 'zmieniono $1 {{PLURAL:$1|stronę|strony|stron}}',
	'masseditregex-view-full-summary' => 'Pokaż pełny rejestr zmian',
	'masseditregex-hint-intro' => 'Oto kilka wskazówek i przykładów wykonania typowych zadań:',
	'masseditregex-hint-headmatch' => 'Pasuje',
	'masseditregex-hint-headreplace' => 'Zastąp',
	'masseditregex-hint-headeffect' => 'Efekt',
	'masseditregex-hint-toappend' => 'Dołącz tekst na koniec strony – wygodne dla dodania stron do kategorii',
	'masseditregex-hint-remove' => 'Usuń tekst ze wszystkich stron z listy',
	'masseditregex-hint-removecat' => 'Usuń wszystkie kategorie ze strony (uwaga na konieczność escapowania nawiasów kwadratowych w kodzie wiki).
Tekst wstawiany nie wymaga escapowania.',
	'masseditregex-listtype-intro' => 'Jest to lista',
	'masseditregex-listtype-pagenames' => 'Nazwy stron (edytuj te strony)',
	'masseditregex-listtype-pagename-prefixes' => 'Prefiksy nazw stron (edytuj strony, których nazwy rozpoczynają się od tej frazy)',
	'masseditregex-listtype-categories' => 'Nazwy kategorii (edytuj wszystkie strony, należące do którejś z tych kategorii; wybór przestrzeni nazw jest ignorowany)',
	'masseditregex-listtype-backlinks' => 'Linkujące (edytuj strony, które zawierają linki do tej strony)',
	'masseditregex-namespace-intro' => 'Wszystkie te strony, które są w przestrzeni nazw',
	'masseditregex-exprnomatch' => 'Wyrażenie „$1” nie pasuje do żadnej strony.',
	'masseditregex-badregex' => 'Nieprawidłowe wyrażenie regularne',
	'masseditregex-editfailed' => 'Edycja nie powiodła się',
	'masseditregex-tooltip-execute' => 'Zastosuj te zmiany do wszystkich stron',
	'right-masseditregex' => 'Zamiana treści stron z użyciem wyrażeń regularnych',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'action-masseditregex' => 'fà na modìfica a baron',
	'masseditregex' => 'Modìfiche mùltiple an dovrand espression regolar',
	'masseditregex-desc' => 'Dovré espression regolar për [[Special:MassEditRegex|modifiché vàire pàgine ant na sola operassion]]',
	'masseditregextext' => 'Anseriss un-a o pi espression regolar (un-a për linia) për confront, e un-a o pi espression për rimpiassé minca confront bon.
La prima espression ëd confront, se bon-a, a sarà rimpiassà con la prima espression ëd rimpiass, e via parèj.
Varda [http://php.net/manual/en/function.preg-replace.php la funsion PHP preg_replace()] për detaj.',
	'masseditregex-pagelisttxt' => 'Pàgine da modifiché (deuvra pa në spassi nominal: prefiss):',
	'masseditregex-matchtxt' => 'Serca:',
	'masseditregex-replacetxt' => 'Rimpiassa con:',
	'masseditregex-executebtn' => 'Fà giré',
	'masseditregex-err-nopages' => 'It deve spessifiché almanch na pàgina da cambié.',
	'masseditregex-before' => 'Prima',
	'masseditregex-after' => "D'apress",
	'masseditregex-max-preview-diffs' => "La previsualisassion a l'é stàita limità {{PLURAL:$1|al $1-m confront|ai prim $1 confront}}.",
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|cangiament|cangiament}}',
	'masseditregex-page-not-exists' => '$1 a esist pa',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|pàgine|pàgine}} modificà',
	'masseditregex-view-full-summary' => "Varda l'antregh somari dle modìfiche",
	'masseditregex-hint-intro' => 'Sì a-i son chèich idèje e esempi për fé ëd travaj comun:',
	'masseditregex-hint-headmatch' => 'Midem',
	'masseditregex-hint-headreplace' => 'Rimpiassa',
	'masseditregex-hint-headeffect' => 'Efet',
	'masseditregex-hint-toappend' => 'Pend dël test a la fin ëd la pàgina - bon për gionté pàgine a le categorìe',
	'masseditregex-hint-remove' => 'Gava dël test da tute le pàgine ant la lista',
	'masseditregex-hint-removecat' => "Gava tute le categorìe da 'nt na pàgina (nòta ël truch ëd le paréntesi quadre ant ël còdes wiki.)
Ij valor ëd rimpiassadura a dovrìo nen esse trucà.",
	'masseditregex-listtype-intro' => "Costa-sì a l'é na lista ëd:",
	'masseditregex-listtype-pagenames' => 'Nòm ëd le pàgine (modìfica ste pàgine-sì)',
	'masseditregex-listtype-pagename-prefixes' => "Prefiss dij nòm dle pàgine (modìfica pàgine con nòm ch'a ancamin-o con sto test-sì)",
	'masseditregex-listtype-categories' => "Nòm dle categorìe (modìfica minca pàgina an ste categorìe-sì; la selession djë spassi nominaj a l'é ignorà)",
	'masseditregex-listtype-backlinks' => 'Colegament andré (modìfica pàgine colegà mach a coste-sì)',
	'masseditregex-namespace-intro' => 'Tute ste pàgine-sì a son an sto spassi nominal-sì:',
	'masseditregex-exprnomatch' => 'L\'espression "$1" a corispond pa a gnun-e pàgine.',
	'masseditregex-badregex' => 'Regex pa bon-a:',
	'masseditregex-editfailed' => 'Modìfica falìa:',
	'masseditregex-tooltip-execute' => 'Fà sti cangiament-sì a minca pàgina',
	'right-masseditregex' => "Rampiassé ij contnù ëd la pàgina an dovrand d'espression regolar",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'masseditregex-matchtxt' => 'پلټنه د:',
	'masseditregex-before' => 'دمخه',
	'masseditregex-after' => 'وروسته',
	'masseditregex-listtype-intro' => 'دا يو لړليک دی د:',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'masseditregex' => 'Edições em massa usando expressões regulares',
	'masseditregex-desc' => '[[Special:MassEditRegex|Página especial]] para editar múltiplas páginas numa só operação, usando expressões regulares',
	'masseditregextext' => "Introduza uma ou várias (uma por linha) expressões regulares de busca e uma ou várias expressões de troca correspondentes.
Cada ocorrência da primeira expressão-de-busca será substituída pela primeira expressão-de-troca e assim por diante.
Consulte [http://php.net/manual/en/function.preg-replace.php a função PHP ''preg_replace()''] para mais detalhes.",
	'masseditregex-pagelisttxt' => "Páginas a editar (não use um prefixo 'espaço nominal:'):",
	'masseditregex-matchtxt' => 'Expressão-de-busca:',
	'masseditregex-replacetxt' => 'Expressão-de-troca:',
	'masseditregex-executebtn' => 'Executar',
	'masseditregex-err-nopages' => 'Introduza pelo menos uma página para alterar.',
	'masseditregex-before' => 'Antes',
	'masseditregex-after' => 'Depois',
	'masseditregex-max-preview-diffs' => 'A antevisão foi limitada {{PLURAL:$1|à primeira ocorrência|às primeiras $1 ocorrências}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|alteração|alterações}}',
	'masseditregex-page-not-exists' => '$1 não existe',
	'masseditregex-num-articles-changed' => '{{PLURAL:$1|Uma página editada|$1 páginas editadas}}',
	'masseditregex-view-full-summary' => 'Ver resumo de edição completo',
	'masseditregex-hint-intro' => 'Seguem-se algumas dicas e exemplos para realizar operações comuns:',
	'masseditregex-hint-headmatch' => 'Busca',
	'masseditregex-hint-headreplace' => 'Troca',
	'masseditregex-hint-headeffect' => 'Efeito',
	'masseditregex-hint-toappend' => 'Adiciona algum texto ao fim da página - útil para adicionar páginas a categorias',
	'masseditregex-hint-remove' => 'Remover um texto de todas as páginas na lista',
	'masseditregex-hint-removecat' => "Remover todas as categorias de uma página (note o ''escape'' dos parênteses rectos no código wiki.)
Os valores de troca não devem ter o ''escape''.",
	'masseditregex-listtype-intro' => 'Esta é uma lista de:',
	'masseditregex-listtype-pagenames' => 'Nomes de página (editar estas páginas)',
	'masseditregex-listtype-pagename-prefixes' => 'Inícios dos nomes de página (editar páginas cujos nomes começam por estes caracteres)',
	'masseditregex-listtype-categories' => 'Nomes de categoria (editar cada página nestas categorias; não é feita selecção dos espaços nominais)',
	'masseditregex-listtype-backlinks' => 'Afluentes (editar páginas que contêm links para estas)',
	'masseditregex-namespace-intro' => 'Todas estas páginas estão neste espaço nominal:',
	'masseditregex-exprnomatch' => 'A expressão "$1" não ocorre em nenhuma página.',
	'masseditregex-badregex' => 'Regex inválida:',
	'masseditregex-editfailed' => 'Edição falhou:',
	'masseditregex-tooltip-execute' => 'Aplicar estas alterações a cada página',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'masseditregex' => 'Edições em massa usando expressões regulares',
	'masseditregex-desc' => '[[Special:MassEditRegex|Página especial]] para editar múltiplas páginas numa só operação, usando expressões regulares',
	'masseditregextext' => "Introduza uma ou várias (uma por linha) expressões regulares de busca e uma ou várias expressões de troca correspondentes.
Cada ocorrência da primeira expressão-de-busca será substituída pela primeira expressão-de-troca e assim por diante.
Consulte [http://php.net/manual/en/function.preg-replace.php a função PHP ''preg_replace()''] para mais detalhes.",
	'masseditregex-pagelisttxt' => "Páginas a editar (não use um prefixo 'espaço nominal:'):",
	'masseditregex-matchtxt' => 'Expressão-de-busca:',
	'masseditregex-replacetxt' => 'Expressão-de-troca:',
	'masseditregex-executebtn' => 'Executar',
	'masseditregex-err-nopages' => 'Você deve introduzir pelo menos uma página para alterar.',
	'masseditregex-before' => 'Antes',
	'masseditregex-after' => 'Depois',
	'masseditregex-max-preview-diffs' => 'A previsão foi limitada {{PLURAL:$1|à primeira ocorrência|às primeiras $1 ocorrências}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|alteração|alterações}}',
	'masseditregex-page-not-exists' => '$1 não existe',
	'masseditregex-num-articles-changed' => '{{PLURAL:$1|Uma página editada|$1 páginas editadas}}',
	'masseditregex-view-full-summary' => 'Ver resumo de edição completo',
	'masseditregex-hint-intro' => 'Seguem-se algumas dicas e exemplos para realizar operações comuns:',
	'masseditregex-hint-headmatch' => 'Correspondência',
	'masseditregex-hint-headreplace' => 'Substituir',
	'masseditregex-hint-headeffect' => 'Efeito',
	'masseditregex-hint-toappend' => 'Adiciona algum texto ao fim da página - útil para adicionar páginas a categorias',
	'masseditregex-hint-remove' => 'Remover um texto de todas as páginas na lista',
	'masseditregex-hint-removecat' => 'Remover todas as categorias de uma página (note o escape dos parênteses retos no código wiki.)
Os valores de troca não devem ser o escapados.',
	'masseditregex-listtype-intro' => 'Esta é uma lista de:',
	'masseditregex-listtype-pagenames' => 'Nomes de página (editar estas páginas)',
	'masseditregex-listtype-pagename-prefixes' => 'Inícios dos nomes de página (editar páginas cujos nomes começam por estes caracteres)',
	'masseditregex-listtype-categories' => 'Nomes de categoria (editar cada página nestas categorias; não é feita seleção dos espaços nominais)',
	'masseditregex-listtype-backlinks' => 'Afluentes (editar páginas que contêm links para estas)',
	'masseditregex-namespace-intro' => 'Todas estas páginas estão neste espaço nominal:',
	'masseditregex-exprnomatch' => 'A expressão "$1" não ocorre em nenhuma página.',
	'masseditregex-badregex' => 'Regex inválida:',
	'masseditregex-editfailed' => 'Edição falhou:',
	'masseditregex-tooltip-execute' => 'Aplicar estas alterações a cada página',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'masseditregex-matchtxt' => 'Caută:',
	'masseditregex-replacetxt' => 'Înlocuiește cu:',
	'masseditregex-executebtn' => 'Execută',
	'masseditregex-before' => 'Înainte',
	'masseditregex-after' => 'După',
	'masseditregex-hint-headmatch' => 'Potrivire',
	'masseditregex-hint-headreplace' => 'Înlocuiește',
	'masseditregex-hint-headeffect' => 'Efect',
	'masseditregex-editfailed' => 'Editare eşuată',
);

/** Russian (Русский)
 * @author Eleferen
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'action-masseditregex' => 'выполнить массовое изменение',
	'masseditregex' => 'Множественное редактирование посредством регулярных выражений',
	'masseditregex-desc' => 'Использование регулярных выражений для [[Special:MassEditRegex|правки множества страниц за одно действие]]',
	'masseditregextext' => 'Введите одно или несколько регулярных выражений (по одному на строке) для поиска соответствий, а также одно или несколько выражений для замены соответствий.
Соответствия для первого выражения, если такие найдутся, будут заменены на первое выражение для замены и т. д.
Подробнее см. [http://php.net/manual/en/function.preg-replace.php описание PHP-функции preg_replace()].',
	'masseditregex-pagelisttxt' => 'Страницы для редактирования (не используйте префикс пространства имён):',
	'masseditregex-matchtxt' => 'Искать:',
	'masseditregex-replacetxt' => 'Заменить на:',
	'masseditregex-executebtn' => 'Запустить',
	'masseditregex-err-nopages' => 'Вы должны указать как минимум одну страницу для запуска редактирования.',
	'masseditregex-before' => 'До',
	'masseditregex-after' => 'После',
	'masseditregex-max-preview-diffs' => 'Предпросмотр ограничен {{PLURAL:$1|первым $1 соответствием|первыми $1 соответствиями|первыми $1 соответствиями}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|изменение|изменения|изменений}}',
	'masseditregex-page-not-exists' => '$1 не существует',
	'masseditregex-num-articles-changed' => '{{PLURAL:$1|Отредактирована $1 страница|Отредактировано $1 страницы|Отредактировано $1 страниц}}',
	'masseditregex-view-full-summary' => 'Просмотреть полное описание изменения',
	'masseditregex-hint-intro' => 'Несколько советов и примеров по выполнению типовых задач:',
	'masseditregex-hint-headmatch' => 'Соответствие',
	'masseditregex-hint-headreplace' => 'Замена',
	'masseditregex-hint-headeffect' => 'Результат',
	'masseditregex-hint-toappend' => 'Добавление текста в конец страницы — замечательно подходит для добавления страницы в категории',
	'masseditregex-hint-remove' => 'Удаление текста со всех страниц в списке',
	'masseditregex-hint-removecat' => 'Удаление всех категорий со страницы (обратите внимание на экранирование квадратных скобок в вики-разметке).
Значение для замены не должно экранироваться.',
	'masseditregex-listtype-intro' => 'Это список:',
	'masseditregex-listtype-pagenames' => 'Названия страниц (редактировать эти страницы)',
	'masseditregex-listtype-pagename-prefixes' => 'Префиксы названий страниц (редактировать страницы, названия которых начинаются этим текстом)',
	'masseditregex-listtype-categories' => 'Названия категорий (редактировать все страницы в этих категориях, выбор пространств имён игнорируется)',
	'masseditregex-listtype-backlinks' => 'Обратные ссылки (редактировать страницы, ссылающиеся на данные страницы)',
	'masseditregex-namespace-intro' => 'Все эти страницы находятся в пространство имен:',
	'masseditregex-exprnomatch' => 'Выражению "$1" не соответствует ни одна страница.',
	'masseditregex-badregex' => 'Ошибочное регулярное выражение:',
	'masseditregex-editfailed' => 'Ошибка редактирования:',
	'masseditregex-tooltip-execute' => 'Применить эти изменения для каждой страницы',
	'right-masseditregex' => 'Заменить содержимое страницы, с помощью регулярных выражений',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'masseditregex-pagelisttxt' => 'Стране за измену (не користите префикс за именски простор):',
	'masseditregex-matchtxt' => 'Тражи:',
	'masseditregex-replacetxt' => 'Замени са:',
	'masseditregex-executebtn' => 'Изврши',
	'masseditregex-err-nopages' => 'Морате навести најмање једну страну за измену.',
	'masseditregex-before' => 'Пре',
	'masseditregex-after' => 'После',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$1|измена|измене|измена}}',
	'masseditregex-page-not-exists' => '$1 не постоји',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|страна|стране|страна}} измењено',
	'masseditregex-view-full-summary' => 'Види потпун опис измене',
	'masseditregex-hint-headmatch' => 'Поклапање',
	'masseditregex-hint-headreplace' => 'Замени',
	'masseditregex-hint-headeffect' => 'Ефекат',
	'masseditregex-listtype-intro' => 'Ово је списак од:',
	'masseditregex-listtype-pagenames' => 'Називи страница (измени ове странице)',
	'masseditregex-exprnomatch' => 'Израз "$1" се не налази ни на једној страни.',
	'masseditregex-badregex' => 'Неисправан regex:',
	'masseditregex-editfailed' => 'Измена није снимљена:',
	'masseditregex-tooltip-execute' => 'Примени ове промене на сваку страну',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Rancher
 */
$messages['sr-el'] = array(
	'masseditregex-pagelisttxt' => 'Strane za izmenu (ne koristite prefiks za imenski prostor):',
	'masseditregex-matchtxt' => 'Traži:',
	'masseditregex-replacetxt' => 'Zameni sa:',
	'masseditregex-executebtn' => 'Izvrši',
	'masseditregex-err-nopages' => 'Morate navesti najmanje jednu stranu za izmenu.',
	'masseditregex-before' => 'Pre',
	'masseditregex-after' => 'Posle',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$1|izmena|izmene|izmena}}',
	'masseditregex-page-not-exists' => '$1 ne postoji',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|strana|strane|strana}} izmenjeno',
	'masseditregex-view-full-summary' => 'Vidi potpun opis izmene',
	'masseditregex-hint-headmatch' => 'Poklapanje',
	'masseditregex-hint-headreplace' => 'Zameni',
	'masseditregex-hint-headeffect' => 'Efekat',
	'masseditregex-listtype-intro' => 'Ovo je spisak od:',
	'masseditregex-listtype-pagenames' => 'Imena strana (izmeni ove strane)',
	'masseditregex-exprnomatch' => 'Izraz "$1" se ne nalazi ni na jednoj strani.',
	'masseditregex-badregex' => 'Neispravan regex:',
	'masseditregex-editfailed' => 'Izmena nije snimljena:',
	'masseditregex-tooltip-execute' => 'Primeni ove promene na svaku stranu',
);

/** Swedish (Svenska)
 * @author Dafer45
 * @author Per
 */
$messages['sv'] = array(
	'masseditregex' => 'Använd regulära uttryck för att massredigera.',
	'masseditregex-matchtxt' => 'Sök efter:',
	'masseditregex-replacetxt' => 'Ersätt med:',
	'masseditregex-executebtn' => 'Genomför',
	'masseditregex-err-nopages' => 'Du måste specificera minst en sida att ändra.',
	'masseditregex-before' => 'Före',
	'masseditregex-after' => 'Efter',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|ändring|ändringar}}',
	'masseditregex-page-not-exists' => '$1 finns inte',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|sida|sidor}} redigerade',
	'masseditregex-view-full-summary' => 'Visa fullständingt redigeringssammandrag',
	'masseditregex-hint-headreplace' => 'Ersätt',
	'masseditregex-hint-headeffect' => 'Effekt',
	'masseditregex-listtype-intro' => 'Detta är en lista över:',
	'masseditregex-listtype-pagenames' => 'Sidnamn (redigera dessa sidor)',
	'masseditregex-exprnomatch' => 'Uttrycket "$1" matchade inga sidor.',
	'masseditregex-editfailed' => 'Redigera misslyckades:',
	'masseditregex-tooltip-execute' => 'Tillämpa dessa förändringar på varje sida',
);

/** Telugu (తెలుగు)
 * @author RanjithSutari
 * @author Veeven
 */
$messages['te'] = array(
	'masseditregex-err-nopages' => 'మీరు కనీసం ఒక్క మార్చాల్సిన పేజీని అయినా పేర్కొనాలి.',
	'masseditregex-before' => 'ముందు',
	'masseditregex-after' => 'తర్వాత',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|మార్పు|మార్పులు}}',
	'masseditregex-page-not-exists' => '$1 లేనే లేదు',
	'masseditregex-num-articles-changed' => '$1 {{PLURAL:$1|పేజీని|పేజీలను}} మార్చారు',
	'masseditregex-listtype-pagenames' => 'పుటల పేర్లు (ఈ పుటలని మార్చండి)',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'masseditregex' => 'Maramihang pamamatnugot na ginagamitan ng pangkaraniwang mga pagsasaad',
	'masseditregex-desc' => 'Gamitin ang pangkaraniwang mga pagsasaad sa [[Special:MassEditRegex|pagpapatnugot ng maraming mga pahina sa loob ng isang pagsasagawa]]',
	'masseditregextext' => 'Magpasok ng isa o mahigit pang pangkaraniwang mga pagsasaad (isa bawat guhit) para sa pagtutugma, at isa o mahigit pang mga pagsasaad upang pampalit. Ang unang pagtutugma ng pagsasaad, kung matagumpay, ay papalitan ng unang pamalit na pagtutugma, at mga kasunod pa. Tingnan ang [http://php.net/manual/tl/function.preg-replace.php the PHP function preg_replace()] para sa mga detalye.',
	'masseditregex-pagelisttxt' => 'Mga pahinang pamamatnugutan (huwag gamitin ang isang puwang na pampangalan: unlapi)',
	'masseditregex-matchtxt' => 'Hanapin ang:',
	'masseditregex-replacetxt' => 'Palitan ng:',
	'masseditregex-executebtn' => 'Isakatuparan',
	'masseditregex-err-nopages' => 'Dapat kang tumukoy ng kahit na isang pahinang babaguhin.',
	'masseditregex-before' => 'Dati',
	'masseditregex-after' => 'Pagkaraan',
	'masseditregex-max-preview-diffs' => 'Nakahangga ang paunang-tingin sa unang $1 {{PLURAL:$1|pagtugma|mga pagtutugma}}.',
	'masseditregex-num-changes' => '$1: $2 {{PLURAL:$2|pagbabago|mga pagbabago}}',
	'masseditregex-page-not-exists' => 'Hindi umiiral ang $1',
	'masseditregex-num-articles-changed' => '$1 napatnugot na {{PLURAL:$1|pahina|mga pahina}}',
	'masseditregex-view-full-summary' => 'Tingnan ang buong buod ng pamamatnugot',
	'masseditregex-hint-intro' => 'Narito ang ilang mga parunggit at mga halimbawa para sa pagsasagawa ng pangkaraniwang mga gawain:',
	'masseditregex-hint-headmatch' => 'Itugma',
	'masseditregex-hint-headreplace' => 'Palitan',
	'masseditregex-hint-headeffect' => 'Epekto',
	'masseditregex-hint-toappend' => 'Magkabit ng ilang mga teksto sa hulihan ng pahina - magaling para sa pagdaragdag ng mga pahina sa mga kategorya',
	'masseditregex-hint-remove' => 'Tanggalin ang ilang mga teksto mula sa lahat ng mga pahinang nasa loob ng talaan',
	'masseditregex-hint-removecat' => 'Tanggalin ang lahat ng mga kategorya mula sa isang pahina (tandaan ang pagtakas ng mga parisukat na panaklong sa loob ng wikikodigo.)
Hindi dapat matakasan ang kapalit na mga halaga.',
	'masseditregex-listtype-intro' => 'Ito ay isang talaan ng:',
	'masseditregex-listtype-pagenames' => 'Mga pangalan ng pahina (baguhin ang mga pahinang ito)',
	'masseditregex-listtype-pagename-prefixes' => 'Mga unlapi ng pangalan ng pahina (baguhin ang mga pahina na may mga pangalan nagsisimula sa tekstong ganito)',
	'masseditregex-listtype-categories' => 'Pangalan ng mga kategorya (baguhin ang bawat isang pahinang may ganitong mga kategorya; hindi pinapansin ang pagpili ng puwang na pampangalan)',
	'masseditregex-listtype-backlinks' => 'Mga kawing-pabalik (baguhin ang mga pahinang umuugnay sa mga ito)',
	'masseditregex-namespace-intro' => 'Ang lahat ng mga pahinang ito ay nasa loob ng ganitong puwang ng pangalan:',
	'masseditregex-exprnomatch' => 'Ang pagsasaad na "$1" ay hindi tumugma sa anumang mga pahina.',
	'masseditregex-badregex' => 'Hindi tanggap na regex:',
	'masseditregex-editfailed' => 'Nabigo ang pagpatnugot:',
	'masseditregex-tooltip-execute' => 'Gamitin ang mga pagbabagong ito sa bawat pahina',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'masseditregex-matchtxt' => 'Şunu ara:',
	'masseditregex-replacetxt' => 'Şununla değiştir:',
	'masseditregex-err-nopages' => 'Değiştirilecek en az bir sayfa belirtmelisiniz.',
	'masseditregex-before' => 'Önce',
	'masseditregex-after' => 'Sonra',
	'masseditregex-view-full-summary' => 'Değişiklik özetinin tamamını gör',
	'masseditregex-hint-headmatch' => 'Eşleşme',
	'masseditregex-hint-headreplace' => 'Değiştir',
	'masseditregex-hint-headeffect' => 'Etki',
	'masseditregex-editfailed' => 'Değişiklik başarısız oldu:',
	'masseditregex-tooltip-execute' => 'Bu değişiklikleri tüm sayfalara uygula',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'masseditregex-hint-headreplace' => 'Заміна',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'masseditregex-matchtxt' => 'Ectä:',
	'masseditregex-executebtn' => 'Tehta',
	'masseditregex-before' => 'Edel',
	'masseditregex-after' => "Jäl'ges",
	'masseditregex-hint-headeffect' => 'Effekt',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'masseditregex-matchtxt' => '查找：',
	'masseditregex-replacetxt' => '替换为：',
	'masseditregex-executebtn' => '执行',
	'masseditregex-before' => '前',
	'masseditregex-after' => '后',
	'masseditregex-page-not-exists' => '$1 不存在',
	'masseditregex-hint-headreplace' => '替换',
	'masseditregex-hint-headeffect' => '影响',
	'masseditregex-listtype-intro' => '这是一个列表：',
	'masseditregex-listtype-pagenames' => '页面名称（编辑这些网页）',
	'masseditregex-listtype-pagename-prefixes' => '网页名称前缀（编辑网页名称的开头有这个文字）',
	'masseditregex-editfailed' => '编辑失败：',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'masseditregex-matchtxt' => '查找：',
	'masseditregex-replacetxt' => '替換為：',
	'masseditregex-executebtn' => '執行',
	'masseditregex-before' => '之前',
	'masseditregex-after' => '之後',
	'masseditregex-page-not-exists' => '$1 不存在',
	'masseditregex-hint-headreplace' => '替換',
	'masseditregex-hint-headeffect' => '影響',
	'masseditregex-listtype-intro' => '這是一個列表：',
	'masseditregex-listtype-pagenames' => '頁面名稱（編輯這些網頁）',
	'masseditregex-listtype-pagename-prefixes' => '網頁名稱前綴（編輯網頁名稱的開頭有這個文字）',
	'masseditregex-editfailed' => '編輯失敗：',
);

