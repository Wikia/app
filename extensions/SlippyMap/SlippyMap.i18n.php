<?php
/**
 * Internationalisation file for SlippyMap extension.
 *
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'slippymap_desc' => "Allows the use of the <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> tag to display an OpenLayers slippy map. Maps are from [http://openstreetmap.org openstreetmap.org]",
	'slippymap_latmissing' => "Missing lat value (for the latitude).",
	'slippymap_lonmissing' => "Missing lon value (for the longitude).",
	'slippymap_zoommissing' => "Missing z value (for the zoom level).",
	'slippymap_longdepreciated' => "Please use 'lon' instead of 'long' (parameter was renamed).",
	'slippymap_widthnan' => "width (w) value '%1' is not a valid integer",
	'slippymap_heightnan' => "height (h) value '%1' is not a valid integer",
	'slippymap_zoomnan' => "zoom (z) value '%1' is not a valid integer",
	'slippymap_latnan' => "latitude (lat) value '%1' is not a valid number",
	'slippymap_lonnan' => "longitude (lon) value '%1' is not a valid number",
	'slippymap_widthbig' => "width (w) value cannot be greater than 1000",
	'slippymap_widthsmall' => "width (w) value cannot be less than 100",
	'slippymap_heightbig' => "height (h) value cannot be greater than 1000",
	'slippymap_heightsmall' => "height (h) value cannot be less than 100",
	'slippymap_latbig' => "latitude (lat) value cannot be greater than 90",
	'slippymap_latsmall' => "latitude (lat) value cannot be less than -90",
	'slippymap_lonbig' => "longitude (lon) value cannot be greater than 180",
	'slippymap_lonsmall' => "longitude (lon) value cannot be less than -180",
	'slippymap_zoomsmall' => "zoom (z) value cannot be less than zero",
	'slippymap_zoom18' => "zoom (z) value cannot be greater than 17. Note that this mediawiki extension hooks into the OpenStreetMap 'osmarender' layer which does not go beyond zoom level 17. The Mapnik layer available on openstreetmap.org, goes up to zoom level 18",
	'slippymap_zoombig' => "zoom (z) value cannot be greater than 17.",
	'slippymap_invalidlayer' => "Invalid 'layer' value '%1'",
	'slippymap_maperror' => "Map error:",
	'slippymap_osmlink' => 'http://www.openstreetmap.org/?lat=%1&lon=%2&zoom=%3', # do not translate or duplicate this message to other languages
	'slippymap_osmtext' => 'See this map on OpenStreetMap.org',
	'slippymap_code'    => 'Wikicode for this map view:',
	'slippymap_button_code' => 'Get wikicode',
	'slippymap_resetview' => 'Reset view',
	'slippymap_license' => 'OpenStreetMap - CC-BY-SA-2.0', # do not translate or duplicate this message to other languages
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'slippymap_maperror'    => 'خطأ في الخريطة:',
	'slippymap_button_code' => 'الحصول على كود ويكي',
	'slippymap_resetview'   => 'إعادة ضبط الرؤية',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'slippymap_desc'         => 'Позволява използването на етикета <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> за показване на OpenLayers slippy карти. Картите са от [http://openstreetmap.org openstreetmap.org]',
	'slippymap_zoommissing'  => 'Липсваща стойност z (за степен на приближаване).',
	'slippymap_zoomsmall'    => 'стойността за приближаване (z) не може да бъде отрицателно число',
	'slippymap_zoombig'      => 'стойността за приближаване (z) не може да бъде по-голяма от 17.',
	'slippymap_invalidlayer' => "Невалидна стойност на 'слоя' '%1'",
	'slippymap_maperror'     => 'Грешка в картата:',
	'slippymap_osmtext'      => 'Преглеждане на картата в OpenStreetMap.org',
	'slippymap_code'         => 'Уикикод за тази карта:',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'slippymap_desc'            => 'Ermöglicht die Nutzung des <tt><nowiki>&lt;slippymap&gt;</nowiki></tt>-Tags zur Anzeige einer OpenLayer-SlippyMap. Die Karten stammen von [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing'      => 'Es wurde kein Wert für die geografische Breite (lat) angegeben.',
	'slippymap_lonmissing'      => 'Es wurde kein Wert für die geografische Länge (lon) angegeben.',
	'slippymap_zoommissing'     => 'Es wurde kein Zoom-Wert (z) angegeben.',
	'slippymap_longdepreciated' => "Bitte benutze 'lon' an Stelle von 'long' (Parameter wurde umbenannt). ",
	'slippymap_widthnan'        => "Der Wert für die Breite (w) '%1' ist keine gültige Zahl",
	'slippymap_heightnan'       => "Der Wert für die Höhe (h) '%1' ist keine gültige Zahl",
	'slippymap_zoomnan'         => "Der Wert für den Zoom (z) '%1' ist keine gültige Zahl",
	'slippymap_latnan'          => "Der Wert für die geografische Breite (lat) '%1' ist keine gültige Zahl",
	'slippymap_lonnan'          => "Der Wert für die geografische Länge (lon) '%1' ist keine gültige Zahl",
	'slippymap_widthbig'        => 'Die Breite (w) darf 1000 nicht überschreiten',
	'slippymap_widthsmall'      => 'Die Breite (w) darf 100 nicht unterschreiten',
	'slippymap_heightbig'       => 'Die Höhe (h) darf 1000 nicht überschreiten',
	'slippymap_heightsmall'     => 'Die Höhe (h) darf 100 nicht unterschreiten',
	'slippymap_latbig'          => 'Die geografische Breite darf nicht größer als 90 sein',
	'slippymap_latsmall'        => 'Die geografische Breite darf nicht kleiner als -90 sein',
	'slippymap_lonbig'          => 'Die geografische Länge darf nicht größer als 180 sein',
	'slippymap_lonsmall'        => 'Die geografische Länge darf nicht kleiner als -180 sein',
	'slippymap_zoomsmall'       => 'Der Zoomwert darf nicht negativ sein',
	'slippymap_zoom18'          => "Der Zoomwert (z) darf nicht größer als 17 sein. Beachte, dass diese MediaWiki-Erweiterung die OpenStreetMap 'Osmarender'-Karte einbindet, die nicht höher als Zoom 17 geht. Die Mapnik-Karte ist auf openstreetmap.org verfügbar und geht bis Zoom 18.",
	'slippymap_zoombig'         => 'Der Zoomwert (z) darf nicht größer als 17 sein.',
	'slippymap_invalidlayer'    => "Ungültiger 'layer'-Wert „%1“",
	'slippymap_maperror'        => 'Kartenfehler:',
	'slippymap_osmtext'         => 'Diese Karte auf OpenStreetMap.org ansehen',
	'slippymap_code'            => 'Wikitext für diese Kartenansicht:',
	'slippymap_button_code'     => 'Zeige Wikicode',
	'slippymap_resetview'       => 'Zurücksetzen',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'slippymap_maperror'    => 'Mapa eraro:',
	'slippymap_osmtext'     => 'Vidi ĉi tiun mapon en OpenStreetMap.org',
	'slippymap_code'        => 'Vikikodo por ĉi tiu mapvido:',
	'slippymap_button_code' => 'Akiri vikikodon',
	'slippymap_resetview'   => 'Restarigi vidon',
);

/** French (Français)
 * @author Grondin
 * @author Cedric31
 * @author Siebrand
 */
