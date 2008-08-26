<?php

/**
 * Internationalisation file for the MakeBot extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @license GNU General Public Licence 2.0 or later
 */

$messages = array();

/** English
 * @author Rob Church
 */
$messages['en'] = array(
	'makebot'                 => 'Grant or revoke bot status',
	'makebot-desc'            => 'Special page allows local bureaucrats to grant and revoke bot permissions',
	'makebot-header'          => '\'\'\'A local bureaucrat can use this page to grant or revoke [[{{MediaWiki:Grouppage-bot}}|bot status]] to another user account.\'\'\'<br />Bot status hides a user\'s edits from [[Special:Recentchanges|recent changes]] and similar lists, and is useful for flagging users who make automated edits. This should be done in accordance with applicable policies.',
	'makebot-username'        => 'Username:',
	'makebot-search'          => 'Go',
	'makebot-isbot'           => '[[User:$1|$1]] has bot status.',
	'makebot-notbot'          => '[[User:$1|$1]] does not have bot status.',
	'makebot-privileged'      => '[[User:$1|$1]] has [[Special:Listadmins|administrator or bureaucrat privileges]], and cannot be granted bot status.',
	'makebot-change'          => 'Change status:',
	'makebot-grant'           => 'Grant',
	'makebot-revoke'          => 'Revoke',
	'makebot-comment'         => 'Comment:',
	'makebot-granted'         => '[[User:$1|$1]] now has bot status.',
	'makebot-revoked'         => '[[User:$1|$1]] no longer has bot status.',
	'makebot-logpage'         => 'Bot status log',
	'makebot-logpagetext'     => 'This is a log of changes to users\' [[{{MediaWiki:Grouppage-bot}}|bot]] status.',
	'makebot-logentrygrant'   => 'granted bot status to [[$1]]',
	'makebot-logentryrevoke'  => 'removed bot status from [[$1]]',
	'right-makebot'           => 'Grant and revoke bot flags',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'makebot'                 => 'منح أو سحب صلاحية بوت',
	'makebot-desc'            => 'صفحة خاصة تسمح للبيروقراطيين المحليين بمنح وسحب سماحات البوت',
	'makebot-header'          => '\'\'\'يمكن للبيروقراط المحلي استخدام هذه الصفحة لإعطاء [[مساعدة:بوت|صلاحية بوت]] لحساب مستخدم آخر.\'\'\'<br />تخفي صلاحية البوت تعديلات المستخدم من صفحة أحدث التغييرات و القوائم المماثلة، و هذا يعتبر مفيدا إلى المستخدمين الذين يقومون بتعديلات آلية. يجب أن يكون هذا تبعا للسياسات المتبعة.',
	'makebot-username'        => 'اسم المستخدم:',
	'makebot-search'          => 'اذهب',
	'makebot-isbot'           => '[[User:$1|$1]] لديه صلاحية بوت.',
	'makebot-notbot'          => 'لا يملك [[User:$1|$1]] صلاحية بوت.',
	'makebot-privileged'      => 'يملك [[User:$1|$1]] صلاحية [[Special:Listadmins|إداري أو بيروقراط]]، و لا يمكن منحه صلاحية بوت.',
	'makebot-change'          => 'تغيير الحالة:',
	'makebot-grant'           => 'منح',
	'makebot-revoke'          => 'سحب',
	'makebot-comment'         => 'تعليق:',
	'makebot-granted'         => '[[User:$1|$1]] لديه الآن صلاحية بوت.',
	'makebot-revoked'         => 'فقد [[User:$1|$1]] صلاحية البوت.',
	'makebot-logpage'         => 'سجل صلاحيات البوت',
	'makebot-logpagetext'     => 'هذا سجل لتغييرات صلاحية [[{{MediaWiki:Grouppage-bot}}|البوت]].',
	'makebot-logentrygrant'   => 'منح صلاحية بوت إلى [[$1]]',
	'makebot-logentryrevoke'  => 'سحب صلاحية بوت من [[$1]]',
	'right-makebot'           => 'منح وسحب أعلام البوت',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'makebot'                 => 'منح أو سحب صلاحية بوت',
	'makebot-desc'            => 'صفحة خاصة تسمح للبيروقراطيين المحليين بمنح وسحب سماحات البوت',
	'makebot-header'          => '\'\'\'يمكن للبيروقراط المحلى استخدام هذه الصفحة لإعطاء [[مساعدة:بوت|صلاحية بوت]] لحساب مستخدم آخر.\'\'\'<br />تخفي صلاحية البوت تعديلات المستخدم من صفحة أحدث التغييرات و القوائم المماثلة، و هذا يعتبر مفيدا إلى المستخدمين الذين يقومون بتعديلات آلية. يجب أن يكون هذا تبعا للسياسات المتبعة.',
	'makebot-username'        => 'اسم المستخدم:',
	'makebot-search'          => 'اذهب',
	'makebot-isbot'           => '[[User:$1|$1]] لديه صلاحية بوت.',
	'makebot-notbot'          => 'لا يملك [[User:$1|$1]] صلاحية بوت.',
	'makebot-privileged'      => 'يملك [[User:$1|$1]] صلاحية [[Special:Listadmins|إداري أو بيروقراط]]، و لا يمكن منحه صلاحية بوت.',
	'makebot-change'          => 'تغيير الحالة:',
	'makebot-grant'           => 'منح',
	'makebot-revoke'          => 'سحب',
	'makebot-comment'         => 'تعليق:',
	'makebot-granted'         => '[[User:$1|$1]] لديه الآن صلاحية بوت.',
	'makebot-revoked'         => 'فقد [[User:$1|$1]] صلاحية البوت.',
	'makebot-logpage'         => 'سجل صلاحيات البوت',
	'makebot-logpagetext'     => 'هذا سجل لتغييرات صلاحية [[{{MediaWiki:Grouppage-bot}}|البوت]].',
	'makebot-logentrygrant'   => 'منح صلاحية بوت إلى [[$1]]',
	'makebot-logentryrevoke'  => 'سحب صلاحية بوت من [[$1]]',
	'right-makebot'           => 'منح وسحب أعلام البوت',
);

/** Asturian (Asturianu)
 * @author SPQRobin
 */
$messages['ast'] = array(
	'makebot'             => 'Conceder o revocar estatus de bot',
	'makebot-username'    => "Nome d'usuariu:",
	'makebot-search'      => 'Dir',
	'makebot-comment'     => 'Comentariu:',
	'makebot-logpage'     => 'Rexistru de status de bot',
	'makebot-logpagetext' => 'Esti ye un rexistru de los cambeos del status de [[{{MediaWiki:Grouppage-bot}}|bot]] de los usuarios.',
);

$messages['bcl'] = array(
	'makebot-search'          => 'Dumanán',
	'makebot-grant'           => 'Otobón',
	'makebot-comment'         => 'Komento:',
);

/** Bulgarian (Български)
 * @author Spiritia
 */
$messages['bg'] = array(
	'makebot'                => 'Даване или отнемане на бот статус',
	'makebot-header'         => "'''Чрез тази страница бюрократите могат да дават или отнемат [[{{MediaWiki:Grouppage-bot}}|бот статуса]] на други потребителски сметки.'''<br /> Бот статусът скрива редакциите на потребителската сметка от списъка с [[Special:Recentchanges|последните промени]] и други подобни списъци, и е подходящо да се дава на потребители, които правят автоматизирани редакции. Даването на такъв статус трябва да се извършва в съответствие с действащите правила и политики.",
	'makebot-username'       => 'Потребителско име:',
	'makebot-search'         => 'Проверяване на статуса',
	'makebot-isbot'          => '[[User:$1|$1]] има бот статус.',
	'makebot-notbot'         => '[[User:$1|$1]] няма бот статус.',
	'makebot-privileged'     => '[[User:$1|$1]] има [[Special:Listadmins|пълномощия на администратор или бюрократ]] и не може да получи бот статус.',
	'makebot-change'         => 'Промяна на статуса:',
	'makebot-grant'          => 'Даване',
	'makebot-revoke'         => 'Отнемане',
	'makebot-comment'        => 'Коментар:',
	'makebot-granted'        => '[[User:$1|$1]] вече има бот статус.',
	'makebot-revoked'        => '[[User:$1|$1]] вече няма бот статус.',
	'makebot-logpage'        => 'Дневник на бот статусите',
	'makebot-logpagetext'    => 'Тази страница съдържа дневник на промените на [[{{MediaWiki:Grouppage-bot}}|бот статусите]] на потребители.',
	'makebot-logentrygrant'  => 'даде бот статус на [[$1]]',
	'makebot-logentryrevoke' => 'отне бот статуса на [[$1]]',
);

/** Bengali (বাংলা)
 * @author Zaheen
 */
$messages['bn'] = array(
	'makebot'          => 'বট মর্যাদা প্রদান করুন বা প্রত্যাহার করুন',
	'makebot-header'   => "'''একজন স্থানীয় আমলা এই পাতাটি ব্যবহার করে আরেকটি ব্যবহারকারী অ্যাকাউন্টকে [[{{MediaWiki:Grouppage-bot}}|বট মর্যাদা]] প্রদান করতে বা সেটি থেকে বট মর্যাদা প্রত্যাহার করতে পারবেন।'''<br />বট মর্যাদাপ্রাপ্ত ব্যবহারকারীর সম্পাদনাগুলি [[Special:Recentchanges|সাম্প্রতিক পরিবর্তন]] পাতা এবং সেই রকম তালিকাগুলিতে লুকিয়ে রাখে, এবং যেসমস্ত ব্যবহারকারী স্বয়ংক্রিয় উপায়ে সম্পাদনা করেন, তাদেরকে চিহ্নিত করতে সহায়ক। এই কাজটি প্রয়োগযোগ্য নীতিমালা মেনে সম্পাদন করা উচিত।",
	'makebot-username' => 'ব্যবহারকারী নাম:',
	'makebot-search'   => 'চলো',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'makebot-search' => 'Mont',
);

$messages['ca'] = array(
	'makebot'                 => 'Donar o treure la marca de bot',
	'makebot-header'          => '\'\'\'Un buròcrata local pot fer servir aquesta pàgina per a concedir o retirar l\'estatus de [[{{MediaWiki:Grouppage-bot}}|bot]] a qualsevol compte d\'usuari.\'\'\'<br />L\'estatus de bot oculta les edicions d\'un usuari a la pàgina de [[Special:Recentchanges|canvis recents]] i llistes semblants, i és útil per a usuaris que realitzen edicions automàticament. Això s\'ha de fer segons les polítiques aplicables.',
	'makebot-username'        => 'Usuari:',
	'makebot-search'          => 'Continua',
	'makebot-isbot'           => 'L\'usuari [[User:$1|$1]] té estatus de bot.',
	'makebot-notbot'          => 'L\'usuari [[User:$1|$1]] no té estatus de bot.',
	'makebot-privileged'      => 'L\'usuari [[User:$1|$1]] és [[Special:Listadmins|administrador o buròcrata]] i no pot rebre l\'estatus de bot.',
	'makebot-change'          => 'Canvia l\'estatus:',
	'makebot-grant'           => 'Concedeix',
	'makebot-revoke'          => 'Retira',
	'makebot-comment'         => 'Comentaris:',
	'makebot-granted'         => 'L\'usuari [[User:$1|$1]] ha rebut l\'estatus de bot.',
	'makebot-revoked'         => 'L\'usuari [[User:$1|$1]] ja no té l\'estatus de bot.',
	'makebot-logpage'         => 'Registre de marca de bot',
	'makebot-logpagetext'     => 'Aquest és un registre dels canvis d\'estatus de [[{{MediaWiki:Grouppage-bot}}|bot]] als usuaris.',
	'makebot-logentrygrant'   => 'concedida la marca de bot a [[$1]]',
	'makebot-logentryrevoke'  => 'retirada la marca de bot a [[$1]]',
);

/* Min Dong (GnuDoyng) */
$messages['cdo'] = array(
	'makebot' => 'Dò̤-ké̤ṳk hĕ̤k dò̤-duōng gĭ-ké-nè̤ng sĭng-hông',
	'makebot-header'          => '\'\'\'Buōng câng gì guăng-lièu ô nièng-ngài sāi cī hiĕk lì dò̤-ké̤ṳk hĕ̤k-ciā dò̤-duōng bĕk-bĭk dióng-hô̤ gì [[Help:Gĭ-ké-nè̤ng|gĭ-ké-nè̤ng sĭng-hông]].\'\'\'<br />Gĭ-ké-nè̤ng sĭng-hông â̤ găk [[Special:Recentchanges|cī-bŏng gāi-biéng gì dăng-dăng]] (hĕ̤k-ciā gì-tă dăng-dăng) gà̤-dēng káung kī cê-gă sū có̤ gì siŭ-gāi gé-liŏh, iâ â̤ biĕu-gé có̤ cê̤ṳ-dông siŭ-gāi gì ê̤ṳng-hô. Sāi-ê̤ṳng sèng-âu, diŏh gâe̤ng céng-cháik ô gák.',
	'makebot-username'        => 'Ê̤ṳng-hô-miàng:',
	'makebot-search'          => 'Kó̤',
	'makebot-isbot'           => '[[User:$1|$1]] ô gĭ-ké-nè̤ng sĭng-hông.',
	'makebot-notbot'          => '[[User:$1|$1]] mò̤ gĭ-ké-nè̤ng sĭng-hông.',
	'makebot-privileged'      => '[[User:$1|$1]] ô [[Special:Listadmins|guāng-lī-uòng hĕ̤k-ciā guăng-lièu sĭng-hông]], mâ̤-sāi có̤ gĭ-ké-nè̤ng.',
	'makebot-change'          => 'Gāi-biéng sĭng-hông:',
	'makebot-grant'           => 'Dò̤-ké̤ṳk',
	'makebot-revoke'          => 'Dò̤-duōng',
	'makebot-comment'         => 'Pàng-lâung:',
	'makebot-granted'         => '[[User:$1|$1]] hiêng-câi ô gĭ-ké-nè̤ng sĭng-hông lāu.',
	'makebot-revoked'         => '[[User:$1|$1]] ī-gĭng mò̤ gĭ-ké-nè̤ng sĭng-hông lāu.',
	'makebot-logpage'         => 'Gĭ-ké-nè̤ng sĭng-hông nĭk-cé',
	'makebot-logpagetext'     => 'Cuòi sê gé-liŏh gāi-biéng ê̤ṳng-hô [[Help:Bot|gĭ-ké-nè̤ng]] sĭng-hông gì nĭk-cé.',
	'makebot-logentrygrant'   => 'gău ké̤ṳk [[$1]] gĭ-ké-nè̤ng sĭng-hông',
	'makebot-logentryrevoke'  => 'siŭ duōng [[$1]] gì gĭ-ké-nè̤ng sĭng-hông',
);

