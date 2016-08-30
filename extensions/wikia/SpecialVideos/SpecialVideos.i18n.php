<?php
/**
 * Internationalisation file for the SpecialVideos extension.
 *
 * @addtogroup Languages
 */

$messages = [];

$messages['en'] = [
	'videos' => 'Videos',
	'specialvideos-desc' => 'Implements [[Special:Videos]]',
	'specialvideos-html-title' => 'Videos on this wiki',
	'specialvideos-page-title' => 'Videos',
	'specialvideos-wiki-videos-tally' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|video on<br /> this wiki|videos on<br /> this wiki}}</span>',
	'specialvideos-sort-by' => 'Sort by',
	'specialvideos-sort-latest' => 'Latest',
	'specialvideos-sort-most-popular' => 'Most Popular',
	'specialvideos-sort-trending' => 'Trending',
	'specialvideos-sort-featured' => 'Source: Wikia Library',
	'specialvideos-uploadby' => 'by $1',
	'specialvideos-posted-in' => 'Posted in $1',
	'special-videos-add-video' => 'Add a Video',
	'specialvideos-meta-description-gaming' => '$1 has new videos that include the latest walk throughs, game reviews, game guides and game trailers. Watch now!',
	'specialvideos-meta-description-entertainment' => '$1 has new videos that include the latest TV clips, movie trailers, music videos, actor interviews and episodes. Watch now!',
	'specialvideos-meta-description-lifestyle' => '$1 has new videos that include how to videos, travel guides, cooking shows, recipe and crafting videos. Watch now!',
	'specialvideos-meta-description-corporate' => '$1 has new videos that include the latest video clips, video reviews, video interviews and trailers. Watch now!',
	'specialvideos-remove-modal-title' => 'Delete video',
	'specialvideos-remove-modal-message' => 'Are you sure you want to delete this video from your wiki?',
	'specialvideos-no-videos' => 'Sorry, there are no videos on {{SITENAME}} yet, but you can add one from the desktop site.',
	'specialvideos-filter-games' => 'Trending in Games',
	'specialvideos-filter-lifestyle' => 'Trending in Lifestyle',
	'specialvideos-filter-entertainment' => 'Trending in Entertainment',
	'specialvideos-btn-load-more' => 'Load More',
	'specialvideos-posted-in-label' => 'Posted in',
	'related-videos-tooltip-add' => 'Add a video to this wiki',
	'right-specialvideosdelete' => 'Can delete videos',
	'right-videoupload' => 'Can upload videos',
];

