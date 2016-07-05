<?php
/** Sicilian (Sicilianu)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Aushulz
 * @author Gmelfi
 * @author Kaganer
 * @author Melos
 * @author Omnipaedista
 * @author Santu
 * @author Sarvaturi
 * @author Tonyfroio
 * @author Urhixidur
 * @author לערי ריינהארט
 */

$fallback = 'it';

$namespaceNames = array(
	NS_MEDIA            => 'Mèdia',
	NS_SPECIAL          => 'Spiciali',
	NS_TALK             => 'Discussioni',
	NS_USER             => 'Utenti',
	NS_USER_TALK        => 'Discussioni_utenti',
	NS_PROJECT_TALK     => 'Discussioni_$1',
	NS_FILE             => 'File',
	NS_FILE_TALK        => 'Discussioni_file',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'Discussioni_MediaWiki',
	NS_TEMPLATE         => 'Template',
	NS_TEMPLATE_TALK    => 'Discussioni_template',
	NS_HELP             => 'Aiutu',
	NS_HELP_TALK        => 'Discussioni_aiutu',
	NS_CATEGORY         => 'Catigurìa',
	NS_CATEGORY_TALK    => 'Discussioni_catigurìa',
);

$namespaceAliases = array(
	'Discussioni_Utenti' => NS_USER_TALK,
	'Mmàggini' => NS_FILE,
	'Discussioni mmàggini' => NS_FILE_TALK,
	'Discussioni_Template' => NS_TEMPLATE_TALK,
	'Discussioni_Aiutu' => NS_HELP_TALK,
	'Discussioni_Catigurìa' => NS_CATEGORY_TALK,
);

