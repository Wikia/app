<?php

/**
 * Internationalization file for the Maps extension.
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
	'maps_desc' => "Provides the ability to display coordinate data in maps, and geocode addresses ([http://mapping.referata.com/wiki/Maps_examples demo's]).
Available mapping services: $1",
	'maps_map' => 'Map',
	'maps-loading-map' => 'Loading map...',
	'maps-markers' => 'Markers',
	'maps-others' => 'others',
	'maps-ns-layer' => 'Layer',
	'maps-ns-layer-talk' => 'Layer talk',
	'maps-layer-property' => 'Property',
	'maps-layer-value' => 'Value',
	'maps-layer-errors' => 'Errors',
	'maps-error-invalid-layerdef' => 'This layer definition is not valid.',
	'maps-error-invalid-layertype' => 'There are no layers of type "$1". Only {{PLURAL:$3|this type is|these types are}} supported: $2',
	'maps-error-no-layertype' => 'You need to specify the layer type. {{PLURAL:$2|Only this type is|These types are}} supported: $1',
	'validation-error-invalid-layer' => 'Parameter $1 must be a valid layer.',
	'validation-error-invalid-layers' => 'Parameter $1 must be one or more valid layers.',
	'maps-layer-of-type' => 'Layer of type $1',
	'maps-layer-type-supported-by' => 'This layer type can {{PLURAL:$2|only be used with the $1 mapping service|be used with these mapping services: $1}}.',

	// Validation
	'validation-error-invalid-location' => 'Parameter $1 must be a valid location.',
	'validation-error-invalid-locations' => 'Parameter $1 must be one or more valid locations.',
	'validation-error-invalid-width' => 'Parameter $1 must be a valid width.',
	'validation-error-invalid-height' => 'Parameter $1 must be a valid height.',
	'validation-error-invalid-distance' => 'Parameter $1 must be a valid distance.',
	'validation-error-invalid-distances' => 'Parameter $1 must be one or more valid distances.',
	'validation-error-invalid-image' => 'Parameter $1 must be a valid image.',
	'validation-error-invalid-images' => 'Parameter $1 must be one or more valid images.',

	'validation-error-invalid-goverlay' => 'Parameter $1 must be a valid overlay.',
	'validation-error-invalid-goverlays' => 'Parameter $1 must be one or more valid overlays.',

	// Coordinate handling
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude'  => 'Latitude:',
	'maps-longitude' => 'Longitude:',

	// Coordinate errors
	'maps-invalid-coordinates' => 'The value $1 was not recognized as a valid set of coordinates.',
	'maps_coordinates_missing' => 'No coordinates provided for the map.',
	'maps_geocoding_failed' => 'The following {{PLURAL:$2|address|addresses}} could not be geocoded: $1.',
	'maps_geocoding_failed_for' => 'The following {{PLURAL:$2|address|addresses}} could not be geocoded and {{PLURAL:$2|has|have}} been omitted from the map:
$1',
	'maps_unrecognized_coords' => 'The following {{PLURAL:$2|coordinate was|coordinates were}} not recognized: $1.',
	'maps_unrecognized_coords_for' => 'The following {{PLURAL:$2|coordinate was|coordinates were}} not recognized and {{PLURAL:$2|has|have}} been omitted from the map:
$1',
	'maps_map_cannot_be_displayed' => 'The map cannot be displayed.',

	// Geocoding
	'maps-geocoder-not-available' => 'The geocoding feature of Maps is not available. Your location can not be geocoded.',

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
 * @author Тест
 */
$messages['qqq'] = array(
	'maps_name' => '{{Optional}}',
	'maps_desc' => '{{desc}}

* $1: a list of available map services',
	'maps_map' => '{{Identical|Map}}',
	'maps-others' => '{{Identical|Other}}',
	'maps-layer-property' => '{{Identical|Property}}',
	'maps-layer-value' => '{{identical|Value}}',
	'maps-layer-errors' => '{{Identical|Error}}',
	'maps-latitude' => '{{Identical|Latitude}}',
	'maps-longitude' => '{{Identical|Longitude}}',
	'maps_geocoding_failed_for' => '* $1 is a list
* $2 is the number of list items for PLURAL use.',
	'maps_centred_on' => '$1 and $2 are latitude and longitude.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'maps_map' => 'Kaart',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'O',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Breedte:',
	'maps-longitude' => 'Lengte:',
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

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'maps_desc' => 'Ofron mundësinë për të shfaqur koordinimin e të dhënave në harta, dhe adresat geocode ([http://mapping.referata.com/wiki/Maps_examples demo]). Hartës shërbimet në dispozicion: $1',
	'maps_map' => 'Hartë',
	'maps-loading-map' => 'Loading Harta ...',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Latitude:',
	'maps-longitude' => 'Gjatësi:',
	'maps-invalid-coordinates' => 'Vlera $1 nuk është njohur si një grup të vlefshme të kordinatave.',
	'maps_coordinates_missing' => 'Nuk ka koordinon parashikuara në hartë.',
	'maps_geocoding_failed' => 'Më poshtë {{PLURAL:$2|Adresa|adresat}} nuk mund të geocoded: $1.',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'maps_name' => 'خرائط',
	'maps_desc' => 'يعطي إمكانية عرض معلومات التنسيق في الخرائط وعناوين الترميز الجغرافي ([http://mapping.referata.com/wiki/Maps_examples تجربة]).
خدمات الخرائط المتوفرة: $1',
	'maps_map' => 'خريطة',
	'maps-abb-north' => 'شم',
	'maps-abb-east' => 'شر',
	'maps-abb-south' => 'ج',
	'maps-abb-west' => 'غ',
	'maps-latitude' => 'دائرة العرض:',
	'maps-longitude' => 'خط الطول:',
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

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'maps_map' => 'ܨܘܪܬ ܥܠܡܐ',
	'maps-layer-value' => 'ܛܝܡܐ',
	'maps-layer-errors' => 'ܦܘܕ̈ܐ',
	'maps-abb-north' => 'ܓܪܒܝܐ',
	'maps-abb-east' => 'ܡܕܢܚܐ',
	'maps-abb-south' => 'ܬܝܡܢܐ',
	'maps-abb-west' => 'ܡܥܪܒܐ',
	'maps_photos' => 'ܨܘܪ̈ܬܐ',
	'maps_videos' => 'ܒܝܕ̈ܝܘ',
	'maps_wikipedia' => 'ܘܝܩܝܦܕܝܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'maps_name' => 'خرايط',
	'maps-abb-north' => 'شمال',
	'maps-abb-east' => 'شرق',
	'maps-abb-south' => 'جنوب',
	'maps-abb-west' => 'غرب',
	'maps-latitude' => 'دوائر العرض:',
	'maps-longitude' => 'خطوط الطول:',
	'maps_googlemaps2' => 'خرايط جوجل',
	'maps_yahoomaps' => 'خرايط ياهو',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'maps_desc' => 'Забясьпечвае магчымасьць адлюстраваньня каардынатных зьвестак на мапах і геаграфічнага кадаваньня адрасоў ([http://mapping.referata.com/wiki/Maps_examples дэманстрацыя]). Даступныя геаграфічныя сэрвісы: $1',
	'maps_map' => 'Мапа',
	'maps-loading-map' => 'Загрузка мапы…',
	'maps-markers' => 'Пазнакі',
	'maps-others' => 'іншыя',
	'maps-ns-layer' => 'Слой',
	'maps-ns-layer-talk' => 'Абмеркаваньне слоя',
	'maps-layer-property' => 'Уласьцівасьць',
	'maps-layer-value' => 'Значэньне',
	'maps-layer-errors' => 'Памылкі',
	'maps-error-invalid-layerdef' => 'Гэтае вызначэньне слою — няслушнае.',
	'maps-error-invalid-layertype' => 'Няма слаёў тыпу «$1». Падтрымліваецца толькі {{PLURAL:$3|гэты тып|гэтыя тыпы}}: $2',
	'maps-error-no-layertype' => 'Вам неабходна вызначыць тып слою. {{PLURAL:$2|Падтрымліваецца толькі гэты тып|Падтрымліваюцца толькі гэтыя тыпы}}: $1',
	'validation-error-invalid-layer' => 'Парамэтар $1 мусіць быць слушным слоем.',
	'validation-error-invalid-layers' => 'Парамэтар $1 мусіць быць адным ці болей слушнымі слаямі.',
	'maps-layer-of-type' => 'Слой тыпу $1',
	'maps-layer-type-supported-by' => 'Гэты тып слою можа быць выкарыстаны толькі з {{PLURAL:$2|сэрвісам мапаў $1|сэрвісамі мапаў: $1}}.',
	'validation-error-invalid-location' => 'Парамэтар $1 мусіць быць слушным знаходжаньнем.',
	'validation-error-invalid-locations' => 'Парамэтар $1 мусіць быць адным ці болей слушнымі знаходжаньнямі.',
	'validation-error-invalid-width' => 'Парамэтар $1 мусіць быць слушнай шырынёй.',
	'validation-error-invalid-height' => 'Парамэтар $1 мусіць быць слушнай вышынёй.',
	'validation-error-invalid-distance' => 'Парамэтар $1 мусіць быць слушнай адлегласьцю.',
	'validation-error-invalid-distances' => 'Парамэтар $1 мусіць быць адной ці болей слушнымі адлегласьцямі.',
	'validation-error-invalid-image' => 'Парамэтар $1 мусіць быць слушнай выявай.',
	'validation-error-invalid-images' => 'Парамэтар $1 мусіць быць адной ці болей слушнымі выявамі.',
	'validation-error-invalid-goverlay' => 'Парамэтар $1 мусіць быць слушным слоем.',
	'validation-error-invalid-goverlays' => 'Парамэтар $1 мусіць быць адным ці болей слушнымі слаямі.',
	'maps-abb-north' => 'Пн.',
	'maps-abb-east' => 'У.',
	'maps-abb-south' => 'Пд.',
	'maps-abb-west' => 'З.',
	'maps-latitude' => 'Шырата:',
	'maps-longitude' => 'Даўгата:',
	'maps-invalid-coordinates' => 'Значэньне $1 зьяўляецца недапушчальным наборам каардынатаў.',
	'maps_coordinates_missing' => 'Каардынаты для мапы не пазначаныя.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Наступны адрас ня можа быць геакадаваны|Наступныя адрасы ня могуць быць геакадаваныя}}: $1.
Мапа ня можа быць паказана.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Наступны адрас ня можа быць геакадаваны і быў выдалены|Наступныя адрасы ня могуць быць геакадаваны і былі выдаленыя}} з мапы:
$1',
	'maps_unrecognized_coords' => 'Наступныя {{PLURAL:$2|каардыната не была распазнаная|каардынаты не былі распазнаныя}}: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Наступная каардыната не была апазнаная|Наступныя каардынаты не былі апазнаныя}} і {{PLURAL:$2|яна не паказаная|яны не паказаныя}}:
$1',
	'maps_map_cannot_be_displayed' => 'Мапа ня можа быць паказаная.',
	'maps-geocoder-not-available' => 'Магчымасьць геаграфічнага кадаваньня для мапаў недаступная. Вашае месцазнаходжаньне ня можа быць геаграфічна закадаванае.',
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
	'maps-abb-north' => 'С',
	'maps-abb-east' => 'И',
	'maps-abb-south' => 'Ю',
	'maps-abb-west' => 'З',
	'maps_photos' => 'Снимки',
	'maps_wikipedia' => 'Уикипедия',
	'maps_webcams' => 'Уебкамери',
);

/** Bahasa Banjar (Bahasa Banjar)
 * @author Ezagren
 */
$messages['bjn'] = array(
	'maps-abb-north' => 'U',
	'maps-abb-east' => 'T',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'B',
	'maps_wikipedia' => 'Wikipidia',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'maps_desc' => "Talvezout a ra da embann daveennoù ha chomlec'hioù geokod war kartennoù ([http://mapping.referata.com/wiki/Maps_examples demo]). Servijoù kartennaouiñ hegerz : $1",
	'maps_map' => 'Kartenn',
	'maps-loading-map' => 'O kargañ ar gartenn...',
	'maps-markers' => 'Merkerioù',
	'maps-others' => 're all',
	'maps-ns-layer' => 'Gwiskad',
	'maps-ns-layer-talk' => 'Kaozeadenn ar gwiskad',
	'maps-layer-property' => 'Perzh',
	'maps-layer-value' => 'Talvoudenn',
	'maps-layer-errors' => 'Fazioù',
	'maps-error-invalid-layerdef' => 'Direizh eo termenadur ar gwiskad.',
	'maps-error-invalid-layertype' => 'N\'eus ket a wiskad a seurt gant "$1". N\'eo skoret nemet ar {{PLURAL:$3|seurt-mañ|seurtoù-mañ}} : $2',
	'maps-error-no-layertype' => "Ret eo deoc'h spisaat ar seurt gwiskad. N'eo skoret nemet ar {{PLURAL:$2|seurt-mañ|seurtoù-mañ}} : $1",
	'validation-error-invalid-layer' => 'Rankout a ra an arventenn $1 bezañ ur gwiskad reizh.',
	'validation-error-invalid-layers' => 'Rankout a ra an arventenn $1 bezañ evit ur gwiskad reizh, pe evit meur a hini.',
	'maps-layer-of-type' => 'Gwiskad a seurt $1',
	'maps-layer-type-supported-by' => "N'hall ar seurt gwiskad-mañ {{PLURAL:$2|bezañ implijet nemet gant ar sevij kartennaouiñ $1|bezañ implijet nemet gant ar servijoù kartennaouiñ-mañ : $1}}.",
	'validation-error-invalid-location' => "Rankout a ra an arventenn $1 bezañ evit ul lec'hiadur reizh.",
	'validation-error-invalid-locations' => "Rankout a ra an arventenn $1 bezañ evit ul lec'hiadur reizh, da nebeutañ.",
	'validation-error-invalid-width' => 'Rankout a ra an arventenn $1 bezañ evit ul ledander reizh.',
	'validation-error-invalid-height' => 'Rankout a ra an arventenn $1 bezañ evit un uhelder reizh.',
	'validation-error-invalid-distance' => 'Rankout a ra an arventenn $1 bezañ evit un hed reizh.',
	'validation-error-invalid-distances' => 'Rankout a ra an arventenn $1 bezañ evit un hed reizh, da nebeutañ.',
	'validation-error-invalid-image' => 'Rankout a ra an arventenn $1 bezañ ur skeudenn reizh.',
	'validation-error-invalid-images' => 'Rankout a ra an arventenn $1 bezañ ur skeudenn reizh, pe meur a hini.',
	'validation-error-invalid-goverlay' => 'Rankout a ra an arventenn $1 bezañ evit ur goloadur reizh.',
	'validation-error-invalid-goverlays' => 'Rankout a ra an arventenn $1 bezañ evit ur goloadur reizh, da nebeutañ.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'R',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'K',
	'maps-latitude' => 'Ledred :',
	'maps-longitude' => 'Hedred :',
	'maps-invalid-coordinates' => "N'eo ket bet anavezet an dalvoudenn $1 evel ur stroll daveennoù reizh.",
	'maps_coordinates_missing' => "N'eus bet spisaet daveenn ebet evit ar gartenn.",
	'maps_geocoding_failed' => "N'eus ket bet gallet geokodañ ar {{PLURAL:$2|chomlec'h|chomlec'h}} da-heul : $1.
N'haller ket diskwel ar gartenn.",
	'maps_geocoding_failed_for' => "N'eus ket bet gallet geokodañ ar {{PLURAL:$2|chomlec'h|chomlec'h}} da-heul, setu {{PLURAL:$2|n'eo|n'int}} ket bet lakaet war ar gartenn : 
$1",
	'maps_unrecognized_coords' => "N'eo ket bet anavezet an {{PLURAL:$2|daveenn|daveennoù}} da-heul : $1.",
	'maps_unrecognized_coords_for' => "N'eo ket bet anavezet an {{PLURAL:$2|daveenn|daveennoù}} da-heul ha {{PLURAL:$2|n'eo|n'int}} ket bet lakaet war ar gartenn :
$1",
	'maps_map_cannot_be_displayed' => "N'hall ket ar gartenn bezañ diskwelet.",
	'maps-geocoder-not-available' => "N'haller ket ober gant arc'hwel geokodañ ar c'hartennoù. N'haller ket geokodañ ho lec'hiadur.",
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
	'maps_desc' => 'Daje mogućnost prikazivanja podataka koordinata na mapama i geocode adresa ([http://mapping.referata.com/wiki/Maps_examples demo]).
Dostupne usluge mapa: $1',
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'Učitavam kartu...',
	'maps-markers' => 'Markeri',
	'maps-others' => 'ostali',
	'maps-ns-layer' => 'Sloj',
	'maps-ns-layer-talk' => 'Razgovor o sloju',
	'maps-layer-property' => 'Svojstvo',
	'maps-layer-value' => 'Vrijednost',
	'maps-layer-errors' => 'Greške',
	'maps-error-invalid-layerdef' => 'Ova definicija sloja nije valjana.',
	'maps-error-invalid-layertype' => 'Nema slojeva tipa "$1". Samo {{PLURAL:$3|je ovaj tip podržan|su ovi tipovi podržani}}: $2',
	'maps-error-no-layertype' => 'Morate odrediti tip sloja. {{PLURAL:$2|Samo ovaj tip je podržan|Ovi tipovi su podržani}}: $1',
	'validation-error-invalid-layer' => 'Parametar $1 mora biti valjani sloj.',
	'validation-error-invalid-layers' => 'Parametar $1 mora biti jedan ili više valjanih slojeva.',
	'maps-layer-of-type' => 'Sloj tipa $1',
	'maps-layer-type-supported-by' => 'Ovaj tip sloja može biti korišten {{PLURAL:$2|samo sa $1 uslugom kartografiranja|sa ovim uslugama kartografiranja: $1}}.',
	'validation-error-invalid-location' => 'Parametar $1 mora biti valjana lokacija.',
	'validation-error-invalid-locations' => 'Parametar $1 mora biti jedna ili više valjanih lokacija.',
	'validation-error-invalid-width' => 'Parametar $1 mora biti valjana širina.',
	'validation-error-invalid-height' => 'Parametar $1 mora biti valjana visina.',
	'validation-error-invalid-distance' => 'Parametar $1 mora biti ispravno odstojanje.',
	'validation-error-invalid-distances' => 'Parametar $1 mora biti jedna ili više valjanih udaljenosti.',
	'validation-error-invalid-image' => 'Parametar $1 mora biti valjana slika.',
	'validation-error-invalid-images' => 'Parametar $1 mora biti jedna ili više valjanih slika.',
	'validation-error-invalid-goverlay' => 'Parametar $1 mora biti valjan sloj.',
	'validation-error-invalid-goverlays' => 'Parametar $1 mora biti jedan ili više valjanih slojeva.',
	'maps-abb-north' => 'S',
	'maps-abb-east' => 'I',
	'maps-abb-south' => 'J',
	'maps-abb-west' => 'Z',
	'maps-latitude' => 'Geografska širina:',
	'maps-longitude' => 'Geografska dužina:',
	'maps-invalid-coordinates' => 'Vrijednost $1 nije prepoznata kao valjan set koordinati.',
	'maps_coordinates_missing' => 'Za mapu nisu navedene koordinate.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Slijedeća adresa nije mogla biti geokodirana|Slijedeće adrese nisu mogle biti geokodirane}}: $1.
Mapa se ne može prikazati.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Slijedeća adresa nije|Slijedeće adrese nisu}} mogle biti geokodiranje i {{PLURAL:$2|izostavljena je|izostavljene su}} iz mape:
$1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|Slijedeća koordinata nije prepoznata|Slijedeće koordinate nisu prepoznate}}: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Slijedeća koordinata nije|Slijedeće koordinate nisu}} prepoznate i {{PLURAL:$2|ignorirana je|ignorirane su}} na karti:
$1',
	'maps_map_cannot_be_displayed' => 'Karta se ne može prikazati.',
	'maps-geocoder-not-available' => 'Mogućnost geokodiranja na Mapama nije dostupna. Vaša lokacija ne može biti geokodirana.',
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
 * @author PerroVerd
 */
