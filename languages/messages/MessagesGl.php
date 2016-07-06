<?php
/** Galician (Galego)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Alma
 * @author Elisardojm
 * @author Gallaecio
 * @author Gustronico
 * @author Kaganer
 * @author Lameiro
 * @author Prevert
 * @author Toliño
 * @author Xosé
 * @author לערי ריינהארט
 */

$fallback = 'pt';

$namespaceNames = array(
	NS_MEDIA            => 'Media',
	NS_SPECIAL          => 'Especial',
	NS_TALK             => 'Conversa',
	NS_USER             => 'Usuario',
	NS_USER_TALK        => 'Conversa_usuario',
	NS_PROJECT_TALK     => 'Conversa_$1',
	NS_FILE             => 'Ficheiro',
	NS_FILE_TALK        => 'Conversa_ficheiro',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'Conversa_MediaWiki',
	NS_TEMPLATE         => 'Modelo',
	NS_TEMPLATE_TALK    => 'Conversa_modelo',
	NS_HELP             => 'Axuda',
	NS_HELP_TALK        => 'Conversa_axuda',
	NS_CATEGORY         => 'Categoría',
	NS_CATEGORY_TALK    => 'Conversa_categoría',
);

$namespaceAliases = array(
	'Conversa_Usuario' => NS_USER_TALK,
	'Imaxe' => NS_FILE,
	'Conversa_Imaxe' => NS_FILE_TALK,
	'Conversa_Modelo' => NS_TEMPLATE_TALK,
	'Conversa_Axuda' => NS_HELP_TALK,
	'Conversa_Categoría' => NS_CATEGORY_TALK,
);

$namespaceGenderAliases = array(
	NS_USER => array( 'male' => 'Usuario', 'female' => 'Usuaria' ),
	NS_USER_TALK => array( 'male' => 'Conversa_usuario', 'female' => 'Conversa_usuaria' ),
);

$defaultDateFormat = 'dmy';

$dateFormats = array(
	'dmy time' => 'H:i',
	'dmy date' => 'j \d\e F \d\e Y',
	'dmy both' => 'H:i\,\ j \d\e F \d\e Y',
);

