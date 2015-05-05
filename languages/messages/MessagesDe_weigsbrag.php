<?php
/** Weigsbrag (based on German)
 *
 * @ingroup Language
 * @file
 *
 * @author Volker Waibel
 * Original German authors:
 * @author Jimmy Collins <jimmy.collins@web.de>
 * @author Raimond Spekking (Raymond) <raimond.spekking@gmail.com> since January 2007
 * @author Tim Bartel (avatar) <wikipedistik@computerkultur.org> small changes
 * @author Spacebirdy
 */

$namespaceNames = array(
	NS_MEDIA            => 'Media',
	NS_SPECIAL          => 'Schbesial',
	NS_MAIN             => '',
	NS_TALK             => 'Disgusion',
	NS_USER             => 'Benuds',
	NS_USER_TALK        => 'Benudses_Disgusion',
	# NS_PROJECT set by $wgMetaNamespace
	NS_PROJECT_TALK     => '$1_Disgusion',
	NS_IMAGE            => 'Bild',
	NS_IMAGE_TALK       => 'Bild_Disgusion',
	NS_MEDIAWIKI        => 'MediaWigi',
	NS_MEDIAWIKI_TALK   => 'MediaWigi_Disgusion',
	NS_TEMPLATE         => 'Worlag',
	NS_TEMPLATE_TALK    => 'Worlag_Disgusion',
	NS_HELP             => 'Hilw',
	NS_HELP_TALK        => 'Hilw_Disgusion',
	NS_CATEGORY         => 'Gadegorä',
	NS_CATEGORY_TALK    => 'Gadegorä_Disgusion'
);

$skinNames = array(
	'standard'      => 'Klassik',
	'nostalgia'     => 'Nostalgie',
	'cologneblue'   => 'Kölnisch Blau',
	'monobook'      => 'MonoBook',
	'myskin'        => 'MySkin',
	'chick'         => 'Küken',
	'simple'        => 'Einfach',
	'modern'        => 'Modern'
);

$bookstoreList = array(
	'abebooks.de' => 'http://www.abebooks.de/servlet/BookSearchPL?ph=2&isbn=$1',
	'amazon.de' => 'http://www.amazon.de/exec/obidos/ISBN=$1',
	'buch.de' => 'http://www.buch.de/de.buch.shop/shop/1/home/schnellsuche/buch/?fqbi=$1',
	'Karlsruher Virtueller Katalog (KVK)' => 'http://www.ubka.uni-karlsruhe.de/kvk.html?SB=$1',
	'Lehmanns Fachbuchhandlung' => 'http://www.lob.de/cgi-bin/work/suche?flag=new&stich1=$1'
);

$separatorTransformTable = array(',' => '.', '.' => ',' );
$linkTrail = '/^([äöüßa-z]+)(.*)$/sDu';

/**
 * Alternate names of special pages. All names are case-insensitive. The first
 * listed alias will be used as the default. Aliases from the fallback
 * localisation (usually English) will be included by default.
 *
 * This array may be altered at runtime using the LanguageGetSpecialPageAliases
 * hook.
 */
$specialPageAliases = array(
	'DoubleRedirects'           => array( 'Dobbeldes_Weidleides' ),
	'BrokenRedirects'           => array( 'Gabuddes_Weidleides' ),
	'Disambiguations'           => array( 'Begriwsglärwerweises' ),
	'Userlogin'                 => array( 'Anmeld' ),
	'Userlogout'                => array( 'Abmeld' ),
	'CreateAccount'             => array( 'Benudsesgond_anleg' ),
	'Preferences'               => array( 'Einschdeles' ),
	'Watchlist'                 => array( 'Beobagdlisd' ),
	'Recentchanges'             => array( 'Ledsdes_Ändes' ),
	'Upload'                    => array( 'Hoglad' ),
	'Imagelist'                 => array( 'Dadeies', 'Dadeilisd' ),
	'Newimages'                 => array( 'Neues_Dadeies' ),
	'Listusers'                 => array( 'Benudses' ),
	'Listgrouprights'           => array( 'Grubbesregdes' ),
	'Statistics'                => array( 'Schdadisdig' ),
	'Randompage'                => array( 'Suwäliges_Seid' ),
	'Lonelypages'               => array( 'Werwaisdes_Seides' ),
	'Uncategorizedpages'        => array( 'Noggs_gadegorisärdes_Seides' ),
	'Uncategorizedcategories'   => array( 'Noggs_gadegorisärdes_Gadegoräes' ),
	'Uncategorizedimages'       => array( 'Noggs_gadegorisärdes_Dadeies' ),
	'Uncategorizedtemplates'    => array( 'Noggs_gadegorisärdes_Worlages' ),
	'Unusedcategories'          => array( 'Noggsbenudsdes_Gadegoräes' ),
	'Unusedimages'              => array( 'Noggsbenudsdes_Dadeies' ),
	'Wantedpages'               => array( 'Gewünschdes_Seides' ),
	'Wantedcategories'          => array( 'Gewünschdes_Gadegoräes' ),
	'Missingfiles'              => array( 'Dadeies_wo_wehldar' ),
	'Mostlinked'                => array( 'Meisdwergnübwdes_Seides' ),
	'Mostlinkedcategories'      => array( 'Meisdbenudsdes_Gadegoräes' ),
	'Mostlinkedtemplates'       => array( 'Meisdbenudsdes_Worlages' ),
	'Mostcategories'            => array( 'Meisdgadegorisärdes_Seides' ),
	'Mostimages'                => array( 'Meisdbenudsdes_Dadeies' ),
	'Mostrevisions'             => array( 'Meisdbearbeidedes_Seides' ),
	'Fewestrevisions'           => array( 'Wenigsdbearbeidedes_Seides' ),
	'Shortpages'                => array( 'Gürsesdes_Seides' ),
	'Longpages'                 => array( 'Längsdes_Seides' ),
	'Newpages'                  => array( 'Neues_Seides' ),
	'Ancientpages'              => array( 'Äldesdes_Seides' ),
	'Deadendpages'              => array( 'Sagggasesseides' ),
	'Protectedpages'            => array( 'Geschüdsdes_Seides' ),
	'Protectedtitles'           => array( 'Geschberdes_Dides' ),
	'Allpages'                  => array( 'Ales_Seides' ),
	'Prefixindex'               => array( 'Bräwigsindegs' ) ,
	'Ipblocklist'               => array( 'Geschberdes_IBs' ),
	'Specialpages'              => array( 'Schbesialseides' ),
	'Contributions'             => array( 'Beidräges' ),
	'Emailuser'                 => array( 'I-Mehl' ),
	'Confirmemail'              => array( 'I-Mehl_beschdäd', 'I-Mehl_beschdäd' ),
	'Whatlinkshere'             => array( 'Wergnübwlisd', 'Werweislisd' ),
	'Recentchangeslinked'       => array( 'Ändes_an_wergnübwdes_Seides' ),
	'Movepage'                  => array( 'Werschieb' ),
	'Blockme'                   => array( 'Brogsy-Schber' ),
	'Booksources'               => array( 'ISBN-Sug' ),
	'Categories'                => array( 'Gadegoräes' ),
	'Export'                    => array( 'Egsbordär' ),
	'Version'                   => array( 'Wersion' ),
	'Allmessages'               => array( 'MediaWigi-Sysdemnagrigdes' ),
	'Log'                       => array( 'Logbug' ),
	'Blockip'                   => array( 'Schber' ),
	'Undelete'                  => array( 'Wiedherschdel' ),
	'Import'                    => array( 'Imbordär' ),
	'Lockdb'                    => array( 'Dadesbang_schber' ),
	'Unlockdb'                  => array( 'Dadesbang_endschber' ),
	'Userrights'                => array( 'Benudsesregdes' ),
	'MIMEsearch'                => array( 'MIME-Dyb-Sug' ),
	'FileDuplicateSearch'       => array( 'Dadei-Dubligad-Sug' ),
	'Unwatchedpages'            => array( 'Ignorärdes_Seides', 'Noggsbeobagdedes_Seides' ),
	'Listredirects'             => array( 'Weidleides' ),
	'Revisiondelete'            => array( 'Wersionslösch' ),
	'Unusedtemplates'           => array( 'Noggsbenudsdes_Worlages' ),
	'Randomredirect'            => array( 'Suwäliges_Weidleid' ),
	'Mypage'                    => array( 'Meines_Benudsesseid' ),
	'Mytalk'                    => array( 'Meines_Disgusionsseid' ),
	'Mycontributions'           => array( 'Meines_Beidräges' ),
	'Listadmins'                => array( 'Adminisdradores' ),
	'Listbots'                  => array( 'Bods' ),
	'Popularpages'              => array( 'Beliebdesdes_Seides' ),
	'Search'                    => array( 'Sug' ),
	'Resetpass'                 => array( 'Basword_surügseds' ),
	'Withoutinterwiki'          => array( 'Inderwigis_wo_wehldar' ),
	'MergeHistory'              => array( 'Wersionsgeschigdes_wereinig' ),
	'Filepath'                  => array( 'Dadeibwad' ),
	'Invalidateemail'           => array( 'I-Mehl_noggs_beschdäd' ),
);

$datePreferences = array(
	'default',
	'dmyt',
	'dmyts',
	'dmy',
	'ymd',
	'ISO 8601'
);

$defaultDateFormat = 'dmy';

$dateFormats = array(
	'dmyt time' => 'H:i',
	'dmyt date' => 'j. F Y',
	'dmyt both' => 'j. M Y, H:i',

	'dmyts time' => 'H:i:s',
	'dmyts date' => 'j. F Y',
	'dmyts both' => 'j. M Y, H:i:s',

	'dmy time' => 'H:i',
	'dmy date' => 'j. F Y',
	'dmy both' => 'H:i, j. M Y',

	'ymd time' => 'H:i',
	'ymd date' => 'Y M j',
	'ymd both' => 'H:i, Y M j',

	'ISO 8601 time' => 'xnH:xni:xns',
	'ISO 8601 date' => 'xnY-xnm-xnd',
	'ISO 8601 both' => 'xnY-xnm-xnd"T"xnH:xni:xns'
);

