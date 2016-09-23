<?php
/** Italian (Italiano)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author .anaconda
 * @author Airon90
 * @author Amire80
 * @author Andria
 * @author Aushulz
 * @author Beta16
 * @author Blaisorblade
 * @author Broc
 * @author BrokenArrow
 * @author Brownout
 * @author Candalua
 * @author Civvì
 * @author Cruccone
 * @author Cryptex
 * @author Dakrismeno
 * @author Danmaz74
 * @author Darth Kule
 * @author F. Cosoleto
 * @author Felis
 * @author FollowTheMedia
 * @author Gianfranco
 * @author HalphaZ
 * @author Kaganer
 * @author Klutzy
 * @author Marco 27
 * @author Martorell
 * @author Marzedu
 * @author McDutchie
 * @author Melos
 * @author Nemo bis
 * @author Nick1915
 * @author Ninniuz
 * @author Od1n
 * @author Oile11
 * @author Omnipaedista
 * @author PaoloRomano
 * @author Pietrodn
 * @author Pinodd
 * @author Ramac
 * @author Raoli
 * @author Remember the dot
 * @author Rippitippi
 * @author S.Örvarr.S
 * @author SabineCretella
 * @author Stefano-c
 * @author Tonyfroio
 * @author Trixt
 * @author Una giornata uggiosa '94
 * @author Vajotwo
 * @author Valepert
 * @author Xpensive
 * @author ZioNicco
 * @author לערי ריינהארט
 */

$namespaceNames = array(
	NS_MEDIA            => 'Media',
	NS_SPECIAL          => 'Speciale',
	NS_TALK             => 'Discussione',
	NS_USER             => 'Utente',
	NS_USER_TALK        => 'Discussioni_utente',
	NS_PROJECT_TALK     => 'Discussioni_$1',
	NS_FILE             => 'File',
	NS_FILE_TALK        => 'Discussioni_file',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'Discussioni_MediaWiki',
	NS_TEMPLATE         => 'Template',
	NS_TEMPLATE_TALK    => 'Discussioni_template',
	NS_HELP             => 'Aiuto',
	NS_HELP_TALK        => 'Discussioni_aiuto',
	NS_CATEGORY         => 'Categoria',
	NS_CATEGORY_TALK    => 'Discussioni_categoria',
);

$namespaceAliases = array(
	'Immagine' => NS_FILE,
	'Discussioni_immagine' => NS_FILE_TALK,
);

$separatorTransformTable = array( ',' => "\xc2\xa0", '.' => ',' );

$dateFormats = array(
	'mdy time' => 'H:i',
	'mdy date' => 'M j, Y',
	'mdy both' => 'H:i, M j, Y',

	'dmy time' => 'H:i',
	'dmy date' => 'j M Y',
	'dmy both' => 'H:i, j M Y',

	'ymd time' => 'H:i',
	'ymd date' => 'Y M j',
	'ymd both' => 'H:i, Y M j',
);