$messages['co'] = array(
	'makebot-comment'         => 'Cummentu:',
);

/* Czech */
$messages['cs'] = array(
	'makebot'                 => 'Přidat nebo odebrat příznak bot',
	'makebot-header'          => '\'\'\'Místní byrokraté používají tuto stránku pro přidělení nebo odebrání příznaku [[{{MediaWiki:Grouppage-bot}}|bot]] uživatelskému účtu.\'\'\'<br />Příznak bot zajisti, že editace uživatele jsou skryty ze stránky [[Special:Recentchanges|posledních změn]] a podobných seznamů. Jsou užitečné pro roboty provádějící automatické editace.',
	'makebot-username'        => 'Uživatelské jméno:',
	'makebot-search'          => 'Provést',
	'makebot-isbot'           => '[[User:$1|$1]] má příznak bot.',
	'makebot-notbot'          => '[[User:$1|$1]] nemá příznak bot.',
	'makebot-privileged'      => '[[User:$1|$1]] má [[Special:Listadmins|práva správce nebo byrokrata]], proto mu nemůže být přidělen příznak bot.',
	'makebot-change'          => 'Změnit stav:',
	'makebot-grant'           => 'Přidělit',
	'makebot-revoke'          => 'Odebrat',
	'makebot-comment'         => 'Komentář:',
	'makebot-granted'         => '[[User:$1|$1]] nyní má příznak bot.',
	'makebot-revoked'         => '[[User:$1|$1]] již nemá příznak bot.',
	'makebot-logpage'         => 'Kniha příznaků bot',
	'makebot-logpagetext'     => 'Tato kniha zobrazuje změny v udělovaných příznacích [[{{MediaWiki:Grouppage-bot}}|bot]].',
	'makebot-logentrygrant'   => 'přiděluje účtu [[$1]] příznak bot',
	'makebot-logentryrevoke'  => 'odebírá účtu [[$1]] příznak bot',
);

/* Old Church Slavonic (language file) */
$messages['cu'] = array(
	'makebot'                 => 'Аѵтоматьства даниѥ и отѧтиѥ',
	'makebot-username'        => 'Польѕевател имѧ:',
	'makebot-search'          => 'Прѣиди',
	'makebot-isbot'           => '[[Польѕевател҄ь:$1|$1]] ѥстъ аѵтоматъ.',
	'makebot-notbot'          => '[[Польѕевател҄ь:$1|$1]] нѣстъ аѵтоматъ.',
	'makebot-privileged'      => '[[Польѕевател҄ь:$1|$1]] [[Special:Listadmins|съмотрител҄ь или чинодател҄ь]] ѥстъ, и нѣстъ възможьно ѥго аѵтомата сътворити.',
	'makebot-change'          => 'Аѵтоматьства измѣнѥниѥ:',
	'makebot-grant'           => 'Даждь',
	'makebot-revoke'          => 'Отьми',
	'makebot-granted'         => '[[Польѕевател҄ь:$1|$1]] нынѣ аѵтоматъ ѥстъ.',
	'makebot-revoked'         => '[[Польѕевател҄ь:$1|$1]] вѧще нѣстъ аѵтоматъ.',
	'makebot-logpage'         => 'Їсторї аѵтоматьства',
	'makebot-logentrygrant'   => 'сътвори [[$1]] аѵтоматъ',
	'makebot-logentryrevoke'  => 'Отѧ аѵтоматьство ѹ польѕевател [[$1]]',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'makebot'                => 'Botstatus erteilen oder entziehen',
	'makebot-desc'           => '[[Special:Makebot|Spezialseite]], auf der lokale Bürokraten den Botstatus erteilen und entziehen können',
	'makebot-header'         => "'''Ein Bürokrat dieses Projektes kann anderen Benutzern – in Übereinstimmung mit den lokalen Richtlinien – [[{{ns:help}}:Bot|Botstatus]] erteilen oder entziehen.'''<br /> Mit Botstatus werden die Bearbeitungen eines Bot-Benutzerkontos in den [[{{#Special:Recentchanges}}|Letzten Änderungen]] und ähnlichen Listen versteckt. Die Botmarkierung ist darüberhinaus zur Feststellung automatischer Bearbeitungen nützlich.",
	'makebot-username'       => 'Benutzername:',
	'makebot-search'         => 'Status abfragen',
	'makebot-isbot'          => '„[[User:$1|$1]]“ hat Botstatus.',
	'makebot-notbot'         => '„[[User:$1|$1]]“ hat keinen Botstatus.',
	'makebot-privileged'     => '„[[User:$1|$1]]“ hat [[Special:Listusers/sysop|Administrator- oder Bürokratenrechte]], Botstatus kann nicht erteilt werden.',
	'makebot-change'         => 'Status ändern:',
	'makebot-grant'          => 'Erteilen',
	'makebot-revoke'         => 'Zurücknehmen',
	'makebot-comment'        => 'Kommentar:',
	'makebot-granted'        => '„[[User:$1|$1]]“ hat nun Botstatus.',
	'makebot-revoked'        => '„[[User:$1|$1]]“ hat keinen Botstatus mehr.',
	'makebot-logpage'        => 'Botstatus-Logbuch',
	'makebot-logpagetext'    => 'Dieses Logbuch protokolliert alle [[Help:Bot|Botstatus]]-Änderungen.',
	'makebot-logentrygrant'  => 'erteilte Botstatus für „[[$1]]“',
	'makebot-logentryrevoke' => 'entfernte den Botstatus von „[[$1]]“',
	'right-makebot'          => 'Botflag erteilen und entziehen',
);

/** Zazaki (Zazaki)
 * @author SPQRobin
 */
$messages['diq'] = array(
	'makebot-username' => 'Namey karberi:',

);

$messages['el'] = array(
	'makebot-username'        => 'Όνομα χρήστη:',
	'makebot-comment'         => 'Σχόλιο:',
);

$messages['eo'] = array(
	'makebot'                 => 'Koncedi aŭ revoki robotan statuson',
	'makebot-header'          => '\'\'\'Loka burokrato povas uzi ĉi tiun paĝon por koncedi aŭ revoki [[{{MediaWiki:Grouppage-bot}}|robotan statuson]] al alia uzantokonto.\'\'\'<br />Robota statuso kaŝas uzantoredaktojn de la [[Special:Recentchanges|lastaj ŝanĝoj]] kaj similaj listoj, kaj estas utila por markigo de uzantoj kiuj faras aŭtomatajn redaktojn. Ĉi tio estu farata en akordo kun ĉi tieaj reguloj.',
	'makebot-username'        => 'Uzantonomo:',
	'makebot-search'          => 'Ek',
	'makebot-isbot'           => '[[User:$1|$1]] havas robotan statuson.',
	'makebot-notbot'          => '[[User:$1|$1]] ne havas robotan statuson.',
	'makebot-privileged'      => '[[User:$1|$1]] havas [[Special:Listadmins|administrantajn aŭ burokratajn privilegiojn]], kaj ne povas esti koncedata je robota statuso.',
	'makebot-change'          => 'Ŝanĝu statuson:',
	'makebot-grant'           => 'Koncedi',
	'makebot-revoke'          => 'Revoki',
	'makebot-comment'         => 'Komento:',
	'makebot-granted'         => '[[User:$1|$1]] nun havas robotan statuson.',
	'makebot-revoked'         => '[[User:$1|$1]] ne plu havas robotan statuson.',
	'makebot-logpage'         => 'Robotostatusa loglibro',
	'makebot-logpagetext'     => 'Ĉi tio estas loglibro de ŝanĝoj de uzanta [[{{MediaWiki:Grouppage-bot}}|robota]] statuso.',
	'makebot-logentrygrant'   => 'koncedis robotan statuson al [[$1]]',
	'makebot-logentryrevoke'  => 'revokis robotan statuson de [[$1]]',
);

$messages['es'] = array(
	'makebot'                 => 'Establecer o quitar el flag de bot',
	'makebot-header'          => '\'\'\'Un burócrata local puede usar esta página  para dar o quitar el [[{{MediaWiki:Grouppage-bot}}|flag de bot]] a otra cuenta de usuario.\'\'\'<br />El flag de bot oculta las ediciones de un usuario en [[Special:Recentchanges|cambios recientes]] y listas similares, siendo útil para usuarios que realizan ediciones automáticas. Esto debe hacerse de acuerdo con las políticas aplicables.',
	'makebot-username'        => 'Usuario:',
	'makebot-search'          => 'Seguir',
	'makebot-isbot'           => 'El [[User:$1|usuario $1]] tiene flag de bot.',
	'makebot-notbot'          => 'El [[User:$1|$1]] no tiene flag de bot.',
	'makebot-privileged'      => 'El usuario [[User:$1|$1]] tiene [[Special:Listadmins|privilegios de administrador o burócrata]], y no se le puede dar flag de bot.',
	'makebot-change'          => 'Cambiar estado:',
	'makebot-grant'           => 'Dar',
	'makebot-revoke'          => 'Quitar',
	'makebot-comment'         => 'Motivo:',
	'makebot-granted'         => 'Ahora [[User:$1|$1]] tiene flag de bot.',
	'makebot-revoked'         => 'El usuario [[User:$1|$1]] ya no tiene flag de bot.',
	'makebot-logpage'         => 'Registro del flag de bot',
	'makebot-logpagetext'     => 'Este es un registro de los cambios del flag de [[{{MediaWiki:Grouppage-bot}}|bot]].',
	'makebot-logentrygrant'   => 'dio flag de bot a [[$1]]',
	'makebot-logentryrevoke'  => 'quitó el flag de bot a [[$1]]',
);

$messages['eu'] = array(
	'makebot'                 => 'Bot egoera ezarri edo baliogabetu',
	'makebot-header'          => '\'\'\'Bertako burokrata batek orrialde hau erabil dezake erabiltzaile bati [[{{MediaWiki:Grouppage-bot}}]] egoera eman edo kentzeko.\'\'\'<br />Bot egoerak erabiltzailearen aldaketak ezkutatzen ditu [[Special:Recentchanges|aldaketa berriak]] eta antzeko zerrendetatik, eta erabilgarria da aldaketa automatikoak egiten dituzten erabiltzaileak markatzeko. Hau politikak kontuan izanez burutu behar da.',
	'makebot-username'        => 'Erabiltzaile izena:',
	'makebot-search'          => 'Joan',
	'makebot-isbot'           => '[[User:$1|$1]] erabiltzaileak bot egoera dauka.',
	'makebot-notbot'          => '[[User:$1|$1]] erabiltzaileak ez dauka bot egoera.',
	'makebot-privileged'      => '[[User:$1|$1]] erabiltzaileak [[Special:Listadmins|administratzaile edo burokrata baimenak]] dauzka eta ezin zaio bot egoera ezarri.',
	'makebot-change'          => 'Egoera aldatu:',
	'makebot-grant'           => 'Baimenak eman',
	'makebot-revoke'          => 'Baliogabetu',
	'makebot-comment'         => 'Iruzkina:',
	'makebot-granted'         => '[[User:$1|$1]] erabiltzaileak bot egoera dauka orain.',
	'makebot-revoked'         => '[[User:$1|$1]] erabiltzaileak bot egoera izateari utzi dio.',
	'makebot-logpage'         => 'Bot egoera erregistroa',
	'makebot-logpagetext'     => 'Erabiltzaileen [[{{MediaWiki:Grouppage-bot}}|bot]] egoera aldaketen erregistroa da hau.',
	'makebot-logentrygrant'   => 'bot egoera ezarri zaio [[$1]](r)i',
	'makebot-logentryrevoke'  => 'bot egoera kendu zaio [[$1]](r)i',
);

$messages['ext'] = array(
	'makebot-username'        => 'Nombri el usuáriu:',
	'makebot-search'          => 'Dil',
	'makebot-change'          => 'Chambal estau:',
);