$specialPageAliases = array(
	'Activeusers'               => array( 'Usuarios_activos' ),
	'Allmessages'               => array( 'Todas_as_mensaxes' ),
	'Allpages'                  => array( 'Todas_as_páxinas' ),
	'Ancientpages'              => array( 'Páxinas_máis_antigas' ),
	'Badtitle'                  => array( 'Título_incorrecto' ),
	'Blankpage'                 => array( 'Baleirar_a_páxina' ),
	'Block'                     => array( 'Bloquear', 'Bloquear_o_enderezo_IP', 'Bloquear_o_usuario' ),
	'Blockme'                   => array( 'Bloquearme' ),
	'Booksources'               => array( 'Fontes_bibliográficas' ),
	'BrokenRedirects'           => array( 'Redireccións_rotas' ),
	'Categories'                => array( 'Categorías' ),
	'ChangeEmail'               => array( 'Cambiar_o_correo_electrónico' ),
	'ChangePassword'            => array( 'Cambiar_o_contrasinal' ),
	'ComparePages'              => array( 'Comparar_as_páxinas' ),
	'Confirmemail'              => array( 'Confirmar_o_correo_electrónico' ),
	'Contributions'             => array( 'Contribucións' ),
	'CreateAccount'             => array( 'Crear_unha_conta' ),
	'Deadendpages'              => array( 'Páxinas_mortas' ),
	'DeletedContributions'      => array( 'Contribucións_borradas' ),
	'Disambiguations'           => array( 'Homónimos' ),
	'DoubleRedirects'           => array( 'Redireccións_dobres' ),
	'EditWatchlist'             => array( 'Editar_a_lista_de_vixilancia' ),
	'Emailuser'                 => array( 'Correo_electrónico' ),
	'Export'                    => array( 'Exportar' ),
	'Fewestrevisions'           => array( 'Páxinas_con_menos_revisións' ),
	'FileDuplicateSearch'       => array( 'Procura_de_ficheiros_duplicados' ),
	'Filepath'                  => array( 'Ruta_do_ficheiro' ),
	'Import'                    => array( 'Importar' ),
	'Invalidateemail'           => array( 'Invalidar_o_enderezo_de_correo_electrónico' ),
	'BlockList'                 => array( 'Lista_de_bloqueos', 'Lista_dos_bloqueos_a_enderezos_IP' ),
	'LinkSearch'                => array( 'Buscar_ligazóns_web' ),
	'Listadmins'                => array( 'Lista_de_administradores' ),
	'Listbots'                  => array( 'Lista_de_bots' ),
	'Listfiles'                 => array( 'Lista_de_imaxes' ),
	'Listgrouprights'           => array( 'Lista_de_dereitos_segundo_o_grupo' ),
	'Listredirects'             => array( 'Lista_de_redireccións' ),
	'Listusers'                 => array( 'Lista_de_usuarios' ),
	'Lockdb'                    => array( 'Pechar_a_base_de_datos' ),
	'Log'                       => array( 'Rexistros' ),
	'Lonelypages'               => array( 'Páxinas_orfas' ),
	'Longpages'                 => array( 'Páxinas_longas' ),
	'MergeHistory'              => array( 'Fusionar_os_historiais' ),
	'MIMEsearch'                => array( 'Procura_MIME' ),
	'Mostcategories'            => array( 'Páxinas_con_máis_categorías' ),
	'Mostimages'                => array( 'Ficheiros_máis_ligados' ),
	'Mostlinked'                => array( 'Páxinas_máis_ligadas' ),
	'Mostlinkedcategories'      => array( 'Categorías_máis_ligadas' ),
	'Mostlinkedtemplates'       => array( 'Modelos_máis_ligados' ),
	'Mostrevisions'             => array( 'Páxinas_con_máis_revisións' ),
	'Movepage'                  => array( 'Mover_a_páxina' ),
	'Mycontributions'           => array( 'As_miñas_contribucións' ),
	'Mypage'                    => array( 'A_miña_páxina_de_usuario' ),
	'Mytalk'                    => array( 'A_miña_conversa' ),
	'Myuploads'                 => array( 'As_miñas_subidas' ),
	'Newimages'                 => array( 'Imaxes_novas' ),
	'Newpages'                  => array( 'Páxinas_novas' ),
	'PasswordReset'             => array( 'Restablecer_o_contrasinal' ),
	'PermanentLink'             => array( 'Ligazón_permanente' ),
	'Popularpages'              => array( 'Páxinas_populares' ),
	'Preferences'               => array( 'Preferencias' ),
	'Prefixindex'               => array( 'Índice_de_prefixos' ),
	'Protectedpages'            => array( 'Páxinas_protexidas' ),
	'Protectedtitles'           => array( 'Títulos_protexidos' ),
	'Randompage'                => array( 'Ao_chou', 'Páxina_aleatoria' ),
	'Randomredirect'            => array( 'Redirección_aleatoria' ),
	'Recentchanges'             => array( 'Cambios_recentes' ),
	'Recentchangeslinked'       => array( 'Cambios_relacionados' ),
	'Revisiondelete'            => array( 'Revisións_borradas' ),
	'RevisionMove'              => array( 'Traslado_de_revisión' ),
	'Search'                    => array( 'Procurar' ),
	'Shortpages'                => array( 'Páxinas_curtas' ),
	'Specialpages'              => array( 'Páxinas_especiais' ),
	'Statistics'                => array( 'Estatísticas' ),
	'Tags'                      => array( 'Etiquetas' ),
	'Unblock'                   => array( 'Desbloquear' ),
	'Uncategorizedcategories'   => array( 'Categorías_sen_categoría' ),
	'Uncategorizedimages'       => array( 'Imaxes_sen_categoría' ),
	'Uncategorizedpages'        => array( 'Páxinas_sen_categoría' ),
	'Uncategorizedtemplates'    => array( 'Modelos_sen_categoría' ),
	'Undelete'                  => array( 'Restaurar' ),
	'Unlockdb'                  => array( 'Abrir_a_base_de_datos' ),
	'Unusedcategories'          => array( 'Categorías_sen_uso' ),
	'Unusedimages'              => array( 'Imaxes_sen_uso' ),
	'Unusedtemplates'           => array( 'Modelos_non_usados' ),
	'Unwatchedpages'            => array( 'Páxinas_sen_vixiar' ),
	'Upload'                    => array( 'Cargar' ),
	'Userlogin'                 => array( 'Rexistro' ),
	'Userlogout'                => array( 'Saír_ao_anonimato' ),
	'Userrights'                => array( 'Dereitos_de_usuario' ),
	'Version'                   => array( 'Versión' ),
	'Wantedcategories'          => array( 'Categorías_requiridas' ),
	'Wantedfiles'               => array( 'Ficheiros_requiridos' ),
	'Wantedpages'               => array( 'Páxinas_requiridas', 'Ligazóns_rotas' ),
	'Wantedtemplates'           => array( 'Modelos_requiridos' ),
	'Watchlist'                 => array( 'Lista_de_vixilancia' ),
	'Whatlinkshere'             => array( 'Páxinas_que_ligan_con_esta' ),
	'Withoutinterwiki'          => array( 'Sen_interwiki' ),
);

