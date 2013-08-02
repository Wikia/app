<?php
/**
 * WikiaMobile internationalization messages
 *
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

$messages = array();

$messages['en'] = array(
	'wikiamobile-search' => 'Search',
	'wikiamobile-search-this-wiki' => 'Search this wiki',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Login',
	'wikiamobile-password' => 'Password',
	'wikiamobile-login-submit' => 'Login',
	'wikiamobile-menu' => 'Menu',
	'wikiamobile-article-categories' => 'Categories',
	'wikiamobile-feedback' => 'Feedback',
	'wikiamobile-back' => 'Back',
	'wikiamobile-hide-section' => 'hide',
	'wikiamobile-profile' => 'Profile',

	//footer
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Lifestyle]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Entertainment]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Video Games]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Licensing]]',
	'mobile-full-site' => 'Full site',

	//categories
	'wikiamobile-categories-tagline' => 'Category Page',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|article|articles}}',
	'wikiamobile-category-items-more' => 'Load more',
	'wikiamobile-category-items-prev' => 'Load previous',
	'wikiamobile-categories-expand' => 'Show All',
	'wikiamobile-categories-collapse' => 'Hide All',

	//sharing
	'wikiamobile-sharing-media-image' => 'Picture',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 on $2 - $3',
	'wikiamobile-sharing-email-text' => 'Hey,
you should definitely check this out:

 $1',

 	//media
 	'wikiamobile-media-group-footer' => '1 of $1',
 	'wikiamobile-unsupported-video-download' => 'Your browser doesn\'t support this video format, try clicking <a href="$1">here</a>',
 	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|view|views}}',
	'wikiamobile-video-not-friendly-header' => 'Oh snap!',
	'wikiamobile-video-not-friendly' => 'Sorry, this video isn\'t available on mobile.',

	//ad
	'wikiamobile-ad-label' => 'advertisement',

	//modal
	'wikiamobile-image-not-loaded' => 'Image is not available',
	'wikiamobile-shared-file-not-available' => "Oops, this item is no longer available, but now that you're here, explore the wiki!",

	//404 page
	'wikiamobile-page-not-found' => "Oops! <b>$1</b> does not exist.",
	'wikiamobile-page-not-found-tap' => "Tap what's hiding behind the crack to see one that does.",

	//Game Guides promotion on wikiamobile
	'wikiasmartbanner-appstore' => 'On the App Store',
	'wikiasmartbanner-googleplay' => 'In Google Play',
	'wikiasmartbanner-price' => 'free',
	'wikiasmartbanner-view' => 'view'
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'wikiamobile-search-wiki' => 'Text indicating that scope for a search will be current wiki',
	'wikiamobile-search-wikia' => 'Text indicating that scope for a search will be whole wikia network',
	'wikiamobile-login' => 'Placeholder on input asking for password',
	'wikiamobile-password' => 'Placeholder on input asking for password',
	'wikiamobile-login-submit' => 'Label on a blue button prompting user to log in',
	'wikiamobile-search' => 'Label on a search button placed in Mobile skin top bar',
	'wikiamobile-search-this-wiki' => 'Placeholder in input on search field',
	'wikiamobile-menu' => 'Header on wiki menu',
	'wikiamobile-article-categories' => 'Message displayed on category section on an article',
	'wikiamobile-feedback' => 'Link to a feedback form',
	'wikiamobile-back' => 'Label on a button to go back one level on wiki navigation',
	'wikiamobile-hide-section' => 'Link to close section on an article that is at the end of a given section',
	'wikiamobile-profile' => 'Link to a profile page in a top wiki navigation',

	//footer
	'wikiamobile-footer-link-licencing' => 'Label for the link pointing to content licensing information',
	'wikiamobile-footer-link-lifestyle' => 'Interwiki link, please translate only the last parameter after the last "|" if that makes sense',
	'wikiamobile-footer-link-entertainment' => 'Interwiki link, please translate only the last parameter after the last "|" if that makes sense',
	'wikiamobile-footer-link-videogames' => 'Interwiki link, please translate only the last parameter after the last "|" if that makes sense',
	'mobile-full-site' => 'Link to reload a page and load desktop skin',

	//categories
	'wikiamobile-categories-tagline' => 'Tagline that appears next to the category page title, please keep it really short',
	'wikiamobile-categories-items-total' => 'Message above list of articles in a category. $1 is the total number of articles in the category',
	'wikiamobile-category-items-more' => 'Label on a button to load more articles under given letter on category page',
	'wikiamobile-category-items-prev' => 'Label on a button to load previous articles under given letter on category page',
	'wikiamobile-categories-expand' => 'Label on a button to expand/collapse all articles on category',
	'wikiamobile-categories-collapse' => 'Label on a button to expand/collapse all articles on category',

	//sharing
	'wikiamobile-sharing-media-image' => 'This is a message that becomes part of wikiamobile-sharing-modal-text indicating type of media shared',
	'wikiamobile-sharing-page-text' => 'Message feed into email that have links to wiki and article that is being shared. $1 is the title of the article, $2 is the name of the wiki',
	'wikiamobile-sharing-modal-text' => 'Message feed into email that have links to wiki and media that is being shared. $1 is the type of media, $2 is the title of the article, $3 is the name of the wiki',
	'wikiamobile-sharing-email-text' => 'Email message with a shared page or media. $1 is the result of wikiamobile-sharing-modal-text or wikiamobile-sharing-page-text, please keep the empty space before $1',

	//media
	'wikiamobile-media-group-footer' => 'Caption under a media-group/gallery, $1 contains the total amount of images/videos in the group',
	'wikiamobile-unsupported-video-download' => 'Feedback message for browsers not supporting html5 videos with link to play the video in a native app (the video URL is in $1)',
	'wikiamobile-video-views-counter' => 'Counter for the number of views for a video, $1 is an integer number, minimum 0; possibly it should be no more than 1 or 2 words',
	'wikiamobile-video-not-friendly-header' => 'Friendly message on a screen with a not supported video',
	'wikiamobile-video-not-friendly' => 'Message displayed in modal - to indicate that this video won\'t be loaded in mobile skin',

	//ad
	'wikiamobile-ad-label' => 'Message shown to a user on page next to advertisement - to distinguish that below is an ad',

	//modal
	'wikiamobile-image-not-loaded' => 'This is a message shown to a user when an image could not be loaded in the modal',
	'wikiamobile-shared-file-not-available' => 'Message displayed when user opens a link to particular media on an article and this media is not available anymore.',

	//404 page
	'wikiamobile-page-not-found-tap' => 'Message that describe what to do on 404 page with an image behind the crack',
	'wikiamobile-page-not-found' => 'Message shown to a user on 404 page; $1 is a page title that was not found. Please make sure b element wraps around $1.',

	//Game Guides promotion on wikiamobile
	'wikiasmartbanner-appstore' => 'Message displayed in smart banner promoting an app on app store',
	'wikiasmartbanner-googleplay' => 'Message displayed in smart banner promoting an app on google play store',
	'wikiasmartbanner-price' => 'Message displayed in smart banner indicating a price of an app',
	'wikiasmartbanner-view' => 'Message displayed in smart banner promoting on a button that leads to a store',
);

/** Адыгэбзэ (Адыгэбзэ)
 * @author Peserey
 */
