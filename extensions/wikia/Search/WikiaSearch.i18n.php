<?php
/**
 * Wikia Search Internationalization Messages
 */
$messages = array();


  /********************************/
 /*   Begin V2 Messages          */
/********************************/

$messages['en'] = array(
	'wikiasearch2-page-title-with-query' => "Search results for '$1' - $2",
	'wikiasearch2-page-title-no-query-interwiki' => 'Search Fandom',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Search $1',
	'wikiasearch2-search-all-wikia' => 'Search all of Fandom',
	'wikiasearch2-results' => '$1 {{PLURAL:$1|result|results}}',
	'wikiasearch2-pages' => '$1 {{PLURAL:$2|page|pages}}',
	'wikiasearch2-images' => '$1 {{PLURAL:$2|image|images}}',
	'wikiasearch2-videos' => '$1 {{PLURAL:$2|video|videos}}',
	'wikiasearch2-pages-k' => '$1k {{PLURAL:$2|page|pages}}',
	'wikiasearch2-images-k' => '$1k {{PLURAL:$2|image|images}}',
	'wikiasearch2-videos-k' => '$1k {{PLURAL:$2|video|videos}}',
	'wikiasearch2-pages-M' => '$1M {{PLURAL:$2|page|pages}}',
	'wikiasearch2-images-M' => '$1M {{PLURAL:$2|image|images}}',
	'wikiasearch2-videos-M' => '$1M {{PLURAL:$2|video|videos}}',
	'wikiasearch2-search-on-wiki' => 'Search within this wiki',
	'wikiasearch2-results-count' => 'About $1 {{PLURAL:$1|result|results}} for $2 from {{SITENAME}}',
	'wikiasearch2-results-for' => 'Results for $1 from {{SITENAME}}',
	'wikiasearch2-results-redirected-from' => 'redirected from',
	'wikiasearch2-global-search-headline' => 'Find communities on Fandom',
	'wikiasearch2-wiki-search-headline' => 'Search this wiki',
	'wikiasearch2-advanced-search' => 'Advanced Search Options',
	'wikiasearch2-advanced-select-all' => 'Select all',
	'wikiasearch2-onhub' => ' in the $1 Hub',
	'wikiasearch2-enable-go-search' => 'Enable Go-Search',
	'wikiasearch2-noresults' => 'No results found.',
	'wikiasearch2-spellcheck' => 'No results were found for <em>$1</em>. <strong>Showing results for <em>$2</em>.</strong>',
	'wikiasearch2-search-all-namespaces' => 'Search all namespaces by default',
	'wikiasearch2-search-ads-header' => 'Advertisements',
	'wikiasearch2-tabs-articles' => 'Articles',
	'wikiasearch2-tabs-photos-and-videos' => 'Photos and Videos',
	'wikiasearch2-users' => 'People',
	'wikiasearch2-users-tooltip' => 'Search in Users',
	'wikiasearch2-filter-options-label' => 'Filtering Options',
	'wikiasearch2-sort-options-label' => 'Sorting Options',
	'wikiasearch2-filter-all' => 'All Files',
	'wikiasearch2-filter-category' => 'Category',
	'wikiasearch2-filter-hd' => 'HD Only',
	'wikiasearch2-filter-photos' => 'Photos Only',
	'wikiasearch2-filter-videos' => 'Videos Only',
	'wikiasearch2-sort-relevancy' => 'Relevancy',
	'wikiasearch2-sort-publish-date' => 'Publish Date',
	'wikiasearch2-sort-duration' => 'Duration',
	'wikiasearch2-choose-category' => 'Choose Category',
	'wikiasearch2-crosswiki-description' => '$1 is a community site that anyone can contribute to. Discover, share and add your knowledge!',
	'wikiasearch2-exact-result' => 'Result for $1 from Wikia',


	'wikiasearch2-top-module-title' => 'What\'s hot now',
	'wikiasearch2-top-module-test-1' => 'Top pages',
	'wikiasearch2-top-module-test-2' => 'Popular articles',
	'wikiasearch2-top-module-test-3' => 'What\'s hot now',
	'wikiasearch2-top-module-edit' => 'Last edited on $1',

	'wikiamobile-wikiasearch2-next' => 'Next',
	'wikiamobile-wikiasearch2-prev' => 'Previous',
	'wikiamobile-wikiasearch2-count-of-results' => '$1-$2 of $3 {{PLURAL:$3|result|results}}',
	'wikiasearch2-video-results' => 'Videos for \'$1\''
);

/** Message documentation (Message documentation)
 * @author Michał Roszka (Mix) <michal@wikia-inc.com>
 * @author MtaÄ
 * @author Siebrand
 */
$messages['qqq'] = array(
	'wikiasearch2-page-title-with-query' => 'The message is used as the title of the page (appears in the title bar of a browser window). Parameters: $1 - a keyword or a search term searched for; $2 - the name of the wiki.',
	'wikiasearch2-page-title-no-query-intrawiki' => 'The message says "search this wiki" as opposed to "search all Wikia network". Parameters:
* $1 is the name of the wiki to be searched; {{SITENAME}} - see: http://www.mediawiki.org/wiki/Manual:$wgSitename.',
	'wikiasearch2-results-count' => 'Parameters: $1 - a number of items in the search results list; $2 - a keyword or a search term searched for; {{SITENAME}} - see: http://www.mediawiki.org/wiki/Manual:$wgSitename.',
	'wikiasearch2-results-for' => 'Parameter: $1 - a keyword or a search term searched for.',
	'wikiasearch2-results-redirected-from' => 'Caption for search results that are from redirects',
	'wikiasearch2-enable-go-search' => 'Preferences setting next to a checkbox which asks you whether you want to enable Go-Search (going directly to a page title match in search) or not. Default = off',
	'wikiasearch2-search-ads-header' => 'Heading displayed above search advertisements.',
	'wikiamobile-wikiasearch2-next' => 'Message is used to go to next result page',
	'wikiamobile-wikiasearch2-prev' => 'Message is used to go to previous result page',
	'wikiamobile-wikiasearch2-count-of-results' => 'Message uses to show start number of first and last result shown on current page and numbet of total results',
	'wikiasearch2-tabs-articles' => 'Name of a tab with articles. This tab is displayed in the right column on search page',
	'wikiasearch2-tabs-photos-and-videos' => 'Name of a tab with photos and videos. This tab is displayed in the right column on search page',
	'wikiasearch2-users' => 'Name of a tab with users. This tab is displayed in the right column on search page',
	'wikiasearch2-users-tooltip' => 'Search in UsersTooltip displayed on hover on Blogs Tab in the right column on
	search page',
	'wikiasearch2-pages' => 'Parameters: $1 - number of Pages below 1000',
	'wikiasearch2-images' => 'Parameters: $1 - number of Images below 1000',
	'wikiasearch2-videos' => 'Parameters: $1 - number of Videos below 1000',
	'wikiasearch2-pages-k' => 'Parameters: $1 - number of Pages below 1000000',
	'wikiasearch2-images-k' => 'Parameters: $1 - number of Images below 1000000',
	'wikiasearch2-videos-k' => 'Parameters: $1 - number of Videos below 1000000',
	'wikiasearch2-pages-M' => 'Parameters: $1 - number of Pages above 1000000',
	'wikiasearch2-images-M' => 'Parameters: $1 - number of Images above 1000000',
	'wikiasearch2-videos-M' => 'Parameters: $1 - number of Videos above 1000000',
	'wikiasearch2-crosswiki-description' => 'Used to display a generic description of a wiki for cross-wiki search results',
	'wikiasearch2-top-module-title' => 'Top module header title on search page',
	'wikiasearch2-top-module-edit' => 'Article last edit string containing date',
	'wikiasearch2-video-results' => 'List on-wiki and premium videos in a search'
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'wikiasearch-titles-only' => 'Soek slegs in bladsyname',
	'wikiasearch-system-error-msg' => "Weens 'n stelselfout, kan u soektog nie voltooi word nie",
	'wikiasearch-search-this-wiki' => 'Soek slegs deur Wikia Central',
	'wikiasearch-search-wikia' => 'Deursoek Wikia',
);

