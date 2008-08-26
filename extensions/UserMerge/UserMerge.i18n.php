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
	'usermerge-logpagetext'       	=> 'This is a log of user merge actions',
	'usermerge-noselfdelete'       	=> 'You cannot delete or merge from yourself!',
	'usermerge-unmergable'		=> 'Unable to merge from user - ID or name has been defined as unmergable.',
	'usermerge-protectedgroup'	=> 'Unable to merge from user - user is in a protected group.',
	'right-usermerge'               => 'Merge users',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'usermerge'                 => 'دمج وحذف المستخدم',
	'usermerge-desc'            => "[[Special:UserMerge|يدمج المراجع من مستخدم إلى آخر]] في قاعدة بيانات الويكي - سيحذف أيضا المستخدمين القدامى بعد الدمج. يتطلب صلاحيات ''usermerge''",
	'usermerge-badolduser'      => 'اسم المستخدم القديم غير صحيح',
	'usermerge-badnewuser'      => 'المستخدم الجديد غير صحيح',
	'usermerge-nonewuser'       => 'اسم مستخدم جديد فارغ - افتراض الدمج إلى $1.<br />اضغط <u>دمج المستخدم</u> للقبول.',
	'usermerge-noolduser'       => 'اسم المستخدم القديم فارغ',
	'usermerge-olduser'         => 'مستخدم قديم(دمج من)',
	'usermerge-newuser'         => 'مستخدم جديد(دمج إلى)',
	'usermerge-deleteolduser'   => 'حذف المستخدم القديم؟',
	'usermerge-submit'          => 'دمج المستخدم',
	'usermerge-badtoken'        => 'نص تعديل غير صحيح',
	'usermerge-userdeleted'     => '$1($2) تم حذفه.',
	'usermerge-userdeleted-log' => 'حذف المستخدم: $2($3)',
	'usermerge-updating'        => 'تحديث $1 جدول ($2 إلى $3)',
	'usermerge-success'         => 'الدمج من $1($2) إلى $3($4) اكتمل.',
	'usermerge-success-log'     => 'المستخدم $2($3) تم دمجه مع $4($5)',
	'usermerge-logpage'         => 'سجل دمج المستخدم',
	'usermerge-logpagetext'     => 'هذا سجل بعمليات دمج المستخدمين',
	'usermerge-noselfdelete'    => 'لا يمكنك حذف أو دمج من نفسك!',
	'usermerge-unmergable'      => 'غير قادر على الدمج من مستخدم - الرقم أو الاسم تم تعريفه كغير قابل للدمج.',
	'usermerge-protectedgroup'  => 'غير قادر على الدمج من المستخدم - المستخدم في مجموعة محمية.',
	'right-usermerge'           => 'دمج مستخدمين',
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
	'usermerge'                 => 'Сливане и изтриване на потребители',
	'usermerge-desc'            => "[[Special:UserMerge|Сливане на приносите от един потребител в друг]] в базата от данни - след сливането изтрива стария потребител. Изисква права ''usermerge''",
	'usermerge-badolduser'      => 'Невалиден стар потребител',
	'usermerge-badnewuser'      => 'Невалиден нов потребител',
	'usermerge-noolduser'       => 'Изчистване на старото потребителско име',
	'usermerge-olduser'         => 'Стар потребител (за сливане от)',
	'usermerge-newuser'         => 'Нов потребител (за сливане в)',
	'usermerge-deleteolduser'   => 'Изтриване на стария потребител?',
	'usermerge-submit'          => 'Сливане',
	'usermerge-userdeleted'     => '$1($2) беше изтрит.',
	'usermerge-userdeleted-log' => 'Изтрит потребител: $2($3)',
	'usermerge-success'         => 'Сливането от $1 ($2) към $3 ($4) приключи.',
	'usermerge-success-log'     => 'Потребител $2 ($3) беше слят с $4 ($5)',
	'usermerge-logpage'         => 'Дневник на потребителските сливания',
	'usermerge-logpagetext'     => 'Тази страница съдържа дневник на потребителските сливания',
	'usermerge-noselfdelete'    => 'Не е възможно да изтривате или сливате от себе си!',
	'usermerge-unmergable'      => 'Сливането от потребителя е невъзможно - името или ID е отбелязано като несливаемо.',
	'usermerge-protectedgroup'  => 'Невъзможно е да се извърши сливане от потребител - потребителят е в защитена група.',
	'right-usermerge'           => 'сливане на потребители',
);

/** Bengali (বাংলা)
 * @author Zaheen
 */
