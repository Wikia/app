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

/** Message documentation (Message documentation)
 * @author PtM
 * @author Shirayuki
 * @author Siebrand
 */
$messages['qqq'] = array(
	'wikiamobile-search' => 'Label on a search button placed in Mobile skin top bar',
	'wikiamobile-search-this-wiki' => 'Placeholder in input on search field',
	'wikiamobile-search-wiki' => 'Text indicating that scope for a search will be current wiki',
	'wikiamobile-search-wikia' => 'Text indicating that scope for a search will be whole wikia network',
	'wikiamobile-login' => 'Placeholder on input asking for password',
	'wikiamobile-password' => 'Placeholder on input asking for password',
	'wikiamobile-login-submit' => 'Label on a blue button prompting user to log in',
	'wikiamobile-menu' => 'Header on wiki menu',
	'wikiamobile-article-categories' => 'Message displayed on category section on an article',
	'wikiamobile-feedback' => 'Link to a feedback form',
	'wikiamobile-back' => 'Label on a button to go back one level on wiki navigation',
	'wikiamobile-hide-section' => 'Link to close section on an article that is at the end of a given section',
	'wikiamobile-profile' => 'Link to a profile page in a top wiki navigation.
{{Identical|Profile}}',
	'wikiamobile-footer-link-lifestyle' => 'Interwiki link, please translate only the last parameter after the last "|" if that makes sense',
	'wikiamobile-footer-link-entertainment' => 'Interwiki link, please translate only the last parameter after the last "|" if that makes sense',
	'wikiamobile-footer-link-videogames' => 'Interwiki link, please translate only the last parameter after the last "|" if that makes sense',
	'wikiamobile-footer-link-licencing' => 'Label for the link pointing to content licensing information',
	'mobile-full-site' => 'Link to reload a page and load desktop skin',
	'wikiamobile-categories-tagline' => 'Tagline that appears next to the category page title, please keep it really short',
	'wikiamobile-categories-items-total' => 'Message above list of articles in a category. $1 is the total number of articles in the category',
	'wikiamobile-category-items-more' => 'Label on a button to load more articles under given letter on category page',
	'wikiamobile-category-items-prev' => 'Label on a button to load previous articles under given letter on category page',
	'wikiamobile-categories-expand' => 'Label on a button to expand/collapse all articles on category.
{{Identical|Show all}}',
	'wikiamobile-categories-collapse' => 'Label on a button to expand/collapse all articles on category',
	'wikiamobile-sharing-media-image' => 'This is a message that becomes part of wikiamobile-sharing-modal-text indicating type of media shared.
{{Identical|Picture}}',
	'wikiamobile-sharing-page-text' => 'Message feed into email that have links to wiki and article that is being shared. $1 is the title of the article, $2 is the name of the wiki',
	'wikiamobile-sharing-modal-text' => 'Message feed into email that have links to wiki and media that is being shared. $1 is the type of media, $2 is the title of the article, $3 is the name of the wiki',
	'wikiamobile-sharing-email-text' => 'Email message with a shared page or media. $1 is the result of wikiamobile-sharing-modal-text or wikiamobile-sharing-page-text, please keep the empty space before $1',
	'wikiamobile-media-group-footer' => 'Caption under a media-group/gallery, $1 contains the total amount of images/videos in the group',
	'wikiamobile-unsupported-video-download' => 'Feedback message for browsers not supporting html5 videos with link to play the video in a native app (the video URL is in $1)',
	'wikiamobile-video-views-counter' => 'Counter for the number of views for a video, $1 is an integer number, minimum 0; possibly it should be no more than 1 or 2 words',
	'wikiamobile-video-not-friendly-header' => 'Friendly message on a screen with a not supported video',
	'wikiamobile-video-not-friendly' => "Message displayed in modal - to indicate that this video won't be loaded in mobile skin",
	'wikiamobile-ad-label' => 'Message shown to a user on page next to advertisement - to distinguish that below is an ad',
	'wikiamobile-image-not-loaded' => 'This is a message shown to a user when an image could not be loaded in the modal',
	'wikiamobile-shared-file-not-available' => 'Message displayed when user opens a link to particular media on an article and this media is not available anymore.',
	'wikiamobile-page-not-found' => 'Message shown to a user on 404 page; $1 is a page title that was not found. Please make sure b element wraps around $1.',
	'wikiamobile-page-not-found-tap' => 'Message that describes what to do on 404 page with an image behind the crack. Also see {{msg-wikia|wikiamobile-page-not-found}}.',
	'wikiasmartbanner-appstore' => 'Message displayed in smart banner promoting an app on app store',
	'wikiasmartbanner-googleplay' => 'Message displayed in smart banner promoting an app on google play store',
	'wikiasmartbanner-price' => 'Message displayed in smart banner indicating a price of an app.
{{Identical|Free}}',
	'wikiasmartbanner-view' => 'Message displayed in smart banner promoting on a button that leads to a store.
{{Identical|View}}',
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
);

/** Arabic (العربية)
 * @author Kuwaity26
 */
$messages['ar'] = array(
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|ألعاب الڤيديو]]',
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
);

/** Catalan (català)
 * @author Alvaro Vidal-Abarca
 * @author Gemmaa
 * @author Marcmpujol
 */