$magicWords = array(
	'redirect'                => array( '0', '#REDIRECCIÓN', '#REDIRECIONAMENTO', '#REDIRECT' ),
	'notoc'                   => array( '0', '__SENÍNDICE__', '__SEMTDC__', '__SEMSUMÁRIO__', '__NOTOC__' ),
	'nogallery'               => array( '0', '__SENGALERÍA__', '__SEMGALERIA__', '__NOGALLERY__' ),
	'forcetoc'                => array( '0', '__FORZAROÍNDICE__', '__FORCARTDC__', '__FORCARSUMARIO__', '__FORÇARTDC__', '__FORÇARSUMÁRIO__', '__FORCETOC__' ),
	'toc'                     => array( '0', '__ÍNDICE__', '__TDC__', '__SUMÁRIO__', '__TOC__' ),
	'noeditsection'           => array( '0', '__SECCIÓNSNONEDITABLES__', '__NÃOEDITARSEÇÃO__', '__SEMEDITARSEÇÃO__', '__NOEDITSECTION__' ),
	'noheader'                => array( '0', '___SENCABECEIRA__', '__SEMCABECALHO__', '__SEMCABEÇALHO__', '__SEMTITULO__', '__SEMTÍTULO__', '__NOHEADER__' ),
	'currentmonth'            => array( '1', 'MESACTUAL', 'MESATUAL', 'MESATUAL2', 'CURRENTMONTH', 'CURRENTMONTH2' ),
	'currentmonth1'           => array( '1', 'MESACTUAL1', 'MESATUAL1', 'CURRENTMONTH1' ),
	'currentmonthname'        => array( '1', 'NOMEDOMESACTUAL', 'NOMEDOMESATUAL', 'CURRENTMONTHNAME' ),
	'currentmonthabbrev'      => array( '1', 'ABREVIATURADOMESACTUAL', 'MESATUALABREV', 'MESATUALABREVIADO', 'ABREVIATURADOMESATUAL', 'CURRENTMONTHABBREV' ),
	'currentday'              => array( '1', 'DÍAACTUAL', 'DIAATUAL', 'CURRENTDAY' ),
	'currentday2'             => array( '1', 'DÍAACTUAL2', 'DIAATUAL2', 'CURRENTDAY2' ),
	'currentdayname'          => array( '1', 'NOMEDODÍAACTUAL', 'NOMEDODIAATUAL', 'CURRENTDAYNAME' ),
	'currentyear'             => array( '1', 'ANOACTUAL', 'ANOATUAL', 'CURRENTYEAR' ),
	'currenthour'             => array( '1', 'HORAACTUAL', 'HORAATUAL', 'CURRENTHOUR' ),
	'localmonth'              => array( '1', 'MESLOCAL', 'LOCALMONTH', 'LOCALMONTH2' ),
	'localmonth1'             => array( '1', 'MESLOCAL1', 'LOCALMONTH1' ),
	'localmonthname'          => array( '1', 'NOMEDOMESLOCAL', 'LOCALMONTHNAME' ),
	'localmonthabbrev'        => array( '1', 'ABREVIATURADOMESLOCAL', 'MESLOCALABREV', 'MESLOCALABREVIADO', 'LOCALMONTHABBREV' ),
	'localday'                => array( '1', 'DÍALOCAL', 'DIALOCAL', 'LOCALDAY' ),
	'localday2'               => array( '1', 'DÍALOCAL2', 'DIALOCAL2', 'LOCALDAY2' ),
	'localdayname'            => array( '1', 'NOMEDODÍALOCAL', 'NOMEDODIALOCAL', 'LOCALDAYNAME' ),
	'localyear'               => array( '1', 'ANOLOCAL', 'LOCALYEAR' ),
	'localhour'               => array( '1', 'HORALOCAL', 'LOCALHOUR' ),
	'numberofpages'           => array( '1', 'NÚMERODEPÁXINAS', 'NUMERODEPAGINAS', 'NÚMERODEPÁGINAS', 'NUMBEROFPAGES' ),
	'numberofarticles'        => array( '1', 'NÚMERODEARTIGOS', 'NUMERODEARTIGOS', 'NUMBEROFARTICLES' ),
	'numberoffiles'           => array( '1', 'NÚMERODEFICHEIROS', 'NUMERODEARQUIVOS', 'NÚMERODEARQUIVOS', 'NUMBEROFFILES' ),
	'numberofusers'           => array( '1', 'NÚMERODEUSUARIOS', 'NUMERODEUSUARIOS', 'NÚMERODEUSUÁRIOS', 'NUMBEROFUSERS' ),
	'numberofedits'           => array( '1', 'NÚMERODEEDICIÓNS', 'NUMERODEEDICOES', 'NÚMERODEEDIÇÕES', 'NUMBEROFEDITS' ),
	'pagename'                => array( '1', 'NOMEDAPÁXINA', 'NOMEDAPAGINA', 'NOMEDAPÁGINA', 'PAGENAME' ),
	'namespace'               => array( '1', 'ESPAZODENOMES', 'DOMINIO', 'DOMÍNIO', 'ESPACONOMINAL', 'ESPAÇONOMINAL', 'NAMESPACE' ),
	'fullpagename'            => array( '1', 'NOMECOMPLETODAPÁXINA', 'NOMECOMPLETODAPAGINA', 'NOMECOMPLETODAPÁGINA', 'FULLPAGENAME' ),
	'subpagename'             => array( '1', 'NOMEDASUBPÁXINA', 'NOMEDASUBPAGINA', 'NOMEDASUBPÁGINA', 'SUBPAGENAME' ),
	'basepagename'            => array( '1', 'NOMEDAPÁXINABASE', 'NOMEDAPAGINABASE', 'NOMEDAPÁGINABASE', 'BASEPAGENAME' ),
	'talkpagename'            => array( '1', 'NOMEDAPÁXINADECONVERSA', 'NOMEDAPAGINADEDISCUSSAO', 'NOMEDAPÁGINADEDISCUSSÃO', 'TALKPAGENAME' ),
	'img_manualthumb'         => array( '1', 'miniatura=$1', 'miniaturadaimagem=$1', 'thumbnail=$1', 'thumb=$1' ),
	'img_right'               => array( '1', 'dereita', 'direita', 'right' ),
	'img_left'                => array( '1', 'esquerda', 'left' ),
	'img_none'                => array( '1', 'ningún', 'nenhum', 'none' ),
	'img_center'              => array( '1', 'centro', 'center', 'centre' ),
	'img_page'                => array( '1', 'páxina=$1', 'páxina $1', 'página=$1', 'página $1', 'page=$1', 'page $1' ),
	'img_border'              => array( '1', 'bordo', 'borda', 'border' ),
	'grammar'                 => array( '0', 'GRAMÁTICA:', 'GRAMMAR:' ),
	'displaytitle'            => array( '1', 'AMOSAROTÍTULO', 'EXIBETITULO', 'EXIBETÍTULO', 'DISPLAYTITLE' ),
	'newsectionlink'          => array( '1', '__LIGAZÓNDANOVASECCIÓN__', '__LINKDENOVASECAO__', '__LINKDENOVASEÇÃO__', '__LIGACAODENOVASECAO__', '__LIGAÇÃODENOVASEÇÃO__', '__NEWSECTIONLINK__' ),
	'language'                => array( '0', '#LINGUA:', '#IDIOMA:', '#LANGUAGE:' ),
	'numberofadmins'          => array( '1', 'NÚMERODEADMINISTRADORES', 'NUMERODEADMINISTRADORES', 'NUMBEROFADMINS' ),
	'special'                 => array( '0', 'especial', 'special' ),
	'tag'                     => array( '0', 'etiqueta', 'tag' ),
	'hiddencat'               => array( '1', '__CATEGORÍAOCULTA__', '__CATEGORIAOCULTA__', '__CATOCULTA__', '__HIDDENCAT__' ),
	'pagesincategory'         => array( '1', 'PÁXINASNACATEGORÍA', 'PAGINASNACATEGORIA', 'PÁGINASNACATEGORIA', 'PAGINASNACAT', 'PÁGINASNACAT', 'PAGESINCATEGORY', 'PAGESINCAT' ),
	'pagesize'                => array( '1', 'TAMAÑODAPÁXINA', 'TAMANHODAPAGINA', 'TAMANHODAPÁGINA', 'PAGESIZE' ),
);

$separatorTransformTable = array( ',' => '.', '.' => ',' );