$messages['ca'] = array(
	'maps_map' => 'Mapa',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'O',
	'maps-latitude' => 'Latitud:',
	'maps-longitude' => 'Longitud:',
	'maps_coordinates_missing' => "No s'han proporcionat coordenades pel mapa.",
	'maps_centred_on' => 'Mapa centrat en $1, $2.',
	'maps_overlays' => 'Capes addicionals',
	'maps_photos' => 'Fotos',
	'maps_videos' => 'Videos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Cámeres web',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'maps_photos' => 'Сурт',
	'maps_wikipedia' => 'Википедийа',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'maps_map' => 'Mapa',
	'maps-abb-north' => 'S',
	'maps-abb-east' => 'V',
	'maps-abb-south' => 'J',
	'maps-abb-west' => 'Z',
	'maps-latitude' => 'Zeměpisná šířka:',
	'maps-longitude' => 'Zeměpisná délka:',
	'maps_overlays' => 'Překryvné vrstvy',
	'maps_wikipedia' => 'Wikipedie',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author DaSch
 * @author Imre
 * @author Kghbln
 * @author The Evil IP address
 */
$messages['de'] = array(
	'maps_desc' => 'Ermöglicht es, Koordinaten auf Karten anzuzeigen und Adressen zu geokodieren ([http://mapping.referata.com/wiki/Maps_examples Demonstrationsseite]).
Verfügbare Kartografiedienste: $1',
	'maps_map' => 'Karte',
	'maps-loading-map' => 'Karte wird geladen …',
	'maps-markers' => 'Markierungen',
	'maps-others' => 'andere',
	'maps-ns-layer' => 'Ebene',
	'maps-ns-layer-talk' => 'Ebene Diskussion',
	'maps-layer-property' => 'Eigenschaft',
	'maps-layer-value' => 'Wert',
	'maps-layer-errors' => 'Fehler',
	'maps-error-invalid-layerdef' => 'Die Angaben zu dieser Ebene sind ungültig.',
	'maps-error-invalid-layertype' => 'Es gibt keine Ebenen des Typs „$1“. Nur {{PLURAL:$3|dieser Typ wird|diese Typen werden}} unterstützt: $2',
	'maps-error-no-layertype' => 'Der Ebenentyp muss angegeben werden. Nur {{PLURAL:$2|dieser Typ wird|diese Typen werden}} unterstützt: $1',
	'validation-error-invalid-layer' => 'Parameter $1 muss einer gültigen Ebene entsprechen.',
	'validation-error-invalid-layers' => 'Parameter $1 muss einer oder mehreren gültigen Ebenen entsprechen.',
	'maps-layer-of-type' => 'Ebene des Typs $1',
	'maps-layer-type-supported-by' => 'Dieser Ebenentyp kann {{PLURAL:$2|nur beim Kartografiedienst $1 genutzt werden|bei diesen Kartografiediensten genutzt werden: $1}}.',
	'validation-error-invalid-location' => 'Parameter $1 muss einem gültigen Standort entsprechen.',
	'validation-error-invalid-locations' => 'Parameter $1 muss einem oder mehreren gültigen Standorten entsprechen.',
	'validation-error-invalid-width' => 'Parameter $1 muss einer gültigen Breite entsprechen.',
	'validation-error-invalid-height' => 'Parameter $1 muss einer gültigen Länge entsprechen.',
	'validation-error-invalid-distance' => 'Parameter $1 muss einer gültigen Entfernung entsprechen.',
	'validation-error-invalid-distances' => 'Parameter $1 muss einer oder mehreren gültigen Entfernungen entsprechen.',
	'validation-error-invalid-image' => 'Parameter $1 muss einem gültigen Bild entsprechen.',
	'validation-error-invalid-images' => 'Parameter $1 muss einem oder mehreren gültigen Bildern entsprechen.',
	'validation-error-invalid-goverlay' => 'Parameter $1 muss einer gültigen Überlagerung entsprechen.',
	'validation-error-invalid-goverlays' => 'Parameter $1 muss einer oder mehreren gültigen Überlagerungen entsprechen.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'O',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Breitengrad:',
	'maps-longitude' => 'Längengrad:',
	'maps-invalid-coordinates' => 'Der Wert $1 bezeichnet kein gültiges Koordinatenpaar.',
	'maps_coordinates_missing' => 'Es wurden keine Koordinaten für die Karte angegeben.',
	'maps_geocoding_failed' => 'Die {{PLURAL:$2|folgende Adresse|folgenden Adressen}} konnten nicht geokodiert werden: $1.',
	'maps_geocoding_failed_for' => 'Die {{PLURAL:$2|folgende Adresse konnte|folgenden Adressen konnten}} nicht geokodiert werden und {{PLURAL:$2|wurde|wurden}} auf der Karte nicht berücksichtigt:
$1',
	'maps_unrecognized_coords' => 'Folgende {{PLURAL:$2|Koordinate wurde|Koordinaten wurden}} nicht erkannt: $1.',
	'maps_unrecognized_coords_for' => 'Die {{PLURAL:$2|folgende Koordinate wurde|folgenden Koordinaten wurden}} nicht erkannt und {{PLURAL:$2|wurde|wurden}} auf der Karte nicht berücksichtigt:
$1',
	'maps_map_cannot_be_displayed' => 'Diese Karte kann nicht angezeigt werden.',
	'maps-geocoder-not-available' => 'Die Funktion Geokodierung von Karten ist nicht verfügbar. Der Standort kann nicht geokodiert werden.',
	'maps_click_to_activate' => 'Klicken, um die Karte zu aktivieren.',
	'maps_centred_on' => 'Karte ist auf $1, $2 zentriert.',
	'maps_overlays' => 'Einblendungen',
	'maps_photos' => 'Fotos',
	'maps_videos' => 'Videos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcams',
);

/** German (formal address) (Deutsch (Sie-Form)) */
$messages['de-formal'] = array(
	'maps-geocoder-not-available' => 'Die Funktion Geokodierung von Karten ist nicht verfügbar. Ihr Standort kann nicht geokodiert werden.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'maps_desc' => 'Bitujo móžnosć koordinatowe daty w geografiskich kórtach a geokodowe adrese zwobrazniś. ([http://mapping.referata.com/wiki/Maps_examples demo]).
K dispoziciji stojece kórtowe słužby: $1',
	'maps_map' => 'Karta',
	'maps-loading-map' => 'Kórta se zacytujo...',
	'maps-markers' => 'Marki',
	'maps-others' => 'druge',
	'maps-ns-layer' => 'Rownina',
	'maps-ns-layer-talk' => 'Diskusija rowniny',
	'maps-layer-property' => 'Kakosć',
	'maps-layer-value' => 'Gódnota',
	'maps-layer-errors' => 'Zmólki',
	'maps-error-invalid-layerdef' => 'Definicija toś teje rowniny njejo płaśiwa.',
	'maps-error-invalid-layertype' => 'Njejsu žedne rowniny typa "$1". Jano {{PLURAL:$3|toś ten typ se pódpěra|toś tej typa se pódpěratej|toś te typy se pódpěraju|toś te typy se pódpěraju}}: $2',
	'maps-error-no-layertype' => 'Musyš typ rowniny pódaś. Jano {{PLURAL:$2|toś ten typ se pódpěra|toś tej typa se pódpěratej|toś te typy se pódpěraju|toś te typy se pódpěraju}}: $1',
	'validation-error-invalid-layer' => 'Parameter $1 musy płaśiwa rownina byś.',
	'validation-error-invalid-layers' => 'Parameter $1 musy jadna płaśiwa rownina abo někotare płaśiwe rowniny byś.',
	'maps-layer-of-type' => 'Rownina typa $1',
	'maps-layer-type-supported-by' => 'Toś ten typ rowniny  dajo se jano {{PLURAL:$2|z kartografiskeju słužbu $1 wužywaś|z toś tymi kartografiskimi słužbami wužywaś: $1}}.',
	'validation-error-invalid-location' => 'Parameter $1 musy płaśiwe městno byś.',
	'validation-error-invalid-locations' => 'Parameter $1 musy jadne płaśiwe městno abo někotare płaśiwe městna byś.',
	'validation-error-invalid-width' => 'Parameter $1 musy płaśiwa šyrokosć byś.',
	'validation-error-invalid-height' => 'Parameter $1 musy płaśiwa wusokosć byś.',
	'validation-error-invalid-distance' => 'Gódnota $1 musy płaśiwa distanca byś.',
	'validation-error-invalid-distances' => 'Parameter $1 musy jadna płaśiwa distanca abo někotare płaśiwe distance byś.',
	'validation-error-invalid-image' => 'Parameter $1 musy płaśiwy wobraz byś.',
	'validation-error-invalid-images' => 'Parameter $1 musy jadne płaśiwy wobraz abo někotare płaśiwe wobraze byś.',
	'validation-error-invalid-goverlay' => 'Parameter $1 musy płaśiwe pśewarstowanje byś.',
	'validation-error-invalid-goverlays' => 'Parameter $1 musy jadne płaśiwe pśewarstowanje abo někotare płaśiwe pśewarstowanja byś.',
	'maps-abb-north' => 'PP',
	'maps-abb-east' => 'PZ',
	'maps-abb-south' => 'PD',
	'maps-abb-west' => 'PW',
	'maps-latitude' => 'Šyrina:',
	'maps-longitude' => 'Dlinina:',
	'maps-invalid-coordinates' => 'Gódnota $1 njejo se spóznała ako płaśiwa sajźba koordinatow.',
	'maps_coordinates_missing' => 'Za kórtu njejsu koordinaty pódane.',
	'maps_geocoding_failed' => 'Geokoděrowanje {{PLURAL:$2|slědujuceje adrese|slědujuceju adresowu|slědujucych adresow|slědujucych adresow}} njejo móžno było: $1. Kórta njedajo se zwobrazniś.',
	'maps_geocoding_failed_for' => 'Geokoděrowanje {{PLURAL:$2|slědujuceje adrese|slědujuceju adresowu|slědujucych adresow|slědujucych adresow}} njejo móžno było a togodla toś {{PLURAL:$2|ta adresa wuwóstaja|tej adresy wuwóstajotej|te adrese wuwóstajaju|te adresy wuwóstajaju}} se na kórśe: $1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|Slědujuca koordinata njejo se spóznała|Slědujucej koordinaśe njejstej se spóznałej|Slědujuce koordinaty njejsu se spóznali|Slědujuce koordinaty njejsu se spóznali}}: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Slědujuca koordinata njejo se spóznała|Slědujucej koordinaśe stej se spóznałej|Slědujuce koordinaty su se spóznali|Slědujuce koordinaty su se spóznali}} a {{PLURAL:$2|njejo se wuwóstajiła|njejstej se wuwóstajiłej|njejsu wuwóstajili|njejsu se wuwóstajili}} na kórśe: $1',
	'maps_map_cannot_be_displayed' => 'Kórta njedajo se zwobrazniś.',
	'maps-geocoder-not-available' => 'Funkcija geokoděrowanja Kórtow njestoj k dispoziciji, twójo městno njedajo se geokoděrowaś.',
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
	'maps-abb-north' => 'Β',
	'maps-abb-east' => 'Α',
	'maps-abb-south' => 'Ν',
	'maps-abb-west' => 'Δ',
	'maps-latitude' => 'Γεωγραφικό πλάτος:',
	'maps-longitude' => 'Γεωγραφικό μήκος:',
	'maps_coordinates_missing' => 'Καμία συντεταγμένη δεν παρασχέθηκε για τον χάρτη.',
	'maps_photos' => 'Φωτογραφίες',
	'maps_videos' => 'Βίντεο',
	'maps_wikipedia' => 'Βικιπαίδεια',
);

/** British English (British English)
 * @author Bruce89
 * @author Reedy
 */
$messages['en-gb'] = array(
	'maps_desc' => 'Provides the ability to display coordinate data in maps, and geocode addresses ([http://mapping.referata.com/wiki/Maps_examples demo]).
Available mapping services: $1',
	'maps-invalid-coordinates' => 'The value $1 was not recognised as a valid set of coordinates.',
	'maps_unrecognized_coords' => 'The following {{PLURAL:$2|coordinate was|coordinates were}} not recognised: $1.',
	'maps_unrecognized_coords_for' => 'The following {{PLURAL:$2|coordinate was|coordinates were}} not recognised and {{PLURAL:$2|has|have}} been omitted from the map:
$1',
	'maps_centred_on' => 'Map centred on $1, $2.',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'O',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'U',
	'maps-latitude' => 'Latitudo:',
	'maps-longitude' => 'Longitudo:',
	'maps_map_cannot_be_displayed' => 'La mapo ne esti montrebla.',
	'maps_click_to_activate' => 'Klaku aktivigi mapon',
	'maps_photos' => 'Fotoj',
	'maps_wikipedia' => 'Vikipedio',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dferg
 * @author Diego Grez
 * @author Imre
 * @author Locos epraix
 * @author Pertile
 * @author Peter17
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'maps_desc' => 'Proporciona la capacidad de mostrar los datos de coordenadas en los mapas y geocodifica direcciones ([http://mapping.referata.com/wiki/Maps_examples demo]). Servicios de mapeo disponibles: $1',
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'Cargando mapa...',
	'maps-markers' => 'Marcadores',
	'maps-ns-layer' => 'Capa',
	'maps-ns-layer-talk' => 'Discusión de capa',
	'maps-layer-property' => 'Propiedad',
	'maps-layer-value' => 'Valor',
	'maps-layer-errors' => 'Errores',
	'maps-error-invalid-layerdef' => 'Esta definición de la capa no es válida.',
	'validation-error-invalid-layer' => 'El parámetro $1 debe ser una capa válida.',
	'validation-error-invalid-layers' => 'El parámetro $1 debe ser una o más capas válidas.',
	'validation-error-invalid-location' => 'El parámetro $1 deber ser una ubicación válida.',
	'validation-error-invalid-locations' => 'Parámetro $1 debe ser una o más ubicaciones válidas.',
	'validation-error-invalid-width' => 'El parámetro $1 debe ser un ancho válido.',
	'validation-error-invalid-height' => 'El parámetro $1 deber ser una altura válida.',
	'validation-error-invalid-distance' => 'Parámetro $1 debe ser una distancia válida.',
	'validation-error-invalid-distances' => 'Parámetro $1 debe ser una o más distancias válidas.',
	'validation-error-invalid-goverlay' => 'El parámetro $1 debe ser una superposición válida.',
	'validation-error-invalid-goverlays' => 'El parámetro $1 debe ser una o más superposiciones válidas.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'O',
	'maps-latitude' => 'Latitud:',
	'maps-longitude' => 'Longitud:',
	'maps-invalid-coordinates' => 'El valor $1 no fue reconocido como un conjunto válido de coordenadas.',
	'maps_coordinates_missing' => 'Sin coordenadas provistas para el mapa.',
	'maps_geocoding_failed' => 'Las siguientes {{PLURAL:$2|dirección|direcciones}}  no han podido ser geocodificadas: $1.
No se puede mostrar el mapa.',
	'maps_geocoding_failed_for' => 'No fue posible geocodificar {{PLURAL:$2|la siguiente dirección, que ha sido omitida|las siguientes direcciones, que han sido omitidas}} del mapa:$1.',
	'maps_unrecognized_coords' => '{{PLURAL:$2|La siguiente coordenada no fue reconocida|Las siguientes coordenadas no fueron reconocidas}}: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|La coordenada siguiente no es reconocida|Las coordenadas siguientes no son reconocidas}} y PLURAL:$2|{{han sido omitidas|han sido omitidas}} del mapa :$1',
	'maps_map_cannot_be_displayed' => 'No se puede mostrar el mapa.',
	'maps-geocoder-not-available' => 'La funcionalidad de geocodificación de Maps no está disponible. Su ubicación no puede ser geocodificada.',
	'maps_click_to_activate' => 'Haz clic para activar el mapa',
	'maps_centred_on' => 'Mapa centrado en $1, $2.',
	'maps_overlays' => 'Superposiciones',
	'maps_photos' => 'Fotos',
	'maps_videos' => 'Videos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Cámaras Web',
);

/** Estonian (Eesti)
 * @author Hendrik
 */
$messages['et'] = array(
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Laiuskraad:',
	'maps-longitude' => 'Pikkuskraad:',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'maps-abb-north' => 'I',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'H',
	'maps-abb-west' => 'M',
	'maps-latitude' => 'Latitudea:',
	'maps-longitude' => 'Longitudea:',
	'maps_coordinates_missing' => 'Ez dago koordenaturik maparentzat.',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'maps_desc' => 'Mahdollistaa koordinaattitiedon esittämisen karttoina ja osoitteiden geokoodauksen ([http://mapping.referata.com/wiki/Maps_examples demo]).
Käytettävissä olevat karttapalvelut: $1',
	'maps_map' => 'Kartta',
	'maps-loading-map' => 'Ladataan karttaa...',
	'maps-abb-north' => 'Pohj.',
	'maps-abb-east' => 'It.',
	'maps-abb-south' => 'Etel.',
	'maps-abb-west' => 'Länt.',
	'maps-latitude' => 'Korkeusaste:',
	'maps-longitude' => 'Pituuspiiri:',
	'maps-invalid-coordinates' => 'Arvoa $1 ei tunnistettu oikeaksi koordinaattisarjaksi.',
	'maps_coordinates_missing' => 'Karttaa varten ei tarjottu koordinaatteja.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Seuraavaa osoitetta|Seuraavia osoitteita}} ei voitu geokoodata: $1.
Karttaa ei voida näyttää.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Seuraavaa osoitetta|Seuraavia osoitteita}} ei voitu geokoodata ja {{PLURAL:$2|on|ovat}} jätetty kartalta: $1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|Seuraavaa koordinaattia|Seuraavia koordinaatteja}} ei tunnistettu: $1.',
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
 * @author Peter17
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Verdy p
 */
