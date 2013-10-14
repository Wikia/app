<?php
/**
 * @addtogroup Extensions
*/

$messages = array();
$messages['en'] = array(
	'wikia-videohandlers-desc' => 'Handling of videos within MediaWiki file architecture',
	'videohandler' => 'Video handler',
	'prototype-videohandler-extension-desc' => 'Prototype video handler',
	'movieclips-videohandler-extension-desc' => 'MovieClips video handler',
	'screenplay-videohandler-extension-desc' => 'Screenplay video handler',
	'youtube-videohandler-extension-desc' => 'YouTube video handler',
	'videohandler-error-missing-parameter' => 'Required parameter "$1" is missing',
	'videohandler-error-video-no-exist' => 'Video specified by title does not exist',
	'videohandler-unknown-title' => 'Unknown title',
	'videohandler-video-details' => '$1 (provider: $2)',
	'videohandler-category' => 'Videos',
    'videohandler-description' => 'Description',
	'videohandler-video-views' => '$1 {{PLURAL:$1|view|views}}',
	'videohandler-non-premium-with-links' => 'This wiki only allows licensed content from [http://video.wikia.com Wikia Video Library] to be added. Please go to [http://video.wikia.com video.wikia.com] to search for videos.', // TODO: once VETUpgrade branch is merged to trunk, re-instate links in message (Liz)
	'videohandler-non-premium' => 'This wiki only allows licensed content from Wikia Video Library to be added. Please go to http://video.wikia.com to search for videos.',
	'videohandler-remove' => 'Remove',
	'videohandler-remove-video-modal-title' => 'Are you sure you want to remove this video from your wiki?',
	'videohandler-remove-video-modal-ok' => 'Remove',
	'videohandler-remove-video-modal-success' => 'File:$1 has been removed from this wiki',
	'videohandler-remove-video-modal-cancel' => 'Cancel',
	'videohandler-remove-error-unknown' => 'We are sorry, but something went wrong with the deletion.',
	'videohandler-log-add-description' => 'Adding video description',
	'videohandler-log-add-video' => 'created video',
	'videos-error-empty-title' => 'Empty title.',
	'videos-error-blocked-user' => 'Blocked user.',
	'videos-error-readonly' => 'Read only mode.',
	'videos-error-permissions' => 'you cannot delete this video.',
	'videohandler-error-restricted-video' => 'This video contains restricted content that cannot be displayed on this wiki',

	'videos-add-video' => 'Add a video',
	'videos-add-video-to-this-wiki' => 'Add a video to this wiki',
	'videos-add-video-label-name' => 'Enter the full URL, from any of the supported sites.',
	'videos-add-video-label-all' => 'See all',
	'videos-add-video-ok' => 'Add',
	'videos-notify' => 'Please wait while we process this video',
	'videos-something-went-wrong' => 'We are sorry, but something went wrong with the upload.',
	'videos-error-not-logged-in' => 'Please log in first.',
	'videos-error-no-video-url' => 'No video URL provided.',
	'videos-error-invalid-video-url' => 'Please enter a valid URL from a supported content provider.',
	'videos-error-unknown' => 'An unknown error occurred. Code: $1.',
	'videos-error-old-type-video' => 'Old type of videos no longer supported (VideoPage)',
	'videos-error-while-loading' => 'Error occurred while loading data. Please recheck your connection and refesh the page.',
	'videos-error-admin-only' => 'Sorry, only admins of this wiki are permitted to add videos',
	'videos-initial-upload-edit-summary' => 'created video',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'wikia-videohandlers-desc' => 'Description of module used for credits page',
	'videohandler-error-missing-parameter' => 'Says, that a certain parameter is missing in the input data.
* $1 is the exact name of the missing parameter, as the computer would expect.',
	'videohandler-video-details' => "Parameters:
* $1 is a link to the video on its source page, with the label being the original title of the video
* $2 is a link to the provider's homepage (e.g. [http://youtube.com/ youtube.com])",
	'videohandler-video-views' => 'video views. $1 is number of video views.',
	'videohandler-remove' => 'Text for button to click to remove a wikia library video from your wiki.',
	'videohandler-remove-video-modal-title' => 'This is the message to the user confirming they want to remove the video from their wiki.',
	'videohandler-remove-video-modal-ok' => 'This is the button text to confirm removing a video from a wiki',
	'videohandler-remove-video-modal-success' => 'This is the confirmation message that a video has been removed from a wiki',
	'videohandler-remove-video-modal-cancel' => 'This is the button text to cancel removal of a video from a wiki',
	'videohandler-log-add-description' => 'Notification message that shows up in recent changes when a video description is added',
	'videohandler-log-add-video' => 'Notification message that shows up in recent changes when a video has been added',

	'videos-add-video' => 'Button text to click to add a video to the wiki',
	'videos-add-video-to-this-wiki' => 'Tooltip text for the button to add a video to this wiki',
	'videos-add-video-label-name' => 'Instructions for adding a video to a wiki',
	'videos-add-video-label-all' => 'Link to see a list of supported video providers',
	'videos-add-video-ok' => 'Button text to submit the add video form',
	'videos-notify' => 'Loading text - wait while video is being added',
	'videos-something-went-wrong' => 'Error message when a generic problem occurs while adding a video to a wiki',
	'videos-error-not-logged-in' => 'Error message when a user tries to add a video while not logged in.',
	'videos-error-no-video-url' => 'Error message when there\'s no video URL provided.',
	'videos-error-invalid-video-url' => 'Error message when a user enters an invalid URL.',
	'videos-error-unknown' => 'Error message when an unknown error occurred',
	'videos-error-old-type-video' => 'Error message when user tries to add a video of a type that is no longer supported.',
	'videos-error-while-loading' => 'Error message when failing to add a video.',
	'videos-error-admin-only' => 'Error message that shows up when the wgAllVideosAdminOnly is set to true and a non-admin attempts to upload a video'
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'videohandler-category' => "Video's",
);