$messages['ady-cyrl'] = array(
	'wikiamobile-search' => 'Лъыхъу',
	'wikiamobile-search-wiki' => 'Вики',
	'wikiamobile-search-wikia' => 'Викя',
	'wikiamobile-login' => 'Къихь',
	'wikiamobile-password' => 'Щэфыгъэ',
	'wikiamobile-login-submit' => 'Къихь',
	'wikiamobile-menu' => 'Мэню',
	'wikiamobile-explore' => 'Експлоры',
	'wikiamobile-article-categories' => 'Катэгорий',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Lifestyle]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Entertainment]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Video Games]]',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'wikiamobile-search' => 'Soek',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Meld aan',
	'wikiamobile-password' => 'Wagwoord',
	'wikiamobile-login-submit' => 'Meld aan',
	'wikiamobile-menu' => 'Keuses',
	'wikiamobile-explore' => 'Verken',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'wikiamobile-search' => 'Axtar',
	'wikiamobile-search-wiki' => 'Viki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Loqin',
	'wikiamobile-password' => 'Parol',
	'wikiamobile-login-submit' => 'Loqin',
);

/** Bulgarian (български)
 * @author DCLXVI
 * @author Ivanko
 */
$messages['bg'] = array(
	'wikiamobile-search' => 'Търсене',
	'wikiamobile-search-wiki' => 'Уики',
	'wikiamobile-search-wikia' => 'Уикия',
	'wikiamobile-login' => 'Влизане',
	'wikiamobile-password' => 'Парола',
	'wikiamobile-login-submit' => 'Влизане',
	'wikiamobile-menu' => 'Меню',
	'wikiamobile-article-categories' => 'Категории',
	'wikiamobile-back' => 'Назад',
	'wikiamobile-hide-section' => 'скриване',
);

/** Breton (brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'wikiamobile-search' => 'Klask',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Kevreañ',
	'wikiamobile-password' => 'Ger-tremen',
	'wikiamobile-login-submit' => 'Kevreañ',
	'wikiamobile-menu' => 'Lañser',
	'wikiamobile-explore' => 'Ergerzhout',
);

/** Catalan (català)
 * @author Gemmaa
 */
$messages['ca'] = array(
	'wikiamobile-search' => 'Cerca',
	'wikiamobile-search-wiki' => 'Wikia',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Inici de sessió',
	'wikiamobile-password' => 'Contrasenya',
	'wikiamobile-login-submit' => 'Iniciar sessió',
	'wikiamobile-menu' => 'Menú',
	'wikiamobile-explore' => 'Explorar',
);

/** German (Deutsch)
 * @author Avatar
 * @author Geitost
 * @author Inkowik
 * @author Kghbln
 * @author PtM
 * @author Quedel
 * @author Tiin
 */