$messages['fa'] = array(
	'makebot'                 => 'اعطا یا لغو پرچم ربات',
	'makebot-header'          => '\'\'\'یک دیوانسالار محلی می‌تواند با استفاده از این صفحه [[ویکی‌پدیا:ربات|پرچم ویژه ربات]] را به یک نام کاربری اعمال نماید.\'\'\'<br />پرچم ربات باعث می‌شود که ویرایش‌های یک کاربر در [[Special:Recentchanges|تغییرات اخیر]] ظاهر و فهرست‌های مشابه ظاهر نشود و کارکرد آن مشخص نمودن ویرایش‌های کاربرانی است که ویرایش‌های خودکار انجام می‌دهند. اعطای این پرچم باید بر طبق سیاست‌های مرتبط با آن انجام شود.',
	'makebot-username'        => 'نام کاربری:',
	'makebot-search'          => 'برو',
	'makebot-isbot'           => '[[User:$1|$1]] پرچم دارد.',
	'makebot-notbot'          => '[[User:$1|$1]] پرچم ندارد.',
	'makebot-privileged'      => '[[User:$1|$1]] دارای [[Special:Listadmins|دسترسی مدیریتی یا دیوانسالاری]] است و نمی‌توان پرچم ربات را برای آن اعمال کرد.',
	'makebot-change'          => 'تغییر وضعیت:',
	'makebot-grant'           => 'اعطا',
	'makebot-revoke'          => 'لغو',
	'makebot-comment'         => 'دلیل:',
	'makebot-granted'         => '[[User:$1|$1]] هم‌اکنون دارای پرچم ربات است.',
	'makebot-revoked'         => '[[User:$1|$1]] از هم‌اکنون پرچم ربات ندارد.',
	'makebot-logpage'         => 'سیاههٔ تغییر وضعیت ربات',
	'makebot-logpagetext'     => 'این سیاهه‌ای است از تغییرات وضعیت پرچم [[ویکی‌پدیا:ربات|ربات‌ها]].',
	'makebot-logentrygrant'   => 'به [[$1]] پرچم داد',
	'makebot-logentryrevoke'  => 'پرچم ربات [[$1]] را لغو کرد',
);

/* Finnish (Niklas Laxström) */
$messages['fi'] = array(
	'makebot'                 => 'Anna tai poista botti-merkintä',
	'makebot-header'          => '\'\'\'Paikallinen byrokraatti voi antaa tai poista [[{{MediaWiki:Grouppage-bot}}|botti-merkinnän]] toiselle käyttäjätunnukselle.\'\'\'<br />Botti-merkintä piilottaa botti-tunnuksella tehdyt muokkaukset [[Special:Recentchanges|tuoreista muutoksista]] ja vastaavista listoista. Merkintä on hyödyllinen, jos tunnuksella tehdään automaattisia muutoksia. Merkinnän antaminen tai poistaminen tulee tapahtua voimassa olevien käytäntöjen mukaan.',
	'makebot-username'        => 'Tunnus:',
	'makebot-search'          => 'Hae',
	'makebot-isbot'           => '[[User:$1|$1]] on botti.',
	'makebot-notbot'          => '[[User:$1|$1]] ei ole botti.',
	'makebot-privileged'      => '[[User:$1|$1]] on [[Special:Listadmins|ylläpitäjä tai byrokraatti]], eikä hänelle voida myöntää botti-merkintää.',
	'makebot-change'          => 'Muuta merkintää:',
	'makebot-grant'           => 'Anna',
	'makebot-revoke'          => 'Poista',
	'makebot-comment'         => 'Kommentti:',
	'makebot-granted'         => '[[User:$1|$1]] on nyt botti.',
	'makebot-revoked'         => '[[User:$1|$1]] ei ole enää botti.',
	'makebot-logpage'         => 'Botti-loki',
	'makebot-logpagetext'     => 'Tämä on loki muutoksista käyttäjätunnusten [[{{MediaWiki:Grouppage-bot}}|botti-merkintään]].',
	'makebot-logentrygrant'   => 'antoi botti-merkinnän tunnukselle [[$1]]',
	'makebot-logentryrevoke'  => 'poisti botti-merkinnän tunnukselta [[$1]]',
);

/** Fijian (Na Vosa Vakaviti)
 * @author SPQRobin
 */
$messages['fj'] = array(
	'makebot-username' => 'Yaca vakayagataki:',
	'makebot-search'   => 'Lako',

);

$messages['fo'] = array(
	'makebot-username'        => 'Brúkaranavn:',
	'makebot-search'          => 'Far',
);

/* French (Bertrand Grondin) */
$messages['fr'] = array(
	'makebot'                 => 'Accorder ou révoquer les droits de bot',
	'makebot-desc'            => 'Page spéciale permettant aux bureaucrates locaux d’accorder ou de révoquer les permissions de bot.',
	'makebot-header'          => '\'\'\'Un bureaucrate local peut utiliser cette page pour accorder ou révoquer le [[{{MediaWiki:Grouppage-bot}}|Statut de Bot]] à un autre compte d\'utilisateur.\'\'\'<br />Le statut de bot a pour particularité de masquer les éditions des utilisateurs dans la page des [[Special:Recentchanges|modification récentes]] et de toutes autres listes similaires. Ceci est très utile pour marquer les utilisateurs qui veulent faire des éditions automatiques. Ceci ne doit être fait que conformément aux règles édictées au sein de chaque projet.',
	'makebot-username'        => 'Nom d’utilisateur :',
	'makebot-search'          => 'Valider',
	'makebot-isbot'           => '[[User:$1|$1]] a le statut de bot.',
	'makebot-notbot'          => '[[User:$1|$1]] n’a pas le statut de bot.',
	'makebot-privileged'      => '[[User:$1|$1]] est déjà [[Special:Listadmins|un administrateur]] et ne peut avoir le statut de « bot ».',
	'makebot-change'          => 'Changer les droits :',
	'makebot-grant'           => 'Accorder',
	'makebot-revoke'          => 'Révoquer',
	'makebot-comment'         => 'Commentaire :',
	'makebot-granted'         => '[[User:$1|$1]] a désormais le statut de bot.',
	'makebot-revoked'         => '[[User:$1|$1]] n’a plus le statut de bot.',
	'makebot-logpage'         => 'Historique des changements de statut des bots',
	'makebot-logpagetext'     => 'Cette page répertorie les changements (acquisitions et pertes) de statut des [[{{MediaWiki:Grouppage-bot}}|bots]].',
	'makebot-logentrygrant'   => 'a accordé le statut de bot à [[$1]]',
	'makebot-logentryrevoke'  => 'a révoqué le statut de bot de [[$1]]',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'makebot'                => 'Balyér ou rèvocar los drêts de bot',
	'makebot-header'         => "'''Un burôcrate local pôt utilisar ceta pâge por balyér ou rèvocar lo [[{{MediaWiki:Grouppage-bot}}|statut de bot]] a un ôtro compto utilisator.'''<br />Lo statut de bot at por èxcèpcion de mâscar les èdicions des utilisators dens la pâge des [[Special:Recentchanges|dèrriérs changements]] et de totes les ôtres listes semblâbles. Cen est rudo utilo por marcar los utilisators que vôlont fâre des èdicions ôtomatiques. Cen dêt étre fêt ren que d’aprés les règlles publeyês u méten de châque projèt.",
	'makebot-username'       => 'Nom d’utilisator :',
	'makebot-search'         => 'Validar',
	'makebot-isbot'          => '[[User:$1|$1]] at lo statut de bot.',
	'makebot-notbot'         => '[[User:$1|$1]] at pas lo statut de bot.',
	'makebot-privileged'     => '[[User:$1|$1]] est ja [[Special:Listadmins|un administrator]] et pôt pas avêr lo statut de « bot ».',
	'makebot-change'         => 'Changiér los drêts :',
	'makebot-grant'          => 'Balyér',
	'makebot-revoke'         => 'Rèvocar',
	'makebot-comment'        => 'Comentèro :',
	'makebot-granted'        => 'Dês ora, [[User:$1|$1]] at lo statut de bot.',
	'makebot-revoked'        => '[[User:$1|$1]] at pas més lo statut de bot.',
	'makebot-logpage'        => 'Historico des changements de statut des bots',
	'makebot-logpagetext'    => 'Ceta pâge liste los changements (aquis et pèrtes) de statut des [[{{MediaWiki:Grouppage-bot}}|bots]].',
	'makebot-logentrygrant'  => 'at balyê lo statut de bot a [[$1]]',
	'makebot-logentryrevoke' => 'at rèvocâ lo statut de bot de [[$1]]',
);

/** Irish (Gaeilge)
 * @author SPQRobin
 */
$messages['ga'] = array(
	'makebot-logentrygrant'  => 'tugtar stádas robait do [[$1]]',
	'makebot-logentryrevoke' => 'baintear stádas robait de [[$1]]',
);

$messages['gl'] = array(
	'makebot'                 => 'Outorgar ou retirar o status de bot',
	'makebot-header'          => '\'\'\'Un burócrata local pode usar esta páxina para outorgar ou revocar [[{{MediaWiki:Grouppage-bot}}|status de bot]] a outras contas de usuarios.\'\'\'<br />O status de bot oculta as edicións dos usuarios dos [[Special:Recentchanges|cambios recentes]], e é útil para sinalar aos usuarios que fan edicións automatizadas. Debe ser feito de acordo coas políticas aplicábeis.',
	'makebot-username'        => 'Nome de usuario:',
	'makebot-search'          => 'Ir',
	'makebot-isbot'           => '[[User:$1|$1]] ten status de bot.',
	'makebot-notbot'          => '[[User:$1|$1]] non ten status de bot.',
	'makebot-privileged'      => '[[User:$1|$1]] ten [[Special:Listadmins|privilexios de administrador ou burócrata]] e non se lle pode conceder o status de bot.',
	'makebot-change'          => 'Mudar status:',
	'makebot-grant'           => 'Outorgar',
	'makebot-revoke'          => 'Retirar',
	'makebot-comment'         => 'Comentario:',
	'makebot-granted'         => 'Agora [[User:$1|$1]] ten o status de bot.',
	'makebot-revoked'         => '[[User:$1|$1]] xa non ten o status de bot.',
	'makebot-logpage'         => 'Rexistro de bots',
	'makebot-logpagetext'     => 'Este é un rexistro dos cambios do status de [[{{MediaWiki:Grouppage-bot}}|bot]] dos usuarios.',
	'makebot-logentrygrant'   => 'outorgado status de bot a [[$1]]',
	'makebot-logentryrevoke'  => 'retirado status de bot a [[$1]]',
);

/** Gujarati (ગુજરાતી) */
$messages['gu'] = array(
	'makebot-search' => 'શોધો',
);

/** Hawaiian (Hawai`i)
 * @author SPQRobin
 */
$messages['haw'] = array(
	'makebot-username' => "Inoa mea ho'ohana:",
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'makebot'                => 'הענקת או ביטול הרשאת בוט',
	'makebot-desc'           => 'דף מיוחד המאפשר לביורוקרטים מקומיים להעניק ולבטל הרשאות בוט',
	'makebot-header'         => "'''ניתן להשתמש בדף זה כדי להעניק או לבטל [[Project:בוט|הרשאות בוט]] למשתמשים אחרים.'''<br />הרשאת בוט מסתירה את עריכותיו של המשתמש מ[[Special:Recentchanges|השינויים האחרונים]] ורשימות דומות, ושימושית למשתמשים המבצעים עריכות אוטומטיות. יש להעניק הרשאת בוט אך ורק לפי הנהלים המתאימים.",
	'makebot-username'       => 'שם משתמש:',
	'makebot-search'         => 'הצגה',
	'makebot-isbot'          => 'למשתמש [[User:$1|$1]] יש הרשאת בוט.',
	'makebot-notbot'         => 'למשתמש [[User:$1|$1]] אין הרשאת בוט.',
	'makebot-privileged'     => 'למשתמש [[User:$1|$1]] יש כבר [[Special:Listusers/sysop|הרשאות מפעיל מערכת או ביורוקרט]], ולפיכך אי אפשר להעניק לו דגל בוט.',
	'makebot-change'         => 'מה לבצע:',
	'makebot-grant'          => 'הענקת הרשאה',
	'makebot-revoke'         => 'ביטול הרשאה',
	'makebot-comment'        => 'סיבה:',
	'makebot-granted'        => 'המשתמש [[{{ns:user}}:$1|$1]] קיבל הרשאת בוט.',
	'makebot-revoked'        => 'הרשאת הבוט של המשתמש [[{{ns:user}}:$1|$1]] הוסרה בהצלחה.',
	'makebot-logpage'        => 'יומן הרשאות בוט',
	'makebot-logpagetext'    => 'זהו יומן השינויים בהרשאות ה[[{{ns:help}}:בוט|בוט]] של המשתמשים.',
	'makebot-logentrygrant'  => 'העניק הרשאת בוט למשתמש [[$1]]',
	'makebot-logentryrevoke' => 'ביטל את הרשאת הבוט למשתמש [[$1]]',

	'right-makebot' => 'הענקת וביטול הרשאת בוט',
);

$messages['hr'] = array(
	'makebot'                 => 'Dodjela ili ukidanje \'\'bot\'\' statusa',
	'makebot-header'          => '\'\'\'Lokalni birokrat korištenjem ove stranice dodjeljuje ili povlači [[{{MediaWiki:Grouppage-bot}}|bot status]] suradnicima.\'\'\'<br />Bot status sakriva promjene suradnika na [[Special:Recentchanges|nedavnim promjenama]] i sličnim popisima, i koristan je za označavanje suradnika koji uređuju članke automatski (skriptama). To valja činiti u skladu s važećim smjernicama.',
	'makebot-username'        => 'Suradnik:',
	'makebot-search'          => 'Izvrši',
	'makebot-isbot'           => '[[User:$1|$1]] ima status bota.',
	'makebot-notbot'          => '[[User:$1|$1]] nema bot status.',
	'makebot-privileged'      => '[[User:$1|$1]] ima [[Special:Listadmins|administratorska ili birokratska prava]], i ne može dobiti bot status.',
	'makebot-change'          => 'Promijeni status:',
	'makebot-grant'           => 'Dodijeli',
	'makebot-revoke'          => 'Ukini',
	'makebot-comment'         => 'Komentar:',
	'makebot-granted'         => '[[Suradnik:$1|$1]] je dobio bot status.',
	'makebot-revoked'         => 'Suradniku [[User:$1|$1]] je ukinut bot status.',
	'makebot-logpage'         => 'Evidencija bot-prava',
	'makebot-logpagetext'     => 'Ovo je evidencija promjena suradničkog [[{{MediaWiki:Grouppage-bot}}|bot]] statusa.',
	'makebot-logentrygrant'   => 'dodijeljen bot status suradniku [[$1]]',
	'makebot-logentryrevoke'  => 'ukinut bot status suradniku [[$1]]',
);