$messages['bn'] = array(
	'usermerge'                 => 'ব্যবহারকারী একত্রীকরণ এবং মুছে ফেলা',
	'usermerge-desc'            => "উইকি ডাটাবেজে [[Special:UserMerge|একজন ব্যবহারকারী থেকে অপর ব্যবহারকারীর প্রতি নির্দেশনাগুলি একত্রিত করে]] - এছাড়া একত্রীকরণের পরে পুরনো ব্যবহারকারীদের মুছে দেবে। বিশেষ ''usermerge'' অধিকার আবশ্যক",
	'usermerge-badolduser'      => 'অবৈধ পুরনো ব্যবহারকারী নাম',
	'usermerge-badnewuser'      => 'অবৈধ নতুন ব্যবহারকারী নাম',
	'usermerge-nonewuser'       => 'খালি নতুন ব্যবহারকারী নাম - $1-এর সাথে একত্রীকরণ করা হচ্ছে ধরা হলে। <br /><u>ব্যবহারকারী একত্রিত করা হোক</u> ক্লিক করে সম্মতি দিন।',
	'usermerge-noolduser'       => 'খালি পুরনো ব্যবহারকারী নাম',
	'usermerge-olduser'         => 'পুরনো ব্যবহারকারী (যার থেকে একত্রীকরণ)',
	'usermerge-newuser'         => 'নতুন ব্যবহারকারী (যার সাথে একত্রীকরণ)',
	'usermerge-deleteolduser'   => 'পুরনো ব্যবহারকারী মুছে ফেলা হোক?',
	'usermerge-submit'          => 'ব্যবহারকারী একত্রিত করা হোক',
	'usermerge-badtoken'        => 'সম্পাদনা টোকেন অবৈধ',
	'usermerge-userdeleted'     => '$1 ($2) মুছে ফেলা হয়েছে।',
	'usermerge-userdeleted-log' => 'ব্যবহারকারী মুছে ফেলে হয়েছে: $2 ($3)',
	'usermerge-updating'        => '$1 টেবিল হালনাগাদ করা হচ্ছে ($2 থেকে $3-তে)',
	'usermerge-success'         => '$1 ($2) থেকে $3 ($4)-তে একত্রীকরণ সম্পন্ন হয়েছে।',
	'usermerge-success-log'     => 'ব্যবহারকারী $2 ($3)-কে $4 ($5)-এর সাথে একত্রিত করা হয়েছে',
	'usermerge-logpage'         => 'ব্যবহারকারী একত্রীকরণ লগ',
	'usermerge-logpagetext'     => 'এটি ব্যবহারকারী একত্রীকরণ ক্রিয়াসমূহের একটি লগ',
	'usermerge-noselfdelete'    => 'আপনি নিজের ব্যবহারকারী নাম মুছে ফেলতে বা এটি থেকে অন্য নামে একত্রিত করতে পারবেন না!',
	'usermerge-unmergable'      => 'ব্যবহারকারী নাম থেকে একত্রিত করা যায়নি - আইডি বা নামটি একত্রীকরণযোগ্য নয় হিসেবে সংজ্ঞায়িত।',
	'usermerge-protectedgroup'  => 'ব্যবহারকারী নাম থেকে একত্রিত করা যায়নি - ব্যবহারকারীটি একটি সুরক্ষিত দলে আছেন।',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'usermerge'                 => 'Kendeuziñ an implijer ha diverkañ',
	'usermerge-desc'            => "[[Special:UserMerge|Kendeuziñ a ra daveennoù un implijer gant re unan bennak all]] e diaz titouroù ar wiki - diverkañ a raio ivez ar c'hendeuzadennoù implijer kozh da zont. Rekis eo kaout aotreoù ''kendeuziñ''",
	'usermerge-badolduser'      => 'Anv implijer kozh direizh',
	'usermerge-badnewuser'      => 'Anv implijer nevez direizh',
	'usermerge-nonewuser'       => "Anv implijer nevez goullo - soñjal a ra deomp e fell deoc'h kendeuziñ davet $1.<br />Klikañ war <u>Kendeuziñ implijer</u> evit asantiñ.",
	'usermerge-noolduser'       => 'Anv implijer kozh goullo',
	'usermerge-olduser'         => 'Implijer kozh (kendeuziñ adal)',
	'usermerge-newuser'         => 'Implijer nevez (kendeuziñ davet)',
	'usermerge-deleteolduser'   => 'Diverkañ an implijer kozh ?',
	'usermerge-submit'          => 'Kendeuziñ implijer',
	'usermerge-badtoken'        => 'Jedouer aozañ direizh',
	'usermerge-userdeleted'     => 'Diverket eo bet $1 ($2).',
	'usermerge-userdeleted-log' => 'Implijer diverket : $2($3)',
	'usermerge-updating'        => "Oc'h hizivaat an daolenn $1 (eus $2 da $3)",
	'usermerge-success'         => 'Kendeuzadenn adal $1 ($2) davet $3 ($4) kaset da benn vat.',
	'usermerge-success-log'     => 'Implijer $2 ($3) kendeuzet davet $4 ($5)',
	'usermerge-logpage'         => 'Marilh kendeuzadennoù an implijerien',
	'usermerge-logpagetext'     => 'Setu aze marilh kendeuzadennoù an implijerien',
	'usermerge-noselfdelete'    => "N'hallit ket diverkañ pe kendeuziñ adal pe davedoc'h hoc'h-unan",
	'usermerge-unmergable'      => 'Dibosupl kendeuziñ adal un implijer - un niv. anaout pe un anv bet termenet evel digendeuzadus.',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'usermerge'                 => 'Benutzerkonten zusammenführen und löschen',
	'usermerge-desc'            => "[[Special:UserMerge|Führt Benutzerkonten in der Wiki-Datenbank zusammen]] - das alte Benutzerkonto wird nach der Zusammenführung gelöscht. Erfordert das ''usermerge''-Recht.",
	'usermerge-badolduser'      => 'Ungültiger alter Benutzername',
	'usermerge-badnewuser'      => 'Ungültiger neuer Benutzername',
	'usermerge-nonewuser'       => 'Leerer neuer Benutzername - es wird eine Zusammenführung mit $1 vermutet.<br />Klicke <u>Benutzerkonten zusammenführen</u> zum Ausführen.',
	'usermerge-noolduser'       => 'Leerer alter Benutzername',
	'usermerge-olduser'         => 'Alter Benutzername (zusammenführen von)',
	'usermerge-newuser'         => 'Neuer Benutzername (zusammenführen nach)',
	'usermerge-deleteolduser'   => 'Alten Benutzernamen löschen?',
	'usermerge-submit'          => 'Benutzerkonten zusammenführen',
	'usermerge-badtoken'        => 'Ungültiges Bearbeiten-Token',
	'usermerge-userdeleted'     => '$1 ($2) wurde gelöscht.',
	'usermerge-userdeleted-log' => 'Gelöschter Benutzername: $2 ($3)',
	'usermerge-updating'        => 'Aktualisierung $1 Tabelle ($2 nach $3)',
	'usermerge-success'         => 'Die Zusammenführung von $1 ($2) nach $3 ($4) ist vollständig.',
	'usermerge-success-log'     => 'Benutzername $2 ($3) zusammengeführt mit $4 ($5)',
	'usermerge-logpage'         => 'Benutzerkonten-Zusammenführungs-Logbuch',
	'usermerge-logpagetext'     => 'Dies ist das Logbuch der Benutzerkonten-Zusammenführungen.',
	'usermerge-noselfdelete'    => 'Zusammenführung mit sich selber ist nicht möglich!',
	'usermerge-unmergable'      => 'Zusammenführung nicht möglich - ID oder Benutzername wurde als nicht zusammenführbar definiert.',
	'usermerge-protectedgroup'  => 'Zusammenführung nicht möglich - Benutzername ist in einer geschützen Gruppe.',
	'right-usermerge'           => 'Benutzerkonten vereinen',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'usermerge-userdeleted'     => '$1 ($2) estis forigita.',
	'usermerge-userdeleted-log' => 'Forigis uzanton: $2 ($3)',
	'right-usermerge'           => 'Kunfandi uzantojn',
);

/** Finnish (Suomi)
 * @author Nike
 */
$messages['fi'] = array(
	'usermerge'            => 'Käyttäjätunnusten yhdistys ja poisto',
	'usermerge-badolduser' => 'Vanha käyttäjätunnus ei kelpaa',
	'usermerge-badnewuser' => 'Uusi käyttäjätunnus ei kelpaa',
);

/** French (Français)
 * @author Sherbrooke
 * @author Grondin
 * @author Guillom
 * @author Urhixidur
 * @author IAlex
 */
$messages['fr'] = array(
	'usermerge'                 => 'Fusionner utilisateur et détruire',
	'usermerge-desc'            => '[[Special:UserMerge|Fusionne les références d’un utilisateur vers un autre]] dans la base de données wiki - supprimera aussi les anciennes fusions d’utilisateurs suivantes.',
	'usermerge-badolduser'      => "Ancien nom d'utilisateur invalide",
	'usermerge-badnewuser'      => "Nouveau nom d'utilisateur invalide",
	'usermerge-nonewuser'       => "Nouveau nom d'utilisateur vide. Nous faisons l'hypothèse que vous voulez fusionner dans $1.

Cliquez sur ''Fusionner utilisateur'' pour accepter.",
	'usermerge-noolduser'       => "Ancien nom d'utilisateur vide",
	'usermerge-olduser'         => 'Ancien utilisateur (fusionner depuis)',
	'usermerge-newuser'         => 'Nouvel utilisateur (fusionner dans)',
	'usermerge-deleteolduser'   => 'Détruire l’ancien utilisateur ?',
	'usermerge-submit'          => 'Fusionner utilisateur',
	'usermerge-badtoken'        => 'Jeton d’édition invalide',
	'usermerge-userdeleted'     => '$1($2) est détruit.',
	'usermerge-userdeleted-log' => 'Contributeur effacé : $2($3)',
	'usermerge-updating'        => 'Mise à jour de la table $1 (de $2 à $3)',
	'usermerge-success'         => 'La fusion de $1($2) à $3($4) est terminée.',
	'usermerge-success-log'     => 'Contributeur $2($3) fusionné avec $4($5)',
	'usermerge-logpage'         => 'Journal des fusions de contributeurs',
	'usermerge-logpagetext'     => 'Ceci est un journal des actions de fusions de contributeurs',
	'usermerge-noselfdelete'    => 'Vous ne pouvez pas vous supprimer ou vous fusionner vous-même !',
	'usermerge-unmergable'      => "Ne peut fusionner à partir d'un utilisateur, d'un numéro d'identification ou un nom qui ont été définis comme non fusionnables.",
	'usermerge-protectedgroup'  => "Impossible de fusionner à partir d'un utilisateur - l'utilisateur se trouve dans un groupe protégé.",
	'right-usermerge'           => 'Fusionner des utilisateurs',
);

