<?php
/** German (Deutsch)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author *Surak*
 * @author Als-Holder
 * @author ChrisiPK
 * @author Church of emacs
 * @author DaSch
 * @author Duesentrieb
 * @author Geitost
 * @author Giftpflanze
 * @author Imre
 * @author Inkowik
 * @author Jan Luca
 * @author Jens Liebenau
 * @author Jimmy Collins <jimmy.collins@web.de>
 * @author Kaganer
 * @author Kebap
 * @author Kghbln
 * @author Khaledelmansoury
 * @author Krinkle
 * @author Kwin
 * @author LWChris
 * @author Li-sung
 * @author Locos epraix
 * @author Lyzzy
 * @author MF-Warburg
 * @author Man77
 * @author Melancholie
 * @author Meno25
 * @author Merlissimo
 * @author Metalhead64
 * @author MichaelFrey
 * @author MtaÄ
 * @author Omnipaedista
 * @author Pill
 * @author Purodha
 * @author Raimond Spekking (Raymond) <raimond.spekking@gmail.com> since January 2007
 * @author Red Baron
 * @author Remember the dot
 * @author Revolus
 * @author Rillke
 * @author SVG
 * @author Saibo
 * @author Spacebirdy
 * @author Srhat
 * @author TMg
 * @author Tbleher
 * @author The Evil IP address
 * @author Tim Bartel (avatar) <wikipedistik@computerkultur.org> small changes
 * @author Tischbeinahe
 * @author UV
 * @author Umherirrender
 * @author W (aka Wuzur)
 * @author Wikifan
 * @author Xqt
 * @author Ziko
 * @author Zylbath
 * @author לערי ריינהארט
 * @author ✓
 */

$capitalizeAllNouns = true;

$namespaceNames = array(
	NS_MEDIA            => 'Medium',
	NS_SPECIAL          => 'Spezial',
	NS_TALK             => 'Diskussion',
	NS_USER             => 'Benutzer',
	NS_USER_TALK        => 'Benutzer_Diskussion',
	NS_PROJECT_TALK     => '$1_Diskussion',
	NS_FILE             => 'Datei',
	NS_FILE_TALK        => 'Datei_Diskussion',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'MediaWiki_Diskussion',
	NS_TEMPLATE         => 'Vorlage',
	NS_TEMPLATE_TALK    => 'Vorlage_Diskussion',
	NS_HELP             => 'Hilfe',
	NS_HELP_TALK        => 'Hilfe_Diskussion',
	NS_CATEGORY         => 'Kategorie',
	NS_CATEGORY_TALK    => 'Kategorie_Diskussion',
);

$namespaceAliases = array(
	'Bild' => NS_FILE,
	'Bild_Diskussion' => NS_FILE_TALK,
);
$namespaceGenderAliases = array(
	NS_USER => array( 'male' => 'Benutzer', 'female' => 'Benutzerin' ),
	NS_USER_TALK => array( 'male' => 'Benutzer_Diskussion', 'female' => 'Benutzerin_Diskussion' ),
);

$bookstoreList = array(
	'abebooks.de' => 'http://www.abebooks.de/servlet/BookSearchPL?ph=2&isbn=$1',
	'amazon.de' => 'http://www.amazon.de/gp/search/field-isbn=$1',
	'buch.de' => 'http://www.buch.de/shop/home/suche/?sswg=BUCH&sq=$1',
	'Karlsruher Virtueller Katalog (KVK)' => 'http://www.ubka.uni-karlsruhe.de/kvk.html?SB=$1',
	'Lehmanns Fachbuchhandlung' => 'http://www.lob.de/cgi-bin/work/suche?flag=new&stich1=$1'
);

$separatorTransformTable = array( ',' => '.', '.' => ',' );
$linkTrail = '/^([äöüßa-z]+)(.*)$/sDu';