$messages['hsb'] = array(
	'makebot'                 => 'Botowy status dać abo zebrać',
	'makebot-header'          => '\'\'\'Lokalny běrokrat móže tutu stronu wužiwać, zo by [[{{MediaWiki:Grouppage-bot}}|botowy status]] dał abo zebrał.\'\'\'<br />Botowy status chowa změny wužiwarja w [[Special:Recentchanges|aktualnych změnach]] a podobnych lisćinach a je za woznamjenjenje wužiwarjow, kotřiž awtomatisce měnja, wužitne. To měło so po přihódnych postajenjach stać.',
	'makebot-username'        => 'Wužiwarske mjeno:',
	'makebot-search'          => 'Pytać',
	'makebot-isbot'           => '[[User:$1|$1]] ma botowy status.',
	'makebot-notbot'          => '[[User:$1|$1]] nima botowy status.',
	'makebot-privileged'      => '[[User:$1|$1]] ma [[Special:Listusers/sysop|prawa administratora abo běrokrata]], botowy status njehodźi so dać.',
	'makebot-change'          => 'Status změnić',
	'makebot-grant'           => 'Dać',
	'makebot-revoke'          => 'Zebrać',
	'makebot-comment'         => 'Komentar:',
	'makebot-granted'         => '[[User:$1|$1]] ma nětko botowy status.',
	'makebot-revoked'         => '[[User:$1|$1]] hižo nima botowy status.',
	'makebot-logpage'         => 'Protokol botoweho statusa',
	'makebot-logpagetext'     => 'To je protokol wšěch změnow [[{{MediaWiki:Grouppage-bot}}|botoweho statusa]] wužiwarja.',
	'makebot-logentrygrant'   => 'Botowy status za [[$1]] daty',
	'makebot-logentryrevoke'  => 'Botowy status wužiwarjej [[$1]] zebrany.',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'makebot'                => 'Botstátusz megadása vagy visszavonása',
	'makebot-header'         => "'''Ezen lap segítségével egy helyi bürokrata [[{{MediaWiki:Grouppage-bot}}|botstátuszt]] adhat vagy vehet el egy másik felhasználótól.'''<br />A botstátusz jelentősége, hogy elrejti az adott szerkesztő szerkesztéseit a [[Special:Recentchanges|friss változások]] oldalról és a hasonló listákról, plusz hasznos jelölés az automatikus szerkesztést végző felhasználók számára.  Az eszközt a szabályoknak megfelelően használd.",
	'makebot-username'       => 'Felhasználónév:',
	'makebot-search'         => 'Menj',
	'makebot-isbot'          => '[[User:$1|$1]] szerkesztőnek botstátusza van.',
	'makebot-notbot'         => '[[User:$1|$1]] nem rendelkezik botstátusszal.',
	'makebot-privileged'     => '[[User:$1|$1]] [[Special:Listadmins|adminisztrátori vagy bürokrata jogokkal rendelkezik]], így nem kaphat botstátuszt.',
	'makebot-change'         => 'Állapot váltása:',
	'makebot-grant'          => 'Megadás',
	'makebot-revoke'         => 'Visszavonás',
	'makebot-comment'        => 'Megjegyzés:',
	'makebot-granted'        => '[[User:$1|$1]] botstátuszt kapott.',
	'makebot-revoked'        => '[[User:$1|$1]] többé nem rendelkezik botstátusszal.',
	'makebot-logpage'        => 'Botstátusz-napló',
	'makebot-logpagetext'    => 'Ez a felhasználók [[{{MediaWiki:Grouppage-bot}}|bot]]státusz-változásainak naplója.',
	'makebot-logentrygrant'  => '[[$1]] szerkesztőnek botstátuszt adott',
	'makebot-logentryrevoke' => '[[$1]] botstátuszát elvette',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'makebot'                 => 'Pemberian atau penarikan status bot',
	'makebot-desc'            => 'Halaman istimewa yang mengizinkan birokrat lokal untuk memberikan atau menarik hak akses bot',
	'makebot-header'          => '\'\'\'Birokrat lokal dapat menggunakan halaman ini untuk memberikan atau menarik [[{{MediaWiki:Grouppage-bot}}|status bot]] untuk akun pengguna lain.\'\'\'<br />Status bot akan menyembunyikan suntingan pengguna dari [[Special:Recentchanges|perubahan terbaru]] dan daftar serupa lainnya, dan berguna untuk menandai pengguna yang melakukan penyuntingan otomatis. Hal ini harus dilakukan sesuai dengan kebijakan yang telah digariskan.',
	'makebot-username'        => 'Nama pengguna:',
	'makebot-search'          => 'Cari',
	'makebot-isbot'           => '[[User:$1|$1]] mempunyai status bot.',
	'makebot-notbot'          => '[[User:$1|$1]] tak mempunyai status bot.',
	'makebot-privileged'      => '[[User:$1|$1]] mempunyai [[Special:Listadmins|berstatus pengurus atau birokrat]], karenanya tak bisa mendapat status bot.',
	'makebot-change'          => 'Ganti status:',
	'makebot-grant'           => 'Berikan',
	'makebot-revoke'          => 'Tarik',
	'makebot-comment'         => 'Komentar:',
	'makebot-granted'         => '[[User:$1|$1]] sekarang mempunyai status bot.',
	'makebot-revoked'         => '[[User:$1|$1]] sekarang tidak lagi mempunyai status bot.',
	'makebot-logpage'         => 'Log perubahan status bot',
	'makebot-logpagetext'     => 'Di bawah adalah log perubahan status [[{{MediaWiki:Grouppage-bot}}|bot]] pengguna.',
	'makebot-logentrygrant'   => 'memberikan status bot untuk [[$1]]',
	'makebot-logentryrevoke'  => 'menarik status bot dari [[$1]]',
);

$messages['io'] = array(
	'makebot-username'        => 'Uzantonomo:',
	'makebot-search'          => 'Irar',
);

/** Icelandic (Íslenska)
 * @author SPQRobin
 * @author S.Örvarr.S
 * @author Spacebirdy
 */
$messages['is'] = array(
	'makebot'                => 'Veita eða afturkalla vélmennisskráningu',
	'makebot-header'         => "'''Möppudýr geta notað þessa síðu til að merkja eða afmerkja notenda sem [[{{MediaWiki:Grouppage-bot}}|vélmenni (bot)]].'''<br />Breytingar notanda sem er merktur sem vélmenni sjást ekki á [[Special:Recentchanges|síðunni yfir nýlegar breytingar]] og samskonar síðum, og er gagnlegt fyrir notendur sem gera sjálfvirkar breytingar. Þetta ætti að gera í samræmi við viðeigandi reglur.",
	'makebot-username'       => 'Notandanafn:',
	'makebot-search'         => 'Áfram',
	'makebot-isbot'          => '[[User:$1|$1]] er merktur sem vélmenni.',
	'makebot-notbot'         => '[[User:$1|$1]] er ekki merktur sem vélmenni.',
	'makebot-privileged'     => '[[User:$1|$1]] er annaðhvort [[Special:Listadmins|stjórnandi eða möppudýr]], og því er ekki hægt að merkja hann sem vélmenni.',
	'makebot-change'         => 'Breyta merkingu:',
	'makebot-grant'          => 'Merkja',
	'makebot-revoke'         => 'Afmerkja',
	'makebot-comment'        => 'Upplýsingar:',
	'makebot-granted'        => '[[User:$1|$1]] er nú skráður sem vélmenni.',
	'makebot-revoked'        => '[[User:$1|$1]] er ekki merktur sem vélmenni lengur.',
	'makebot-logpage'        => 'Vélmennaskrá',
	'makebot-logpagetext'    => 'Þetta er skrá yfir merkingar [[{{MediaWiki:Grouppage-bot}}|vélmenna]].',
	'makebot-logentrygrant'  => 'merkti [[$1]] sem vélmenni',
	'makebot-logentryrevoke' => 'afmerkti [[$1]] sem vélmenni',
);

/* Italian (BrokenArrow) */
$messages['it'] = array(
	'makebot'                 => 'Assegna o revoca lo status di bot',
	'makebot-header'          => '\'\'\'Questa pagina consente ai burocrati di assegnare o revocare lo [[{{MediaWiki:Grouppage-bot}}|status di bot]] a un\'altra utenza.\'\'\'<br /> Tale status nasconde le modifiche effettuate dall\'utenza nell\'elenco delle [[{{ns:special}}:Recentchanges|ultime modifiche]] e nelle liste simili; è utile per contrassegnare le utenze che effettuano modifiche in automatico. Tale operazione dev\'essere effettuata in conformità con le policy del sito.',
	'makebot-username'        => 'Nome utente:',
	'makebot-search'          => 'Vai',
	'makebot-isbot'           => 'L\'utente [[{{ns:user}}:$1|$1]] ha lo status di bot.',
	'makebot-notbot'          => 'L\'utente [[{{ns:user}}:$1|$1]] non ha lo status di bot.',
	'makebot-privileged'      => 'L\'utente [[{{ns:user}}:$1|$1]] possiede i privilegi di [[Special:Listadmins|amministratore o burocrate privileges]], che sono incompatibili con lo status di bot.',
	'makebot-change'          => 'Modifica lo status:',
	'makebot-grant'           => 'Concedi',
	'makebot-revoke'          => 'Revoca',
	'makebot-comment'         => 'Commento:',
	'makebot-granted'         => 'L\'utente [[{{ns:user}}:$1|$1]] ha ora lo status di bot.',
	'makebot-revoked'         => 'L\'utente [[{{ns:user}}:$1|$1]] non ha più lo status di bot.',
	'makebot-logpage'         => 'Registro dei bot',
	'makebot-logpagetext'     => 'Qui di seguito viene riportata la lista dei cambiamenti di status dei [[{{MediaWiki:Grouppage-bot}}|bot]].',
	'makebot-logentrygrant'   => 'ha concesso lo status di bot a [[$1]]',
	'makebot-logentryrevoke'  => 'ha revocato lo status di bot a [[$1]]',
);

/* Japanese */
$messages['ja'] = array(
	'makebot'                 => 'botフラグの付与・剥奪',
	'makebot-header'          => '\'\'\'各プロジェクトのビューロクラットはこのページで利用者に[[{{MediaWiki:Grouppage-bot}}|bot]]フラグを付与または除去することができます。 \'\'\'<br />botフラグをつけるとその利用者の編集を[[Special:Recentchanges|最近更新したページ]]やその他類似のページから隠します。この機能は便利な反面危険も孕んでいますので方針に沿った利用を行ってください。',
	'makebot-username'        => '利用者名:',
	'makebot-search'          => '進む',
	'makebot-isbot'           => '[[User:$1|$1]]はbotフラグが付与されています。',
	'makebot-notbot'          => '[[User:$1|$1]]はbotフラグが付与されていません。',
	'makebot-privileged'      => '[[User:$1|$1]]は[[Special:Listusers/sysop|管理者]]あるいは[[Special:Listusers/bureaucrat|ビューロクラット]]の権限を有しているため、botフラグを付与することはできません。',
	'makebot-change'          => '権限の変更:',
	'makebot-grant'           => '付与',
	'makebot-revoke'          => '剥奪',
	'makebot-comment'         => '要約:',
	'makebot-granted'         => '[[User:$1|$1]]にbotフラグを付与しました。',
	'makebot-revoked'         => '[[$1]]のbotフラグを剥奪しました。',
	'makebot-logpage'         => 'Botフラグログ',
	'makebot-logpagetext'     => 'これは[[{{MediaWiki:Grouppage-bot}}|bot]]フラグの付与および剥奪の記録です。',
	'makebot-logentrygrant'   => '[[$1]]にbotフラグを付与しました。',
	'makebot-logentryrevoke'  => '[[$1]]のbotフラグを剥奪しました。',
);

