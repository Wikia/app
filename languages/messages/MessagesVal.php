<?php
$skinNames = array(
	'standard' => "Estàndard",
	'nostalgia' => "Nostàlgia",
	'cologneblue' => "Colònia blava",
);
$namespaceNames = array(
	NS_MEDIA          => 'Media',
	NS_SPECIAL        => 'Especial',
	NS_MAIN           => '',
	NS_TALK           => 'Discussió',
	NS_USER           => 'Usuari',
	NS_USER_TALK      => 'Usuari_Discussió',
	# NS_PROJECT set by $wgMetaNamespace
	NS_PROJECT_TALK   => '$1_Discussió',
	NS_IMAGE          => 'Image',
	NS_IMAGE_TALK     => 'Image_Discussió',
	NS_MEDIAWIKI      => 'MediaWiki',
	NS_MEDIAWIKI_TALK => 'MediaWiki_Discussió',
	NS_TEMPLATE       => 'Plantilla',
	NS_TEMPLATE_TALK  => 'Plantilla_Discussió',
	NS_HELP           => 'Ajuda',
	NS_HELP_TALK      => 'Ajuda_Discussió',
	NS_CATEGORY       => 'Categoria',
	NS_CATEGORY_TALK  => 'Categoria_Discussió'
);

$separatorTransformTable = array(',' => '.', '.' => ',' );

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

$linkTrail = '/^([a-zàèéíòóúç·ïü\']+)(.*)$/sDu';

