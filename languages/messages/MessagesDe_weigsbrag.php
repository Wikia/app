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
	'monobook'      => 'MonoBook',
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