$messages['de'] = array(
	'wikiamobile-search' => 'Suche',
	'wikiamobile-search-this-wiki' => 'Im Wiki suchen',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Anmelden',
	'wikiamobile-password' => 'Passwort',
	'wikiamobile-login-submit' => 'Anmelden',
	'wikiamobile-menu' => 'Menü',
	'wikiamobile-explore' => 'Durchsuchen',
	'wikiamobile-article-categories' => 'Kategorien',
	'wikiamobile-feedback' => 'Rückmeldung',
	'wikiamobile-back' => 'Zurück',
	'wikiamobile-hide-section' => 'ausblenden',
	'wikiamobile-footer-link-license' => 'Lizenz',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Lifestyle]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Entertainment]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Spiele]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|Artikel|Artikel}}',
	'wikiamobile-category-items-more' => 'Weitere laden',
	'wikiamobile-category-items-prev' => 'Vorherige laden',
	'wikiamobile-categories-expand' => 'Alle anzeigen',
	'wikiamobile-categories-collapse' => 'Alle ausblenden',
	'wikiamobile-sharing-media-image' => 'Bild',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 auf $2 - $3',
	'wikiamobile-sharing-email-text' => 'Hallo,
du solltest dir das unbedingt anschauen:

$1',
	'wikiamobile-ad-close' => 'schließen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Geitost
 */
$messages['de-formal'] = array(
	'wikiamobile-sharing-email-text' => 'Hallo,
Sie sollten sich das unbedingt anschauen:

$1',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'wikiamobile-search' => 'Cı geyre',
	'wikiamobile-search-this-wiki' => 'Ena viki de bıvin',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Dekewtış',
	'wikiamobile-password' => 'Parola',
	'wikiamobile-login-submit' => 'Dekewtış',
	'wikiamobile-menu' => 'Menu',
	'wikiamobile-explore' => 'Keşıf',
	'wikiamobile-article-categories' => 'Kategoriy',
	'wikiamobile-feedback' => 'Peydrıstış',
	'wikiamobile-back' => 'Peyd bê',
	'wikiamobile-hide-section' => 'bınımne',
	'wikiamobile-footer-link-license' => 'Lisans',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Stilê cıwıyayışi]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Keyfiye]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Kayê Videoy]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|wesiqe|wesiqey}}',
	'wikiamobile-category-items-more' => 'Vêşi barke',
	'wikiamobile-category-items-prev' => 'Verqayti barke',
	'wikiamobile-categories-expand' => 'Pêron Bımocne',
	'wikiamobile-categories-collapse' => 'Pêron bınımne',
	'wikiamobile-sharing-media-image' => 'Resim',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 ke $2 - $3',
	'wikiamobile-sharing-email-text' => 'Hey,
Heq ne heq eneri qontrol kerê:

$1',
	'wikiamobile-ad-close' => 'racnê',
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Benfutbol10
 * @author Ciencia Al Poder
 * @author Kflorence
 * @author VegaDark
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'wikiamobile-search' => 'Buscar',
	'wikiamobile-search-this-wiki' => 'Buscar en este wiki',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Ingresar',
	'wikiamobile-password' => 'Contraseña',
	'wikiamobile-login-submit' => 'Ingresar',
	'wikiamobile-menu' => 'Menú',
	'wikiamobile-explore' => 'Explorar',
	'wikiamobile-article-categories' => 'Categorías',
	'wikiamobile-feedback' => 'Sugerencias',
	'wikiamobile-back' => 'Atrás',
	'wikiamobile-hide-section' => 'ocultar',
	'wikiamobile-footer-link-license' => 'Licencia',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Estilo de vida]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Entretenimiento]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Videojuegos]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|artículo|artículos}}',
	'wikiamobile-category-items-more' => 'Cargar más',
	'wikiamobile-category-items-prev' => 'Cargar el anterior',
	'wikiamobile-categories-expand' => 'Mostrar todo',
	'wikiamobile-categories-collapse' => 'Ocultar todo',
	'wikiamobile-sharing-media-image' => 'Imagen',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 en $2 - $3',
	'wikiamobile-sharing-email-text' => 'Oye,
definitivamente debes de ver esto:

$1',
	'wikiamobile-ad-close' => 'cerrar',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'wikiamobile-search' => 'جستجو',
	'wikiamobile-search-wiki' => 'ویکی',
	'wikiamobile-search-wikia' => 'ویکیا',
	'wikiamobile-login' => 'ورود',
	'wikiamobile-password' => 'رمز عبور',
);

/** Finnish (suomi)
 * @author VezonThunder
 */
$messages['fi'] = array(
	'wikiamobile-search' => 'Hae',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Kirjaudu sisään',
	'wikiamobile-password' => 'Salasana',
	'wikiamobile-login-submit' => 'Kirjaudu sisään',
	'wikiamobile-menu' => 'Valikko',
	'wikiamobile-explore' => 'Tutustu',
	'wikiamobile-article-categories' => 'Luokat',
	'wikiamobile-feedback' => 'Palaute',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Elämäntyyli]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Viihde]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Pelaaminen]]',
);

