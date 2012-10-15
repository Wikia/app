<?php
/**
 * Internationalization for CloseWikis extension.
 */

$messages = array();

/**
 * English
 * @author Victor Vasiliev
 */
$messages['en'] = array(
	'closewikis-desc'           => 'Allows to close wiki sites in wiki farms',
	'closewikis-closed'         => '$1',
	'closewikis-page'           => 'Close wiki',

	'closewikis-page-close' => 'Close wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Reason (displayed):',
	'closewikis-page-close-reason' => 'Reason (logged):',
	'closewikis-page-close-submit' => 'Close',
	'closewikis-page-close-success' => 'Wiki successfully closed',
	'closewikis-page-reopen' => 'Reopen wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Reason:',
	'closewikis-page-reopen-submit' => 'Reopen',
	'closewikis-page-reopen-success' => 'Wiki successfully reopened',
	'closewikis-page-err-nowiki' => 'Invalid wiki specified',
	'closewikis-page-err-closed' => 'Wiki is already closed',
	'closewikis-page-err-opened' => 'Wiki is not closed',

	'closewikis-list'                   => 'Closed wikis list',
	'closewikis-list-intro'             => 'This list contains wikis which were closed by stewards.',
	'closewikis-list-header-wiki'       => 'Wiki',
	'closewikis-list-header-by'         => 'Closed by',
	'closewikis-list-header-timestamp'  => 'Closed on',
	'closewikis-list-header-dispreason' => 'Displayed reason',

	'closewikis-log'         => 'Wikis closure log',
	'closewikis-log-header'  => 'Here is a log of all wiki closures and reopenings made by stewards',
	'closewikis-log-close'   => 'closed $2',
	'closewikis-log-reopen'  => 'reopened $2',
	'right-editclosedwikis'  => 'Edit closed wikis',
	'right-closewikis'       => 'Close wikis',
);

/** Message documentation (Message documentation)
 * @author Bennylin
 * @author Darth Kule
 * @author EugeneZelenko
 * @author Purodha
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'closewikis-desc' => '{{desc}}',
	'closewikis-closed' => '{{optional}}',
	'closewikis-page-close-wiki' => '{{Identical|Wiki}}',
	'closewikis-page-close-submit' => '{{Identical|Close}}',
	'closewikis-page-reopen-wiki' => '{{Identical|Wiki}}',
	'closewikis-page-reopen-reason' => '{{Identical|Reason}}',
	'closewikis-list-header-wiki' => '{{Identical|Wiki}}',
	'right-editclosedwikis' => '{{doc-right|editclosedwikis}}',
	'right-closewikis' => '{{doc-right|closewikis}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'closewikis-desc' => "Maak die sluit en heropenig van wiki's in 'n wiki-plaas moontlik",
	'closewikis-page' => 'Sluit wiki',
	'closewikis-page-close' => 'Sluit wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Rede (wys op wiki):',
	'closewikis-page-close-reason' => 'Rede (vir logboek):',
	'closewikis-page-close-submit' => 'Sluit',
	'closewikis-page-close-success' => 'Die wiki is nou gesluit',
	'closewikis-page-reopen' => 'Heropen wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Rede:',
	'closewikis-page-reopen-submit' => 'Heropen',
	'closewikis-page-reopen-success' => 'Die wiki is suksesvol heropen',
	'closewikis-page-err-nowiki' => 'Ongeldige wiki gespesifiseer',
	'closewikis-page-err-closed' => 'Hierdie wiki is reeds gesluit',
	'closewikis-page-err-opened' => 'Hierdie wiki is nie gesluit nie',
	'closewikis-list' => "Geslote wiki's",
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Gesluit deur',
	'closewikis-list-header-timestamp' => 'Gesluit op',
	'closewikis-log-close' => 'het $2 gesluit',
	'closewikis-log-reopen' => 'het $2 heropen',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'closewikis-page-reopen-reason' => 'Razón:',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'closewikis-desc' => 'يسمح بغلق مواقع الويكي في مزارع الويكي',
	'closewikis-page' => 'إغلاق الويكي',
	'closewikis-page-close' => 'إغلاق الويكي',
	'closewikis-page-close-wiki' => 'الويكي:',
	'closewikis-page-close-dreason' => 'السبب (المعروض):',
	'closewikis-page-close-reason' => 'السبب (المسجل):',
	'closewikis-page-close-submit' => 'أغلق',
	'closewikis-page-close-success' => 'الويكي تم إغلاقه بنجاح',
	'closewikis-page-reopen' => 'إعادة فتح الويكي',
	'closewikis-page-reopen-wiki' => 'الويكي:',
	'closewikis-page-reopen-reason' => 'السبب:',
	'closewikis-page-reopen-submit' => 'إعادة فتح',
	'closewikis-page-reopen-success' => 'الويكي تمت إعادة فتحه بنجاح',
	'closewikis-page-err-nowiki' => 'ويكي غير صحيح تم تحديده',
	'closewikis-page-err-closed' => 'الويكي مغلق بالفعل',
	'closewikis-page-err-opened' => 'الويكي ليس مغلقا',
	'closewikis-list' => 'قائمة الويكيات المغلقة',
	'closewikis-list-intro' => 'هذه القائمة تحتوي على الويكيات التي تم إغلاقها بواسطة المضيفين.',
	'closewikis-list-header-wiki' => 'الويكي',
	'closewikis-list-header-by' => 'أغلق بواسطة',
	'closewikis-list-header-timestamp' => 'أغلق في',
	'closewikis-list-header-dispreason' => 'السبب المعروض',
	'closewikis-log' => 'سجل إغلاق الويكيات',
	'closewikis-log-header' => 'هنا يوجد سجل بكل عمليات إغلاق وإعادة فتح الويكيات بواسطة المضيفين',
	'closewikis-log-close' => 'أغلق $2',
	'closewikis-log-reopen' => 'أعاد فتح $2',
	'right-editclosedwikis' => 'تعديل الويكيات المغلقة',
	'right-closewikis' => 'إغلاق الويكيات',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'closewikis-page-close-wiki' => 'ܘܝܩܝ:',
	'closewikis-page-close-submit' => 'ܣܟܘܪ',
	'closewikis-page-reopen' => 'ܦܬܘܚ ܘܝܩܝ ܙܒܢܬܐ ܐܚܪܬܐ',
	'closewikis-page-reopen-wiki' => 'ܘܝܩܝ:',
	'closewikis-page-reopen-reason' => 'ܥܠܬܐ:',
	'closewikis-page-reopen-submit' => 'ܦܬܘܚ ܙܒܢܬܐ ܐܚܪܬܐ',
	'closewikis-list-header-wiki' => 'ܘܝܩܝ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'closewikis-desc' => 'يسمح بغلق مواقع الويكى فى مزارع الويكي',
	'closewikis-page' => 'إغلاق الويكي',
	'closewikis-page-close' => 'إغلاق الويكي',
	'closewikis-page-close-wiki' => 'الويكي:',
	'closewikis-page-close-dreason' => 'السبب (المعروض):',
	'closewikis-page-close-reason' => 'السبب (المسجل):',
	'closewikis-page-close-submit' => 'إغلاق',
	'closewikis-page-close-success' => 'الويكى تم إغلاقه بنجاح',
	'closewikis-page-reopen' => 'إعادة فتح الويكي',
	'closewikis-page-reopen-wiki' => 'الويكي:',
	'closewikis-page-reopen-reason' => 'السبب:',
	'closewikis-page-reopen-submit' => 'إعادة فتح',
	'closewikis-page-reopen-success' => 'الويكى تمت إعادة فتحه بنجاح',
	'closewikis-page-err-nowiki' => 'ويكى غير صحيح تم تحديده',
	'closewikis-page-err-closed' => 'الويكى مغلق بالفعل',
	'closewikis-page-err-opened' => 'الويكى ليس مغلقا',
	'closewikis-list' => 'قائمة الويكيات المغلقة',
	'closewikis-list-intro' => 'هذه القائمة تحتوى على الويكيات التى تم إغلاقها بواسطة المضيفين.',
	'closewikis-list-header-wiki' => 'الويكى',
	'closewikis-list-header-by' => 'أغلق بواسطة',
	'closewikis-list-header-timestamp' => 'أغلق فى',
	'closewikis-list-header-dispreason' => 'السبب المعروض',
	'closewikis-log' => 'سجل إغلاق الويكيات',
	'closewikis-log-header' => 'هنا يوجد سجل بكل عمليات إغلاق وإعادة فتح الويكيات بواسطة المضيفين',
	'closewikis-log-close' => 'أغلق $2',
	'closewikis-log-reopen' => 'أعاد فتح $2',
	'right-editclosedwikis' => 'تعديل الويكيات المغلقة',
	'right-closewikis' => 'إغلاق الويكيات',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 */