$messages['qqq'] = [
	'videos' => 'This is the feature name that shows up in the Wiki Nav menu bar when the Extension is enabled',
	'specialvideos-desc' => '{{desc}}',
	'specialvideos-html-title' => 'This is the page title for the Special:Videos page',
	'specialvideos-page-title' => 'This is the h1 (header) text for the Special:Videos page',
	'specialvideos-wiki-videos-tally' => 'This text displays the number of videos on a wiki',
	'specialvideos-sort-by' => 'Label text for the dropdown with the options on how to sort the videos displayed on Special:Videos',
	'specialvideos-sort-latest' => 'Dropdown option to sort videos by most recent first in Special:Videos.',
	'specialvideos-sort-most-popular' => 'Dropdown option to sort videos by most viewed first in Special:Videos.',
	'specialvideos-sort-trending' => 'Dropdown option to sort videos by the videos that are currently trending (i.e. most viewed in the last 30 days) in Special:Videos.',
	'specialvideos-sort-featured' => 'Dropdown option to filter videos by premium, wiki-library sourced, videos in Special:Videos.',
	'specialvideos-uploadby' => 'text displayed below a video to indicate which user uploaded the video',
	'specialvideos-posted-in' => 'text displayed below a video to indicate which articles the video is posted in.  Can be a truncated list.',
	'special-videos-add-video' => 'Button text to click to add a video to a wiki.',
	'specialvideos-meta-description-gaming' => 'Gaming hub description of videos page placed in the description meta tag for better SEO.  Placeholder is the wiki name',
	'specialvideos-meta-description-entertainment' => 'Entertainment hub description of videos page placed in the description meta tag for better SEO.  Placeholder is the wiki name',
	'specialvideos-meta-description-lifestyle' => 'Lifestyle hub description of videos page placed in the description meta tag for better SEO.  Placeholder is the wiki name',
	'specialvideos-meta-description-corporate' => 'Corporate hub description of videos page placed in the description meta tag for better SEO.  Placeholder is the wiki name',
	'specialvideos-remove-modal-title' => 'Modal dialog title to delete video',
	'specialvideos-remove-modal-message' => 'Modal dialog message to confirm whether or not user wants to delete',
	'specialvideos-no-videos' => 'Message shown when there are no videos added to the wiki',

	'specialvideos-filter-games' => 'Label that appears in sort/filter pulldown to show only trending gaming videos',
	'specialvideos-filter-lifestyle' => 'Label that appears in sort/filter pulldown to show only trending lifestyle videos',
	'specialvideos-filter-entertainment' => 'Label that appears in sort/filter pulldown to show only trending entertainment videos',
	'specialvideos-btn-load-more' => 'Label for button that loads more videos when clicked',
	'specialvideos-posted-in-label' => 'This is the label text that appears before a list of titles in which the video is posted. Due to design constraints, it comes before the list, so if, when translated, it would otherwise come after the list, please do your best to adjust accordingly. Think of it as a label or a heading followed by bullet points. ex: "Posted in: title1, title2, title3."  It is up to you if you want to include a colon at the end.',
];

$messages['de'] = [
	'specialvideos-html-title' => 'Videos auf diesem Wiki',
	'specialvideos-page-title' => 'Videos',
	'specialvideos-wiki-videos-tally' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|Videos auf<br /> diesem Wiki|Videos auf<br /> Diesem Wiki}}</span>',
	'specialvideos-sort-by' => 'Sortieren nach',
	'specialvideos-sort-latest' => 'Neueste',
	'specialvideos-sort-most-popular' => 'Populärste',
	'specialvideos-sort-trending' => 'Trends',
	'specialvideos-sort-featured' => 'Quelle: Wikia-Bibliothek',
	'specialvideos-uploadby' => 'von $1',
	'specialvideos-posted-in' => 'Veröffentlicht auf $1',
	'special-videos-add-video' => 'Video hinzufügen',
	'related-videos-tooltip-add' => 'Eine Video zu dieser Seite hinzufügen',
];

$messages['es'] = [
	'specialvideos-html-title' => 'Vídeos en este wiki',
	'specialvideos-page-title' => 'Vídeos',
	'specialvideos-wiki-videos-tally' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|vídeo en<br /> este wiki|vídeos en<br /> este wiki}}</span>',
	'specialvideos-sort-by' => 'Organizar Por',
	'specialvideos-sort-latest' => 'Más Recientes',
	'specialvideos-sort-most-popular' => 'Más Populares',
	'specialvideos-sort-trending' => 'Creciendo Ahora',
	'specialvideos-sort-featured' => 'Fuente: Biblioteca Wikia',
	'specialvideos-uploadby' => 'por $1',
	'specialvideos-posted-in' => 'Publicado en $1',
	'special-videos-add-video' => 'Añade un video',
	'related-videos-tooltip-add' => 'Añadir un vídeo a esta página',
];

$messages['fr'] = [
	'specialvideos-html-title' => 'Vidéos sur ce wiki',
	'specialvideos-page-title' => 'Vidéos',
	'specialvideos-wiki-videos-tally' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|vidéo|vidéos}} sur<br />ce wiki</span>',
	'specialvideos-sort-by' => 'Trier par',
	'specialvideos-sort-latest' => 'Dernières',
	'specialvideos-sort-most-popular' => 'Les plus populaires',
	'specialvideos-sort-trending' => 'Tendances',
	'specialvideos-sort-featured' => 'Source : Librairie Wikia',
	'specialvideos-uploadby' => 'par $1',
	'specialvideos-posted-in' => 'Postée sur $1',
	'special-videos-add-video' => 'Ajouter une vidéo',
	'related-videos-tooltip-add' => 'Ajouter une vidéo à cette page.',
];