/** French (français)
 * @author Crochet.david
 * @author DavidL
 * @author Gomoko
 * @author Verdy p
 * @author Wyz
 */
$messages['fr'] = array(
	'wikiamobile-search' => 'Rechercher',
	'wikiamobile-search-this-wiki' => 'Rechercher sur ce wiki',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Connexion',
	'wikiamobile-password' => 'Mot de passe',
	'wikiamobile-login-submit' => 'Se connecter',
	'wikiamobile-menu' => 'Menu',
	'wikiamobile-explore' => 'Explorer',
	'wikiamobile-article-categories' => 'Catégories',
	'wikiamobile-feedback' => 'Avis',
	'wikiamobile-back' => 'Retour',
	'wikiamobile-hide-section' => 'masquer',
	'wikiamobile-footer-link-license' => 'Sous licence',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Lifestyle]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Divertissement]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Jeu]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|article|articles}}',
	'wikiamobile-category-items-more' => 'Lire la suite',
	'wikiamobile-category-items-prev' => 'Lire le précédent',
	'wikiamobile-categories-expand' => 'Afficher tout',
	'wikiamobile-categories-collapse' => 'Masquer tout',
	'wikiamobile-sharing-media-image' => 'Image',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 sur $2 - $3',
	'wikiamobile-sharing-email-text' => 'Bonjour,
vous devriez vraiment y jeter un œil :

$1',
	'wikiamobile-ad-close' => 'fermer',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'wikiamobile-search' => 'Procurar',
	'wikiamobile-search-this-wiki' => 'Procurar neste wiki',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Rexistro',
	'wikiamobile-password' => 'Contrasinal',
	'wikiamobile-login-submit' => 'Rexistro',
	'wikiamobile-menu' => 'Menú',
	'wikiamobile-explore' => 'Explorar',
	'wikiamobile-article-categories' => 'Categorías',
	'wikiamobile-feedback' => 'Comentarios',
	'wikiamobile-back' => 'Volver',
	'wikiamobile-hide-section' => 'agochar',
	'wikiamobile-footer-link-license' => 'Licenza',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Estilo de vida]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Entretemento]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Xogos]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|artigo|artigos}}',
	'wikiamobile-category-items-more' => 'Cargar máis',
	'wikiamobile-category-items-prev' => 'Cargar os anteriores',
	'wikiamobile-categories-expand' => 'Mostrar todos',
	'wikiamobile-categories-collapse' => 'Agochar todos',
	'wikiamobile-sharing-media-image' => 'Imaxe',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 en $2 - $3',
	'wikiamobile-sharing-email-text' => 'Boas,
deberías botar un ollo a isto:

 $1',
	'wikiamobile-ad-close' => 'pechar',
);

/** Hebrew (עברית)
 * @author Yova
 */
$messages['he'] = array(
	'wikiamobile-search' => 'חיפוש',
	'wikiamobile-search-wiki' => 'ויקי',
	'wikiamobile-search-wikia' => 'ויקיה',
	'wikiamobile-login' => 'כניסה',
	'wikiamobile-password' => 'סיסמה',
	'wikiamobile-login-submit' => 'התחבר/י',
	'wikiamobile-menu' => 'תפריט',
	'wikiamobile-explore' => 'חקור/י עוד',
	'wikiamobile-article-categories' => 'קטגוריות',
	'wikiamobile-feedback' => 'משוב',
	'wikiamobile-back' => 'חזרה',
	'wikiamobile-hide-section' => 'הסתר',
	'wikiamobile-footer-link-license' => 'רישיון',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|איכות חיים]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|בידור]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|משחקי וידאו]]',
	'wikiamobile-categories-items-total' => '{{PLURAL:$1|ערך אחד|$1 ערכים}}',
	'wikiamobile-category-items-more' => 'טען עוד',
	'wikiamobile-category-items-prev' => 'טען פחות',
	'wikiamobile-categories-expand' => 'הצג הכל',
	'wikiamobile-categories-collapse' => 'הסתר הכל',
	'wikiamobile-sharing-media-image' => 'תמונה',
	'wikiamobile-sharing-modal-text' => '$1 ב$2 - $3',
	'wikiamobile-sharing-email-text' => 'שלום,
אתה בהחלט צריך לבדוק זאת:

 $1',
	'wikiamobile-ad-close' => 'סגור',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'wikiamobile-search' => 'Cercar',
	'wikiamobile-search-this-wiki' => 'Cercar in iste wiki',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Aperir session',
	'wikiamobile-password' => 'Contrasigno',
	'wikiamobile-login-submit' => 'Aperir session',
	'wikiamobile-menu' => 'Menu',
	'wikiamobile-explore' => 'Explorar',
	'wikiamobile-article-categories' => 'Categorias',
	'wikiamobile-feedback' => 'Commentario',
	'wikiamobile-back' => 'Retro',
	'wikiamobile-hide-section' => 'celar',
	'wikiamobile-footer-link-license' => 'Licentia',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Stilo de vita]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Intertenimento]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Joco]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|articulo|articulos}}',
	'wikiamobile-category-items-more' => 'Cargar plus',
	'wikiamobile-category-items-prev' => 'Cargar precedente',
	'wikiamobile-categories-expand' => 'Monstrar totes',
	'wikiamobile-categories-collapse' => 'Celar totes',
	'wikiamobile-sharing-media-image' => 'Imagine',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 sur $2 - $3',
	'wikiamobile-sharing-email-text' => 'Bon die,