$messages['ca'] = array(
	'wikiamobile-search' => 'Cerca',
	'wikiamobile-search-this-wiki' => 'Cerca aquest viqui',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Inici de sessió',
	'wikiamobile-password' => 'Contrasenya',
	'wikiamobile-login-submit' => 'Iniciar sessió',
	'wikiamobile-menu' => 'Menú',
	'wikiamobile-article-categories' => 'Categories',
	'wikiamobile-feedback' => 'Comentaris',
	'wikiamobile-back' => 'Enrere',
	'wikiamobile-hide-section' => 'amaga',
	'wikiamobile-profile' => 'Perfil',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Estil de vida]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Entreteniment]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Videojocs]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Llicència]]',
	'mobile-full-site' => 'Lloc web complet',
	'wikiamobile-categories-tagline' => 'Pàgina de la categoria',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|article|articles}}',
	'wikiamobile-category-items-more' => 'Carrega més',
	'wikiamobile-category-items-prev' => "Carrega l'anterior",
	'wikiamobile-categories-expand' => 'Mostra-ho tot',
	'wikiamobile-categories-collapse' => 'Amaga-ho tot',
	'wikiamobile-sharing-media-image' => 'Imatge',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 a $2 - $3',
	'wikiamobile-sharing-email-text' => 'Hola,
hauries de visitar això:

 $1',
	'wikiamobile-media-group-footer' => '1 de $1',
	'wikiamobile-unsupported-video-download' => 'El teu navegador no suporta aquest format de vídeo, prova <a href="$1">aquí</a>',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|visita|visites}}',
	'wikiamobile-video-not-friendly-header' => 'Vaja!',
	'wikiamobile-video-not-friendly' => 'Ho sentim, aquest vídeo no està disponible en versió mòbil.',
	'wikiamobile-ad-label' => 'publicitat',
	'wikiamobile-image-not-loaded' => 'La imatge no està disponible',
	'wikiamobile-shared-file-not-available' => 'Ui, aquest element ja no està disponible, però ja que hi ets aquí, explora la viqui!',
	'wikiamobile-page-not-found' => 'Ui! <b>$1</b> no existeix.',
	'wikiamobile-page-not-found-tap' => "Toqueu què hi ha darrera d'aquest error per veure què l'ha provocat.",
	'wikiasmartbanner-appstore' => "A l'App Store",
	'wikiasmartbanner-googleplay' => 'A Google Play',
	'wikiasmartbanner-price' => 'gratis',
	'wikiasmartbanner-view' => 'mostra',
);

/** Czech (česky)
 * @author Michaelbrabec
 */
$messages['cs'] = array(
	'wikiamobile-profile' => 'Profil',
	'wikiamobile-categories-tagline' => 'Stránka Kategorie',
	'wikiamobile-media-group-footer' => '1 z $1',
	'wikiamobile-unsupported-video-download' => 'Váš prohlížeč nepodporuje formát tohoto videa. Zkuste kliknout <a href="$1">sem</a>',
	'wikiamobile-video-not-friendly' => 'Omlouváme se, toto video není dostupné na mobilním telefonu.',
	'wikiamobile-ad-label' => 'reklama',
	'wikiamobile-page-not-found' => 'Jejda! <b>$1</b> neexistuje.',
	'wikiasmartbanner-googleplay' => 'Na Google Play',
	'wikiasmartbanner-price' => 'zdarma',
	'wikiasmartbanner-view' => 'zobrazit',
);