$messages['fr'] = array(
	'maps_name' => 'Cartes',
	'maps_desc' => 'Permet d’afficher des coordonnées dans des cartes, ainsi que des adresses géocodées ([http://mapping.referata.com/wiki/Maps_examples démonstration]).
Services de cartographie disponibles : $1',
	'maps_map' => 'Carte',
	'maps-loading-map' => 'Chargement de la carte...',
	'maps-markers' => 'Marqueurs',
	'maps-others' => 'autres',
	'maps-ns-layer' => 'Couche',
	'maps-ns-layer-talk' => 'Discussion couche',
	'maps-layer-property' => 'Propriété',
	'maps-layer-value' => 'Valeur',
	'maps-layer-errors' => 'Erreurs',
	'maps-error-invalid-layerdef' => 'Cette définition de couche n’est pas valide.',
	'maps-error-invalid-layertype' => 'Il n’y a pas de couche de type « $1 ». Seul {{PLURAL:$3|ce type est|ces types sont}} pris en charge : $2',
	'maps-error-no-layertype' => 'Vous devez spécifier le type de couche. {{PLURAL:$2|Seul ce type est|Ces types sont}}  pris en charge : $1',
	'validation-error-invalid-layer' => 'Le paramètre $1 doit être une couche valide.',
	'validation-error-invalid-layers' => 'Le paramètre $1 doit être une ou plusieurs couche(s) valide(s).',
	'maps-layer-of-type' => 'Couche de type $1',
	'maps-layer-type-supported-by' => 'Ce type de couche peut {{PLURAL:$2|être utilisé uniquement avec le service de cartographie $1|être utilisé avec ces services de cartographie : $1}}.',
	'validation-error-invalid-location' => 'Le paramètre $1 doit être un emplacement valide.',
	'validation-error-invalid-locations' => 'Le paramètre $1 doit être un ou plusieurs emplacement(s) valide(s).',
	'validation-error-invalid-width' => 'Le paramètre $1 doit être une largeur valide.',
	'validation-error-invalid-height' => 'Le paramètre $1 doit être une hauteur valide.',
	'validation-error-invalid-distance' => 'Le paramètre $1 doit être une distance valide.',
	'validation-error-invalid-distances' => 'Le paramètre $1 doit être une ou plusieurs distance(s) valide(s).',
	'validation-error-invalid-image' => 'Le paramètre $1 doit être une image valide.',
	'validation-error-invalid-images' => 'Le paramètre $1 doit être une ou plusieurs image(s) valide(s).',
	'validation-error-invalid-goverlay' => 'Le paramètre $1 doit être un recouvrement valide.',
	'validation-error-invalid-goverlays' => 'Le paramètre $1 doit être un ou plusieurs recouvrement(s) valide(s).',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'O',
	'maps-latitude' => 'Latitude :',
	'maps-longitude' => 'Longitude :',
	'maps-invalid-coordinates' => "La valeur $1 n'a pas été reconnue comme un ensemble de coordonnées valable.",
	'maps_coordinates_missing' => "Aucune coordonnée n'a été fournie pour le plan.",
	'maps_geocoding_failed' => "{{PLURAL:$2|L′adresse suivante n'as pu être géocodée|Les adresses suivantes n'ont pas pu être géocodées}} : $1.
Le plan ne peut pas être affiché.",
	'maps_geocoding_failed_for' => '{{PLURAL:$2|L′adresse suivante n’as pu être géocodée|Les adresses suivantes n’ont pas pu être géocodées}} et {{PLURAL:$2|n’est pas affichée|ne sont pas affichées}} sur le plan : $1',
	'maps_unrecognized_coords' => "{{PLURAL:$2|La coordonnée suivante n'a pas été reconnue|Les coordonnées suivantes n'ont pas été reconnues}} : $1.",
	'maps_unrecognized_coords_for' => "{{PLURAL:$2|La coordonnée suivante n'a pas été reconnue|Les coordonnées suivantes n'ont pas été reconnues}} et {{PLURAL:$2|a été omise|ont été omises}} sur la carte :
$1",
	'maps_map_cannot_be_displayed' => 'La carte ne peut pas être affichée.',
	'maps-geocoder-not-available' => "La fonctionnalité géocodage des cartes n'est pas disponible. Votre emplacement ne peut être géocodé.",
	'maps_click_to_activate' => 'Cliquer pour activer la carte',
	'maps_centred_on' => 'Carte centrée sur $1, $2.',
	'maps_overlays' => 'Superpositions',
	'maps_photos' => 'Photos',
	'maps_videos' => 'Vidéos',
	'maps_wikipedia' => 'Wikipédia',
	'maps_webcams' => 'Webcams',
);

/** Franco-Provençal (Arpetan) */
$messages['frp'] = array(
	'maps-abb-north' => 'B',
	'maps-abb-east' => 'L',
	'maps-abb-south' => 'M',
	'maps-abb-west' => 'P',
	'maps-latitude' => 'Latituda :',
	'maps-longitude' => 'Longituda :',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'maps_desc' => 'Al furnìs la possibilitât di mostrâ i dâts de coordinadis e lis direzions geocodificadis intune mape ([http://mapping.referata.com/wiki/Maps_examples demo]).
Servizis di mapis disponibii: $1',
	'maps_map' => 'Mape',
	'maps_coordinates_missing' => 'Nissune coordenade furnide pe mape.',
	'maps_geocoding_failed' => '{{PLURAL:$2|La direzion ca sot no pues jessi geocodificade|Lis direzions ca sot no puedin jessi geocodificadis}}: $1.
La mape no pues jessi mostrade.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|La direzion|Lis direzions}} ca sot no {{PLURAL:$2|pues|puedin}} jessi {{PLURAL:$2|geocodificade|geocodificadis}} e  {{PLURAL:$2|no je mostrade|no son mostradis}} te mape:
$1',
);

/** Galician (Galego)
 * @author Gallaecio
 * @author Toliño
 */
$messages['gl'] = array(
	'maps_desc' => 'Proporciona a capacidade de mostrar datos de coordenadas en mapas, e enderezos xeocodificados ([http://mapping.referata.com/wiki/Maps_examples demostración]).
Servizos de cartografía dispoñibles: $1',
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'Cargando o mapa...',
	'maps-markers' => 'Marcadores',
	'maps-others' => 'outros',
	'maps-ns-layer' => 'Capa',
	'maps-ns-layer-talk' => 'Conversa capa',
	'maps-layer-property' => 'Propiedade',
	'maps-layer-value' => 'Valor',
	'maps-layer-errors' => 'Erros',
	'maps-error-invalid-layerdef' => 'A definición desta capa non é válida.',
	'maps-error-invalid-layertype' => 'Non existen capas do tipo "$1". Só {{PLURAL:$3|está soportado este tipo|están soportados estes tipos}}: $2',
	'maps-error-no-layertype' => 'Cómpre especificar o tipo de capa. {{PLURAL:$3|Só está soportado este tipo|Están soportados estes tipos}}: $1',
	'validation-error-invalid-layer' => 'O parámetro $1 debe ser unha capa válida.',
	'validation-error-invalid-layers' => 'O parámetro $1 debe ser unha ou máis capas válidas.',
	'maps-layer-of-type' => 'Capa de tipo $1',
	'maps-layer-type-supported-by' => 'Este tipo de capa só se pode empregar {{PLURAL:$2|co servizo de mapas $1|con estes servizos de mapas: $1}}.',
	'validation-error-invalid-location' => 'O parámetro $1 debe ser unha localización válida.',
	'validation-error-invalid-locations' => 'O parámetro $1 debe ser unha ou máis localizacións válidas.',
	'validation-error-invalid-width' => 'O parámetro $1 debe ser un largo válido.',
	'validation-error-invalid-height' => 'O parámetro $1 debe ser unha altura válida.',
	'validation-error-invalid-distance' => 'O parámetro $1 debe ser unha distancia válida.',
	'validation-error-invalid-distances' => 'O parámetro $1 debe ser unha ou máis distancias válidas.',
	'validation-error-invalid-image' => 'O parámetro $1 debe ser unha imaxe válida.',
	'validation-error-invalid-images' => 'O parámetro $1 debe ser unha ou máis imaxes válidas.',
	'validation-error-invalid-goverlay' => 'O parámetro $1 debe ser unha capa de superposición válida.',
	'validation-error-invalid-goverlays' => 'O parámetro $1 debe ser unha ou máis capas de superposición válidas.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'L',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'O',
	'maps-latitude' => 'Latitude:',
	'maps-longitude' => 'Lonxitude:',
	'maps-invalid-coordinates' => 'O valor $1 non foi recoñecido como un conxunto de coordenadas válido.',
	'maps_coordinates_missing' => 'Non se proporcionou ningunha coordenada para o mapa.',
	'maps_geocoding_failed' => '{{PLURAL:$2|O seguinte enderezo non se puido xeocodificar|Os seguintes enderezos non se puideron xeocodificar}}: $1.
O mapa non se pode mostrar.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|O seguinte enderezo non se puido xeocodificar|Os seguintes enderezos non se puideron xeocodificar}} e {{PLURAL:$2|omitiuse|omitíronse}} no mapa: $1.',
	'maps_unrecognized_coords' => 'Non se {{PLURAL:$2|recoñeceu a seguinte coordenada|recoñeceron as seguintes coordenadas}}: $1.',
	'maps_unrecognized_coords_for' => 'Non se {{PLURAL:$2|recoñeceu a seguinte coordenada|recoñeceron as seguintes coordenadas}} e {{PLURAL:$2|foi omitida|foron omitidas}} do mapa:
$1',
	'maps_map_cannot_be_displayed' => 'O mapa non se pode mostrar.',
	'maps-geocoder-not-available' => 'A funcionalidade de xeocodificación de mapas non está dispoñible; non se pode xeocodificar a súa situación.',
	'maps_click_to_activate' => 'Prema para activar o mapa',
	'maps_centred_on' => 'Mapa centrado en $1, $2.',
	'maps_overlays' => 'Sobreposicións',
	'maps_photos' => 'Fotos',
	'maps_videos' => 'Vídeos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Cámaras web',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ) */
$messages['grc'] = array(
	'maps-abb-north' => 'Β',
	'maps-abb-east' => 'Α',
	'maps-abb-south' => 'Ν',
	'maps-abb-west' => 'Δ',
	'maps-latitude' => 'Πλάτος γεωγραφικόν:',
	'maps-longitude' => 'Μῆκος γεωγραφικόν:',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'maps_desc' => 'Ergänzt d Megligkeit Koordinatedate in Charte un Geocodeadrässe aazzeige. Verfiegbari Chartedienscht: $1. [http://www.mediawiki.org/wiki/Extension:Maps Dokumäntation]. [http://mapping.referata.com/wiki/Maps_examples Demo]',
	'maps_map' => 'Charte',
	'maps-loading-map' => 'Am Lade vu dr Charte ...',
	'maps-markers' => 'Markierige',
	'maps-others' => 'anderi',
	'maps-ns-layer' => 'Ebeni',
	'maps-ns-layer-talk' => 'Ebeni Diskussion',
	'maps-layer-property' => 'Eigeschaft',
	'maps-layer-value' => 'Wärt',
	'maps-layer-errors' => 'Fähler',
	'maps-error-invalid-layerdef' => 'D Aagabe zue däre Ebeni sin nit giltig.',
	'maps-error-invalid-layertype' => 'S git kei Ebene vum Typ „$1“. Nume {{PLURAL:$3|dää Typ wird|die Type wäre}} unterstitzt: $2',
	'maps-error-no-layertype' => 'Dr Ebenetyp mueß aagee wäre. Nume {{PLURAL:$2|dää Typ wird|die Typen wäre}} unterstitzt: $1',
	'validation-error-invalid-layer' => 'Parameter $1 mueß e giltigi Ebeni syy.',
	'validation-error-invalid-layers' => 'Parameter $1 mueß ei oder meh giltigi Ebene syy.',
	'maps-layer-of-type' => 'Ebeni vum Typ $1',
	'maps-layer-type-supported-by' => 'Dää Ebenetyp cha {{PLURAL:$2|nume bim Kartografidienscht $1 brucht wäre|bi däne Kartografidienscht brucht wäre: $1}}.',
	'validation-error-invalid-location' => 'Parameter $1 mueß e giltige Standort syy.',
	'validation-error-invalid-locations' => 'Parameter $1 mueß ei oder meh giltigi Standort syy.',
	'validation-error-invalid-width' => 'Parameter $1 mueß e giltigi Breiti syy.',
	'validation-error-invalid-height' => 'Parameter $1 mueß e giltigi Lengi syy.',
	'validation-error-invalid-distance' => 'Parameter $1 mueß e giltigi Entfärnig syy.',
	'validation-error-invalid-distances' => 'Parameter $1 mueß ei oder meh giltigi Entfärnige syy.',
	'validation-error-invalid-image' => 'Parameter $1 mueß e giltig Bild syy.',
	'validation-error-invalid-images' => 'Parameter $1 mueß ei oder meh giltigi Bilder syy.',
	'validation-error-invalid-goverlay' => 'Parameter $1 mueß e giltigi Iberlagerig syy.',
	'validation-error-invalid-goverlays' => 'Parameter $1 mueß ei oder meh giltigi Iberlagerige syy.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'O',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Breiti:',
	'maps-longitude' => 'Lengi:',
	'maps-invalid-coordinates' => 'Dr Wärt $1 isch nit erkännt wore as giltige Satz vu Koordinate.',
	'maps_coordinates_missing' => 'S git kei Koordinate fir die Charte.',
	'maps_geocoding_failed' => 'Die {{PLURAL:$2|Adräss het|Adräss hän}} nit chenne georeferänziert wäre: $1. D Charte cha nit aazeigt wäre.',
	'maps_geocoding_failed_for' => 'Die {{PLURAL:$2|Adräss het|Adrässe hän}} nit chenne georeferänziert wäre un {{PLURAL:$2|isch|sin}} us dr Charte uusegnuu wore: $1',
	'maps_unrecognized_coords' => 'Die {{PLURAL:$2|Koordinate isch|Koordinate sin}} nit erkannt wore: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Die Koordinate isch nit erkannt wore un isch|Die Koordinate sin nit erkannt wore un sin}} wäge däm uusegnuu wore us dr Charte:
$1',
	'maps_map_cannot_be_displayed' => 'D Charte cha nit aazeigt wäre.',
	'maps-geocoder-not-available' => 'S Geokodierigs-Feature vu däre Charte isch nit verfiegbar, Dyy Ort cha nit geokodiert wäre.',
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
 * @author Yonidebest
 */
$messages['he'] = array(
	'maps_desc' => 'הוספת האפשרות להצגת נתוני קואורדינטות במפות וכתובות geocode ([http://mapping.referata.com/wiki/Maps_examples demo]).
שירותי המיפוי הזמינים: $1',
	'maps_map' => 'מפה',
	'maps-loading-map' => 'המפה נטענת...',
	'maps-markers' => 'סמנים',
	'maps-ns-layer' => 'שכבה',
	'maps-ns-layer-talk' => 'דיון השכבה',
	'maps-layer-property' => 'מאפיין',
	'maps-layer-value' => 'ערך',
	'maps-layer-errors' => 'שגיאות',
	'validation-error-invalid-distance' => 'הערך $1 אינו מרחק תקין.',
	'maps-abb-north' => "צפ'",
	'maps-abb-east' => "מז'",
	'maps-abb-south' => "דר'",
	'maps-abb-west' => "מע'",
	'maps-latitude' => 'קו רוחב:',
	'maps-longitude' => 'קו אורך:',
	'maps-invalid-coordinates' => 'הערך $1 לא זוהה כסדרת קואורדינטות תקינה.',
	'maps_coordinates_missing' => 'לא סופקו קואורדינטות למפה.',
	'maps_geocoding_failed' => 'לא ניתן לייצר geocode עבור {{PLURAL:$2|הכתובת הבאה|הכתובות הבאות}}: $1.
לא ניתן להציג את המפה.',
	'maps_geocoding_failed_for' => 'לא ניתן לייצר geocode עבור {{PLURAL:$2|הכתובת הבאה|הכתובות הבאות}}, ולכן {{PLURAL:$2|היא הושמטה|הן הושמטו}} מהמפה:
$1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|הקואורדינטה הבאה אינה מזוהה|הקואורדינטות הבאות אינן מזוהות}}: $1.',
	'maps_map_cannot_be_displayed' => 'לא ניתן להציג את המפה.',
	'maps-geocoder-not-available' => 'הקידוד הגיאוקרטוגרפי של מפות אינו זמין. לא ניתן לקודד את המיקום שנבחר.',
	'maps_click_to_activate' => 'יש ללחוץ כדי להפעיל את המפה',
	'maps_centred_on' => 'המפה ממורכזת סביב $1,$2',
	'maps_overlays' => 'שכבות',
	'maps_photos' => 'תמונות',
	'maps_videos' => 'סרטוני וידאו',
	'maps_wikipedia' => 'ויקיפדיה',
	'maps_webcams' => 'מצלמות אינטרנט',
);

