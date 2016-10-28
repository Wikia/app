<?php
/** Catalan (Català)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Aleator
 * @author Avm99963
 * @author BroOk
 * @author Cedric31
 * @author Davidpar
 * @author El libre
 * @author Gemmaa
 * @author Iradigalesc
 * @author Jordi Roqué
 * @author Juanpabl
 * @author Kaganer
 * @author Martorell
 * @author McDutchie
 * @author Pasqual (ca)
 * @author Paucabot
 * @author PerroVerd
 * @author Pérez
 * @author Qllach
 * @author SMP
 * @author Smeira
 * @author Solde
 * @author Spacebirdy
 * @author Ssola
 * @author Toniher
 * @author Vriullop
 * @author לערי ריינהארט
 */

$bookstoreList = array(
	'Catàleg Col·lectiu de les Universitats de Catalunya' => 'http://ccuc.cbuc.es/cgi-bin/vtls.web.gateway?searchtype=control+numcard&searcharg=$1',
	'Totselsllibres.com' => 'http://www.totselsllibres.com/tel/publi/busquedaAvanzadaLibros.do?ISBN=$1',
	'inherit' => true,
);

$namespaceNames = array(
	NS_MEDIA            => 'Media',
	NS_SPECIAL          => 'Especial',
	NS_TALK             => 'Discussió',
	NS_USER             => 'Usuari',
	NS_USER_TALK        => 'Usuari_Discussió',
	NS_PROJECT_TALK     => '$1_Discussió',
	NS_FILE             => 'Fitxer',
	NS_FILE_TALK        => 'Fitxer_Discussió',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'MediaWiki_Discussió',
	NS_TEMPLATE         => 'Plantilla',
	NS_TEMPLATE_TALK    => 'Plantilla_Discussió',
	NS_HELP             => 'Ajuda',
	NS_HELP_TALK        => 'Ajuda_Discussió',
	NS_CATEGORY         => 'Categoria',
	NS_CATEGORY_TALK    => 'Categoria_Discussió',
);

$namespaceAliases = array(
	'Imatge' => NS_FILE,
	'Imatge_Discussió' => NS_FILE_TALK,
);

$separatorTransformTable = array( ',' => '.', '.' => ',' );

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

$magicWords = array(
	'numberofarticles'        => array( '1', 'NOMBRED\'ARTICLES', 'NUMBEROFARTICLES' ),
	'numberoffiles'           => array( '1', 'NOMBRED\'ARXIUS', 'NUMBEROFFILES' ),
	'numberofusers'           => array( '1', 'NOMBRED\'USUARIS', 'NUMBEROFUSERS' ),
	'numberofedits'           => array( '1', 'NOMBRED\'EDICIONS', 'NUMBEROFEDITS' ),
	'pagename'                => array( '1', 'NOMDELAPLANA', 'PAGENAME' ),
	'img_right'               => array( '1', 'dreta', 'right' ),
	'img_left'                => array( '1', 'esquerra', 'left' ),
	'img_border'              => array( '1', 'vora', 'border' ),
	'img_link'                => array( '1', 'enllaç=$1', 'link=$1' ),
	'displaytitle'            => array( '1', 'TÍTOL', 'DISPLAYTITLE' ),
	'language'                => array( '0', '#IDIOMA:', '#LANGUAGE:' ),
	'special'                 => array( '0', 'especial', 'special' ),
	'defaultsort'             => array( '1', 'ORDENA:', 'DEFAULTSORT:', 'DEFAULTSORTKEY:', 'DEFAULTCATEGORYSORT:' ),
	'pagesize'                => array( '1', 'MIDADELAPLANA', 'PAGESIZE' ),
);

