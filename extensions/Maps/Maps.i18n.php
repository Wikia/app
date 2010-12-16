<?php

/**
 * Internationalization file for the Maps extension
 *
 * @file Maps.i18n.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
*/

$messages = array();

/** English
 * @author Jeroen De Dauw
 */
$messages['en'] = array(
	// General
	'maps_name' => 'Maps',
	'maps_desc' => "Provides the ability to display coordinate data in maps, and geocode addresses ([http://wiki.bn2vs.com/wiki/Maps demo]).
Available mapping services: $1",
	'maps_map' => 'Map',

	// Coordinate errors
	'maps_coordinates_missing' => 'No coordinates provided for the map.',
	'maps_geocoding_failed' => 'The following {{PLURAL:$2|address|addresses}} could not be geocoded: $1.',
	'maps_geocoding_failed_for' => 'The following {{PLURAL:$2|address|addresses}} could not be geocoded and {{PLURAL:$2|has|have}} been omitted from the map:
$1',
	'maps_unrecognized_coords' => 'The following coordinates were not recognized: $1.',
	'maps_unrecognized_coords_for' => 'The following {{PLURAL:$2|coordinate was|coordinates were}} not recognized and {{PLURAL:$2|has|have}} been omitted from the map:
$1',
	'maps_map_cannot_be_displayed' => 'The map cannot be displayed.',

	// Mapping services
	'maps_googlemaps2' => 'Google Maps v2',
	'maps_googlemaps3' => 'Google Maps v3',
	'maps_yahoomaps' => 'Yahoo! Maps',
	'maps_openlayers' => 'OpenLayers', 
	'maps_osm' => 'OpenStreetMap', 

	// Static maps
	'maps_click_to_activate' => 'Click to activate map',
	'maps_centred_on' => 'Map centered on $1, $2.',

	// Google Maps v2 overlays
	'maps_overlays' => 'Overlays',	
	'maps_photos' => 'Photos',
	'maps_videos' => 'Videos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcams'
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Purodha
 * @author Raymond
 */
$messages['qqq'] = array(
	'maps_name' => '{{Optional}}',
	'maps_desc' => '{{desc}}

* $1: a list of available map services',
	'maps_map' => '{{Identical|Map}}',
	'maps_geocoding_failed_for' => '* $1 is a list
* $2 is the number of list items for PLURAL use.',
	'maps_centred_on' => '$1 and $2 are latitude and longitude.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'maps_map' => 'Kaart',
	'maps_coordinates_missing' => 'Geen koördinate is vir die kaart verskaf nie.',
	'maps_unrecognized_coords' => 'Die volgende koördinate is nie herken nie: $1.',
	'maps_unrecognized_coords_for' => 'Die volgende {{PLURAL:$2|koördinaat|koördinate}} is nie herken nie en is uit die kaart weggelaat:
$1.',
	'maps_map_cannot_be_displayed' => 'Die kaart kan nie vertoon word nie.',
	'maps_click_to_activate' => 'Kliek om die kaart te aktiveer',
	'maps_centred_on' => 'Kaart gesentreer op $1, $2.',
	'maps_photos' => "Foto's",
	'maps_videos' => "Video's",
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webkameras',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'maps_name' => 'خرائط',
	'maps_desc' => 'يعطي إمكانية عرض معلومات التنسيق في الخرائط وعناوين الترميز الجغرافي ([http://wiki.bn2vs.com/wiki/Maps تجربة]).
خدمات الخرائط المتوفرة: $1',
	'maps_map' => 'خريطة',
	'maps_coordinates_missing' => 'لا إحداثيات موفرة للخريطة.',
	'maps_geocoding_failed' => '{{PLURAL:$2|العنوان التالي|العناوين التالية}} لم يمكن تكويدها جغرافيا: $1.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|العنوان التالي|العناوين التالية}} لم يمكن تكويدها جغرافيا و {{PLURAL:$2|تمت|تمت}} إزالتها من الخريطة:
$1',
	'maps_unrecognized_coords' => 'الإحداثيات التالية لم يتم التعرف عليها: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|الإحداثي التالي|الإحداثيات التالية}} لم يتم التعرف عليها و {{PLURAL:$2|تمت|تمت}} إزالتها من الخريطة:
$1',
	'maps_map_cannot_be_displayed' => 'الخريطة لا يمكن عرضها.',
	'maps_googlemaps2' => 'خرائط جوجل',
	'maps_yahoomaps' => 'خرائط ياهو!',
	'maps_openlayers' => 'أوبن لايرز',
	'maps_osm' => 'أوبن ستريت ماب',
	'maps_click_to_activate' => 'اضغط لتنشيط الخريطة',
	'maps_centred_on' => 'الخريطة مركزها في $1، $2.',
	'maps_overlays' => 'الطبقات الإضافية',
	'maps_photos' => 'صور',
	'maps_videos' => 'فيديوهات',
	'maps_wikipedia' => 'ويكيبيديا',
	'maps_webcams' => 'كاميرات الويب',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'maps_name' => 'خرايط',
	'maps_googlemaps2' => 'خرايط جوجل',
	'maps_yahoomaps' => 'خرايط ياهو',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'maps_desc' => 'Забясьпечвае магчымасьць адлюстраваньня каардынатных зьвестак на мапах і геаграфічнага кадаваньня адрасоў ([http://wiki.bn2vs.com/wiki/Maps дэманстрацыя]). Даступныя геаграфічныя сэрвісы: $1',
	'maps_map' => 'Мапа',
	'maps_coordinates_missing' => 'Каардынаты для мапы не пазначаныя.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Наступны адрас ня можа быць геакадаваны|Наступныя адрасы ня могуць быць геакадаваныя}}: $1.
Мапа ня можа быць паказана.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Наступны адрас ня можа быць геакадаваны і быў выдалены|Наступныя адрасы ня могуць быць геакадаваны і былі выдаленыя}} з мапы:
$1',
	'maps_unrecognized_coords' => 'Наступныя каардынаты не былі распазнаныя: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Наступная каардыната не была апазнаная|Наступныя каардынаты не былі апазнаныя}} і {{PLURAL:$2|яна не паказаная|яны не паказаныя}}:
$1',
	'maps_map_cannot_be_displayed' => 'Мапа ня можа быць паказаная.',
	'maps_click_to_activate' => 'Націсьніце для актывацыі мапы',
	'maps_centred_on' => 'Цэнтар мапы — $1, $2.',
	'maps_overlays' => 'Слаі',
	'maps_photos' => 'Фотаздымкі',
	'maps_videos' => 'Відэа',
	'maps_wikipedia' => 'Вікіпэдыя',
	'maps_webcams' => 'Ўэб-камэры',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'maps_map' => 'Карта',
	'maps_photos' => 'Снимки',
	'maps_wikipedia' => 'Уикипедия',
	'maps_webcams' => 'Уебкамери',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'maps_desc' => "Talvezout a ra da embann daveennoù ha chomlec'hioù geokod war kartennoù ([http://wiki.bn2vs.com/wiki/Maps demo]). Servijoù kartennaouiñ hegerz : $1",
	'maps_map' => 'Kartenn',
	'maps_coordinates_missing' => "N'eus bet spisaet daveenn ebet evit ar gartenn.",
	'maps_geocoding_failed' => "N'eus ket bet gallet douarkodañ ar {{PLURAL:$2|chomlec'h|chomlec'h}} da-heul : $1.