/** Hindi (हिन्दी) */
$messages['hi'] = array(
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'अक्षांश:',
	'maps-longitude' => 'रेखांश:',
);

/** Croatian (Hrvatski)
 * @author Ex13
 */
$messages['hr'] = array(
	'maps_desc' => 'Pruža mogućnost prikaza podataka o koordinatama na kartama, te geokodiranih adresa ([http://mapping.referata.com/wiki/Maps_examples demo]). Dostupne usluge kartiranja: $1',
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
	'maps_desc' => 'Skići móžnosć koordinatowe daty w geografiskich kartach a geokodne adresy zwobraznić ([http://mapping.referata.com/wiki/Maps_examples demo]). 
K dispoziciji stejace kartowe słužby: $1',
	'maps_map' => 'Karta',
	'maps-loading-map' => 'Karta so začituje...',
	'maps-markers' => 'Marki',
	'maps-others' => 'druhe',
	'maps-ns-layer' => 'Runina',
	'maps-ns-layer-talk' => 'Diskusija runiny',
	'maps-layer-property' => 'Kajkosć',
	'maps-layer-value' => 'Hódnota',
	'maps-layer-errors' => 'Zmylki',
	'maps-error-invalid-layerdef' => 'Definicija tuteje runiny płaćiwa njeje.',
	'maps-error-invalid-layertype' => 'Njejsu žane runiny typa "$1". Jenož {{PLURAL:$3|tutón typ so podpěruje|tutej typaj so podpěrujetej|tute typy so podpěruja|tute typy so podpěruja}}: $2',
	'maps-error-no-layertype' => 'Dyrbiš typ runiny podać: {{PLURAL:$2|Jenož tutón typ so podpěruje|Tutej typaj so podpěrujetej|Tute typy so podpěruja|Tute typy so podpěruja}}: $1',
	'validation-error-invalid-layer' => 'Parameter $1 dyrbi płaćiwa runina być.',
	'validation-error-invalid-layers' => 'Parameter $1 dyrbi jedna runina abo wjacore runiny być.',
	'maps-layer-of-type' => 'Runina typa $1',
	'maps-layer-type-supported-by' => 'Tutón typ runiny móže so {{PLURAL:$2|jenož z kartografiskej słužbu $1|z tutej kartografiskimaj słužbomaj: $1|z tutymi kartografiskimi słužbami: $1|z tutymi kartografiskimi słužbami: $1}}.wužiwać.',
	'validation-error-invalid-location' => 'Parameter $1 dyrbi płaćiwe městno być.',
	'validation-error-invalid-locations' => 'Parameter $1 dyrbi jedne městno abo wjacore městna być.',
	'validation-error-invalid-width' => 'Parameter $1 dyrbi płaćiwa šěrokosć być.',
	'validation-error-invalid-height' => 'Parameter $1 dyrbi płaćiwa wysokosć być.',
	'validation-error-invalid-distance' => 'Parameter $1 dyrbi płaćiwa distanca być.',
	'validation-error-invalid-distances' => 'Parameter $1 dyrbi jedna distanca abo wjacore distancy być.',
	'validation-error-invalid-image' => 'Parameter $1 dyrbi płaćiwy wobraz być.',
	'validation-error-invalid-images' => 'Parameter $1 dyrbi jedyn wobraz abo wjacore wobrazy być.',
	'validation-error-invalid-goverlay' => 'Parameter $1 dyrbi płaćiwa woršta być.',
	'validation-error-invalid-goverlays' => 'Parameter $1 dyrbi jedna woršta abo wjacore woršty być.',
	'maps-abb-north' => 'S',
	'maps-abb-east' => 'W',
	'maps-abb-south' => 'J',
	'maps-abb-west' => 'Z',
	'maps-latitude' => 'Šěrina:',
	'maps-longitude' => 'Dołhosć:',
	'maps-invalid-coordinates' => 'Hódnota $1 njebu jako płaćiwu sadźbu koordinatow spóznata.',
	'maps_coordinates_missing' => 'Za kartu njejsu koordinaty podate.',
	'maps_geocoding_failed' => 'Geokodowanje {{PLURAL:$2|slědowaceje adresy|slědowaceju adresow|slědowacych adresow|slědowacych adresow}} njebě móžno: $1. Karta njeda so zwobraznić.',
	'maps_geocoding_failed_for' => 'Geokodowanje {{PLURAL:$2|slědowaceje adresy|slědowaceju adresow|slědowacych adresow|slědowacych adresow}} njebě móžno a {{PLURAL:$2|tuta adresa|tutej adresy|tute adresy|tute adresy}} so na karće {{PLURAL:$2|wuwostaja|wuwostajetej|wuwostajeja|wuwostajeja}}: $1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|Slědowaca koordinata njebu spóznana|Slědowacej koordinaće njebuštej spóznanej|Slědowace koordinaty njebuchu spóznane|Slědowace koordinaty njebuchu spóznane}}: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Slědowaca koordinata njebu spóznana|Slědowacej koordinaće njebuštej spóznanej|Slědowace koordinaty njebuchu spóznane|Slědowace koordinaty njebuchu spóznane}} a {{PLURAL:$2|bu na karće wuwostajena|buštej na karće wuwostajenej|buchu na karće wuwostajene|buchu na karće wuwostajene}}: $1',
	'maps_map_cannot_be_displayed' => 'Karta njeda so zwobraznić.',
	'maps-geocoder-not-available' => 'Funkcija geokodowanja Kartow k dispoziciji njesteji, twoje městno njehodźi so geokodować.',
	'maps_click_to_activate' => 'Klikń, zo by kartu aktiwizował',
	'maps_centred_on' => 'Karta na $1, $2 centrowana.',
	'maps_overlays' => 'Naworštowanja',
	'maps_photos' => 'Fota',
	'maps_videos' => 'Wideja',
	'maps_wikipedia' => 'Wikipedija',
	'maps_webcams' => 'Webcamy',
);

/** Haitian (Kreyòl ayisyen) */
$messages['ht'] = array(
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 * @author Misibacsi
 */
$messages['hu'] = array(
	'maps_desc' => 'Lehetővé teszi koordinátaadatok és geokódolt címek megjelenítését térképeken ([http://mapping.referata.com/wiki/Maps_examples demó]). Elérhető térképszolgáltatások: $1',
	'maps_map' => 'Térkép',
	'maps-loading-map' => 'Térkép betöltése…',
	'maps-markers' => 'Markerek',
	'maps-ns-layer' => 'Réteg',
	'maps-ns-layer-talk' => 'Rétegvita',
	'maps-layer-property' => 'Tulajdonság',
	'maps-layer-value' => 'Érték',
	'maps-layer-errors' => 'Hibák',
	'maps-error-invalid-layerdef' => 'A rétegdefiníció érvénytelen.',
	'validation-error-invalid-location' => 'A $1 paraméternek valós helynek kell lennie.',
	'validation-error-invalid-width' => 'A $1 paraméternek valós szélességnek kell lennie.',
	'validation-error-invalid-height' => 'A $1 paraméternek valós magasságnak kell lennie.',
	'validation-error-invalid-distance' => 'A $1 paraméter nem valós távolság.',
	'validation-error-invalid-image' => 'A(z) $1 paraméter csak érvényes kép lehet.',
	'validation-error-invalid-images' => 'A(z) $1 paraméter csak egy vagy több érvényes kép lehet.',
	'validation-error-invalid-goverlay' => 'A(z) $1 paraméter csak érvényes réteg lehet.',
	'validation-error-invalid-goverlays' => 'A(z) $1 paraméter csak egy vagy több érvényes réteg lehet.',
	'maps-abb-north' => 'É',
	'maps-abb-east' => 'K',
	'maps-abb-south' => 'D',
	'maps-abb-west' => 'Ny',
	'maps-latitude' => 'Földrajzi szélesség:',
	'maps-longitude' => 'Földrajzi hosszúság:',
	'maps-invalid-coordinates' => 'A(z) „$1” érték nem érvényes koordinátacsoport.',
	'maps_coordinates_missing' => 'Nincsenek megadva koordináták a térképhez.',
	'maps_geocoding_failed' => 'A következő {{PLURAL:$2|cím|címek}} nem geokódolhatók: $1.
A térképet nem lehet megjeleníteni.',
	'maps_geocoding_failed_for' => 'A következő {{PLURAL:$2|cím nem geokódolható|címek nem geokódolhatóak}}, és nem {{PLURAL:$2|szerepel|szerepelnek}} a térképen:
$1',
	'maps_unrecognized_coords' => 'A következő {{PLURAL:$2|koordinátát|koordinátákat}} nem sikerült felismerni: $1.',
	'maps_unrecognized_coords_for' => 'A következő {{PLURAL:$2|koordinátát|koordinátákat}} nem sikerült felismerni, és el {{PLURAL:$2|lett|lettek}} távolítva a térképről: $1',
	'maps_map_cannot_be_displayed' => 'A térképet nem sikerült megjeleníteni.',
	'maps-geocoder-not-available' => 'A térképek kiterjesztés geokódoló funkciója nem elérhető. A tartózkodási helyed nem geokódolható.',
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
	'maps_desc' => 'Permitte monstrar datos de coordinatas in mappas, e adresses geocodice ([http://mapping.referata.com/wiki/Maps_examples demo]).
Servicios cartographic disponibile: $1',
	'maps_map' => 'Carta',
	'maps-loading-map' => 'Cargamento del carta…',
	'maps-markers' => 'Marcatores',
	'maps-others' => 'alteres',
	'maps-ns-layer' => 'Strato',
	'maps-ns-layer-talk' => 'Discussion Strato',
	'maps-layer-property' => 'Proprietate',
	'maps-layer-value' => 'Valor',
	'maps-layer-errors' => 'Errores',
	'maps-error-invalid-layerdef' => 'Iste definition de strato non es valide.',
	'maps-error-invalid-layertype' => 'Il non ha stratos del typo "$1". Solmente iste {{PLURAL:$3|typo|typos}} es supportate: $2',
	'maps-error-no-layertype' => 'Tu debe specificar le typo de strato. {{PLURAL:$2|Solmente iste typo|Iste typos}} es supportate: $1',
	'validation-error-invalid-layer' => 'Le parametro $1 debe esser un strato valide.',
	'validation-error-invalid-layers' => 'Le parametro $1 debe esser un o plus stratos valide.',
	'maps-layer-of-type' => 'Strato del typo $1',
	'maps-layer-type-supported-by' => 'Iste typo de strato pote {{PLURAL:$2|solmente esser usate con le servicio cartographic|esser usate con le sequente servicios cartographic:}} $1.',
	'validation-error-invalid-location' => 'Le parametro $1 debe esser un loco valide.',
	'validation-error-invalid-locations' => 'Le parametro $1 debe esser un o plus locos valide.',
	'validation-error-invalid-width' => 'Le parametro $1 debe esser un latitude valide.',
	'validation-error-invalid-height' => 'Le parametro $1 debe esser un altitude valide.',
	'validation-error-invalid-distance' => 'Le parametro $1 debe esser un distantia valide.',
	'validation-error-invalid-distances' => 'Le parametro $1 debe esser un o plus distantias valide.',
	'validation-error-invalid-image' => 'Le parametro $1 debe esser un imagine valide.',
	'validation-error-invalid-images' => 'Le parametro $1 debe esser un o plus imagines valide.',
	'validation-error-invalid-goverlay' => 'Le parametro $1 debe esser un superposition valide.',
	'validation-error-invalid-goverlays' => 'Le parametro $1 debe esser un o plus superpositiones valide.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Latitude:',
	'maps-longitude' => 'Longitude:',
	'maps-invalid-coordinates' => 'Le valor $1 non es recognoscite qua coordinatas valide.',
	'maps_coordinates_missing' => 'Nulle coordinata providite pro le mappa.',
	'maps_geocoding_failed' => 'Le sequente {{PLURAL:$2|adresse|adresses}} non poteva esser geocodificate: $1.
Le mappa non pote esser monstrate.',
	'maps_geocoding_failed_for' => 'Le sequente {{PLURAL:$2|adresse|adresses}} non poteva esser geocodificate e ha essite omittite del mappa:
$1',
	'maps_unrecognized_coords' => 'Le sequente {{PLURAL:$2|coordinata|coordinatas}} non esseva recognoscite: $1.',
	'maps_unrecognized_coords_for' => 'Le sequente {{PLURAL:$2|coordinata|coordinatas}} non esseva recognoscite e ha essite omittite del carta:
$1',
	'maps_map_cannot_be_displayed' => 'Le carta on pote esser monstrate.',
	'maps-geocoder-not-available' => 'Le function de geocodification de Maps non es disponibile; tu loco non pote esser geocodificate.',
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
	'maps_desc' => "Memampukan tampilan data koordinat pada peta, dan alamat ''geocode'' ([http://mapping.referata.com/wiki/Maps_examples demo]). 
Layanan pemetaan yang tersedia: $1",
	'maps_map' => 'Peta',
	'maps-loading-map' => 'Memuat peta...',
	'maps-markers' => 'Tanda',
	'maps-others' => 'lainnya',
	'maps-ns-layer' => 'Lapisan',
	'maps-ns-layer-talk' => 'Pembicaraan lapisan',
	'maps-layer-property' => 'Properti',
	'maps-layer-value' => 'Nilai',
	'maps-layer-errors' => 'Kesalahan',
	'maps-error-invalid-layerdef' => 'Definisi lapisan tidak valid.',
	'maps-error-invalid-layertype' => 'Tidak ada lapisan jenis "$1". {{PLURAL:$3|Jenis|Jenis}} yang didukung: $2',
	'maps-error-no-layertype' => 'Anda perlu menentukan jenis lapisan. {{PLURAL:$2|Jenis|Jenis}} yang didukung: $1',
	'validation-error-invalid-layer' => 'Parameter $1 harus merupakan lapisan yang sah.',
	'validation-error-invalid-layers' => 'Parameter $1 harus berupa satu atau lebih lapisan yang sah.',
	'maps-layer-of-type' => 'Lapisan jenis $1',
	'maps-layer-type-supported-by' => 'Lapisan ini hanya dapat digunakan oleh layanan pemetaan {{PLURAL:$2|$1|$1}}.',
	'validation-error-invalid-location' => 'Parameter $1 harus merupakan lokasi yang sah.',
	'validation-error-invalid-locations' => 'Parameter $1 harus berupa satu atau lebih lokasi yang sah.',
	'validation-error-invalid-width' => 'Parameter $1 harus merupakan lebar yang sah.',
	'validation-error-invalid-height' => 'Parameter $1 harus merupakan tinggi yang sah.',
	'validation-error-invalid-distance' => 'Parameter $1 harus merupakan nilai jarak yang sah.',
	'validation-error-invalid-distances' => 'Parameter $1 harus berupa satu atau lebih jarak yang sah.',
	'validation-error-invalid-image' => 'Parameter $1 harus merupakan berkas yang sah.',
	'validation-error-invalid-images' => 'Parameter $1 harus berupa satu atau lebih berkas yang sah.',
	'validation-error-invalid-goverlay' => 'Parameter $1 harus merupakan hamparan yang sah.',
	'validation-error-invalid-goverlays' => 'Parameter $1 harus berupa satu atau lebih hamparan yang sah.',
	'maps-abb-north' => 'U',
	'maps-abb-east' => 'T',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'B',
	'maps-latitude' => 'Lintang:',
	'maps-longitude' => 'Bujur:',
	'maps-invalid-coordinates' => 'Nilai $1 tidak dikenali sebagai rangkaian koordinat yang sah.',
	'maps_coordinates_missing' => 'Tidak koordinat yang disediakan bagi peta.',
	'maps_geocoding_failed' => '{{PLURAL:$2|alamat|alamat}} berikut tidak dapat di Geocode: $1. 
Peta tidak dapat ditampilkan.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|alamat|alamat}} berikut tidak dapat di Geocode dan  {{PLURAL:$2|telah|telah}} dihilangkan dari peta: $1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|Koordinat|Koordinat}} berikut tidak dikenali: $1.',
	'maps_unrecognized_coords_for' => 'Koordinat berikut tidak dikenali dan {{PLURAL:$2|telah|telah}} diabaikan dari peta:
$1',
	'maps_map_cannot_be_displayed' => 'Peta tak dapat ditampilkan.',
	'maps-geocoder-not-available' => 'Fitur kodegeo Peta tidak tersedia. Lokasi Anda tidak dapat dikodegeokan',
	'maps_click_to_activate' => 'Klik untuk mengaktifkan peta',
	'maps_centred_on' => 'Peta dipusatkan di $1, $2.',
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

/** Italian (Italiano)
 * @author Civvì
 * @author Gianfranco
 * @author HalphaZ
 */
$messages['it'] = array(
	'maps_desc' => "Fornisce la possibilità di visualizzare i dati di coordinate su mappe e la geocodifica di indirizzi ([http://wiki.bn2vs.com/wiki/Demo dell'estensione Maps]).
Servizi di cartografia disponibili: $1",
	'maps_map' => 'Mappa',
	'maps-loading-map' => 'Caricamento mappa ...',
	'maps-markers' => 'Marcatori',
	'validation-error-invalid-distance' => 'Il valore $1 non è una distanza valida.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'O',
	'maps-latitude' => 'Latitudine:',
	'maps-longitude' => 'Longitudine:',
	'maps-invalid-coordinates' => 'Il valore $1 non è stato riconosciuto come un set di coordinate valido.',
	'maps_coordinates_missing' => 'Non sono state fornite coordinate per la mappa',
	'maps_geocoding_failed' => 'Non è stato possibile effettuare la geocodifica per {{PLURAL:$2|il seguente indirizzo|i seguenti indirizzi}}: $1.',
	'maps_geocoding_failed_for' => 'Non è stato possibile effettuare la geocodifica {{PLURAL:$2|del seguente indirizzo|dei seguenti indirizzi}} che {{PLURAL:$2|è stato omesso|sono stati omessi}} dalla mappa: $1.',
	'maps_unrecognized_coords' => '{{PLURAL:$2|La seguente coordinata|Le seguenti coordinate}} non sono state riconosciute: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|La seguente coordinata|Le seguenti coordinate}} {{PLURAL:$2|non è stata riconosciuta ed è stata omessa|non sono state riconosciute e sono state omesse}} dalla mappa: $1.',
	'maps_map_cannot_be_displayed' => 'La mappa non può essere visualizzata.',
	'maps-geocoder-not-available' => "La funzionalità di geocodifica dell'estensione Maps non è disponibile. La tua posizione non può essere geocodificata.",
	'maps_click_to_activate' => 'Clicca per attivare la mappa.',
	'maps_centred_on' => 'Mappa centrata su $1, $2.',
	'maps_overlays' => 'Overlay',
	'maps_photos' => 'Foto',
	'maps_videos' => 'Video',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcam',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Yanajin66
 * @author 青子守歌
 */
$messages['ja'] = array(
	'maps_desc' => '地図上に座標データを表示し、住所を座標データに変換する機能を提供する ([http://mapping.referata.com/wiki/Maps_examples 実演])。次の地図サービスに対応します: $1',
	'maps_map' => '地図',
	'maps-loading-map' => '地図を読み込み中…',
	'maps-markers' => 'マーカー',
	'maps-others' => 'その他',
	'maps-ns-layer' => 'レイヤー',
	'maps-ns-layer-talk' => 'レイヤー・トーク',
	'maps-layer-property' => '属性',
	'maps-layer-value' => '値',
	'maps-layer-errors' => 'エラー',
	'maps-error-invalid-layerdef' => 'このレイヤー定義は不正です。',
	'maps-error-invalid-layertype' => '種類「$1」のレイヤーが存在しません。{{PLURAL:$3|この|これら}}の種類のサポート：$2',
	'maps-error-no-layertype' => 'レイヤーの種類を指定する必要があります。{{PLURAL:$2|この種類のみ|これらの種類}}のサポート：$1',
	'validation-error-invalid-layer' => '引数$1は有効なレイヤーでなければなりません。',
	'validation-error-invalid-layers' => '引数$1は1つ以上の有効なレイヤーでなければなりません。',
	'maps-layer-of-type' => '種類$1のレイヤー',
	'maps-layer-type-supported-by' => 'このレイヤー種は、{{PLURAL:$2|$1地図サービスでのみ利用可能です|以下の地図サービスで利用可能です：$1}}。',
	'validation-error-invalid-location' => 'パラメータ$1は有効な場所でなければなりません。',
	'validation-error-invalid-locations' => '引数$1は、1つそれ以上有効な場所でなければなりません。',
	'validation-error-invalid-width' => 'パラメータ$1は有効な幅でなければなりません。',
	'validation-error-invalid-height' => 'パラメータ$1は有効な高さでなければなりません。',
	'validation-error-invalid-distance' => '引数$1は有効な距離でなければなりません。',
	'validation-error-invalid-distances' => '引数$1は、1つ以上の有効な距離でなければなりません。',
	'validation-error-invalid-image' => '引数$1は有効な画像でなければなりません。',
	'validation-error-invalid-images' => '引数$1は、1つ以上の有効な画像でなければなりません。',
	'validation-error-invalid-goverlay' => '引数$1は有効なオーバーレイでなければなりません。',
	'validation-error-invalid-goverlays' => '引数$1は、1つ以上の有効なオーバーレイでなければなりません。',
	'maps-abb-north' => '北',
	'maps-abb-east' => '東',
	'maps-abb-south' => '南',
	'maps-abb-west' => '西',
	'maps-latitude' => '緯度:',
	'maps-longitude' => '経度:',
	'maps-invalid-coordinates' => '値 $1 は座標の有効な組み合わせとして認識されませんでした。',
	'maps_coordinates_missing' => '地図に座標が指定されていません。',
	'maps_geocoding_failed' => '指定された{{PLURAL:$2|住所}}の座標への変換に失敗しました。 $1。地図は表示できません。',
	'maps_geocoding_failed_for' => '指定された{{PLURAL:$2|住所|複数の住所}}の座標への変換に失敗したため、それらを地図から除外して表示します。$1',
	'maps_unrecognized_coords' => '以下の{{PLURAL:$2|座標}}は認識されませんでした: $1',
	'maps_unrecognized_coords_for' => '以下の{{PLURAL:$2|座標}}は認識されなかったため、地図から省かれています:
$1',
	'maps_map_cannot_be_displayed' => 'この地図は表示できません。',
	'maps-geocoder-not-available' => '地図のジオコーディング機能は利用できません。指定した位置をジオコーディングできません。',
	'maps_click_to_activate' => 'クリックして地図をアクティブに',
	'maps_centred_on' => '地図の中心は $1、$2。',
	'maps_overlays' => 'オーバーレイ',
	'maps_photos' => '写真',
	'maps_videos' => '動画',
	'maps_wikipedia' => 'ウィキペディア',
	'maps_webcams' => 'ウェブカメラ',
);

/** Javanese (Basa Jawa) */
$messages['jv'] = array(
	'maps-abb-north' => 'L',
	'maps-abb-east' => 'W',
	'maps-abb-south' => 'Kdl',
	'maps-abb-west' => 'Kln',
	'maps-latitude' => 'Latituda:',
	'maps-longitude' => 'Longituda:',
);

/** Georgian (ქართული)
 * @author Temuri rajavi
 */
$messages['ka'] = array(
	'maps_map' => 'რუკა',
	'maps_videos' => 'ვიდეოები',
);

/** Khmer (ភាសាខ្មែរ) */
$messages['km'] = array(
	'maps-abb-north' => 'ជ',
	'maps-abb-east' => 'ក',
	'maps-abb-south' => 'ត្ប',
	'maps-abb-west' => 'ល',
	'maps-latitude' => 'រយះទទឹង៖',
	'maps-longitude' => 'រយះបណ្តោយ៖',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'maps_wikipedia' => 'ವಿಕಿಪೀಡಿಯ',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'maps_desc' => 'Määt et müjjelesch, Koodinaate en Landkaate aanzezeije, un Addräße en Koodinaate op de Ääd ömzerääschne. (E [http://mapping.referata.com/wiki/Maps_examples Beispöll]). He di Deenste för Landkaat(e) ham_mer ze beede: $1',
	'maps_map' => 'Kaat',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'O',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Breedt om Jlobus:',
	'maps-longitude' => 'Längde om Jlobus:',
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
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'Cargando la mapa...',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'O',
	'maps_photos' => 'Fotoggrafías',
	'maps_wikipedia' => 'Vikipedya',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'maps_desc' => "Gëtt d'Méiglechkeet fir d'Date vun de Koordinaten op Kaarten a Geocode Adressen ze weisen. Disponibel mapping Servicer: $1 [http://www.mediawiki.org/wiki/Extension:Maps Dokumentatioun]. [http://mapping.referata.com/wiki/Maps_examples Démo]",
	'maps_map' => 'Kaart',
	'maps-loading-map' => "D'Kaart gëtt gelueden…",
	'maps-markers' => 'Markéierungen',
	'maps-others' => 'anerer',
	'maps-layer-property' => 'Eegeschaft',
	'maps-layer-value' => 'Wäert',
	'maps-layer-errors' => 'Feeler',
	'validation-error-invalid-location' => 'Parameter $1 muss eng valabel Plaz sinn.',
	'validation-error-invalid-locations' => 'Parameter $1 muss eng oder méi valabel Plaze sinn.',
	'validation-error-invalid-width' => 'Parameter $1 muss eng valabel Breet sinn.',
	'validation-error-invalid-height' => 'Parameter $1 muss eng valabel Héicht sinn.',
	'validation-error-invalid-distance' => 'Parameter $1 muss eng valabel Distanz sinn.',
	'validation-error-invalid-distances' => 'Parameter $1 muss eng oder méi valabel Distanze sinn.',
	'validation-error-invalid-image' => 'Parameter $1 muss e valabelt Bild sinn.',
	'validation-error-invalid-images' => 'Parameter $1 muss eent oder méi valabel Biller sinn.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'O',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Breedegrad:',
	'maps-longitude' => 'Längtegrad:',
	'maps-invalid-coordinates' => 'De Wäert $1 gouf net als valabel Set vu Koordinaten erkannt.',
	'maps_coordinates_missing' => "Et goufe keng Koordinate fir d'Kaart uginn.",
	'maps_geocoding_failed' => 'Dës {{PLURAL:$2|Adress konnt|Adresse konnten}} net geocodéiert ginn: $1',
	'maps_geocoding_failed_for' => 'Dës {{PLURAL:$2|Adress|Adresse}} konnten net geocodéiert ginn an {{PLURAL:$2|huet|hu}} missen op der Kaart ewechgelooss ginn:
$1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|Dëse Koordinate gouf|Dës Koordinate goufen}} net erkannt: $1',
	'maps_unrecognized_coords_for' => 'Dës {{PLURAL:$2|Koordinate|Koordinate}} goufen net erkannt a vun der Kaart ignoréiert:
$1',
	'maps_map_cannot_be_displayed' => "D'Kaart kann net gewise ginn.",
	'maps-geocoder-not-available' => "D'Fonctioun vun der Geocodéierung vu Kaarten ass net disponibel. Äre Standuert konnt net geocodéiert ginn.",
	'maps_click_to_activate' => "Klickt fir d'kaart z'aktivéieren",
	'maps_centred_on' => "D'Kaart ass zentréiert op $1, $2",
	'maps_overlays' => 'Ablendungen',
	'maps_photos' => 'Fotoen',
	'maps_videos' => 'Videoen',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Web-Kameraen',
);

/** Lithuanian (Lietuvių)
 * @author Hugo.arg
 */
$messages['lt'] = array(
	'maps_desc' => 'Suteikia galimybę atvaizduoti koordinačių duomenis žemėlapiuose ir geografinio kodavimo adresus ([http://mapping.referata.com/wiki/Maps_examples demo]).
Katrografavimo paslaugos pasiekiamos: $1',
	'maps_map' => 'Žemėlapis',
	'maps-loading-map' => 'Kraunamas žemėlapis ...',
	'maps-abb-north' => 'Š',
	'maps-abb-east' => 'R',
	'maps-abb-south' => 'P',
	'maps-abb-west' => 'V',
	'maps-latitude' => 'Platuma:',
	'maps-longitude' => 'Ilguma:',
	'maps-invalid-coordinates' => 'Vertė $ 1 nepripažįstama kaip galiojanti koordinatė.',
	'maps_coordinates_missing' => 'Nesudarytos koordinatės žemėlapiui.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Šis adresas|Šie adresai}} negali būti kartografuoti: $1.',
	'maps_unrecognized_coords' => '{{PLURAL:$2|Ši koordinatė|Šios koordinatės}} nebuvo atpažintos: $1.',
	'maps_map_cannot_be_displayed' => 'Žemėlapis negal būti parodytas.',
	'maps_click_to_activate' => 'Spustelėkite, norėdami įjungti žemėlapį',
	'maps_centred_on' => 'Žemėlapis centruotas link $1, $2.',
	'maps_photos' => 'Nuotraukos',
	'maps_videos' => 'Vaizdo klipai',
	'maps_wikipedia' => 'Vikipedija',
	'maps_webcams' => 'Interneto kameros',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author McDutchie
 */
$messages['mk'] = array(
	'maps_desc' => 'Дава можност за приказ на координатни податоци во картите, и геокодирање на адреси ([http://mapping.referata.com/wiki/Maps_examples демо]).
Картографски служби на располагање: $1',
	'maps_map' => 'Карта',
	'maps-loading-map' => 'Ја вчитувам картата...',
	'maps-markers' => 'Обележувачи',
	'maps-others' => 'други',
	'maps-ns-layer' => 'Слој',
	'maps-ns-layer-talk' => 'Разговор за слој',
	'maps-layer-property' => 'Својство',
	'maps-layer-value' => 'Вредност',
	'maps-layer-errors' => 'Грешки',
	'maps-error-invalid-layerdef' => 'Ова определение за слојот е неважечко.',
	'maps-error-invalid-layertype' => 'Нема слоеви од типот „$1“. {{PLURAL:$3|Поддржан е само овој тип|Поддржани е само следниве типови}}: $2',
	'maps-error-no-layertype' => 'Ќе треба да наведете тип на слој. {{PLURAL:$2|Поддржан е само овој тип|Поддржани е само следниве типови}}: $1',
	'validation-error-invalid-layer' => 'Параметарот $1 мора да биде важечки слој.',
	'validation-error-invalid-layers' => 'Параметарот $1 мора да биде еден или повеќе важечки слоеви.',
	'maps-layer-of-type' => 'Слој од типот $1',
	'maps-layer-type-supported-by' => 'Овој тип на слој може да се користи {{PLURAL:$2|само со картографската служба $1|само со следниве картографски служби: $1}}.',
	'validation-error-invalid-location' => 'Параметарот $1 мора да претставува важечка местоположба.',
	'validation-error-invalid-locations' => 'Параметарот $1 мора да претставува една или повеќе важечки местоположби.',
	'validation-error-invalid-width' => 'Параметарот $1 мора да претставува важечка ширина.',
	'validation-error-invalid-height' => 'Параметарот $1 мора да претставува важечка висина.',
	'validation-error-invalid-distance' => 'Параметарот $1 мора да претставува важечко растојание.',
	'validation-error-invalid-distances' => 'Параметарот $1 мора да претставува едно или повеќе важечки растојанија.',
	'validation-error-invalid-image' => 'Параметарот $1 мора да биде важечка слика.',
	'validation-error-invalid-images' => 'Параметарот $1 мора да биде една или повеќе важечки слики.',
	'validation-error-invalid-goverlay' => 'Параметарот $1 мора да претставува важечка облога.',
	'validation-error-invalid-goverlays' => 'Параметарот $1 мора да претставува една или повеќе важечки облоги.',
	'maps-abb-north' => 'С',
	'maps-abb-east' => 'И',
	'maps-abb-south' => 'Ј',
	'maps-abb-west' => 'З',
	'maps-latitude' => 'Геог. ширина',
	'maps-longitude' => 'Геог. должина:',
	'maps-invalid-coordinates' => 'Вредноста $1 не беше препознаена како правилен збир координати.',
	'maps_coordinates_missing' => 'Нема координати за картата.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Следнава адреса не можеше да се геокодира|Следниве адреси не можеа да се геокодираат}}: $1.
Картата не може да се прикаже.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Следнава адреса не можеше да се геокодира|Следниве адреси не можеа да се геокодираат}} и затоа {{PLURAL:$2|беше изоставена|беа изоставени}} од картата:
$1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|Следнава координата не е препознаена|Следниве координати не се препознаени}}: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Следнава координата не беше препознаена|Следниве координати не беа препознаени}} и {{PLURAL:$2|беше изоставена|беа изоставени}} од картата:
$1',
	'maps_map_cannot_be_displayed' => 'Картата не може да се прикаже.',
	'maps-geocoder-not-available' => 'Функцијата за геокодирање на Карти е недостапна. Вашата местоположба не може да се геокодира.',
	'maps_click_to_activate' => 'Кликнете за активирање на картата',
	'maps_centred_on' => 'Средиште на картата во $1, $2.',
	'maps_overlays' => 'Слоеви',
	'maps_photos' => 'Фотографии',
	'maps_videos' => 'Видеа',
	'maps_wikipedia' => 'Википедија',
	'maps_webcams' => 'Мреж. камери',
);

/** Malayalam (മലയാളം) */
$messages['ml'] = array(
	'maps-abb-north' => 'വടക്ക്',
	'maps-abb-east' => 'കിഴക്ക്',
	'maps-abb-south' => 'തെക്ക്',
	'maps-abb-west' => 'പടിഞ്ഞാറ്‌',
	'maps-latitude' => 'അക്ഷാംശം:',
	'maps-longitude' => 'രേഖാംശം:',
);

/** Marathi (मराठी) */
$messages['mr'] = array(
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'अक्षांश:',
	'maps-longitude' => 'रेखांश:',
);