/** German (Deutsch)
 * @author Avatar
 * @author Geitost
 * @author Inkowik
 * @author Kghbln
 * @author Metalhead64
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
	'wikiamobile-article-categories' => 'Kategorien',
	'wikiamobile-feedback' => 'Rückmeldung',
	'wikiamobile-back' => 'Zurück',
	'wikiamobile-hide-section' => 'ausblenden',
	'wikiamobile-profile' => 'Profil',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Lifestyle]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Unterhaltung]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Videospiele]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Lizenzierung]]',
	'mobile-full-site' => 'Vollständige Website',
	'wikiamobile-categories-tagline' => 'Kategorieseite',
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
	'wikiamobile-media-group-footer' => '1 von $1',
	'wikiamobile-unsupported-video-download' => 'Dein Browser unterstützt dieses Videoformat nicht. Versuche, <a href="$1">hier</a> zu klicken.',
	'wikiamobile-video-views-counter' => '{{PLURAL:$1|Ein Aufruf|$1 Aufrufe}}',
	'wikiamobile-video-not-friendly-header' => 'Verdammt!',
	'wikiamobile-video-not-friendly' => 'Dieses Video ist auf mobilen Geräten leider nicht verfügbar.',
	'wikiamobile-ad-label' => 'Anzeige',
	'wikiamobile-image-not-loaded' => 'Das Bild ist nicht verfügbar',
	'wikiamobile-shared-file-not-available' => 'Huch! Dieses Objekt ist nicht mehr verfügbar. Aber jetzt wo du gerade hier bist, entdecke das Wiki!',
	'wikiamobile-page-not-found' => 'Huch! <b>$1</b> ist nicht vorhanden.',
	'wikiamobile-page-not-found-tap' => 'Tippe, was sich hinter dem Sprung verbirgt, um eines zu sehen, das funktioniert.',
	'wikiasmartbanner-appstore' => 'Im App Store',
	'wikiasmartbanner-googleplay' => 'In Google Play',
	'wikiasmartbanner-price' => 'kostenlos',
	'wikiasmartbanner-view' => 'ansehen',
);

/** German (formal address) (Deutsch (Sie-Form)‎)
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
	'wikiamobile-article-categories' => 'Kategoriy',
	'wikiamobile-feedback' => 'Peydrıstış',
	'wikiamobile-back' => 'Peyd bê',
	'wikiamobile-hide-section' => 'bınımne',
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
	'wikiamobile-article-categories' => 'Categorías',
	'wikiamobile-feedback' => 'Sugerencias',
	'wikiamobile-back' => 'Atrás',
	'wikiamobile-hide-section' => 'ocultar',
	'wikiamobile-profile' => 'Perfil',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Estilo de vida]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Entretenimiento]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Videojuegos]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Licencias]]',
	'mobile-full-site' => 'Sitio completo',
	'wikiamobile-categories-tagline' => 'Página de categoría',
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
	'wikiamobile-media-group-footer' => '1 de $1',
	'wikiamobile-unsupported-video-download' => 'Tu navegador no soporta este formato de video, prueba <a href="$1">aquí</a>',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|vista|vistas}}',
	'wikiamobile-video-not-friendly-header' => '¡Oh, vaya!',
	'wikiamobile-video-not-friendly' => 'Lo sentimos, este video no está disponible para la versión móvil.',
	'wikiamobile-ad-label' => 'anuncio',
	'wikiamobile-image-not-loaded' => 'Imagen no disponible',
	'wikiamobile-shared-file-not-available' => 'Vaya, este artículo ya no está disponible, pero ya que estás aquí, ¡explora el wiki!',
	'wikiamobile-page-not-found' => '¡Vaya! <b>$1</b> no existe.',
	'wikiamobile-page-not-found-tap' => 'Pulsa lo que se esconde detrás de la grieta para ver lo que hace.',
	'wikiasmartbanner-appstore' => 'En la App Store',
	'wikiasmartbanner-googleplay' => 'En Google Play',
	'wikiasmartbanner-price' => 'gratis',
	'wikiasmartbanner-view' => 'ver',
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
	'wikiamobile-article-categories' => 'Luokat',
	'wikiamobile-feedback' => 'Palaute',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Elämäntyyli]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Viihde]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Pelaaminen]]',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'wikiamobile-search' => 'Leita',
	'wikiamobile-search-this-wiki' => 'Leita á hesi wiki',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => 'Rita inn',
	'wikiamobile-password' => 'Loyniorð',
	'wikiamobile-login-submit' => 'Rita inn',
	'wikiamobile-menu' => 'Meny',
	'wikiamobile-article-categories' => 'Bólkar',
	'wikiamobile-feedback' => 'Afturmelding',
	'wikiamobile-back' => 'Aftur',
	'wikiamobile-hide-section' => 'fjal',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Lívsstílur]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Undirhald]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Videospøl]]',
	'mobile-full-site' => 'Full síða',
	'wikiamobile-categories-tagline' => 'Bólkasíða',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|grein|greinar}}',
	'wikiamobile-category-items-more' => 'Innles meira',
	'wikiamobile-category-items-prev' => 'Innles tað fyrra',
	'wikiamobile-categories-expand' => 'Vís alt',
	'wikiamobile-categories-collapse' => 'Fjal alt',
	'wikiamobile-sharing-media-image' => 'Mynd',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 á $2 - $3',
	'wikiamobile-sharing-email-text' => 'Hey,
tú burdi heilt sikkurt hugt eftir hesum:

 $1',
	'wikiamobile-media-group-footer' => '1 av $1',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|sýning|sýningar}}',
	'wikiamobile-image-not-loaded' => 'Myndin er ikki tøk',
	'wikiasmartbanner-appstore' => 'Í App Store',
	'wikiasmartbanner-googleplay' => 'Í Google Play',
	'wikiasmartbanner-price' => 'ókeypis',
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
	'wikiamobile-article-categories' => 'Catégories',
	'wikiamobile-feedback' => 'Avis',
	'wikiamobile-back' => 'Retour',
	'wikiamobile-hide-section' => 'masquer',
	'wikiamobile-profile' => 'Profil',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Mode de vie]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Divertissement]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Jeux vidéo]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Licence]]',
	'mobile-full-site' => 'Site complet',
	'wikiamobile-categories-tagline' => 'Page de catégorie',
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
	'wikiamobile-media-group-footer' => '1 sur $1',
	'wikiamobile-unsupported-video-download' => 'Vore navigateur ne supporte pas ce format de vidéo, essayez en cliquant <a href="$1">ici</a>',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|vue|vues}}',
	'wikiamobile-video-not-friendly-header' => 'Crac !',
	'wikiamobile-video-not-friendly' => 'Désolé, cette vidéo n’est pas disponible sur mobile.',
	'wikiamobile-ad-label' => 'publicité',
	'wikiamobile-image-not-loaded' => 'L’image n’est pas disponible',
	'wikiamobile-shared-file-not-available' => 'Oups, cet élément n’est plus disponible ; mais vu que vous êtes ici, explorez le wiki !',
	'wikiamobile-page-not-found' => 'Oups ! <b>$1</b> n’existe pas.',
	'wikiamobile-page-not-found-tap' => 'Tapotez ce qui se cache derrière la fissure pour voir un article qui existe.',
	'wikiasmartbanner-appstore' => "Sur l'App Store",
	'wikiasmartbanner-googleplay' => 'Dans Google Play',
	'wikiasmartbanner-price' => 'gratuit',
	'wikiasmartbanner-view' => 'afficher',
);

/** Galician (galego)
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
	'wikiamobile-article-categories' => 'Categorías',
	'wikiamobile-feedback' => 'Comentarios',
	'wikiamobile-back' => 'Volver',
	'wikiamobile-hide-section' => 'agochar',
	'wikiamobile-profile' => 'Perfil',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Estilo de vida]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Lecer]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Xogos]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Licenza]]',
	'mobile-full-site' => 'Sitio completo',
	'wikiamobile-categories-tagline' => 'Páxina de categoría',
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
	'wikiamobile-media-group-footer' => '1 de $1',
	'wikiamobile-unsupported-video-download' => 'O seu navegador non soporta este formato de vídeo; probe premendo <a href="$1">aquí</a>',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|vista|vistas}}',
	'wikiamobile-video-not-friendly-header' => 'Vaites!',
	'wikiamobile-video-not-friendly' => 'Sentímolo, este vídeo non está dispoñible para o móbil.',
	'wikiamobile-ad-label' => 'anuncio',
	'wikiamobile-image-not-loaded' => 'A imaxe non está dispoñible',
	'wikiamobile-shared-file-not-available' => 'Vaites! Este elemento xa non está dispoñible. Pero agora que está aquí, explore o wiki!',
	'wikiamobile-page-not-found' => 'Vaites! "<b>$1</b>" non existe.',
	'wikiamobile-page-not-found-tap' => 'Prema no que hai detrás deste erro para ver a súa orixe.',
	'wikiasmartbanner-appstore' => 'Na tenda de aplicacións',
	'wikiasmartbanner-googleplay' => 'No Google Play',
	'wikiasmartbanner-price' => 'gratuíta',
	'wikiasmartbanner-view' => 'ver',
);

/** Manx (Gaelg)
 * @author Shimmin Beg
 */