/** Arabic (العربية)
 * @author Malhargan
 */
$messages['ar'] = array(
	'wikiasearch-titles-only' => 'البحث فقط في عناوين الصفحات',
	'wikiasearch-system-error-msg' => 'بسبب خطأ في النظام ، لا يمكن إكمال البحث',
	'wikiasearch-search-wikia' => 'بحث ويكي',
);

/** Azerbaijani (azərbaycanca)
 * @author Sortilegus
 */
$messages['az'] = array(
	'wikiasearch-titles-only' => 'Yalnız səhifə başlıqlarında axtar',
	'wikiasearch-system-error-msg' => 'Sistem xətasına görə axtarış etmək mümkün deyil',
	'wikiasearch-search-this-wiki' => 'Yalnız Wikia Central üzrə axtarış',
	'wikiasearch-search-wikia' => 'Wikiada axtar',
	'wikiasearch-image-results' => '"$1" üçün şəkil axtarışının nəticələri',
);

/** Bashkir (Башҡортса)
 * @author Roustammr
 */
$messages['ba'] = array(
	'wikiasearch-titles-only' => 'Биттәрҙең баш исемдәренән генә эҙләргә',
	'wikiasearch-search-this-wiki' => 'Wikia Central да ғына эҙләү',
	'wikiasearch-search-wikia' => 'Wikia ла эҙләргә',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'wikiasearch-titles-only' => 'Шукаць толькі ў назвах старонак',
	'wikiasearch-system-error-msg' => 'У выніку сыстэмнай памылкі Ваш пошук ня можа быць выкананы',
	'wikiasearch-search-this-wiki' => 'Пошук выключна ў Wikia Central',
	'wikiasearch-search-wikia' => 'Знайсьці ў Wikia',
	'wikiasearch-image-results' => 'Вынікі пошуку выяваў для «$1»',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'wikiasearch-titles-only' => 'Klask e titl ar pajennoù hepken',
	'wikiasearch-system-error-msg' => "N'eus ket bet gellet ober ar c'hlask dre ma 'z eus bet ur fazi sistem",
	'wikiasearch-search-this-wiki' => 'Klask er Wikia Kreiz hepken',
	'wikiasearch-search-wikia' => 'Klask e Wikia',
	'wikiasearch-image-results' => 'Disoc\'hoù skeudenn evit "$1"',
);

/** Czech (česky)
 * @author Dontlietome7
 * @author Reaperman
 */
$messages['cs'] = array(
	'search-desc' => 'Vyhledávací engine Wikia používající Solr',
	'wikiasearch-titles-only' => 'Hledat pouze v názvech stránek',
	'wikiasearch-system-error-msg' => 'Kvůli systémové chybě nelze dokončit vyhledávání',
	'wikiasearch-search-this-wiki' => 'Prohledávat pouze Wikia Central',
	'wikiasearch-search-wikia' => 'Prohledat Wkii',
	'wikiasearch-image-results' => 'Výsledky obrázků pro "$1"',
	'wikiasearch-search-all-wikia' => 'Hledat v celé Wikii',
);

/** German (Deutsch)
 * @author LWChris
 * @author MtaÄ
 * @author PtM
 * @author SVG
 */