/** Erzya (Эрзянь) */
$messages['myv'] = array(
	'maps-abb-north' => 'Веньэльйонкс',
	'maps-abb-east' => 'Чилисемайонкс',
	'maps-abb-south' => 'Чиньэльйонкс',
	'maps-abb-west' => 'Чивалгомайонкс',
	'maps-latitude' => 'Келезэ:',
	'maps-longitude' => 'Кувалмозо:',
);

/** Nahuatl (Nāhuatl) */
$messages['nah'] = array(
	'maps-abb-north' => 'M',
	'maps-abb-east' => 'T',
	'maps-abb-south' => 'H',
);

/** Dutch (Nederlands)
 * @author Kjell
 * @author Siebrand
 */
$messages['nl'] = array(
	'maps_desc' => 'Biedt de mogelijkheid om locatiegegevens weer te geven op kaarten en adressen om te zetten naar coordinaten ([http://wiki.bn2vs.com/wiki/Semantic_Maps demo]).
Beschikbare kaartdiensten: $1',
	'maps_map' => 'Kaart',
	'maps-loading-map' => 'Bezig met het laden van de kaart...',
	'maps-markers' => 'Markeringen',
	'maps-others' => 'anderen',
	'maps-ns-layer' => 'Laag',
	'maps-ns-layer-talk' => 'Overleg_laag',
	'maps-layer-property' => 'Eigenschap',
	'maps-layer-value' => 'Waarde',
	'maps-layer-errors' => 'Fouten',
	'maps-error-invalid-layerdef' => 'Deze laagdefinitie is niet geldig.',
	'maps-error-invalid-layertype' => 'Er zijn geen lagen van het type "$1". Alleen {{PLURAL:$3|dit type wordt|deze typen worden}} ondersteund: $2',
	'maps-error-no-layertype' => 'U moet het laagtype opgeven. Alleen {{PLURAL:$2|dit type wordt|deze typen worden}} ondersteund: $1',
	'validation-error-invalid-layer' => 'Parameter $1 moet een geldige laag zijn.',
	'validation-error-invalid-layers' => 'Parameter $1 moet een of meer geldige lagen zijn.',
	'maps-layer-of-type' => 'Laag van het type $1',
	'maps-layer-type-supported-by' => 'Dit laagtype kan {{PLURAL:$2|alleen gebruikt worden met de kaartdienst $1|gebruikt worden met de kaartdiensten $1}}.',
	'validation-error-invalid-location' => 'Parameter $1 moet een geldige locatie zijn.',
	'validation-error-invalid-locations' => 'Parameter $1 moet een of meer geldige locaties zijn.',
	'validation-error-invalid-width' => 'Parameter $1 moet een geldige breedte zijn.',
	'validation-error-invalid-height' => 'Parameter $1 moet een geldige hoogte zijn.',
	'validation-error-invalid-distance' => 'Parameter $1 moet een geldige afstand zijn.',
	'validation-error-invalid-distances' => 'Parameter $1 moet een of meer geldige afstanden zijn.',
	'validation-error-invalid-image' => 'Parameter $1 moet een geldige afbeelding zijn.',
	'validation-error-invalid-images' => 'Parameter $1 moet een of meer geldige afbeeldingen zijn.',
	'validation-error-invalid-goverlay' => 'Parameter $1 moet een geldige overlay zijn.',
	'validation-error-invalid-goverlays' => 'Parameter $1 moet een of meer geldige overlays zijn.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'O',
	'maps-abb-south' => 'Z',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Breedte:',
	'maps-longitude' => 'Lengte:',
	'maps-invalid-coordinates' => 'De waarde "$1" is niet herkend als geldige coördinaten.',
	'maps_coordinates_missing' => 'Er zijn geen coördinaten opgegeven voor de kaart.',
	'maps_geocoding_failed' => 'Voor {{PLURAL:$2|het volgende adres|de volgende adressen}} was geocodering niet mogelijk: $1
De kaart kan niet worden weergegeven.',
	'maps_geocoding_failed_for' => 'Voor {{PLURAL:$2|het volgende adres|de volgende adressen}} was geocodering niet mogelijk en {{PLURAL:$2|dit is|deze zijn}} weggelaten uit de kaart:
$1',
	'maps_unrecognized_coords' => 'De volgende {{PLURAL:$2|coördinaat is|coördinaten zijn}} niet herkend: $1.',
	'maps_unrecognized_coords_for' => 'De volgende {{PLURAL:$2|coördinaat is niet herkend en is|coördinaten zijn niet herkend en zijn}} weggelaten uit de kaart:
$1.',
	'maps_map_cannot_be_displayed' => 'De kaart kan niet weergegeven worden.',
	'maps-geocoder-not-available' => 'Geocoderen via Maps is niet beschikbaar. Het geocoderen van uw locatie is niet mogelijk.',
	'maps_googlemaps2' => 'Google Maps v2',
	'maps_yahoomaps' => 'Yahoo! Maps',
	'maps_openlayers' => 'OpenLayers',
	'maps_click_to_activate' => 'Klik om de kaart te activeren',
	'maps_centred_on' => 'Kaart gecentreerd op $1, $2.',
	'maps_overlays' => "Overlay's",
	'maps_photos' => "Foto's",
	'maps_videos' => "Video's",
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcams',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'maps_map' => 'Kart',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'A',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'V',
	'maps-latitude' => 'Breiddegrad:',
	'maps-longitude' => 'Lengdegrad:',
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
	'maps_desc' => 'Gir mulighet for å vise koordinatdata i kart og geokodeadresser ([http://mapping.referata.com/wiki/Maps_examples demo]).
Tilgjengelige karttjenester: $1',
	'maps_map' => 'Kart',
	'maps-loading-map' => 'Laster kart...',
	'maps-markers' => 'Markører',
	'maps-others' => 'andre',
	'maps-ns-layer' => 'Lag',
	'maps-ns-layer-talk' => 'Lagdiskusjon',
	'maps-layer-property' => 'Egenskap',
	'maps-layer-value' => 'Verdi',
	'maps-layer-errors' => 'Feil',
	'maps-error-invalid-layerdef' => 'Denne lagdefinisjonen er ikke gyldig.',
	'maps-error-invalid-layertype' => 'Det er ingen lag av typen «$1». Bare {{PLURAL:$3|denne typen|disse typene}} er støttet: $2',
	'maps-error-no-layertype' => 'Du må angi en lagtype. Bare {{PLURAL:$2|denne typen|disse typene}} er støttet: $1',
	'validation-error-invalid-layer' => 'Parameter $1 må været et gyldig lag.',
	'validation-error-invalid-layers' => 'Parameter $1 må være et eller flere gyldige lag.',
	'maps-layer-of-type' => 'Lagtype $1',
	'maps-layer-type-supported-by' => 'Denne lagtypen kan bare brukes med {{PLURAL:$2|karttjenesten $1|disse karttjenestene: $1}}.',
	'validation-error-invalid-location' => 'Parameter $1 må være en gyldig lokasjon.',
	'validation-error-invalid-locations' => 'Parameter $1 må være en eller flere gyldige lokasjoner.',
	'validation-error-invalid-width' => 'Parameter $1 må være en gyldig bredde.',
	'validation-error-invalid-height' => 'Parameter $1 må være en gyldig høyde.',
	'validation-error-invalid-distance' => 'Parameter $1 må være en gyldig avstand.',
	'validation-error-invalid-distances' => 'Parameter $1 må være en eller flere gyldige avstander.',
	'validation-error-invalid-image' => 'Parameter $1 må være et gyldig bilde.',
	'validation-error-invalid-images' => 'Parameter $1 må være et eller flere gyldige bilder.',
	'validation-error-invalid-goverlay' => 'Parameter $1 må være et gyldig overlegg.',
	'validation-error-invalid-goverlays' => 'Parameter $1 må være et eller flere gyldige overlegg.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'Ø',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'V',
	'maps-latitude' => 'Breddegrad:',
	'maps-longitude' => 'Lengdegrad:',
	'maps-invalid-coordinates' => 'Verdien $1 ble ikke gjenkjent som et gyldig sett med koordinater.',
	'maps_coordinates_missing' => 'Ingen koordinater oppgitt for kartet.',
	'maps_geocoding_failed' => 'Følgende {{PLURAL:$2|adresse|adresser}} kunne ikke geokodes: $1.',
	'maps_geocoding_failed_for' => 'Følgende {{PLURAL:$2|adresse|adresser}} kunne ikke geokodes og har blitt utelatt fra kartet:
$1',
	'maps_unrecognized_coords' => 'Følgende {{PLURAL:$2|koordinat|koordinat}} ble ikke gjenkjent: $1.',
	'maps_unrecognized_coords_for' => 'Følgende {{PLURAL:$2|koordinat|koordinater}} ble ikke gjenkjent og har blitt utelatt fra kartet:
$1',
	'maps_map_cannot_be_displayed' => 'Kartet kan ikke vises.',
	'maps-geocoder-not-available' => 'Geokodingsfunksjonen i Maps er ikke tilgjengelig. Din plassering kan ikke geokodes.',
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
([http://www.mediawiki.org/wiki/Extension:Maps documentacion], [http://mapping.referata.com/wiki/Maps_examples demonstracion]). 
Servicis de cartografia disponibles : $1",
	'maps_map' => 'Mapa',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'O',
	'maps-latitude' => 'Latitud :',
	'maps-longitude' => 'Longitud :',
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

/** Deitsch (Deitsch) */
$messages['pdc'] = array(
	'maps-abb-north' => 'N',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Yarl
 */
$messages['pl'] = array(
	'maps_desc' => 'Umożliwia wyświetlanie na mapach współrzędnych oraz adresów geograficznych ([http://mapping.referata.com/wiki/Maps_examples demo]).
Dostępne serwisy mapowe: $1',
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'Wczytywanie mapy…',
	'maps-markers' => 'Zaznaczenia',
	'maps-others' => 'inne',
	'maps-ns-layer' => 'Warstwa',
	'maps-ns-layer-talk' => 'Dyskusja warstwy',
	'maps-layer-property' => 'Własność',
	'maps-layer-value' => 'Wartość',
	'maps-layer-errors' => 'Błędy',
	'maps-error-invalid-layerdef' => 'Definicja tej warstwy jest nieprawidłowa.',
	'maps-error-invalid-layertype' => 'Brak warstw typu „$1”. {{PLURAL:$3|Wspierany jest wyłącznie typ|Wspierane są wyłącznie typy:}} $2',
	'maps-error-no-layertype' => 'Musisz określić typ warstwy. {{PLURAL:$2|Wspierany jest wyłącznie typ|Wspierane są wyłącznie typy:}} $1',
	'validation-error-invalid-layer' => 'Parametr $1 musi określać prawidłową warstwę.',
	'validation-error-invalid-layers' => 'Parametr $1 musi wskazywać jedną lub więcej prawidłowych warstw.',
	'maps-layer-of-type' => 'Warstwa typu $1',
	'maps-layer-type-supported-by' => 'Tego typu warstwa może być używana wyłącznie z {{PLURAL:$2|serwisem map|serwisami map:}} $1.',
	'validation-error-invalid-location' => 'Parametr $1 musi wskazywać prawidłową lokalizację.',
	'validation-error-invalid-locations' => 'Parametr $1 musi wskazywać jedną lub więcej prawidłowych lokalizacji.',
	'validation-error-invalid-width' => 'Parametr $1 musi określać prawidłową szerokość.',
	'validation-error-invalid-height' => 'Parametr $1 musi określać prawidłową wysokość.',
	'validation-error-invalid-distance' => 'Parametr $1 musi określać prawidłową odległość.',
	'validation-error-invalid-distances' => 'Parametr $1 musi określać jedną lub więcej prawidłowych odległości.',
	'validation-error-invalid-image' => 'Parametr $1 musi określać prawidłową grafikę.',
	'validation-error-invalid-images' => 'Parametr $1 musi wskazywać jedną lub więcej prawidłowych grafik.',
	'validation-error-invalid-goverlay' => 'Parametr $1 musi być prawidłową nakładką.',
	'validation-error-invalid-goverlays' => 'Parametr $1 musi być jedną lub więcej prawidłową nakładką.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Szerokość geograficzna',
	'maps-longitude' => 'Długość geograficzna',
	'maps-invalid-coordinates' => 'Wartość $1 nie została rozpoznana jako prawidłowe współrzędne.',
	'maps_coordinates_missing' => 'Brak współrzędnych dla mapy.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Następującego adresu nie można odnaleźć na mapie|Następujących adresów nie można odnaleźć na mapie:}} $1.
Mapa nie może zostać wyświetlona.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Następujący adres został pominięty, ponieważ nie można go odnaleźć na mapie|Następujące adresy zostały pominięte, ponieważ nie można ich odnaleźć na mapie:}} $1.',
	'maps_unrecognized_coords' => '{{PLURAL:$2|Następująca współrzędna nie została rozpoznana –|Następujące współrzędne nie zostały rozpoznane:}} $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Następującą współrzędną|Następujące współrzędne}} pominięto, ponieważ nie {{PLURAL:$2|została rozpoznana|zostały rozpoznane}}:
$1',
	'maps_map_cannot_be_displayed' => 'Mapa nie może zostać wyświetlona.',
	'maps-geocoder-not-available' => 'Funkcja geokodowania map nie jest dostępna. Lokalizacja nie może zostać zakodowana.',
	'maps_click_to_activate' => 'Kliknij, aby aktywować mapę',
	'maps_centred_on' => 'Środek mapy – $1, $2.',
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
	'maps_desc' => "A dà la possibilità ëd visualisé le coordinà ant le mape, e j'adrësse geocode ([http://mapping.referata.com/wiki/Maps_examples demo]). Sërvissi ëd mapatura disponìbil: $1",
	'maps_map' => 'Pian',
	'maps-loading-map' => 'Cariament ëd la carta...',
	'maps-markers' => 'Marcador',
	'maps-others' => 'àutri',
	'maps-ns-layer' => 'Livel',
	'maps-ns-layer-talk' => 'Ciaciarada ëd livel',
	'maps-layer-property' => 'Propietà',
	'maps-layer-value' => 'Valor',
	'maps-layer-errors' => 'Eror',
	'maps-error-invalid-layerdef' => "Sta definission ëd livel a l'é pa bon-a",
	'maps-error-invalid-layertype' => 'A-i é pa gnun livej ëd sòrt "$1". A {{PLURAL:$3|l\'é|sn}} mach apogià sta sòrt: $2',
	'maps-error-no-layertype' => "It deuve specifiché la sòrt ëd livel. Mach {{PLURAL:$2|sta sòrt a l'é|ste sòrt a son}} apogià: $1",
	'validation-error-invalid-layer' => 'Ël paràmetr $1 a dev esse un livel bon.',
	'validation-error-invalid-layers' => 'Ël paràmetr $1 a dev esse un o pi livej bon.',
	'maps-layer-of-type' => 'Livel ëd sòrt $1',
	'maps-layer-type-supported-by' => 'Sta sòrt ëd livel a peul {{PLURAL:$2|mach esse dovrà con ël servissi ëd mapping $1|esse dovrà con sti servissi ëd mapping: $1}}.',
	'validation-error-invalid-location' => 'Ël paràmetr $1 a dev esse na locassion bon-a.',
	'validation-error-invalid-locations' => 'Ël paràmetr $1 a dev esse un-a o pi locassion bon-e.',
	'validation-error-invalid-width' => 'Ël paràmetr $1 a dev esse na larghëssa bon-a.',
	'validation-error-invalid-height' => "Ël paràmetr $1 a dev esse n'autëssa bon-a.",
	'validation-error-invalid-distance' => 'Ël valor $1 a deuv esse na distansa bon-a.',
	'validation-error-invalid-distances' => 'Ël paràmetr $1 a dev esse un-a o pi distanse bon-e.',
	'validation-error-invalid-image' => 'Ël paràmetr $1 a dev esse na figura bon-a.',
	'validation-error-invalid-images' => 'Ël paràmetr $1 a dev esse un-a o pi figure bon-e.',
	'validation-error-invalid-goverlay' => 'Ël paràmetr $1 a dev esse un coatament bon.',
	'validation-error-invalid-goverlays' => 'Ël paràmetr $1 a dev esse un o pi coatament bon.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Latitùdin:',
	'maps-longitude' => 'Longitùdin:',
	'maps-invalid-coordinates' => "Ël valor $1 a l'é pa stàit arconossù con n'ansema bon ëd coordinà.",
	'maps_coordinates_missing' => 'Pa gnun-e coordinà dàite për la mapa.',
	'maps_geocoding_failed' => "{{PLURAL:$2|L'adrëssa|J'adrësse}} sì sota a peulo pa esse sota geocode: $1.
La mapa a peul pa esse visualisà.",
	'maps_geocoding_failed_for' => "{{PLURAL:$2|L'adrëssa|J'adrësse}} sì sota a peula pa esse sota geocode e a {{PLURAL:$2|l'é pa stàita|son pa stàite}}  butà ant la mapa: $1",
	'maps_unrecognized_coords' => "{{PLURAL:$2|La coordinà sota a l'é pa stàita arconossùa|Le coordinà sota a son pa stàite arconossùe}}: $1.",
	'maps_unrecognized_coords_for' => "{{PLURAL:$2|La coordinatà sota a l'é pa stàita arconossùa|Le coordinà sota a son pa stàite arconossùe}}  e a {{PLURAL:$2|l'é stàita|a son stàite}} pa butà ant la carta: 
$1",
	'maps_map_cannot_be_displayed' => 'La carta a peul pa esse mostrà.',
	'maps-geocoder-not-available' => "La possibilità ëd geocodìfica dle carte a l'é pa disponìbil. Soa locassion a peul pa esse geocodificà.",
	'maps_click_to_activate' => 'Sgnaca për ativé la carta',
	'maps_centred_on' => 'Carta sentrà su $1, $2.',
	'maps_overlays' => 'Sovraposission',
	'maps_photos' => 'Fòto',
	'maps_videos' => 'Filmà',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcam',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'maps_map' => 'نخشه',
	'maps-abb-north' => 'سهـ',
	'maps-abb-east' => 'خ',
	'maps-abb-south' => 'سو',
	'maps-abb-west' => 'ل',
	'maps_photos' => 'انځورونه',
	'maps_videos' => 'ويډيوګانې',
	'maps_wikipedia' => 'ويکيپېډيا',
	'maps_webcams' => 'وېبکامرې',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Waldir
 */
$messages['pt'] = array(
	'maps_desc' => 'Permite apresentar dados de coordenadas em mapas e endereços por geocódigo ([http://mapping.referata.com/wiki/Maps_examples demonstração]).
Serviços de cartografia disponíveis: $1',
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'A carregar o mapa...',
	'maps-markers' => 'Marcadores',
	'maps-others' => 'outros',
	'maps-ns-layer' => 'Camada',
	'maps-ns-layer-talk' => 'Camada Discussão',
	'maps-layer-property' => 'Propriedade',
	'maps-layer-value' => 'Valor',
	'maps-layer-errors' => 'Erros',
	'maps-error-invalid-layerdef' => 'A definição desta camada não é válida.',
	'maps-error-invalid-layertype' => 'Não existem camadas do tipo "$1". Só {{PLURAL:$3|é suportado o tipo|são suportados os tipos}}: $2',
	'maps-error-no-layertype' => 'Tem de especificar o tipo da camada. Só {{PLURAL:$2|é suportado o tipo|são suportados os tipos}}: $1',
	'validation-error-invalid-layer' => 'O parâmetro $1 tem de ser uma camada válida.',
	'validation-error-invalid-layers' => 'O parâmetro $1 tem de ser uma ou mais camadas válidas.',
	'maps-layer-of-type' => 'Camada de tipo $1',
	'maps-layer-type-supported-by' => 'Este tipo de camada só pode ser usado com {{PLURAL:$2|o serviço de cartografia $1|os serviços de cartografia: $1}}.',
	'validation-error-invalid-location' => 'O parâmetro $1 tem de ser uma localização válida.',
	'validation-error-invalid-locations' => 'O parâmetro $1 tem de ser uma ou mais localizações válidas.',
	'validation-error-invalid-width' => 'O parâmetro $1 tem de ser uma largura válida.',
	'validation-error-invalid-height' => 'O parâmetro $1 tem de ser uma altura válida.',
	'validation-error-invalid-distance' => 'O parâmetro $1 tem de ser uma distância válida.',
	'validation-error-invalid-distances' => 'O parâmetro $1 tem de ser uma ou mais distâncias válidas.',
	'validation-error-invalid-image' => 'O parâmetro $1 tem de ser uma imagem válida.',
	'validation-error-invalid-images' => 'O parâmetro $1 tem de ser uma ou mais imagens válidas.',
	'validation-error-invalid-goverlay' => 'O parâmetro $1 tem de ser uma sobreposição válida.',
	'validation-error-invalid-goverlays' => 'O parâmetro $1 tem de ser uma ou mais sobreposições válidas.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'O',
	'maps-latitude' => 'Latitude:',
	'maps-longitude' => 'Longitude:',
	'maps-invalid-coordinates' => 'O valor $1 não foi reconhecido como um conjunto de coordenadas válido.',
	'maps_coordinates_missing' => 'Não foram fornecidas coordenadas para o mapa.',
	'maps_geocoding_failed' => 'Não foi possível geocodificar {{PLURAL:$2|o seguinte endereço|os seguintes endereços}}: $1.
O mapa não pode ser apresentado.',
	'maps_geocoding_failed_for' => 'Não foi possível geocodificar {{PLURAL:$2|o seguinte endereço, que foi omitido|os seguintes endereços, que foram omitidos}} do mapa:
$1.',
	'maps_unrecognized_coords' => '{{PLURAL:$2|A seguinte coordenada não foi reconhecida|As seguintes coordenadas não foram reconhecidas}}: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|A seguinte coordenada não foi reconhecida e foi omitida|As seguintes coordenadas não foram reconhecidas e foram omitidas}} do mapa:
$1',
	'maps_map_cannot_be_displayed' => 'Não é possível apresentar o mapa.',
	'maps-geocoder-not-available' => 'A funcionalidade de georeferenciação do Mapas está indisponível; a sua localização não pode ser georeferenciada.',
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
 * @author Giro720
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'maps_desc' => 'Provê a possibilidade de exibir dados de coordenadas em mapas e endereços em geocódigo. ([http://mapping.referata.com/wiki/Maps_examples demonstração]).
Serviços de mapeamento disponíveis: $1',
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'Carregando mapa...',
	'maps-markers' => 'Marcadores',
	'maps-others' => 'outros',
	'maps-ns-layer' => 'Camada',
	'maps-ns-layer-talk' => 'Camada Discussão',
	'maps-layer-property' => 'Propriedade',
	'maps-layer-value' => 'Valor',
	'maps-layer-errors' => 'Erros',
	'maps-error-invalid-layerdef' => 'A definição desta camada não é válida.',
	'maps-error-invalid-layertype' => 'Não existem camadas do tipo "$1". Só {{PLURAL:$3|é suportado o tipo|são suportados os tipos}}: $2',
	'maps-error-no-layertype' => 'Você precisa especificar o tipo da camada. {{PLURAL:$2|Só é suportado o tipo|São suportados os tipos}}: $1',
	'validation-error-invalid-layer' => 'O parâmetro $1 deve ser uma camada válida.',
	'validation-error-invalid-layers' => 'O parâmetro $1 deve ser uma ou mais camadas válidas.',
	'maps-layer-of-type' => 'Camada de tipo $1',
	'maps-layer-type-supported-by' => 'Este tipo de camada só pode ser usado com {{PLURAL:$2|o serviço de cartografia $1|os serviços de cartografia: $1}}.',
	'validation-error-invalid-location' => 'O parâmetro $1 deve ser uma localização válida.',
	'validation-error-invalid-locations' => 'O parâmetro $1 deve ser uma localização válida.',
	'validation-error-invalid-width' => 'O parâmetro $1 deve ser uma largura válida.',
	'validation-error-invalid-height' => 'O parâmetro $1 deve ser uma altura válida.',
	'validation-error-invalid-distance' => 'O parâmetro $1 deve ser uma distância válida.',
	'validation-error-invalid-distances' => 'O parâmetro $1 deve ser uma ou mais distâncias válidas.',
	'validation-error-invalid-image' => 'O parâmetro $1 deve ser uma imagem válida.',
	'validation-error-invalid-images' => 'O parâmetro $1 deve ser uma ou mais imagens válidas.',
	'validation-error-invalid-goverlay' => 'O parâmetro $1 deve ser uma sobreposição válida.',
	'validation-error-invalid-goverlays' => 'O parâmetro $1 deve ser uma ou mais sobreposições válidas.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'L',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'O',
	'maps-latitude' => 'Latitude:',
	'maps-longitude' => 'Longitude:',
	'maps-invalid-coordinates' => 'O valor $1 não foi reconhecido como um conjunto de coordenadas válido.',
	'maps_coordinates_missing' => 'Nenhuma coordenada fornecida para o mapa',
	'maps_geocoding_failed' => '{{PLURAL:$2|O seguinte endereço não pode|Os seguintes endereços não puderam}} ser {{PLURAL:$2|geocodificado|geocodificados}}: $1.
O mapa não pode ser exibido.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|O seguinte endereço não pode|Os seguintes endereços não puderam}} ser {{PLURAL:$2|geocodificado e foi omitido|geocodificados e foram omitidos}} do mapa:
$1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|A seguinte coordenada não foi reconhecida|As seguintes coordenadas não foram reconhecidas}}: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|A seguinte coordenada não foi reconhecida e foi omitida|As seguintes coordenadas não foram reconhecidas e foram omitidas}} do mapa:
$1',
	'maps_map_cannot_be_displayed' => 'O mapa não pode ser mostrado.',
	'maps-geocoder-not-available' => 'A funcionalidade de georeferenciação do Mapas está indisponível; a sua localização não pode ser georeferenciada.',
	'maps_click_to_activate' => 'Clique para ativar o mapa',
	'maps_centred_on' => 'Mapa centrado nas coordenadas $1, $2.',
	'maps_overlays' => 'Sobreposições',
	'maps_photos' => 'Fotos',
	'maps_videos' => 'Vídeos',
	'maps_wikipedia' => 'Wikipédia',
	'maps_webcams' => 'Webcams',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'maps_desc' => 'Asigură capacitatea de a afișa coordonate pe hărți și adrese geocode ([http://mapping.referata.com/wiki/Maps_examples demonstrație]).