N'haller ket diskwel ar gartenn.",
	'maps_geocoding_failed_for' => "N'eus ket bet gallet douarkodañ ar {{PLURAL:$2|chomlec'h|chomlec'h}} da-heul, setu {{PLURAL:$2|n'eo|n'int}} ket bet lakaet war ar gartenn : 
$1",
	'maps_unrecognized_coords' => "N'eo ket bet anavezet an daveennoù da-heul : $1.",
	'maps_unrecognized_coords_for' => "N'eo ket bet anavezet an {{PLURAL:$2|daveenn|daveennoù}} da-heul ha {{PLURAL:$2|n'eo|n'int}} ket bet lakaet war ar gartenn :
$1",
	'maps_map_cannot_be_displayed' => "Ar gartenn ne c'hall ket bezañ diskwelet.",
	'maps_click_to_activate' => 'Klikañ evit gweredekaat  ar gartenn',
	'maps_centred_on' => 'Kartenn kreizet war $1, $2.',
	'maps_overlays' => 'Dreistlakadennoù',
	'maps_photos' => "Luc'hskeudennoù",
	'maps_videos' => 'Videoioù',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Kameraoù web',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'maps_desc' => 'Daje mogućnost prikazivanja podataka koordinata na mapama i geocode adresa ([http://wiki.bn2vs.com/wiki/Maps demo]).
Dostupne usluge mapa: $1',
	'maps_map' => 'Mapa',
	'maps_coordinates_missing' => 'Za mapu nisu navedene koordinate.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Slijedeća adresa nije mogla biti geokodirana|Slijedeće adrese nisu mogle biti geokodirane}}: $1.
Mapa se ne može prikazati.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Slijedeća adresa nije|Slijedeće adrese nisu}} mogle biti geokodiranje i {{PLURAL:$2|izostavljena je|izostavljene su}} iz mape:
$1',
	'maps_unrecognized_coords' => 'Slijedeće koordinate nisu prepoznate: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Slijedeća koordinata nije|Slijedeće koordinate nisu}} prepoznate i {{PLURAL:$2|ignorirana je|ignorirane su}} na karti:
$1',
	'maps_map_cannot_be_displayed' => 'Karta se ne može prikazati.',
	'maps_click_to_activate' => 'Kliknite da aktivirate kartu',
	'maps_centred_on' => 'Karta centrirana na $1, $2.',
	'maps_overlays' => 'Slojevi',
	'maps_photos' => 'Fotografije',
	'maps_videos' => 'Video snimci',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Web kamere',
);

/** Catalan (Català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'maps_coordinates_missing' => "No s'han proporcionat coordenades pel mapa.",
);

/** German (Deutsch)
 * @author DaSch
 * @author Imre
 */
$messages['de'] = array(
	'maps_desc' => 'Ermöglicht es, Koordinaten in Karten anzuzeigen und Adressen zu geokodieren ([http://wiki.bn2vs.com/wiki/Maps Demonstration]).
Verfügbare Kartografie-Dienste: $1',
	'maps_map' => 'Karte',
	'maps_coordinates_missing' => 'Es wurden keine Koordinaten für die Karte angegeben.',
	'maps_geocoding_failed' => 'Die {{PLURAL:$2|folgende Adresse|folgenden Adressen}} konnten nicht geokodiert werden: $1.',
	'maps_geocoding_failed_for' => 'Die {{PLURAL:$2|folgende Adresse konnte|folgenden Adressen konnten}} nicht geokodiert werden und {{PLURAL:$2|wurde|wurden}} auf der Karte nicht berücksichtigt:
$1',
	'maps_unrecognized_coords' => 'Folgende Koordinaten wurden nicht erkannt: $1.',
	'maps_unrecognized_coords_for' => 'Die {{PLURAL:$2|folgende Koordinate wurde|folgenden Koordinaten wurden}} nicht erkannt und {{PLURAL:$2|wurde|wurden}} auf der Karte nicht berücksichtigt:
$1',
	'maps_map_cannot_be_displayed' => 'Diese Karte kann nicht angezeigt werden.',
	'maps_click_to_activate' => 'Klicken um Karte zu aktivieren',
	'maps_centred_on' => 'Karte ist zentriert auf $1, $2.',
	'maps_overlays' => 'Einblendungen',
	'maps_photos' => 'Fotos',
	'maps_videos' => 'Videos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcams',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'maps_desc' => 'Bitujo móžnosć koordinatowe daty w geografiskich kórtach a geokodowe adrese zwobrazniś. ([http://wiki.bn2vs.com/wiki/Maps demo]).
K dispoziciji stojece kórtowe słužby: $1',
	'maps_map' => 'Karta',
	'maps_coordinates_missing' => 'Za kórtu njejsu koordinaty pódane.',
	'maps_geocoding_failed' => 'Geokoděrowanje {{PLURAL:$2|slědujuceje adrese|slědujuceju adresowu|slědujucych adresow|slědujucych adresow}} njejo móžno było: $1. Kórta njedajo se zwobrazniś.',
	'maps_geocoding_failed_for' => 'Geokoděrowanje {{PLURAL:$2|slědujuceje adrese|slědujuceju adresowu|slědujucych adresow|slědujucych adresow}} njejo móžno było a togodla toś {{PLURAL:$2|ta adresa wuwóstaja|tej adresy wuwóstajotej|te adrese wuwóstajaju|te adresy wuwóstajaju}} se na kórśe: $1',
	'maps_unrecognized_coords' => 'Slědujuce koordinaty njejsu se spóznali: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Slědujuca koordinata njejo se spóznała|Slědujucej koordinaśe stej se spóznałej|Slědujuce koordinaty su se spóznali|Slědujuce koordinaty su se spóznali}} a {{PLURAL:$2|njejo se wuwóstajiła|njejstej se wuwóstajiłej|njejsu wuwóstajili|njejsu se wuwóstajili}} na kórśe: $1',
	'maps_map_cannot_be_displayed' => 'Kórta njedajo se zwobrazniś.',
	'maps_click_to_activate' => 'Klikni, aby kórtu aktiwěrował',
	'maps_centred_on' => 'Kórta na $1, $2 centrěrowana.',
	'maps_overlays' => 'Pśekšyśa',
	'maps_photos' => 'Fota',
	'maps_videos' => 'Wideo',
	'maps_wikipedia' => 'Wikipedija',
	'maps_webcams' => 'Webcamy',
);

/** Greek (Ελληνικά)
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'maps_coordinates_missing' => 'Καμία συντεταγμένη δεν παρασχέθηκε για τον χάρτη.',
	'maps_photos' => 'Φωτογραφίες',
	'maps_videos' => 'Βίντεο',
	'maps_wikipedia' => 'Βικιπαίδεια',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'maps_map_cannot_be_displayed' => 'La mapo ne esti montrebla.',
	'maps_click_to_activate' => 'Klaku aktivigi mapon',
	'maps_photos' => 'Fotoj',
	'maps_wikipedia' => 'Vikipedio',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Peter17
 * @author Translationista
 */