/* Kazakh Arabic (kk:User:AlefZet) */
$messages['kk-arab'] = array(
	'makebot'                 => 'بوت كۇيىن بەرۋ نە قايتارۋ',
	'makebot-header'         => "'''بۇل بەتتى ورنىنداعى بىتىكشىلەر باسقا كاتىسۋشى تىركەلگىسىنە [[{{MediaWiki:Grouppage-bot}}|بوت كۇيىن]] بەرۋ نە قايتارۋ ٴۇشىن قولدانادى.'''<br />بەرىلگەن بوت كۇيى قاتىسۋشىنىڭ وڭدەۋلەرىن [[{{ns:special}}:Recentchanges|جۋىقتاعى وزگەرىستەر]] سىيياقتى تىزىمدەردەن جاسىرادى, جانە دە وزدىك تۇردە وڭدەۋ جاسايتىن قاتىسۋشىلاردى بەلگىلەۋگە قولايلى. وسى ارەكەت ىسكە اساتىن ساياساتى بويىنشا جاسالۋى قاجەت.",
	'makebot-username'        => 'قاتىسۋشى اتى:',
	'makebot-search'          => 'ٴوتۋ',
	'makebot-isbot'           => '[[{{ns:user}}:$1|$1]] دەگەندە بوت كۇيى بار.',
	'makebot-notbot'          => '[[{{ns:user}}:$1|$1]] دەگەندە بوت كۇيى جوق.',
	'makebot-privileged'      => '[[{{ns:user}}:$1|$1]] دەگەندە [[{{ns:special}}:Listadmins|اكىمشى نەمەسە بىتىكشى قۇقىقتارى]] بار, سوندىقتان بوت كۇيى بەرىلمەيدى.',
	'makebot-change'          => 'كۇيىن وزگەرتۋ:',
	'makebot-grant'           => 'بەرۋ',
	'makebot-revoke'          => 'قايتا شاقىرۋ',
	'makebot-comment'         => 'ماندەمەسى:',
	'makebot-granted'         => '[[{{ns:user}}:$1|$1]] دەگەندە ەندى بوت كۇيى بار.',
	'makebot-revoked'         => '[[{{ns:user}}:$1|$1]] دەگەندە ەندى بوت كۇيى جوق.',
	'makebot-logpage'         => 'بوت كۇيى جۋرنالى',
	'makebot-logpagetext'     => 'بۇل قاتىسۋشى [[{{MediaWiki:Grouppage-bot}}|بوت]] كۇيىن وزگەرتۋ جۋرنالى.',
	'makebot-logentrygrant'   => '[[$1]] دەگەنگە بوت كۇيى بەرىلدى',
	'makebot-logentryrevoke'  => '[[$1]] دەگەننەن بوت كۇيى الاستالدى',
);

/* Kazakh Cyrillic (kk:User:AlefZet) */
$messages['kk-cyrl'] = array(
	'makebot'                 => 'Бот күйін беру не қайтару',
	'makebot-header'         => "'''Бұл бетті орнындағы бітікшілер басқа катысушы тіркелгісіне [[{{MediaWiki:Grouppage-bot}}|бот күйін]] беру не қайтару үшін қолданады.'''<br />Берілген бот күйі қатысушының өңдеулерін [[{{ns:special}}:Recentchanges|жуықтағы өзгерістер]] сияқты тізімдерден жасырады, және де өздік түрде өңдеу жасайтын қатысушыларды белгілеуге қолайлы. Осы әрекет іске асатын саясаты бойынша жасалуы қажет.",
	'makebot-username'        => 'Қатысушы аты:',
	'makebot-search'          => 'Өту',
	'makebot-isbot'           => '[[{{ns:user}}:$1|$1]] дегенде бот күйі бар.',
	'makebot-notbot'          => '[[{{ns:user}}:$1|$1]] дегенде бот күйі жоқ.',
	'makebot-privileged'      => '[[{{ns:user}}:$1|$1]] дегенде [[{{ns:special}}:Listadmins|әкімші немесе бітікші құқықтары]] бар, сондықтан бот күйі берілмейді.',
	'makebot-change'          => 'Күйін өзгерту:',
	'makebot-grant'           => 'Беру',
	'makebot-revoke'          => 'Қайта шақыру',
	'makebot-comment'         => 'Мәндемесі:',
	'makebot-granted'         => '[[{{ns:user}}:$1|$1]] дегенде енді бот күйі бар.',
	'makebot-revoked'         => '[[{{ns:user}}:$1|$1]] дегенде енді бот күйі жоқ.',
	'makebot-logpage'         => 'Бот күйі журналы',
	'makebot-logpagetext'     => 'Бұл қатысушы [[{{MediaWiki:Grouppage-bot}}|бот]] күйін өзгерту журналы.',
	'makebot-logentrygrant'   => '[[$1]] дегенге бот күйі берілді',
	'makebot-logentryrevoke'  => '[[$1]] дегеннен бот күйі аласталды',
);

/* Kazakh Latin (kk:User:AlefZet) */
$messages['kk-latn'] = array(
	'makebot'                 => 'Bot küýin berw ne qaýtarw',
	'makebot-header'         => "'''Bul betti ornındağı bitikşiler basqa katıswşı tirkelgisine [[{{MediaWiki:Grouppage-bot}}|bot küýin]] berw ne qaýtarw üşin qoldanadı.'''<br />Berilgen bot küýi qatıswşınıñ öñdewlerin [[{{ns:special}}:Recentchanges|jwıqtağı özgerister]] sïyaqtı tizimderden jasıradı, jäne de özdik türde öñdew jasaýtın qatıswşılardı belgilewge qolaýlı. Osı äreket iske asatın sayasatı boýınşa jasalwı qajet.",
	'makebot-username'        => 'Qatıswşı atı:',
	'makebot-search'          => 'Ötw',
	'makebot-isbot'           => '[[{{ns:user}}:$1|$1]] degende bot küýi bar.',
	'makebot-notbot'          => '[[{{ns:user}}:$1|$1]] degende bot küýi joq.',
	'makebot-privileged'      => '[[{{ns:user}}:$1|$1]] degende [[{{ns:special}}:Listadmins|äkimşi nemese bitikşi quqıqtarı]] bar, sondıqtan bot küýi berilmeýdi.',
	'makebot-change'          => 'Küýin özgertw:',
	'makebot-grant'           => 'Berw',
	'makebot-revoke'          => 'Qaýta şaqırw',
	'makebot-comment'         => 'Mändemesi:',
	'makebot-granted'         => '[[{{ns:user}}:$1|$1]] degende endi bot küýi bar.',
	'makebot-revoked'         => '[[{{ns:user}}:$1|$1]] degende endi bot küýi joq.',
	'makebot-logpage'         => 'Bot küýi jwrnalı',
	'makebot-logpagetext'     => 'Bul qatıswşı [[{{MediaWiki:Grouppage-bot}}|bot]] küýin özgertw jwrnalı.',
	'makebot-logentrygrant'   => '[[$1]] degenge bot küýi berildi',
	'makebot-logentryrevoke'  => '[[$1]] degennen bot küýi alastaldı',
);

$messages['ksh'] = array(
	'makebot'                 => '{{NS:User}} zom Bot maache un ömmjekiijot',
	'makebot-username'        => 'Hee dä {{ns:user}}_Name fö_dä Bot:',
	'makebot-search'          => 'Loßß_Jonn!',
	'makebot-isbot'           => 'Dä {{ns:user}} „[[User:$1|$1]]“ eß alld_enne Bot.',
	'makebot-notbot'          => 'Dä {{ns:user}} „[[:User:$1|$1]]“ eß këĳnne Bot.',
	'makebot-privileged'      => 'Dä {{ns:user}} [[:User:$1|$1]] ess_[[:Special:Listadmins|enne Wikki_Köbeß odder_enne Bürokraat]], un dä kann dröm nit zom Bot jemaat wääde.',
	'makebot-change'          => 'Änndere:',
	'makebot-grant'           => 'Zom Bot maache',
	'makebot-revoke'          => 'Fott_Nämme',
	'makebot-comment'         => 'Bemärrkung:',
	'makebot-granted'         => 'Dä {{ns:user}} „[[:User:$1|$1]]“ eß jäz enn Bot.',
	'makebot-revoked'         => 'Dä {{ns:user}} „[[User:$1|$1]]“ eß jäz këĳnne Bot mih.',
	'makebot-logpage'         => 'Logbooch met Bot_Shtatus_Änderonge',
	'makebot-logpagetext'     => 'He is opjelėßß, wat fö_n {{ns:user}} wat fö_n anndere {{ns:user}} dä Shtatuß als_enne Bot_jejovve oddo_fottjenumme hann.',
	'makebot-logentrygrant'   => 'hät dä_{{ns:user}} „[[$1]]“ zom Bot jemaat',
	'makebot-logentryrevoke'  => 'hät däm_{{ns:user}} „[[$1]]“ de Bot-Ëĳeschaff jenůmme',
);

$messages['la'] = array(
	'makebot-username'        => 'Nomen usoris:',
	'makebot-search'          => 'Ire',
	'makebot-isbot'           => '[[User:$1|$1]]] statum bot habet.',
	'makebot-notbot'          => '[[User:$1|$1]] non habet statum bot.',
	'makebot-change'          => 'Statum modificare:',
	'makebot-grant'           => 'Licere',
	'makebot-revoke'          => 'Revocare',
	'makebot-comment'         => 'Sententia:',
	'makebot-granted'         => '[[User:$1|$1]] nunc statum bot habet.',
	'makebot-revoked'         => '[[User:$1|$1]] non iam statum bot habet.',
	'makebot-logpage'         => 'Index mutationum statui bot',
	'makebot-logpagetext'     => 'Hic est index mutationum statui [[{{MediaWiki:Grouppage-bot}}|bot]] usorum.',
	'makebot-logentrygrant'   => 'licuit statum bot pro [[$1]]',
	'makebot-logentryrevoke'  => 'removit statum bot usoris [[$1]]',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'makebot'                => 'Botstatus autoriséieren oder ofhuelen',
	'makebot-header'         => "'''E Bürokrat vun dëser Wiki kann anere Benotzer - no de lokale Riichtlinnen - de [[{{MediaWiki:Grouppage-bot}}|Botstatus]] erdeelen oder entzéien.<br /> Mat dem Botstatus ass et méiglech, d'Kontributiounen vu Bot-Benotzerkonten an der Lëscht vun de '''[[Special:Recentchanges|rezenten Ännerungen]]''' an an änleche Lëschten ze verstoppen. D'Botmarkéierung ass doriwwer eraus nëtzlech fir automatesch Verännerunge vun Säiten z'erkennen.",
	'makebot-username'       => 'Benotzernumm:',
	'makebot-search'         => 'Status offroen',
	'makebot-isbot'          => 'De [[User:$1|$1]] huet Botstatus.',
	'makebot-notbot'         => '[[User:$1|$1]] huet de Botstatus net.',
	'makebot-change'         => 'Status änneren:',
	'makebot-grant'          => 'Autoriséieren',
	'makebot-revoke'         => 'Ofhuelen',
	'makebot-comment'        => 'Bemierkung:',
	'makebot-granted'        => '[[User:$1|$1]] huet elo Botstatus.',
	'makebot-revoked'        => '[[User:$1|$1]] huet de Botstatus net méi.',
	'makebot-logpage'        => 'Logbuch vum Botstatus',
	'makebot-logentrygrant'  => 'huet dem [[$1]] de Botstatus autoriséiert',
	'makebot-logentryrevoke' => '[[$1]] krut de Botstatus ofgeholl',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'makebot'          => 'Gaef of nöm botsjtatus aaf',
	'makebot-header'   => "''''ne Bureaucraat kin via dees pazjena 'ne [[{{MediaWiki:Grouppage-bot}}|botstatus]] aan 'ne angere gebroeker gaeve of dae status tröknömme.'''<br />De botstatus verberg de bewèrkinge van 'ne gebroeker in de [[Special:Recentchanges|Recènte Verangeringe]] en gelieksaortige lieste. 't Is henjig veur gebroekers die automatische bewèrkinge make. Dit heurt aan de handj van 't geljendje beleid te gebeure.",
	'makebot-username' => 'Gebroekersnaam:',
	'makebot-search'   => 'OK',
	'makebot-isbot'    => '[[User:$1|$1]] haet botstatus.',
	'makebot-change'   => 'Veranger de sjtatus:',
	'makebot-grant'    => 'Gaeve',
	'makebot-revoke'   => 'Innömme',
	'makebot-comment'  => 'Opmèrking:',
);

/* Lao */
$messages['lo'] = array(
	'makebot-username' => 'ຊື່ຜູ້ໃຊ້:',
	'makebot-search'   => 'ໄປ',
	'makebot-comment'  => 'ຄຳເຫັນ:',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'makebot-username' => 'Brukernaam:',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'makebot'                => 'Botstatus beheren',
	'makebot-header'         => "'''Een bureaucraat kan via deze pagina een [[{{MediaWiki:Grouppage-bot}}|botstatus]] aan een andere gebruiker verlenen of die status intrekken.'''<br />De botstatus verbergt de bewerkingen van een gebruiker in de [[Special:Recentchanges|recente wijzigingen]] en gelijksoortige lijsten. Het is handig voor gebruikers die automatisch bewerkingen maken. Dit hoort aan de hand van het geldende beleid te gebeuren.",
	'makebot-username'       => 'Gebruiker:',
	'makebot-search'         => 'OK',
	'makebot-isbot'          => '[[User:$1|$1]] heef de botstatus.',
	'makebot-notbot'         => '[[User:$1|$1]] heeft geen botstatus.',
	'makebot-privileged'     => '[[User:$1|$1]] heeft de rol [[Special:Listadmins|beheerder of bureaucraat]] en kan geen botstatus krijgen.',
	'makebot-change'         => 'Status wijzigen:',
	'makebot-grant'          => 'Verlenen',
	'makebot-revoke'         => 'Intrekken',
	'makebot-comment'        => 'Opmerking:',
	'makebot-granted'        => '[[User:$1|$1]] heeft nu de botstatus.',
	'makebot-revoked'        => '[[User:$1|$1]] heeft niet langer de botstatus.',
	'makebot-logpage'        => 'Botstatuslogboek',
	'makebot-logpagetext'    => 'Dit is een logboek waarin wijzigingen ten aanzien van de [[{{MediaWiki:Grouppage-bot}}|botstatus]] van gebruikers te zien zijn.',
	'makebot-logentrygrant'  => 'heeft de botstatus gegeven aan [[$1]]',
	'makebot-logentryrevoke' => 'heeft de botstatus van [[$1]] ingetrokken',
);