Servici de cartografiere disponibile: $1',
	'maps_map' => 'Hartă',
	'maps-loading-map' => 'Se încarcă harta...',
	'maps-markers' => 'Marcatori',
	'validation-error-invalid-layer' => 'Parametrul $1 trebuie să fie un strat valabil.',
	'validation-error-invalid-layers' => 'Parametrul $1 trebuie să fie una sau mai multe straturi valide.',
	'validation-error-invalid-location' => 'Parametrul $1 trebuie să fie o locaţie validă.',
	'validation-error-invalid-locations' => 'Parametrul $1 trebuie să fie una sau mai multe locaţii valide.',
	'validation-error-invalid-distance' => 'Valoarea $1 nu reprezintă o distanță validă.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'V',
	'maps-latitude' => 'Latitudine:',
	'maps-longitude' => 'Longitudine:',
	'maps-invalid-coordinates' => 'Valoarea $1 nu a fost recunoscută ca un set valid de coordonate.',
	'maps_coordinates_missing' => 'Nu au fost furnizate coordonate pentru hartă.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Următoarea|Următoarele}} {{PLURAL:$2|adresă|adrese}} nu {{PLURAL:$2|a|au}} putut fi {{PLURAL:$2|geocodificată|geocodificate}}: $1.
Harta nu poate fi afișată.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Următoarea|Următoarele}} {{PLURAL:$2|adresă|adrese}} nu {{PLURAL:$2|a|au}} putut fi {{PLURAL:$2|geocodificată|geocodificate}} și {{PLURAL:$2|a|au}} fost {{PLURAL:$2|omisă|omise}} de pe hartă:
$1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|Următorul|Următoarele}} {{PLURAL:$2|set|seturi}} de coordonate nu {{PLURAL:$2|a|au}} putut fi {{PLURAL:$2|recunoscut|recunoscute}}: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Următorul|Următoarele}} {{PLURAL:$2|set|seturi}} de coordonate nu {{PLURAL:$2|a|au}} putut fi {{PLURAL:$2|recunoscut|recunoscute}} și {{PLURAL:$2|a|au}} fost {{PLURAL:$2|omis|omise}}: $1',
	'maps_map_cannot_be_displayed' => 'Harta nu poate fi afișată.',
	'maps-geocoder-not-available' => 'Opțiunea de geocodare pentru Hărți nu este disponibilă. Locația dumneavoastră nu a putut fi geocodată.',
	'maps_click_to_activate' => 'Apăsați pentru a activa harta',
	'maps_centred_on' => 'Hartă centrată la $1, $2.',
	'maps_overlays' => 'Straturi',
	'maps_photos' => 'Fotografii',
	'maps_videos' => 'Filme',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Camere web',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'maps_desc' => "Dè l'abbilità a fà vedè le coordinate jndr'à le mappe e le indirizze geocodificate ([http://mapping.referata.com/wiki/Maps_examples demo]). Disponibbile le servizie de mappe: $1",
);

/** Russian (Русский)
 * @author Lockal
 * @author MaxSem
 * @author McDutchie
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'maps_desc' => 'Обеспечивает возможность отображения координатных данных на картах и геокодирование адресов ([http://mapping.referata.com/wiki/Maps_examples демонстрация]).
Доступные картографические службы: $1',
	'maps_map' => 'Карта',
	'maps-loading-map' => 'Идёт загрузка карты…',
	'maps-markers' => 'Отметки',
	'maps-others' => 'другие',
	'maps-ns-layer' => 'Слой',
	'maps-ns-layer-talk' => 'Обсуждение слоя',
	'maps-layer-property' => 'Свойство',
	'maps-layer-value' => 'Значение',
	'maps-layer-errors' => 'Ошибки',
	'maps-error-invalid-layerdef' => 'Это определение слоя неверно.',
	'maps-error-invalid-layertype' => 'Не существует слоя типа «$1». {{PLURAL:$3|Поддерживается только следующий тип|Поддерживаются только следующие типы}}: $2',
	'maps-error-no-layertype' => 'Вам нужно указать тип слоя. {{PLURAL:$2|Поддерживается только следующий тип|Поддерживаются следующие типы}}: $1',
	'validation-error-invalid-layer' => 'Параметр $1 должен быть корректным слоем.',
	'validation-error-invalid-layers' => 'Параметр $1 должен содержать один или несколько корректных слоёв.',
	'maps-layer-of-type' => 'Слой типа $1',
	'maps-layer-type-supported-by' => 'Этот тип слоя может быть использован {{PLURAL:$2|только с картографической службой $1|только со следующими картографическими службами}}: $1',
	'validation-error-invalid-location' => 'Параметр $1 должен быть корректным местоположением.',
	'validation-error-invalid-locations' => 'Параметр $1 должен содержать одно или несколько корректных местоположений.',
	'validation-error-invalid-width' => 'Параметр $1 должен быть корректной шириной.',
	'validation-error-invalid-height' => 'Параметр $1 должен быть корректной высотой.',
	'validation-error-invalid-distance' => 'Параметр $1 должен быть корректным расстоянием.',
	'validation-error-invalid-distances' => 'Параметр $1 должен содержать одно или несколько корректных расстояний.',
	'validation-error-invalid-image' => 'Параметр $1 должен быть корректным изображением.',
	'validation-error-invalid-images' => 'Параметр $1 должен содержать одно или несколько корректных изображений.',
	'validation-error-invalid-goverlay' => 'Параметр $1 должен быть корректным наложением.',
	'validation-error-invalid-goverlays' => 'Параметр $1 должен содержать одно или несколько корректных наложений.',
	'maps-abb-north' => 'С',
	'maps-abb-east' => 'В',
	'maps-abb-south' => 'Ю',
	'maps-abb-west' => 'З',
	'maps-latitude' => 'Широта:',
	'maps-longitude' => 'Долгота:',
	'maps-invalid-coordinates' => 'Значение $1 не признано допустимым набором координат.',
	'maps_coordinates_missing' => 'Не указаны координаты для карты.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Следующий адрес не может быть геокодирован|Следующие адреса не могут быть геокодированы}}: $1.
Карта не может быть отображена.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Следующий адрес не может быть геокодирован и был удалён|Следующие адреса не могут быть геокодированы и были удалены}} с карты:
$1',
	'maps_unrecognized_coords' => 'Следующие {{PLURAL:$2|координаты|координаты}} не были опознаны: $1.',
	'maps_unrecognized_coords_for' => 'Следующие координаты не были опознаны, {{PLURAL:$2|они|они}} не показаны на карте:
$1',
	'maps_map_cannot_be_displayed' => 'Карта не может быть показана.',
	'maps-geocoder-not-available' => 'Функция геокодирования карт недоступна, ваше местоположение не может быть геокодировано.',
	'maps_click_to_activate' => 'Нажмите для активации карты',
	'maps_centred_on' => 'Центр карты — $1, $2.',
	'maps_overlays' => 'Слои',
	'maps_photos' => 'Фото',
	'maps_videos' => 'Видео',
	'maps_wikipedia' => 'Википедия',
	'maps_webcams' => 'Веб-камеры',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'maps_map' => 'Мапа',
	'maps-loading-map' => 'Награваня мапы. . .',
	'maps-abb-north' => 'С',
	'maps-abb-east' => 'В',
	'maps-abb-south' => 'Ю',
	'maps-abb-west' => 'З',
);

/** Sinhala (සිංහල)
 * @author තඹරු විජේසේකර
 */
$messages['si'] = array(
	'maps-loading-map' => 'සිතියම පුරණය වෙමින් පවතී...',
	'maps-abb-north' => 'උ',
	'maps-abb-east' => 'නැ',
	'maps-abb-south' => 'ද',
	'maps-abb-west' => 'බ',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'maps_desc' => 'Poskytuje možnosť zobrazovať údaje súradníc na mapách a tvoriť geografické adresy lokalít ([http://wiki.bn2vs.com/wiki/Semantic_Maps demo]).
Dostupné mapovacie služby: $1',
	'maps_map' => 'Mapa',
	'maps-abb-north' => 'S',
	'maps-abb-east' => 'V',
	'maps-abb-south' => 'J',
	'maps-abb-west' => 'Z',
	'maps-latitude' => 'Zem. dĺžka:',
	'maps-longitude' => 'Zem. šírka:',
	'maps_coordinates_missing' => 'Neboli poskytnuté žiadne súradnice.',
	'maps_geocoding_failed' => 'Nebolo možné určiť súradnice {{PLURAL:$2|nasledovnej adresy|nasledovných adries}}: $1.',
	'maps_geocoding_failed_for' => 'Nebolo možné určiť súradnice {{PLURAL:$2|nasledovnej adresy|nasledovných adries}} a {{PLURAL:$2|bola vynechaná|boli vynechané}} z mapy: $1.',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'maps_map' => 'Мапа',
	'maps-loading-map' => 'Учитавање мапе...',
	'maps-abb-north' => 'С',
	'maps-abb-east' => 'И',
	'maps-abb-south' => 'Ј',
	'maps-abb-west' => 'З',
	'maps-latitude' => 'Географска ширина:',
	'maps-longitude' => 'Географска дужина:',
	'maps_photos' => 'Фотографије',
	'maps_videos' => 'Видео снимци',
	'maps_webcams' => 'Веб-камере',
);