$messages['gl'] = [
	'related-videos-tooltip-add' => 'Engadir un vídeo a esta páxina',
];

$messages['hu'] = [
	'related-videos-tooltip-add' => 'Videó hozzáadása az oldalhoz',
];

$messages['ia'] = [
	'related-videos-tooltip-add' => 'Adder un video a iste pagina',
];

$messages['mk'] = [
	'related-videos-tooltip-add' => 'Додај видео во страницава',
];

$messages['ms'] = [
	'related-videos-tooltip-add' => 'Letakkan video pada laman ini',
];

$messages['nb'] = [
	'related-videos-tooltip-add' => 'Legg til en video på denne siden',
];

$messages['nl'] = [
	'related-videos-tooltip-add' => 'Video aan deze pagina toevoegen',
];

$messages['pl'] = [
	'specialvideos-html-title' => 'Filmy',
	'specialvideos-page-title' => 'Filmy',
	'specialvideos-wiki-videos-tally' => '<em>{{FORMATNUM:$1}}</em><span> {{PLURAL:$1|film na<br /> tej wiki|filmów na<br /> tej wiki}}</span>',
	'specialvideos-sort-by' => 'Sposób sortowania',
	'specialvideos-sort-latest' => 'Najnowsze',
	'specialvideos-sort-most-popular' => 'Najpopularniejsze',
	'specialvideos-sort-trending' => 'Na fali',
	'specialvideos-sort-featured' => 'Źródło: Wikia Library',
	'specialvideos-uploadby' => 'dodał(a) $1',
	'specialvideos-posted-in' => 'Użyto w $1',
	'special-videos-add-video' => 'Dodaj film',
	'related-videos-tooltip-add' => 'Dodaj film do tej strony',
];

$messages['ru'] = [
	'specialvideos-html-title' => 'Видео на этой вики ',
	'specialvideos-page-title' => 'Видео',
	'specialvideos-wiki-videos-tally' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|видео на<br /> этой вики}}</span>',
	'specialvideos-sort-by' => 'Cортировать по',
	'specialvideos-sort-latest' => 'Самому новому',
	'specialvideos-sort-most-popular' => 'Самому просматриваемому',
	'specialvideos-sort-trending' => 'Самому популярному',
	'specialvideos-sort-featured' => 'Источник: Библиотека Викия',
	'specialvideos-uploadby' => 'от $1',
	'specialvideos-posted-in' => 'Опубликовано в $1',
	'special-videos-add-video' => 'Добавить видео',
	'related-videos-tooltip-add' => 'Добавить видео на эту страницу',
];

$messages['sv'] = [
	'related-videos-tooltip-add' => 'Lägg till en video på denna sida',
];

$messages['tl'] = [
	'related-videos-tooltip-add' => 'Magdagdag ng isang bidyo sa pahinang ito',
];

$messages['it'] = [
	'specialvideos-html-title' => 'Video in questa wiki',
	'specialvideos-page-title' => 'Video',
	'specialvideos-wiki-videos-tally' => '<em>{{FORMATNUM:$1}}</em><span>{{PLURAL:$1|video in<br /> questa wiki|video in<br /> questa wiki}}</span>',
	'specialvideos-sort-by' => 'Ordina per',
	'specialvideos-sort-latest' => 'Più recenti',
	'specialvideos-sort-most-popular' => 'Più popolari',
	'specialvideos-sort-trending' => 'Tendenza',
	'specialvideos-sort-featured' => 'Fonte: Wikia Library',
	'specialvideos-uploadby' => 'da $1',
	'specialvideos-posted-in' => 'Pubblicato in $1',
	'special-videos-add-video' => 'Carica un video',

];