/* Norwegian (Jon Harald Søby) */
$messages['no'] = array(
	'makebot'                 => 'Gi eller fjern botstatus',
	'makebot-header'          => '\'\'\'En byråkrat kan bruke denne siden til å gi eller fjerne [[{{MediaWiki:Grouppage-bot}}|botstatus]] på en brukerkonto.\'\'\'<br />Botstatus skjuler en kontos redigeringer fra [[Special:Recentchanges|siste endringer]] og lignende lister, og er nyttig for flagging av kontoer som gjør automatiske endringer. Dette burde gjøres i samsvar med gjeldende retningslinjer.',
	'makebot-username'        => 'Brukernavn:',
	'makebot-search'          => 'Gå',
	'makebot-isbot'           => '[[User:$1|$1]] har botstatus.',
	'makebot-notbot'          => '[[User:$1|$1]] har ikke botstatus.',
	'makebot-privileged'      => '[[User:$1|$1]] har [[Special:Listadmins|administrator- eller byråkratrettigheter]], og kan ikke gis botstatus.',
	'makebot-change'          => 'Endre status:',
	'makebot-grant'           => 'Gi',
	'makebot-revoke'          => 'Fjern',
	'makebot-comment'         => 'Kommentar:',
	'makebot-granted'         => '[[User:$1|$1]] har nå botstatus.',
	'makebot-revoked'         => '[[User:$1|$1]] har ikke lenger botstatus.',
	'makebot-logpage'         => 'Botstatuslogg',
	'makebot-logpagetext'     => 'Dette er en logg over endringer i kontoers [[{{MediaWiki:Grouppage-bot}}|botstatus]].',
	'makebot-logentrygrant'   => 'ga botstatus til [[User:$1|$1]]',
	'makebot-logentryrevoke'  => 'fjernet botstatus fra [[User:$1|$1]]',
);

/* Occitan (Cedric31) */
$messages['oc'] = array(
	'makebot'                 => 'Donar o levar los dreches de bòt',
	'makebot-header'          => '\'\'\'Un burocrata local pòt utilizar aquesta pagina per acordar o revocar l\'[[{{MediaWiki:Grouppage-bot}}|Estatut de Bòt]] a un autre compte d\'utilizaire.\'\'\'<br />L\'estatut de bòt a per particularitat d\'amagar las edicions dels utilizaires dins la pagina dels [[Special:Recentchanges|darrièrs cambiaments]] e de totas las autras listas similàrias. Aquò es fòrt util per marcar los utilizaires que vòlon far d\'edicions automaticas. Aquò deu pas èsser fach pas que conformament a las règlas edictadas al sen de cada projècte.',
	'makebot-username'        => 'Nom d\'utilizaire:',
	'makebot-search'          => 'Validar',
	'makebot-isbot'           => '[[User:$1|$1]] a l\'estatut de bòt.',
	'makebot-notbot'          => '[[User:$1|$1]] a pas l\'estatut de bòt.',
	'makebot-privileged'      => '[[User:$1|$1]] ja es [[Special:Listadmins|un administrator]] e pòt pas aver l\'estatut de « bòt ».',
	'makebot-change'          => 'Cambiar los dreches:',
	'makebot-grant'           => 'Acordar',
	'makebot-revoke'          => 'Revocar',
	'makebot-comment'         => 'Comentari:',
	'makebot-granted'         => 'D\'ara enlà, [[User:$1|$1]] a l\'estatut de bòt.',
	'makebot-revoked'         => '[[User:$1|$1]] a pas mai l\'estatut de bòt.',
	'makebot-logpage'         => 'Istoric dels cambiaments d\'estatut dels bòts',
	'makebot-logpagetext'     => 'Aquesta pagina repertòria los cambiaments (aquisicions e pèrdas) d\'estatut dels [[{{MediaWiki:Grouppage-bot}}|bòts]].',
	'makebot-logentrygrant'   => 'a balhat l\'estatut de bòt a [[$1]]',
	'makebot-logentryrevoke'  => 'a levat l\'estatut de bòt de [[$1]]',
);

$messages['pl'] = array(
	'makebot'                 => 'Nadawanie i odbieranie flagi bota',
	'makebot-header'          => '\'\'\'Lokalny biurokrata może użyć tej strony do przyznania lub odebrania kontu użytkownika [[{{MediaWiki:Grouppage-bot}}|flagi bota]].\'\'\'<br />Flaga bota ukrywa edycje użytkownika w [[Special:Recentchanges|liście ostatnich zmian]] i podobnych listach, jest przydatna do oznaczania użytkowników, którzy robią automatyczne edycje. Przyznawanie flagi bota powinno się odbywać w zgodzie z lokalnymi zasadami.',
	'makebot-username'        => 'Konto:',
	'makebot-search'          => 'Start',
	'makebot-isbot'           => '[[User:$1|$1]] ma status bota.',
	'makebot-notbot'          => '[[User:$1|$1]] nie ma statusu bota.',
	'makebot-privileged'      => '[[User:$1|$1]] ma [[Special:Listadmins|uprawnienia administratora lub biurokraty]] i nie może otrzymać statusu bota.',
	'makebot-change'          => 'Zmień uprawnienia:',
	'makebot-grant'           => 'Przyznaj',
	'makebot-revoke'          => 'Odbierz',
	'makebot-comment'         => 'Komentarz:',
	'makebot-granted'         => '[[User:$1|$1]] otrzymał status bota.',
	'makebot-revoked'         => 'Konto [[User:$1|$1]] nie ma już flagi bota.',
	'makebot-logpage'         => 'Rejestr flag bota',
	'makebot-logpagetext'     => 'Operacje nadawania i zdejmowania [[{{MediaWiki:Grouppage-bot}}|flagi bota]]:',
	'makebot-logentrygrant'   => 'nadano kontu [[$1]] flagę bota.',
	'makebot-logentryrevoke'  => 'odebrano kontu [[$1]] flagę bota.',
);

/* Piedmontese (Bèrto 'd Sèra) */
$messages['pms'] = array(
	'makebot'                 => 'Gava ò buta la qualìfica da trigomiro',
	'makebot-header'          => '\'\'\'Un mangiapapé a peul dovré sta pàgina-sì për buteje ò gaveje la [[{{MediaWiki:Grouppage-bot}}|qualìfica da trigomiro]] al cont ëd n\'àotr utent.\'\'\'<br />Le qualìfiche da trigomiro a stërmo le modìfiche ëd n\'utent da \'nt j\'[[Special:Recentchanges|ùltime modìfiche]] e da dj\'àotre liste parej, e a ven-o a taj për marché coj utent ch\'a fan dij travaj aotomàtich. Sòn a ventrìa sempe dovrelo conforma a le polìtiche corente.',
	'makebot-username'        => 'Stranòm:',
	'makebot-search'          => 'Va',
	'makebot-isbot'           => '[[User:$1|$1]] a l\'ha la qualìfica da trigomiro.',
	'makebot-notbot'          => '[[User:$1|$1]] a l\'ha pa la qualìfica da trigomiro.',
	'makebot-privileged'      => '[[User:$1|$1]] a l\'ha la [[Special:Listadmins|qualìfica da aministrator ò da mangiapapé]], e a peul nen avej cola da trigomiro.',
	'makebot-change'          => 'Modìfica lë stat:',
	'makebot-grant'           => 'Buta',
	'makebot-revoke'          => 'Gava',
	'makebot-comment'         => 'Coment:',
	'makebot-granted'         => '[[User:$1|$1]] adess a l\'ha la qualìfica da trigomiro.',
	'makebot-revoked'         => '[[User:$1|$1]] a l\'ha pì nen la qualìfica da trigomiro.',
	'makebot-logpage'         => 'Registr dle qualìfiche da trigomiro',
	'makebot-logpagetext'     => 'Cost-sì a l\'é un registr ch\'a marca le modìfiche faite a le qualìfiche da [[{{MediaWiki:Grouppage-bot}}|trigomiro]] dj\'utent.',
	'makebot-logentrygrant'   => 'qualìfica da trigomiro daita a [[$1]]',
	'makebot-logentryrevoke'  => 'gavà la qualìfica da trigomiro a [[$1]]',
);

/* Portuguese (Lugusto) */
$messages['pt'] = array(
	'makebot'                 => 'Conceder ou remover estatuto de bot',
	'makebot-header'          => '\'\'\'Um burocrata local poderá a partir desta página conceder ou remover [[{{MediaWiki:Grouppage-bot}}|estatutos de bot]] em outras contas de utilizador.\'\'\'<br />Um estatuto de bot faz com que as edições do utilizador sejam ocultadas da página de [[Special:Recentchanges|mudanças recentes]] e listagens similares, sendo bastante útil para marcar contas de utilizadores que façam edições automatizadas. Isso deverá ser feito de acordo com as políticas aplicáveis.',
	'makebot-username'        => 'Utilizador:',
	'makebot-search'          => 'Ir',
	'makebot-isbot'           => '[[User:$1|$1]] possui estatuto de bot.',
	'makebot-notbot'          => '[[User:$1|$1]] não possui estatuto de bot.',
	'makebot-privileged'      => '[[User:$1|$1]] possui [[Special:Listadmins|privilégios de administrador ou burocrata]], não podendo que o estatuto de bot seja a ele concedido.',
	'makebot-change'          => 'Alterar estado:',
	'makebot-grant'           => 'Conceder',
	'makebot-revoke'          => 'Remover',
	'makebot-comment'         => 'Comentário:',
	'makebot-granted'         => '[[User:$1|$1]] agora possui estatuto de bot.',
	'makebot-revoked'         => '[[User:$1|$1]] deixou de ter estatuto de bot.',
	'makebot-logpage'         => 'Registo de estatutos de bot',
	'makebot-logpagetext'     => 'Este é um registo de alterações quanto ao\' estatuto de [[{{MediaWiki:Grouppage-bot}}|bot]].',
	'makebot-logentrygrant'   => 'concedido estatuto de bot para [[$1]]',
	'makebot-logentryrevoke'  => 'removido estatuto de bot para [[$1]]',
);

$messages['rm'] = array(
	'makebot-username'        => 'Num d\'utilisader:',
);

/* Romanian (KlaudiuMihăilă) */
$messages['ro'] = array(
	'makebot'                 => 'Acordarea şi revocarea statutului de robot',
	'makebot-header'          => '\'\'\'Un birocrat poate folosi acest formular pentru a acorda sau revoca statutul de [[{{MediaWiki:Grouppage-bot}}|robot]].\'\'\'<br />Statutul de robot ascunde modificările utilizatorului în lista de [[Special:Recentchanges|schimbări recente]] şi alte liste asemănătoare, ceea ce este util în cazul utilizatorilor care fac modificări automate. Acordarea şi revocarea statutului de robot se fac conform regulamentului.',
	'makebot-username'        => 'Nume de utilizator:',
	'makebot-search'          => 'Salt',
	'makebot-isbot'           => '[[Utilizator:$1|$1]] are statut de bot.',
	'makebot-notbot'          => '[[Utilizator:$1|$1]] nu are statut de robot.',
	'makebot-privileged'      => '[[Utilizator:$1|$1]] are [[Special:Listadmins|permisiuni de administrator sau birocrat]] şi nu poate primi statutul de robot.',
	'makebot-change'          => 'Schimbă statut:',
	'makebot-grant'           => 'Acordă',
	'makebot-revoke'          => 'Revocă',
	'makebot-comment'         => 'Comentariu:',
	'makebot-granted'         => '[[Utilizator:$1|$1]] are statut de robot.',
	'makebot-revoked'         => '[[Utilizator:$1|$1]] nu mai are statut de robot.',
	'makebot-logpage'         => 'Jurnal roboţi',
	'makebot-logpagetext'     => 'Acesta este jurnalul modificărilor în statutul de [[{{MediaWiki:Grouppage-bot}}|robot]] al utilizatorilor.',
	'makebot-logentrygrant'   => 'a acordat statutul de robot utilizatorului [[$1]]',
	'makebot-logentryrevoke'  => 'a revocat statutul de robot lui [[$1]]',
);

/* Russian */
$messages['ru'] = array(
	'makebot' => 'Присвоить/снять статус бота',
	'makebot-header' => "'''Бюрократы могут использовать эту страницу для присвоения участнику статуса бота и лишения его.'''<br />Статус бота позволяет скрывать правки участника на странице [[Special:Recentchanges|свежих правок]] и в других подобных местах и полезен для пометки участников, делающих множество правок в автоматизированном режиме. Присвоение и лишение статуса должно осуществляться согласно действующим правилам.",
	'makebot-username' => 'Имя участника:',
	'makebot-search' => 'Искать',
	'makebot-isbot' => '[[User:$1|Участник $1]] имеет статус бота.',
	'makebot-notbot' => '[[User:$1|Участник $1]] не имеет статуса бота.',
	'makebot-privileged' => '[[User:$1|Участник $1]] является [[Special:Listadmins|администратором или бюрократом]] и не может получить статус бота.',
	'makebot-change' => 'Изменить статус:',
	'makebot-grant' => 'Присвоить',
	'makebot-revoke' => 'Снять',
	'makebot-comment' => 'Комментарий:',
	'makebot-granted' => '[[User:$1|Участнику $1]] присвоен статус бота.',
	'makebot-revoked' => 'С [[User:$1|участник $1]] снят статус бота.',
	'makebot-logpage' => 'Журнал изменения статуса бота',
	'makebot-logpagetext' => 'В данном журнале отображены изменения статуса бота.',
	'makebot-logentrygrant' => 'присвоил статус бота участнику [[$1]]',
	'makebot-logentryrevoke' => 'снял статус бота с участника [[$1]]',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'makebot'                => 'Udeliť alebo odobrať status bota',
	'makebot-header'         => "'''Miestny byrokrat môže použiť túto stránku na udelenie alebo odobranie [[{{MediaWiki:Grouppage-bot}}|statusu bot]] inému používateľskému účtu.'''<br />Status bot skrýva úpravy používateľa z [[Special:Recentchanges|posledných zmien]] a podobných zoznamov, používa sa na označenie používateľov, ktorí robia automatizované úpravy. Využívanie tejto stránky by malo prebiehať v súlade s prijatými zásadami.",
	'makebot-username'       => 'Používateľské meno:',
	'makebot-search'         => 'Vykonať',
	'makebot-isbot'          => '[[User:$1|$1]] má status bot.',
	'makebot-notbot'         => '[[User:$1|$1]] nemá status bot.',
	'makebot-privileged'     => '[[User:$1|$1]] má [[Special:Listadmins|privilégiá správcu alebo byrokrata]], a preto mu nemôže byt udelený status bot.',
	'makebot-change'         => 'Zmeniť status:',
	'makebot-grant'          => 'Udeliť',
	'makebot-revoke'         => 'Odobrať',
	'makebot-comment'        => 'Komentár:',
	'makebot-granted'        => '[[User:$1|$1]] odteraz má status bot.',
	'makebot-revoked'        => '[[User:$1|$1]] odteraz nemá status bot.',
	'makebot-logpage'        => 'Záznam statusu bot',
	'makebot-logpagetext'    => 'Toto je záznam zmien používateľského stavu na/z [[{{MediaWiki:Grouppage-bot}}|bot]].',
	'makebot-logentrygrant'  => 'udelený status bot používateľovi [[$1]]',
	'makebot-logentryrevoke' => 'odobratý status bot používateľovi [[$1]]',
);