/** Azerbaijani (azərbaycanca)
 * @author Sortilegus
 * @author Vago
 */
$messages['az'] = array(
	'videohandler-category' => 'Videolar',
);

/** Belarusian (Taraškievica orthography) (‪беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'videohandler-category' => 'Відэа',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'videohandler-category' => 'Видео',
);

/** Breton (brezhoneg)
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'videohandler-category' => 'Videoioù',
	'videos-add-video-ok' => 'Graet',
	'videos-add-video-label-all' => 'Gwelet pep tra',
);

/** Bosnian (bosanski)
 * @author Palapa
 */
$messages['bs'] = array(
	'videohandler-category' => 'Videa',
);

/** Catalan (català)
 * @author Gemmaa
 * @author Paucabot
 */
$messages['ca'] = array(
	'videohandler-category' => 'Vídeos',
);

/** Czech (česky)
 * @author Mr. Richard Bolla
 */
$messages['cs'] = array(
	'videohandler-category' => 'Videa',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'videohandler-category' => 'Fideos',
);

/** German (Deutsch)
 * @author Inkowik
 * @author LWChris
 * @author PtM
 * @author Tiin
 */
$messages['de'] = array(
	'wikia-videohandlers-desc' => 'Handhabung von Videos innerhalb der MediaWiki-Dateiorganisation',
	'videohandler' => 'Video handler',
	'prototype-videohandler-extension-desc' => 'Prototyp-Video-Steuerung',
	'movieclips-videohandler-extension-desc' => 'MovieClips-Video-Steuerungsprogramm',
	'screenplay-videohandler-extension-desc' => 'Screenplay-Video-Steuerungsprogramm',
	'youtube-videohandler-extension-desc' => 'YouTube-Video-Steuerungsprogramm',
	'videohandler-error-missing-parameter' => 'Erforderlicher Parameter "$1" fehlt',
	'videohandler-error-video-no-exist' => 'Video existiert nicht mit dem Titel',
	'videohandler-unknown-title' => 'Unbekannter Titel',
	'videohandler-video-details' => '$1 (Provider: $2)',
	'videohandler-category' => 'Videos',
	'videohandler-description' => 'Beschreibung',
	'videos-error-while-loading' => 'Fehler beim laden von Daten. Überprüfen Sie bitte Ihre Verbindung und laden sie die Seite erneut.',
	'videos-add-video-label-name' => 'Gib die vollständige URL von einer der unterstützten Websites ein.',
	'videos-add-video-ok' => 'Hinzufügen',
	'videos-add-video-label-all' => 'Alle anzeigen',
	'videos-add-video' => 'Video hinzufügen',
	'videos-add-video-to-this-wiki' => 'Ein neues Video zu diesem Wiki hinzufügen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author LWChris
 */
$messages['de-formal'] = array(
	'videohandler-category' => 'Videos',
);

/** Spanish (español)
 * @author Bola
 * @author Ciencia Al Poder
 * @author Fitoschido
 * @author Translationista
 * @author VegaDark
 */
$messages['es'] = array(
	'wikia-videohandlers-desc' => 'Manejo de vídeos dentro de la arquitectura de MediaWiki',
	'videohandler' => 'Controlador de vídeo',
	'prototype-videohandler-extension-desc' => 'Controlador del prototipo de vídeo',
	'movieclips-videohandler-extension-desc' => 'Controlador de clips de película',
	'screenplay-videohandler-extension-desc' => 'Controlador de vídeo Screnplay',
	'youtube-videohandler-extension-desc' => 'Controlador de vídeo de YouTube',
	'videohandler-error-missing-parameter' => 'Falta el parámetro "$1"',
	'videohandler-error-video-no-exist' => 'El vídeo especificado por título no existe',
	'videohandler-unknown-title' => 'Título desconocido',
	'videohandler-video-details' => '$1 (proveedor: $2)',
	'videohandler-category' => 'Vídeos',
	'videohandler-description' => 'Descripción',
	'videos-error-while-loading' => 'Error al cargar los datos. Por favor vuelve a comprobar tu conexión a internet y refresca la página.',
	'videos-add-video-label-name' => 'Ingrese la dirección completa de cualquiera de los sitios soportados.',
	'videos-add-video-ok' => 'Añadir',
	'videos-add-video-label-all' => 'Ver todo',
);

/** Basque (euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'videohandler-category' => 'Bideoak',
);

/** Persian (فارسی) */
$messages['fa'] = array(
	'videohandler-category' => 'ویدیو‌ها',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Crt
 */
$messages['fi'] = array(
	'videohandler-category' => 'Videot',
);

/** French (français)
 * @author IAlex
 * @author Wyz
 */
$messages['fr'] = array(
	'wikia-videohandlers-desc' => "Gestion des vidéos au sein de l'architecture de fichiers de MediaWiki",
	'videohandler' => 'Gestionnaire de vidéos',
	'prototype-videohandler-extension-desc' => 'Gestionnaire de vidéos de Prototype',
	'movieclips-videohandler-extension-desc' => 'Gestionnaire de vidéos de MovieClips',
	'screenplay-videohandler-extension-desc' => 'Gestionnaire de vidéos de ScreenPlay',
	'youtube-videohandler-extension-desc' => 'Gestionnaire de vidéos de YouTube',
	'videohandler-error-missing-parameter' => 'Le paramètre « $1 » obligatoire est manquant',
	'videohandler-error-video-no-exist' => 'Aucune vidéo n’existe avec ce titre',
	'videohandler-unknown-title' => 'Titre inconnu',
	'videohandler-video-details' => '$1 (hébergeur : $2)',
	'videohandler-category' => 'Vidéos',
	'videohandler-description' => 'Description',
	'videos-error-while-loading' => 'Une erreur est survenue lors du chargement des données. Veuillez vérifier votre connexion et rafraîchir la page.',
	'videos-add-video-label-name' => "Entrez l'URL complète, de n'importe lequel des sites pris en charge.",
	'videos-add-video-ok' => 'Ajouter',
	'videos-add-video-label-all' => 'Tout voir',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'wikia-videohandlers-desc' => 'Manipulación de vídeos dentro da arquitectura de ficheiros de MediaWiki',
	'videohandler' => 'Manipulador de vídeos',
	'prototype-videohandler-extension-desc' => 'Manipulador de vídeos de Prototype',
	'movieclips-videohandler-extension-desc' => 'Manipulador de vídeos de MovieClips',
	'screenplay-videohandler-extension-desc' => 'Manipulador de vídeos de Screnplay',
	'youtube-videohandler-extension-desc' => 'Manipulador de vídeos de YouTube',
	'videohandler-error-missing-parameter' => 'Falta o parámetro obrigatorio "$1"',
	'videohandler-error-video-no-exist' => 'Non existe ningún vídeo con ese título',
	'videohandler-unknown-title' => 'Título descoñecido',
	'videohandler-video-details' => '$1 (provedor: $2)',
	'videohandler-category' => 'Vídeos',
	'videohandler-description' => 'Descrición',
	'videos-error-while-loading' => 'Houbo un erro ao cargar os datos. Volva comprobar a súa conexión e recargue a páxina.',
	'videos-add-video-label-name' => 'Escriba o enderezo URL completo de calquera dos sitios soportados.',
	'videos-add-video-ok' => 'Engadir',
	'videos-add-video-label-all' => 'Ollar todos',
);

/** Hebrew (עברית)
 * @author שומבלע
 */
$messages['he'] = array(
	'videohandler-category' => 'סרטוני וידאו',
);

/** Hungarian (magyar)
 * @author Glanthor Reviol
 * @author TK-999
 */
$messages['hu'] = array(
	'videohandler' => 'Videókezelő',
	'prototype-videohandler-extension-desc' => 'Prototype videókezelő',
	'movieclips-videohandler-extension-desc' => 'MovieClips videókezelő',
	'screenplay-videohandler-extension-desc' => 'Screnplay videókezelő',
	'youtube-videohandler-extension-desc' => 'YouTube videókezelő',
	'videohandler-error-video-no-exist' => 'A cím által meghatározott videó nem létezik',
	'videohandler-unknown-title' => 'Ismeretlen cím',
	'videohandler-video-details' => '$1 (szolgáltató: $2 )',
	'videohandler-category' => 'Videók',
	'videohandler-description' => 'Leírás',
	'videos-error-while-loading' => 'Hiba történt az adatok betöltése közben. Kérlek, ellenőrizd az internetkapcsolatodat és frissítsd az oldalt.',
	'videos-add-video-label-name' => 'Írd be a teljes URL-címet valamely támogatott webhelyről.',
	'videos-add-video-ok' => 'Hozzáadás',
	'videos-add-video-label-all' => 'Összes megtekintése',
);

/** Armenian (Հայերեն)
 * @author Pandukht
 */
$messages['hy'] = array(
	'videohandler-category' => 'Տեսանյութեր',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'videohandler' => 'Gestor de videos',
	'prototype-videohandler-extension-desc' => 'Gestor de videos Prototype',
	'movieclips-videohandler-extension-desc' => 'Gestor de videos MovieClips',
	'screenplay-videohandler-extension-desc' => 'Gestor de videos ScreenPlay',
	'youtube-videohandler-extension-desc' => 'Gestor de videos YouTube',
	'videohandler-error-video-no-exist' => 'Le video specificate per le titulo non existe',
	'videohandler-unknown-title' => 'Titulo incognite',
	'videohandler-video-details' => '$1 (fornitor: $2)',
	'videohandler-category' => 'Videos',
	'videohandler-description' => 'Description',
	'videos-error-while-loading' => 'Un error occurreva durante le cargamento del datos. Per favor re-verifica tu connexion e refresca le pagina.',
	'videos-add-video-label-name' => 'Entra le URL complete de un del sitos supportate.',
	'videos-add-video-ok' => 'Adder',
	'videos-add-video-label-all' => 'Vider totes',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 * @author Kenrick95
 */
$messages['id'] = array(
	'videohandler-category' => 'Video',
);

/** Italian (italiano)
 * @author HalphaZ
 */
$messages['it'] = array(
	'videohandler-category' => 'Video',
);

/** Japanese (日本語)
 * @author Schu
 * @author Tommy6
 */
$messages['ja'] = array(
	'videohandler-category' => '動画',
);

/** Georgian (ქართული)
 * @author David1010
 */
$messages['ka'] = array(
	'videohandler-category' => 'ვიდეოები',
);

/** Karachay-Balkar (къарачай-малкъар)
 * @author Къарачайлы
 */
$messages['krc'] = array(
	'videohandler-category' => 'Видеола',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'videohandler-category' => 'Videoen',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'wikia-videohandlers-desc' => 'Поставување на видеа во рамките на податотечната архитектура на МедијаВики',
	'videohandler' => 'Поставување на видеа',
	'prototype-videohandler-extension-desc' => 'Прототипен поставувач на видеа',
	'movieclips-videohandler-extension-desc' => 'Поставувач на видеа од MovieClips',
	'screenplay-videohandler-extension-desc' => 'Поставувач на видеа од Screnplay',
	'youtube-videohandler-extension-desc' => 'Поставувач на видеа од YouTube',
	'videohandler-error-missing-parameter' => 'Недостасува задолжителниот параметар „$1“',
	'videohandler-error-video-no-exist' => 'Не постои видео со таков наслов',
	'videohandler-unknown-title' => 'Непознат наслов',
	'videohandler-video-details' => '$1 (добавувач: $2)',
	'videohandler-category' => 'Видеоснимки',
	'videohandler-description' => 'Опис',
	'videohandler-video-views' => '$1 {{PLURAL:$1|преглед|прегледи}}',
	'videos-error-while-loading' => 'Не појави грешка при вчитувањето на податоците. Проверете си ја врската со интернет и превчитајте ја страницата.',
	'videos-add-video-label-name' => 'Внесете ја полната URL-адреса од едно од поддржаните мрежни места.',
	'videos-add-video-ok' => 'Додај',
	'videos-add-video-label-all' => 'Прикажи ги сите',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'videohandler' => 'Pengelola video',
	'prototype-videohandler-extension-desc' => 'Pengelola video prototaip',
	'movieclips-videohandler-extension-desc' => 'Pengelola video MovieClips',
	'screenplay-videohandler-extension-desc' => 'Pengelola video ScreenPlay',
	'youtube-videohandler-extension-desc' => 'Pengelola video YouTube',
	'videohandler-error-missing-parameter' => 'Parameter wajib "$1" tertinggal',
	'videohandler-error-video-no-exist' => 'Tiada video dengan tajuk yang dinyatakan',
	'videohandler-unknown-title' => 'Tajuk tidak diketahui',
	'videohandler-video-details' => '$1 (penyedia: $2)',
	'videohandler-category' => 'Video',
	'videohandler-description' => 'Keterangan',
	'videos-error-while-loading' => 'Berlakunya ralat ketika memuatkan data. Sila semak semula sambungan anda dan muatkan semula laman ini.',
	'videos-add-video-label-name' => 'Isikan URL penuh dari mana-mana tapak web yang disokong.',
	'videos-add-video-ok' => 'Tambahkan',
	'videos-add-video-label-all' => 'Lihat semua',
);

/** Norwegian Bokmål (‪norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'wikia-videohandlers-desc' => 'Behandling av videoer innenfor MediaWikis filarkitektur',
	'videohandler' => 'Videobehandler',
	'prototype-videohandler-extension-desc' => 'Prototype-videobehandler',
	'movieclips-videohandler-extension-desc' => 'MovieClips-videobehandler',
	'screenplay-videohandler-extension-desc' => 'Screenplay-videobehandler',
	'youtube-videohandler-extension-desc' => 'YouTube-videobehandler',
	'videohandler-error-missing-parameter' => 'Påkrevd parameter «$1» mangler',
	'videohandler-error-video-no-exist' => 'Video spesifisert med tittel eksisterer ikke',
	'videohandler-unknown-title' => 'Ukjent tittel',
	'videohandler-video-details' => '$1 (leverandør: $2)',
	'videohandler-category' => 'Videoer',
	'videohandler-description' => 'Beskrivelse',
	'videos-error-while-loading' => 'Det oppstod en feil under lasting av data. Vennligst sjekk din netttilkobling og oppdater siden.',
	'videos-add-video-label-name' => 'Oppgi en fullstendig URL fra en av de støttede sidene.',
	'videos-add-video-ok' => 'Legg til',
	'videos-add-video-label-all' => 'Vis alle',
);

/** Dutch (Nederlands)
 * @author AvatarTeam
 * @author Siebrand
 */
$messages['nl'] = array(
	'videohandler' => 'Videoverwerking',
	'prototype-videohandler-extension-desc' => 'Prototype videoverwerking',
	'videohandler-error-missing-parameter' => 'Vereiste parameter "$1" ontbreekt',
	'videohandler-unknown-title' => 'Onbekende titel',
	'videohandler-video-details' => '$1 (provider: $2)',
	'videohandler-category' => "Video's",
	'videohandler-description' => 'Beschrijving',
	'videos-error-while-loading' => 'Fout is opgetreden tijdens het laden van gegevens. Controleer alstublieft uw verbinding en ververs de pagina.',
	'videos-add-video-label-name' => 'Geef een volledige URL op van een van de ondersteunde websites.',
	'videos-add-video-ok' => 'Toevoegen',
	'videos-add-video-label-all' => 'Allemaal bekijken',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Aalam
 */
$messages['pa'] = array(
	'videohandler-category' => 'ਵਿਡੀਓ',
);

/** Polish (polski)
 * @author Marcin Łukasz Kiejzik
 * @author Sovq
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'wikia-videohandlers-desc' => 'Obsługa filmów wewnątrz systemu plików MediaWiki',
	'videohandler' => 'Odtwarzacz filmów',
	'prototype-videohandler-extension-desc' => 'Prototypowy odtwarzacz filmów',
	'movieclips-videohandler-extension-desc' => 'Odtwarzacz filmów MovieClips',
	'screenplay-videohandler-extension-desc' => 'Odtwarzacz filmów Screnplay',
	'youtube-videohandler-extension-desc' => 'Odtwarzacz filmów YouTube',
	'videohandler-error-missing-parameter' => 'Brak wymaganego parametru "$1"',
	'videohandler-error-video-no-exist' => 'Film o tym tytule nie istnieje',
	'videohandler-unknown-title' => 'Nieznany tytuł',
	'videohandler-video-details' => '$1 (z $2)',
	'videohandler-category' => 'Filmy',
	'videohandler-description' => 'Opis',
	'videos-error-while-loading' => 'Wystąpił błąd podczas ładowania danych. Sprawdź ponownie połączenie i odśwież stronę.',
	'videos-add-video-label-name' => 'Wpisz pełny adres URL, z jednej z obsługiwanych witryn.',
	'videos-add-video-ok' => 'Dodaj',
	'videos-add-video-label-all' => 'Pokaż wszystko',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'videohandler-category' => 'Video',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'videohandler-category' => 'ويډيوګانې',
	'videos-add-video-ok' => 'ورګډول',
	'videos-add-video-label-all' => 'ټول کتل',
);

/** Portuguese (português)
 * @author Crazymadlover
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'videohandler-category' => 'Vídeos',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Daemorris
 */
$messages['pt-br'] = array(
	'videohandler-category' => 'Vídeos',
);

/** Romanian (română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'videohandler-category' => 'Videoclipuri',
);

/** Russian (русский)
 * @author DCamer
 * @author Eleferen
 * @author Kuzura
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'wikia-videohandlers-desc' => 'Обработка видео с файловой архитектурой MediaWiki',
	'videohandler' => 'Видео обработчик',
	'prototype-videohandler-extension-desc' => 'Прототип видео обработчик',
	'movieclips-videohandler-extension-desc' => 'Видео обработчик клипов',
	'screenplay-videohandler-extension-desc' => 'Видео обработчик сценария',
	'youtube-videohandler-extension-desc' => 'YouTube видео обработчик',
	'videohandler-error-missing-parameter' => 'Отсутствует обязательный параметр «$1»',
	'videohandler-error-video-no-exist' => 'Видео с данным названием не существует',
	'videohandler-unknown-title' => 'Неизвестное название',
	'videohandler-video-details' => '$1 (источник: $2)',
	'videohandler-category' => 'Видео',
	'videohandler-description' => 'Описание',
	'videos-error-while-loading' => 'Ошибка при загрузке данных. Пожалуйста, проверьте Ваше соединение и обновите страницу.',
	'videos-add-video-label-name' => 'Введите полный URL-адрес от любого из поддерживаемых сайтов.',
	'videos-add-video-ok' => 'Добавить',
	'videos-add-video-label-all' => 'Смотреть всё',
);

/** Sinhala (සිංහල)
 * @author තඹරු විජේසේකර
 */
$messages['si'] = array(
	'videohandler-category' => 'වීඩියෝ',
);

/** Slovenian (slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'videohandler-category' => 'Videoposnetki',
);

/** Serbian (Cyrillic script) (‪српски (ћирилица)‬)
 * @author Charmed94
 * @author Rancher
 * @author Verlor
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'videohandler-category' => 'Видео-снимци',
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'videohandler' => 'Videohanterare',
	'prototype-videohandler-extension-desc' => 'Videohanterare för Prototype',
	'movieclips-videohandler-extension-desc' => 'Videohanterare för MovieClips',
	'screenplay-videohandler-extension-desc' => 'Videohanterare för Screnplay',
	'youtube-videohandler-extension-desc' => 'Videohanterare för YouTube',
	'videohandler-unknown-title' => 'Okänd titel',
	'videohandler-video-details' => '$1 (leverantör: $2)',
	'videohandler-category' => 'Videoklipp',
	'videohandler-description' => 'Beskrivning',
	'videos-error-while-loading' => 'Ett fel uppstod när data skulle läses in. Var god kontrollera din anslutning och uppdatera sidan.',
	'videos-add-video-label-name' => 'Ange en fullständig URL från någon av de stödjande sidorna.',
	'videos-add-video-ok' => 'Lägg till',
	'videos-add-video-label-all' => 'Se alla',
);

/** Tamil (தமிழ்)
 * @author Karthi.dr
 */
$messages['ta'] = array(
	'videos-add-video-ok' => 'முடிந்தது',
	'videos-add-video-label-all' => 'எல்லாவற்றையும் பார்க்கவும்',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'wikia-videohandlers-desc' => 'Pag-aasikaso ng mga bidyo na nasa loob ng arkitektura ng talaksan ng MediaWiki',
	'videohandler' => 'Tagahawak ng bidyo',
	'prototype-videohandler-extension-desc' => 'Prototipong tagahawak ng bidyo',
	'movieclips-videohandler-extension-desc' => 'Tagahawak ng bidyo ng MovieClips',
	'screenplay-videohandler-extension-desc' => 'Tagahawak ng bidyo ng Screnplay',
	'youtube-videohandler-extension-desc' => 'Tagahawak ng bidyo ng YouTube',
	'videohandler-error-missing-parameter' => 'Nawawala ang kailangang parametrong "$1"',
	'videohandler-error-video-no-exist' => 'Hindi umiiral ang bidyo na tinukoy ayon sa pamagat',
	'videohandler-unknown-title' => 'Hindi nalalamang pamagat',
	'videohandler-video-details' => '$1 (tagapagbigay: $2)',
	'videohandler-category' => 'Mga bidyo',
	'videohandler-description' => 'Paglalarawan',
	'videos-error-while-loading' => 'Naganap ang kamalian habang ikinakarga ang dato. Pakisuring muli ang pagkakakunekta mo at sariwain ang pahina.',
	'videos-add-video-label-name' => 'Ipasok ang buong URL, mula sa anuman sa tinatangkilik na mga pook.',
	'videos-add-video-ok' => 'Idagdag',
	'videos-add-video-label-all' => 'Tingnan lahat',
);

/** Turkish (Türkçe)
 * @author Mert.subay
 */
$messages['tr'] = array(
	'videohandler-category' => 'Videolar',
);

/** Ukrainian (українська)
 * @author A1
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'videohandler-category' => 'Відео',
);

/** Simplified Chinese (‪中文（简体）‬)
 * @author Hydra
 * @author Yanmiao liu
 */
$messages['zh-hans'] = array(
	'videohandler-category' => '视频',
);