$specialPageAliases = array(
	'Activeusers'               => array( 'UtentiAttivi' ),
	'Allmessages'               => array( 'Messaggi' ),
	'Allpages'                  => array( 'TutteLePagine' ),
	'Ancientpages'              => array( 'PagineMenoRecenti' ),
	'Badtitle'                  => array( 'TitoloErrato' ),
	'Blankpage'                 => array( 'PaginaVuota' ),
	'Block'                     => array( 'Blocca' ),
	'Blockme'                   => array( 'BloccaProxy' ),
	'Booksources'               => array( 'RicercaISBN' ),
	'BrokenRedirects'           => array( 'RedirectErrati' ),
	'Categories'                => array( 'Categorie' ),
	'ChangePassword'            => array( 'CambiaPassword' ),
	'ComparePages'              => array( 'ComparaPagine' ),
	'Confirmemail'              => array( 'ConfermaEMail' ),
	'Contributions'             => array( 'Contributi', 'ContributiUtente' ),
	'CreateAccount'             => array( 'CreaAccount' ),
	'Deadendpages'              => array( 'PagineSenzaUscita' ),
	'DeletedContributions'      => array( 'ContributiCancellati' ),
	'Disambiguations'           => array( 'Disambigua', 'Disambigue' ),
	'DoubleRedirects'           => array( 'RedirectDoppi' ),
	'EditWatchlist'             => array( 'ModifcaListaSeguiti' ),
	'Emailuser'                 => array( 'InviaEMail' ),
	'Export'                    => array( 'Esporta' ),
	'Fewestrevisions'           => array( 'PagineConMenoRevisioni' ),
	'FileDuplicateSearch'       => array( 'CercaFileDuplicati' ),
	'Filepath'                  => array( 'Percorso' ),
	'Import'                    => array( 'Importa' ),
	'Invalidateemail'           => array( 'InvalidaEMail' ),
	'BlockList'                 => array( 'IPBloccati', 'ElencoBlocchi', 'Blocchi' ),
	'LinkSearch'                => array( 'CercaCollegamenti' ),
	'Listadmins'                => array( 'Amministratori', 'ElencoAmministratori', 'Admin' ),
	'Listbots'                  => array( 'Bot', 'ElencoBot' ),
	'Listfiles'                 => array( 'File', 'Immagini' ),
	'Listgrouprights'           => array( 'ElencoPermessiGruppi' ),
	'Listredirects'             => array( 'Redirect', 'ElencoRedirect' ),
	'Listusers'                 => array( 'Utenti', 'ElencoUtenti' ),
	'Lockdb'                    => array( 'BloccaDB' ),
	'Log'                       => array( 'Registri', 'Registro' ),
	'Lonelypages'               => array( 'PagineOrfane' ),
	'Longpages'                 => array( 'PaginePiùLunghe' ),
	'MergeHistory'              => array( 'FondiCronologia', 'UnificaCronologia' ),
	'MIMEsearch'                => array( 'RicercaMIME' ),
	'Mostcategories'            => array( 'PagineConPiùCategorie' ),
	'Mostimages'                => array( 'ImmaginiPiùRichiamate' ),
	'Mostlinked'                => array( 'PaginePiùRichiamate' ),
	'Mostlinkedcategories'      => array( 'CategoriePiùRichiamate' ),
	'Mostlinkedtemplates'       => array( 'TemplatePiùRichiamati' ),
	'Mostrevisions'             => array( 'PagineConPiùRevisioni' ),
	'Movepage'                  => array( 'Sposta', 'Rinomina' ),
	'Mycontributions'           => array( 'MieiContributi' ),
	'Mypage'                    => array( 'MiaPaginaUtente', 'MiaPagina' ),
	'Mytalk'                    => array( 'MieDiscussioni' ),
	'Myuploads'                 => array( 'MieiUpload' ),
	'Newimages'                 => array( 'ImmaginiRecenti' ),
	'Newpages'                  => array( 'PaginePiùRecenti' ),
	'PasswordReset'             => array( 'ReimpostaPassword' ),
	'Popularpages'              => array( 'PaginePiùVisitate' ),
	'Preferences'               => array( 'Preferenze' ),
	'Prefixindex'               => array( 'Prefissi' ),
	'Protectedpages'            => array( 'PagineProtette' ),
	'Protectedtitles'           => array( 'TitoliProtetti' ),
	'Randompage'                => array( 'PaginaCasuale' ),
	'Randomredirect'            => array( 'RedirectCasuale' ),
	'Recentchanges'             => array( 'UltimeModifiche' ),
	'Recentchangeslinked'       => array( 'ModificheCorrelate' ),
	'Revisiondelete'            => array( 'CancellaRevisione' ),
	'Search'                    => array( 'Ricerca', 'Cerca' ),
	'Shortpages'                => array( 'PaginePiùCorte' ),
	'Specialpages'              => array( 'PagineSpeciali' ),
	'Statistics'                => array( 'Statistiche' ),
	'Tags'                      => array( 'Etichette' ),
	'Unblock'                   => array( 'ElencoSblocchi', 'Sblocchi' ),
	'Uncategorizedcategories'   => array( 'CategorieSenzaCategorie' ),
	'Uncategorizedimages'       => array( 'ImmaginiSenzaCategorie' ),
	'Uncategorizedpages'        => array( 'PagineSenzaCategorie' ),
	'Uncategorizedtemplates'    => array( 'TemplateSenzaCategorie' ),
	'Undelete'                  => array( 'Ripristina' ),
	'Unlockdb'                  => array( 'SbloccaDB' ),
	'Unusedcategories'          => array( 'CategorieNonUsate', 'CategorieVuote' ),
	'Unusedimages'              => array( 'ImmaginiNonUsate' ),
	'Unusedtemplates'           => array( 'TemplateNonUsati' ),
	'Unwatchedpages'            => array( 'PagineNonOsservate' ),
	'Upload'                    => array( 'Carica' ),
	'Userlogin'                 => array( 'Entra', 'Login' ),
	'Userlogout'                => array( 'Esci', 'Logout' ),
	'Userrights'                => array( 'PermessiUtente' ),
	'Version'                   => array( 'Versione' ),
	'Wantedcategories'          => array( 'CategorieRichieste' ),
	'Wantedfiles'               => array( 'FileRichiesti' ),
	'Wantedpages'               => array( 'PagineRichieste' ),
	'Wantedtemplates'           => array( 'TemplateRichiesti' ),
	'Watchlist'                 => array( 'OsservatiSpeciali' ),
	'Whatlinkshere'             => array( 'PuntanoQui' ),
	'Withoutinterwiki'          => array( 'PagineSenzaInterwiki' ),
);