$messages['fr'] = array(
	'slippymap_desc'            => 'Autorise l’utilisation de la balise <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> pour afficher une carte glissante d’OpenLayers. Les cartes proviennent de [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing'      => 'Valeur lat manquante (pour la latitude).',
	'slippymap_lonmissing'      => 'Valeur lon manquante (pour la longitude).',
	'slippymap_zoommissing'     => 'Valeur z manquante (pour le niveau du zoom).',
	'slippymap_longdepreciated' => 'Veuillez utiliser « lon » au lieu de « long » (le paramètre a été renommé).',
	'slippymap_widthnan'        => 'La largeur (w) ayant pour valeur « %1 » n’est pas un nombre entier correct.',
	'slippymap_heightnan'       => 'La hauteur (h) ayant pour valeur « %1 » n’est pas un nombre entier correct.',
	'slippymap_zoomnan'         => 'Le zoom (z) ayant pour valeur « %1 » n’est pas un nombre entier correct.',
	'slippymap_latnan'          => 'La latitude (lat) ayant pour valeur « %1 » n’est pas un nombre correct.',
	'slippymap_lonnan'          => 'La longitude (lon) ayant pour valeur « %1 » n’est pas un nombre correct.',
	'slippymap_widthbig'        => 'La valeur de la largeur (w) ne peut excéder 1000',
	'slippymap_widthsmall'      => 'La valeur de la largeur (w) ne peut être inférieure à 100',
	'slippymap_heightbig'       => 'La valeur de la hauteur (h) ne peut excéder 1000',
	'slippymap_heightsmall'     => 'La valeur de la hauteur (h) ne peut être inférieure à 100',
	'slippymap_latbig'          => 'La valeur de la latitude (lat) ne peut excéder 90',
	'slippymap_latsmall'        => 'La valeur de la latitude (lat) ne peut être inférieure à -90',
	'slippymap_lonbig'          => 'La valeur de la longitude (lon) ne peut excéder 180',
	'slippymap_lonsmall'        => 'La valeur de la longitude (lon) ne peut être inférieure à -180',
	'slippymap_zoomsmall'       => 'La valeur du zoom (z) ne peut être négative',
	'slippymap_zoom18'          => 'La valeur du zoom (z) ne peut excéder 17. Notez que ce crochet d’extension mediawiki dans la couche « osmarender » de OpenStreetMap ne peut aller au-delà du niveau 17 du zoop. La couche Mapnik disponible sur openstreetmap.org, ne peut aller au-delà du niveau 18.',
	'slippymap_zoombig'         => 'La valeur du zoom (z) ne peut excéder 17.',
	'slippymap_invalidlayer'    => 'Valeur de « %1 » de la « couche » incorrecte',
	'slippymap_maperror'        => 'Erreur de carte :',
	'slippymap_osmtext'         => 'Voyez cette carte sur OpenStreetMap.org',
	'slippymap_code'            => 'Code Wiki pour le visionnement de cette cate :',
	'slippymap_button_code'     => 'Obtenir le code wiki',
	'slippymap_resetview'       => 'Réinitialiser le visionnement',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'slippymap_desc'            => 'Permite o uso da etiqueta <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> para amosar un mapa slippy. Os mapas son de [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing'      => 'Falta o valor lat (para a latitude).',
	'slippymap_lonmissing'      => 'Falta o valor lan (para a lonxitude).',
	'slippymap_zoommissing'     => 'Falta o valor z (para o nivel do zoom).',
	'slippymap_longdepreciated' => 'Por favor, use "lon" no canto de "long" (o parámetro foi renomeado).',
	'slippymap_widthnan'        => "o valor '%1' do ancho (w) non é un número enteiro válido",
	'slippymap_heightnan'       => "o valor '%1' da altura (h) non é un número enteiro válido",
	'slippymap_zoomnan'         => "o valor '%1' do zoom (z) non é un número enteiro válido",
	'slippymap_latnan'          => "o valor '%1' da latitude (lat) non é un número enteiro válido",
	'slippymap_lonnan'          => "o valor '%1' da lonxitude (lon) non é un número enteiro válido",
	'slippymap_widthbig'        => 'o valor do ancho (w) non pode ser máis de 1000',
	'slippymap_widthsmall'      => 'o valor do ancho (w) non pode ser menos de 100',
	'slippymap_heightbig'       => 'o valor da altura (h) non pode ser máis de 1000',
	'slippymap_heightsmall'     => 'o valor da altura (h) non pode ser menos de 100',
	'slippymap_latbig'          => 'o valor da latitude (lat) non pode ser máis de 90',
	'slippymap_latsmall'        => 'o valor da latitude (lat) non pode ser menos de -90',
	'slippymap_lonbig'          => 'o valor da lonxitude (lon) non pode ser máis de 180',
	'slippymap_lonsmall'        => 'o valor da lonxitude (lon) non pode ser menos de -180',
	'slippymap_zoomsmall'       => 'o valor do zoom (z) non pode ser menos de cero',
	'slippymap_zoom18'          => 'o valor do zoom (z) non pode ser máis de 17. Déase conta de que esta extensión MediaWiki asocia no OpenStreetMap a capa "osmarender", que non vai máis alá do nivel 17 do zoom. A capa Mapnik dispoñible en openstreetmap.org, vai máis aló do nivel 18',
	'slippymap_zoombig'         => 'o valor do zoom (z) non pode ser máis de 17.',
	'slippymap_invalidlayer'    => 'Valor \'%1\' da "capa" inválido',
	'slippymap_maperror'        => 'Erro no mapa:',
	'slippymap_osmtext'         => 'Vexa este mapa en OpenStreetMap.org',
	'slippymap_code'            => 'Código wiki para o visionado deste mapa:',
	'slippymap_button_code'     => 'Obter o código wiki',
	'slippymap_resetview'       => 'Axustar a vista',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'slippymap_desc'            => "Erméiglecht d'Benotzung vum Tag <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> fir eng ''OpenLayers slippy map'' ze weisen. D'kaarte si vun [http://openstreetmap.org openstreetmap.org]",
	'slippymap_longdepreciated' => "Benitzt w.e.g. 'lon' aplaz vun  'long' (de parameter gouf ëmbennnt)",
	'slippymap_widthnan'        => "Breet (w) de Wert '%1' ass keng gëlteg ganz Zuel",
	'slippymap_zoomnan'         => "Zoom (z) de Wert '%1' ass keng gëlteg ganz Zuel",
	'slippymap_widthbig'        => 'Breet (w) de Wert kann net méi grouss si wéi 1000',
	'slippymap_widthsmall'      => 'Breet (w) de Wert kann net méi kleng si wéi 100',
	'slippymap_heightbig'       => 'Héicht (h) de Wert kann net méi grouss wéi 1000 sinn',
	'slippymap_heightsmall'     => 'Héicht (h) de Wert kann net méi kleng wéi 100 sinn',
	'slippymap_zoomsmall'       => 'Zoom (z) de Wert kann net méi kleng si wéi null',
	'slippymap_zoombig'         => 'Zoom (z) de Wert kann net méi grouss si wéi 17.',
	'slippymap_code'            => 'Wikicode fir dës Kaart ze kucken:',
	'slippymap_button_code'     => 'Wikicode weisen',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'slippymap_desc'            => 'Laat het gebruik van de tag <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> toe om een OpenLayers-kaart weer te geven. Kaarten zijn van [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing'      => 'De "lat"-waarde ontbreekt (voor de breedte).',
	'slippymap_lonmissing'      => 'De "lon"-waarde ontbreekt (voor de lengte).',
	'slippymap_zoommissing'     => 'De "z"-waarde ontbreekt (voor het zoomniveau).',
	'slippymap_longdepreciated' => 'Gebruik "lon" in plaats van "long" (parameter is hernoemd).',
	'slippymap_widthnan'        => "De waarde '%1' voor de breedte (w) is geen geldige integer",
	'slippymap_heightnan'       => "De waarde '%1' voor de hoogte (h) is geen geldige integer",
	'slippymap_zoomnan'         => "De waarde '%1' voor de zoom (z) is geen geldige integer",
	'slippymap_latnan'          => "De waarde '%1' voor de breedte (lat) is geen geldig nummer",
	'slippymap_lonnan'          => "De waarde '%1' voor de lengte (lon) is geen geldig nummer",
	'slippymap_widthbig'        => 'De breedte (w) kan niet groter dan 1000 zijn',
	'slippymap_widthsmall'      => 'De breedte (w) kan niet kleiner dan 100 zijn',
	'slippymap_heightbig'       => 'De hoogte (h) kan niet groter dan 1000 zijn',
	'slippymap_heightsmall'     => 'De hoogte (h) kan niet kleiner dan 100 zijn',
	'slippymap_latbig'          => 'De breedte (lat) kan niet groter dan -90 zijn',
	'slippymap_latsmall'        => 'De breedte (lat) kan niet kleiner dan -90 zijn',
	'slippymap_lonbig'          => 'De lengte (lon) kan niet groter dan 180 zijn',
	'slippymap_lonsmall'        => 'De lengte (lon) kan niet kleiner dan -180 zijn',
	'slippymap_zoomsmall'       => 'De zoom (z) kan niet minder dan nul zijn',
	'slippymap_zoom18'          => 'De zoom (z) kan niet groter zijn dan 17. Merk op dat deze MediaWiki-uitbreiding de "Osmarender"-layer van OpenSteetMap gebruikt die niet dieper dan het niveau 17 gaat. de "Mapnik"-layer, beschikbaar op openstreetmap.org, gaat tot niveau 18.',
	'slippymap_zoombig'         => 'De zoom (z) kan niet groter dan 17 zijn',
	'slippymap_invalidlayer'    => 'Ongeldige \'layer\'-waarde "%1"',
	'slippymap_maperror'        => 'Kaartfout:',
	'slippymap_osmtext'         => 'Deze kaart op OpenStreetMap.org bekijken',
	'slippymap_code'            => 'Wikicode voor deze kaart:',
	'slippymap_button_code'     => 'Wikicode weergeven',
	'slippymap_resetview'       => 'Overzicht opnieuw instellen',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'slippymap_desc'            => 'Tillater bruk av taggen <tt>&lt;slippymap&gt;</tt> for å vise et «slippy map» fra OpenLayers. Kartene kommer fra [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing'      => 'Mangler «lat»-verdi (for breddegraden).',
	'slippymap_lonmissing'      => 'Mangler «lon»-verdi (for lengdegraden).',
	'slippymap_zoommissing'     => 'Mangler «z»-verdi (for zoom-nivået).',
	'slippymap_longdepreciated' => 'Bruk «lon» i stedet for «long» (parameteret fikk nytt navn).',
	'slippymap_widthnan'        => 'breddeverdien («w») «%1» er ikke et gyldig heltall',
	'slippymap_heightnan'       => 'høydeverdien («h»)',
	'slippymap_zoomnan'         => 'zoomverdien («z») «%1» er ikke et gyldig heltall',
	'slippymap_latnan'          => 'breddegradsverdien («lat») «%1» er ikke et gyldig tall',
	'slippymap_lonnan'          => 'lengdegradsverdien («lon») «%1» er ikke et gyldig tall',
	'slippymap_widthbig'        => 'breddeverdien («w») kan ikke være større enn 1000',
	'slippymap_widthsmall'      => 'breddeverdien («w») kan ikke være mindre enn 100',
	'slippymap_heightbig'       => 'høydeverdien («h») kan ikke være større enn 1000',
	'slippymap_heightsmall'     => 'høydeverdien («h») kan ikke være mindre enn 100',
	'slippymap_latbig'          => 'breddegradsverdien («lat») kan ikke være større enn 90',
	'slippymap_latsmall'        => 'breddegradsverdien («lat») kan ikke være mindre enn –90',
	'slippymap_lonbig'          => 'lengdegradsverdien («lon») kan ikke være større enn 180',
	'slippymap_lonsmall'        => 'lengdegradsverdien («lon») kan ikke være mindre enn –180',
	'slippymap_zoomsmall'       => 'zoomverdien («z») kan ikke være mindre enn null',
	'slippymap_zoom18'          => 'zoomverdien («z») kan ikke være større enn 17. Merk at denne MediaWiki-utvidelsen bruker OpenStreetMap-laget «osmarender», som ikke kan zoome mer enn til nivå 17. «Mapnik»-laget på openstreetmap.org går til zoomnivå 18.',
	'slippymap_zoombig'         => 'zoomverdien («z») kan ikke være større enn 17.',
	'slippymap_invalidlayer'    => 'Ugyldig «layer»-verdi «%1»',
	'slippymap_maperror'        => 'Kartfeil:',
	'slippymap_osmtext'         => 'Se dette kartet på OpenStreetMap.org',
	'slippymap_code'            => 'Wikikode for denne kartvisningen:',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author Siebrand
 */
$messages['oc'] = array(
	'slippymap_desc'            => 'Autoriza l’utilizacion de la balisa <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> per afichar una mapa lisanta d’OpenLayers. Las mapas provenon de [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing'      => 'Valor lat mancanta (per la latitud).',
	'slippymap_lonmissing'      => 'Valor lon mancanta (per la longitud).',
	'slippymap_zoommissing'     => 'Valor z mancanta (pel nivèl del zoom).',
	'slippymap_longdepreciated' => 'Utilizatz « lon » al luòc de « long » (lo paramètre es estat renomenat).',
	'slippymap_widthnan'        => "La largor (w) qu'a per valor « %1 » es pas un nombre entièr corrèct.",
	'slippymap_heightnan'       => "La nautor (h) qu'a per valor « %1 » es pas un nombre entièr corrèct.",
	'slippymap_zoomnan'         => "Lo zoom (z) qu'a per valor « %1 » es pas un nombre entièr corrèct.",
	'slippymap_latnan'          => "La latitud (lat) qu'a per valor « %1 » es pas un nombre corrèct.",
	'slippymap_lonnan'          => "La longitud (lon) qu'a per valor « %1 » es pas un nombre corrèct.",
	'slippymap_widthbig'        => 'La valor de la largor (w) pòt pas excedir 1000',
	'slippymap_widthsmall'      => 'La valor de la largor (w) pòt pas èsser inferiora a 100',
	'slippymap_heightbig'       => 'La valor de la nautor (h) pòt pas excedir 1000',
	'slippymap_heightsmall'     => 'La valor de la nautor (h) pòt pas èsser inferiora a 100',
	'slippymap_latbig'          => 'La valor de la latitud (lat) pòt pas excedir 90',
	'slippymap_latsmall'        => 'La valor de la latitud (lat) pòt pas èsser inferiora a -90',
	'slippymap_lonbig'          => 'La valor de la longitud (lon) pòt pas excedir 180',
	'slippymap_lonsmall'        => 'La valor de la longitud (lon) pòt pas èsser inferiora a -180',
	'slippymap_zoomsmall'       => 'La valor del zoom (z) pòt pas èsser negativa',
	'slippymap_zoom18'          => "La valor del zoom (z) pòt excedir 17. Notatz qu'aqueste croquet d’extension mediawiki dins lo jaç « osmarender » de OpenStreetMap pòt pas anar de delà del nivèl 17 del zoom. Lo jaç Mapnik disponible sus openstreetmap.org, pòt pas anar de delà del nivèl 18.",
	'slippymap_zoombig'         => 'La valor del zoom (z) pòt pas excedir 17.',
	'slippymap_invalidlayer'    => 'Valor de « %1 » del « jaç » incorrècta',
	'slippymap_maperror'        => 'Error de mapa :',
	'slippymap_osmtext'         => 'Vejatz aquesta mapa sus OpenStreetMap.org',
	'slippymap_code'            => "Còde Wiki pel visionament d'aquesta mapa :",
);

/** Polish (Polski)
 * @author Maikking
 */
$messages['pl'] = array(
	'slippymap_maperror' => 'Błąd mapy:',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'slippymap_desc'            => 'Umožňuje použitie značky <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> na zobrazenie posuvnej mapy OpenLayers. Mapy sú z [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing'      => 'Chýba hodnota lat (rovnobežka).',
	'slippymap_lonmissing'      => 'Chýba hodnota lon (poludník).',
	'slippymap_zoommissing'     => 'Chýba hodnota z (úroveň priblíženia)',
	'slippymap_longdepreciated' => 'Prosím, použite „lon” namiesto „long” (názov parametra sa zmenil).',
	'slippymap_widthnan'        => 'hodnota šírky (w) „%1” nie je platné celé číslo',
	'slippymap_heightnan'       => 'hodnota výšky (h) „%1” nie je platné celé číslo',
	'slippymap_zoomnan'         => 'hodnota úrovne priblíženia (z) „%1” nie je platné celé číslo',
	'slippymap_latnan'          => 'hodnota zemepisnej šírky (lat) „%1” nie je platné celé číslo',
	'slippymap_lonnan'          => 'hodnota zemepisnej dĺžky (lon) „%1” nie je platné celé číslo',
	'slippymap_widthbig'        => 'hodnota šírky (w) nemôže byť väčšia ako 1000',
	'slippymap_widthsmall'      => 'hodnota šírky (w) nemôže byť menšia ako 100',
	'slippymap_heightbig'       => 'hodnota výšky (h) nemôže byť väčšia ako 1000',
	'slippymap_heightsmall'     => 'hodnota výšky (h) nemôže byť menšia ako 100',
	'slippymap_latbig'          => 'hodnota zemepisnej dĺžky (h) nemôže byť väčšia ako 90',
	'slippymap_latsmall'        => 'hodnota zemepisnej dĺžky (h) nemôže byť menšia ako -90',
	'slippymap_lonbig'          => 'hodnota zemepisnej šírky (lon) nemôže byť väčšia ako 180',
	'slippymap_lonsmall'        => 'hodnota zemepisnej dĺžky (lon) nemôže byť menšia ako -180',
	'slippymap_zoomsmall'       => 'hodnota úrovne priblíženia (lon) nemôže byť menšia ako nula',
	'slippymap_zoom18'          => 'hodnota úrovne priblíženia (lon) nemôže byť väčšia ako 17. Toto rozšírenie MediaWiki využíva vrstvu „osmarender” OpenStreetMap, ktorá umožňuje úroveň priblíženia po 17. Vrstva Mapnik na openstreetmap.org umožňuje priblíženie do úrovne 18.',
	'slippymap_zoombig'         => 'hodnota úrovne priblíženia (lon) nemôže byť väčšia ako 17.',
	'slippymap_invalidlayer'    => 'Neplatná hodnota „layer” „%1”',
	'slippymap_maperror'        => 'Chyba mapy:',
	'slippymap_osmtext'         => 'Pozrite si túto mapu na OpenStreetMap.org',
	'slippymap_code'            => 'Wikikód tohto pohľadu na mapu:',
	'slippymap_button_code'     => 'Zobraziť zdrojový kód',
	'slippymap_resetview'       => 'Obnoviť zobrazenie',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Boivie
 */
$messages['sv'] = array(
	'slippymap_desc'            => 'Tillåter användning av taggen <tt>&lt;slippymap&gt;</tt> för att visa "slippy map" från OpenLayers. Kartorna kommer från [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing'      => 'Saknat "lat"-värde (för breddgraden).',
	'slippymap_lonmissing'      => 'Saknat "lon"-värde (för längdgraden).',
	'slippymap_zoommissing'     => 'Saknat z-värde (för zoom-nivån).',
	'slippymap_longdepreciated' => 'Var god använd "lon"  istället för "long" (parametern fick ett nytt namn).',
	'slippymap_widthnan'        => 'breddvärdet (w) "%1" är inte ett giltigt heltal',
	'slippymap_heightnan'       => 'höjdvärdet (h) "%1" är inte ett giltigt heltal',
	'slippymap_zoomnan'         => 'zoomvärdet (z) "%1" är inte ett giltigt heltal',
	'slippymap_latnan'          => 'breddgradsvärdet (lat) "%1" är inte ett giltigt nummer',
	'slippymap_lonnan'          => 'längdgradsvärdet (lon) "%1" är inte ett giltigt nummer',
	'slippymap_widthbig'        => 'breddvärdet (w) kan inte vara större än 1000',
	'slippymap_widthsmall'      => 'breddvärdet (w) kan inte vara mindre än 100',
	'slippymap_heightbig'       => 'höjdvärdet (h) kan inte vara större än 1000',
	'slippymap_heightsmall'     => 'höjdvärdet (h) kan inte vara mindre än 100',
	'slippymap_latbig'          => 'breddgradsvärdet (lat) kan inte vara större än 90',
	'slippymap_latsmall'        => 'breddgradsvärdet (lat) kan inte vara mindre än -90',
	'slippymap_lonbig'          => 'längdgradsvärdet (lon) kan inte vara större än 180',
	'slippymap_lonsmall'        => 'längdgradsvärdet (lon) kan inte vara mindre än -180',
	'slippymap_zoomsmall'       => 'zoomvärdet (z) kan inte vara mindre än noll',
	'slippymap_zoom18'          => "zoomvärdet (z) kan inte vara högre än 17. Observera att detta programtillägg använder OpenStreetMap-lagret 'osmarender', som inte kan zoomas mer än till nivå 17. Mapnik-lagret på openstreetmap.org zoomar till nivå 18",
	'slippymap_zoombig'         => 'zoomvärdet (z) kan inte vara högre än 17.',
	'slippymap_invalidlayer'    => "Ogiltigt 'layer'-värde '%1'",
	'slippymap_maperror'        => 'Kartfel:',
	'slippymap_osmtext'         => 'Se den här kartan på OpenStreetMap.org',
	'slippymap_code'            => 'Wikikod för denna kartvisning:',
	'slippymap_button_code'     => 'Hämta wikikod',
	'slippymap_resetview'       => 'Återställ visning',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'slippymap_maperror' => 'పటపు పొరపాటు:',
);