/** Serbian Latin ekavian (Srpski (latinica)) */
$messages['sr-el'] = array(
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'Učitavanje mape...',
	'maps-abb-north' => 'S',
	'maps-abb-east' => 'I',
	'maps-abb-south' => 'J',
	'maps-abb-west' => 'Z',
	'maps-latitude' => 'Geografska širina:',
	'maps-longitude' => 'Geografska dužina:',
	'maps_photos' => 'Fotografije',
	'maps_videos' => 'Video snimci',
	'maps_webcams' => 'Veb-kamere',
);

/** Swedish (Svenska)
 * @author Ainali
 * @author Dafer45
 * @author Fluff
 * @author Per
 */
$messages['sv'] = array(
	'maps_desc' => 'Ger möjlighet till att visa koordinater på kartor och geokodade adresser ([http://mapping.referata.com/wiki/Maps_examples demo]).
Tillgängliga karttjänster: $1',
	'maps_map' => 'Karta',
	'maps-loading-map' => 'Laddar karta ...',
	'maps-markers' => 'Markörer',
	'validation-error-invalid-location' => 'Parameter $1 måste vara en giltig plats.',
	'validation-error-invalid-locations' => 'Parameter $1 måste vara en eller flera giltiga platser.',
	'validation-error-invalid-width' => 'Parameter $1 måste vara en giltig bredd.',
	'validation-error-invalid-height' => 'Parameter $1 måste vara en giltig höjd.',
	'validation-error-invalid-distance' => 'Parameter $1 måste vara ett giltigt avstånd.',
	'validation-error-invalid-distances' => 'Parameter $1 måste vara en eller flera giltiga avstånd.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'Ö',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'V',
	'maps-latitude' => 'Breddgrad:',
	'maps-longitude' => 'Längdgrad:',
	'maps-invalid-coordinates' => 'Värdet $1 identifierades inte som en giltig uppsättning koordinater.',
	'maps_coordinates_missing' => 'Inga koordinater angivna för kartan.',
	'maps_geocoding_failed' => 'Följande {{PLURAL:$2|adress|adresser}} kunde inte geokodas: $1.
Kartan kan inte visas.',
	'maps_geocoding_failed_for' => 'Följande {{PLURAL:$2|adress|adresser}}kunde inte geokodas och {{PLURAL:$2|har|har}} uteslutits från kartan: $1',
	'maps_unrecognized_coords' => 'Följande koordinater kändes inte igen: $1.',
	'maps_unrecognized_coords_for' => 'Följande {{PLURAL:$2|koordinat|koordinater}} kändes inte igen och {{PLURAL:$2|har|har}} utelämnats från kartan:
$1',
	'maps_map_cannot_be_displayed' => 'Kartan kan inte visas.',
	'maps_click_to_activate' => 'Klicka för att aktivera karta',
	'maps_centred_on' => 'Karta centrerad på $1, $2.',
	'maps_photos' => 'Foton',
	'maps_videos' => 'Videoklipp',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webbkameror',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'maps_map' => 'పటం',
	'maps-layer-property' => 'లక్షణం',
	'maps-layer-value' => 'విలువ',
	'maps-layer-errors' => 'పొరపాట్లు',
	'maps-abb-north' => 'ఉ',
	'maps-abb-east' => 'తూ',
	'maps-abb-south' => 'ద',
	'maps-abb-west' => 'ప',
	'maps-latitude' => 'అక్షాంశం:',
	'maps-longitude' => 'రేఖాంశం:',
	'maps_photos' => 'చిత్రాలు',
	'maps_videos' => 'దృశ్యకాలు',
	'maps_wikipedia' => 'వికీపీడియా',
);

/** Thai (ไทย)
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'maps_desc' => 'ให้ความสามารถในการแสดงพิกัดในแผนที่ และที่อยู่ที่เป็นรหัสทางภูมิศาสตร์([http://mapping.referata.com/wiki/Maps_examples demo]).
<br />บริการแผนที่ที่มีอยู่: $1',
	'maps_coordinates_missing' => 'ไม่ได้กำหนดพิกัดของแผนที่มาให้',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'maps_desc' => 'Nagbibigay ng kakayahang ipakita ang dato ng tugmaang-pampook sa loob ng mga mapa, at mga adres ([http://mapping.referata.com/wiki/Maps_examples pagpapakita]).
Makukuhang mga paglilingkod na pangpagmamapa: $1',
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'Ikinakarga ang mapa...',
	'maps-markers' => 'Mga palatandaan',
	'validation-error-invalid-location' => 'Ang parametrong $1 ay dapat na isang tanggap na lokasyon.',
	'validation-error-invalid-locations' => 'Ang parametrong $1 ay dapat na isa o mahigit pang tanggap na mga lokasyon.',
	'validation-error-invalid-width' => 'Ang parametrong $1 ay dapat na isang tanggap na lapad.',
	'validation-error-invalid-height' => 'Ang parametrong $1 ay dapat na isang tanggap na taas.',
	'validation-error-invalid-distance' => 'Ang parametrong $1 ay dapat na isang tanggap na layo.',
	'validation-error-invalid-distances' => 'Ang parametrong $1 ay dapat na isa o mahigit pang tanggap na mga layo.',
	'validation-error-invalid-goverlay' => 'Ang parametrong $1 ay dapat na isang tanggap na patong.',
	'validation-error-invalid-goverlays' => 'Ang parametrong $1 ay dapat na isa o mahigit pang tanggap na mga patong.',
	'maps-abb-north' => 'H',
	'maps-abb-east' => 'S',
	'maps-abb-south' => 'T',
	'maps-abb-west' => 'K',
	'maps-latitude' => 'Latitud:',
	'maps-longitude' => 'Longhitud:',
	'maps-invalid-coordinates' => 'Hindi kinilala ang halagang $1 bilang isang tanggap na pangkat ng mga tugmaang-pampook.',
	'maps_coordinates_missing' => 'Walang mga tugmaang-pampook na ibinigay para sa mapa.',
	'maps_geocoding_failed' => 'Hindi mageokodigo ang sumusunod na {{PLURAL:$2|tirahan|mga tirahan}}:  $1.',
	'maps_geocoding_failed_for' => 'Hindi mageokodigo ang sumusunod na {{PLURAL:$2|tirahan|mga tirahan}} at {{PLURAL:$2|tinanggal|mga tinanggal}} na mula sa mapa:
$1',
	'maps_unrecognized_coords' => 'Hindi kinilala ang sumusunod na {{PLURAL:$2|tugmaan|mga tugmaan}}: $1.',
	'maps_unrecognized_coords_for' => 'Hindi nakilala ang sumusunod na {{PLURAL:$2|tugmaang pampook|mga tugmaang pampook}} at {{PLURAL:$2|inalis|mga inalis}} na mula sa mapa:
$1',
	'maps_map_cannot_be_displayed' => 'Hindi maipapakita ang mapa.',
	'maps-geocoder-not-available' => 'Wala ang katangiang-kasangkapang pang-geokodigo ng Mga Mapa.  Hindi mageokodigo ang lokasyon mo.',
	'maps_click_to_activate' => 'Pindutin upang mabuhay ang mapa',
	'maps_centred_on' => 'Nakagitna ang mapa sa $1, $2.',
	'maps_overlays' => 'Mga patong',
	'maps_photos' => 'Mga larawan',
	'maps_videos' => 'Mga bidyo',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Mga webkam',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Manco Capac
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'maps_map' => 'Harita',
	'maps-loading-map' => 'Harita yükleniyor...',
	'validation-error-invalid-distance' => '$1 değeri geçerli bir mesafe değeri değildir.',
	'maps-abb-north' => 'K',
	'maps-abb-east' => 'D',
	'maps-abb-south' => 'G',
	'maps-abb-west' => 'B',
	'maps-latitude' => 'Enlem:',
	'maps-longitude' => 'Boylam:',
	'maps-invalid-coordinates' => '$1 değeri geçerli bir koordinat olarak algılanmadı.',
	'maps_coordinates_missing' => 'Harita için koordinat girilmedi.',
	'maps_geocoding_failed' => 'Takip eden {{PLURAL:$2|adres|adresler}} coğrafi olarak kodlanmaıyor: $1',
	'maps_unrecognized_coords' => 'Şu {{PLURAL:$2|koordinat|koordinatlar}} tanınamadı: $1',
	'maps_map_cannot_be_displayed' => 'Harita görüntülenemiyor.',
	'maps-geocoder-not-available' => 'Haritanın coğrafi kodlama özelliği etkin değil. Konumunuz kodlanamıyor.',
	'maps_click_to_activate' => 'Haritayı etkinleştirmek için tıkla',
	'maps_centred_on' => 'Harita, $1 $2 koordinatlarında ortalandı.',
	'maps_overlays' => 'Katmanlar',
	'maps_photos' => 'Fotoğraflar',
	'maps_videos' => 'Videolar',
	'maps_wikipedia' => 'Vikipedi',
	'maps_webcams' => 'Web kameraları',
);

/** Tatar (Cyrillic) (Татарча/Tatarça (Cyrillic))
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'maps_wikipedia' => 'Википедия',
);

/** Ukrainian (Українська)
 * @author Arturyatsko
 * @author Тест
 */
$messages['uk'] = array(
	'maps_desc' => 'Надає можливість відображення координат даних в картах, і геокодування адрес ([http://mapping.referata.com/wiki/Maps_examples]). 
Доступні картографічні служби: $1',
	'maps_map' => 'Мапа',
	'maps-loading-map' => 'Завантаження мапи...',
	'maps-markers' => 'Відмітки',
	'maps-layer-property' => 'Властивість',
	'maps-layer-value' => 'Значення',
	'maps-layer-errors' => 'Помилки',
	'validation-error-invalid-distance' => 'Параметр $1 повинен бути дійсною відстанню.',
	'maps-abb-north' => 'П',
	'maps-abb-east' => 'С',
	'maps-abb-south' => 'П',
	'maps-abb-west' => 'З',
	'maps-latitude' => 'Широта:',
	'maps-longitude' => 'Довгота:',
	'maps-invalid-coordinates' => 'Значення $1 не є дійсним набором координат.',
	'maps_coordinates_missing' => 'Не вказані координати для мапи.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Ця адреса не може бути геокодована|Ці адреси не можуть бути геокодовані}}: $1.
Мапа не може бути відображена.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Наступна адреса не може бути геокодована та була видалена|Наступні адреси не можуть бути геокодовані та були видалені}} з мапи:
$1',
	'maps_unrecognized_coords' => 'Ці {{PLURAL:$2|координати|координати}} не були розпізнані: $1.',
	'maps_unrecognized_coords_for' => 'Наступні координати не були розпізнані, {{PLURAL:$2|вони|вони}} не показані на мапі:
$1',
	'maps_map_cannot_be_displayed' => 'Мапа не може бути відображена.',
	'maps-geocoder-not-available' => 'Функція геокодування мап недоступна. Ваше місце розташування не може бути геокодоване.',
	'maps_click_to_activate' => 'Натисність щоб активувати мапу',
	'maps_centred_on' => 'Центр мапи — $1, $2.',
	'maps_overlays' => 'Шари',
	'maps_photos' => 'Фото',
	'maps_videos' => 'Відео',
	'maps_wikipedia' => 'Вікіпедія',
	'maps_webcams' => 'Веб-камери',
);

/** Veps (Vepsan kel') */
$messages['vep'] = array(
	'maps-abb-north' => 'Pohj.',
	'maps-abb-east' => 'Päivl.',
	'maps-abb-south' => 'Suvi',
	'maps-abb-west' => 'Päivn.',
	'maps-latitude' => 'Leveduz:',
	'maps-longitude' => 'Piduz:',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'maps_name' => 'Bản đồ',
	'maps_desc' => 'Cung cấp khả năng hiển thị dữ liệu tọa độ trên bản đồ và địa chỉ mã địa lý ([http://mapping.referata.com/wiki/Maps_examples thử xem]).
Các dịch vụ bản đồ có sẵn: $1',
	'maps_map' => 'Bản đồ',
	'maps-loading-map' => 'Đang tải bản đồ…',
	'maps-markers' => 'Chú thích',
	'maps-others' => 'khác',
	'maps-ns-layer' => 'Lớp',
	'maps-ns-layer-talk' => 'Thảo luận Lớp',
	'maps-layer-property' => 'Thuộc tính',
	'maps-layer-value' => 'Giá trị',
	'maps-layer-errors' => 'Lỗi',
	'maps-error-invalid-layerdef' => 'Định nghĩa lớp này không hợp lệ.',
	'maps-error-invalid-layertype' => 'Không có lớp nào kiểu “$1”. Chỉ có {{PLURAL:$3|loại|các loại}} này được hỗ trợ: $2',
	'maps-error-no-layertype' => 'Cần phải định rõ kiểu lớp. {{PLURAL:$2|Kiểu|Các kiểu}} này được hỗ trợ: $1',
	'validation-error-invalid-layer' => 'Tham số $1 phải là một lớp hợp lệ.',
	'validation-error-invalid-layers' => 'Tham số $1 phải là một hoặc nhiều lớp hợp lệ.',
	'maps-layer-of-type' => 'Lớp kiểu $1',
	'maps-layer-type-supported-by' => '{{PLURAL:$2|Có thể|Chỉ có thể}} sử dụng kiểu lớp này với {{PLURAL:$2|dịch vụ bản đồ $1|các dịch vụ bản đồ: $1}}.',
	'validation-error-invalid-location' => 'Tham số $1 phải là một vị trí hợp lệ.',
	'validation-error-invalid-locations' => 'Tham số $1 phải là một hoặc nhiều vị trí hợp lệ.',
	'validation-error-invalid-width' => 'Tham số $1 phải là một chiều rộng hợp lệ.',
	'validation-error-invalid-height' => 'Tham số $1 phải là một chiều cao hợp lệ.',
	'validation-error-invalid-distance' => 'Tham số $1 phải là một tầm hợp lệ.',
	'validation-error-invalid-distances' => 'Tham số $1 phải là một hoặc nhiều vị trí hợp lệ.',
	'validation-error-invalid-image' => 'Tham số $1 phải là một hình ảnh hợp lệ.',
	'validation-error-invalid-images' => 'Tham số $1 phải là một hoặc nhiều hình ảnh hợp lệ.',
	'validation-error-invalid-goverlay' => 'Tham số $1 phả là một lấp hợp lệ.',
	'validation-error-invalid-goverlays' => 'Tham số $1 phải là một hoặc nhiều lấp hợp lệ.',
	'maps-abb-north' => 'B',
	'maps-abb-east' => 'Đ',
	'maps-abb-south' => 'N',
	'maps-abb-west' => 'T',
	'maps-latitude' => 'Vĩ độ:',
	'maps-longitude' => 'Kinh độ:',
	'maps-invalid-coordinates' => 'Giá trị $1 không được nhận ra là tọa độ hợp lệ.',
	'maps_coordinates_missing' => 'Chưa định rõ tọa độ cho bản đồ.',
	'maps_geocoding_failed' => 'Không thể tính ra mã địa lý của {{PLURAL:$2|địa chỉ|các địa chỉ}} sau: $1.
Không thể hiển thị bản đồ.',
	'maps_geocoding_failed_for' => 'Không thể tính ra mã địa lý của {{PLURAL:$2|địa chỉ|các địa chỉ}} sau nên bản đồ bỏ qua nó:
$1',
	'maps_unrecognized_coords' => 'Không thể nhận ra {{PLURAL:$2|tọa độ|các tọa độ}} sau: $1.',
	'maps_unrecognized_coords_for' => 'Không thể nhận ra {{PLURAL:$2|tọa độ|các tọa độ}} sau nên bản đồ bỏ qua nó:
$1',
	'maps_map_cannot_be_displayed' => 'Không thể hiển thị bản đồ.',
	'maps-geocoder-not-available' => 'Không thể mã hóa vị trí của bạn vì tính năng mã hóa địa lý của Bản đồ không có sẵn.',
	'maps_osm' => 'OpenStreetMap',
	'maps_click_to_activate' => 'Nhấn chuột vào bản đồ để kích hoạt',
	'maps_centred_on' => 'Bản đồ với trung tậm tại $1, $2.',
	'maps_overlays' => 'Lấp',
	'maps_photos' => 'Hình ảnh',
	'maps_videos' => 'Video',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcam',
);

/** Volapük (Volapük) */
$messages['vo'] = array(
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'L',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'V',
	'maps-latitude' => 'Videt:',
	'maps-longitude' => 'Lunet:',
);

/** Chinese (China) (‪中文(中国大陆)‬) */
$messages['zh-cn'] = array(
	'maps-latitude' => '纬度：',
	'maps-longitude' => '经度：',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'maps_map' => '地图',
	'maps-loading-map' => '载入中...',
	'maps-abb-north' => '北',
	'maps-abb-east' => '东',
	'maps-abb-south' => '南',
	'maps-abb-west' => '西',
	'maps-latitude' => '纬度：',
	'maps-longitude' => '经度：',
	'maps_wikipedia' => '维基百科',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Horacewai2
 */
$messages['zh-hant'] = array(
	'maps_map' => '地圖',
	'maps-loading-map' => '載入中...',
	'maps-abb-north' => '北',
	'maps-abb-east' => '東',
	'maps-abb-south' => '南',
	'maps-abb-west' => '西',
	'maps-latitude' => '緯度：',
	'maps-longitude' => '經度：',
);

/** Chinese (Taiwan) (‪中文(台灣)‬) */
$messages['zh-tw'] = array(
	'maps-abb-north' => '北',
	'maps-abb-east' => '東',
	'maps-abb-south' => '南',
	'maps-abb-west' => '西',
	'maps-latitude' => '緯度：',
	'maps-longitude' => '經度：',
);