$magicWords = array(
	'redirect'                => array( '0', '#RINVIA', '#RINVIO', '#RIMANDO', '#REDIRECT' ),
	'currentmonth'            => array( '1', 'MESECORRENTE', 'CURRENTMONTH', 'CURRENTMONTH2' ),
	'currentmonthname'        => array( '1', 'NOMEMESECORRENTE', 'CURRENTMONTHNAME' ),
	'currentmonthnamegen'     => array( '1', 'NOMEMESECORRENTEGEN', 'CURRENTMONTHNAMEGEN' ),
	'currentmonthabbrev'      => array( '1', 'MESECORRENTEABBREV', 'CURRENTMONTHABBREV' ),
	'currentday'              => array( '1', 'GIORNOCORRENTE', 'CURRENTDAY' ),
	'currentday2'             => array( '1', 'GIORNOCORRENTE2', 'CURRENTDAY2' ),
	'currentdayname'          => array( '1', 'NOMEGIORNOCORRENTE', 'CURRENTDAYNAME' ),
	'currentyear'             => array( '1', 'ANNOCORRENTE', 'CURRENTYEAR' ),
	'currenttime'             => array( '1', 'ORARIOATTUALE', 'CURRENTTIME' ),
	'currenthour'             => array( '1', 'ORACORRENTE', 'CURRENTHOUR' ),
	'localmonth'              => array( '1', 'MESELOCALE', 'LOCALMONTH', 'LOCALMONTH2' ),
	'localmonthname'          => array( '1', 'NOMEMESELOCALE', 'LOCALMONTHNAME' ),
	'localmonthnamegen'       => array( '1', 'NOMEMESELOCALEGEN', 'LOCALMONTHNAMEGEN' ),
	'localmonthabbrev'        => array( '1', 'MESELOCALEABBREV', 'LOCALMONTHABBREV' ),
	'localday'                => array( '1', 'GIORNOLOCALE', 'LOCALDAY' ),
	'localday2'               => array( '1', 'GIORNOLOCALE2', 'LOCALDAY2' ),
	'localdayname'            => array( '1', 'NOMEGIORNOLOCALE', 'LOCALDAYNAME' ),
	'localyear'               => array( '1', 'ANNOLOCALE', 'LOCALYEAR' ),
	'localtime'               => array( '1', 'ORARIOLOCALE', 'LOCALTIME' ),
	'localhour'               => array( '1', 'ORALOCALE', 'LOCALHOUR' ),
	'numberofpages'           => array( '1', 'NUMEROPAGINE', 'NUMBEROFPAGES' ),
	'numberofarticles'        => array( '1', 'NUMEROARTICOLI', 'NUMBEROFARTICLES' ),
	'numberoffiles'           => array( '1', 'NUMEROFILE', 'NUMBEROFFILES' ),
	'numberofusers'           => array( '1', 'NUMEROUTENTI', 'NUMBEROFUSERS' ),
	'numberofactiveusers'     => array( '1', 'NUMEROUTENTIATTIVI', 'NUMBEROFACTIVEUSERS' ),
	'numberofedits'           => array( '1', 'NUMEROEDIT', 'NUMBEROFEDITS' ),
	'numberofviews'           => array( '1', 'NUMEROVISITE', 'NUMBEROFVIEWS' ),
	'pagename'                => array( '1', 'TITOLOPAGINA', 'PAGENAME' ),
	'pagenamee'               => array( '1', 'TITOLOPAGINAE', 'PAGENAMEE' ),
	'subpagename'             => array( '1', 'NOMESOTTOPAGINA', 'SUBPAGENAME' ),
	'subpagenamee'            => array( '1', 'NOMESOTTOPAGINAE', 'SUBPAGENAMEE' ),
	'subst'                   => array( '0', 'SOST:', 'SUBST:' ),
	'img_right'               => array( '1', 'destra', 'right' ),
	'img_left'                => array( '1', 'sinistra', 'left' ),
	'img_none'                => array( '1', 'nessuno', 'none' ),
	'img_center'              => array( '1', 'centro', 'center', 'centre' ),
	'img_page'                => array( '1', 'pagina=$1', 'pagina $1', 'page=$1', 'page $1' ),
	'img_border'              => array( '1', 'bordo', 'border' ),
	'sitename'                => array( '1', 'NOMESITO', 'SITENAME' ),
	'servername'              => array( '0', 'NOMESERVER', 'SERVERNAME' ),
	'gender'                  => array( '0', 'GENERE:', 'GENDER:' ),
	'currentweek'             => array( '1', 'SETTIMANACORRENTE', 'CURRENTWEEK' ),
	'localweek'               => array( '1', 'SETTIMANALOCALE', 'LOCALWEEK' ),
	'plural'                  => array( '0', 'PLURALE:', 'PLURAL:' ),
	'language'                => array( '0', '#LINGUA', '#LANGUAGE:' ),
	'numberofadmins'          => array( '1', 'NUMEROADMIN', 'NUMBEROFADMINS' ),
	'special'                 => array( '0', 'speciale', 'special' ),
	'pagesincategory'         => array( '1', 'PAGINEINCAT', 'PAGESINCATEGORY', 'PAGESINCAT' ),
	'pagesize'                => array( '1', 'DIMENSIONEPAGINA', 'PESOPAGINA', 'PAGESIZE' ),
	'index'                   => array( '1', '__INDICE__', '__INDEX__' ),
	'noindex'                 => array( '1', '__NOINDICE__', '__NOINDEX__' ),
	'protectionlevel'         => array( '1', 'LIVELLOPROTEZIONE', 'PROTECTIONLEVEL' ),
);

$linkTrail = '/^([a-zàéèíîìóòúù]+)(.*)$/sDu';