$messages['gv'] = array(
	'wikiamobile-media-group-footer' => '1 jeh $1',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|keayrt|cheayrt|cheayrt|keayrtyn}}', # Fuzzy
	'wikiamobile-video-not-friendly-header' => 'Atreih!',
	'wikiamobile-video-not-friendly' => 'Do-gheddyn er jeshaght hooylagh',
	'wikiamobile-ad-label' => 'soilsheen',
	'wikiamobile-shared-file-not-available' => 'Cha nel y mean shoh ry-gheddyn foast, atreih, agh failt ort dy wandrail trooid y wiki!',
	'wikiasmartbanner-appstore' => "'Sy Çhapp Appyn",
	'wikiasmartbanner-price' => 'nastee',
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
	'wikiamobile-article-categories' => 'קטגוריות',
	'wikiamobile-feedback' => 'משוב',
	'wikiamobile-back' => 'חזרה',
	'wikiamobile-hide-section' => 'הסתר',
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
	'wikiamobile-article-categories' => 'Categorias',
	'wikiamobile-feedback' => 'Commentario',
	'wikiamobile-back' => 'Retro',
	'wikiamobile-hide-section' => 'celar',
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
	'wikiamobile-article-categories' => 'ವರ್ಗಗಳು',
	'wikiamobile-feedback' => 'ಮರುಮಾಹಿತಿ',
	'wikiamobile-back' => 'ಹಿಂದಕ್ಕೆ',
	'wikiamobile-hide-section' => 'ಅಡಗಿಸು',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|ಮನರಂಜನೆ]]',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
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
	'wikiamobile-profile' => 'Profil',
	'wikiamobile-categories-tagline' => 'Säit vun der Kategorie',
	'wikiamobile-media-group-footer' => '1 vu(n) $1',
	'wikiamobile-video-not-friendly-header' => 'Oh merde!',
	'wikiamobile-video-not-friendly' => 'Pardon, dëse Video ass op mobilen Apparater net disponibel.',
	'wikiamobile-ad-label' => 'Reklamm',
	'wikiamobile-page-not-found' => 'Ups! <b>$1</b> gëtt et net.',
	'wikiasmartbanner-appstore' => 'Am App Store',
	'wikiasmartbanner-price' => 'fräi',
	'wikiasmartbanner-view' => 'weisen',
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
	'wikiamobile-article-categories' => 'Категории',
	'wikiamobile-feedback' => 'Мислења',
	'wikiamobile-back' => 'Назад',
	'wikiamobile-hide-section' => 'скриј',
	'wikiamobile-profile' => 'Профил',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Животен стил]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Забава]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Игри]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Лиценцирање]]',
	'mobile-full-site' => 'Полн портал',
	'wikiamobile-categories-tagline' => 'Категориска страница',
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
	'wikiamobile-media-group-footer' => '1 од $1',
	'wikiamobile-unsupported-video-download' => 'Вашиот прелистувач не го поддржува овој видеоформат. Обидете се <a href="$1">тука</a>',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|преглед|прегледи}}',
	'wikiamobile-video-not-friendly-header' => 'По ѓаволите!',
	'wikiamobile-video-not-friendly' => 'Нажалост, видеото не е достапно за мобилен уред.',
	'wikiamobile-ad-label' => 'реклама',
	'wikiamobile-image-not-loaded' => 'Сликата не е достапна',
	'wikiamobile-shared-file-not-available' => 'Упс! Објектот повеќе не е достапен. Но, штом сте веќе тука, повелете, истражете го викито!',
	'wikiamobile-page-not-found' => 'Упс! <b>$1</b> не постои.',
	'wikiamobile-page-not-found-tap' => 'Тапнете го она што се крие зад пукнатината за да видите еден што работи.',
	'wikiasmartbanner-appstore' => 'Во дуќанот за прилози',
	'wikiasmartbanner-googleplay' => 'На Google Play',
	'wikiasmartbanner-price' => 'бесплатно',
	'wikiasmartbanner-view' => 'погледајте',
);