/** Galician (Galego)
 * @author Toliño
 * @author Alma
 */
$messages['gl'] = array(
	'usermerge'                 => 'Fusionar e eliminar usuario',
	'usermerge-desc'            => "[[Special:UserMerge|Fusiona as referencias dun usuario noutro usuario]] na base de datos do wiki (tamén borrará as fusións vellas dos usuarios seguintes. Require privilexios ''usermerge'')",
	'usermerge-badolduser'      => 'Antigo nome de usuario non válido',
	'usermerge-badnewuser'      => 'Novo nome de usuario non válido',
	'usermerge-nonewuser'       => 'Novo nome de usuario baleiro - asumindo que se fusionan para $1.<br />
Prema en <u>Fusionar o usuario</u> para aceptar.',
	'usermerge-noolduser'       => 'Antigo nome de usuario baleiro',
	'usermerge-olduser'         => 'Antigo usuario (fusionar desde)',
	'usermerge-newuser'         => 'Novo usuario (fusionar a)',
	'usermerge-deleteolduser'   => 'Eliminar o antigo usuario?',
	'usermerge-submit'          => 'Fusionar o usuario',
	'usermerge-badtoken'        => 'Sinal de edición non válido',
	'usermerge-userdeleted'     => '$1 ($2) foi eliminado.',
	'usermerge-userdeleted-log' => 'Usuario eliminado: $2 ($3)',
	'usermerge-updating'        => 'Actualizando táboa $1 ($2 a $3)',
	'usermerge-success'         => 'A fusión desde $1 ($2) a $3 ($4) foi completada.',
	'usermerge-success-log'     => 'Usuario $2 ($3) fusionado con $4 ($5)',
	'usermerge-logpage'         => 'Rexistro de fusión de usuarios',
	'usermerge-logpagetext'     => 'Este é un rexistro das accións de fusión de usuarios',
	'usermerge-noselfdelete'    => 'Non se pode eliminar ou fusionar a si mesmo!',
	'usermerge-unmergable'      => 'Non se pode fusionar o usuario (o ID ou o nome foron definidos como "non fusionables").',
	'usermerge-protectedgroup'  => 'Non se pode fusionar o usuario (o usuario está nun frupo protexido).',
	'right-usermerge'           => 'Fusionar usuarios',
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
	'usermerge'                 => 'Wužiwarske konta zjednoćić a zničić',
	'usermerge-desc'            => "[[Special:UserMerge|Zjednoća referency wužiwarjow]] we wikowej datowej bance - stare wužiwarske konto so po zjednoćenju wušmórnje. Žada sej prawa ''usermerge''.",
	'usermerge-badolduser'      => 'Njepłaćiwe stare wužiwarske mjeno',
	'usermerge-badnewuser'      => 'Njepłaćiwe nowe wužiwarske mjeno',
	'usermerge-nonewuser'       => 'Nowe wužiwarske mjeno faluje - najskerje ma so z $1 zjednoćić.<br /> Klikń na <u>Wužiwarske konta zjednoćić</u>, zo by potwerdźił.',
	'usermerge-noolduser'       => 'Falowace stare wužiwarske mjeno',
	'usermerge-olduser'         => 'Stare wužiwarske konto (Zjednoćić wot)',
	'usermerge-newuser'         => 'Nowe wužiwarske konto (Zjednoćić do)',
	'usermerge-deleteolduser'   => 'Stare wužiwarske mjeno zničić?',
	'usermerge-submit'          => 'Wužiwarske konta zjednoćić',
	'usermerge-badtoken'        => 'Njepłaćiwe wobdźěłanske znamjo',
	'usermerge-userdeleted'     => '$1($2) bu zničeny.',
	'usermerge-userdeleted-log' => 'Wušmórnjeny wužiwar: $2($3)',
	'usermerge-updating'        => '$1 tabela so aktualizuje ($2 do $3)',
	'usermerge-success'         => 'Zjednoćenje wot $1($2) do $3($4) je dokónčene.',
	'usermerge-success-log'     => 'Wužiwar $2($3) je so z $4 ($5) zjednoćił',
	'usermerge-logpage'         => 'Protokol wužiwarskich zjednoćenjow',
	'usermerge-logpagetext'     => 'To je protokol wužiwarskich zjednoćenjow',
	'usermerge-noselfdelete'    => 'Njemóžeš sam wušmórnyć abo zjednoćić!',
	'usermerge-unmergable'      => 'Zjednoćenje wužiwarjow njemóžno - ID abo wužiwarske mjeno bu jako njezjednoćujomne definowane.',
	'usermerge-protectedgroup'  => 'Zjednoćenje wužiwarjow njemóžno - wužiwar je w škitanej skupinje',
	'right-usermerge'           => 'Wužiwarjow zjednoćić',
);

/** Haitian (Kreyòl ayisyen)
 * @author Masterches
 */