$messages['es'] = array(
	'maps_desc' => 'Proporciona la capacidad de mostrar los datos de coordenadas en los mapas y geocodifica direcciones ([http://wiki.bn2vs.com/wiki/Maps demo]). Servicios de mapeo disponibles: $1',
	'maps_map' => 'Mapa',
	'maps_coordinates_missing' => 'Sin coordenadas provistas para el mapa.',
	'maps_geocoding_failed' => 'Las siguientes {{PLURAL:$2|dirección|direcciones}}  no han podido ser geocodificadas: $1.
No se puede mostrar el mapa.',
	'maps_geocoding_failed_for' => 'No fue posible geocodificar {{PLURAL:$2|la siguiente dirección, que ha sido omitida|las siguientes direcciones, que han sido omitidas}} del mapa:$1.',
	'maps_unrecognized_coords' => 'Las siguientes coordenadas no fueron reconocidas: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|La coordenada siguiente no es reconocida|Las coordenadas siguientes no son reconocidas}} y PLURAL:$2|{{han sido omitidas|han sido omitidas}} del mapa :$1',
	'maps_map_cannot_be_displayed' => 'No se puede mostrar el mapa.',
	'maps_click_to_activate' => 'Haz clic para activar el mapa',
	'maps_centred_on' => 'Mapa centrado en $1, $2.',
	'maps_overlays' => 'Superposiciones',
	'maps_photos' => 'Fotos',
	'maps_videos' => 'Videos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Cámaras Web',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'maps_coordinates_missing' => 'Ez dago koordenaturik maparentzat.',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'maps_desc' => 'Mahdollistaa koordinaattitiedon esittämisen karttoina ja osoitteiden geokoodauksen ([http://wiki.bn2vs.com/wiki/Maps demo]).
Käytettävissä olevat karttapalvelut: $1',
	'maps_map' => 'Kartta',
	'maps_coordinates_missing' => 'Karttaa varten ei tarjottu koordinaatteja.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Seuraavaa osoitetta|Seuraavia osoitteita}} ei voitu geokoodata: $1.
Karttaa ei voida näyttää.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Seuraavaa osoitetta|Seuraavia osoitteita}} ei voitu geokoodata ja {{PLURAL:$2|on|ovat}} jätetty kartalta: $1',
	'maps_unrecognized_coords' => 'Seuraavia koordinaatteja ei tunnistettu: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Seuraavaa koordinaattia|Seuraavia koordinaatteja}} ei tunnistettu ja {{PLURAL:$2|se|ne}} on jätetty pois kartasta:
$1',
	'maps_map_cannot_be_displayed' => 'Karttaa ei voida näyttää.',
	'maps_click_to_activate' => 'Napsauta aktivoidaksesi kartan',
	'maps_centred_on' => 'Kartta keskitetty kohtaan $1, $2.',
	'maps_overlays' => 'Kerrokset',
	'maps_photos' => 'Kuvat',
	'maps_videos' => 'Videot',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Web-kamerat',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author Jean-Frédéric
 * @author McDutchie
 * @author PieRRoMaN
 * @author Verdy p
 */
$messages['fr'] = array(
	'maps_name' => 'Cartes',
	'maps_desc' => 'Permet d’afficher des coordonnées dans des cartes, ainsi que des adresses géocodées ([http://wiki.bn2vs.com/wiki/Maps démonstration]).
Services de cartographie disponibles : $1',
	'maps_map' => 'Carte',
	'maps_coordinates_missing' => "Aucune coordonnée n'a été fournie pour le plan.",
	'maps_geocoding_failed' => "{{PLURAL:$2|L′adresse suivante n'as pu être géocodée|Les adresses suivantes n'ont pas pu être géocodées}} : $1.
Le plan ne peut pas être affiché.",
	'maps_geocoding_failed_for' => '{{PLURAL:$2|L′adresse suivante n’as pu être géocodée|Les adresses suivantes n’ont pas pu être géocodées}} et {{PLURAL:$2|n’est pas affichée|ne sont pas affichées}} sur le plan : $1',
	'maps_unrecognized_coords' => "Les coordonnées suivantes n'ont pas été reconnues : $1.",
	'maps_unrecognized_coords_for' => "{{PLURAL:$2|La coordonnée suivante n'a pas été reconnue|Les coordonnées suivantes n'ont pas été reconnues}} et {{PLURAL:$2|a été omise|ont été omises}} sur la carte :
$1",
	'maps_map_cannot_be_displayed' => 'La carte ne peut pas être affichée.',
	'maps_click_to_activate' => 'Cliquer pour activer la carte',
	'maps_centred_on' => 'Carte centrée sur $1, $2.',
	'maps_overlays' => 'Superpositions',
	'maps_photos' => 'Photos',
	'maps_videos' => 'Vidéos',
	'maps_wikipedia' => 'Wikipédia',
	'maps_webcams' => 'Webcams',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'maps_desc' => 'Al furnìs la possibilitât di mostrâ i dâts de coordinadis e lis direzions geocodificadis intune mape ([http://wiki.bn2vs.com/wiki/Maps demo]).
Servizis di mapis disponibii: $1',
	'maps_map' => 'Mape',
	'maps_coordinates_missing' => 'Nissune coordenade furnide pe mape.',
	'maps_geocoding_failed' => '{{PLURAL:$2|La direzion ca sot no pues jessi geocodificade|Lis direzions ca sot no puedin jessi geocodificadis}}: $1.
La mape no pues jessi mostrade.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|La direzion|Lis direzions}} ca sot no {{PLURAL:$2|pues|puedin}} jessi {{PLURAL:$2|geocodificade|geocodificadis}} e  {{PLURAL:$2|no je mostrade|no son mostradis}} te mape:
$1',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'maps_desc' => 'Proporciona a capacidade de mostrar datos de coordenadas en mapas, e enderezos xeocodificados ([http://wiki.bn2vs.com/wiki/Maps demostración]).
Servizos de cartografía dispoñibles: $1',
	'maps_map' => 'Mapa',
	'maps_coordinates_missing' => 'Non se proporcionou ningunha coordenada para o mapa.',
	'maps_geocoding_failed' => '{{PLURAL:$2|O seguinte enderezo non se puido xeocodificar|Os seguintes enderezos non se puideron xeocodificar}}: $1.
O mapa non se pode mostrar.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|O seguinte enderezo non se puido xeocodificar|Os seguintes enderezos non se puideron xeocodificar}} e {{PLURAL:$2|omitiuse|omitíronse}} no mapa: $1.',
	'maps_unrecognized_coords' => 'Non se recoñeceron as seguintes coordenadas: $1.',
	'maps_unrecognized_coords_for' => 'Non se {{PLURAL:$2|recoñeceu a seguinte coordenada|recoñeceron as seguintes coordenadas}} e {{PLURAL:$2|foi omitida|foron omitidas}} do mapa:
$1',
	'maps_map_cannot_be_displayed' => 'O mapa non se pode mostrar.',
	'maps_click_to_activate' => 'Prema para activar o mapa',
	'maps_centred_on' => 'Mapa centrado en $1, $2.',
	'maps_overlays' => 'Sobreposicións',
	'maps_photos' => 'Fotos',
	'maps_videos' => 'Vídeos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Cámaras web',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'maps_desc' => 'Ergänzt d Megligkeit Koordinatedate in Charte un Geocodeadrässe aazzeige. Verfiegbari Chartedienscht: $1. [http://www.mediawiki.org/wiki/Extension:Maps Dokumäntation]. [http://wiki.bn2vs.com/wiki/Maps Demo]',
	'maps_map' => 'Charte',
	'maps_coordinates_missing' => 'S git kei Koordinate fir die Charte.',
	'maps_geocoding_failed' => 'Die {{PLURAL:$2|Adräss het|Adräss hän}} nit chenne georeferänziert wäre: $1. D Charte cha nit aazeigt wäre.',
	'maps_geocoding_failed_for' => 'Die {{PLURAL:$2|Adräss het|Adrässe hän}} nit chenne georeferänziert wäre un {{PLURAL:$2|isch|sin}} us dr Charte uusegnuu wore: $1',
	'maps_unrecognized_coords' => 'Die Koordinate sin nit erkannt wore: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Die Koordinate isch nit erkannt wore un isch|Die Koordinate sin nit erkannt wore un sin}} wäge däm uusegnuu wore us dr Charte:
$1',
	'maps_map_cannot_be_displayed' => 'D Charte cha nit aazeigt wäre.',
	'maps_click_to_activate' => 'Klick go d Charte aktiviere',
	'maps_centred_on' => 'Charte zäntriert uf $1, $2.',
	'maps_overlays' => 'Overlay',
	'maps_photos' => 'Foto',
	'maps_videos' => 'Video',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcam',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'maps_desc' => 'הוספת האפשרות להצגת נתוני קואורדינטות במפות וכתובות geocode ([http://wiki.bn2vs.com/wiki/Maps demo]).
שירותי המיפוי הזמינים: $1',
	'maps_map' => 'מפה',
	'maps_coordinates_missing' => 'לא סופקו קואורדינטות למפה.',
	'maps_geocoding_failed' => 'לא ניתן לייצר geocode עבור {{PLURAL:$2|הכתובת הבאה|הכתובות הבאות}}: $1.
לא ניתן להציג את המפה.',
	'maps_geocoding_failed_for' => 'לא ניתן לייצר geocode עבור {{PLURAL:$2|הכתובת הבאה|הכתובות הבאות}}, ולכן {{PLURAL:$2|היא הושמטה|הן הושמטו}} מהמפה:
$1',
	'maps_unrecognized_coords' => 'הקואורדינטות הבאות אינן מזוהות: $1.',
	'maps_map_cannot_be_displayed' => 'לא ניתן להציג את המפה.',
	'maps_click_to_activate' => 'יש ללחוץ כדי להפעיל את המפה',
	'maps_centred_on' => 'המפה ממורכזת סביב $1,$2',
	'maps_overlays' => 'שכבות',
	'maps_photos' => 'תמונות',
	'maps_videos' => 'סרטוני וידאו',
	'maps_wikipedia' => 'ויקיפדיה',
	'maps_webcams' => 'מצלמות אינטרנט',
);

/** Croatian (Hrvatski)
 * @author Ex13
 */
$messages['hr'] = array(
	'maps_desc' => 'Pruža mogućnost prikaza podataka o koordinatama na kartama, te geokodiranih adresa ([http://wiki.bn2vs.com/wiki/Maps demo]). Dostupne usluge kartiranja: $1',
	'maps_coordinates_missing' => 'Za kartu nisu dostupne koordinate.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Sljedeća adresa ne može biti geokodirana|Sljedeće adrese ne mogu biti geokodirane}}: $1.
Karta ne može biti prikazana.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Sljedeća adresa ne može biti geokodirana|Sljedeće adrese ne mogu biti geokodirane}} i {{PLURAL:$2|izostavljena je|izostavljene su}} iz karte:
$1',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'maps_desc' => 'Skići móžnosć koordinatowe daty w geografiskich kartach a geokodne adresy zwobraznić ([http://wiki.bn2vs.com/wiki/Maps demo]). 
K dispoziciji stejace kartowe słužby: $1',
	'maps_map' => 'Karta',
	'maps_coordinates_missing' => 'Za kartu njejsu koordinaty podate.',
	'maps_geocoding_failed' => 'Geokodowanje {{PLURAL:$2|slědowaceje adresy|slědowaceju adresow|slědowacych adresow|slědowacych adresow}} njebě móžno: $1. Karta njeda so zwobraznić.',
	'maps_geocoding_failed_for' => 'Geokodowanje {{PLURAL:$2|slědowaceje adresy|slědowaceju adresow|slědowacych adresow|slědowacych adresow}} njebě móžno a {{PLURAL:$2|tuta adresa|tutej adresy|tute adresy|tute adresy}} so na karće {{PLURAL:$2|wuwostaja|wuwostajetej|wuwostajeja|wuwostajeja}}: $1',
	'maps_unrecognized_coords' => 'Slědowace koordinaty njebuchu spóznane: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Slědowaca koordinata njebu spóznana|Slědowacej koordinaće njebuštej spóznanej|Slědowace koordinaty njebuchu spóznane|Slědowace koordinaty njebuchu spóznane}} a {{PLURAL:$2|bu na karće wuwostajena|buštej na karće wuwostajenej|buchu na karće wuwostajene|buchu na karće wuwostajene}}: $1',
	'maps_map_cannot_be_displayed' => 'Karta njeda so zwobraznić.',
	'maps_click_to_activate' => 'Klikń, zo by kartu aktiwizował',
	'maps_centred_on' => 'Karta na $1, $2 centrowana.',
	'maps_overlays' => 'Naworštowanja',
	'maps_photos' => 'Fota',
	'maps_videos' => 'Wideja',
	'maps_wikipedia' => 'Wikipedija',
	'maps_webcams' => 'Webcamy',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'maps_desc' => 'Lehetővé teszi koordinátaadatok és geokódolt címek megjelenítését térképeken ([http://wiki.bn2vs.com/wiki/Maps demó]). Elérhető térképszolgáltatások: $1',
	'maps_map' => 'Térkép',
	'maps_coordinates_missing' => 'Nincsenek megadva koordináták a térképhez.',
	'maps_geocoding_failed' => 'A következő {{PLURAL:$2|cím|címek}} nem geokódolhatók: $1.
A térképet nem lehet megjeleníteni.',
	'maps_geocoding_failed_for' => 'A következő {{PLURAL:$2|cím nem geokódolható|címek nem geokódolhatóak}}, és nem {{PLURAL:$2|szerepel|szerepelnek}} a térképen:
$1',
	'maps_unrecognized_coords' => 'A következő koordinátákat nem sikerült felismerni: $1.',
	'maps_unrecognized_coords_for' => 'A következő {{PLURAL:$2|koordinátát|koordinátákat}} nem sikerült felismerni, és el {{PLURAL:$2|lett|lettek}} távolítva a térképről: $1',
	'maps_map_cannot_be_displayed' => 'A térképet nem sikerült megjeleníteni.',
	'maps_click_to_activate' => 'Kattints a térkép aktiválásához',
	'maps_centred_on' => 'Térkép középre igazítva a következő koordináták alapján: $1, $2.',
	'maps_overlays' => 'Rétegek',
	'maps_photos' => 'Fényképek',
	'maps_videos' => 'Videók',
	'maps_wikipedia' => 'Wikipédia',
	'maps_webcams' => 'Webkamerák',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'maps_desc' => 'Permitte monstrar datos de coordinatas in mappas, e adresses geocodice ([http://wiki.bn2vs.com/wiki/Maps demo]).
Servicios cartographic disponibile: $1',
	'maps_map' => 'Carta',
	'maps_coordinates_missing' => 'Nulle coordinata providite pro le mappa.',
	'maps_geocoding_failed' => 'Le sequente {{PLURAL:$2|adresse|adresses}} non poteva esser geocodificate: $1.
Le mappa non pote esser monstrate.',
	'maps_geocoding_failed_for' => 'Le sequente {{PLURAL:$2|adresse|adresses}} non poteva esser geocodificate e ha essite omittite del mappa:
$1',
	'maps_unrecognized_coords' => 'Le sequente coordinatas non esseva recognoscite: $1.',
	'maps_unrecognized_coords_for' => 'Le sequente {{PLURAL:$2|coordinata|coordinatas}} non esseva recognoscite e ha essite omittite del carta:
$1',
	'maps_map_cannot_be_displayed' => 'Le carta on pote esser monstrate.',
	'maps_click_to_activate' => 'Clicca pro activar le carta',
	'maps_centred_on' => 'Carta centrate super $1, $2.',
	'maps_overlays' => 'Superpositiones',
	'maps_photos' => 'Photos',
	'maps_videos' => 'Videos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Cameras web',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 */
$messages['id'] = array(
	'maps_desc' => "Memampukan tampilan data koordinat pada peta, dan alamat ''geocode'' ([http://wiki.bn2vs.com/wiki/Maps demo]). 
Layanan pemetaan yang tersedia: $1",
	'maps_map' => 'Peta',
	'maps_coordinates_missing' => 'Tidak koordinat yang disediakan bagi peta.',
	'maps_geocoding_failed' => '{{PLURAL:$2|alamat|alamat}} berikut tidak dapat di Geocode: $1. 
Peta tidak dapat ditampilkan.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|alamat|alamat}} berikut tidak dapat di Geocode dan  {{PLURAL:$2|telah|telah}} dihilangkan dari peta: $1',
	'maps_unrecognized_coords' => 'Koordinat berikut tidak dikenali: $1.',
	'maps_unrecognized_coords_for' => 'Koordinat berikut tidak dikenali dan {{PLURAL:$2|telah|telah}} diabaikan dari peta:
$1',
	'maps_map_cannot_be_displayed' => 'Peta tak dapat ditampilkan.',
	'maps_click_to_activate' => 'Klik untuk mengaktifkan peta',
	'maps_overlays' => 'Hamparan',
	'maps_photos' => 'Foto',
	'maps_videos' => 'Video',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Kamera web',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'maps_map' => 'Otú Uzọr',
	'maps_photos' => 'Onyònyò',
	'maps_videos' => 'Enyónyó-na-jé',
	'maps_wikipedia' => 'Wikipedia',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'maps_desc' => '地図上に座標データを表示し、住所を座標データに変換する機能を提供する ([http://wiki.bn2vs.com/wiki/Maps 実演])。次の地図サービスに対応します: $1',
	'maps_map' => '地図',
	'maps_coordinates_missing' => '地図に座標が指定されていません。',
	'maps_geocoding_failed' => '指定された{{PLURAL:$2|住所}}の座標への変換に失敗しました。 $1。地図は表示できません。',
	'maps_geocoding_failed_for' => '指定された{{PLURAL:$2|住所|複数の住所}}の座標への変換に失敗したため、それらを地図から除外して表示します。$1',
	'maps_unrecognized_coords' => '以下の座標は認識されませんでした: $1',
	'maps_unrecognized_coords_for' => '以下の{{PLURAL:$2|座標}}は認識されなかったため、地図から省かれています:
$1',
	'maps_map_cannot_be_displayed' => 'この地図は表示できません。',
	'maps_click_to_activate' => 'クリックして地図をアクティブに',
	'maps_centred_on' => '地図の中心は $1、$2。',
	'maps_overlays' => 'オーバーレイ',
	'maps_photos' => '写真',
	'maps_videos' => '動画',
	'maps_wikipedia' => 'ウィキペディア',
	'maps_webcams' => 'ウェブカメラ',
);