$messages = array(
# User preference toggles
'tog-underline'               => 'Werweises undschdreig:',
'tog-highlightbroken'         => 'Werweises auw leeres Seides herworheb <a href="" class="new">Beischb</a> (Aldernadiw: wie dose<a href="" class="internal">?</a>).',
'tog-justify'                 => 'Degsd als Bloggsads',
'tog-hideminor'               => 'Gleines Ändes ausblend',
'tog-extendwatchlist'         => 'Erweiderdes Beobagdlisd',
'tog-usenewrc'                => 'Erweiderdes Darschdel (Sgribd benödigdes)',
'tog-numberheadings'          => 'Übschriwdes audomadisches numerär',
'tog-showtoolbar'             => 'Bearbeid-Wergseugleisd anseig',
'tog-editondblclick'          => 'Seides mid Dobbgligg bearbeid (JawaSgribd)',
'tog-editsection'             => 'Werweises su Bearbeid won einselnes Absädses anseig',
'tog-editsectiononrightclick' => 'Einselnes Absädses mid Regdsgligg bearbeid (JawaSgribd)',
'tog-showtoc'                 => 'Inhaldswerseig anseig bei Seides mid mehres wie drei Übschriwdes',
'tog-rememberpassword'        => 'Benuds auw dose Gombjud dauhawdes anmeld las',
'tog-editwidth'               => 'Degsd-Eingabweld mid woles Breid',
'tog-watchcreations'          => 'Selb erschdeldes Seides audomadisches beobagd',
'tog-watchdefault'            => 'Selb geänderdes und neu erschdeldes Seides audomadisches beobagd',
'tog-watchmoves'              => 'Selb werschobenes Seides audomadisches beobagd',
'tog-watchdeletion'           => 'Selb gelöschdes Seides audomadisches beobagd',
'tog-minordefault'            => 'Eigenes Ändes schdandardmäs als geringwügiges margär',
'tog-previewontop'            => 'Worschau obhalb won dose Bearbeidwensd anseig',
'tog-previewonfirst'          => 'Bei ersdes Bearbeid imm dose Worschau anseig',
'tog-nocache'                 => 'Seidesgedsch deagdiwär',
'tog-enotifwatchlistpages'    => 'Bei Ändes an Seides wo beobagd I-Mehls schig',
'tog-enotifusertalkpages'     => 'Bei Ändes an meines Benuds-Disgusionsseid I-Mehls schig',
'tog-enotifminoredits'        => 'Aug bei gleines Ändes an Seides wo beobagd I-Mehls schig',
'tog-enotifrevealaddr'        => 'Deines I-Mehl-Adres in Benagrigdig-I-Mehls anseig',
'tog-shownumberswatching'     => 'Ansähl won Benudses wo beobagd anseig',
'tog-fancysig'                => 'Signadur ohn Wergnübw su Benudsesseid',
'tog-externaleditor'          => 'Egsdernes Edidor als Schdandard benuds (nur wür Egsberdes, musdar schbesieles Einschdeles auw eigenes Gombjud mag)',
'tog-externaldiff'            => 'Egsdernes Diww-Brogram als Schdandard benuds (nur wür Egsberdes, musdar schbesieles Einschdeles auw eigenes Gombjud mag)',
'tog-showjumplinks'           => '„Wegs-su“-Werweises mög mag',
'tog-uselivepreview'          => 'Laiw-Worschau nuds (JawaSgribd) (egsberimendeles)',
'tog-forceeditsummary'        => 'Warn, wan bei Schbeig dose Susamwas wehldar',
'tog-watchlisthideown'        => 'Eigenes Bearbeides in dose Beobagdlisd ausblend',
'tog-watchlisthidebots'       => 'Bearbeides durg Bods in dose Beobagdlisd ausblend',
'tog-watchlisthideminor'      => 'Gleines Bearbeides in dose Beobagdlisd ausblend',
'tog-nolangconversion'        => 'Gonwerdär won Sbragwariandes deagdiwiär',
'tog-ccmeonemails'            => 'Schig Gobäes won dose I-Mehls, wo haddar anderes Benudses schig',
'tog-diffonly'                => 'Seig bei Wersionswergleig nur dose Undschiedes, noggs dose wolschdändiges Seid',
'tog-showhiddencats'          => 'Seig werschdegdes Gadegoräes',

'underline-always'  => 'imm',
'underline-never'   => 'nie',
'underline-default' => 'abhäng won Brauseinschdel',

'skinpreview' => '(Worschau)',

# Dates
'sunday'        => 'Sond',
'monday'        => 'Mons',
'tuesday'       => 'Diens',
'wednesday'     => 'Midwog',
'thursday'      => 'Don',
'friday'        => 'Wreid',
'saturday'      => 'Sams',
'sun'           => 'So',
'mon'           => 'Mo',
'tue'           => 'Di',
'wed'           => 'Mi',
'thu'           => 'Do',
'fri'           => 'Wr',
'sat'           => 'Sa',
'january'       => 'Jän',
'february'      => 'Web',
'march'         => 'Märs',
'april'         => 'Abril',
'may_long'      => 'Mai',
'june'          => 'Jun',
'july'          => 'Jul',
'august'        => 'Augusd',
'september'     => 'Sebdemb',
'october'       => 'Ogdob',
'november'      => 'Nowemb',
'december'      => 'Desemb',
'january-gen'   => 'Jäns',
'february-gen'  => 'Webs',
'march-gen'     => 'Märses',
'april-gen'     => 'Abrils',
'may-gen'       => 'Mais',
'june-gen'      => 'Juns',
'july-gen'      => 'Juls',
'august-gen'    => 'Augusds',
'september-gen' => 'Sebdembs',
'october-gen'   => 'Ogdobs',
'november-gen'  => 'Nowembs',
'december-gen'  => 'Desembs',
'jan'           => 'Jän',
'feb'           => 'Web.',
'mar'           => 'Märs',
'apr'           => 'Abr.',
'may'           => 'Mai',
'jun'           => 'Jun',
'jul'           => 'Jul',
'aug'           => 'Aug.',
'sep'           => 'Seb.',
'oct'           => 'Ogd.',
'nov'           => 'Now.',
'dec'           => 'Des.',

# Categories related messages
'pagecategories'                 => '{{PLURAL:$1|Gadegorä|Gadegoräes}}',
'category_header'                => 'Seides in dose Gadegorä „$1“',
'subcategories'                  => 'Undgadegoräes',
'category-media-header'          => 'Medies in dose Gadegorä „$1“',
'category-empty'                 => "''Dose Gadegorä haddar momendan noggs Seides od Medies.''",
'hidden-categories'              => '{{PLURAL:$1|Werschdegdes Gadegorä|Werschdegdes Gadegoräes}}',
'hidden-category-category'       => 'Werschdegdes Gadegorä', # Name of the category where hidden categories will be listed
'category-subcat-count'          => '{{PLURAL:$2|Dose Gadegorä haddar wolgendes Undgadegorä:|{{PLURAL:$1|Wolgendes Undgadegorä eines sei won insgesamdes $2 Undgadegoräes in dose Gadegorä:|$1 won insgesamdes $2 Undgadegoräes in dose Gadegorä anseig:}}}}',
'category-subcat-count-limited'  => 'Dose Gadegorä haddar wolgendes {{PLURAL:$1|Undgadegorä|$1 Undgadegoräes}}:',
'category-article-count'         => '{{PLURAL:$2|Dose Gadegorä haddar wolgendes Seides:|{{PLURAL:$1|Wolgendes Seid eines won sei insgesamdes $2 Seides in dose Gadegorä:|$1 won insgesamdes $2 Seides in dose Gadegorä anseig:}}}}',
'category-article-count-limited' => 'Wolgendes {{PLURAL:$1|Seid|$1 Seides}} in dose Gadegorä drin sei:',
'category-file-count'            => '{{PLURAL:$2|Dose Gadegorä haddar wolgendes Dadei:|{{PLURAL:$1|Wolgendes Dadei eines sei won insgesamdes $2 Dadeies in dose Gadegorä:|$1 won insgesamdes $2 Dadeies in dose Gadegorä anseig:}}}}',
'category-file-count-limited'    => 'Wolgendes {{PLURAL:$1|Dadei|$1 Dadeies}} in dose Gadegorä drin sei:',
'listingcontinuesabbrev'         => '(Wordseds)',

'mainpagetext'      => 'Haddar MediaWigi erwolgreiges insdalär.',
'mainpagedocfooter' => 'Hilw su Benuds und Gonwigurär won dose Wigi-Sowdwär gön wend in dose [http://meta.wikimedia.org/wiki/Help:Contents Benudseshandbug].

== Schdardhilwes ==

* [http://www.mediawiki.org/wiki/Manual:Configuration_settings Lisd won Gonwigurärwariables]
* [http://www.mediawiki.org/wiki/Manual:FAQ MediaWigi-FAQ]
* [http://lists.wikimedia.org/mailman/listinfo/mediawiki-announce Mehlinglisd won neues MediaWigi-Wersiones]',

'about'          => 'Üb',
'article'        => 'Seid',
'newwindow'      => '(in neues Wensd)',
'cancel'         => 'Abbrug',
'qbfind'         => 'Wend',
'qbbrowse'       => 'Blädd',
'qbedit'         => 'änd',
'qbpageoptions'  => 'Seidesobsiones',
'qbpageinfo'     => 'Seidesdades',
'qbmyoptions'    => 'Meines Seides',
'qbspecialpages' => 'Schbesialseides',
'moredotdotdot'  => 'Mehr …',
'mypage'         => 'Eigenes Seid',
'mytalk'         => 'Eigenes Disgusion',
'anontalk'       => 'Disgusionsseid won dose IB',
'navigation'     => 'Nawigasion',
'and'            => 'und',

# Metadata in edit box
'metadata_help' => 'Medadades:',

'errorpagetitle'    => 'Wehl',
'returnto'          => 'Surüg su Seid $1.',
'tagline'           => 'Aus dose {{SITENAME}}',
'help'              => 'Hilw',
'search'            => 'Sug',
'searchbutton'      => 'Sug',
'go'                => 'Auswühr',
'searcharticle'     => 'Seid',
'history'           => 'Wersiones',
'history_short'     => 'Wersiones/Audores',
'updatedmarker'     => '(geänderdes)',
'info_short'        => 'Inwormasion',
'printableversion'  => 'Druggwersion',
'permalink'         => 'Bermanendwergnübw',
'print'             => 'Drugg',
'edit'              => 'Bearbeid',
'create'            => 'Erschdel',
'editthispage'      => 'Seid bearbeid',
'create-this-page'  => 'Seid erschdel',
'delete'            => 'Lösch',
'deletethispage'    => 'Dose Seid lösch',
'undelete_short'    => '{{PLURAL:$1|1 Wersion|$1 Wersiones}} wiedherschdel',
'protect'           => 'Schüds',
'protect_change'    => 'Schuds änd',
'protectthispage'   => 'Seid schüds',
'unprotect'         => 'Wreigeb',
'unprotectthispage' => 'Schuds auwheb',
'newpage'           => 'Neues Seid',
'talkpage'          => 'Disgusion',
'talkpagelinktext'  => 'Disgusion',
'specialpage'       => 'Schbesialseid',
'personaltools'     => 'Bersönliges Wergseuges',
'postcomment'       => 'Senw dasugeb',
'articlepage'       => 'Seid',
'talk'              => 'Disgusion',
'views'             => 'Ansigdes',
'toolbox'           => 'Wergseuges',
'userpage'          => 'Benudsesseid',
'projectpage'       => 'Meda-Degsd',
'imagepage'         => 'Dadeiseid',
'mediawikipage'     => 'Inhaldsseid anseig',
'templatepage'      => 'Worlagesseid anseig',
'viewhelppage'      => 'Hilwseid anseig',
'categorypage'      => 'Gadegoräseid anseig',
'viewtalkpage'      => 'Disgusion',
'otherlanguages'    => 'Anderes Sbrages',
'redirectedfrom'    => '(Weidleid won $1)',
'redirectpagesub'   => 'Weidleid',
'lastmodifiedat'    => 'Dose Seid haddar suledsd an $1 um $2 Uhr änd.', # $1 date, $2 time
'viewcount'         => 'Dose Seid haddar bis jedsd {{PLURAL:$1|einesmal|$1-mal}} abruw.',
'protectedpage'     => 'Geschüdsdes Seid',
'jumpto'            => 'Wegs su:',
'jumptonavigation'  => 'Nawigasion',
'jumptosearch'      => 'Sug',

# All link text and link target definitions of links into project namespace that get used by other message strings, with the exception of user group pages (see grouppage) and the disambiguation template definition (see disambiguations).
'aboutsite'            => 'Üb {{SITENAME}}',
'aboutpage'            => 'Project:üb_{{SITENAME}}',
'bugreports'           => 'Gondagd',
'bugreportspage'       => 'Project:Gondagd',
'copyright'            => 'Inhald sei werwügbares undd dose $1.',
'copyrightpagename'    => '{{SITENAME}} Urhebregd',
'copyrightpage'        => '{{ns:project}}:Urhebregd',
'currentevents'        => 'Agdueles Ereiges',
'currentevents-url'    => 'Project:Agdueles Ereiges',
'disclaimers'          => 'Imbresum',
'disclaimerpage'       => 'Project:Imbresum',
'edithelp'             => 'Bearbeidhilw',
'edithelppage'         => 'Help:Bearbeidhilw',
'faq'                  => 'FAQ',
'faqpage'              => 'Project:FAQ',
'helppage'             => 'Help:Hilw',
'mainpage'             => 'Haubdseid',
'mainpage-description' => 'Haubdseid',
'policy-url'           => 'Project:Leidlines',
'portal'               => '{{SITENAME}}-Bordal',
'portal-url'           => 'Project:Bordal',
'privacy'              => 'Dadesschuds',
'privacypage'          => 'Project:Dadesschuds',
'sitesupport'          => 'Schbendes',
'sitesupport-url'      => 'Project:Schbendes',

'badaccess'        => 'Noggs ausreigendes Regdes',
'badaccess-group0' => 'Haddar noggs nödiges Beregd wür dose Agsion.',
'badaccess-group1' => 'Dose Agsion nur Benudses gön mag, wo su dose Grubb „$1“ gehördar.',
'badaccess-group2' => 'Dose Agsion nur Benudses gön mag, wo su eines won dose Grubbes „$1“ gehördar.',
'badaccess-groups' => 'Dose Agsion nur Benudses gön mag, wo su eines won dose Grubbes „$1“ gehördar.',

'versionrequired'     => 'Braugdar Wersion $1 won dose MediaWigi',
'versionrequiredtext' => 'Braugdar Wersion $1 won dose MediaWigi das gön nuds dose Seid. Seddar dose [[{{#special:version}}|Wersionsseid]]',

'ok'                      => 'SOCK',
'retrievedfrom'           => 'Won dose „$1“',
'youhavenewmessages'      => 'Haddar $2 auw deines $1.',
'newmessageslink'         => 'Disgusionsseid',
'newmessagesdifflink'     => 'neues Nagrigdes',
'youhavenewmessagesmulti' => 'Haddar neues Nagrigdes: $1',
'editsection'             => 'Bearbeid',
'editold'                 => 'Bearbeid',
'viewsourceold'           => 'Gueldegsd seig',
'editsectionhint'         => 'Abschnid bearbeid: $1',
'toc'                     => 'Inhaldswerseig',
'showtoc'                 => 'Anseig',
'hidetoc'                 => 'Werberg',
'thisisdeleted'           => '$1 anschauddar od wiedherschdel?',
'viewdeleted'             => '$1 anseig?',
'restorelink'             => '$1 {{PLURAL:$1|gelöschdes Wersion|gelöschdes Wersiones}}',
'feedlinks'               => 'Wiid:',
'feed-invalid'            => 'Ungüldiges Abonomo-Dyb.',
'feed-unavailable'        => 'Wür {{SITENAME}} noggs Wiids geb.',
'site-rss-feed'           => 'RSS-Wiid wür $1',
'site-atom-feed'          => 'Adom-Wiid wür $1',
'page-rss-feed'           => 'RSS-Wiid wür „$1“',
'page-atom-feed'          => 'Adom-Wiid wür „$1“',
'red-link-title'          => '$1 (Seid noggs geb)',

# Short words for each namespace, by default used in the namespace tab in monobook
'nstab-main'      => 'Seid',
'nstab-user'      => 'Benudsesseid',
'nstab-media'     => 'Media',
'nstab-special'   => 'Schbesialseid',
'nstab-project'   => 'Bordalseid',
'nstab-image'     => 'Dadei',
'nstab-mediawiki' => 'MediaWigi-Sysdemdegsd',
'nstab-template'  => 'Worlag',
'nstab-help'      => 'Hilwseid',
'nstab-category'  => 'Gadegorä',

# Main script and global functions
'nosuchaction'      => 'Dose Agsion noggs geb',
'nosuchactiontext'  => 'Dose Agsion wo in URL haddar angeb, dose MediaWigi noggs undschdüds.',
'nosuchspecialpage' => 'Schbesialseid noggs geb',
'nospecialpagetext' => "<big>'''Dose Schbesialseid wo haddar auwruw noggs geb.'''</big>

Ales werwügbares Schbesialseides gön in dose [[{{ns:special}}:Specialpages|Lisd won Schbesialseides]] wend.",

# General errors
'error'                => 'Wehl',
'databaseerror'        => 'Wehl in dose Dadesbang',
'dberrortext'          => 'Haddar eines Syndagswehl in dose Dadesbangabwräg geb.
Dose ledsdes Dadesbangabwräg wesdar: <blockquote><tt>$1</tt></blockquote> aus dose Wungsion „<tt>$2</tt>“.
MySQL haddar dose Wehl „<tt>$3: $4</tt>“ meld.',
'dberrortextcl'        => 'Haddar eines Syndagswehl in dose Dadesbangabwräg geb.
Dose ledsdes Dadesbangabwräg wesdar: „$1“ aus dose Wungsion „<tt>$2</tt>“.
MySQL haddar meld dose Wehl: „<tt>$3: $4</tt>“.',
'noconnect'            => 'Haddar noggs Werbind su Dadesbang auw $1 gön herschdel',
'nodb'                 => 'Haddar Dadesbang $1 noggs gön auswähl',
'cachederror'          => 'Dose Wolgendes eines Gobä aus dose Gedsch und wileigd noggs mehr agdueles sei.',
'laggedslavemode'      => 'Obagd: In dose Seid wo anseig wileigd noggs mehr neuesdes Bearbeides drin sei.',
'readonly'             => 'Dadesbang geschberdes sei',
'enterlockreason'      => 'Bid eines Grund eingeb, wies sol schber dose Dadesbang und eines Abschäds wie langes dose Schber dau',
'readonlytext'         => 'Dose Dadesbang wür Neueindräges und Ändes worübgeddar haddar schber. Bid schbäderes nogmal brobär.

Grund won Schber: $1',
'missing-article'      => 'Dose Degsd wür „$1“ $2 haddar noggs wend in dose Dadesbang.

Dose Seid haddar wileigd lösch od werschieb.

Wan dose noggs sei, haddar ewenduel eines Wehl in dose Sowdwär wend. Bid dose eines [[{{MediaWiki:Grouppage-sysop}}|Adminisdrad]] meld und dose URL nen.',
'missingarticle-rev'   => '(Wersionsnum: $1)',
'missingarticle-diff'  => '(Undschied swisch Wersiones: $1, $2)',
'readonly_lag'         => 'Dose Dadesbang haddar audomadisches wür Schreibsugriwes schber, das dose werdeildes Dadesbangsörwes (slaves) gön mid dose Haubddadesbangsörw (master) abgleig.',
'internalerror'        => 'Indernes Wehl',
'internalerror_info'   => 'Indernes Wehl: $1',
'filecopyerror'        => 'Dose Dadei „$1“ haddar noggs gön nag „$2“ gobär.',
'filerenameerror'      => 'Dose Dadei „$1“ haddar noggs gön in „$2“ umbenen.',
'filedeleteerror'      => 'Dose Dadei „$1“ haddar noggs gön lösch.',
'directorycreateerror' => 'Dose Werseig „$1“ haddar noggs gön anleg.',
'filenotfound'         => 'Dose Dadei „$1“ haddar noggs wend.',
'fileexistserror'      => 'Haddar noggs gön in dose Dadei „$1“ schreib, weil dose Dadei schon geb.',
'unexpected'           => 'Noggserwardedes Werd: „$1“=„$2“.',
'formerror'            => 'Wehl: Dose Eingabes haddar noggs gön werarbeid.',
'badarticleerror'      => 'Dose Agsion auw dose Seid noggs gön anwend.',
'cannotdelete'         => 'Dose gewähldes Seid noggs gön lösch. Wileigd dose haddar schon lösch.',
'badtitle'             => 'Noggsgüldiges Did',
'badtitletext'         => 'Dose Did won Seid wo haddar anword noggsgüldiges sei, leeres od eines noggsgüldiges Sbragwerweis won anderes Wigi.',
'perfdisabled'         => "'''Endschuld!''' Haddar dose Wungsion weg Üblasd won Sörw worübgeddar deagdiwär.",
'perfcached'           => 'Dose wolgendes Dades aus dose Gedsch schdam und wileigd noggs mehr agdueles sei:',
'perfcachedts'         => 'Dose Dades aus dose Gedsch schdam, ledsdes Abded: $1',
'querypage-no-updates' => "'''Dose Agdualisärwungsion wür dose Seid momendanes deagdiwärdes sei. Dose Dades bis auw weideres noggs erneu.'''",
'wrong_wfQuery_params' => 'Walsches Baramed wür wfQuery()<br />
Wungsion: $1<br />
Abwr?g: $2',
'viewsource'           => 'Gueldegsd anschauddar',
'viewsourcefor'        => 'wür $1',
'actionthrottled'      => 'Agsionsansähl limidärdes',
'actionthrottledtext'  => 'Dose Agsion in gurses Dseidabschdand nur begrensdes owd gön auswühr. Haddar dose Grens grad erreig. Bid in baar Minudes nogmal brobär.',
'protectedpagetext'    => 'Dose Seid wür Bearbeid haddar schber.',
'viewsourcetext'       => 'Gueldegsd won dose Seid:',
'protectedinterface'   => 'In dose Seid Degsd wür dose Sbrag-Inderwes won Sowdwär drin sei und geschberdes sei, das gön Misbraug werhind.',
'editinginterface'     => "'''Warn:''' In dose Seid Degsd drin sei wo dose MediaWigi-Sowdwär braugdar. Ändes auw Benudsesobwläg auswirg.",
'sqlhidden'            => '(SQL-Abwräg werschdegdes)',
'cascadeprotected'     => 'Dose Seid haddar wür Bearbeid schber. Dose in dose {{PLURAL:$1|wolgendes Seid|wolgendes Seides}} haddar einbind, wo mid dose Gasgadesschberobsion geschüdsdes {{PLURAL:$1|sei|sei}}:
$2',
'namespaceprotected'   => "Haddar noggs Beregd su bearbeid dose Seid in '''$1'''-Namesraum.",
'customcssjsprotected' => 'Haddar noggs Beregd su bearbeid dose Seid, weil dose gehördar su bersönliges Einschdeles won anderes Benuds.',
'ns-specialprotected'  => 'Schbesialseides noggs gön bearbeid.',
'titleprotected'       => "Gön noggs anleg eines Seid mid dose Nam. Dose Schber dose [[{{ns:user}}:$1]] haddar einrigd mid dose Begründ ''„$2“''.",

# Virus scanner
'virus-badscanner'     => 'Wehlhawdes Gonwigurär: noggsbegandes Wirussgän: <i>$1</i>',
'virus-scanfailed'     => 'Sgän daneb geddar (god $1)',
'virus-unknownscanner' => 'Noggsbegandes Wirussgän:',

# Login and logout pages
'logouttitle'                => 'Benudses-Abmeld',
'logouttext'                 => 'Haddar abmeld.
Gön dose {{SITENAME}} jedsd anonymes weidbenuds, od gön wied undd gleiges od anderes Benudsesnam anmeld.',
'welcomecreation'            => '== Wilgom, $1! ==

Haddar Benudsesgond einrigd. Noggs werges dose Einschdeles anbas.',
'loginpagetitle'             => 'Benudes-Anmeld',
'yourname'                   => 'Benudesnam:',
'yourpassword'               => 'Basword:',
'yourpasswordagain'          => 'Basword wiedhöl:',
'remembermypassword'         => 'Benuds auw dose Gombjud dauhawdes anmeld',
'yourdomainname'             => 'Deines Domän:',
'externaldberror'            => 'Endwed eines Wehl bei egsdernes Audhendiwisär gebdar, od dörw dose egsdernes Benudsesgond noggs agdualisär.',
'loginproblem'               => "'''Haddar eines Broblem bei Anmeld geb.'''<br />Bid nogmal brobär!",
'login'                      => 'Anmeld',
'nav-login-createaccount'    => 'Anmeld',
'loginprompt'                => 'Wan wol anmeld bei dose {{SITENAME}}, musdar dose Guugies in Braus agdiwär.',
'userlogin'                  => 'Anmeld',
'logout'                     => 'Abmeld',
'userlogout'                 => 'Abmeld',
'notloggedin'                => 'Haddar noggs anmeld',
'nologin'                    => 'Haddar noggs Benudsesgond? $1.',
'nologinlink'                => 'Neues Benudsesgond anleg',
'createaccount'              => 'Benudsesgond anleg',
'gotaccount'                 => 'Haddar schon eines Benudsesgond? $1.',
'gotaccountlink'             => 'Anmeld',
'createaccountmail'          => 'üb I-Mehl',
'badretype'                  => 'Dose beides Baswördes noggs susambas.',
'userexists'                 => 'Dose Benudsesnam schon geb. Bid anderes nehm.',
'youremail'                  => 'I-Mehl-Adres:',
'username'                   => 'Benudsesnam:',
'uid'                        => 'Benudses-ID:',
'prefs-memberingroups'       => 'Midglied won dose {{PLURAL:$1|Benudsesgrubb|Benudsesgrubbes}}:',
'yourrealname'               => 'Egdes Nam:',
'yourlanguage'               => 'Sbrag won Benudsesobwläg:',
'yourvariant'                => 'Wariand',
'yournick'                   => 'Undschriwd:',
'badsig'                     => 'Dose Syndags won Undschriwd noggsgüldiges sei; bid HDML übbrüw.',
'badsiglength'               => 'Dose Undschriwd dörw magsimal $1 {{PLURAL:$1|Seig|Seiges}} langes sei.',
'email'                      => 'I-Mehl',
'prefs-help-realname'        => 'Nur wan wol. Deines egdes Nam su dose Beidräges suord.',
'loginerror'                 => 'Wehl bei Anmeld',
'prefs-help-email'           => 'Nur wan wol. Mid dose anderes Benudses üb I-Mehl gön Gondagd auwnehm, ohn das deines Idendidäd erwähr, und gön eines Ersadsbasword suschdel las an dose.',
'prefs-help-email-required'  => 'Braugdar eines güldiges I-Mehl-Adres.',
'nocookiesnew'               => 'Haddar Benudsessugang erschdel, aber haddar noggs einlog.  Wür dose Wungsion dose {{SITENAME}} braugdar Guugies, bid dose agdiwär und dan mid neues Benudsesnam und Basword einlog.',
'nocookieslogin'             => '{{SITENAME}} braugdar Guugies wür Einlog won Benudses. Haddar Guugies deagdiwär, bid dose agdiwär und nogmal brobär.',
'noname'                     => 'Musdar güldiges Benudsesnam angeb.',
'loginsuccesstitle'          => 'Anmeld erwolgreiges',
'loginsuccess'               => 'Haddar jedsd als „$1“ bei dose {{SITENAME}} anmeld.',
'nosuchuser'                 => 'Dose Benudsesnam „$1“ gar noggs geb. Übbrüw dose Schreibweis od als neues Benuds anmeld.',
'nosuchusershort'            => 'Dose Benudsesnam „<nowiki>$1</nowiki>“ gar noggs geb. Bid dose Schreibweis übbrüw.',
'nouserspecified'            => 'Bid Benudsesnam angeb.',
'wrongpassword'              => 'Dose Basword walsches sei (od wehldar). Bid nogmal brobär.',
'wrongpasswordempty'         => 'Haddar gar noggs Basword eingeb. Bid nogmal brobär.',
'passwordtooshort'           => 'Wehl bei Wähl won Basword: Musdar mind {{PLURAL:$1|1 Seig|$1 Seiges}} haddar und dörw noggs idendisches sei mid dose Benudsnam.',
'mailmypassword'             => 'Neues Basword suschig',
'passwordremindertitle'      => 'Neues Basword wür eines {{SITENAME}}-Benudsesgond',
'passwordremindertext'       => 'Jem mid dose IB-Adres $1, wahrschein Du selb, haddar eines neues Basword wür dose Anmeld bei dose {{SITENAME}} ($4) anword.

Dose audomadisches generärdes Basword wür Benuds $2 jedsd sei: $3
Bes wan jedsd anmeld und änd dose Basword: {{fullurl:{{ns:special}}}}:Userlogin

Bid dose I-Mehl ignorär, wan haddar noggs selb anword. Dose aldes Basword weid güldiges bleibdar.',
'noemail'                    => 'Dose Benuds „$1“ haddar noggs I-Mehl-Adres angeb.',
'passwordsent'               => 'Haddar neues, demboräres Basword an dose I-Mehl-Adres won Benuds „$1“ schig.
Bid gleig mid dose anmeld wan haddar grieg. Dose aldes Basword weid güldiges bleibdar.',
'blocked-mailpassword'       => 'Dose IB-Adres wo haddar, haddar wür Änd won Seides schber. Das gön Misbraug werhind, gön aug noggs anword neues Basword.',
'eauthentsent'               => 'Haddar eines Beschdäd-I-Mehl an dose Adres werschig wo haddar angeb.

Bewor eines I-Mehl won anderes Benudses üb dose I-Mehl-Wungsion gön embwäng, musdar dose Adres und das dose werg su dose Benudsesgond gehördar, suersd beschdäd. Bid dose Hinweises in dose Beschdäd-I-Mehl bewolg.',
'throttled-mailpassword'     => 'Haddar in ledsdes {{PLURAL:$1|Schdund|$1 Schdundes}} schon eines neues Basword anword. Das gön Misbraug won dose Wungsion werhind, nur {{PLURAL:$1|einesmal bro Schdund|ales $1 Schdundes}} gön neues Basword anword.',
'mailerror'                  => 'Wehl bei Schig won I-Mehl: $1',
'acct_creation_throttle_hit' => 'Haddar schon $1 Benudsesgondes anleg, gön noggs nog mehres anleg.',
'emailauthenticated'         => 'Haddar Deines I-Mehl-Adres beschdäd: $1.',
'emailnotauthenticated'      => 'Haddar Deines I-Mehl-Adres nog noggs beschdäd. Wolgendes I-Mehl-Wungsiones ersd nag erwolgreiges Beschdäd su Werwüg schdeddar.',
'noemailprefs'               => 'Musdar eines I-Mehl-Adres angeb, das haddar dose wolgendes Wungiones.',
'emailconfirmlink'           => 'I-Mehl-Adres beschdäd (audhendiwisär).',
'invalidemailaddress'        => 'Haddar dose I-Mehl-Adres noggs agsebdär, weil dose anschein ungüldiges Wormad haddar. Bid eines Adres in eines güldiges Wormad eingeb od dose Weld leeres las.',
'accountcreated'             => 'Haddar Benudsesgond erschdel',
'accountcreatedtext'         => 'Dose Benudsesgond $1 haddar einrigd.',
'createaccount-title'        => 'Erschdel won eines Benudsgond wür dose {{SITENAME}}',
'createaccount-text'         => 'Haddar eines Benudsesgond "$2" auw dose {{SITENAME}} ($4) erschdel. Dose audomadisches generärdes Basword wür "$2" sei "$3". Bes wan gleig anmeld und dose Basword änd.

Wan haddar aus Werseddar dose Benudsesgond anleg, gön dose Nagrigd ignorär.',
'loginlanguagelabel'         => 'Sbrag: $1',

# Password reset dialog
'resetpass'               => 'Basword wür Benudsesgond surügseds',
'resetpass_announce'      => 'Anmeld mid dose God wo haddar mid I-Mehl suschig. Wan wol abschlies dose Anmeld, musdar jedsd neues Basword aussug.',
'resetpass_header'        => 'Basword surügseds',
'resetpass_submit'        => 'Basword schig und anmeld',
'resetpass_success'       => 'Haddar Basword erwolgreiges änd. Jedsd gom dose Anmeld …',
'resetpass_bad_temporary' => 'Noggsgüldiges worläuwiges Basword. Haddar dose Basword schon erwolgreiges änd od haddar neues, worläuwiges Basword anword.',
'resetpass_forbidden'     => 'Dose Basword in dose {{SITENAME}} noggs gön änd.',
'resetpass_missing'       => 'Leeres Wormular',

# Edit page toolbar
'bold_sample'     => 'Weddes Degsd',
'bold_tip'        => 'Weddes Degsd',
'italic_sample'   => 'Gursiwes Degsd',
'italic_tip'      => 'Gursiwes Degsd',
'link_sample'     => 'Werweis-Degsd',
'link_tip'        => 'Inderned Werweis',
'extlink_sample'  => 'http://www.example.com Werweis-Degsd',
'extlink_tip'     => 'Egsdernes Werweis (http:// beagd)',
'headline_sample' => 'Ebene 2 Übschriwd',
'headline_tip'    => 'Ebene 2 Übschriwd',
'math_sample'     => 'Wormel da einwüg',
'math_tip'        => 'Madhemadisches Wormel (LaTeX)',
'nowiki_sample'   => 'Noggswormadärdes Degsd da einwüg',
'nowiki_tip'      => 'Noggswormadärdes Degsd',
'image_sample'    => 'Beischb.jpg',
'image_tip'       => 'Dadeiwerweis',
'media_sample'    => 'Beischb.ogg',
'media_tip'       => 'Mediesdadei-Werweis',
'sig_tip'         => 'Deines Signadur mid Dseidschdemb',
'hr_tip'          => 'Horisondales Lin (schbarsames werwend)',

# Edit pages
'summary'                          => 'Susamwas',
'subject'                          => 'Bedrew',
'minoredit'                        => 'Haddar nur bis weränd dose',
'watchthis'                        => 'Dose Seid beobagd',
'savearticle'                      => 'Seid schbeig',
'preview'                          => 'Worschau',
'showpreview'                      => 'Worschau seig',
'showlivepreview'                  => 'Laiw-Worschau',
'showdiff'                         => 'Ändes seig',
'anoneditwarning'                  => "Du dose Seid noggsangemeldedes bearbeid. Wan dose schbeig, ales gön seddar deines agdueles IB-Adres in dose Wersionsgeschigd.",
'missingsummary'                   => "'''Hinweis:''' Haddar noggs Susamwas angeb. Wan nogmal auw „Seid schbeig“ gligg, deines Änd ohn Susamwas übnehm.",
'missingcommenttext'               => 'Bid eines Susamwas angeb.',
'missingcommentheader'             => "'''OBAGD:''' Haddar noggs Übschriwd in dose Weld „Bedrew:“ eingeb. Wan nogmal auw „Seid schbeig“ gligg, deines Bearb ohn Übschriwd schbeig.",
'summary-preview'                  => 'Worschau won Susamwasdseil',
'subject-preview'                  => 'Worschau won Bedrew',
'blockedtitle'                     => 'Benuds geschberdes sei',
'blockedtext'                      => 'Deines Benudsesnam od Deines IB-Adres dose $1 haddar schber. Als Grund haddar angeb:

:\'\'$2\'\' (<span class="plainlinks">[{{fullurl:Special:Ipblocklist|&action=search&limit=&ip=%23}}$5 Logbugeindrag]</span>)

<p style="border-style: solid; border-color: red; border-width: 1px; padding:5px;"><b>Lessugriw schon haddar,</b>
nur dose Bearbeid und Erschdel won Seides in dose {{SITENAME}} haddar schber.
Wan dose Nagrigd anseig, obwohl haddar nur les, haddar wolg eines (rodes) Werweis auw eines Seid wo nog noggs geb.</p>

Gön $1 od eines won anderes [[{{MediaWiki:Grouppage-sysop}}|Adminisdradores]] gondagdär und disgudär üb dose Schber.

<div style="border-style: solid; border-color: red; border-width: 1px; padding:5px;">
\'\'\'Bid wolgendes Dades in jedes Anwräg angeb:\'\'\'
*Schberendes Adminisdrad: $1
*Schbergrund: $2
*Anwäng won Schber: $8
*End won Schber: $6
*IB-Adres: $3
*Schber bedrew: $7
*Schber-ID: #$5
</div>',
'autoblockedtext'                  => 'Deines IB-Adres haddar audomadisches schber, weil eines anderes Benuds haddar nuds dose, wo durg dose $1 geschberdes sei.
Als Grund haddar angeb:

:\'\'$2\'\' (<span class="plainlinks">[{{fullurl:Special:Ipblocklist|&action=search&limit=&ip=%23}}$5 Logbugeindrag]</span>)

<p style="border-style: solid; border-color: red; border-width: 1px; padding:5px;"><b>Lessugriw schon haddar,</b>
nur dose Bearbeid und Erschdel won Seides in dose {{SITENAME}} haddar schber.
Wan dose Nagrigd anseig, obwohl haddar nur les, haddar wolg eines (rodes) Werweis auw eines Seid wo nog noggs geb.</p>

Gön $1 od eines won anderes [[{{MediaWiki:Grouppage-sysop}}|Adminisdradores]] gondagdär und disgudär üb dose Schber.

<div style="border-style: solid; border-color: red; border-width: 1px; padding:5px;">
\'\'\'Bid wolgendes Dades in jedes Anwräg angeb:\'\'\'
*Schberendes Adminisdrador: $1
*Schbergrund: $2
*Anwäng won Schber: $8
*End won Schber: $6
*IB-Adres: $3
*Schber-ID: #$5
</div>',
'blockednoreason'                  => 'haddar gar noggs Begründ angeb',
'blockedoriginalsource'            => "Dose Gueldegsd won dose '''$1''' da anseig:",
'blockededitsource'                => "Dose Gueldegsd won '''Deines Ändes''' an dose '''$1''':",
'whitelistedittitle'               => 'Wür Bearbeid musdar angemeldedes sei',
'whitelistedittext'                => 'Musdar $1, wan wol Seides bearbeid.',
'whitelistreadtitle'               => 'Wür Les musdar angemeldedes sei',
'whitelistreadtext'                => 'Musdar [[Special:Userlogin|da anmeld]], wan wol Seides les.',
'whitelistacctitle'                => 'Haddar nogs Beregd das gön eines Benudsesgond anleg.',
'whitelistacctext'                 => 'Wan wol Benudsesgondes anleg in dose {{SITENAME}}, musdar [[Special:Userlogin|da anmeld]] und dose nödiges Beregdes haddar.',
'confirmedittitle'                 => 'Wür Bearbeid dose I-Mehl-Beschdäd braugdar.',
'confirmedittext'                  => 'Musdar suersd I-Mehl-Adres beschdäd, bewor gön Bearbeides mag. Bid ergäns und beschdäd Deines I-Mehl in dose [[Special:Preferences|Einschdeles]].',
'nosuchsectiontitle'               => 'Abschnid noggs geb',
'nosuchsectiontext'                => 'Brobär su bearbeid dose Abschnid $1 wo gar noggs geb. Gön aba nur Abschnides bearbeid wo schon geb.',
'loginreqtitle'                    => 'Musdar anmeld',
'loginreqlink'                     => 'anmeld',
'loginreqpagetext'                 => 'Musdar $1, wan wol Seides les.',
'accmailtitle'                     => 'Haddar Basword werschig',
'accmailtext'                      => 'Dose Basword wür „$1“ haddar an $2 schig.',
'newarticle'                       => '(Neues)',
'newarticletext'                   => 'Da dose Degsd won neues Seid reinschreib. Bid nur in ganses Sädses schreib und noggs gobär urhebregdliges geschüdsdes Degsdes won anderes.',
'anontalkpagetext'                 => "---- ''Dose Seid wür dose sei, das gön eines Benuds Nagrigdes schig wo haddar noggs anmeld. Wan mid dose Gomendäres auw dose Seid noggs gön anwäng, dose wahrschein wür eines wrüheres Inhab won Deines IB-Adres, dan gön ignorär dose.''",
'noarticletext'                    => '(Dose Seid momendanes nog noggs Degsd drinhaddar)',
'userpage-userdoesnotexist'        => 'Dose Benudsesgond „$1“ gar noggs geb. Bid brüw, ob wol werg erschdel dose Seid.',
'clearyourcache'                   => "'''Hinweis:''' Das Ändes seddar, bid dose Gedsch leer: '''Mosila/Waierwogs:''' ''Shift-Strg-R'', '''Inderned Egsblor:''' ''Strg-F5'', '''Obera:''' ''F5'', '''Sawari:''' ''?-R'', '''Gongueror:''' ''Strg-R''.",
'usercssjsyoucanpreview'           => '<strong>Tipp:</strong> Benudsdar dose Worschau-Gnobw su desd neues CSS/JS wor dose Schbeig.',
'usercsspreview'                   => "== Worschau won Deines Benuds-CSS ==
'''Beagd:''' Nag dose Schbeig musdar Braus anweis, dose neues Wersion lad: '''Mosila/Waierwogs:''' ''Strg-Shift-R'', '''Inderned Egsblor:''' ''Strg-F5'', '''Obera:''' ''F5'', '''Sawari:''' ''Cmd-Shift-R'', '''Gongueror:''' ''F5''.",
'userjspreview'                    => "== Worschau won Deines Benuds-JawaSgribd ==
'''Beagd:''' Nag dose Schbeig musdar Braus anweis, dose neues Wersion lad: '''Mosila/Waierwogs:''' ''Strg-Shift-R'', '''Inderned Egsblor:''' ''Strg-F5'', '''Obera:''' ''F5'', '''Sawari:''' ''Cmd-Shift-R'', '''Gongueror:''' ''F5''.",
'userinvalidcssjstitle'            => "'''Obagd:''' Sgin „$1“ gar noggs geb. Deng, das benudsschbesiwisches .css- und .js-Seides mid Gleinbugschdabes musdar anwäng, sum Beischb ''{{ns:user}}:Musderman/monobook.css'' schdadd ''{{ns:user}}:Musderman/Monobook.css''.",
'updated'                          => '(Geänderdes)',
'note'                             => '<strong>Hinweis:</strong>',
'previewnote'                      => '<strong>Dose nur Worschau sei, haddar Seid nog noggs schbeig!</strong> [[#editform|? Su dose Bearbeidwensd]]',
'previewconflict'                  => 'In dose Worschau seddar Inhald won oberes Degsdweld. So dose Ardig ausschauddar, wan jedsd schbeig.',
'session_fail_preview'             => '<strong>Haddar Bearbeid noggs gön schbeig, weil haddar werlor deines Sidsdades.
Bid nogmal brobär, mid nogmal gligg auw „Seid schbeig“ undd dose wolgendes Degsdworschau.
Wan dose Broblem dan imm nog haddar, bid abmeld und dan wied anmeld.</strong>',
'session_fail_preview_html'        => "<strong>Haddar Bearbeid noggs gön schbeig, weil haddar werlor deines Sidsdades.</strong>

''Weil in dose {{SITENAME}} dose Schbeig won reines HDML agdiwärdes sei, haddar dose Worschau ausblend, das gön JawaSgribd-Addagges worbeug.''

<strong>Bid nogmal brobär, mid nogmal gligg auw „Seid schbeig“ undd dose wolgendes Degsdworschau. Wan dose Broblem dan imm nog haddar, bid abmeld und dan wied anmeld.</strong>",
'token_suffix_mismatch'            => '<strong>Haddar Bearbeid surügweis, weil Deines Braus haddar Seiges in Bearbeid-Dogen verschdüm.
Eines Schbeig gön dose Seidesinhald wersresch. Dose mangmal gebdar bei Benuds won anonymes Brogsy-Diensd, wo wehlhawdes arbeid.</strong>',
'editing'                          => 'Bearbeid won $1',
'editingsection'                   => 'Bearbeid won $1 (Absads)',
'editingcomment'                   => 'Bearbeid won $1 (Gomendar)',
'editconflict'                     => 'Bearbeidgonwligd: $1',
'explainconflict'                  => "Jem anderes haddar dose Seid änd, nagdem Du haddar anwäng su bearb dose.
In dose oberes Degsdweld agdueles Schdand seddar.
In dose underes Degsdweld Deines Ändes seddar.
Bid Ändes in dose oberes Degsdweld einwüg.
'''Nur''' dose Inhald won oberes Degsdweld schbeig, wan auw „Seid schbeig“ gligg!",
'yourtext'                         => 'Deines Degsd',
'storedversion'                    => 'Geschbeigerdes Wersion',
'nonunicodebrowser'                => '<strong>Obagd:</strong> Deines Braus noggs gön Junigod-Seiges rigdiges werarb. Bid anderes Braus nehmdar su bearbeid Seides.',
'editingold'                       => '<strong>OBAGD: Du eines aldes Wersion won dose Seid bearbeid. Wan schbeig, ales neueres Wersiones übschreib.</strong>',
'yourdiff'                         => 'Undschiedes',
'copyrightwarning'                 => '<strong>Bid <big>noggs Nedsseides gobär</big>, wo noggs deines eigenes sei, nehmdar <big>noggs urhebregdliges geschüdsdes Werges</big> ohn Erlaub won Gobyraid-Inhab!</strong><br />
Mid dose Du Deines Susag geb, das dose Degsd <strong>selb werwas</strong> haddar, das dose Degsd Algemeinesgud (<strong>bablig domän</strong>) sei, od das dose <strong>Gobyraid-Inhab</strong> seines <strong>Suschdäm</strong> haddar geb. Wan dose Degsd schon woand haddar weröwendlig, bid auw Disgusionsseid auw dose hinweis.
<i>Bid beagd, das ales {{SITENAME}}-Beidräges audomadisches undd dose „$2“ schdeddar (seddar $1 wür Dedailes). Wan noggs wol, das anderes Deines Arb weränd od werbreid, dan noggs gligg auw „Seid schbeig“.</i>',
'copyrightwarning2'                => 'Bid beagd, das ales Beidräges su dose {{SITENAME}} anderes gön bearbeid, änd od lösch.
Noggs Degsdes reingeb wan noggs wol, das dose ohn Einschräng gön änd.

Mid dose Du aug beschdäd, das haddar dose Degsdes selb schreib od haddar dose gobär won eines gemeinwreies Guel.
(seddar $1 wür weideres Dedailes). <strong>NOGGS URHEBREGDLIGES GESCHÜDSDES INHALDES REINGEB OHN GENEHMIG!</strong>',
'longpagewarning'                  => '<strong>WARN: Dose Seid $1 GiloBaid groses sei; manges Brauses gön haddar Broblemes su bearbeid Seides wo sei gröseres wie 32 Gilobaid.
Bid übleg, ob gön auwdeil dose Seid in gleineres Abschnides.</strong>',
'longpageerror'                    => '<strong>WEHL: Dose Degsd wo brobär su schbeig, $1 Gilobaid groses sei. Dose gröseres sei wie dose erlaubdes Magsimum won $2 Gilobaid – Schbeig noggs mög sei.</strong>',
'readonlywarning'                  => '<strong>OBAGD: Dose Dadesbang haddar bei Seidbearbeid wür Wardarbeides schber, gön dose Seid momendan
noggs schbeig. Bid sock dose Degsd und brobär dose Ändes schbäderes nogmal reingeb.</strong>',
'protectedpagewarning'             => "'''OBAGD: Dose Seid haddar schber. Nur Benudses mid Adminisdradregdes gön bearbeid dose Seid.'''",
'semiprotectedpagewarning'         => "'''Halbschber:''' Dose Seid haddar so schber, das nur regisdrärdes Benudses gön änd dose.",
'cascadeprotectedwarning'          => "'''OBAGD: Dose Seid haddar schber, das nur Benudses mid Adminisdradoregdes gön bearbeid dose. Dose haddar in dose {{PLURAL:$1|wolgendes Seid|wolgendes Seides}} einbind, wo mid dose Gasgadesschberobsion geschüdsdes {{PLURAL:$1|sei|sei}}:'''",
'titleprotectedwarning'            => '<strong>OBAGD: Dose Seideserschdel haddar schber. Nur beschdämdes Benudsesgrubbes gön erschdel dose Seid.</strong>',
'templatesused'                    => 'Dose Seid wolgendes Worlages werwend:',
'templatesusedpreview'             => 'Dose Seidesworschau wolgendes Worlages werwend:',
'templatesusedsection'             => 'Dose Abschnid wolgendes Worlages werwend:',
'template-protected'               => '(schreibgeschüdsdes)',
'template-semiprotected'           => '(schreibgeschüdsdes wür noggsangemeldedes und neues Benudses)',
'hiddencategories'                 => 'Dose Seid Midglied sei won {{PLURAL:$1|1 werschdegdes Gadegorä|$1 werschdegdes Gadegoräes}}:',
'edittools'                        => '<!-- Dose Degsd undd dose „Bearbeid“-Wormular und dose "Hoglad"-Wormular anseig. -->',
'nocreatetitle'                    => 'Dose Erschdel won neues Seides eingeschrängdes sei.',
'nocreatetext'                     => 'Auw dose {{SITENAME}} haddar dose Erschdel won neues Seides einschräng. Gön Seides änd wo schon geb od gön [[Special:Userlogin|anmeld]].',
'nocreate-loggedin'                => 'Haddar noggs Beregd su anleg neues Seides in dose {{SITENAME}}.',
'permissionserrors'                => 'Beregdwehl',
'permissionserrorstext'            => 'Sei noggs beregdigdes das gön auswühr dose Agsion. {{PLURAL:$1|Grund|Gründes}}:',
'permissionserrorstext-withaction' => 'Sei noggs beregdigdes das gön auswühr dose Agsion „$2“, {{PLURAL:$1|Grund|Gründes}}:',
'recreate-deleted-warn'            => "'''Obagd: Du grad eines Seid erschdel, wo haddar wrüheres schon lösch.'''

Bid sorgwäldiges brüw, ob dose neues Seiderschdel dose Rigdlines endsbreg.
Wür Deines Inwormasion dose Lösch-Logbug wolg mid dose Begründ wür dose worhergeddares Lösch:",

# Parser/template warnings
'expensive-parserfunction-warning'        => 'Obagd: Dose Seid haddar su wieles Auwruwes won auwwändiges Barserwungsiones.
 
Dörw noggs mehres wie $2 Auwruwes geb, agdueles dose $1 Auwruwes sei.',
'expensive-parserfunction-category'       => 'Seides wo auwwändiges Barserwungsiones su owd auwruw',
'post-expand-template-inclusion-warning'  => 'Warn: Dose Grös won eingebundenes Worlages su groses sei, einiges Worlages haddar noggs gön einbind.',
'post-expand-template-inclusion-category' => 'Seides, wo haddar übschreid dose magsimales Grös won eingebundenes Worlages',
'post-expand-template-argument-warning'   => 'Warn: Dose Seid haddar mind eines Argumend in eines Worlag, wo egsbandärdes su groses sei. Dose Argumendes ignorär.',
'post-expand-template-argument-category'  => 'Seides wo haddar ignorärdes Worlagesargumendes',

# "Undo" feature
'undo-success' => 'Dose Änd haddar gön erwolgreiges rügggäng mag. Bid gondrolär dose Bearbeid in dose Wergleigsansigd und dan gligg auw „Seid schbeig“ das schbeig dose.',
'undo-failure' => '<span class="error">Dose Änd haddar noggs gön rügggäng mag, weil dose bedrowenes Abschnid inswisch haddar weränd.</span>',
'undo-norev'   => 'Dose Bearbeid haddar noggs gön rügggäng mag, weil dose noggs geb od haddar lösch.',
'undo-summary' => 'Änd $1 won [[{{#special:Contributions}}/$2|$2]] ([[{{ns:User talk}}:$2|Disgusion]]) haddar rügggäng mag.',

# Account creation failure
'cantcreateaccounttitle' => 'Haddar noggs gön erschdel Benudsesgond',
'cantcreateaccount-text' => "Dose Erschdel won eines Benudsesgond won dose IB-Adres '''($1)''' dose [[User:$3|$3]] haddar schber.

Grund won Schber: ''$2''",

# History pages
'viewpagelogs'        => 'Logbüges wür dose Seid anseig',
'nohistory'           => 'Gebdar noggs Wersionsgeschigd wür dose Seid.',
'revnotfound'         => 'Haddar noggs wend dose Wersion.',
'revnotfoundtext'     => 'Dose Wersion won dose Seid wo sug haddar noggs wend. Bid übbrüw dose URL won dose Seid.',
'currentrev'          => 'Agdueles Wersion',
'revisionasof'        => 'Wersion won $1',
'revision-info'       => 'Dose eines aldes Wersion sei. Dseidbungd won Bearbeid: $1 durg $2.',
'previousrevision'    => '? Nägsdälderes Wersion',
'nextrevision'        => 'Nägsdjüngeres Wersion ?',
'currentrevisionlink' => 'Agdueles Wersion',
'cur'                 => 'Agduel',
'next'                => 'Nägsdes',
'last'                => 'Woriges',
'page_first'          => 'Anwäng',
'page_last'           => 'End',
'histlegend'          => 'Wür Anseig won dose Ändes einwag dose Wersiones auswähl wo wol wergleig und dose Schaldwläg „{{int:compareselectedversions}}“ gligg.<br />
* (Agduel) = Undschied su agdueles Wersion, (Woriges) = Undschied su woriges Wersion
* Uhrdseid/Dadum = Wersion su dose Ddseid, Benudsnam/IB-Adres won Bearbeid, G = Gleines Änd',
'deletedrev'          => '[gelöschdes]',
'histfirst'           => 'Äldesdes',
'histlast'            => 'Neuesdes',
'historysize'         => '({{PLURAL:$1|1 Baid|$1 Baids}})',
'historyempty'        => '(leeres)',

# Revision feed
'history-feed-title'          => 'Wersionsgeschigd',
'history-feed-description'    => 'Wersionsgeschigd wür dose Seid in dose {{SITENAME}}',
'history-feed-item-nocomment' => '$1 um $2', # user at time
'history-feed-empty'          => 'Dose Seid wo anword gar noggs geb. Wileigd haddar lösch od werschieb. [[Special:Search|Durgsug]] dose {{SITENAME}} wür basendes neues Seides.',

# Revision deletion
'rev-deleted-comment'         => '(Bearbeidgomendar endwerndes)',
'rev-deleted-user'            => '(Benudsnam endwerndes)',
'rev-deleted-event'           => '(Logbugagsion endwerndes)',
'rev-deleted-text-permission' => '<div class="mw-warning plainlinks"> Dose Wersion haddar lösch und noggs mehr gön öwendliges einseddar.
Näheres Angabes su Löschworgang und eines Begründ gön wend in dose [{{fullurl:Special:Log/delete|page={{FULLPAGENAMEE}}}} Lösch-Logbug].</div>',
'rev-deleted-text-view'       => '<div class="mw-warning plainlinks">Dose Wersion haddar lösch und noggs mehr gön öwendliges einseddar.
Als Adminisdrad auw dose {{SITENAME}} gön dose weid einseddar.
Näheres Angabes su Löschworgang und eines Begründ gön wend in dose [{{fullurl:Special:Log/delete|page={{FULLPAGENAMEE}}}} Lösch-Logbug].</div>',
'rev-delundel'                => 'seig/werschdeg',
'revisiondelete'              => 'Wersiones lösch/wiedherschdel',
'revdelete-nooldid-title'     => 'Haddar noggs Wersion angeb',
'revdelete-nooldid-text'      => 'Endwed haddar noggs Wersion angeb wo dose Agsion sol auswühr, od dose Wersion wo wähl gar noggs geb, od haddar brobär su endwern dose agdueles Wersion.',
'revdelete-selected'          => "{{PLURAL:$2|Ausgewähldes Wersion|Ausgewähldes Wersiones}} won '''$1:'''",
'logdelete-selected'          => "{{PLURAL:$1|Ausgewähldes Logbugeindrag|Ausgewähldes Logbugeindräges}} wür '''$1:'''",
'revdelete-text'              => 'Dose Inhald od anderes Deiles won gelöschdes Wersiones gön noggs mehr öwendliges einseddar, gön aba imm nog seddar als Eindräges in dose Wersionsgeschigd.

{{SITENAME}}-Adminisdradores gön dose endwerndes Inhald od anderes endwerndes Deiles imm nog einseddar und wiedherschdel, aus wan haddar wesdleg das dose Sugangsbeschränges aug wür Adminisdradores geld.',
'revdelete-legend'            => 'Seds won Seddarbargeids-Einschränges',
'revdelete-hide-text'         => 'Degsd won Wersion werschdeg',
'revdelete-hide-name'         => 'Logbug-Agsion werschdeg',
'revdelete-hide-comment'      => 'Bearbeidgomendar werschdeg',
'revdelete-hide-user'         => 'Benudsesnam/dose IB won Bearbeid werschdeg',
'revdelete-hide-restricted'   => 'Dose Einschränges aug wür Adminisdradores geld, schber dose Wormular',
'revdelete-suppress'          => 'Grund won Lösch aug wor Adminisdradores werschdeg',
'revdelete-hide-image'        => 'Bildinhald werschdeg',
'revdelete-unsuppress'        => 'Einschränges wür wiedherschdeldar Wersiones auwheb',
'revdelete-log'               => 'Gomendar/Begründ (in Logbug erschein):',
'revdelete-submit'            => 'Auw ausgewähldes Wersion anwend',
'revdelete-logentry'          => 'Wersionsansigd haddar änd wür „[[$1]]“',
'logdelete-logentry'          => 'haddar änd dose Seddarbargeid wür „[[$1]]“',
'revdelete-success'           => "'''Wersionsansigd haddar erwolgreiges änd.'''",
'logdelete-success'           => "'''Logbugansigd haddar erwolgreiges änd.'''",
'revdel-restore'              => 'Seddarbargeid änd',
'pagehist'                    => 'Wersionsgeschigd',
'deletedhist'                 => 'Gelöschdes Wersiones',
'revdelete-content'           => 'Seidesinhald',
'revdelete-summary'           => 'Susamwasgomendar',
'revdelete-uname'             => 'Benudsnam',
'revdelete-restricted'        => 'Einschränges aug wür Adminisdradores geld',
'revdelete-unrestricted'      => 'Einschränges wür Adminisdradores haddar auwheb',
'revdelete-hid'               => 'werschdegdes $1',
'revdelete-unhid'             => 'haddar $1 wied öwendliges mag',
'revdelete-log-message'       => '$1 wür $2 {{PLURAL:$2|Wersion|Wersiones}}: $3',
'logdelete-log-message'       => '$1 wür $2 {{PLURAL:$2|Logbugeindrag|Logbugeindräges}}',

# Suppression log
'suppressionlog'     => 'Oversight-Logbug',
'suppressionlogtext' => 'Dose dose Logbug won dose Oversight-Agsiones sei (Ändes won Seddarbargeid won Wersiones, Bearbeidgomendares, Benudsesnames und Benudsesschberes).',

# History merging
'mergehistory'                     => 'Wersionsgeschigdes wereinig',
'mergehistory-header'              => 'Mid dose Schbesialseid gön dose Wersionsgeschigd won eines Urschbrungsseid mid dose Wersionsgeschigd won eines Sielseid wereinig.
Musdar sock sei, das dose Wersionsgeschigd won eines Ardig hisdorisches goregdes sei.',
'mergehistory-box'                 => 'Wersionsgeschigd won suai Seides wereinig',
'mergehistory-from'                => 'Urschbrungsseid:',
'mergehistory-into'                => 'Sielseid:',
'mergehistory-list'                => 'Wersiones, wo gön wereinig',
'mergehistory-merge'               => 'Dose wolgendes Wersiones won „[[:$1]]“ gön nag „[[:$2]]“ übdrag. Margär dose Wersion, bis su dose (einschliesliges) sol übdrag dose Wersiones. Bid beagd, das dose Nuds won dose Nawigasionswerweises dose Auswähl surügseds.',
'mergehistory-go'                  => 'Seig Wersiones, wo gön wereinig',
'mergehistory-submit'              => 'Wereinig Wersiones',
'mergehistory-empty'               => 'Gön noggs Wersiones wereinig.',
'mergehistory-success'             => '{{PLURAL:$3|1 Wersion|$3 Wersiones}} won „[[:$1]]“ haddar erwolgreiges nag „[[:$2]]“ wereinig.',
'mergehistory-fail'                => 'Wersionswereinig noggs mög, bid brüw dose Seid und dose Dseidangabes.',
'mergehistory-no-source'           => 'Urschbrungsseid „$1“ gar noggs geb.',
'mergehistory-no-destination'      => 'Sielseid „$1“ gar noggs geb.',
'mergehistory-invalid-source'      => 'Urschbrungsseid musdar sei güldiges Seidesnam.',
'mergehistory-invalid-destination' => 'Sielseid musdar sei güldiges Seidesnam.',
'mergehistory-autocomment'         => '„[[:$1]]“ haddar wereinig nag „[[:$2]]“',
'mergehistory-comment'             => '„[[:$1]]“ haddar wereinig nag „[[:$2]]“: $3',

# Merge log
'mergelog'           => 'Wereinig-Logbug',
'pagemerge-logentry' => 'wereinigdes [[$1]] in [[$2]] (Wersiones bis $3)',
'revertmerge'        => 'Wereinig rügggängiges mag',
'mergelogpagetext'   => 'Dose dose Logbug won wereinigdes Wersionsgeschigdes sei.',

# Diffs
'history-title'           => 'Wersionsgeschigd won „$1“',
'difference'              => '(Undschied swisch Wersiones)',
'lineno'                  => 'Dseil $1:',
'compareselectedversions' => 'Gewähldes Wersiones wergleig',
'editundo'                => 'rügggängiges',
'diff-multi'              => '(Dose Wersionswergleig {{PLURAL:$1|1 daswisch liegdares Wersion|$1 daswisch liegdares Wersiones}} mid einbesiehdar.)',

# Search results
'searchresults'             => 'Sugergebnises',
'searchresulttext'          => 'Wür mehres Inwormasiones su Sug seddar dose [[{{MediaWiki:Helppage}}|Hilwseid]].',
'searchsubtitle'            => 'Deines Suganwräg: „[[:$1|$1]]“.',
'searchsubtitleinvalid'     => 'Deines Suganwräg: „$1“.',
'noexactmatch'              => "'''Gebdar noggs Seid mid dose Did „$1“.'''

Aldernadiwes gön aug dose [[Special:Allpages|alwabedisches Indegs]] nag ähnliges Begriwes durgsug.

Wan ausgen mid dose Dhem, gön ja dose Seid „[[$1]]“ selb schreib, od.",
'noexactmatch-nocreate'     => "'''Gebdar noggs Seid mid dose Did „$1“.'''",
'toomanymatches'            => 'Dose Ansähl won Sugergebnises su groses sei, bid brobär anderes Abwräg.',
'titlematches'              => 'Übeinschdämes mid Seidesdides',
'notitlematches'            => 'Noggs Übeinschdämes mid Seidesdides',
'textmatches'               => 'Übeinschdämes mid Inhaldes',
'notextmatches'             => 'Noggs Übeinschdämes mid Inhaldes',
'prevn'                     => 'woriges $1',
'nextn'                     => 'nägsdes $1',
'viewprevnext'              => 'Seig ($1) ($2) ($3)',
'search-result-size'        => '$1 ({{PLURAL:$2|1 Word|$2 Wördes}})',
'search-result-score'       => 'Relewans: $1 %',
'search-redirect'           => '(Weidleid $1)',
'search-section'            => '(Abschnid $1)',
'search-suggest'            => 'Haddar mein „$1“?',
'search-interwiki-caption'  => 'Schwesdbrojegdes',
'search-interwiki-default'  => '$1 Ergebnises:',
'search-interwiki-more'     => '(weideres)',
'search-mwsuggest-enabled'  => 'mid Worschläges',
'search-mwsuggest-disabled' => 'noggs Worschläges',
'search-relatedarticle'     => 'Werwanddes',
'mwsuggest-disable'         => 'Worschläges ber Ajags deagdiwär',
'searchrelated'             => 'werwanddes',
'searchall'                 => 'ales',
'showingresults'            => "Da {{PLURAL:$1|haddar '''1''' Ergebnis|haddar '''$1''' Ergebnises}}, anwäng mid Num '''$2.'''",
'showingresultsnum'         => "Da {{PLURAL:$3|haddar '''1''' Ergebnis|haddar '''$1''' Ergebnises}}, anwäng mid Num '''$2.'''",
'showingresultstotal'       => "Jedsd {{PLURAL:$3|Sugergeb '''$1''' won '''$3:'''|Sugergebnises '''$1–$2''' won '''$3:'''}} gom",
'nonefound'                 => "'''Hinweis:''' Schdandardmäs nur baar Namesräumes durgsug. Sedsdar ''all:'' wor dose Sugbegriw, das ales Seides (ingl. Disgusionsseides, Worlages usw.) durgsug od dose Nam won Namesraum einseds wo sol durgsug.",
'powersearch'               => 'Erweiderdes Sug',
'powersearch-legend'        => 'Erweiderdes Sug',
'powersearch-ns'            => 'Sug in Namesräumes:',
'powersearch-redir'         => 'Weidleides anseig',
'powersearch-field'         => 'Sug nag:',
'search-external'           => 'Egsdernes Sug',
'searchdisabled'            => 'Dose {{SITENAME}}-Sug deagdiwärdes sei. Gön ja derweil mid Guugl sug. Bid bedeng, das dose Sugindegs wür dose {{SITENAME}} gön weraldedes sei.',

# Preferences page
'preferences'              => 'Einschdeles',
'preferences-summary'      => 'Auw dose Schbesialseid gön Deines Sugangsdades änd und beschdämdes Deiles won dose Obwläg indiwidueles anbas.',
'mypreferences'            => 'Einschdeles',
'prefs-edits'              => 'Ansähl Bearbeides:',
'prefsnologin'             => 'Noggs angemeldedes',
'prefsnologintext'         => 'Musdar [[Special:Userlogin|angemeldedes]] sei, das gön dose Einschdeles änd.',
'prefsreset'               => 'Dose Eingabes haddar werwerw, haddar noggs schbeig dose.',
'qbsettings'               => 'Seidesleisd',
'qbsettings-none'          => 'Noggs',
'qbsettings-fixedleft'     => 'Linges, wigses',
'qbsettings-fixedright'    => 'Regdes, wigses',
'qbsettings-floatingleft'  => 'Linges, schwebendes',
'qbsettings-floatingright' => 'Regdes, schwebendes',
'changepassword'           => 'Basword änd',
'skin'                     => 'Sgin',
'math'                     => 'TeX',
'dateformat'               => 'Dadumeswormad',
'datedefault'              => 'Schdandard',
'datetime'                 => 'Dadum und Dseid',
'math_failure'             => 'Barser-Wehl',
'math_unknown_error'       => 'Noggsbegandes Wehl',
'math_unknown_function'    => 'Noggsbegandes Wungsion',
'math_lexing_error'        => "'Lexing'-Wehl",
'math_syntax_error'        => 'Syndagswehl',
'math_image_error'         => 'dose PNG-Gonwerdär daneb geddar',
'math_bad_tmpdir'          => 'Dose demboräres Werseig wür madhemadisches Wormeles haddar noggs gön anleg od beschreib.',
'math_bad_output'          => 'Dose Sielwerseig wür madhemadisches Wormeles haddar noggs gön anleg od beschreib.',
'math_notexvc'             => 'Dose texvc-Brogram haddar noggs wend. Bid math/README beagd.',
'prefs-personal'           => 'Benudsesdades',
'prefs-rc'                 => 'Anseig won „Ledsdes Ändes“',
'prefs-watchlist'          => 'Beobagdlisd',
'prefs-watchlist-days'     => 'Ansähl won Däges, wo schdandardmäs in dose Beobagdlisd drin sei sol:',
'prefs-watchlist-edits'    => 'Magsimales Ansähl won dose Eindräges in dose erweideres Beobagdlisd:',
'prefs-misc'               => 'Werschiedenes',
'saveprefs'                => 'Einschdeles schbeig',
'resetprefs'               => 'Eingabes werwerw',
'oldpassword'              => 'Aldes Basword:',
'newpassword'              => 'Neues Basword:',
'retypenew'                => 'Neues Basword (nogmal):',
'textboxsize'              => 'Bearbeid',
'rows'                     => 'Dseiles',
'columns'                  => 'Schbaldes',
'searchresultshead'        => 'Sug',
'resultsperpage'           => 'Drewes bro Seid:',
'contextlines'             => 'Dseiles bro Drew:',
'contextchars'             => 'Seiges bro Dseil:',
'recentchangesdays'        => 'Ansähl won Däges, wo schdandardmäs in dose Lisd won dose „Ledsdes Ändes“ drin sei sol:',
'recentchangescount'       => 'Ansähl won Eindräges in „Ledsdes Ändes“, dose Wersionsgeschigd und dose Logbüges:',
'savedprefs'               => 'Haddar Einschdeles schbeig.',
'timezonelegend'           => 'Dseid-Dson',
'timezonetext'             => '¹Ansahl won Schdundes eingeb, wo swisch Deines Dseid-Dson und dose UTC liegdar.',
'localtime'                => 'Ordesdseid:',
'timezoneoffset'           => 'Undschied¹:',
'servertime'               => 'Agdueles Dseid auw dose Sörw:',
'guesstimezone'            => 'Won Braus übnehm',
'allowemail'               => 'I-Mehl-Embwäng won anderes Benudses mög mag',
'prefs-searchoptions'      => 'Sugobsiones',
'prefs-namespaces'         => 'Namesräumes',
'defaultns'                => 'In dose Namesräumes schdandardmäs sol sug:',
'default'                  => 'Woreinschdel',
'files'                    => 'Dadeies',

# User rights
'userrights'                       => 'Benudsesregdeswerwald', # Not used as normal message but as header for the special page itself
'userrights-lookup-user'           => 'Werwald Grubbessugehöriggeid',
'userrights-user-editname'         => 'Benudsesnam:',
'editusergroup'                    => 'Benudsesregdes bearbeid',
'editinguser'                      => "Änd Benudsesregdes won dose '''[[{{ns:User}}:$1]]''' ([[User talk:$1|{{int:talkpagelinktext}}]] | [[{{#Special:Contributions}}/$1|{{int:contribslink}}]])",
'userrights-editusergroup'         => 'Benudses-Grubbessugehöriggeid bearbeid',
'saveusergroups'                   => 'Grubbessugehöriggeid änd',
'userrights-groupsmember'          => 'Midglied won:',
'userrights-groupsremovable'       => 'Grubbes won gön rausnehm:',
'userrights-groupsavailable'       => 'Grubbes wo werwügbares:',
'userrights-groups-help'           => 'Gön Grubbessugehöriggeid won dose Benuds änd:
* Wan dose Gäsd margärdes sei dose heis, das dose Benuds Midglied won dose Grubb sei
* Dose * heis, das dose Benudsesregd nag Erdeil noggs mehr gön surügnehm (od umgegehrdes).',
'userrights-reason'                => 'Grund:',
'userrights-available-none'        => 'Du noggs dörw Benudsesregdes weränd.',
'userrights-available-add'         => 'Gön Benudses {{PLURAL:$2|su wolgendes Grubb|su wolgendes $2 Grubbes}} dasugeb: $1.',
'userrights-available-remove'      => 'Gön Benudses aus {{PLURAL:$2|dose wolgendes Grubb|dose wolgendes $2 Grubbes}} rausnehm: $1.',
'userrights-available-add-self'    => 'Gön Dig selb su {{PLURAL:$2|dose Grubb|dose Grubbes}} dasugeb: $1.',
'userrights-available-remove-self' => 'Gön Dig selb aus {{PLURAL:$2|dose Grubb|dose Grubbes}} rausnehm: $1.',
'userrights-no-interwiki'          => 'Haddar noggs Beregd, das gön Benudsesregdes in anderes Wigis änd.',
'userrights-nodatabase'            => 'Dose Dadesbang $1 gar noggs geb od noggs logales.',
'userrights-nologin'               => 'Musdar mid eines Adminisdrad-Benudsesgond [[{{#special:Userlogin}}|anmeld]], das gön Benudsesregdes änd.',
'userrights-notallowed'            => 'Haddar noggs nödiges Beregdes, das gön Benudsesregdes wergeb.',
'userrights-changeable-col'        => 'Grubbessugehöriggeid, wo gön änd wan wol',
'userrights-unchangeable-col'      => 'Grubbessugehöriggeid, wo noggs gön änd',

# Groups
'group'               => 'Grubb:',
'group-user'          => 'Benudses',
'group-autoconfirmed' => 'Beschdädigdes Benudses',
'group-bot'           => 'Bods',
'group-sysop'         => 'Adminisdradores',
'group-bureaucrat'    => 'Bürogrades',
'group-suppress'      => 'Oversighter',
'group-all'           => '(ales)',

'group-user-member'          => 'Benuds',
'group-autoconfirmed-member' => 'Beschdädigdes Benuds',
'group-bot-member'           => 'Bod',
'group-sysop-member'         => 'Adminisdrad',
'group-bureaucrat-member'    => 'Bürograd',
'group-suppress-member'      => 'Oversighter',

'grouppage-user'          => '{{ns:project}}:Benudses',
'grouppage-autoconfirmed' => '{{ns:project}}:Beschdädigdes Benudses',
'grouppage-bot'           => '{{ns:project}}:Bods',
'grouppage-sysop'         => '{{ns:project}}:Adminisdradores',
'grouppage-bureaucrat'    => '{{ns:project}}:Bürogrades',
'grouppage-suppress'      => '{{ns:project}}:Oversighter',

# Rights
'right-read'                 => 'Seides les',
'right-edit'                 => 'Seides bearbeid',
'right-createpage'           => 'Seides erschdel (noggs Disgusionsseides)',
'right-createtalk'           => 'Disgusionsseides erschdel',
'right-createaccount'        => 'Benudsesgond erschdel',
'right-minoredit'            => 'Bearbeides als gleines margär',
'right-move'                 => 'Seides werschieb',
'right-move-subpages'        => 'Seides inglusiw Undseides werschieb',
'right-suppressredirect'     => 'Bei Werschieb dose Erschdel won eines Weidleid unddrügg',
'right-upload'               => 'Dadeies hoglad',
'right-reupload'             => 'Übschreib won worhandenes Dadei',
'right-reupload-own'         => 'Übschreib won eines Dadei wo haddar worher selb hoglad',
'right-reupload-shared'      => 'Logales Übschreib won eines in eines Rebosidorium worhandenes Dadei, wo gemeinsames nuds',
'right-upload_by_url'        => 'Hoglad won eines URL-Adres',
'right-purge'                => 'Seidesgedsch leer ohn Rüggwräg',
'right-autoconfirmed'        => 'Halbesgeschüdsdes Seides bearbeid',
'right-bot'                  => 'Behand als audomadisches Brodsess',
'right-nominornewtalk'       => 'Bei gleines Bearbeides an Disgusionsseides noggs dose „Neues Nagrigdes“-Anseig gom',
'right-apihighlimits'        => 'Höheres Beschränges in API-Abwräges',
'right-writeapi'             => 'Benuds won dose writeAPI',
'right-delete'               => 'Seides lösch',
'right-bigdelete'            => 'Seides lösch mid groses Wersionsgeschigd',
'right-deleterevision'       => 'Lösch und Wiedherschdel won einselnes Wersiones',
'right-deletedhistory'       => 'Anschauddar won gelöschdes Wersiones in dose Wersionsgeschigd (ohn dasugehördares Degsd)',
'right-browsearchive'        => 'Sug nag gelöschdes Seides',
'right-undelete'             => 'Seides wiedherschdel',
'right-suppressrevision'     => 'Anschauddar und Wiedherschel won Wersiones, wo aug Adminisdradores noggs gön seddar',
'right-suppressionlog'       => 'Anschauddar won briwades Logbüges',
'right-block'                => 'Benuds schber (Schreibregd)',
'right-blockemail'           => 'Benuds an Werschig won I-Mehls hind',
'right-hideuser'             => 'Schber und werberg won eines Benudsesnam',
'right-ipblock-exempt'       => 'Ausnahm won IB-Schberes, Audobloggs und Renschschberes',
'right-proxyunbannable'      => 'Ausnahm won audomadisches Brogsyschberes',
'right-protect'              => 'Seidesschuds-Schdadus änd',
'right-editprotected'        => 'Geschüdsdes Seides bearbeid (ohn Gasgadesschuds)',
'right-editinterface'        => 'Benudsesinderwejs bearbeid',
'right-editusercssjs'        => 'Bearbeid won wremdes CSS- und JS-Dadeies',
'right-rollback'             => 'Schneles surügseds',
'right-markbotedits'         => 'Schneles surüggesedsdes Bearbeides als Bod-Bearbeid margär',
'right-noratelimit'          => 'Noggs Beschräng durg Limids',
'right-import'               => 'Imbord won Seides aus anderes Wigis',
'right-importupload'         => 'Imbord won Seides üb Dadeihoglad',
'right-patrol'               => 'Margär wremdes Bearbeides als gondrolärdes',
'right-autopatrol'           => 'Margär eigenes Bearbeides audomadisches als gondrolärdes',
'right-patrolmarks'          => 'Anschauddar won Gondrolmargäres in dose ledsdes Ändes',
'right-unwatchedpages'       => 'Anschauddar won Lisd won noggsbeobagdedes Seides',
'right-trackback'            => 'Drägbäg übmidd',
'right-mergehistory'         => 'Wersionsgeschigdes won Seides wereinig',
'right-userrights'           => 'Benudsesregdes bearbeid',
'right-userrights-interwiki' => 'Benudsesregdes in anderes Wigis bearbeid',
'right-siteadmin'            => 'Dadesbang schber und endschber',

# User rights log
'rightslog'      => 'Regdes-Logbug',
'rightslogtext'  => 'Dose sei dose Logbug won Ändes won Benudsesregdes.',
'rightslogentry' => 'haddar Benudsesregdes änd wür „[[$1]]“ won „$2“ auw „$3“',
'rightsnone'     => '(-)',

# Recent changes
'nchanges'                          => '$1 {{PLURAL:$1|Änd|Ändes}}',
'recentchanges'                     => 'Ledsdes Ändes',
'recentchangestext'                 => "Auw dose Seid gön dose ledsdes Ändes auw dose '''{{SITENAME}}''' nagwerwolg.",
'recentchanges-feed-description'    => 'Werwolg mid dose Wied dose ledsdes Ändes in dose {{SITENAME}}.',
'rcnote'                            => "Anseigdar {{PLURAL:$1|'''1''' Änd|dose ledsdes '''$1''' Ändes}} {{PLURAL:$2|won ledsdes Dag|won ledsdes '''$2''' Däges}}. Schdand: $3. (<b><tt>Neues</tt></b>&nbsp;– neues Eindrag; <b><tt>K</tt></b>&nbsp;– gleines Änd; <b><tt>B</tt></b>&nbsp;– Änd won eines Bod; ''(± Sahl)''&nbsp;– Grösesänd in Baid)",
'rcnotefrom'                        => "Anseigdar dose Ändes seid '''$2''' (mags. '''$1''' Eindräges).",
'rclistfrom'                        => 'Nur Ändes seid $1 seig.',
'rcshowhideminor'                   => 'Gleines Ändes $1',
'rcshowhidebots'                    => 'Bods $1',
'rcshowhideliu'                     => 'Angemeldedes Benudses $1',
'rcshowhideanons'                   => 'Anonymes Benudses $1',
'rcshowhidepatr'                    => 'Gondrolärdes Ändes $1',
'rcshowhidemine'                    => 'Eigenes Beidräges $1',
'rclinks'                           => 'Seig dose ledsdes $1 Ändes won ledsdes $2 Däges.<br />$3',
'diff'                              => 'Undschied',
'hist'                              => 'Wersiones',
'hide'                              => 'ausblend',
'show'                              => 'einblend',
'minoreditletter'                   => 'G',
'newpageletter'                     => 'N',
'boteditletter'                     => 'B',
'number_of_watching_users_pageview' => '[$1 {{PLURAL:$1|Benuds|Benudses}} wo beobagd]',
'rc_categories'                     => 'Nur Seides aus dose Gadegoräes (gedrendes mid „|“):',
'rc_categories_any'                 => 'Ales',
'rc-change-size'                    => '$1 {{PLURAL:$1|Baid|Baids}}',
'newsectionsummary'                 => 'Neues Abschnid /* $1 */',

# Recent changes linked
'recentchangeslinked'          => 'Ändes an vergnübwdes Seides',
'recentchangeslinked-title'    => 'Ändes an Seides, wo won „$1“ wergnübwdes sei',
'recentchangeslinked-noresult' => 'In ausgewähldes Dseidraum haddar an dose wergnübwdes Seides noggs Ändes mag.',
'recentchangeslinked-summary'  => "Dose Schbesialseid dose ledsdes Ändes an dose wergnübwdes Seides auwlisd (bsw. bei Gadegoräes an dose Midgliedes won dose Gadegorä). Seides auw Deines [[Special:Watchlist|Beobagdlisd]] in '''weddes''' Schriwd sei.",
'recentchangeslinked-page'     => 'Seid:',
'recentchangeslinked-to'       => 'Seig Ändes auw Seides, wo su dose her wergnübw',

# Upload
'upload'                      => 'Hoglad',
'uploadbtn'                   => 'Dadei hoglad',
'reupload'                    => 'Abbreg',
'reuploaddesc'                => 'Abbreg und surüg su Hoglad-Seid',
'uploadnologin'               => 'Noggs angemeldedes',
'uploadnologintext'           => 'Musdar [[Special:Userlogin|angemeldedes sei]], das gön Dadeies hoglad.',
'upload_directory_missing'    => 'Dose Abloud-Werseig ($1) wehldar und haddar aug noggs gön erschdel durg dose Websörw.',
'upload_directory_read_only'  => 'Dose Websörw haddar noggs Schreibregdes wür dose Abloud-Werseig ($1).',
'uploaderror'                 => 'Wehl bei Hoglad',
'uploadtext'                  => "Geddar su dose [[{{#special:Imagelist}}|Lisd won hoggeladenes Dadeies]], das gön worhandenes Dadeies sug und anseig.

Benudsdar dose Wormular su neues Dadeies hoglad. Gliggdar auw '''„Durgsug …“''' su öw eines Dadeiauswähl-Dialog.
Nag Auswähl won eines Dadei dose Dadeinam in dose Degsdweld '''„Gueldadei“''' anseig.
Dan beschdäd dose Lisens-Wereinbar und nag dose gliggdar auw '''„Dadei hoglad“'''.
Dose gön geddar eines Weil, besond wan haddar langsames Inderned-Werbind.

Wan eines '''Bild''' wol in eines Seid reinschmeis, schreibdar an Schdel won Bild sum Beischb:
* '''<tt><nowiki>[[</nowiki>{{ns:image}}:Dadei.jpg<nowiki>]]</nowiki></tt>'''
* '''<tt><nowiki>[[</nowiki>{{ns:image}}:Dadei.jpg|Werweis-Degsd<nowiki>]]</nowiki></tt>'''

Wan '''Mediesdadeies''' wol reinschmeis, schreibdar sum Beischb:
* '''<tt><nowiki>[[</nowiki>{{ns:media}}:Dadei.ogg<nowiki>]]</nowiki></tt>'''
* '''<tt><nowiki>[[</nowiki>{{ns:media}}:Dadei.ogg|Werweis-Degsd<nowiki>]]</nowiki></tt>'''

Bid beagd das, wie bei normales Seidesinhaldes aug, anderes Benudses gön lösch od weränd Deines Dadeies.",
'upload-permitted'            => 'Erlaubdes Dadeidybes: $1.',
'upload-preferred'            => 'Beworsugdes Dadeidybes: $1.',
'upload-prohibited'           => 'Noggs erlaubdes Dadeidybes: $1.',
'uploadlog'                   => 'Dadei-Logbug',
'uploadlogpage'               => 'Dadei-Logbug',
'uploadlogpagetext'           => 'Dose dose Logbug won hoggeladenes Dadeies sei, seddar aug [[{{ns:special}}:Newimages]].',
'filename'                    => 'Dadeinam',
'filedesc'                    => 'Beschreib',
'fileuploadsummary'           => 'Beschreib/Guel:',
'filestatus'                  => 'Gobyraid-Schdadus:',
'filesource'                  => 'Guel:',
'uploadedfiles'               => 'Hoggeladenes Dadeies',
'ignorewarning'               => 'Warn ignorär und Dadei schbeig',
'ignorewarnings'              => 'Warnes ignorär',
'minlength1'                  => 'Dadeinämes musdar haddar mind eines Bugschdab.',
'illegalfilename'             => 'Dose Dadeinam „$1“ haddar mind eines Seig wo noggs erlaubdes sei. Bid dose Dadei anderes Nam geb und brobär nogmal hoglad.',
'badfilename'                 => 'Dose Dadeinam haddar änd in „$1“.',
'filetype-badmime'            => 'Dadeies mid dose MIME-Dyb „$1“ noggs dörw hoglad.',
'filetype-unwanted-type'      => "'''„.$1“''' eines noggserwünschdes Dadeiwormad sei. Erlaubdes sei: $2.",
'filetype-banned-type'        => "'''„.$1“''' eines noggserlaubdes Dadeiwormad sei. Erlaubdes sei: $2.",
'filetype-missing'            => 'Dose Dadei wo wol hoglad haddar noggs Erweid (s.B. „.jpg“).',
'large-file'                  => 'Bes wan dose Dadeigrös noggs gröseres wie $1 sei. Dose Dadei $2 groses sei.',
'largefileserver'             => 'Dose Dadei sei gröseres wie dose Magsimalgrös wo auw Sörw eingeschdeldes sei.',
'emptyfile'                   => 'Dose Dadei wo wol hoglad leeres sei. Grund gön sei eines Dibbwehl in Dadeinam. Bid gondrolär, ob wol werg hoglad dose Dadei.',
'fileexists'                  => 'Gebdar schon eines Dadei mid dose Nam. Wan auw „Dadei schbeig“ gligg, dose Dadei übschreib. Bid brüw <strong><tt>$1</tt></strong>, wan noggs sock sei.',
'filepageexists'              => 'Haddar schon eines Beschreibseid als <strong><tt>$1</tt></strong> erschdel, gebdar aba noggs Dadei mid dose Nam. Dose Beschreib wo eingeb noggs übnehm auw dose Beschreibseid. Musdar dose Beschreibseid nag Hoglad won Dadei nog manueles bearbeid.',
'fileexists-extension'        => 'Gebdar schon eines Dadei mid ähnliges Nam:<br />
Nam won Dadei wo wol hoglad: <strong><tt>$1</tt></strong><br />
Nam won worhandenes Dadei: <strong><tt>$2</tt></strong><br />
Nur dose Dadeiend in Groses/Gleinesschreib undscheid. Bid brüw, ob dose Dadeies inhaldliges idendisches sei.',
'fileexists-thumb'            => "<center>'''Worhandenes Dadei'''</center>",
'fileexists-thumbnail-yes'    => 'Dose Dadei anschein eines Bild sei wo haddar werglein <i>(thumbnail)</i>. Bid brüw dose Dadei <strong><tt>$1</tt></strong>.<br />
Wan dose Bild in Originalgrös sei, braugdar noggs seberades Worschaubild hoglad.',
'file-thumbnail-no'           => 'Dose Dadeinam mid <strong><tt>$1</tt></strong> anwäng. Dose sei Hinweis auw eines Bild wo haddar werglein <i>(thumbnail)</i>.
Bid brüw, ob haddar dose Bild in woles Auwlös und lad dose mid dose Originalnam hog.',
'fileexists-forbidden'        => 'Mid dose Nam schon eines Dadei geb. Bid surüg geddar und dose Dadei mid anderes Nam hoglad. [[Image:$1|thumb|center|$1]]',
'fileexists-shared-forbidden' => 'Mid dose Nam schon eines Dadei geb. Bid surüg geddar und dose Dadei mid anderes Nam hoglad. [[Image:$1|thumb|center|$1]]',
'file-exists-duplicate'       => 'Dose Dadei eines Dubligad sei won dose wolgendes {{PLURAL:$1|Dadei|$1 Dadeies}}:',
'successfulupload'            => 'Haddar erwolgreiges hoglad',
'uploadwarning'               => 'Warn',
'savefile'                    => 'Dadei schbeig',
'uploadedimage'               => 'haddar „[[$1]]“ hoglad',
'overwroteimage'              => 'haddar eines neues Wersion won „[[$1]]“ hoglad',
'uploaddisabled'              => 'Endschuld, dose Hoglad deagdiwärdes sei.',
'uploaddisabledtext'          => 'Dose Hoglad won Dadeies in dose {{SITENAME}} deagdiwärdes sei.',
'uploadscripted'              => 'Dose Dadei haddar HDML- od Sgribdgod drin, wo eines Nedsbraus gön aus Werseddar auswühr.',
'uploadcorrupt'               => 'Dose Dadei gabuddes sei od haddar walsches Dadei-Erweid. Bid übbrüw dose Dadei und wiedhöl dose Hoglad-Worgang.',
'uploadvirus'                 => 'In dose Dadei eines Wirus drin sei! Dedailes: $1',
'sourcefilename'              => 'Gueldadei:',
'destfilename'                => 'Sielnam:',
'upload-maxfilesize'          => 'Magsimales Dadeigrös: $1',
'watchthisupload'             => 'Dose Seid beobagd',
'filewasdeleted'              => 'Haddar schonmal eines Dadei mid dose Nam hoglad und swischdseidliges wied lösch. Bid suersd dose Eindrag in dose $1 brüw, bewor dose Dadei werg schbeig.',
'upload-wasdeleted'           => "'''Obagd: Du eines Dadei hoglad, wo haddar wrüheres schon lösch.'''

Bid genaues brüw, ob dose nogmales Hoglad dose Rigdlines endsbreg.
Wür Deines Inwormasion jedsd dose Lösch-Logbug gom mid dose Begründ wies dose haddar worher lösch:",
'filename-bad-prefix'         => 'Dose Dadeinam mid <strong>„$1“</strong> anwäng. Dose in algemeines dose won eines Digidalgamera worgegebenes Dadeinam sei und drum noggs grad aussaggräwdiges sei.
Bid dose Dadei eines Nam geb, wo dose Inhald beseres beschreibdar.',

'upload-proto-error'      => 'Walsches Brodogol',
'upload-proto-error-text' => 'Dose URL musdar mid <code>http://</code> od <code>ftp://</code> anwäng.',
'upload-file-error'       => 'Indernes Wehl',
'upload-file-error-text'  => 'Bei dose Erschdel won eines demboräres Dadei auw dose Sörw haddar eines indernes Wehl geb. Bid eines Sysdem-Adminisdrad inwormär.',
'upload-misc-error'       => 'Noggsbegandes Wehl bei Hoglad',
'upload-misc-error-text'  => 'Bei Hoglad haddar eines noggsbegandes Wehl geb. Bid brüw dose URL auw Wehles, dose Onlain-Schdadus won Seid und nogmal brobär. Wan dose Broblem dan imm nog sei, bid eines Sysdem-Adminisdrad inwormär.',

# Some likely curl errors. More could be added from <http://curl.haxx.se/libcurl/c/libcurl-errors.html>
'upload-curl-error6'       => 'URL noggs erreigbares sei',
'upload-curl-error6-text'  => 'Dose URL wo haddar angeb noggs erreigbares sei. Brüw dose URL auw Wehles und aug dose Onlain-Schdadus won Seid.',
'upload-curl-error28'      => 'Dseidübschreid bei Hoglad',
'upload-curl-error28-text' => 'Dose Seid braugdar su langes wür eines Andword. Brüw ob dose Seid onlain sei, eines Momend ward und dan nogmal brobär. Gön sinwoles sei, wan su anderes Dseidbungd nogmal brobär.',

'license'            => 'Lisens:',
'nolicense'          => 'noggs Worauswähl',
'license-nopreview'  => '(noggs Worschau werwügbar sei)',
'upload_source_url'  => ' (güldiges, öwendlig sugängliges URL)',
'upload_source_file' => ' (eines Dadei auw Deines Gombjud)',

# Special:Imagelist
'imagelist-summary'     => 'Auw dose Schbesialseid ales Dadeies seddar wo haddar hoglad. Schdandardmäs dose Dadeies suersd seddar wo haddar suledsdes hoglad. Wan auw dose Schbaldesübschriwdes gligg gön dose Sordär umdreh od gön nag eines anderes Schbald sordär.',
'imagelist_search_for'  => 'Sug nag Dadei:',
'imgfile'               => 'Dadei',
'imagelist'             => 'Dadeilisd',
'imagelist_date'        => 'Dadum',
'imagelist_name'        => 'Nam',
'imagelist_user'        => 'Benuds',
'imagelist_size'        => 'Grös',
'imagelist_description' => 'Beschreib',

# Image description page
'filehist'                       => 'Dadeiwersiones',
'filehist-help'                  => 'Gliggdar auw eines Dseidbungd, das lad dose Wersion.',
'filehist-deleteall'             => 'Ales Wersiones lösch',
'filehist-deleteone'             => 'Dose Wersion lösch',
'filehist-revert'                => 'surügseds',
'filehist-current'               => 'agdueles',
'filehist-datetime'              => 'Wersion won',
'filehist-user'                  => 'Benuds',
'filehist-dimensions'            => 'Abmeses',
'filehist-filesize'              => 'Dadeigrös',
'filehist-comment'               => 'Gomendar',
'imagelinks'                     => 'Werwend',
'linkstoimage'                   => 'Dose {{PLURAL:$1|wolgendes Seid|wolgendes $1 Seides}} dose Dadei werwend:',
'nolinkstoimage'                 => 'Noggs Seid dose Dadei benudsdar.',
'morelinkstoimage'               => '[[Special:Whatlinkshere/$1|Weideres Werweises]] wür dose Dadei.',
'redirectstofile'                => 'Dose {{PLURAL:$1|wolgendes Dadei|wolgendes $1 Dadeies}} auw dose Dadei weidleid:',
'duplicatesoffile'               => 'Dose {{PLURAL:$1|wolgendes Dadei eines Dubligad|wolgendes $1 Dadeies Dubligades}} won dose Dadei sei:',
'sharedupload'                   => 'Dose Dadei eines gemeinsames genudsdes Abloud sei, anderes Brojegdes gön werwend dose.',
'shareduploadwiki'               => 'Wür weideres Inwormasiones seddar dose $1.',
'shareduploadwiki-desc'          => 'Jedsd dose Inhald gom won dose $1 aus dose gemeinsames benudsdes Rebosidorium.',
'shareduploadwiki-linktext'      => 'Dadei-Beschreibseid',
'shareduploadduplicate'          => 'Dose Dadei eines Dubligad $1 aus dose gemeinsames genudsdes Rebosidorium sei.',
'shareduploadduplicate-linktext' => 'won dose anderes Dadei',
'shareduploadconflict'           => 'Dose Dadei haddar gleiges Nam wie $1 aus dose gemeinsames genudsdes Rebosidorium.',
'shareduploadconflict-linktext'  => 'dose anderes Dadei',
'noimage'                        => 'Gebdar gar noggs Dadei mid dose Nam, gön dose aba $1.',
'noimage-linktext'               => 'hoglad',
'uploadnewversion-linktext'      => 'Eines neues Wersion won dose Dadei hoglad',
'imagepage-searchdupe'           => 'Sug nag Dadei-Dubligades',

# File reversion
'filerevert'                => 'Surügseds won „$1“',
'filerevert-legend'         => 'Dadei surügseds',
'filerevert-intro'          => '<span class="plainlinks">Du dose Dadei \'\'\'[[Media:$1|$1]]\'\'\' auw dose [$4 Wersion won $2, $3 Uhr] surügseds.</span>',
'filerevert-comment'        => 'Grund:',
'filerevert-defaultcomment' => 'haddar surügseds auw dose Wersion won $1, $2 Uhr',
'filerevert-submit'         => 'Surügseds',
'filerevert-success'        => '<span class="plainlinks">\'\'\'[[Media:$1|$1]]\'\'\' haddar auw dose [$4 Wersion won $2, $3 Uhr] surügseds.</span>',
'filerevert-badversion'     => 'Gebdar gar noggs Wersion won dose Dadei su dose Dseidbungd wo haddar angeb.',

# File deletion
'filedelete'                  => 'Lösch „$1“',
'filedelete-legend'           => 'Lösch Dadei',
'filedelete-intro'            => "Du dose Dadei '''„[[Media:$1|$1]]“''' lösch.",
'filedelete-intro-old'        => '<span class="plainlinks">Du won dose Dadei \'\'\'„[[Media:$1|$1]]“\'\'\' dose [$4 Wersion won $2, $3 Uhr] lösch.</span>',
'filedelete-comment'          => 'Grund:',
'filedelete-submit'           => 'Lösch',
'filedelete-success'          => "'''„$1“''' haddar lösch.",
'filedelete-success-old'      => '<span class="plainlinks">Won dose Dadei \'\'\'„[[Media:$1|$1]]“\'\'\' haddar dose Wersion $2, $3 Uhr lösch.</span>',
'filedelete-nofile'           => "'''„$1“''' auw dose {{SITENAME}} gar noggs geb.",
'filedelete-nofile-old'       => "Gebdar won '''„$1“''' noggs Wersion won $2, $3 Uhr.",
'filedelete-iscurrent'        => 'Du brobär su lösch dose agdueles Wersion won dose Dadei. Bid dose worher auw eines älderes Wersion surügseds.',
'filedelete-otherreason'      => 'Anderes/ergänsendes Grund:',
'filedelete-reason-otherlist' => 'Anderes Grund',
'filedelete-reason-dropdown'  => '
* Algemeines Löschgründes
** Urhebregdswerleds
** Dubligad',
'filedelete-edit-reasonlist'  => 'Löschgründes bearbeid',

# MIME search
'mimesearch'         => 'Sug nag MIME-Dyb',
'mimesearch-summary' => 'Auw dose Schbesialseid gön dose Dadeies nag dose MIME-Dyb wild. In dose Eingab musdar imm dose Medies- und Subdyb drin sei: <tt>image/jpeg</tt> (seddar Bildbeschreibseid).',
'mimetype'           => 'MIME-Dyb:',
'download'           => 'Rundlad',

# Unwatched pages
'unwatchedpages'         => 'Noggs beobagdedes Seides',
'unwatchedpages-summary' => 'Dose Schbesialseid ales Seides seig, wo noggs Benuds haddar auw eines Beobagdlisd.',

# List redirects
'listredirects'         => 'Weidleidlisd',
'listredirects-summary' => 'Dose Schbesialseid Weidleides auwlisd.',

# Unused templates
'unusedtemplates'         => 'Noggs benudsdes Worlages',
'unusedtemplates-summary' => 'Dose Seid ales Worlages auwlisd, wo noggs in anderes Seides eingebundenes sei. Übbrüw anderes Werweises su dose Worlages, bewor dose lösch.',
'unusedtemplatestext'     => '',
'unusedtemplateswlh'      => 'Anderes Werweises',

# Random page
'randompage'         => 'Suwäliges Seid',
'randompage-nopages' => 'In dose Namesraum gebdar gar noggs Seides.',

# Random redirect
'randomredirect'         => 'Suwäliges Weidleid',
'randomredirect-nopages' => 'In dose Namesraum gebdar gar noggs Weidleides.',

# Statistics
'statistics'             => 'Schdadisdig',
'sitestats'              => 'Seidesschdadisdig',
'userstats'              => 'Benudsesschdadisdig',
'sitestatstext'          => "Gebdar insgesamdes '''$1''' {{PLURAL:$1|Seid|Seides}} in dose Dadesbang.
Bei dose Disgusionsseides, Seides üb dose {{SITENAME}}, gleines Seides, Weidleides und anderes Seides dabei sei,
wo ewenduel gar noggs gön bewerd als Seides.

Won dose mal abseddar, gebdar '''$2''' {{PLURAL:$2|Seid|Seides}}, wo gön als Seid bewerd.

Insgesamdes {{PLURAL:$8|haddar '''1''' Dadei|haddar '''$8''' Dadeies}} hoglad.

Insgesamdes haddar geb '''$3''' {{PLURAL:$3|Seidesabruw|Seidesabruwes}} und '''$4''' {{PLURAL:$4|Seidesbearbeid|Seidesbearbeides}} seid dose {{SITENAME}} haddar einrigd.
Aus dose ergebdar '''$5''' Bearbeides bro Seid und '''$6''' Seidesabruwes bro Bearbeid.

Läng won dose [http://www.mediawiki.org/wiki/Manual:Job_queue „Job queue“]: '''$7'''",
'userstatstext'          => "Gebdar '''$1''' {{PLURAL:$1|regisdrärdes|regisdrärdes}} [[Special:Listusers|Benudses]].
Won dose {{PLURAL:$2|haddar|haddar}} '''$2''' Benudses (=$4 %) $5-Regdes.",
'statistics-mostpopular' => 'Meisdes besugdes Seides',

'disambiguations'      => 'Begriwsglärseides',
'disambiguationspage'  => 'Template:Begriwsglär',
'disambiguations-text' => 'Dose wolgendes Seides auw eines Seid su Begriwsglär werweis. Schdadd dose sol dose auw dose Seid wo eig mein werweis.<br />Eines Seid als Begriwsglärseid behand, wan [[MediaWiki:Disambiguationspage]] auw dose werweis.<br />Werweises aus Namesräumes noggs auw dose auwlisd.',

'doubleredirects'         => 'Dobbeldes Weidleides',
'doubleredirects-summary' => 'In dose Lisd seddar Weidleides, wo auw eines weideres Weidleid werweis.
In jedes Dseil Werweises sei su dose ersdes und suaides Weidleid und dose Siel won dose suaides Weidleid, wo normales dose gewünschdes Sielseid sei,
wo aba schon dose ersdes Weidleid sol drauwseig, werschdeddar?.',
'doubleredirectstext'     => '',

'brokenredirects'         => 'Gabuddes Weidleides',
'brokenredirects-summary' => 'Dose Schbesialseid Weidleides auw Seides wo gar noggs geb auwlisd.',
'brokenredirectstext'     => '',
'brokenredirects-edit'    => '(bearbeid)',
'brokenredirects-delete'  => '(lösch)',

'withoutinterwiki'         => 'Seides ohn Werweises su anderes Sbrages',
'withoutinterwiki-summary' => 'Dose wolgendes Seides noggs auw anderes Sbragwersiones werweis.',
'withoutinterwiki-legend'  => 'Bräwigs',
'withoutinterwiki-submit'  => 'Seig',

'fewestrevisions'         => 'Seides mid wenigsdes Wersiones',
'fewestrevisions-summary' => 'Dose Schbesialseid dose Seides mid wenigsdes Bearbeides auwlisd.',

# Miscellaneous special pages
'nbytes'                          => '$1 {{PLURAL:$1|Baid|Baids}}',
'ncategories'                     => '$1 {{PLURAL:$1|Gadegorä|Gadegoräes}}',
'nlinks'                          => '{{PLURAL:$1|1 Werweis|$1 Werweises}}',
'nmembers'                        => '{{PLURAL:$1|1 Eindrag|$1 Eindräges}}',
'nrevisions'                      => '{{PLURAL:$1|1 Bearbeid|$1 Bearbeides}}',
'nviews'                          => '{{PLURAL:$1|1 Abwräg|$1 Abwräges}}',
'specialpage-empty'               => 'Dose Seid haddar agdueles noggs Eindräges.',
'lonelypages'                     => 'Werwaisdes Seides',
'lonelypages-summary'             => 'Dose Schbesialseid Seides seig, auw dose noggs anderes Seides werweis. Dose werwaisdes Seides drum noggs erwünschdes od wileigd wragwürdiges sei, weil dose nie üb dose normales Nawigasion durg dose {{SITENAME}} gön auwruw. ',
'lonelypagestext'                 => '',
'uncategorizedpages'              => 'Noggs gadegorisärdes Seides',
'uncategorizedpages-summary'      => 'Dose Schbesialseid ales Seides seig, wo haddar nog su noggs Gadegorä suweis.',
'uncategorizedcategories'         => 'Noggs gadegorisärdes Gadegoräes',
'uncategorizedcategories-summary' => 'Dose Schbesialseid ales Gadegoräes seig, wo haddar selb nog su noggs Gadegorä suweis.',
'uncategorizedimages'             => 'Noggs gadegorisärdes Dadeies',
'uncategorizedimages-summary'     => 'Dose Schbesialseid ales Dadeies seig, wo haddar noggs in Gadegorä einord.',
'uncategorizedtemplates'          => 'Noggs gadegorisärdes Worlages',
'uncategorizedtemplates-summary'  => 'Dose Schbesialseid ales Worlages seig, wo haddar noggs in Gadegorä einord.',
'unusedcategories'                => 'Noggsbenudsdes Gadegoräes',
'unusedimages'                    => 'Noggsbenudsdes Dadeies',
'popularpages'                    => 'Beliebdesdes Seides',
'wantedcategories'                => 'Benudsdes, aba noggs angelegdes Gadegoräres',
'wantedcategories-summary'        => 'Dose Schbesialseid Gadegoräes auwlisd, wo in Seides werwend, wo haddar aba noggs als Gadegorä anleg.',
'wantedpages'                     => 'Gewünschdes Seides',
'wantedpages-summary'             => 'Dose Schbesialseid ales Seides auwlisd, wo nog noggs gebdar, auw dose aba anderes Seides wo geb werweis.',
'missingfiles'                    => 'Dadeies wo wehldar',
'missingfiles-summary'            => 'Dose Schbesialseid ales Dadeies auwlisd, wo auw Seides wergnübwdes sei, aba gar noggs gebdar.',
'mostlinked'                      => 'Häuwig wergnübwdes Seides',
'mostlinked-summary'              => 'Dose Schbesialseid unabhängiges won Namesraum ales Seides seig, wo besond häuwiges vergnübwdes sei.',
'mostlinkedcategories'            => 'Meisdbenudsdes Gadegoräes',
'mostlinkedcategories-summary'    => 'Dose Schbesialseid eines Lisd won meisdbenudsdes Gadegoräes seig.',
'mostlinkedtemplates'             => 'Meisdbenudsdes Worlages',
'mostlinkedtemplates-summary'     => 'Dose Schbesialseid eines Lisd won meisdbenudsdes Worlages seig.',
'mostcategories'                  => 'Meisdgadegorisärdes Seides',
'mostcategories-summary'          => 'Dose Schbesialseid besond häuwiges gadegorisärdes Seides anseig.',
'mostimages'                      => 'Meisdbenudsdes Dadeies',
'mostimages-summary'              => 'Dose Schbesialseid eines Lisd won meisdbenudsdes Dadeies seig.',
'mostrevisions'                   => 'Seides mid meisdes Wersiones',
'mostrevisions-summary'           => 'Dose Schbesialseid eines Lisd won Seides mid meisdes Bearbeides seig.',
'prefixindex'                     => 'Ales Seides (mit Bräwigs)',
'prefixindex-summary'             => 'Dose Schbesialseid ales Seides seig, wo mid dose Seigeswolg („Bräwigs“) anwäng wo haddar eingeb. Dose Ausgab gön auw eines Namesraum einschräng.',
'shortpages'                      => 'Gurses Seides',
'shortpages-summary'              => 'Dose Lisd dose gürsesdes Seides in Haubdnamesraum anseig. Sähldar dose Seiges won Degsd wie dose in Bearbeidwensd seddar, als in Wigi-Syndags und ohn dose Inhaldes won eingebundenes Worlages. Grundlag won dose Sähl dose UTF-8-godärdes Degsd sei, nag dose sum Beischb deudsches Umlaudes wie suai Seiges geld.',
'longpages'                       => 'Langes Seides',
'longpages-summary'               => 'Dose Lisd dose längsdes Seides in Haubdnamesraum anseig. Sähldar dose Seiges won Degsd wie dose in Bearbeidwensd seddar, als in Wigi-Syndags und ohn dose Inhaldes won eingebundenes Worlages. Grundlag won dose Sähl dose UTF-8-godärdes Degsd sei, nag dose sum Beischb deudsches Umlaudes wie suai Seiges geld.',
'deadendpages'                    => 'Sagggassesseides',
'deadendpages-summary'            => 'Dose Schbesialseid eines Lisd won Seides seig, wo hadddar noggs Werweises auw anderes Seides od haddar nur Werweises auw Seides wo nog gar noggs geb.',
'deadendpagestext'                => '',
'protectedpages'                  => 'Geschüdsdes Seides',
'protectedpages-indef'            => 'Nur noggsbeschrängdes geschüdsdes Seides seig',
'protectedpages-summary'          => 'Dose Schbesialseid ales Seides seig, wo wor Werschieb od Bearbeid geschüdsdes sei.',
'protectedpagestext'              => '',
'protectedpagesempty'             => 'Agdueles noggs Seides mid dose Baramedes geschüdsdes sei.',
'protectedtitles'                 => 'Geschberdes Dides',
'protectedtitles-summary'         => 'Dose wolgendes Dides haddar wür Neuerschdel schber.',
'protectedtitlestext'             => '',
'protectedtitlesempty'            => 'Momendanes mid dose Baramedes wo haddar angeb gar noggs Seides geb wo haddar wür Neuerschel schber.',
'listusers'                       => 'Benudseswerseig',
'listusers-summary'               => "Dose Schbesialseid ales regisdrärdes Benudses auwlisd; dose Gesamdsähl gön [[Special:Statistics|da]] seddar. Üb dose Auswählweld ''Grubb'' gön dose Anwräg auw beschdämdes Benudsesgrubbes einschräng.",
'newpages'                        => 'Neues Seides',
'newpages-summary'                => 'Dose Schbesialseid ales Seides auwlisd wo haddar in ledsdes Däges neues erschdel. Dose Ausgab gön auw eines Namesraum und/od Benudsesnam einschräng.',
'newpages-username'               => 'Benudsesnam:',
'ancientpages'                    => 'Seides wo haddar schon längeres noggs mehr bearbeid',
'ancientpages-summary'            => 'Dose Schbesialseid dose Seides auwlisd, wo haddar längsdes noggs mehr änd.',
'move'                            => 'Werschieb',
'movethispage'                    => 'Seid werschieb',
'unusedimagestext'                => 'Bid beagd, das anderes Nedsseides gön dose Dadei mid eines diregdes URL wergnübw. Dose noggs als Werwend ergen, drum dose Dadei da auwwühr.',
'unusedcategoriestext'            => 'Dose Schbesialseid ales Gadegoräes seig wo leeres sei, wo haddar selb noggs Gadegoräes od Seides drin.',
'notargettitle'                   => 'Haddar gar noggs Seid angeb',
'notargettext'                    => 'Haddar gar noggs angeb, auw welges Seid dose Wungsion sol anwend.',
'nopagetitle'                     => 'Sielseid gar noggs geb',
'nopagetext'                      => 'Dose Sielseid wo haddar angeb gar noggs geb.',
'pager-newer-n'                   => '{{PLURAL:$1|nägsdes|nägsdes $1}}',
'pager-older-n'                   => '{{PLURAL:$1|woriges|woriges $1}}',
'suppress'                        => 'Oversight',

# Book sources
'booksources'               => 'ISBN-Sug',
'booksources-summary'       => 'Auw dose Schbesialseid gön eines ISBN eingeb, dan griegdar eines Lisd mid Onlain-Gadalöges und hald wo Büges gön gauw su dose ISBN. Dose Bindschdriges od Leerseiges swisch dose Dsähles wür dose Sug noggs Rol schbäl.',
'booksources-search-legend' => 'Sug nag Besugsgueles wür Büges',
'booksources-go'            => 'Sug',
'booksources-text'          => 'Dose eines Lisd sei mid Werweises su Nedsseides, wo neues und gebraugdes Büges wergauw. Bei dose gön aug wend mehres Inwormasiones üb dose Büges. Dose {{SITENAME}} haddar mid noggs won dose Anbiedes geschäwdliges su duddar.',

# Special:Log
'specialloguserlabel'  => 'Benuds:',
'speciallogtitlelabel' => 'Did:',
'log'                  => 'Logbüges',
'all-logs-page'        => 'Ales Logbüges',
'log-search-legend'    => 'Logbüges durgsug',
'log-search-submit'    => 'Sug',
'alllogstext'          => 'Dose eines gombinärdes Anseig won ales Logbüges sei ,wo in dose {{SITENAME}} wühr. Dose Ausgab gön durg Auswähl won dose Logbugdyb, dose Benuds od dose Seidesdid einschräng.',
'logempty'             => 'Noggs Eindräges wo basdar.',
'log-title-wildcard'   => 'Did anwäng mid …',

# Special:Allpages
'allpages'          => 'Ales Seides',
'allpages-summary'  => "Auw dose Schbesialseid ales Seides won dose {{SITENAME}} alwabedisches auwlisd. Bei dose Sordär suersd Sähles, dan Grosbugschdabes, Gleinbugschdabes und dan Sondseiges gom. ''A&nbsp;10'' wor dose ''AZ'' gom, dose ''Aal'' aba nag dose gom.",
'alphaindexline'    => '$1 bis $2',
'nextpage'          => 'Nägsdes Seid ($1)',
'prevpage'          => 'Woriges Seid ($1)',
'allpagesfrom'      => 'Seides anseig ab:',
'allarticles'       => 'Ales Seides',
'allinnamespace'    => 'Ales Seides (Namesraum: $1)',
'allnotinnamespace' => 'Ales Seides (noggs in dose $1 Namesraum)',
'allpagesprev'      => 'Woriges',
'allpagesnext'      => 'Nägsdes',
'allpagessubmit'    => 'Anwend',
'allpagesprefix'    => 'Seides anseig mid Bräwigs:',
'allpagesbadtitle'  => 'Dose Seidesnam wo haddar eingeb noggs güldiges sei: Endwed haddar worangeschdeldes Sbrag-, eines Inderwigi-Gürs od haddar eines od mehres Seiges, wo in Seidesnämes noggs dörw werwend.',
'allpages-bad-ns'   => 'Dose Namesraum „$1“ in dose {{SITENAME}} gar noggs geb.',

# Special:Categories
'categories'                    => 'Gadegoräes',
'categoriespagetext'            => 'Wolgendes Gadegoräes in dose {{SITENAME}} haddar Seides od Dadeies drin:',
'categoriesfrom'                => 'Seig Gadegoräes ab:',
'special-categories-sort-count' => 'Sordär nag Ansähl',
'special-categories-sort-abc'   => 'Sordär nag Alwabed',

# Special:Listusers
'listusersfrom'      => 'Seig Benudses ab:',
'listusers-submit'   => 'Seig',
'listusers-noresult' => 'Haddar noggs Benuds wend.',

# Special:Listgrouprights
'listgrouprights'          => 'Benudsesgrubbes-Regdes',
'listgrouprights-summary'  => 'Dose eines Lisd sei mid dose Benudsesgrubbes wo in dose Wigi haddar dewinär und dose Regdes wo dose haddar.
Susädsliges Inwormasiones üb einselnes Regdes gön [[{{MediaWiki:Listgrouprights-helppage}}|da]] seddar.',
'listgrouprights-group'    => 'Grubb',
'listgrouprights-rights'   => 'Regdes',
'listgrouprights-helppage' => 'Help:Grubbesregdes',
'listgrouprights-members'  => '(Midgliedeslisd)',

# E-mail user
'mailnologin'     => 'Wehl bei I-Mehl-Wersänd',
'mailnologintext' => 'Musdar [[{{#special:Userlogin}}|angemeldedes sei]] und eines [[{{#special:Confirmemail}}|beschdädigdes]] I-Mehl-Adres haddar, das gön anderes Benudses I-Mehls schig.',
'emailuser'       => 'I-Mehl an dose Benuds',
'emailpage'       => 'I-Mehl an Benudses',
'emailpagetext'   => 'Wan dose Benuds haddar güldiges I-Mehl-Adres angeb, gön dose mid dose undderes Wormular eines I-Mehl schig. Absend dose I-Mehl-Adres sei wo haddar in Einschdeles eindrag, das dose Benuds gön andword.',
'usermailererror' => 'Dose I-Mehl-Objegd haddar eines Wehl surüggeb:',
'defemailsubject' => '{{SITENAME}}-I-Mehl',
'noemailtitle'    => 'Noggs I-Mehl-Adres',
'noemailtext'     => 'Dose Benuds haddar noggs güldiges I-Mehl-Adres angeb od wol noggs I-Mehl won anderes Benudses embwäng.',
'emailfrom'       => 'Won',
'emailto'         => 'An',
'emailsubject'    => 'Bedrew',
'emailmessage'    => 'Nagrigd',
'emailsend'       => 'Schig',
'emailccme'       => 'Schig eines Gobä won dose I-Mehl an mig',
'emailccsubject'  => 'Gobä won Deines Nagrigd an $1: $2',
'emailsent'       => 'Haddar I-Mehl werschig',
'emailsenttext'   => 'Haddar Deines I-Mehl werschig.',

# Watchlist
'watchlist'            => 'Beobagdlisd',
'mywatchlist'          => 'Beobagdlisd',
'watchlistfor'         => "(wür '''$1''')",
'nowatchlist'          => 'Haddar noggs Eindräges auw Deines Beobagdlisd.',
'watchlistanontext'    => 'Musdar $1, das gön Deines Beobagdlisd seddar od Eindräges auw dose bearbeid.',
'watchnologin'         => 'Noggs angemeldedes sei',
'watchnologintext'     => 'Musdar [[Special:Userlogin|angemeldedes]] sei, das gön Deines Beobagdlisd bearbeid.',
'addedwatch'           => 'Haddar su Beobagdlisd dasugeb',
'addedwatchtext'       => 'Dose Seid „<nowiki>$1</nowiki>“ haddar su Deines [[Special:Watchlist|Beobagdlisd]] dasugeb.

Schbäderes Ändes an dose Seid und dose Disgusionsseid wo dasugehördar auw dose auwlisd und
in dose Übsigd won dose [[Special:Recentchanges|ledsdes Ändes]] in Weddesschriwd darschdel.

Wan wol dose Seid wied won Deines Beobagdlisd rausnehm, musdar auw dose jeweiliges Seid auw „noggs mehr beobagd“ gligg.',
'removedwatch'         => 'Haddar won Beobagdlisd rausnehm',
'removedwatchtext'     => 'Dose Seid „<nowiki>$1</nowiki>“ haddar won Deines Beobagdlisd rausnehm.',
'watch'                => 'Beobagd',
'watchthispage'        => 'Seid beobagd',
'unwatch'              => 'noggs mehr beobagd',
'unwatchthispage'      => 'Noggs mehr beobagd',
'notanarticle'         => 'Noggs Seid',
'notvisiblerev'        => 'Haddar Wersion lösch',
'watchnochange'        => 'Haddar noggs won Seides wo beobagd, in dose Dseidraum wo anseig bearbeid.',
'watchlist-details'    => 'Du {{PLURAL:$1|1 Seid|$1 Seides}} beobagd.',
'wlheader-enotif'      => '* Dose I-Mehl-Benagrigdigdiensd agdiwärdes sei.',
'wlheader-showupdated' => "* Seides wo haddar Ändes wo nog noggs seddar, in '''weddes''' Schriwd darschdel.",
'watchmethod-recent'   => 'Übbrüw won dose ledsdes Bearbeides wür dose Beobagdlisd',
'watchmethod-list'     => 'Übbrüw won dose Beobagdlisd nag ledsdes Bearbeides',
'watchlistcontains'    => 'Deines Beobagdlisd haddar $1 {{PLURAL:$1|Seid|Seides}} drin.',
'iteminvalidname'      => 'Broblem mid dose Eindrag „$1“, ungüldiges Nam.',
'wlnote'               => "Jedsd gom {{PLURAL:$1|dose ledsdes Änd|dose ledsdes '''$1''' Ändes}} won dose ledsdes {{PLURAL:$2|Schdund|'''$2''' Schdundes}}.",
'wlshowlast'           => 'Seig dose Ändes won ledsdes $1 Schdundes, $2 Däges od $3 (in dose ledsdes 30 Däges).',
'watchlist-show-bots'  => 'Bod-Ändes einblend',
'watchlist-hide-bots'  => 'Bod-Ändes ausblend',
'watchlist-show-own'   => 'eigenes Ändes einblend',
'watchlist-hide-own'   => 'eigenes Ändes ausblend',
'watchlist-show-minor' => 'gleines Ändes einblend',
'watchlist-hide-minor' => 'gleines Ändes ausblend',

# Displayed when you click the "watch" button and it is in the process of watching
'watching'   => 'Beobagd …',
'unwatching' => 'Noggs beobagd …',

'enotif_mailer'                => '{{SITENAME}} I-Mehl-Benagrigdigdiensd',
'enotif_reset'                 => 'Ales Seides als besugdes margär',
'enotif_newpagetext'           => 'Dose eines neues Seid sei.',
'enotif_impersonal_salutation' => '{{SITENAME}}-Benuds',
'changed'                      => 'geänderdes',
'created'                      => 'erseugdes',
'enotif_subject'               => '[{{SITENAME}}] Dose Seid "$PAGETITLE" haddar dose $PAGEEDITOR $CHANGEDORCREATED',
'enotif_lastvisited'           => 'Ales Ändes auw eines Bligg: $1',
'enotif_lastdiff'              => 'Seddar $1 wür dose Änd.',
'enotif_anon_editor'           => 'Anonymes Benuds $1',
'enotif_body'                  => 'Liebes $WATCHINGUSERNAME,

dose {{SITENAME}}-Seid "$PAGETITLE" haddar dose $PAGEEDITOR an $PAGEEDITDATE $CHANGEDORCREATED.

Agdueles Wersion: $PAGETITLE_URL

$NEWPAGE

Susamwas won dose Bearbeid: $PAGESUMMARY $PAGEMINOREDIT

Gondagd su dose Bearbeid:
I-Mehl: $PAGEEDITOR_EMAIL
Wigi: $PAGEEDITOR_WIKI

Duddar solanges noggs mehr weideres Benagrigdigmehl schig, bis haddar dose Seid wied besug. Auw Deines Beobagdlisd gön ales Benagrigdigsmargäres susam surügseds.

             Deines wreundliges {{SITENAME}} Benagrigdigsysdem

--
Wan wol dose Einschdeles won Deines Beobagdlisd anbas, geddar auw: {{fullurl:Special:Watchlist/edit}}',

# Delete/protect/revert
'deletepage'                  => 'Seid lösch',
'confirm'                     => 'Beschdäd',
'excontent'                   => "Aldes Inhald: '$1'",
'excontentauthor'             => "Inhald wesdar: '$1' (einsiges Bearbeid: [[{{ns:User}}:$2|$2]] – [[{{ns:User talk}}:$2|Disgusion]])",
'exbeforeblank'               => "Inhald wor dose Leer won Seid: '$1'",
'exblank'                     => 'Seid leeres wesdar',
'delete-confirm'              => 'Lösch won „$1“',
'delete-legend'               => 'Lösch',
'historywarning'              => 'Obagd, dose Seid wo wol lösch, haddar eines Wersionsgeschigd:',
'confirmdeletetext'           => 'Du grad eines Seid lösch mid ales älderes Wersiones wo dasugehördar. Bid beschdäd, das sei dose Gonseguenses bewusdes, und das dose in Übeinschdäm mid dose [[{{MediaWiki:Policy-url}}|Rigdlines]] mag.',
'actioncomplete'              => 'Agsion beendedes',
'deletedtext'                 => '„<nowiki>$1</nowiki>“ haddar lösch. In $2 eines Lisd mid dose ledsdes Lösches wend.',
'deletedarticle'              => 'haddar „[[$1]]“ lösch',
'suppressedarticle'           => 'haddar dose Seddarbargeid won „[[$1]]“ weränd',
'dellogpage'                  => 'Lösch-Logbug',
'dellogpagetext'              => 'Dose dose Logbug sei won gelöschdes Seides und Dadeies.',
'deletionlog'                 => 'Lösch-Logbug',
'reverted'                    => 'Haddar auw eines aldes Wersion surügseds',
'deletecomment'               => 'Grund won Lösch:',
'deleteotherreason'           => 'Anderes/ergänsendes Grund:',
'deletereasonotherlist'       => 'Anderes Grund',
'deletereason-dropdown'       => '
* Algemeines Löschgründes
** Wunsch won dose Audor
** Urhebregdswerleds
** Wandalism',
'delete-edit-reasonlist'      => 'Löschgründes bearbeid',
'delete-toobig'               => 'Dose Seid mid mehres wie $1 Wersiones haddar bruddales langes Wersionsgeschigd. Dose Lösch won solges Seides haddar einschräg, das noggs aus Werseddar dose Sörw üblasd.',
'delete-warning-toobig'       => 'Dose Seid mid mehres wie $1 Wersiones haddar bruddales langes Wersionsgeschigd. Dose Lösch gön mag das haddar Schdöres in dose Dadesbangbedrieb.',
'rollback'                    => 'Surügseds won dose Ändes',
'rollback_short'              => 'Surügseds',
'rollbacklink'                => 'Surügseds',
'rollbackfailed'              => 'Surügseds daneb geddar',
'cantrollback'                => 'Dose Änd noggs gön surügseds, weil gebdar noggs wrüheres Audores.',
'alreadyrolled'               => "Dose Surügseds won dose Ändes won dose [[{{ns:user}}:$2|$2]] <span style='font-size: smaller'>([[{{ns:user talk}}:$2|Disgusion]], [[{{#special:Contributions}}/$2|Beidräges]])</span> an Seid [[:$1]] noggs erwolgreiges wesdar, weil in Swischdseid schon eines anderes Benuds
haddar Ändes an dose Seid mag.<br />Dose ledsdes Änd gom won dose [[{{ns:user}}:$3|$3]] <span style='font-size: smaller'>([[{{ns:user talk}}:$3|Disgusion]])</span>.",
'editcomment'                 => 'Dose Ändgomendar sei: „<i>$1</i>“.', # only shown if there is an edit comment
'revertpage'                  => 'Haddar Ändes won dose [[User:$2|$2]] ([[{{ns:special}}:Contributions/$2|Beidräges]]) rügggäng mag und ledsdes Wersion won dose $1 wiedherschdel', # Additional available: $3: revid of the revision reverted to, $4: timestamp of the revision reverted to, $5: revid of the revision reverted from, $6: timestamp of the revision reverted from
'rollback-success'            => 'Haddar Ändes won dose $1 rügggäng mag und dose ledsdes Wersion won dose $2 wiedherschdel.',
'sessionfailure'              => 'Haddar eines Broblem geb mid Deines Benudsessids.
Haddar dose Agsion aus Sockheidsgründes abbreg, das gön werhind eines walsches Suord won deines Ändes su eines anderes Benuds.
Bid surüg geddar und nogmal brobär auswühr dose Worgang.',
'protectlogpage'              => 'Seidesschuds-Logbug',
'protectlogtext'              => 'Dose dose Seidesschuds-Logbug sei. Seddar dose [[{{ns:special}}:Protectedpages|Lisd won geschüdsdes Seides]] wür ales Seides wo agdueles geschüdsdes sei.',
'protectedarticle'            => 'haddar schüds „[[$1]]“',
'modifiedarticleprotection'   => 'haddar Schuds änd won „[[$1]]“',
'unprotectedarticle'          => 'haddar Schuds auwheb won „[[$1]]“',
'protect-title'               => 'Schuds änd won „$1“',
'protect-legend'              => 'Seidesschudsschdadus änd',
'protectcomment'              => 'Grund:',
'protectexpiry'               => 'Schberdau:',
'protect_expiry_invalid'      => 'Dose Dau wo haddar eingeb noggsgüldiges sei.',
'protect_expiry_old'          => 'Dose Schberdseid in Wergängheid liegdar.',
'protect-unchain'             => 'Werschiebschuds änd',
'protect-text'                => "Da gön dose Schudsschdadus won dose Seid '''<nowiki>$1</nowiki>''' einseddar und änd.",
'protect-locked-blocked'      => 'Du noggs gön änd dose Seidesschuds, weil Deines Benudsesgond geschberdes sei. Da haddar dose agdueles Seidesschuds-Einschdeles wür dose Seid <strong>„$1“:</strong>',
'protect-locked-dblock'       => 'Dose Dadesbang geschberdes sei, drum noggs gön änd dose Seidesschuds. Da haddar dose agdueles Seidesschuds-Einschdeles wür dose Seid <strong>„$1“:</strong>',
'protect-locked-access'       => 'Deines Benudsesgond haddar noggs nödiges Regdes das gön änd dose Seidesschuds. Da haddar dose agdueles Seidesschuds-Einschdeles wür dose Seid <strong>„$1“:</strong>',
'protect-cascadeon'           => 'Dose Seid momendanes Deil sei won eines Gasgadesschber. Dose sei in dose {{PLURAL:$1|wolgendes Seid|wolgendes Seides}} eingebundenes, wo durg dose Gasgadesschberobsion geschüdsdes {{PLURAL:$1|sei|sei}}. Dose Seidesschudsschdadus wür dose Seid schon gön änd, dose haddar aba noggs Einwlus auw dose Gasgadesschber:',
'protect-default'             => 'Ales (Schdandard)',
'protect-fallback'            => 'Braugdar dose „$1“-Beregd.',
'protect-level-autoconfirmed' => 'Schber wür noggs regisdrärdes Benudses',
'protect-level-sysop'         => 'Nur Adminisdradores',
'protect-summary-cascade'     => 'gasgadärendes',
'protect-expiring'            => 'bis $1 (UTC)',
'protect-cascade'             => 'Gasgadärendes Schber – ales Worlages wo in dose Seid eingebundenes sei, aug geschberdes sei.',
'protect-cantedit'            => 'Du noggs gön änd dose Schber won dose Seid, weil haddar noggs Beregd wür Bearbeid won dose Seid.',
'restriction-type'            => 'Schudsschdadus',
'restriction-level'           => 'Schudshöh',
'minimum-size'                => 'Mindgrös',
'maximum-size'                => 'Magsimalgrös:',
'pagesize'                    => '(Baids)',

# Restrictions (nouns)
'restriction-edit'   => 'Bearbeid',
'restriction-move'   => 'Werschieb',
'restriction-create' => 'Erschdel',
'restriction-upload' => 'Hoglad',

# Restriction levels
'restriction-level-sysop'         => 'geschüdsdes (nur Adminisdradores)',
'restriction-level-autoconfirmed' => 'geschüdsdes (nur angemeldedes, noggs-neues Benudses)',
'restriction-level-all'           => 'ales',

# Undelete
'undelete'                     => 'Gelöschdes Seid wiedherschdel',
'undeletepage'                 => 'Gelöschdes Seid wiedherschdel',
'undeletepagetitle'            => "'''Dose wolgendes Ausgab seigdar dose gelöschdes Wersiones won [[:$1|$1]]'''.",
'viewdeletedpage'              => 'Gelöschdes Seides anseig',
'undeletepagetext'             => 'Dose wolgendes Seides haddar lösch, Adminisdradores gön wiedherschdel dose:',
'undeleteextrahelp'            => '* Wan wol dose Seid gombleddes mid ales Wersiones wiedherschdel, bid eines Begründ angeb und auw „Wiedherschdel“ gligg.
* Wan wol nur beschdämdes Wersiones wiedherschdel, dose bid einselnes mid dose Margäres auswähl, eines Begründ angeb und dan auw „Wiedherschdel“ gligg.
* „Abbreg“ leerdar dose Gomendarweld und endwerndar ales Margäres bei dose Wersiones.',
'undeleterevisions'            => '{{PLURAL:$1|1 Wersion|$1 Wersiones}} argiwärdes',
'undeletehistory'              => 'Wan dose Seid wiedherschdel, aug ales aldes
Wersiones wiedherschel. Wan haddar seid dose Lösch eines neues Seid mid gleiges
Nam erschdel, dan dose Wersiones wo haddar wiedherschdel gronologisches in dose Wersionsgeschigd einord.
Seddarbargeides-Einschränges an Dadeiwersiones bei eines Wiedherschdel werlor geddar.',
'undeleterevdel'               => 'Dose Wiedherschdel noggs durgwühr, wan dose agduelsdes Wersion werschdegdes sei od haddar werschdegdes Deiles drin
.
In dose Wal dörw dose agduelsdes Wersion noggs margär od musdar dose Schdadus won dose auw dose won eines normales Wersion änd.',
'undeletehistorynoadmin'       => 'Dose Seid haddar lösch. Dose Grund wür dose Lösch gön in dose Susamwas seddar,
genaues wie aug dose Dedailes su ledsdes Benuds, wo haddar dose Seid wor dose Lösch bearbeid.
Dose agdueles Degsd won dose gelöschdes Seid nur Adminisdradores gön seddar.',
'undelete-revision'            => 'Gelöschdes Wersion won $1 - $2, $3:',
'undeleterevision-missing'     => 'Noggsgüldiges od wehlendes Wersion. Endwed dose Werweis walsches sei od haddar dose Wersion aus dose Argiw wiedherschdel od haddar endwern.',
'undelete-nodiff'              => 'Noggs woriges Wersion gebdar.',
'undeletebtn'                  => 'Wiedherschdel',
'undeletelink'                 => 'wiedherschdel',
'undeletereset'                => 'Abbreg',
'undeletecomment'              => 'Begründ:',
'undeletedarticle'             => 'haddar „[[$1]]“ wiedherschdel',
'undeletedrevisions'           => '{{PLURAL:$1|1 Wersion haddar|$1 Wersiones haddar}} wiedherschdel',
'undeletedrevisions-files'     => '{{PLURAL:$1|1 Wersion|$1 Wersiones}} und {{PLURAL:$2|1 Dadei|$2 Dadeies}} haddar wiedherschdel',
'undeletedfiles'               => '{{PLURAL:$1|1 Dadei haddar|$1 Dadeies haddar}} wiedherschel',
'cannotundelete'               => 'Wiedherschdel daneb geddar; haddar schon jem anderes dose Seid wiedherschdel.',
'undeletedpage'                => "'''$1''' haddar wiedherschdel.

In dose [[Special:Log/delete|Lösch-Logbug]] haddar eines Übsigd won dose Seides wo haddar lösch und wiedherschdel.",
'undelete-header'              => 'Seddar dose [[{{ns:special}}:Log/delete|Lösch-Logbug]] wür gürsliges gelöschdes Seides.',
'undelete-search-box'          => 'Sug nag gelöschdes Seides',
'undelete-search-prefix'       => 'Sugbegriw (Wordanwäng ohn Waildgards):',
'undelete-search-submit'       => 'Sug',
'undelete-no-results'          => 'Haddar in Argiw noggs Seides wend wo su dose Sugbegriw basdar.',
'undelete-filename-mismatch'   => 'Dose Dadeiwersion mid dose Dseidschdemb $1 haddar noggs gön wiedherschel: Dose Dadeinämes noggs susambas.',
'undelete-bad-store-key'       => 'Dose Dadeiwersion mid dose Dseidschdemb $1 haddar noggs gön wiedherschel: Dose Dadei schon wor Lösch haddar noggs mehr geb.',
'undelete-cleanup-error'       => 'Wehl bei Lösch won dose noggsbenudsdes Argiw-Wersion $1.',
'undelete-missing-filearchive' => 'Dose Dadei mid dose Argiw-ID $1 noggs gön wiedherschdel, weil dose in dose Dadesbang gar noggs geb. Wileigd haddar dose schon wiedherschdel.',
'undelete-error-short'         => 'Wehl bei Wiedherschdel won dose Dadei $1',
'undelete-error-long'          => 'Haddar Wehles bei Wiedherschdel won eines Dadei wesdschdel:

$1',

# Namespace form on various pages
'namespace'      => 'Namesraum:',
'invert'         => 'Auswähl umgehr',
'blanknamespace' => '(Seides)',

# Contributions
'contributions' => 'Benudsesbeidräges',
'mycontris'     => 'Eigenes Beidräges',
'contribsub2'   => 'Wür $1 ($2)',
'nocontribs'    => 'Haddar noggs Benudsesbeidräges mid dose Grideries wend.',
'uctop'         => '(agdueles)',
'month'         => 'und Mons:',
'year'          => 'bis Jahr:',

'sp-contributions-newbies'     => 'Seig nur Beidräges won neues Benudses',
'sp-contributions-newbies-sub' => 'Wür Neulinges',
'sp-contributions-blocklog'    => 'Schberlogbug',
'sp-contributions-search'      => 'Sug nag Benudsesbeidräges',
'sp-contributions-username'    => 'IB-Adres od Benudsesnam:',
'sp-contributions-submit'      => 'Sug',

# What links here
'whatlinkshere'            => 'Werweises auw dose Seid',
'whatlinkshere-title'      => 'Seides, wo auw dose „$1“ werweis',
'whatlinkshere-summary'    => 'Dose Schbesialseid ales indernes Werweises auw eines beschdämdes Seid auwlisd. Dose mögliges Susädses „(Worlageseinbind)“ und „(Weidleidseid)“ jeweils anseig, das dose Seid noggs durg eines normales Wigiwerweis eingebundenes sei. ',
'whatlinkshere-page'       => 'Seid:',
'linklistsub'              => '(Werweislisd)',
'linkshere'                => "Dose wolgendes Seides werweisdar auw '''„[[:$1]]“''':",
'nolinkshere'              => "Noggs Seid werweisdar auw '''„[[:$1]]“'''.",
'nolinkshere-ns'           => "Noggs Seid werweisdar auw '''„[[:$1]]“''' in dose gewähldes Namesraum.",
'isredirect'               => 'Weidleidseid',
'istemplate'               => 'Worlageseinbind',
'isimage'                  => 'Dadeiwerweis',
'whatlinkshere-prev'       => '{{PLURAL:$1|woriges|woriges $1}}',
'whatlinkshere-next'       => '{{PLURAL:$1|nägsdes|nägsdes $1}}',
'whatlinkshere-links'      => '? Werweises',
'whatlinkshere-hideredirs' => 'Weidleides $1',
'whatlinkshere-hidetrans'  => 'Worlageseinbindes $1',
'whatlinkshere-hidelinks'  => 'Werweises $1',
'whatlinkshere-hideimages' => 'Dadeiwerweises $1',
'whatlinkshere-filters'    => 'Wild',

# Block/unblock
'blockip'                     => 'IB-Adres/Benuds schber',
'blockip-legend'              => 'IB-Adres/Benuds schber',
'blockiptext'                 => 'Mid dose Wormular gön eines IB-Adres od eines Benudsesnam schber, das won dose noggs mehr gön Ändes mag.
Dose nur mag, wan wol Wandalism werhind und in Übeinschdäm mid dose [[{{MediaWiki:Policy-url}}|Rigdlines]].
Bid Grund wür dose Schber angeb.',
'ipaddress'                   => 'IB-Adres od Benudsesnam:',
'ipadressorusername'          => 'IB-Adres od Benudsesnam:',
'ipbexpiry'                   => 'Schberdau:',
'ipbreason'                   => 'Begründ:',
'ipbreasonotherlist'          => 'Anderes Begründ',
'ipbreason-dropdown'          => '
* Algemeines Schbergründes
** Lösch won Seides
** Einschdel won noggssiniges Seides
** Imm wied Werschdöses geg dose Rigdlines wür Nedswerweises
** Werschdos geg dose Grundsads „Noggs bersönliges Angriwes“
* Benudsesschbesiwisches Schbergründes
** Noggsgeeignedes Benudsesnam
** Neuanmeld won eines noggsbeschrängdes geschberdes Benuds
* IB-schbesiwisches Schbergründes
** Brogsy, weg Wandalism einselnes Benuds längereswrisdiges geschberdes',
'ipbanononly'                 => 'Nur anonymes Benudses schber',
'ipbcreateaccount'            => 'Erschdel won Benudsesgondes werhind',
'ipbemailban'                 => 'I-Mehl-Wersand schber',
'ipbenableautoblock'          => 'Schber dose agdueles won dose Benuds genudsdes IB-Adres und audomadisches ales wolgendes, won dose aus dose Bearbeides od dose Anleg won Benudsesgondes brobär',
'ipbsubmit'                   => 'IB-Adres/Benuds schber',
'ipbother'                    => 'Anderes Dau (englisches):',
'ipboptions'                  => '1 Schdund:1 hour,2 Schdundes:2 hours,6 Schdundes:6 hours,1 Dag:1 day,3 Däges:3 days,1 Wog:1 week,2 Woges:2 weeks,1 Mons:1 month,3 Monses:3 months,1 Jahr:1 year,Noggsbeschrängdes:infinite', # display1:time1,display2:time2,...
'ipbotheroption'              => 'Anderes Dau',
'ipbotherreason'              => 'Anderes/ergänsendes Begründ:',
'ipbhidename'                 => 'Benudsesnam in dose Schber-Logbug, dose Lisd won agdiwes Schberes und dose Benudseswerseig werschdeg.',
'ipbwatchuser'                => 'Benudses(disgusions)seid beobagd',
'badipaddress'                => 'Dose IB-Adres eines walsches Wormad haddar.',
'blockipsuccesssub'           => 'Schber erwolgreiges',
'blockipsuccesstext'          => 'Dose Benuds/dose IB-Adres [[{{ns:special}}:Contributions/$1|$1]] haddar schber und dose Agsion in dose [[{{ns:special}}:Log/block|Benudsesschber-Logbug]] brodogolär

Wür Auwheb won Schber seddar dose [[{{ns:special}}:Ipblocklist|Lisd won ales agdiwes Schberes]].',
'ipb-edit-dropdown'           => 'Schbergründes bearbeid',
'ipb-unblock-addr'            => '„$1“ wreigeb',
'ipb-unblock'                 => 'IB-Adres/Benuds wreigeb',
'ipb-blocklist-addr'          => 'Agdueles Schber wür „$1“ anseig',
'ipb-blocklist'               => 'Ales agdueles Schberes anseig',
'unblockip'                   => 'IB-Adres wreigeb',
'unblockiptext'               => 'Mid dose Wormular gön eines IB-Adres od eines Benuds wreigeb.',
'ipusubmit'                   => 'Wreigeb',
'unblocked'                   => '[[User:$1|$1]] haddar wreigeb',
'unblocked-id'                => 'Schber-ID $1 haddar wreigeb',
'ipblocklist'                 => 'Lisd won geschberdes Benudses/IB-Adreses',
'ipblocklist-legend'          => 'Sug nag eines geschberdes Benuds',
'ipblocklist-username'        => 'Benudsesnam od IB-Adres:',
'ipblocklist-summary'         => "Dose Schbesialseid wührdar – ergänsendes su dose [[Special:Log/block|Benudsesschber-Logbug]], wo ales (End-)Schberes brodogolär wo haddar manueles mag – dose '''agdueles''' geschberdes Benudses und IB-Adreses auw, einschliesliges audomadisches geschberdes IB-Adreses in anonymisärdes Worm.",
'ipblocklist-submit'          => 'Sug',
'blocklistline'               => '$1, $2 haddar schber $3 (bis $4)',
'infiniteblock'               => 'noggsbegrensdes',
'expiringblock'               => '$1',
'anononlyblock'               => 'nur Anonymes',
'noautoblockblock'            => 'Audoblogg deagdiwärdes',
'createaccountblock'          => 'Erschdel won Benudsesgondes geschberdes',
'emailblock'                  => 'I-Mehl-Wersand geschberdes',
'ipblocklist-empty'           => 'Dose Lisd haddar noggs Eindräges drin.',
'ipblocklist-no-results'      => 'Dose IB-Adres/dose Benudsesnam wo sug noggs geschberdes.',
'blocklink'                   => 'Schber',
'unblocklink'                 => 'Wreigeb',
'contribslink'                => 'Beidräges',
'autoblocker'                 => 'Audomadisches Schber, weil du gemeinsames IB-Adres mid dose [[Benuds:$1]] benudsdar. Grund: „$2“.',
'blocklogpage'                => 'Benudsesschber-Logbug',
'blocklogentry'               => 'haddar schber dose „[[$1]]“ wür dose Dseidraum: $2 $3',
'blocklogtext'                => 'Dose dose Logbug sei üb Schberes und Endschberes won Benudses und IB-Adreses. Audomadisches geschberdes IB-Adreses dose noggs erwas. Seddar dose [[{{ns:special}}:Ipblocklist|{{int:ipblocklist}}]] wür ales agdiwes Schberes.',
'unblocklogentry'             => 'haddar Schber won dose „[[$1]]“ auwheb',
'block-log-flags-anononly'    => 'nur Anonymes',
'block-log-flags-nocreate'    => 'Erschdel won Benudsesgondes geschberdes',
'block-log-flags-noautoblock' => 'Audoblogg deagdiwärdes',
'block-log-flags-noemail'     => 'I-Mehl-Wersand geschberdes',
'range_block_disabled'        => 'Dose Mög das gön ganses Adresräumes schber, noggs agdiwärdes sei.',
'ipb_expiry_invalid'          => 'Dose Dau wo haddar eingeb ungüldiges sei.',
'ipb_expiry_temp'             => 'Werschdegdes Benudsesnames-Schberes soldar bermanendes sei.',
'ipb_already_blocked'         => '„$1“ haddar schon schber.',
'ipb_cant_unblock'            => 'Wehl: Schber-ID $1 haddar noggs wend. Dose Schber haddar schon auwheb.',
'ipb_blocked_as_range'        => 'Wehl: Dose IB-Adres $1 haddar als Deil won dose Bereigsschber $2 indiregdes schber. Eines Endschber nur won dose $1 aleines noggs mög sei.',
'ip_range_invalid'            => 'Ungüldiges IB-Adresbereig.',
'blockme'                     => 'Schber mig',
'proxyblocker'                => 'Brogsybloggärer',
'proxyblocker-disabled'       => 'Dose Wungsion deagdiwärdes sei.',
'proxyblockreason'            => 'Deines IB-Adres haddar schber, weil dose eines owenes Brogsy sei. Bid mal sbreg mid deines Inderned-Anbied od deines Sysdemadminisdradores und inwormär dose üb dose mögliges Sockheidsbroblem.',
'proxyblocksuccess'           => 'Werdiges sei.',
'sorbsreason'                 => 'Dose IB-Adres in dose DNSBL won dose {{SITENAME}} als owenes BROGSY gelisdedes sei.',
'sorbs_create_account_reason' => 'Dose IB-Adres in dose DNSBL won dose {{SITENAME}} als owenes BROGSY gelisdedes sei. Dose Anleg won neues Benudses noggs mög sei.',

# Developer tools
'lockdb'              => 'Dadesbang schber',
'unlockdb'            => 'Dadesbang wreigeb',
'lockdbtext'          => 'Mid dose Schber won dose Dadesbang ales Ändes an Benudseseinschdeles, Beobagdlisdes, Seides usw. werdar werhind. Bid beschdäd dose Schber.',
'unlockdbtext'        => 'Dose Auwheb won dose Dadesbang-Schber ales Ändes wied sulas. Bid beschdäd dose Auwheb.',
'lockconfirm'         => 'Sock, wol dose Dadesbang schber.',
'unlockconfirm'       => 'Sock, wol dose Dadesbang wreigeb.',
'lockbtn'             => 'Dadesbang schber',
'unlockbtn'           => 'Dadesbang wreigeb',
'locknoconfirm'       => 'Haddar dose Beschdäd-Weld ja gar noggs margär.',
'lockdbsuccesssub'    => 'Haddar Dadesbang erwolgreiges schber',
'unlockdbsuccesssub'  => 'Haddar Dadesbang erwolgreiges wreigeb',
'lockdbsuccesstext'   => 'Dose {{SITENAME}}-Dadesbang haddar schber.<br />Bid dose Dadesbang [[Special:Unlockdb|wied wreigeb]], gleig wan dose Ward werd sei.',
'unlockdbsuccesstext' => 'Dose {{SITENAME}}-Dadesbang haddar wreigeb.',
'lockfilenotwritable' => 'Dose Dadesbang-Schberdadei noggs beschreibbares sei. Wan dose Dadesbang wol schber od wreigeb musdar dose wür dose Websörw beschreibbares sei.',
'databasenotlocked'   => 'Dose Dadesbang noggs geschberdes sei.',

# Move page
'move-page'               => 'Werschieb „$1“',
'move-page-legend'        => 'Seid werschieb',
'movepagetext'            => 'Mid dose Wormular gön eines Seid umbenen (mid ales Wersiones). Dose aldes Did dan su neues weidleid. Werweises auw dose aldes Did noggs änd.',
'movepagetalktext'        => "Dose Disgusionsseid wo dasugehördar, wan gebdar, aug midwerschieb, '''aba noggs wan:'''
*Gebdar schon eines Disgusionsseid mid dose Nam, od
*wan dose Obsion wo undd schdeddar rausgeb.

In dose Wäles musdar, wan wol, dose Inhald won dose Seid won Hand werschieb od susamwühr.

Bid dose '''neues''' Did undd '''Siel''' eindräg, und undd dose dose Umbenen bid '''begründ.'''",
'movearticle'             => 'Seid werschieb:',
'movenologin'             => 'Du noggs angemeldedes sei',
'movenologintext'         => 'Musdar eines regisdrärdes Benuds und [[Special:Userlogin|angemeldedes]] sei,das gön eines Seid werschieb.',
'movenotallowed'          => 'Haddar in dose Wigi gar noggs Beregd, das gön Seides werschieb.',
'newtitle'                => 'Siel:',
'move-watch'              => 'Dose Seid beobagd',
'movepagebtn'             => 'Seid werschieb',
'pagemovedsub'            => 'Werschieb erwolgreiges wesdar',
'articleexists'           => 'Undd dose Nam schon eines Seid geb. Bid anderes Nam nehm.',
'cantmove-titleprotected' => 'Dose Werschieb noggs gön durgwühr, weil dose Sieldid wür Erschdel geschberdes sei.',
'talkexists'              => 'Dose Seid selb haddar erwolgreiges werschieb, aba dose Disgusionsseid wo dasugehördar noggs, weil schon eines gebdar mid dose neues Did. Bid dose Inhaldes won Hand abgleig.',
'movedto'                 => 'haddar werschieb nag',
'movetalk'                => 'Dose Disgusionsseid aug midwerschieb, wan mög.',
'move-subpages'           => 'Ales Unddseides, wan geb, aug midwerschieb',
'move-talk-subpages'      => 'Ales Unddseides won Disgusionsseides, wan geb, aug midwerschieb',
'movepage-page-exists'    => 'Dose Seid „$1“ schon geb, gön noggs audomadisches übschreib dose.',
'movepage-page-moved'     => 'Dose Seid „$1“ haddar nag „$2“ werschieb.', # The two titles are passed in plain text as $3 and $4 to allow additional goodies in the message.
'movepage-page-unmoved'   => 'Dose Seid „$1“ haddar noggs gön nag „$2“ werschieb.',
'movepage-max-pages'      => 'Dose Magsimalansähl won $1 {{PLURAL:$1|Seid|Seides}} haddar werschieb, ales weideres Seides noggs gön audomadisches werschieb.',
'1movedto2'               => 'haddar „[[$1]]“ nag „[[$2]]“ werschieb',
'1movedto2_redir'         => 'haddar „[[$1]]“ nag „[[$2]]“ werschieb und bei dose eines Weidleid übschreib',
'movelogpage'             => 'Werschieb-Logbug',
'movelogpagetext'         => 'Dose eines Lisd sei won ales werschobenes Seides.',
'movereason'              => 'Begründ:',
'revertmove'              => 'surüg werschieb',
'delete_and_move'         => 'Lösch und Werschieb',
'delete_and_move_text'    => '==Sielseid gebdar, lösch?==

Dose Seid „[[$1]]“ schon geb. Wol dose lösch, das gön dose Seid werschieb?',
'delete_and_move_confirm' => 'Sielseid wür dose Werschieb lösch',
'delete_and_move_reason'  => 'haddar lösch, das haddar Blads wür Werschieb',
'selfmove'                => 'Urschbrunges- und Sielnam gleiges sei; eines Seid noggs gön auw sig selb werschieb.',
'immobile_namespace'      => 'Dose Guel- od Sielnamesraum geschüdsdes sei; Werschiebes in dose Namesraum rein od aus dose raus noggs mög sei.',
'imagenocrossnamespace'   => 'Dadeies noggs gön aus dose {{ns:image}}-Namesraum raus werschieb',
'imagetypemismatch'       => 'Dose neues Dadeierweid noggs mid dose aldes idendisches sei',

# Export
'export'            => 'Seides egsbordär',
'exporttext'        => 'Mid dose Schbesialseid gön dose Degsd (und dose Bearbeides-/Wersionsgeschigd) won einselnes Seides in eines XML-Dadei egsbordär.
Dose Dadei dan gön in anderes Wigi mid MediaWigi-Sowdwär einschbäl, bearbeid od argiwär.

Bid dose Seidesdid od -dides in dose wolgendes Degsdweld eindrag (bro Dseil imm nur wür eines Seid).

Aldernadiwes dose Egsbord aug mid dose Syndags <tt><nowiki>[[</nowiki>{{ns:special}}<nowiki>:Export/Seitentitel]]</nowiki></tt> mög sei, sum Beischb [[{{ns:special}}:Export/{{Mediawiki:mainpage}}]] wür dose [[{{Mediawiki:mainpage}}]].',
'exportcuronly'     => 'Nur dose agdueles Wersion won Seid egsbordär',
'exportnohistory'   => "----
'''Hinweis:''' Dose Egsbord won gombleddes Wersionsgeschigdes aus Berwormänsgründes bis auw weideres noggs mög sei.",
'export-submit'     => 'Seides egsbordär',
'export-addcattext' => 'Seides aus Gadegorä dasugeb:',
'export-addcat'     => 'Dasugeb',
'export-download'   => 'Als XML-Dadei schbeig',
'export-templates'  => 'Inglusiw Worlages',

# Namespace 8 related
'allmessages'               => 'MediaWigi-Sysdemdegsdes',
'allmessagesname'           => 'Nam',
'allmessagesdefault'        => 'Schdandarddegsd',
'allmessagescurrent'        => 'Agdueles Degsd',
'allmessagestext'           => 'Dose eines Lisd sei won dose MediaWigi-Sysdemdegsdes.',
'allmessagesnotsupportedDB' => 'Dose Schbesialseid noggs su Werwüg schdeddar, weil haddar dose üb dose Baramed <tt>$wgUseDatabaseMessages</tt> deagdiwär.',
'allmessagesfilter'         => 'Nagrigdesnameswild:',
'allmessagesmodified'       => 'Nur geänderdes anseig',

# Thumbnails
'thumbnail-more'           => 'wergrös',
'filemissing'              => 'Dadei wehldar',
'thumbnail_error'          => 'Wehl bei Erschdel won dose Worschaubild: $1',
'djvu_page_error'          => 'DjVu-Seid aushalb won Seidesbereig',
'djvu_no_xml'              => 'XML-Dades noggs gön wür dose DjVu-Dadei abruw',
'thumbnail_invalid_params' => 'Noggsgüldiges Sambnäil-Baramed',
'thumbnail_dest_directory' => 'Sielwerseig noggs gön erschdel.',

# Special:Import
'import'                     => 'Seides imbordär',
'importinterwiki'            => 'Dranswigi-Imbord',
'import-interwiki-text'      => 'Wähldar eines Wigi und eines Seid su Imbordär aus.
Dose Wersionsdades und Benudsesnames bei dose erhald bleib.
Ales Dranswigi-Imbord-Agsiones in dose [[Special:Log/import|Imbord-Logbug]] brodogolär.',
'import-interwiki-history'   => 'Imbordär ales Wersiones won dose Seid',
'import-interwiki-submit'    => 'Imbord',
'import-interwiki-namespace' => 'Imbordär dose Seid in dose Namesraum:',
'importtext'                 => 'Auw dose Schbesialseid gön dose Seides wo haddar üb dose [[{{ns:special}}:Export]] egsbordär in dose Wigi imbordär.',
'importstart'                => 'Imbordär Seid …',
'import-revision-count'      => '– {{PLURAL:$1|1 Wersion|$1 Wersiones}}',
'importnopages'              => 'Gebdar noggs Seid su imbordär.',
'importfailed'               => 'Imbord daneb geddar: $1',
'importunknownsource'        => 'Noggsbegandes Imbordguel',
'importcantopen'             => 'Imborddadei haddar noggs gön öw',
'importbadinterwiki'         => 'Walsches Inderwigi-Werweis',
'importnotext'               => 'Leeres od noggs Degsd',
'importsuccess'              => 'Haddar Imbord abschlies!',
'importhistoryconflict'      => 'Gebdar schon älderes Wersiones, wo mid dose golidär. Gön sei das dose Seid haddar schon worher imbordär.',
'importnosources'            => 'Wür dose Dranswigi-Imbord noggs Gueles dewinärdes sei. Dose diregdes Hoglad won Wersiones geschberdes sei.',
'importnofile'               => 'Haddar noggs Imborddadei auswähl!',
'importuploaderrorsize'      => 'Dose Hoglad won dose Imborddadei daneb geddar. Dose Dadei gröseres sei wie dose magsimales erlaubdes Dadeigrös.',
'importuploaderrorpartial'   => 'Dose Hoglad won dose Imborddadei daneb geddar. Dose Dadei haddar nur deilweis hoglad.',
'importuploaderrortemp'      => 'Dose Hoglad won dose Imborddadei daneb geddar. Wehldar eines demboräres Werseig.',
'import-parse-failure'       => 'Wehl bei dose XML-Imbord:',
'import-noarticle'           => 'Haddar noggs Ardig angeb wo sol imbordär!',
'import-nonewrevisions'      => 'Gebdar noggs neues Wersiones wür Imbord, ales Wersiones schon wrüheres haddar imbordär.',
'xml-error-string'           => '$1 Dseil $2, Schbald $3, (Baid $4): $5',
'import-upload'              => 'XML-Dades imbordär',

# Import log
'importlogpage'                    => 'Imbord-Logbug',
'importlogpagetext'                => 'Adminisdradiwes Imbord won Seides mid Wersionsgeschigd won anderes Wigis.',
'import-logentry-upload'           => 'haddar „[[$1]]“ won eines Dadei imbordär',
'import-logentry-upload-detail'    => '$1 {{PLURAL:$1|Wersion|Wersiones}}',
'import-logentry-interwiki'        => 'haddar „[[$1]]“ imbordär (Dranswigi)',
'import-logentry-interwiki-detail' => '$1 {{PLURAL:$1|Wersion|Wersiones}} won $2',

# Tooltip help for the actions
'tooltip-pt-userpage'             => 'Eigenes Benudsesseid',
'tooltip-pt-anonuserpage'         => 'Benudsesseid won dose IB-Adres won dose Du Ändes mag',
'tooltip-pt-mytalk'               => 'Eigenes Disgusionsseid',
'tooltip-pt-anontalk'             => 'Disgusion üb Ändes won dose IB-Adres',
'tooltip-pt-preferences'          => 'Eigenes Einschdeles',
'tooltip-pt-watchlist'            => 'Lisd won beobagdedes Seides',
'tooltip-pt-mycontris'            => 'Lisd won eigenes Beidräges',
'tooltip-pt-login'                => 'Wan einlog dose guddes sei, aba noggs musdar.',
'tooltip-pt-anonlogin'            => 'Wan einlog dose guddes sei, aba noggs musdar.',
'tooltip-pt-logout'               => 'Abmeld',
'tooltip-ca-talk'                 => 'Disgusion su dose Seidesinhald',
'tooltip-ca-edit'                 => 'Seid bearbeid. Bid wor dose Schbeig dose Worschauwungsion benuds.',
'tooltip-ca-addsection'           => 'Eines Gomendar su dose Disgusion dasugeb.',
'tooltip-ca-viewsource'           => 'Dose Seid geschüdsdes sei. Dose Gueldegsd gön anschauddar.',
'tooltip-ca-history'              => 'Wrüheres Wersiones won dose Seid',
'tooltip-ca-protect'              => 'Schüds dose Seid',
'tooltip-ca-delete'               => 'Lösch dose Seid',
'tooltip-ca-undelete'             => 'Eindräges wiedherschdel, bewor dose Seid haddar lösch',
'tooltip-ca-move'                 => 'Werschieb dose Seid',
'tooltip-ca-watch'                => 'Dose Seid su dose bersönliges Beobagdlisd dasugeb',
'tooltip-ca-unwatch'              => 'Dose Seid aus dose bersönliges Beobagdlisd rausnehm',
'tooltip-search'                  => '{{SITENAME}} durgsug',
'tooltip-search-go'               => 'Geddar diregdes su dose Seid, wo haddar genaues dose Nam wo eingeb.',
'tooltip-search-fulltext'         => 'Sug nag Seides, wo dose Degsd drin sei',
'tooltip-p-logo'                  => 'Haubdseid',
'tooltip-n-mainpage'              => 'Haubdseid anseig',
'tooltip-n-portal'                => 'Üb dose Bordal, was gön mag, wo was wend',
'tooltip-n-currentevents'         => 'Hindgrundinwormasiones su agdueles Ereiges',
'tooltip-n-recentchanges'         => 'Lisd won dose ledsdes Ändes in dose {{SITENAME}}.',
'tooltip-n-randompage'            => 'Suwäliges Seid',
'tooltip-n-help'                  => 'Hilwseid anseig',
'tooltip-n-sitesupport'           => 'Undschdüdsdar dose {{SITENAME}}',
'tooltip-t-whatlinkshere'         => 'Lisd won ales Seides, wo daher werweis',
'tooltip-t-recentchangeslinked'   => 'Ledsdes Ändes an Seides, wo dose Seid drauw werweis',
'tooltip-feed-rss'                => 'RSS-Wied wür dose Seid',
'tooltip-feed-atom'               => 'Adom-Wied wür dose Seid',
'tooltip-t-contributions'         => 'Lisd won Beidräges won dose Benuds anschauddar',
'tooltip-t-emailuser'             => 'Eines I-Mehl an dose Benuds schig',
'tooltip-t-upload'                => 'Dadeies hoglad',
'tooltip-t-specialpages'          => 'Lisd won ales Schbesialseides',
'tooltip-t-print'                 => 'Druggansigd won dose Seid',
'tooltip-t-permalink'             => 'Dauhawdes Werweis su dose Seideswersion',
'tooltip-ca-nstab-main'           => 'Seidesinhald anseig',
'tooltip-ca-nstab-user'           => 'Benudsesseid anseig',
'tooltip-ca-nstab-media'          => 'Mediesdadeiesseid anseig',
'tooltip-ca-nstab-special'        => 'Dose eines Schbesialseid sei. Dose noggs gön weränd.',
'tooltip-ca-nstab-project'        => 'Bordalseid anseig',
'tooltip-ca-nstab-image'          => 'Dadeiseid anseig',
'tooltip-ca-nstab-mediawiki'      => 'MediaWigi-Sysdemdegsd anseig',
'tooltip-ca-nstab-template'       => 'Worlag anseig',
'tooltip-ca-nstab-help'           => 'Hilwseid anseig',
'tooltip-ca-nstab-category'       => 'Gadegoräseid anseig',
'tooltip-minoredit'               => 'Dose Änd als gleines margär.',
'tooltip-save'                    => 'Ändes schbeig',
'tooltip-preview'                 => 'Worschau won dose Ändes an dose Seid. Bid benudsdar dose wor dose Schbeig!',
'tooltip-diff'                    => 'Ändes an dose Degsd dabelarisches anseig',
'tooltip-compareselectedversions' => 'Undschied swisch suai ausgewähldes Wersiones won dose Seid anseig.',
'tooltip-watch'                   => 'Dose Seid su Deines Beobagdlisd dasugeb',
'tooltip-recreate'                => 'Seid neues erschdel, obwohl dose haddar lösch.',
'tooltip-upload'                  => 'Hoglad anwäng',

# Stylesheets
'common.css'      => '/* CSS an dose Schdel auw ales Sgins auswirg */',
'standard.css'    => '/* CSS an dose Schdel auw dose Klassik-Sgin auswirg. Wür algemeinesgüldiges Sgin-Anbases bid dose [[MediaWiki:Common.css]] bearbeid. */',
'nostalgia.css'   => '/* CSS an dose Schdel auw dose Nostalgie-Skin auswirg. Wür algemeinesgüldiges Sgin-Anbases bid dose [[MediaWiki:Common.css]] bearbeid. */',
'cologneblue.css' => '/* CSS an dose Schdel auw dose Kölnisch Blau-Skin auswirg. Wür algemeinesgüldiges Sgin-Anbases bid dose [[MediaWiki:Common.css]] bearbeid. */',
'monobook.css'    => '/* CSS an dose Schdel auw dose Monobook-Skin auswirg. Wür algemeinesgüldiges Sgin-Anbases bid dose [[MediaWiki:Common.css]] bearbeid. */
/* Gleinschreib noggs erswing */
.portlet h5,
.portlet h6,
#p-personal ul,
#p-cactions li a {
	text-transform: none;
}',
'myskin.css'      => '/* CSS an dose Schdel auw dose MySkin-Skin auswirg. Wür algemeinesgüldiges Sgin-Anbases bid dose [[MediaWiki:Common.css]] bearbeid. */',
'chick.css'       => '/* CSS an dose Schdel auw dose Küken-Skin auswirg. Wür algemeinesgüldiges Sgin-Anbases bid dose [[MediaWiki:Common.css]] bearbeid. */',
'simple.css'      => '/* CSS an dose Schdel auw dose Einfach-Skin auswirg. Wür algemeinesgüldiges Sgin-Anbases bid dose [[MediaWiki:Common.css]] bearbeid. */',
'modern.css'      => '/* CSS an dose Schdel auw dose MySkin-Skin auswirg. Wür algemeinesgüldiges Sgin-Anbases bid dose [[MediaWiki:Common.css]] bearbeid. */',

# Scripts
'common.js'      => '/* Dose wolgendes JawaSgribd wür ales Benudses lad. */',
'standard.js'    => '/* Dose wolgendes JawaSgribd wür dose Benudses lad, wo dose Klassik-Sgin werwend. Algemeinesgüldiges JawaSgribd bid in dose [[MediaWiki:Common.js]] eindrag. */',
'nostalgia.js'   => '/* Dose wolgendes JawaSgribd wür dose Benudses lad, wo dose Nostalgie-Sgin werwend. Algemeinesgüldiges JawaSgribd bid in dose [[MediaWiki:Common.js]] eindrag. */',
'cologneblue.js' => '/* Dose wolgendes JawaSgribd wür dose Benudses lad, wo dose Kölnisch Blau-Sgin werwend. Algemeinesgüldiges JawaSgribd bid in dose [[MediaWiki:Common.js]] eindrag. */',
'monobook.js'    => '/* Dose wolgendes JawaSgribd wür dose Benudses lad, wo dose Monobook-Sgin werwend. Algemeinesgüldiges JawaSgribd bid in dose [[MediaWiki:Common.js]] eindrag. */',
'myskin.js'      => '/* Dose wolgendes JawaSgribd wür dose Benudses lad, wo dose Myskin-Sgin werwend. Algemeinesgüldiges JawaSgribd bid in dose [[MediaWiki:Common.js]] eindrag. */',
'chick.js'       => '/* Dose wolgendes JawaSgribd wür dose Benudses lad, wo dose KükenSgin werwend. Algemeinesgüldiges JawaSgribd bid in dose [[MediaWiki:Common.js]] eindrag. */',
'simple.js'      => '/* Dose wolgendes JawaSgribd wür dose Benudses lad, wo dose Einfach-Sgin werwend. Algemeinesgüldiges JawaSgribd bid in dose [[MediaWiki:Common.js]] eindrag. */',
'modern.js'      => '/* Dose wolgendes JawaSgribd wür dose Benudses lad, wo dose Modern-Sgin werwend. Algemeinesgüldiges JawaSgribd bid in dose [[MediaWiki:Common.js]] eindrag. */',

# Metadata
'nodublincore'      => 'Dublin-Core-RDF-Medadades wür dose Sörw deagdiwärdes sei.',
'nocreativecommons' => 'Creative-Commons-RDF-Medadades wür dose Sörw deagdiwärdes sei.',
'notacceptable'     => 'Dose Wigi-Sörw dose Dades noggs gön auwbereid wür deines Ausgabgeräd.',

# Attribution
'anonymous'        => 'Anonymes Benuds(es) auw dose {{SITENAME}}',
'siteuser'         => '{{SITENAME}}-Benuds $1',
'lastmodifiedatby' => 'Dose Seid haddar suledsd an $1 um $2 Uhr dose $3 änd.', # $1 date, $2 time, $3 user
'othercontribs'    => 'Basär auw dose Arb won dose $1',
'others'           => 'anderes',
'siteusers'        => '{{SITENAME}}-Benudses $1',
'creditspage'      => 'Seidesinwormasiones',
'nocredits'        => 'Gebdar noggs Inwormasiones wür dose Seid.',

# Spam protection
'spamprotectiontitle' => 'Sbämschudswild',
'spamprotectiontext'  => 'Dose Seid wo wol schbeig, won dose Sbämschudswild bloggärdes sei. Daose wahrschein an eines Werweis auw eines egsdernes Seid liegdar.',
'spamprotectionmatch' => "'''Dose wolgendes Degsd haddar dose Sbämwild wend: ''$1'''''",
'spambot_username'    => 'MediaWigi Sbäm-Säub',
'spam_reverting'      => 'Ledsdes Wersion ohn Werweises su $1 haddar wiedherschdel.',
'spam_blanking'       => 'Ales Wersionen haddar Werweises su $1 drin, haddar berein.',

# Info page
'infosubtitle'   => 'Seidesinwormasion',
'numedits'       => 'Ansähl won Seidesändes: $1',
'numtalkedits'   => 'Ansähl won Disgusionsändes: $1',
'numwatchers'    => 'Ansähl won Beobagdes: $1',
'numauthors'     => 'Ansähl won Audores: $1',
'numtalkauthors' => 'Ansähl won Disgusionsdeilnehmes: $1',

# Math options
'mw_math_png'    => 'Imm als PNG darschdel',
'mw_math_simple' => 'Einwages TeX als HDML darschdel, sonsd PNG',
'mw_math_html'   => 'Wan mög als HDML darschdel, sonsd PNG',
'mw_math_source' => 'Als TeX belas (wür Degsdbraus)',
'mw_math_modern' => 'Embwehlwerdes wür modernes Brauses',
'mw_math_mathml' => 'MathML (egsberimendeles)',

# Patrolling
'markaspatrolleddiff'                 => 'Als gondrolärdes margär',
'markaspatrolledtext'                 => 'Dose neues Seid als gondrolärdes margär',
'markedaspatrolled'                   => 'Als gondrolärdes margär',
'markedaspatrolledtext'               => 'Dose ausgewähldes Seidesänd haddar als gondrolärdes margär.',
'rcpatroldisabled'                    => 'Gondrol won ledsdes Ändes geschberdes sei',
'rcpatroldisabledtext'                => 'Dose Gondrol won ledsdes Ändes momendanes geschberdes sei.',
'markedaspatrollederror'              => 'Margär als „gondrolärdes“ noggs mög sei.',
'markedaspatrollederrortext'          => 'Musdar eines Seidesänd auswähl.',
'markedaspatrollederror-noautopatrol' => 'Dose noggs erlaubdes sei, das eigenes Bearbeides als gondrolärdes margär.',

# Patrol log
'patrol-log-page' => 'Gondrol-Logbug',
'patrol-log-line' => 'haddar $1 won „$2“ als gondrolärdes margär $3',
'patrol-log-auto' => '(audomadisches)',
'patrol-log-diff' => 'Wersion $1',

# Image deletion
'deletedrevision'                 => 'aldes Wersion: $1',
'filedeleteerror-short'           => 'Wehl bei dose Dadei-Lösch: $1',
'filedeleteerror-long'            => 'Bei dose Dadei-Lösch haddar Wehles wesdschdel:

$1',
'filedelete-missing'              => 'Dose Dadei „$1“ noggs gön lösch, weil dose gar noggs geb.',
'filedelete-old-unregistered'     => 'Dose Dadei-Wersion „$1“ wo haddar angeb gar noggs geb in dose Dadesbang.',
'filedelete-current-unregistered' => 'Dose Dadei „$1“ wo haddar angeb gar noggs geb in dose Dadesbang.',
'filedelete-archive-read-only'    => 'Dose Argiw-Werseig „$1“ wür dose Websörw noggs beschreibbares sei.',

# Browsing diffs
'previousdiff' => '? Su woriges Wersionsundschied',
'nextdiff'     => 'Su nägsdes Wersionsundschied ?',

# Media information
'mediawarning'         => "'''Warn:''' Dose Ard won Dadei gön böswiliges Brogramgod endhald. Dose Rundlad und Öw won dose Dadei gön Deines Gombjud gabuddes mag.<hr />",
'imagemaxsize'         => 'Magsimales Bildgrös auw Bildbeschreibseides:',
'thumbsize'            => 'Schdandardgrös won dose Worschaubildes (sambnäils):',
'widthheightpage'      => '$1×$2, {{PLURAL:$3|1 Seid|$3 Seides}}',
'file-info'            => '(Dadeigrös: $1, MIME-Dyb: $2)',
'file-info-size'       => '($1 × $2 Bigsel, Dadeigrös: $3, MIME-Dyb: $4)',
'file-nohires'         => '<small>Noggs höheres Auwlös gebdar.</small>',
'svg-long-desc'        => '(SVG-Dadei, Basisgrös: $1 × $2 Bigsel, Dadeigrös: $3)',
'show-big-image'       => 'Wersion in höheres Auwlös',
'show-big-image-thumb' => '<small>Grös won dose Woransigd: $1 × $2 Bigsel</small>',

# Special:Newimages
'newimages'             => 'Neues Dadeies',
'imagelisttext'         => "Da haddar eines Lisd won '''$1''' {{PLURAL:$1|Dadei|Dadeies}}, sordärdes $2.",
'newimages-summary'     => 'Dose Schbesialseid dose Dadeies anseig wo haddar suledsd hoglad.',
'showhidebots'          => '(Bods $1)',
'noimages'              => 'Haddar noggs Dadeies wend.',
'ilsubmit'              => 'Sug',
'bydate'                => 'nag Dadum',
'sp-newimages-showfrom' => 'Seig neues Dadeies ab $1, $2 Uhr',

# Bad image list
'bad_image_list' => 'Wormad:

Nur dose Dseiles auswerd, wo mid eines * anwäng. Als ersderes nag dose * musdar eines Werweis auw eines noggserwünschdes Bild schdeddar.
Seideswerweises wo auw dose in gleiges wolg dewinär Ausnahmes, in doses Gondegsd dose Bild drodsd dörw gom.',

# Metadata
'metadata'          => 'Medadades',
'metadata-help'     => 'Dose Dadei haddar weideres Inwormasiones drin, won in Reg won dose Digidalgamera od dose Sgän schdam wo haddar werwend. Gön sei das durg nagdrägliches Bearbeid won dose Originäldadei haddar baar Dedailes weränd.',
'metadata-expand'   => 'Erweiderdes Dedailes einblend',
'metadata-collapse' => 'Erweiderdes Dedailes ausblend',
'metadata-fields'   => 'Dose wolgendes Weldes won dose EXIF-Medadades in dose MediaWigi-Sysdemdegsd auw Bildbeschreibseides anseig; gön weideres schdandardmäsiges „eingeglabbdes“ Dedailes anseig.
* make
* model
* datetimeoriginal
* exposuretime
* fnumber
* focallength', # Do not translate list items

# EXIF tags
'exif-imagewidth'                  => 'Breid',
'exif-imagelength'                 => 'Läng',
'exif-bitspersample'               => 'Bids bro Warbgombonend',
'exif-compression'                 => 'Ard won dose Gombresion',
'exif-photometricinterpretation'   => 'Bigselsusamseds',
'exif-orientation'                 => 'Gameraausrigd',
'exif-samplesperpixel'             => 'Ansähl Gombonendes',
'exif-planarconfiguration'         => 'Dadesausrigd',
'exif-ycbcrsubsampling'            => 'Sabsämbling Rad won Y bis C',
'exif-ycbcrpositioning'            => 'Y und C Bosisionär',
'exif-xresolution'                 => 'Horisondales Auwlös',
'exif-yresolution'                 => 'Werdigales Auwlös',
'exif-resolutionunit'              => 'Maseinheid won dose Auwlös',
'exif-stripoffsets'                => 'Bilddades-Wersads',
'exif-rowsperstrip'                => 'Ansähl Dseiles bro Schdreiw',
'exif-stripbytecounts'             => 'Baids bro gomprimädes Schdreiw',
'exif-jpeginterchangeformat'       => 'Owsed su JPEG SOI',
'exif-jpeginterchangeformatlength' => 'Grös won dose JPEG-Dades in Baids',
'exif-transferfunction'            => 'Übdragwungsion',
'exif-whitepoint'                  => 'Manueles mid Mes',
'exif-ycbcrcoefficients'           => 'YCbCr-Goewisiendes',
'exif-referenceblackwhite'         => 'Schwads/Weis-Rewerensbungdes',
'exif-datetime'                    => 'Schbeigdseidbungd',
'exif-imagedescription'            => 'Bilddid',
'exif-make'                        => 'Herschdel',
'exif-model'                       => 'Model',
'exif-software'                    => 'Sowdwär',
'exif-artist'                      => 'Wodograw',
'exif-copyright'                   => 'Urhebregdes',
'exif-exifversion'                 => 'Exif-Wersion',
'exif-flashpixversion'             => 'undschdüdsdes Flashpix-Wersion',
'exif-colorspace'                  => 'Warbraum',
'exif-componentsconfiguration'     => 'Bedeud won einselnes Gombonendes',
'exif-compressedbitsperpixel'      => 'Gombrimärdes Bids bro Bigsel',
'exif-pixelydimension'             => 'Güldiges Bildbreid',
'exif-pixelxdimension'             => 'Güldiges Bildhöh',
'exif-makernote'                   => 'Herschdelesnodis',
'exif-usercomment'                 => 'Benudsesgomendares',
'exif-relatedsoundfile'            => 'Sugehöriges Dondadei',
'exif-datetimeoriginal'            => 'Erwasdseidbungd',
'exif-datetimedigitized'           => 'Digidalisärdseidbungd',
'exif-subsectime'                  => 'Schbeigdseidbungd (1/100 s)',
'exif-subsectimeoriginal'          => 'Erwasdseidbungd (1/100 s)',
'exif-subsectimedigitized'         => 'Digidalisärdseidbungd (1/100 s)',
'exif-exposuretime'                => 'Beligddau',
'exif-exposuretime-format'         => '$1 Segundes ($2)',
'exif-fnumber'                     => 'Blend',
'exif-exposureprogram'             => 'Beligdbrogram',
'exif-spectralsensitivity'         => 'Spectral Sensitivity',
'exif-isospeedratings'             => 'Wilm- od Sensoresembwindgeid (ISO)',
'exif-oecf'                        => 'Obdoelegdronisches Umregwagdor',
'exif-shutterspeedvalue'           => 'Beligddseidwerd',
'exif-aperturevalue'               => 'Blendeswerd',
'exif-brightnessvalue'             => 'Heliggeidswerd',
'exif-exposurebiasvalue'           => 'Beligdworgab',
'exif-maxaperturevalue'            => 'Grösdes Blend',
'exif-subjectdistance'             => 'Endwern',
'exif-meteringmode'                => 'Meswerwähr',
'exif-lightsource'                 => 'Ligdguel',
'exif-flash'                       => 'Blids',
'exif-focallength'                 => 'Brenweid',
'exif-subjectarea'                 => 'Bereig',
'exif-flashenergy'                 => 'Blidsschdärg',
'exif-focalplanexresolution'       => 'Sensorauwlös horisondales',
'exif-focalplaneyresolution'       => 'Sensorauwlös werdigales',
'exif-focalplaneresolutionunit'    => 'Einheid won dose Sensorauwlös',
'exif-subjectlocation'             => 'Modiwschdandord',
'exif-exposureindex'               => 'Beligdindegs',
'exif-sensingmethod'               => 'Mesmedhod',
'exif-filesource'                  => 'Guel won Dadei',
'exif-scenetype'                   => 'Sdsenesdyb',
'exif-cfapattern'                  => 'CFA-Musd',
'exif-customrendered'              => 'Benudsesdewinärdes Bildwerarbeid',
'exif-exposuremode'                => 'Beligdmodus',
'exif-whitebalance'                => 'Weisabgleig',
'exif-digitalzoomratio'            => 'Digidalsuum',
'exif-focallengthin35mmfilm'       => 'Brenweid (Gleinesbildäguiwalend)',
'exif-scenecapturetype'            => 'Auwnahmard',
'exif-gaincontrol'                 => 'Werschdärg',
'exif-contrast'                    => 'Gondrasd',
'exif-saturation'                  => 'Säddig',
'exif-sharpness'                   => 'Schärw',
'exif-devicesettingdescription'    => 'Gerädeseinschdel',
'exif-subjectdistancerange'        => 'Modiwendwern',
'exif-imageuniqueid'               => 'Bild-ID',
'exif-gpsversionid'                => 'GPS-Däg-Wersion',
'exif-gpslatituderef'              => 'nördl. od südl. Breid',
'exif-gpslatitude'                 => 'Geograwisches Breid',
'exif-gpslongituderef'             => 'ösdl. od wesdl. Läng',
'exif-gpslongitude'                => 'Geograwisches Läng',
'exif-gpsaltituderef'              => 'Besugshöh',
'exif-gpsaltitude'                 => 'Höh',
'exif-gpstimestamp'                => 'GPS-Dseid',
'exif-gpssatellites'               => 'Wür dose Mes benudsdes Sadelides',
'exif-gpsstatus'                   => 'Embwängesschdadus',
'exif-gpsmeasuremode'              => 'Meswerwähr',
'exif-gpsdop'                      => 'Masbräsision',
'exif-gpsspeedref'                 => 'Geschwindgeidseinheid',
'exif-gpsspeed'                    => 'Geschwind won dose GPS-Embwäng',
'exif-gpstrackref'                 => 'Rewerens wür Bewegrigd',
'exif-gpstrack'                    => 'Bewegrigd',
'exif-gpsimgdirectionref'          => 'Rewerens wür dose Ausrigd won Bild',
'exif-gpsimgdirection'             => 'Bildrigd',
'exif-gpsmapdatum'                 => 'Geodädisches Dadum haddar benuds',
'exif-gpsdestlatituderef'          => 'Rewerens wür dose Breid',
'exif-gpsdestlatitude'             => 'Breid',
'exif-gpsdestlongituderef'         => 'Rewerens wür dose Läng',
'exif-gpsdestlongitude'            => 'Läng',
'exif-gpsdestbearingref'           => 'Rewerens wür dose Modiwrigd',
'exif-gpsdestbearing'              => 'Modiwrigd',
'exif-gpsdestdistanceref'          => 'Rewerens wür dose Modiwendwern',
'exif-gpsdestdistance'             => 'Modiwendwern',
'exif-gpsprocessingmethod'         => 'Nam won dose GPS-Werwähr',
'exif-gpsareainformation'          => 'Nam won dose GPS-Gebied',
'exif-gpsdatestamp'                => 'GPS-Dadum',
'exif-gpsdifferential'             => 'GPS-Diwerensiälgoregdur',

# EXIF attributes
'exif-compression-1' => 'Noggsgombrimärdes',

'exif-unknowndate' => 'Noggsbegandes Dadum',

'exif-orientation-1' => 'Normales', # 0th row: top; 0th column: left
'exif-orientation-2' => 'Horisondales gedrehdes', # 0th row: top; 0th column: right
'exif-orientation-3' => 'Um 180° gedrehdes', # 0th row: bottom; 0th column: right
'exif-orientation-4' => 'Werdigales gedrehdes', # 0th row: bottom; 0th column: left
'exif-orientation-5' => 'Endgeg won Uhrseigessin um 90° gedrehdes und werdigales gewendedes', # 0th row: left; 0th column: top
'exif-orientation-6' => 'Um 90° in Uhrseigessin gedrehdes', # 0th row: right; 0th column: top
'exif-orientation-7' => 'Um 90° in Uhrseigessin gedrehdes und werdigales gewendedes', # 0th row: right; 0th column: bottom
'exif-orientation-8' => 'Um 90° endgeg Uhrseigessin gedrehdes', # 0th row: left; 0th column: bottom

'exif-planarconfiguration-1' => 'Grobwormad',
'exif-planarconfiguration-2' => 'Blanarwormad',

'exif-componentsconfiguration-0' => 'Noggs geb',

'exif-exposureprogram-0' => 'Noggsbegandes',
'exif-exposureprogram-1' => 'Manueles',
'exif-exposureprogram-2' => 'Schdandardbrogram',
'exif-exposureprogram-3' => 'Dseidaudomadig',
'exif-exposureprogram-4' => 'Blendesaudomadig',
'exif-exposureprogram-5' => 'Greadiwbrogram mid Beworsug won hohes Schärwesdiew',
'exif-exposureprogram-6' => 'Action-Brogram mid Beworsug won gurses Beligddseid',
'exif-exposureprogram-7' => 'Bordrä-Brogram',
'exif-exposureprogram-8' => 'Landschawdsauwnähmes',

'exif-subjectdistance-value' => '$1 Medes',

'exif-meteringmode-0'   => 'Noggsbegandes',
'exif-meteringmode-1'   => 'Durgschnidliges',
'exif-meteringmode-2'   => 'Middessendrärdes',
'exif-meteringmode-3'   => 'Sbodmes',
'exif-meteringmode-4'   => 'Mehrwagsbodmes',
'exif-meteringmode-5'   => 'Musd',
'exif-meteringmode-6'   => 'Bilddeil',
'exif-meteringmode-255' => 'Noggsbegandes',

'exif-lightsource-0'   => 'Noggsbegandes',
'exif-lightsource-1'   => 'Dägesligd',
'exif-lightsource-2'   => 'Wluoressärendes',
'exif-lightsource-3'   => 'Glühlamb',
'exif-lightsource-4'   => 'Blids',
'exif-lightsource-9'   => 'Schönes Wedd',
'exif-lightsource-10'  => 'Bewölgdes',
'exif-lightsource-11'  => 'Schaddes',
'exif-lightsource-12'  => 'Dägesligd wluoressärendes (D 5700–7100 K)',
'exif-lightsource-13'  => 'Dägesweis wluoressärendes (N 4600–5400 K)',
'exif-lightsource-14'  => 'Galdesweis wluoressärendes (W 3900–4500 K)',
'exif-lightsource-15'  => 'Weis wluoressärendes (WW 3200–3700 K)',
'exif-lightsource-17'  => 'Schdandardligd A',
'exif-lightsource-18'  => 'Schdandardligd B',
'exif-lightsource-19'  => 'Schdandardligd C',
'exif-lightsource-24'  => 'ISO Schdudio Gunsdligd',
'exif-lightsource-255' => 'Anderes Ligdguel',

'exif-focalplaneresolutionunit-2' => 'Dsol',

'exif-sensingmethod-1' => 'Noggsdewinärdes',
'exif-sensingmethod-2' => 'Eines-Dschib-Warbsensor',
'exif-sensingmethod-3' => 'Suaies-Dschib-Warbsensor',
'exif-sensingmethod-4' => 'Dreies-Dschib-Warbsensor',
'exif-sensingmethod-7' => 'Drilineares Sensor',

'exif-scenetype-1' => 'Normales',

'exif-customrendered-0' => 'Schdandard',
'exif-customrendered-1' => 'Benudsesdewinärdes',

'exif-exposuremode-0' => 'Audomadisches Beligd',
'exif-exposuremode-1' => 'Manueles Beligd',
'exif-exposuremode-2' => 'Beligdreih',

'exif-whitebalance-0' => 'Audomadisches',
'exif-whitebalance-1' => 'Manueles',

'exif-scenecapturetype-0' => 'Schdandard',
'exif-scenecapturetype-1' => 'Landschawd',
'exif-scenecapturetype-2' => 'Bordrä',
'exif-scenecapturetype-3' => 'Nagdsdsen',

'exif-gaincontrol-0' => 'Noggs',
'exif-gaincontrol-1' => 'Geringes',
'exif-gaincontrol-2' => 'High gain up',
'exif-gaincontrol-3' => 'Low gain down',
'exif-gaincontrol-4' => 'High gain down',

'exif-contrast-0' => 'Normales',
'exif-contrast-1' => 'Schwages',
'exif-contrast-2' => 'Schdarges',

'exif-saturation-0' => 'Normales',
'exif-saturation-1' => 'Geringes',
'exif-saturation-2' => 'Hoges',

'exif-sharpness-0' => 'Normales',
'exif-sharpness-1' => 'Geringes',
'exif-sharpness-2' => 'Schdarges',

'exif-subjectdistancerange-0' => 'Noggsbegandes',
'exif-subjectdistancerange-1' => 'Magro',
'exif-subjectdistancerange-2' => 'Nahes',
'exif-subjectdistancerange-3' => 'Endwerndes',

# Pseudotags used for GPSLatitudeRef and GPSDestLatitudeRef
'exif-gpslatitude-n' => 'nördl. Breid',
'exif-gpslatitude-s' => 'südl. Breid',

# Pseudotags used for GPSLongitudeRef and GPSDestLongitudeRef
'exif-gpslongitude-e' => 'ösdl. Läng',
'exif-gpslongitude-w' => 'wesdl. Läng',

'exif-gpsstatus-a' => 'Mes läuwdar',

'exif-gpsmeasuremode-2' => '2-dimensionäles Mes',
'exif-gpsmeasuremode-3' => '3-dimensionäles Mes',

# Pseudotags used for GPSSpeedRef and GPSDestDistanceRef
'exif-gpsspeed-k' => 'gm/h',
'exif-gpsspeed-m' => 'mbh',
'exif-gpsspeed-n' => 'Gnodes',

# Pseudotags used for GPSTrackRef, GPSImgDirectionRef and GPSDestBearingRef
'exif-gpsdirection-t' => 'Dadsägliges Rigd',
'exif-gpsdirection-m' => 'Magnedisches Rigd',

# External editor support
'edit-externally'      => 'Dose Dadei mid egsdernes Brogram bearbeid',
'edit-externally-help' => '<span class="plainlinks">Seddar dose [http://meta.wikimedia.org/wiki/Help:External_editors Insdaläranweises] wür weideres Inwormasiones</span>',

# 'all' in various places, this might be different for inflected languages
'recentchangesall' => 'ales',
'imagelistall'     => 'ales',
'watchlistall2'    => 'ales',
'namespacesall'    => 'ales',
'monthsall'        => 'ales',

# E-mail address confirmation
'confirmemail'             => 'I-Mehl-Adres beschäd (Audhendiwisär)',
'confirmemail_noemail'     => 'Haddar noggs güldiges I-Mehl-Adres in deines [[Special:Preferences|bersönliges Einschdeles]] eindrag.',
'confirmemail_text'        => 'Dose {{SITENAME}} erword, das Du Deines I-Mehl-Adres beschdäd (audhendiwisär), bewor gön dose erweiderdes I-Mehl-Wungsiones benuds. Bid gligg auw dose underes Schaldwläg wo „Beschädgod suschig“ drauwschdeddar, das schig eines audomadisches erschdeldes I-Mehl an dose Adres wo haddar angeb. In dose I-Mehl eines Nedsadres mid eines Beschdädgod drin sei. Wan dose Nedsseid mid Deines Nedsbraus öw, Du mid dose beschdäd das dose I-Mehl-Adres wo haddar angeb goregdes und güldiges sei.',
'confirmemail_pending'     => '<div class="error">Haddar ja schon eines Beschäd-God mid I-Mehl suschig. Wan haddar Deines Benudsesgond ersd wor gurses erschdel, bid nog baar Minudes auw dose I-Mehl ward, bewor eines neues God anword.</div>',
'confirmemail_send'        => 'Beschdädgod suschig',
'confirmemail_sent'        => 'Haddar Beschdäd-I-Mehl werschig.',
'confirmemail_oncreate'    => 'Haddar eines Beschdäd-God an Deines I-Mehl-Adres schig. Dose God wür dose Anmeld noggs braug, aba braugdar dose wür Agdiwär won dose I-Mehl-Wungsiones ineshalb won dose Wigi.',
'confirmemail_sendfailed'  => 'Haddar dose Beschdäd-I-Mehl noggs gön werschig. Bid brüw dose I-Mehl-Adres auw noggsgüldiges Seiges.

Rückmeldung des Mailservers: $1',
'confirmemail_invalid'     => 'Noggsgüldiges Beschdädgod. Wileigd dose Beschdäddseidraum worbei sei. >Bid brobär su wiedhöl dose Beschdäd.',
'confirmemail_needlogin'   => 'Musdar $1 das gön Deines I-Mehl-Adres beschdäd.',
'confirmemail_success'     => 'Haddar Deines I-Mehl-Adres erwolgreiges beschdäd. Gön jedsd einlog.',
'confirmemail_loggedin'    => 'Haddar Deines I-Mehl-Adres erwolgreiges beschdäd.',
'confirmemail_error'       => 'Haddar eines Wehl geb bei dose Beschdäd won Deines I-Mehl-Adres.',
'confirmemail_subject'     => '[{{SITENAME}}] - Beschdäd won dose I-Mehl-Adres',
'confirmemail_body'        => 'Hal,

jem mid dose IB-Adres $1, wahrschein Du selb, haddar dose Benudsesgond "$2" in dose {{SITENAME}} regisdrär.

Das dose I-Mehl-Wungsion wür dose {{SITENAME}} gön (wied) agdiwär und das gön beschdäd,
das dose Benudsesgond werg gehördar su Deines I-Mehl-Adres und mid dose su Dir gehördar, bid öw dose wolgendes Neds-Adres:

$3

Wan dose Adres in Deines I-Mehl-Brogram üb mehres Dseiles geddar, musdar dose ewendueles won Hand in dose Adresdseil won Deines Neds-Braus einwüg.

Wan dose genandes Benudsesgond *noggs* haddar regisdrär, dan bid wolg dose Werweis, das dose Beschdädworgang gön abbreg:

$5

Dose Beschdädgod güldiges sei bis $4.',
'confirmemail_invalidated' => 'I-Mehl-Adresbeschdäd abbreg',
'invalidateemail'          => 'I-Mehl-Adresbeschdäd abbreg',

# Scary transclusion
'scarytranscludedisabled' => '[Inderwigi-Einbind deagdiwärdes sei]',
'scarytranscludefailed'   => '[Worlageseinbind wür $1 daneb geddar]',
'scarytranscludetoolong'  => '[URL su langes sei; Endschuld]',

# Trackbacks
'trackbackbox'      => '<div id="mw_trackbacks">
Drägbäs wür dose Seid:<br />
$1
</div>',
'trackbackremove'   => '([$1 lösch])',
'trackbacklink'     => 'Drägbäg',
'trackbackdeleteok' => 'Drägbäg haddar erwolgreiges lösch.',

# Delete conflict
'deletedwhileediting' => '<span class="error">Obagd: Dose Seid haddar lösch, nagdem haddar anwäng su bearbeid dose!
Schauddar in dose [{{fullurl:Special:Log|type=delete&page=}}{{FULLPAGENAMEE}} Lösch-Logbug],
wies haddar lösch dose Seid. Wan dose Seid schbeig, dose neues anleg.</span>',
'confirmrecreate'     => "Benuds [[User:$1|$1]] ([[User_talk:$1|Disgusion]]) haddar dose Seid lösch, nagdem Du haddar anwäng su bearbeid dose. Dose Begründ sei:
''$2''
Bid beschdäd, das dose Seid werg wol neues erschdel.",
'recreate'            => 'Erneudes anleg',

# HTML dump
'redirectingto' => 'Weidgeleidedes nag [[$1]]',

# action=purge
'confirm_purge'        => 'Dose Seid aus dose Sörw-Gedsch lösch? $1',
'confirm_purge_button' => 'SOCK',

# AJAX search
'searchcontaining' => "Sug nag Seides, wo ''$1'' worgom.",
'searchnamed'      => "Sug nag Seides, wo in Nam ''$1'' drin haddar.",
'articletitles'    => "Seides, wo mid ''$1'' anwäng",
'hideresults'      => 'Werberg',
'useajaxsearch'    => 'Benuds AJAX-undschdüdsdes Sug',

# Multipage image navigation
'imgmultipageprev' => '? woriges Seid',
'imgmultipagenext' => 'nägsdes Seid ?',
'imgmultigo'       => 'SOCK',
'imgmultigoto'     => 'Geddar su Seid $1',

# Table pager
'ascending_abbrev'         => 'auw',
'descending_abbrev'        => 'ab',
'table_pager_next'         => 'Nägsdes Seid',
'table_pager_prev'         => 'Woriges Seid',
'table_pager_first'        => 'Ersdes Seid',
'table_pager_last'         => 'Ledsdes Seid',
'table_pager_limit'        => 'Seig $1 Eindräges bro Seid',
'table_pager_limit_submit' => 'Los',
'table_pager_empty'        => 'Noggs Ergebnises',

# Auto-summaries
'autosumm-blank'   => 'Dose Seid haddar leer.',
'autosumm-replace' => "Dose Seidesinhald haddar mid anderes Degsd erseds: '$1'",
'autoredircomment' => 'Weidleid nag [[$1]] haddar erschdel',
'autosumm-new'     => 'Dose Seid haddar neues anleg: $1',

# Size units
'size-bytes' => '$1 Baids',

# Live preview
'livepreview-loading' => 'Lad …',
'livepreview-ready'   => 'Lad … Werdiges!',
'livepreview-failed'  => 'Laiw-Worschau noggs mög sei! Bid dose normales Worschau benuds.',
'livepreview-error'   => 'Werbind noggs mög sei: $1 „$2“. Bid dose normales Worschau benuds.',

# Friendlier slave lag warnings
'lag-warn-normal' => 'Bearbeides won dose ledsdes $1 Segundes in dose Lisd nog noggs anseig.',
'lag-warn-high'   => 'Weg hohes Dadesbangauslasd dose Bearbeides won ledsdes $1 Segundes in dose Lisd nog noggs anseig.',

# Watchlist editor
'watchlistedit-numitems'       => 'Deines Beobagdlisd haddar {{PLURAL:$1|1 Eindrag |$1 Eindräges}}, Disgusionsseides noggs sähl.',
'watchlistedit-noitems'        => 'Deines Beobagdlisd leeres sei.',
'watchlistedit-normal-title'   => 'Beobagdlisd bearbeid',
'watchlistedit-normal-legend'  => 'Eindräges won dose Beobagdlisd rausnehm',
'watchlistedit-normal-explain' => 'Dose dose Eindräges won Deines Beobagdlisd sei. Wan wol Eindräges rausnehm, margär dose Gäsdes neb dose Eindräges
	und gligg auw „Eindräges rausnehm“. Gön Deines Beobagdlisd aug in dose [[Special:Watchlist/raw|Lisdeswormad bearbeid]].',
'watchlistedit-normal-submit'  => 'Eindräges rausnehm',
'watchlistedit-normal-done'    => 'Haddar {{PLURAL:$1|1 Eindrag|$1 Eindräges}} won Deines Beobagdlisd rausnehm:',
'watchlistedit-raw-title'      => 'Beobagdlisd in Lisdeswormad bearbeid',
'watchlistedit-raw-legend'     => 'Beobagdlisd in Lisdeswormad bearbeid',
'watchlistedit-raw-explain'    => 'Dose dose Eindräges won Deines Beobagdlisd in Lisdeswormad sei. Dose Eindräges gön dseilesweis lösch od dasugeb.
	Bro Dseil eines Eindrag erlaubdes sei. Wan sei werdiges mid dose, gligg auw „Beobagdlisd schbeig“.
	Gön aug dose [[Special:Watchlist/edit|Schdandard-Bearbeidseid]] benuds.',
'watchlistedit-raw-titles'     => 'Eindräges:',
'watchlistedit-raw-submit'     => 'Beobagdlisd schbeig',
'watchlistedit-raw-done'       => 'Haddar Deines Beobagdlisd schbeig.',
'watchlistedit-raw-added'      => '{{PLURAL:$1|1 Eindrag|$1 Eindräges}} haddar dasugeb:',
'watchlistedit-raw-removed'    => '{{PLURAL:$1|1 Eindrag|$1 Eindräges}} haddar rausnehm:',

# Watchlist editing tools
'watchlisttools-view' => 'Beobagdlisd: Ändes',
'watchlisttools-edit' => 'normales bearbeid',
'watchlisttools-raw'  => 'Lisdeswormad bearbeid (Imbord/Egsbord)',

# Core parser functions
'unknown_extension_tag' => 'Noggsbegandes Egsdenschn-Däg „$1“',

# Special:Version
'version'                          => 'Wersion', # Not used as normal message but as header for the special page itself
'version-extensions'               => 'Insdalärdes Erweides',
'version-specialpages'             => 'Schbesialseides',
'version-parserhooks'              => 'Barser-Huugs',
'version-variables'                => 'Wariables',
'version-other'                    => 'Anderes',
'version-mediahandlers'            => 'Medies-Händ',
'version-hooks'                    => "Schnidschdeles ''(Huugs)''",
'version-extension-functions'      => 'Wungsionsauwruwes',
'version-parser-extensiontags'     => "Barser-Erweides ''(dägs)''",
'version-parser-function-hooks'    => 'Barser-Wungsiones',
'version-skin-extension-functions' => 'Sgin-Erweid-Wungsiones',
'version-hook-name'                => 'Schnidschdelesnam',
'version-hook-subscribedby'        => 'Auwruw won',
'version-version'                  => 'Wersion',
'version-license'                  => 'Lisens',
'version-software'                 => 'Insdalärdes Sowdwär',
'version-software-product'         => 'Brodugd',
'version-software-version'         => 'Wersion',

# Special:Filepath
'filepath'         => 'Dadeibwad',
'filepath-page'    => 'Dadei:',
'filepath-submit'  => 'Bwad sug',
'filepath-summary' => 'Mid dose Schbesialseid gön dose gombledes Bwad won dose agdueles Wersion won eines Dadei ohn Umweg abwräg. Dose Daei wo anwräg diregdes darschdel bsw. mid dose wergnübwdes Anwend schdard.

Dose Eingab musdar ohn dose Susads „{{ns:image}}:“ mag.',

# Special:FileDuplicateSearch
'fileduplicatesearch'          => 'Dadei-Dubligad-Sug',
'fileduplicatesearch-summary'  => 'Sug nag Dadei-Dubligades auw Basis won Hash-Werd won dose.

Dose Eingab musdar ohn dose Susads „{{ns:image}}:“ mag.',
'fileduplicatesearch-legend'   => 'Sug nag Dubligades',
'fileduplicatesearch-filename' => 'Dadeinam:',
'fileduplicatesearch-submit'   => 'Sug',
'fileduplicatesearch-info'     => '$1 × $2 Bigsel<br />Dadeigrös: $3<br />MIME-Dyb: $4',
'fileduplicatesearch-result-1' => 'Dose Dadei „$1“ haddar noggs idendisches Dubligades.',
'fileduplicatesearch-result-n' => 'Dose Dadei „$1“ hadar {{PLURAL:$2|1 idendisches Dubligad|$2 idendisches Dubligades}}.',

# Special:SpecialPages
'specialpages'                   => 'Schesialseides',
'specialpages-summary'           => 'Auw dose Seid haddar eines Übblig üb ales Schbesialseides. Dose audomadisches erseug, gön noggs bearbeid dose.',
'specialpages-note'              => '----
* Schbesialseides wür Jedesman
* <span class="mw-specialpagerestricted">Schbesialseides wür Benudses mid erweiderdes Regdes</span>',
'specialpages-group-maintenance' => 'Wardungslisdes',
'specialpages-group-other'       => 'Anderes Schbesialseides',
'specialpages-group-login'       => 'Anmeld',
'specialpages-group-changes'     => 'Ledsdes Ändes und Logbüges',
'specialpages-group-media'       => 'Medies',
'specialpages-group-users'       => 'Benudses und Regdes',
'specialpages-group-highuse'     => 'Häuwiges benudsdes Seides',
'specialpages-group-pages'       => 'Seideslisdes',
'specialpages-group-pagetools'   => 'Seideswergseuges',
'specialpages-group-wiki'        => 'Sysdemdades und Wergseuges',
'specialpages-group-redirects'   => 'Weidleidendes Schbesialseides',
'specialpages-group-spam'        => 'Sbäm-Wergseuges',

# Special:Blank
'blankpage'              => 'Leeres Seid',
'intentionallyblankpage' => 'Dose Seid absigdliges haddar noggs Inhald. Dose wür Benschmargs werwend.',

);
