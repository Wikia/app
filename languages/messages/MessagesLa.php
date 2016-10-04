<?php
/** Latin (Latina)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Andrew Dalby
 * @author Dferg
 * @author Esteban97
 * @author Kaganer
 * @author LeighvsOptimvsMaximvs
 * @author McDutchie
 * @author MissPetticoats
 * @author Omnipaedista
 * @author OrbiliusMagister
 * @author Ornil
 * @author Rafaelgarcia
 * @author SPQRobin
 * @author UV
 * @author Žekřil71pl
 * @author לערי ריינהארט
 */

$namespaceNames = array(
	NS_SPECIAL          => 'Specialis',
	NS_TALK             => 'Disputatio',
	NS_USER             => 'Usor',
	NS_USER_TALK        => 'Disputatio_Usoris',
	NS_PROJECT_TALK     => 'Disputatio_{{GRAMMAR:genitive|$1}}',
	NS_FILE             => 'Fasciculus',
	NS_FILE_TALK        => 'Disputatio_Fasciculi',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'Disputatio_MediaWiki',
	NS_TEMPLATE         => 'Formula',
	NS_TEMPLATE_TALK    => 'Disputatio_Formulae',
	NS_HELP             => 'Auxilium',
	NS_HELP_TALK        => 'Disputatio_Auxilii',
	NS_CATEGORY         => 'Categoria',
	NS_CATEGORY_TALK    => 'Disputatio_Categoriae',
);

$namespaceAliases = array(
	'Imago' => NS_FILE,
	'Disputatio_Imaginis' => NS_FILE_TALK,
);

$separatorTransformTable = array( ',' => "\xc2\xa0" );

$dateFormats = array(
	'mdy time' => 'H:i',
	'mdy date' => 'xg j, Y',
	'mdy both' => 'H:i, xg j, Y',

	'dmy time' => 'H:i',
	'dmy date' => 'j xg Y',
	'dmy both' => 'H:i, j xg Y',

	'ymd time' => 'H:i',
	'ymd date' => 'Y xg j',
	'ymd both' => 'H:i, Y xg j',

	'ISO 8601 time' => 'xnH:xni:xns',
	'ISO 8601 date' => 'xnY-xnm-xnd',
	'ISO 8601 both' => 'xnY-xnm-xnd"T"xnH:xni:xns',
);