/** Georgian (ქართული)
 * @author Temuri rajavi
 */
$messages['ka'] = array(
	'maps_map' => 'რუკა',
	'maps_videos' => 'ვიდეოები',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'maps_wikipedia' => 'ವಿಕಿಪೀಡಿಯ',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'maps_desc' => 'Määt et müjjelesch, Koodinaate en Landkaate aanzezeije, un Addräße en Koodinaate op de Ääd ömzerääschne. (E [http://wiki.bn2vs.com/wiki/Maps Beispöll]). He di Deenste för Landkaat(e) ham_mer ze beede: $1',
	'maps_map' => 'Kaat',
	'maps_coordinates_missing' => 'Mer han kein Koodinaate för di Kaat.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Di Koodinaat|De Koodinaate|Kein Koodinaat}} om Jlobus för di {{PLURAL:$2|aanjejovve Adräß wohr|aanjejovve Adräße wohre|kein aanjejovve Adräß wohr}} Kappes: $1. Di Kaat künne mer su nit aanzeije.',
	'maps_geocoding_failed_for' => 'De Koodinaate om Jlobus för {{PLURAL:$2|ein|paa|kein}} vun dä aanjejovve Adräße {{PLURAL:$2|es|wohre|Fähler!}} Kappes. Di {{PLURAL:$2|es|sin|Fähler!}} dröm nit op dä Kaat. De fottjelohße {{PLURAL:$2|es|sin|Fähler!}}: $1',
	'maps_unrecognized_coords' => 'He di Koordinate kunnte mer nit verschtonn: $1.',
	'maps_unrecognized_coords_for' => 'He di {{PLURAL:$2|Koordinat kunnt|Koordinate kunnte}} mer nit verschtonn un dröm {{PLURAL:$2|es|sin}} se nit en de Kaat opjenumme woode:
$1',
	'maps_map_cannot_be_displayed' => 'Di Kaat künne mer nit aanzeije.',
	'maps_click_to_activate' => 'Donn klecke, öm op di Kaat ze jonn',
	'maps_overlays' => 'Enbländunge',
	'maps_photos' => 'Fottos',
	'maps_videos' => 'Viddejos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webkammeras',
);

/** Ladino (Ladino)
 * @author Universal Life
 */