/** Malayalam (മലയാളം)
 * @author Kavya Manohar
 */
$messages['ml'] = array(
	'wikiasmartbanner-view' => 'കാണുക',
);

/** Marathi (मराठी)
 * @author V.narsikar
 */
$messages['mr'] = array(
	'wikiamobile-categories-tagline' => 'वर्ग पान',
	'wikiamobile-media-group-footer' => ' $1 पैकी १',
	'wikiamobile-unsupported-video-download' => 'आपला न्याहाळक या माध्यमाच्या फॉरमॅटला सहाय्य करीत नाही, <a href="$1">येथे</a> टिचकून बघा',
	'wikiamobile-video-not-friendly' => 'माफ करा,हा व्हीडिओ भ्रमणध्वनीवर उपलब्ध नाही.',
	'wikiamobile-ad-label' => 'जाहिरात',
	'wikiamobile-shared-file-not-available' => 'अरेच्चा, ही बाब उपलब्ध नाही, आपण येथे आलाच आहात तर, विकिवर शोधा!',
	'wikiamobile-page-not-found' => 'अरेच्चा!<b>$1</b> अस्तित्वात नाही.',
	'wikiasmartbanner-googleplay' => "'गूगल प्ले' मध्ये",
	'wikiasmartbanner-price' => 'मुक्त',
	'wikiasmartbanner-view' => 'पहा',
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
	'wikiamobile-article-categories' => 'Kategori',
	'wikiamobile-feedback' => 'Maklum balas',
	'wikiamobile-back' => 'Kembali',
	'wikiamobile-hide-section' => 'sorokkan',
	'wikiamobile-profile' => 'Profil',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Gaya Hidup]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Hiburan]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Permainan]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Pelesenan]]',
	'mobile-full-site' => 'Laman penuh',
	'wikiamobile-categories-tagline' => 'Halaman Kategori',
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
	'wikiamobile-media-group-footer' => '1/$1',
	'wikiamobile-unsupported-video-download' => 'Pelayar anda tidak menyokong format video ini; cuba klik di <a href="$1">sini</a>',
	'wikiamobile-video-views-counter' => 'Dilihat $1 kali',
	'wikiamobile-video-not-friendly-header' => 'Maaf!',
	'wikiamobile-video-not-friendly' => 'Video ini tidak boleh ditonton secara mudah alih.',
	'wikiamobile-ad-label' => 'iklan',
	'wikiamobile-image-not-loaded' => 'Gambar tidak tersedia',
	'wikiamobile-shared-file-not-available' => 'Maaf, perkara ini tidak lagi wujud, tetapi memandangkan anda berada di sini, terokailah wiki ini!',
	'wikiamobile-page-not-found' => 'Maaf! <b>$1</b> tidak wujud.',
	'wikiamobile-page-not-found-tap' => 'Ketik apa yang menyorok di sebalik retakan untuk melihatnya.',
	'wikiasmartbanner-appstore' => 'Di App Store',
	'wikiasmartbanner-googleplay' => 'Di Google Play',
	'wikiasmartbanner-price' => 'percuma',
	'wikiasmartbanner-view' => 'lihat',
);

/** Norwegian Bokmål (norsk bokmål)
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
	'wikiamobile-article-categories' => 'Kategorier',
	'wikiamobile-feedback' => 'Tilbakemelding',
	'wikiamobile-back' => 'Tilbake',
	'wikiamobile-hide-section' => 'skjul',
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
);

/** Dutch (Nederlands)
 * @author AvatarTeam
 * @author Bereisgreat
 * @author Hansmuller
 * @author Jochempluim
 * @author SPQRobin
 * @author Siebrand
 * @author Southparkfan
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
	'wikiamobile-article-categories' => 'Categorieën',
	'wikiamobile-feedback' => 'Terugkoppeling',
	'wikiamobile-back' => 'Terug',
	'wikiamobile-hide-section' => 'verbergen',
	'wikiamobile-profile' => 'Profiel',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Lifestyle]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Vermaak]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Video Games]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Licensering]]',
	'mobile-full-site' => 'Hele site',
	'wikiamobile-categories-tagline' => 'Categoriepagina',
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
	'wikiamobile-media-group-footer' => '1 van $1',
	'wikiamobile-unsupported-video-download' => 'Je browser ondersteunt dit videoformaat niet. Probeer <a href="$1">deze link</a>.',
	'wikiamobile-video-views-counter' => '{{PLURAL:$1|1 keer|$1 keer}} bekeken',
	'wikiamobile-video-not-friendly-header' => 'Verdorie!',
	'wikiamobile-video-not-friendly' => 'Deze video is helaas niet beschikbaar voor mobiel...',
	'wikiamobile-ad-label' => 'advertentie',
	'wikiamobile-image-not-loaded' => 'Afbeelding is niet beschikbaar',
	'wikiamobile-shared-file-not-available' => 'Dit item is niet langer beschikbaar. Maar nu u er toch bent, verken vooral de wiki!',
	'wikiamobile-page-not-found' => 'Oeps! <b>$1</b> bestaat niet.',
	'wikiamobile-page-not-found-tap' => 'Klik op hetgeen dat zich achter de spleet verbergt om te zien wat het doet.',
	'wikiasmartbanner-appstore' => 'In de App Store',
	'wikiasmartbanner-googleplay' => 'In Google Play',
	'wikiasmartbanner-price' => 'gratis',
	'wikiasmartbanner-view' => 'bekijken',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Faren
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
	'wikiamobile-article-categories' => 'Kategorie',
	'wikiamobile-feedback' => 'Opinie',
	'wikiamobile-back' => 'Wstecz',
	'wikiamobile-hide-section' => 'ukryj',
	'wikiamobile-profile' => 'Profil',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Lifestyle]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Rozrywka]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Gry]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Licencja]]',
	'mobile-full-site' => 'Pełna strona',
	'wikiamobile-categories-tagline' => 'Strona kategorii',
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
	'wikiamobile-media-group-footer' => '1 z $1',
	'wikiamobile-unsupported-video-download' => 'Twoja przeglądarka nie obsługuje tego formatu, spróbuj <a href="$1">tutaj</a>',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|odwiedziny|odwiedzin}}',
	'wikiamobile-video-not-friendly-header' => 'Ups!',
	'wikiamobile-video-not-friendly' => 'Ten film nie jest dostępny w wersji mobilnej.',
	'wikiamobile-ad-label' => 'reklama',
	'wikiamobile-image-not-loaded' => 'Obraz nie jest dostępny',
	'wikiamobile-shared-file-not-available' => 'Oj, ten element nie jest już dostępny, ale skoro już tutaj jesteś, eksploruj wiki!',
	'wikiamobile-page-not-found' => 'Oj! <b>$1</b> nie istnieje.',
	'wikiamobile-page-not-found-tap' => 'Przejdź na inną stronę klikając za pęknięciem.',
	'wikiasmartbanner-appstore' => 'W App Store',
	'wikiasmartbanner-googleplay' => 'W Google Play',
	'wikiasmartbanner-price' => 'za darmo',
	'wikiasmartbanner-view' => 'pokaż',
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
);

/** Portuguese (português)
 * @author Luckas
 * @author Malafaya
 */
