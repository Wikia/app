<?php
/** Serbian Latin ekavian (‪Srpski (latinica)‬)
 *
 * @ingroup Language
 * @file
 *
 * @author FriedrickMILBarbarossa
 * @author Liangent
 * @author Meno25
 * @author Michaello
 * @author Rancher
 * @author Red Baron
 * @author Reedy
 * @author Slaven Kosanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 * @author לערי ריינהארט
 */

$namespaceNames = array(
	NS_MEDIA            => 'Medija',
	NS_SPECIAL          => 'Posebno',
	NS_TALK             => 'Razgovor',
	NS_USER             => 'Korisnik',
	NS_USER_TALK        => 'Razgovor_sa_korisnikom',
	NS_PROJECT_TALK     => 'Razgovor_o_$1',
	NS_FILE             => 'Slika',
	NS_FILE_TALK        => 'Razgovor_o_slici',
	NS_MEDIAWIKI        => 'MedijaViki',
	NS_MEDIAWIKI_TALK   => 'Razgovor_o_MedijaVikiju',
	NS_TEMPLATE         => 'Šablon',
	NS_TEMPLATE_TALK    => 'Razgovor_o_šablonu',
	NS_HELP             => 'Pomoć',
	NS_HELP_TALK        => 'Razgovor_o_pomoći',
	NS_CATEGORY         => 'Kategorija',
	NS_CATEGORY_TALK    => 'Razgovor_o_kategoriji',
);

# Aliases to cyrillic namespaces 
$namespaceAliases = array(
	"Медија"                  => NS_MEDIA,
	"Посебно"                 => NS_SPECIAL,
	"Разговор"                => NS_TALK,
	"Корисник"                => NS_USER,
	"Разговор_са_корисником"  => NS_USER_TALK,
	"Разговор_о_$1"           => NS_PROJECT_TALK,
	"Слика"                   => NS_FILE,
	"Разговор_о_слици"        => NS_FILE_TALK,
	"МедијаВики"              => NS_MEDIAWIKI,
	"Разговор_о_МедијаВикију" => NS_MEDIAWIKI_TALK,
	'Шаблон'                  => NS_TEMPLATE,
	'Разговор_о_шаблону'      => NS_TEMPLATE_TALK,
	'Помоћ'                   => NS_HELP,
	'Разговор_о_помоћи'       => NS_HELP_TALK,
	'Категорија'              => NS_CATEGORY,
	'Разговор_о_категорији'   => NS_CATEGORY_TALK,
);


$extraUserToggles = array(
	'nolangconversion',
);

$datePreferenceMigrationMap = array(
	'default',
	'hh:mm d. month y.',
	'hh:mm d month y',
	'hh:mm dd.mm.yyyy',
	'hh:mm d.m.yyyy',
	'hh:mm d. mon y.',
	'hh:mm d mon y',
	'h:mm d. month y.',
	'h:mm d month y',
	'h:mm dd.mm.yyyy',
	'h:mm d.m.yyyy',
	'h:mm d. mon y.',
	'h:mm d mon y',
);

$datePreferences = array(
	'default',
	'hh:mm d. month y.',
	'hh:mm d month y',
	'hh:mm dd.mm.yyyy',
	'hh:mm d.m.yyyy',
	'hh:mm d. mon y.',
	'hh:mm d mon y',
	'h:mm d. month y.',
	'h:mm d month y',
	'h:mm dd.mm.yyyy',
	'h:mm d.m.yyyy',
	'h:mm d. mon y.',
	'h:mm d mon y',
);

$defaultDateFormat = 'hh:mm d. month y.';