$messages['az'] = array(
	'closewikis-page-close-wiki' => 'Viki:',
	'closewikis-page-reopen-wiki' => 'Viki:',
	'closewikis-page-reopen-reason' => 'Səbəb:',
	'closewikis-page-reopen-submit' => 'Açmaq',
	'closewikis-list-header-wiki' => 'Viki',
	'closewikis-list-header-by' => 'Bağlayan',
	'closewikis-list-header-timestamp' => 'Bağlanıb',
	'right-editclosedwikis' => 'Bağlanmış vikiləri redaktə',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'closewikis-desc' => 'Вики фермала вики-сайттарҙы ябыу мөмкинлеге бирә',
	'closewikis-page' => 'Вики проектты ябыу',
	'closewikis-page-close' => 'Вики проектты ябырға',
	'closewikis-page-close-wiki' => 'Вики:',
	'closewikis-page-close-dreason' => 'Сәбәп (күренә торған):',
	'closewikis-page-close-reason' => 'Сәбәп (журнал яҙмаһы өсөн):',
	'closewikis-page-close-submit' => 'Ябырға',
	'closewikis-page-close-success' => 'Вики уңышлы ябылды',
	'closewikis-page-reopen' => 'Викины яңынан асырға',
	'closewikis-page-reopen-wiki' => 'Вики:',
	'closewikis-page-reopen-reason' => 'Сәбәп:',
	'closewikis-page-reopen-submit' => 'Яңынан асырға',
	'closewikis-page-reopen-success' => 'Вики уңышлы асылды',
	'closewikis-page-err-nowiki' => 'Дөрөҫ вики күрһәтелмәгән',
	'closewikis-page-err-closed' => 'Вики ябылған инде',
	'closewikis-page-err-opened' => 'Вики ябыҡ түгел',
	'closewikis-list' => 'Ябылған викилар исемлеге',
	'closewikis-list-intro' => 'Был исемлектә стюардтар тарафынан ябылған викилар күрһәтелгән.',
	'closewikis-list-header-wiki' => 'Вики',
	'closewikis-list-header-by' => 'Ябыусы',
	'closewikis-list-header-timestamp' => 'Ябыу ваҡыты',
	'closewikis-list-header-dispreason' => 'Күрһәтелгән сәбәп',
	'closewikis-log' => 'Вики ябыу яҙмалары журналы',
	'closewikis-log-header' => 'Был — бөтә стюардтар тарафынан вики ябыуҙыр һәм яңынан асыуҙар яҙмалары журналы',
	'closewikis-log-close' => '$2 викиһын япҡан',
	'closewikis-log-reopen' => '$2 викиһын яңынан асҡан',
	'right-editclosedwikis' => 'Ябыҡ викиларҙы үҙгәртергә',
	'right-closewikis' => 'Ябыҡ викилар',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'closewikis-desc' => 'Dameglichts Schliassen vo oazlne Wikis in ner Wikifarm',
	'closewikis-page' => 'Wiki schliassen.',
	'closewikis-page-close' => 'Wiki schliassen',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Åzoagter Grund:',
	'closewikis-page-close-reason' => 'Grund, der wos ins Logbuach aitrong werd:',
	'closewikis-page-close-submit' => 'Schliassen',
	'closewikis-page-close-success' => 'Wiki is erfoigraich gschlossen worn.',
	'closewikis-page-reopen' => 'Wiki wider effnan',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Grund:',
	'closewikis-page-reopen-submit' => 'Wider effna',
	'closewikis-page-reopen-success' => 'Wiki is wider erfoigraich geffnat',
	'closewikis-page-err-nowiki' => 'Ungüitigs Wiki ågeem',
	'closewikis-page-err-closed' => 'Wiki is beraits gschlossen',
	'closewikis-page-err-opened' => 'Wiki is ned gschlossen',
	'closewikis-list' => 'Listen vo de gschlossanen Wikis',
	'closewikis-list-intro' => 'De Listn do enthoit Wikis, de vo Stewards gschlossen worn san.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Gschlossen vo',
	'closewikis-list-header-timestamp' => 'Gschlossen am',
	'closewikis-list-header-dispreason' => 'Åzoagter Grund',
	'closewikis-log' => 'Wikischliassungs-Logbuach',
	'closewikis-log-header' => 'Des Logbuach do zoagt olle Schliassungen und Wiaderdaeffnungen vo Wikis duch an Steward å.',
	'closewikis-log-close' => 'gschlossen $2',
	'closewikis-log-reopen' => '$2 hod wiider geffnet',
	'right-editclosedwikis' => 'Gschlossane Wikis beorwaiten',
	'right-closewikis' => 'Wikis schliassen',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'closewikis-page-close-submit' => 'Закрыць',
	'closewikis-page-reopen-reason' => 'Прычына:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'closewikis-desc' => 'Дазваляе закрываць вікі-сайты ў вікі-фэрмах',
	'closewikis-page' => 'Закрыць вікі',
	'closewikis-page-close' => 'Закрыць вікі',
	'closewikis-page-close-wiki' => 'Вікі:',
	'closewikis-page-close-dreason' => 'Прычына (якая будзе паказвацца):',
	'closewikis-page-close-reason' => 'Прычына (для журнала):',
	'closewikis-page-close-submit' => 'Закрыць',
	'closewikis-page-close-success' => 'Вікі пасьпяхова закрытая',
	'closewikis-page-reopen' => 'Адкрыць вікі ізноў',
	'closewikis-page-reopen-wiki' => 'Вікі:',
	'closewikis-page-reopen-reason' => 'Прычына:',
	'closewikis-page-reopen-submit' => 'Адкрыць ізноў',
	'closewikis-page-reopen-success' => 'Вікі пасьпяхова адкрытая ізноў',
	'closewikis-page-err-nowiki' => 'Пазначаная няслушная вікі',
	'closewikis-page-err-closed' => 'Вікі ўжо закрытая',
	'closewikis-page-err-opened' => 'Вікі не закрытая',
	'closewikis-list' => 'Сьпіс закрытых вікі',
	'closewikis-list-intro' => 'Гэты сьпіс утрымлівае вікі, якія былі закрытыя сьцюардамі.',
	'closewikis-list-header-wiki' => 'Вікі',
	'closewikis-list-header-by' => 'Сьцюард',
	'closewikis-list-header-timestamp' => 'Дата',
	'closewikis-list-header-dispreason' => 'Прычына для паказу',
	'closewikis-log' => 'Журнал закрыцьця вікі',
	'closewikis-log-header' => 'Журнал усіх закрыцьцяй і адкрыцьцяй вікі сьцюардамі',
	'closewikis-log-close' => 'закрытая $2',
	'closewikis-log-reopen' => 'адкрытая ізноў $2',
	'right-editclosedwikis' => 'рэдагаваньне ў закрытых вікі',
	'right-closewikis' => 'закрыцьцё вікі',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 */
$messages['bg'] = array(
	'closewikis-desc' => 'Позволява да се затварят уикита в уики ферми',
	'closewikis-page' => 'Затваряне на уики',
	'closewikis-page-close' => 'Затваряне на уики',
	'closewikis-page-close-wiki' => 'Уики:',
	'closewikis-page-close-dreason' => 'Причина (публична):',
	'closewikis-page-close-reason' => 'Причина (за дневници)',
	'closewikis-page-close-submit' => 'Затваряне',
	'closewikis-page-close-success' => 'Уикито беше затворено.',
	'closewikis-page-reopen' => 'Отваряне на уики',
	'closewikis-page-reopen-wiki' => 'Уики:',
	'closewikis-page-reopen-reason' => 'Причина:',
	'closewikis-page-reopen-submit' => 'Отваряне наново',
	'closewikis-page-reopen-success' => 'Уикито беше наново отворено.',
	'closewikis-page-err-nowiki' => 'Посоченото уики е невалидно.',
	'closewikis-page-err-closed' => 'Уикито вече беше затворено.',
	'closewikis-page-err-opened' => 'Уикито не беше затворено.',
	'closewikis-list' => 'Списък на затворените уикита',
	'closewikis-list-intro' => 'Този списък съдържа уикита, които са били затворени от стюардите.',
	'closewikis-list-header-wiki' => 'Уики',
	'closewikis-list-header-by' => 'Затворено от',
	'closewikis-list-header-timestamp' => 'Затворено на',
	'closewikis-list-header-dispreason' => 'Причина',
	'closewikis-log' => 'Дневник на затварянията на уикита',
	'closewikis-log-header' => 'Това е дневник на всички затваряния и отваряния на уикита, направени от стюардите.',
	'closewikis-log-close' => 'затвори $2',
	'closewikis-log-reopen' => 'отвори $2',
	'right-editclosedwikis' => 'Редактиране на затворени уикита',
	'right-closewikis' => 'Затваряне на уикита',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'closewikis-desc' => 'উইকি ফার্মে উইকি সাইট বন্ধ করার সুযোগ দিন',
	'closewikis-page' => 'উইকি বন্ধ করুন',
	'closewikis-page-close' => 'উইকি বন্ধ করুন',
	'closewikis-page-close-wiki' => 'উইকি:',
	'closewikis-page-close-dreason' => 'কারণ (প্রদর্শিত):',
	'closewikis-page-close-reason' => 'কারণ (লগড):',
	'closewikis-page-close-submit' => 'বন্ধ',
	'closewikis-page-close-success' => 'উইকি সফলভাবে বন্ধ করা হয়েছে',
	'closewikis-page-reopen' => 'উইকি নতুন করে চালু করুন',
	'closewikis-page-reopen-wiki' => 'উইকি:',
	'closewikis-page-reopen-reason' => 'কারণ:',
	'closewikis-page-reopen-submit' => 'নতুন করে চালু করুন',
	'closewikis-page-reopen-success' => 'উইকি সফলভাবে পুনরায় চালু করা হয়েছে',
	'closewikis-page-err-nowiki' => 'অপ্রযোজ্য উইকি নির্বাচন করা হয়েছে',
	'closewikis-page-err-closed' => 'উইকি ইতিমধ্যেই বন্ধ রয়েছে',
	'closewikis-page-err-opened' => 'উইকি বন্ধ নয়',
	'closewikis-list' => 'বন্ধ হওয়া উইকির তালিকা',
	'closewikis-list-intro' => 'এই তালিকাটিতে এমন সব উইকি রয়েছে যেগুলো স্টুয়ার্ডদের দ্বারা বন্ধ করা হয়েছে।',
	'closewikis-list-header-wiki' => 'উইকি:',
	'closewikis-list-header-by' => 'বন্ধ করেছেন',
	'closewikis-list-header-timestamp' => 'বন্ধ হয়েছে',
	'closewikis-list-header-dispreason' => 'প্রদর্শনযোগ্য কারণ',
	'closewikis-log' => 'উইকি বন্ধের লগ',
	'closewikis-log-header' => 'এটি হচ্ছে স্টুয়ার্ড কর্তৃক বন্ধ ও পুনরায় চালু করা সকল উইকির লগ',
	'closewikis-log-close' => 'বন্ধ $2',
	'closewikis-log-reopen' => 'পুনরায় চালু $2',
	'right-editclosedwikis' => 'সম্পাদনা বন্ধ এমন উইকি',
	'right-closewikis' => 'উইকি বন্ধ করুন',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'closewikis-desc' => "Talvezout a ra da serriñ lec'hiennoù wiki er vagouri wikioù-mañ",
	'closewikis-page' => 'Serriñ ar wiki',
	'closewikis-page-close' => 'Serriñ ar wiki',
	'closewikis-page-close-wiki' => 'Wiki :',
	'closewikis-page-close-dreason' => 'Abeg (diskouezet) :',
	'closewikis-page-close-reason' => 'Abeg (enrollet) :',
	'closewikis-page-close-submit' => 'Serriñ',
	'closewikis-page-close-success' => 'Serret eo ar wiki',
	'closewikis-page-reopen' => 'Addigeriñ ar wiki',
	'closewikis-page-reopen-wiki' => 'Wiki :',
	'closewikis-page-reopen-reason' => 'Abeg :',
	'closewikis-page-reopen-submit' => 'Addigeriñ',
	'closewikis-page-reopen-success' => 'Addigoret eo bet ar wiki ervat',
	'closewikis-page-err-nowiki' => 'Fall eo ar wiki spisaet',
	'closewikis-page-err-closed' => 'Serret eo ar wiki dija',
	'closewikis-page-err-opened' => "N'eo ket serret ar wiki",
	'closewikis-list' => 'Roll ar wikioù serret',
	'closewikis-list-intro' => 'Er roll-mañ emañ ar wikioù serret gant stewarded.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Serret gant',
	'closewikis-list-header-timestamp' => "Serret d'an",
	'closewikis-list-header-dispreason' => 'Abeg diskwelet',
	'closewikis-log' => 'Marilh ar wikioù serret',
	'closewikis-log-header' => 'Amañ emañ marilh ar serriñ hag an addigeriñ wikioù graet gant stewarded',
	'closewikis-log-close' => '{{Gender:.|en|he}} deus serret $2',
	'closewikis-log-reopen' => '{{Gender:.|en|he}} deus addigoret $2',
	'right-editclosedwikis' => 'Aozañ ar wikioù serret',
	'right-closewikis' => 'Serriñ ar wikioù',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'closewikis-desc' => 'Omogućava zatvaranje wiki projekata u wiki farmama',
	'closewikis-page' => 'Zatvaranje wikija',
	'closewikis-page-close' => 'Zatvaranje wikija',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Razlog (prikazani):',
	'closewikis-page-close-reason' => 'Razlog (zapisani):',
	'closewikis-page-close-submit' => 'Zatvori',
	'closewikis-page-close-success' => 'Wiki uspješno zatvoren',
	'closewikis-page-reopen' => 'Ponovno otvaranje wikija',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Razlog:',
	'closewikis-page-reopen-submit' => 'Ponovno otvori',
	'closewikis-page-reopen-success' => 'Wiki uspješno ponovno otvoren',
	'closewikis-page-err-nowiki' => 'Navedeni wiki je nevaljan',
	'closewikis-page-err-closed' => 'Wiki je već zatvoren',
	'closewikis-page-err-opened' => 'Wiki nije zatvoren',
	'closewikis-list' => 'Spisak zatvorenih wikija',
	'closewikis-list-intro' => 'Ovaj spisak sadrži wikije koje su stjuardi zatvorili.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Zatvorio',
	'closewikis-list-header-timestamp' => 'Zatvoreno dana',
	'closewikis-list-header-dispreason' => 'Navedeni razlog',
	'closewikis-log' => 'Zapisnik o zatvaranju wikija',
	'closewikis-log-header' => 'Ovdje se nalazi zapisnik svih zatvaranja i ponovnih otvaranja wikija koje su načinili stjuardi.',
	'closewikis-log-close' => 'zatvoreno $2',
	'closewikis-log-reopen' => 'ponovno otvoreno $2',
	'right-editclosedwikis' => 'Uređivanje zatvorenih wikija',
	'right-closewikis' => 'Zatvaranje wikija',
);

/** Catalan (Català)
 * @author Paucabot
 * @author SMP
 */
$messages['ca'] = array(
	'closewikis-desc' => 'Permet tancar llocs wiki en granges de wikis',
	'closewikis-page' => 'Tanca el wiki',
	'closewikis-page-close' => 'Tanca el wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Motiu (mostrat):',
	'closewikis-page-close-reason' => 'Motiu (registrat):',
	'closewikis-page-close-submit' => 'Tanca',
	'closewikis-page-close-success' => "El wiki s'ha tancat amb èxit",
	'closewikis-page-reopen' => 'Reobre el wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Motiu:',
	'closewikis-page-reopen-submit' => 'Reobre',
	'closewikis-page-reopen-success' => "El wiki s'ha reobert satisfactòriament",
	'closewikis-page-err-nowiki' => 'Wiki especificat no vàlid',
	'closewikis-page-err-closed' => 'El wiki ja està tancat',
	'closewikis-page-err-opened' => 'El wiki no està tancat',
	'closewikis-list' => 'Llista de wikis tancats',
	'closewikis-list-intro' => 'Aquesta llista conté els wikis tancats pels stewards',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Tancat per',
	'closewikis-list-header-timestamp' => 'Tancat el',
	'closewikis-list-header-dispreason' => 'Motiu mostrat',
	'closewikis-log' => 'Registre de tancament de wikis',
	'closewikis-log-header' => 'Aquí teniu un registre de tots els tancaments i reobertures de wikis fetes pels stewards',
	'closewikis-log-close' => 'tancat $2',
	'closewikis-log-reopen' => 'reobert $2',
	'right-editclosedwikis' => 'Editar en wikis tancats',
	'right-closewikis' => 'Tancar wikis',
);

/** Chechen (Нохчийн) */
$messages['ce'] = array(
	'closewikis-page-reopen-reason' => 'Бахьан:',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'closewikis-page-reopen-reason' => 'هۆکار:',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 */
$messages['cs'] = array(
	'closewikis-desc' => 'Umožňuje uzavřít jednotlivé wiki na wikifarmách',
	'closewikis-page' => 'Zavření wiki',
	'closewikis-page-close' => 'Zavřít wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Důvod (k zobrazení):',
	'closewikis-page-close-reason' => 'Důvod (k zapsání do knihy):',
	'closewikis-page-close-submit' => 'Zavřít',
	'closewikis-page-close-success' => 'Wiki byla úspěšně zavřena',
	'closewikis-page-reopen' => 'Znovu otevřít wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Důvod:',
	'closewikis-page-reopen-submit' => 'Otevřít',
	'closewikis-page-reopen-success' => 'Wiki byla úspěšně otevřena',
	'closewikis-page-err-nowiki' => 'Chybné určení wiki',
	'closewikis-page-err-closed' => 'Wiki již je zavřena',
	'closewikis-page-err-opened' => 'Wiki není zavřená',
	'closewikis-list' => 'Seznam uzavřených wiki',
	'closewikis-list-intro' => 'Tento seznam obsahuje wiki uzavřené stewardy.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Zavřel',
	'closewikis-list-header-timestamp' => 'Kdy',
	'closewikis-list-header-dispreason' => 'Zobrazený důvod',
	'closewikis-log' => 'Kniha zavření wiki',
	'closewikis-log-header' => 'Tato kniha zachycuje všechna zavření a znovuotevření wiki provedená stevardy',
	'closewikis-log-close' => 'uzavírá $2',
	'closewikis-log-reopen' => 'opět otevírá $2',
	'right-editclosedwikis' => 'Editování uzavřených wiki',
	'right-closewikis' => 'Zavírání wiki',
);

/** German (Deutsch)
 * @author ChrisiPK
 */
$messages['de'] = array(
	'closewikis-desc' => 'Ermöglicht das Schließen einzelner Wikis in einer Wikifarm',
	'closewikis-page' => 'Wiki schließen.',
	'closewikis-page-close' => 'Wiki schließen',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Angezeigter Grund:',
	'closewikis-page-close-reason' => 'Grund, der ins Logbuch eingetragen wird:',
	'closewikis-page-close-submit' => 'Schließen',
	'closewikis-page-close-success' => 'Wiki erfolgreich geschlossen.',
	'closewikis-page-reopen' => 'Wiki wieder öffnen',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Grund:',
	'closewikis-page-reopen-submit' => 'Wieder öffnen',
	'closewikis-page-reopen-success' => 'Wiki erfolgreich wieder geöffnet',
	'closewikis-page-err-nowiki' => 'Ungültiges Wiki angegeben',
	'closewikis-page-err-closed' => 'Wiki ist bereits geschlossen',
	'closewikis-page-err-opened' => 'Wiki ist nicht geschlossen',
	'closewikis-list' => 'Liste geschlossener Wikis',
	'closewikis-list-intro' => 'Diese Liste enthält Wikis, die von Stewards geschlossen wurden.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Geschlossen von',
	'closewikis-list-header-timestamp' => 'Geschlossen am',
	'closewikis-list-header-dispreason' => 'Angezeigter Grund',
	'closewikis-log' => 'Wikischließungs-Logbuch',
	'closewikis-log-header' => 'Dieses Logbuch zeigt alle Schließungen und Wiederöffnungen von Wikis durch Stewards an.',
	'closewikis-log-close' => 'schloss $2',
	'closewikis-log-reopen' => 'öffnete $2 wieder',
	'right-editclosedwikis' => 'Geschlossene Wikis bearbeiten',
	'right-closewikis' => 'Wikis schließen',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'closewikis-desc' => 'Zmóžnja wikijowe sedła we wikijowych farmach zacyniś',
	'closewikis-page' => 'Wiki zacyniś',
	'closewikis-page-close' => 'Wiki zacyniś',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Pśicyna (zwobraznjona):',
	'closewikis-page-close-reason' => 'Pśicyna (sprotokolěrowana):',
	'closewikis-page-close-submit' => 'Zacyniś',
	'closewikis-page-close-success' => 'Wiki wuspěšnje zacynjony',
	'closewikis-page-reopen' => 'Wiki zasej wócyniś',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Pśicyna:',
	'closewikis-page-reopen-submit' => 'Zasej wócyniś',
	'closewikis-page-reopen-success' => 'Wiki wuspěšnje zasej wócynjony',
	'closewikis-page-err-nowiki' => 'Njepłaśiwy wiki pódany',
	'closewikis-page-err-closed' => 'Wiki jo južo zacynjony',
	'closewikis-page-err-opened' => 'Wiki njejo zacynjony',
	'closewikis-list' => 'Lisćina zacynjonych wikijow',
	'closewikis-list-intro' => 'Toś ta lisćina wopśimujo wikije, kótarež stewardy su zacynili.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Zacynjony wót',
	'closewikis-list-header-timestamp' => 'Zacynjony',
	'closewikis-list-header-dispreason' => 'Zwobraznjona pśicyna',
	'closewikis-log' => 'Protokol wikijowego zacynjenja',
	'closewikis-log-header' => 'How jo protokol wšych wikijowych zacynjenjow a zasejwócynjenjow, kótarež stewardy su cynili',
	'closewikis-log-close' => 'jo $2 zacynił',
	'closewikis-log-reopen' => 'jo $2 zasej wócynił',
	'right-editclosedwikis' => 'Zacynjone wikije wobźěłaś',
	'right-closewikis' => 'Wikije zacyniś',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Glavkos
 * @author Omnipaedista
 */
$messages['el'] = array(
	'closewikis-desc' => 'Επιτρέπει να κλείσει wiki ιστοσελίδες  σε wiki φάρμες',
	'closewikis-page' => 'Κλείσιμο του βίκι',
	'closewikis-page-close' => 'Κλείσιμο του βίκι',
	'closewikis-page-close-wiki' => 'Βίκι:',
	'closewikis-page-close-dreason' => 'Λόγος (εμφανίζεται):',
	'closewikis-page-close-submit' => 'Κλείσιμο',
	'closewikis-page-close-success' => 'Το Wiki έκλεισε επιτυχώς',
	'closewikis-page-reopen' => 'Ξανάνοιγμα του βίκι',
	'closewikis-page-reopen-wiki' => 'Βίκι:',
	'closewikis-page-reopen-reason' => 'Αιτία:',
	'closewikis-page-reopen-submit' => 'Ξανάνοιγμα',
	'closewikis-page-reopen-success' => 'Το Wiki ξανάνοιξε επιτυχώς',
	'closewikis-page-err-nowiki' => 'Καθορίστηκε μη έγκυρο wiki',
	'closewikis-page-err-closed' => 'Το Wiki έχει ήδη κλείσει',
	'closewikis-page-err-opened' => 'Το βίκι δεν είναι κλειστό',
	'closewikis-list' => 'Λίστα κλειστών  wikis',
	'closewikis-list-intro' => 'Αυτή η λίστα περιέχει τα wikis που έκλεισαν από επιτρόπους',
	'closewikis-list-header-wiki' => 'Βίκι',
	'closewikis-list-header-by' => 'Κλειστό από',
	'closewikis-list-header-timestamp' => 'Έκλεισε στις',
	'closewikis-list-header-dispreason' => 'Προβαλλόμενη αιτία',
	'closewikis-log' => 'Ημερολόγιο κλεισίματος βίκι',
	'closewikis-log-close' => 'έκλεισε $2',
	'closewikis-log-reopen' => 'ξανάνοιξε $2',
	'right-editclosedwikis' => 'Επεξεργασία κλεισμένων βίκι',
	'right-closewikis' => 'Κλείσιμο των βίκι',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'closewikis-desc' => 'Permesas fermi vikiojn en vikiaroj',
	'closewikis-page' => 'Fermi vikion',
	'closewikis-page-close' => 'Fermi vikion',
	'closewikis-page-close-wiki' => 'Vikio:',
	'closewikis-page-close-dreason' => 'Kialo (montrota):',
	'closewikis-page-close-reason' => 'Kialo (protokolota):',
	'closewikis-page-close-submit' => 'Fermi',
	'closewikis-page-close-success' => 'Vikio estis sukcese fermita',
	'closewikis-page-reopen' => 'Remalfermi vikion',
	'closewikis-page-reopen-wiki' => 'Vikio:',
	'closewikis-page-reopen-reason' => 'Kialo:',
	'closewikis-page-reopen-submit' => 'Remalfermi',
	'closewikis-page-reopen-success' => 'Vikio estis sukcese remalfermita',
	'closewikis-page-err-nowiki' => 'Nevalida vikio estis specifita',
	'closewikis-page-err-closed' => 'Vikio estas jam fermita',
	'closewikis-page-err-opened' => 'Vikio ne estas fermita',
	'closewikis-list' => 'Listo de fermaj vikioj',
	'closewikis-list-intro' => 'Ĉi tiu listo enhavas vikiojn kiu estis fermita de stivardoj.',
	'closewikis-list-header-wiki' => 'Vikio',
	'closewikis-list-header-by' => 'Fermis de',
	'closewikis-list-header-timestamp' => 'Fermis je',
	'closewikis-list-header-dispreason' => 'Montrita kialo',
	'closewikis-log' => 'Protokolo pri vikia fermado',
	'closewikis-log-header' => 'Jen protokolo de ĉiuj viki-fermadoj kaj remalfermadoj de stevardoj',
	'closewikis-log-close' => 'fermis $2',
	'closewikis-log-reopen' => 'remalfermis $2',
	'right-editclosedwikis' => 'Redakti fermitajn vikiojn',
	'right-closewikis' => 'Fermi vikiojn',
);

/** Spanish (Español)
 * @author BicScope
 * @author Fitoschido
 */
$messages['es'] = array(
	'closewikis-desc' => 'Permitir cerrar sitios wiki en granjas wiki',
	'closewikis-page' => 'Cerrar wiki',
	'closewikis-page-close' => 'Cerrar wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Razón (especificada):',
	'closewikis-page-close-reason' => 'Razón (inicial):',
	'closewikis-page-close-submit' => 'Cerrar',
	'closewikis-page-close-success' => 'La wiki ha sido cerrada satisfactoriamente',
	'closewikis-page-reopen' => 'Reabrir  wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Motivo:',
	'closewikis-page-reopen-submit' => 'Reabrir',
	'closewikis-page-reopen-success' => 'La wiki ha sido reabierta satisfactoriamente',
	'closewikis-page-err-nowiki' => 'Ha entrado un nombre wiki inválido',
	'closewikis-page-err-closed' => 'La wiki ya está cerrada',
	'closewikis-page-err-opened' => 'La wiki no está cerrada',
	'closewikis-list' => 'Lista de wikis cerradas:',
	'closewikis-list-intro' => 'Ésta lista contiene wikis que fueron cerradas por administradores (stewards).',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Cerrada por',
	'closewikis-list-header-timestamp' => 'Cerrada el',
	'closewikis-list-header-dispreason' => 'Razón',
	'closewikis-log' => 'Registro de wikis cerradas',
	'closewikis-log-header' => 'He aquí un registro de todas las wikis cerradas y reabiertas hechas por administradores (stewards)',
	'closewikis-log-close' => '$2 cerrada',
	'closewikis-log-reopen' => '$2 reabierta',
	'right-editclosedwikis' => 'Editar wikis cerradas',
	'right-closewikis' => 'Cerrar wikis',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author KalmerE.
 * @author Pikne
 */
$messages['et'] = array(
	'closewikis-page' => 'Sulge wiki',
	'closewikis-page-close' => 'Sulge wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Põhjus (näidatud):',
	'closewikis-page-close-reason' => 'Põhjus (logitud):',
	'closewikis-page-close-submit' => 'Sulge',
	'closewikis-page-close-success' => 'Wiki edukalt suletud',
	'closewikis-page-reopen' => 'Taasava wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Põhjus:',
	'closewikis-page-reopen-submit' => 'Taasava',
	'closewikis-page-reopen-success' => 'Wiki edukalt taasavatud',
	'closewikis-page-err-closed' => 'Wiki on juba suletud',
	'closewikis-page-err-opened' => 'Wiki ei ole suletud',
	'closewikis-list' => 'Suletud wikide list',
	'closewikis-list-header-wiki' => 'Viki',
	'closewikis-list-header-by' => 'Sulgeja:',
	'closewikis-list-header-timestamp' => 'Suletud',
	'closewikis-list-header-dispreason' => 'Põhjus esitatud',
	'closewikis-log' => 'Vikide sulgemislogi',
	'closewikis-log-close' => 'suleti $2',
	'closewikis-log-reopen' => 'taasavati $2',
	'right-editclosedwikis' => 'Redigeerida suletud vikisid',
	'right-closewikis' => 'Sulgeda vikisid',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'closewikis-page' => 'Wikia itxi',
	'closewikis-page-close' => 'Wikia itxi',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-submit' => 'Itxi',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Arrazoia:',
	'closewikis-page-reopen-submit' => 'Berrireki',
	'closewikis-list' => 'Itxitako wikien zerrenda',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-log-close' => '$2 itxita',
	'closewikis-log-reopen' => '$2 berrirekia',
	'right-closewikis' => 'Wikiak itxi',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'closewikis-page-close-wiki' => 'ویکی:',
	'closewikis-page-reopen-wiki' => 'ویکی:',
	'closewikis-list-header-wiki' => 'ویکی',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'closewikis-page' => 'Sulje wiki',
	'closewikis-page-close' => 'Sulje wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Syy (näytetty):',
	'closewikis-page-close-reason' => 'Syy (kirjattu):',
	'closewikis-page-close-submit' => 'Sulje',
	'closewikis-page-close-success' => 'Wiki suljettiin onnistuneesti',
	'closewikis-page-reopen' => 'Avaa wiki uudestaan',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Syy:',
	'closewikis-page-reopen-submit' => 'Avaa uudelleen',
	'closewikis-page-reopen-success' => 'Wiki avattiin onnistuneesti uudelleen',
	'closewikis-page-err-nowiki' => 'Annettu wiki ei kelpaa',
	'closewikis-page-err-closed' => 'Wiki on jo suljettu',
	'closewikis-page-err-opened' => 'Wikiä ei ole suljettu',
	'closewikis-list' => 'Suljettujen wikien luettelo',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Sulkija:',
	'closewikis-list-header-timestamp' => 'Suljettu',
	'closewikis-list-header-dispreason' => 'Näytetty syy',
	'closewikis-log' => 'Wikien sulkemisloki',
	'closewikis-log-close' => 'suljettiin $2',
	'closewikis-log-reopen' => 'avattiin $2 uudelleen',
	'right-editclosedwikis' => 'Muokata suljettuja wikejä',
	'right-closewikis' => 'Sulkea wikejä',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Zetud
 */
$messages['fr'] = array(
	'closewikis-desc' => 'Permet de clôturer les sites wiki dans ce gestionnaire de wiki',
	'closewikis-page' => 'Clôturer le wiki',
	'closewikis-page-close' => 'Clôturer le wiki',
	'closewikis-page-close-wiki' => 'Wiki :',
	'closewikis-page-close-dreason' => 'Motif (affiché) :',
	'closewikis-page-close-reason' => 'Motif (enregistré) :',
	'closewikis-page-close-submit' => 'Clôturer',
	'closewikis-page-close-success' => 'Wiki clôturé avec succès',
	'closewikis-page-reopen' => 'Réouvrir le wiki',
	'closewikis-page-reopen-wiki' => 'Wiki :',
	'closewikis-page-reopen-reason' => 'Motif :',
	'closewikis-page-reopen-submit' => 'Réouvrir',
	'closewikis-page-reopen-success' => 'Wiki réouvert avec succès',
	'closewikis-page-err-nowiki' => 'Le wiki indiqué est incorrect',
	'closewikis-page-err-closed' => 'Ce wiki est déjà clôturé',
	'closewikis-page-err-opened' => 'Wiki non clôturé',
	'closewikis-list' => 'Liste des wikis clos',
	'closewikis-list-intro' => 'Cette liste contient les wiki clos par les stewards.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Clos par',
	'closewikis-list-header-timestamp' => 'Clos le',
	'closewikis-list-header-dispreason' => 'Raison donnée',
	'closewikis-log' => 'Journal de clôture des wiki',
	'closewikis-log-header' => 'Voici un journal de toutes les fermetures et réouvertures de wiki faites par les stewards',
	'closewikis-log-close' => 'a clôturé $2',
	'closewikis-log-reopen' => 'a réouvert $2',
	'right-editclosedwikis' => 'Modifier les wikis clôturés',
	'right-closewikis' => 'Clôturer les wikis',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'closewikis-desc' => 'Pèrmèt de cllôre los setos vouiqui dens la fèrma vouiqui.',
	'closewikis-page' => 'Cllôre lo vouiqui',
	'closewikis-page-close' => 'Cllôre lo vouiqui',
	'closewikis-page-close-wiki' => 'Vouiqui :',
	'closewikis-page-close-dreason' => 'Rêson (montrâ) :',
	'closewikis-page-close-reason' => 'Rêson (encartâ) :',
	'closewikis-page-close-submit' => 'Cllôre',
	'closewikis-page-close-success' => 'Vouiqui cllôs avouéc reusséta',
	'closewikis-page-reopen' => 'Tornar uvrir lo vouiqui',
	'closewikis-page-reopen-wiki' => 'Vouiqui :',
	'closewikis-page-reopen-reason' => 'Rêson :',
	'closewikis-page-reopen-submit' => 'Tornar uvrir',
	'closewikis-page-reopen-success' => 'Vouiqui tornâ uvrir avouéc reusséta',
	'closewikis-page-err-nowiki' => 'Lo vouiqui spècefiâ est fôx',
	'closewikis-page-err-closed' => 'Lo vouiqui est ja cllôs',
	'closewikis-page-err-opened' => 'Lo vouiqui est pas cllôs',
	'closewikis-list' => 'Lista des vouiquis cllôs',
	'closewikis-list-intro' => 'Ceta lista contint los vouiquis cllôs per los stevârds.',
	'closewikis-list-header-wiki' => 'Vouiqui',
	'closewikis-list-header-by' => 'Cllôs per',
	'closewikis-list-header-timestamp' => 'Cllôs lo',
	'closewikis-list-header-dispreason' => 'Rêson balyê',
	'closewikis-log' => 'Jornal de cllotura des vouiquis',
	'closewikis-log-close' => 'at cllôs $2',
	'closewikis-log-reopen' => 'at tornâ uvrir $2',
	'right-editclosedwikis' => 'Changiér los vouiquis cllôs',
	'right-closewikis' => 'Cllôre los vouiquis',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'closewikis-page-close-wiki' => 'Vicí:',
	'closewikis-list-header-wiki' => 'Vicí',
	'closewikis-list-header-by' => 'Dúnadh le',
	'closewikis-list-header-timestamp' => 'Dúnadh ar',
	'closewikis-log-close' => 'dúnta $2',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'closewikis-desc' => 'Permite pechar wikis nas granxas wiki',
	'closewikis-page' => 'Pechar o wiki',
	'closewikis-page-close' => 'Pechar o wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Motivo (amosado):',
	'closewikis-page-close-reason' => 'Motivo (rexistro):',
	'closewikis-page-close-submit' => 'Pechar',
	'closewikis-page-close-success' => 'O wiki foi pechado con éxito',
	'closewikis-page-reopen' => 'Reabrir o wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Motivo:',
	'closewikis-page-reopen-submit' => 'Reabrir',
	'closewikis-page-reopen-success' => 'O wiki foi aberto de novo con éxito',
	'closewikis-page-err-nowiki' => 'Especificou un wiki inválido',
	'closewikis-page-err-closed' => 'O wiki xa está pechado',
	'closewikis-page-err-opened' => 'O wiki non está pechado',
	'closewikis-list' => 'Lista dos wikis pechados',
	'closewikis-list-intro' => 'Esta lista contén os wikis que foron pechados polos stewards.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Pechado por',
	'closewikis-list-header-timestamp' => 'Pechado o',
	'closewikis-list-header-dispreason' => 'Motivo exposto',
	'closewikis-log' => 'Rexistro de peches de wikis',
	'closewikis-log-header' => 'Aquí hai un rexistro de todos os peches e reaperturas de wikis feitos polos stewards',
	'closewikis-log-close' => 'pechou "$2"',
	'closewikis-log-reopen' => 'volveu abrir "$2"',
	'right-editclosedwikis' => 'Editar wikis pechados',
	'right-closewikis' => 'Pechar wikis',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'closewikis-page-close-wiki' => 'Βίκι:',
	'closewikis-page-close-submit' => 'Κλῄειν',
	'closewikis-page-reopen-wiki' => 'Βίκι:',
	'closewikis-page-reopen-reason' => 'Αἰτία:',
	'closewikis-page-reopen-submit' => 'Ἀνοίγειν πάλιν',
	'closewikis-list-header-wiki' => 'Βίκι',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'closewikis-desc' => 'Macht s Zuemache megli vun eme einzelne Wiki in eme Wikihof',
	'closewikis-page' => 'Wiki zuemache.',
	'closewikis-page-close' => 'Wiki zuemache',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Aazeigter Grund:',
	'closewikis-page-close-reason' => 'Grund, wu in s Logbuech yytrait wird:',
	'closewikis-page-close-submit' => 'Zuemache',
	'closewikis-page-close-success' => 'Wiki mit Erfolg zuegmacht',
	'closewikis-page-reopen' => 'Wiki wider ufmache',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Grund:',
	'closewikis-page-reopen-submit' => 'Wider ufmache',
	'closewikis-page-reopen-success' => 'Wiki mit Erfolg wider ufgmacht',
	'closewikis-page-err-nowiki' => 'Uugiltig Wiki aagee',
	'closewikis-page-err-closed' => 'Wiki isch scho zuegmacht',
	'closewikis-page-err-opened' => 'Wiki isch nit zuegmacht',
	'closewikis-list' => 'Lischt vu Wiki, wu zuegmacht sin',
	'closewikis-list-intro' => 'In däre Lischt het s Wiki, wu vu Steward zuegmacht wore sin.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Zuegmacht vu',
	'closewikis-list-header-timestamp' => 'Zuegmacht am',
	'closewikis-list-header-dispreason' => 'Aazeigte Grund',
	'closewikis-log' => 'Logbuech iber zuegmachti Wiki',
	'closewikis-log-header' => 'In däm Logbuech het s alli Wiki, wu vu Steward zuegmacht un wider ufgmacht wore sin.',
	'closewikis-log-close' => 'het $2 zuegmacht',
	'closewikis-log-reopen' => 'het $2 wider ufgmacht',
	'right-editclosedwikis' => 'Zuegmachti Wiki bearbeite',
	'right-closewikis' => 'Wiki zuemache',
);

/** Manx (Gaelg)
 * @author Shimmin Beg
 */
$messages['gv'] = array(
	'closewikis-page-reopen-reason' => 'Fa:',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'closewikis-page-reopen-reason' => 'Dalili:',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'closewikis-desc' => 'הרחבה המאפשרת לסגור אתרי ויקי בחוות ויקי',
	'closewikis-page' => 'סגירת ויקי',
	'closewikis-page-close' => 'סגירת ויקי',
	'closewikis-page-close-wiki' => 'ויקי:',
	'closewikis-page-close-dreason' => 'סיבה (לתצוגה):',
	'closewikis-page-close-reason' => 'סיבה (לרישום ביומן):',
	'closewikis-page-close-submit' => 'סגירה',
	'closewikis-page-close-success' => 'הוויקי נסגר בהצלחה',
	'closewikis-page-reopen' => 'פתיחת הוויקי מחדש',
	'closewikis-page-reopen-wiki' => 'ויקי:',
	'closewikis-page-reopen-reason' => 'סיבה:',
	'closewikis-page-reopen-submit' => 'פתיחה מחדש',
	'closewikis-page-reopen-success' => 'הוויקי נפתח מחדש בהצלחה',
	'closewikis-page-err-nowiki' => 'הוויקי שצוין שגוי',
	'closewikis-page-err-closed' => 'הוויקי כבר סגור',
	'closewikis-page-err-opened' => 'הוויקי אינו סגור',
	'closewikis-list' => 'רשימת אתרי הוויקי הסגורים',
	'closewikis-list-intro' => 'הרשימה מכילה אתרי ויקי שנסגרו על ידי דיילים.',
	'closewikis-list-header-wiki' => 'ויקי',
	'closewikis-list-header-by' => 'נסגר על ידי',
	'closewikis-list-header-timestamp' => 'נסגר בתאריך',
	'closewikis-list-header-dispreason' => 'הסיבה המוצגת',
	'closewikis-log' => 'יומן סגירת אתרי ויקי',
	'closewikis-log-header' => 'להלן יומן של כל הסגירות והפתיחות מחדש של אתרי ויקי שבוצעו על ידי דיילים.',
	'closewikis-log-close' => 'נסגר $2',
	'closewikis-log-reopen' => 'נפתח מחדש $2',
	'right-editclosedwikis' => 'עריכת אתרי הוויקי הסגורים',
	'right-closewikis' => 'סגירת אתרי ויקי',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'closewikis-desc' => 'Zmóžnja začinjenje wikijowych sydłow we wikijowych farmach',
	'closewikis-page' => 'Wiki začinić',
	'closewikis-page-close' => 'Wiki začinić',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Zwobraznjena přičina:',
	'closewikis-page-close-reason' => 'Protokolowana přičina:',
	'closewikis-page-close-submit' => 'Začinić',
	'closewikis-page-close-success' => 'Wiki wuspěšnje začinjeny',
	'closewikis-page-reopen' => 'Wiki zaso wočinić',
	'closewikis-page-reopen-wiki' => 'wiki:',
	'closewikis-page-reopen-reason' => 'Přičina:',
	'closewikis-page-reopen-submit' => 'Zaso wočinić',
	'closewikis-page-reopen-success' => 'Wiki wuspěšnje zaso wočinjeny',
	'closewikis-page-err-nowiki' => 'Njepłaćiwy wiki podaty',
	'closewikis-page-err-closed' => 'Wiki je hižo začinjeny',
	'closewikis-page-err-opened' => 'Wiki njeje začinjeny',
	'closewikis-list' => 'Lisćina začinjenych wikijow',
	'closewikis-list-intro' => 'Tuta lisćina wobsahuje wikije, kotrež buchu wot stewardow začinjene.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Začinjeny wot',
	'closewikis-list-header-timestamp' => 'Začinjeny',
	'closewikis-list-header-dispreason' => 'Zwobraznjena přičina',
	'closewikis-log' => 'Protokol začinjenjow wikijow',
	'closewikis-log-header' => 'To je protokol wšěch začinjenjow a zasowočinjenjow wikijow, kotrež su stewardźa činili.',
	'closewikis-log-close' => 'je $2 začinił',
	'closewikis-log-reopen' => 'je $2 zaso wočinił',
	'right-editclosedwikis' => 'Začinjene wikije wobdźěłać',
	'right-closewikis' => 'Wikije začinić',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'closewikis-desc' => 'Lehetővé teszi wikik bezárását wikifarmokon',
	'closewikis-page' => 'Wiki bezárása',
	'closewikis-page-close' => 'Wiki bezárása',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Ok (megjelenített):',
	'closewikis-page-close-reason' => 'Ok (naplózott):',
	'closewikis-page-close-submit' => 'Bezárás',
	'closewikis-page-close-success' => 'Wiki sikeresen bezárva',
	'closewikis-page-reopen' => 'Wiki megnyitása',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Ok:',
	'closewikis-page-reopen-submit' => 'Megnyitás',
	'closewikis-page-reopen-success' => 'Wiki sikeresen megnyitva',
	'closewikis-page-err-nowiki' => 'A megadott wiki érvénytelen',
	'closewikis-page-err-closed' => 'A wiki már be van zárva',
	'closewikis-page-err-opened' => 'A megadott wiki nincs bezárva',
	'closewikis-list' => 'Bezárt wikik listája',
	'closewikis-list-intro' => 'Ez a lista azon wikik listáját tartalmazza, amiket bezártak a helytartók.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Bezárta',
	'closewikis-list-header-timestamp' => 'Bezárás ideje:',
	'closewikis-list-header-dispreason' => 'Megjelenített ok',
	'closewikis-log' => 'Wikibezárási napló',
	'closewikis-log-header' => 'Itt található a helytartók által végzett wikibezárások és újra-megnyitások listája',
	'closewikis-log-close' => 'bezárta a(z) $2 wikit',
	'closewikis-log-reopen' => 'újra megnyitotta a(z) $2 wikit',
	'right-editclosedwikis' => 'bezárt wikik szerkesztése',
	'right-closewikis' => 'wikik bezárása',
);

/** Interlingua (Interlingua)
 * @author Malafaya
 * @author McDutchie
 */
$messages['ia'] = array(
	'closewikis-desc' => 'Permitte clauder sitos wiki in fermas de wikis.',
	'closewikis-page' => 'Clauder wiki',
	'closewikis-page-close' => 'Clauder wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Motivo (public):',
	'closewikis-page-close-reason' => 'Motivo (pro le registro):',
	'closewikis-page-close-submit' => 'Clauder',
	'closewikis-page-close-success' => 'Wiki claudite con successo',
	'closewikis-page-reopen' => 'Reaperir wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Motivo:',
	'closewikis-page-reopen-submit' => 'Reaperir',
	'closewikis-page-reopen-success' => 'Wiki reaperite con successo',
	'closewikis-page-err-nowiki' => 'Le wiki specificate es invalide',
	'closewikis-page-err-closed' => 'Iste wiki es ja claudite',
	'closewikis-page-err-opened' => 'Le wiki non es claudite',
	'closewikis-list' => 'Lista de wikis claudite',
	'closewikis-list-intro' => 'Iste lista contine wikis que ha essite claudite per stewards.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Claudite per',
	'closewikis-list-header-timestamp' => 'Claudite le',
	'closewikis-list-header-dispreason' => 'Motivo public',
	'closewikis-log' => 'Registro de clausura de wikis',
	'closewikis-log-header' => 'Ecce un registro de tote le clausuras e reaperturas de wikis facite per stewards',
	'closewikis-log-close' => 'claudeva $2',
	'closewikis-log-reopen' => 'reaperiva $2',
	'right-editclosedwikis' => 'Modificar wikis claudite',
	'right-closewikis' => 'Clauder wikis',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'closewikis-desc' => 'Mengijinkan penutupan situs wiki di sebuah lahan wiki',
	'closewikis-page' => 'Tutup wiki',
	'closewikis-page-close' => 'Tutup wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Alasan (ditampilkan):',
	'closewikis-page-close-reason' => 'Alasan (dicatat log):',
	'closewikis-page-close-submit' => 'Tutup',
	'closewikis-page-close-success' => 'Wiki ditutup dengan sukses',
	'closewikis-page-reopen' => 'Buka ulang wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Alasan:',
	'closewikis-page-reopen-submit' => 'Buka kembali',
	'closewikis-page-reopen-success' => 'Wiki dibuka kembali dengan sukses',
	'closewikis-page-err-nowiki' => 'Wiki tidak sah',
	'closewikis-page-err-closed' => 'Wiki telah ditutup',
	'closewikis-page-err-opened' => 'Wiki tidak ditutup',
	'closewikis-list' => 'Daftar wiki yang ditutup',
	'closewikis-list-intro' => 'Daftar ini adalah wiki-wiki yang ditutup oleh pengelola.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Ditutup oleh',
	'closewikis-list-header-timestamp' => 'Ditutup pada',
	'closewikis-list-header-dispreason' => 'Alasan yang ditampilkan',
	'closewikis-log' => 'Log penutupan wiki',
	'closewikis-log-header' => 'Daftar ini adalah log penutupan dan pembukaan ulang wiki oleh pengelola.',
	'closewikis-log-close' => 'ditutup $2',
	'closewikis-log-reopen' => 'dibuka ulang $2',
	'right-editclosedwikis' => 'Sunting wiki yang ditutup',
	'right-closewikis' => 'Tutup wiki',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-submit' => 'Mèchié',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Mgbághapụtà:',
	'closewikis-page-reopen-submit' => 'Mèpókwá',
	'closewikis-list-header-wiki' => 'Wiki',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'closewikis-page' => 'Klozar wiki',
	'closewikis-page-close' => 'Klozar wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-submit' => 'Klozez',
	'closewikis-page-reopen' => 'Ri-apertar wiki',
	'closewikis-page-reopen-reason' => 'Motivo:',
	'closewikis-page-reopen-submit' => 'Ri-apertez',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Klozita da',
	'closewikis-list-header-timestamp' => 'Klozita ye',
	'closewikis-log-close' => 'klozis $2',
	'closewikis-log-reopen' => 'ri-apertis $2',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Pietrodn
 */
$messages['it'] = array(
	'closewikis-desc' => 'Permette di chiudere i siti wiki nelle famiglie wiki',
	'closewikis-page' => 'Chiudi wiki',
	'closewikis-page-close' => 'Chiudi wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Motivo (visualizzato):',
	'closewikis-page-close-reason' => 'Motivo (registrato):',
	'closewikis-page-close-submit' => 'Chiudi',
	'closewikis-page-close-success' => 'Wiki chiusa con successo',
	'closewikis-page-reopen' => 'Riapri wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Motivo:',
	'closewikis-page-reopen-submit' => 'Riapri',
	'closewikis-page-reopen-success' => 'Wiki riaperta con successo',
	'closewikis-page-err-nowiki' => 'Specificata una wiki non valida',
	'closewikis-page-err-closed' => 'La wiki è già chiusa',
	'closewikis-page-err-opened' => 'La wiki non è chiusa',
	'closewikis-list' => 'Elenco di wiki chiuse',
	'closewikis-list-intro' => 'Questo elenco contiene le wiki che sono state chiuse dagli steward.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Chiusa da',
	'closewikis-list-header-timestamp' => 'Chiusa il',
	'closewikis-list-header-dispreason' => 'Motivazione mostrata',
	'closewikis-log' => 'Registro di chiusura delle wiki',
	'closewikis-log-header' => 'Ecco un log di tutte le chiusure e riaperture delle wiki eseguite dagli steward',
	'closewikis-log-close' => 'chiusa $2',
	'closewikis-log-reopen' => 'riaperta $2',
	'right-editclosedwikis' => 'Modifica le wiki chiuse',
	'right-closewikis' => 'Chiude wiki',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author 青子守歌
 */
$messages['ja'] = array(
	'closewikis-desc' => 'ウィキファーム内のウィキサイトを閉鎖できるようにする',
	'closewikis-page' => 'ウィキを閉鎖する',
	'closewikis-page-close' => 'ウィキを閉鎖する',
	'closewikis-page-close-wiki' => 'ウィキ:',
	'closewikis-page-close-dreason' => '理由 (表示用):',
	'closewikis-page-close-reason' => '理由 (記録用):',
	'closewikis-page-close-submit' => '閉鎖',
	'closewikis-page-close-success' => 'ウィキの閉鎖に成功しました',
	'closewikis-page-reopen' => 'ウィキを再開する',
	'closewikis-page-reopen-wiki' => 'ウィキ:',
	'closewikis-page-reopen-reason' => '理由：',
	'closewikis-page-reopen-submit' => '再開',
	'closewikis-page-reopen-success' => 'ウィキの再開に成功しました',
	'closewikis-page-err-nowiki' => '無効なウィキが指定されました',
	'closewikis-page-err-closed' => 'ウィキは既に閉鎖されています',
	'closewikis-page-err-opened' => 'ウィキは閉鎖されていません',
	'closewikis-list' => '閉鎖されたウィキの一覧',
	'closewikis-list-intro' => 'この一覧にはスチュワードによって閉鎖されたウィキが載っています。',
	'closewikis-list-header-wiki' => 'ウィキ',
	'closewikis-list-header-by' => '閉鎖者',
	'closewikis-list-header-timestamp' => '閉鎖日',
	'closewikis-list-header-dispreason' => '表示理由',
	'closewikis-log' => 'ウィキ閉鎖記録',
	'closewikis-log-header' => 'これはスチュワードによるすべてのウィキの閉鎖および再開の記録です',
	'closewikis-log-close' => '$2 を閉鎖',
	'closewikis-log-reopen' => '$2 を再開',
	'right-editclosedwikis' => '閉鎖されたウィキを編集する',
	'right-closewikis' => 'ウィキを閉鎖する',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'closewikis-page' => 'បិទវិគី',
	'closewikis-page-close' => 'បិទវិគី',
	'closewikis-page-close-wiki' => 'វិគី៖',
	'closewikis-page-close-dreason' => 'ហេតុផល (បង្ហាញ)​៖',
	'closewikis-page-close-reason' => 'ហេតុផល (ចូល)​៖',
	'closewikis-page-close-submit' => 'បិទ',
	'closewikis-page-close-success' => 'វិគី​បាន​បិទ​ដោយជោគជ័យ',
	'closewikis-page-reopen' => 'បើកវិគីឡើងវិញ',
	'closewikis-page-reopen-wiki' => 'វិគី៖',
	'closewikis-page-reopen-reason' => 'មូលហេតុ៖',
	'closewikis-page-reopen-submit' => 'បើកឡើងវិញ',
	'closewikis-page-reopen-success' => 'វិគី​បាន​បើកឡើងវិញ​ដោយជោគជ័យ',
	'closewikis-page-err-nowiki' => 'វិគីដែលបានផ្ដល់អោយគ្មានសុពលភាព',
	'closewikis-page-err-closed' => 'វិគី​ត្រូវ​បាន​បិទ​រួចរាល់ហើយ',
	'closewikis-page-err-opened' => 'វិគី​មិនត្រូវ​បាន​បិទ​ទេ',
	'closewikis-list' => 'បាន​បិទ​បញ្ជី​វិគី',
	'closewikis-list-header-wiki' => 'វិគី',
	'closewikis-list-header-by' => 'បានបិទដោយ',
	'closewikis-list-header-timestamp' => 'បានបិទនៅ',
	'closewikis-list-header-dispreason' => 'មូលហេតុបង្ហាញ',
	'closewikis-log' => 'កំណត់ហេតុស្ដីពីការបិទវិគីនានា',
	'closewikis-log-close' => 'បានបិទ$2',
	'closewikis-log-reopen' => 'បាន​បើកឡើងវិញ $2',
	'right-editclosedwikis' => 'កែប្រែវិគីដែលបានបិទ',
	'right-closewikis' => 'បិទវិគី',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'closewikis-page-close-wiki' => 'ವಿಕಿ:',
	'closewikis-page-reopen-wiki' => 'ವಿಕಿ:',
	'closewikis-page-reopen-reason' => 'ಕಾರಣ:',
	'closewikis-list-header-wiki' => 'ವಿಕಿ',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'closewikis-page-reopen-reason' => '이유:',
	'closewikis-list' => '닫힌 위키의 목록',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'closewikis-desc' => 'Määt et müjjelesch, enkel Wikis en ene Wiki-Farm zohzemaache.',
	'closewikis-page' => 'Wiki zomaache',
	'closewikis-page-close' => 'Wiki zomaache',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Der Jrond (för Aanzezeije):',
	'closewikis-page-close-reason' => 'Der Jrond (för en et Logbooch ze schrieve):',
	'closewikis-page-close-submit' => 'Zohmaache',
	'closewikis-page-close-success' => 'Dat Wiki es jetz zojemaat.',
	'closewikis-page-reopen' => 'Wiki wider opmaache',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Jrond:',
	'closewikis-page-reopen-submit' => 'Wider Opmaache!',
	'closewikis-page-reopen-success' => 'Dat Wiki es jetz wider opjemaat.',
	'closewikis-page-err-nowiki' => 'Do Blötschkopp häs e onsennesch Wiki jenannt',
	'closewikis-page-err-closed' => 'Dat Wiki es ald zo.',
	'closewikis-page-err-opened' => 'Dat Wiki es nit zo.',
	'closewikis-list' => 'Leß met de zojemaate Wikis',
	'closewikis-list-intro' => 'De Leß ömfaß de Wikis, di ene <i lang="en">Steward</i> zojemaat hät.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Zojemaat vum',
	'closewikis-list-header-timestamp' => 'Zojemaat om un öm',
	'closewikis-list-header-dispreason' => 'Dä aanjzeichte Jrond',
	'closewikis-log' => 'Logbooch met de zojemaate un widder opjemaate Wikis',
	'closewikis-log-header' => 'He es jedes Zomaache un Widderopmaache opjeliß, wat de <i lang="en">Stewards</i> met Wikis jemaat han.',
	'closewikis-log-close' => 'hät $2 zojemaat',
	'closewikis-log-reopen' => 'hät $2 wider op jemaat',
	'right-editclosedwikis' => 'zojemaate Wikis ändere',
	'right-closewikis' => 'Wikis zomaache',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'closewikis-page-close-submit' => 'Bigre',
	'closewikis-page-reopen' => 'Wîkîyê dîsa veke',
	'closewikis-page-reopen-reason' => 'Sedem:',
	'closewikis-page-reopen-submit' => 'Dîsa veke',
	'right-editclosedwikis' => "Wîkî'yên hatin girtin biguherîne",
	'right-closewikis' => "Wîkî'yan bigre",
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'closewikis-desc' => 'Erlaabt et Wiki-Siten a Wiki-Farmen zouzemaachen',
	'closewikis-page' => 'Wiki zoumaachen',
	'closewikis-page-close' => 'Wiki zoumaachen',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Grond (ugewisen):',
	'closewikis-page-close-reason' => 'Grond (geloggt):',
	'closewikis-page-close-submit' => 'Zoumaachen',
	'closewikis-page-close-success' => 'Wiki gouf zougemaach',
	'closewikis-page-reopen' => 'Wiki nees opmaachen',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Grond:',
	'closewikis-page-reopen-submit' => 'Nees opmaachen',
	'closewikis-page-reopen-success' => 'Wiki nees opgemaach',
	'closewikis-page-err-nowiki' => 'Ongëlteg Wiki uginn',
	'closewikis-page-err-closed' => 'Wiki ass schonn zougemaach',
	'closewikis-page-err-opened' => 'Wiki ass net zougemaach',
	'closewikis-list' => 'Lëscht vun de Wikien déi zou sinn',
	'closewikis-list-intro' => 'Op dëser Lëscht stinn déi Wikien déi vun de Stewarden zougemaach goufen.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Zougemaach vum',
	'closewikis-list-header-timestamp' => 'Zougemaach de(n)',
	'closewikis-list-header-dispreason' => 'Grond',
	'closewikis-log' => 'Lëscht vun den zougemaachte Wikien',
	'closewikis-log-header' => "Hei ass d'Lëscht vun alle Wikien déi vu Stewarden opgemaach oder zougemaach goufen",
	'closewikis-log-close' => 'huet $2 zougemaach',
	'closewikis-log-reopen' => 'huet $2 nees opgemaach',
	'right-editclosedwikis' => 'Zougemaachte Wikien änneren',
	'right-closewikis' => 'Wikien zoumaachen',
);

/** Limburgish (Limburgs)
 * @author Pahles
 */
$messages['li'] = array(
	'closewikis-desc' => "Maak het sjlete en heräöpene van wiki's in 'ne wikifarm mäögelik",
	'closewikis-page' => 'Wiki sjlete',
	'closewikis-page-close' => 'Wiki sjlete',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Raej (weergegaeve op wiki):',
	'closewikis-page-close-reason' => 'Raej (veur logbook):',
	'closewikis-page-close-submit' => 'Sjlete',
	'closewikis-page-close-success' => 'De wiki is noe gesjlote',
	'closewikis-page-reopen' => 'Wiki heräöpene',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Reeje:',
	'closewikis-page-reopen-submit' => 'Heräöpene',
	'closewikis-page-reopen-success' => 'De wiki is noe heräöpend',
	'closewikis-page-err-nowiki' => 'Ongeljige naam van wiki opgegaeve',
	'closewikis-page-err-closed' => 'Deze wiki is al gesjlote',
	'closewikis-page-err-opened' => 'Deze wiki is neet gesjlaote',
	'closewikis-list' => "Gesjlaote wiki's",
	'closewikis-list-intro' => "Deze lies bevat wiki's die gesjlaote zien door stewards.",
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Gesjlaote door',
	'closewikis-list-header-timestamp' => 'Gesjlaote op',
	'closewikis-list-header-dispreason' => 'Weergegaeve raej',
	'closewikis-log' => 'Wikisletingslogbook',
	'closewikis-log-header' => "Dit is 'n logbook van alle sjletinge en heräöpeninge van wiki's oetgeveurd door stewards",
	'closewikis-log-close' => 'haet $2 gesjlaote',
	'closewikis-log-reopen' => 'haet $2 heräöpend',
	'right-editclosedwikis' => 'Gesjlaote wikis bewirke',
	'right-closewikis' => "Gesjlaote wiki's",
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'closewikis-desc' => 'Leidžia uždaryti wiki svetaines wiki farms',
	'closewikis-page' => 'Uždaryti Wiki',
	'closewikis-page-close' => 'Uždaryti Wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Priežastis (rodomas):',
	'closewikis-page-close-submit' => 'Uždaryti',
	'closewikis-page-close-success' => 'Wiki sėkmingai uždaryta',
	'closewikis-page-reopen' => 'Iš naujo atidaryti wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Priežastis:',
	'closewikis-page-reopen-submit' => 'Atidaryti iš naujo',
	'closewikis-page-reopen-success' => 'Wiki sėkmingai iš naujo atidaryta',
	'closewikis-page-err-closed' => 'Wiki jau uždaryta',
	'closewikis-page-err-opened' => 'Wiki neuždaryta',
	'closewikis-list' => 'Uždarytu wiki sąrašas',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Uždarytas',
	'closewikis-list-header-timestamp' => 'Uždarytas',
	'closewikis-list-header-dispreason' => 'Rodoma priežastis',
	'closewikis-log-close' => 'uždaryta $2',
	'closewikis-log-reopen' => 'iš naujo atidaryta $2',
	'right-editclosedwikis' => 'Redaguoti uždarytas wiki',
	'right-closewikis' => 'Uždaryti wiki',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'closewikis-page-close-wiki' => 'Viki:',
	'closewikis-page-reopen-wiki' => 'Viki:',
	'closewikis-page-reopen-reason' => 'Īmesle:',
	'closewikis-list-header-wiki' => 'Viki',
);

/** Latvian (Latviešu)
 * @author Xil
 */
$messages['lv'] = array(
	'closewikis-desc' => 'Ļauj slēgt atsevišķas vietnes vairāku wiki grupā',
	'closewikis-page' => 'Slēgt wiki',
	'closewikis-page-close' => 'Slēgt wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Iemesls (redzams):',
	'closewikis-page-close-reason' => 'Iemesls (reģistros):',
	'closewikis-page-close-submit' => 'Slēgt',
	'closewikis-page-close-success' => 'Wiki veiksmīgi slēgta',
	'closewikis-page-reopen' => 'Atjaunot wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Iemesls:',
	'closewikis-page-reopen-submit' => 'Atjaunot',
	'closewikis-page-reopen-success' => 'Wiki veiksmīgi atjaunota',
	'closewikis-page-err-nowiki' => 'Norādītā wiki ir nederīga',
	'closewikis-page-err-closed' => 'Wiki jau ir slēgta',
	'closewikis-page-err-opened' => 'Wiki nav slēgta',
	'closewikis-list' => 'Slēgto wiki saraksts',
	'closewikis-list-intro' => "Šajā sarakst'uzskitītas pārvaldnieku slēgtās wiki",
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Aizslēdza',
	'closewikis-list-header-timestamp' => 'Slēgts',
	'closewikis-list-header-dispreason' => 'Attēlotais iemesls',
	'closewikis-log' => 'Wiki slēgšnu reģistrs',
	'closewikis-log-header' => 'Visu pārvaldnieku veikto slēgšanu un atjaunošanu saraksts',
	'closewikis-log-close' => 'slēdza $2',
	'closewikis-log-reopen' => 'atjaunoja $2',
	'right-editclosedwikis' => 'Rediģēt slēgtas wiki',
	'right-closewikis' => 'Slēgt wiki',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'closewikis-desc' => 'Овозможува затворање на вики-мрежни места во вики-фарми',
	'closewikis-page' => 'Затвори го викито',
	'closewikis-page-close' => 'Затвори го викито',
	'closewikis-page-close-wiki' => 'Вики:',
	'closewikis-page-close-dreason' => 'Причина (за прикажување):',
	'closewikis-page-close-reason' => 'Причина (за во дневник):',
	'closewikis-page-close-submit' => 'Затвори',
	'closewikis-page-close-success' => 'Викито е успешно затворено',
	'closewikis-page-reopen' => 'Отвори го викито',
	'closewikis-page-reopen-wiki' => 'Вики:',
	'closewikis-page-reopen-reason' => 'Причина:',
	'closewikis-page-reopen-submit' => 'Отвори',
	'closewikis-page-reopen-success' => 'Викито е успешно отворено',
	'closewikis-page-err-nowiki' => 'Назначено е неважечко вики',
	'closewikis-page-err-closed' => 'Викито е веќе затворено',
	'closewikis-page-err-opened' => 'Викито не е затворено',
	'closewikis-list' => 'Список на затворени викија',
	'closewikis-list-intro' => 'Овој список ги наведува викијата затворени од стјуарди.',
	'closewikis-list-header-wiki' => 'Вики',
	'closewikis-list-header-by' => 'Затворил',
	'closewikis-list-header-timestamp' => 'Затворено на',
	'closewikis-list-header-dispreason' => 'Причина за прикажување',
	'closewikis-log' => 'Дневник на затворање на викија',
	'closewikis-log-header' => 'Еве дневник на сите затворања на викија од страна на стјуарди  и нивни повторни отворања',
	'closewikis-log-close' => 'затворено $2',
	'closewikis-log-reopen' => 'отворено $2',
	'right-editclosedwikis' => 'Уредување на затворени викија',
	'right-closewikis' => 'Затворање на викија',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'closewikis-desc' => 'വിക്കിഫാമുകളിൽ വിക്കി സൈറ്റുകൾ അടയ്ക്കാൻ അനുവദിക്കുന്നു',
	'closewikis-page' => 'വിക്കി അടയ്ക്കുക',
	'closewikis-page-close' => 'വിക്കി അടയ്ക്കുക',
	'closewikis-page-close-wiki' => 'വിക്കി:',
	'closewikis-page-close-dreason' => 'കാരണം (പ്രദർശിപ്പിക്കപ്പെട്ടത്):',
	'closewikis-page-close-reason' => 'കാരണം (രേഖപ്പെടുത്തിയത്):',
	'closewikis-page-close-submit' => 'അടയ്ക്കുക',
	'closewikis-page-close-success' => 'വിക്കി വിജയകരമായി അടച്ചിരിക്കുന്നു',
	'closewikis-page-reopen' => 'വിക്കി വീണ്ടും തുറക്കുക',
	'closewikis-page-reopen-wiki' => 'വിക്കി:',
	'closewikis-page-reopen-reason' => 'കാരണം:',
	'closewikis-page-reopen-submit' => 'വീണ്ടും തുറക്കുക',
	'closewikis-page-reopen-success' => 'വിക്കി വിജയകരമായി വീണ്ടും തുറന്നിരിക്കുന്നു',
	'closewikis-page-err-nowiki' => 'അസാധുവായ വിക്കിയാണ് നൽകിയത്',
	'closewikis-page-err-closed' => 'വിക്കി മുമ്പേ അടച്ചിരിക്കുകയാണ്',
	'closewikis-page-err-opened' => 'വിക്കി അടച്ചിട്ടില്ല',
	'closewikis-list' => 'അടയ്ക്കപ്പെട്ട വിക്കികളുടെ പട്ടിക',
	'closewikis-list-intro' => 'ഈ പട്ടികയിൽ സ്റ്റ്യൂവർഡുകൾ അടച്ച വിക്കികൾ നൽകിയിരിക്കുന്നു.',
	'closewikis-list-header-wiki' => 'വിക്കി',
	'closewikis-list-header-by' => 'അടച്ചത്',
	'closewikis-list-header-timestamp' => 'അടച്ച തീയതി',
	'closewikis-list-header-dispreason' => 'പ്രദർശിപ്പിക്കപ്പെട്ട കാരണം',
	'closewikis-log' => 'വിക്കി അടയ്ക്കൽ രേഖ',
	'closewikis-log-header' => 'സ്റ്റ്യൂവാർഡുകൾ നടത്തിയ എല്ലാ വിക്കി അടയ്ക്കലുകളുടേയും വീണ്ടും തുറക്കലുകളുടേയും രേഖ',
	'closewikis-log-close' => '$2 അടച്ചു',
	'closewikis-log-reopen' => '$2 വീണ്ടും തുറന്നു',
	'right-editclosedwikis' => 'അടച്ച വിക്കികൾ തിരുത്തുക',
	'right-closewikis' => 'വിക്കികൾ അടയ്ക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'closewikis-page-reopen-reason' => 'Шалтгаан:',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'closewikis-desc' => 'Membolehkan penutupan tapak wiki di ladang wiki',
	'closewikis-page' => 'Tutup wiki',
	'closewikis-page-close' => 'Tutup Wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Sebab (dipaparkan):',
	'closewikis-page-close-reason' => 'Sebab (dilog):',
	'closewikis-page-close-submit' => 'Tutup',
	'closewikis-page-close-success' => 'Wiki berjaya ditutup',
	'closewikis-page-reopen' => 'Buka semula wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Sebab:',
	'closewikis-page-reopen-submit' => 'Buka semula',
	'closewikis-page-reopen-success' => 'Wiki berjaya dibuka semula',
	'closewikis-page-err-nowiki' => 'Wiki yang dinyatakan tidak sah',
	'closewikis-page-err-closed' => 'Wiki sudah pun ditutup',
	'closewikis-page-err-opened' => 'Wiki belum ditutup',
	'closewikis-list' => 'Senarai wiki ditutup',
	'closewikis-list-intro' => 'Senarai ini mengandungi wiki-wiki yang ditutup oleh para steward',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Ditutup oleh',
	'closewikis-list-header-timestamp' => 'Ditutup pada',
	'closewikis-list-header-dispreason' => 'Sebab yang dipaparkan',
	'closewikis-log' => 'Log penutupan wiki',
	'closewikis-log-header' => 'Berikut ialah senarai semua penutupan dan pembukaan semula wiki yang dilakukan oleh steward',
	'closewikis-log-close' => 'menutup $2',
	'closewikis-log-reopen' => 'membuka semula $2',
	'right-editclosedwikis' => 'Menyunting wiki yang ditutup',
	'right-closewikis' => 'Menutup wiki',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'closewikis-page-close-submit' => 'Agħlaq',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'closewikis-page-close-wiki' => 'Вики:',
	'closewikis-page-close-submit' => 'Пекстамс',
	'closewikis-page-reopen-wiki' => 'Вики:',
	'closewikis-page-reopen-reason' => 'Тувталось:',
	'closewikis-list-header-wiki' => 'Вики',
	'closewikis-list-header-by' => 'Пекстыцязо',
);

/** Nahuatl (Nāhuatl)
 * @author Teòtlalili
 */
$messages['nah'] = array(
	'closewikis-page-reopen-reason' => 'Tlèka:',
	'closewikis-list-header-wiki' => 'Wiki',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'closewikis-desc' => 'Tillater stenging av wikier i wikisamlinger',
	'closewikis-page' => 'Steng wiki',
	'closewikis-page-close' => 'Steng wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Årsak (vises):',
	'closewikis-page-close-reason' => 'Årsak (logges):',
	'closewikis-page-close-submit' => 'Lukk',
	'closewikis-page-close-success' => 'Wiki stengt',
	'closewikis-page-reopen' => 'Åpne wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Årsak:',
	'closewikis-page-reopen-submit' => 'Åpne',
	'closewikis-page-reopen-success' => 'Wiki åpnet',
	'closewikis-page-err-nowiki' => 'Ugyldig wiki oppgitt',
	'closewikis-page-err-closed' => 'Wikien er allerede stengt',
	'closewikis-page-err-opened' => 'Wikien er ikke stengt',
	'closewikis-list' => 'Liste over stengte wikier',
	'closewikis-list-intro' => 'Denne listen inneholder wikier som har blitt stengt av forvaltere.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Stengt av',
	'closewikis-list-header-timestamp' => 'Stengt den',
	'closewikis-list-header-dispreason' => 'Vist årsak',
	'closewikis-log' => 'Logg for stenging av wikier',
	'closewikis-log-header' => 'Her er en logg over alle wikistenginger og -åpninger gjort av forvaltere',
	'closewikis-log-close' => 'stengte $2',
	'closewikis-log-reopen' => 'åpnet $2',
	'right-editclosedwikis' => 'Redigere stengte wikier',
	'right-closewikis' => 'Steng wikier',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'closewikis-desc' => "Maakt het sluiten en heropenen van wiki's in een wikifarm mogelijk",
	'closewikis-page' => 'Wiki sluiten',
	'closewikis-page-close' => 'Wiki sluiten',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Reden (weergegeven op wiki):',
	'closewikis-page-close-reason' => 'Reden (voor logboek):',
	'closewikis-page-close-submit' => 'Sluiten',
	'closewikis-page-close-success' => 'De wiki is nu gesloten',
	'closewikis-page-reopen' => 'Wiki heropenen',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Reden:',
	'closewikis-page-reopen-submit' => 'Heropenen',
	'closewikis-page-reopen-success' => 'De wiki is nu heropend',
	'closewikis-page-err-nowiki' => 'Ongeldige naam van wiki opgegeven',
	'closewikis-page-err-closed' => 'Deze wiki is al gesloten',
	'closewikis-page-err-opened' => 'Deze wiki was niet gesloten',
	'closewikis-list' => "Gesloten wiki's",
	'closewikis-list-intro' => "Deze lijst bevat wiki's die gesloten zijn door stewards.",
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Gesloten door',
	'closewikis-list-header-timestamp' => 'Gesloten op',
	'closewikis-list-header-dispreason' => 'Weergegeven reden',
	'closewikis-log' => 'Wikisluitingslogboek',
	'closewikis-log-header' => "Dit is een logboek van alle sluitingen en heropeningen van wiki's uitgevoerd door stewards",
	'closewikis-log-close' => 'heeft $2 gesloten',
	'closewikis-log-reopen' => 'heeft $2 heropend',
	'right-editclosedwikis' => 'Gesloten wikis bewerken',
	'right-closewikis' => "Wiki's sluiten",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'closewikis-desc' => 'Tillèt stenging av wikiar i wikisamlingar',
	'closewikis-page' => 'Steng wiki',
	'closewikis-page-close' => 'Steng wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Årsak (blir vist):',
	'closewikis-page-close-reason' => 'Årsak (blir logga):',
	'closewikis-page-close-submit' => 'Steng',
	'closewikis-page-close-success' => 'Wiki stengt',
	'closewikis-page-reopen' => 'Attopna wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Årsak:',
	'closewikis-page-reopen-submit' => 'Attopna',
	'closewikis-page-reopen-success' => 'Wikien blei attopna',
	'closewikis-page-err-nowiki' => 'Oppgav ugyldig wiki',
	'closewikis-page-err-closed' => 'Wikien er allereie stengt',
	'closewikis-page-err-opened' => 'Wikien er ikkje stengt',
	'closewikis-list' => 'Lista over stengte wikiar',
	'closewikis-list-intro' => 'Denne lista inneheld wikiar som har blitt stengt av forvaltarar.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Stengt av',
	'closewikis-list-header-timestamp' => 'Stengt den',
	'closewikis-list-header-dispreason' => 'Vist årsak',
	'closewikis-log' => 'Logg over stenging av wikiar',
	'closewikis-log-header' => 'Her er ein logg over alle stengingar og attopningar av gjort av forvaltarar.',
	'closewikis-log-close' => 'stengte $2',
	'closewikis-log-reopen' => 'opna att $2',
	'right-editclosedwikis' => 'Endra stengte wikiar',
	'right-closewikis' => 'Steng wikiar',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'closewikis-desc' => 'Permet de clausurar los sites wiki dins aqueste gestionari de wiki',
	'closewikis-page' => 'Clausar lo wiki',
	'closewikis-page-close' => 'Clausurar lo wiki',
	'closewikis-page-close-wiki' => 'Wiki :',
	'closewikis-page-close-dreason' => 'Motiu (afichat) :',
	'closewikis-page-close-reason' => 'Motiu (enregistrat) :',
	'closewikis-page-close-submit' => 'Clausurar',
	'closewikis-page-close-success' => 'Wiki claus amb succès',
	'closewikis-page-reopen' => 'Tornar dobrir lo wiki',
	'closewikis-page-reopen-wiki' => 'Wiki :',
	'closewikis-page-reopen-reason' => 'Motiu :',
	'closewikis-page-reopen-submit' => 'Tornar dobrir',
	'closewikis-page-reopen-success' => 'Lo wiki es estat redobert amb succès',
	'closewikis-page-err-nowiki' => 'Lo wiki indicat es incorrècte',
	'closewikis-page-err-closed' => 'Aqueste wiki ja es estat clausurat',
	'closewikis-page-err-opened' => 'Wiki pas clausurat',
	'closewikis-list' => 'Tièra dels wikis clauses',
	'closewikis-list-intro' => 'Aquesta tièra conten los wiki clauses pels stewards.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Claus per',
	'closewikis-list-header-timestamp' => 'Claus lo',
	'closewikis-list-header-dispreason' => 'Rason balhada',
	'closewikis-log' => 'Jornal de clausura dels wiki',
	'closewikis-log-header' => 'Vaquí un jornal de totas las tampaduras e redoberturas de wiki fachas pels stewards',
	'closewikis-log-close' => 'a clausurat $2',
	'closewikis-log-reopen' => 'a redobert $2',
	'right-editclosedwikis' => 'Modificar los wikis clausurats',
	'right-closewikis' => 'Wikis clauses',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Jnanaranjan Sahu
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'closewikis-page' => 'ଉଇକି ବନ୍ଦ କରିବେ',
	'closewikis-page-close' => 'ଉଇକି ବନ୍ଦ କରିବେ',
	'closewikis-page-close-wiki' => 'ଉଇକି :',
	'closewikis-page-close-dreason' => 'କାରଣ (ଦର୍ଶାଯାଇଛି):',
	'closewikis-page-close-reason' => 'କାରଣ (ଜଣାଇଦିଆଯାଇଛି):',
	'closewikis-page-close-submit' => 'ବନ୍ଦ କରିବେ',
	'closewikis-page-close-success' => 'ଉଇକି ସଫଳ ଭାବେ ବନ୍ଦ କରିଦିଆଯାଇଛି',
	'closewikis-page-reopen' => "ଉଇକି ଆଉଥରେ ଖୋଲନ୍ତୁ'",
	'closewikis-page-reopen-wiki' => 'ଉଇକି :',
	'closewikis-page-reopen-reason' => 'କାରଣ:',
	'closewikis-page-reopen-submit' => 'ପୁନଃଖୋଲିବା',
	'closewikis-page-reopen-success' => 'ଉଇକି ସଫଳ ଭାବେ ଖୋଲା ପୁନଃଖୋଲାଯାଇଛି',
	'closewikis-page-err-nowiki' => 'ଅବୈଧ ଉଇକି ଦର୍ଶଯାଇଛି',
	'closewikis-page-err-closed' => 'ଉଇକି ଆଗରୁ ବନ୍ଦ ହେଇସାରିଛି',
	'closewikis-page-err-opened' => 'ଉଇକି ବନ୍ଦ ହୋଇନି',
	'closewikis-list' => 'ବନ୍ଦ ହୋଇଥିବା ଉଇକିମାନଙ୍କ ତାଲିକା',
	'closewikis-list-intro' => 'ଏହି ତାଲିକାରେ ଷ୍ଟିଉଆର୍ଡଙ୍କ ଦ୍ଵାରା ବନ୍ଦ କରାଯାଇଥିବା ଉଇକିମାନଙ୍କର ତାଲିକା ଅଛି',
	'closewikis-list-header-wiki' => 'ଉଇକି',
	'closewikis-list-header-by' => 'ଙ୍କଦ୍ଵାରା ବନ୍ଦକରାଯାଇଛି',
	'closewikis-list-header-timestamp' => 'ଦିନ ବନ୍ଦକରାଯାଇଛି',
	'closewikis-list-header-dispreason' => 'ଦର୍ଶାଯାଇଥିବା କାରଣ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-submit' => 'Zumache',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Grund:',
	'closewikis-list-header-wiki' => 'Wiki',
);

/** Polish (Polski)
 * @author Jwitos
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'closewikis-desc' => 'Pozwala zamykać pojedyncze projekty wiki na farmie wiki',
	'closewikis-page' => 'Zamknij wiki',
	'closewikis-page-close' => 'Zamknij wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Powód (oficjalny)',
	'closewikis-page-close-reason' => 'Powód (zapamiętany)',
	'closewikis-page-close-submit' => 'Zamknij',
	'closewikis-page-close-success' => 'Wiki została zamknięta',
	'closewikis-page-reopen' => 'Otwórz wiki ponownie',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Powód',
	'closewikis-page-reopen-submit' => 'Otwórz ponownie',
	'closewikis-page-reopen-success' => 'Wiki została ponownie otwarta',
	'closewikis-page-err-nowiki' => 'Określono nieprawidłową wiki',
	'closewikis-page-err-closed' => 'Wiki została zamknięta',
	'closewikis-page-err-opened' => 'Wiki nie została zamknięta',
	'closewikis-list' => 'Lista zamkniętych wiki',
	'closewikis-list-intro' => 'Lista zawiera wiki, które zostały zamknięte przez stewardów.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Zamknięta przez',
	'closewikis-list-header-timestamp' => 'Zamknięta',
	'closewikis-list-header-dispreason' => 'Oficjalny powód',
	'closewikis-log' => 'Rejestr zamkniętych wiki',
	'closewikis-log-header' => 'Poniżej znajduje się rejestr wszystkich wiki zamkniętych lub ponownie otwartych przez stewardów',
	'closewikis-log-close' => 'zamknięta $2',
	'closewikis-log-reopen' => 'powtórnie otwarta $2',
	'right-editclosedwikis' => 'Edycja zamkniętych projektów wiki',
	'right-closewikis' => 'Zamykanie projektów wiki',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'closewikis-desc' => 'A përmëtt ëd saré ij sit wiki an famije wiki',
	'closewikis-page' => 'Sara wiki',
	'closewikis-page-close' => 'Sara wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Rason (visualisà):',
	'closewikis-page-close-reason' => 'Rason (registrà):',
	'closewikis-page-close-submit' => 'Sara',
	'closewikis-page-close-success' => 'Wiki sarà bin',
	'closewikis-page-reopen' => 'Torna deurbe la wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Rason:',
	'closewikis-page-reopen-submit' => 'Torna deurbe',
	'closewikis-page-reopen-success' => 'Wiki torna durbìa da bin',
	'closewikis-page-err-nowiki' => 'Wiki spessificà pa bon-a',
	'closewikis-page-err-closed' => "Wiki a l'é già sarà",
	'closewikis-page-err-opened' => "Wiki a l'é pa sarà",
	'closewikis-list' => 'Lista dle wiki sarà',
	'closewikis-list-intro' => 'Sta lista-sì a conten le wiki che a son ëstàite sarà dai comess.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Sarà da',
	'closewikis-list-header-timestamp' => 'Sarà ël',
	'closewikis-list-header-dispreason' => 'Rason visualisà',
	'closewikis-log' => 'Registr ëd la saradura dle wiki',
	'closewikis-log-header' => 'Sì a-i é un registr ëd tute le wiki sarà e torna duvertà dai comess',
	'closewikis-log-close' => 'sarà $2',
	'closewikis-log-reopen' => 'torna duvertà $2',
	'right-editclosedwikis' => 'Modìfica wiki sarà',
	'right-closewikis' => 'Sara wiki',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'closewikis-page' => 'ويکي تړل',
	'closewikis-page-close' => 'ويکي تړل',
	'closewikis-page-close-wiki' => 'ويکي:',
	'closewikis-page-close-submit' => 'تړل',
	'closewikis-page-close-success' => 'ويکي په برياليتوب سره وتړل شوه',
	'closewikis-page-reopen' => 'ويکي بيا پرانيستل',
	'closewikis-page-reopen-wiki' => 'ويکي:',
	'closewikis-page-reopen-reason' => 'سبب:',
	'closewikis-page-reopen-submit' => 'بيا پرانيستل',
	'closewikis-page-reopen-success' => 'ويکي په برياليتوب سره بيا پرانيستل شوه',
	'closewikis-page-err-closed' => 'ويکي له پخوا نه تړل شوې',
	'closewikis-page-err-opened' => 'ويکي نه ده تړل شوې',
	'closewikis-list-header-wiki' => 'ويکي',
	'right-closewikis' => 'ويکي تړل',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Sir Lestaty de Lioncourt
 */
$messages['pt'] = array(
	'closewikis-desc' => 'Permite fechar wikis em fazendas de wikis',
	'closewikis-page' => 'Fechar wiki',
	'closewikis-page-close' => 'Fechar wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Motivo (apresentado):',
	'closewikis-page-close-reason' => 'Motivo (registado):',
	'closewikis-page-close-submit' => 'Fechar',
	'closewikis-page-close-success' => 'Wiki foi fechada com sucesso',
	'closewikis-page-reopen' => 'Reabrir wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Motivo:',
	'closewikis-page-reopen-submit' => 'Reabrir',
	'closewikis-page-reopen-success' => 'Wiki reaberta com sucesso',
	'closewikis-page-err-nowiki' => 'Foi especificada uma wiki inválida',
	'closewikis-page-err-closed' => 'Wiki já está fechada',
	'closewikis-page-err-opened' => 'Esta wiki não está fechada',
	'closewikis-list' => 'Lista de wikis fechadas',
	'closewikis-list-intro' => "Esta lista contém wikis que foram fechadas por administradores ''(stewards)''.",
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Fechada por',
	'closewikis-list-header-timestamp' => 'Fechada em',
	'closewikis-list-header-dispreason' => 'Motivo apresentado',
	'closewikis-log' => 'Registo de Wikis fechadas',
	'closewikis-log-header' => "Este é um registo de todas as wikis que foram fechadas ou reabertas por administradores ''(stewards)''",
	'closewikis-log-close' => 'fechada $2',
	'closewikis-log-reopen' => 'reaberta $2',
	'right-editclosedwikis' => 'Editar wikis fechadas',
	'right-closewikis' => 'Fechar wikis',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'closewikis-desc' => 'Permite fechar uma wiki em sites com múltiplos wikis',
	'closewikis-page' => 'Fechar wiki',
	'closewikis-page-close' => 'Fechar wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Razão (exibida):',
	'closewikis-page-close-reason' => 'Razão (registrada):',
	'closewikis-page-close-submit' => 'Fechar',
	'closewikis-page-close-success' => 'Wiki foi fechada com sucesso',
	'closewikis-page-reopen' => 'Reabrir wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Motivo:',
	'closewikis-page-reopen-submit' => 'Reabrir',
	'closewikis-page-reopen-success' => 'Wiki reaberta com sucesso',
	'closewikis-page-err-nowiki' => 'A wiki especificada é inválida',
	'closewikis-page-err-closed' => 'Wiki já está fechada',
	'closewikis-page-err-opened' => 'Esta wiki não está fechada',
	'closewikis-list' => 'Lista de wikis fechados',
	'closewikis-list-intro' => 'Esta lista contém wikis que foram fechados por stewards.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Fechado por',
	'closewikis-list-header-timestamp' => 'Fechada em',
	'closewikis-list-header-dispreason' => 'Razão apresentada',
	'closewikis-log' => 'Registro de Wikis fechadas',
	'closewikis-log-header' => 'Aqui está um registro de todas as wikis que foram fechadas ou reabertas por stewards',
	'closewikis-log-close' => 'fechada $2',
	'closewikis-log-reopen' => 'reaberta $2',
	'right-editclosedwikis' => 'Editar wikis fechadas',
	'right-closewikis' => 'Fechar wikis',
);

/** Romanian (Română)
 * @author Danutz
 * @author KlaudiuMihaila
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'closewikis-page' => 'Închide wiki',
	'closewikis-page-close' => 'Închide wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Motiv (afișat):',
	'closewikis-page-close-submit' => 'Închidere',
	'closewikis-page-close-success' => 'Wiki închis cu succes',
	'closewikis-page-reopen' => 'Redeschide wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Motiv:',
	'closewikis-page-reopen-submit' => 'Redeschide',
	'closewikis-page-reopen-success' => 'Wiki redeschis cu succes',
	'closewikis-page-err-nowiki' => 'Wiki-ul specificat este invalid.',
	'closewikis-page-err-closed' => 'Acest wiki e deja închis',
	'closewikis-page-err-opened' => 'Acest wiki nu e închis',
	'closewikis-list' => 'Listă de wiki închise',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Închis de',
	'closewikis-list-header-timestamp' => 'Închis la',
	'closewikis-list-header-dispreason' => 'Motiv afișat',
	'closewikis-log' => 'Jurnal închidere wiki',
	'closewikis-log-close' => 'închis $2',
	'closewikis-log-reopen' => 'redeschis $2',
	'right-editclosedwikis' => 'Modifică wiki închise',
	'right-closewikis' => 'Închide wiki-urile',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'closewikis-page' => "Achiude 'a uicchi",
	'closewikis-page-close' => "Achiude 'a uicchi",
	'closewikis-page-close-wiki' => 'Uicchi:',
	'closewikis-page-close-submit' => 'Achiude',
	'closewikis-page-reopen-wiki' => 'Uicchi:',
	'closewikis-page-reopen-reason' => 'Mutive:',
	'closewikis-list-header-wiki' => 'Uicchi',
	'closewikis-list-header-by' => 'Achiuse da',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'closewikis-desc' => 'Позволяет закрывать вики-сайты в вики ферме',
	'closewikis-page' => 'Закрыть вики',
	'closewikis-page-close' => 'Закрыть вики',
	'closewikis-page-close-wiki' => 'Вики:',
	'closewikis-page-close-dreason' => 'Причина (отображаемая):',
	'closewikis-page-close-reason' => 'Причина (для журнала):',
	'closewikis-page-close-submit' => 'Закрыть',
	'closewikis-page-close-success' => 'Вики успешно закрыта',
	'closewikis-page-reopen' => 'Открыть вики',
	'closewikis-page-reopen-wiki' => 'Вики:',
	'closewikis-page-reopen-reason' => 'Причина:',
	'closewikis-page-reopen-submit' => 'Открыть',
	'closewikis-page-reopen-success' => 'Вики успешно открыта',
	'closewikis-page-err-nowiki' => 'Указана неправильная вики',
	'closewikis-page-err-closed' => 'Вики уже закрыта',
	'closewikis-page-err-opened' => 'Вики не закрыта',
	'closewikis-list' => 'Список закрытых вики',
	'closewikis-list-intro' => 'Этот список содержит вики, закрытые стюардами.',
	'closewikis-list-header-wiki' => 'Вики',
	'closewikis-list-header-by' => 'Закрыто',
	'closewikis-list-header-timestamp' => 'Закрыто',
	'closewikis-list-header-dispreason' => 'Отображаемая причина',
	'closewikis-log' => 'Журнал закрытия вики',
	'closewikis-log-header' => 'Журнал всех закрытий и открытый вики стюардами',
	'closewikis-log-close' => 'закрыто $2',
	'closewikis-log-reopen' => 'открыта $2',
	'right-editclosedwikis' => 'Править закрытые вики',
	'right-closewikis' => 'Закрытие вики',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'closewikis-desc' => 'Доволює заперти єднотливы вікі на вікіфармах',
	'closewikis-page' => 'Запертя вікі',
	'closewikis-page-close' => 'Заперти вікі',
	'closewikis-page-close-wiki' => 'Вікі:',
	'closewikis-page-close-dreason' => 'Причіна (про зображіня):',
	'closewikis-page-close-reason' => 'Причіна (лоґованя):',
	'closewikis-page-close-submit' => 'Заперти',
	'closewikis-page-close-success' => 'Вікі успішно заперта',
	'closewikis-page-reopen' => 'Знову одкрыти вікі',
	'closewikis-page-reopen-wiki' => 'Вікі:',
	'closewikis-page-reopen-reason' => 'Причіна:',
	'closewikis-page-reopen-submit' => 'Знову отворити',
	'closewikis-page-reopen-success' => 'Вікі успішно отворена',
	'closewikis-page-err-nowiki' => 'Хыбне становлїня вікі',
	'closewikis-page-err-closed' => 'Вікі уж заперта',
	'closewikis-page-err-opened' => 'Вікі незаперта',
	'closewikis-list' => 'Список запертых вікі',
	'closewikis-list-intro' => 'Тот список обсягує вікі заперты стювардами',
	'closewikis-list-header-wiki' => 'Вікі',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'closewikis-page' => 'Биикини сабыы',
	'closewikis-page-close' => 'Биикини сап',
	'closewikis-page-close-wiki' => 'Биики:',
	'closewikis-page-close-dreason' => 'Төрүөтэ (көстөрө):',
	'closewikis-page-close-reason' => 'Төрүөтэ (сурунаалга суруллара):',
	'closewikis-page-close-submit' => 'Сап',
	'closewikis-page-close-success' => 'Биики сөпкө сабылынна',
	'closewikis-page-reopen' => 'Биикини арый',
	'closewikis-page-reopen-reason' => 'Төрүөтэ:',
	'closewikis-page-reopen-success' => 'Биики сөпкө арылынна',
	'closewikis-list-header-dispreason' => 'Көстөр төрүөтэ',
	'closewikis-log-close' => 'сабыллыбыт $2',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-submit' => 'Chiudi',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Mutivu:',
	'closewikis-list-header-wiki' => 'Wiki',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'closewikis-desc' => 'Umožňuje zatvoriť wiki vo wiki farmách',
	'closewikis-closed' => '$1',
	'closewikis-page' => 'Zatvoriť wiki',
	'closewikis-page-close' => 'Zatvoriť wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Dôvod (zobrazí sa):',
	'closewikis-page-close-reason' => 'Dôvod (do záznamu):',
	'closewikis-page-close-submit' => 'Zatvoriť',
	'closewikis-page-close-success' => 'Wiki bola úspešne zatvorená',
	'closewikis-page-reopen' => 'Znovu otvoriť wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Dôvod:',
	'closewikis-page-reopen-submit' => 'Znovu otvoriť',
	'closewikis-page-reopen-success' => 'Wiki bola úspešne znovu otvorená',
	'closewikis-page-err-nowiki' => 'Bola zadaná neplatná wiki',
	'closewikis-page-err-closed' => 'Wiki je už zatvorená',
	'closewikis-page-err-opened' => 'Wiki nie je zatvorená',
	'closewikis-list' => 'Zoznam zatvorených wiki',
	'closewikis-list-intro' => 'Tento zoznam obsahuje wiki, ktoré stewardi zatvorili.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Zatvoril',
	'closewikis-list-header-timestamp' => 'Kedy',
	'closewikis-list-header-dispreason' => 'Dôvod',
	'closewikis-log' => 'Záznam zatvorení wiki',
	'closewikis-log-header' => 'Toto je záznam všetkých zatvorení a znovu otvorení wiki, ktoré vykonali stewardi',
	'closewikis-log-close' => 'zatvoril $2',
	'closewikis-log-reopen' => 'znovu otvoril $2',
	'right-editclosedwikis' => 'Upravovať zatvorené wiki',
	'right-closewikis' => 'Zatvárať wiki',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'closewikis-desc' => 'Omogoča zapiranje wikimest v wikiposestvih',
	'closewikis-page' => 'Zapri wiki',
	'closewikis-page-close' => 'Zapri wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Razlog (prikazan):',
	'closewikis-page-close-reason' => 'Razlog (zabeležen):',
	'closewikis-page-close-submit' => 'Zapri',
	'closewikis-page-close-success' => 'Wiki je bil uspešno zaprt',
	'closewikis-page-reopen' => 'Ponovno odpri wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Razlog:',
	'closewikis-page-reopen-submit' => 'Ponovno odpri',
	'closewikis-page-reopen-success' => 'Wiki je bil uspešno ponovno odprt',
	'closewikis-page-err-nowiki' => 'Določen je neveljaven wiki',
	'closewikis-page-err-closed' => 'Wiki je že zaprt',
	'closewikis-page-err-opened' => 'Wiki ni zaprt',
	'closewikis-list' => 'Seznam zaprtih wikijev',
	'closewikis-list-intro' => 'Ta seznam vsebuje wikije, ki so jih zaprli upravniki.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Zaprl',
	'closewikis-list-header-timestamp' => 'Zaprto',
	'closewikis-list-header-dispreason' => 'Prikazan razlog',
	'closewikis-log' => 'Dnevnik zapiranja wikijev',
	'closewikis-log-header' => 'Tukaj je dnevnik vseh zapiranj in ponovnih odpiranj wikijev, ki so jih naredili upravniki',
	'closewikis-log-close' => 'zaprl(-a) $2',
	'closewikis-log-reopen' => 'ponovno odprl(-a) $2',
	'right-editclosedwikis' => 'Urejanje zaprtih wikijev',
	'right-closewikis' => 'Zapiranje wikijev',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'closewikis-desc' => 'Омогућава затварање Вики-сајтова у Вики-фармама',
	'closewikis-closed' => '$1',
	'closewikis-page' => 'Затвори викију',
	'closewikis-page-close' => 'Затвори викију',
	'closewikis-page-close-wiki' => 'Вики:',
	'closewikis-page-close-dreason' => 'Разлог (приказан):',
	'closewikis-page-close-reason' => 'Разлог (забележен):',
	'closewikis-page-close-submit' => 'Затвори',
	'closewikis-page-close-success' => 'Вики је успешно затворен',
	'closewikis-page-reopen' => 'Отвори Вики поново',
	'closewikis-page-reopen-wiki' => 'Вики:',
	'closewikis-page-reopen-reason' => 'Разлог:',
	'closewikis-page-reopen-submit' => 'Отвори поново',
	'closewikis-page-reopen-success' => 'Вики је успешно поново отворен',
	'closewikis-page-err-nowiki' => 'Наведен је погрешан Вики',
	'closewikis-page-err-closed' => 'Вики је већ затворен',
	'closewikis-page-err-opened' => 'Вики није затворен',
	'closewikis-list' => 'Списак затвореник Викија',
	'closewikis-list-intro' => 'Овај списак садржи Викије које су стјуарди затворили.',
	'closewikis-list-header-wiki' => 'Вики',
	'closewikis-list-header-by' => 'Затворио',
	'closewikis-list-header-timestamp' => 'Затворен на',
	'closewikis-list-header-dispreason' => 'Приказани разлог',
	'closewikis-log' => 'Историја затварања Викија',
	'closewikis-log-header' => 'Овде је историја свих затварања и поновних отварања Викија од стране стјуарда',
	'closewikis-log-close' => 'затворен $2',
	'closewikis-log-reopen' => 'поново отворен $2',
	'right-editclosedwikis' => 'Измени затворене Викије',
	'right-closewikis' => 'затварање викија',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'closewikis-desc' => 'Omogućava zatvaranje Viki-sajtova u Viki-farmama',
	'closewikis-closed' => '$1',
	'closewikis-page' => 'Zatvori vikiju',
	'closewikis-page-close' => 'Zatvori vikiju',
	'closewikis-page-close-wiki' => 'Viki:',
	'closewikis-page-close-dreason' => 'Razlog (prikazan):',
	'closewikis-page-close-reason' => 'Razlog (zabeležen):',
	'closewikis-page-close-submit' => 'Zatvori',
	'closewikis-page-close-success' => 'Viki je uspešno zatvoren',
	'closewikis-page-reopen' => 'Otvori Viki ponovo',
	'closewikis-page-reopen-wiki' => 'Viki:',
	'closewikis-page-reopen-reason' => 'Razlog:',
	'closewikis-page-reopen-submit' => 'Otvori ponovo',
	'closewikis-page-reopen-success' => 'Viki je uspešno ponovo otvoren',
	'closewikis-page-err-nowiki' => 'Naveden je pogrešan Viki',
	'closewikis-page-err-closed' => 'Viki je već zatvoren',
	'closewikis-page-err-opened' => 'Viki nije zatvoren',
	'closewikis-list' => 'Spisak zatvorenik Vikija',
	'closewikis-list-intro' => 'Ovaj spisak sadrži Vikije koje su stjuardi zatvorili.',
	'closewikis-list-header-wiki' => 'Viki',
	'closewikis-list-header-by' => 'Zatvorio',
	'closewikis-list-header-timestamp' => 'Zatvoren na',
	'closewikis-list-header-dispreason' => 'Prikazani razlog',
	'closewikis-log' => 'Istorija zatvaranja Vikija',
	'closewikis-log-header' => 'Ovde je istorija svih zatvaranja i ponovnih otvaranja Vikija od strane stjuarda',
	'closewikis-log-close' => 'zatvoren $2',
	'closewikis-log-reopen' => 'ponovo otvoren $2',
	'right-editclosedwikis' => 'Izmeni zatvorene Vikije',
	'right-closewikis' => 'zatvaranje vikija',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'closewikis-desc' => 'Moaket dät Sluuten muugelk fon eenpelde Wikis in ne Wikifarm',
	'closewikis-closed' => '$1',
	'closewikis-page' => 'Wiki sluute',
	'closewikis-page-close' => 'Wiki sluute',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Anwieseden Gruund:',
	'closewikis-page-close-reason' => 'Gruund, die der in dät Logbouk iendrain wäd:',
	'closewikis-page-close-submit' => 'Sluute',
	'closewikis-page-close-success' => 'Wiki mäd Ärfoulch sleeten.',
	'closewikis-page-reopen' => 'Wiki wier eepenje',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Gruund:',
	'closewikis-page-reopen-submit' => 'Wier eepenje',
	'closewikis-page-reopen-success' => 'Wiki mäd Ärfoulch wier eepend',
	'closewikis-page-err-nowiki' => 'Uungultich Wiki anroat',
	'closewikis-page-err-closed' => 'Wiki is al sleeten',
	'closewikis-page-err-opened' => 'Wiki is nit sleeten',
	'closewikis-list' => 'Lieste fon sleetene Wikis',
	'closewikis-list-intro' => 'Disse Lieste änthaalt Wikis, do der fon Stewards sleeten wuuden.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Sleeten fon:',
	'closewikis-list-header-timestamp' => 'Sleeten an n',
	'closewikis-list-header-dispreason' => 'Anwiesden Gruund',
	'closewikis-log' => 'Wikisluutengs-Logbouk',
	'closewikis-log-header' => 'Dit Logbouk wiest aal Sluutengen un Wiereepengen fon Wikis truch Stewards oun.',
	'closewikis-log-close' => 'sloot $2',
	'closewikis-log-reopen' => 'eepende $2 wier',
	'right-editclosedwikis' => 'Sleetene Wikis beoarbaidje',
	'right-closewikis' => 'Wikis sluute',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'closewikis-page-reopen-reason' => 'Alesan:',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'closewikis-desc' => 'Möjliggör stängning av wikier inom wikisamlingar',
	'closewikis-page' => 'Stäng wiki',
	'closewikis-page-close' => 'Stäng wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Anledning (visas):',
	'closewikis-page-close-reason' => 'Anledning (loggas):',
	'closewikis-page-close-submit' => 'Stäng',
	'closewikis-page-close-success' => 'Wiki lyckades stängas',
	'closewikis-page-reopen' => 'Återöppna wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Anledning:',
	'closewikis-page-reopen-submit' => 'Återöppna',
	'closewikis-page-reopen-success' => 'Wiki lyckades återöppnas',
	'closewikis-page-err-nowiki' => 'Ogiltig wiki specificerad',
	'closewikis-page-err-closed' => 'Wiki är redan stängd',
	'closewikis-page-err-opened' => 'Wiki är inte stängd',
	'closewikis-list' => 'Lista över stängda wikier',
	'closewikis-list-intro' => 'Denna lista innehåller wikier som stängdes av stewarder.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Stängd av',
	'closewikis-list-header-timestamp' => 'Stängd vid',
	'closewikis-list-header-dispreason' => 'Visad anledning',
	'closewikis-log' => 'Logg över stängning av wikier',
	'closewikis-log-header' => 'Här är en logg över alla stängningar och återöppningar av wikier som gjorts av stewarder',
	'closewikis-log-close' => 'stängde $2',
	'closewikis-log-reopen' => 'återöppnade $2',
	'right-editclosedwikis' => 'Redigera stängda wikier',
	'right-closewikis' => 'Stäng wikier',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'closewikis-page-close-wiki' => 'விக்கி:',
	'closewikis-page-close-dreason' => 'காரணம் (காட்டப்பட்டுள்ளது):',
	'closewikis-page-close-submit' => 'மூடுக',
	'closewikis-page-reopen-wiki' => 'விக்கி:',
	'closewikis-page-reopen-reason' => 'காரணம்:',
	'closewikis-page-reopen-submit' => 'திரும்பத் திறக்கவும்',
	'closewikis-list-header-wiki' => 'விக்கி',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'closewikis-desc' => 'ఈ వికీ ఫాంలలోని వికీ సైటులను మూసివేయనిస్తుంది',
	'closewikis-page' => 'వికీని మూసివేయండి',
	'closewikis-page-close' => 'వికీని మూసివేయండి',
	'closewikis-page-close-wiki' => 'వికీ:',
	'closewikis-page-close-dreason' => 'కారణము (చూపించబడినది):',
	'closewikis-page-close-reason' => 'కారణం (లాగ్ అయినది):',
	'closewikis-page-close-submit' => 'మూసివేయండి',
	'closewikis-page-close-success' => 'వికీ విజయవంతముగా మూసివేయబడినది',
	'closewikis-page-reopen' => 'వికీని తిరిగి తెరవండి',
	'closewikis-page-reopen-wiki' => 'వికీ:',
	'closewikis-page-reopen-reason' => 'కారణం:',
	'closewikis-page-reopen-submit' => 'తిరిగి తెరవండి',
	'closewikis-page-err-closed' => 'వికీ ఇదివరకే మూసివేయబడినది',
	'closewikis-page-err-opened' => 'వికీ మూయబడలేదు',
	'closewikis-list' => 'మూసివేయబడిన వికీల జాబితా',
	'closewikis-list-header-wiki' => 'వికీ',
	'closewikis-list-header-by' => 'ద్వారా మూసివేయబడినది',
	'closewikis-list-header-timestamp' => 'మూసివేయబడిన రోజు',
	'closewikis-list-header-dispreason' => 'ప్రదర్శింపబడిన కారణము',
	'closewikis-log' => 'వికీ మూసివేతల లాగు',
	'closewikis-log-close' => '$2 మూసివేయబడినది',
	'closewikis-log-reopen' => '$2 తిరిగి తెరవబడినది',
	'right-closewikis' => 'వికీలను మూసివేయండి',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-list-header-wiki' => 'Wiki',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'closewikis-desc' => 'Nagpapahintulot na maisara ang mga sityo ng wiking nasa loob ng mga linangan ng wiki',
	'closewikis-page' => 'Isara ang wiki',
	'closewikis-page-close' => 'Isara ang wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Dahilan (ipinapakita):',
	'closewikis-page-close-reason' => 'Dahilan (nakatala):',
	'closewikis-page-close-submit' => 'Isara',
	'closewikis-page-close-success' => 'Matagumpay na naisara ang wiki',
	'closewikis-page-reopen' => 'Buksang muli ang wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Dahilan:',
	'closewikis-page-reopen-submit' => 'Buksang muli',
	'closewikis-page-reopen-success' => 'Matagumpay na nabuksang muli ang wiki',
	'closewikis-page-err-nowiki' => 'Hindi tanggap ang tinukoy na wiki',
	'closewikis-page-err-closed' => 'Nakasarado na ang wiki',
	'closewikis-page-err-opened' => 'Hindi pa nakasara ang wiki',
	'closewikis-list' => 'Talaan ng isinarang mga wiki',
	'closewikis-list-intro' => 'Naglalaman ang talaang ito ng mga wiking isinarado ng mga katiwala.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Isinara ni',
	'closewikis-list-header-timestamp' => 'Isinara noong',
	'closewikis-list-header-dispreason' => 'Ipinapakitang dahilan',
	'closewikis-log' => 'Talaan ng pagsasara ng mga wiki',
	'closewikis-log-header' => 'Narito ang isang talaan ng lahat ng mga pagsasara ng wiki at mga muling pagbubukas na ginawa ng mga katiwala',
	'closewikis-log-close' => 'isinara ang $2',
	'closewikis-log-reopen' => 'binuksang muli ang $2',
	'right-editclosedwikis' => 'Baguhin ang nakasarang mga wiki',
	'right-closewikis' => 'Isara ang mga wiki',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 */
$messages['tr'] = array(
	'closewikis-desc' => 'Viki çiftliklerindeki viki sitelerini kapatmaya izin verir',
	'closewikis-page' => 'Kapat',
	'closewikis-page-close' => 'Kapat',
	'closewikis-page-close-wiki' => 'Viki:',
	'closewikis-page-close-dreason' => 'Sebep (gösterilen):',
	'closewikis-page-close-reason' => 'Sebep (günlüklenmiş):',
	'closewikis-page-close-submit' => 'Kapat',
	'closewikis-page-close-success' => 'Viki başarıyla kapatıldı',
	'closewikis-page-reopen' => 'Vikiyi yeniden aç',
	'closewikis-page-reopen-wiki' => 'Viki:',
	'closewikis-page-reopen-reason' => 'Nedeni:',
	'closewikis-page-reopen-submit' => 'Tekrar aç',
	'closewikis-page-reopen-success' => 'Viki başarıyla yeniden açıldı',
	'closewikis-page-err-nowiki' => 'Geçersiz viki belirtildi',
	'closewikis-page-err-closed' => 'Viki zaten kapalı',
	'closewikis-page-err-opened' => 'Viki kapalı değil',
	'closewikis-list' => 'Kapalı Vikiler listesi',
	'closewikis-list-intro' => 'Bu liste, stewardlar tarafından kapatılan vikileri içerir.',
	'closewikis-list-header-wiki' => 'Viki',
	'closewikis-list-header-by' => 'Kapatan',
	'closewikis-list-header-timestamp' => 'Kapatılma tarihi',
	'closewikis-list-header-dispreason' => 'Gösterilen sebep',
	'closewikis-log' => 'Viki kapatma günlüğü',
	'closewikis-log-header' => 'Bu, stewardlar tarafından yapılan tüm viki kapatma ve tekrar açmalarının günlüğüdür',
	'closewikis-log-close' => '$2 vikisini kapattı',
	'closewikis-log-reopen' => '$2 vikisini tekrar açtı',
	'right-editclosedwikis' => 'Kapalı vikileri değiştir',
	'right-closewikis' => 'Vikileri kapat',
);

/** Ukrainian (Українська)
 * @author Dim Grits
 * @author Prima klasy4na
 * @author Sodmy
 * @author Тест
 */
$messages['uk'] = array(
	'closewikis-desc' => 'Дозволяє закрити вікі сайти у вікі фермі',
	'closewikis-page' => 'Закрити Вікі',
	'closewikis-page-close' => 'Закрити Вікі',
	'closewikis-page-close-wiki' => 'Вікі:',
	'closewikis-page-close-dreason' => 'Причина (для показу):',
	'closewikis-page-close-reason' => 'Причина (для запису в журнал):',
	'closewikis-page-close-submit' => 'Закрити',
	'closewikis-page-close-success' => 'Wiki успішно закрито',
	'closewikis-page-reopen' => 'Перевідкрити Вікі',
	'closewikis-page-reopen-wiki' => 'Вікі:',
	'closewikis-page-reopen-reason' => 'Причина:',
	'closewikis-page-reopen-submit' => 'Повторно відкрити',
	'closewikis-page-reopen-success' => 'Вікі успішно відновлено',
	'closewikis-page-err-nowiki' => 'Вказано неприпустиму Вікі',
	'closewikis-page-err-closed' => 'Вікі вже закрита',
	'closewikis-page-err-opened' => 'Вікі не закрита',
	'closewikis-list' => 'Список закритих Вікі',
	'closewikis-list-intro' => 'Цей список містить Вікі, які були закриті стюардами.',
	'closewikis-list-header-wiki' => 'Вікі',
	'closewikis-list-header-by' => 'Закрито',
	'closewikis-list-header-timestamp' => 'Закрито по',
	'closewikis-list-header-dispreason' => 'Відображена причина',
	'closewikis-log' => 'Журнал закриття вікі',
	'closewikis-log-header' => 'Ось журнал всіх закритих та відновдених Вікі, що зроблені стюардами',
	'closewikis-log-close' => 'закрито $2',
	'closewikis-log-reopen' => 'відновлено $2',
	'right-editclosedwikis' => 'Редагування закритих Вікі',
	'right-closewikis' => 'Закриті Вікі',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'closewikis-page-reopen-reason' => 'وجہ:',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-submit' => 'Saubata',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Sü:',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Sauptai:',
	'closewikis-list-header-timestamp' => 'Om sauptud',
	'closewikis-list-header-dispreason' => 'Ozutadud sü',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'closewikis-desc' => 'Cho phép đóng cửa các wiki trong mạng wiki',
	'closewikis-page' => 'Đóng cửa wiki',
	'closewikis-page-close' => 'Đóng cửa wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Lý do (để trình bày):',
	'closewikis-page-close-reason' => 'Lý do (trong nhật trình):',
	'closewikis-page-close-submit' => 'Đóng cửa',
	'closewikis-page-close-success' => 'Đóng cửa wiki thành công',
	'closewikis-page-reopen' => 'Mở cửa lại wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Lý do:',
	'closewikis-page-reopen-submit' => 'Mở cửa lại',
	'closewikis-page-reopen-success' => 'Mở cửa lại wiki thành công',
	'closewikis-page-err-nowiki' => 'Định rõ wiki không hợp lệ',
	'closewikis-page-err-closed' => 'Wiki đã bị đóng cửa',
	'closewikis-page-err-opened' => 'Wiki chưa bị đóng cửa',
	'closewikis-list' => 'Danh sách các wiki đã đóng',
	'closewikis-list-intro' => 'Danh này bao gồm các wiki đã được tiếp viên đóng lại.',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Đóng bởi',
	'closewikis-list-header-timestamp' => 'Đóng vào ngày',
	'closewikis-list-header-dispreason' => 'Lý do được hiển thị',
	'closewikis-log' => 'Nhật trình đóng cửa wiki',
	'closewikis-log-header' => 'Đây là danh sách các tác vụ đóng cửa wiki và mở cửa lại wiki được thực hiện bởi tiếp viên.',
	'closewikis-log-close' => 'đóng cửa $2',
	'closewikis-log-reopen' => 'mở cửa lại $2',
	'right-editclosedwikis' => 'Sửa đổi các wiki bị đóng cửa',
	'right-closewikis' => 'Đóng wiki',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'closewikis-desc' => 'Dälon ad färmükon vükis in vükafarms',
	'closewikis-page' => 'Färmükön vüki',
	'closewikis-page-close' => 'Färmükön vüki',
	'closewikis-page-close-wiki' => 'Vük:',
	'closewikis-page-close-dreason' => 'Kod (pajonöl):',
	'closewikis-page-close-reason' => 'Kod (in jenotalised):',
	'closewikis-page-close-submit' => 'Färmükön',
	'closewikis-page-close-success' => 'Vüki pefärmükon benosekiko',
	'closewikis-page-reopen' => 'Dönumaifükon vüki',
	'closewikis-page-reopen-wiki' => 'Vük:',
	'closewikis-page-reopen-reason' => 'Kod:',
	'closewikis-page-reopen-submit' => 'Dönumaifükön',
	'closewikis-page-reopen-success' => 'Vük pedönumaifükon benosekiko',
	'closewikis-page-err-nowiki' => 'Vük pavilöl no lonöfon',
	'closewikis-page-err-closed' => 'Vük at ya pefärmükon',
	'closewikis-page-err-opened' => 'Vüki at no pefärmükon',
	'closewikis-list' => 'Lised vükas pefärmüköl',
	'closewikis-list-intro' => 'Is palisedons vüks fa guvans pefärmüköls',
	'closewikis-list-header-wiki' => 'Vük',
	'closewikis-list-header-by' => 'Pefärmükon fa',
	'closewikis-list-header-timestamp' => 'Pefärmükon tü',
	'closewikis-list-header-dispreason' => 'Kod pajonöl',
	'closewikis-log' => 'Jenotalised vükifärmükamas',
	'closewikis-log-header' => 'Is palisedons vikifärmükams e vikidönumaifükams valiks fa guvans pejenüköls',
	'closewikis-log-close' => 'efärmükon $2',
	'closewikis-log-reopen' => 'edönumaifükon $2',
	'right-editclosedwikis' => 'Votükön vükis pefärmüköl',
	'right-closewikis' => 'Färmükön vükis',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'closewikis-page-reopen-reason' => '理由：',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'closewikis-page-close-wiki' => 'וויקי:',
	'closewikis-page-reopen-wiki' => 'וויקי:',
	'closewikis-page-reopen-reason' => 'אורזאַך:',
	'closewikis-list-header-wiki' => 'וויקי:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'closewikis-desc' => '允许关闭在维基农场的维基网站',
	'closewikis-page' => '关闭维基',
	'closewikis-page-close' => '关闭维基',
	'closewikis-page-close-wiki' => '维基：',
	'closewikis-page-close-dreason' => '原因（显示）：',
	'closewikis-page-close-reason' => '原因（登录）：',
	'closewikis-page-close-submit' => '关闭',
	'closewikis-page-close-success' => '维基成功关闭',
	'closewikis-page-reopen' => '重新打开维基',
	'closewikis-page-reopen-wiki' => '维基：',
	'closewikis-page-reopen-reason' => '原因：',
	'closewikis-page-reopen-submit' => '重新打开',
	'closewikis-page-reopen-success' => '维基成功打开',
	'closewikis-page-err-nowiki' => '指定的维基无效',
	'closewikis-page-err-closed' => '维基已经关闭',
	'closewikis-page-err-opened' => '维基并不关闭',
	'closewikis-list' => '封闭的维基列表',
	'closewikis-list-intro' => '该列表包含管家封闭的维基。',
	'closewikis-list-header-wiki' => '维基',
	'closewikis-list-header-by' => '关闭由',
	'closewikis-list-header-timestamp' => '关闭在',
	'closewikis-list-header-dispreason' => '显示的原因',
	'closewikis-log' => '维基关闭日志',
	'closewikis-log-header' => '这里是管家所有维基封锁和所做的重开的日志',
	'closewikis-log-close' => '封闭$2',
	'closewikis-log-reopen' => '重新开$2',
	'right-editclosedwikis' => '更改关闭维基',
	'right-closewikis' => '关闭维基',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'closewikis-desc' => '允許關閉在維基農場的維基網站',
	'closewikis-page' => '關閉維基',
	'closewikis-page-close' => '關閉維基',
	'closewikis-page-close-wiki' => '維基：',
	'closewikis-page-close-dreason' => '原因（顯示）：',
	'closewikis-page-close-reason' => '理由（登入）：',
	'closewikis-page-close-submit' => '關閉',
	'closewikis-page-close-success' => '維基成功關閉',
	'closewikis-page-reopen' => '重新打開維基',
	'closewikis-page-reopen-wiki' => '維基：',
	'closewikis-page-reopen-reason' => '原因：',
	'closewikis-page-reopen-submit' => '重新打開',
	'closewikis-page-reopen-success' => '維基成功打開',
	'closewikis-page-err-nowiki' => '指定的維基無效',
	'closewikis-page-err-closed' => '維基已經關閉',
	'closewikis-page-err-opened' => '維基並不關閉',
	'closewikis-list' => '封閉的維基列表',
	'closewikis-list-intro' => '該列表包含管家封閉的維基。',
	'closewikis-list-header-wiki' => '維基',
	'closewikis-list-header-by' => '關閉由',
	'closewikis-list-header-timestamp' => '關閉在',
	'closewikis-list-header-dispreason' => '顯示的原因',
	'closewikis-log' => '維基關閉日誌',
	'closewikis-log-header' => '這裡是管家所有維基封鎖和所做的重開的日誌',
	'closewikis-log-close' => '封閉$2',
	'closewikis-log-reopen' => '重新開$2',
	'right-editclosedwikis' => '更改關閉維基',
	'right-closewikis' => '關閉維基',
);