tu deberea absolutemente jectar un oculo sur isto:

 $1',
	'wikiamobile-ad-close' => 'clauder',
);

/** Kannada (ಕನ್ನಡ)
 * @author VASANTH S.N.
 */
$messages['kn'] = array(
	'wikiamobile-search' => 'ಹುಡುಕು',
	'wikiamobile-search-wiki' => 'ವಿಕಿ',
	'wikiamobile-search-wikia' => 'ವಿಕಿಯಾ',
	'wikiamobile-login' => 'ಲಾಗ್ ಇನ್',
	'wikiamobile-password' => 'ಪ್ರವೇಶಪದ',
	'wikiamobile-login-submit' => 'ಲಾಗ್ ಇನ್',
	'wikiamobile-menu' => 'ಯಾದಿ',
	'wikiamobile-explore' => 'ಅನ್ವೇಷಿಸು',
	'wikiamobile-article-categories' => 'ವರ್ಗಗಳು',
	'wikiamobile-feedback' => 'ಮರುಮಾಹಿತಿ',
	'wikiamobile-back' => 'ಹಿಂದಕ್ಕೆ',
	'wikiamobile-hide-section' => 'ಅಡಗಿಸು',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|ಮನರಂಜನೆ]]',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'wikiamobile-search' => 'Lêgerîn',
	'wikiamobile-search-wiki' => 'Wîkî',
	'wikiamobile-search-wikia' => 'Wîkiya',
	'wikiamobile-login' => 'Têketin',
	'wikiamobile-password' => 'Şîfre',
	'wikiamobile-login-submit' => 'Têkeve',
	'wikiamobile-menu' => 'Menû',
	'wikiamobile-explore' => 'Vedîtin',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'wikiamobile-search' => 'Sichen',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Aloggen',
	'wikiamobile-password' => 'Passwuert',
	'wikiamobile-login-submit' => 'Aloggen',
	'wikiamobile-menu' => 'Menü',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'wikiamobile-search' => 'Пребарај',
	'wikiamobile-search-this-wiki' => 'Пребарување по ова вики',
	'wikiamobile-search-wiki' => 'Вики',
	'wikiamobile-search-wikia' => 'Викија',
	'wikiamobile-login' => 'Најава',
	'wikiamobile-password' => 'Лозинка',
	'wikiamobile-login-submit' => 'Најава',
	'wikiamobile-menu' => 'Мени',
	'wikiamobile-explore' => 'Истражете',
	'wikiamobile-article-categories' => 'Категории',
	'wikiamobile-feedback' => 'Мислења',
	'wikiamobile-back' => 'Назад',
	'wikiamobile-hide-section' => 'скриј',
	'wikiamobile-footer-link-license' => 'Лиценцирање',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Животен стил]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Забава]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Игри]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|статија|статии}}',
	'wikiamobile-category-items-more' => 'Вчитај уште',
	'wikiamobile-category-items-prev' => 'Вчитај претходни',
	'wikiamobile-categories-expand' => 'Прикажи сè',
	'wikiamobile-categories-collapse' => 'Скриј ги сите',
	'wikiamobile-sharing-media-image' => 'Слика',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 на $2 - $3',
	'wikiamobile-sharing-email-text' => 'Здраво,
ова дефинитивно мора да го видиш:

 $1',
	'wikiamobile-ad-close' => 'затвори',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'wikiamobile-search' => 'Cari',
	'wikiamobile-search-this-wiki' => 'Cari dalam wiki ini',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Log masuk',
	'wikiamobile-password' => 'Kata laluan',
	'wikiamobile-login-submit' => 'Log masuk',
	'wikiamobile-menu' => 'Masuk',
	'wikiamobile-explore' => 'Jelajah',
	'wikiamobile-article-categories' => 'Kategori',
	'wikiamobile-feedback' => 'Maklum balas',
	'wikiamobile-back' => 'Kembali',
	'wikiamobile-hide-section' => 'sorokkan',
	'wikiamobile-footer-link-license' => 'Perlesenan',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Gaya Hidup]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Hiburan]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Permainan]]',
	'wikiamobile-categories-items-total' => '$1 rencana',
	'wikiamobile-category-items-more' => 'Muatkan banyak lagi',
	'wikiamobile-category-items-prev' => 'Muatkan yang sebelumnya',
	'wikiamobile-categories-expand' => 'Paparkan Semua',
	'wikiamobile-categories-collapse' => 'Sorokkan Semua',
	'wikiamobile-sharing-media-image' => 'Gambar',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 tentang $2 - $3',
	'wikiamobile-sharing-email-text' => 'Hei,