$dateFormats = array(
	/*
	'Није битно',
	'06:12, 5. јануар 2001.',
	'06:12, 5 јануар 2001',
	'06:12, 05.01.2001.',
	'06:12, 5.1.2001.',
	'06:12, 5. јан 2001.',
	'06:12, 5 јан 2001',
	'6:12, 5. јануар 2001.',
	'6:12, 5 јануар 2001',
	'6:12, 05.01.2001.',
	'6:12, 5.1.2001.',
	'6:12, 5. јан 2001.',
	'6:12, 5 јан 2001',
	 */
	
	'hh:mm d. month y. time'    => 'H:i',
	'hh:mm d month y time'      => 'H:i',
	'hh:mm dd.mm.yyyy time'     => 'H:i',
	'hh:mm d.m.yyyy time'       => 'H:i',
	'hh:mm d. mon y. time'      => 'H:i',
	'hh:mm d mon y time'        => 'H:i',
	'h:mm d. month y. time'     => 'G:i',
	'h:mm d month y time'       => 'G:i',
	'h:mm dd.mm.yyyy time'      => 'G:i',
	'h:mm d.m.yyyy time'        => 'G:i',
	'h:mm d. mon y. time'       => 'G:i',
	'h:mm d mon y time'         => 'G:i',

	'hh:mm d. month y. date'    => 'j. F Y.',
	'hh:mm d month y date'      => 'j F Y',  
	'hh:mm dd.mm.yyyy date'     => 'd.m.Y',  
	'hh:mm d.m.yyyy date'       => 'j.n.Y',  
	'hh:mm d. mon y. date'      => 'j. M Y.',
	'hh:mm d mon y date'        => 'j M Y',  
	'h:mm d. month y. date'     => 'j. F Y.',
	'h:mm d month y date'       => 'j F Y',  
	'h:mm dd.mm.yyyy date'      => 'd.m.Y',  
	'h:mm d.m.yyyy date'        => 'j.n.Y',  
	'h:mm d. mon y. date'       => 'j. M Y.',
	'h:mm d mon y date'         => 'j M Y',  

	'hh:mm d. month y. both'    =>'H:i, j. F Y.', 
	'hh:mm d month y both'      =>'H:i, j F Y',   
	'hh:mm dd.mm.yyyy both'     =>'H:i, d.m.Y',   
	'hh:mm d.m.yyyy both'       =>'H:i, j.n.Y',   
	'hh:mm d. mon y. both'      =>'H:i, j. M Y.', 
	'hh:mm d mon y both'        =>'H:i, j M Y',   
	'h:mm d. month y. both'     =>'G:i, j. F Y.', 
	'h:mm d month y both'       =>'G:i, j F Y',   
	'h:mm dd.mm.yyyy both'      =>'G:i, d.m.Y',   
	'h:mm d.m.yyyy both'        =>'G:i, j.n.Y',   
	'h:mm d. mon y. both'       =>'G:i, j. M Y.', 
	'h:mm d mon y both'         =>'G:i, j M Y',   
);


