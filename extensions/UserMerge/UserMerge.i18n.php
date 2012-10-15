<?php
/**
 * Internationalisation file for the User Merge and Delete Extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'usermerge'                     => 'Merge and delete users',
	'usermerge-desc'                => "[[Special:UserMerge|Merges references from one user to another user]] in the wiki database - will also delete old users following merge. Requires ''usermerge'' privileges",
	'usermerge-badolduser' 		=> 'Invalid old username',
	'usermerge-badnewuser' 		=> 'Invalid new username',
	'usermerge-nonewuser' 		=> 'Empty new username - assuming merge to "$1".<br />
Click "{{int:usermerge-submit}}" to accept.',
	'usermerge-noolduser' 		=> 'Empty old username',
	'usermerge-fieldset'            => 'Usernames to merge',
	'usermerge-olduser' 		=> 'Old user (merge from):',
	'usermerge-newuser' 		=> 'New user (merge to):',
	'usermerge-deleteolduser' 	=> 'Delete old user',
	'usermerge-submit' 		=> 'Merge user',
	'usermerge-badtoken' 		=> 'Invalid edit token',
	'usermerge-userdeleted' 	=> '$1 ($2) has been deleted.',
	'usermerge-userdeleted-log' 	=> 'Deleted user: $2 ($3)',
	'usermerge-updating' 		=> 'Updating $1 table ($2 to $3)',
	'usermerge-success' 		=> 'Merge from $1 ($2) to $3 ($4) is complete.',
	'usermerge-success-log' 	=> 'User $2 ($3) merged to $4 ($5)',
	'usermerge-logpage'           	=> 'User merge log',
	'usermerge-logpagetext'       	=> 'This is a log of user merge actions.',
	'usermerge-noselfdelete'       	=> 'You cannot delete or merge from yourself!',
	'usermerge-unmergable'		=> 'Unable to merge from user - ID or name has been defined as unmergable.',
	'usermerge-protectedgroup'	=> 'Unable to merge from user - user is in a protected group.',
	'right-usermerge'               => 'Merge users',
	'usermerge-editcount'		=> 'Add edit count?',
	'usermerge-editcount-success'	=> 'Adding edit count of ($1 and $2)',
	'usermerge-autopagedelete'	=> 'Automatically deleted when merging users',
	'usermerge-page-unmoved' 	=> 'The page $1 could not be moved to $2.',
	'usermerge-page-moved'   	=> 'The page $1 has been moved to $2.',
	'usermerge-move-log'   		=> 'Automatically moved page while merging the user "[[User:$1|$1]]" to "[[User:$2|$2]]"',
	'usermerge-page-deleted' 	=> 'Deleted page $1',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Meno25
 * @author Purodha
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'usermerge-desc' => '{{desc}}',
	'usermerge-badtoken' => '{{Identical|Invalid edit token}}',
	'usermerge-userdeleted' => 'Parameters:
* $1 is a user name (not linked)
* $2 is a user ID',
	'usermerge-userdeleted-log' => 'Parameters:
* $2 is a user name (not linked) of the deleted user
* $3 is a user ID of the deleted user',
	'usermerge-success' => 'Parameters:
* $1 is a user name (not linked) that is merged into another user
* $2 is a user ID of the source user
* $3 is a user name (not linked) that the other user is merged into
* $4 is a user ID of the target user',
	'usermerge-success-log' => 'Parameters:
* $2 is a user name (not linked) that is merged into another user
* $3 is a user ID of the source user
* $4 is a user name (not linked) that the other user is merged into
* $5 is a user ID of the target user',
	'right-usermerge' => '{{doc-right|usermerge}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'usermerge' => 'Versmelt en verwyder gebruikers',
	'usermerge-desc' => "Maak 'n [[Special:UserMerge|spesiale bladsy]] beskikbaar om gebruikers te versmelt en die ou gebruiker(s) te verwyder (hiervoor is die ''usermerge''-reg nodig)",
	'usermerge-badolduser' => 'Ongeldige ou gebruiker',
	'usermerge-badnewuser' => 'Ongeldige nuwe gebruiker',
	'usermerge-nonewuser' => 'Die nuwe gebruikersnaam is nie ingevoer nie - daar word aangeneem dat dit met $1 versmelt moet word.<br />
Kliek "{{int:usermerge-submit}}" om die handeling uit te voer.',
	'usermerge-noolduser' => 'Ou gebruikersnaam is leeg',
	'usermerge-fieldset' => 'Gebruikers om saam te smelt',
	'usermerge-olduser' => 'Ou gebruiker (versmelt van):',
	'usermerge-newuser' => 'Nuwe gebruiker (versmelt na):',
	'usermerge-deleteolduser' => 'Verwyder ou gebruiker',
	'usermerge-submit' => 'Versmelt gebruiker',
	'usermerge-badtoken' => 'Ongeldige wysigingsteken ("edit token")',
	'usermerge-userdeleted' => '$1 ($2) is verwyder.',
	'usermerge-userdeleted-log' => 'Verwyderde gebruiker: $2 ($3)',
	'usermerge-updating' => 'Tabel $1 aan die verander ($2 na $3)',
	'usermerge-success' => 'Versmelting van $1 ($2) na $3 ($4) is voltooi.',
	'usermerge-success-log' => 'Gebruiker $2 ($3) is versmelt na $4 ($5)',
	'usermerge-logpage' => 'Logboek van gebruikersversmeltings',
	'usermerge-logpagetext' => "Die is 'n logboek van gebruikersversmeltings.",
	'usermerge-noselfdelete' => 'U kan nie uself verwyder of versmelt nie!',
	'usermerge-unmergable' => 'Hierdie gebruiker kan nie versmelt word nie. Die ID of naam is gesteld as nie versmeltbaar nie.',
	'usermerge-protectedgroup' => "Dit is nie moontlik om die gebruikers saam te voeg nie. Die gebruiker is in 'n beskermde groep.",
	'right-usermerge' => 'Versmelt gebruikers',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'usermerge' => 'Përziej dhe fshini përdoruesit',
	'usermerge-desc' => "[[Special:UserMerge|referencat bashkohet nga një user në një përdorues tjetër]] në bazën e të dhënave wiki - do të fshini gjithashtu përdoruesit e vjetër pas bashkohen. Kërkon''''usermerge privilegje",
	'usermerge-badolduser' => 'emrin e pavlefshme të vjetra',
	'usermerge-badnewuser' => 'emrin e pavlefshme të reja',
	'usermerge-nonewuser' => 'Bosh emrin e re - duke supozuar të bashkohen për të "" $1 ". <br /> Kliko "{{int:usermerge-submit}}" për të pranuar.',
	'usermerge-noolduser' => 'Bosh emrin e vjetër',
	'usermerge-fieldset' => 'Emr të bashkojë',
	'usermerge-olduser' => 'përdorues Vjetër (bashkojë nga):',
	'usermerge-newuser' => 'Përdorues i ri (të bashkohen për të):',
	'usermerge-deleteolduser' => 'Fshi përdorues i vjetër',
	'usermerge-submit' => 'Merge përdorues',
	'usermerge-badtoken' => 'Pavlefshme redakto shenjë',
	'usermerge-userdeleted' => '$1 ($2) është fshirë.',
	'usermerge-userdeleted-log' => 'përdorues Deleted: $2 ($3)',
	'usermerge-updating' => 'Tabela Përditësimi $1 ($2 në $3)',
	'usermerge-success' => 'Merge nga $1 ($2) për $3 ($4), është i kompletuar.',
	'usermerge-success-log' => 'User $2 ($3) bashkohen në $4 ($5)',
	'usermerge-logpage' => 'Përdoruesi bashkojë log',
	'usermerge-logpagetext' => 'Ky është një regjistër i përdoruesit bashkojë veprimet.',
	'usermerge-noselfdelete' => 'Ju nuk mund të fshini ose përpuqni nga vetë!',
	'usermerge-unmergable' => 'Në pamundësi për të bashkuar nga përdoruesit - ID ose emër është përcaktuar si unmergable.',
	'usermerge-protectedgroup' => 'Në pamundësi për të bashkuar nga përdoruesi - user është në një grup të mbrojtura.',
	'right-usermerge' => 'Merge përdoruesit',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author روخو
 */