$specialPageAliases = array(
	'Allmessages'               => array( 'Missatges', 'MediaWiki' ),
	'Allpages'                  => array( 'Llista de pàgines' ),
	'Ancientpages'              => array( 'Pàgines velles' ),
	'Blankpage'                 => array( 'Pàgina en blanc', 'Blanc' ),
	'Block'                     => array( 'Bloca' ),
	'Blockme'                   => array( 'Bloca\'m' ),
	'Booksources'               => array( 'Fonts bibliogràfiques' ),
	'BrokenRedirects'           => array( 'Redireccions rompudes' ),
	'ChangePassword'            => array( 'Reinicia contrasenya' ),
	'Confirmemail'              => array( 'Confirma adreça' ),
	'Contributions'             => array( 'Contribucions' ),
	'CreateAccount'             => array( 'Crea compte' ),
	'Deadendpages'              => array( 'Atzucacs' ),
	'DeletedContributions'      => array( 'Contribucions esborrades' ),
	'Disambiguations'           => array( 'Desambiguacions' ),
	'DoubleRedirects'           => array( 'Redireccions dobles' ),
	'Emailuser'                 => array( 'Envia missatge' ),
	'Export'                    => array( 'Exporta' ),
	'Fewestrevisions'           => array( 'Pàgines menys editades' ),
	'FileDuplicateSearch'       => array( 'Cerca fitxers duplicats' ),
	'Import'                    => array( 'Importa' ),
	'BlockList'                 => array( 'Usuaris blocats' ),
	'LinkSearch'                => array( 'Enllaços web', 'Busca enllaços', 'Recerca d\'enllaços web' ),
	'Listadmins'                => array( 'Administradors' ),
	'Listbots'                  => array( 'Bots' ),
	'Listfiles'                 => array( 'Imatges' ),
	'Listgrouprights'           => array( 'Drets dels grups d\'usuaris' ),
	'Listredirects'             => array( 'Redireccions' ),
	'Listusers'                 => array( 'Usuaris' ),
	'Lockdb'                    => array( 'Bloca bd' ),
	'Log'                       => array( 'Registre' ),
	'Lonelypages'               => array( 'Pàgines òrfenes' ),
	'Longpages'                 => array( 'Pàgines llargues' ),
	'MergeHistory'              => array( 'Fusiona historial' ),
	'MIMEsearch'                => array( 'Cerca MIME' ),
	'Mostcategories'            => array( 'Pàgines amb més categories' ),
	'Mostimages'                => array( 'Imatges més útils' ),
	'Mostlinked'                => array( 'Pàgines més enllaçades' ),
	'Mostlinkedcategories'      => array( 'Categories més útils' ),
	'Mostlinkedtemplates'       => array( 'Plantilles més útils' ),
	'Mostrevisions'             => array( 'Pàgines més editades' ),
	'Movepage'                  => array( 'Reanomena' ),
	'Mycontributions'           => array( 'Contribucions pròpies' ),
	'Mypage'                    => array( 'Pàgina personal' ),
	'Mytalk'                    => array( 'Discussió personal' ),
	'Newimages'                 => array( 'Imatges noves' ),
	'Newpages'                  => array( 'Pàgines noves' ),
	'Popularpages'              => array( 'Pàgines populars' ),
	'Preferences'               => array( 'Preferències' ),
	'Prefixindex'               => array( 'Cerca per prefix' ),
	'Protectedpages'            => array( 'Pàgines protegides' ),
	'Protectedtitles'           => array( 'Títols protegits' ),
	'Randompage'                => array( 'Article aleatori', 'Atzar', 'Aleatori' ),
	'Randomredirect'            => array( 'Redirecció aleatòria' ),
	'Recentchanges'             => array( 'Canvis recents' ),
	'Recentchangeslinked'       => array( 'Seguiment' ),
	'Revisiondelete'            => array( 'Esborra versió' ),
	'Search'                    => array( 'Cerca' ),
	'Shortpages'                => array( 'Pàgines curtes' ),
	'Specialpages'              => array( 'Pàgines especials' ),
	'Statistics'                => array( 'Estadístiques' ),
	'Uncategorizedcategories'   => array( 'Categories sense categoria' ),
	'Uncategorizedimages'       => array( 'Imatges sense categoria' ),
	'Uncategorizedpages'        => array( 'Pàgines sense categoria' ),
	'Uncategorizedtemplates'    => array( 'Plantilles sense categoria' ),
	'Undelete'                  => array( 'Restaura' ),
	'Unlockdb'                  => array( 'Desbloca bd' ),
	'Unusedcategories'          => array( 'Categories no usades' ),
	'Unusedimages'              => array( 'Imatges no usades' ),
	'Unusedtemplates'           => array( 'Plantilles no usades' ),
	'Unwatchedpages'            => array( 'Pàgines desateses' ),
	'Upload'                    => array( 'Carrega' ),
	'Userlogin'                 => array( 'Registre i entrada' ),
	'Userlogout'                => array( 'Finalitza sessió' ),
	'Userrights'                => array( 'Drets' ),
	'Version'                   => array( 'Versió' ),
	'Wantedcategories'          => array( 'Categories demanades' ),
	'Wantedfiles'               => array( 'Arxius demanats' ),
	'Wantedpages'               => array( 'Pàgines demanades' ),
	'Watchlist'                 => array( 'Llista de seguiment' ),
	'Whatlinkshere'             => array( 'Enllaços' ),
	'Withoutinterwiki'          => array( 'Sense interwiki' ),
);

$linkTrail = "/^((?:[a-zàèéíòóúç·ïü]|'(?!'))+)(.*)$/sDu";

