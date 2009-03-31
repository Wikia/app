<?php
/*
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
 * @author Darth Kule
 * @author Purodha
 */
$messages['qqq'] = array(
	'closewikis-desc' => 'Short description of this extension, shown on [[Special:Version]]. Do not translate or change links.',
	'right-editclosedwikis' => '{{doc-right}}',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'closewikis-desc' => 'يسمح بغلق مواقع الويكي في مزارع الويكي',
	'closewikis-page' => 'إغلاق الويكي',
	'closewikis-page-close' => 'إغلاق الويكي',
	'closewikis-page-close-wiki' => 'الويكي:',
	'closewikis-page-close-dreason' => 'السبب (المعروض):',
	'closewikis-page-close-reason' => 'السبب (المسجل):',
	'closewikis-page-close-submit' => 'إغلاق',
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
	'closewikis-list-intro' => 'هذه القائمة تحتوى على الويكيات التي تم إغلاقها بواسطة المضيفين.',
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

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'closewikis-desc' => 'Позволява да се затварят уикита в уики ферми',
	'closewikis-page' => 'Затваряне на уикито',
	'closewikis-page-close' => 'Затваряне на уикито',
	'closewikis-page-close-wiki' => 'Уики:',
	'closewikis-page-close-dreason' => 'Причина (публична):',
	'closewikis-page-close-submit' => 'Затваряне',
	'closewikis-page-close-success' => 'Уикито беше затворено успешно',
	'closewikis-page-reopen-wiki' => 'Уики:',
	'closewikis-page-reopen-reason' => 'Причина:',
	'closewikis-page-err-nowiki' => 'Посоченото уики е невалидно',
	'closewikis-page-err-closed' => 'Уикито вече беше затворено',
	'closewikis-page-err-opened' => 'Уикито не беше затворено',
	'closewikis-list' => 'Списък на затворените уикита',
	'closewikis-list-intro' => 'Този списък съдържа уикита, които са били затворени от стюардите.',
	'closewikis-list-header-wiki' => 'Уики',
	'closewikis-list-header-by' => 'Затворено от',
	'closewikis-list-header-timestamp' => 'Затворено на',
	'closewikis-log' => 'Дневник на затварянията на уикита',
	'right-editclosedwikis' => 'Редактиране на затворени уикита',
	'right-closewikis' => 'Затваряне на уикита',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'closewikis-desc' => 'Omogućava zatvaranje wiki projekata u wiki farmama',
	'closewikis-page-reopen-reason' => 'Razlog:',
	'closewikis-list-header-dispreason' => 'Navedeni razlog',
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

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
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
	'closewikis-list-header-wiki' => 'Vikio',
	'closewikis-list-header-by' => 'Fermis de',
	'closewikis-list-header-timestamp' => 'Fermis je',
	'closewikis-log' => 'Protokolo pri vikia fermado',
	'closewikis-log-header' => 'Jen protokolo de ĉiuj viki-fermadoj kaj remalfermadoj de stevardoj',
	'closewikis-log-close' => 'fermis $2',
	'closewikis-log-reopen' => 'remalfermis $2',
	'right-editclosedwikis' => 'Redakti fermitajn vikiojn',
	'right-closewikis' => 'Fermi vikiojn',
);