apa kata anda tengok yang ini pula:

 $1',
	'wikiamobile-ad-close' => 'tutup',
);

/** Norwegian Bokmål (‪norsk (bokmål)‬)
 * @author Audun
 */
$messages['nb'] = array(
	'wikiamobile-search' => 'Søk',
	'wikiamobile-search-this-wiki' => 'Søk i denne wikien',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Logg inn',
	'wikiamobile-password' => 'Passord',
	'wikiamobile-login-submit' => 'Logg inn',
	'wikiamobile-menu' => 'Meny',
	'wikiamobile-explore' => 'Utforsk',
	'wikiamobile-article-categories' => 'Kategorier',
	'wikiamobile-feedback' => 'Tilbakemelding',
	'wikiamobile-back' => 'Tilbake',
	'wikiamobile-hide-section' => 'skjul',
	'wikiamobile-footer-link-license' => 'Lisensiering',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Livsstil]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Underholdning]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Spill]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|artikkel|artikler}}',
	'wikiamobile-category-items-more' => 'Last inn mer',
	'wikiamobile-category-items-prev' => 'Last inn forrige',
	'wikiamobile-categories-expand' => 'Vis alle',
	'wikiamobile-categories-collapse' => 'Skjul alle',
	'wikiamobile-sharing-media-image' => 'Bilde',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 på $2 – $3',
	'wikiamobile-sharing-email-text' => 'Hei,
du burde definitivt sjekke ut dette:

$1',
	'wikiamobile-ad-close' => 'lukk',
);

/** Dutch (Nederlands)
 * @author AvatarTeam
 * @author Bereisgreat
 * @author SPQRobin
 * @author Siebrand
 * @author TBloemink
 */
$messages['nl'] = array(
	'wikiamobile-search' => 'Zoeken',
	'wikiamobile-search-this-wiki' => 'In wiki zoeken',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Aanmelden',
	'wikiamobile-password' => 'Wachtwoord',
	'wikiamobile-login-submit' => 'Aanmelden',
	'wikiamobile-menu' => 'Menu',
	'wikiamobile-explore' => 'Verkennen',
	'wikiamobile-article-categories' => 'Categorieën',
	'wikiamobile-feedback' => 'Terugkoppeling',
	'wikiamobile-back' => 'Terug',
	'wikiamobile-hide-section' => 'verbergen',
	'wikiamobile-footer-link-license' => 'Licentie',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Lifestyle]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Vermaak]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Video Games]]',
	'wikiamobile-categories-items-total' => "{{PLURAL:$1|Eén pagina|$1 pagina's}}",
	'wikiamobile-category-items-more' => 'Meer laden',
	'wikiamobile-category-items-prev' => 'Vorige laden',
	'wikiamobile-categories-expand' => 'Allemaal weergeven',
	'wikiamobile-categories-collapse' => 'Alles verbergen',
	'wikiamobile-sharing-media-image' => 'Afbeelding',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 in $2 - $3',
	'wikiamobile-sharing-email-text' => 'Hallo,
dit moet u echt zien:

$1',
	'wikiamobile-ad-close' => 'sluiten',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sovq
 * @author Woytecr
 */
$messages['pl'] = array(
	'wikiamobile-search' => 'Szukaj',
	'wikiamobile-search-this-wiki' => 'Przeszukaj wiki',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Login',
	'wikiamobile-password' => 'Hasło',
	'wikiamobile-login-submit' => 'Zaloguj',
	'wikiamobile-menu' => 'Menu',
	'wikiamobile-explore' => 'Eksploruj',
	'wikiamobile-article-categories' => 'Kategorie',
	'wikiamobile-feedback' => 'Opinie',
	'wikiamobile-back' => 'Wstecz',
	'wikiamobile-hide-section' => 'ukryj',
	'wikiamobile-footer-link-license' => 'Licencja',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Lifestyle]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Rozrywka]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Gry]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|artykuł|artykuły|artykułów}}',
	'wikiamobile-category-items-more' => 'Załaduj więcej',
	'wikiamobile-category-items-prev' => 'Załaduj poprzednie',
	'wikiamobile-categories-expand' => 'Pokaż wszystko',
	'wikiamobile-categories-collapse' => 'Ukryj wszystko',
	'wikiamobile-sharing-media-image' => 'Obraz',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 w $2 - $3',
	'wikiamobile-sharing-email-text' => 'Zdecydowanie powinieneś zobaczyć to:

 $1',
	'wikiamobile-ad-close' => 'zamknij',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'wikiamobile-search' => 'پلټل',
	'wikiamobile-search-wiki' => 'ويکي',
	'wikiamobile-search-wikia' => 'ويکيا',
	'wikiamobile-login' => 'ننوتل',
	'wikiamobile-password' => 'پټنوم',
	'wikiamobile-login-submit' => 'ننوتل',
	'wikiamobile-menu' => 'غورنۍ',
	'wikiamobile-article-categories' => 'وېشنيزې',
	'wikiamobile-back' => 'پر شا',
	'wikiamobile-hide-section' => 'پټول',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|ويډيويي لوبې]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|ليکنه|ليکنې}}',
	'wikiamobile-categories-expand' => 'ټول ښکاره کول',
	'wikiamobile-categories-collapse' => 'ټول پټول',
	'wikiamobile-sharing-media-image' => 'انځور',
	'wikiamobile-ad-close' => 'تړل',
);