$messages['ht'] = array(
	'usermerge'                 => 'Mèt ansanm kont itilizatè yo ak efase tou',
	'usermerge-desc'            => '[[Special:UserMerge|Mèt ansanm referans yo depi yon itilizatè nan referans yon lòt itilizatè]] nan baz done wiki a - l ap efase tou vye non itilizatè yo apre fizyon, reyinyon sa. Ou dwèt genyen dwa pou fè fizyon sa.',
	'usermerge-badolduser'      => 'Lòt vyen non itilizatè ou an pa bon, li pa korèk, genyen yon erè anndan l.',
	'usermerge-badnewuser'      => 'Nouvo non itilizatè ou chwazi an pa bon, li pa korèk, genyen yon erè anndan l',
	'usermerge-nonewuser'       => 'Efase nouvo non itilizatè - depi ou vle mèt ansanm kont ou an ak $1.<br />
Klike (prese) <u>Mèt ansanm kont Itilizatè</u> pou aksepte operasyon an.',
	'usermerge-noolduser'       => 'Efase vye non itilizatè an',
	'usermerge-olduser'         => 'Ansyen non itilizatè (mèt ansanm)',
	'usermerge-newuser'         => 'Nouvo non itilizatè (mèt ansanm)',
	'usermerge-deleteolduser'   => 'Efase ansyen, vye non itilizatè a ?',
	'usermerge-submit'          => 'Mèt ansanm kont itilizatè yo',
	'usermerge-badtoken'        => 'Edisyon ou fè an pa bon, li pa korèk, genyen yon erè nan operasyon an',
	'usermerge-userdeleted'     => '$1 ($2) efase.',
	'usermerge-userdeleted-log' => 'Non itilizatè ki efase a: $2 ($3)',
	'usermerge-updating'        => 'Mèt a jou, modifye tab $1 (depi $2 jouk $3)',
	'usermerge-success'         => 'Nou rive mèt ansanm $1 ($2) ak $3 ($4), depi premye kont an.',
	'usermerge-success-log'     => 'Itilizatè $2 ($3) fizyone ak $4 ($5)',
	'usermerge-logpage'         => 'Jounal itilizatè pou referans fizyon, "mèt ansanm kont itilizatè yo"',
	'usermerge-logpagetext'     => "Sa se yon jounal ki ap reprann tout aksyon ki fèt nan seksyon 'Mèt ansanm kont itilizatè yo, fizyone'",
	'usermerge-noselfdelete'    => 'Ou pa kapab efase tèt ou oubyen mèt yon lòt kont sou tèt ou, depi kont ou an menm.',
	'usermerge-unmergable'      => 'Nou pa kapab mèt ansanm kont sa yo - ID an oubyen non an pa kapab mete ansanm, li sanble l make nan definisyon yo.',
	'usermerge-protectedgroup'  => 'Nou pa kapab mèt ansanm kont itilizatè yo - itilizatè sa a nan yon gwoup ki pwoteje.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'usermerge'                 => 'Penggabungan dan penghapusan Pengguna',
	'usermerge-desc'            => "[[Special:UserMerge|Menggabungkan rekam jejak dari suatu pengguna ke pengguna lain]] di basis data wiki - sekaligus menghapus pengguna lama setelah selesai digabungkan. Tindakan ini memerlukan hak ''usermerge''.",
	'usermerge-badolduser'      => 'Nama pengguna lama tidak sah',
	'usermerge-badnewuser'      => 'Nama pengguna baru tidak sah',
	'usermerge-nonewuser'       => 'Nama pengguna baru tidak dituliskan - diasumsikan akan digabungkan ke $1.<br />
Klik <u>Gabungkan Pengguna</u> untuk melanjutkan.',
	'usermerge-noolduser'       => 'Nama pengguna lama tidak diisi',
	'usermerge-olduser'         => 'Pengguna lama (digabungkan dari)',
	'usermerge-newuser'         => 'Pengguna baru (digabungkan ke)',
	'usermerge-deleteolduser'   => 'Hapus pengguna lama?',
	'usermerge-submit'          => 'Gabungkan pengguna',
	'usermerge-badtoken'        => 'Token penyuntingan tidak sah',
	'usermerge-userdeleted'     => '$1 ($2) telah dihapuskan.',
	'usermerge-userdeleted-log' => 'Pengguna telah dihapuskan: $2 ($3)',
	'usermerge-updating'        => 'Memperbaharui tabel $1 ($2 hingga $3)',
	'usermerge-success'         => '$1 ($2) telah selesai digabungkan ke $3 ($4).',
	'usermerge-success-log'     => 'Pengguna $2 ($3) telah digabungkan ke $4 ($5)',
	'usermerge-logpage'         => 'Log penggabungan pengguna',
	'usermerge-logpagetext'     => 'Ini adalah catatan tindakan penggabungan pengguna',
	'usermerge-noselfdelete'    => 'Anda tidak dapat menghapus atau menggabungkan dari Anda sendiri!',
	'usermerge-unmergable'      => 'Tidak dapat menggabungkan dari pengguna ini - nomor ID atau nama akun ini telah ditandai sebagai akun yang tidak dapat digabungkan.',
	'usermerge-protectedgroup'  => 'Tidak dapat menggabungkan dari pengguna ini - pengguna ini termasuk dalam kelompok terproteksi.',
	'right-usermerge'           => 'Gabungkan pengguna',
);

/** Italian (Italiano)
 * @author Pietrodn
 * @author Darth Kule
 */
$messages['it'] = array(
	'usermerge'                 => 'Unione e cancellazione utenti',
	'usermerge-desc'            => "[[Special:UserMerge|Unisce i riferimenti di un utente con quelli di un altro]] nel database della wiki e inoltre cancellerà il vecchio utente dopo l'unione. Richiede privilegi ''usermerge''",
	'usermerge-badolduser'      => 'Vecchio nome utente non valido',
	'usermerge-badnewuser'      => 'Nuovo nome utente non valido',
	'usermerge-nonewuser'       => "Nuovo nome utente vuoto - l'unione verrà effettuata con l'utente $1.<br />
Fai clic su <u>Unisci Utente</u> per accettare.",
	'usermerge-noolduser'       => 'Vecchio nome utente vuoto',
	'usermerge-olduser'         => 'Vecchio utente (unisci da)',
	'usermerge-newuser'         => 'Nuovo utente (unisci a)',
	'usermerge-deleteolduser'   => 'Cancellare vecchio utente?',
	'usermerge-submit'          => 'Unisci utente',
	'usermerge-badtoken'        => 'Edit token non valido',
	'usermerge-userdeleted'     => '$1 ($2) è stato cancellato.',
	'usermerge-userdeleted-log' => 'Utente cancellato: $2 ($3)',
	'usermerge-updating'        => 'Aggiornamento tabella $1 ($2 a $3)',
	'usermerge-success'         => "L'unione di $1 ($2) a $3 ($4) è completa.",
	'usermerge-success-log'     => 'Utente $2 ($3) unito a $4 ($5)',
	'usermerge-logpage'         => 'Log unione utente',
	'usermerge-logpagetext'     => 'Di seguito viene presentato il registro delle unioni di utenti',
	'usermerge-noselfdelete'    => 'Non puoi cancellare o unire il tuo account!',
	'usermerge-unmergable'      => "Impossibile unire da questo utente - l'ID o il nome è stato definito non unibile.",
	'usermerge-protectedgroup'  => "Impossibile unire da questo utente - l'utente fa parte di un gruppo protetto.",
	'right-usermerge'           => 'Unisce utenti',
);

/** Japanese (日本語)
 * @author Mzm5zbC3
 */