$messages['pt'] = array(
	'wikiamobile-search' => 'Pesquisar',
	'wikiamobile-search-wiki' => 'Wiki',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-password' => 'Senha',
	'wikiamobile-menu' => 'Menu',
	'wikiamobile-article-categories' => 'Categorias',
	'wikiamobile-back' => 'Voltar',
	'wikiamobile-profile' => 'Perfil',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|artigo|artigos}}',
	'wikiamobile-category-items-more' => 'Carregar mais',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-media-group-footer' => '1 de $1',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Caio1478
 * @author Luckas
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
	'wikiamobile-article-categories' => 'Categorias',
	'wikiamobile-feedback' => 'Feedback',
	'wikiamobile-back' => 'Voltar',
	'wikiamobile-hide-section' => 'esconder',
	'wikiamobile-profile' => 'Perfil',
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
	'wikiasmartbanner-view' => 'ver',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'wikiamobile-search' => 'Cirche',
	'wikiamobile-search-this-wiki' => 'Cirche sta uicchi',
	'wikiamobile-search-wiki' => 'Uicchi',
	'wikiamobile-search-wikia' => 'Uicchia',
	'wikiamobile-login' => 'Tràse',
	'wikiamobile-password' => 'Passuord',
	'wikiamobile-login-submit' => 'Tràse',
	'wikiamobile-menu' => 'Menù',
	'wikiamobile-article-categories' => 'Categorije',
	'wikiamobile-feedback' => 'Segnalazione',
	'wikiamobile-back' => 'Rrete',
	'wikiamobile-hide-section' => 'scunne',
	'wikiamobile-profile' => 'Profile',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Stile de vite]]',
	'wikiamobile-footer-link-entertainment' => "[[w:c:www:Entertainment|'Ndrattenimende]]",
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Video Sciuèche]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Licenze]]',
	'mobile-full-site' => 'Site comblete',
	'wikiamobile-categories-tagline' => "Pàgene d'a categorije",
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|vôsce}}',
	'wikiamobile-category-items-more' => 'Careche le otre',
	'wikiamobile-category-items-prev' => "Careche 'u precedende",
	'wikiamobile-categories-expand' => 'Fà vedè tutte',
	'wikiamobile-categories-collapse' => 'Scunne tutte',
	'wikiamobile-sharing-media-image' => 'Fote',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 sus a $2 - $3',
	'wikiamobile-sharing-email-text' => 'Uè,
Tu avissa verificà definitivamende quiste:

 $1',
	'wikiamobile-media-group-footer' => '1 de $1',
	'wikiamobile-unsupported-video-download' => '\'U browser tune non ge supporte stu formate de video, pruève cazzanne <a href="$1">aqquà</a>',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|visite}}',
	'wikiamobile-video-not-friendly-header' => "Oh 'u scatte!",
	'wikiamobile-video-not-friendly' => "Ne despiace, stu video non g'è disponibbile sus a 'u mobile.",
	'wikiamobile-ad-label' => 'pubblecetà',
	'wikiamobile-image-not-loaded' => 'Immaggine non disponibbile',
	'wikiamobile-shared-file-not-available' => "Uè, sta vôsce non g'è cchiù disponibbile, ma mò ca tu si aqquà, navighe sus a sta uicchi!",
	'wikiamobile-page-not-found' => "Uè! <b>$1</b> non g'esiste.",
	'wikiamobile-page-not-found-tap' => "Cazze pe 'ndrucà quidde ca succede sotte 'u crack pe 'ndrucà quidde ca face",
	'wikiasmartbanner-appstore' => "Sus a 'u Negozie de le App",
	'wikiasmartbanner-googleplay' => "Jndr'à Google Play",
	'wikiasmartbanner-price' => 'libbere',
	'wikiasmartbanner-view' => "'ndruche",
);