/** Portuguese (português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'wikiamobile-menu' => 'Menu',
	'wikiamobile-article-categories' => 'Categorias',
	'wikiamobile-ad-close' => 'fechar',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Caio1478
 * @author Pedroca cerebral
 */
$messages['pt-br'] = array(
	'wikiamobile-search' => 'Pesquisa',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Login',
	'wikiamobile-password' => 'Senha',
	'wikiamobile-login-submit' => 'Login',
	'wikiamobile-menu' => 'Menu',
	'wikiamobile-explore' => 'Explorar',
	'wikiamobile-article-categories' => 'Categorias',
	'wikiamobile-feedback' => 'Feedback',
	'wikiamobile-back' => 'Voltar',
	'wikiamobile-hide-section' => 'esconder',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|artigo|artigos}}',
	'wikiamobile-category-items-more' => 'Carregar mais',
	'wikiamobile-category-items-prev' => 'Carregamento anterior',
	'wikiamobile-categories-expand' => 'Mostrar Todas',
	'wikiamobile-categories-collapse' => 'Esconder Todas',
	'wikiamobile-sharing-media-image' => 'Imagem',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 no $2 - $3',
	'wikiamobile-sharing-email-text' => 'Ei,
você deve definitivamente verificar isso:

 $1',
	'wikiamobile-ad-close' => 'fechar',
);

/** Russian (русский)
 * @author Express2000
 * @author Kuzura
 * @author Lvova
 */
$messages['ru'] = array(
	'wikiamobile-search' => 'Поиск',
	'wikiamobile-search-this-wiki' => 'Поиск по этой вики',
	'wikiamobile-search-wiki' => 'Вики',
	'wikiamobile-search-wikia' => 'Викия',
	'wikiamobile-login' => 'Войти',
	'wikiamobile-password' => 'Пароль',
	'wikiamobile-login-submit' => 'Войти',
	'wikiamobile-menu' => 'Меню',
	'wikiamobile-explore' => 'Исследовать',
	'wikiamobile-article-categories' => 'Категории',
	'wikiamobile-feedback' => 'Отзыв',
	'wikiamobile-back' => 'Назад',
	'wikiamobile-hide-section' => 'скрыть',
	'wikiamobile-footer-link-license' => 'Лицензирование',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Увлечения]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Кино и сериалы]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Игры]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|статья|статьи|статей}}',
	'wikiamobile-category-items-more' => 'Загрузить ещё',
	'wikiamobile-category-items-prev' => 'Загрузить предыдущие',
	'wikiamobile-categories-expand' => 'Показать всё',
	'wikiamobile-categories-collapse' => 'Скрыть всё',
	'wikiamobile-sharing-media-image' => 'Картинка',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 на $2 - $3',
	'wikiamobile-sharing-email-text' => 'Привет,
ты определенно должен заглянуть сюда:

 $1',
	'wikiamobile-ad-close' => 'закрыть',
);

/** Sakha (саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'wikiamobile-login-submit' => 'Киир',
);

/** Slovak (slovenčina)
 * @author Kusavica
 */
$messages['sk'] = array(
	'wikiamobile-login' => 'Prihlásiť sa',
	'wikiamobile-password' => 'Heslo',
	'wikiamobile-login-submit' => 'Prihlasovacie meno',
	'wikiamobile-menu' => 'Ponuka',
	'wikiamobile-explore' => 'Skúmať',
	'wikiamobile-feedback' => 'Spätná väzba',
	'wikiamobile-back' => 'Späť',
	'wikiamobile-category-items-more' => 'Načítať viac',
	'wikiamobile-category-items-prev' => 'Načítať predchádzajúce',
	'wikiamobile-categories-expand' => 'Zobraziť všetko',
	'wikiamobile-categories-collapse' => 'Skryť všetko',
	'wikiamobile-sharing-media-image' => 'Obrázok',
);