/** Estonian (Eesti)
 * @author Avjoska
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
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'closewikis-page-close-submit' => 'Itxi',
	'closewikis-page-reopen-reason' => 'Arrazoia:',
	'closewikis-page-reopen-submit' => 'Berrireki',
	'closewikis-log-close' => '$2 itxita',
	'closewikis-log-reopen' => '$2 berrirekia',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Silvonen
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
	'closewikis-list-header-dispreason' => 'Näytetty syy',
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
	'closewikis-page-reopen' => 'Volver abrir o wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Motivo:',
	'closewikis-page-reopen-submit' => 'Volver abrir',
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
	'closewikis-page-close-submit' => 'Κλῄειν',
	'closewikis-page-reopen-reason' => 'Αἰτία:',
	'closewikis-page-reopen-submit' => 'Ἀνοίγειν πάλιν',
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
	'closewikis-page-close-dreason' => 'Motivo (monstrate):',
	'closewikis-page-close-reason' => 'Motivo (registrate):',
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
	'closewikis-log' => 'Registro de clausura de wikis',
	'closewikis-log-header' => 'Ecce un registro de tote le clausuras e reaperturas de wikis facite per stewards',
	'closewikis-log-close' => 'claudeva $2',
	'closewikis-log-reopen' => 'reaperiva $2',
	'right-editclosedwikis' => 'Modificar wikis claudite',
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
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'closewikis-page' => '閉鎖されたウィキ',
	'closewikis-page-close' => '閉鎖されたウィキ',
	'closewikis-page-close-wiki' => 'ウィキ:',
	'closewikis-page-close-submit' => '閉鎖',
	'closewikis-page-close-success' => '正常に閉鎖されたウィキ',
	'closewikis-page-reopen-wiki' => 'ウィキ:',
	'closewikis-page-reopen-reason' => '理由:',
	'closewikis-list-header-wiki' => 'ウィキ',
	'right-closewikis' => 'ウィキを閉鎖する',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
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
	'closewikis-page-err-closed' => 'វិគី​ត្រូវ​បាន​បិទ​រួចរាល់ហើយ',
	'closewikis-page-err-opened' => 'វិគី​មិនត្រូវ​បាន​បិទ​ទេ',
	'closewikis-list' => 'បាន​បិទ​បញ្ជី​វិគី',
	'closewikis-list-header-wiki' => 'វិគី',
	'closewikis-list-header-by' => 'បានបិទដោយ',
	'closewikis-list-header-timestamp' => 'បានបិទនៅ',
	'closewikis-log-close' => 'បានបិទ$2',
	'closewikis-log-reopen' => 'បាន​បើកឡើងវិញ $2',
	'right-closewikis' => 'បិទវិគី',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'closewikis-page-reopen-reason' => '이유:',
	'closewikis-list' => '닫힌 위키의 목록',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'closewikis-desc' => 'Määt et müjjelesch, enkel Wikis en ene Wiki-Farm zohzemaache.',
	'closewikis-page' => 'Wiki zomaache',
	'closewikis-page-close' => 'Wiki zomaache',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Der Jrond (för Aanzezeije):',
	'closewikis-page-close-reason' => 'Der Jrond (för en et Logbooch ze schrieve):',
	'closewikis-page-close-submit' => 'Zomache!',
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

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'closewikis-page-close-wiki' => 'Вики:',
	'closewikis-page-close-submit' => 'Пекстамс',
	'closewikis-page-reopen-wiki' => 'Вики:',
	'closewikis-page-reopen-reason' => 'Тувталось:',
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
	'right-closewikis' => "Gesloten wiki's",
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

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'closewikis-desc' => 'Tillater stenging av wikier i wikisamlinger',
	'closewikis-page' => 'Steng wiki',
	'closewikis-page-close' => 'Steng wiki',
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Årsak (vises):',
	'closewikis-page-close-reason' => 'Årsak (logges):',
	'closewikis-page-close-submit' => 'Steng',
	'closewikis-page-close-success' => 'Wiki stengt',
	'closewikis-page-reopen' => 'Åpne wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Årsak:',
	'closewikis-page-reopen-submit' => 'Åpne',
	'closewikis-page-reopen-success' => 'Wiki åpnet',
	'closewikis-page-err-nowiki' => 'Ugyldig wiki oppgitt',
	'closewikis-page-err-closed' => 'Wikien er allerede stengt',
	'closewikis-page-err-opened' => 'Wikien er ikke stengt',
	'closewikis-log' => 'Logg for stenging av wikier',
	'closewikis-log-header' => 'Her er en logg over alle wikistenginger og -åpninger gjort av forvaltere',
	'closewikis-log-close' => 'stengte $2',
	'closewikis-log-reopen' => 'åpnet $2',
	'right-editclosedwikis' => 'Redigere stengte wikier',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'closewikis-desc' => 'Permet de clausurar los sits wiki dins aqueste gestionari de wiki',
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
	'closewikis-page-close-submit' => 'Zamknij',
	'closewikis-page-err-closed' => 'Wiki została zamknięta',
	'closewikis-page-err-opened' => 'Wiki nie została zamknięta',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Zamknięta przez',
	'closewikis-list-header-timestamp' => 'Zamknięta',
	'closewikis-log-close' => 'zamknięta $2',
	'closewikis-log-reopen' => 'powtórnie otwarta $2',
	'right-editclosedwikis' => 'Edytuj zamknięte projekty wiki',
	'right-closewikis' => 'Zamknij projekty wiki',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Sir Lestaty de Lioncourt
 */