$messages = array(
# User preference toggles
'tog-underline'               => 'Subralla els enllaços:',
'tog-highlightbroken'         => 'Formateja els enllaços trencats  <a href="" class="new">d\'esta manera</a> (atrament, se faria d\'esta atra manera<a href="" class="internal">?</a>).',
'tog-justify'                 => 'Alineació justificada dels paràgrafs',
'tog-hideminor'               => 'Amaga les edicions menors en la pàgina de canvis recents',
'tog-extendwatchlist'         => 'Desplega la llista de seguiment per a mostrar tots els canvis afectats',
'tog-usenewrc'                => 'Presentació millorada dels canvis recents (fa falta JavaScript)',
'tog-showtoolbar'             => "Mostra la barra de ferramentes d'edició (fa falta JavaScript)",
'tog-editondblclick'          => "Inicia l'edició de la pàgina al fer clic dos vegades (fa falta JavaScript)",
'tog-editsection'             => "Activa l'edició per seccions mediant l'enllaç específic corresponent",
'tog-editsectiononrightclick' => "Activa l'edició per seccions al fer clic sobre l'encapçalament en el botó dret del ratolí (fa falta JavaScript)",
'tog-showtoc'                 => "Mostrar l'índex de continguts a les pàgines en més de 3 seccions",
'tog-rememberpassword'        => 'Recorda la contrasenya entre sessions',
'tog-editwidth'               => "Amplia al màxim la caixa d'edició",
'tog-watchcreations'          => 'Vigila els artículs que he creat',
'tog-watchdefault'            => 'Vigila els artículs que he editat',
'tog-watchmoves'              => 'Afig les pàgines que nomeniu a la llista de seguiment',
'tog-watchdeletion'           => 'Afig les pàgines que elimines a la llista de seguiment',
'tog-minordefault'            => 'Marca totes les contribucions com a edicions menors per defecte',
'tog-previewontop'            => "Mostra una vista prèvia de l'artícul davant del panel d'edicions",
'tog-previewonfirst'          => "Mostra una visualisació prèvia de l'artícul en la primera edició",
'tog-nocache'                 => 'Desactiva la memòria cache per als artículs',
'tog-enotifwatchlistpages'    => "Notifica'm per correu electrònic els canvis en les pàgines que vigili",
'tog-enotifusertalkpages'     => "Notifica per correu quan hi han modificacions a la pàgina de discussió del meu conte d'usuari",
'tog-enotifminoredits'        => "Notifica per correu també en casos d'edicions menors",
'tog-enotifrevealaddr'        => "Mostra la direcció del meu correu en els mensages d'avís per correu",
'tog-shownumberswatching'     => "Mostra el número d'usuaris que vigilen l'artícul",
'tog-fancysig'                => 'Signatures planes (sense enllaç automàtic)',
'tog-externaleditor'          => 'Recorre a un editor extern per omissió',
'tog-externaldiff'            => 'Recorre a un atre visualisador de canvis per defecte',
'tog-showjumplinks'           => "Activa els enllaços de direccions d'accessibilitat",
'tog-uselivepreview'          => 'Activa la previsualisació automàtica (fa falta JavaScript) (experimental)',
'tog-forceeditsummary'        => "Avisa'm quan el camp de sumari estiga en blanc",
'tog-watchlisthideown'        => 'Amaga el que he contribuït de la llista de seguiment',
'tog-watchlisthidebots'       => 'Amaga de la llista de seguiment les edicions fetes per usuaris bots',
'tog-watchlisthideminor'      => 'Amaga les edicions menors de la llista de seguiment',
'tog-nolangconversion'        => 'Desactiva la conversió de variants',
'tog-ccmeonemails'            => "Envia'm còpies dels mensages que envie als atres usuaris.",
'tog-diffonly'                => 'Amaga el contingut de la pàgina baix de la taula de diferències',

'underline-always'  => 'Sempre',
'underline-never'   => 'Mai',
'underline-default' => 'Configuració per defecte del navegador',

'skinpreview' => '(prova)',

# Dates
'sunday'        => 'dumenge',
'monday'        => 'dilluns',
'tuesday'       => 'dimarts',
'wednesday'     => 'dimecres',
'thursday'      => 'dijous',
'friday'        => 'divendres',
'saturday'      => 'dissabte',
'sun'           => 'dg',
'mon'           => 'dl',
'tue'           => 'dt',
'wed'           => 'dc',
'thu'           => 'dj',
'fri'           => 'dv',
'sat'           => 'ds',
'january'       => 'giner',
'february'      => 'febrer',
'march'         => 'març',
'april'         => 'abril',
'may_long'      => 'maig',
'june'          => 'juny',
'july'          => 'juliol',
'august'        => 'agost',
'september'     => 'setembre',
'october'       => 'octubre',
'november'      => 'novembre',
'december'      => 'decembre',
'january-gen'   => 'giner',
'february-gen'  => 'febrer',
'march-gen'     => 'març',
'april-gen'     => 'abril',
'may-gen'       => 'maig',
'june-gen'      => 'juny',
'july-gen'      => 'juliol',
'august-gen'    => 'agost',
'september-gen' => 'setembre',
'october-gen'   => 'octubre',
'november-gen'  => 'novembre',
'december-gen'  => 'decembre',
'jan'           => 'gin',
'feb'           => 'febr',
'mar'           => 'març',
'apr'           => 'abr',
'may'           => 'maig',
'jun'           => 'juny',
'jul'           => 'jul',
'aug'           => 'ag',
'sep'           => 'set',
'oct'           => 'oct',
'nov'           => 'nov',
'dec'           => 'dec',

# Bits of text used by many pages
'categories'            => 'Categories',
'pagecategories'        => '{{PLURAL:$1|Categoria|Categories}}',
'category_header'       => 'Artículs a la categoria «$1»',
'subcategories'         => 'Subcategories',
'category-media-header' => 'Contingut multimédia en la categoria "$1"',

'mainpagetext'      => "<big>'''MediaWiki s'ha instalat correctament.'''</big>",
'mainpagedocfooter' => "Consulta la [http://meta.wikimedia.org/wiki/Help:Contents Guia d'Usuari] per a més informació sobre com utilisar el programa wiki.

== Per a començar ==

* [http://www.mediawiki.org/wiki/Manual:Configuration_settings Llista de característiques que pots configurar]
* [http://www.mediawiki.org/wiki/Manual:FAQ PMF del MediaWiki]
* [http://lists.wikimedia.org/mailman/listinfo/mediawiki-announce Llista de correu (''listserv'') per a anuncis del MediaWiki]",

'about'          => 'Informació',
'articul'        => 'Contingut de la pàgina',
'newwindow'      => '(obrir en una nova finestra)',
'cancel'         => 'Anula',
'qbfind'         => 'Busca',
'qbbrowse'       => 'Navega',
'qbedit'         => 'Edita',
'qbpageoptions'  => 'Opcions de pàgina',
'qbpageinfo'     => 'Informació de pàgina',
'qbmyoptions'    => 'Pàgines pròpies',
'qbspecialpages' => 'Pàgines especials',
'moredotdotdot'  => 'Més...',
'mypage'         => 'Pàgina personal',
'mytalk'         => 'Discussió',
'anontalk'       => "Contactar en l'anònim que utilisa esta IP",
'navigation'     => 'Navegació',

# Metadata in edit box
'metadata_help' => 'Mitadades:',

'errorpagetitle'    => 'Error',
'returnto'          => 'Torna cap a $1.',
'tagline'           => 'De {{SITENAME}}',
'help'              => 'Ajuda',
'search'            => 'Busca',
'searchbutton'      => 'Busca',
'go'                => 'Anar',
'searcharticul'     => 'Anar',
'history'           => 'Historial de canvis',
'history_short'     => 'Historial',
'updatedmarker'     => 'actualisat des de la última visita',
'info_short'        => 'Informació',
'printableversion'  => 'Versió per a impressora',
'permalink'         => 'Enllaç permanent',
'print'             => "Envia esta pàgina a la cua d'impressió",
'edit'              => 'Edita',
'editthispage'      => 'Edita la pàgina',
'delete'            => 'Elimina',
'deletethispage'    => 'Elimina la pàgina',
'undelete_short'    => 'Recupera {{PLURAL:$1|la pàgina eliminada|$1 modificacions de la pàgina eliminada}}',
'protect'           => 'Protecció',
'protectthispage'   => 'Protecció de la pàgina',
'unprotect'         => 'Desprotecció',
'unprotectthispage' => 'Desprotecció de la pàgina',
'newpage'           => 'Pàgina nova',
'talkpage'          => 'Discussió de la pàgina',
'specialpage'       => 'Pàgina especial',
'personaltools'     => "Ferramentes de l'usuari",
'postcomment'       => 'Envia un comentari',
'articulpage'       => 'Mostra la pàgina',
'talk'              => 'Discussió',
'views'             => 'Vistes',
'toolbox'           => 'Ferramentes',
'userpage'          => "Visualisa la pàgina d'usuari",
'projectpage'       => 'Visualisa la pàgina del proyecte',
'imagepage'         => 'Visualisa la pàgina de la image',
'mediawikipage'     => 'Visualisa la pàgina de mensages',
'templatepage'      => 'Visualisa la pàgina de plantilla',
'viewhelppage'      => "Visualisa la pàgina d'ayuda",
'categorypage'      => 'Visualisa la pàgina de la categoria',
'viewtalkpage'      => 'Visualisa la pàgina de discussió',
'otherlanguages'    => 'En atres llengües',
'redirectedfrom'    => "(S'ha redirigit des de $1)",
'redirectpagesub'   => 'Pàgina de redireccionament',
'lastmodifiedat'    => 'Última modificació de la pàgina: $2, $1.', # $1 date, $2 time
'viewcount'         => 'Esta pàgina ha segut visitada {{plural:$1|una vegada|$1 vegaes}}.',
'protectedpage'     => 'Pàgina protegida',
'jumpto'            => 'Direccions ràpides:',
'jumptonavigation'  => 'navegació',
'jumptosearch'      => 'Busca',

# All link text and link target definitions of links into project namespace that get used by other message strings, with the exception of user group pages (see grouppage) and the disambiguation template definition (see disambiguations).
'aboutsite'         => 'Informació sobre {{SITENAME}}',
'aboutpage'         => 'Proyecte:Informació',
'bugreports'        => "Informes d'errors del programa",
'bugreportspage'    => "Proyecte:Informes d'errors",
'copyright'         => "El contingut està disponible baix els termes d'una llicència $1",
'copyrightpagename' => '{{SITENAME}}, tots els drets reservats',
'copyrightpage'     => 'Proyecte:Copyrights',
'currentevents'     => 'Actualitat',
'currentevents-url' => 'Proyecte:Actualitat',
'disclaimers'       => 'Avís general',
'disclaimerpage'    => 'Proyecte:Avís general',
'edithelp'          => 'Ajuda per a editar pàgines',
'edithelppage'      => "Ajuda:Com s'edita una pàgina",
'faq'               => 'PMF',
'faqpage'           => 'Proyecte:PMF',
'helppage'          => 'Ajuda:Índex',
'mainpage'          => 'Portada',
'policy-url'        => 'Proyecte:Polítiques',
'portal'            => 'Portal comunitari',
'portal-url'        => 'Proyecte:Portal',
'privacy'           => 'Política de privacitat',
'privacypage'       => 'Proyecte:Política de privacitat',
'sitesupport'       => 'Donacions',
'sitesupport-url'   => 'Proyecte:Donatius',

'badaccess'        => 'Error de permissos',
'badaccess-group0' => "No tens permissos per a eixecutar l'acció que has solicitat.",
'badaccess-group1' => "L'acció que has solicitat se llimita als usuaris del grup $1.",
'badaccess-group2' => "L'acció que has solicitat se llimita a un dels usuaris dels grups $1.",
'badaccess-groups' => "L'acció que has solicitat se llimita als usuaris d'un dels grups $1.",

'versionrequired'     => 'Fa falta la versió $1 del MediaWiki',
'versionrequiredtext' => 'Fa falta la versió $1 del MediaWiki per a utilisar esta pàgina. mira [[Special:Version]]',

'ok'                  => "D'acort",
'pagetitle'           => '$1 - {{SITENAME}}',
'retrievedfrom'       => 'Obtingut de "$1"',
'youhavenewmessages'  => 'Tens $1 ($2).',
'newmessageslink'     => 'nous mensages',
'newmessagesdifflink' => 'últims canvis',
'editsection'         => 'edita',
'editold'             => 'edita',
'editsectionhint'     => 'Edita la secció: $1',
'toc'                 => 'Contingut',
'showtoc'             => 'desplega',
'hidetoc'             => 'amaga',
'thisisdeleted'       => 'Vols mostrar o restaurar $1?',
'viewdeleted'         => 'Vols mostrar $1?',
'restorelink'         => '{{PLURAL:$1|una versió borrada|$1 versions borrades}}',
'feedlinks'           => 'Sindicament:',
'feed-invalid'        => 'La subscripció no es vàlida pel tipo de sindicament.',

# Short words for each namespace, by default used in the 'articul' tab in monobook
'nstab-main'      => 'Artícul',
'nstab-user'      => "Pàgina d'usuari",
'nstab-media'     => 'Pàgina de mijans',
'nstab-special'   => 'Pàgina especial',
'nstab-project'   => 'Pàgina del proyecte',
'nstab-image'     => 'Ficher',
'nstab-mediawiki' => 'Mensage',
'nstab-template'  => 'Plantilla',
'nstab-help'      => 'Ajuda',
'nstab-category'  => 'Categoria',

# Main script and global functions
'nosuchaction'      => 'No se reconeix esta operació',
'nosuchactiontext'  => "El programa wiki que utilisa {{SITENAME}} no reconeix l'operació especificada per la direcció URL",
'nosuchspecialpage' => 'No se troba la pàgina especial que busques',
'nospecialpagetext' => 'La pàgina especial que demana no es vàlida. Mira la llista de pàgines especials en [[Special:Specialpages]].',

# General errors
'error'                => 'Error',
'databaseerror'        => "S'ha produït un error en la base de dades",
'dberrortext'          => "S'ha produït un error de sintaxis en una consulta a la base de dades.
Açò podria indicar un error en el programa.
L'última consulta que s'ha intentat fer ha segut:
<blockquote><tt>$1</tt></blockquote>
des de la funció «<tt>$2</tt>».
L'error de retorn de MySQL ha segut «<tt>$3: $4</tt>».",
'dberrortextcl'        => "S'ha produït un error de sintaxis en una consulta a la base de dades.
L'última consulta que s'ha intentat fer ha segut:
<blockquote><tt>$1</tt></blockquote>
des de la funció «<tt>$2</tt>».
L'error de retorn de MySQL ha segut «<tt>$3: $4</tt>».",
'noconnect'            => "Al programa wiki hi ha algun problema tècnic, i no s'ha pogut contactar en el servidor de la base de dades. <br />
$1",
'nodb'                 => "No s'ha pogut seleccionar la base de dades $1",
'cachederror'          => 'Ací tens una còpia provinent de la memòria cache de la pàgina que hi has demanat i, per això, podria no estar actualisada.',
'laggedslavemode'      => 'Avís: La pàgina podria mancar de modificacions recents.',
'readonly'             => 'La base de dades se troba bloquejada',
'enterlockreason'      => 'Escrigau un motiu pel bloqueig, així com una estimació de quan tindrà lloc el desbloqueig',
'readonlytext'         => "La base de dades està temporalment bloquejada segurament per tarees de manteniment, després de les quals se tornarà a la normalitat.

L'administrador que l'ha bloquejat ha donat esta explicació: $1",
'missingarticul'       => 'La base de dades no ha trobat el text d\'una
pàgina que hauria d\'haver trobat, nomenada "$1".
Això acostuma a passar quan se seguix un enllaç a una pàgina que ha segut eliminada.

Si este no es el cas, provablement se tracta d\'un error de la uep.
Informa per favor a un administrador, fent-ne arribar la direcció URL.',
'readonly_lag'         => "S'ha bloquejada la base de dades automàticament per a la sincronisació dels servidors",
'internalerror'        => 'Fallida interna',
'filecopyerror'        => 'No s\'ha pogut copiar el ficher "$1" com "$2".',
'filerenameerror'      => 'No s\'ha pogut renomenar el ficher "$1" com "$2".',
'filedeleteerror'      => 'No s\'ha pogut borrar el ficher "$1".',
'filenotfound'         => 'No s\'ha pogut trobar el ficher "$1".',
'unexpected'           => 'S\'ha trobat un valor imprevist: "$1"="$2".',
'formerror'            => "Error: no s'ha pogut enviar les dades del formulari",
'badarticulerror'      => 'Esta operació no se pot dur a terme en esta pàgina',
'cannotdelete'         => "No s'ha pogut borrar la pàgina o el ficher especificat, o potser ya ha segut esborrat per algú atre.",
'badtitle'             => 'El títul no es correcte',
'badtitletext'         => 'El títul de la pàgina que has demanat no es correcte, està en blanc o es un enllaç inter-lingüístic trencat. Podria haver-hi algun caràcter no permés per al seu ús en els títuls.',
'perfdisabled'         => "S'ha desactivat temporalment esta funcionalitat perquè sobrecarrega la base de dades fins al punt d'inutilisar el programa wiki.",
'perfcached'           => 'Tot seguit se mostren les dades que se troben a la memòria cau, i podria no tenir els últims canvis del dia:',
'perfcachedts'         => 'Tot seguit se mostra les dades que se troben a la memòria cau, la última actualisació de la qual va ser el $1.',
'querypage-no-updates' => "S'ha inhabilitat l'actualisació d'esta pàgina. Les dades que hi contenen podrien no estar al dia.",
'wrong_wfQuery_params' => 'Paràmetros incorrectes per a wfQuery()<br />
Funció: $1<br />
Consulta: $2',
'viewsource'           => 'Mostra la font',
'viewsourcefor'        => 'per a $1',
'protectedpagetext'    => 'Esta pàgina està protegida i no pot ser editada.',
'viewsourcetext'       => "Pots visualisar i copiar la font d'esta pàgina:",
'protectedinterface'   => "Esta pàgina conté cadenes de text per a la navegació de la uep, i està protegida per a previndre'n abusos.",
'editinginterface'     => "'''Avís:''' Estàs editant una pàgina que conté cadenes de text per a la navegació d'esta uep. Tin en conte que els canvis que se fan a esta pàgina afecten a l'apariència de la navegació d'usuari per a tots els usuaris.",
'sqlhidden'            => '(consulta SQL oculta)',
'cascadeprotected'     => "S'ha protegit esta pàgina de modificacions al trobar-se inclosa entre les següents pàgines protegides l'opció en cascada:",

# Login and logout pages
'logouttitle'                => 'Fi de la sessió',
'logouttext'                 => '<strong>Has finalisat la teua sessió.</strong><br />
Pots continuar utilisant {{SITENAME}} de forma anònima, o pots iniciar una sessió una atra vegada en el mateix o un atre usuari. Tin en conte que algunes pàgines poden continuar mostrant-se com si encara estigueren en una sessió, fins que buida la memòria cache del teu navegador.',
'welcomecreation'            => "== Te donem la benvinguda, $1! ==

S'ha creat el teu conte. No oblides de canviar les teues preferències.",
'loginpagetitle'             => 'Inici de sessió',
'yourname'                   => "Nom d'usuari",
'yourpassword'               => 'Contrasenya',
'yourpasswordagain'          => 'Escriu una atra vegada la contrasenya',
'remembermypassword'         => 'Recorda la contrasenya entre sessions.',
'yourdomainname'             => 'El teu domini',
'externaldberror'            => "Hi ha hagut una fallida en el servidor d'autenticació externa de la base de dades i no tens permís per a actualisar el teu conte d'accés extern.",
'loginproblem'               => "<strong>S'ha produït un problema en iniciar la sessió.</strong><br />Prova-lo de nou!",
'alreadyloggedin'            => '<strong>Te donem la benvinguda $1, ya has iniciat la teua sessió!</strong><br />',
'login'                      => 'Inici de sessió',
'loginprompt'                => 'Tens que tindre les cookies activades per a poder registarte.',
'userlogin'                  => 'Inicia una sessió / crea un conte',
'logout'                     => 'Finalisa la sessió',
'userlogout'                 => 'Finalisa la sessió',
'notloggedin'                => 'No us has identificat',
'nologin'                    => 'No tens un conte? $1.',
'nologinlink'                => 'Crea un conte',
'createaccount'              => 'Crea un nou conte',
'gotaccount'                 => 'Ya tens un conte? $1.',
'gotaccountlink'             => 'Inicia una sessió',
'createaccountmail'          => 'per correu electrònic',
'badretype'                  => 'Les contrasenyes que has introduït no coincidixen.',
'userexists'                 => 'El nom que has entrat ya està en us. Escolliu un atre.',
'youremail'                  => 'Direcció electrònica *',
'username'                   => "Nom d'usuari:",
'uid'                        => "Identificador d'usuari:",
'yourrealname'               => 'Nom real *',
'yourlanguage'               => 'Llengua:',
'yourvariant'                => 'Variant llingüística',
'yournick'                   => 'Àlies (nom que se mostrarà):',
'badsig'                     => 'La signatura que has inserit no es vàlida; verifica les etiquetes HTML que has emprat.',
'email'                      => 'Direcció electrònica',
'prefs-help-realname'        => "* Nom real (opcional): si elegiu donar esta informació serà utilisada per a donar-te l'atribució de la teua faena.",
'loginerror'                 => "Error d'inici de sessió",
'prefs-help-email'           => "* direcció electrònica (opcional): Permet als atres usuaris enviar-te mensages de correu electrònic a través de la teua pàgina d'usuari o de discussió, sense que així necessites revelar la teua identitat.",
'nocookiesnew'               => "S'ha creat el conte d'usuari, pero no estàs registrat. El proyecte {{SITENAME}} usa cookies per registrar els usuaris. Per favor activa-les, per a poder registrar-te en el teu nom d'usuari i la clau.",
'nocookieslogin'             => 'El programa {{SITENAME}} utilisa cookies per registrar usuaris. Tens les cookies desactivades. Activa-les i torna a provar.',
'noname'                     => "No has especificat un nom vàlit d'usuari.",
'loginsuccesstitle'          => "S'ha iniciat la sessió en èxit",
'loginsuccess'               => 'Has iniciat la sessió a {{SITENAME}} com a "$1".',
'nosuchuser'                 => 'No hi ha cap usuari nomenat "$1".
Revisa l\'ortografia, o crea un nou conte d\'usuari.',
'nosuchusershort'            => 'No hi ha cap usuari nomenat "$1". Comprova que ho hages escrit correctament.',
'nouserspecified'            => "Tens que especificar un nom d'usuari.",
'wrongpassword'              => 'La contrasenya que has introduït es incorrecta. Torneu-ho a provar.',
'wrongpasswordempty'         => "La contrasenya que s'ha introduït era en blanc. Torneu-ho a provar.",
'mailmypassword'             => "Envia'm una nova contrasenya per correu electrònic",
'passwordremindertitle'      => 'Recordatori de la contrasenya del proyecte {{SITENAME}}',
'passwordremindertext'       => "Algú (tu mateix segurament, des de la direcció l'IP $1) ha solicitat que t' enviem una nova contrasenya per a iniciar la sessió al proyecte {{SITENAME}} ($4).
La contrasenya per a l'usuari «$2» es ara «$3».
Ara hauries d'iniciar la sessió i canviar la teua contrasenya.

Si algú atre hagué fet esta solicitut o si ya haguesis recordat la teua contrasenya i
no volgueres canviar-la, ignora este mensage i continua utilisant
la teua antiga contrasenya.",
'noemail'                    => 'No hi ha cap direcció electrònica registrada de l\'usuari "$1".',
'passwordsent'               => 'S\'ha enviat una nova contrasenya a l\'direcció electrònica registrada per "$1".
Inicia una sessió després que la rebes.',
'blocked-mailpassword'       => 'La teua direcció IP ha segut bloquejada. Se us ha desactivat la funció de recuperació de contrasenya per a previndre abusos.',
'eauthentsent'               => "S'ha enviat un correu electrònic a la direcció especificada. Abans no s'envie cap atre correu electrònic a esta direcció, fa falta verificar que es realment teua. Per tant, fa falta que seguiu les instruccions presents en el correu electrònic que se us ha enviat.",
'throttled-mailpassword'     => "En les últimes $1 hores ya se t'ha enviat una contrasenya. Per prevenir abusos, només s'envia un recordatori de contrasenya cada $1 hores.",
'mailerror'                  => "S'ha produït un error en enviar el mensage: $1",
'acct_creation_throttle_hit' => 'Lo sentim, ya tens $1 contes creats i no està permés de tenir-ne més.',
'emailauthenticated'         => "S'ha autenticat la teua direcció electrònica a $1.",
'emailnotauthenticated'      => 'La teua direcció de correu electrònic <strong>encara no està autentificada</strong>. No rebrà correu electrònic provinent de cap les següents funcionalitats.',
'noemailprefs'               => 'Especifica una direcció electrònica per a activar estes característiques.',
'emailconfirmlink'           => 'Confirma la teua direcció electrònica',
'invalidemailaddress'        => "No se pot acceptar la direcció electrònica perque pareix que té un format no vàlit.
Introduïx una direcció en un format adequat o bè buida el camp.",
'accountcreated'             => "S'ha creat el conte",
'accountcreatedtext'         => "S'ha creat el conte d'usuari de $1.",

# Password reset dialog
'resetpass'               => 'Reinicia la contrasenya del conte',
'resetpass_announce'      => 'Has iniciat la sessió en un codi temporal enviat per correu electrònic. Per a finalisar-la, tens que definir una nova contrasenya ací:',
'resetpass_text'          => '<!-- Afig un text -->',
'resetpass_header'        => 'Reinicia la contrasenya',
'resetpass_submit'        => 'Definiu una contrasenya i inicia una sessió',
'resetpass_success'       => "S'ha canviat la teua contrasenya en èxit! Ara ya pots iniciar sessió...",
'resetpass_bad_temporary' => 'La contrasenya temporal no es vàlida. Potser ya havies canviat la teua contrasenya o has solicitat una nova contrasenya temporal.',
'resetpass_forbidden'     => "No poden canviar-se les contrasenyes d'este wiki",
'resetpass_missing'       => 'No hi ha cap dada de formulari.',

# Edit page toolbar
'bold_sample'     => 'Text en negreta',
'bold_tip'        => 'Text en negreta',
'italic_sample'   => 'Text en cursiva',
'italic_tip'      => 'Text en cursiva',
'link_sample'     => "Títul de l'enllaç",
'link_tip'        => 'Enllaç intern',
'extlink_sample'  => "http://www.uiquipedia.org títul de l'enllaç",
'extlink_tip'     => 'Enllaç extern (recorda el prefix http://)',
'headline_sample' => "Text per a l'encapçalament",
'headline_tip'    => 'Encapçalat de secció de 2n nivell',
'math_sample'     => 'Inserta una fòrmula ací',
'math_tip'        => 'Fòrmula matemàtica (LaTeX)',
'nowiki_sample'   => 'Inserta ací text no formatejat',
'nowiki_tip'      => 'Ignora el format wiki',
'image_sample'    => 'Eixemple.jpg',
'image_tip'       => 'Image anexada',
'media_sample'    => 'Eixemple.ogg',
'media_tip'       => 'Enllaç cap al ficher multimédia',
'sig_tip'         => 'La teua signatura en marca horària',
'hr_tip'          => 'Llínia horisontal (useu-la moderadament)',

# Edit pages
'summary'                   => 'Resum',
'subject'                   => 'Tema/capçalera',
'minoredit'                 => 'Esta es una edició menor.',
'watchthis'                 => 'Vigila este artícul.',
'savearticle'               => 'Guarda la pàgina',
'preview'                   => 'Vista prèvia',
'showpreview'               => 'Mostra una vista prèvia',
'showlivepreview'           => 'Vista ràpida',
'showdiff'                  => 'Mostra els canvis',
'anoneditwarning'           => "'''Atenció:''' No estàs registrat en un nom d'usuari. Es guardarà la teua direcció IP en l'historial de la pàgina.",
'missingsummary'            => "'''Recordatori''': Has deixat en blanc el sumari d'edició. Si tornes a clicar el botó de guardar, l'edició se guardarà sense sumari.",
'missingcommenttext'        => 'Introduïu un comentari a continuació.',
'missingcommentheader'      => "'''Recordatori:''' No hi has proporcionat l'assunt o l'encapçalament del teu comentari. Si hi fas clic el botó de guardar una atra vegada, la teua contribució serà desada sense açò.",
'summary-preview'           => 'Previsualisació del resum',
'subject-preview'           => 'Previsualisació de tema/capçalera',
'blockedtitle'              => "L'usuari està bloquejat",
'blockedtext'               => "<big>'''S'ha procedit al bloqueig del teu conte d'usuari o la teua direcció IP.'''</big>

El bloqueig l'ha dut a terme $1, en el següent motiu: ''$2''

Pots contactar $1 o un dels [[{{MediaWiki:grouppage-sysop}}|administradors]] per a discutir el blocage.

Tin un conte que no pots utilisar el formulari d'enviament de mensages de correu a cap usuari, fins que tingues una direcció de correu vàlida registrada a les teues [[Special:Preferences|preferències d'usuari]].

La teua direcció IP es $3, i el núm. ID del bloqueig es #$5. Per favor, inclou esta direcció en totes les consultes que fases.",
'blockedoriginalsource'     => "La font de '''$1''' se mostra a sota:",
'blockededitsource'         => "El text de les teues edicions a '''$1''' se mostra a continuació:",
'whitelistedittitle'        => "Tens que iniciar una sessió per a poder editar",
'whitelistedittext'         => 'tens que $1 per editar pàgines.',
'whitelistreadtitle'        => "Tens que iniciar una sessió per a llegir-lo",
'whitelistreadtext'         => "Tens que [[Special:Userlogin|indentificar-te]] per llegir les pàgines.",
'whitelistacctitle'         => 'No tens permissos per a crear un conte',
'whitelistacctext'          => "Per estar autorisat a crear contes en esta Uiquipédia has d'[[Special:Userlogin|identificar-te]] i tenir els permissos apropiats.",
'confirmedittitle'          => "Cal una confirmació de la direcció electrònica per a poder editar",
'confirmedittext'           => "Tens que confirmar la teua direcció electrònica adés de poder editar pàgines. Indica i valida la teua direcció electrònica a través de les teues [[Special:Preferences|preferències d'usuari]].",
'loginreqtitle'             => 'Fa falta que inicies sessió',
'loginreqlink'              => 'inicia una sessió',
'loginreqpagetext'          => 'Tens que ser $1 per a visualisar atres pàgines.',
'accmailtitle'              => "S'ha enviat una contrasenya.",
'accmailtext'               => "S'ha enviat a $2 la contrasenya per a «$1».",
'newarticul'                => '(Nou)',
'newarticultext'            => "Has seguit un enllaç a una pàgina que encara no existix.
Per a crear-la comença a escriure en l'espai de baix
(vore l'[[{{MediaWiki:helppage}}|ajuda]] per a més informació).
Si sou ací per error simplement fes clic el botó \"darrere\" del teu navegador.",
'anontalkpagetext'          => "----''Esta es la pàgina de discussió d'un usuari anònim que encara no ha creat un conte o que no usa el seu nom registrat. Per lo tant tenim que usar la seua direcció IP numèrica per identificar-lo. Una direcció IP pot ser compartida per molts usuaris. Si eres un usuari anònim i trobes que t'han borrat comentaris inoportuns, per favor, [[Special:Userlogin|creat un conte]] per evitar futures confusions en atres usuaris anònims.''",
'noarticultext'             => 'En este moment no hi ha text en esta pàgina. Pots [[Special:Search/{{PAGENAME}}|buscar-ne el títul]] en atres pàgines o [{{fullurl:{{FULLPAGENAME}}|action=edit}} començar a escriure-hi].',
'clearyourcache'            => "'''Nota:''' Després de guardar, tens que posar al dia la memòria cache del teu navegador per vore els canvis. '''Mozilla / Firefox / Safari:''' Pressiona ''Shift'' mentres fas clic ''Actualisa'' (Reload), o pressiona ''Ctrl+Shift+R'' (''Cmd+Shift+R'' en un Mac Apple); '''Internet Explorer:''' pressiona ''Ctrl'' mentres fas clic ''Actualisa'' (Refresh), o pressiona ''Ctrl+F5''; '''Konqueror:''': simplement fes clic el botó ''Recarregar'' (Reload), o pressiona ''F5''; '''Opera''' hauràs de borrar completament la teua memòria cache a ''Ferramentes→Preferències''.",
'usercssjsyoucanpreview'    => '<strong>Consell:</strong> Utilisa el botó «Mostra previsualisació» per probar el teu nou CSS/JS abans de guardar-lo.',
'usercsspreview'            => "'''Recorda que estàs previsualisant el teu CSS d'usuari i que encara no s'ha guardat!'''",
'userjspreview'             => "'''Recorda que només estàs provant/previsualisant el teu JavaScript, encara no ho has guardat!'''",
'userinvalidcssjstitle'     => "'''Atenció:''' No existix l'apariència «$1». Recorda que les subpàgines personalisades en extensions .css i .js utilisen el títul en minúscules, per eixemple, Usuari:NOM/monobook.css no es el mateix que Usuari:NOM/Monobook.css.",
'updated'                   => '(Actualisat)',
'note'                      => '<strong>Nota:</strong>',
'previewnote'               => "<strong>Donat conte que això només es una vista prèvia, els canvis dels quals encara no s'han publicat!</strong>",
'previewconflict'           => "Esta previsualisació reflexa el text a l'ària
d'edició superior tal i com apareixerà si escollixes guardar.",
'session_fail_preview'      => "<strong>Lo sentim, no s'ha pogut processar, pero, les teues modificacions, a causa d'una pèrdua de la sessió de dades.
Per favor, intenta-lo una atra vegada. Si continua havent problemes, eixiu de la sessió del teu conte i torna per autenticar-te.</strong>",
'session_fail_preview_html' => "<strong>Lo sentim, no s'han pogut processar les teues modificacions, a causa d'una pèrdua de la sessió de dades.</strong>

''Com que esta uep està basada en wiki té habilitat l'us de codi pla d'HTML, s'ha amagat la previsualisació com a prevenció contra atacs a través de codis JavaScript.''

<strong>Si se tracta d'una contribució llegítima, per favor, intenta-lo una atra vegada. Si continua havent problemes, tens que eixir de la sessió del teu conte i tornar per autenticar-te.</strong>",
'importing'                 => "S'està important $1",
'editing'                   => "S'està editant $1",
'editinguser'               => "S'està editant $1",
'editingsection'            => "S'està editant $1 (secció)",
'editingcomment'            => "S'està editant $1 (comentari)",
'editconflict'              => "Conflicte d'edició: $1",
'explainconflict'           => "Algú més ha canviat esta pàgina des que l'has editada.
L'ària de text superior conté el text de la pàgina com existix actualment. Els teues canvis se mostren a l'ària de text inferior.
Hauràs d'incorporar els teues canvis en el text existent.
<b>Solament</b> el text a l'ària de text superior serà gravat quan pressiones
 \"Guarda pàgina\".<br />",
'yourtext'                  => 'El teu text',
'storedversion'             => 'Versió guardada',
'nonunicodebrowser'         => "<strong>ALERTA: El teu navegador no es compatible en unicode, per favor canvia-lo adés d'editar artículs.</strong>",
'editingold'                => "<strong>ATENCIÓ:Estàs editant una versió antiga d'esta pàgina.
Si la guardes, els canvis fets des d'eixa revisió se perdran.</strong>",
'yourdiff'                  => 'Diferències',
'copyrightwarning'          => "Per favor, Tin en conte que totes les contribucions per al proyecte {{SITENAME}} se consideren com a publicades baix els termes de la llicència $2 (mira més detalls a $1). Si no desiges la modificació i distribució lliure dels teues escrits sense el teu consentiment, no els poses ací.<br />
A més a més, al manar el teu text, dona fe que tot es baix la teua autoria, o copiats des de fonts en el domini públic o pareguts. Tens que saber que este <strong>no</strong> és el cas de la majoria de pàgines que hi ha a Internet.
<strong>No utilises textos en drets d'autor sense permís!</strong>",
'copyrightwarning2'         => "Per favor, Tin en conte que totes les contribucions per al proyecte {{SITENAME}} poden ser corregits o borrats sense pietat per atres usuaris. Si no desiges la modificació i distribució lliure dels teues escrits sense el teu consentiment, no els poses ací.<br />
A més a més, en enviar el teu text, dona fe què tot es baix la teua autoria, o copiats des de fonts en el domini públic o pareguts (mira $1). Tens que saber que este <strong>no</strong> es el cas de la majoria de pàgines que hi ha a Internet.<strong>No utilises textos en drets d'autor sense permís!</strong>",
'longpagewarning'           => "<strong>ATENCIÓ: Esta pàgina fa $1 kB; hi ha navegadors que poden presentar problemes editant pàgines que s'acosten o sobrepassen els 32 kB. Intenta, si es possible, dividir la pàgina en seccions més chicotetes.</strong>",
'longpageerror'             => '<strong>ERROR: El text que has introduït es de $1 kB i  sobrepassa el màxim permés de $2 kB. Per lo tant, no se guardarà.</strong>',
'readonlywarning'           => '<strong>ADVERTÈNCIA: La base de dades està tancada per manteniment
i no pots deixar les teues contribucions en estes moments. pots retallar i enganchar el codi
en un ficher de text i guarda-lo més tart.</strong>',
'protectedpagewarning'      => '<strong>ATENCIÓ: Esta pàgina està bloquejada i només pot ser editada per usuaris [[{{MediaWiki:grouppage-sysop}}|administradors]].</strong>',
'semiprotectedpagewarning'  => "'''Atenció:''' Esta pàgina està bloquejada i només pot ser editada per usuaris registrats.",
'cascadeprotectedwarning'   => "'''Avís:''' S'ha bloquejat esta pàgina, per tant només els usuaris en permissos d'administrador poden editar-lo, ya que se troba en les següents pàgines protegides en cascada:",
'templatesused'             => 'Esta pàgina utilisa les següents plantilles:',
'templatesusedpreview'      => 'Plantilles usades en esta previsualisació:',
'templatesusedsection'      => 'Plantilles usades en esta secció:',
'template-protected'        => '(protegida)',
'template-semiprotected'    => '(semiprotegida)',
'edittools'                 => "<!-- Es mostrarà als formularis d'edició i de càrrega el text que hi haja després d'esta línia. -->",
'nocreatetitle'             => "S'ha llimitat la creació de pàgines",
'nocreatetext'              => "Està restringida la possibilitat de crear noves pàgines.
Pots editar les planes ya existents o bè [[Special:Userlogin|entrar en un conte d'usuari]].",

# "Undo" feature
'undo-success' => "Pot desfer-se la modificació. Per favor, revisa la comparació de baix per a assegurar-te que es el que vols fer; entonces deixa els canvis per a finalisar la desfeta de l'edició.",
'undo-failure' => 'No pot desfer-se la modificació perqué hi ha edicions entre mig que hi entren en conflicte.',
'undo-summary' => 'Se desfà la revisió $1 de [[Special:Contributions/$2|$2]] ([[User talk:$2|Discussió]])',

# Account creation failure
'cantcreateaccounttitle' => 'No se pot crear el conte',
'cantcreateaccounttext'  => "La creació de contes d'usuari des d'esta direcció IP (<b>$1</b>) s'ha bloquejat. 
Provablement se deu a atacs insistents de vandalisme per part d'usuaris del teu mateix proveïdor d'internet.",
# History pages
'revhistory'          => 'Historial de revisions',
'viewpagelogs'        => "Visualisa els registres d'esta pàgina",
'nohistory'           => 'No hi ha un historial de revisions per a esta pàgina.',
'revnotfound'         => 'Revisió no trobada',
'revnotfoundtext'     => "No s'ha pogut trobar la revisió antiga de la pàgina que demanaves.
Revisa l'URL que has utilisat per a accedir.",
'loadhist'            => 'Recuperant la historial de la pàgina',
'currentrev'          => 'Revisió actual',
'revisionasof'        => 'Revisió de $1',
'revision-info'       => 'Revisió de $1; $2',
'previousrevision'    => '←Versió anterior',
'nextrevision'        => 'Versió posterior→',
'currentrevisionlink' => 'Versió actual',
'cur'                 => 'act',
'next'                => 'seg',
'last'                => 'prev',
'orig'                => 'orig',
'page_first'          => 'primera',
'page_last'           => 'última',
'histlegend'          => 'Simbologia: (act) = diferència en la versió actual,
(prev) = diferència en la versió prèvia, m = edició menor',
'deletedrev'          => '[suprimit]',
'histfirst'           => 'El primer',
'histlast'            => "L'últim",

# Revision feed
'history-feed-title'          => 'Historial de revisió',
'history-feed-description'    => 'Historial de revisió per a esta pàgina del wiki',
'history-feed-item-nocomment' => '$1 a $2', # user at time
'history-feed-empty'          => 'La pàgina demanada no existix.
Potser ha segut borrada o renomenada.
Intenta [[Special:Search|buscar al mateix wiki]] per a noves pàgines rellevants.',

# Revision deletion
'rev-deleted-comment'         => "(s'ha suprimit el comentari)",
'rev-deleted-user'            => "(s'ha suprimit el nom d'usuari)",
'rev-deleted-text-permission' => '<div class="mw-warning plainlinks">
Esta versió de la pàgina ha segut eliminada dels archius públics. Mira més detalls al [{{fullurl:Special:Log/delete|page={{PAGENAMEE}}}} registre d\'esborrats].
</div>',
'rev-deleted-text-view'       => '<div class="mw-warning plainlinks">
Esta versió de la pàgina ha segut eliminada dels archius públics. Com a administrador d\'esta wiki pots mirar-la; mira més detalls al [{{fullurl:Special:Log/delete|page={{PAGENAMEE}}}} registre de borrats].
</div>',
'rev-delundel'                => 'mostra/amaga',
'revisiondelete'              => 'Borrar/restaurar revisions',
'revdelete-nooldid-title'     => 'No hi ha pàgina per a la reversió',
'revdelete-nooldid-text'      => 'No has especificat la versió des de la qual vols aplicar esta funció.',
'revdelete-selected'          => 'Revisió seleccionada de [[:$1]]',
'revdelete-text'              => "Les versions borrades se mostraran encara dins de l'historial de l'artícul, si bé el seu contingut serà inaccessible al públic.

Atres administradors de la uep basada en wiki encara podrien accedir al contingut amagat i restituir-lo de nou a través de esta mateixa navegació, si no hi ha cap atra restricció adicional pels operadors del lloc uep.",
'revdelete-legend'            => 'Definix restriccions en la revisió:',
'revdelete-hide-text'         => 'Amaga el text de revisió',
'revdelete-hide-comment'      => "Amaga el comentari de l'edició",
'revdelete-hide-user'         => "Amaga el nom d'usuari o la IP de l'editor",
'revdelete-hide-restricted'   => 'Aplica estes restriccions als administradors com també als atres',
'revdelete-log'               => 'Comentari del registre:',
'revdelete-submit'            => 'Aplica a la revisió seleccionada',
'revdelete-logentry'          => "s'ha canviat la visibilitat de la revisió de [[$1]]",

# Diffs
'difference'                => '(Diferència entre revisions)',
'loadingrev'                => 'carregant revisió',
'lineno'                    => 'Llínia $1:',
'editcurrent'               => "Edita la versió actual d'esta pàgina",
'selectnewerversionfordiff' => 'Selecciona una nova versió per a comparar',
'selectolderversionfordiff' => 'Selecciona una versió més antiga per a comparar',
'compareselectedversions'   => 'Compara les versions seleccionades',
'editundo'                  => 'desfés',
'diff-multi'                => '(Hi ha {{plural:$1|una revisió intermedia|$1 revisions intermedies}})',

# Search results
'searchresults'         => 'Resultats de la búsqueda',
'searchresulttext'      => 'Per a més informació de les búsquedes del proyecte {{SITENAME}}, anar a [[{{MediaWiki:helppage}}|{{int:help}}]].',
'searchsubtitle'        => "Has buscat '''[[:$1]]'''",
'searchsubtitleinvalid' => 'Per consulta "$1"',
'badquery'              => 'Consulta formulada de manera incorrecta',
'badquerytext'          => "No s'ha pogut processar la búsqueda.
El motiu es provablement perque has intentat buscar una paraula de menys de tres lletres, la qual cosa encara no es possible.
També pot ser que hajau comés un error en escriure el terme.
Torna a provar en una atra búsqueda.",
'matchtotals'           => 'La consulta "$1" ha coincidit en $2  títuls d\'artículs
i el text de $3 artículs.',
'noexactmatch'          => "'''No hi ha cap pàgina nomenada «$1».''' Si vols, pot ajudar [[:$1|creant-la]].",
'titlematches'          => "Coincidències de títul d'artícul",
'notitlematches'        => "No hi ha coincidències de títul d'artícul",
'textmatches'           => "Coincidències de text d'artícul",
'notextmatches'         => "No hi ha coincidències de text d'artícul",
'prevn'                 => '$1 anteriors',
'nextn'                 => '$1 següents',
'viewprevnext'          => 'Anar a ($1) ($2) ($3).',
'showingresults'        => "S'està mostrant a baix <b>$1</b> resultats escomençant per #<b>$2</b>.",
'showingresultsnum'     => 'Tot seguit se llisten els <b>$3</b> resultats començant pel nº<b>$2</b>.',
'nonefound'             => '<strong>Nota</strong>: les búsquedes sense èxit són causades normalment
per búsquedes de paraules comunes com "la" o "de",
que no se troben a l\'índex, o per especificar més d\'una paraula a Buscar (només les pàgines
que contenen tots els termes d\'una búsquedes apareixeran en el resultat).',
'powersearch'           => 'Busca',
'powersearchtext'       => '
Busca en espais de nom :<br />
$1<br />
$2 Llista redireccions   Busca $3 $9',
'searchdisabled'        => 'La búsquedes dins el proyecte {{SITENAME}} està desactivat. Mentrestant pots buscar a través de Google, pero tin en conte que la seua base de dades no estarà actualisada.',
'blanknamespace'        => '(Portada)',

# Preferences page
'preferences'              => 'Preferències',
'mypreferences'            => 'Preferències',
'prefsnologin'             => 'No has iniciat una sessió',
'prefsnologintext'         => "Tens que haver [[Special:Userlogin|entrat]] per seleccionar preferències d'usuari.",
'prefsreset'               => "Les preferències han segut respostes des d'almagasenage.",
'qbsettings'               => 'Preferències de "Quickbar"',
'qbsettings-none'          => 'Cap',
'qbsettings-fixedleft'     => 'Fixa a la dreta',
'qbsettings-fixedright'    => "Fixa a l'esquerra",
'qbsettings-floatingleft'  => "Surant a l'esquerra",
'qbsettings-floatingright' => 'Surant a la dreta',
'changepassword'           => 'Canvia la contrasenya',
'skin'                     => 'Apariència',
'math'                     => 'Com se mostren les fòrmules',
'dateformat'               => 'Format de la data',
'datedefault'              => 'Cap preferència',
'datetime'                 => 'Data i hora',
'math_failure'             => "No s'ha pogut entendre",
'math_unknown_error'       => 'error desconegut',
'math_unknown_function'    => 'funció desconeguda',
'math_lexing_error'        => 'error de lèxic',
'math_syntax_error'        => 'error de sintaxis',
'math_image_error'         => "Hi ha hagut una errada en la conversió cap el format PNG; verifica la instalació de ''Latex'', ''dvips'', ''gs'' i ''convert''.",
'math_bad_tmpdir'          => 'No ha segut possible crear el directori temporal de math o escriure-hi dins.',
'math_bad_output'          => "No ha segut possible crear el directori d'eixida de math o escriure-hi dins.",
'math_notexvc'             => "No s'ha trobat el ficher eixecutable ''texvc''; per favor, mira math/README per a configurar-lo.",
'prefs-personal'           => "Perfil d'usuari",
'prefs-rc'                 => 'Canvis recents',
'prefs-watchlist'          => 'Llista de seguiment',
'prefs-watchlist-days'     => 'Número de dies per mostrar en la llista de seguiment:',
'prefs-watchlist-edits'    => 'Número de modificacions a mostrar en una llista estesa de seguiment:',
'prefs-misc'               => 'Atres preferències',
'saveprefs'                => 'Guardar les preferències',
'resetprefs'               => 'Torna a preferències per defecte',
'oldpassword'              => 'Contrasenya antiga',
'newpassword'              => 'Contrasenya nova',
'retypenew'                => 'Torna a escriure la nova contrasenya:',
'textboxsize'              => 'Dimensions de la caixa de text',
'rows'                     => 'Files',
'columns'                  => 'Columnes',
'searchresultshead'        => 'Preferències de la Busca',
'resultsperpage'           => 'Resultats a mostrar per pàgina',
'contextlines'             => 'Llínies a mostrar per resultat',
'contextchars'             => 'Caràcters de context per línia',
'recentchangescount'       => 'Número de títuls en canvis recents',
'savedprefs'               => 'Les teues preferències han segut guardades.',
'timezonelegend'           => 'Fus horari',
'timezonetext'             => "Introduïu el número d'hores de diferència entre la teua hora local i la del servidor (UTC).",
'localtime'                => 'Hora local',
'timezoneoffset'           => 'Diferència',
'servertime'               => 'Hora del servidor',
'guesstimezone'            => 'Ompli-lo des del navegador',
'allowemail'               => "Habilita el correu electrònic des d'atres usuaris",
'defaultns'                => 'Busca per defecte en els següents espais de noms:',
'default'                  => 'per defecte',
'files'                    => 'Fichers',

# User rights
'userrights-lookup-user'     => "Gestiona els grups d'usuari",
'userrights-user-editname'   => "Introduïx un nom d'usuari:",
'editusergroup'              => "Edita els grups d'usuaris",
'userrights-editusergroup'   => "Edita els grups d'usuaris",
'saveusergroups'             => "Guarda els grups d'usuari",
'userrights-groupsmember'    => 'Membre de:',
'userrights-groupsavailable' => 'Grups disponibles:',
'userrights-groupshelp'      => "Selecciona els grups dels quals vols suprimir-ne l'usuari o afegir-lo.
Els grups no seleccionats no se canviaran. Pots traure la selecció d'un grup en CTRL + Clic",

# Groups
'group'            => 'Grup:',
'group-bot'        => 'bots',
'group-sysop'      => 'administradors',
'group-bureaucrat' => 'burócrates',
'group-all'        => '(tots)',

'group-bot-member'        => 'bot',
'group-sysop-member'      => 'administrador',
'group-bureaucrat-member' => 'burócrata',

'grouppage-bot'        => 'Proyecte:Bots',
'grouppage-sysop'      => 'Proyecte:Administradors',
'grouppage-bureaucrat' => 'Proyecte:Burócrates',

# User rights log
'rightslog'      => "Registre dels permissos d'usuari",
'rightslogtext'  => "Este es un registre de canvis dels permissos d'usuari.",
'rightslogentry' => "has modificat els drets de l'usuari «$1» del grup $2 al de $3",
'rightsnone'     => '(cap)',

# Recent changes
'recentchanges'                     => 'Canvis recents',
'recentchangestext'                 => 'Seguix els canvis recents del proyecte {{SITENAME}} en esta pàgina.',
'recentchanges-feed-description'    => 'Seguix en este canal els canvis més recents del wiki.',
'rcnote'                            => 'A continuació hi ha els últims <strong>$1</strong> canvis en els últims <strong>$2</strong> dies, com de $3.',
'rcnotefrom'                        => 'A baix hi ha els canvis des de <b>$2</b> (es mostren fins <b>$1</b>).',
'rclistfrom'                        => 'Mostra els canvis nous des de $1',
'rcshowhideminor'                   => '$1 edicions menors',
'rcshowhidebots'                    => '$1 bots',
'rcshowhideliu'                     => '$1 usuaris identificats',
'rcshowhideanons'                   => '$1 usuaris anònims',
'rcshowhidepatr'                    => '$1 edicions patrullades',
'rcshowhidemine'                    => '$1 edicions pròpies',
'rclinks'                           => 'Mostra els últims $1 canvis en els últims $2 dies<br />$3',
'diff'                              => 'dif',
'hist'                              => 'hist',
'hide'                              => 'amaga',
'show'                              => 'mostra',
'minoreditletter'                   => 'm',
'newpageletter'                     => 'N',
'boteditletter'                     => 'b',
'number_of_watching_users_pageview' => '[Usuaris que vigilen esta pàgina: $1]',
'rc_categories'                     => 'Llimita a les categories (separades per "|")',
'rc_categories_any'                 => 'Qualsevol',

# Recent changes linked
'recentchangeslinked' => "Seguiment d'enllaços",

# Upload
'upload'                      => 'Pujar image',
'uploadbtn'                   => 'Puja un ficher',
'reupload'                    => 'Puja de nou',
'reuploaddesc'                => 'Torna al formulari per apujar.',
'uploadnologin'               => 'No has iniciat una sessió',
'uploadnologintext'           => "Tens que [[Special:Userlogin|iniciar una sessió]]
per a penjar-hi fichers.",
'upload_directory_read_only'  => 'El servidor uep no pot escriure al directori de càrrega ($1)',
'uploaderror'                 => "S'ha produït un error en l'intent de carregar",
'uploadtext'                  => "Utilisa el formulari de baix per a carregar-hi una còpia d'un ficher. Per a visualisar o buscar images que s'hagueren carregat prèviament, anar a la [[Special:Imagelist|llista de fichers carregats]]. Les càrregues i les destruccions se registren en el [[Special:Log/upload|registre de càrregues]].

Per a incloure una image en un artícul, fes un enllaç de la forma
* '''<nowiki>[[</nowiki>{{ns:image}}<nowiki>:Ficher.jpg]]</nowiki>''';
* '''<nowiki>[[</nowiki>{{ns:image}}<nowiki>:Ficher.png|alt text]]</nowiki>'''; o per a sons
* '''<nowiki>[[</nowiki>{{ns:media}}<nowiki>:Ficher.ogg]]</nowiki>''' per a enllaçar-ho directament al ficher.",
'uploadlog'                   => 'registre de càrregues',
'uploadlogpage'               => 'Registre de càrregues',
'uploadlogpagetext'           => "A baix hi ha un llistat dels fichers que s'han pujat més recentment.
Totes les hores són les del servidor (UTC).",
'filename'                    => 'Nom de ficher',
'filedesc'                    => 'Sumari',
'fileuploadsummary'           => 'Resum:',
'filestatus'                  => 'Situació del copyright',
'filesource'                  => 'Font',
'uploadedfiles'               => 'Fichers carregats',
'ignorewarning'               => 'Ignora qualsevol avís i guarda el ficher igualment.',
'ignorewarnings'              => 'Ignora qualsevol avís',
'illegalfilename'             => "El nom de l'archiu “$1” conté caràcters que no estan permesos en els títuls de pàgines. Per favor canvia el nom a l'archiu i torna-lo a carregar-lo.",
'badfilename'                 => 'El nom de la image s\'ha canviat a "$1".',
'large-file'                  => 'Els fichers importants no haurien de ser més grans de $1; este ficher ocupa $2.',
'largefileserver'             => 'Este ficher es més gran del que el servidor permet.',
'emptyfile'                   => "L'archiu que has carregat pareix estar buit. Això por ser degut a un mal caràcter en el nom de l'archiu. Per favor revisa si realment vols carregar este archiu.",
'fileexists'                  => 'Ya hi existix un ficher en este nom, per favor, verifica $1 si no estas segur de voler substituir-lo.',
'fileexists-forbidden'        => 'Ya hi existix un ficher en este nom; per favor, torna arrere i carrega este ficher baix un atre nom. [[Image:$1|thumb|center|$1]]',
'fileexists-shared-forbidden' => 'Ya hi ha un ficher en este nom al fons comú de fichers; per favor, torna arrere i carregua una còpia en un atre nom. [[Image:$1|thumb|center|$1]]',
'successfulupload'            => "El ficher s'ha carregat en èxit",
'uploadwarning'               => 'Avís de càrrega',
'savefile'                    => 'Guarda el ficher',
'uploadedimage'               => '"[[$1]]" carregat.',
'uploaddisabled'              => "S'ha inhabilitat la càrrega",
'uploaddisabledtext'          => "S'ha inhabilitat la càrrega de fichers en este wiki.",
'uploadscripted'              => 'Este ficher conté codi HTML o de seqüències que pot ser interpretat equivocadament per un navegador.',
'uploadcorrupt'               => 'El ficher està corrupte o té una extensió incorrecte. Reviseu-lo i torneu-lo a pujar.',
'uploadvirus'                 => 'El ficher conté un virus! Detalls: $1',
'sourcefilename'              => 'Font del nom del ficher',
'destfilename'                => 'Nom del ficher de destinació',
'watchthisupload'             => 'Vigila esta pàgina',
'filewasdeleted'              => "Prèviament se va carregar un ficher d'este nom i després va ser borrat. Hauries de verificar $1 adés de procedir a carregar-lo una atra vegada.",

'upload-proto-error'      => 'El protocol es incorrecte',
'upload-proto-error-text' => 'Per a les càrregues remotes fa falta que els URL comencen en <code>http://</code> o <code>ftp://</code>.',
'upload-file-error'       => "S'ha produït un error intern",
'upload-file-error-text'  => "S'ha produït un error de càrrega desconegut quan s'intentava crear un ficher temporal al servidor. Contactar al teu administrador de sistemes.",
'upload-misc-error'       => "S'ha produït un error de càrrega desconegut",
'upload-misc-error-text'  => "S'ha produït un error desconegut durant la càrrega. Verifica que l'URL es vàlit i accessible, i torna-ho a provar. Si el problema persistix, cantacta en el teu administrador de sistemes.",

# Some likely curl errors. More could be added from <http://curl.haxx.se/libcurl/c/libcurl-errors.html>
'upload-curl-error6'       => "No s'ha pogut accedir a l'URL",
'upload-curl-error6-text'  => "No s'ha pogut accedir a l'URL que s'ha proporcionat. Torna a comprovar que es correcte i que el lloc està funcionant.",
'upload-curl-error28'      => "S'ha excedit el temps d'espera de la càrrega",
'upload-curl-error28-text' => "El lloc ha tardat massa en respondre. Comprova que està funcionant, esperaun moment i torna a provar. Pots d'intentar-ho en uns minuts.",

'license'            => 'Llicència',
'nolicense'          => "No s'ha seleccionat cap",
'upload_source_url'  => ' (un URL vàlit i accessible públicament)',
'upload_source_file' => ' (un ficher en el teu ordenador)',

# Image list
'imagelist'                 => "Llistat d'images",
'imagelisttext'             => "Llista {{plural:$1|d'un sol archiu|de '''$1''' archius ordenats $2}}.",
'imagelistforuser'          => 'Només se mostren les images que ha pujat $1',
'getimagelist'              => " obtenint el llistat d'images",
'ilsubmit'                  => 'Busca',
'showlast'                  => 'Mostra les darreres $1 images ordenades $2.',
'byname'                    => 'per nom',
'bydate'                    => 'per data',
'bysize'                    => 'per mida',
'imgdelete'                 => 'edi',
'imgdesc'                   => 'desc',
'imgfile'                   => 'ficher',
'imglegend'                 => 'Simbologia: (edi) = mostra/edita la descripció de la image.',
'imghistory'                => 'Història de la image',
'revertimg'                 => 'res',
'deleteimg'                 => 'bor',
'deleteimgcompletely'       => "Borra totes les versions d'este archiu",
'imghistlegend'             => 'Simbologia: (act) = esta es la image actual, (bor) = borra
esta versió antiga, (rev) = revertix a esta versió antiga.
<br /><i>Fes clic sobre la data per vore la image carregada en esta data</i>.',
'imagelinks'                => 'Enllaços a la image',
'linkstoimage'              => 'Les següents pàgines enllacen a esta image:',
'nolinkstoimage'            => 'No hi ha pàgines que enllacen esta image.',
'sharedupload'              => 'Este ficher està compartit i pot ser usat per atres proyectes.',
'shareduploadwiki'          => 'Consulta $1 per a més informació.',
'shareduploadwiki-linktext' => 'pàgina de descripció del ficher',
'noimage'                   => 'No existix cap ficher en este nom, pero pots $1.',
'noimage-linktext'          => 'Actualisa',
'uploadnewversion-linktext' => "Actualisa una nova versió d'este ficher",
'imagelist_date'            => 'Data',
'imagelist_name'            => 'Nom',
'imagelist_user'            => 'Usuari',
'imagelist_size'            => 'Mida (octets)',
'imagelist_description'     => 'Descripció',
'imagelist_search_for'      => "Busca un nom d'image:",

# MIME search
'mimesearch'         => 'Busca per MIME',
'mimesearch-summary' => 'Esta pàgina permet filtrar archius de tipo MIME. Input: contenttype/subtype, e.g. <tt>image/jpeg</tt>.',
'mimetype'           => 'Tipo MIME:',
'download'           => 'descarrega',

# Unwatched pages
'unwatchedpages' => 'Pàgines desateses',

# List redirects
'listredirects' => 'Llista de redireccions',

# Unused templates
'unusedtemplates'     => 'Plantilles no utilisades',
'unusedtemplatestext' => "Esta pàgina mostra les pàgines en l'espai de noms de plantilles, que no estan incloses en cap atra pàgina. Enecorda't de comprovar les pàgines que hi enllacen abans d'esborrar-les.",
'unusedtemplateswlh'  => 'atres enllaços',

# Random redirect
'randomredirect' => "Redirecció a l'asar",

# Statistics
'statistics'             => 'Estadístiques',
'sitestats'              => 'Estadístiques del lloc',
'userstats'              => "Estadístiques d'usuari",
'sitestatstext'          => "Hi ha un total de '''$1''' pàgines en la base de dades.
Això inclou pàgines de discussió, pàgines sobre el proyecte {{SITENAME}}, pàgines mínimes,
redireccions, i atres que provablement no se poden classificar com a artículs.
Excloent-les, hi ha '''$2''' pàgines que provablement són artículs llegítims.

S'han penjat '''$8''' fichers.

Hi ha hagut un total de '''$3''' visites a pàgines, i '''$4''' edicions de pàgina
des que el programa s'ha configurat.
Això resulta en un promig de '''$5''' edicions per pàgina,
i '''$6''' visites per edició.

La mida de la [http://meta.wikimedia.org/wiki/Help:Job_queue cua de treballs] es '''$7'''.",
'userstatstext'          => "Hi ha '''$1''' usuaris registrats, dels quals 
{{PLURAL:$2|un (el '''$4%''') n'és $5|'''$2''' (el '''$4%''') en són $5}}.",
'statistics-mostpopular' => 'Pàgines més visualisades',

'disambiguations'      => 'Pàgines de desambiguació',
'disambiguationspage'  => 'Template:desambiguació',
'disambiguations-text' => "Les següents pàgines enllacen a una '''pàgina de desambiguació'''. Per això, fa falta que enllacen al tema apropiat.<br />Una pàgina se tracta com de desambiguació si utilisa una plantilla que prové de [[MediaWiki:disambiguationspage]]",

'doubleredirects'     => 'Redireccions dobles',
'doubleredirectstext' => '<b>Atenció:</b> este llistat pot contindre falsos positius. Això normalment significa que hi ha text

addicional en enllaços baix el primer #REDIRECT.<br />
Cada fila conté enllaços al segon i tercer redireccionament, així com la primera llínia del

segon redireccionament, la qual cosa dòna normalment l\'artícul "real", al que el primer redireccionamet hauria d\'apuntar.',

'brokenredirects'        => 'Redireccions rompudes',
'brokenredirectstext'    => 'Les següents redireccions enllacen a pàgines inexistents:',
'brokenredirects-edit'   => '(edita)',
'brokenredirects-delete' => '(elimina)',

# Miscellaneous special pages
'nbytes'                  => '$1 {{PLURAL:$1|octet|octets}}',
'ncategories'             => '$1 {{PLURAL:$1|categoria|categories}}',
'nlinks'                  => '$1 {{PLURAL:$1|enllaç|enllaços}}',
'nmembers'                => '$1 {{PLURAL:$1|membre|membres}}',
'nrevisions'              => '$1 {{PLURAL:$1|revisió|revisions}}',
'nviews'                  => '$1 {{PLURAL:$1|visita|visites}}',
'specialpage-empty'       => 'Esta pàgina està buida.',
'lonelypages'             => 'Pàgines orfes',
'lonelypagestext'         => "Les següents pàgines no s'enllacen des d'atres pàgines d'este wiki.",
'uncategorizedpages'      => 'Pàgines sense categoria',
'uncategorizedcategories' => 'Categories sense categoria',
'uncategorizedimages'     => 'Images sense categoria',
'unusedcategories'        => 'Categories sense artículs',
'unusedimages'            => 'Images sense us',
'popularpages'            => 'Pàgines populars',
'wantedcategories'        => 'Categories demanades',
'wantedpages'             => 'Pàgines demanades',
'mostlinked'              => 'Pàgines més enllaçades',
'mostlinkedcategories'    => 'Categories més utilisades',
'mostcategories'          => 'Pàgines que utilisen més categories',
'mostimages'              => 'Images més enllaçades',
'mostrevisions'           => 'Pàgines més modificades',
'allpages'                => 'Totes les pàgines',
'prefixindex'             => 'Buscar per prefix',
'randompage'              => "Artícul a l'asar",
'shortpages'              => 'Pàgines curtes',
'longpages'               => 'Pàgines llargues',
'deadendpages'            => 'Pàgines assucac',
'deadendpagestext'        => "Estes pàgines no tenen enllaços a d'atres pàgines d'esta mateixa wiki.",
'protectedpages'          => 'Pàgines protegides',
'protectedpagestext'      => 'Estes pàgines estan protegides contra la seua lliure edició o el seu reanomenament:',
'protectedpagesempty'     => 'No hi ha cap pàgina protegida per ara',
'listusers'               => "Llistat d'usuaris",
'specialpages'            => 'Pàgines especials',
'spheading'               => 'Pàgines especials',
'restrictedpheading'      => 'Pàgines especials restringides',
'rclsub'                  => '(a pàgines enllaçades des de "$1")',
'newpages'                => 'Pàgines noves',
'newpages-username'       => "Nom d'usuari:",
'ancientpages'            => 'Pàgines més antigues',
'intl'                    => 'Enllaços entre llengües',
'move'                    => 'Renomena',
'movethispage'            => 'Trasllada la pàgina',
'unusedimagestext'        => '<p>Donat conte que atres llocs uep poden enllaçar una image en un URL directe i estar llistada aquí.</p>',
'unusedcategoriestext'    => 'Les pàgines de categoria següents existixen encara que cap atre artícul o categoria les utilisa.',

# Book sources
'booksources'               => 'Obres de referència',
'booksources-search-legend' => 'Busca fonts de llibres',
'booksources-go'            => 'Anar',
'booksources-text'          => "A baix hi ha una llista d'enllaços d'atres llocs que venen llibres nous i de segona mà, i també podrien tenir més informació dels llibres que estas buscant:",

'categoriespagetext' => 'Les categories següents existixen en el wiki.',
'data'               => 'Dades',
'userrights'         => "Gestió dels permissos d'usuari",
'groups'             => "Grups d'usuaris",
'alphaindexline'     => '$1 a $2',
'version'            => 'Versió',

# Special:Log
'specialloguserlabel'  => 'Usuari:',
'speciallogtitlelabel' => 'Títul:',
'log'                  => 'Registres',
'alllogstext'          => "Presentació combinada de càrregues, eliminacions, proteccions, bloquejos, i registres d'administrador. 
Pots reduir l'extensió seleccionant el tipo de identificació, el nom del usuari, o la pàgina afectada.",
'logempty'             => 'No hi ha cap coincidència en el registre.',

# Special:Allpages
'nextpage'          => 'Següent pàgina ($1)',
'prevpage'          => 'Pàgina prèvia ($1)',
'allpagesfrom'      => 'Mostra les pàgines que van crear-se el:',
'allarticuls'       => 'Tots els artículs',
'allinnamespace'    => "Totes les pàgines (de l'espai de noms $1)",
'allnotinnamespace' => "Totes les pàgines (que no són a l'espai de noms $1)",
'allpagesprev'      => 'Anterior',
'allpagesnext'      => 'Següent',
'allpagessubmit'    => 'Anar',
'allpagesprefix'    => 'Mostra les pàgines en prefig:',
'allpagesbadtitle'  => "El títul de la pàgina que hi has inserit no es vàlit o hi conté un prefix d'inter-wiki o inter-llingüístic. Hi podria contindre un o més caràcters els quals no s'haurien d'utilisar per als títuls.",

# Special:Listusers
'listusersfrom'      => 'Mostra usuaris començant per:',
'listusers-submit'   => 'Mostra',
'listusers-noresult' => "No s'han trobat coincidències de noms d'usuaris. Per favor, busca també en variacions per mayúscules i minúscules.",

# E-mail user
'mailnologin'     => "No envies la direcció",
'mailnologintext' => "Tens que haver [[Special:Userlogin|entrat]]
i tenir una direcció electrònica vàlida en les teues [[Special:Preferences|preferències]]
per enviar un correu electrònic a atres usuaris.",
'emailuser'       => 'Envia un mensage de correu electrònic a este usuari',
'emailpage'       => 'Correu electrònic a usuari',
'emailpagetext'   => "Si este usuari ha entrat una direcció electrònica vàlida en les teues preferències d'usuari, el següent formulari

servix per enviar-li un mensage.
La direcció electrònica que has introduït en les teues preferències d'usuari apareixerà en el remitent, de manera que el destinatari puga

respondre.",
'usermailererror' => "L'objecte de correu ha retornat un error:",
'defemailsubject' => 'Direcció correu de {{SITENAME}}',
'noemailtitle'    => 'No hi ha cap direcció electrònica',
'noemailtext'     => "Este usuari no ha especificat una direcció electrònica vàlida, o ha elegit no rebre correu electrònic d'atres usuaris

.",
'emailfrom'       => 'De',
'emailto'         => 'Per',
'emailsubject'    => 'Assunt',
'emailmessage'    => 'Mensage',
'emailsend'       => 'Envia',
'emailccme'       => "Envia'm una còpia del meu mensage.",
'emailccsubject'  => 'Còpia del teu mensage a $1: $2',
'emailsent'       => 'Correu electrònic enviat',
'emailsenttext'   => 'El teu correu electrònic ha segut enviat.',

# Watchlist
'watchlist'            => 'Llista de seguiment',
'mywatchlist'          => 'Llista de seguiment',
'watchlistfor'         => "(per a '''$1''')",
'nowatchlist'          => 'No tens cap element en el teu llistat de seguiment.',
'watchlistanontext'    => 'Fes clic $1 per a visualisar o editar elements de la teua llista de seguiment.',
'watchlistcount'       => "'''Tens {{PLURAL:$1|$1 element|$1 elements}} en la teua llista de seguiment, incloent-hi les pàgines de discussió.'''",
'watchnologin'         => 'No has iniciat la sessió',
'watchnologintext'     => "Tens que [[Special:Userlogin|entrar]]
per modificar el teu llistat de seguiment.",
'addedwatch'           => "S'ha afegit la pàgina a la llista de seguiment",
'addedwatchtext'       => "S'ha afegit la pàgina «[[:$1]]» a la teua [[Special:Watchlist|llista de seguiment]].

Els canvis futurs que tindran lloc en esta pàgina i la seua corresponent discussió s'avisaran a la teua [[Special:Watchlist|llista de seguiment]], resaltant-se també '''en negreta''' en la [[Special:Recentchanges|llista de canvis recents]] per a que tot lo món puga donar-se'n conte més fàcilment.

Si vols deixar de vigilar la pàgina, fes clic sobre l'enllaç de «desatén» de la barra lateral.",
'removedwatch'         => "S'ha tret de la llista de seguiment",
'removedwatchtext'     => 'S\'ha tret la pàgina "[[:$1]]" de la teua llista de seguiment.',
'watch'                => 'Vigila',
'watchthispage'        => 'Vigila esta pàgina',
'unwatch'              => 'Desatén',
'unwatchthispage'      => 'Desatén',
'notanarticul'         => 'No es un artícul',
'watchnochange'        => "No s'ha editat cap dels elements que vigila en el periodo de temps que se mostra.",
'watchlist-details'    => '{{PLURAL:$1|$1 pàgina|$1 pàgines}} vigilades, sense contar les pàgines de discussió',
'wlheader-enotif'      => "* S'ha habilitat la notificació per correu electrònic.",
'wlheader-showupdated' => "* Les pàgines que s'han canviat des de la teua última visita se mostren '''en negreta'''",
'watchmethod-recent'   => "s'està comprovant si ha pàgines vigilades en les edicions recents",
'watchmethod-list'     => "s'està comprovant si hi ha edicions recents en les pàgines vigilades",
'watchlistcontains'    => 'La teua llista de seguiment conté $1 pàgines.',
'iteminvalidname'      => "Hi ha un problema en l'element '$1': el nom no es vàlit...",
'wlnote'               => 'A baix hi ha els últims $1 canvis en les últimes <b>$2</b> hores.',
'wlshowlast'           => '<small>- Mostra les últimes $1 hores, els últims $2 dies o $3</small>',
'wlsaved'              => 'Esta es una versió guardada de la teua llista de seguiment.',
'watchlist-show-bots'  => 'Mostra les edicions dels bots',
'watchlist-hide-bots'  => 'Amaga les edicions dels bots',
'watchlist-show-own'   => 'Mostra les edicions pròpies',
'watchlist-hide-own'   => 'Amaga les edicions pròpies',
'watchlist-show-minor' => 'Mostra les edicions menors',
'watchlist-hide-minor' => 'Amaga les edicions menors',

# Displayed when you click the "watch" button and it's in the process of watching
'watching'   => "S'està vigilant...",
'unwatching' => "S'està desatenent...",

'enotif_mailer'      => 'Sistema de notificació per correu electrònic de {{SITENAME}}',
'enotif_reset'       => 'Marca totes les pàgines com a visitades',
'enotif_newpagetext' => 'Esta es una nova pàgina.',
'changed'            => 'modificat',
'created'            => 'publicat',
'enotif_subject'     => '$PAGEEDITOR ha $CHANGEDORCREATED la pàgina $PAGETITLE en {{SITENAME}}',
'enotif_lastvisited' => "Mira $1 per a tots els canvis que s'han fet des de la teua última visita.",
'enotif_body'        => 'Benvingut, $WATCHINGUSERNAME,

La pàgina $PAGETITLE del proyecte {{SITENAME}} ha segut $CHANGEDORCREATED el dia $PAGEEDITDATE per $PAGEEDITOR, mira $PAGETITLE_URL per a la versió actual.

$NEWPAGE

Resum oferit per l\'editor: $PAGESUMMARY $PAGEMINOREDIT

Contactar a l\'editor:
correu: $PAGEEDITOR_EMAIL
pàgina d\'usuari: $PAGEEDITOR_WIKI

No rebràs més notificacions de futurs canvis si no visita la pàgina. També pots canviar el tipo de notificació de les pàgines que vigila en la teua llista de seguiment.

             El servici de notificació del proyecte {{SITENAME}}

--
Per a canviar les opcions de la teua llista de seguiment anar a:
{{fullurl:Special:Watchlist/edit}}

Sugerències i ajuda:
{{fullurl:{{MediaWiki:helppage}}}}',

# Delete/protect/revert
'deletepage'                  => 'Borra esta pàgina',
'confirm'                     => 'Confirma',
'excontent'                   => 'el contingut era: «$1»',
'excontentauthor'             => "el contingut era: «$1» (i l'única persona qui hi ha editat ha segut «[[Special:Contributions/$2|$2]]»)",
'exbeforeblank'               => "el contingut abans d'estar en blanc era: '$1'",
'exblank'                     => 'la pàgina estava en blanc',
'confirmdelete'               => "Confirma que desixes borrar",
'deletesub'                   => '(Borrant "$1")',
'historywarning'              => 'Avís: La pàgina que vols eliminar té un historial:',
'confirmdeletetext'           => "Estàs a punt de borrar de forma permanent una pàgina o image i tot el seu historial de la base de dades.
Confirma que realment ho vols fer, que entens les
conseqüències, i que el que estàs fent està d'acort en la [[{{MediaWiki:policy-url}}|política]] del proyecte.",
'actioncomplete'              => "S'ha realisat l'acció de manera satisfactòria.",
'deletedtext'                 => '"$1" ha segut borrat.
Mostra $2 per a un registre dels artículs borrats més recents.',
'deletedarticul'              => 'borrat "$1"',
'dellogpage'                  => "Registre_de_borrats",
'dellogpagetext'              => 'Baix hi ha una llista dels artículs borrats recentment.',
'deletionlog'                 => "Registre de borrats",
'reverted'                    => 'Invertit per una revisió anterior',
'deletecomment'               => 'Motiu per a ser borrat',
'imagereverted'               => "S'ha revertit en èxit a una versió anterior.",
'rollback'                    => 'Revertix edicions',
'rollback_short'              => 'Revoca',
'rollbacklink'                => 'Revertix',
'rollbackfailed'              => "No s'ha pogut revocar",
'cantrollback'                => "No s'ha pogut revertir les edicions; el darrer colaborador es l'únic autor d'este articul.",
'alreadyrolled'               => "No se pot retrocedir a la última modificació de [[:$1]]
per l'usuari [[User:$2|$2]] ([[User talk:$2|Discussió]]); algú atre hi ha editat tot seguit o ya ha revertit la pàgina.

La última modificació s'ha fet per l'usuari [[User:$3|$3]] ([[User talk:$3|Discussió]]).",
'editcomment'                 => 'El comentari d\'edició ha segut: "<i>$1</i>".', # only shown if there is an edit comment
'revertpage'                  => "Revertides les edicions de [[Special:Contributions/$2|$2]] ([[User talk:$2|discussió]]); s'ha recuperat la última versió de [[User:$1|$1]]",
'sessionfailure'              => 'Pareix que hi ha problema en la teua sessió; esta acció ha segut anulada en prevenció de suplantació de sessió. Per favor, fes clic en "Torna", i recarrega la pàgina des d\'on vens, entonces intenta-lo de nou.',
'protectlogpage'              => 'Registre de protecció',
'protectlogtext'              => 'Este es el registre de proteccions i desproteccions. mira la [[Special:Protectedpages|llista de pàgines protegides]] per a la llista de les pàgines que actualment tenen alguna protecció.',
'protectedarticul'            => 'protegit «[[$1]]»',
'unprotectedarticul'          => '«[[$1]]» desprotegida',
'protectsub'                  => '(Protegint «$1»)',
'confirmprotect'              => 'Confirma la protecció',
'protectcomment'              => 'Motiu de la protecció',
'protectexpiry'               => "Data d'expiració",
'protect_expiry_invalid'      => "Data d'expiració no vàlida",
'protect_expiry_old'          => "El temps d'expiració ya ha passat.",
'unprotectsub'                => "(S'està desprotegint «$1»)",
'protect-unchain'             => 'Permet diferent nivell de protecció per editar i per moure',
'protect-text'                => 'Açí pots visualisar i canviar el nivell de protecció de la pàgina «$1». Assegurat de seguir les polítiques existents.',
'protect-cascadeon'           => "Esta pàgina se troba protegida perque està inclosa en les següents pàgines que tenen activada una protecció en cascada. Pots canviar el nivell de protecció d'esta pàgina pero això no afectarà la protecció en cascada.",
'protect-default'             => '(per defecte)',
'protect-level-autoconfirmed' => 'Bloqueja els usuaris no registrats',
'protect-level-sysop'         => 'Bloqueja tots els usuaris excepte administradors',
'protect-summary-cascade'     => 'en cascada',
'protect-expiring'            => 'expira el dia $1 (UTC)',
'protect-cascade'             => "Protecció en cascada: protegix totes les pàgines i plantilles dins d'esta.",

# Restrictions (nouns)
'restriction-edit' => 'Edita',
'restriction-move' => 'Renomena',

# Restriction levels
'restriction-level-sysop'         => 'protegida',
'restriction-level-autoconfirmed' => 'semiprotegida',

# Undelete
'undelete'                 => 'Restaura una pàgina borrada',
'undeletepage'             => 'Mostra i restaura pàgines borrades',
'viewdeletedpage'          => 'Visualisa les pàgines eliminades',
'undeletepagetext'         => "Les següents pàgines han segut borrades pero encara són a l'archiu i poden ser restaurades. L'archiu pot ser netejat

periòdicament.",
'undeleteextrahelp'        => "Per a recuperar tota la pàgina, deixa totes les caselles sense seleccionar i
Fes clic en  '''''Recupera'''''. Per a realisar una recuperació selectiva, marca les caselles que corresponguen
a les revisions que vols recuperar, i fes clic a '''''Recupera'''''. Si fas clic '''''Reinicia''''', se netejarà el
camp de comentari i se desmarcaran totes les caselles.",
'undeleterevisions'        => '$1 revisions archivades',
'undeletehistory'          => 'Si restaures una pàgina, totes les revisions seran restaurades a la història.
Si una nova pàgina en el mateix nom ha segut creada des de l\'borrat, les versions restaurades apareixeran com a història anterior, i la revisió actual del la pàgina "viva" no serà substituïda automàticament.',
'undeletehistorynoadmin'   => "S'ha eliminat este artícul. El motiu se mostra
al resum a continuació, juntament en detalls dels usuaris que havien editat esta pàgina
abans de la seua eliminació. El text de les revisions eliminades només està accessible als administradors.",
'undelete-revision'        => "S'ha eliminat la revisió de $1 de $2:",
'undeleterevision-missing' => "La revisió no es vàlida o està incompleta. Pots tindre un mal enllaç, o bè pot haver-se restaurat o eliminat de l'archiu.",
'undeletebtn'              => 'Recupera!',
'undeletereset'            => 'Reinicia',
'undeletecomment'          => 'Comentari:',
'undeletedarticul'         => 'restaurat "$1"',
'undeletedrevisions'       => '$1 revisions restaurades',
'undeletedrevisions-files' => '$1 revisions i $2 archiu(s) restaurats',
'undeletedfiles'           => '$1 {{PLURAL:$1|archiu restaurat|archius restaurats}}',
'cannotundelete'           => "No s'ha pogut restaurar; algú atre pot estar restaurant la mateixa pàgina.",
'undeletedpage'            => "<big>'''S'ha restaurat «$1»'''</big>

Consulta el [[Special:Log/delete|registre de borrats]] per a vore els borrats i les restauracions més recents.",
'undelete-header'          => "Mira [[Special:Log/delete|el registre d'eliminació]] per a vore les pàgines eliminades recentment.",
'undelete-search-box'      => 'Busca pàgines borrades',
'undelete-search-prefix'   => 'Mostra pàgines que comencen:',
'undelete-search-submit'   => 'Busca',
'undelete-no-results'      => "No s'ha trobat cap pàgina que hi coincidix en l'archiu d'eliminació.",

# Namespace form on various pages
'namespace' => 'Espai de noms:',
'invert'    => 'Invertix la selecció',

# Contributions
'contributions' => "Contribucions de l'usuari",
'mycontris'     => 'Contribucions',
'contribsub2'   => 'Per $1 ($2)',
'nocontribs'    => "No s'ha trobat canvis que encaixen en estes criteris.",
'ucnote'        => "A baix hi ha els últims <b>$1</b> canvis d'este usuari en els últims<b>$2</b> dies.",
'uclinks'       => 'Mostra els últims $1 canvis; mostra els últims $2 dies.',
'uctop'         => ' (actual)',

'sp-contributions-newest'      => 'Les més noves',
'sp-contributions-oldest'      => 'Les més antigues',
'sp-contributions-newer'       => '$1 anteriors',
'sp-contributions-older'       => '$1 següents',
'sp-contributions-newbies-sub' => 'Per a novells',
'sp-contributions-blocklog'    => 'Registre de bloquejades',

'sp-newimages-showfrom' => 'Mostra images des de $1',

# What links here
'whatlinkshere' => 'Qué enllaça ací',
'notargettitle' => 'No hi ha pàgina en blanc',
'notargettext'  => 'No has especificat a quina pàgina dur a terme esta funció.',
'linklistsub'   => "(Llista d'enllaços)",
'linkshere'     => "Les següents pàgines enllacen en '''[[:$1]]''':",
'nolinkshere'   => "Ninguna pàgina enllaça en '''[[:$1]]'''.",
'isredirect'    => 'pàgina redirigida',
'istemplate'    => 'inclosa',

# Block/unblock
'blockip'                     => "Bloqueja l'usuari",
'blockiptext'                 => "Utilisa el següent formulari per bloquejar l'accés
d'escritura des d'una direcció IP específica o des d'un usuari determinat.
això només s'hauria de fer per previndre el vandalisme, i
d'acort en la [[{{MediaWiki:policy-url}}|política del proyecte]].
Plena el diàlec de baix en un motiu específic (per eixemple, citant
quines pàgines en concret estan sent vandalisades).",
'ipaddress'                   => 'Direcció IP',
'ipadressorusername'          => "Direcció IP o nom de l'usuari",
'ipbexpiry'                   => 'Venciment',
'ipbreason'                   => 'Motiu',
'ipbanononly'                 => 'Bloqueja només els usuaris anònims',
'ipbcreateaccount'            => 'Evita la creació de contes',
'ipbenableautoblock'          => 'Bloqueja automàticament totes les adreces IPs que utilise este usuari',
'ipbsubmit'                   => 'Bloqueja esta direcció',
'ipbother'                    => "Un atre temps d'expiració",
'ipboptions'                  => '2 hores:2 hours,1 dia:1 day,3 dies:3 days,1 semana:1 week,2 semanes:2 weeks,1 mes:1 month,3 mesos:3 months,6 mesos:6 months,1 any:1 year,infinit:infinite',
'ipbotheroption'              => 'un atre',
'badipaddress'                => "La direcció IP no té el format correcte.",
'blockipsuccesssub'           => "S'ha bloquejat en èxit",
'blockipsuccesstext'          => 'L\'usuari "[[Special:Contributions/$1|$1]]" ha segut bloquejat.
<br />Mira la [[Special:Ipblocklist|llista d\'IP blocades]] per revisar els bloquejos.',
'ipb-unblock-addr'            => 'Desbloquejar $1',
'ipb-unblock'                 => 'Desbloqueja un usuari o una direcció IP',
'ipb-blocklist-addr'          => 'Llista els bloquejos existents per $1',
'ipb-blocklist'               => 'Llista els bloquejos existents',
'unblockip'                   => "Desbloqueja l'usuari",
'unblockiptext'               => "Utilisa el següent formulari per restaurar
l'accés a l'escriptura a una direcció IP o un usuari prèviament bloquejat.",
'ipusubmit'                   => 'Desbloqueja esta direcció',
'unblocked'                   => "S'ha desbloquejat l'usuari [[User:$1|$1]]",
'ipblocklist'                 => "Llista dde direccións IP i noms d'usuaris bloquejats",
'ipblocklist-submit'          => 'Busca',
'blocklistline'               => '$1, $2 bloqueja $3 ($4)',
'infiniteblock'               => 'infinit',
'expiringblock'               => 'termina el $1',
'anononlyblock'               => 'només usuari anònim',
'noautoblockblock'            => "S'ha deshabilitat el bloqueig automàtic",
'createaccountblock'          => "s'ha bloquejat la creació del conte",
'blocklink'                   => 'bloqueja',
'unblocklink'                 => 'desbloqueja',
'contribslink'                => 'contribucions',
'autoblocker'                 => 'Has segut bloquejat perque compartiu direcció IP en "$1". Motiu: "$2"',
'blocklogpage'                => 'Registre de bloquejats',
'blocklogentry'               => 's\'ha bloquejat "[[$1]]" per a un periodo de $2 $3',
'blocklogtext'                => "Això es una relació de accions de bloqueig i desbloqueig. Les direccions IP bloquejades automàticament no apareixen. mira la [[Special:Ipblocklist|llista d'usuaris actualment bloquejats]].",
'unblocklogentry'             => 'desbloquejat $1',
'block-log-flags-anononly'    => 'només els usuaris anònims',
'block-log-flags-nocreate'    => "s'ha desactivat la creació de contes",
'range_block_disabled'        => 'La facultat dels administradors per crear bloquets de ranc està desactivada.',
'ipb_expiry_invalid'          => "Data d'acabament no vàlida.",
'ipb_already_blocked'         => '«$1»ya està bloquejat',
'ip_range_invalid'            => 'Ranc de IP no vàlit.',
'proxyblocker'                => 'bloqueig de proxy',
'ipb_cant_unblock'            => "Errada: No s'ha trobat el núm. ID de bloqueig $1. És possible que ya se'n haguera desbloquejat.",
'proxyblockreason'            => "La teua direcció IP ha segut bloquejada perque es un proxy obert. Per favor contacta el teu proveïdor d'internet o servici tècnic i informeu-los d'este seriós problema de seguritat.",
'proxyblocksuccess'           => 'Fet.',
'sorbsreason'                 => 'La teua direcció IP està llistada com a servidor intermediari obert a la llista negra de DNS que consulta este lloc uep.',
'sorbs_create_account_reason' => 'La teua direcció IP està llistada com a servidor intermediari obert a la llista negra de DNS que consulta este lloc uep. No pots crear-hi un conte',

# Developer tools
'lockdb'              => 'Bloqueja la base de dades',
'unlockdb'            => 'Desbloqueja la base de dades',
'lockdbtext'          => "Bloquejant la base de dades s'anularà la capacitat de tots els
usuaris d'editar pàgines, canviar les preferències, editar els llistats de seguiments, i
atres canvis que requerixen canvis en la base de dades.
Confirma que això es el que intentes fer, i sobretot no t'oblides
de desbloquejar la base de dades quan acabes el manteniment.",
'unlockdbtext'        => "Desbloquejant la base de dades se restaurarà l'habilitat de tots
els usuaris d'editar pàgines, canviar les preferències, editar els llistats de seguiment, i
atres accions que requerixen canvis en la base de dades.
Confirma que això es el que vols fer.",
'lockconfirm'         => 'Sí, realment vull bloquejar la base de dades.',
'unlockconfirm'       => 'Sí, realment vull desbloquejar la base dades.',
'lockbtn'             => 'Bloqueja la base de dades',
'unlockbtn'           => 'Desbloqueja la base de dades',
'locknoconfirm'       => 'No has respost al diàlec de confirmació.',
'lockdbsuccesssub'    => "S'ha bloquejat la base de dades",
'unlockdbsuccesssub'  => "S'ha eliminat el bloqueig de la base de dades",
'lockdbsuccesstext'   => "S'ha bloquejat la base de dades del proyecte {{SITENAME}}.
<br />Recordat de traure el bloqueig quan hages acabat el manteniment.",
'unlockdbsuccesstext' => "S'ha desbloquejat la base de dades del proyecte {{SITENAME}}.",
'lockfilenotwritable' => 'No se pot modificar el ficher de la base de dades de bloquejos. Per a bloquejar o desbloquejar la base de dades, tens donar permís de modificació al servidor uep.',
'databasenotlocked'   => 'La base de dades no està bloquejada.',

# Move page
'movepage'                => 'Renomena la pàgina',
'movepagetext'            => "Utilisant el següent formulari renomenaràs una pàgina,
movent tota la seua història al nou nom.
El títul anterior se convertirà en un redireccionament al nou títul.
Els enllaços a l'antic títul de la pàgina no se canviaran. Assegurat de verificar que no deixis redireccions

dobles o trencades.
Eres el responsable de fer que els enllaços seguixen apuntant on se suposa que ho facen.

Donat conte que la pàgina '''no''' serà traslladada si ya existix una pàgina en el títul nou, a no ser que siga una pàgina buida o un '''redireccionament''' sense història.
Això significa que pots renomenar de nou una pàgina al seu títul original si comets un error, i que no pots sobreescriure una pàgina existent.

<b>ADVERTÈNCIA!</b>
Això pot ser un canvi dràstic i inesperat per una pàgina popular;
assegurat d'entendre les conseqüències que comporta adés de seguir avant.",
'movepagetalktext'        => "La pàgina de discussió associada, si existix, serà traslladada automàticament '''a menys que:'''
*Ya existix una pàgina de discussió no buida que té el nom nou, o
*Hages desseleccionat la opció de baix.

En estes casos, hauràs de traslladar o fusionar la pàgina manualment si ho desigeu.",
'movearticul'             => 'Renomena la pàgina',
'movenologin'             => "No sou a dins d'una sessió",
'movenologintext'         => "Tens que ser un usuari registrat i estar [[Special:Userlogin|dintre d'una sessió]]
per renomenar una pàgina.",
'newtitle'                => 'A títul nou',
'move-watch'              => 'Vigila esta pàgina',
'movepagebtn'             => 'Renomena la pàgina',
'pagemovedsub'            => 'Renomenament en èxit',
'articulexists'           => 'Ya existix una pàgina en este nom, o el nom que heu
escollit no es vàlit.
Escolliu un atre nom, per favor.',
'talkexists'              => "S'ha renomenat la pàgina en èxit, pero la pàgina de discussió no s'ha pogut moure ya existix en el títul nou.

Incorporeu-les manualment, per favor.",
'movedto'                 => 'renomenat a',
'movetalk'                => 'Renomena també la pàgina de discussió si es aplicable.',
'talkpagemoved'           => 'També ha segut renomenada la pàgina de discussió corresponent.',
'talkpagenotmoved'        => 'La pàgina de discussió corresponent <strong>no</strong> ha segut renomenada.',
'1movedto2'               => "[[$1]] s'ha renomenat com [[$2]]",
'1movedto2_redir'         => "[[$1]] s'ha renomenat com [[$2]] en una redirecció",
'movelogpage'             => 'Registre de reanomenaments',
'movelogpagetext'         => 'Mira la llista de les últimes pàgines renomenades.',
'movereason'              => 'Motiu',
'revertmove'              => 'revertir',
'delete_and_move'         => 'Borra i trasllada',
'delete_and_move_text'    => '==Fa falta borrar==

L\'articul de destí, "[[$1]]",ya existix. Vols borrar-lo per fer lloc per al trasllat?',
'delete_and_move_confirm' => 'Sí, borra la pàgina',
'delete_and_move_reason'  => "S'ha eliminat per a permetre el renomenament",
'selfmove'                => "Els títuls d'orige i de destí coincidixen: no es possible de renomenar una pàgina a si mateixa.",
'immobile_namespace'      => "El títul d'orige o de destí es d'un tipo especial; no es possible renomenar pàgines a este espai de noms.",

# Export
'export'          => 'Exporta les pàgines',
'exporttext'      => "Pots exportar en XML el text i l'historial d'una pàgina en concret o d'un conjunt de pàgines; entonces el resultat pot importar-se en un atre uep basat en wiki en programa de MediaWiki mijançant la [[Special:Import|pàgina d'importació]].

Per a exportar pàgines, escriu els títuls que desiges a la caixa de text de baix, un títul per llínia, i selecciona si desiges o no la versió actual en totes les versions prèvies, en la pàgina d'historial, o tan sols la pàgina actual en la informació de la última modificació.

En el següent cas pots fer servir un enllaç, com ara [[{{ns:Special}}:Export/{{Mediawiki:mainpage}}]] per a la pàgina {{Mediawiki:mainpage}}.",
'exportcuronly'   => "Exporta únicament la versió actual en voltes de l'historial sancer",
'exportnohistory' => "----
'''Nota:''' s'ha deshabilitat l'exportació sancera d'historial de pàgines a través d'este formulari a causa de problemes de rendiment del servidor.",
'export-submit'   => 'Exporta',

# Namespace 8 related
'allmessages'               => 'Tots els mensages del sistema',
'allmessagesname'           => 'Etiqueta',
'allmessagesdefault'        => 'Text per defecte',
'allmessagescurrent'        => 'Text actual',
'allmessagestext'           => "Ací està una llista dels mensages del sistema que se troben a l'espai de noms de ''MediaWiki''.",
'allmessagesnotsupportedUI' => "La llengua de la teua navegació actual, <strong>$1</strong>, no se troba implementada en els Special:Allmessages d'este lloc.",
'allmessagesnotsupportedDB' => "No se pot processar '''{{ns:special}}:Allmessages''' perquè la variable '''\$wgUseDatabaseMessages''' hi es desactivada.",
'allmessagesfilter'         => 'Busca etiqueta de mensage:',
'allmessagesmodified'       => 'Mostra només mensages modificats',

# Thumbnails
'thumbnail-more'  => 'Amplia',
'missingimage'    => '<b>Manca la image</b><br /><i>$1</i>',
'filemissing'     => 'Ficher inexistent',
'thumbnail_error' => "S'ha produït un error en crear la miniatura: $1",

# Special:Import
'import'                     => 'Importa les pàgines',
'importinterwiki'            => 'Importa interwiki',
'import-interwiki-text'      => "Tria una uep basat en wiki i un títul de pàgina per a importar.
Es conservaran les dates de les versions i els noms dels editors.
Totes les accions d'importació interwiki se conserven al [[Special:Log/import|registre d'importacions]].",
'import-interwiki-history'   => "Copia totes les versions de l'historial d'esta pàgina",
'import-interwiki-submit'    => 'Importa',
'import-interwiki-namespace' => "Transferix les pàgines a l'espai de noms:",
'importtext'                 => "Per favor, exporta el ficher des del wiki d'orige utilisant la ferramenta Special:Export, baixa-lo al teu disc dur i carrega una còpia ací.",
'importstart'                => "S'està important pàgines...",
'import-revision-count'      => '$1 {{PLURAL:$1|revisió|revisions}}',
'importnopages'              => 'No hi ha cap pàgina per importar.',
'importfailed'               => 'La importació ha fallat: $1',
'importunknownsource'        => "No se reconeix el tipo de la font d'importació",
'importcantopen'             => "No ha segut possible d'obrir el ficher a importar",
'importbadinterwiki'         => "Enllaç d'interwiki incorrecte",
'importnotext'               => 'Buit o sense text',
'importsuccess'              => "S'ha importat en èxit!",
'importhistoryconflict'      => "Hi ha un conflicte de versions en l'historial (la pàgina podria haver segut importada adés)",
'importnosources'            => "No s'ha definit cap font d'orige interwiki i s'ha deshabilitat la càrrega directa d'una còpia de l'historial",
'importnofile'               => "No s'ha pujat cap ficher d'importació.",
'importuploaderror'          => "Ha fallat la càrrega del ficher d'importació; potser el seu pes ha excedit el llímit màxim.",

# Import log
'importlogpage'                    => "Registre d'importació",
'importlogpagetext'                => "Importacions administratives de pàgines en l'historial des d'atres wikis.",
'import-logentry-upload'           => "s'ha importat [[$1]] per càrrega de fichers",
'import-logentry-upload-detail'    => '$1 revisió/ons',
'import-logentry-interwiki'        => "s'ha importat $1 via interwiki",
'import-logentry-interwiki-detail' => '$1 revisió/ons de $2',

# Tooltip help for the actions
'tooltip-pt-userpage'             => "La teua pàgina d'usuari.",
'tooltip-pt-anonuserpage'         => "La pàgina d'usuari per la IP que utiliseu",
'tooltip-pt-mytalk'               => 'La teua pàgina de discussió.',
'tooltip-pt-anontalk'             => 'Discussió sobre les edicions per esta direcció IP.',
'tooltip-pt-preferences'          => 'Les teues preferències.',
'tooltip-pt-watchlist'            => 'La llista de pàgines de les que estàs vigilant els canvis.',
'tooltip-pt-mycontris'            => 'Llista de les teues contribucions.',
'tooltip-pt-login'                => 'Mos agradaria que te registrares, pero no es obligatori.',
'tooltip-pt-anonlogin'            => 'Mos agradaria que te registrares, pero no es obligatori.',
'tooltip-pt-logout'               => "Finalisa la sessió d'usuari",
'tooltip-ca-talk'                 => "Discussió sobre el contingut d'esta pàgina.",
'tooltip-ca-edit'                 => 'Pots editar esta pàgina. Per favor, previsualisa adés de guardar.',
'tooltip-ca-addsection'           => 'Afegir un comentari a esta discussió.',
'tooltip-ca-viewsource'           => 'Esta pàgina està protegida. Pots vore el seu codi font.',
'tooltip-ca-history'              => "Versions antigues d'esta pàgina.",
'tooltip-ca-protect'              => 'Protegix esta pàgina.',
'tooltip-ca-delete'               => 'Borra esta pàgina.',
'tooltip-ca-undelete'             => 'Restaura les edicions fetes a esta pàgina abans de que fos esborrada.',
'tooltip-ca-move'                 => 'Renomena esta pàgina.',
'tooltip-ca-watch'                => 'Afegir esta pàgina a la teua llista de seguiment.',
'tooltip-ca-unwatch'              => 'Llevar esta pàgina de la teua llista de seguiment.',
'tooltip-search'                  => 'Busca en el proyecte {{SITENAME}}',
'tooltip-p-logo'                  => 'Portada',
'tooltip-n-mainpage'              => 'Visita la pàgina principal.',
'tooltip-n-portal'                => 'Sobre el proyecte, qué pots fer, on pots trobar coses.',
'tooltip-n-currentevents'         => "Per trobar informació general sobre l'actualitat.",
'tooltip-n-recentchanges'         => 'La llista de canvis recents a la wiki.',
'tooltip-n-randompage'            => 'Anar a una pàgina aleatòria.',
'tooltip-n-help'                  => 'El lloc per adivinar.',
'tooltip-n-sitesupport'           => 'Fes-nos una donació.',
'tooltip-t-whatlinkshere'         => 'Llista de totes les pàgines Uiqui que enllacen ací.',
'tooltip-t-recentchangeslinked'   => 'Canvis recents a pàgines que enllacen en esta pàgina.',
'tooltip-feed-rss'                => "Canal RSS d'esta pàgina",
'tooltip-feed-atom'               => "Canal Atom d'esta pàgina",
'tooltip-t-contributions'         => "Mirar la llista de contribucions d'este usuari.",
'tooltip-t-emailuser'             => 'Envia un correu en este usuari.',
'tooltip-t-upload'                => "Càrrega d'images o atres fichers.",
'tooltip-t-specialpages'          => 'Llista de totes les pàgines especials.',
'tooltip-ca-nstab-main'           => 'Mirar el contingut de la pàgina.',
'tooltip-ca-nstab-user'           => "Mirar la pàgina de l'usuari.",
'tooltip-ca-nstab-media'          => " Mirar la pàgina de l'element multimédia",
'tooltip-ca-nstab-special'        => 'Esta pàgina es una pàgina especial, no pots editar-la.',
'tooltip-ca-nstab-project'        => ' Mirar la pàgina del proyecte',
'tooltip-ca-nstab-image'          => ' Mirar la pàgina de la image',
'tooltip-ca-nstab-mediawiki'      => ' Mirar el mensage de sistema.',
'tooltip-ca-nstab-template'       => ' Mirar la plantilla.',
'tooltip-ca-nstab-help'           => " Mirar la pàgina d'ajuda.",
'tooltip-ca-nstab-category'       => ' Mirar la pàgina de la categoria.',
'tooltip-minoredit'               => 'Marca-lo com una edició menor',
'tooltip-save'                    => 'Guarda els teus canvis',
'tooltip-preview'                 => 'Revisa els teus canvis, fes-ho adés de guardar!',
'tooltip-diff'                    => 'Mostra quins canvis has fet al text.',
'tooltip-compareselectedversions' => "Mirar les diferències entre les dos versions seleccionades d'esta pàgina.",
'tooltip-watch'                   => 'Afegix esta pàgina a la teua llista de seguiment',
'tooltip-recreate'                => 'Recrea la pàgina a pesar que haja segut suprimida',

# Stylesheets
'common.css'   => '/* Edita este ficher per personalisar totes les apariències per al lloc sancer */',
'monobook.css' => "/* Edita este ficher per personalisar monobook per a tot el lloc sancer */",

# Scripts
'common.js'   => "/* Se carregarà per a tots els usuaris, i per a qualsevol pàgina, el codi JavaScript que hi haja després d'esta llínia. */",
'monobook.js' => '/* Deprecated; use [[MediaWiki:common.js]] */',

# Metadata
'nodublincore'      => "S'han inhabilitat les mitadades RDF de Dublin Core del servidor.",
'nocreativecommons' => "S'han inhabilitat les mitadades RDF de Creative Commons del servidor.",
'notacceptable'     => 'El servidor wiki no pot oferir dades en un format que el client no pot llegir.',

# Attribution
'anonymous'        => 'Usuaris anònims del proyecte {{SITENAME}}',
'siteuser'         => 'Usuari $1 del proyecte {{SITENAME}}',
'lastmodifiedatby' => 'Va ser modificada la pàgina per última vegada el $2, $1 per $3.', # $1 date, $2 time, $3 user
'and'              => 'i',
'othercontribs'    => 'Basat en les contribucions de $1.',
'others'           => 'atres',
'siteusers'        => '{{SITENAME}} usuaris $1',
'creditspage'      => 'Títuls de la pàgina',
'nocredits'        => 'No hi ha títuls disponibles per esta pàgina.',

# Spam protection
'spamprotectiontitle'    => 'Filtre de protecció de fem',
'spamprotectiontext'     => 'La pàgina que volies guardar va ser bloquejada pel filtre de fem. Provablement per un enllaç a un lloc extern.',
'spamprotectionmatch'    => 'El següent text es el que va disparar el nostre filtre de fem: $1',
'subcategorycount'       => "Hi ha {{PLURAL:$1|una subcategoria|$1 subcategories}} dins d'esta categoria.",
'categoryarticulcount'   => 'Hi ha {{PLURAL:$1|un artícul|$1 artículs}} en esta categoria.',
'category-media-count'   => 'Esta categoria conté {{PLURAL:$1|un archiu|$1 archius}}.',
'listingcontinuesabbrev' => ' cont.',
'spambot_username'       => "Neteja MediaWiki d'spam",
'spam_reverting'         => 'Se revertix a la última versió que no conté enllaços a $1',
'spam_blanking'          => "Totes les revisions contenien enllaços $1, s'està deixant en blanc",

# Info page
'infosubtitle'   => 'Informació de la pàgina',
'numedits'       => "Número d'edicions (artícul): $1",
'numtalkedits'   => "Número d'edicions (pàgina de discussió): $1",
'numwatchers'    => "Número d'usuaris que l'estan vigilant: $1",
'numauthors'     => "Número d'autors (artícul): $1",
'numtalkauthors' => "Número d'autors (pàgina de discussió): $1",

# Math options
'mw_math_png'    => 'Produïx sempre PNG',
'mw_math_simple' => 'HTML si es molt simple, si no PNG',
'mw_math_html'   => 'HTML si es possible, si no PNG',
'mw_math_source' => 'Deixa com a TeX (per a navegadors de text)',
'mw_math_modern' => 'Recomanat per navegadors moderns',
'mw_math_mathml' => 'MathML si es possible (experimental)',

# Patrolling
'markaspatrolleddiff'                 => 'Marca com a supervisat',
'markaspatrolledtext'                 => "Marca l'artícul com a supervisat",
'markedaspatrolled'                   => 'Marca com a supervisat',
'markedaspatrolledtext'               => "S'ha marcat la revisió seleccionada com supervisada.",
'rcpatroldisabled'                    => "S'ha deshabilitat la supervisió dels canvis recents",
'rcpatroldisabledtext'                => 'La funció de supervisió de canvis recents està actualment deshabilitada.',
'markedaspatrollederror'              => 'No se pot marcar com a supervisat',
'markedaspatrollederrortext'          => 'Fa falta que especifiques una versió per a marcar-la com a supervisada.',
'markedaspatrollederror-noautopatrol' => 'No pots marcar les teues pròpies modificacions com a supervisades.',

# Patrol log
'patrol-log-page' => 'Registre de supervisió',
'patrol-log-line' => "s'ha marcat la versió $1 de $2 com a supervisat $3",
'patrol-log-auto' => '(automàtic)',
'patrol-log-diff' => 'r$1',

# Image deletion
'deletedrevision' => "S'ha eliminat la revisió antiga $1.",

# Browsing diffs
'previousdiff' => '← Anar a la diferència prèvia',
'nextdiff'     => 'Anar a la pròxima diferència →',

# Media information
'mediawarning' => "'''Advertència''': Este archiu pot contindre codi maliciós, si l'eixecutes pots comprometre la seguritat del nostre sistema.<hr />",
'imagemaxsize' => "Llimita les images de les pàgines de descripció d'images a:",
'thumbsize'    => 'Mida de la miniatura:',

'newimages'    => 'Galeria de nous fichers',
'showhidebots' => '($1 bots)',
'noimages'     => 'Res per vore.',

'passwordtooshort' => 'La contrasenya es molt corta. Com ha mínim ha de tindre $1 caràcters.',

# Metadata
'metadata'          => 'Mitadades',
'metadata-help'     => "Este archiu conté informació adicional, provablement afegida per la càmara digital o l'escàner usat per a crear-lo o digitalisar-lo. Si l'archiu ha segut modificat posteriorment, alguns detalls poden no correspondre en l'informació real de l'archiu.",
'metadata-expand'   => 'Mostra els detalls estesos',
'metadata-collapse' => 'Amaga els detalls estesos',
'metadata-fields'   => 'Els camps de mitadades EXIF llistats en este mensage se mostraran en la pàgina de descripció de la image fins i tot quan la taula estiga plegada. La resta estaran ocults pero se podran desplegar.
* make
* model
* datetimeoriginal
* exposuretime
* fnumber
* focallength',

# EXIF tags
'exif-imagewidth'                  => 'Ample',
'exif-imagelength'                 => 'Alçada',
'exif-bitspersample'               => 'Octets per component',
'exif-compression'                 => 'Esquema de compressió',
'exif-photometricinterpretation'   => 'Composició dels píxels',
'exif-orientation'                 => 'Orientació',
'exif-samplesperpixel'             => 'Número de components',
'exif-planarconfiguration'         => 'Ordenament de dades',
'exif-ycbcrsubsampling'            => 'Proporció de mostreix secundari de Y en C',
'exif-ycbcrpositioning'            => 'Posició YCbCr',
'exif-xresolution'                 => 'Resolució horisontal',
'exif-yresolution'                 => 'Resolució vertical',
'exif-resolutionunit'              => 'Unitats de les resolucions X i Y',
'exif-stripoffsets'                => 'Ubicació de les dades de la image',
'exif-rowsperstrip'                => 'Número de fileres per franja',
'exif-stripbytecounts'             => 'Octets per franja comprimida',
'exif-jpeginterchangeformat'       => 'Acorament del JPEG SOI',
'exif-jpeginterchangeformatlength' => 'Octets de dades JPEG',
'exif-transferfunction'            => 'Funció de transferència',
'exif-whitepoint'                  => 'Cromositat del punt blanc',
'exif-primarychromaticities'       => 'Coordenada cromàtica del color primari',
'exif-ycbcrcoefficients'           => "Coeficients de la matriu de transformació de l'espai colorimètric",
'exif-referenceblackwhite'         => 'Valors de referència negre i blanc',
'exif-datetime'                    => "Data i hora de modificació de l'archiu",
'exif-imagedescription'            => 'Títul de la image',
'exif-make'                        => 'Fabricant de la càmara',
'exif-model'                       => 'Model de càmara',
'exif-software'                    => 'Programa utilisat',
'exif-artist'                      => 'Autor',
'exif-copyright'                   => "Titular dels drets d'autor",
'exif-exifversion'                 => 'Versió Exif',
'exif-flashpixversion'             => 'Versió Flashpix admesa',
'exif-colorspace'                  => 'Espai de color',
'exif-componentsconfiguration'     => 'Significat de cada component',
'exif-compressedbitsperpixel'      => "Modo de compressió d'image",
'exif-pixelydimension'             => 'Ample de la image',
'exif-pixelxdimension'             => 'Alçada de la image',
'exif-makernote'                   => 'Notes del fabricant',
'exif-usercomment'                 => "Comentaris de l'usuari",
'exif-relatedsoundfile'            => "Ficher d'àudio relacionat",
'exif-datetimeoriginal'            => 'Dia i hora de generació de les dades',
'exif-datetimedigitized'           => 'Dia i hora de digitalisació',
'exif-subsectime'                  => 'Data i hora, fraccions de segon',
'exif-subsectimeoriginal'          => 'Data i hora de creació, fraccions de segon',
'exif-subsectimedigitized'         => 'Data i hora de digitalisació, fraccions de segon',
'exif-exposuretime'                => "Temps d'exposició",
'exif-exposuretime-format'         => '$1 s ($2)',
'exif-fnumber'                     => 'Obertura del diafragma',
'exif-exposureprogram'             => "Programa d'exposició",
'exif-spectralsensitivity'         => 'Sensibilitat espectral',
'exif-isospeedratings'             => 'Sensibilitat ISO',
'exif-oecf'                        => 'Factor de conversió optoelectrònic',
'exif-shutterspeedvalue'           => "Temps d'exposició",
'exif-aperturevalue'               => 'Obertura',
'exif-brightnessvalue'             => 'Brillantot',
'exif-exposurebiasvalue'           => "Correcció d'exposició",
'exif-maxaperturevalue'            => "Camp d'obertura màxim",
'exif-subjectdistance'             => 'Distància del subjecte',
'exif-meteringmode'                => 'Modo de medida',
'exif-lightsource'                 => 'Font de llum',
'exif-flash'                       => 'Flash',
'exif-focallength'                 => 'Llongitut focal de la lent',
'exif-subjectarea'                 => 'Enquadre del subjecte',
'exif-flashenergy'                 => 'Energia del flash',
'exif-spatialfrequencyresponse'    => 'Resposta en freqüència espacial',
'exif-focalplanexresolution'       => 'Resolució X del pla focal',
'exif-focalplaneyresolution'       => 'Resolució Y del pla focal',
'exif-focalplaneresolutionunit'    => 'Unitat de resolució del pla focal',
'exif-subjectlocation'             => 'Posició del subjecte',
'exif-exposureindex'               => "Índex d'exposició",
'exif-sensingmethod'               => 'Método de detecció',
'exif-filesource'                  => 'Font del ficher',
'exif-scenetype'                   => "Tipo d'escena",
'exif-cfapattern'                  => 'Patró CFA',
'exif-customrendered'              => "Processament d'image personalisat",
'exif-exposuremode'                => "Modo d'exposició",
'exif-whitebalance'                => 'Balanç de blancs',
'exif-digitalzoomratio'            => "Escala d'ampliació digital (zoom)",
'exif-focallengthin35mmfilm'       => 'Distància focal per a película de 35 mm',
'exif-scenecapturetype'            => "Tipo de captura d'escena",
'exif-gaincontrol'                 => "Control d'escena",
'exif-contrast'                    => 'Contrast',
'exif-saturation'                  => 'Saturació',
'exif-sharpness'                   => 'Nitidea',
'exif-devicesettingdescription'    => 'Descripció dels paràmetros del dispositiu',
'exif-subjectdistancerange'        => 'Escala de distància del subjecte',
'exif-imageuniqueid'               => 'Identificadot únic de la image',
'exif-gpsversionid'                => 'Versió del tag GPS',
'exif-gpslatituderef'              => 'Latitut nort o sut',
'exif-gpslatitude'                 => 'Latitut',
'exif-gpslongituderef'             => 'Llongitut est o oest',
'exif-gpslongitude'                => 'Llongitut',
'exif-gpsaltituderef'              => "Referència d'altitut",
'exif-gpsaltitude'                 => 'Altitut',
'exif-gpstimestamp'                => 'Hora GPS (rellonge atòmic)',
'exif-gpssatellites'               => 'Satèlits usats per la mesura',
'exif-gpsstatus'                   => 'Estat del receptor',
'exif-gpsmeasuremode'              => 'Modo de mesura',
'exif-gpsdop'                      => 'Precisió de la mesura',
'exif-gpsspeedref'                 => 'Unitats de velocitat',
'exif-gpsspeed'                    => 'Velocitat del receptor GPS',
'exif-gpstrackref'                 => 'Referència per la direcció del moviment',
'exif-gpstrack'                    => 'Direcció del moviment',
'exif-gpsimgdirectionref'          => 'Referència per la direcció de la image',
'exif-gpsimgdirection'             => 'Direcció de la image',
'exif-gpsmapdatum'                 => 'Dates geodèsics usats',
'exif-gpsdestlatituderef'          => 'Referència per a la latitut del destí',
'exif-gpsdestlatitude'             => 'Latitut de la destinació',
'exif-gpsdestlongituderef'         => 'Referència per a la llongitut del destí',
'exif-gpsdestlongitude'            => 'Llongitut de la destinació',
'exif-gpsdestbearingref'           => "Referència per a l'orientació de destí",
'exif-gpsdestbearing'              => 'Orientació del destí',
'exif-gpsdestdistanceref'          => 'Referència de la distància a la destinació',
'exif-gpsdestdistance'             => 'Distància a la destinació',
'exif-gpsprocessingmethod'         => 'Nom del mètodo de processament GPS',
'exif-gpsareainformation'          => "Nom de l'àrea GPS",
'exif-gpsdatestamp'                => 'Data GPS',
'exif-gpsdifferential'             => 'Correcció diferencial GPS',

# EXIF attributes
'exif-compression-1' => 'Sense compressió',

'exif-unknowndate' => 'Data desconeguda',

'exif-orientation-1' => 'Normal', # 0th row: top; 0th column: left
'exif-orientation-2' => 'Invertit horisontalment', # 0th row: top; 0th column: right
'exif-orientation-3' => 'Girat 180°', # 0th row: bottom; 0th column: right
'exif-orientation-4' => 'Invertit verticalment', # 0th row: bottom; 0th column: left
'exif-orientation-5' => 'Rotat 90° en sentit antihorari i invertit verticalment', # 0th row: left; 0th column: top
'exif-orientation-6' => 'Rotat 90° en sentit horari', # 0th row: right; 0th column: top
'exif-orientation-7' => 'Rotat 90° en sentit horari i invertit verticalment', # 0th row: right; 0th column: bottom
'exif-orientation-8' => 'Rotat 90° en sentit antihorari', # 0th row: left; 0th column: bottom

'exif-planarconfiguration-1' => 'a blocs densos (chunky)',
'exif-planarconfiguration-2' => 'format pla',

'exif-xyresolution-i' => '$1 ppp',
'exif-xyresolution-c' => '$1 ppc',

'exif-componentsconfiguration-0' => 'no existix',

'exif-exposureprogram-0' => 'No definit',
'exif-exposureprogram-1' => 'Manual',
'exif-exposureprogram-2' => 'Programa normal',
'exif-exposureprogram-3' => "en prioritat d'obertura",
'exif-exposureprogram-4' => "en prioritat de velocitat d'obturació",
'exif-exposureprogram-5' => 'Programa creatiu (preferència a la profunditat de camp)',
'exif-exposureprogram-6' => "Programa acció (preferència a la velocitat d'obturació)",
'exif-exposureprogram-7' => 'Modo retrat (per primers plans en fons desenfocat)',
'exif-exposureprogram-8' => 'Modo paisage (per fotos de paisages en el fons enfocat)',

'exif-subjectdistance-value' => '$1 metros',

'exif-meteringmode-0'   => 'Desconegut',
'exif-meteringmode-1'   => 'Mijana',
'exif-meteringmode-2'   => 'Mesura central mijana',
'exif-meteringmode-3'   => 'Puntual',
'exif-meteringmode-4'   => 'Multipuntual',
'exif-meteringmode-5'   => 'Patró',
'exif-meteringmode-6'   => 'Parcial',
'exif-meteringmode-255' => 'Atres',

'exif-lightsource-0'   => 'Desconegut',
'exif-lightsource-1'   => 'Llum de dia',
'exif-lightsource-2'   => 'Fluorescent',
'exif-lightsource-3'   => 'Tungstè (llum incandescent)',
'exif-lightsource-4'   => 'Flaig',
'exif-lightsource-9'   => 'Clar',
'exif-lightsource-10'  => 'Nuvolat',
'exif-lightsource-11'  => 'Ombra',
'exif-lightsource-12'  => 'Fluorescent de llum del dia (D 5700 – 7100K)',
'exif-lightsource-13'  => 'Fluorescent de llum blanca (N 4600 – 5400K)',
'exif-lightsource-14'  => 'Fluorescent blanc fret (W 3900 – 4500K)',
'exif-lightsource-15'  => 'Fluorescent blanc (WW 3200 – 3700K)',
'exif-lightsource-17'  => 'Llum estàndart A',
'exif-lightsource-18'  => 'Llum estàndart B',
'exif-lightsource-19'  => 'Llum estàndart C',
'exif-lightsource-24'  => "Bombeta de tungsten d'estudi ISO",
'exif-lightsource-255' => 'Atre font de llum',

'exif-focalplaneresolutionunit-2' => 'polzades',

'exif-sensingmethod-1' => 'Indefinit',
'exif-sensingmethod-2' => "Sensor d'àrea de color a un chip",
'exif-sensingmethod-3' => "Sensor d'àrea de color a dos chips",
'exif-sensingmethod-4' => "Sensor d'àrea de color a tres chips",
'exif-sensingmethod-5' => "Sensor d'àrea de color per seqüències",
'exif-sensingmethod-7' => 'Sensor trilineal',
'exif-sensingmethod-8' => 'Sensor llinear de color per seqüències',

'exif-scenetype-1' => 'Una image fotografiada directament',

'exif-customrendered-0' => 'Procés normal',
'exif-customrendered-1' => 'Processament personalisat',

'exif-exposuremode-0' => 'Exposició automàtica',
'exif-exposuremode-1' => 'Exposició manual',
'exif-exposuremode-2' => 'Bracketting automàtic',

'exif-whitebalance-0' => 'Balanç automàtic de blancs',
'exif-whitebalance-1' => 'Balanç manual de blancs',

'exif-scenecapturetype-0' => 'Estàndart',
'exif-scenecapturetype-1' => 'Paisage',
'exif-scenecapturetype-2' => 'Retrat',
'exif-scenecapturetype-3' => 'Escena nocturna',

'exif-gaincontrol-0' => 'Cap',
'exif-gaincontrol-1' => 'Low gain up',
'exif-gaincontrol-2' => 'High gain up',
'exif-gaincontrol-3' => 'Low gain down',
'exif-gaincontrol-4' => 'High gain down',

'exif-contrast-0' => 'Normal',
'exif-contrast-1' => 'Suau',
'exif-contrast-2' => 'Fort',

'exif-saturation-0' => 'Normal',
'exif-saturation-1' => 'Baixa saturació',
'exif-saturation-2' => 'Alta saturació',

'exif-sharpness-0' => 'Normal',
'exif-sharpness-1' => 'Suau',
'exif-sharpness-2' => 'Fort',

'exif-subjectdistancerange-0' => 'Desconeguda',
'exif-subjectdistancerange-1' => 'Macro',
'exif-subjectdistancerange-2' => 'Subjecte a cerca',
'exif-subjectdistancerange-3' => 'Subjecte llunt',

# Pseudotags used for GPSLatitudeRef and GPSDestLatitudeRef
'exif-gpslatitude-n' => 'Latitut nort',
'exif-gpslatitude-s' => 'Latitut sur',

# Pseudotags used for GPSLongitudeRef and GPSDestLongitudeRef
'exif-gpslongitude-e' => 'Llongitut est',
'exif-gpslongitude-w' => 'Llongitut oest',

'exif-gpsstatus-a' => 'Mesura en curs',
'exif-gpsstatus-v' => 'Interoperabilitat de mesura',

'exif-gpsmeasuremode-2' => 'Mesura bidimensional',
'exif-gpsmeasuremode-3' => 'Mesura tridimensional',

# Pseudotags used for GPSSpeedRef and GPSDestDistanceRef
'exif-gpsspeed-k' => 'Quilòmetres per hora',
'exif-gpsspeed-m' => 'Milles per hora',
'exif-gpsspeed-n' => 'Nusos',

# Pseudotags used for GPSTrackRef, GPSImgDirectionRef and GPSDestBearingRef
'exif-gpsdirection-t' => 'Direcció real',
'exif-gpsdirection-m' => 'Direcció magnètica',

# External editor support
'edit-externally'      => 'Edita este ficher fent servir una aplicació externa',
'edit-externally-help' => ' Mirar les [http://meta.wikimedia.org/wiki/Help:External_editors instruccions de configuració] per a més informació.',

# 'all' in various places, this might be different for inflected languages
'recentchangesall' => 'tots',
'imagelistall'     => 'totes',
'watchlistall2'    => 'totes',
'namespacesall'    => 'tots',

# E-mail address confirmation
'confirmemail'            => "Confirma la direcció de correu electrònic",
'confirmemail_noemail'    => "No has introduït una direcció vàlida de correu electrònic en les teues [[Special:Preferences|preferències d'usuari]].",
'confirmemail_text'       => "El programa del sistema necessita que valides la teua direcció de correu electrònic per a poder disfrutar d'algunes facilitats. Fes clic el botó inferior
per enviar un codi de confirmació a la teua direcció. Seguiu l'enllaç que
hi haurà al mensage enviat per a confirmar que el teu correu es correcte.",
'confirmemail_pending'    => "<div class=\"error\">
Ya s'ha enviat el teu codi de confirmació per correu electrònic; si
fa poc hi has creat el teu conte, adés de mirar de demanar un nou
codi, primer hauries d'esperar alguns minuts per a rebre'l.
</div>",
'confirmemail_send'       => 'Envia per correu electrònic un codi de confirmació',
'confirmemail_sent'       => "S'ha enviat un mensage de confirmació.",
'confirmemail_oncreate'   => "S'ha enviat un codi de confirmació a la teua direcció de correu electrònic.
No se requerix este codi per a autenticar-s'hi, pero te caldrà proporcionar-lo
adés d'activar qualsevol funcionalitat del wiki basada en mensages
de correu electrònic.",
'confirmemail_sendfailed' => "No s'ha pogut enviar un mensage de confirmació. Comprova que la direcció no tinga caràcters no vàlits.

El programa de correu retornà el següent mensage: $1",
'confirmemail_invalid'    => 'El codi de confirmació no es vàlit. Este podria haver finalisat.',
'confirmemail_needlogin'  => 'Necessites $1 per a confirmar la teua direcció electrònica.',
'confirmemail_success'    => "S'ha confirmat la teua direcció electrònica. Ara pots iniciar una sessió i disfrutar del wiki.",
'confirmemail_loggedin'   => "Ya s'ha confirmat la teua direcció electrònica.",
'confirmemail_error'      => 'Com ha fallat en guardar la teua confirmació.',
'confirmemail_subject'    => "Confirmació de la direcció electrònica del proyecte {{SITENAME}}",
'confirmemail_body'       => "Algú, segurament tu, ha registrat el conte «$2» al proyecte {{SITENAME}}
en esta direcció electrònica des de la direcció IP $1.

Per a confirmar que esta direcció electrònica te pertany realment
i així activar les opcions de correu del programa, seguix este enllaç:

$3

Si '''no''' has segut tu, no el fases clic. Este codi de confirmació
caducarà a $4.",

# Scary transclusion
'scarytranscludedisabled' => "[S'ha deshabilitat la transclusió interwiki]",
'scarytranscludefailed'   => '[Ha fallat la recuperació de la plantilla per a $1; ho sentim]',
'scarytranscludetoolong'  => "[L'URL es massa llarga]",

# Trackbacks
'trackbackbox'      => '<div id="mw_trackbacks">
Referències d\'este artícul:<br />
$1
</div>',
'trackbackremove'   => ' ([$1 eliminada])',
'trackbacklink'     => 'Referència',
'trackbackdeleteok' => "La referència s'ha eliminat en èxit.",

# Delete conflict
'deletedwhileediting' => "Avís: S'ha suprimit esta pàgina adés que hages començat a editar-la!",
'confirmrecreate'     => "L'usuari [[User:$1|$1]] ([[User talk:$1|discussió]]) va borrar esta pàgina que havies creat donant-ne el següent motiu:
: ''$2''
Confirma que realment vols tornar-la a crear.",
'recreate'            => 'Recrea',

# HTML dump
'redirectingto' => "S'està redirigint a [[$1]]...",

# action=purge
'confirm_purge'        => "Vols buidar la memòria d'esta pàgina?

$1",
'confirm_purge_button' => "D'acort",

'youhavenewmessagesmulti' => 'Tens nous mensages a $1',

'searchcontaining' => "Busca artículs que continguen ''$1''.",
'searchnamed'      => "Busca els artículs que s'nomenen ''$1''.",
'articultitles'    => "Artículs que comencen en ''$1''",
'hideresults'      => 'Amaga els resultats',

'loginlanguagelabel' => 'Idioma: $1',

# Multipage image navigation
'imgmultipageprev'   => '&larr; pàgina prèvia',
'imgmultipagenext'   => 'pàgina següent &rarr;',
'imgmultigo'         => 'Anar',
'imgmultigotopre'    => 'Anar a la pàgina',
'imgmultiparseerror' => "Pareix que el ficher de la image es corromput o no es vàlit, i per això no s'ha pogut procedir una llista de pàgines en {{SITENAME}}.",

# Table pager
'ascending_abbrev'         => 'asc',
'descending_abbrev'        => 'desc',
'table_pager_next'         => 'Pàgina següent',
'table_pager_prev'         => 'Pàgina anterior',
'table_pager_first'        => 'Primera pàgina',
'table_pager_last'         => 'Última pàgina',
'table_pager_limit'        => 'Mostra $1 elements per pàgina',
'table_pager_limit_submit' => 'Anar',
'table_pager_empty'        => 'Sense resultats',

# Auto-summaries
'autosumm-blank'   => "S'està suprimint tot el contingut de la pàgina",
'autosumm-replace' => 'Contingut canviat per «$1».',
'autoredircomment' => "S'està redirigint a [[$1]]", # This should be changed to the new naming convention, but existed beforehand
'autosumm-new'     => 'Pàgina nova, en el contingut: «$1».',

# Size units
'size-bytes'     => '$1 B',
'size-kilobytes' => '$1 KB',
'size-megabytes' => '$1 MB',
'size-gigabytes' => '$1 GB',

# Live preview
'livepreview-loading' => 'Carregant-se…',
'livepreview-ready'   => 'Carregat!',
'livepreview-failed'  => 'Ha fallat la vista ràpida!
Tria en la previsualisació normal.',
'livepreview-error'   => 'La conexió no ha segut possible: $1 "$2"
Tria en la previsualisació normal.',

);