/** Serbian (Cyrillic script) (‪српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'wikiamobile-search' => 'Претражи',
	'wikiamobile-search-wiki' => 'Вики',
	'wikiamobile-search-wikia' => 'Викија',
	'wikiamobile-login' => 'Пријава',
	'wikiamobile-password' => 'Лозинка',
	'wikiamobile-login-submit' => 'Пријави ме',
	'wikiamobile-menu' => 'Мени',
	'wikiamobile-explore' => 'Истражите',
	'wikiamobile-article-categories' => 'Категорије',
	'wikiamobile-feedback' => 'Повратне информације',
	'wikiamobile-back' => 'Назад',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Животни стил]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Забава]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Игре]]',
);

/** Swedish (svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'wikiamobile-search' => 'Sök',
	'wikiamobile-search-this-wiki' => 'Sök på denna wiki',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Logga in',
	'wikiamobile-password' => 'Lösenord',
	'wikiamobile-login-submit' => 'Logga in',
	'wikiamobile-menu' => 'Meny',
	'wikiamobile-explore' => 'Utforska',
	'wikiamobile-article-categories' => 'Kategorier',
	'wikiamobile-feedback' => 'Feedback',
	'wikiamobile-back' => 'Tillbaka',
	'wikiamobile-hide-section' => 'dölj',
	'wikiamobile-footer-link-license' => 'Licensiering',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Livsstil]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Underhållning]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Spel]]',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|artikel|artiklar}}',
	'wikiamobile-category-items-more' => 'Läs in fler',
	'wikiamobile-category-items-prev' => 'Läs in föregående',
	'wikiamobile-categories-expand' => 'Visa alla',
	'wikiamobile-categories-collapse' => 'Dölj alla',
	'wikiamobile-sharing-media-image' => 'Bild',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 på $2 - $3',
	'wikiamobile-sharing-email-text' => 'Hej,
du borde definitivt spana in detta:

$1',
	'wikiamobile-ad-close' => 'stäng',
);

/** Tulu (ತುಳು)
 * @author VASANTH S.N.
 */
$messages['tcy'] = array(
	'wikiamobile-search' => 'ನಾಡ್‘ಲೆ',
	'wikiamobile-search-wiki' => 'ವಿಕಿ',
	'wikiamobile-search-wikia' => 'ವಿಕಿ',
	'wikiamobile-login' => 'ಲಾಗಿನ್ ಆಲೆ',
	'wikiamobile-password' => 'ಪಾಸ್-ವರ್ಡ್:',
	'wikiamobile-login-submit' => 'ಲಾಗ್ ಇನ್',
	'wikiamobile-menu' => 'ಮೆನು',
	'wikiamobile-explore' => 'ಹುಡುಕುಲೆ',
	'wikiamobile-article-categories' => 'ವರ್ಗೊಲು',
	'wikiamobile-feedback' => 'ಫೀಡ್ ಬ್ಯಾಕ್',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|ಜನ ಜೀವನ ವಿಧಾನ]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|ಮನರಂಜನೆ]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|ಗೊಬ್ಬುಲು]]',
);

/** Telugu (తెలుగు)
 * @author Ravichandra
 * @author Veeven
 */
$messages['te'] = array(
	'wikiamobile-search' => 'వెతుకు',
	'wikiamobile-search-wiki' => 'వికీ',
	'wikiamobile-search-wikia' => 'వికియా',
	'wikiamobile-login' => 'ప్రవేశించండి',
	'wikiamobile-password' => 'సంకేతపదం',
	'wikiamobile-login-submit' => 'ప్రవేశించు',
	'wikiamobile-menu' => 'మెనూ',
	'wikiamobile-explore' => 'అన్వేషించండి',
	'wikiamobile-article-categories' => 'వర్గాలు',
	'wikiamobile-feedback' => 'ప్రతిస్పందన',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|జీవనవిధానం]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|వినోదం]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|ఆటలు]]',
);

/** Thai (ไทย)
 * @author Akkhaporn
 */
$messages['th'] = array(
	'wikiamobile-search' => 'ค้นหา',
	'wikiamobile-search-wiki' => 'วิกิ',
	'wikiamobile-search-wikia' => 'วิเกีย',
	'wikiamobile-login' => 'ลงชื่อเข้าใช้',
	'wikiamobile-password' => 'รหัสผ่าน',
	'wikiamobile-login-submit' => 'ลงชื่อเข้าใช้',
	'wikiamobile-menu' => 'เมนู',
	'wikiamobile-explore' => 'สำรวจ',
);

/** Turkish (Türkçe)
 * @author Bilalokms
 */
$messages['tr'] = array(
	'wikiamobile-search-wiki' => 'Viki',
);

/** Simplified Chinese (‪中文（简体）‬)
 * @author Anakmalaysia
 */
$messages['zh-hans'] = array(
	'wikiamobile-search' => '搜索',
	'wikiamobile-search-wiki' => '维基',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => '登录',
	'wikiamobile-password' => '密码',
	'wikiamobile-login-submit' => '登录',
	'wikiamobile-menu' => '菜单',
	'wikiamobile-explore' => '探索',
	'wikiamobile-article-categories' => '分类',
	'wikiamobile-feedback' => '反馈',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|生活时尚]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|影音娱乐]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|电玩游戏]]',
);

/** Traditional Chinese (‪中文（繁體）‬)
 * @author Lauhenry
 */
$messages['zh-hant'] = array(
	'wikiamobile-search' => '搜尋',
	'wikiamobile-search-wiki' => '維基',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => '登入',
	'wikiamobile-password' => '密碼',
	'wikiamobile-login-submit' => '登入',
	'wikiamobile-menu' => '選單',
	'wikiamobile-explore' => '探索',
);