/* NOT USED IN STABLE VERSION */
$magicWords = array(
	'redirect'              => array( '0', '#Preusmeri', '#preusmeri', '#PREUSMERI', '#REDIRECT' ),
	'notoc'                 => array( '0', '__BEZSADRŽAJA__', '__NOTOC__' ),
	'forcetoc'              => array( '0', '__FORSIRANISADRŽAJ__', '__FORCETOC__' ),
	'toc'                   => array( '0', '__SADRŽAJ__', '__TOC__' ),
	'noeditsection'         => array( '0', '__BEZ_IZMENA__', '__BEZIZMENA__', '__NOEDITSECTION__' ),
	'currentmonth'          => array( '1', 'TRENUTNIMESEC', 'CURRENTMONTH', 'CURRENTMONTH2' ),
	'currentmonthname'      => array( '1', 'TRENUTNIMESECIME', 'CURRENTMONTHNAME' ),
	'currentmonthnamegen'   => array( '1', 'TRENUTNIMESECGEN', 'CURRENTMONTHNAMEGEN' ),
	'currentmonthabbrev'    => array( '1', 'TRENUTNIMESECSKR', 'CURRENTMONTHABBREV' ),
	'currentday'            => array( '1', 'TRENUTNIDAN', 'CURRENTDAY' ),
	'currentdayname'        => array( '1', 'TRENUTNIDANIME', 'CURRENTDAYNAME' ),
	'currentyear'           => array( '1', 'TRENUTNAGODINA', 'CURRENTYEAR' ),
	'currenttime'           => array( '1', 'TRENUTNOVREME', 'CURRENTTIME' ),
	'numberofarticles'      => array( '1', 'BROJČLANAKA', 'NUMBEROFARTICLES' ),
	'numberoffiles'         => array( '1', 'BROJDATOTEKA', 'BROJFAJLOVA', 'NUMBEROFFILES' ),
	'pagename'              => array( '1', 'STRANICA', 'PAGENAME' ),
	'pagenamee'             => array( '1', 'STRANICE', 'PAGENAMEE' ),
	'namespace'             => array( '1', 'IMENSKIPROSTOR', 'NAMESPACE' ),
	'namespacee'            => array( '1', 'IMENSKIPROSTORI', 'NAMESPACEE' ),
	'fullpagename'          => array( '1', 'PUNOIMESTRANE', 'FULLPAGENAME' ),
	'fullpagenamee'         => array( '1', 'PUNOIMESTRANEE', 'FULLPAGENAMEE' ),
	'msg'                   => array( '0', 'POR:', 'MSG:' ),
	'subst'                 => array( '0', 'ZAMENI:', 'SUBST:' ),
	'msgnw'                 => array( '0', 'NVPOR:', 'MSGNW:' ),
	'img_thumbnail'         => array( '1', 'mini', 'thumbnail', 'thumb' ),
	'img_manualthumb'       => array( '1', 'mini=$1', 'thumbnail=$1', 'thumb=$1' ),
	'img_right'             => array( '1', 'desno', 'd', 'right' ),
	'img_left'              => array( '1', 'levo', 'l', 'left' ),
	'img_none'              => array( '1', 'n', 'bez', 'none' ),
	'img_width'             => array( '1', '$1piskel', '$1p', '$1px' ),
	'img_center'            => array( '1', 'centar', 'c', 'center', 'centre' ),
	'img_framed'            => array( '1', 'okvir', 'ram', 'framed', 'enframed', 'frame' ),
	'sitename'              => array( '1', 'IMESAJTA', 'SITENAME' ),
	'ns'                    => array( '0', 'IP:', 'NS:' ),
	'localurl'              => array( '0', 'LOKALNAADRESA:', 'LOCALURL:' ),
	'localurle'             => array( '0', 'LOKALNEADRESE:', 'LOCALURLE:' ),
	'servername'            => array( '0', 'IMESERVERA', 'SERVERNAME' ),
	'scriptpath'            => array( '0', 'SKRIPTA', 'SCRIPTPATH' ),
	'grammar'               => array( '0', 'GRAMATIKA:', 'GRAMMAR:' ),
	'notitleconvert'        => array( '0', '__БЕЗКН__', '__BEZKN__', '__NOTITLECONVERT__', '__NOTC__' ),
	'nocontentconvert'      => array( '0', '__BEZCC__', '__NOCONTENTCONVERT__', '__NOCC__' ),
	'currentweek'           => array( '1', 'TRENUTNANEDELJA', 'CURRENTWEEK' ),
	'currentdow'            => array( '1', 'TRENUTNIDOV', 'CURRENTDOW' ),
	'revisionid'            => array( '1', 'IDREVIZIJE', 'REVISIONID' ),
	'plural'                => array( '0', 'MNOŽINA:', 'PLURAL:' ),
	'fullurl'               => array( '0', 'PUNURL:', 'FULLURL:' ),
	'fullurle'              => array( '0', 'PUNURLE:', 'FULLURLE:' ),
	'lcfirst'               => array( '0', 'LCPRVI:', 'LCFIRST:' ),
	'ucfirst'               => array( '0', 'UCPRVI:', 'UCFIRST:' ),
);

$separatorTransformTable = array(',' => '.', '.' => ',' );