$messages['ar'] = array(
	'usermerge' => 'دمج وحذف المستخدمين',
	'usermerge-desc' => "[[Special:UserMerge|يدمج المراجع من مستخدم إلى آخر]] في قاعدة بيانات الويكي - سيحذف أيضا المستخدمين القدامى بعد الدمج. يتطلب صلاحيات ''usermerge''",
	'usermerge-badolduser' => 'اسم المستخدم القديم غير صحيح',
	'usermerge-badnewuser' => 'اسم المستخدم الجديد غير صحيح',
	'usermerge-nonewuser' => 'اسم مستخدم جديد فارغ - افتراض الدمج إلى "$1".<br />
اضغط "{{int:usermerge-submit}}" للقبول.',
	'usermerge-noolduser' => 'اسم المستخدم القديم فارغ',
	'usermerge-fieldset' => 'أسماء المستخدمين للدمج',
	'usermerge-olduser' => 'مستخدم قديم (دمج من):',
	'usermerge-newuser' => 'مستخدم جديد (دمج إلى):',
	'usermerge-deleteolduser' => 'حذف المستخدم القديم',
	'usermerge-submit' => 'دمج المستخدم',
	'usermerge-badtoken' => 'نص تعديل غير صحيح',
	'usermerge-userdeleted' => '$1($2) تم حذفه.',
	'usermerge-userdeleted-log' => 'حذف المستخدم: $2($3)',
	'usermerge-updating' => 'تحديث $1 جدول ($2 إلى $3)',
	'usermerge-success' => 'الدمج من $1($2) إلى $3($4) اكتمل.',
	'usermerge-success-log' => 'المستخدم $2($3) تم دمجه مع $4($5)',
	'usermerge-logpage' => 'سجل دمج المستخدم',
	'usermerge-logpagetext' => 'هذا سجل بأفعال دمج المستخدمين.',
	'usermerge-noselfdelete' => 'لا يمكنك حذف أو دمج من نفسك!',
	'usermerge-unmergable' => 'غير قادر على الدمج من مستخدم - الرقم أو الاسم تم تعريفه كغير قابل للدمج.',
	'usermerge-protectedgroup' => 'غير قادر على الدمج من المستخدم - المستخدم في مجموعة محمية.',
	'right-usermerge' => 'دمج المستخدمين',
	'usermerge-page-deleted' => 'صفحة محذوفة $1',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'usermerge-deleteolduser' => 'ܫܘܦ ܡܦܠܚܢܐ ܥܬܝܩܐ',
	'usermerge-submit' => 'ܚܒܘܛ ܡܦܠܚܢܐ',
	'usermerge-logpage' => 'ܣܓܠܐ ܕܚܒܛ̈ܐ ܕܡܦܠܚܢܐ',
	'right-usermerge' => 'ܚܒܘܛ ܡܦܠܚܢ̈ܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'usermerge' => 'دمج وحذف اليوزرز',
	'usermerge-desc' => "[[Special:UserMerge|يدمج المراجع من يوزر ليوزر]] فى قاعدة بيانات الويكى - يحذف اليوزرز القدام بعد الدمج. يتطلب صلاحيات ''usermerge''",
	'usermerge-badolduser' => 'اسم اليوزر القديم مش صحيح',
	'usermerge-badnewuser' => 'اسم اليوزر الجديد مش صحيح',
	'usermerge-nonewuser' => 'اسم يوزر جديد فارغ - افتراض الدمج إلى $1.<br />
اضغط "{{int:usermerge-submit}}" للقبول.',
	'usermerge-noolduser' => 'اسم اليوزر القديم فارغ',
	'usermerge-fieldset' => 'أسماء اليوزرز للدمج',
	'usermerge-olduser' => 'يوزر قديم (دمج من):',
	'usermerge-newuser' => 'يوزر جديد (دمج ل):',
	'usermerge-deleteolduser' => 'حذف اليوزر القديم',
	'usermerge-submit' => 'دمج اليوزر',
	'usermerge-badtoken' => 'نص تعديل غير صحيح',
	'usermerge-userdeleted' => '$1($2) تم حذفه.',
	'usermerge-userdeleted-log' => 'حذف اليوزر: $2($3)',
	'usermerge-updating' => 'تحديث $1 جدول ($2 إلى $3)',
	'usermerge-success' => 'الدمج من $1($2) إلى $3($4) اكتمل.',
	'usermerge-success-log' => 'اليوزر $2($3) تم دمجه مع $4($5)',
	'usermerge-logpage' => 'سجل دمج اليوزر',
	'usermerge-logpagetext' => 'ده سجل بأفعال دمج اليوزرز.',
	'usermerge-noselfdelete' => 'لا يمكنك حذف أو دمج من نفسك!',
	'usermerge-unmergable' => 'مش قادر يدمج من يوزر - الرقم أو الاسم تم تعريفه على  انه مش  قابل للدمج.',
	'usermerge-protectedgroup' => 'مش قادر  يدمج من اليوزر - اليوزر فى مجموعة محمية.',
	'right-usermerge' => 'دمج اليوزرز',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Renessaince
 */
$messages['be-tarask'] = array(
	'usermerge' => "Аб'яднаньне і выдаленьне рахункаў удзельнікаў",
	'usermerge-desc' => "[[Special:UserMerge|Аб'ядноўвае спасылкі аднаго ўдзельніка на іншага]] ў базе зьвестак вікі — адначасова выдаляе старыя рахункі пасьля аб'яднаньня. Патрабуе правы на ''аб'яданьне рахункаў удзельнікаў''",
	'usermerge-badolduser' => 'Няслушнае старое імя ўдзельніка',
	'usermerge-badnewuser' => 'Няслушнае новае імя ўдзельніка',
	'usermerge-nonewuser' => "Пустое новае імя ўдзельніка — мяркуецца аб'яднаньне з «$1».<br />
Націсьніце «{{int:usermerge-submit}}» каб пагадзіцца.",
	'usermerge-noolduser' => 'Пустое старое імя ўдзельніка',
	'usermerge-fieldset' => "Імёны ўдзельнікаў для аб'яднаньня",
	'usermerge-olduser' => "Стары ўдзельнік (аб'яднаць з):",
	'usermerge-newuser' => "Новы ўдзельнік (аб'яднаць з):",
	'usermerge-deleteolduser' => 'Выдаліць стары рахунак удзельніка',
	'usermerge-submit' => "Аб'яднаць рахункі ўдзельнікаў",
	'usermerge-badtoken' => 'Няслушны знак рэдагаваньня',
	'usermerge-userdeleted' => '$1 ($2) быў выдалены.',
	'usermerge-userdeleted-log' => 'Выдалены рахунак удзельніка: $2 ($3)',
	'usermerge-updating' => 'Абнаўленьне табліцы $1 ($2 да $3)',
	'usermerge-success' => "Аб'яднаньне $1 ($2) з $3 ($4) скончанае.",
	'usermerge-success-log' => "Удзельнік $2 ($3) аб'яднаны з $4 ($5)",
	'usermerge-logpage' => "Журнал аб'яднаньня рахункаў удзельнікаў",
	'usermerge-logpagetext' => "Гэта журнал аб'яднаньня рахункаў удзельнікаў.",
	'usermerge-noselfdelete' => "Вы ня можаце выдаліць ці аб'яднаць уласны рахунак!",
	'usermerge-unmergable' => "Немагчыма аб'яднаць рахунак удзельніка — ідэнтыфікатар ці імя былі пазначаны як неаб'яднальныя.",
	'usermerge-protectedgroup' => "Немагчыма аб'яднаць рахунак удзельніка — удзельнік знаходзіцца ў абароненай групе.",
	'right-usermerge' => "аб'яднаньне рахункаў удзельнікаў",
	'usermerge-editcount' => 'Дадаць лічыльнік рэдагаваньняў?',
	'usermerge-editcount-success' => 'Даданьне лічыльніка рэдагаваньняў ($1 і $2)',
	'usermerge-autopagedelete' => 'Аўтаматычна выдалены падчас аб’яднаньня рахункаў ўдзельнікаў',
	'usermerge-page-unmoved' => 'Старонка $1 ня можа быць перанесеная ў $2.',
	'usermerge-page-moved' => 'Старонка $1 перанесеная ў $2.',
	'usermerge-move-log' => 'Аўтаматычна перанесеная старонка падчас аб’яднаньня рахунку ўдзельніка «[[User:$1|$1]]» з «[[User:$2|$2]]»',
	'usermerge-page-deleted' => 'Выдаленая старонка $1',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'usermerge' => 'Сливане и изтриване на потребители',
	'usermerge-desc' => "[[Special:UserMerge|Сливане на приносите от един потребител в друг]] в базата от данни - след сливането изтрива стария потребител. Изисква права ''usermerge''",
	'usermerge-badolduser' => 'Невалиден стар потребител',
	'usermerge-badnewuser' => 'Невалиден нов потребител',
	'usermerge-noolduser' => 'Изчистване на старото потребителско име',
	'usermerge-fieldset' => 'Потребителски имена за сливане',
	'usermerge-olduser' => 'Стар потребител (за сливане от):',
	'usermerge-newuser' => 'Нов потребител (за сливане в):',
	'usermerge-deleteolduser' => 'Изтриване на стария потребител',
	'usermerge-submit' => 'Сливане',
	'usermerge-userdeleted' => '$1($2) беше изтрит.',
	'usermerge-userdeleted-log' => 'Изтрит потребител: $2($3)',
	'usermerge-success' => 'Сливането от $1 ($2) към $3 ($4) приключи.',
	'usermerge-success-log' => 'Потребител $2 ($3) беше слят с $4 ($5)',
	'usermerge-logpage' => 'Дневник на потребителските сливания',
	'usermerge-logpagetext' => 'Тази страница съдържа дневник на потребителските сливания.',
	'usermerge-noselfdelete' => 'Не е възможно да изтривате или сливате от себе си!',
	'usermerge-unmergable' => 'Сливането от потребителя е невъзможно - името или ID е отбелязано като несливаемо.',
	'usermerge-protectedgroup' => 'Невъзможно е да се извърши сливане от потребител - потребителят е в защитена група.',
	'right-usermerge' => 'сливане на потребители',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'usermerge' => 'ব্যবহারকারী একত্রীকরণ এবং মুছে ফেলা',
	'usermerge-desc' => "উইকি ডাটাবেজে [[Special:UserMerge|একজন ব্যবহারকারী থেকে অপর ব্যবহারকারীর প্রতি নির্দেশনাগুলি একত্রিত করে]] - এছাড়া একত্রীকরণের পরে পুরনো ব্যবহারকারীদের মুছে দেবে। বিশেষ ''usermerge'' অধিকার আবশ্যক",
	'usermerge-badolduser' => 'অবৈধ পুরনো ব্যবহারকারী নাম',
	'usermerge-badnewuser' => 'অবৈধ নতুন ব্যবহারকারী নাম',
	'usermerge-nonewuser' => 'খালি নতুন ব্যবহারকারী নাম - $1-এর সাথে একত্রীকরণ করা হচ্ছে ধরা হলে। <br /><u>ব্যবহারকারী একত্রিত করা হোক</u> ক্লিক করে সম্মতি দিন।',
	'usermerge-noolduser' => 'খালি পুরনো ব্যবহারকারী নাম',
	'usermerge-fieldset' => 'একত্রিক করার জন্য ব্যবহারকারীনাম',
	'usermerge-olduser' => 'পুরনো ব্যবহারকারী (যার থেকে একত্রীকরণ):',
	'usermerge-newuser' => 'নতুন ব্যবহারকারী (যার সাথে একত্রীকরণ)ঃ',
	'usermerge-deleteolduser' => 'পুরনো ব্যবহারকারী অপসারণ',
	'usermerge-submit' => 'ব্যবহারকারী একত্রিত করা হোক',
	'usermerge-badtoken' => 'সম্পাদনা টোকেন অবৈধ',
	'usermerge-userdeleted' => '$1 ($2) মুছে ফেলা হয়েছে।',
	'usermerge-userdeleted-log' => 'ব্যবহারকারী মুছে ফেলে হয়েছে: $2 ($3)',
	'usermerge-updating' => '$1 টেবিল হালনাগাদ করা হচ্ছে ($2 থেকে $3-তে)',
	'usermerge-success' => '$1 ($2) থেকে $3 ($4)-তে একত্রীকরণ সম্পন্ন হয়েছে।',
	'usermerge-success-log' => 'ব্যবহারকারী $2 ($3)-কে $4 ($5)-এর সাথে একত্রিত করা হয়েছে',
	'usermerge-logpage' => 'ব্যবহারকারী একত্রীকরণ লগ',
	'usermerge-logpagetext' => 'এটি ব্যবহারকারী একত্রীকরনের একটি লগ।',
	'usermerge-noselfdelete' => 'আপনি নিজের ব্যবহারকারী নাম মুছে ফেলতে বা এটি থেকে অন্য নামে একত্রিত করতে পারবেন না!',
	'usermerge-unmergable' => 'ব্যবহারকারী নাম থেকে একত্রিত করা যায়নি - আইডি বা নামটি একত্রীকরণযোগ্য নয় হিসেবে সংজ্ঞায়িত।',
	'usermerge-protectedgroup' => 'ব্যবহারকারী নাম থেকে একত্রিত করা যায়নি - ব্যবহারকারীটি একটি সুরক্ষিত দলে আছেন।',
	'right-usermerge' => 'ব্যবহারকারী একত্রিত করা হোক',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'usermerge' => 'Kendeuziñ an implijer ha diverkañ',
	'usermerge-desc' => "[[Special:UserMerge|Kendeuziñ a ra daveennoù un implijer gant re unan bennak all]] e diaz titouroù ar wiki - diverkañ a raio ivez ar c'hendeuzadennoù implijer kozh da zont. Rekis eo kaout aotreoù ''kendeuziñ''",
	'usermerge-badolduser' => 'Anv implijer kozh direizh',
	'usermerge-badnewuser' => 'Anv implijer nevez direizh',
	'usermerge-nonewuser' => 'Anv implijer nevez goullo - soñjal a ra deomp e fell deoc\'h kendeuziñ davet "$1".<br />
Klikañ war "{{int:usermerge-submit}}" evit asantiñ.',
	'usermerge-noolduser' => 'Anv implijer kozh goullo',
	'usermerge-fieldset' => 'Anvioù implijer da gendeuziñ',
	'usermerge-olduser' => 'Implijer kozh (kendeuziñ adal) :',
	'usermerge-newuser' => 'Implijer nevez (kendeuziñ gant) :',
	'usermerge-deleteolduser' => 'Diverkañ an implijer kozh',
	'usermerge-submit' => 'Kendeuziñ implijer',
	'usermerge-badtoken' => 'Jedouer aozañ direizh',
	'usermerge-userdeleted' => 'Diverket eo bet $1 ($2).',
	'usermerge-userdeleted-log' => 'Implijer diverket : $2($3)',
	'usermerge-updating' => "Oc'h hizivaat an daolenn $1 (eus $2 da $3)",
	'usermerge-success' => 'Kendeuzadenn adal $1 ($2) davet $3 ($4) kaset da benn vat.',
	'usermerge-success-log' => 'Implijer $2 ($3) kendeuzet davet $4 ($5)',
	'usermerge-logpage' => 'Marilh kendeuzadennoù an implijerien',
	'usermerge-logpagetext' => 'Setu aze marilh kendeuzadennoù an implijerien.',
	'usermerge-noselfdelete' => "N'hallit ket diverkañ pe kendeuziñ adal pe davedoc'h hoc'h-unan",
	'usermerge-unmergable' => 'Dibosupl kendeuziñ adal un implijer - un niv. anaout pe un anv bet termenet evel digendeuzadus.',
	'usermerge-protectedgroup' => 'Dibosupl kendeuziñ an implijer - emañ-eñ en ur strollad gwarezet',
	'right-usermerge' => 'Kendeuziñ implijerien',
	'usermerge-page-deleted' => 'Pajenn $1 diverket',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'usermerge' => 'Spajanje i brisanje korisnika',
	'usermerge-desc' => "[[Special:UserMerge|Spajanje referenci sa jednog na drugog kornisnika]] u wiki bazi podataka - također će obrisaiti stare korisnike nakon spajanja. Zahtjeva ''usermerge'' privilegije.",
	'usermerge-badolduser' => 'Nevaljano staro korisničko ime',
	'usermerge-badnewuser' => 'Nevaljano novo korisničko ime',
	'usermerge-nonewuser' => 'Prazno novo korisničko ime - pretpostavljam da se spaja na "$1".<br />
Kliknite na "{{int:usermerge-submit}}" za prihvatanje.',
	'usermerge-noolduser' => 'Prazno staro korisničko ime',
	'usermerge-fieldset' => 'Korisnička imena za spajanje',
	'usermerge-olduser' => 'Stari korisnik (spajanje sa):',
	'usermerge-newuser' => 'Novi korisnik (spajanje na):',
	'usermerge-deleteolduser' => 'Obriši starog korisnika',
	'usermerge-submit' => 'Spoji korisnika',
	'usermerge-badtoken' => 'Nevaljan token izmjene',
	'usermerge-userdeleted' => '$1 ($2) je obrisan.',
	'usermerge-userdeleted-log' => 'Obrisani korisnik: $2 ($3)',
	'usermerge-updating' => 'Ažuriram $1 tabelu ($2 do $3)',
	'usermerge-success' => 'Spajanje sa $1 ($2) na $3 ($4) je završeno.',
	'usermerge-success-log' => 'Korisnik $2 ($3) spojen na $4 ($5)',
	'usermerge-logpage' => 'Zapisnik spajanja korisnika',
	'usermerge-logpagetext' => 'Ovo je zapisnik akcija spajanja korisnika.',
	'usermerge-noselfdelete' => 'Ne možete obrisati ili spajati od samog sebe!',
	'usermerge-unmergable' => 'Ne može se spajati od korisnika - ID ili naziv je definisan kao nespojiv.',
	'usermerge-protectedgroup' => 'Ne može se spajati od korisnika - korisnik je u zaštićenoj grupi.',
	'right-usermerge' => 'Spajanje korisnika',
);

/** Catalan (Català)
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'usermerge-badolduser' => "Nom d'usuari antic no vàlid",
	'usermerge-badnewuser' => "Nom d'usuari nou no vàlid",
	'usermerge-noolduser' => "Nom d'usuari antic sense especificar",
	'usermerge-olduser' => 'Antic usuari (barreja des de):',
	'usermerge-newuser' => 'Nou usuari (barreja a):',
	'usermerge-deleteolduser' => "Elimina l'antic usuari",
	'usermerge-submit' => 'Combina els usuaris',
	'usermerge-userdeleted-log' => 'Usuari eliminat: $2 ($3)',
	'usermerge-logpage' => "Registre de fusions d'usuaris",
	'right-usermerge' => 'Fusionar usuaris',
);

/** Sorani (کوردی)
 * @author Marmzok
 */
$messages['ckb'] = array(
	'usermerge-deleteolduser' => 'سڕینەوەی بەکارهێنەری کۆن',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'usermerge' => 'Slučování a mazání uživatelů',
	'usermerge-desc' => "[[Special:UserMerge|Slučuje odkazy na jednoho uživatele na odkazy na druhého]] v databázi wiki; také následně smaže starého uživatele. Vyžaduje oprávnění ''usermerge''.",
	'usermerge-badolduser' => 'Původní uživatelské jméno je neplatné',
	'usermerge-badnewuser' => 'Neplatné nové uživatelské jmnéo',
	'usermerge-nonewuser' => 'Nové uživatelské jméno je prázdné – předpokládá se sloučení do „$1“.<br />
Potvrdit můžete kliknutím na „{{int:usermerge-submit}}“.',
	'usermerge-noolduser' => 'Původní uživatelské jméno je prázdné',
	'usermerge-fieldset' => 'Slučovaná uživatelská jména',
	'usermerge-olduser' => 'Původní uživatel (odkud se slučuje):',
	'usermerge-newuser' => 'Nový uživatel (kam se slučuje):',
	'usermerge-deleteolduser' => 'Smazat původního uživatele',
	'usermerge-submit' => 'Sloučit uživatele',
	'usermerge-badtoken' => 'Neplatný editační token',
	'usermerge-userdeleted' => '$1 ($2) byl smazán.',
	'usermerge-userdeleted-log' => 'Smazaný uživatel: $2 ($3)',
	'usermerge-updating' => 'Aktualizuje se tabulka $1 ($2 na $3)',
	'usermerge-success' => 'Sloučení z $1 ($2) do $3 ($4) je dokončeno.',
	'usermerge-success-log' => 'Uživatel $2 ($3) byl sloučen do $4 ($5)',
	'usermerge-logpage' => 'Kniha slučování uživatelů',
	'usermerge-logpagetext' => 'Toto je záznam slučování uživatelů.',
	'usermerge-noselfdelete' => 'Nemůžete smazat nebo sloučit svůj vlastní účet!',
	'usermerge-unmergable' => 'Nebylo možné sloučit uživatele – zdrojové jméno nebo ID bylo definováno jako neslučitelné.',
	'usermerge-protectedgroup' => 'Nebylo možné sloučit uvedeného uživatele – uživatel je v chráněné skupině.',
	'right-usermerge' => 'Slučování uživatelů',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Lukas9950
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'usermerge' => 'Benutzerkonten zusammenführen und löschen',
	'usermerge-desc' => 'Ergänzt eine [[Special:UserMerge|Spezialseite]] zum Zusammenführen von Benutzerkonten und der anschließenden Löschung des alten Benutzerkontos in der Datenbank des Wikis',
	'usermerge-badolduser' => 'Ungültiger alter Benutzername',
	'usermerge-badnewuser' => 'Ungültiger neuer Benutzername',
	'usermerge-nonewuser' => 'Es wurde kein neuer Benutzername angegeben. Daher wird eine Zusammenführung mit „$1“ angenommen.<br />
Zum Ausführen auf „{{int:usermerge-submit}}“ klicken.',
	'usermerge-noolduser' => 'Es wurde kein neuer Benutzername angegeben.',
	'usermerge-fieldset' => 'Benutzernamen zum Zusammenführen',
	'usermerge-olduser' => 'Alter Benutzername (zusammenführen von):',
	'usermerge-newuser' => 'Neuer Benutzername (zusammenführen nach):',
	'usermerge-deleteolduser' => 'Alten Benutzernamen löschen',
	'usermerge-submit' => 'Benutzerkonten zusammenführen',
	'usermerge-badtoken' => 'Ungültiges Bearbeitungstoken',
	'usermerge-userdeleted' => '„$1“ ($2) wurde gelöscht.',
	'usermerge-userdeleted-log' => 'hat „$2“ ($3) gelöscht',
	'usermerge-updating' => 'Aktualisiere Tabelle $1 ($2 nach $3) …',
	'usermerge-success' => 'Die Zusammenführung von „$1“ ($2) nach „$3“ ($4) war erfolgreich.',
	'usermerge-success-log' => 'hat „$2“ ($3) mit „$4“ ($5) zusammengeführt',
	'usermerge-logpage' => 'Benutzerkontenzusammenführungs-Logbuch',
	'usermerge-logpagetext' => 'Dies ist das Logbuch der Benutzerkontenzusammenführungen.',
	'usermerge-noselfdelete' => 'Die Zusammenführung mit sich selber ist nicht möglich!',
	'usermerge-unmergable' => 'Die Zusammenführung ist nicht möglich: Benutzerkennung oder Benutzername wurde als nicht zusammenführbar definiert.',
	'usermerge-protectedgroup' => 'Die Zusammenführung ist nicht möglich: Der Benutzer befindet sich in einer geschützten Gruppe.',
	'right-usermerge' => 'Benutzerkonten zusammenführen',
	'usermerge-editcount' => 'Bearbeitungszähler hinzufügen?',
	'usermerge-editcount-success' => 'Hinzufügen des Bearbeitungszählers ($1 und $2)',
	'usermerge-autopagedelete' => 'Automatisch während der Benutzerkontenzusammenführung gelöscht',
	'usermerge-page-unmoved' => 'Die Seite „$1“ konnte nicht nach „$2“ verschoben werden.',
	'usermerge-page-moved' => 'Die Seite „$1“ wurde nach „$2“ verschoben.',
	'usermerge-move-log' => 'Seite während der Benutzerkontenzusammenführung von „[[User:$1|$1]]“ nach „[[User:$2|$2]]“ automatisch verschoben',
	'usermerge-page-deleted' => 'Seite „$1“ gelöscht',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'usermerge' => 'Wužywarjow zjadnośiś a wulašowaś',
	'usermerge-desc' => "[[Special:UserMerge|Zjadnośujo reference wót jadnogo wužywarja k drugemu wužywarjeju]] we wikijowej datowej bance - buźo teke wšych starych wužywarjow pó zjadnosénju lašowaś. Pomina se pšawa ''usermerge''",
	'usermerge-badolduser' => 'Njepłaśiwe stare wužywarske mě',
	'usermerge-badnewuser' => 'Njepłaśiwe nowe wužywarske mě',
	'usermerge-nonewuser' => 'Prozne nowe wužywarske mě - góda se zjadnośenje k $1.<br />
Klikni na "{{int:usermerge-submit}}", aby akceptěrował.',
	'usermerge-noolduser' => 'Prozne stare wužywarske mě',
	'usermerge-fieldset' => 'Wužywarskej mjeni, kótarejž maju se zjadnośiś',
	'usermerge-olduser' => 'Stary wužywaŕ (zjadnośiś wót):',
	'usermerge-newuser' => 'Nowy wužywaŕ (zjadnośiś do):',
	'usermerge-deleteolduser' => 'Starego wužywarja lašowaś',
	'usermerge-submit' => 'Wužywarja zjadnośiś',
	'usermerge-badtoken' => 'Njepłaśiwy wobźěłowański token',
	'usermerge-userdeleted' => '$1 ($2) jo se wulašował.',
	'usermerge-userdeleted-log' => 'Wulašowany wužywaŕ: $2 ($3)',
	'usermerge-updating' => 'Aktualizěrujo se tabela $1 ($2 do $3)',
	'usermerge-success' => 'Zjadnosénje wot $1 ($2) do $3 ($4) jo skóńcone.',
	'usermerge-success-log' => 'Wužywaŕ $2 ($3) jo se do $4 ($5) zjadnośił',
	'usermerge-logpage' => 'Protokol wužywarskich zjadnośenjow',
	'usermerge-logpagetext' => 'To jo protokol akcijow wužywarskich zjadnośenjow.',
	'usermerge-noselfdelete' => 'Njamóžoš se ze sobu zjadnośiś!',
	'usermerge-unmergable' => 'Zjadnosénja wót wužywarja njemóžno - ID abo wužywarske mě jo se ako njezjadnośujobne definěrowane.',
	'usermerge-protectedgroup' => 'Zjadnośenje wót wužywarja njemóžno - wužywaŕ jo w šćitanej kupce.',
	'right-usermerge' => 'Wužywarjow zjadnośiś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'usermerge' => 'Συγχώνευση και διαγραφή χρηστών',
	'usermerge-badolduser' => 'Μη έγκυρο παλιό όνομα χρήστη',
	'usermerge-badnewuser' => 'Μη έγκυρο νέο όνομα χρήστη',
	'usermerge-noolduser' => 'Άδειασμα παλαιού ονόματος χρήστη',
	'usermerge-fieldset' => 'Ονόματα χρηστών προς συγχώνευση',
	'usermerge-olduser' => 'Παλιός χρήστης (συγχώνευση από):',
	'usermerge-newuser' => 'Νέος χρήστης (συγχώνευση σε):',
	'usermerge-deleteolduser' => 'Διαγραφή παλαιού χρήστη',
	'usermerge-submit' => 'Συγχώνευση χρήστη',
	'usermerge-badtoken' => 'Άκυρο δείγμα επεξεργασίας',
	'usermerge-userdeleted' => 'Ο $1 ($2) έχει διαγραφεί.',
	'usermerge-userdeleted-log' => 'Διεγραμμένος χρήστης: $2 ($3)',
	'usermerge-updating' => 'Ενημέρωση $1 πίνακα ($2 σε $3)',
	'usermerge-success' => 'Η συγχώνευση από $1 ($2) σε $3 ($4) είναι πλήρης.',
	'usermerge-success-log' => 'Ο χρήστης $2 ($3) συγχωνεύθηκε σε $4 ($5)',
	'usermerge-logpage' => 'Αρχείο καταγραφής συγχωνεύσεων χρηστών',
	'usermerge-logpagetext' => 'Αυτό είναι ένα αρχείο καταγραφής συγχωνεύσεων.',
	'usermerge-noselfdelete' => 'Δεν μπορείτε να διαγράψετε ή να συγχωνευτείτε από μόνος σας!',
	'right-usermerge' => 'Συγχώνευση χρηστών',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'usermerge' => 'Kunigi kaj forigi uzantojn',
	'usermerge-badolduser' => 'Nevalida malnova salutnomo',
	'usermerge-badnewuser' => 'Nevalida nova salutnomo',
	'usermerge-noolduser' => 'Malplena malnova salutnomo',
	'usermerge-fieldset' => 'Kunigotaj salutnomoj',
	'usermerge-olduser' => 'Malnova uzanto (kunigante de):',
	'usermerge-newuser' => 'Nova uzanto (kunigante al):',
	'usermerge-deleteolduser' => 'Forigi malnovan uzanton',
	'usermerge-submit' => 'Kunigi uzanton',
	'usermerge-badtoken' => 'Nevalida redakta ĵetono',
	'usermerge-userdeleted' => '$1 ($2) estis forigita.',
	'usermerge-userdeleted-log' => 'Forigis uzanton: $2 ($3)',
	'usermerge-updating' => 'Ĝisdatigante tabelon $1 ($2 al $3)',
	'usermerge-success' => 'Kunigado de $1 ($2) al $3 ($4) kompletiĝis.',
	'usermerge-success-log' => 'Uzanto $2 ($3) kunigita al $4 ($5)',
	'usermerge-logpage' => 'Protokolo pri kunigado de uzantoj',
	'usermerge-logpagetext' => 'Jen protokolo de kunigadoj de uzantoj',
	'usermerge-noselfdelete' => 'Vi ne povas forigi aŭ kunigi de vi mem!',
	'usermerge-protectedgroup' => 'Ne eblis kunigi de uzanto - uzanto estas en protektita grupo.',
	'right-usermerge' => 'Kunfandi uzantojn',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Sanbec
 */
$messages['es'] = array(
	'usermerge' => 'Fusionar y borrar usuarios',
	'usermerge-desc' => "[[Special:UserMerge|Fusiona referencias de un usuario a otro usuario]] en la base de datos wiki - borrará también usuarios antiguos en la siguiente fusión. requiere ''usermerge'' privilegios",
	'usermerge-badolduser' => 'Nombre de usuario antiguo inválido',
	'usermerge-badnewuser' => 'Nombre de usuario nuevo inválido',
	'usermerge-nonewuser' => 'Vaciar nuevo nombre de usuario - asumiendo que fue fusionado a $1.<br />
Haga Click en "{{int:usermerge-submit}}" para aceptar.',
	'usermerge-noolduser' => 'Vaciar antiguo nombre de usuario',
	'usermerge-fieldset' => 'Nombres de usuario a fusionar',
	'usermerge-olduser' => 'Antiguo usuario (fusionar de):',
	'usermerge-newuser' => 'Nuevo usuario (fusionar a):',
	'usermerge-deleteolduser' => 'Borrar antiguo usuario',
	'usermerge-submit' => 'Fusionar usuario',
	'usermerge-badtoken' => 'Ficha de edición inválida',
	'usermerge-userdeleted' => '$1 ($2) ha sido borrado.',
	'usermerge-userdeleted-log' => 'Usuario borrado: $2 ($3)',
	'usermerge-updating' => 'Actualizando $1 tabla ($2 to $3)',
	'usermerge-success' => 'Fusión de $1 ($2) a $3 ($4) está completada.',
	'usermerge-success-log' => 'Usuario $2 ($3) fusionado a $4 ($5)',
	'usermerge-logpage' => 'Registro de fusiones del usuario',
	'usermerge-logpagetext' => 'Este es un registro de acciones de fusión de usuarios.',
	'usermerge-noselfdelete' => 'Usted no puede borrarse o fusionarse a sí mismo!',
	'usermerge-unmergable' => 'Incapaz de fusionar de usuario - ID o nombre ha sido definido como no fusionable.',
	'usermerge-protectedgroup' => 'Incapaz de fusionar de usuario - Usuario está en un grupo protegido.',
	'right-usermerge' => 'Fusionar usuarios',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'usermerge-badolduser' => 'Vigane vana kasutajanimi',
	'usermerge-badnewuser' => 'Vigane uus kasutajanimi',
	'usermerge-userdeleted' => '$1 ($2) on kustutatud.',
	'usermerge-logpage' => 'Kasutaja ühendamislogi',
	'usermerge-logpagetext' => 'See on kasutajaühendamistoimingute logi.',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Theklan
 */
$messages['eu'] = array(
	'usermerge-badolduser' => 'Baliogabeko lankide izen zaharra',
	'usermerge-badnewuser' => 'Baliogabeko lankide izen berria',
	'usermerge-noolduser' => 'Lankide izen zahar hutsa',
	'usermerge-olduser' => 'Lankide zaharra (nondik batu):',
	'usermerge-newuser' => 'Lankide berria (nora batu):',
	'usermerge-deleteolduser' => 'Ezabatu lankide zaharra',
	'usermerge-submit' => 'Lankidea batu',
	'usermerge-badtoken' => 'Aldaketa token ez baliagarria',
	'usermerge-userdeleted' => '$1 ($2) ezabatua izan da.',
	'usermerge-userdeleted-log' => 'Ezabatutako lankidea: $2 ($3)',
	'usermerge-updating' => '$1 taula berritzen ($2(e)tik $3(e)ra)',
	'usermerge-success' => '$1(e)tik ($2) $3(e)ra ($4) batzea burutu da.',
	'usermerge-success-log' => '$2 ($3) lankidea $4 ($5) lankidera batu da',
	'usermerge-logpage' => 'Lankide batze loga',
	'usermerge-logpagetext' => 'Log hau lankide batze ekintzena da.',
	'usermerge-noselfdelete' => 'Ezin duzu zure burua ezabatu edo batu!',
	'right-usermerge' => 'Lankideak bateratu',
);

/** Persian (فارسی)
 * @author BlueDevil
 * @author Huji
 * @author Meisam
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'usermerge' => 'یکی کردن و حذف کردن کاربران',
	'usermerge-badolduser' => 'نام کاربری قدیمی نامعتبر',
	'usermerge-badnewuser' => 'نام کاربری جدید نامعتبر',
	'usermerge-noolduser' => 'نام کاربری قدیمی خالی',
	'usermerge-olduser' => 'کاربر قدیمی (ادغام از)',
	'usermerge-newuser' => 'کاربر جدید (ادغام با):',
	'usermerge-deleteolduser' => 'کاربر قدیمی حذف شود؟',
	'usermerge-submit' => 'یکی کردن کاربر',
	'usermerge-userdeleted' => '$1 ($2) پاک شد.',
	'usermerge-logpage' => 'سیاههٔ ادغام کاربر',
	'right-usermerge' => 'ادغام حساب‌های کاربری',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'usermerge' => 'Käyttäjätunnusten yhdistys ja poisto',
	'usermerge-badolduser' => 'Vanha käyttäjätunnus ei kelpaa',
	'usermerge-badnewuser' => 'Uusi käyttäjätunnus ei kelpaa',
	'usermerge-nonewuser' => 'Uusi käyttäjätunnus -kenttä on tyhjä - oletetaan yhdistäminen tunnukseen "$1". <br /> 
Napsauta "{{int:usermerge-submit}}" hyväksyäksesi.',
	'usermerge-noolduser' => 'Vanha käyttäjätunnus ei voi olla tyhjä.',
	'usermerge-fieldset' => 'Yhdistettävät käyttäjänimet',
	'usermerge-olduser' => 'Vanha käyttäjä (mikä yhdistetään)',
	'usermerge-newuser' => 'Uusi käyttäjä (mihin yhdistetään)',
	'usermerge-deleteolduser' => 'Poista vanha käyttäjä',
	'usermerge-submit' => 'Yhdistä käyttäjä',
	'usermerge-badtoken' => 'Virheellinen muokkauslipuke',
	'usermerge-userdeleted' => '$1 ($2) on poistettu.',
	'usermerge-userdeleted-log' => 'Poistettiin käyttäjä: $2 ($3)',
	'usermerge-updating' => 'Päivitetään taulukko $1 ($2 arvoon $3)',
	'usermerge-success' => 'Yhdistäminen tunnuksesta $1 ($2) tunnukseen $3 ($4) on suoritettu.',
	'usermerge-success-log' => 'Käyttäjä $2 ($3) yhdistettiin käyttäjään $4 ($5)',
	'usermerge-logpage' => 'Käyttäjien yhdistämisloki',
	'usermerge-logpagetext' => 'Tämä on loki käyttäjätunnuksien yhdistämistoimista.',
	'usermerge-noselfdelete' => 'Et voi poistaa tai yhdistää itseltäsi.',
	'usermerge-protectedgroup' => 'Ei voi yhdistää käyttäjänimestä - käyttäjänimi kuuluu suojattuun ryhmään.',
	'right-usermerge' => 'Yhdistää käyttäjiä',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author Guillom
 * @author IAlex
 * @author McDutchie
 * @author PieRRoMaN
 * @author Seb35
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'usermerge' => 'Fusionner et supprimer des utilisateurs',
	'usermerge-desc' => "[[Special:UserMerge|Fusionne les références d’un utilisateur vers un autre]] dans la base de données wiki - supprimera aussi les anciens utilisateurs après la fusion. Nécessite le privilège ''usermerge''",
	'usermerge-badolduser' => 'Ancien nom d’utilisateur invalide',
	'usermerge-badnewuser' => 'Nouveau nom d’utilisateur invalide',
	'usermerge-nonewuser' => 'Nouveau nom d’utilisateur vide. Nous faisons l’hypothèse que vous voulez fusionner dans « $1 ».<br />
Cliquez sur « {{int:usermerge-submit}} » pour accepter.',
	'usermerge-noolduser' => 'Ancien nom d’utilisateur vide',
	'usermerge-fieldset' => 'Noms d’utilisateur à fusionner',
	'usermerge-olduser' => 'Ancien utilisateur (fusionner depuis) :',
	'usermerge-newuser' => 'Nouvel utilisateur (fusionner avec) :',
	'usermerge-deleteolduser' => 'Supprimer l’ancien utilisateur',
	'usermerge-submit' => 'Fusionner l’utilisateur',
	'usermerge-badtoken' => 'Jeton de modification invalide',
	'usermerge-userdeleted' => '$1 ($2) a été supprimé.',
	'usermerge-userdeleted-log' => 'Contributeur supprimé : $2 ($3)',
	'usermerge-updating' => 'Mise à jour de la table $1 (de $2 à $3)',
	'usermerge-success' => 'La fusion de $1 ($2) à $3 ($4) est terminée.',
	'usermerge-success-log' => 'Utilisateur $2 ($3) fusionné avec $4 ($5)',
	'usermerge-logpage' => 'Journal des fusions de comptes utilisateur',
	'usermerge-logpagetext' => 'Voici un journal des actions de fusions d’utilisateurs.',
	'usermerge-noselfdelete' => 'Vous ne pouvez pas vous supprimer ou vous fusionner vous-même !',
	'usermerge-unmergable' => 'Impossible de fusionner l’utilisateur : le numéro ou le nom a été défini comme non fusionnable.',
	'usermerge-protectedgroup' => 'Impossible de fusionner l’utilisateur : l’utilisateur est dans un groupe protégé.',
	'right-usermerge' => 'Fusionner des utilisateurs',
	'usermerge-editcount' => 'Ajouter le compteur d’éditions ?',
	'usermerge-editcount-success' => 'Ajout du compteur d’éditions de ($1 et $2)',
	'usermerge-autopagedelete' => 'Supprimé automatiquement lors de la fusion de utilisateurs',
	'usermerge-page-unmoved' => 'Cette page $1 ne peut pas être déplacée vers $2.',
	'usermerge-page-moved' => 'La page $1 a été déplacée vers $2.',
	'usermerge-move-log' => 'Page déplacée automatiquement lors de la fusion de l’utilisateur « [[User:$1|$1]] » en « [[User:$2|$2]] »',
	'usermerge-page-deleted' => 'Page $1 effacée',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'usermerge' => 'Fusionar et suprimar des usanciérs',
	'usermerge-badolduser' => 'Viely nom d’usanciér envalido',
	'usermerge-badnewuser' => 'Novél nom d’usanciér envalido',
	'usermerge-noolduser' => 'Viely nom d’usanciér vouedo',
	'usermerge-fieldset' => 'Noms d’usanciér a fusionar',
	'usermerge-olduser' => 'Viely usanciér (fusionar dês) :',
	'usermerge-newuser' => 'Novél usanciér (fusionar avouéc) :',
	'usermerge-deleteolduser' => 'Suprimar lo viely usanciér',
	'usermerge-submit' => 'Fusionar l’usanciér',
	'usermerge-badtoken' => 'Jeton de changement envalido',
	'usermerge-userdeleted' => '$1 ($2) at étâ suprimâ.',
	'usermerge-userdeleted-log' => 'Contributor suprimâ : $2 ($3)',
	'usermerge-updating' => 'Misa a jorn de la trâbla $1 (de $2 a $3)',
	'usermerge-success' => 'La fusion de $1 ($2) a $3 ($4) est chavonâ.',
	'usermerge-success-log' => 'Usanciér $2 ($3) fusionâ avouéc $4 ($5)',
	'usermerge-logpage' => 'Jornal de les fusions d’usanciérs',
	'usermerge-logpagetext' => 'O est un jornal de les accions de fusions d’usanciérs.',
	'usermerge-noselfdelete' => 'Vos vos pouede pas suprimar ou ben fusionar vos-mémo !',
	'usermerge-unmergable' => 'Empossiblo de fusionar l’usanciér : lo numerô ou ben lo nom at étâ dèfeni coment pas fusionâblo.',
	'usermerge-protectedgroup' => 'Empossiblo de fusionar l’usanciér : l’usanciér est dens una tropa protègiê.',
	'right-usermerge' => 'Fusionar des usanciérs',
	'usermerge-editcount' => 'Apondre lo comptor de changements ?',
	'usermerge-editcount-success' => 'Aponsa du comptor de changements de ($1 et $2)',
	'usermerge-autopagedelete' => 'Suprimâ ôtomaticament pendent la fusion d’usanciérs',
	'usermerge-page-unmoved' => 'La pâge $1 pôt pas étre dèplaciê vers $2.',
	'usermerge-page-moved' => 'La pâge $1 at étâ dèplaciê vers $2.',
	'usermerge-move-log' => 'Pâge dèplaciê ôtomaticament pendent la fusion de l’usanciér « [[User:$1|$1]] » en « [[User:$2|$2]] »',
	'usermerge-page-deleted' => 'Pâge suprimâ $1',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'usermerge-userdeleted-log' => 'Úsáideoir scriosta: $2 ($3)',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'usermerge' => 'Fusionar e eliminar usuario',
	'usermerge-desc' => "[[Special:UserMerge|Fusiona as referencias dun usuario noutro usuario]] na base de datos do wiki (tamén borrará as fusións vellas dos usuarios seguintes. Require privilexios ''usermerge'')",
	'usermerge-badolduser' => 'Antigo nome de usuario non válido',
	'usermerge-badnewuser' => 'Novo nome de usuario non válido',
	'usermerge-nonewuser' => 'Nome de usuario baleiro (asúmese que quere fusionalo con "$1").<br />
Prema en "{{int:usermerge-submit}}" para aceptar.',
	'usermerge-noolduser' => 'Antigo nome de usuario baleiro',
	'usermerge-fieldset' => 'Nomes de usuario a fusionar',
	'usermerge-olduser' => 'Usuario antigo (fusionar desde):',
	'usermerge-newuser' => 'Usuario novo (fusionar con):',
	'usermerge-deleteolduser' => 'Borrar o usuario antigo',
	'usermerge-submit' => 'Fusionar o usuario',
	'usermerge-badtoken' => 'Sinal de edición non válido',
	'usermerge-userdeleted' => '$1 ($2) foi eliminado.',
	'usermerge-userdeleted-log' => 'Usuario eliminado: $2 ($3)',
	'usermerge-updating' => 'Actualizando táboa $1 ($2 a $3)',
	'usermerge-success' => 'A fusión desde $1 ($2) a $3 ($4) foi completada.',
	'usermerge-success-log' => 'Usuario $2 ($3) fusionado con $4 ($5)',
	'usermerge-logpage' => 'Rexistro de fusión de usuarios',
	'usermerge-logpagetext' => 'Este é un rexistro das accións de fusión de usuarios.',
	'usermerge-noselfdelete' => 'Non se pode eliminar ou fusionar a si mesmo!',
	'usermerge-unmergable' => 'Non se pode fusionar o usuario (o ID ou o nome foron definidos como "non fusionables").',
	'usermerge-protectedgroup' => 'Non se pode fusionar o usuario (o usuario está nun frupo protexido).',
	'right-usermerge' => 'Fusionar usuarios',
	'usermerge-editcount' => 'Quere engadir o contador de edicións?',
	'usermerge-editcount-success' => 'Engadindo o contador de edicións de ($1 e $2)',
	'usermerge-autopagedelete' => 'Borrada automaticamente ao fusionar os usuarios',
	'usermerge-page-unmoved' => 'A páxina "$1" non pode ser movida a "$2".',
	'usermerge-page-moved' => 'A páxina "$1" foi movida a "$2".',
	'usermerge-move-log' => 'A páxina moveuse automaticamente cando se fusionou o usuario "[[User:$1|$1]]" con "[[User:$2|$2]]"',
	'usermerge-page-deleted' => 'A páxina "$1" foi borrada',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'usermerge-badtoken' => 'Ἄκυρον δεῖγμα μεταγραφῆς',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'usermerge' => 'Benutzerkonte zämmefiere un lesche',
	'usermerge-desc' => "[[Special:UserMerge|Fiert Benutzerkonte in dr Wiki-Datebank zämme]] - s alt Benutzerkonto wird no dr Zämmefierig glescht. Bruucht s ''usermerge''-Rächt.",
	'usermerge-badolduser' => 'Uugiltiger alter Benutzername',
	'usermerge-badnewuser' => 'Uugiltiger nejer Benutzername',
	'usermerge-nonewuser' => 'Läärer nejer Benutzername - s wird e Zämmefierig mit „$1“ vermuetet.<br />
Klick uf "{{int:usermerge-submit}}" go s Uusfiere.',
	'usermerge-noolduser' => 'Läärer alter Benutzername',
	'usermerge-fieldset' => 'Benutzernäme, wu solle zämmegfiert wäre',
	'usermerge-olduser' => 'Alter Benutzername (zämmefiere vu):',
	'usermerge-newuser' => 'Nejer Benutzername (zämmefiere noch):',
	'usermerge-deleteolduser' => 'Alte Benutzername lesche',
	'usermerge-submit' => 'Benutzerkonte zämmefiere',
	'usermerge-badtoken' => 'Uugiltig Bearbeite-Token',
	'usermerge-userdeleted' => '„$1“ ($2) isch glescht wore.',
	'usermerge-userdeleted-log' => 'Gleschter Benutzername: „$2“ ($3)',
	'usermerge-updating' => 'Aktualisierig $1 Tabälle ($2 noch $3)',
	'usermerge-success' => 'D Zämmefierig vu „$1“ ($2) noch „$3“ ($4) isch vollständig.',
	'usermerge-success-log' => 'Benutzername „$2“ ($3) zämmegfiert mit „$4“ ($5)',
	'usermerge-logpage' => 'Benutzerkonte-Zämmefierigs-Logbuech',
	'usermerge-logpagetext' => 'Des isch s Logbuech vu dr Benutzerkonte-Zämmefierige.',
	'usermerge-noselfdelete' => 'Zämmefierig mit sich sälber isch nit megli!',
	'usermerge-unmergable' => 'Zämmefierig nit megli - ID oder Benutzername isch nit as zämmefierbar definiert.',
	'usermerge-protectedgroup' => 'Zämmefierig nit megli - Benutzername isch in ere gschitze Gruppe.',
	'right-usermerge' => 'Benutzerkonte zämmefiere',
	'usermerge-editcount' => 'Bearbeitigszääler dezuefiege?',
	'usermerge-editcount-success' => 'Dezuefiege vum Bearbeitigszääler ($1 un $2)',
	'usermerge-autopagedelete' => 'Derwyylischt de Benutzerchontezämmefierig automatisch glöscht',
	'usermerge-page-unmoved' => 'D Syte „$1“ het nüt chönne uf „$2“ verschobe werde.',
	'usermerge-page-moved' => 'D Syte „$1“ isch uff „$2“ verschobe worde.',
	'usermerge-move-log' => 'Dur d Benutzerchontezämmefierig vu „[[User:$1|$1]]“ noch „[[User:$2|$2]]“ automatisch verschobeni Syte',
	'usermerge-page-deleted' => 'Gleschti Syte $1',
);

/** Gujarati (ગુજરાતી)
 * @author Ashok modhvadia
 */
$messages['gu'] = array(
	'usermerge' => 'સભ્યોને ભેળવો અને રદ કરો',
	'usermerge-badolduser' => 'અમાન્ય જુનું સભ્યનામ',
	'usermerge-badnewuser' => 'અમાન્ય નવું સભ્યનામ',
	'usermerge-noolduser' => 'જુનું સભ્યનામ ખાલી કરો',
	'usermerge-fieldset' => 'ભેળવવા માટેનાં સભ્યનામો',
	'usermerge-submit' => 'સભ્ય ભેળવો',
	'right-usermerge' => 'સભ્યો ભેળવો',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'usermerge' => 'מיזוג ומחיקת משתמשים',
	'usermerge-desc' => "[[Special:UserMerge|מיזוג התייחסויות ממשתמש אחד לאחר]] בבסיס הנתונים של הוויקי, כולל מחיקת המשתמשים הישנים לאחר המיזוג. נדרשת הרשאת ''usermerge''",
	'usermerge-badolduser' => 'שם המשתמש הישן אינו תקין',
	'usermerge-badnewuser' => 'שם המשתמש החדש אינו תקין',
	'usermerge-nonewuser' => 'שם המשתמש החדש ריק - כנראה שהמיזוג הוא ל־"$1".<br />
לחצו על "{{int:usermerge-submit}}" לאישור.',
	'usermerge-noolduser' => 'שם המשתמש הישן ריק',
	'usermerge-fieldset' => 'שמות משתמש למיזוג',
	'usermerge-olduser' => 'משתמש ישן (מיזוג מ):',
	'usermerge-newuser' => 'משתמש חדש (מיזוג ל):',
	'usermerge-deleteolduser' => 'מחיקת משתמש ישן',
	'usermerge-submit' => 'מיזוג משתמש',
	'usermerge-badtoken' => 'אסימון עריכה שגוי.',
	'usermerge-userdeleted' => '$1 ($2) נמחק.',
	'usermerge-userdeleted-log' => 'המשתמש נמחק: $2 ($3)',
	'usermerge-updating' => 'בתהליך עדכון הטבלה $1 ($2 ל$3)',
	'usermerge-success' => 'המיזוג מ$1 ($2) ל$3 ($4) הושלם.',
	'usermerge-success-log' => 'המשתמש $2 ($3) מוזג ל$4 ($5)',
	'usermerge-logpage' => 'יומן מיזוג משתמשים',
	'usermerge-logpagetext' => 'זהו יומן של פעולות מיזוג המשתמשים.',
	'usermerge-noselfdelete' => 'לא ניתן למחוק או למזג מעצמך!',
	'usermerge-unmergable' => 'לא ניתן למזג ממשתמש זה - מספר המשתמש או השם כבר מוגדר כבלתי ניתן למיזוג.',
	'usermerge-protectedgroup' => 'לא ניתן למזג ממשתמש זה - המשתמש נמצא בקבוצה מוגנת.',
	'right-usermerge' => 'מיזוג משתמשים',
	'usermerge-editcount' => 'להוסיף מונה עריכות?',
	'usermerge-editcount-success' => 'הוספת מונה עריכות של ($1&rlm;, $2)',
	'usermerge-autopagedelete' => 'נמחק אוטומטית בזמן מיזוג חשבונות',
	'usermerge-page-unmoved' => 'לא ניתן להעביר את הדף $1 לשם $2.',
	'usermerge-page-moved' => 'הדף $1 הועבר לשם $2.',
	'usermerge-move-log' => 'הדף הועבר אוטומטית בזמן מיזוג חשבון "[[User:$1|$1]]" אל "[[User:$2|$2]]"',
	'usermerge-page-deleted' => 'הדף $1 נמחק',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'usermerge-badtoken' => 'गलत एडिट टोकन',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'usermerge' => 'Wužiwarske konta zjednoćić a zničić',
	'usermerge-desc' => "[[Special:UserMerge|Zjednoća referency wužiwarjow]] we wikowej datowej bance - stare wužiwarske konto so po zjednoćenju wušmórnje. Žada sej prawa ''usermerge''.",
	'usermerge-badolduser' => 'Njepłaćiwe stare wužiwarske mjeno',
	'usermerge-badnewuser' => 'Njepłaćiwe nowe wužiwarske mjeno',
	'usermerge-nonewuser' => 'Falowace nowe wužiwarske mjeno - najskerje zjednoćenje do "$1".<br />
Klikń na "{{int:usermerge-submit}}", zo by akceptował.',
	'usermerge-noolduser' => 'Falowace stare wužiwarske mjeno',
	'usermerge-fieldset' => 'Wužiwarskej mjenje, kotrejž matej so zjednoćić',
	'usermerge-olduser' => 'Stary wužiwar (zjednoćić wot):',
	'usermerge-newuser' => 'Nowy wužiwar (zjednoćić do):',
	'usermerge-deleteolduser' => 'Stare wužiwarske mjeno zničić',
	'usermerge-submit' => 'Wužiwarske konta zjednoćić',
	'usermerge-badtoken' => 'Njepłaćiwe wobdźěłanske znamjo',
	'usermerge-userdeleted' => '$1($2) bu zničeny.',
	'usermerge-userdeleted-log' => 'Wušmórnjeny wužiwar: $2($3)',
	'usermerge-updating' => '$1 tabela so aktualizuje ($2 do $3)',
	'usermerge-success' => 'Zjednoćenje wot $1($2) do $3($4) je dokónčene.',
	'usermerge-success-log' => 'Wužiwar $2($3) je so z $4 ($5) zjednoćił',
	'usermerge-logpage' => 'Protokol wužiwarskich zjednoćenjow',
	'usermerge-logpagetext' => 'To je protokol wužiwarskich zjednoćenjow.',
	'usermerge-noselfdelete' => 'Njemóžeš sam wušmórnyć abo zjednoćić!',
	'usermerge-unmergable' => 'Zjednoćenje wužiwarjow njemóžno - ID abo wužiwarske mjeno bu jako njezjednoćujomne definowane.',
	'usermerge-protectedgroup' => 'Zjednoćenje wužiwarjow njemóžno - wužiwar je w škitanej skupinje',
	'right-usermerge' => 'Wužiwarjow zjednoćić',
	'usermerge-editcount' => 'Ličenje změnow přidać?',
	'usermerge-editcount-success' => 'Přidawanje ličenja změnow ($1 a $2)',
	'usermerge-autopagedelete' => 'Při zjednoćenju wužiwarjow awtomatisce zhašany',
	'usermerge-page-unmoved' => 'Strona $1 njeda so do $2 přesunyć.',
	'usermerge-page-moved' => 'Strona $1 bu do $2 přesunjena.',
	'usermerge-move-log' => 'Strona za zjednoćenje wužiwarja "[[User:$1|$1]]" z "[[User:$2|$2]]" awtomatisce přesunjena',
	'usermerge-page-deleted' => 'Zhašana strona $1',
);

/** Haitian (Kreyòl ayisyen)
 * @author Boukman
 * @author Masterches
 */
$messages['ht'] = array(
	'usermerge' => 'Mete ansanm ak efase kont itilizatè yo',
	'usermerge-desc' => "[[Special:UserMerge|Mèt ansanm referans yo depi yon itilizatè nan referans yon lòt itilizatè]] nan baz done wiki a - l ap efase tou vye non itilizatè yo apre fizyon fin fèt. Ou bezwen genyen dwa ''usermerge'' pou fè fizyon sa.",
	'usermerge-badolduser' => 'Ansyen non itilizatè a pa bon.',
	'usermerge-badnewuser' => 'Nouvo non itilizatè a pa bon.',
	'usermerge-nonewuser' => 'Nouvo non itilizatè ki vid - nou kwè ou vle mete l ansanm ak $1.<br />
Klike "{{int:usermerge-submit}}" pou aksepte operasyon an.',
	'usermerge-noolduser' => 'Ansyen non itilizatè a vid',
	'usermerge-olduser' => 'Ansyen non itilizatè (mete ansanm depi)',
	'usermerge-newuser' => 'Nouvo non itilizatè (mete ansanm ak)',
	'usermerge-deleteolduser' => 'Efase ansyen non itilizatè a',
	'usermerge-submit' => 'Mèt ansanm kont itilizatè yo',
	'usermerge-badtoken' => 'Tikè pou modifikasyon pa bon',
	'usermerge-userdeleted' => '$1 ($2) efase.',
	'usermerge-userdeleted-log' => 'Non itilizatè ki efase a: $2 ($3)',
	'usermerge-updating' => 'Mete ajou tablo $1 (depi $2 jouk $3)',
	'usermerge-success' => 'Nou rive mèt ansanm $1 ($2) ak $3 ($4), depi premye kont an.',
	'usermerge-success-log' => 'Itilizatè $2 ($3) fizyone ak $4 ($5)',
	'usermerge-logpage' => 'Jounal pou fizyon kont itilizatè',
	'usermerge-logpagetext' => 'Men jounal ki dekri tout aksyon ki te fèt pou fizyon kont itilizatè yo.',
	'usermerge-noselfdelete' => 'Ou pa kapab efase tèt ou oubyen fizyone tèt ou.',
	'usermerge-unmergable' => 'Nou pa kapab mèt ansanm kont sa yo - ID an oubyen non an pa kapab mete ansanm, li sanble l make nan definisyon yo.',
	'usermerge-protectedgroup' => 'Nou pa kapab mèt ansanm kont itilizatè yo - itilizatè sa a nan yon gwoup ki pwoteje.',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'usermerge' => 'Felhasználói fiókok összevonása és törlése',
	'usermerge-desc' => "[[Special:UserMerge|Beolvasztja egy felhasználó közreműködéseit egy másikéba]] a wiki adatbázisában, majd törli a beolvasztott felhasználói fiókot. ''Szerkesztők egyesítése'' jogosultság kell hozzá",
	'usermerge-badolduser' => 'Érvénytelen régi felhasználói név',
	'usermerge-badnewuser' => 'Érvénytelen új felhasználói név',
	'usermerge-nonewuser' => 'Üres új felhasználónév – feltételezett cél: „$1”<br />
Kattints a „{{int:usermerge-submit}}”-ra az elfogadáshoz.',
	'usermerge-noolduser' => 'A régi felhasználói név üres',
	'usermerge-fieldset' => 'Összevonandó felhasználói nevek',
	'usermerge-olduser' => 'Régi felhasználói név (honnan):',
	'usermerge-newuser' => 'Új felhasználói név (hová):',
	'usermerge-deleteolduser' => 'Régi felhasználói fiók törlése',
	'usermerge-submit' => 'Felhasználói fiók összevonása',
	'usermerge-badtoken' => 'Érvénytelen szerkesztési token',
	'usermerge-userdeleted' => '„$1” ($2) törölve.',
	'usermerge-userdeleted-log' => 'Törölt felhasználó: $2 ($3)',
	'usermerge-updating' => '$1 tábla frissítése ($2 → $3)',
	'usermerge-success' => '„$1” ($2) fiók beolvasztása a(z) „$3” ($4) felhasználói fiókba elkészült.',
	'usermerge-success-log' => '„$2” ($3) felhasználó beolvasztva a(z) „$4” ($5) felhasználói fiókba',
	'usermerge-logpage' => 'Felhasználói nevek egyesítésének naplója',
	'usermerge-logpagetext' => 'Ez a felhasználó nevek összevonásának naplója.',
	'usermerge-noselfdelete' => 'Nem tudsz törölni vagy összevonni a saját fiókodból!',
	'usermerge-unmergable' => 'Nem lehetséges beolvasztani a felhasználói fiókot – az azonosító vagy a név be van jelölve összevonhatatlannak.',
	'usermerge-protectedgroup' => 'Nem lehetséges beolvasztani a felhasználói fiókot – a felhasználó védett csoportban van.',
	'right-usermerge' => 'szerkesztők egyesítése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'usermerge' => 'Fusionar e deler usatores',
	'usermerge-desc' => "[[Special:UserMerge|Fusiona le referentias ab un usator verso un altere usator]] in le base de datos wiki - delera equalmente le ancian usatores post le fusion. Require le privilegio ''usermerge''",
	'usermerge-badolduser' => 'Nomine de usator ancian invalide',
	'usermerge-badnewuser' => 'Nomine de nove usator invalide',
	'usermerge-nonewuser' => 'Nomine de nove usator vacue; nos assume un fusion con $1.<br />
Clicca "{{int:usermerge-submit}}" pro acceptar.',
	'usermerge-noolduser' => 'Nomine de usator ancian vacue',
	'usermerge-fieldset' => 'Nomines de usator a fusionar',
	'usermerge-olduser' => 'Ancian usator (fusionar ab):',
	'usermerge-newuser' => 'Nove usator (fusionar con):',
	'usermerge-deleteolduser' => 'Deler ancian usator',
	'usermerge-submit' => 'Fusionar usator',
	'usermerge-badtoken' => 'Indicio de modification invalide',
	'usermerge-userdeleted' => '$1 ($2) ha essite delite.',
	'usermerge-userdeleted-log' => 'Usator delite: $2 ($3)',
	'usermerge-updating' => 'Actualisa le tabella $1 (de $2 a $3)',
	'usermerge-success' => 'Le fusion de $1 ($2) a $3 ($4) es complete.',
	'usermerge-success-log' => 'Usator $2 ($3) fusionate con $4 ($5)',
	'usermerge-logpage' => 'Registro de fusiones de usatores',
	'usermerge-logpagetext' => 'Isto es un registro de actiones de fusion de usatores.',
	'usermerge-noselfdelete' => 'Tu non pote deler o fusionar ab te mesme!',
	'usermerge-unmergable' => 'Impossibile fusionar ab iste usator - le ID o nomine ha essite definite como non fusionabile.',
	'usermerge-protectedgroup' => 'Impossibile fusionar ab iste usator - le usator es membro de un gruppo protegite.',
	'right-usermerge' => 'Fusionar usatores',
	'usermerge-editcount' => 'Adder numero de modificationes?',
	'usermerge-editcount-success' => 'Es addite le numero de modificationes de ($1 e $2)',
	'usermerge-autopagedelete' => 'Automaticamente delite durante le fusion de usatores',
	'usermerge-page-unmoved' => 'Le pagina $1 non poteva esser renominate a $2.',
	'usermerge-page-moved' => 'Le pagina $1 ha essite renominate a $2.',
	'usermerge-move-log' => 'Le pagina ha essite automaticamente renominate con le fusion del usator "[[User:$1|$1]]" in "[[User:$2|$2]]"',
	'usermerge-page-deleted' => 'Pagina $1 delite',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'usermerge' => 'Penggabungan dan penghapusan Pengguna',
	'usermerge-desc' => "[[Special:UserMerge|Menggabungkan rekam jejak dari suatu pengguna ke pengguna lain]] di basis data wiki - sekaligus menghapus pengguna lama setelah selesai digabungkan. Tindakan ini memerlukan hak ''usermerge''.",
	'usermerge-badolduser' => 'Nama pengguna lama tidak sah',
	'usermerge-badnewuser' => 'Nama pengguna baru tidak sah',
	'usermerge-nonewuser' => 'Nama pengguna baru tidak dituliskan - diasumsikan akan digabungkan ke "$1".<br />
Klik "{{int:usermerge-submit}}" untuk melanjutkan.',
	'usermerge-noolduser' => 'Nama pengguna lama tidak diisi',
	'usermerge-fieldset' => 'Akun-akun pengguna yang akan digabungkan',
	'usermerge-olduser' => 'Pengguna lama (digabungkan dari):',
	'usermerge-newuser' => 'Pengguna baru (digabungkan ke):',
	'usermerge-deleteolduser' => 'Hapus pengguna lama',
	'usermerge-submit' => 'Gabungkan pengguna',
	'usermerge-badtoken' => 'Token penyuntingan tidak sah',
	'usermerge-userdeleted' => '$1 ($2) telah dihapuskan.',
	'usermerge-userdeleted-log' => 'Pengguna telah dihapuskan: $2 ($3)',
	'usermerge-updating' => 'Memperbaharui tabel $1 ($2 hingga $3)',
	'usermerge-success' => '$1 ($2) telah selesai digabungkan ke $3 ($4).',
	'usermerge-success-log' => 'Pengguna $2 ($3) telah digabungkan ke $4 ($5)',
	'usermerge-logpage' => 'Log penggabungan pengguna',
	'usermerge-logpagetext' => 'Ini adalah catatan tindakan penggabungan pengguna.',
	'usermerge-noselfdelete' => 'Anda tidak dapat menghapus atau menggabungkan dari Anda sendiri!',
	'usermerge-unmergable' => 'Tidak dapat menggabungkan dari pengguna ini - nomor ID atau nama akun ini telah ditandai sebagai akun yang tidak dapat digabungkan.',
	'usermerge-protectedgroup' => 'Tidak dapat menggabungkan dari pengguna ini - pengguna ini termasuk dalam kelompok terproteksi.',
	'right-usermerge' => 'Menggabungkan pengguna',
);

/** Interlingue (Interlingue)
 * @author Renan
 */
$messages['ie'] = array(
	'usermerge' => 'Fuser se e deleter usatores',
	'usermerge-desc' => "[[Special:UserMerge|Referenties de fusion de un usator por altri usator]] in li funde de data del wiki - anc va deleter usatores antiqui succedent fusion. Exige avantages de ''fusion de usator''",
	'usermerge-badolduser' => 'Antiqui nómine de usator ínvalid',
	'usermerge-badnewuser' => 'Nov nómine de usator ínvalid',
	'usermerge-nonewuser' => 'Nov nómine de usator vacui - acceptant fusion por "$1".<br />
Clacca "{{int:usermerge-submit}}" por acceptar.',
	'usermerge-noolduser' => 'Antiqui nómine de usator vacui',
	'usermerge-fieldset' => 'Nómines de usator por fusion',
	'usermerge-olduser' => 'Antiqui usator (fuser se de):',
	'usermerge-newuser' => 'Nov usator (fuser se por):',
	'usermerge-deleteolduser' => 'Deleter usator antiqui',
	'usermerge-submit' => 'Fuser usator',
	'usermerge-badtoken' => 'Simbol de redaction ínvalid',
	'usermerge-userdeleted' => '$1 ($2) ha esset deletet.',
	'usermerge-userdeleted-log' => 'Usator deletet: $2 ($3)',
	'usermerge-updating' => 'Modernisant tabelle $1 ($2 por $3)',
	'usermerge-success' => 'Fuser se de $1 ($2) por $3 ($4) es complet.',
	'usermerge-logpage' => 'Diarium de fusion de usator',
	'usermerge-logpagetext' => 'Ti es un diarium de actiones de fusion de usator.',
	'usermerge-noselfdelete' => 'Vu ne posse deleter o fuser se vu self!',
	'usermerge-unmergable' => 'Ne posse fuser se de ti usator - ID o nómine ha esset definit quam ínfusibil.',
	'usermerge-protectedgroup' => 'Ne posse fuser de ti usator - usator es in un gruppe protectet.',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Pietrodn
 */
$messages['it'] = array(
	'usermerge' => 'Unione e cancellazione utenti',
	'usermerge-desc' => "[[Special:UserMerge|Unisce i riferimenti di un utente con quelli di un altro]] nel database della wiki e inoltre cancellerà il vecchio utente dopo l'unione. Richiede privilegi ''usermerge''",
	'usermerge-badolduser' => 'Vecchio nome utente non valido',
	'usermerge-badnewuser' => 'Nuovo nome utente non valido',
	'usermerge-nonewuser' => 'Nuovo nome utente vuoto - l\'unione verrà effettuata con l\'utente "$1".<br />
Fare clic su "{{int:usermerge-submit}}" per accettare.',
	'usermerge-noolduser' => 'Vecchio nome utente vuoto',
	'usermerge-fieldset' => 'Nomi utente da unire',
	'usermerge-olduser' => 'Vecchio utente (unisci da):',
	'usermerge-newuser' => 'Nuovo utente (unisci a):',
	'usermerge-deleteolduser' => 'Cancella vecchio utente',
	'usermerge-submit' => 'Unisci utente',
	'usermerge-badtoken' => 'Edit token non valido',
	'usermerge-userdeleted' => '$1 ($2) è stato cancellato.',
	'usermerge-userdeleted-log' => 'Utente cancellato: $2 ($3)',
	'usermerge-updating' => 'Aggiornamento tabella $1 ($2 a $3)',
	'usermerge-success' => "L'unione di $1 ($2) a $3 ($4) è completa.",
	'usermerge-success-log' => 'Utente $2 ($3) unito a $4 ($5)',
	'usermerge-logpage' => 'Log unione utente',
	'usermerge-logpagetext' => 'Di seguito sono elencate le azioni di unione di utenti.',
	'usermerge-noselfdelete' => 'Non puoi cancellare o unire il tuo account!',
	'usermerge-unmergable' => "Impossibile unire da questo utente - l'ID o il nome è stato definito non unibile.",
	'usermerge-protectedgroup' => "Impossibile unire da questo utente - l'utente fa parte di un gruppo protetto.",
	'right-usermerge' => 'Unisce utenti',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author Mzm5zbC3
 */
$messages['ja'] = array(
	'usermerge' => '利用者の統合と削除',
	'usermerge-desc' => "ウィキデータベース上における[[Special:UserMerge|ある利用者を別の利用者へ統合し]]、また統合元の利用者を削除する(「{{int:right-usermerge}}」権限 ''usermerge'' が必要)",
	'usermerge-badolduser' => '無効な旧利用者名',
	'usermerge-badnewuser' => '無効な新利用者名',
	'usermerge-nonewuser' => '新しい利用者名の欄が空です。「$1」への統合と仮定します。<br />
「{{int:usermerge-submit}}」をクリックして承認してください。',
	'usermerge-noolduser' => '旧利用者名の欄が空です',
	'usermerge-fieldset' => '統合する利用者名',
	'usermerge-olduser' => '旧利用者 (統合元):',
	'usermerge-newuser' => '新利用者 (統合先):',
	'usermerge-deleteolduser' => '旧利用者を削除する',
	'usermerge-submit' => '利用者の統合',
	'usermerge-badtoken' => '編集トークンが不正',
	'usermerge-userdeleted' => '$1 ($2) は削除されました。',
	'usermerge-userdeleted-log' => '利用者: $2 ($3) を削除しました',
	'usermerge-updating' => '$1 のテーブルを更新 ($2 を $3 へ)',
	'usermerge-success' => '$1 ($2) の $3 ($4) への統合が完了しました。',
	'usermerge-success-log' => '利用者 $2 ($3) を $4 ($5) へ統合しました',
	'usermerge-logpage' => '利用者統合記録',
	'usermerge-logpagetext' => 'これは、利用者の統合を記録したものです。',
	'usermerge-noselfdelete' => 'あなたは、自身を統合あるいは削除することはできません。',
	'usermerge-unmergable' => '利用者を統合できません。IDまたは名前が統合不可能となっています。',
	'usermerge-protectedgroup' => '利用者を統合できません。この利用者は被保護グループに属しています。',
	'right-usermerge' => '利用者を統合する',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'usermerge' => 'Panggabungan lan pambusakan panganggo',
	'usermerge-desc' => "[[Special:UserMerge|Nggabungaké rèferènsi saka panganggo siji menyang liyané]] ing basis data wiki - bakal sekaligus mbusak panganggo lawas sawisé rampung panggabungan. Tindakan iki merlokaké hak ''usermerge''.",
	'usermerge-badolduser' => 'Jeneng panganggo lawas ora sah',
	'usermerge-badnewuser' => 'Jeneng panganggo anyar ora absah',
	'usermerge-nonewuser' => 'Jeneng panganggo kothong - dianggep bakal digabungaké menyang $1.<br />
Klik "{{int:usermerge-submit}}" kanggo nerusaké.',
	'usermerge-noolduser' => 'Jeneng panganggo sing lawas kosong',
	'usermerge-olduser' => 'Panganggo lawas (digabungaké saka):',
	'usermerge-newuser' => 'Panganggo anyar (digabungaké menyang):',
	'usermerge-deleteolduser' => 'Busak panganggo lawas',
	'usermerge-submit' => 'Gabung panganggo',
	'usermerge-badtoken' => 'Token panyuntingan ora absah',
	'usermerge-userdeleted' => '$1 ($2) wis dibusak.',
	'usermerge-userdeleted-log' => 'Panganggo dibusak: $2 ($3)',
	'usermerge-updating' => 'Nganyari tabèl $1 ($2 menyang $3)',
	'usermerge-success' => '$1 ($2) wis rampung digabungaké menyang $3 ($4).',
	'usermerge-success-log' => 'Panganggo $2 ($3) wis digabungaké menyang $4 ($5)',
	'usermerge-logpage' => 'Log panggabungan panganggo',
	'usermerge-logpagetext' => 'Iki sawijining log aksi panggabungan panganggo.',
	'usermerge-noselfdelete' => 'Panjenengan ora bisa mbusak utawa nggabung saka panjenengan dhéwé!',
	'usermerge-unmergable' => 'Ora bisa nggabungaké saka panganggo iki - nomer ID utawa jeneng akun iki wis ditandhani minangka akun sing ora bisa digabungaké.',
	'usermerge-protectedgroup' => 'Ora bisa nggabungaké saka panganggo iki - panganggo ana jroning klompok kareksa.',
	'right-usermerge' => 'Gabung panganggo',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'usermerge' => 'បញ្ចូលរួមគ្នានិង​លុបអ្នកប្រើប្រាស់',
	'usermerge-badolduser' => 'អត្តនាមចាស់មិនត្រឹមត្រូវទេ',
	'usermerge-badnewuser' => 'អត្តនាមថ្មីមិនត្រឹមត្រូវទេ',
	'usermerge-olduser' => 'អ្នកប្រើប្រាស់ចាស់(បញ្ចូលរួមគ្នាពី)៖',
	'usermerge-newuser' => 'អ្នកប្រើប្រាស់ថ្មី(បញ្ចូលរួមគ្នាទៅ)៖',
	'usermerge-deleteolduser' => 'លុបអ្នកប្រើប្រាស់ចាស់ចោល',
	'usermerge-submit' => 'បញ្ចូលរួមគ្នា អ្នកប្រើប្រាស់',
	'usermerge-userdeleted' => '$1 ($2) ត្រូវបានលុបហើយ។',
	'usermerge-userdeleted-log' => 'បានលុបអ្នកប្រើប្រាស់៖ $2($3)',
	'usermerge-updating' => 'បន្ទាន់សម័យ $1 តារាង ($2 to $3)',
	'usermerge-success' => 'ការបញ្ចូលរួមគ្នាពី$1($2)ទៅ$3($4)បានបញ្ចប់ដោយពេញលេញ។',
	'usermerge-success-log' => 'អ្នកប្រើប្រាស់ $2 ($3) បញ្ចូលរួមគ្នាទៅ $4 ($5)',
	'usermerge-logpage' => 'កំណត់ហេតុនៃការបញ្ចួលអ្នកប្រើប្រាស់រួមគ្នា',
	'usermerge-logpagetext' => 'នេះជាកំណត់ហេតុនៃសកម្មភាពបញ្ចូលអ្នកប្រើប្រាស់រួមគ្នា។',
	'usermerge-noselfdelete' => 'អ្នកមិនអាច លុបចេញ ឬ បញ្ចូលរួមគ្នា ពីខ្លួនអ្នកផ្ទាល់ !',
	'usermerge-protectedgroup' => 'មិនអាចបញ្ចូលអ្នកប្រើប្រាស់រួមគ្នាបានទេ - អ្នកប្រើប្រាស់ស្ថិតនៅក្នុងក្រុមដែលបានការពារ។',
	'right-usermerge' => 'បញ្ចូលអ្នកប្រើប្រាស់រួមគ្នា',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'usermerge' => '사용자 계정 병합 및 삭제',
	'usermerge-olduser' => '이전 사용자',
	'usermerge-deleteolduser' => '이전 계정을 삭제하기',
	'usermerge-submit' => '계정 합치기',
	'usermerge-userdeleted-log' => '$2 ($3) 사용자를 삭제함',
	'usermerge-success-log' => '$2 ($3) 사용자를 $4 ($5) 로 병합함',
	'usermerge-logpage' => '사용자 병합 기록',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'usermerge' => 'Metmaacher zosammelääje un fött schmiiße',
	'usermerge-desc' => '[[Special:UserMerge|Läät de Date fun einem Metmaacher met anem andere Metmaacher komplät zosamme]] en dem Wiki singe Datebank, un kann donoh och de övverhollte Metmaacher fottschmieße. Doför bruch mer et „{{int:right-usermerge}}“ Rääsch (<i lang="en">usermerge</i>)',
	'usermerge-badolduser' => 'Dä ahle Metmaachername es nit jöltesch',
	'usermerge-badnewuser' => 'Dä neue Metmaachername es nit jöltesch',
	'usermerge-nonewuser' => 'Keine neue Metmaachername aanjejovve. Mer vermoode, dat De met „$1“ zosamme lääje wells.<br />
Kleck op „{{int:usermerge-submit}}“ öm dat esu ze maache.',
	'usermerge-noolduser' => 'Keine ahle Metmaachername aanjejovve',
	'usermerge-fieldset' => 'De Name vun dä Metmaacher zum Zosamme lääje',
	'usermerge-olduser' => 'Dä ahle Metmaachername (Zosamme lääje fun&nbsp;…):',
	'usermerge-newuser' => 'Dä neu Metmaachername (Zosamme lääje noh&nbsp;…):',
	'usermerge-deleteolduser' => 'Dä ahle Metmaacher fott schmieße',
	'usermerge-submit' => 'Zosammelääje',
	'usermerge-badtoken' => 'Onjöltesch Kennzeiche',
	'usermerge-userdeleted' => '„$1“ ($2) es jetz fott jeschmeße.',
	'usermerge-userdeleted-log' => 'Fott jeschmeße Metmaacherame: „$2“ ($3)',
	'usermerge-updating' => 'Jeändert: Tabäll $1 (vun $2 noh $3)',
	'usermerge-success' => 'Et Zosammelääje vun „$1“ ($2) noh „$3“ ($4) es komplätt.',
	'usermerge-success-log' => 'Metmaacher Name „$2“ ($3) zosammejelaat met „$4“ ($5)',
	'usermerge-logpage' => 'Logboch övver et Metmaacher-Zosammelääje',
	'usermerge-logpagetext' => 'Dat hee es et Logboch övver de zosammejelaate Metmaachere.',
	'usermerge-noselfdelete' => 'Ene Metmaacher met sesch sellver zosamme ze lääje, wat ene Quatsch! Dat jeiht nit.',
	'usermerge-unmergable' => 'Schadt. Die esu zosamme ze Lääje es nit müjjelech. Dat dä Metmaacher nit zosamme jelaat wääde kann, es övver singe Name odder per sing Nommer esu faßjelaat woode.',
	'usermerge-protectedgroup' => 'Schadt. Die esu zosamme ze Lääje es nit müjjelech. Dä Metmaacher es en en Jropp, die et Zosammelääje verbeede deiht.',
	'right-usermerge' => 'Metmaacher zosammelääje',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'usermerge' => 'Benotzerkonten zesummeféieren a läschen',
	'usermerge-desc' => "[[Special:UserMerge|Féiert Benotzerkonte vun engem Benotzer mat engem anere Benotzer]] an der Wiki-Datebank zesummen - déi al Benotzerkonte ginn no der Zesummeféierung och geläscht. Erfuedert ''usermerge''-Rechter.",
	'usermerge-badolduser' => 'Ongëltegen ale Benotzernumm',
	'usermerge-badnewuser' => 'Ongëltegen neie Benotzernumm',
	'usermerge-nonewuser' => 'Eidelen neie Benotzernumm - wahrscheinlech eng Zesummeféierung mat "$1".<br />
Klickt op "{{int:usermerge-submit}}" wann Dir d\'accord sidd.',
	'usermerge-noolduser' => 'Eidelen ale Benotzernumm',
	'usermerge-fieldset' => 'Benotzernimm fir zesummenzeféieren',
	'usermerge-olduser' => 'Ale Benotzer (zesummeféiere vun):',
	'usermerge-newuser' => 'Neie Benotzer (zusammenféiere mat):',
	'usermerge-deleteolduser' => 'Ale Benotzer läschen',
	'usermerge-submit' => 'Benotzerkonten zesummeféieren',
	'usermerge-badtoken' => 'Ännerungs-Jeton net valabel',
	'usermerge-userdeleted' => '$1 ($2) gouf geläscht.',
	'usermerge-userdeleted-log' => 'Geläschte Benotzer: $2($3)',
	'usermerge-updating' => 'Aktualiséierung vun der Tabell $1 ($2 op $3)',
	'usermerge-success' => 'D\'Zesummeféierung vum "$1" ($2) op "$3" ($4) ass net komplett.',
	'usermerge-success-log' => 'Benotzer $2 ($3) gouf zesummegeféiert mat $4 ($5)',
	'usermerge-logpage' => 'Lëscht vun de Benotzerkonten déi zesummegeféiert goufen',
	'usermerge-logpagetext' => 'Dëst ass eng Lëscht vun de Benotzerkonten, déi zesummegeféiert goufen.',
	'usermerge-noselfdelete' => 'Dir kënnt Iech net selwer läschen oder mat Iech selwer zesummeféieren!',
	'usermerge-unmergable' => "Zesammenféierung ass net méiglech - d'ID oder de Benotzernumm gouf als net zesummeféierbar definéiert.",
	'usermerge-protectedgroup' => "D'Zesammenféierung ass net méiglech - De Benotzer ass an engem geschützte Grupp.",
	'right-usermerge' => 'Benotzer zesummeféieren',
	'usermerge-editcount' => 'Compteur vun den Ännerungen derbäisetzen?',
	'usermerge-editcount-success' => 'De Compteur vun den Ännerungen vun ($1 a(n) $2) gëtt derbäigesat',
	'usermerge-autopagedelete' => "Automatesch geläscht wéi d'Benotzer zesummegeluecht goufen",
	'usermerge-page-unmoved' => "D'Säit $1 konnt net op $2 geréckelt ginn.",
	'usermerge-page-moved' => "D'Säit $1 gouf op $2 geréckelt.",
	'usermerge-move-log' => 'D\'Säit gouf automatesch geréckelt wéi de Benotzer "[[User:$1|$1]]" mam "[[User:$2|$2]]" zesummegeluecht gouf',
	'usermerge-page-deleted' => 'Säit $1 ass geläscht',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'right-usermerge' => 'Manempo ny kaontim-pikambana',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'usermerge' => 'Спојување и бришење корисници',
	'usermerge-desc' => "[[Special:UserMerge|Спојува наводи од еден корисник во друг]] во вики базата на податици - ги брише и старите корисници по спојувањето. Бара ''usermerge'' привилегии",
	'usermerge-badolduser' => 'Погрешно старо корисничко име',
	'usermerge-badnewuser' => 'Погрешно ново корисничко име',
	'usermerge-nonewuser' => 'Празно ново корисничко име - се подразбира спојување со „$1“.<br />
Кликнете на „{{int:usermerge-submit}}“ за да прифатите.',
	'usermerge-noolduser' => 'Празно старо корисничко име',
	'usermerge-fieldset' => 'Кориснички имиња за спојување',
	'usermerge-olduser' => 'Стар корисник (за спојување од):',
	'usermerge-newuser' => 'Нов корисник (за спојување со):',
	'usermerge-deleteolduser' => 'Избриши стар корисник',
	'usermerge-submit' => 'Спој го корисникот',
	'usermerge-badtoken' => 'Погрешен жетон за уредување',
	'usermerge-userdeleted' => '$1 ($2) беше избришано.',
	'usermerge-userdeleted-log' => 'Избришан корисник: $2 ($3)',
	'usermerge-updating' => 'Обновувам табела $1 ($2 до $3)',
	'usermerge-success' => 'Спојувањето од $1 ($2) до $3 ($4) е готово.',
	'usermerge-success-log' => 'Корисникот $2 ($3) е споен со $4 ($5)',
	'usermerge-logpage' => 'Дневник на спојувања на кориснички сметки',
	'usermerge-logpagetext' => 'Ова е дневник на спојувања на кориснички имиња.',
	'usermerge-noselfdelete' => 'Не можете да се избришете или споите самите себеси!',
	'usermerge-unmergable' => 'Не можам да спојам од корисникот - ид. бр.или името е определено како неспојливо.',
	'usermerge-protectedgroup' => 'Не можам да спојам од корисникот - корисникот е во заштитена група.',
	'right-usermerge' => 'Спојување на корисници',
	'usermerge-editcount' => 'Да го додадам бројот на уредувањата?',
	'usermerge-editcount-success' => 'Го додавам бројот на уредувања на ($1 и $2)',
	'usermerge-autopagedelete' => 'Се брише автоматски, при спојување на корисници',
	'usermerge-page-unmoved' => 'Не моежев да ја преместам страницата $1 на $2.',
	'usermerge-page-moved' => 'Страницата $1 е преместена на $2.',
	'usermerge-move-log' => 'Автоматско преместување на страница при припојувањето на корисникот „[[User:$1|$1]]“ кон „[[User:$2|$2]]“',
	'usermerge-page-deleted' => 'Избришана страница $1',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'usermerge-badolduser' => 'അസാധുവായ പഴയ ഉപയോക്തൃനാമം',
	'usermerge-badnewuser' => 'അസാധുവായ പുതിയ ഉപയോക്തൃനാമം',
	'usermerge-noolduser' => 'പഴയ ഉപയോക്തൃനാമം ശൂന്യമാക്കുക',
	'usermerge-olduser' => 'പഴയ ഉപയോക്താവ് (ലയിപ്പിക്കാനുള്ളത്):',
	'usermerge-newuser' => 'പുതിയ ഉപയോക്താവ് (ഇതിലേക്കു സം‌യോജിപ്പിക്കണം):',
	'usermerge-deleteolduser' => 'പഴയ ഉപയോക്താവിനെ മായ്ക്കുക',
	'usermerge-submit' => 'ഉപയോക്താവിനെ സം‌യോജിപ്പിക്കുക',
	'usermerge-userdeleted' => '$1 ($2) മായ്ച്ചു.',
	'usermerge-userdeleted-log' => 'ഉപയോക്താവിനെ മായ്ച്ചു: $2 ($3)',
	'usermerge-updating' => '$1 പട്ടിക ($2 to $3) പുതുക്കുന്നു',
	'usermerge-success' => '$1 ($2) നെ $3 ($4) ലേക്കു സം‌യോജിപ്പിക്കുന്ന പ്രക്രിയ പൂർത്തിയായി.',
	'usermerge-success-log' => '$2 ($3) എന്ന ഉപയോക്താവിനെ $4 ($5)ലേക്കു സം‌യോജിപ്പിച്ചു',
	'usermerge-logpage' => 'ഉപയോക്തൃസം‌യോജന പ്രവർത്തനരേഖ',
	'usermerge-logpagetext' => 'ഉപയോക്താക്കളെ സം‌യോജിപ്പിച്ചതിന്റെ പ്രവർത്തനരേഖയാണിത്',
	'usermerge-noselfdelete' => 'താങ്കൾക്ക് താങ്കളെത്തന്നെ മായ്ക്കാനോ, മറ്റൊരു അക്കുണ്ടിലേക്കു സം‌യോജിപ്പിക്കാനോ പറ്റില്ല!',
	'right-usermerge' => 'ഉപയോക്താക്കളെ സം‌യോജിപ്പിക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'usermerge' => 'सदस्य एकत्रीकरण व वगळणे',
	'usermerge-badolduser' => 'चुकीचे जुने सदस्यनाव',
	'usermerge-badnewuser' => 'चुकीचे नवे सदस्यनाव',
	'usermerge-noolduser' => 'रिकामे जुने सदस्यनाव',
	'usermerge-olduser' => 'जुना सदस्य (इथून एकत्र करा)',
	'usermerge-newuser' => 'नवीन सदस्य (मध्ये एकत्र करा)',
	'usermerge-deleteolduser' => 'जुना सदस्य वगळायचा का?',
	'usermerge-submit' => 'सदस्य एकत्र करा',
	'usermerge-badtoken' => 'चुकीचे एडीट टोकन',
	'usermerge-userdeleted' => '$1 ($2) ला वगळण्यात आलेले आहे.',
	'usermerge-userdeleted-log' => 'सदस्य वगळला: $2 ($3)',
	'usermerge-updating' => '$1 सारणी ताजीतवानी करीत आहोत ($2 ते $3)',
	'usermerge-success-log' => 'सदस्य $2 ($3) ला $4 ($5) मध्ये एकत्र केले',
	'usermerge-logpage' => 'सदस्य एकत्रीकरण नोंद',
	'usermerge-logpagetext' => 'ही सदस्य एकत्रीकरणाची सूची आहे',
	'usermerge-noselfdelete' => 'तुम्ही स्वत:लाच वगळू किंवा एकत्र करू शकत नाही.',
	'right-usermerge' => 'सदस्य एकत्र करा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'right-usermerge' => 'Menggabungkan pengguna',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'usermerge-badolduser' => 'Ahcualli huēhuehtlatequitiltilīltōcāitl',
	'usermerge-badnewuser' => 'Ahcualli yancuīc tlatequitiltilīltōcāitl',
	'usermerge-userdeleted' => '$1 ($2) ōmopolo',
	'usermerge-userdeleted-log' => 'Tlapoloc tlatequitiltilīlli: $2 ($3)',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'usermerge' => 'Brukersammenslåing og -sletting',
	'usermerge-desc' => "Gir muligheten til  å [[Special:UserMerge|slå sammen kontoer]] ved at alle referanser til en bruker byttes ut til en annen bruker i databasen, for så å slette den ene kontoen. Trenger rettigheten ''usermerge''.",
	'usermerge-badolduser' => 'Gammelt brukernavn ugyldig',
	'usermerge-badnewuser' => 'Nytt brukernavn ugyldig',
	'usermerge-nonewuser' => 'Nytt brukernavn tomt &ndash; antar sammenslåing til «$1».<br />
Klikk «{{int:usermerge-submit}}» for å godta.',
	'usermerge-noolduser' => 'Gammelt brukernavn tomt',
	'usermerge-fieldset' => 'Brukernavn som skal slås sammen',
	'usermerge-olduser' => 'Gammelt brukernavn (slå sammen fra):',
	'usermerge-newuser' => 'Nytt brukernavn (slå sammen til):',
	'usermerge-deleteolduser' => 'Slett gammel bruker',
	'usermerge-submit' => 'Slå sammen brukere',
	'usermerge-badtoken' => 'Ugyldig redigeringstegn',
	'usermerge-userdeleted' => '$1 ($2) har blitt slettet.',
	'usermerge-userdeleted-log' => 'Slettet bruker: $2 ($3)',
	'usermerge-updating' => 'Oppdaterer $1-tabell ($2 til $3)',
	'usermerge-success' => 'Sammenslåing fra $1 ($2) til $3 ($4) er fullført.',
	'usermerge-success-log' => 'Brukeren $2 ($3) slått sammen med $4 ($5)',
	'usermerge-logpage' => 'Brukersammenslåingslogg',
	'usermerge-logpagetext' => 'Dette er en logg over brukersammenslåinger.',
	'usermerge-noselfdelete' => 'Du kan ikke slette eller slå sammen din egen konto!',
	'usermerge-unmergable' => 'Kan ikke slå sammen den gamle kontoen. ID-en eller navnet anses som ikke-sammenslåbart.',
	'usermerge-protectedgroup' => 'Kan ikke slå sammen den gamle kontoen. Brukeren er medlem i en beskyttet brukergruppe.',
	'right-usermerge' => 'Slå sammen kontoer',
	'usermerge-editcount' => 'Legge til antall redigeringer?',
	'usermerge-editcount-success' => 'Legge til antall redigeringer for ($1 og $2)',
	'usermerge-autopagedelete' => 'Automatisk slettet ved brukersammenslåing',
	'usermerge-page-unmoved' => 'Side $1 kunne ikke flyttes til $2.',
	'usermerge-page-moved' => 'Side $1 er flyttet til $2.',
	'usermerge-move-log' => 'Flyttet siden automatisk i forbindelse med sammenslåing av bruker "[[User:$1|$1]]" til "[[User:$2|$2]]"',
	'usermerge-page-deleted' => 'Slettet side $1',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'usermerge' => 'Gebrukers samenvoegen en vortdoon',
	'usermerge-desc' => "Zet n [[Special:UserMerge|spesiale pagina]] derbie um gebrukers samen te voegen en de ouwe gebruker(s) vort te doon (hierveur is t recht ''usermerge'' neudig)",
	'usermerge-badolduser' => 'Ongeldige ouwe gebrukersnaam',
	'usermerge-badnewuser' => 'Ongeldige nieje gebrukersnaam',
	'usermerge-nonewuser' => 'De nieje gebrukersnaam is niet op-egeven - der wörden vanuut egaon dat der samengevoeg mut wörden naor $1.<br />
Klik "{{int:usermerge-submit}}" um de haandeling uut te voeren.',
	'usermerge-noolduser' => 'Ouwe gebrukersnaam is niet op-egeven',
	'usermerge-fieldset' => 'Gebrukersnamen die samenevoegen mutten wörden',
	'usermerge-olduser' => 'Ouwe gebruker (samenvoegen van):',
	'usermerge-newuser' => 'Nieje gebruker (samenvoegen naor):',
	'usermerge-deleteolduser' => 'Ouwe gebruker vortdoon',
	'usermerge-submit' => 'Gebruker samenvoegen',
	'usermerge-badtoken' => 'Ongeldig bewarkingstoken',
	'usermerge-userdeleted' => '$1 ($2) is vort-edaon.',
	'usermerge-userdeleted-log' => 'Vort-edaone gebruker: $2 ($3)',
	'usermerge-updating' => 'Tabel $1 an t biewarken ($2 naor $3)',
	'usermerge-success' => 'Samenvoegen van $1 ($2) naor $3 ($4) is aoferond.',
	'usermerge-success-log' => 'Gebruker $2 ($3) samenevoeg naor $4 ($5)',
	'usermerge-logpage' => 'Logboek gebrukerssamenvoegingen',
	'usermerge-logpagetext' => 'Dit is t logboek van gebrukerssamenvoegingen.',
	'usermerge-noselfdelete' => 'Je kunnen je eigen niet vortdoon of samenvoegen!',
	'usermerge-unmergable' => 'Disse gebruker kan niet samenevoeg wörden. De gebrukersnaam of t gebrukersnummer is in-esteld as niet samenvoegen.',
	'usermerge-protectedgroup' => 'Kan de gebrukers niet samenvoegen. De gebruker zit in n bescharmde groep.',
	'right-usermerge' => 'Gebrukers samenvoegen',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'usermerge' => 'Gebruikers samenvoegen en verwijderen',
	'usermerge-desc' => "Voegt een [[Special:UserMerge|speciale pagina]] toe om gebruikers samen te voegen en de oude gebruiker(s) te verwijderen. Hiervoor is het recht ''usermerge'' nodig.",
	'usermerge-badolduser' => 'Ongeldige oude gebruiker',
	'usermerge-badnewuser' => 'Ongeldige nieuwe gebruiker',
	'usermerge-nonewuser' => 'De nieuwe gebruikersnaam is niet ingegeven - er wordt aangenomen dat er samengevoegd moet worden naar $1.<br />
Klik "{{int:usermerge-submit}}" om de handeling uit te voeren.',
	'usermerge-noolduser' => 'Oude gebruiker is niet ingegeven',
	'usermerge-fieldset' => 'Samen te voegen gebruikersnamen',
	'usermerge-olduser' => 'Oude gebruiker (samenvoegen van):',
	'usermerge-newuser' => 'Nieuwe gebruiker (samenvoegen naar):',
	'usermerge-deleteolduser' => 'Oude gebruiker verwijderen',
	'usermerge-submit' => 'Gebruiker samenvoegen',
	'usermerge-badtoken' => 'Ongeldig bewerkingstoken',
	'usermerge-userdeleted' => '$1 ($2) is verwijderd.',
	'usermerge-userdeleted-log' => 'Verwijderde gebruiker: $2 ($3)',
	'usermerge-updating' => 'Tabel $1 aan het bijwerken ($2 naar $3)',
	'usermerge-success' => 'Samenvoegen van $1 ($2) naar $3 ($4) is afgerond.',
	'usermerge-success-log' => 'Gebruiker $2 ($3) samengevoegd naar $4 ($5)',
	'usermerge-logpage' => 'Logboek gebruikerssamenvoegingen',
	'usermerge-logpagetext' => 'Dit is het logboek van gebruikerssamenvoegingen.',
	'usermerge-noselfdelete' => 'U kunt uzelf niet verwijderen of samenvoegen!',
	'usermerge-unmergable' => 'Deze gebruiker kan niet samengevoegd worden. De gebruikersnaam of het gebruikersnummer is ingesteld als niet samen te voegen.',
	'usermerge-protectedgroup' => 'Het is niet mogelijk de gebruikers samen te voegen. De gebruiker zit in een beschermde groep.',
	'right-usermerge' => 'Gebruikers samenvoegen',
	'usermerge-editcount' => 'Aantal bewerkingen toevoegen?',
	'usermerge-editcount-success' => 'Bezig met het toevoegen van het aantal bewerkingen voor ($1 en $2)',
	'usermerge-autopagedelete' => 'Automatisch verwijderd bij het samenvoegen van gebruikers',
	'usermerge-page-unmoved' => 'De pagina $1 kon niet hernoemd worden naar $2.',
	'usermerge-page-moved' => 'De pagina $1 is hernoemd naar $2.',
	'usermerge-move-log' => 'Pagina automatisch hernoemd bij het samenvoegen van gebruiker "[[User:$1|$1]]" naar "[[User:$2|$2]]"',
	'usermerge-page-deleted' => 'Verwijderde pagina $1',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Gunnernett
 * @author Harald Khan
 */
$messages['nn'] = array(
	'usermerge' => 'Slå saman og slett brukarar',
	'usermerge-desc' => "Gjev høve til å [[Special:UserMerge|slå saman kontoar]] ved at alle referansar til ein brukar vert bytta ut til ein annen brukar i databasen, for så å slette den eine kontoen. Krev rett til ''usermerge''.",
	'usermerge-badolduser' => 'Gammalt brukernamn ugyldig',
	'usermerge-badnewuser' => 'Nytt brukernamn ugyldig',
	'usermerge-nonewuser' => 'Nytt brukarnamn tomt &ndash; går ut frå samanslåing til $1.<br />Klikk "{{int:usermerge-submit}}" for å godta',
	'usermerge-noolduser' => 'Gammalt brukarnamn tomt',
	'usermerge-fieldset' => 'Brukarnamn som skal verta slegne saman',
	'usermerge-olduser' => 'Gammalt brukarnamn (slå saman frå):',
	'usermerge-newuser' => 'Nytt brukarnamn (slå saman til):',
	'usermerge-deleteolduser' => 'Slett gammal brukar',
	'usermerge-submit' => 'Slå saman brukarar',
	'usermerge-badtoken' => 'Ugyldig redigeringsteikn',
	'usermerge-userdeleted' => '$1 ($2) er sletta.',
	'usermerge-userdeleted-log' => 'Sletta brukar: $2 ($3)',
	'usermerge-updating' => 'Oppdaterer $1-tabell ($2 til $3)',
	'usermerge-success' => 'Samanslåing frå $1 ($2) til $3 ($4) er ferdig.',
	'usermerge-success-log' => 'Brukaren $2 ($3) slått saman med $4 ($5)',
	'usermerge-logpage' => 'Brukarsamanslåingslogg',
	'usermerge-logpagetext' => 'Dette er ein logg over brukarsamanslåingar.',
	'usermerge-noselfdelete' => 'Du kan ikkje slette eller slå saman din eigen konto!',
	'usermerge-unmergable' => 'Kan ikkje slå saman den gamle kontoen. ID-en eller namnet vert ikkje rekna som samanslåbart.',
	'usermerge-protectedgroup' => 'Kan ikkje slå saman den gamle kontoen. Brukaren er medlem i ei verna brukargruppe.',
	'right-usermerge' => 'Slå saman kontoar',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'usermerge' => 'Fusionar utilizaire e destruire',
	'usermerge-desc' => "[[Special:UserMerge|Fusiona las referéncias d'un utilizaire cap a un autre]] dins la banca de donadas wiki - suprimirà tanben las fusions d'utilizaires ancianas seguentas.",
	'usermerge-badolduser' => "Nom d'utilizaire ancian invalid",
	'usermerge-badnewuser' => "Nom d'utilizaire novèl invalid",
	'usermerge-nonewuser' => "Nom d'utilizaire novèl void. Fasèm l'ipotèsi que volètz fusionar dins « $1 ».<br />
Clicatz sus « {{int:usermerge-submit}} » per acceptar.",
	'usermerge-noolduser' => "Nom d'utilizaire ancian void",
	'usermerge-fieldset' => 'Noms d’utilizaires de fusionar',
	'usermerge-olduser' => 'Utilizaire ancian (fusionar dempuèi) :',
	'usermerge-newuser' => 'Utilizaire novèl (fusionar amb) :',
	'usermerge-deleteolduser' => "Suprimir l'utilizaire ancian",
	'usermerge-submit' => 'Fusionar utilizaire',
	'usermerge-badtoken' => "Geton d'edicion invalid",
	'usermerge-userdeleted' => '$1($2) es destruch.',
	'usermerge-userdeleted-log' => 'Contributor escafat : $2($3)',
	'usermerge-updating' => 'Mesa a jorn de la taula $1 (de $2 a $3)',
	'usermerge-success' => 'La fusion de $1($2) a $3($4) es completada.',
	'usermerge-success-log' => 'Contributor $2($3) fusionat amb $4($5)',
	'usermerge-logpage' => 'Jornal de las fusions de contributors',
	'usermerge-logpagetext' => 'Aquò es un jornal de las accions de fusions de contributors.',
	'usermerge-noselfdelete' => 'Podètz pas, vos-meteis, vos suprimir ni vos fusionar !',
	'usermerge-unmergable' => "Pòt pas fusionar a partir d'un utilizaire, d'un numèro d'identificacion o un nom que son estats definits coma non fusionables.",
	'usermerge-protectedgroup' => "Impossible de fusionar a partir d'un utilizaire - l'utilizaire se tròba dins un grop protegit.",
	'right-usermerge' => "Fusionar d'utilizaires",
);

/** Polish (Polski)
 * @author Derbeth
 * @author Masti
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'usermerge' => 'Integruj i usuń użytkowników',
	'usermerge-desc' => "[[Special:UserMerge|Integruje odwołania dla jednego użytkownika do drugiego]] w bazie danych wiki – usuwa również dotychczasowego użytkownika po integracji. Wymaga uprawnienia ''usermerge''",
	'usermerge-badolduser' => 'Nieprawidłowa nazwa dotychczasowego użytkownika',
	'usermerge-badnewuser' => 'Nieprawidłowa nazwa nowego użytkownika',
	'usermerge-nonewuser' => 'Pusta nazwa nowego użytkownika – integracja nastąpi z $1.<br />
Kliknij „{{int:usermerge-submit}}”, aby zaakceptować.',
	'usermerge-noolduser' => 'Pusta nazwa dotychczasowego użytkownika',
	'usermerge-fieldset' => 'Nazwy kont użytkowników do integracji',
	'usermerge-olduser' => 'Dotychczasowy użytkownik (do integracji)',
	'usermerge-newuser' => 'Nowy użytkownik (integruj z)',
	'usermerge-deleteolduser' => 'Usuń dotychczasowego użytkownika',
	'usermerge-submit' => 'Integruj użytkowników',
	'usermerge-badtoken' => 'Nieprawidłowy żeton edycji',
	'usermerge-userdeleted' => '$1 ($2) został usunięty.',
	'usermerge-userdeleted-log' => 'usunął użytkownika „$2” ($3)',
	'usermerge-updating' => 'Aktualizacja tablicy $1 ($2 do $3)',
	'usermerge-success' => 'Integracja $1 ($2) z $3 ($4) zakończona.',
	'usermerge-success-log' => 'zintegrował użytkownika „$2” ($3) do „$4” ($5)',
	'usermerge-logpage' => 'Rejestr integracji użytkowników',
	'usermerge-logpagetext' => 'To jest rejestr operacji integracji użytkowników.',
	'usermerge-noselfdelete' => 'Nie możesz usunąć lub zintegrować samego siebie!',
	'usermerge-unmergable' => 'Nie można zintegrować użytkownika – identyfikator lub nazwa zostały zdefiniowane jako nieintegrowalne.',
	'usermerge-protectedgroup' => 'Nie można zintegrować użytkownika – jest członkiem zabezpieczonej grupy.',
	'right-usermerge' => 'Łączenie kont użytkowników',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'usermerge' => "Union e scancelament d'utent",
	'usermerge-desc' => "[[Special:UserMerge|A uniss j'arferiment da n'utent a n'àutr utent]] ant ël database wiki - a scanselerà ëdcò ij vej utent d'apress l'union. A veul ij pribilegi ''usermerge''",
	'usermerge-badolduser' => 'Vej stranòm nen bon',
	'usermerge-badnewuser' => 'Neuv stranòm nen bon',
	'usermerge-nonewuser' => 'Neuv stranòm veujd - i të tnisoma bon për n\'union a "$1".<br />
Sgnaca "{{int:usermerge-submit}}" për asseté.',
	'usermerge-noolduser' => 'Vej stranòm veujd',
	'usermerge-fieldset' => 'Nòm utent da unì',
	'usermerge-olduser' => 'Vej utent (unì da):',
	'usermerge-newuser' => 'Neuv utent (unì a):',
	'usermerge-deleteolduser' => "Scansela l'utent vej",
	'usermerge-submit' => 'Unì Utent',
	'usermerge-badtoken' => "Geton d'edission nen bon",
	'usermerge-userdeleted' => "$1($2) a l'é stàit scancelà.",
	'usermerge-userdeleted-log' => 'Utent scanselà: $2 ($3)',
	'usermerge-updating' => "Antramentr ch'i agiornoma la tàola $1 ($2 a $3)",
	'usermerge-success' => 'Union da $1($2) a $3($4) completà.',
	'usermerge-success-log' => 'Utent $2 ($3) unì a $4 ($5)',
	'usermerge-logpage' => 'Registr dle union utent',
	'usermerge-logpagetext' => "Sto sì a l'é un registr ëd le assion d'union utent.",
	'usermerge-noselfdelete' => 'It peule pa scanselé o unì ti midem!',
	'usermerge-unmergable' => "As peul pa unì l'utent - l'ID o ël nòm a l'é stàit definì pa unificàbil.",
	'usermerge-protectedgroup' => "As peul pa unì l'utent - l'utent a l'é ant na partìa protegiùa.",
	'right-usermerge' => "Uniss j'utent",
	'usermerge-editcount' => 'Gionté un conteur ëd modìfiche?',
	'usermerge-editcount-success' => 'Gionté un conteur ëd modìfiche ëd ($1 e $2)',
	'usermerge-autopagedelete' => "Scancelà automaticament an unificand j'utent",
	'usermerge-page-unmoved' => 'La pàgina $1 a peul pa esse tramudà a $2.',
	'usermerge-page-moved' => "La pàgina $1 a l'ha fàit San Martin a $2.",
	'usermerge-move-log' => 'Pàgina tramudà n\'automàtich damëntrè ch\'as arbatiava "[[User:$1|$1]]" an "[[User:$2|$2]]"',
	'usermerge-page-deleted' => 'Scancelà la pagina $1',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'usermerge-badnewuser' => 'نوی کارن-نوم مو ناسم دی',
	'usermerge-deleteolduser' => 'زوړ کارن ړنګول',
);

/** Portuguese (Português)
 * @author Crazymadlover
 * @author Hamilton Abreu
 * @author Jorge Morais
 * @author Lijealso
 * @author Malafaya
 * @author Sir Lestaty de Lioncourt
 * @author Waldir
 */
$messages['pt'] = array(
	'usermerge' => 'Fusão e eliminação de utilizadores',
	'usermerge-desc' => "[[Special:UserMerge|Faz a fusão das referências a um utilizador com as de outro utilizador]] na base de dados da wiki - também apaga o utilizador antigo após a fusão. Requer o privilégio ''usermerge''",
	'usermerge-badolduser' => 'Nome antigo inválido',
	'usermerge-badnewuser' => 'Nome novo inválido',
	'usermerge-nonewuser' => 'O nome de utilizador novo está vazio - será assumida a fusão com $1.<br />
Clique "{{int:usermerge-submit}}" para aceitar.',
	'usermerge-noolduser' => 'O nome de utilizador antigo está vazio',
	'usermerge-fieldset' => 'Nomes de utilizadores a fundir',
	'usermerge-olduser' => 'Utilizador antigo (fundir de):',
	'usermerge-newuser' => 'Utilizador novo (fundir para):',
	'usermerge-deleteolduser' => 'Apagar utilizador antigo',
	'usermerge-submit' => 'Fundir utilizador',
	'usermerge-badtoken' => 'Chave de edição inválida',
	'usermerge-userdeleted' => '$1 ($2) foi eliminado.',
	'usermerge-userdeleted-log' => 'Utilizador apagado: $2 ($3)',
	'usermerge-updating' => 'A actualizar a tabela $1 ($2 para $3)',
	'usermerge-success' => 'A fusão de $1 ($2) com $3 ($4) está completa.',
	'usermerge-success-log' => 'Utilizador $2 ($3) fundido com $4 ($5)',
	'usermerge-logpage' => 'Registo de fusão de utilizadores',
	'usermerge-logpagetext' => 'Este é um registo de acções de fusão de utilizadores.',
	'usermerge-noselfdelete' => 'Não pode apagar ou fundir a partir de si próprio!',
	'usermerge-unmergable' => 'Não foi possível fundir o utilizador - o nome ou ID está definido como não podendo ser fundido.',
	'usermerge-protectedgroup' => 'Não é possível fundir este utilizador - o utilizador está num grupo protegido.',
	'right-usermerge' => 'Fundir utilizadores',
	'usermerge-editcount' => 'Adicionar as contagens de edições?',
	'usermerge-editcount-success' => 'A adicionar as contagens de edições de ($1 e $2)',
	'usermerge-autopagedelete' => 'Eliminada automaticamente ao fundir utilizadores',
	'usermerge-page-unmoved' => 'Não foi possível mover a página $1 para $2.',
	'usermerge-page-moved' => 'A página $1 foi movida para $2.',
	'usermerge-move-log' => 'Página movida automaticamente ao fundir o utilizador "[[User:$1|$1]]" com "[[User:$2|$2]]"',
	'usermerge-page-deleted' => 'A página $1 foi eliminada',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Crazymadlover
 * @author Eduardo.mps
 * @author Jorge Morais
 */
$messages['pt-br'] = array(
	'usermerge' => 'Fusão e eliminação de utilizadores',
	'usermerge-desc' => "[[Special:UserMerge|Unifica as referências de um utilizador em outro utilizador]] no banco de dados da wiki - também apagará o antigo utilizador após a fusão. Requer privilégio ''usermerge''",
	'usermerge-badolduser' => 'Nome antigo inválido',
	'usermerge-badnewuser' => 'Nome novo inválido',
	'usermerge-nonewuser' => 'Novo nome de utilizador vazio - assumida fusão com "$1".<br />
Clique "{{int:usermerge-submit}}" para aceitar.',
	'usermerge-noolduser' => 'Limpar nome antigo',
	'usermerge-fieldset' => 'Nomes de utilizador a unificar',
	'usermerge-olduser' => 'Utilizador antigo (fundir de):',
	'usermerge-newuser' => 'Utilizador novo (fundir para):',
	'usermerge-deleteolduser' => 'Apagar usuário antigo',
	'usermerge-submit' => 'Fundir utilizador',
	'usermerge-badtoken' => 'Token de edição inválida',
	'usermerge-userdeleted' => '$1 ($2) foi eliminado.',
	'usermerge-userdeleted-log' => 'Utilizador eliminado: $2 ($3)',
	'usermerge-updating' => 'Atualizando tabela $1 ($2 para $3)',
	'usermerge-success' => 'Fusão de $1 ($2) para $3 ($4) está completa.',
	'usermerge-success-log' => 'Utilizador $2 ($3) fundido com $4 ($5)',
	'usermerge-logpage' => 'Registo de fusão de utilizadores',
	'usermerge-logpagetext' => 'Este é um registro de ações de fusão de utilizadores.',
	'usermerge-noselfdelete' => 'Você não pode apagar ou fundir a partir de si próprio!',
	'usermerge-unmergable' => 'Não foi possível fundir o utilizador - Nome ou ID foi definido para não ser fundido.',
	'usermerge-protectedgroup' => 'Não é possível fundir este utilizador - Utilizador está em um grupo protegido',
	'right-usermerge' => 'Fundir utilizadores',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'usermerge' => 'Contopire și ștergere utilizatori',
	'usermerge-desc' => "[[Special:UserMerge|Contopește două conturi diferite de utilizatori]] totodată șterge din baza de date wiki contul de utilizator vechi ca urmare a contopirii. Necesită drepturi speciale (''usermerge'')",
	'usermerge-badolduser' => 'Nume de utilizator vechi incorect',
	'usermerge-badnewuser' => 'Nume de utilizator nou incorect',
	'usermerge-nonewuser' => 'Noul nume de utilizator nu este introdus - Este presupusă fuzionarea în "$1".<br />
Apasă "{{int:usermerge-submit}}" pentru a accepta.',
	'usermerge-noolduser' => 'Nume de utilizator vechi gol',
	'usermerge-fieldset' => 'Nume de utilizator de contopit',
	'usermerge-olduser' => 'Utilizator vechi (redenumește din):',
	'usermerge-newuser' => 'Utilizator nou (contopește în):',
	'usermerge-deleteolduser' => 'Şterge contul de utilizator vechi',
	'usermerge-submit' => 'Contopește utilizatorul',
	'usermerge-badtoken' => 'Jetonul de modificare este invalid',
	'usermerge-userdeleted' => '$1 ($2) a fost șters.',
	'usermerge-userdeleted-log' => 'Şterge utilizator: $2 ($3)',
	'usermerge-updating' => 'Actualizarea tabelului $1 ($2 în $3)',
	'usermerge-success' => 'Contopirea din $1 ($2) în $3 ($4) este completă.',
	'usermerge-success-log' => 'Utilizatorul $2 ($3) a fost contopit în $4 ($5)',
	'usermerge-logpage' => 'Jurnal contopire utilizatori',
	'usermerge-logpagetext' => 'Acesta este jurnalul acțiunilor de contopire a conturilor de utilizator.',
	'usermerge-noselfdelete' => 'Nu poate fi șters sau contopit contul propriu!',
	'usermerge-unmergable' => 'Nu poate fi contopit utilizatorul - ID-ul sau numele a fost definit ca fiind de necontopit.',
	'usermerge-protectedgroup' => 'Nu poate fi contopit utilizatorul - utilizatorul face parte dintr-un grup protejat.',
	'right-usermerge' => 'Contopire conturi de utilizator',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'usermerge-badolduser' => 'Nome utende vecchije invalide',
	'usermerge-badnewuser' => 'Nome utende nuève invalide',
);

/** Russian (Русский)
 * @author Askarmuk
 * @author Ferrer
 * @author Illusion
 * @author Innv
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'usermerge' => 'Объединение и удаление учётных записей',
	'usermerge-desc' => "[[Special:UserMerge|Переводит связи с одного участника на другого]] в базе данных вики, старые пользователи будут удаляться. Требует прав ''usermerge''",
	'usermerge-badolduser' => 'Неправильное старое имя участника',
	'usermerge-badnewuser' => 'Неправильное новое имя участника',
	'usermerge-nonewuser' => 'Пустое новое имя участника — при слиянии с «$1».<br />
Нажмите «{{int:usermerge-submit}}», чтобы подтвердить действие.',
	'usermerge-noolduser' => 'Пустое старое имя участника',
	'usermerge-fieldset' => 'Учётные записи для объединения',
	'usermerge-olduser' => 'Старая учётная запись (объединить с):',
	'usermerge-newuser' => 'Новая учётная запись (объединить в):',
	'usermerge-deleteolduser' => 'Удалить старую учётную запись',
	'usermerge-submit' => 'Объединить участников',
	'usermerge-badtoken' => 'Недействительный маркер правки',
	'usermerge-userdeleted' => '$1 ($2) был удалён.',
	'usermerge-userdeleted-log' => 'Удалён участник $2 ($3)',
	'usermerge-updating' => 'Обновление таблицы $1 ($2 из $3)',
	'usermerge-success' => 'Объединение $1 ($2) с $3 ($4) выполнено.',
	'usermerge-success-log' => 'Участник $2 ($3) объединён в $4 ($5)',
	'usermerge-logpage' => 'Журнал объединения участников',
	'usermerge-logpagetext' => 'Это журнал объединения учётных записей.',
	'usermerge-noselfdelete' => 'Вы не можете удалять или объединять себя самого!',
	'usermerge-unmergable' => 'Невозможно объединить участников — идентификатор или имя было определено как необъединяемое.',
	'usermerge-protectedgroup' => 'Невозможно объединить участников — участник относится к защищённой группе.',
	'right-usermerge' => 'объединение участников',
	'usermerge-autopagedelete' => 'Автоматически удаляются при объединении пользователей',
	'usermerge-page-unmoved' => 'Страница $1 не может быть переименована в $2.',
	'usermerge-page-moved' => 'Страница $1 была переименована в $2.',
	'usermerge-move-log' => 'Автоматически переименовано во время объединения учетной записи "[[User:$1|$1]]" с "[[User:$2|$2]]"',
	'usermerge-page-deleted' => 'Удалить страницу $1',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'usermerge-noolduser' => 'Порожнє старе мено хоснователя',
	'usermerge-deleteolduser' => 'Змазати старого хоснователя',
	'usermerge-userdeleted' => '$1 ($2) быв змазаный.',
	'usermerge-userdeleted-log' => 'Змазаный хоснователь: $2 ($3)',
	'usermerge-updating' => 'Актуалізує ся таблиця $1 ($2 на $3)',
);

/** Sinhala (සිංහල)
 * @author Calcey
 */
$messages['si'] = array(
	'usermerge' => 'පරිශීලකයින් මුසු කිරීම හා මැකීම',
	'usermerge-desc' => "විකිදත්ත ගබඩාවේ ඇති [[Special:UserMerge|එක් පරිශීලකයකුගෙන් තවත් පරිශිලකයෙකුට යොමුවන් මුසු කරයි]] පැරණි පරිශීලකයින්වද මකයි,පහත මුසු කිරීමට ''usermerge'' වරප්‍රසාද අවශ්‍යවේ.",
	'usermerge-badolduser' => 'වලංගු නොවන පැරණි පරිශීලක නාමය',
	'usermerge-badnewuser' => 'වලංගු නොවන නව පරිශීලක නාමය',
	'usermerge-nonewuser' => 'හිස් නව පරිශීලක නාමය - "$1" ට මුසු කිරීමට උපකල්පනය කරමින්.<br />
පිළිගැනීමට "{{int:usermerge-submit}}" ක්ලික් කරන්න.',
	'usermerge-noolduser' => 'හිස් පැරණි පරිශීලක නාමය',
	'usermerge-fieldset' => 'මුසු කිරීමට නියමිත පරිශීලක නාමයන්',
	'usermerge-olduser' => 'පැරණි පරිශීලක (මුසු කරන්නේ):',
	'usermerge-newuser' => 'නව පරිශීලකයා (මුසු කිරීමට තිබෙන):',
	'usermerge-deleteolduser' => 'පැරණි පරිශීලකයා මකන්න',
	'usermerge-submit' => 'පරිශීලකයා මුසු කරන්න',
	'usermerge-badtoken' => 'වලංගු නොවන සංස්කරණ සංඥාව',
	'usermerge-userdeleted' => '$1 ($2) මකනු ලැබ ඇත.',
	'usermerge-userdeleted-log' => 'මකනු ලැබූ පරිශීලක: $2 ($3)',
	'usermerge-updating' => '$1 වගුව යාවත්කාලීන කිරීම ($2 ,$3ට )',
	'usermerge-success' => '$1 ($2) සිට $3 ($4) දක්වා මුසු කිරීම සම්පූර්ණ විය.',
	'usermerge-success-log' => '$2 ($3) පරිශීලකයා $4 ($5) ට මුසු කරන ලදී',
	'usermerge-logpage' => 'පරිශීලක මුසු කිරීම් ලඝු සටහන',
	'usermerge-logpagetext' => 'මෙය පරිශීලක මුසු කිරීම් කාර්යයන්වල ලඝු සටහනකි.',
	'usermerge-noselfdelete' => 'ඔබ විසින්ම මැකීම හෝ මුසු කිරීම සිදු කරනු ලැබිය නොහැකිය!',
	'usermerge-unmergable' => 'පරිශීලකයා මඟින් මුසු කළ නොහැකියි - ID හෝ නම හඳුන්වා දී තිබෙන්නේ මුසු කළ නොහැකි ලෙසයි.',
	'usermerge-protectedgroup' => 'පරිශිලකයා මඟින් මුසු කළ නොහැකියි - පරිශීලකයා සිටින්නේ ආරක්ෂිත කණ්ඩායමකය.',
	'right-usermerge' => 'පරිශීලකයින් මුසු කිරීම',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'usermerge' => 'Zlúčenie a zmazanie používateľov',
	'usermerge-desc' => "[[Special:UserMerge|Zlučuje odkazy na jedného používateľa na odkazy na druhého]] v databáze wiki; tiež následne zmaže starého používateľa. Vyžaduje oprávnenie ''usermerge''.",
	'usermerge-badolduser' => 'Neplatné staré používateľské meno',
	'usermerge-badnewuser' => 'Neplatné nové používateľské meno',
	'usermerge-nonewuser' => 'Prázdne nové používateľské meno - predpokladá sa zlúčenie do „$1“.<br />
Kliknutím na „{{int:usermerge-submit}}“ prijmete.',
	'usermerge-noolduser' => 'Prázdne staré používateľské meno',
	'usermerge-fieldset' => 'Zlúčiť používateľov',
	'usermerge-olduser' => 'Starý používateľ (zlúčiť odtiaľto)',
	'usermerge-newuser' => 'Nový používateľ (zlúčiť sem)',
	'usermerge-deleteolduser' => 'Zmazať starého používateľa',
	'usermerge-submit' => 'Zlúčiť používateľov',
	'usermerge-badtoken' => 'Neplatný token úprav',
	'usermerge-userdeleted' => '$1($2) bol zmazaný.',
	'usermerge-userdeleted-log' => 'Zmazaný používateľ: $2($3)',
	'usermerge-updating' => 'Aktualizuje sa tabuľka $1 ($2 na $3)',
	'usermerge-success' => 'Zlúčenie z $1($2) do $3($4) je dokončené.',
	'usermerge-success-log' => 'Používateľ $2($3) bol zlúčený do $4($5)',
	'usermerge-logpage' => 'Záznam zlúčení používateľov',
	'usermerge-logpagetext' => 'Toto je záznam zlúčení používateľov.',
	'usermerge-noselfdelete' => 'Nemôžete zmazať alebo zlúčiť svoj účet!',
	'usermerge-unmergable' => 'Nebolo možné vykonať zlúčenie používateľa - zdrojové meno alebo ID bolo definované ako nezlúčiteľné.',
	'usermerge-protectedgroup' => 'Nebolo možné zlúčiť uvedeného používateľa - používateľ je v chránenej skupine.',
	'right-usermerge' => 'Zlučovať používateľov',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'usermerge' => 'Spoji in izbriši uporabnike',
	'usermerge-desc' => "[[Special:UserMerge|Združi sklice iz enega uporabnika na drugega]] v zbirki podatkov wikija – prav tako po združitvi izbriše stare uporabnika. Potrebuje pravico ''usermerge''",
	'usermerge-badolduser' => 'Neveljavno staro uporabniško ime',
	'usermerge-badnewuser' => 'Neveljavno novo uporabniško ime',
	'usermerge-nonewuser' => 'Prazno novo uporabniško ime – predpostavljam združitev z »$1«.<br />
Kliknite »{{int:usermerge-submit}}« za sprejetje.',
	'usermerge-noolduser' => 'Prazno staro uporabniško ime',
	'usermerge-fieldset' => 'Uporabniška imena za spajanje',
	'usermerge-olduser' => 'Stari uporabnik (spoji od):',
	'usermerge-newuser' => 'Novi uporabnik (spoji do):',
	'usermerge-deleteolduser' => 'Izbriši starega uporabnika',
	'usermerge-submit' => 'Spoji uporabnika',
	'usermerge-badtoken' => 'Neveljavni žeton urejanja',
	'usermerge-userdeleted' => '$1 ($2) je bil izbrisan.',
	'usermerge-userdeleted-log' => 'Izbrisal(-a) uporabnika: $2 ($3)',
	'usermerge-updating' => 'Posodabljanje tabele $1 ($2 v $3)',
	'usermerge-success' => 'Združitev iz $1 ($2) v $3 ($4) je končana.',
	'usermerge-success-log' => 'Uporabnik $2 ($3) je spojen z $4 ($5)',
	'usermerge-logpage' => 'Dnevnik spajanja uporabnikov',
	'usermerge-logpagetext' => 'To je dnevnik dejanj spajanja uporabnikov.',
	'usermerge-noselfdelete' => 'Ne morete izbrisati ali združevati sebe!',
	'usermerge-unmergable' => 'Ne morem združiti uporabnika – ID ali ime je opredeljeno kot nezdružljivo.',
	'usermerge-protectedgroup' => 'Ne morem združiti uporabnika – uporabnik je v zaščiteni skupini.',
	'right-usermerge' => 'Spajanje uporabnikov',
	'usermerge-editcount' => 'Dodam števec urejanj?',
	'usermerge-editcount-success' => 'Dodajanje števca urejanj ($1 in $2)',
	'usermerge-autopagedelete' => 'Samodejno izbrisano med združevanjem uporabnikov',
	'usermerge-page-unmoved' => 'Strani $1 ni bilo mogoče prestaviti na $2.',
	'usermerge-page-moved' => 'Stran $1 je bila prestavljena na $2.',
	'usermerge-move-log' => 'Samodejno prestavljena stran med združevanjem uporabnika »[[User:$1|$1]]« z »[[User:$2|$2]]«',
	'usermerge-page-deleted' => 'Izbrisana stran $1',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'usermerge' => 'Спаја и брише кориснике',
	'usermerge-badolduser' => 'Неисправно старо корисничко име',
	'usermerge-badnewuser' => 'Неисправно ново корисничко име',
	'usermerge-noolduser' => 'Испразни старо корисничко име',
	'usermerge-fieldset' => 'Корисничка имена за спајање',
	'usermerge-olduser' => 'Стари корисник (спајање од):',
	'usermerge-newuser' => 'Нови корисник (спајање са):',
	'usermerge-deleteolduser' => 'Обриши старог корисника',
	'usermerge-submit' => 'Споји корисника',
	'usermerge-userdeleted' => '$1 ($2) је обрисан.',
	'usermerge-userdeleted-log' => 'Обрисан корисник: $2 ($3)',
	'usermerge-updating' => 'Ажурирање $1 табеле ($2 на $3)',
	'usermerge-success' => 'Спајање $1 ($2) са $3 ($4) је завршено.',
	'usermerge-success-log' => 'Корисник $2 ($3) је спојен са $4 ($5)',
	'usermerge-logpage' => 'Историја спајања корисника',
	'usermerge-logpagetext' => 'Ово је историја спајања корисника.',
	'usermerge-noselfdelete' => 'Не можете да се обришете или спојите са другим налогом!',
	'usermerge-protectedgroup' => 'Није могуђе спојити овог корисника са другим — налази се у заштићеној групи.',
	'right-usermerge' => 'спајање корисника',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'usermerge' => 'Spaja i briše korisnike',
	'usermerge-badolduser' => 'Neispravno staro korisničko ime',
	'usermerge-badnewuser' => 'Neispravno novo korisničko ime',
	'usermerge-noolduser' => 'Isprazni staro korisničko ime',
	'usermerge-fieldset' => 'Korisnička imena za spajanje',
	'usermerge-olduser' => 'Stari korisnik (spajanje od):',
	'usermerge-newuser' => 'Novi korisnik (spajanje sa):',
	'usermerge-deleteolduser' => 'Obriši starog korisnika',
	'usermerge-submit' => 'Spoji korisnika',
	'usermerge-userdeleted' => '$1 ($2) je obrisan.',
	'usermerge-userdeleted-log' => 'Obrisan korisnik: $2 ($3)',
	'usermerge-updating' => 'Ažuriranje $1 tabele ($2 na $3)',
	'usermerge-success' => 'Spajanje $1 ($2) sa $3 ($4) je završeno.',
	'usermerge-success-log' => 'Korisnik $2 ($3) je spojen sa $4 ($5)',
	'usermerge-logpage' => 'Istorija spajanja korisnika',
	'usermerge-logpagetext' => 'Ovo je istorija spajanja korisnika.',
	'usermerge-noselfdelete' => 'Ne možete da se obrišete ili spojite sa drugim nalogom!',
	'usermerge-protectedgroup' => 'Nije moguđe spojiti ovog korisnika sa drugim — nalazi se u zaštićenoj grupi.',
	'right-usermerge' => 'spajanje korisnika',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'usermerge' => 'Benutserkonten touhoopefiere un läskje',
	'usermerge-desc' => "[[Special:UserMerge|Fiert Benutserkonten in ju Wiki-Doatenbank touhoope]] - dät oolde Benutserkonto wäd ätter ju Touhoopefierenge läsked. Ärfoardert dät ''usermerge''-Gjucht.",
	'usermerge-badolduser' => 'Uungultigen oolden Benutsernoome',
	'usermerge-badnewuser' => 'Uungultigen näien Benutsernoome',
	'usermerge-nonewuser' => 'Loosen näien Benutsernoome - der is ne Touhoopefierenge mäd „$1“ fermoudjen.<br />
Klik ap  „{{int:usermerge-submit}}“ toun Uutfieren.',
	'usermerge-noolduser' => 'Loosen oolden Benutsernoome',
	'usermerge-olduser' => 'Oolden Benutsernoome (touhoopefieren fon):',
	'usermerge-newuser' => 'Näien Benutsernoome (touhoopefieren ätter):',
	'usermerge-deleteolduser' => 'Oolden Benutsernoome läskje',
	'usermerge-submit' => 'Benutserkonten touhoopefiere',
	'usermerge-badtoken' => 'Uungultich Beoarbaidjen-Token',
	'usermerge-userdeleted' => '„$1“ ($2) wuud läsked.',
	'usermerge-userdeleted-log' => 'Läskeden Benutsernoome: „$2“ ($3)',
	'usermerge-updating' => 'Aktualisierenge $1 Tabelle ($2 ätter $3)',
	'usermerge-success' => 'Ju Touhoopefierenge fon „$1“ ($2) ätter „$3“ ($4) is fulboodich.',
	'usermerge-success-log' => 'Benutsernoome „$2“ ($3) touhoopefierd mäd „$4“ ($5)',
	'usermerge-logpage' => 'Benutserkonten-Touhoopefierenge-Logbouk',
	'usermerge-logpagetext' => 'Dit is dät Logbouk fon do Benutserkonten-Touhoopefierengen.',
	'usermerge-noselfdelete' => 'Touhoopefierenge mäd aan sälwen is nit muugelk!',
	'usermerge-unmergable' => 'Touhoopefierenge nit muugelk - ID of Benutsernoome wuud as nit touhoopefierboar definierd.',
	'usermerge-protectedgroup' => 'Touhoopefierenge nit muugelk - Benutsernoome is in ne skutsede Gruppe.',
	'right-usermerge' => 'Benutserkonten fereenje',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'usermerge-desc' => "Ngagabungkeun Préférénsi ti hiji pamaké ka pamaké séjén dina pangkalan data wiki - ogé baris ngahapus pamaké lila sadeui Ngagabungkeun. diperlukeun hak aksés ''usermerge''",
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author Micke
 * @author Sannab
 */
$messages['sv'] = array(
	'usermerge' => 'Slå ihop och radera användarkonton',
	'usermerge-desc' => "Ger möjlighet att [[Special:UserMerge|slå samman användarkonton]] genom att alla referenser till en användare byts ut till en annan användare i databasen, samt att efter sammanslagning radera gamla konton. Kräver behörigheten ''usermerge''.",
	'usermerge-badolduser' => 'Ogiltigt gammalt användarnamn',
	'usermerge-badnewuser' => 'Ogiltigt nytt användarnamn',
	'usermerge-nonewuser' => 'Nytt användarnamn tomt. Antar sammanslagning till $1.<br />Klicka på "{{int:usermerge-submit}}" för att godkänna.',
	'usermerge-noolduser' => 'Gammalt användarnamn tomt',
	'usermerge-fieldset' => 'Användarnamn att förena',
	'usermerge-olduser' => 'Gammalt användarnamn (slå ihop från)',
	'usermerge-newuser' => 'Nytt användarnamn (slå ihop till)',
	'usermerge-deleteolduser' => 'Ta bort den gamla användaren',
	'usermerge-submit' => 'Förena konton',
	'usermerge-badtoken' => 'Ogiltigt redigeringstecken',
	'usermerge-userdeleted' => '$1 ($2) har raderats.',
	'usermerge-userdeleted-log' => 'Raderad användare: $2 ($3)',
	'usermerge-updating' => 'Uppdaterar $1-tabell  ($2 till $3)',
	'usermerge-success' => 'Sammanslagning från $1 ($2) till $3 ($4) är genomförd.',
	'usermerge-success-log' => 'Användare $2 ($3) sammanslagen med $4 ($5)',
	'usermerge-logpage' => 'Användarsammanslagningslogg',
	'usermerge-logpagetext' => 'Det här är en logg över sammanslagningar av användarkonton.',
	'usermerge-noselfdelete' => 'Du kan inte radera eller slå samman ditt eget konto!',
	'usermerge-unmergable' => 'Kan inte sammanfoga det gamla kontot. ID:t eller namnet har angetts som icke-sammanslagningsbart.',
	'usermerge-protectedgroup' => 'Kan inte sammanfoga det gamla kontot. Användaren är medlem i en skyddad användargrupp.',
	'right-usermerge' => 'Slå ihop användarkonton',
);

/** Silesian (Ślůnski)
 * @author Lajsikonik
 */
$messages['szl'] = array(
	'usermerge' => 'Skupluj a wyćep użytkowńikůw',
	'usermerge-desc' => "[[Special:UserMerge|Kupluje odwołańo lů jednygo użytkowńika do drugigo]] we baźe danych wiki – wyćepuje tyż starygo użytkowńika po skuplowańu. Wymogo uprowńyńo ''usermerge''",
	'usermerge-badolduser' => 'Felerne stare mjano użytkowńika',
	'usermerge-badnewuser' => 'Felerne nowe mjano użytkowńika',
	'usermerge-nonewuser' => 'Puste mjano nowygo użytkowńika – przyjynto, aże nastůmpi integracyjo do $1. <br />Naciś <u>Kupluj użytkowńikůw</u>, coby zaakceptować.',
	'usermerge-noolduser' => 'Puste stare mjano użytkowńika',
	'usermerge-olduser' => 'Stary użytkowńik (kupluj uod)',
	'usermerge-newuser' => 'Nowy użytkowńik (kupluj s)',
	'usermerge-deleteolduser' => 'Wyćepać starygo użytkowńika?',
	'usermerge-submit' => 'Kupluj użytkowńikůw',
	'usermerge-badtoken' => 'Ńyprowidłowy żetůn sprowjyńo',
	'usermerge-userdeleted' => '$1 ($2) zostoł wyćepany.',
	'usermerge-userdeleted-log' => 'wyćepoł użytkowńika „$2” ($3)',
	'usermerge-updating' => 'Uodśwjeżańy tabuli $1 ($2 do $3)',
	'usermerge-success' => 'Kuplowańy $1 ($2) s $3 ($4) zakończůne.',
	'usermerge-success-log' => 'skuplowoł użytkowńika „$2” ($3) do „$4” ($5)',
	'usermerge-logpage' => 'Rejer kuplowańo użytkowńików',
	'usermerge-logpagetext' => 'To je rejer uoperacyji kuplowańo użytkowńikůw.',
	'usermerge-noselfdelete' => 'Ńy idźe wyćepać abo kuplować samygo śebje!',
	'usermerge-unmergable' => 'Ńy idźe skuplować użytkowńika - identyfikator abo mjano uostoły zidentyfikowane kej ńykuplowalne.',
	'usermerge-protectedgroup' => 'Ńy idźe skulować użytkowńika - je uůn człůnkym zabezpjeczůnyj grupy.',
	'right-usermerge' => 'Kuplowańy użytkowńikůw',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'usermerge' => 'వాడుకరి విలీనం మరియు తొలగింపు',
	'usermerge-badolduser' => 'తప్పుడు పాత వాడుకరిపేరు',
	'usermerge-badnewuser' => 'తప్పుడు కొత్త వాడుకరిపేరు',
	'usermerge-noolduser' => 'పాత వాడుకరిపేరు ఖాళీగా ఉంది',
	'usermerge-fieldset' => 'విలీనించాల్సిన వాడుకరిపేర్లు',
	'usermerge-olduser' => 'పాత వాడుకరి (నుండి విలీనం):',
	'usermerge-newuser' => 'కొత్త వాడుకరి (గా విలీనం):',
	'usermerge-deleteolduser' => 'పాత వాడుకరిని తొలగించు',
	'usermerge-submit' => 'వాడుకరిని విలీనం చేయ్యండి',
	'usermerge-userdeleted' => '$1 ($2)ని తొలగించాం.',
	'usermerge-userdeleted-log' => 'వాడుకరిని తొలగించాం: $2 ($3)',
	'usermerge-updating' => '$1 పట్టిక ($2 నుండి $3 వరకు) ని తాజాకరిస్తున్నాం',
	'usermerge-success' => '$1 ($2) నుండి $3 ($4) కి విలీనం పూర్తయ్యింది.',
	'usermerge-success-log' => '$2 ($3) వాడుకరి $4 ($5)లో విలీనమయ్యారు',
	'usermerge-logpage' => 'వాడుకరి విలీనాల చిట్టా',
	'usermerge-logpagetext' => 'ఇది వాడుకరి విలీనాల చిట్టా.',
	'usermerge-noselfdelete' => 'మిమ్మల్ని మీరే తొలగించుకోలేరు లేదా మీలో విలీనం కాలేరు!',
	'right-usermerge' => 'వాడుకరులను విలీనం చేయగలగడం',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'usermerge' => 'Идгом ва ҳафзи корбар',
	'usermerge-badolduser' => 'Номи корбарии кӯҳнаи номӯътабар',
	'usermerge-badnewuser' => 'Номи корбарии ҷадидӣ номӯътабар',
	'usermerge-noolduser' => 'Холӣ кардани номи корбарии кӯҳна',
	'usermerge-olduser' => 'Корбари кӯҳна (идғом аз)',
	'usermerge-newuser' => 'Корбари ҷадид (идғом ба)',
	'usermerge-deleteolduser' => 'Корбари кӯҳна ҳазв шавад?',
	'usermerge-submit' => 'Идғоми корбар',
	'usermerge-userdeleted-log' => 'Корбари ҳазфшуда: $2 ($3)',
	'usermerge-logpage' => 'Гузориши идғоми корбар',
	'usermerge-logpagetext' => 'Ин гузориши амалҳои идғоми корбар аст.',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'usermerge' => 'Idgom va hafzi korbar',
	'usermerge-badolduser' => "Nomi korbariji kūhnai nomū'tabar",
	'usermerge-badnewuser' => "Nomi korbariji çadidī nomū'tabar",
	'usermerge-noolduser' => 'Xolī kardani nomi korbariji kūhna',
	'usermerge-submit' => 'Idƣomi korbar',
	'usermerge-userdeleted-log' => 'Korbari hazfşuda: $2 ($3)',
	'usermerge-logpage' => 'Guzorişi idƣomi korbar',
	'usermerge-logpagetext' => 'In guzorişi amalhoi idƣomi korbar ast.',
);

/** Thai (ไทย)
 * @author Mopza
 */
$messages['th'] = array(
	'usermerge-logpage' => 'ปูมการรวมผู้ใช้',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'usermerge' => 'Pagsanibin at burahin ang mga tagagamit',
	'usermerge-desc' => '[[Special:UserMerge|Nagsasanib ng mga sanggunian mula sa isang tagagamit patungo sa ibang tagagamit]] sa loob ng kalipunan ng dato ng wiki - magbubura din ng lumang mga tagagamit kasunod ng pagsasanib.  Nangangailangan ng mga karapatang "tagagamitpagsasanib"',
	'usermerge-badolduser' => 'Hindi tanggap na lumang pangalan ng tagagamit',
	'usermerge-badnewuser' => 'Hindi tanggap na bagong pangalan ng tagagamit',
	'usermerge-nonewuser' => 'Tanggalan ng laman ang bagong pangalan ng tagagamit - ipinapalagay na isasanib sa $1.<br />
Pindutin ang "{{int:usermerge-submit}}" upang tanggapin.',
	'usermerge-noolduser' => 'Tanggalan ng laman ang lumang pangalan ng tagagamit',
	'usermerge-fieldset' => 'Mga pangalan ng tagagamit na pagsasanibin',
	'usermerge-olduser' => 'Lumang tagagamit (isanib mula sa):',
	'usermerge-newuser' => 'Bagong tagagamit (isanib sa):',
	'usermerge-deleteolduser' => 'Burahin ang lumang tagagamit',
	'usermerge-submit' => 'Isanib ang tagagamit',
	'usermerge-badtoken' => 'Hindi tanggap na pananda ng pagbabago',
	'usermerge-userdeleted' => 'Nabura na ang $1 ($2).',
	'usermerge-userdeleted-log' => 'Binurang tagagamit: $2 ($3)',
	'usermerge-updating' => 'Isinasapanahon ang $1 na tabla ($2 hanggang $3)',
	'usermerge-success' => 'Ganap na ang pagsanib mula sa $1 ($2) patungo sa $3 ($4).',
	'usermerge-success-log' => 'Tagagamit na $2 ($3) isinanib sa $4 ($5)',
	'usermerge-logpage' => 'Talaan ng pagsasanib ng tagagamit',
	'usermerge-logpagetext' => 'Isa itong talaan ng mga galaw na pangpagsasanib ng tagagamit.',
	'usermerge-noselfdelete' => 'Hindi ka maaaring magbura o sumanib mula sa sarili mo!',
	'usermerge-unmergable' => 'Hindi naisanib mula sa tagagamit - nilarawan ang ID o pangalan bilang hindi mapagsasanib.',
	'usermerge-protectedgroup' => 'Hindi naisanib mula sa tagagamit - nasa loob ng isang nakasanggalang na pangkat ang tagagamit.',
	'right-usermerge' => 'Pagsanibin ang mga tagagamit',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Srhat
 */
$messages['tr'] = array(
	'usermerge' => 'Kullanıcıları birleştir ve sil',
	'usermerge-desc' => "Viki veritabanında [[Special:UserMerge|referansları bir kullanıcıdan diğerine birleştirir]] - birleşmeyi mütakip eski kullanıcıları da siler. ''Kullanıcıbirleştir'' ayrıcalığı gerekir",
	'usermerge-badolduser' => 'Geçersiz eski kullanıcı adı',
	'usermerge-badnewuser' => 'Geçersiz yeni kullanıcı',
	'usermerge-nonewuser' => 'Yeni boş kullanıcıadı - "$1" ile birleştirme varsayılıyor.<br />
Kabul etmek için "{{int:usermerge-submit}}"e tıklayın.',
	'usermerge-noolduser' => 'Boş eski kullanıcı adı',
	'usermerge-fieldset' => 'Birleştirilecek kullanıcı adları',
	'usermerge-olduser' => 'Eski kullanıcı (dan birleştir):',
	'usermerge-newuser' => 'Yeni kullanıcı (e birleştir):',
	'usermerge-deleteolduser' => 'Eski kullanıcıyı sil',
	'usermerge-submit' => 'Kullanıcıyı birleştir',
	'usermerge-badtoken' => 'Geçersiz değişiklik dizgeciği',
	'usermerge-userdeleted' => '$1 ($2) silindi.',
	'usermerge-userdeleted-log' => 'Silinen kullanıcı: $2 ($3)',
	'usermerge-updating' => '$1 tablosu ($2 den $3 e) güncelleniyor',
	'usermerge-success' => '$1 ($2) kullanıcısından $3 ($4) kullanıcısına birleştirme tamamlandı.',
	'usermerge-success-log' => '$2 ($3) kullanıcısı $4 ($5) kullanıcısına birleştirildi',
	'usermerge-logpage' => 'Kullanıcı birleştirme günlüğü',
	'usermerge-logpagetext' => 'Bu bir kullanıcı birleştirme eylemleri günlüğüdür.',
	'usermerge-noselfdelete' => 'Kendinizden birleştiremez ya da silemezsiniz!',
	'usermerge-unmergable' => 'Kullanıcıdan birleştirilemiyor - ID ya da isim birleştirilemez olarak tanımlanmış.',
	'usermerge-protectedgroup' => 'Kullanıcıdan birleştirilemiyor - kullanıcı korunan bir grupta bulunuyor.',
	'right-usermerge' => 'Kullanıcıları birleştir',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'usermerge' => "Об'єднання і вилучення облікових записів",
	'usermerge-desc' => "[[Special:UserMerge|Переводить зв'язки з одного користувача на іншого]] у базі даних вікі, старі користувачі будуть вилучатися. Вимагає прав ''usermerge''",
	'usermerge-badolduser' => "Неправильне старе ім'я користувача",
	'usermerge-badnewuser' => "Неправильне нове ім'я користувача",
	'usermerge-nonewuser' => "Порожнє ім'я користувача — при злитті з «$1».<br />
Натисніть «{{int:usermerge-submit}}», щоб підтвердити дію.",
	'usermerge-noolduser' => "Порожнє старе ім'я користувача",
	'usermerge-fieldset' => "Облікові записи для об'єднання",
	'usermerge-olduser' => "Старий обліковий запис (об'єднати з):",
	'usermerge-newuser' => "Новий обліковий запис (об'єднати у):",
	'usermerge-deleteolduser' => 'Вилучити старий обліковий запис',
	'usermerge-submit' => "Об'єднати користувачів",
	'usermerge-badtoken' => 'Недійсний маркер редагування',
	'usermerge-userdeleted' => '$1 ($2) був вилучений.',
	'usermerge-userdeleted-log' => 'Вилучений користувач: $2 ($3)',
	'usermerge-updating' => 'Оновлення таблиці $1 ($2 з $3)',
	'usermerge-success' => "Об'єднання $1 ($2) з $3 ($4) виконане.",
	'usermerge-success-log' => 'Користувач $2 ($3) приєднаний до $4 ($5)',
	'usermerge-logpage' => "Журнал об'єднання користувачів",
	'usermerge-logpagetext' => "Це журнал об'єднання облікових записів.",
	'usermerge-noselfdelete' => 'Ви не можете вилучати або приєднувати самого себе!',
	'usermerge-unmergable' => "Неможливо об'єднати користувачів — ідентифікатор або ім'я було визначене як необ'єднуване.",
	'usermerge-protectedgroup' => "Неможливо об'єднати користувачів — користувач належить до захищеної групи.",
	'right-usermerge' => "об'єднання користувачів",
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'usermerge-badolduser' => 'Vär vanh kävutajan nimi',
	'usermerge-badnewuser' => "Vär uz' kävutajan nimi",
	'usermerge-deleteolduser' => 'Čuta poiš vanh kävutajan nimi',
	'right-usermerge' => 'Ühtenzoitta kävutajid',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'usermerge' => 'Trộn và xóa thành viên',
	'usermerge-desc' => "[[Special:UserMerge|Trộn các tham chiếu từ thành viên này sang một thành viên khác]] trong cơ sở dữ liệu wiki - đồng thời xóa thành viên cũ sau khi trộn. Cần phải có quyền ''usermerge''",
	'usermerge-badolduser' => 'Tên thành viên cũ không hợp lệ',
	'usermerge-badnewuser' => 'Tên thành viên mới không hợp lệ',
	'usermerge-nonewuser' => 'Tên thành viên mới đã để trống - xem như trộn với “$1”.<br />
Nhấn “{{int:usermerge-submit}}” để chấp nhận.',
	'usermerge-noolduser' => 'Tên thành viên cũ trống',
	'usermerge-fieldset' => 'Các tên thành viên sẽ trộn',
	'usermerge-olduser' => 'Thành viên cũ (trộn từ đây):',
	'usermerge-newuser' => 'Thành viên mới (trộn đến đây):',
	'usermerge-deleteolduser' => 'Xóa thành viên cũ',
	'usermerge-submit' => 'Trộn thành viên',
	'usermerge-badtoken' => 'Thẻ sửa đổi không hợp lệ',
	'usermerge-userdeleted' => '$1 ($2) đã bị xóa.',
	'usermerge-userdeleted-log' => 'Người đã xóa: $2 ($3)',
	'usermerge-updating' => 'Đang cập nhật bảng $1 ($2 sang $3)',
	'usermerge-success' => 'Việc trộn từ $1 ($2) đến $3 ($4) đã hoàn thành.',
	'usermerge-success-log' => 'Thành viên $2 ($3) đã được trộn sang $4 ($5)',
	'usermerge-logpage' => 'Nhật trình trộn thành viên',
	'usermerge-logpagetext' => 'Đây là nhật trình ghi lại các tác vụ trộn thành viên.',
	'usermerge-noselfdelete' => 'Bạn không thể xóa hoặc trộn từ chính bạn!',
	'usermerge-unmergable' => 'Không thể trộn từ thành viên này - mã số hoặc tên đã được định nghĩa là không thể trộn.',
	'usermerge-protectedgroup' => 'Không thể trộn từ thành viên này - thành viên này thuộc nhóm được bảo vệ.',
	'right-usermerge' => 'Trộn thành viên',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'usermerge-badolduser' => 'Gebananem büik no lonöfon',
	'usermerge-badnewuser' => 'Gebananem nulik no lonöfon',
	'usermerge-noolduser' => 'Vagükön gebananemi büik',
	'usermerge-deleteolduser' => 'Moükön gebani vönedik',
	'usermerge-userdeleted' => '$1 ($2) pemoükon.',
	'usermerge-userdeleted-log' => 'Moükön gebani: $2 ($3)',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'usermerge' => '用戶合併同刪除',
	'usermerge-badolduser' => '無效嘅舊用戶名',
	'usermerge-badnewuser' => '無效嘅新用戶名',
	'usermerge-nonewuser' => '清除新用戶名 - 假設合併到$1。<br />撳<u>合併用戶</u>去接受。',
	'usermerge-noolduser' => '清除舊用戶名',
	'usermerge-olduser' => '舊用戶 (合併自)',
	'usermerge-newuser' => '新用戶 (合併到)',
	'usermerge-deleteolduser' => '刪舊用戶？',
	'usermerge-submit' => '合併用戶',
	'usermerge-badtoken' => '無效嘅編輯幣',
	'usermerge-userdeleted' => '$1($2) 已經刪除咗。',
	'usermerge-updating' => '更新緊 $1 表 ($2 到 $3)',
	'usermerge-success' => '由 $1($2) 到 $3($4) 嘅合併已經完成。',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Gzdavidwong
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'usermerge' => '用户合并和删除',
	'usermerge-badolduser' => '无效的旧用户名',
	'usermerge-badnewuser' => '无效的新用户名',
	'usermerge-nonewuser' => '清除新用户名 - 假设合并到$1。<br />点击<u>合并用户</u>以接受。',
	'usermerge-noolduser' => '清除旧用户名',
	'usermerge-fieldset' => '使用者名称合并',
	'usermerge-olduser' => '旧用户（合并自）：',
	'usermerge-newuser' => '新用户（合并到）：',
	'usermerge-deleteolduser' => '删除旧用户',
	'usermerge-submit' => '合并用户',
	'usermerge-badtoken' => '无效的编辑币',
	'usermerge-userdeleted' => '$1（$2） 已删除。',
	'usermerge-userdeleted-log' => '已删除的用户： $2 （$3）',
	'usermerge-updating' => '正在更新 $1 表格 （$2 到 $3）',
	'usermerge-success' => '由 $1（$2） 到 $3（$4） 的合并已经完成。',
	'usermerge-success-log' => '用户 $2 （$3） 合并到 $4 （$5）',
	'usermerge-logpage' => '用户合并日志',
	'usermerge-logpagetext' => '这是一份用户合并动作的记录。',
	'usermerge-noselfdelete' => '您不能将自己删除或者合并！',
	'usermerge-unmergable' => '无法完成用户合并 - ID或者名称被标记为不可合并。',
	'usermerge-protectedgroup' => '无法完成用户合并 - 用户位于受保护组中。',
	'right-usermerge' => '合并用户',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'usermerge' => '用戶合併和刪除',
	'usermerge-badolduser' => '無效的舊用戶名',
	'usermerge-badnewuser' => '無效的新用戶名',
	'usermerge-nonewuser' => '清除新用戶名 - 假設合併到$1。<br />點擊<u>合併用戶</u>以接受。',
	'usermerge-noolduser' => '清除舊用戶名',
	'usermerge-fieldset' => '使用者名稱合併',
	'usermerge-olduser' => '舊用戶（合併自）：',
	'usermerge-newuser' => '新用戶（合併到）：',
	'usermerge-deleteolduser' => '刪除舊用戶',
	'usermerge-submit' => '合併用戶',
	'usermerge-badtoken' => '無效的編輯幣',
	'usermerge-userdeleted' => '$1（$2） 已刪除。',
	'usermerge-userdeleted-log' => '已刪除的用戶： $2 （$3）',
	'usermerge-updating' => '正在更新 $1 表格 （$2 到 $3）',
	'usermerge-success' => '由 $1（$2） 到 $3（$4） 的合併已經完成。',
	'usermerge-success-log' => '用戶 $2 （$3） 合併到 $4 （$5）',
	'usermerge-logpage' => '使用者合併記錄',
	'usermerge-logpagetext' => '這是一份用戶合併動作的記錄。',
	'usermerge-noselfdelete' => '您不能將自己刪除或者合併！',
	'usermerge-unmergable' => '無法完成用戶合併 - ID 或者名稱被標記為不可合併。',
	'usermerge-protectedgroup' => '無法完成用戶合併 - 用戶位於受保護群組中。',
	'right-usermerge' => '合併使用者',
);

/** Chinese (Taiwan) (‪中文(台灣)‬)
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'usermerge' => '用戶合併及刪除',
	'usermerge-badolduser' => '無效的舊用戶名',
	'usermerge-badnewuser' => '無效的新用戶名',
);