$messages['pt'] = array(
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
	'closewikis-page-reopen-reason' => 'Razão:',
	'closewikis-page-reopen-submit' => 'Reabrir',
	'closewikis-page-reopen-success' => 'Wiki reaberta com sucesso',
	'closewikis-page-err-nowiki' => 'A wiki especificada é inválida',
	'closewikis-page-err-closed' => 'Wiki já está fechada',
	'closewikis-page-err-opened' => 'Esta wiki não está fechada',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-log' => 'Registro de Wikis fechadas',
	'closewikis-log-header' => 'Aqui está um registro de todas as wikis que foram fechadas ou reabertas por stewards',
	'closewikis-log-close' => 'fechada $2',
	'closewikis-log-reopen' => 'reaberta $2',
	'right-editclosedwikis' => 'Editar wikis fechadas',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-close-dreason' => 'Motiv (afişat):',
	'closewikis-page-close-submit' => 'Închide',
	'closewikis-page-close-success' => 'Wiki închis cu succes',
	'closewikis-page-reopen' => 'Redeschide wiki',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-page-reopen-reason' => 'Motiv:',
	'closewikis-page-reopen-submit' => 'Redeschide',
	'closewikis-page-reopen-success' => 'Wiki redeschis cu succes',
	'closewikis-page-err-closed' => 'Acest wiki e deja închis',
	'closewikis-page-err-opened' => 'Acest wiki nu e închis',
	'closewikis-list' => 'Listă de wiki închise',
	'closewikis-list-header-wiki' => 'Wiki',
	'closewikis-list-header-by' => 'Închis de',
	'closewikis-list-header-timestamp' => 'Închis la',
	'closewikis-list-header-dispreason' => 'Motiv afişat',
	'closewikis-log' => 'Jurnal închidere wiki',
	'closewikis-log-close' => 'închis $2',
	'closewikis-log-reopen' => 'redeschis $2',
	'right-editclosedwikis' => 'Modifică wiki închise',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'closewikis-page-reopen-wiki' => 'Uicchi:',
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
	'closewikis-log' => 'Wikisluutengs-Logbouk',
	'closewikis-log-header' => 'Dit Logbouk wiest aal Sluutengen un Wiereepengen fon Wikis truch Stewards oun.',
	'closewikis-log-close' => 'sloot $2',
	'closewikis-log-reopen' => 'eepende $2 wier',
	'right-editclosedwikis' => 'Sleetene Wikis beoarbaidje',
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

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'closewikis-page-close-wiki' => 'వికీ:',
	'closewikis-page-reopen-wiki' => 'వికీ:',
	'closewikis-page-reopen-reason' => 'కారణం:',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'closewikis-page-close-wiki' => 'Wiki:',
	'closewikis-page-reopen-wiki' => 'Wiki:',
	'closewikis-list-header-wiki' => 'Wiki',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
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
	'closewikis-log' => 'Nhật trình đóng cửa wiki',
	'closewikis-log-header' => 'Đây là danh sách các tác vụ đóng cửa wiki và mở cửa lại wiki được thực hiện bởi tiếp viên.',
	'closewikis-log-close' => 'đóng cửa $2',
	'closewikis-log-reopen' => 'mở cửa lại $2',
	'right-editclosedwikis' => 'Sửa đổi các wiki bị đóng cửa',
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