$specialPageAliases = array(
	'Activeusers'               => array( 'Aktive_Benutzer' ),
	'Allmessages'               => array( 'MediaWiki-Systemnachrichten', 'Systemnachrichten' ),
	'Allpages'                  => array( 'Alle_Seiten' ),
	'Ancientpages'              => array( 'Älteste_Seiten' ),
	'Badtitle'                  => array( 'Ungültiger_Seitenname' ),
	'Blankpage'                 => array( 'Leerseite', 'Leere_Seite' ),
	'Block'                     => array( 'Sperren' ),
	'Blockme'                   => array( 'Proxy-Sperre' ),
	'Booksources'               => array( 'ISBN-Suche' ),
	'BrokenRedirects'           => array( 'Kaputte_Weiterleitungen' ),
	'Categories'                => array( 'Kategorien' ),
	'ChangeEmail'               => array( 'E-Mail-Adresse_ändern' ),
	'ChangePassword'            => array( 'Passwort_ändern', 'Passwort_zurücksetzen' ),
	'ComparePages'              => array( 'Seiten_vergleichen' ),
	'Confirmemail'              => array( 'E-Mail_bestaetigen', 'E-Mail_bestätigen' ),
	'Contributions'             => array( 'Beiträge' ),
	'CreateAccount'             => array( 'Benutzerkonto_anlegen' ),
	'Deadendpages'              => array( 'Sackgassenseiten' ),
	'DeletedContributions'      => array( 'Gelöschte_Beiträge' ),
	'Disambiguations'           => array( 'Begriffsklärungsverweise' ),
	'DoubleRedirects'           => array( 'Doppelte_Weiterleitungen' ),
	'EditWatchlist'             => array( 'Beobachtungsliste_bearbeiten' ),
	'Emailuser'                 => array( 'E-Mail' ),
	'Export'                    => array( 'Exportieren' ),
	'Fewestrevisions'           => array( 'Wenigstbearbeitete_Seiten' ),
	'FileDuplicateSearch'       => array( 'Dateiduplikatsuche', 'Datei-Duplikat-Suche' ),
	'Filepath'                  => array( 'Dateipfad' ),
	'Import'                    => array( 'Importieren' ),
	'Invalidateemail'           => array( 'E-Mail_nicht_bestaetigen', 'E-Mail_nicht_bestätigen' ),
	'BlockList'                 => array( 'Liste_der_Sperren', 'Gesperrte_IP-Adressen', 'Gesperrte_IPs' ),
	'LinkSearch'                => array( 'Weblinksuche', 'Weblink-Suche' ),
	'Listadmins'                => array( 'Administratoren' ),
	'Listbots'                  => array( 'Bots' ),
	'Listfiles'                 => array( 'Dateien', 'Dateiliste' ),
	'Listgrouprights'           => array( 'Gruppenrechte' ),
	'Listredirects'             => array( 'Weiterleitungen' ),
	'Listusers'                 => array( 'Benutzer', 'Benutzerliste' ),
	'Lockdb'                    => array( 'Datenbank_sperren' ),
	'Log'                       => array( 'Logbuch' ),
	'Lonelypages'               => array( 'Verwaiste_Seiten' ),
	'Longpages'                 => array( 'Längste_Seiten' ),
	'MergeHistory'              => array( 'Versionsgeschichten_vereinen' ),
	'MIMEsearch'                => array( 'MIME-Typ-Suche' ),
	'Mostcategories'            => array( 'Meistkategorisierte_Seiten' ),
	'Mostimages'                => array( 'Meistbenutzte_Dateien' ),
	'Mostlinked'                => array( 'Meistverlinkte_Seiten' ),
	'Mostlinkedcategories'      => array( 'Meistbenutzte_Kategorien' ),
	'Mostlinkedtemplates'       => array( 'Meistbenutzte_Vorlagen' ),
	'Mostrevisions'             => array( 'Meistbearbeitete_Seiten' ),
	'Movepage'                  => array( 'Verschieben' ),
	'Mycontributions'           => array( 'Meine_Beiträge' ),
	'Mypage'                    => array( 'Meine_Benutzerseite' ),
	'Mytalk'                    => array( 'Meine_Diskussionsseite' ),
	'Myuploads'                 => array( 'Meine_hochgeladenen_Dateien' ),
	'Newimages'                 => array( 'Neue_Dateien' ),
	'Newpages'                  => array( 'Neue_Seiten' ),
	'PasswordReset'             => array( 'Passwort_neu_vergeben' ),
	'PermanentLink'             => array( 'Permanenter_Link', 'Permalink' ),
	'Popularpages'              => array( 'Beliebteste_Seiten' ),
	'Preferences'               => array( 'Einstellungen' ),
	'Prefixindex'               => array( 'Präfixindex' ),
	'Protectedpages'            => array( 'Geschützte_Seiten' ),
	'Protectedtitles'           => array( 'Geschützte_Titel', 'Gesperrte_Titel' ),
	'Randompage'                => array( 'Zufällige_Seite' ),
	'Randomredirect'            => array( 'Zufällige_Weiterleitung' ),
	'Recentchanges'             => array( 'Letzte_Änderungen' ),
	'Recentchangeslinked'       => array( 'Änderungen_an_verlinkten_Seiten' ),
	'Revisiondelete'            => array( 'Versionslöschung' ),
	'RevisionMove'              => array( 'Version_verschieben' ),
	'Search'                    => array( 'Suche' ),
	'Shortpages'                => array( 'Kürzeste_Seiten' ),
	'Specialpages'              => array( 'Spezialseiten' ),
	'Statistics'                => array( 'Statistik' ),
	'Tags'                      => array( 'Kennzeichnungen' ),
	'Unblock'                   => array( 'Freigeben' ),
	'Uncategorizedcategories'   => array( 'Nicht_kategorisierte_Kategorien' ),
	'Uncategorizedimages'       => array( 'Nicht_kategorisierte_Dateien' ),
	'Uncategorizedpages'        => array( 'Nicht_kategorisierte_Seiten' ),
	'Uncategorizedtemplates'    => array( 'Nicht_kategorisierte_Vorlagen' ),
	'Undelete'                  => array( 'Wiederherstellen' ),
	'Unlockdb'                  => array( 'Datenbank_entsperren' ),
	'Unusedcategories'          => array( 'Unbenutzte_Kategorien' ),
	'Unusedimages'              => array( 'Unbenutzte_Dateien' ),
	'Unusedtemplates'           => array( 'Unbenutzte_Vorlagen' ),
	'Unwatchedpages'            => array( 'Ignorierte_Seiten', 'Unbeobachtete_Seiten' ),
	'Upload'                    => array( 'Hochladen' ),
	'UploadStash'               => array( 'Hochladespeicher' ),
	'Userlogin'                 => array( 'Anmelden' ),
	'Userlogout'                => array( 'Abmelden' ),
	'Userrights'                => array( 'Benutzerrechte' ),
	'Wantedcategories'          => array( 'Gewünschte_Kategorien' ),
	'Wantedfiles'               => array( 'Fehlende_Dateien' ),
	'Wantedpages'               => array( 'Gewünschte_Seiten' ),
	'Wantedtemplates'           => array( 'Fehlende_Vorlagen' ),
	'Watchlist'                 => array( 'Beobachtungsliste' ),
	'Whatlinkshere'             => array( 'Linkliste', 'Verweisliste' ),
	'Withoutinterwiki'          => array( 'Fehlende_Interwikis' ),
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

$magicWords = array(
	'redirect'                => array( '0', '#WEITERLEITUNG', '#REDIRECT' ),
	'notoc'                   => array( '0', '__KEIN_INHALTSVERZEICHNIS__', '__NOTOC__' ),
	'nogallery'               => array( '0', '__KEINE_GALERIE__', '__NOGALLERY__' ),
	'forcetoc'                => array( '0', '__INHALTSVERZEICHNIS_ERZWINGEN__', '__FORCETOC__' ),
	'toc'                     => array( '0', '__INHALTSVERZEICHNIS__', '__TOC__' ),
	'noeditsection'           => array( '0', '__ABSCHNITTE_NICHT_BEARBEITEN__', '__NOEDITSECTION__' ),
	'noheader'                => array( '0', '__KEINKOPF__', '__NOHEADER__' ),
	'currentmonth'            => array( '1', 'JETZIGER_MONAT', 'JETZIGER_MONAT_2', 'CURRENTMONTH', 'CURRENTMONTH2' ),
	'currentmonth1'           => array( '1', 'JETZIGER_MONAT_1', 'CURRENTMONTH1' ),
	'currentmonthname'        => array( '1', 'JETZIGER_MONATSNAME', 'CURRENTMONTHNAME' ),
	'currentmonthnamegen'     => array( '1', 'JETZIGER_MONATSNAME_GENITIV', 'CURRENTMONTHNAMEGEN' ),
	'currentmonthabbrev'      => array( '1', 'JETZIGER_MONATSNAME_KURZ', 'CURRENTMONTHABBREV' ),
	'currentday'              => array( '1', 'JETZIGER_KALENDERTAG', 'CURRENTDAY' ),
	'currentday2'             => array( '1', 'JETZIGER_KALENDERTAG_2', 'CURRENTDAY2' ),
	'currentdayname'          => array( '1', 'JETZIGER_WOCHENTAG', 'CURRENTDAYNAME' ),
	'currentyear'             => array( '1', 'JETZIGES_JAHR', 'CURRENTYEAR' ),
	'currenttime'             => array( '1', 'JETZIGE_UHRZEIT', 'CURRENTTIME' ),
	'currenthour'             => array( '1', 'JETZIGE_STUNDE', 'CURRENTHOUR' ),
	'localmonth'              => array( '1', 'LOKALER_MONAT', 'LOKALER_MONAT_2', 'LOCALMONTH', 'LOCALMONTH2' ),
	'localmonth1'             => array( '1', 'LOKALER_MONAT_1', 'LOCALMONTH1' ),
	'localmonthname'          => array( '1', 'LOKALER_MONATSNAME', 'LOCALMONTHNAME' ),
	'localmonthnamegen'       => array( '1', 'LOKALER_MONATSNAME_GENITIV', 'LOCALMONTHNAMEGEN' ),
	'localmonthabbrev'        => array( '1', 'LOKALER_MONATSNAME_KURZ', 'LOCALMONTHABBREV' ),
	'localday'                => array( '1', 'LOKALER_KALENDERTAG', 'LOCALDAY' ),
	'localday2'               => array( '1', 'LOKALER_KALENDERTAG_2', 'LOCALDAY2' ),
	'localdayname'            => array( '1', 'LOKALER_WOCHENTAG', 'LOCALDAYNAME' ),
	'localyear'               => array( '1', 'LOKALES_JAHR', 'LOCALYEAR' ),
	'localtime'               => array( '1', 'LOKALE_UHRZEIT', 'LOCALTIME' ),
	'localhour'               => array( '1', 'LOKALE_STUNDE', 'LOCALHOUR' ),
	'numberofpages'           => array( '1', 'SEITENANZAHL', 'NUMBEROFPAGES' ),
	'numberofarticles'        => array( '1', 'ARTIKELANZAHL', 'NUMBEROFARTICLES' ),
	'numberoffiles'           => array( '1', 'DATEIANZAHL', 'NUMBEROFFILES' ),
	'numberofusers'           => array( '1', 'BENUTZERANZAHL', 'NUMBEROFUSERS' ),
	'numberofactiveusers'     => array( '1', 'AKTIVE_BENUTZER', 'NUMBEROFACTIVEUSERS' ),
	'numberofedits'           => array( '1', 'BEARBEITUNGSANZAHL', 'NUMBEROFEDITS' ),
	'numberofviews'           => array( '1', 'BETRACHTUNGEN', 'NUMBEROFVIEWS' ),
	'pagename'                => array( '1', 'SEITENNAME', 'PAGENAME' ),
	'pagenamee'               => array( '1', 'SEITENNAME_URL', 'PAGENAMEE' ),
	'namespace'               => array( '1', 'NAMENSRAUM', 'NAMESPACE' ),
	'namespacee'              => array( '1', 'NAMENSRAUM_URL', 'NAMESPACEE' ),
	'talkspace'               => array( '1', 'DISKUSSIONSNAMENSRAUM', 'DISK_NR', 'TALKSPACE' ),
	'talkspacee'              => array( '1', 'DISKUSSIONSNAMENSRAUM_URL', 'DISK_NR_URL', 'TALKSPACEE' ),
	'subjectspace'            => array( '1', 'HAUPTNAMENSRAUM', 'SUBJECTSPACE', 'ARTICLESPACE' ),
	'subjectspacee'           => array( '1', 'HAUPTNAMENSRAUM_URL', 'SUBJECTSPACEE', 'ARTICLESPACEE' ),
	'fullpagename'            => array( '1', 'VOLLER_SEITENNAME', 'FULLPAGENAME' ),
	'fullpagenamee'           => array( '1', 'VOLLER_SEITENNAME_URL', 'FULLPAGENAMEE' ),
	'subpagename'             => array( '1', 'UNTERSEITE', 'SUBPAGENAME' ),
	'subpagenamee'            => array( '1', 'UNTERSEITE_URL', 'SUBPAGENAMEE' ),
	'basepagename'            => array( '1', 'OBERSEITE', 'BASEPAGENAME' ),
	'basepagenamee'           => array( '1', 'OBERSEITE_URL', 'BASEPAGENAMEE' ),
	'talkpagename'            => array( '1', 'DISKUSSIONSSEITE', 'DISK', 'TALKPAGENAME' ),
	'talkpagenamee'           => array( '1', 'DISKUSSIONSSEITE_URL', 'DISK_URL', 'TALKPAGENAMEE' ),
	'subjectpagename'         => array( '1', 'HAUPTSEITE', 'SUBJECTPAGENAME', 'ARTICLEPAGENAME' ),
	'subjectpagenamee'        => array( '1', 'HAUPTSEITE_URL', 'SUBJECTPAGENAMEE', 'ARTICLEPAGENAMEE' ),
	'subst'                   => array( '0', 'ERS:', 'SUBST:' ),
	'img_thumbnail'           => array( '1', 'miniatur', 'thumbnail', 'thumb' ),
	'img_manualthumb'         => array( '1', 'miniatur=$1', 'thumbnail=$1', 'thumb=$1' ),
	'img_right'               => array( '1', 'rechts', 'right' ),
	'img_left'                => array( '1', 'links', 'left' ),
	'img_none'                => array( '1', 'ohne', 'none' ),
	'img_center'              => array( '1', 'zentriert', 'center', 'centre' ),
	'img_framed'              => array( '1', 'gerahmt', 'framed', 'enframed', 'frame' ),
	'img_frameless'           => array( '1', 'rahmenlos', 'frameless' ),
	'img_page'                => array( '1', 'seite=$1', 'seite $1', 'page=$1', 'page $1' ),
	'img_upright'             => array( '1', 'hochkant', 'hochkant=$1', 'hochkant $1', 'upright', 'upright=$1', 'upright $1' ),
	'img_border'              => array( '1', 'rand', 'border' ),
	'img_sub'                 => array( '1', 'tiefgestellt', 'sub' ),
	'img_super'               => array( '1', 'hochgestellt', 'super', 'sup' ),
	'img_link'                => array( '1', 'verweis=$1', 'link=$1' ),
	'img_alt'                 => array( '1', 'alternativtext=$1', 'alt=$1' ),
	'int'                     => array( '0', 'NACHRICHT:', 'INT:' ),
	'sitename'                => array( '1', 'PROJEKTNAME', 'SITENAME' ),
	'ns'                      => array( '0', 'NR:', 'NS:' ),
	'nse'                     => array( '0', 'NR_URL:', 'NSE:' ),
	'localurl'                => array( '0', 'LOKALE_URL:', 'LOCALURL:' ),
	'articlepath'             => array( '0', 'ARTIKELPFAD', 'ARTICLEPATH' ),
	'pageid'                  => array( '0', 'SEITENID', 'PAGEID' ),
	'scriptpath'              => array( '0', 'SKRIPTPFAD', 'SCRIPTPATH' ),
	'stylepath'               => array( '0', 'STYLEPFAD', 'STYLEPATH' ),
	'grammar'                 => array( '0', 'GRAMMATIK:', 'GRAMMAR:' ),
	'gender'                  => array( '0', 'GESCHLECHT:', 'GENDER:' ),
	'currentweek'             => array( '1', 'JETZIGE_KALENDERWOCHE', 'CURRENTWEEK' ),
	'currentdow'              => array( '1', 'JETZIGER_WOCHENTAG_ZAHL', 'CURRENTDOW' ),
	'localweek'               => array( '1', 'LOKALE_KALENDERWOCHE', 'LOCALWEEK' ),
	'localdow'                => array( '1', 'LOKALER_WOCHENTAG_ZAHL', 'LOCALDOW' ),
	'revisionid'              => array( '1', 'REVISIONSID', 'REVISIONID' ),
	'revisionday'             => array( '1', 'REVISIONSTAG', 'REVISIONDAY' ),
	'revisionday2'            => array( '1', 'REVISIONSTAG2', 'REVISIONDAY2' ),
	'revisionmonth'           => array( '1', 'REVISIONSMONAT', 'REVISIONMONTH' ),
	'revisionmonth1'          => array( '1', 'REVISIONSMONAT1', 'REVISIONMONTH1' ),
	'revisionyear'            => array( '1', 'REVISIONSJAHR', 'REVISIONYEAR' ),
	'revisiontimestamp'       => array( '1', 'REVISIONSZEITSTEMPEL', 'REVISIONTIMESTAMP' ),
	'revisionuser'            => array( '1', 'REVISIONSBENUTZER', 'REVISIONUSER' ),
	'fullurl'                 => array( '0', 'VOLLSTÄNDIGE_URL:', 'FULLURL:' ),
	'canonicalurl'            => array( '0', 'KANONISCHE_URL:', 'CANONICALURL:' ),
	'lcfirst'                 => array( '0', 'INITIAL_KLEIN:', 'LCFIRST:' ),
	'ucfirst'                 => array( '0', 'INITIAL_GROSS:', 'UCFIRST:' ),
	'lc'                      => array( '0', 'KLEIN:', 'LC:' ),
	'uc'                      => array( '0', 'GROSS:', 'UC:' ),
	'raw'                     => array( '0', 'ROH:', 'RAW:' ),
	'displaytitle'            => array( '1', 'SEITENTITEL', 'DISPLAYTITLE' ),
	'newsectionlink'          => array( '1', '__NEUER_ABSCHNITTSLINK__', '__PLUS_LINK__', '__NEWSECTIONLINK__' ),
	'nonewsectionlink'        => array( '1', '__KEIN_NEUER_ABSCHNITTSLINK__', '__KEIN_PLUS_LINK__', '__NONEWSECTIONLINK__' ),
	'currentversion'          => array( '1', 'JETZIGE_VERSION', 'CURRENTVERSION' ),
	'urlencode'               => array( '0', 'URLENKODIERT:', 'URLENCODE:' ),
	'anchorencode'            => array( '0', 'SPRUNGMARKEENKODIERT:', 'ANCHORENCODE' ),
	'currenttimestamp'        => array( '1', 'JETZIGER_ZEITSTEMPEL', 'CURRENTTIMESTAMP' ),
	'localtimestamp'          => array( '1', 'LOKALER_ZEITSTEMPEL', 'LOCALTIMESTAMP' ),
	'directionmark'           => array( '1', 'TEXTAUSRICHTUNG', 'DIRECTIONMARK', 'DIRMARK' ),
	'language'                => array( '0', '#SPRACHE:', '#LANGUAGE:' ),
	'contentlanguage'         => array( '1', 'INHALTSSPRACHE', 'CONTENTLANGUAGE', 'CONTENTLANG' ),
	'pagesinnamespace'        => array( '1', 'SEITEN_IM_NAMENSRAUM:', 'SEITEN_NR:', 'PAGESINNAMESPACE:', 'PAGESINNS:' ),
	'numberofadmins'          => array( '1', 'ADMINANZAHL', 'NUMBEROFADMINS' ),
	'formatnum'               => array( '0', 'ZAHLENFORMAT', 'FORMATNUM' ),
	'padleft'                 => array( '0', 'FÜLLENLINKS', 'PADLEFT' ),
	'padright'                => array( '0', 'FÜLLENRECHTS', 'PADRIGHT' ),
	'special'                 => array( '0', 'spezial', 'special' ),
	'defaultsort'             => array( '1', 'SORTIERUNG:', 'DEFAULTSORT:', 'DEFAULTSORTKEY:', 'DEFAULTCATEGORYSORT:' ),
	'filepath'                => array( '0', 'DATEIPFAD:', 'FILEPATH:' ),
	'hiddencat'               => array( '1', '__VERSTECKTE_KATEGORIE__', '__WARTUNGSKATEGORIE__', '__HIDDENCAT__' ),
	'pagesincategory'         => array( '1', 'SEITEN_IN_KATEGORIE', 'SEITEN_KAT', 'PAGESINCATEGORY', 'PAGESINCAT' ),
	'pagesize'                => array( '1', 'SEITENGRÖSSE', 'PAGESIZE' ),
	'index'                   => array( '1', '__INDIZIEREN__', '__INDEX__' ),
	'noindex'                 => array( '1', '__NICHT_INDIZIEREN__', '__NOINDEX__' ),
	'numberingroup'           => array( '1', 'BENUTZER_IN_GRUPPE', 'NUMBERINGROUP', 'NUMINGROUP' ),
	'staticredirect'          => array( '1', '__PERMANENTE_WEITERLEITUNG__', '__STATICREDIRECT__' ),
	'protectionlevel'         => array( '1', 'SCHUTZSTATUS', 'PROTECTIONLEVEL' ),
	'formatdate'              => array( '0', 'DATUMSFORMAT', 'formatdate', 'dateformat' ),
);

$imageFiles = array(
	'button-bold'     => 'de/button_bold.png',
	'button-italic'   => 'de/button_italic.png',
);