/** Russian (русский)
 * @author Express2000
 * @author Kuzura
 * @author Lvova
 * @author Okras
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
	'wikiamobile-article-categories' => 'Категории',
	'wikiamobile-feedback' => 'Отзыв',
	'wikiamobile-back' => 'Назад',
	'wikiamobile-hide-section' => 'скрыть',
	'wikiamobile-profile' => 'Профиль',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Увлечения]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Кино и сериалы]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Игры]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Лицензирование]]',
	'mobile-full-site' => 'Весь сайт',
	'wikiamobile-categories-tagline' => 'Страница категорий',
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
	'wikiamobile-media-group-footer' => '1 из $1',
	'wikiamobile-unsupported-video-download' => 'Ваш браузер не поддерживает этот формат видео, попробуйте нажать <a href="$1">здесь</a>',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|просмотр|просмотра|просмотров}}',
	'wikiamobile-video-not-friendly-header' => 'Вот чёрт!',
	'wikiamobile-video-not-friendly' => 'К сожалению, это видео не доступно на мобильном устройстве.',
	'wikiamobile-ad-label' => 'реклама',
	'wikiamobile-image-not-loaded' => 'Изображение недоступно',
	'wikiamobile-shared-file-not-available' => 'Ой, этот элемент больше не доступен, но раз уж вы здесь, исследуйте проект!',
	'wikiamobile-page-not-found' => 'Ой! <b>$1</b> не существует.',
	'wikiamobile-page-not-found-tap' => 'Нажмите на, что скрывается за трещиной, чтобы увидеть то, что существует.',
	'wikiasmartbanner-appstore' => 'В App Store',
	'wikiasmartbanner-googleplay' => 'В Google Play',
	'wikiasmartbanner-price' => 'бесплатно',
	'wikiasmartbanner-view' => 'смотреть',
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
	'wikiamobile-feedback' => 'Spätná väzba',
	'wikiamobile-back' => 'Späť',
	'wikiamobile-category-items-more' => 'Načítať viac',
	'wikiamobile-category-items-prev' => 'Načítať predchádzajúce',
	'wikiamobile-categories-expand' => 'Zobraziť všetko',
	'wikiamobile-categories-collapse' => 'Skryť všetko',
	'wikiamobile-sharing-media-image' => 'Obrázok',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
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
	'wikiamobile-article-categories' => 'Kategorier',
	'wikiamobile-feedback' => 'Feedback',
	'wikiamobile-back' => 'Tillbaka',
	'wikiamobile-hide-section' => 'dölj',
	'wikiamobile-profile' => 'Profil',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Livsstil]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Underhållning]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Spel]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Licensiering]]',
	'mobile-full-site' => 'Fullständig sida',
	'wikiamobile-categories-tagline' => 'Kategorisida',
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
	'wikiamobile-media-group-footer' => '1 av $1',
	'wikiamobile-unsupported-video-download' => 'Din webbläsare stöder inte detta videoformat. Prova att klicka <a href="$1">här</a>',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|visning|visningar}}',
	'wikiamobile-video-not-friendly-header' => 'Attans!',
	'wikiamobile-video-not-friendly' => 'Tyvärr, detta videoklipp är inte tillgänglig för mobiler.',
	'wikiamobile-ad-label' => 'annons',
	'wikiamobile-image-not-loaded' => 'Bilden är inte tillgänglig',
	'wikiamobile-shared-file-not-available' => 'Hoppsan, detta objekt finns inte tillgängligt längre, men nu när du är här kan du utforska wikin!',
	'wikiamobile-page-not-found' => 'Hoppsan! <b>$1</b> finns inte.',
	'wikiamobile-page-not-found-tap' => 'Peka på det som gömmer sig bakom sprickan för att se någonting som finns.',
	'wikiasmartbanner-appstore' => 'På App Store',
	'wikiasmartbanner-googleplay' => 'På Google Play',
	'wikiasmartbanner-price' => 'gratis',
	'wikiasmartbanner-view' => 'visa',
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
);

/** Turkish (Türkçe)
 * @author Bilalokms
 * @author Talha Samil Cakir
 */
