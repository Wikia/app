<?php
/** Swiss German (Alemannisch)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Als-Chlämens
 * @author Als-Holder
 * @author Hendergassler
 * @author J. 'mach' wust
 * @author Kaganer
 * @author MaxSem
 * @author Melancholie
 * @author MichaelFrey
 * @author Purodha
 * @author Remember the dot
 * @author Spacebirdy
 * @author Strommops
 * @author The Evil IP address
 * @author Urhixidur
 * @author לערי ריינהארט
 * @author 80686
 */

$fallback = 'de';

$specialPageAliases = array(
	'Allmessages'               => array( 'Alli Nochrichte' ),
	'Allpages'                  => array( 'Alli Syte' ),
	'Ancientpages'              => array( 'Veralteti Syte' ),
	'Blankpage'                 => array( 'Läärsyte' ),
	'Block'                     => array( 'Sperre' ),
	'Blockme'                   => array( 'Proxy-Sperre' ),
	'Booksources'               => array( 'ISBN-Suech' ),
	'BrokenRedirects'           => array( 'Kaputti Wyterlaitige' ),
	'Categories'                => array( 'Kategorie' ),
	'ChangePassword'            => array( 'Passwort ändre' ),
	'Confirmemail'              => array( 'E-Mail bstetige' ),
	'Contributions'             => array( 'Byytreeg' ),
	'CreateAccount'             => array( 'Benutzerchonto aaleege' ),
	'Deadendpages'              => array( 'Sackgassesyte' ),
	'DeletedContributions'      => array( 'Gleschti Byytreeg' ),
	'Disambiguations'           => array( 'Begriffschlärigsverwyys' ),
	'DoubleRedirects'           => array( 'Doppleti Wyterlaitige' ),
	'Emailuser'                 => array( 'E-Mail' ),
	'Export'                    => array( 'Exportiere' ),
	'Fewestrevisions'           => array( 'Syte wo am wenigschte bearbeitet sin' ),
	'FileDuplicateSearch'       => array( 'Datei-Duplikat-Suech' ),
	'Filepath'                  => array( 'Dateipfad' ),
	'Import'                    => array( 'Importiere' ),
	'Invalidateemail'           => array( 'E-Mail nit bstetige' ),
	'BlockList'                 => array( 'Gsperrti IP' ),
	'LinkSearch'                => array( 'Suech no Gleicher' ),
	'Listadmins'                => array( 'Ammanne' ),
	'Listbots'                  => array( 'Bötli' ),
	'Listfiles'                 => array( 'Dateie' ),
	'Listgrouprights'           => array( 'Grupperächt' ),
	'Listredirects'             => array( 'Wyterleitige' ),
	'Listusers'                 => array( 'Benutzerlischte' ),
	'Lockdb'                    => array( 'Datebank sperre' ),
	'Log'                       => array( 'Logbuech' ),
	'Lonelypages'               => array( 'Verwaisti Syte' ),
	'Longpages'                 => array( 'Langi Syte' ),
	'MergeHistory'              => array( 'Versionsgschichte zämefiere' ),
	'MIMEsearch'                => array( 'MIME-Suech' ),
	'Mostcategories'            => array( 'Syte wo am meischte kategorisiert sin' ),
	'Mostimages'                => array( 'Dateie wo am meischte brucht wäre' ),
	'Mostlinked'                => array( 'Syte wo am meischte vergleicht sin' ),
	'Mostlinkedcategories'      => array( 'Kategorie wo am meischte brucht wäre' ),
	'Mostlinkedtemplates'       => array( 'Vorlage wo am meischte brucht wäre' ),
	'Mostrevisions'             => array( 'Syte wo am meischte bearbeitet sin' ),
	'Movepage'                  => array( 'Verschiebe' ),
	'Mycontributions'           => array( 'Myyni Byytreeg' ),
	'Mypage'                    => array( 'Myyni Benutzersyte' ),
	'Mytalk'                    => array( 'Myyni Diskussionssyte' ),
	'Newimages'                 => array( 'Neji Dateie' ),
	'Newpages'                  => array( 'Neji Syte' ),
	'Popularpages'              => array( 'Beliebteschti Syte' ),
	'Preferences'               => array( 'Ystellige' ),
	'Prefixindex'               => array( 'Vorsilbeverzeichnis' ),
	'Protectedpages'            => array( 'Gschitzti Syte' ),
	'Protectedtitles'           => array( 'Gsperrti Titel' ),
	'Randompage'                => array( 'Zuefelligi Syte' ),
	'Randomredirect'            => array( 'Zuefelligi Wyterleitig' ),
	'Recentchanges'             => array( 'Letschti Änderige' ),
	'Recentchangeslinked'       => array( 'Änderige an vergleichte Syte' ),
	'Revisiondelete'            => array( 'Versionsleschig' ),
	'Search'                    => array( 'Suech' ),
	'Shortpages'                => array( 'Churzi Syte' ),
	'Specialpages'              => array( 'Spezialsyte' ),
	'Statistics'                => array( 'Statischtik' ),
	'Uncategorizedcategories'   => array( 'Kategorie wo nit kategorisiert sin' ),
	'Uncategorizedimages'       => array( 'Dateie wo nit kategorisiert sin' ),
	'Uncategorizedpages'        => array( 'Syte wo nit kategorisiert sin' ),
	'Uncategorizedtemplates'    => array( 'Vorlage wo nit kategorisiert sin' ),
	'Undelete'                  => array( 'Widerhärstelle' ),
	'Unlockdb'                  => array( 'Sperrig vu dr Datebank ufhebe' ),
	'Unusedcategories'          => array( 'Kategorie wo nit brucht wäre' ),
	'Unusedimages'              => array( 'Dateie wo nit brucht wäre' ),
	'Unusedtemplates'           => array( 'Vorlage wo nit brucht wäre' ),
	'Unwatchedpages'            => array( 'Syte wu nit beobachtet wäre' ),
	'Upload'                    => array( 'Uffelade' ),
	'Userlogin'                 => array( 'Amälde' ),
	'Userlogout'                => array( 'Abmälde' ),
	'Userrights'                => array( 'Benutzerrächt' ),
	'Wantedcategories'          => array( 'Kategorie wo gwinscht sin' ),
	'Wantedfiles'               => array( 'Dateie wo fähle' ),
	'Wantedpages'               => array( 'Syte wo gwinscht sin' ),
	'Wantedtemplates'           => array( 'Vorlage wo fähle' ),
	'Watchlist'                 => array( 'Beobachtigslischte' ),
	'Whatlinkshere'             => array( 'Was gleicht do ane?' ),
	'Withoutinterwiki'          => array( 'Ohni Interwiki' ),
);

$magicWords = array(
	'displaytitle'            => array( '1', 'SYTETITEL', 'SEITENTITEL', 'DISPLAYTITLE' ),
);

$linkTrail = '/^([äöüßa-z]+)(.*)$/sDu';