$specialPageAliases = array(
	'Allmessages'               => array( 'Nuntia systematis' ),
	'Allpages'                  => array( 'Paginae omnes', 'Omnes paginae' ),
	'Ancientpages'              => array( 'Paginae veterrimae' ),
	'Blankpage'                 => array( 'Pagina vacua' ),
	'Block'                     => array( 'Usorem obstruere' ),
	'Blockme'                   => array( 'Usor obstructus' ),
	'Booksources'               => array( 'Librorum fontes' ),
	'BrokenRedirects'           => array( 'Redirectiones fractae' ),
	'Categories'                => array( 'Categoriae' ),
	'ChangePassword'            => array( 'Tesseram novam creare' ),
	'Confirmemail'              => array( 'Inscriptionem electronicam confirmare' ),
	'Contributions'             => array( 'Conlationes', 'Conlationes usoris' ),
	'CreateAccount'             => array( 'Rationem creare' ),
	'Deadendpages'              => array( 'Paginae sine nexu' ),
	'DeletedContributions'      => array( 'Conlationes deletae', 'Conlationes usoris deletae' ),
	'Disambiguations'           => array( 'Paginae disambiguationis', 'Disambiguationes' ),
	'DoubleRedirects'           => array( 'Redirectiones duplices' ),
	'Emailuser'                 => array( 'Litteras electronicas usori mittere', 'Littera electronica' ),
	'Export'                    => array( 'Exportare', 'Paginas exportare' ),
	'Fewestrevisions'           => array( 'Paginae minime mutatae' ),
	'FileDuplicateSearch'       => array( 'Quaerere fasciculos duplices', 'Quaerere imagines duplices' ),
	'Import'                    => array( 'Importare', 'Paginas importare' ),
	'Invalidateemail'           => array( 'Adfimationem inscriptionis electronicae abrogare' ),
	'BlockList'                 => array( 'Usores obstructi' ),
	'LinkSearch'                => array( 'Quaerere nexus externos' ),
	'Listadmins'                => array( 'Magistratus' ),
	'Listbots'                  => array( 'Automata' ),
	'Listfiles'                 => array( 'Fasciculi', 'Imagines' ),
	'Listgrouprights'           => array( 'Gregum usorum potestates', 'Iura gregum' ),
	'Listredirects'             => array( 'Redirectiones' ),
	'Listusers'                 => array( 'Usores' ),
	'Lockdb'                    => array( 'Basem datorum obstruere' ),
	'Log'                       => array( 'Acta' ),
	'Lonelypages'               => array( 'Paginae non annexae' ),
	'Longpages'                 => array( 'Paginae longae' ),
	'MergeHistory'              => array( 'Historias paginarum confundere' ),
	'MIMEsearch'                => array( 'Quaerere per MIME' ),
	'Mostcategories'            => array( 'Paginae plurimis categoriis' ),
	'Mostimages'                => array( 'Fasciculi maxime annexi', 'Imagines maxime annexae' ),
	'Mostlinked'                => array( 'Paginae maxime annexae' ),
	'Mostlinkedcategories'      => array( 'Categoriae maxime annexae' ),
	'Mostlinkedtemplates'       => array( 'Formulae maxime annexae' ),
	'Mostrevisions'             => array( 'Paginae plurimum mutatae' ),
	'Movepage'                  => array( 'Paginam movere', 'Movere' ),
	'Mycontributions'           => array( 'Conlationes meae' ),
	'Mypage'                    => array( 'Pagina mea' ),
	'Mytalk'                    => array( 'Disputatio mea' ),
	'Newimages'                 => array( 'Fasciculi novi', 'Imagines novae' ),
	'Newpages'                  => array( 'Paginae novae' ),
	'Popularpages'              => array( 'Paginae saepe monstratae' ),
	'Preferences'               => array( 'Praeferentiae' ),
	'Prefixindex'               => array( 'Praefixa', 'Quaerere per praefixa' ),
	'Protectedpages'            => array( 'Paginae protectae' ),
	'Protectedtitles'           => array( 'Tituli protecti' ),
	'Randompage'                => array( 'Pagina fortuita' ),
	'Randomredirect'            => array( 'Redirectio fortuita' ),
	'Recentchanges'             => array( 'Nuper mutata', 'Mutationes recentes' ),
	'Recentchangeslinked'       => array( 'Nuper mutata annexorum' ),
	'Revisiondelete'            => array( 'Emendationem delere' ),
	'Search'                    => array( 'Quaerere' ),
	'Shortpages'                => array( 'Paginae breves' ),
	'Specialpages'              => array( 'Paginae speciales' ),
	'Statistics'                => array( 'Census' ),
	'Uncategorizedcategories'   => array( 'Categoriae sine categoriis' ),
	'Uncategorizedimages'       => array( 'Fasciculi sine categoriis', 'Imagines sine categoriis' ),
	'Uncategorizedpages'        => array( 'Paginae sine categoriis' ),
	'Uncategorizedtemplates'    => array( 'Formulae sine categoriis' ),
	'Undelete'                  => array( 'Paginam restituere' ),
	'Unlockdb'                  => array( 'Basem datorum deobstruere' ),
	'Unusedcategories'          => array( 'Categoriae non in usu', 'Categoriae vacuae' ),
	'Unusedimages'              => array( 'Fasciculi non in usu', 'Imagines non in usu' ),
	'Unusedtemplates'           => array( 'Formulae non in usu' ),
	'Unwatchedpages'            => array( 'Paginae incustoditae' ),
	'Upload'                    => array( 'Fasciculos onerare', 'Imagines onerare' ),
	'Userlogin'                 => array( 'Conventum aperire' ),
	'Userlogout'                => array( 'Conventum concludere' ),
	'Userrights'                => array( 'Usorum potestates', 'Iura usorum' ),
	'Version'                   => array( 'Versio' ),
	'Wantedcategories'          => array( 'Categoriae desideratae' ),
	'Wantedfiles'               => array( 'Fasciculi desiderati', 'Imagines desideratae' ),
	'Wantedpages'               => array( 'Paginae desideratae', 'Nexus fracti' ),
	'Wantedtemplates'           => array( 'Formulae desideratae' ),
	'Watchlist'                 => array( 'Paginae custoditae' ),
	'Whatlinkshere'             => array( 'Nexus ad paginam' ),
	'Withoutinterwiki'          => array( 'Paginae sine nexibus ad linguas alias', 'Paginae sine nexibus intervicis' ),
);