$messages['tr'] = array(
	'wikiamobile-search' => 'Ara',
	'wikiamobile-search-wiki' => 'Viki',
	'wikiamobile-login' => 'Giriş',
	'wikiamobile-menu' => 'Menü',
	'wikiamobile-article-categories' => 'Kategoriler',
	'wikiamobile-back' => 'Geri',
	'wikiamobile-hide-section' => 'gizle',
	'wikiamobile-categories-tagline' => 'Kategori Sayfası',
	'wikiamobile-categories-expand' => 'Hepsini Göster',
	'wikiamobile-categories-collapse' => 'Tümünü Gizle',
	'wikiamobile-sharing-media-image' => 'Resim',
	'wikiamobile-ad-label' => 'reklam',
	'wikiasmartbanner-price' => 'ücretsiz',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Ua2004
 */
$messages['uk'] = array(
	'wikiamobile-search' => 'Пошук',
	'wikiamobile-search-this-wiki' => 'Пошук у цій вікі',
	'wikiamobile-search-wiki' => 'Вікі',
	'wikiamobile-search-wikia' => 'Вікія',
	'wikiamobile-login' => 'Увійти',
	'wikiamobile-password' => 'Пароль',
	'wikiamobile-login-submit' => 'Увійти',
	'wikiamobile-menu' => 'Меню',
	'wikiamobile-article-categories' => 'Категорії',
	'wikiamobile-feedback' => "Зворотний зв'язок",
	'wikiamobile-back' => 'Назад',
	'wikiamobile-hide-section' => 'сховати',
	'wikiamobile-profile' => 'Профіль',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|Спосіб життя]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|Розваги]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|Відеоігри]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|Ліцензування]]',
	'mobile-full-site' => 'Повний сайт',
	'wikiamobile-categories-tagline' => 'Сторінка категорії',
	'wikiamobile-categories-items-total' => '$1 {{PLURAL:$1|стаття|статті|статей}}',
	'wikiamobile-category-items-more' => 'Завантажити більше',
	'wikiamobile-category-items-prev' => 'Завантажити попередні',
	'wikiamobile-categories-expand' => 'Показати усі',
	'wikiamobile-categories-collapse' => 'Приховати всі',
	'wikiamobile-sharing-media-image' => 'Зображення',
	'wikiamobile-sharing-page-text' => '$1 - $2',
	'wikiamobile-sharing-modal-text' => '$1 у $2 - $3',
	'wikiamobile-sharing-email-text' => "Привіт,
 ви повинні обов'язково перевірити це:

$1",
	'wikiamobile-media-group-footer' => '1 з $1',
	'wikiamobile-unsupported-video-download' => 'Ваш браузер не підтримує цей формат відео, спробуйте натиснути <a href="<span class=" notranslate"="" translate="no">$1 "> тут</a>',
	'wikiamobile-video-views-counter' => '$1 {{PLURAL:$1|перегляд|перегляди|переглядів}}',
	'wikiamobile-video-not-friendly-header' => 'Йой, провал!',
	'wikiamobile-video-not-friendly' => 'На жаль, це відео недоступне на мобільному телефоні.',
	'wikiamobile-ad-label' => 'реклама',
	'wikiamobile-image-not-loaded' => 'Зображення недоступне',
	'wikiamobile-shared-file-not-available' => 'На жаль, цей пункт вже недоступний, але тепер, коли ви тут, досліджуйте вікі!',
	'wikiamobile-page-not-found' => 'На жаль! <b> $1 </b> не існує.',
	'wikiamobile-page-not-found-tap' => 'Натисніть на приховане, щоб побачити, що робиться.',
	'wikiasmartbanner-appstore' => 'На App Store',
	'wikiasmartbanner-googleplay' => 'У Google Play',
	'wikiasmartbanner-price' => 'Безкоштовно',
	'wikiasmartbanner-view' => 'перегляд',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Anakmalaysia
 * @author Liuxinyu970226
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'wikiamobile-search' => '搜索',
	'wikiamobile-search-this-wiki' => '搜索此维基',
	'wikiamobile-search-wiki' => '维基',
	'wikiamobile-search-wikia' => 'Wikia',
	'wikiamobile-login' => '登录',
	'wikiamobile-password' => '密码',
	'wikiamobile-login-submit' => '登录',
	'wikiamobile-menu' => '菜单',
	'wikiamobile-article-categories' => '分类',
	'wikiamobile-feedback' => '反馈',
	'wikiamobile-back' => '返回',
	'wikiamobile-hide-section' => '隐藏',
	'wikiamobile-profile' => '个人资料',
	'wikiamobile-footer-link-lifestyle' => '[[w:c:www:Lifestyle|生活时尚]]',
	'wikiamobile-footer-link-entertainment' => '[[w:c:www:Entertainment|影音娱乐]]',
	'wikiamobile-footer-link-videogames' => '[[w:c:www:Video_Games|电玩游戏]]',
	'wikiamobile-footer-link-licencing' => '[[w:Wikia:Licensing|授权]]',
	'mobile-full-site' => '完整站点',
	'wikiamobile-categories-tagline' => '分类页面',
	'wikiamobile-categories-items-total' => '$1个{{PLURAL:$1|条目|条目}}',
	'wikiamobile-category-items-more' => '载入更多',
	'wikiamobile-category-items-prev' => '加载上次',
	'wikiamobile-categories-expand' => '显示全部',
	'wikiamobile-categories-collapse' => '隐藏全部',
	'wikiamobile-sharing-media-image' => '图片',
	'wikiamobile-sharing-page-text' => '$1-$2',
	'wikiamobile-sharing-modal-text' => '$1在$2-$3',
	'wikiamobile-sharing-email-text' => '嗨，
您应该检查一下这些：

$1',
	'wikiamobile-media-group-footer' => '$1的1',
	'wikiamobile-video-views-counter' => '$1次{{PLURAL:$1|浏览|浏览}}',
	'wikiamobile-video-not-friendly-header' => '哦买糕的！',
	'wikiamobile-ad-label' => '广告',
	'wikiamobile-image-not-loaded' => '图像不可用',
	'wikiasmartbanner-appstore' => 'App Store',
	'wikiasmartbanner-googleplay' => 'Google Play',
	'wikiasmartbanner-price' => '自由',
	'wikiasmartbanner-view' => '查看',
);

/** Traditional Chinese (中文（繁體）‎)
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
);