$messages['de'] = array(
	'search-desc' => 'Wikia-weite Suchengine, verwendet das Solr Backend',
	'wikiasearch-titles-only' => 'Suche nur in Seitentiteln',
	'wikiasearch-system-error-msg' => 'Aufgrund eines Systemfehlers konnte deine Suche nicht abgeschlossen werden',
	'wikiasearch-search-this-wiki' => 'Nur Wikia Zentrale durchsuchen',
	'wikiasearch-search-wikia' => 'Wikia durchsuchen',
	'wikiasearch-image-results' => 'Bild-Ergebnisse für „$1“',
	'wikiasearch-search-all-wikia' => 'Suche alle von Wikia',
	'wikiasearch2-page-title-with-query' => 'Suchergebnisse für "$1" - $2',
	'wikiasearch2-page-title-no-query-interwiki' => 'Durchsuche Wikia',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Suche nach $1',
	'wikiasearch2-search-all-wikia' => 'Durchsuche alle Wikia-Wikis',
	'wikiasearch2-results' => '$1 {{PLURAL:$1|Ergebnis|Ergebnisse}}',
	'wikiasearch2-pages' => '$1 {{PLURAL:$1|Seite|Seiten}}',
	'wikiasearch2-images' => '$1 {{PLURAL:$2|Bild|Bilder}}',
	'wikiasearch2-videos' => '$1 {{PLURAL:$2|Video|Videos}}',
	'wikiasearch2-pages-k' => '$1k {{PLURAL:$2|Seite|Seiten}}',
	'wikiasearch2-images-k' => '$1k {{PLURAL:$2|Bild|Bilder}}',
	'wikiasearch2-videos-k' => '$1k {{PLURAL:$2|Video|Videos}}',
	'wikiasearch2-pages-M' => '$1M {{PLURAL:$2|Seite|Seiten}}',
	'wikiasearch2-images-M' => '$1M {{PLURAL:$2|Bild|Bilder}}',
	'wikiasearch2-videos-M' => '$1M {{PLURAL:$2|Video|Videos}}',
	'wikiasearch2-search-on-wiki' => 'Durchsuche dieses Wiki',
	'wikiasearch2-results-count' => 'Über $1 {{PLURAL:$1|Ergebnis|Ergebnisse}} für $2',
	'wikiasearch2-results-for' => 'Ergebnisse für $1',
	'wikiasearch2-results-redirected-from' => 'weitergeleitet von',
	'wikiasearch2-global-search-headline' => 'Entdecke weitere Wikia-Communitys',
	'wikiasearch2-wiki-search-headline' => 'Suchergebnisse',
	'wikiasearch2-advanced-search' => 'Erweiterte Such-Optionen',
	'wikiasearch2-onhub' => 'in der Kategorie $1',
	'wikiasearch2-enable-go-search' => 'Gehe bei einer direkten Übereinstimmung einer Suchanfrage mit einem Seitentitel direkt zur Seite und nicht zuerst zu den Suchergebnissen',
	'wikiasearch2-noresults' => 'Nichts gefunden.',
	'wikiasearch2-spellcheck' => 'Es wurde für <em>$1</em> nichts gefunden. <strong>Treffer für <em>$2</em>.</strong>',
	'wikiasearch2-tabs-articles' => 'Artikel',
	'wikiasearch2-tabs-photos-and-videos' => 'Fotos und Videos',
	'wikiasearch2-users' => 'Personen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author LWChris
 */
$messages['de-formal'] = array(
	'wikiasearch-system-error-msg' => 'Aufgrund eines Systemfehlers konnte Ihre Suche nicht abgeschlossen werden',
);

/** Greek (Ελληνικά)
 * @author Dada
 * @author Evropi
 */
$messages['el'] = array(
	'wikiasearch-titles-only' => 'Αναζήτηση μόνο στους τίτλους των σελίδων',
	'wikiasearch-system-error-msg' => 'Εξαιτίας ενός σφάλματος του συστήματος, η αναζήτησή σας δεν ολοκληρώθηκε',
	'wikiasearch-search-this-wiki' => 'Αναζήτηση μόνο στο Wikia Central',
	'wikiasearch-search-wikia' => 'Αναζήτηση στο Wikia',
	'wikiasearch-image-results' => 'Αποτελέσματα Εικόνων για "$1"',
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Ciencia Al Poder
 * @author Invadinado
 * @author VegaDark
 */
$messages['es'] = array(
	'search-desc' => 'Motor de búsqueda a través de Wikia usando Solr',
	'wikiasearch-titles-only' => 'Buscar sólo en títulos de páginas',
	'wikiasearch-system-error-msg' => 'Debido a un error del sistema, su búsqueda no se pudo completar',
	'wikiasearch-search-this-wiki' => 'Buscar sólo en Wikia Central',
	'wikiasearch-search-wikia' => 'Buscar en Wikia',
	'wikiasearch-image-results' => 'Resultados para la imagen "$1"',
	'wikiasearch-search-all-wikia' => 'Buscar en todo Wikia',
	'wikiasearch2-page-title-with-query' => "Resultados de la búsqueda de '$1' - $2",
	'wikiasearch2-page-title-no-query-interwiki' => 'Buscar en Wikia',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Buscar $1',
	'wikiasearch2-search-all-wikia' => 'Buscar en todo Wikia',
	'wikiasearch2-results' => '$1 {{PLURAL:$1|resultado|resultados}}',
	'wikiasearch2-pages' => '$1 {{PLURAL:$1|página|páginas}}',
	'wikiasearch2-images' => '$1 {{PLURAL:$2|imagen|imágenes}}',
	'wikiasearch2-videos' => '$1 {{PLURAL:$2|vídeo|vídeos}}',
	'wikiasearch2-pages-k' => '$1k {{PLURAL:$2|página|páginas}}',
	'wikiasearch2-images-k' => '$1k {{PLURAL:$2|imagen|imágenes}}',
	'wikiasearch2-videos-k' => '$1k {{PLURAL:$2|vídeo|vídeos}}',
	'wikiasearch2-pages-M' => '$1M {{PLURAL:$2|página|páginas}}',
	'wikiasearch2-images-M' => '$1M {{PLURAL:$2|imagen|imágenes}}',
	'wikiasearch2-videos-M' => '$1M {{PLURAL:$2|vídeo|vídeos}}',
	'wikiasearch2-search-on-wiki' => 'Buscar en este wiki',
	'wikiasearch2-results-count' => 'Aproximadamente $1 {{PLURAL:$1|resultado|resultados}} para $2',
	'wikiasearch2-results-for' => 'Resultados de $1',
	'wikiasearch2-global-search-headline' => 'Encuentra las comunidades de Wikia que estás buscando',
	'wikiasearch2-wiki-search-headline' => 'Buscar en este wiki',
	'wikiasearch2-advanced-search' => 'Opciones de búsqueda avanzada',
	'wikiasearch2-onhub' => 'en el concentrador $1',
	'wikiasearch2-enable-go-search' => 'Habilitar la búsqueda Go-Search',
	'wikiasearch2-noresults' => 'No se han encontrado resultados',
	'wikiasearch2-spellcheck' => 'No se han encontrado resultados para <em>$1</em>. <strong>Mostrando resultados para <em>$2</em>.</strong>',
	'wikiasearch2-tabs-articles' => 'Artículos',
	'wikiasearch2-tabs-photos-and-videos' => 'Fotos y Vídeos',
	'wikiasearch2-users' => 'Gente',
);

/** Estonian (eesti)
 * @author Hendrik
 */
$messages['et'] = array(
	'wikiasearch-titles-only' => 'Otsi ainult lehtede pealkirjadest',
);

/** Persian (فارسی) */
$messages['fa'] = array(
	'wikiasearch-titles-only' => 'جستجو فقط در عنوان صفحه‌ها',
	'wikiasearch-system-error-msg' => 'به علت مشکلی در سیستم جستجو پایان نیافت',
);

/** Finnish (suomi)
 * @author Crt
 * @author Nike
 * @author VezonThunder
 */
$messages['fi'] = array(
	'search-desc' => 'Wikian-laajuinen hakukone, joka käyttää Solr-taustaosaa',
	'wikiasearch-titles-only' => 'Etsi vain sivujen otsikoista',
	'wikiasearch-system-error-msg' => 'Hakua ei voitu suorittaa loppuun järjestelmävirheen takia',
	'wikiasearch-search-this-wiki' => 'Etsi vain Wikia Centralista',
	'wikiasearch-search-wikia' => 'Etsi Wikiasta',
	'wikiasearch-image-results' => 'Kuvatulokset haulla ”$1”',
	'wikiasearch-search-all-wikia' => 'Hae koko Wikiasta',
);

/** French (français)
 * @author DavidL
 * @author Gomoko
 * @author IAlex
 * @author WikiEoFrEn
 * @author Wyz
 */
$messages['fr'] = array(
	'search-desc' => 'Moteur de recherche à travers les Wikia utilisant Solr',
	'wikiasearch-titles-only' => 'Ne chercher que dans les titres des pages',
	'wikiasearch-system-error-msg' => "À cause d'une erreur du système, nous n'avons pas pu accomplir votre recherche",
	'wikiasearch-search-this-wiki' => 'Ne chercher que dans Wikia Central',
	'wikiasearch-search-wikia' => 'Chercher dans Wikia',
	'wikiasearch-image-results' => 'Résultats d’images pour « $1 »',
	'wikiasearch-search-all-wikia' => 'Rechercher sur tous les Wikia',
	'wikiasearch2-page-title-with-query' => 'Résultats de recherche pour « $1 » - $2',
	'wikiasearch2-page-title-no-query-interwiki' => 'Rechercher sur Wikia',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Rechercher $1',
	'wikiasearch2-search-all-wikia' => 'Rechercher sur tout Wikia',
	'wikiasearch2-results' => '$1 {{PLURAL:$1|résultat|résultats}}',
	'wikiasearch2-pages' => '$1 {{PLURAL:$1|page|pages}}',
	'wikiasearch2-images' => '$1 {{PLURAL:$2|image|images}}',
	'wikiasearch2-videos' => '$1 {{PLURAL:$2|vidéo|vidéos}}',
	'wikiasearch2-pages-k' => '$1k {{PLURAL:$2|page|pages}}',
	'wikiasearch2-images-k' => '$1k {{PLURAL:$2|image|images}}',
	'wikiasearch2-videos-k' => '$1k {{PLURAL:$2|vidéo|vidéos}}',
	'wikiasearch2-pages-M' => '$1M {{PLURAL:$2|page|pages}}',
	'wikiasearch2-images-M' => '$1M {{PLURAL:$2|image|images}}',
	'wikiasearch2-videos-M' => '$1M {{PLURAL:$2|vidéo|vidéos}}',
	'wikiasearch2-search-on-wiki' => 'Rechercher sur ce wiki',
	'wikiasearch2-results-count' => 'Environ $1 {{PLURAL:$1|résultat|résultats}} pour $2',
	'wikiasearch2-results-for' => 'Résultats pour $1',
	'wikiasearch2-results-redirected-from' => 'redirigé depuis',
	'wikiasearch2-global-search-headline' => 'Trouver des wikias sur Wikia',
	'wikiasearch2-wiki-search-headline' => 'Rechercher sur ce wiki',
	'wikiasearch2-advanced-search' => 'Options de recherche avancée',
	'wikiasearch2-onhub' => 'dans le thème « $1 »',
	'wikiasearch2-enable-go-search' => 'Activer « aller » pour la recherche',
	'wikiasearch2-noresults' => "Aucun résultat n'a été trouvé.",
	'wikiasearch2-spellcheck' => "Aucun résultat n'a été trouvé pour <em>$1</em>. <strong>Affichage des résultats pour <em>$2</em>.</strong>",
);

/** Scottish Gaelic (Gàidhlig)
 * @author Akerbeltz
 */
$messages['gd'] = array(
	'search-desc' => 'Einnsean-luirg thar nam uicipeidean le Solr backend',
	'wikiasearch-titles-only' => 'Lorg am broinn tiotalan nan duilleagan a-mhàin',
	'wikiasearch-system-error-msg' => "Cha b' urrainn dhuinn an lorg agad a thoirt gu buil air sgàth mearachd an t-siostaim",
	'wikiasearch-search-this-wiki' => 'Lorg air Wikia Central a-mhàin',
	'wikiasearch-search-wikia' => 'Lorg air Wikia',
	'wikiasearch-image-results' => 'Toraidhean deilbh airson "$1"',
	'wikiasearch-search-all-wikia' => "Lorg air feadh a' Wikia",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'search-desc' => 'Motor de procuras a través de Wikia que emprega tecnoloxía Solr',
	'wikiasearch-titles-only' => 'Procurar só nos títulos das páxinas',
	'wikiasearch-system-error-msg' => 'Debido a un erro do sistema, non se puido completar a súa procura',
	'wikiasearch-search-this-wiki' => 'Procurar só en Wikia Central',
	'wikiasearch-search-wikia' => 'Procurar en Wikia',
	'wikiasearch-image-results' => 'Resultados de imaxes para "$1"',
	'wikiasearch-search-all-wikia' => 'Procurar en toda Wikia',
	'wikiasearch2-page-title-with-query' => 'Resultados da procura de "$1" - $2',
	'wikiasearch2-page-title-no-query-interwiki' => 'Procurar en Wikia',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Procurar "$1"',
	'wikiasearch2-search-all-wikia' => 'Procurar en toda Wikia',
	'wikiasearch2-results' => '$1 {{PLURAL:$1|resultado|resultados}}',
	'wikiasearch2-pages' => '$1 {{PLURAL:$1|páxina|páxinas}}',
	'wikiasearch2-search-on-wiki' => 'Procurar neste wiki',
	'wikiasearch2-results-count' => 'Aproximadamente $1 {{PLURAL:$1|resultado|resultados}} para "$2"',
	'wikiasearch2-results-for' => 'Resultados para "$1"',
	'wikiasearch2-global-search-headline' => 'Atopar wikis en Wikia',
	'wikiasearch2-wiki-search-headline' => 'Procurar neste wiki',
	'wikiasearch2-advanced-search' => 'Opcións de procura avanzadas',
	'wikiasearch2-onhub' => ' no centro de actividade $1',
	'wikiasearch2-enable-go-search' => 'Activar o "Go-Search"',
	'wikiasearch2-noresults' => 'Non se atopou ningún resultado.',
	'wikiasearch2-spellcheck' => 'Non se atopou ningún resultado para <em>$1</em>. <strong>Móstranse os resultados para <em>$2</em>.</strong>',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'wikiasearch-titles-only' => 'Jenož w titulach stronow pytać',
	'wikiasearch-system-error-msg' => 'Systemoweho zmylka dla waše pytanje njeda so dokónčić',
	'wikiasearch-search-this-wiki' => 'Jenož centralnu Wikiju přepytać',
	'wikiasearch-search-wikia' => 'Wikiju přepytać',
	'wikiasearch-image-results' => 'Wobrazowe wuslědki za "$1"',
);

/** Hungarian (magyar)
 * @author Glanthor Reviol
 * @author Misibacsi
 * @author TK-999
 */
$messages['hu'] = array(
	'search-desc' => 'Solr alapú Wikia-közi keresőmotor',
	'wikiasearch-titles-only' => 'Keresés csak a lapcímekben',
	'wikiasearch-system-error-msg' => 'A keresés nem teljesíthető rendszerhiba miatt',
	'wikiasearch-search-this-wiki' => 'Keresés csak a Wikia Centralon',
	'wikiasearch-search-wikia' => 'Keresés a Wikián',
	'wikiasearch-image-results' => 'Képkeresés eredményei: "$1"',
	'wikiasearch-search-all-wikia' => 'Keresés a Wikia egészében',
);

/** Armenian (Հայերեն)
 * @author Pandukht
 */
$messages['hy'] = array(
	'wikiasearch-titles-only' => 'Որոնել միայն էջերի վերնագրերում',
	'wikiasearch-system-error-msg' => 'Որոնումը հնարավոր չե կատարել համակարգային սխալի պատճառով',
	'wikiasearch-search-this-wiki' => 'Որոնում միայն Wikia Central-ով',
	'wikiasearch-search-wikia' => 'Որոնել Wikia-ում',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'search-desc' => 'Motor de recerca trans-Wikia usante le back-end Solr',
	'wikiasearch-titles-only' => 'Cercar solmente in titulos de paginas',
	'wikiasearch-system-error-msg' => 'A causa de un error de systema, le recerca non poteva esser completate',
	'wikiasearch-search-this-wiki' => 'Cercar solmente in Wikia Central',
	'wikiasearch-search-wikia' => 'Cercar in Wikia',
	'wikiasearch-image-results' => 'Resultatos de imagines pro "$1"',
	'wikiasearch-search-all-wikia' => 'Cercar in tote Wikia',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 * @author Farras
 * @author Irwangatot
 */
$messages['id'] = array(
	'search-desc' => 'Mesin pencari Cross-Wikia dengan menggunakan Solr backend',
	'wikiasearch-titles-only' => 'Cari hanya dalam judul halaman',
	'wikiasearch-system-error-msg' => 'Karena kesalahan sistem, pencarian anda tidak dapat diselesaikan',
	'wikiasearch-search-this-wiki' => 'Cari hanya Wikia Central',
	'wikiasearch-search-wikia' => 'Pencarian Wikia',
	'wikiasearch-image-results' => 'Hasil Pencarian Gambar untuk "$1"',
	'wikiasearch-search-all-wikia' => 'Cari di semua Wikia',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'wikiasearch-titles-only' => 'Chọwa na ime ishi ihü nani',
	'wikiasearch-system-error-msg' => 'Màkà nsigbú na nsónùsòrò, ihe nchowá gi enwéghìkì mecha',
	'wikiasearch-search-this-wiki' => 'Chọwa na nánì Mpkurụ Wikia',
	'wikiasearch-search-wikia' => 'Chọwa na imé Wikia',
);

/** Italian (italiano)
 * @author Leviathan 89
 * @author Lexaeus 94
 * @author Pietrodn
 */
$messages['it'] = array(
	'search-desc' => 'Motore di ricerca di Wikia che utilizza il backend Solr',
	'wikiasearch-titles-only' => 'Cerca solo nei titoli delle pagine',
	'wikiasearch-system-error-msg' => 'A causa di un errore di sistema, la tua ricerca non è stata completata',
	'wikiasearch-search-this-wiki' => 'Cerca sono in Wikia Central',
	'wikiasearch-search-wikia' => 'Cerca in Wikia',
	'wikiasearch-image-results' => 'Risultati immagini per "$1"',
	'wikiasearch-search-all-wikia' => 'Cerca in tutta Wikia',
	'wikiasearch2-page-title-no-query-interwiki' => 'Cerca in Wikia',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Ricerca $1',
	'wikiasearch2-search-all-wikia' => 'Cerca in tutta Wikia',
	'wikiasearch2-pages' => '$1 {{PLURAL:$1|pagina|pagine}}',
	'wikiasearch2-search-on-wiki' => "Cerca all'interno di questa wiki",
	'wikiasearch2-results-count' => 'Mostra $1 {{PLURAL:$1|il risultato|i risultati}} per $2',
	'wikiasearch2-results-for' => 'Risultati per $1',
	'wikiasearch2-global-search-headline' => 'Trova delle wiki su Wikia',
	'wikiasearch2-wiki-search-headline' => 'Trova questa wiki',
	'wikiasearch2-advanced-search' => 'Opzioni di Ricerca Avanzata',
	'wikiasearch2-onhub' => 'Nel centro di $1',
);

/** Japanese (日本語)
 * @author Schu
 * @author Tommy6
 */
$messages['ja'] = array(
	'search-desc' => 'Solr バックエンドを使用したクロスウィキア検索エンジン',
	'wikiasearch-titles-only' => 'ページのタイトルだけを検索する',
	'wikiasearch-system-error-msg' => 'システムエラーにより検索を完了できませんでした。',
	'wikiasearch-search-this-wiki' => 'セントラルウィキアのみを検索する',
	'wikiasearch-search-wikia' => 'ウィキア全体を検索',
	'wikiasearch-image-results' => '"$1" の画像検索結果',
	'wikiasearch-search-all-wikia' => 'すべてのウィキアから検索',
);

/** Jamaican Creole English (Patois)
 * @author Yocahuna
 */
$messages['jam'] = array(
	'wikiasearch-titles-only' => 'Saach onggl ina piej taikl',
	'wikiasearch-system-error-msg' => 'Juu tu sistim era, yu saach kudn kompliit',
	'wikiasearch-search-this-wiki' => 'Saach Wikia Central onli',
	'wikiasearch-search-wikia' => 'Saach Wikia',
	'wikiasearch-image-results' => 'Imij Rizolt fi "$1"',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'wikiasearch-image-results' => 'Encamên wêneyê ji bo "$1"',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'wikiasearch-titles-only' => 'Nëmmen an de Säitentitele sichen',
	'wikiasearch-system-error-msg' => 'Duerch e Feeler am System konnt net fäerdeg gesicht ginn',
	'wikiasearch-search-this-wiki' => 'Nëmmen a Wikia Central sichen',
	'wikiasearch-search-wikia' => 'A Wikia sichen',
	'wikiasearch-image-results' => 'Resultater vun de Biller fir "$1"',
);

/** Ganda (Luganda)
 * @author Kizito
 */
$messages['lg'] = array(
	'wikiasearch-titles-only' => "Noonyeza mu mitwe gy'empapula gyokka",
	'wikiasearch-system-error-msg' => 'Okunoonya kwo kugaanye olwa kiremya mu sisitemu',
	'wikiasearch-search-wikia' => 'Noonyeza mu Wikia',
);

/** Basa Banyumasan (Basa Banyumasan)
 * @author StefanusRA
 */
$messages['map-bms'] = array(
	'wikiasearch-titles-only' => 'Goleti nang judul kaca thok',
	'wikiasearch-system-error-msg' => 'Jalaran kesalahan sistem, panggoletane panjenengan ora bisa dirampungna',
	'wikiasearch-search-this-wiki' => 'Goleti nang Wikia Central thok',
	'wikiasearch-image-results' => 'Hasil gambar nggo "$1"',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'search-desc' => 'Пребарувач низ сета Викија на основа на Solr',
	'wikiasearch-titles-only' => 'Пребарувај само наслови на страници',
	'wikiasearch-system-error-msg' => 'Се појави системска грешја и пребарувањето не можеше да се изврши',
	'wikiasearch-search-this-wiki' => 'Пербарувај само по Викија Централата',
	'wikiasearch-search-wikia' => 'Пребарајте ја Викија',
	'wikiasearch-image-results' => 'Резултати за слики за „$1“',
	'wikiasearch-search-all-wikia' => 'Пребарај ја целата Викија',
	'wikiasearch2-page-title-with-query' => 'Резултати од пребарувањето на „$1“ - $2',
	'wikiasearch2-page-title-no-query-interwiki' => 'Пребарување по Викија',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Пребарување на $1',
	'wikiasearch2-search-all-wikia' => 'Пребарај ја целата Викија',
	'wikiasearch2-results' => '$1 {{PLURAL:$1|резултат|резултати}}',
	'wikiasearch2-pages' => '$1 {{PLURAL:$1|страница|страници}}',
	'wikiasearch2-search-on-wiki' => 'Пребарај во ова вики',
	'wikiasearch2-results-count' => 'Има околу $1 {{PLURAL:$1|резултат|резултат}} за $2',
	'wikiasearch2-results-for' => 'Резултати за $1',
	'wikiasearch2-global-search-headline' => 'Пронајдете викија на Викија',
	'wikiasearch2-wiki-search-headline' => 'Пребарување по ова вики',
	'wikiasearch2-advanced-search' => 'Напредни можности за пребарување',
	'wikiasearch2-onhub' => 'во порталот $1',
	'wikiasearch2-enable-go-search' => 'Овозможи пребарување со „Оди“',
	'wikiasearch2-noresults' => 'Нема пронајдено резултати.',
	'wikiasearch2-spellcheck' => 'Не пронајдов ништо за <em>$1</em>. <strong>Ги прикажувам резултатите за <em>$2</em>.</strong>',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'search-desc' => 'Enjin carian rentas Wikia yang menggunakan backend Solr',
	'wikiasearch-titles-only' => 'Cari tajuk laman sahaja',
	'wikiasearch-system-error-msg' => 'Carian anda tidak dapat disiapkan kerana ralat sistem',
	'wikiasearch-search-this-wiki' => 'Cari di Wikia Central sahaja',
	'wikiasearch-search-wikia' => 'Cari dalam Wikia',
	'wikiasearch-image-results' => 'Hasil Carian Gambar (Imej) untuk "$1"',
	'wikiasearch-search-all-wikia' => 'Cari di seluruh Wikia',
	'wikiasearch2-page-title-with-query' => "Hasil carian untuk '$1' - $2",
	'wikiasearch2-page-title-no-query-interwiki' => 'Cari dalam Wikia',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Cari dalam $1',
	'wikiasearch2-search-all-wikia' => 'Cari di seluruh Wikia',
	'wikiasearch2-results' => '$1 hasil',
	'wikiasearch2-pages' => '$1 laman',
	'wikiasearch2-search-on-wiki' => 'Cari di dalam wiki ini',
	'wikiasearch2-results-count' => 'Kira-kira $1 hasil untuk $2',
	'wikiasearch2-results-for' => 'Hasil carian untuk $1',
	'wikiasearch2-global-search-headline' => 'Cari wiki di Wikia',
	'wikiasearch2-wiki-search-headline' => 'Cari dalam wiki ini',
	'wikiasearch2-advanced-search' => 'Pilihan Pencarian Termaju',
	'wikiasearch2-onhub' => ' di Pusat $1',
	'wikiasearch2-enable-go-search' => 'Hidupkan Pergi-Cari',
	'wikiasearch2-noresults' => 'Tiada hasil carian.',
	'wikiasearch2-spellcheck' => 'Tiada hasil carian untuk <em>$1</em>. <strong>Hasil carian dipaparkan untuk <em>$2</em>.</strong>',
);

/** Norwegian Bokmål (‪norsk (bokmål)‬)
 * @author Audun
 */
$messages['nb'] = array(
	'search-desc' => 'Kryss-Wikia søkemotor som bruker Solr-bakgrunnsfunksjon',
	'wikiasearch-titles-only' => 'Kun søk i sidetitler',
	'wikiasearch-system-error-msg' => 'På grunn av en systemfeil kunne ikke søket ditt fullføres',
	'wikiasearch-search-this-wiki' => 'Søk kun i Wikiasentralen',
	'wikiasearch-search-wikia' => 'Søk i Wikia',
	'wikiasearch-image-results' => 'Bilderesultat for «$1»',
	'wikiasearch-search-all-wikia' => 'Søk gjennom hele Wikia',
	'wikiasearch2-page-title-with-query' => 'Søkeresultater for «$1» – $2',
	'wikiasearch2-page-title-no-query-interwiki' => 'Søk i Wikia',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Søk i $1',
	'wikiasearch2-search-all-wikia' => 'Søk i hele Wikia',
	'wikiasearch2-results' => '$1 {{PLURAL:$1|resultat|resultater}}',
	'wikiasearch2-pages' => '$1 {{PLURAL:$1|side|sider}}',
	'wikiasearch2-search-on-wiki' => 'Søk innenfor denne wikien',
	'wikiasearch2-results-count' => 'Omkring $1 {{PLURAL:$1|resultat|resultater}} for $2',
	'wikiasearch2-results-for' => 'Resultater for $1',
	'wikiasearch2-global-search-headline' => 'Finn wikier på Wikia',
	'wikiasearch2-wiki-search-headline' => 'Søk i denne wikien',
	'wikiasearch2-advanced-search' => 'Avanserte søkealternativer',
	'wikiasearch2-onhub' => 'i $1-hubben',
	'wikiasearch2-enable-go-search' => 'Aktiver Gå-søk',
	'wikiasearch2-noresults' => 'Ingen resultater funnet.',
	'wikiasearch2-spellcheck' => 'Ingen resultater ble funnet for <em>$1</em>. <strong>Viser resultater for <em>$2</em>.</strong>',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'search-desc' => "Zoekmachine die gebruik maakt van Solr om in alle Wikia-wiki's te zoeken",
	'wikiasearch-titles-only' => 'Alleen paginanamen doorzoeken',
	'wikiasearch-system-error-msg' => 'Door een systeemfout was het niet mogelijk uw zoekopdracht uit te voeren',
	'wikiasearch-search-this-wiki' => 'Alleen Wikia Central doorzoeken',
	'wikiasearch-search-wikia' => 'Wikia doorzoeken',
	'wikiasearch-image-results' => 'Afbeeldingsresultaten voor "$1"',
	'wikiasearch-search-all-wikia' => 'Heel Wikia dooezoeken',
	'wikiasearch2-page-title-with-query' => "Zoekresultaten voor '$1' - $2",
	'wikiasearch2-page-title-no-query-interwiki' => 'Wikia doorzoeken',
	'wikiasearch2-page-title-no-query-intrawiki' => 'In $1 zoeken',
	'wikiasearch2-search-all-wikia' => 'Heel Wikia dooezoeken',
	'wikiasearch2-results' => '{{PLURAL:$1|één resultaat|$1 resultaten}}',
	'wikiasearch2-pages' => "{{PLURAL:$1|één pagina|$1 pagina's}}",
	'wikiasearch2-search-on-wiki' => 'Binnen deze wiki zoeken',
	'wikiasearch2-results-count' => 'Over {{PLURAL:$1|één resultaat|$1 resultaten}} for $2',
	'wikiasearch2-results-for' => 'Resultaten voor $1',
	'wikiasearch2-global-search-headline' => "Wiki's van Wikia vinden",
	'wikiasearch2-wiki-search-headline' => 'In wiki zoeken',
	'wikiasearch2-advanced-search' => 'Geavanceerde zoekopties',
	'wikiasearch2-onhub' => 'in de hub $1',
	'wikiasearch2-enable-go-search' => 'Go-Search inschakelen',
	'wikiasearch2-noresults' => 'Geen resultaten gevonden.',
	'wikiasearch2-spellcheck' => 'Er zijn geen resultaten gevonden voor <em>$1</em>. <strong>De resultaten voor <em>$2</em> worden weergegeven.</strong>',
	'wikiasearch2-search-all-namespaces' => 'Standaard in alle naamruimten zoeken',
);

/** ‪Nederlands (informeel)‬ (‪Nederlands (informeel)‬)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'wikiasearch-system-error-msg' => 'Door een systeemfout was het niet mogelijk je zoekopdracht uit te voeren',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'wikiasearch-titles-only' => 'Cercar pas que dins los títols de las paginas',
	'wikiasearch-system-error-msg' => "A causa d'una error del sistèma, avèm pas pogut acomplir vòstra recèrca",
	'wikiasearch-search-this-wiki' => 'Cercar pas que dins Wikia Central',
	'wikiasearch-search-wikia' => 'Cercar dins Wikia',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'wikiasearch-search-this-wiki' => 'କେବଳ ଉଇକିଆ ସେଣ୍ଟ୍ରାଲରେ  ଖୋଜିବେ',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sovq
 */
$messages['pl'] = array(
	'search-desc' => 'Silnik wyszukiwania w różnych Wikia  oparty na backendzie Solr',
	'wikiasearch-titles-only' => 'Szukaj wyłącznie w tytułach stron',
	'wikiasearch-system-error-msg' => 'Ze względu na błąd systemu, wyszukiwanie nie mogło zostać wykonane',
	'wikiasearch-search-this-wiki' => 'Szukaj wyłącznie w Wikia Central',
	'wikiasearch-search-wikia' => 'Szukaj w Wikii',
	'wikiasearch-image-results' => 'Grafiki odnalezione dla „$1”',
	'wikiasearch-search-all-wikia' => 'Wyszukiwanie wszystkich Wikia',
	'wikiasearch2-page-title-with-query' => 'Wyników dla frazy "$1" - $2',
	'wikiasearch2-page-title-no-query-interwiki' => 'Przeszukaj Wikię',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Wyszukaj $1',
	'wikiasearch2-search-all-wikia' => 'Szukaj na wszystkich wiki',
	'wikiasearch2-results' => '$1 {{PLURAL:$1|Wynik|Wyniki|Wyników}}',
	'wikiasearch2-pages' => '$1 {{PLURAL:$1|Strona|Strony|Stron}}',
	'wikiasearch2-search-on-wiki' => 'Szukaj na tej wiki',
	'wikiasearch2-results-count' => 'Około $1 {{PLURAL:$1|wynik|wyniki|wyników}} dla "$2"',
	'wikiasearch2-results-for' => 'Wyniki dla $1',
	'wikiasearch2-results-redirected-from' => 'przekierowanie z',
	'wikiasearch2-global-search-headline' => 'Wyszukaj wikię na Wikii',
	'wikiasearch2-wiki-search-headline' => 'Przeszukaj wiki',
	'wikiasearch2-advanced-search' => 'Zaawansowane Opcje Wyszukiwania',
	'wikiasearch2-onhub' => 'W portalu $1',
	'wikiasearch2-enable-go-search' => 'Bezpośrednio przekierowuj do wyszukiwanych artykułów',
	'wikiasearch2-noresults' => 'Brak wyników.',
	'wikiasearch2-spellcheck' => 'Brak wyników dla zapytania <em>$1</em>. <strong>Wyświetlono wyniki dla <em>$2</em>.</strong>',
	'wikiasearch2-tabs-articles' => 'Artykuły',
	'wikiasearch2-tabs-photos-and-videos' => 'Zdjęcia i Filmy',
	'wikiasearch2-users' => 'Ludzie',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'search-desc' => "Motor d'arserca a travers le Wikia ch'a deuvra Solr",
	'wikiasearch-titles-only' => 'Sërché mach ant ij tìtoj dle pàgine',
	'wikiasearch-system-error-msg' => "Për n'eror dël sistema, soa arserca a peul pa esse completà",
	'wikiasearch-search-this-wiki' => 'Serca Mach an Wikia Sentral',
	'wikiasearch-search-wikia' => 'Serca an Wikia',
	'wikiasearch-image-results' => 'Figura Arzultà për "$1"',
	'wikiasearch-search-all-wikia' => 'Arserché su tuta Wikia',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'wikiasearch-titles-only' => 'يوازې د مخ په سرليکونو کې پلټل',
	'wikiasearch-system-error-msg' => 'د غونډال د ستونزو له امله، ستاسې پلټنه نه شي بشپړه کېدای.',
	'wikiasearch-search-this-wiki' => 'يوازې مرکزي ويکي يا پلټل',
	'wikiasearch-search-wikia' => 'ويکيا پلټل',
	'wikiasearch-image-results' => 'د "$1" لپاره د انځور پايلې',
	'wikiasearch-search-all-wikia' => 'ټول ويکييا پلټل',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'search-desc' => 'Motor de pesquisa em toda a Wikia, usando o backend Solr',
	'wikiasearch-titles-only' => 'Pesquisar apenas nos títulos de página',
	'wikiasearch-system-error-msg' => 'Não foi possível concluir a sua pesquisa devido a um erro de sistema',
	'wikiasearch-search-this-wiki' => 'Pesquisar apenas na Wikia Central',
	'wikiasearch-search-wikia' => 'Pesquisar na Wikia',
	'wikiasearch-image-results' => 'Resultados de Imagens para "$1"',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author Daemorris
 * @author Giro720
 */
$messages['pt-br'] = array(
	'search-desc' => 'Motor de pesquisa em toda a Wikia, usando o backend Solr',
	'wikiasearch-titles-only' => 'Pesquisar apenas nos títulos de páginas',
	'wikiasearch-system-error-msg' => 'Devido a um erro de sistema, sua pesquisa não pôde ser efetuada',
	'wikiasearch-search-this-wiki' => 'Pesquisar apenas na wikia Central',
	'wikiasearch-search-wikia' => 'Pesquisar na wikia',
	'wikiasearch-image-results' => 'Resultados de Imagens para "$1"',
);

/** Romanian (română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'wikiasearch-search-wikia' => 'Căutare Wikia',
	'wikiasearch-image-results' => 'Rezultate imagine pentru "$1"',
);

/** Russian (русский)
 * @author Kuzura
 */
$messages['ru'] = array(
	'search-desc' => 'Кросс-Викия поиск с помощью сервера Solr',
	'wikiasearch-titles-only' => 'Искать только в заголовках страниц',
	'wikiasearch-system-error-msg' => 'Из-за системной ошибки, поиск не может быть выполнен',
	'wikiasearch-search-this-wiki' => 'Поиск только по Wikia Central',
	'wikiasearch-search-wikia' => 'Найти на Wikia',
	'wikiasearch-image-results' => 'Результаты поиска изображения для «$1»',
	'wikiasearch-search-all-wikia' => 'Поиск по всей Викия',
	'wikiasearch2-page-title-with-query' => "Результаты поиска для '$1' - $2",
	'wikiasearch2-page-title-no-query-interwiki' => 'Найти на Викия',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Поиск $1',
	'wikiasearch2-search-all-wikia' => 'Поиск по всей Викия',
	'wikiasearch2-results' => '$1 {{PLURAL:$1|результат|результата|результатов}}',
	'wikiasearch2-pages' => '$1 {{PLURAL:$1|страница|страницы|страниц}}',
	'wikiasearch2-search-on-wiki' => 'Поиск в этой вики',
	'wikiasearch2-results-count' => 'Примерно $1 {{PLURAL:$1|результат|результата|результатов}} для $2',
	'wikiasearch2-results-for' => 'Результаты для $1',
	'wikiasearch2-global-search-headline' => 'Найти викии на Викия',
	'wikiasearch2-wiki-search-headline' => 'Поиск по вики',
	'wikiasearch2-advanced-search' => 'Расширенные параметры поиска',
	'wikiasearch2-onhub' => 'в $1 Портале',
	'wikiasearch2-enable-go-search' => 'Перенаправлять на статью при использовании поиска',
	'wikiasearch2-noresults' => 'Ничего не найдено',
	'wikiasearch2-spellcheck' => 'Ничего не найдено для <em>$1</em>. <strong>Показать результатыт поиска для <em>$2</em>.</strong>',
);

/** Serbian (Cyrillic script) (‪српски (ћирилица)‬)
 * @author Rancher
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'wikiasearch-titles-only' => 'Претражи само наслове страница',
	'wikiasearch-system-error-msg' => 'Због системске грешке, ваша претрага се не може извршити',
	'wikiasearch-search-this-wiki' => 'Претражи само централну Викију',
	'wikiasearch-search-wikia' => 'Претражи Викију',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'wikiasearch2-page-title-with-query' => "Säikresultoate foar '$1' - $2",
	'wikiasearch2-page-title-no-query-interwiki' => 'Säik truch Wikia',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Säik $1',
	'wikiasearch2-search-all-wikia' => 'Säik in aal Wikia-Wikis',
	'wikiasearch2-results' => '$1 {{PLURAL:$1|Resultoat|Resultoate}}',
	'wikiasearch2-pages' => '$1 {{PLURAL:$1|Siede|Sieden}}',
	'wikiasearch2-search-on-wiki' => 'Truchsäik dit Wiki',
	'wikiasearch2-results-count' => 'Sowät $1 {{PLURAL:$1|Resultoat|Resultoate}} foar $2',
	'wikiasearch2-results-for' => 'Resultoate foar $1',
	'wikiasearch2-global-search-headline' => 'Fiend uur Wikis ap Wikia',
	'wikiasearch2-wiki-search-headline' => 'Säikresultoate',
	'wikiasearch2-advanced-search' => 'Ärwiederde äiki-Optione',
	'wikiasearch2-onhub' => 'in ju Kategorie $1',
	'wikiasearch2-enable-go-search' => 'Gung bie ne direkte Uureenstämmenge fon ne Säichanfroage mäd n Siedentittel fluks tou ju Siede un nit eerste tou do Säikresultoate',
	'wikiasearch2-noresults' => 'Niks fuunen.',
	'wikiasearch2-spellcheck' => 'Deer wuud foar <em>$1</em> niks fuunen. <strong>Träffere foar <em>$2</em>.</strong>',
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'search-desc' => 'Kryss-Wikias sökmotor som använder bakgrundsfunktionen Solr',
	'wikiasearch-titles-only' => 'Sök endast i sidtitlar',
	'wikiasearch-system-error-msg' => 'På grund av ett systemfel kunde sökningen inte slutföras',
	'wikiasearch-search-this-wiki' => 'Sök endast på Wikia Central',
	'wikiasearch-search-wikia' => 'Sök Wikia',
	'wikiasearch-image-results' => 'Bildresultat för "$1"',
	'wikiasearch-search-all-wikia' => 'Sök på hela Wikia',
	'wikiasearch2-page-title-with-query' => "Sökresultat för '$1'-$2",
	'wikiasearch2-page-title-no-query-interwiki' => 'Sök på Wikia',
	'wikiasearch2-page-title-no-query-intrawiki' => 'Sök på $1',
	'wikiasearch2-search-all-wikia' => 'Sök på hela Wikia',
	'wikiasearch2-results' => '$1 {{PLURAL:$1|resultat|resultat}}',
	'wikiasearch2-pages' => '$1 {{PLURAL:$1|sida|sidor}}',
	'wikiasearch2-search-on-wiki' => 'Sök inom denna wiki',
	'wikiasearch2-results-count' => 'Om $1 {{PLURAL:$1|resultat|resultat}} för $2',
	'wikiasearch2-results-for' => 'Resultat för $1',
	'wikiasearch2-global-search-headline' => 'Hitta wikis på Wikia',
	'wikiasearch2-wiki-search-headline' => 'Sök på denna wiki',
	'wikiasearch2-advanced-search' => 'Avancerade sökalternativ',
	'wikiasearch2-noresults' => 'Inga resultat hittades.',
	'wikiasearch2-spellcheck' => 'Inga resultat hittades för <em>$1</em>. <strong>Visar resultat för <em>$2</em>.</strong>',
);

/** Tamil (தமிழ்)
 * @author Mahir78
 * @author TRYPPN
 */
$messages['ta'] = array(
	'wikiasearch-titles-only' => 'பக்க தலைப்புகளில் மட்டும் தேடுக',
	'wikiasearch-system-error-msg' => 'கணினியில் ஏற்பட்ட பிழை காரணமாக, தங்களின் தேடுதல்களை முழுதும் செய்து முடிக்க முடியவில்லை',
	'wikiasearch-search-this-wiki' => 'மத்திய விக்கியாவில் மட்டும் தேடுங்கள்',
	'wikiasearch-search-wikia' => 'விக்கியாவில் தேடுங்கள்',
	'wikiasearch-image-results' => '"$1"-ன் தோற்றத்தின் முடிவுகள்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'wikiasearch-titles-only' => 'కేవలం పుటల శీర్శికలలో వెతుకు',
	'wikiasearch-search-wikia' => 'వికియాను వెతకండి',
	'wikiasearch-image-results' => '"$1" కొరకు బొమ్మల ఫలితాలు',
);

/** Thai (ไทย)
 * @author Akkhaporn
 */
$messages['th'] = array(
	'search-desc' => 'เครื่องมือการค้นหาข้าม Wikia ใช้ Solr backend',
	'wikiasearch-titles-only' => 'ค้นหาเฉพาะในชื่อหน้า',
	'wikiasearch-system-error-msg' => 'เนื่องจากการผิดพลาดของระบบ การค้นหาของคุณอาจไม่เสร็จสมบูรณ์',
	'wikiasearch-search-this-wiki' => 'ค้นหา Wikia Central เท่านั้น',
	'wikiasearch-search-wikia' => 'ค้นหา Wikia',
	'wikiasearch-image-results' => 'ผลการค้นหารูปภาพสำหรับ "$1"',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'search-desc' => 'Makinang panghanap ng Cross-Wikia na ginagamit ang panlikurang dulo ng Solr',
	'wikiasearch-titles-only' => 'Maghanap lamang sa loob ng mga pamagat ng pahina',
	'wikiasearch-system-error-msg' => 'Dahila sa isang kamalian ng sistema, hindi makukumpleto ang paghahanap mo',
	'wikiasearch-search-this-wiki' => 'Maghanap lamang sa Wikia Central',
	'wikiasearch-search-wikia' => 'Maghanap sa Wikia',
	'wikiasearch-image-results' => 'Mga Kinalabasang Larawan para sa "$1"',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'search-desc' => 'Solr серверы ярдәмендә Кросс-Викия эзләве',
	'wikiasearch-titles-only' => 'Битнең баш исемнәреннән генә эзләргә',
	'wikiasearch-system-error-msg' => 'система хатасы аркасында эзләшү мөмкин түгел',
	'wikiasearch-search-this-wiki' => 'Wikia Central да гына эзләү',
	'wikiasearch-search-wikia' => 'Wikia дә табарга',
	'wikiasearch-image-results' => '«$1» өчен рәсемнәр табу',
	'wikiasearch-search-all-wikia' => 'Бөтен Викия буенча эзләү',
);

/** Ukrainian (українська)
 * @author A1
 * @author Ast
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'wikiasearch-titles-only' => 'Шукати тільки в заголовках сторінок',
	'wikiasearch-system-error-msg' => 'Ваш пошук не може бути виконаним через системну помилку',
	'wikiasearch-search-wikia' => 'Шукати на Вікіа',
	'wikiasearch-image-results' => 'Результати пошуку зображень для "$1"',
	'wikiasearch-search-all-wikia' => 'Шукати по всій Вікіа',
);

/** Vietnamese (Tiếng Việt)
 * @author Xiao Qiao
 * @author XiaoQiaoGrace
 */
$messages['vi'] = array(
	'search-desc' => 'Thông qua công cụ tìm kiếm Wikia bằng cách sử dụng phụ trợ Solr',
	'wikiasearch-titles-only' => 'Chỉ tìm kiếm tiêu đề trang',
	'wikiasearch-system-error-msg' => 'Do một lỗi hệ thống, tìm kiếm của bạn không thể hoàn tất',
	'wikiasearch-search-this-wiki' => 'Chỉ tìm kiếm ở trung tâm Wikia',
	'wikiasearch-search-wikia' => 'Tìm kiếm Wikia',
	'wikiasearch-image-results' => 'Kết quả hình ảnh cho "$1"',
	'wikiasearch-search-all-wikia' => 'Tìm kiếm tất cả Wikia',
);

/** Simplified Chinese (‪中文（简体）‬)
 * @author Dimension
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'search-desc' => '跨Wikia搜索引擎（使用Solr后端）',
	'wikiasearch-titles-only' => '仅在页面标题中搜索',
	'wikiasearch-system-error-msg' => '系统错误，无法完成您的搜索',
	'wikiasearch-search-this-wiki' => '仅在Wikia Central中搜索',
	'wikiasearch-search-wikia' => '搜索Wikia',
	'wikiasearch-image-results' => '"$1"图像搜索结果',
	'wikiasearch-search-all-wikia' => '搜索所有Wikia',
);

/** Traditional Chinese (‪中文（繁體）‬)
 * @author Ffaarr
 */
$messages['zh-hant'] = array(
	'wikiasearch-search-wikia' => '搜尋Wikia',
	'wikiasearch-search-all-wikia' => '搜尋整個 Wikia',
);

