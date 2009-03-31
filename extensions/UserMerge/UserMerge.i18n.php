<?php
#coding: utf-8
/** \file
* \brief Internationalization file for the User Merge and Delete Extension.
*/

$messages = array();

$messages['en'] = array(
	'usermerge'                     => 'Merge and delete users',
	'usermerge-desc'                => "[[Special:UserMerge|Merges references from one user to another user]] in the wiki database - will also delete old users following merge. Requires ''usermerge'' privileges",
	'usermerge-badolduser' 		=> 'Invalid old username',
	'usermerge-badnewuser' 		=> 'Invalid new username',
	'usermerge-nonewuser' 		=> 'Empty new username - assuming merge to $1.<br />
Click <u>Merge User</u> to accept.',
	'usermerge-noolduser' 		=> 'Empty old username',
	'usermerge-olduser' 		=> 'Old user (merge from)',
	'usermerge-newuser' 		=> 'New user (merge to)',
	'usermerge-deleteolduser' 	=> 'Delete old user?',
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
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Meno25
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'usermerge-desc' => 'Shown in [[Special:Version]] as a short description of this extension.{{doc-important|Do not translate links.}}',
	'usermerge-badtoken' => '{{Identical|Invalid edit token}}',
	'right-usermerge' => '{{doc-right}}',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'usermerge' => 'دمج وحذف المستخدمين',
	'usermerge-desc' => "[[Special:UserMerge|يدمج المراجع من مستخدم إلى آخر]] في قاعدة بيانات الويكي - سيحذف أيضا المستخدمين القدامى بعد الدمج. يتطلب صلاحيات ''usermerge''",
	'usermerge-badolduser' => 'اسم المستخدم القديم غير صحيح',
	'usermerge-badnewuser' => 'اسم المستخدم الجديد غير صحيح',
	'usermerge-nonewuser' => 'اسم مستخدم جديد فارغ - افتراض الدمج إلى $1.<br />
اضغط <u>دمج المستخدم</u> للقبول.',
	'usermerge-noolduser' => 'اسم المستخدم القديم فارغ',
	'usermerge-olduser' => 'مستخدم قديم (دمج من)',
	'usermerge-newuser' => 'مستخدم جديد (دمج إلى)',
	'usermerge-deleteolduser' => 'حذف المستخدم القديم؟',
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
اضغط <u>دمج اليوزر</u> للقبول.',
	'usermerge-noolduser' => 'اسم اليوزر القديم فارغ',
	'usermerge-olduser' => 'يوزر قديم (دمج من)',
	'usermerge-newuser' => 'يوزر جديد (دمج ل)',
	'usermerge-deleteolduser' => 'حذف اليوزر القديم؟',
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

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'usermerge' => "Аб'яднаньне і выдаленьне рахункаў удзельнікаў",
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
	'usermerge-olduser' => 'Стар потребител (за сливане от)',
	'usermerge-newuser' => 'Нов потребител (за сливане в)',
	'usermerge-deleteolduser' => 'Изтриване на стария потребител?',
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
 * @author Zaheen
 */
$messages['bn'] = array(
	'usermerge' => 'ব্যবহারকারী একত্রীকরণ এবং মুছে ফেলা',
	'usermerge-desc' => "উইকি ডাটাবেজে [[Special:UserMerge|একজন ব্যবহারকারী থেকে অপর ব্যবহারকারীর প্রতি নির্দেশনাগুলি একত্রিত করে]] - এছাড়া একত্রীকরণের পরে পুরনো ব্যবহারকারীদের মুছে দেবে। বিশেষ ''usermerge'' অধিকার আবশ্যক",
	'usermerge-badolduser' => 'অবৈধ পুরনো ব্যবহারকারী নাম',
	'usermerge-badnewuser' => 'অবৈধ নতুন ব্যবহারকারী নাম',
	'usermerge-nonewuser' => 'খালি নতুন ব্যবহারকারী নাম - $1-এর সাথে একত্রীকরণ করা হচ্ছে ধরা হলে। <br /><u>ব্যবহারকারী একত্রিত করা হোক</u> ক্লিক করে সম্মতি দিন।',
	'usermerge-noolduser' => 'খালি পুরনো ব্যবহারকারী নাম',
	'usermerge-olduser' => 'পুরনো ব্যবহারকারী (যার থেকে একত্রীকরণ)',
	'usermerge-newuser' => 'নতুন ব্যবহারকারী (যার সাথে একত্রীকরণ)',
	'usermerge-deleteolduser' => 'পুরনো ব্যবহারকারী মুছে ফেলা হোক?',
	'usermerge-submit' => 'ব্যবহারকারী একত্রিত করা হোক',
	'usermerge-badtoken' => 'সম্পাদনা টোকেন অবৈধ',
	'usermerge-userdeleted' => '$1 ($2) মুছে ফেলা হয়েছে।',
	'usermerge-userdeleted-log' => 'ব্যবহারকারী মুছে ফেলে হয়েছে: $2 ($3)',
	'usermerge-updating' => '$1 টেবিল হালনাগাদ করা হচ্ছে ($2 থেকে $3-তে)',
	'usermerge-success' => '$1 ($2) থেকে $3 ($4)-তে একত্রীকরণ সম্পন্ন হয়েছে।',
	'usermerge-success-log' => 'ব্যবহারকারী $2 ($3)-কে $4 ($5)-এর সাথে একত্রিত করা হয়েছে',
	'usermerge-logpage' => 'ব্যবহারকারী একত্রীকরণ লগ',
	'usermerge-logpagetext' => 'এটি ব্যবহারকারী একত্রীকরণ ক্রিয়াসমূহের একটি লগ',
	'usermerge-noselfdelete' => 'আপনি নিজের ব্যবহারকারী নাম মুছে ফেলতে বা এটি থেকে অন্য নামে একত্রিত করতে পারবেন না!',
	'usermerge-unmergable' => 'ব্যবহারকারী নাম থেকে একত্রিত করা যায়নি - আইডি বা নামটি একত্রীকরণযোগ্য নয় হিসেবে সংজ্ঞায়িত।',
	'usermerge-protectedgroup' => 'ব্যবহারকারী নাম থেকে একত্রিত করা যায়নি - ব্যবহারকারীটি একটি সুরক্ষিত দলে আছেন।',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'usermerge' => 'Kendeuziñ an implijer ha diverkañ',
	'usermerge-desc' => "[[Special:UserMerge|Kendeuziñ a ra daveennoù un implijer gant re unan bennak all]] e diaz titouroù ar wiki - diverkañ a raio ivez ar c'hendeuzadennoù implijer kozh da zont. Rekis eo kaout aotreoù ''kendeuziñ''",
	'usermerge-badolduser' => 'Anv implijer kozh direizh',
	'usermerge-badnewuser' => 'Anv implijer nevez direizh',
	'usermerge-nonewuser' => "Anv implijer nevez goullo - soñjal a ra deomp e fell deoc'h kendeuziñ davet $1.<br />Klikañ war <u>Kendeuziñ implijer</u> evit asantiñ.",
	'usermerge-noolduser' => 'Anv implijer kozh goullo',
	'usermerge-olduser' => 'Implijer kozh (kendeuziñ adal)',
	'usermerge-newuser' => 'Implijer nevez (kendeuziñ davet)',
	'usermerge-deleteolduser' => 'Diverkañ an implijer kozh ?',
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
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'usermerge' => 'Sloučuvání a mazání uživatelů',
	'usermerge-desc' => "[[Special:UserMerge|Slučuje odkazy na jednoho uživatele na odkazy na druhého]] v databázi wiki; také následně smaže starého uživatele. Vyžaduje oprávnění ''usermerge''.",
	'usermerge-badolduser' => 'Neplatné staré uživatelské jméno',
	'usermerge-badnewuser' => 'Neplatné nové uživatelské jmnéo',
	'usermerge-nonewuser' => 'Prázdné nové uživatelské jméno',
	'usermerge-noolduser' => 'Prázdné staré uživatelské jméno',
	'usermerge-olduser' => 'Starý uživatel (sloučit odsud)',
	'usermerge-newuser' => 'Nový uživatel (sloučit sem)',
	'usermerge-deleteolduser' => 'Smazat starého uživatele?',
	'usermerge-submit' => 'Sloučit uživatele',
	'usermerge-badtoken' => 'Neplatný editační token',
	'usermerge-userdeleted' => '$1 ($2) byl smazán.',
	'usermerge-userdeleted-log' => 'Smazaný uživatel: $2 ($3)',
	'usermerge-updating' => 'Aktualizuje se tabulka $1 ($2 na $3)',
	'usermerge-success' => 'Sloučení z $1 ($2) do $3 ($4) je dokončeno.',
	'usermerge-success-log' => 'Uživatel $2 ($3) byl sloučen do $4 ($5)',
	'usermerge-logpage' => 'Záznam sloučení uživatelů',
	'usermerge-logpagetext' => 'Toto je záznam sloučení uživatelů.',
	'usermerge-noselfdelete' => 'Nemůžete smazat nebo sloučit svůj účet!',
	'usermerge-unmergable' => 'Nebylo možné sloučit uživatele - zdrojové jméno nebo ID bylo definováno jako neslučitelné.',
	'usermerge-protectedgroup' => 'Nebylo možné sloučit uvedeného uživatele - uživatel je v chráněné skupině.',
	'right-usermerge' => 'Slučovat uživatele',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'usermerge' => 'Benutzerkonten zusammenführen und löschen',
	'usermerge-desc' => "[[Special:UserMerge|Führt Benutzerkonten in der Wiki-Datenbank zusammen]] - das alte Benutzerkonto wird nach der Zusammenführung gelöscht. Erfordert das ''usermerge''-Recht.",
	'usermerge-badolduser' => 'Ungültiger alter Benutzername',
	'usermerge-badnewuser' => 'Ungültiger neuer Benutzername',
	'usermerge-nonewuser' => 'Leerer neuer Benutzername - es wird eine Zusammenführung mit „$1“ vermutet.<br />
Klicke auf <u>Benutzerkonten zusammenführen</u> zum Ausführen.',
	'usermerge-noolduser' => 'Leerer alter Benutzername',
	'usermerge-olduser' => 'Alter Benutzername (zusammenführen von)',
	'usermerge-newuser' => 'Neuer Benutzername (zusammenführen nach)',
	'usermerge-deleteolduser' => 'Alten Benutzernamen löschen?',
	'usermerge-submit' => 'Benutzerkonten zusammenführen',
	'usermerge-badtoken' => 'Ungültiges Bearbeiten-Token',
	'usermerge-userdeleted' => '„$1“ ($2) wurde gelöscht.',
	'usermerge-userdeleted-log' => 'Gelöschter Benutzername: „$2“ ($3)',
	'usermerge-updating' => 'Aktualisierung $1 Tabelle ($2 nach $3)',
	'usermerge-success' => 'Die Zusammenführung von „$1“ ($2) nach „$3“ ($4) ist vollständig.',
	'usermerge-success-log' => 'Benutzername „$2“ ($3) zusammengeführt mit „$4“ ($5)',
	'usermerge-logpage' => 'Benutzerkonten-Zusammenführungs-Logbuch',
	'usermerge-logpagetext' => 'Dies ist das Logbuch der Benutzerkonten-Zusammenführungen.',
	'usermerge-noselfdelete' => 'Zusammenführung mit sich selber ist nicht möglich!',
	'usermerge-unmergable' => 'Zusammenführung nicht möglich - ID oder Benutzername wurde als nicht zusammenführbar definiert.',
	'usermerge-protectedgroup' => 'Zusammenführung nicht möglich - Benutzername ist in einer geschützen Gruppe.',
	'right-usermerge' => 'Benutzerkonten vereinen',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'usermerge-deleteolduser' => 'Διαγραφή παλαιού χρήστη;',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'usermerge' => 'Kunigi kaj forigi uzantojn',
	'usermerge-badolduser' => 'Nevalida malnova salutnomo',
	'usermerge-badnewuser' => 'Nevalida nova salutnomo',
	'usermerge-noolduser' => 'Malplena malnova salutnomo',
	'usermerge-olduser' => 'Malnova uzanto (kunigante de)',
	'usermerge-newuser' => 'Nova uzanto (kunigante al)',
	'usermerge-deleteolduser' => 'Forigi malnovan uzanton?',
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
 * @author Imre
 * @author Sanbec
 */
$messages['es'] = array(
	'usermerge' => 'Fusionar y borrar usuarios',
	'usermerge-submit' => 'Fusionar usuario',
	'usermerge-userdeleted' => '$1 ($2) ha sido borrado.',
	'usermerge-userdeleted-log' => 'Usuario borrado: $2 ($3)',
	'right-usermerge' => 'Fusionar usuarios',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Theklan
 */
$messages['eu'] = array(
	'usermerge-badolduser' => 'Baliogabeko lankide izen zaharra',
	'usermerge-badnewuser' => 'Baliogabeko lankide izen berria',
	'usermerge-noolduser' => 'Lankide izen zahar hutsa',
	'usermerge-olduser' => 'Lankide zaharra (nondik batu)',
	'usermerge-newuser' => 'Lankide berria (nora batu)',
	'usermerge-deleteolduser' => 'Ezabatu lankide zaharra?',
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
 * @author Meisam
 */
$messages['fa'] = array(
	'usermerge' => 'ادغام و پاک‌کردن کاربران',
	'usermerge-badolduser' => 'نام کاربری قدیمی نامعتبر',
	'usermerge-badnewuser' => 'نام کاربری جدید نامعتبر',
	'usermerge-noolduser' => 'نام‌کاربری قدیمی خالی',
	'usermerge-olduser' => 'کاربر قدیمی (ادغام از)',
	'usermerge-newuser' => 'کاربر جدید (ادغام با)',
	'usermerge-deleteolduser' => 'کاربر قدیمی پاک‌شود؟',
	'usermerge-submit' => 'ادغام کاربر',
	'usermerge-userdeleted' => '$1 ($2) پاک شد.',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'usermerge' => 'Käyttäjätunnusten yhdistys ja poisto',
	'usermerge-badolduser' => 'Vanha käyttäjätunnus ei kelpaa',
	'usermerge-badnewuser' => 'Uusi käyttäjätunnus ei kelpaa',
	'usermerge-noolduser' => 'Vanha käyttäjätunnus ei voi olla tyhjä.',
	'usermerge-olduser' => 'Vanha käyttäjä (mikä yhdistetään)',
	'usermerge-newuser' => 'Uusi käyttäjä (mihin yhdistetään)',
	'usermerge-deleteolduser' => 'Poista vanha käyttäjä?',
	'usermerge-userdeleted' => '$1 ($2) on poistettu.',
	'usermerge-userdeleted-log' => 'Poistettiin käyttäjä: $2 ($3)',
	'usermerge-success-log' => 'Käyttäjä $2 ($3) yhdistettiin käyttäjään $4 ($5)',
	'right-usermerge' => 'Yhdistää käyttäjiä',
);

/** French (Français)
 * @author Grondin
 * @author Guillom
 * @author IAlex
 * @author McDutchie
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'usermerge' => 'Fusionner utilisateur et détruire',
	'usermerge-desc' => "[[Special:UserMerge|Fusionne les références d’un utilisateur vers un autre]] dans la base de données wiki - supprimera aussi les anciens utilisateurs après la fusion. Nécessite le privilège ''usermerge''",
	'usermerge-badolduser' => "Ancien nom d'utilisateur invalide",
	'usermerge-badnewuser' => "Nouveau nom d'utilisateur invalide",
	'usermerge-nonewuser' => "Nouveau nom d'utilisateur vide. Nous faisons l'hypothèse que vous voulez fusionner dans $1.

Cliquez sur ''Fusionner utilisateur'' pour accepter.",
	'usermerge-noolduser' => "Ancien nom d'utilisateur vide",
	'usermerge-olduser' => 'Ancien utilisateur (fusionner depuis)',
	'usermerge-newuser' => 'Nouvel utilisateur (fusionner dans)',
	'usermerge-deleteolduser' => 'Détruire l’ancien utilisateur ?',
	'usermerge-submit' => 'Fusionner utilisateur',
	'usermerge-badtoken' => 'Jeton d’édition invalide',
	'usermerge-userdeleted' => '$1($2) est détruit.',
	'usermerge-userdeleted-log' => 'Contributeur effacé : $2($3)',
	'usermerge-updating' => 'Mise à jour de la table $1 (de $2 à $3)',
	'usermerge-success' => 'La fusion de $1($2) à $3($4) est terminée.',
	'usermerge-success-log' => 'Contributeur $2($3) fusionné avec $4($5)',
	'usermerge-logpage' => 'Journal des fusions de contributeurs',
	'usermerge-logpagetext' => 'Ceci est un journal des actions de fusions de contributeurs.',
	'usermerge-noselfdelete' => 'Vous ne pouvez pas vous supprimer ou vous fusionner vous-même !',
	'usermerge-unmergable' => "Ne peut fusionner à partir d'un utilisateur, d'un numéro d'identification ou un nom qui ont été définis comme non fusionnables.",
	'usermerge-protectedgroup' => "Impossible de fusionner à partir d'un utilisateur - l'utilisateur se trouve dans un groupe protégé.",
	'right-usermerge' => 'Fusionner des utilisateurs',
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
	'usermerge-nonewuser' => 'Novo nome de usuario baleiro - asumindo que se fusionan para $1.<br />
Prema en <u>Fusionar o usuario</u> para aceptar.',
	'usermerge-noolduser' => 'Antigo nome de usuario baleiro',
	'usermerge-olduser' => 'Antigo usuario (fusionar desde)',
	'usermerge-newuser' => 'Novo usuario (fusionar a)',
	'usermerge-deleteolduser' => 'Eliminar o antigo usuario?',
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
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'usermerge' => 'מיזוג ומחיקת משתמשים',
	'usermerge-desc' => "[[Special:UserMerge|מיזוג התייחסויות ממשתמש אחד לאחר]] בבסיס הנתונים של הוויקי, כולל מחיקת המשתמשים הישנים לאחר המיזוג. נדרשת הרשאת ''usermerge''",
	'usermerge-badolduser' => 'שם המשתמש הישן אינו תקין',
	'usermerge-badnewuser' => 'שם המשתמש החדש אינו תקין',
	'usermerge-nonewuser' => 'שם המשתמש החדש ריק - כנראה שהמיזוג הוא ל$1.<br />
אם זה נכון, נא לחצו על <u>מיזוג משתמש</u>.',
	'usermerge-noolduser' => 'שם המשתמש הישן ריק',
	'usermerge-olduser' => 'משתמש ישן (מיזוג מ)',
	'usermerge-newuser' => 'משתמש חדש (מיזוג ל)',
	'usermerge-deleteolduser' => 'למחוק את המשתמש הישן?',
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
	'usermerge-nonewuser' => 'Nowe wužiwarske mjeno faluje - najskerje ma so z $1 zjednoćić.<br /> Klikń na <u>Wužiwarske konta zjednoćić</u>, zo by potwerdźił.',
	'usermerge-noolduser' => 'Falowace stare wužiwarske mjeno',
	'usermerge-olduser' => 'Stare wužiwarske konto (Zjednoćić wot)',
	'usermerge-newuser' => 'Nowe wužiwarske konto (Zjednoćić do)',
	'usermerge-deleteolduser' => 'Stare wužiwarske mjeno zničić?',
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
);

/** Haitian (Kreyòl ayisyen)
 * @author Masterches
 */
$messages['ht'] = array(
	'usermerge' => 'Mèt ansanm kont itilizatè yo ak efase tou',
	'usermerge-desc' => '[[Special:UserMerge|Mèt ansanm referans yo depi yon itilizatè nan referans yon lòt itilizatè]] nan baz done wiki a - l ap efase tou vye non itilizatè yo apre fizyon, reyinyon sa. Ou dwèt genyen dwa pou fè fizyon sa.',
	'usermerge-badolduser' => 'Lòt vyen non itilizatè ou an pa bon, li pa korèk, genyen yon erè anndan l.',
	'usermerge-badnewuser' => 'Nouvo non itilizatè ou chwazi an pa bon, li pa korèk, genyen yon erè anndan l',
	'usermerge-nonewuser' => 'Efase nouvo non itilizatè - depi ou vle mèt ansanm kont ou an ak $1.<br />
Klike (prese) <u>Mèt ansanm kont Itilizatè</u> pou aksepte operasyon an.',
	'usermerge-noolduser' => 'Efase vye non itilizatè an',
	'usermerge-olduser' => 'Ansyen non itilizatè (mèt ansanm)',
	'usermerge-newuser' => 'Nouvo non itilizatè (mèt ansanm)',
	'usermerge-deleteolduser' => 'Efase ansyen, vye non itilizatè a ?',
	'usermerge-submit' => 'Mèt ansanm kont itilizatè yo',
	'usermerge-badtoken' => 'Edisyon ou fè an pa bon, li pa korèk, genyen yon erè nan operasyon an',
	'usermerge-userdeleted' => '$1 ($2) efase.',
	'usermerge-userdeleted-log' => 'Non itilizatè ki efase a: $2 ($3)',
	'usermerge-updating' => 'Mèt a jou, modifye tab $1 (depi $2 jouk $3)',
	'usermerge-success' => 'Nou rive mèt ansanm $1 ($2) ak $3 ($4), depi premye kont an.',
	'usermerge-success-log' => 'Itilizatè $2 ($3) fizyone ak $4 ($5)',
	'usermerge-logpage' => 'Jounal itilizatè pou referans fizyon, "mèt ansanm kont itilizatè yo"',
	'usermerge-logpagetext' => "Men jounal ki ap reprann tout aksyon ki fèt nan seksyon 'Mete ansanm kont itilizatè yo, fizyone yo'.",
	'usermerge-noselfdelete' => 'Ou pa kapab efase tèt ou oubyen mèt yon lòt kont sou tèt ou, depi kont ou an menm.',
	'usermerge-unmergable' => 'Nou pa kapab mèt ansanm kont sa yo - ID an oubyen non an pa kapab mete ansanm, li sanble l make nan definisyon yo.',
	'usermerge-protectedgroup' => 'Nou pa kapab mèt ansanm kont itilizatè yo - itilizatè sa a nan yon gwoup ki pwoteje.',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
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
Clicca <u>Fusionar usator</u> pro acceptar.',
	'usermerge-noolduser' => 'Nomine de usator ancian vacue',
	'usermerge-olduser' => 'Ancian usator (fusionar ab)',
	'usermerge-newuser' => 'Nove usator (fusionar verso)',
	'usermerge-deleteolduser' => 'Deler ancian usator?',
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
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'usermerge' => 'Penggabungan dan penghapusan Pengguna',
	'usermerge-desc' => "[[Special:UserMerge|Menggabungkan rekam jejak dari suatu pengguna ke pengguna lain]] di basis data wiki - sekaligus menghapus pengguna lama setelah selesai digabungkan. Tindakan ini memerlukan hak ''usermerge''.",
	'usermerge-badolduser' => 'Nama pengguna lama tidak sah',
	'usermerge-badnewuser' => 'Nama pengguna baru tidak sah',
	'usermerge-nonewuser' => 'Nama pengguna baru tidak dituliskan - diasumsikan akan digabungkan ke $1.<br />
Klik <u>Gabungkan Pengguna</u> untuk melanjutkan.',
	'usermerge-noolduser' => 'Nama pengguna lama tidak diisi',
	'usermerge-olduser' => 'Pengguna lama (digabungkan dari)',
	'usermerge-newuser' => 'Pengguna baru (digabungkan ke)',
	'usermerge-deleteolduser' => 'Hapus pengguna lama?',
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
	'right-usermerge' => 'Gabungkan pengguna',
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
	'usermerge-nonewuser' => "Nuovo nome utente vuoto - l'unione verrà effettuata con l'utente $1.<br />
Fai clic su <u>Unisci Utente</u> per accettare.",
	'usermerge-noolduser' => 'Vecchio nome utente vuoto',
	'usermerge-olduser' => 'Vecchio utente (unisci da)',
	'usermerge-newuser' => 'Nuovo utente (unisci a)',
	'usermerge-deleteolduser' => 'Cancellare vecchio utente?',
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
 * @author Mzm5zbC3
 */
$messages['ja'] = array(
	'usermerge' => '利用者の統合と削除',
	'usermerge-desc' => "ウィキデータベース上における[[Special:UserMerge|一人の利用者を別の利用者へ統合する]] - また統合元の利用者を削除する（''usermerge''の権限が必要）",
	'usermerge-badolduser' => '無効な旧利用者名',
	'usermerge-badnewuser' => '無効な新利用者名',
	'usermerge-nonewuser' => '新しい利用者名の欄が空です - $1に統合します。<br />
<u>利用者の統合</u>をクリックしてください。',
	'usermerge-noolduser' => '旧利用者名の欄が空です',
	'usermerge-olduser' => '旧利用者（統合元）',
	'usermerge-newuser' => '新利用者（統合先）',
	'usermerge-deleteolduser' => '統合元の利用者を削除しますか?',
	'usermerge-submit' => '利用者の統合',
	'usermerge-badtoken' => '無効な編集証拠',
	'usermerge-userdeleted' => '$1 ($2) は削除されました。',
	'usermerge-userdeleted-log' => '利用者: $2 ($3) を削除しました。',
	'usermerge-updating' => '$1 のテーブルを更新 ($2 を $3 へ)',
	'usermerge-success' => '$1 ($2) を $3 ($4) へ安全に統合しました。',
	'usermerge-success-log' => '$2 ($3) を $4 ($5) へ利用者を統合しました。',
	'usermerge-logpage' => '利用者統合記録',
	'usermerge-logpagetext' => 'これは、利用者の統合を記録したものです。',
	'usermerge-noselfdelete' => 'あなたは、自分から統合・削除をすることはできません!',
	'usermerge-unmergable' => '利用者を統合することができません - IDまたは名前が統合不可能です。',
	'usermerge-protectedgroup' => '利用者を統合できません - この利用者は、保護の対象となるグループです。',
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
Klik <u>Gabungaké Panganggo</u> kanggo nerusaké.',
	'usermerge-noolduser' => 'Jeneng panganggo sing lawas kosong',
	'usermerge-olduser' => 'Panganggo lawas (digabungaké saka)',
	'usermerge-newuser' => 'Panganggo anyar (digabungaké menyang)',
	'usermerge-deleteolduser' => 'Busak panganggo lawas?',
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
 */
$messages['km'] = array(
	'usermerge' => 'បញ្ចូលរួមគ្នានិង​លុបអ្នកប្រើប្រាស់',
	'usermerge-badolduser' => 'ឈ្មោះអ្នកប្រើប្រាស់ចាស់មិនត្រឹមត្រូវទេ',
	'usermerge-badnewuser' => 'ឈ្មោះអ្នកប្រើប្រាស់ថ្មីមិនត្រឹមត្រូវទេ',
	'usermerge-olduser' => 'អ្នកប្រើប្រាស់ចាស់ (បញ្ចូលរួមគ្នាពី)',
	'usermerge-newuser' => 'អ្នកប្រើប្រាស់ថ្មី (បញ្ចូលរួមគ្នាទៅ)',
	'usermerge-deleteolduser' => 'លុបអ្នកប្រើប្រាស់ចាស់ឬ?',
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
	'usermerge-deleteolduser' => '이전의 계정을 삭제하시겠습니까?',
	'usermerge-submit' => '계정 합치기',
	'usermerge-userdeleted-log' => '$2 ($3) 사용자를 삭제함',
	'usermerge-success-log' => '$2 ($3) 사용자를 $4 ($5) 로 병합함',
	'usermerge-logpage' => '사용자 병합 기록',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'usermerge' => 'Metmaacher zosammelääje un fött schmiiße',
	'usermerge-desc' => '[[Special:UserMerge|Läät de Date fun einem Metmaacher met anem andere Metmaacher komplät zosamme]] en dem Wiki singe Datebank, un kann donoh och de övverhollte Metmaacher fottschmieße. Doför bruch mer et „{{int:right-usermerge}}“ (<i lang="en">usermerge</i>) Rääsch.',
	'usermerge-badolduser' => 'Dä ahle Metmaachername es nit jöltesch',
	'usermerge-badnewuser' => 'Dä neue Metmaachername es nit jöltesch',
	'usermerge-nonewuser' => 'keine neue Metmaachername aanjejovve. Mer vermoode, dat De met „$1“ zosamme lääje wells.<br />
Kleck op „<u>{{int:bbbbbbbbbb}}</u>“ öm dat esu ze maache.',
	'usermerge-noolduser' => 'Keine ahle Metmaachername aanjejovve',
	'usermerge-olduser' => '
Dä ahle Metmaachername (Zosamme lääje fun&nbsp;…)',
	'usermerge-newuser' => 'Dä neu Metmaachername (Zosamme lääje noh …)',
	'usermerge-deleteolduser' => 'Dä ahle Metmaacher fott schmieße?',
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
 * @author Robby
 */
$messages['lb'] = array(
	'usermerge' => 'Benotzerkonten zesummeféieren a läschen',
	'usermerge-desc' => "[[Special:UserMerge|Féiert Benotzerkonten vun engem Benotzer op en anere Benotzer]] an der Wiki-Datebank zusammen - déi al Benotzerkonte ginn no der Zesummeféierung och geläscht. Erfuedert ''usermerge''-Rechter.",
	'usermerge-badolduser' => 'Ongëltegen ale Benotzernumm',
	'usermerge-badnewuser' => 'Ongëltegen neie Benotzernumm',
	'usermerge-nonewuser' => 'Eidele neie Benotzernumm - wahrscheinlech eng Zesummeféierung matt "$1".<br />
Klickt op <u>Benotzerkonten zesammeféieren</u> wann Dir d\'accord sidd.',
	'usermerge-noolduser' => 'Eidelen ale Benotzernumm',
	'usermerge-olduser' => 'Ale Benotzer (zesummeféiere vun)',
	'usermerge-newuser' => 'Neie Benotzer (zusammenféiere mat)',
	'usermerge-deleteolduser' => 'Ale Benotzer läschen?',
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
);

/** Macedonian (Македонски)
 * @author Brest
 */
$messages['mk'] = array(
	'usermerge' => 'Спојување и бришење корисници',
	'usermerge-submit' => 'Спојување корисник',
	'usermerge-badtoken' => 'Погрешен токен за уредување',
	'usermerge-userdeleted' => '$1 ($2) беше избришано.',
	'usermerge-userdeleted-log' => 'Избришан корисник: $2 ($3)',
	'usermerge-logpage' => 'Дневник на спојувања на кориснички сметки',
	'usermerge-logpagetext' => 'Ова е дневник на акции за спојување на кориснички имиња.',
	'right-usermerge' => 'Спојување на корисници',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'usermerge-badolduser' => 'അസാധുവായ പഴയ ഉപയോക്തൃനാമം',
	'usermerge-badnewuser' => 'അസാധുവായ പുതിയ ഉപയോക്തൃനാമം',
	'usermerge-noolduser' => 'പഴയ ഉപയോക്തൃനാമം ശൂന്യമാക്കുക',
	'usermerge-olduser' => 'പഴയ ഉപയോക്തൃനാമം (ലയിപ്പിക്കാനുള്ളത്)',
	'usermerge-newuser' => 'പുതിയ ഉപയോക്തൃനാമം (ഇതിലേക്കു സം‌യോജിപ്പിക്കണം)',
	'usermerge-deleteolduser' => 'പഴയ ഉപയോക്താവിനെ മായ്ക്കട്ടെ?',
	'usermerge-submit' => 'ഉപയോക്താവിനെ സം‌യോജിപ്പിക്കുക',
	'usermerge-userdeleted' => '$1 ($2) മായ്ച്ചു.',
	'usermerge-userdeleted-log' => 'ഉപയോക്താവിനെ മായ്ച്ചു: $2 ($3)',
	'usermerge-updating' => '$1 പട്ടിക ($2 to $3) പുതുക്കുന്നു',
	'usermerge-success' => '$1 ($2) നെ $3 ($4) ലേക്കു സം‌യോജിപ്പിക്കുന്ന പ്രക്രിയ പൂര്‍ത്തിയായി.',
	'usermerge-success-log' => '$2 ($3) എന്ന ഉപയോക്താവിനെ $4 ($5)ലേക്കു സം‌യോജിപ്പിച്ചു',
	'usermerge-logpage' => 'ഉപയോക്തൃസം‌യോജന പ്രവര്‍ത്തനരേഖ',
	'usermerge-logpagetext' => 'ഉപയോക്താക്കളെ സം‌യോജിപ്പിച്ചതിന്റെ പ്രവര്‍ത്തനരേഖയാണിത്',
	'usermerge-noselfdelete' => 'താങ്കള്‍ക്ക് താങ്കളെത്തന്നെ മായ്ക്കാനോ, മറ്റൊരു അക്കുണ്ടിലേക്കു സം‌യോജിപ്പിക്കാനോ പറ്റില്ല!',
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

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'usermerge-badolduser' => 'Ahcualli huēhuehtlatequitiltilīltōcāitl',
	'usermerge-badnewuser' => 'Ahcualli yancuīc tlatequitiltilīltōcāitl',
	'usermerge-userdeleted' => '$1 ($2) ōmopolo',
	'usermerge-userdeleted-log' => 'Tlapoloc tlatequitiltilīlli: $2 ($3)',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'usermerge' => 'Gebruikers samenvoegen en verwijderen',
	'usermerge-desc' => "Voegt een [[Special:UserMerge|speciale pagina]] toe om gebruikers samen te voegen en de oude gebruiker(s) te verwijderen (hiervoor is het recht ''usermerge'' nodig)",
	'usermerge-badolduser' => 'Verkeerde oude gebruiker',
	'usermerge-badnewuser' => 'Verkeerde nieuwe gebruiker',
	'usermerge-nonewuser' => 'Nieuwe gebruiker is niet ingegeven - er wordt aangenomen dat er samengevoegd moet worden naar $1.<br />
Klik <u>Gebruiker samenvoegen</u> om te aanvaarden.',
	'usermerge-noolduser' => 'Oude gebruiker is niet ingegeven',
	'usermerge-olduser' => 'Oude gebruiker (samenvoegen van)',
	'usermerge-newuser' => 'Nieuwe gebruiker (samenvoegen naar)',
	'usermerge-deleteolduser' => 'Oude gebruiker verwijderen?',
	'usermerge-submit' => 'Gebruiker samenvoegen',
	'usermerge-badtoken' => 'Ongeldig bewerkingstoken',
	'usermerge-userdeleted' => '$1($2) is verwijderd.',
	'usermerge-userdeleted-log' => 'Verwijderde gebruiker: $2($3)',
	'usermerge-updating' => 'Tabel $1 aan het bijwerken ($2 naar $3)',
	'usermerge-success' => 'Samenvoegen van $1($2) naar $3($4) is afgerond.',
	'usermerge-success-log' => 'Gebruiker $2 ($3) samengevoegd naar $4 ($5)',
	'usermerge-logpage' => 'Logboek gebruikerssamenvoegingen',
	'usermerge-logpagetext' => 'Dit is het logboek van gebruikerssamenvoegingen.',
	'usermerge-noselfdelete' => 'U kunt uzelf niet verwijderen of samenvoegen!',
	'usermerge-unmergable' => 'Deze gebruiker kan niet samengevoegd worden. De gebruikersnaam of het gebruikersnummer is ingesteld als niet samen te voegen.',
	'usermerge-protectedgroup' => 'Het is niet mogelijk de gebruikers samen te voegen. De gebruiker zit in een beschermde groep.',
	'right-usermerge' => 'Gebruikers samenvoegen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 */
$messages['nn'] = array(
	'usermerge' => 'Slå saman og slett brukarar',
	'usermerge-desc' => "Gjev høve til å [[Special:UserMerge|slå saman kontoar]] ved at alle referansar til ein brukar vert bytta ut til ein annen brukar i databasen, for så å slette den eine kontoen. Krev rett til ''usermerge''.",
	'usermerge-badolduser' => 'Gammalt brukernamn ugyldig',
	'usermerge-badnewuser' => 'Nytt brukernamn ugyldig',
	'usermerge-nonewuser' => 'Nytt brukernamn tomt &ndash; går ut frå samanslåing til $1.<br />Klikk <u>Slå saman brukarar</u> for å godta',
	'usermerge-noolduser' => 'Gammalt brukarnamn tomt',
	'usermerge-olduser' => 'Gammalt brukernamn (slå saman frå)',
	'usermerge-newuser' => 'Nytt brukernamn (slå saman til)',
	'usermerge-deleteolduser' => 'Slett gammal brukar?',
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

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'usermerge' => 'Brukersammenslåing og -sletting',
	'usermerge-desc' => "Gir muligheten til  å [[Special:UserMerge|slå sammen kontoer]] ved at alle referanser til en bruker byttes ut til en annen bruker i databasen, for så å slette den ene kontoen. Trenger rettigheten ''usermerge''.",
	'usermerge-badolduser' => 'Gammelt brukernavn ugyldig',
	'usermerge-badnewuser' => 'Nytt brukernavn ugyldig',
	'usermerge-nonewuser' => 'Nytt brukernavn tomt &ndash; antar sammenslåing til $1.<br />Klikk <u>Slå sammen brukere</u> for å godta.',
	'usermerge-noolduser' => 'Gammelt brukernavn tomt',
	'usermerge-olduser' => 'Gammelt brukernavn (slå sammen fra)',
	'usermerge-newuser' => 'Nytt brukernavn (slå sammen til)',
	'usermerge-deleteolduser' => 'Slett gammel bruker?',
	'usermerge-submit' => 'Slå sammen brukere',
	'usermerge-badtoken' => 'Ugydlgi redigeringstegn',
	'usermerge-userdeleted' => '$1 ($2) har blitt slettet.',
	'usermerge-userdeleted-log' => 'Slettet bruker: $2 ($3)',
	'usermerge-updating' => 'Oppdaterer $1-tabell ($2 til $3)',
	'usermerge-success' => 'Sammenslåing fra $1 ($2) til $3 ($4) er ferdig.',
	'usermerge-success-log' => 'Brukeren $2 ($3) slått sammen med $4 ($5)',
	'usermerge-logpage' => 'Brukersammenslåingslogg',
	'usermerge-logpagetext' => 'Dette er en logg over brukersammenslåinger.',
	'usermerge-noselfdelete' => 'Du kan ikke slette eller slå sammen din egen konto!',
	'usermerge-unmergable' => 'Kan ikke slå sammen den gamle kontoen. ID-en eller navnet anses som ikke-sammenslåbart.',
	'usermerge-protectedgroup' => 'Kan ikke slå sammen den gamle kontoen. Brukeren er medlem i en beskyttet brukergruppe.',
	'right-usermerge' => 'Slå sammen kontoer',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'usermerge' => 'Fusionar utilizaire e destruire',
	'usermerge-desc' => "[[Special:UserMerge|Fusiona las referéncias d'un utilizaire cap a un autre]] dins la banca de donadas wiki - suprimirà tanben las fusions d'utilizaires ancianas seguentas.",
	'usermerge-badolduser' => "Nom d'utilizaire ancian invalid",
	'usermerge-badnewuser' => "Nom d'utilizaire novèl invalid",
	'usermerge-nonewuser' => "Nom d'utilizaire novèl void. Fasèm l'ipotèsi que volètz fusionar dins $1. Clicatz sus ''Fusionar utilizaire'' per acceptar.",
	'usermerge-noolduser' => "Nom d'utilizaire ancian void",
	'usermerge-olduser' => 'Utilizaire ancian (fusionar dempuèi)',
	'usermerge-newuser' => 'Utilizaire novèl (fusionar dins)',
	'usermerge-deleteolduser' => 'Destruire utilizaire ancian ?',
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
	'usermerge-desc' => "[[Special:UserMerge|Integruje odwołania dla jednego użytkownika do drugiego]] w bazie danych wiki – usuwa również starego użytkownika po integracji. Wymaga uprawnienia ''usermerge''",
	'usermerge-badolduser' => 'Niewłaściwa stara nazwa użytkownika',
	'usermerge-badnewuser' => 'Niewłaściwa nowa nazwa użytkownika',
	'usermerge-nonewuser' => 'Pusta nazwa nowego użytkownika – przyjęto, że nastąpi integracja do $1. <br />Naciśnij <u>Integruj użytkowników</u>, by zaakceptować.',
	'usermerge-noolduser' => 'Pusta stara nazwa użytkownika',
	'usermerge-olduser' => 'Stary użytkownik (integruj od)',
	'usermerge-newuser' => 'Nowy użytkownik (integruj z)',
	'usermerge-deleteolduser' => 'Usunąć starego użytkownika?',
	'usermerge-submit' => 'Integruj użytkowników',
	'usermerge-badtoken' => 'Nieprawidłowy żeton edycji',
	'usermerge-userdeleted' => '$1 ($2) został usunięty.',
	'usermerge-userdeleted-log' => 'usunął użytkownika „$2” ($3)',
	'usermerge-updating' => 'Odświeżanie tablicy $1 ($2 do $3)',
	'usermerge-success' => 'Integracja $1 ($2) z $3 ($4) zakończona.',
	'usermerge-success-log' => 'zintegrował użytkownika „$2” ($3) do „$4” ($5)',
	'usermerge-logpage' => 'Rejestr integracji użytkowników',
	'usermerge-logpagetext' => 'To jest rejestr operacji integracji użytkowników.',
	'usermerge-noselfdelete' => 'Nie możesz usunąć lub połączyć samego siebie!',
	'usermerge-unmergable' => 'Nie można zintegrować użytkownika – identyfikator lub nazwa zostały zdefiniowane jako nieintegrowalne.',
	'usermerge-protectedgroup' => 'Nie można zintegrować użytkownika – jest członkiem zabezpieczonej grupy.',
	'right-usermerge' => 'Scalanie użytkowników',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'usermerge' => "Union e scancelament d'utent",
	'usermerge-badolduser' => 'Vej stranòm nen bon',
	'usermerge-badnewuser' => 'Neuv stranòm nen bon',
	'usermerge-nonewuser' => "Neuv stranòm veujd - i la tnisoma bon për n'union a $1.<br />de-ie 'n colp ansima a <u>Unì Utent</u> për aceté.",
	'usermerge-noolduser' => 'Vej stranòm veujd',
	'usermerge-olduser' => 'Vej stranòm (Unì da)',
	'usermerge-newuser' => 'Neuv stranòm (Unì a)',
	'usermerge-deleteolduser' => "Veul-lo scancelé l'utent vej?",
	'usermerge-submit' => 'Unì Utent',
	'usermerge-badtoken' => "Geton d'edission nen bon",
	'usermerge-userdeleted' => "$1($2) a l'é stàit scancelà.",
	'usermerge-updating' => "Antramentr ch'i agiornoma la tàola $1 ($2 a $3)",
	'usermerge-success' => 'Union da $1($2) a $3($4) completà.',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'usermerge-badnewuser' => 'نوی کارن-نوم مو ناسم دی',
	'usermerge-deleteolduser' => 'آيا زوړ کارونکی ړنګوې؟',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 * @author Sir Lestaty de Lioncourt
 */
$messages['pt'] = array(
	'usermerge' => 'Fusão e eliminação de utilizadores',
	'usermerge-desc' => "[[Special:UserMerge|Unifica as referências de um utilizador em outro utilizador]] no banco de dados da wiki - também apagará o antigo utilizador após a fusão. Requer privilégio ''usermerge''",
	'usermerge-badolduser' => 'Nome antigo inválido',
	'usermerge-badnewuser' => 'Nome novo inválido',
	'usermerge-nonewuser' => 'Novo nome de utilizador vazio - assumida fusão com $1.<br />
Clique <u>Fundir Utilizador</u> para aceitar.',
	'usermerge-noolduser' => 'Limpar nome antigo',
	'usermerge-olduser' => 'Utilizador antigo (fundir de)',
	'usermerge-newuser' => 'Utilizador novo (fundir para)',
	'usermerge-deleteolduser' => 'Apagar utilizador antigo?',
	'usermerge-submit' => 'Limpar usuário',
	'usermerge-badtoken' => 'Ficha de edição inválida',
	'usermerge-userdeleted' => '$1 ($2) foi eliminado.',
	'usermerge-userdeleted-log' => 'Usuário eliminado: $2 ($3)',
	'usermerge-updating' => 'Actualizando tabela $1 ($2 para $3)',
	'usermerge-success' => 'Fusão de $1 ($2) para $3 ($4) está completa.',
	'usermerge-success-log' => 'Usuário $2 ($3) fundido com $4 ($5)',
	'usermerge-logpage' => 'Registo de fusão de utilizadores',
	'usermerge-logpagetext' => 'Este é um registo de acções de fusão de utilizadores.',
	'usermerge-noselfdelete' => 'Você não pode apagar ou fundir a partir de si próprio!',
	'usermerge-unmergable' => 'Não foi possível fundir o utilizador - Nome ou ID foi definido para não ser fundido.',
	'usermerge-protectedgroup' => 'Não é possível fundir este utilizador - Utilizador está em um grupo protegido',
	'right-usermerge' => 'Fundir utilizadores',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'usermerge-badolduser' => 'Nume de utilizator vechi incorect',
	'usermerge-badnewuser' => 'Nume de utilizator nou incorect',
	'usermerge-noolduser' => 'Nume de utilizator vechi gol',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Illusion
 * @author Innv
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'usermerge' => 'Объединение и удаление учётных записей',
	'usermerge-badolduser' => 'Неправильное старое имя участника',
	'usermerge-badnewuser' => 'Неправильное новое имя участника',
	'usermerge-olduser' => 'Старая учётная запись (объединить с)',
	'usermerge-newuser' => 'Новая учётная запись (объединить в)',
	'usermerge-deleteolduser' => 'Удалить старую учётную запись?',
	'usermerge-submit' => 'Объединить участников',
	'usermerge-userdeleted' => '$1 ($2) был удалён.',
	'usermerge-userdeleted-log' => 'Удалён участник $2 ($3)',
	'usermerge-success-log' => 'Участник $2 ($3) объединён в $4 ($5)',
	'usermerge-logpage' => 'Журнал объединения участников',
	'usermerge-logpagetext' => 'Это журнал объединения учётных записей.',
	'usermerge-noselfdelete' => 'Вы не можете удалять или объединять себя самого!',
	'right-usermerge' => 'объединение участников',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'usermerge' => 'Zlúčenie a zmazanie používateľov',
	'usermerge-desc' => "[[Special:UserMerge|Zlučuje odkazy na jedného používateľa na odkazy na druhého]] v databáze wiki; tiež následne zmaže starého používateľa. Vyžaduje oprávnenie ''usermerge''.",
	'usermerge-badolduser' => 'Neplatné staré používateľské meno',
	'usermerge-badnewuser' => 'Neplatné nové používateľské meno',
	'usermerge-nonewuser' => 'Prázdne nové používateľské meno - Predpokladá sa zlúčenie do $1.<br />Kliknutím na <u>Zlúčiť používateľov</u> prijmete.',
	'usermerge-noolduser' => 'Prázdne staré používateľské meno',
	'usermerge-olduser' => 'Starý používateľ(zlúčiť odtiaľto)',
	'usermerge-newuser' => 'Nový používate(zlúčiť sem)',
	'usermerge-deleteolduser' => 'Zmazať starého používateľa?',
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

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'usermerge' => 'Benutserkonten touhoopefiere un läskje',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'usermerge-desc' => "Ngagabungkeun Préférénsi ti hiji pamaké ka pamaké séjén dina pangkalan data wiki - ogé baris ngahapus pamaké lila sadeui Ngagabungkeun. diperlukeun hak aksés ''usermerge''",
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author Sannab
 */
$messages['sv'] = array(
	'usermerge' => 'Slå ihop och radera användarkonton',
	'usermerge-desc' => "Ger möjlighet att [[Special:UserMerge|slå samman användarkonton]] genom att alla referenser till en användare byts ut till en annan användare i databasen, samt att efter sammanslagning radera gamla konton. Kräver behörigheten ''usermerge''.",
	'usermerge-badolduser' => 'Ogiltigt gammalt användarnamn',
	'usermerge-badnewuser' => 'Ogiltigt nytt användarnamn',
	'usermerge-nonewuser' => 'Inget nytt användarnamn angavs. Antar att det gamla kontot ska slås ihop till $1.<br />Tryck på <u>Slå ihop konton</u> för att godkänna sammanslagningen.',
	'usermerge-noolduser' => 'Inget gammalt användarnamn angavs',
	'usermerge-olduser' => 'Gammalt användarnamn (slås ihop från)',
	'usermerge-newuser' => 'Nytt användarnamn (slås ihop till)',
	'usermerge-deleteolduser' => 'Ta bort det gamla användarkontot?',
	'usermerge-submit' => 'Slå ihop konton',
	'usermerge-badtoken' => 'Ogiltigt redigeringstecken',
	'usermerge-userdeleted' => '$1 ($2) har raderats.',
	'usermerge-userdeleted-log' => 'raderade användare $2 ($3)',
	'usermerge-updating' => 'Uppdaterar tabellen $1 (från $2 till $3)',
	'usermerge-success' => 'Sammanslagningen av $1 ($2) till $3 ($4) har genomförts.',
	'usermerge-success-log' => 'slog ihop användare $2 ($3) med $4 ($5)',
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
	'usermerge-olduser' => 'పాత వాడుకరి (నుండి విలీనం)',
	'usermerge-newuser' => 'కొత్త వాడుకరి (గా విలీనం)',
	'usermerge-deleteolduser' => 'పాత వాడుకరిని తొలగించాలా?',
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

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
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

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'usermerge' => 'Pagsanibin at burahin ang mga tagagamit',
	'usermerge-desc' => '[[Special:UserMerge|Nagsasanib ng mga sanggunian mula sa isang tagagamit patungo sa ibang tagagamit]] sa loob ng kalipunan ng dato ng wiki - magbubura din ng lumang mga tagagamit kasunod ng pagsasanib.  Nangangailangan ng mga karapatang "tagagamitpagsasanib"',
	'usermerge-badolduser' => 'Hindi tanggap na lumang pangalan ng tagagamit',
	'usermerge-badnewuser' => 'Hindi tanggap na bagong pangalan ng tagagamit',
	'usermerge-nonewuser' => 'Tanggalan ng laman ang bagong pangalan ng tagagamit - itinuturing (ipinapalagay) na isasanib sa $1.<br />
Pindutin ang <u>Isanib ang Tagagamit</u> upang tanggapin.',
	'usermerge-noolduser' => 'Tanggalan ng laman ang lumang pangalan ng tagagamit',
	'usermerge-olduser' => 'Lumang tagagamit (isanib mula sa)',
	'usermerge-newuser' => 'Bagong tagagamit (isanib sa)',
	'usermerge-deleteolduser' => 'Burahin ang lumang tagagamit?',
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
 * @author Karduelis
 */
$messages['tr'] = array(
	'usermerge-badolduser' => 'Geçersiz eski kullanıcı adı',
	'usermerge-badnewuser' => 'Geçersiz yeni kullanıcı',
	'usermerge-noolduser' => 'Boş eski kullanıcı adı',
	'usermerge-deleteolduser' => 'Eski kullanıcı sil ?',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'usermerge' => 'Trộn và xóa thành viên',
	'usermerge-desc' => "[[Special:UserMerge|Trộn các tham chiếu từ thành viên này sang một thành viên khác]] trong cơ sở dữ liệu wiki - đồng thời xóa thành viên cũ sau khi trộn. Cần phải có quyền ''usermerge''",
	'usermerge-badolduser' => 'Tên thành viên cũ không hợp lệ',
	'usermerge-badnewuser' => 'Tên thành viên mới không hợp lệ',
	'usermerge-nonewuser' => 'Tên thành viên mới trống - giả thiết là trộn với $1.<br />
Nhất <u>Trộn Thành viên</u> để chấp nhận.',
	'usermerge-noolduser' => 'Tên thành viên cũ trống',
	'usermerge-olduser' => 'Thành viên cũ (trộn từ đây)',
	'usermerge-newuser' => 'Tên thành viên mới (trộn đến đây)',
	'usermerge-deleteolduser' => 'Xóa thành viên cũ?',
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

/** Yue (粵語) */
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
 */
$messages['zh-hans'] = array(
	'usermerge' => '用户合并和删除',
	'usermerge-badolduser' => '无效的旧用户名',
	'usermerge-badnewuser' => '无效的新用户名',
	'usermerge-nonewuser' => '清除新用户名 - 假设合并到$1。<br />点击<u>合并用户</u>以接受。',
	'usermerge-noolduser' => '清除旧用户名',
	'usermerge-olduser' => '旧用户 (合并自)',
	'usermerge-newuser' => '新用户 (合并到)',
	'usermerge-deleteolduser' => '删除旧用户？',
	'usermerge-submit' => '合并用户',
	'usermerge-badtoken' => '无效的编辑币',
	'usermerge-userdeleted' => '$1($2) 已删除。',
	'usermerge-userdeleted-log' => '已删除的用户： $2 ($3)',
	'usermerge-updating' => '正在更新 $1 表格 ($2 到 $3)',
	'usermerge-success' => '由 $1($2) 到 $3($4) 的合并已经完成。',
	'usermerge-success-log' => '用户 $2 ($3) 合并到 $4 ($5)',
	'usermerge-logpage' => '用户合并日志',
	'usermerge-logpagetext' => '这是一份用户合并动作的记录。',
	'usermerge-noselfdelete' => '您不能将自己删除或者合并！',
	'usermerge-unmergable' => '无法完成用户合并 - ID或者名称被标记为不可合并。',
	'usermerge-protectedgroup' => '无法完成用户合并 - 用户位于受保护组中。',
	'right-usermerge' => '合并用户',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'usermerge' => '用戶合併和刪除',
	'usermerge-badolduser' => '無效的舊用戶名',
	'usermerge-badnewuser' => '無效的新用戶名',
	'usermerge-nonewuser' => '清除新用戶名 - 假設合併到$1。<br />點擊<u>合併用戶</u>以接受。',
	'usermerge-noolduser' => '清除舊用戶名',
	'usermerge-olduser' => '舊用戶 (合併自)',
	'usermerge-newuser' => '新用戶 (合併到)',
	'usermerge-deleteolduser' => '刪除舊用戶？',
	'usermerge-submit' => '合併用戶',
	'usermerge-badtoken' => '無效的編輯幣',
	'usermerge-userdeleted' => '$1($2) 已刪除。',
	'usermerge-updating' => '正在更新 $1 表格 ($2 到 $3)',
	'usermerge-success' => '由 $1($2) 到 $3($4) 的合併已經完成。',
	'usermerge-logpage' => '使用者合併記錄',
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