/* Albanian */
$messages['sq'] = array(
	'makebot'                => 'Jepni ose hiqni titullin robot',
	'makebot-change'         => 'Ndrysho titullin:',
	'makebot-comment'        => 'Shënim:',
	'makebot-grant'          => 'Jepja',
	'makebot-granted'        => '[[User:$1|$1]] tani ka titullin robot.',
	'makebot-header'         => "'''Një burokrat mund të përdori këtë faqe për t'i dhënë apo hequr titullin robot një përdoruesi tjetër.'''<br />Titulli robot fsheh redaktimet automatike të përdoruesit nga [[Special:Recentchanges|ndryshime së fundmi]] dhe lista të ngjashme. Titulli duhet dhënë sipas rregullave të vendosura.",
	'makebot-isbot'          => '[[User:$1|$1]] ka titull robot.',
	'makebot-logentrygrant'  => 'i dha titullin robot [[$1]]',
	'makebot-logentryrevoke' => 'i hoqi titullin robot [[$1]]',
	'makebot-logpage'        => 'Regjistri i robotëve',
	'makebot-logpagetext'    => 'Ky është një regjistër për ndryshimin e privilegjit robot të përdoruesve.',
	'makebot-notbot'         => '[[User:$1|$1]] nuk ka status robot.',
	'makebot-privileged'     => "[[User:$1|$1]] ka privilegje [[Special:Listadmins|administruesi ose burokrati]] dhe s'mund t'i jepet statusi robot.",
	'makebot-revoke'         => 'Hiqja',
	'makebot-revoked'        => '[[User:$1|$1]] nuk ka më status robot.',
	'makebot-search'         => 'Shko',
	'makebot-username'       => 'Përdoruesi:',
);

/* Serbian default (Sasa Stefanovic) */
$messages['sr'] = array(
	'makebot'                 => 'Давање или одузимање статуса бота',
	'makebot-header'          => '\'\'\'Локални бирократа може користити ову страну да даје или одузима [[{{MediaWiki:Grouppage-bot}}|статус бота]] неком другом корисничком налогу.\'\'\'<br />Статус бота скрива измене корисника са [[Посебно:Recentchanges|скорашњих измена]] и сличних листа и користан је за обележавање корисника који врше аутоматске измене. Ово треба да се ради у складу са одговарајућим политикама.',
	'makebot-username'        => 'Корисничко име:',
	'makebot-search'          => 'Иди',
	'makebot-isbot'           => '[[User:$1|$1]] има статус бота.',
	'makebot-notbot'          => '[[User:$1|$1]] нема статус бота.',
	'makebot-privileged'      => '[[Корисник:$1|$1]] има [[Посебно:Listadmins|администраторске или бирократске привилегије]], и не може му се доделити статус бота.',
	'makebot-change'          => 'Промени статус:',
	'makebot-grant'           => 'Дај',
	'makebot-revoke'          => 'Одузми',
	'makebot-comment'         => 'Коментар:',
	'makebot-granted'         => '[[Корисник:$1|$1]] сада има статус бота.',
	'makebot-revoked'         => '[[Корисник:$1|$1]] више нема статус бота.',
	'makebot-logpage'         => 'историја статуса бота',
	'makebot-logpagetext'     => 'Ово је историја измена статуса [[{{MediaWiki:Grouppage-bot}}|бота]] корисника.',
	'makebot-logentrygrant'   => 'дао статус бота: [[$1]]',
	'makebot-logentryrevoke'  => 'уклонио статус бота: [[$1]]',
);

/* Serbian cyrillic (Sasa Stefanovic) */
$messages['sr-ec'] = array(
	'makebot'                 => 'Давање или одузимање статуса бота',
	'makebot-header'          => '\'\'\'Локални бирократа може користити ову страну да даје или одузима [[{{MediaWiki:Grouppage-bot}}|статус бота]] неком другом корисничком налогу.\'\'\'<br />Статус бота скрива измене корисника са [[Посебно:Recentchanges|скорашњих измена]] и сличних листа и користан је за обележавање корисника који врше аутоматске измене. Ово треба да се ради у складу са одговарајућим политикама.',
	'makebot-username'        => 'Корисничко име:',
	'makebot-search'          => 'Иди',
	'makebot-isbot'           => '[[User:$1|$1]] има статус бота.',
	'makebot-notbot'          => '[[User:$1|$1]] нема статус бота.',
	'makebot-privileged'      => '[[Корисник:$1|$1]] има [[Посебно:Listadmins|администраторске или бирократске привилегије]], и не може му се доделити статус бота.',
	'makebot-change'          => 'Промени статус:',
	'makebot-grant'           => 'Дај',
	'makebot-revoke'          => 'Одузми',
	'makebot-comment'         => 'Коментар:',
	'makebot-granted'         => '[[Корисник:$1|$1]] сада има статус бота.',
	'makebot-revoked'         => '[[Корисник:$1|$1]] више нема статус бота.',
	'makebot-logpage'         => 'историја статуса бота',
	'makebot-logpagetext'     => 'Ово је историја измена статуса [[{{MediaWiki:Grouppage-bot}}|бота]] корисника.',
	'makebot-logentrygrant'   => 'дао статус бота: [[$1]]',
	'makebot-logentryrevoke'  => 'уклонио статус бота: [[$1]]',
);

/* Serbian latin (Sasa Stefanovic) */
$messages['sr-el'] = array(
	'makebot'                 => 'Davanje ili oduzimanje statusa bota',
	'makebot-header'          => '\'\'\'Lokalni birokrata može koristiti ovu stranu da daje ili oduzima [[{{MediaWiki:Grouppage-bot}}|status bota]] nekom drugom korisničkom nalogu.\'\'\'<br />Status bota skriva izmene korisnika sa [[Posebno:Recentchanges|skorašnjih izmena]] i sličnih lista i koristan je za obeležavanje korisnika koji vrše automatske izmene. Ovo treba da se radi u skladu sa odgovarajućim politikama.',
	'makebot-username'        => 'Korisničko ime:',
	'makebot-search'          => 'Idi',
	'makebot-isbot'           => '[[User:$1|$1]] ima status bota.',
	'makebot-notbot'          => '[[User:$1|$1]] nema status bota.',
	'makebot-privileged'      => '[[Korisnik:$1|$1]] ima [[Posebno:Listadmins|administratorske ili birokratske privilegije]], i ne može mu se dodeliti status bota.',
	'makebot-change'          => 'Promeni status:',
	'makebot-grant'           => 'Daj',
	'makebot-revoke'          => 'Oduzmi',
	'makebot-comment'         => 'Komentar:',
	'makebot-granted'         => '[[Korisnik:$1|$1]] sada ima status bota.',
	'makebot-revoked'         => '[[Korisnik:$1|$1]] više nema status bota.',
	'makebot-logpage'         => 'istorija statusa bota',
	'makebot-logpagetext'     => 'Ovo je istorija izmena statusa [[{{MediaWiki:Grouppage-bot}}|bota]] korisnika.',
	'makebot-logentrygrant'   => 'dao status bota: [[$1]]',
	'makebot-logentryrevoke'  => 'uklonio status bota: [[$1]]',
);

$messages['ss'] = array(
	'makebot-search'          => 'Kúhámba',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'makebot'                => 'Botstoatus reeke of ounieme',
	'makebot-header'         => "'''N Bürokroat fon dit Projekt kon uur Benutsere - in Uureenstimmenenge mäd do lokoale Gjuchtlienjen - [[Help:Bot|Botstoatus]] reeke of ounieme.'''<br /> Mät Botstoatus wäide do Beoarbaidengen fon n Bot-Benuserkonto in do [[Special:Recentchanges|Lääste Annerengen]] un äänelke Liesten ferstat. Ju Botmarkierenge is buutendät nutselk tou ju Fääststaalenge fon automatiske Beoarbaidengen.",
	'makebot-username'       => 'Benutsernoome:',
	'makebot-search'         => 'Stoatus oufräigje',
	'makebot-isbot'          => '„[[User:$1|$1]]“ häd Botstoatus.',
	'makebot-notbot'         => '„[[User:$1|$1]]“ häd naan Botstoatus.',
	'makebot-privileged'     => '„[[User:$1|$1]]“ häd [[Special:Listusers/sysop|Administrator- of Bürokratengjuchte]], Botstoatus kon nit roat wäide.',
	'makebot-change'         => 'Stoatus annerje:',
	'makebot-grant'          => 'Reeke',
	'makebot-revoke'         => 'Touräächnieme',
	'makebot-comment'        => 'Kommentoar:',
	'makebot-granted'        => '„[[User:$1|$1]]“ häd nu Botstoatus.',
	'makebot-revoked'        => '„[[User:$1|$1]]“ häd naan Botstoatus moor.',
	'makebot-logpage'        => 'Botstoatus-Logbouk',
	'makebot-logpagetext'    => 'Dit Logbouk protokolliert aal [[Help:Bot|Botstoatus]]-Annerengen.',
	'makebot-logentrygrant'  => 'roate Botstoatus foar „[[$1]]“',
	'makebot-logentryrevoke' => 'hoalde dän Botstoatus fon „[[$1]]“ wäch',
);

/* Sundanese (Kandar via BetaWiki) */
$messages['su'] = array(
	'makebot'                 => 'Leler atawa cabut status bot',
	'makebot-header'          => '\'\'\'Birokrat lokal bisa migunakeun ieu kaca pikeun ngaleler atawa nyabut [[{{MediaWiki:Grouppage-bot}}|status bot]] ka rekening pamaké séjén.\'\'\'<br />Status bot nyumputkeun éditan hiji pamaké dina [[Special:Recentchanges|daptar parobahan anyar]] jeung nu sarupa jeung éta. Hal ieu penting pikeun nandaan pamaké nu ngajalankeun éditan otomatis, luyu jeung kawijakan anu aya.',
	'makebot-username'        => 'Ngaran landihan:',
	'makebot-search'          => 'Jung',
	'makebot-isbot'           => '[[User:$1|$1]] boga status bot.',
	'makebot-notbot'          => '[[User:$1|$1]] teu boga status bot.',
	'makebot-privileged'      => '[[User:$1|$1]] boga [[Special:Listadmins|kawenangan administrator atawa birokrat]], sahingga teu bisa dibéré status bot.',
	'makebot-change'          => 'Robah status:',
	'makebot-grant'           => 'Leler',
	'makebot-revoke'          => 'Cabut',
	'makebot-comment'         => 'Pamanggih:',
	'makebot-granted'         => '[[User:$1|$1]] ayeuna boga status bot.',
	'makebot-revoked'         => '[[User:$1|$1]] geus teu boga status bot deui.',
	'makebot-logpage'         => 'Log status bot',
	'makebot-logpagetext'     => 'Ieu mangrupa log parobahan status [[{{MediaWiki:Grouppage-bot}}|bot]] pamaké.',
	'makebot-logentrygrant'   => 'méré status bot ka [[$1]]',
	'makebot-logentryrevoke'  => 'nyabut status bot [[$1]]',
);