$specialPageAliases = array(
	'Allmessages'               => array( 'Missaggi' ),
	'Allpages'                  => array( 'TuttiLiPàggini' ),
	'Ancientpages'              => array( 'PàgginiMenuNovi' ),
	'Blankpage'                 => array( 'PàgginaVacanti' ),
	'Block'                     => array( 'Blocca' ),
	'Blockme'                   => array( 'BloccaProxy' ),
	'Booksources'               => array( 'RicercaISBN' ),
	'BrokenRedirects'           => array( 'RinnirizzamentiSbagghiati' ),
	'Categories'                => array( 'Catigurìi' ),
	'ChangePassword'            => array( 'RimpostaPassword' ),
	'Confirmemail'              => array( 'CunfermaEmail' ),
	'Contributions'             => array( 'Cuntribbuti', 'CuntribbutiUtenti' ),
	'CreateAccount'             => array( 'CrìatiNuCuntu' ),
	'Deadendpages'              => array( 'PàgginiSenzaNisciuta' ),
	'DeletedContributions'      => array( 'CuntribbutiScancillati' ),
	'Disambiguations'           => array( 'Disambiguazzioni' ),
	'DoubleRedirects'           => array( 'RinnirizzamentiDuppi' ),
	'Emailuser'                 => array( 'MannaEmail' ),
	'Export'                    => array( 'Esporta' ),
	'Fewestrevisions'           => array( 'PàgginiCuCchiùPiccaRivisioni' ),
	'Import'                    => array( 'Mporta' ),
	'BlockList'                 => array( 'IPBluccati' ),
	'LinkSearch'                => array( 'CercaCullicamenti' ),
	'Listadmins'                => array( 'Amministratura' ),
	'Listbots'                  => array( 'ListaBot' ),
	'Listfiles'                 => array( 'Mmàggini' ),
	'Listgrouprights'           => array( 'AlencuPirmessiGruppi' ),
	'Listredirects'             => array( 'Rinnirizzamenti', 'ListaRinnirizzamenti' ),
	'Listusers'                 => array( 'Utilizzatura', 'ListaUtilizzatura' ),
	'Lockdb'                    => array( 'BloccaDB', 'BloccaDatabase' ),
	'Log'                       => array( 'Riggistri', 'Riggistru' ),
	'Lonelypages'               => array( 'PàgginiOrfani' ),
	'Longpages'                 => array( 'PàgginiCchiùLonghi' ),
	'MergeHistory'              => array( 'UnìficaCrunuluggìa' ),
	'MIMEsearch'                => array( 'RicercaMIME' ),
	'Mostcategories'            => array( 'PàgginiCuCchiossaiCatigurìi' ),
	'Mostimages'                => array( 'MmàgginiCchiùRichiamati' ),
	'Mostlinked'                => array( 'PàgginiCchiùRichiamati' ),
	'Mostlinkedcategories'      => array( 'CatigurìiCchiùRichiamati' ),
	'Mostlinkedtemplates'       => array( 'TemplateCchiùRichiamati' ),
	'Mostrevisions'             => array( 'PàgginiCuCchiossaiRivisioni' ),
	'Movepage'                  => array( 'Sposta', 'Rinòmina' ),
	'Mycontributions'           => array( 'CuntribbutiMei' ),
	'Mypage'                    => array( 'MèPàgginaUtenti' ),
	'Mytalk'                    => array( 'DiscussioniMei' ),
	'Newimages'                 => array( 'MmàgginiRicenti' ),
	'Newpages'                  => array( 'PàgginiCchiùNovi' ),
	'Popularpages'              => array( 'PàgginiCchiùVisitati' ),
	'Preferences'               => array( 'Prifirenzi' ),
	'Prefixindex'               => array( 'Prifissi' ),
	'Protectedpages'            => array( 'PàgginiPrutiggiuti' ),
	'Protectedtitles'           => array( 'TìtuliPrutiggiuti' ),
	'Randompage'                => array( 'PàgginaAmmuzzu' ),
	'Randomredirect'            => array( 'RedirectAmmuzzu' ),
	'Recentchanges'             => array( 'ÙrtimiCanciamenti' ),
	'Recentchangeslinked'       => array( 'CanciamentiCurrilati' ),
	'Revisiondelete'            => array( 'ScancellaRivisioni' ),
	'Search'                    => array( 'Ricerca', 'Cerca' ),
	'Shortpages'                => array( 'PàgginiCchiùCurti' ),
	'Specialpages'              => array( 'PàgginiSpiciali' ),
	'Statistics'                => array( 'Statìstichi' ),
	'Uncategorizedcategories'   => array( 'CatigurìiSenzaCatigurìi' ),
	'Uncategorizedimages'       => array( 'MmàgginiSenzaCatigurìi' ),
	'Uncategorizedpages'        => array( 'PàgginiSenzaCatigurìi' ),
	'Uncategorizedtemplates'    => array( 'TemplateSenzaCatigurìi' ),
	'Undelete'                  => array( 'Riprìstina' ),
	'Unlockdb'                  => array( 'SbloccaDB', 'SbloccaDatabase' ),
	'Unusedcategories'          => array( 'CatigurìiNonUsati' ),
	'Unusedimages'              => array( 'MmàgginiNonUsati' ),
	'Unusedtemplates'           => array( 'TemplateNunUsati' ),
	'Unwatchedpages'            => array( 'PàgginiNunTaliati' ),
	'Upload'                    => array( 'Càrrica' ),
	'Userlogin'                 => array( 'Tràsi', 'Login' ),
	'Userlogout'                => array( 'Nesci', 'Logout' ),
	'Userrights'                => array( 'PirmessiUtenti' ),
	'Version'                   => array( 'Virsioni' ),
	'Wantedcategories'          => array( 'CatigurìiAddumannati' ),
	'Wantedfiles'               => array( 'FileAddumannati' ),
	'Wantedpages'               => array( 'PàgginiAddumannati' ),
	'Wantedtemplates'           => array( 'TemplateAddumannati' ),
	'Watchlist'                 => array( 'ArtìculiTaliati' ),
	'Whatlinkshere'             => array( 'ChiPuntaCcà' ),
	'Withoutinterwiki'          => array( 'SenzaInterwiki' ),
);