$messages['ja'] = array(
	'usermerge'               => '利用者の統合と削除',
	'usermerge-olduser'       => '旧利用者（統合元）',
	'usermerge-newuser'       => '新利用者（統合先）',
	'usermerge-deleteolduser' => '利用者を削除する',
	'usermerge-submit'        => '利用者の統合',
	'usermerge-logpage'       => '利用者統合記録',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'usermerge'                 => 'Panggabungan lan pambusakan panganggo',
	'usermerge-badnewuser'      => 'Jeneng panganggo anyar ora absah',
	'usermerge-noolduser'       => 'Jeneng panganggo sing lawas kosong',
	'usermerge-deleteolduser'   => 'Busak panganggo lawas?',
	'usermerge-submit'          => 'Gabung panganggo',
	'usermerge-badtoken'        => 'Token panyuntingan ora absah',
	'usermerge-userdeleted'     => '$1 ($2) wis dibusak.',
	'usermerge-userdeleted-log' => 'Panganggo dibusak: $2 ($3)',
	'usermerge-updating'        => 'Nganyari tabèl $1 ($2 menyang $3)',
	'usermerge-logpage'         => 'Log panggabungan panganggo',
	'usermerge-logpagetext'     => 'Iki sawijining log aksi panggabungan panganggo',
	'usermerge-noselfdelete'    => 'Panjenengan ora bisa mbusak utawa nggabung saka panjenengan dhéwé!',
	'right-usermerge'           => 'Gabung panganggo',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 */
$messages['km'] = array(
	'usermerge'                 => 'បញ្ចូលរួមគ្នា និង​លុបអ្នកប្រើប្រាស់',
	'usermerge-badolduser'      => 'ឈ្មោះអ្នកប្រើប្រាស់ ចាស់ គ្មានសុពលភាព',
	'usermerge-badnewuser'      => 'ឈ្មោះអ្នកប្រើប្រាស់ថ្មីមិនត្រឹមត្រូវទេ',
	'usermerge-olduser'         => 'អ្នកប្រើប្រាស់ ចាស់ (បញ្ចូលរួមគ្នា ពី)',
	'usermerge-newuser'         => 'អ្នកប្រើប្រាស់ ថ្មី (បញ្ចូលរួមគ្នា ទៅ)',
	'usermerge-deleteolduser'   => 'លុបអ្នកប្រើប្រាស់ចាស់ឬ?',
	'usermerge-submit'          => 'បញ្ចូលរួមគ្នា អ្នកប្រើប្រាស់',
	'usermerge-userdeleted'     => '$1 ($2) ត្រូវបានលុបហើយ។',
	'usermerge-userdeleted-log' => 'អ្នកប្រើប្រាស់ ត្រូវបានលុបចេញ ៖ $2 ($3)',
	'usermerge-logpage'         => 'កំនត់ហេតុនៃការបញ្ចួលអ្នកប្រើប្រាស់រួមគ្នា',
	'usermerge-logpagetext'     => 'នេះជាកំនត់ហេតុនៃសកម្មភាពបញ្ចូលអ្នកប្រើប្រាស់រួមគ្នា',
	'usermerge-noselfdelete'    => 'អ្នកមិនអាច លុបចេញ ឬ បញ្ចូលរួមគ្នា ពីខ្លួនអ្នកផ្ទាល់ !',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'right-usermerge' => 'Metmaacher zosammelääje',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'usermerge'                 => 'Benotzerkonten zesummeféieren a läschen',
	'usermerge-badolduser'      => 'Ongëltegen ale Benotzernumm',
	'usermerge-badnewuser'      => 'Ongëltegen neie Benotzernumm',
	'usermerge-noolduser'       => 'Eidelen ale Benotzernumm',
	'usermerge-deleteolduser'   => 'Ale Benotzer läschen?',
	'usermerge-submit'          => 'Benotzerkonten zesummeféieren',
	'usermerge-userdeleted-log' => 'Geläschte Benotzer: $2($3)',
	'usermerge-logpage'         => 'Lëscht vun de Benotzerkonten déi zesummegeféiert goufen',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'usermerge-badolduser'      => 'അസാധുവായ പഴയ ഉപയോക്തൃനാമം',
	'usermerge-badnewuser'      => 'അസാധുവായ പുതിയ ഉപയോക്തൃനാമം',
	'usermerge-noolduser'       => 'പഴയ ഉപയോക്തൃനാമം ശൂന്യമാക്കുക',
	'usermerge-olduser'         => 'പഴയ ഉപയോക്തൃനാമം (ലയിപ്പിക്കാനുള്ളത്)',
	'usermerge-newuser'         => 'പുതിയ ഉപയോക്തൃനാമം (ഇതിലേക്കു സം‌യോജിപ്പിക്കണം)',
	'usermerge-deleteolduser'   => 'പഴയ ഉപയോക്താവിനെ മായ്ക്കട്ടെ?',
	'usermerge-submit'          => 'ഉപയോക്താവിനെ സം‌യോജിപ്പിക്കുക',
	'usermerge-userdeleted'     => '$1 ($2) മായ്ച്ചു.',
	'usermerge-userdeleted-log' => 'ഉപയോക്താവിനെ മായ്ച്ചു: $2 ($3)',
	'usermerge-updating'        => '$1 പട്ടിക ($2 to $3) പുതുക്കുന്നു',
	'usermerge-success'         => '$1 ($2) നെ $3 ($4) ലേക്കു സം‌യോജിപ്പിക്കുന്ന പ്രക്രിയ പൂര്‍ത്തിയായി.',
	'usermerge-success-log'     => '$2 ($3) എന്ന ഉപയോക്താവിനെ $4 ($5)ലേക്കു സം‌യോജിപ്പിച്ചു',
	'usermerge-logpage'         => 'ഉപയോക്തൃസം‌യോജന പ്രവര്‍ത്തനരേഖ',
	'usermerge-logpagetext'     => 'ഉപയോക്താക്കളെ സം‌യോജിപ്പിച്ചതിന്റെ പ്രവര്‍ത്തനരേഖയാണിത്',
	'usermerge-noselfdelete'    => 'താങ്കള്‍ക്ക് താങ്കളെത്തന്നെ മായ്ക്കാനോ, മറ്റൊരു അക്കുണ്ടിലേക്കു സം‌യോജിപ്പിക്കാനോ പറ്റില്ല!',
	'right-usermerge'           => 'ഉപയോക്താക്കളെ സം‌യോജിപ്പിക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'usermerge'                 => 'सदस्य एकत्रीकरण व वगळणे',
	'usermerge-badolduser'      => 'चुकीचे जुने सदस्यनाव',
	'usermerge-badnewuser'      => 'चुकीचे नवे सदस्यनाव',
	'usermerge-noolduser'       => 'रिकामे जुने सदस्यनाव',
	'usermerge-olduser'         => 'जुना सदस्य (इथून एकत्र करा)',
	'usermerge-newuser'         => 'नवीन सदस्य (मध्ये एकत्र करा)',
	'usermerge-deleteolduser'   => 'जुना सदस्य वगळायचा का?',
	'usermerge-submit'          => 'सदस्य एकत्र करा',
	'usermerge-badtoken'        => 'चुकीचे एडीट टोकन',
	'usermerge-userdeleted'     => '$1 ($2) ला वगळण्यात आलेले आहे.',
	'usermerge-userdeleted-log' => 'सदस्य वगळला: $2 ($3)',
	'usermerge-updating'        => '$1 सारणी ताजीतवानी करीत आहोत ($2 ते $3)',
	'usermerge-success-log'     => 'सदस्य $2 ($3) ला $4 ($5) मध्ये एकत्र केले',
	'usermerge-logpage'         => 'सदस्य एकत्रीकरण नोंद',
	'usermerge-logpagetext'     => 'ही सदस्य एकत्रीकरणाची सूची आहे',
	'usermerge-noselfdelete'    => 'तुम्ही स्वत:लाच वगळू किंवा एकत्र करू शकत नाही.',
	'right-usermerge'           => 'सदस्य एकत्र करा',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'usermerge'                 => 'Gebruikers samenvoegen en verwijderen',
	'usermerge-desc'            => "Voegt een [[Special:UserMerge|speciale pagina]] toe om gebruikers samen te voegen en de oude gebruiker(s) te verwijderen (hiervoor is het recht ''usermerge'' nodig)",
	'usermerge-badolduser'      => 'Verkeerde oude gebruiker',
	'usermerge-badnewuser'      => 'Verkeerde nieuwe gebruiker',
	'usermerge-nonewuser'       => 'Nieuwe gebruiker is niet ingegeven - er wordt aangenomen dat er samengevoegd moet worden naar $1.<br />
Klik <u>Gebruiker samenvoegen</u> om te aanvaarden.',
	'usermerge-noolduser'       => 'Oude gebruiker is niet ingegeven',
	'usermerge-olduser'         => 'Oude gebruiker (samenvoegen van)',
	'usermerge-newuser'         => 'Nieuwe gebruiker (samenvoegen naar)',
	'usermerge-deleteolduser'   => 'Oude gebruiker verwijderen?',
	'usermerge-submit'          => 'Gebruiker samenvoegen',
	'usermerge-badtoken'        => 'Ongeldig bewerkingstoken',
	'usermerge-userdeleted'     => '$1($2) is verwijderd.',
	'usermerge-userdeleted-log' => 'Verwijderde gebruiker: $2($3)',
	'usermerge-updating'        => 'Tabel $1 aan het bijwerken ($2 naar $3)',
	'usermerge-success'         => 'Samenvoegen van $1($2) naar $3($4) is afgerond.',
	'usermerge-success-log'     => 'Gebruiker $2 ($3) samengevoegd naar $4 ($5)',
	'usermerge-logpage'         => 'Logboek gebruikerssamenvoegingen',
	'usermerge-logpagetext'     => 'Dit is het logboek van gebruikerssamenvoegingen.',
	'usermerge-noselfdelete'    => 'U kunt uzelf niet verwijderen of samenvoegen!',
	'usermerge-unmergable'      => 'Deze gebruiker kan niet samengevoegd worden. De gebruikersnaam of het gebruikersnummer is ingesteld als niet samen te voegen.',
	'usermerge-protectedgroup'  => 'Het is niet mogelijk de gebruikers samen te voegen. De gebruiker zit in een beschermde groep.',
	'right-usermerge'           => 'Gebruikers samenvoegen',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'usermerge'                 => 'Brukersammenslåing og -sletting',
	'usermerge-desc'            => "Gir muligheten til  å [[Special:UserMerge|slå sammen kontoer]] ved at alle referanser til en bruker byttes ut til en annen bruker i databasen, for så å slette den ene kontoen. Trenger rettigheten ''usermerge''.",
	'usermerge-badolduser'      => 'Gammelt brukernavn ugyldig',
	'usermerge-badnewuser'      => 'Nytt brukernavn ugyldig',
	'usermerge-nonewuser'       => 'Nytt brukernavn tomt &ndash; antar sammenslåing til $1.<br />Klikk <u>Slå sammen brukere</u> for å godta.',
	'usermerge-noolduser'       => 'Gammelt brukernavn tomt',
	'usermerge-olduser'         => 'Gammelt brukernavn (slå sammen fra)',
	'usermerge-newuser'         => 'Nytt brukernavn (slå sammen til)',
	'usermerge-deleteolduser'   => 'Slett gammel bruker?',
	'usermerge-submit'          => 'Slå sammen brukere',
	'usermerge-badtoken'        => 'Ugydlgi redigeringstegn',
	'usermerge-userdeleted'     => '$1 ($2) har blitt slettet.',
	'usermerge-userdeleted-log' => 'Slettet bruker: $2 ($3)',
	'usermerge-updating'        => 'Oppdaterer $1-tabell ($2 til $3)',
	'usermerge-success'         => 'Sammenslåing fra $1 ($2) til $3 ($4) er ferdig.',
	'usermerge-success-log'     => 'Brukeren $2 ($3) slått sammen med $4 ($5)',
	'usermerge-logpage'         => 'Brukersammenslåingslogg',
	'usermerge-logpagetext'     => 'Dette er en logg over brukersammenslåinger.',
	'usermerge-noselfdelete'    => 'Du kan ikke slette eller slå sammen din egen konto!',
	'usermerge-unmergable'      => 'Kan ikke slå sammen den gamle kontoen. ID-en eller navnet anses som ikke-sammenslåbart.',
	'usermerge-protectedgroup'  => 'Kan ikke slå sammen den gamle kontoen. Brukeren er medlem i en beskyttet brukergruppe.',
	'right-usermerge'           => 'Slå sammen kontoer',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'usermerge'                 => 'Fusionar utilizaire e destruire',
	'usermerge-desc'            => "[[Special:UserMerge|Fusiona las referéncias d'un utilizaire vèrs un autre]] dins la banca de donadas wiki - suprimirà tanben las fusions d'utilizaires ancianas seguentas.",
	'usermerge-badolduser'      => "Nom d'utilizaire ancian invalid",
	'usermerge-badnewuser'      => "Nom d'utilizaire novèl invalid",
	'usermerge-nonewuser'       => "Nom d'utilizaire novèl void. Fasèm l'ipotèsi que volètz fusionar dins $1. Clicatz sus ''Fusionar utilizaire'' per acceptar.",
	'usermerge-noolduser'       => "Nom d'utilizaire ancian void",
	'usermerge-olduser'         => 'Utilizaire ancian (fusionar dempuèi)',
	'usermerge-newuser'         => 'Utilizaire novèl (fusionar dins)',
	'usermerge-deleteolduser'   => 'Destruire utilizaire ancian ?',
	'usermerge-submit'          => 'Fusionar utilizaire',
	'usermerge-badtoken'        => "Geton d'edicion invalid",
	'usermerge-userdeleted'     => '$1($2) es destruch.',
	'usermerge-userdeleted-log' => 'Contributor escafat : $2($3)',
	'usermerge-updating'        => 'Mesa a jorn de la taula $1 (de $2 a $3)',
	'usermerge-success'         => 'La fusion de $1($2) a $3($4) es completada.',
	'usermerge-success-log'     => 'Contributor $2($3) fusionat amb $4($5)',
	'usermerge-logpage'         => 'Jornal de las fusions de contributors',
	'usermerge-logpagetext'     => 'Aquò es un jornal de las accions de fusions de contributors',
	'usermerge-noselfdelete'    => 'Podètz pas, vos-meteis, vos suprimir ni vos fusionar !',
	'usermerge-unmergable'      => "Pòt pas fusionar a partir d'un utilizaire, d'un numèro d'identificacion o un nom que son estats definits coma non fusionables.",
	'usermerge-protectedgroup'  => "Impossible de fusionar a partir d'un utilizaire - l'utilizaire se tròba dins un grop protegit.",
	'right-usermerge'           => "Fusionar d'utilizaires",
);

/** Polish (Polski)
 * @author Masti
 * @author Sp5uhe
 * @author Derbeth
 * @author Wpedzich
 */
$messages['pl'] = array(
	'usermerge'                 => 'Integruj i usuń użytkowników',
	'usermerge-desc'            => "[[Special:UserMerge|Integruje odwołania dla jednego użytkownika do drugiego]] w bazie danych wiki – usuwa również starego użytkownika po integracji. Wymaga uprawnienia ''usermerge''",
	'usermerge-badolduser'      => 'Niewłaściwa stara nazwa użytkownika',
	'usermerge-badnewuser'      => 'Niewłaściwa nowa nazwa użytkownika',
	'usermerge-nonewuser'       => 'Pusta nazwa nowego użytkownika – przyjęto, że nastąpi integracja do $1. <br />Naciśnij <u>Integruj użytkowników</u>, by zaakceptować.',
	'usermerge-noolduser'       => 'Pusta stara nazwa użytkownika',
	'usermerge-olduser'         => 'Stary użytkownik (integruj od)',
	'usermerge-newuser'         => 'Nowy użytkownik (integruj z)',
	'usermerge-deleteolduser'   => 'Usunąć starego użytkownika?',
	'usermerge-submit'          => 'Integruj użytkowników',
	'usermerge-badtoken'        => 'Nieprawidłowy żeton edycji',
	'usermerge-userdeleted'     => '$1 ($2) został usunięty.',
	'usermerge-userdeleted-log' => 'usunął użytkownika „$2” ($3)',
	'usermerge-updating'        => 'Odświeżanie tablicy $1 ($2 do $3)',
	'usermerge-success'         => 'Integracja $1 ($2) z $3 ($4) zakończona.',
	'usermerge-success-log'     => 'zintegrował użytkownika „$2” ($3) do „$4” ($5)',
	'usermerge-logpage'         => 'Rejestr integracji użytkowników',
	'usermerge-logpagetext'     => 'To jest rejestr operacji integracji użytkowników',
	'usermerge-noselfdelete'    => 'Nie możesz usunąć lub połączyć samego siebie!',
	'usermerge-unmergable'      => 'Nie można zintegrować użytkownika – identyfikator lub nazwa zostały zdefiniowane jako nieintegrowalne.',
	'usermerge-protectedgroup'  => 'Nie można zintegrować użytkownika – jest członkiem zabezpieczonej grupy.',
	'right-usermerge'           => 'Scalanie użytkowników',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'usermerge'               => "Union e scancelament d'utent",
	'usermerge-badolduser'    => 'Vej stranòm nen bon',
	'usermerge-badnewuser'    => 'Neuv stranòm nen bon',
	'usermerge-nonewuser'     => "Neuv stranòm veujd - i la tnisoma bon për n'union a $1.<br />de-ie 'n colp ansima a <u>Unì Utent</u> për aceté.",
	'usermerge-noolduser'     => 'Vej stranòm veujd',
	'usermerge-olduser'       => 'Vej stranòm (Unì da)',
	'usermerge-newuser'       => 'Neuv stranòm (Unì a)',
	'usermerge-deleteolduser' => "Veul-lo scancelé l'utent vej?",
	'usermerge-submit'        => 'Unì Utent',
	'usermerge-badtoken'      => "Geton d'edission nen bon",
	'usermerge-userdeleted'   => "$1($2) a l'é stàit scancelà.",
	'usermerge-updating'      => "Antramentr ch'i agiornoma la tàola $1 ($2 a $3)",
	'usermerge-success'       => 'Union da $1($2) a $3($4) completà.',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Lijealso
 */
$messages['pt'] = array(
	'usermerge'                 => 'Fusão e eliminação de utilizadores',
	'usermerge-badolduser'      => 'Nome antigo inválido',
	'usermerge-badnewuser'      => 'Nome novo inválido',
	'usermerge-nonewuser'       => 'Novo nome de utilizador vazio - assumida fusão com $1.<br />
Clique <u>Fundir Utilizador</u> para aceitar.',
	'usermerge-noolduser'       => 'Limpar nome antigo',
	'usermerge-olduser'         => 'Utilizador antigo (fundir de)',
	'usermerge-newuser'         => 'Utilizador novo (fundir para)',
	'usermerge-deleteolduser'   => 'Apagar utilizador antigo?',
	'usermerge-submit'          => 'Limpar usuário',
	'usermerge-userdeleted'     => '$1 ($2) foi eliminado.',
	'usermerge-userdeleted-log' => 'Usuário eliminado: $2 ($3)',
	'usermerge-updating'        => 'Actualizando tabela $1 ($2 para $3)',
	'usermerge-success'         => 'Fusão de $1 ($2) para $3 ($4) está completa.',
	'usermerge-success-log'     => 'Usuário $2 ($3) fundido com $4 ($5)',
	'usermerge-logpage'         => 'Registo de fusão de utilizadores',
	'usermerge-logpagetext'     => 'Este é um registo de acções de fusão de utilizadores',
	'usermerge-noselfdelete'    => 'Você não pode apagar ou fundir a partir de si próprio!',
	'right-usermerge'           => 'Fundir utilizadores',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 * @author Illusion
 * @author Innv
 */
$messages['ru'] = array(
	'usermerge'                 => 'Объединение и удаление учётных записей',
	'usermerge-olduser'         => 'Старая учётная запись (объединить с)',
	'usermerge-newuser'         => 'Новая учётная запись (объединить в)',
	'usermerge-deleteolduser'   => 'Удалить старую учётную запись?',
	'usermerge-userdeleted-log' => 'Удалён участник $2 ($3)',
	'usermerge-success-log'     => 'Участник $2 ($3) объединён в $4 ($5)',
	'usermerge-logpage'         => 'Журнал объединения участников',
	'usermerge-logpagetext'     => 'Это журнал объединения учётных записей',
	'right-usermerge'           => 'объединение участников',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'usermerge'                 => 'Zlúčenie a zmazanie používateľov',
	'usermerge-desc'            => "[[Special:UserMerge|Zlučuje odkazy na jedného používateľa na odkazy na druhého]] v databáze wiki; tiež následne zmaže starého používateľa. Vyžaduje oprávnenie ''usermerge''.",
	'usermerge-badolduser'      => 'Neplatné staré používateľské meno',
	'usermerge-badnewuser'      => 'Neplatné nové používateľské meno',
	'usermerge-nonewuser'       => 'Prázdne nové používateľské meno - Predpokladá sa zlúčenie do $1.<br />Kliknutím na <u>Zlúčiť používateľov</u> prijmete.',
	'usermerge-noolduser'       => 'Prázdne staré používateľské meno',
	'usermerge-olduser'         => 'Starý používateľ(zlúčiť odtiaľto)',
	'usermerge-newuser'         => 'Nový používate(zlúčiť sem)',
	'usermerge-deleteolduser'   => 'Zmazať starého používateľa?',
	'usermerge-submit'          => 'Zlúčiť používateľov',
	'usermerge-badtoken'        => 'Neplatný token úprav',
	'usermerge-userdeleted'     => '$1($2) bol zmazaný.',
	'usermerge-userdeleted-log' => 'Zmazaný používateľ: $2($3)',
	'usermerge-updating'        => 'Aktualizuje sa tabuľka $1 ($2 na $3)',
	'usermerge-success'         => 'Zlúčenie z $1($2) do $3($4) je dokončené.',
	'usermerge-success-log'     => 'Používateľ $2($3) bol zlúčený do $4($5)',
	'usermerge-logpage'         => 'Záznam zlúčení používateľov',
	'usermerge-logpagetext'     => 'Toto je záznam zlúčení používateľov',
	'usermerge-noselfdelete'    => 'Nemôžete zmazať alebo zlúčiť svoj účet!',
	'usermerge-unmergable'      => 'Nebolo možné vykonať zlúčenie používateľa - zdrojové meno alebo ID bolo definované ako nezlúčiteľné.',
	'usermerge-protectedgroup'  => 'Nebolo možné zlúčiť uvedeného používateľa - používateľ je v chránenej skupine.',
	'right-usermerge'           => 'Zlučovať používateľov',
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
	'usermerge'                 => 'Slå ihop och radera användarkonton',
	'usermerge-desc'            => "Ger möjlighet att [[Special:UserMerge|slå samman användarkonton]] genom att alla referenser till en användare byts ut till en annan användare i databasen, samt att efter sammanslagning radera gamla konton. Kräver behörigheten ''usermerge''.",
	'usermerge-badolduser'      => 'Ogiltigt gammalt användarnamn',
	'usermerge-badnewuser'      => 'Ogiltigt nytt användarnamn',
	'usermerge-nonewuser'       => 'Inget nytt användarnamn angavs. Antar att det gamla kontot ska slås ihop till $1.<br />Tryck på <u>Slå ihop konton</u> för att godkänna sammanslagningen.',
	'usermerge-noolduser'       => 'Inget gammalt användarnamn angavs',
	'usermerge-olduser'         => 'Gammalt användarnamn (slås ihop från)',
	'usermerge-newuser'         => 'Nytt användarnamn (slås ihop till)',
	'usermerge-deleteolduser'   => 'Ta bort det gamla användarkontot?',
	'usermerge-submit'          => 'Slå ihop konton',
	'usermerge-badtoken'        => 'Ogiltigt redigeringstecken',
	'usermerge-userdeleted'     => '$1 ($2) har raderats.',
	'usermerge-userdeleted-log' => 'raderade användare $2 ($3)',
	'usermerge-updating'        => 'Uppdaterar tabellen $1 (från $2 till $3)',
	'usermerge-success'         => 'Sammanslagningen av $1 ($2) till $3 ($4) har genomförts.',
	'usermerge-success-log'     => 'slog ihop användare $2 ($3) med $4 ($5)',
	'usermerge-logpage'         => 'Användarsammanslagningslogg',
	'usermerge-logpagetext'     => 'Det här är en logg över sammanslagningar av användarkonton.',
	'usermerge-noselfdelete'    => 'Du kan inte radera eller slå samman ditt eget konto!',
	'usermerge-unmergable'      => 'Kan inte sammanfoga det gamla kontot. ID:t eller namnet har angetts som icke-sammanslagningsbart.',
	'usermerge-protectedgroup'  => 'Kan inte sammanfoga det gamla kontot. Användaren är medlem i en skyddad användargrupp.',
	'right-usermerge'           => 'Slå ihop användarkonton',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'usermerge'                 => 'వాడుకరి విలీనం మరియు తొలగింపు',
	'usermerge-badolduser'      => 'తప్పుడు పాత వాడుకరిపేరు',
	'usermerge-badnewuser'      => 'తప్పుడు కొత్త వాడుకరిపేరు',
	'usermerge-noolduser'       => 'పాత వాడుకరిపేరు ఖాళీగా ఉంది',
	'usermerge-deleteolduser'   => 'పాత వాడుకరిని తొలగించాలా?',
	'usermerge-submit'          => 'వాడుకరిని విలీనం చేయ్యండి',
	'usermerge-userdeleted'     => '$1 ($2)ని తొలగించాం.',
	'usermerge-userdeleted-log' => 'వాడుకరిని తొలగించాం: $2 ($3)',
	'usermerge-success'         => '$1 ($2) నుండి $3 ($4) కి విలీనం పూర్తయ్యింది.',
	'usermerge-success-log'     => '$2 ($3) వాడుకరి $4 ($5)లో విలీనమయ్యారు',
	'usermerge-logpage'         => 'వాడుకరి విలీనాల దినచర్య',
	'usermerge-logpagetext'     => 'ఇది వాడుకరి విలీన చర్యల దినచర్య',
	'usermerge-noselfdelete'    => 'మిమ్మల్ని మీరే తొలగించుకోలేరు లేదా మీలో విలీనం కాలేరు!',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'usermerge'                 => 'Идгом ва ҳафзи корбар',
	'usermerge-badolduser'      => 'Номи корбарии кӯҳнаи номӯътабар',
	'usermerge-badnewuser'      => 'Номи корбарии ҷадидӣ номӯътабар',
	'usermerge-noolduser'       => 'Холӣ кардани номи корбарии кӯҳна',
	'usermerge-olduser'         => 'Корбари кӯҳна (идғом аз)',
	'usermerge-newuser'         => 'Корбари ҷадид (идғом ба)',
	'usermerge-deleteolduser'   => 'Корбари кӯҳна ҳазв шавад?',
	'usermerge-submit'          => 'Идғоми корбар',
	'usermerge-userdeleted-log' => 'Корбари ҳазфшуда: $2 ($3)',
	'usermerge-logpage'         => 'Гузориши идғоми корбар',
	'usermerge-logpagetext'     => 'Ин гузориши амалҳои идғоми корбар аст',
);

/** Turkish (Türkçe)
 * @author Karduelis
 */
$messages['tr'] = array(
	'usermerge-badolduser'    => 'Geçersiz eski kullanıcı adı',
	'usermerge-badnewuser'    => 'Geçersiz yeni kullanıcı',
	'usermerge-noolduser'     => 'Boş eski kullanıcı adı',
	'usermerge-deleteolduser' => 'Eski kullanıcı sil ?',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'usermerge'               => '用戶合併同刪除',
	'usermerge-badolduser'    => '無效嘅舊用戶名',
	'usermerge-badnewuser'    => '無效嘅新用戶名',
	'usermerge-nonewuser'     => '清除新用戶名 - 假設合併到$1。<br />撳<u>合併用戶</u>去接受。',
	'usermerge-noolduser'     => '清除舊用戶名',
	'usermerge-olduser'       => '舊用戶 (合併自)',
	'usermerge-newuser'       => '新用戶 (合併到)',
	'usermerge-deleteolduser' => '刪舊用戶？',
	'usermerge-submit'        => '合併用戶',
	'usermerge-badtoken'      => '無效嘅編輯幣',
	'usermerge-userdeleted'   => '$1($2) 已經刪除咗。',
	'usermerge-updating'      => '更新緊 $1 表 ($2 到 $3)',
	'usermerge-success'       => '由 $1($2) 到 $3($4) 嘅合併已經完成。',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'usermerge'               => '用户合并和删除',
	'usermerge-badolduser'    => '无效的旧用户名',
	'usermerge-badnewuser'    => '无效的新用户名',
	'usermerge-nonewuser'     => '清除新用户名 - 假设合并到$1。<br />点击<u>合并用户</u>以接受。',
	'usermerge-noolduser'     => '清除旧用户名',
	'usermerge-olduser'       => '旧用户 (合并自)',
	'usermerge-newuser'       => '新用户 (合并到)',
	'usermerge-deleteolduser' => '删除旧用户？',
	'usermerge-submit'        => '合并用户',
	'usermerge-badtoken'      => '无效的编辑币',
	'usermerge-userdeleted'   => '$1($2) 已删除。',
	'usermerge-updating'      => '正在更新 $1 表格 ($2 到 $3)',
	'usermerge-success'       => '由 $1($2) 到 $3($4) 的合并已经完成。',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'usermerge'               => '用戶合併和刪除',
	'usermerge-badolduser'    => '無效的舊用戶名',
	'usermerge-badnewuser'    => '無效的新用戶名',
	'usermerge-nonewuser'     => '清除新用戶名 - 假設合併到$1。<br />點擊<u>合併用戶</u>以接受。',
	'usermerge-noolduser'     => '清除舊用戶名',
	'usermerge-olduser'       => '舊用戶 (合併自)',
	'usermerge-newuser'       => '新用戶 (合併到)',
	'usermerge-deleteolduser' => '刪除舊用戶？',
	'usermerge-submit'        => '合併用戶',
	'usermerge-badtoken'      => '無效的編輯幣',
	'usermerge-userdeleted'   => '$1($2) 已刪除。',
	'usermerge-updating'      => '正在更新 $1 表格 ($2 到 $3)',
	'usermerge-success'       => '由 $1($2) 到 $3($4) 的合併已經完成。',
);

/** Taiwan Chinese (‪中文(台灣)‬)
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'usermerge'            => '用戶合併及刪除',
	'usermerge-badolduser' => '無效的舊用戶名',
	'usermerge-badnewuser' => '無效的新用戶名',
);