$messages['lad'] = array(
	'maps_wikipedia' => 'Vikipedia',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'maps_desc' => "Gëtt d'Méiglechkeet fir d'Date vun de Koordinaten op Kaarten an Geocode Adressen ze weisen. Disponibel mapping Servicer: $1 [http://www.mediawiki.org/wiki/Extension:Maps Dokumentatioun]. [http://wiki.bn2vs.com/wiki/Maps Démo]",
	'maps_map' => 'Kaart',
	'maps_coordinates_missing' => "Et goufe keng Koordinate fir d'Kaart uginn.",
	'maps_geocoding_failed' => 'Dës {{PLURAL:$2|Adress konnt|Adresse konnten}} net geocodéiert ginn: $1',
	'maps_geocoding_failed_for' => 'Dës {{PLURAL:$2|Adress|Adresse}} konnten net geocodéiert ginn an {{PLURAL:$2|huet|hu}} missen op der Kaart ewechgelooss ginn:
$1',
	'maps_unrecognized_coords' => 'Dës Koordinate goufen net erkannt: $1',
	'maps_unrecognized_coords_for' => 'Dës {{PLURAL:$2|Koordinate|Koordinate}} goufen net erkannt a vun der Kaart ignoréiert:
$1',
	'maps_map_cannot_be_displayed' => "D'Kaart kann net gewise ginn.",
	'maps_click_to_activate' => "Klickt fir d'kaart z'aktivéieren",
	'maps_centred_on' => "D'Kaart ass zentréiert op $1, $2",
	'maps_overlays' => 'Ablendungen',
	'maps_photos' => 'Fotoen',
	'maps_videos' => 'Videoen',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Web-Kameraen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author McDutchie
 */
$messages['mk'] = array(
	'maps_desc' => 'Дава можност за приказ на координатни податоци во картите, и геокодирање на адреси ([http://wiki.bn2vs.com/wiki/Maps демо]).
Картографски служби на располагање: $1',
	'maps_map' => 'Карта',
	'maps_coordinates_missing' => 'Нема координати за картата.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Следнава адреса не можеше да се геокодира|Следниве адреси не можеа да се геокодираат}}: $1.
Картата не може да се прикаже.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Следнава адреса не можеше да се геокодира|Следниве адреси не можеа да се геокодираат}} и затоа {{PLURAL:$2|беше изоставена|беа изоставени}} од картата:
$1',
	'maps_unrecognized_coords' => 'Следниве координати не беа препознаени: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Следнава координата не беше препознаена|Следниве координати не беа препознаени}} и {{PLURAL:$2|беше изоставена|беа изоставени}} од картата:
$1',
	'maps_map_cannot_be_displayed' => 'Картата не може да се прикаже.',
	'maps_click_to_activate' => 'Кликнете за активирање на картата',
	'maps_centred_on' => 'Средиште на картата во $1, $2.',
	'maps_overlays' => 'Слоеви',
	'maps_photos' => 'Фотографии',
	'maps_videos' => 'Видеа',
	'maps_wikipedia' => 'Википедија',
	'maps_webcams' => 'Веб-камери',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'maps_desc' => 'Biedt de mogelijkheid om locatiegegevens weer te geven op kaarten en adressen om te zetten naar coordinaten ([http://wiki.bn2vs.com/wiki/Semantic_Maps demo]).
Beschikbare kaartdiensten: $1',
	'maps_map' => 'Kaart',
	'maps_coordinates_missing' => 'Er zijn geen coördinaten opgegeven voor de kaart.',
	'maps_geocoding_failed' => 'Voor {{PLURAL:$2|het volgende adres|de volgende adressen}} was geocodering niet mogelijk: $1
De kaart kan niet worden weergegeven.',
	'maps_geocoding_failed_for' => 'Voor {{PLURAL:$2|het volgende adres|de volgende adressen}} was geocodering niet mogelijk en {{PLURAL:$2|dit is|deze zijn}} weggelaten uit de kaart:
$1',
	'maps_unrecognized_coords' => 'De volgende coördinaten zijn niet herkend: $1.',
	'maps_unrecognized_coords_for' => 'De volgende {{PLURAL:$2|coördinaat is niet herkend en is|coördinaten zijn niet herkend en zijn}} weggelaten uit de kaart:
$1.',
	'maps_map_cannot_be_displayed' => 'De kaart kan niet weergegeven worden.',
	'maps_googlemaps2' => 'Google Maps v2',
	'maps_yahoomaps' => 'Yahoo! Maps',
	'maps_openlayers' => 'OpenLayers',
	'maps_click_to_activate' => 'Klik om de kaart te activeren',
	'maps_centred_on' => 'Kaart gecentreerd op $1, $2.',
	'maps_overlays' => "Overlay's",
	'maps_photos' => "Foto's",
	'maps_videos' => 'Video',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcams',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'maps_map' => 'Kart',
	'maps_coordinates_missing' => 'Ingen koordinatar vart oppgjevne for kartet.',
	'maps_unrecognized_coords' => 'Dei fylgjande koordinatane vart ikkje kjende att: $1.',
	'maps_map_cannot_be_displayed' => 'Kartet kan ikkje verta vist.',
	'maps_click_to_activate' => 'Trykk for å aktivera kartet',
	'maps_centred_on' => 'Kart sentrert på $1, $2.',
	'maps_photos' => 'Bilete',
	'maps_videos' => 'Videoar',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webkamera',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'maps_desc' => 'Gir mulighet for å vise koorinatdata i kart og geokodeadresser ([http://wiki.bn2vs.com/wiki/Maps demo]).
Tilgjengelige karttjenester: $1',
	'maps_map' => 'Kart',
	'maps_coordinates_missing' => 'Ingen koordinater oppgitt for kartet.',
	'maps_geocoding_failed' => 'Følgende {{PLURAL:$2|adresse|adresser}} kunne ikke geokodes: $1.',
	'maps_geocoding_failed_for' => 'Følgende {{PLURAL:$2|adresse|adresser}} kunne ikke geokodes og har blitt utelatt fra kartet:
$1',
	'maps_unrecognized_coords' => 'Følgende koordinat ble ikke gjenkjent: $1.',
	'maps_unrecognized_coords_for' => 'Følgende {{PLURAL:$2|koordinat|koordinater}} ble ikke gjenkjent og har blitt utelatt fra kartet:
$1',
	'maps_map_cannot_be_displayed' => 'Kartet kan ikke vises.',
	'maps_click_to_activate' => 'Klikk for å aktivere kartet',
	'maps_centred_on' => 'Kart sentrert om $1, $2.',
	'maps_overlays' => 'Transparenter',
	'maps_photos' => 'Foto',
	'maps_videos' => 'Videoer',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webkamera',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'maps_desc' => "Permet d'afichar de coordenadas dins de mapas, e mai d'adreça geocodadas
([http://www.mediawiki.org/wiki/Extension:Maps documentacion], [http://wiki.bn2vs.com/wiki/Maps demonstracion]). 
Servicis de cartografia disponibles : $1",
	'maps_map' => 'Mapa',
	'maps_coordinates_missing' => 'Cap de coordenada es pas estada provesida pel plan.',
	'maps_geocoding_failed' => "{{PLURAL:$2|L'adreça seguenta a pas pogut èsser geoencodada|Las adreças seguentas an pas pogut èsser geoencodadas}} : $1.
Lo plan pòt pas èsser afichat.",
	'maps_geocoding_failed_for' => "{{PLURAL:$2|L'adreça seguenta a pas pogut èsser geoencodada|Las adreças seguentas an pas pogut èsser geoencodadas}} e {{PLURAL:$2|es pas afichada|son pas afichadas}} sul plan : $1",
	'maps_unrecognized_coords' => 'Las coordenadas seguentas son pas estadas reconegudas : $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|La coordenada seguenta es pas estada reconeguda|Las coordenadas seguentas son pas estadas reconegudas}} e {{PLURAL:$2|es estada omesa|son estadas omesas}} sus la mapa :
$1',
	'maps_map_cannot_be_displayed' => 'La mapa pòt pas èsser afichada.',
	'maps_click_to_activate' => 'Clicar per activar la mapa',
	'maps_centred_on' => 'Mapa centrada sus $1, $2.',
	'maps_overlays' => 'Superposicions',
	'maps_photos' => 'Fòtos',
	'maps_videos' => 'Vidèos',
	'maps_wikipedia' => 'Wikipèdia',
	'maps_webcams' => 'Webcams',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Yarl
 */
$messages['pl'] = array(
	'maps_desc' => 'Umożliwia wyświetlanie na mapach współrzędnych oraz adresów geograficznych ([http://wiki.bn2vs.com/wiki/Maps demo]). Dostępne serwisy mapowe: $1',
	'maps_map' => 'Mapa',
	'maps_coordinates_missing' => 'Brak współrzędnych dla mapy.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Następującego adresu nie można odnaleźć na mapie|Następujących adresów nie można odnaleźć na mapie:}} $1.
Mapa nie może zostać wyświetlona.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Następujący adres został pominięty, ponieważ nie można go odnaleźć na mapie|Następujące adresy zostały pominięte, ponieważ nie można ich odnaleźć na mapie:}} $1.',
	'maps_unrecognized_coords' => 'Następujące współrzędne nie zostały rozpoznane: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Następującą współrzędną|Następujące współrzędne}} pominięto, ponieważ nie {{PLURAL:$2|została rozpoznana|zostały rozpoznane}}:
$1',
	'maps_map_cannot_be_displayed' => 'Mapa nie może zostać wyświetlona.',
	'maps_click_to_activate' => 'Kliknij, aby aktywować mapę',
	'maps_overlays' => 'Nakładki',
	'maps_photos' => 'Zdjęcia',
	'maps_videos' => 'Filmy',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Kamery internetowe',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 * @author McDutchie
 */
$messages['pms'] = array(
	'maps_desc' => "A dà la possibilità ëd visualisé le coordinà ant le mape, e j'adrësse geocode ([http://wiki.bn2vs.com/wiki/Maps demo]). Sërvissi ëd mapatura disponìbil: $1",
	'maps_map' => 'Pian',
	'maps_coordinates_missing' => 'Pa gnun-e coordinà dàite për la mapa.',
	'maps_geocoding_failed' => "{{PLURAL:$2|L'adrëssa|J'adrësse}} sì sota a peulo pa esse sota geocode: $1.
La mapa a peul pa esse visualisà.",
	'maps_geocoding_failed_for' => "{{PLURAL:$2|L'adrëssa|J'adrësse}} sì sota a peula pa esse sota geocode e a {{PLURAL:$2|l'é pa stàita|son pa stàite}}  butà ant la mapa: $1",
	'maps_unrecognized_coords' => 'Le coordinà sota a son pa stàite arconossùe: $1.',
	'maps_unrecognized_coords_for' => "{{PLURAL:$2|La coordinatà sota a l'é pa stàita arconossùa|Le coordinà sota a son pa stàite arconossùe}}  e a {{PLURAL:$2|l'é stàita|a son stàite}} pa butà ant la carta: 
$1",
	'maps_map_cannot_be_displayed' => 'La carta a peul pa esse mostrà.',
	'maps_click_to_activate' => 'Sgnaca për ativé la carta',
	'maps_centred_on' => 'Carta sentrà su $1, $2.',
	'maps_overlays' => 'Sovraposission',
	'maps_photos' => 'Fòto',
	'maps_videos' => 'Filmà',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcam',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'maps_desc' => 'Permite apresentar dados de coordenadas em mapas e endereços por geocódigo ([http://wiki.bn2vs.com/wiki/Maps demonstração]).
Serviços de cartografia disponíveis: $1',
	'maps_map' => 'Mapa',
	'maps_coordinates_missing' => 'Não foram fornecidas coordenadas para o mapa.',
	'maps_geocoding_failed' => 'Não foi possível geocodificar {{PLURAL:$2|o seguinte endereço|os seguintes endereços}}: $1.
O mapa não pode ser apresentado.',
	'maps_geocoding_failed_for' => 'Não foi possível geocodificar {{PLURAL:$2|o seguinte endereço, que foi omitido|os seguintes endereços, que foram omitidos}} do mapa:
$1.',
	'maps_unrecognized_coords' => 'As seguintes coordenadas não foram reconhecidas: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|A seguinte coordenada não foi reconhecida e foi omitida|As seguintes coordenadas não foram reconhecidas e foram omitidas}} do mapa:
$1',
	'maps_map_cannot_be_displayed' => 'Não é possível apresentar o mapa.',
	'maps_click_to_activate' => 'Clique para activar o mapa',
	'maps_centred_on' => 'Mapa centrado nas coordenadas $1, $2.',
	'maps_overlays' => 'Sobreposições',
	'maps_photos' => 'Fotografias',
	'maps_videos' => 'Vídeos',
	'maps_wikipedia' => 'Wikipédia',
	'maps_webcams' => 'Câmaras Web',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'maps_desc' => 'Provê a possibilidade de exibir dados de coordenadas em mapas e endereços em geocódigo. ([http://wiki.bn2vs.com/wiki/Maps demonstração]).
Serviços de mapeamento disponíveis: $1',
	'maps_map' => 'Mapa',
	'maps_coordinates_missing' => 'Nenhuma coordenada fornecida para o mapa',
	'maps_geocoding_failed' => '{{PLURAL:$2|O seguinte endereço não pode|Os seguintes endereços não puderam}} ser {{PLURAL:$2|geocodificado|geocodificados}}: $1.
O mapa não pode ser exibido.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|O seguinte endereço não pode|Os seguintes endereços não puderam}} ser {{PLURAL:$2|geocodificado e foi omitido|geocodificados e foram omitidos}} do mapa:
$1',
	'maps_unrecognized_coords' => 'As seguintes coordenadas não foram reconhecidas: $1.',
	'maps_click_to_activate' => 'Clique para ativar o mapa',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Minisarm
 */
$messages['ro'] = array(
	'maps_desc' => 'Asigură capacitatea de a afişa coordonate pe hărţi şi adrese geocode ([http://wiki.bn2vs.com/wiki/Maps demonstraţie]).
Servici de cartografiere disponibile: $1',
	'maps_map' => 'Hartă',
	'maps_coordinates_missing' => 'Nici o coordonată oferită pentru hartă.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Următoarea|Următoarele}} {{PLURAL:$2|adresă|adrese}} nu {{PLURAL:$2|a|au}} putut fi {{PLURAL:$2|geocodificată|geocodificate}}: $1.
Harta nu poate fi afişată.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Următoarea|Următoarele}} {{PLURAL:$2|adresă|adrese}} nu {{PLURAL:$2|a|au}} putut fi {{PLURAL:$2|geocodificată|geocodificate}} şi {{PLURAL:$2|a|au}} fost {{PLURAL:$2|omisă|omise}} de pe hartă:
$1',
	'maps_photos' => 'Fotografii',
	'maps_videos' => 'Filme',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Camere web',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'maps_desc' => "Dè l'abbilità a fà vedè le coordinate jndr'à le mappe e le indirizze geocodificate ([http://wiki.bn2vs.com/wiki/Maps demo]). Disponibbile le servizie de mappe: $1",
);

/** Russian (Русский)
 * @author Lockal
 * @author McDutchie
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'maps_desc' => 'Обеспечивает возможность отображения координатных данных на картах и геокодирование адресов ([http://wiki.bn2vs.com/wiki/Maps демонстрация]).
Доступные картографические службы: $1',
	'maps_map' => 'Карта',
	'maps_coordinates_missing' => 'Не указаны координаты для карты.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Следующий адрес не может быть геокодирован|Следующие адреса не могут быть геокодированы}}: $1.
Карта не может быть отображена.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Следующий адрес не может быть геокодирован и был удалён|Следующие адреса не могут быть геокодированы и были удалены}} с карты:
$1',
	'maps_unrecognized_coords' => 'Следующие координаты не были опознаны: $1.',
	'maps_unrecognized_coords_for' => 'Следующие координаты не были опознаны, {{PLURAL:$2|они|они}} не показаны на карте:
$1',
	'maps_map_cannot_be_displayed' => 'Карта не может быть показана.',
	'maps_click_to_activate' => 'Нажмите для активации карты',
	'maps_centred_on' => 'Центр карты — $1, $2.',
	'maps_overlays' => 'Слои',
	'maps_photos' => 'Фото',
	'maps_videos' => 'Видео',
	'maps_wikipedia' => 'Википедия',
	'maps_webcams' => 'Веб-камеры',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'maps_desc' => 'Poskytuje možnosť zobrazovať údaje súradníc na mapách a tvoriť geografické adresy lokalít ([http://wiki.bn2vs.com/wiki/Semantic_Maps demo]).
Dostupné mapovacie služby: $1',
	'maps_map' => 'Mapa',
	'maps_coordinates_missing' => 'Neboli poskytnuté žiadne súradnice.',
	'maps_geocoding_failed' => 'Nebolo možné určiť súradnice {{PLURAL:$2|nasledovnej adresy|nasledovných adries}}: $1.',
	'maps_geocoding_failed_for' => 'Nebolo možné určiť súradnice {{PLURAL:$2|nasledovnej adresy|nasledovných adries}} a {{PLURAL:$2|bola vynechaná|boli vynechané}} z mapy: $1.',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author Per
 */
$messages['sv'] = array(
	'maps_desc' => 'Ger möjlighet till att visa koordinater på kartor och geokodade adresser ([http://wiki.bn2vs.com/wiki/Maps demo]).
Tillgängliga karttjänster: $1',
	'maps_map' => 'Karta',
	'maps_coordinates_missing' => 'Inga koordinater angivna för kartan.',
	'maps_geocoding_failed' => 'Följande {{PLURAL:$2|adress|adresser}} kunde inte geokodas: $1.
Kartan kan inte visas.',
	'maps_geocoding_failed_for' => 'Följande {{PLURAL:$2|adress|adresser}}kunde inte geokodas och {{PLURAL:$2|har|har}} uteslutits från kartan: $1',
	'maps_unrecognized_coords' => 'Följande koordinater kändes inte igen: $1.',
	'maps_unrecognized_coords_for' => 'Följande {{PLURAL:$2|koordinat|koordinater}} kändes inte igen och {{PLURAL:$2|har|har}} utelämnats från kartan:
$1',
	'maps_map_cannot_be_displayed' => 'Kartan kan inte visas.',
	'maps_click_to_activate' => 'Klicka för att aktivera karta',
	'maps_photos' => 'Foton',
	'maps_wikipedia' => 'Wikipedia',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'maps_map' => 'పటం',
	'maps_photos' => 'చిత్రాలు',
	'maps_videos' => 'దృశ్యకాలు',
	'maps_wikipedia' => 'వికీపీడియా',
);

/** Thai (ไทย)
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'maps_desc' => 'ให้ความสามารถในการแสดงพิกัดในแผนที่ และที่อยู่ที่เป็นรหัสทางภูมิศาสตร์([http://wiki.bn2vs.com/wiki/Maps demo]).
<br />บริการแผนที่ที่มีอยู่: $1',
	'maps_coordinates_missing' => 'ไม่ได้กำหนดพิกัดของแผนที่มาให้',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'maps_map' => 'Harita',
	'maps_coordinates_missing' => 'Harita için koordinat girilmedi.',
	'maps_unrecognized_coords' => 'Şu koordinatlar tanınamadı: $1',
	'maps_map_cannot_be_displayed' => 'Harita görüntülenemiyor.',
	'maps_click_to_activate' => 'Haritayı etkinleştirmek için tıkla',
	'maps_centred_on' => 'Harita, $1 $2 koordinatlarında ortalandı.',
	'maps_photos' => 'Fotoğraflar',
	'maps_videos' => 'Videolar',
	'maps_wikipedia' => 'Vikipedi',
	'maps_webcams' => 'Web kameraları',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'maps_name' => 'Bản đồ',
	'maps_desc' => 'Cung cấp khả năng hiển thị dữ liệu tọa độ trên bản đồ và địa chỉ mã địa lý ([http://wiki.bn2vs.com/wiki/Maps thử xem]).
Các dịch vụ bản đồ có sẵn: $1',
	'maps_map' => 'Bản đồ',
	'maps_coordinates_missing' => 'Chưa định rõ tọa độ cho bản đồ.',
	'maps_geocoding_failed' => 'Không thể tính ra mã địa lý của {{PLURAL:$2|địa chỉ|các địa chỉ}} sau: $1.
Không thể hiển thị bản đồ.',
	'maps_geocoding_failed_for' => 'Không thể tính ra mã địa lý của {{PLURAL:$2|địa chỉ|các địa chỉ}} sau nên bản đồ bỏ qua nó:
$1',
	'maps_unrecognized_coords' => 'Không thể nhận ra tọa độ sau: $1.',
	'maps_unrecognized_coords_for' => 'Không thể nhận ra {{PLURAL:$2|tọa độ|các tọa độ}} sau nên bản đồ bỏ qua nó:
$1',
	'maps_map_cannot_be_displayed' => 'Không thể hiển thị bản đồ.',
	'maps_osm' => 'OpenStreetMap',
	'maps_click_to_activate' => 'Nhấn chuột vào bản đồ để kích hoạt',
	'maps_overlays' => 'Lớp',
	'maps_photos' => 'Hình ảnh',
	'maps_videos' => 'Video',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcam',
);