/* Swedish (Lejonel) */
$messages['sv'] = array(
	'makebot'                 => 'Dela ut eller återkalla robotstatus',
	'makebot-header'          => '\'\'\'Lokala byråkrater kan använda den här sidan för att ge eller ta ifrån användarkonton [[{{MediaWiki:Grouppage-bot}}|robotstatus]].\'\'\'<br />Robotstatus innebär att användarens redigeringar göms från de [[Special:Recentchanges|senaste ändringarna]] och liknande listor. Det är användbart för att användare som gör automatiserade redigeringar. Robotstatus ska användas enligt tillämpliga policies.',
	'makebot-username'        => 'Användarnamn:',
	'makebot-search'          => 'OK',
	'makebot-isbot'           => '[[User:$1|$1]] har robotstatus.',
	'makebot-notbot'          => '[[User:$1|$1]] har inte robotstatus.',
	'makebot-privileged'      => '[[User:$1|$1]] är redan [[Special:Listadmins|administratör eller byråkrat]], och kan därför inte ges robotstatus.',
	'makebot-change'          => 'Ändra status:',
	'makebot-grant'           => 'Tilldela',
	'makebot-revoke'          => 'Återkalla',
	'makebot-comment'         => 'Kommentar:',
	'makebot-granted'         => '[[User:$1|$1]] har nu robotstatus.',
	'makebot-revoked'         => '[[User:$1|$1]] har inte längre robotstatus.',
	'makebot-logpage'         => 'Robotstatuslogg',
	'makebot-logpagetext'     => 'Det här är en logg över ändringar av användares [[{{MediaWiki:Grouppage-bot|robotstatus]].',
	'makebot-logentrygrant'   => 'Gav robotstatus till [[$1]]',
	'makebot-logentryrevoke'  => 'Återkallade robotstatus från [[$1]]',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'makebot'                => 'Fó ka hasai kuana "bot"',
	'makebot-header'         => "'''Burokrata bele uza pájina ne'e ba fó ka hasai [[{{MediaWiki:Grouppage-bot}}|kuana bot]] ba uza-na'in seluk.'''<br />Kuana bot hamsumik edita uza-na'in nian iha [[Special:Recentchanges|mudansa foufoun sira]] no lista hanesan; di'ak ba uza-na'in, ne'ebé edita automátiku. Tenke halo ne'e de'it karik ukun fó lisensa ba halo ne'e.",
	'makebot-username'       => "Naran uza-na'in",
	'makebot-search'         => 'Halo',
	'makebot-isbot'          => '[[User:$1|$1]] iha kuana bot.',
	'makebot-notbot'         => '[[User:$1|$1]] la iha kuana bot.',
	'makebot-privileged'     => '[[User:$1|$1]] iha [[Special:Listadmins|kuana administradór ka burokrata]]; ó la bele fó kuana bot.',
	'makebot-change'         => 'Filak kuana bot:',
	'makebot-grant'          => 'Fó',
	'makebot-revoke'         => 'Hasai',
	'makebot-comment'        => 'Komentáriu:',
	'makebot-granted'        => '[[User:$1|$1]] agora iha kuana bot.',
	'makebot-revoked'        => '[[User:$1|$1]] agora la iha kuana bot.',
	'makebot-logpage'        => 'Lista fó ka hasai kuana bot',
	'makebot-logentrygrant'  => 'fó kuana bot ba [[User:$1|$1]]',
	'makebot-logentryrevoke' => 'hasai kuana bot [[User:$1|$1]] nian',
);

$messages['tg-cyrl'] = array(
	'makebot-username'        => 'Корбар:',
);

/** Tonga (faka-Tonga)
 * @author SPQRobin
 */
$messages['to'] = array(
	'makebot-username' => 'Hingoa ʻo e ʻetita:',
	'makebot-search'   => 'Fai ā',
);

$messages['tr'] = array(
	'makebot'                 => 'Bot statüsü ver veya al',
	'makebot-header'          => '\'\'\'Sitedeki bir bürokrat bu sayfadan bir kullanıcıya [[{{MediaWiki:Grouppage-bot}}|bot statüsü]] verebilir ya da statüyü geri alabilir.\'\'\'<br />Bot statüsü alan kullanıcının değişiklikleri [[Special:Recentchanges|son değişiklikler]] ve benzeri listelerde gizlenir. Otomatik değişiklik yapan normal kullanıcılara da statü vermek yararlı olabilir. Bot statüsü verme, kurallara uygun yapılmalıdır.',
	'makebot-isbot'           => '[[User:$1|$1]] kullanıcısının bot statüsü var.',
	'makebot-change'          => 'Statü değiştir:',
	'makebot-grant'           => 'Statü ver',
	'makebot-comment'         => 'Açıklama:',
	'makebot-granted'         => '[[User:$1|$1]] kullanıcısının artık bot statüsü var.',
	'makebot-logpagetext'     => 'Burada kullanıcı [[{{MediaWiki:Grouppage-bot}}|bot]] durumuna yönelik izin verme ya da geri alma kayıtları listelenmektedir.',
);

/* Urdu */
$messages['ur'] = array(
	'makebot' => 'بخشیں یا منسوخ کریں درجہ خودکارصارف',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'makebot-username' => 'Gebananem:',
	'makebot-grant'    => 'Gevön',
	'makebot-comment'  => 'Küpet:',
);

/* Walloon (language file) */
$messages['wa'] = array(
	'makebot'                 => 'Diner ou rsaetchî l\' livea d\' robot',
	'makebot-header'          => '\'\'\'On mwaisse-manaedjeu sol wiki pout eployî cisse pådje ci po dner ou rsaetchî l\' [[{{MediaWiki:Grouppage-bot}}|livea d\' robot]] a èn ôte conte d\' uzeu.\'\'\'<br />El livea d\' robot fwait ki les candjmints da cist uzeu la si polèt catchî dins l\' pådje des [[Special:Recentchanges|dierins candjmints]] et des sfwaitès djivêyes, çou k\' est ahessåve po mårker les uzeus ki fjhèt des candjmints otomatikes. Çoula doet esse fwait tot shuvant les rîles ki s\' aplikèt.',
	'makebot-username'        => 'No d\' uzeu:',
	'makebot-search'          => 'I va',
	'makebot-isbot'           => '[[User:$1|$1]] a l\' livea d\' robot.',
	'makebot-notbot'          => '[[User:$1|$1]] n\' a nén l\' livea d\' robot',
	'makebot-privileged'      => '[[User:$1|$1]] a ddja on livea d\' [[Special:Listadmins|manaedjeu ou mwaisse-manaedjeu]], ça fwait k\' i n\' pout nén eployî ç\' conte la po on robot.',
	'makebot-change'          => 'Candjî l\' livea:',
	'makebot-grant'           => 'Diner',
	'makebot-revoke'          => 'Rissaetchî',
	'makebot-comment'         => 'Comintaire:',
	'makebot-granted'         => '[[User:$1|$1]] a-st asteure li livea d\' robot.',
	'makebot-revoked'         => '[[User:$1|$1]] n\' a pus d\' livea d\' robot.',
	'makebot-logpage'         => 'Djournå des liveas d\' robot',
	'makebot-logpagetext'     => 'Çouchal, c\' est on djournå des dinaedjes eyet rsaetchaedjes do [[{{MediaWiki:Grouppage-bot}}|livea d\' robot]] a des uzeus.',
	'makebot-logentrygrant'   => 'a dné l\' livea d\' robot a [[$1]]',
	'makebot-logentryrevoke'  => 'a rsaetchî l\' livea d\' robot da [[$1]]',
);

/* Wu */
$messages['wuu'] = array(
	'makebot-username'        => '用户名：',
	'makebot-logpage'         => '机器人状态日志',
);

/* Cantonese (Hillgentleman, Shinjiman) */
$messages['yue'] = array(
	'makebot'                 => '畀或收番機械人身份',
	'makebot-desc'            => '特別頁容許本地事務員去畀同收番機械人權限',
	'makebot-header'          => '\'\'\'本地事務員可以用哩頁畀或收番另一用户嘅 [[{{MediaWiki:Grouppage-bot}}|機械人身份]]。\'\'\'<br />機械人可以喺[[Special:Recentchanges|最近更改]]之類嘅表道匿埋。機械人身份可用來嘜住啲自動化嘅編者。記住要參攷相關嘅政策。',
	'makebot-username'        => '用户名：',
	'makebot-search'          => '去',
	'makebot-isbot'           => '[[User:$1|$1]] 係隻機械人。',
	'makebot-notbot'          => '[[User:$1|$1]]唔係一隻機械人。',
	'makebot-privileged'      => '[[User:$1|$1]] 係 [[Special:Listadmins|管理員]]，唔准扮機械人。',
	'makebot-change'          => '改身份：',
	'makebot-grant'           => '畀',
	'makebot-revoke'          => '收番',
	'makebot-comment'         => '評論：',
	'makebot-granted'         => '[[User:$1|$1]] 而家係隻機械人。',
	'makebot-revoked'         => '[[User:$1|$1]] 而家唔一係隻機械人。',
	'makebot-logpage'         => '機械人身份記錄',
	'makebot-logpagetext'     => '哩頁紀錄各用户啲 [[{{MediaWiki:Grouppage-bot}}|機械人]]身份記錄。',
	'makebot-logentrygrant'   => '畀咗[[$1]]嘅機械人身份',
	'makebot-logentryrevoke'  => ' 收番[[$1]]嘅機械人身份',
	'right-makebot'           => '畀同收機械人旗',
);

/* Chinese (Simplified) (下一次登录) */
$messages['zh-hans'] = array(
	'makebot'                 => '授予或中止机器人身份',
	'makebot-desc'            => '特殊页面容许本地行政员去授予及终止机器人权限',
	'makebot-header'          => '\'\'\'本地行政员可以使用此页授予或中止另一个帐号的[[{{MediaWiki:Grouppage-bot}}|机器人身份]]。\'\'\'<br />机器人状态会导致该用户的编辑不被显示在[[Special:Recentchanges|最近更改]]和其他类似列表中，因此用于标识进行自动编辑的用户，但需要依据相应的可行方针。',
	'makebot-username'        => '用户名：',
	'makebot-search'          => '搜索',
	'makebot-isbot'           => '[[User:$1|$1]]拥有机器人身份。',
	'makebot-notbot'          => '[[User:$1|$1]]没有机器人身份。',
	'makebot-privileged'      => '[[User:$1|$1]]是[[Special:Listadmins|管理员]]，不能接受机器人身份。',
	'makebot-change'          => '改变身份：',
	'makebot-grant'           => '授予',
	'makebot-revoke'          => '中止',
	'makebot-comment'         => '备注：',
	'makebot-granted'         => '[[User:$1|$1]]拥有了机器人身份。',
	'makebot-revoked'         => '[[User:$1|$1]]已不再拥有机器人身份。',
	'makebot-logpage'         => '机器人状态日志',
	'makebot-logpagetext'     => '这是用户[[{{MediaWiki:Grouppage-bot}}|机器人]]更改的日志。',
	'makebot-logentrygrant'   => '授予[[$1]]机器人身份',
	'makebot-logentryrevoke'  => ' 中止[[$1]]的机器人身份',
	'right-makebot'           => '授予和终止机器人身份',
);

/* Chinese (Traditional) (KilluaZaoldyeck, Shinjiman) */
$messages['zh-hant'] = array(
	'makebot'                 => '授予或終止機器人身分',
	'makebot-desc'            => '特殊頁面容許本地行政員去授予及終止機器人權限',
	'makebot-header'          => '\'\'\'所屬行政員允許使用此頁面授予或終止另一個帳號的[[{{MediaWiki:Grouppage-bot}}|機器人身分]]。\'\'\'<br />機器人身分的帳號所進行的修改將不被顯示在[[Special:Recentchanges|最近更改]]和其他類關列表中，因此，此身分用於標記自動編輯的帳號。此項的相關操作必須符合現行方針。',
	'makebot-username'        => '帳號名稱：',
	'makebot-search'          => '搜索',
	'makebot-isbot'           => '[[User:$1|$1]]擁有機器人身分。',
	'makebot-notbot'          => '[[User:$1|$1]]沒有機器人身分。',
	'makebot-privileged'      => '[[User:$1|$1]]是[[Special:Listadmins|管理員]]，不能使用機器人身分。',
	'makebot-change'          => '改變身分：',
	'makebot-grant'           => '授予',
	'makebot-revoke'          => '終止',
	'makebot-comment'         => '備註：',
	'makebot-granted'         => '[[User:$1|$1]]擁有機器人身分。',
	'makebot-revoked'         => '[[User:$1|$1]]失去機器人身分。',
	'makebot-logpage'         => '機器人身分記錄',
	'makebot-logpagetext'     => '這是用戶[[{{MediaWiki:Grouppage-bot}}|機器人]]更改的記錄。',
	'makebot-logentrygrant'   => '授予[[$1]]機器人身分',
	'makebot-logentryrevoke'  => ' 終止[[$1]]機器人身分',
	'right-makebot'           => '授予和終止機器人身分',
);

/* Chinese (Hong Kong) (KilluaZaoldyeck, Shinjiman) */
$messages['zh-hk'] = array(
	'makebot'                 => '授予或終止機械人身份',
	'makebot-desc'            => '特殊頁面容許本地行政員去授予及終止番機械人權限',
	'makebot-header'          => '\'\'\'所屬行政員允許使用此頁面授予或終止另一個帳號的[[{{MediaWiki:Grouppage-bot}}|機械人身份]]。\'\'\'<br />機械人身份的帳號所進行的修改將不被顯示在[[Special:Recentchanges|最近更改]]和其他類關列表中，因此，此身份用於標記自動編輯的帳號。此項的相關操作必須符合現行方針。',
	'makebot-isbot'           => '[[User:$1|$1]]擁有機械人身份。',
	'makebot-notbot'          => '[[User:$1|$1]]沒有機械人身份。',
	'makebot-privileged'      => '[[User:$1|$1]]是[[Special:Listadmins|管理員]]，不能使用機械人身份。',
	'makebot-granted'         => '[[User:$1|$1]]擁有機械人身份。',
	'makebot-revoked'         => '[[User:$1|$1]]失去機械人身份。',
	'makebot-logpage'         => '機械人身份記錄',
	'makebot-logpagetext'     => '這是用戶[[{{MediaWiki:Grouppage-bot}}|機械人]]更改的記錄。',
	'makebot-logentrygrant'   => '授予[[$1]]機械人身份',
	'makebot-logentryrevoke'  => ' 終止[[$1]]機械人身份',
	'right-makebot'           => '授予和終止機械人身份',
);
