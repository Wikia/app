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
	'maps-desc' => "Enables embedding of dynamic maps into wiki pages, geocoding of addresses and other geographical operations. ([http://mapping.referata.com/wiki/Examples demos])",
	
	'right-geocode' => 'Geocode',
	
	'maps_map' => 'Map',
	'maps-loading-map' => 'Loading map...',
	'maps-load-failed' => 'Could not load the map!',
	'maps-markers' => 'Markers',
	'maps-others' => 'others',
	//TODO: move to namespaces i18n
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

	// Parser function descriptions
	'maps-coordinates-description' => 'Parser hook to format coordinates, from and to any of the supported formats.',
	'maps-displaymap-description' => 'Display geographical maps without any wiki-defined markers on them.',
	'maps-displaypoint-description' => 'Display geographical maps with one or more wiki-defined markers on them.',
	'maps-distance-description' => "Convert a distance using a certain supported unit to its equivalent using another unit.",
	'maps-finddestination-description' => 'Find a destination given a starting point (that can be in any of the supported formats), an initial bearing and a distance.',
	'maps-geocode-description' => 'Enables the geocoding of addresses, in other words, turning human readable locations into sets of coordinates. There is support for several geocoding services, which should not be confused with mapping services.',
	'maps-geodistance-description' => 'Calculate the geographical distance between two points, from and to any of the supported formats.',
	'maps-mapsdoc-description' => 'Display a table with the parameters for a specified mapping service together with their default values and descriptions.',

	// Mapsdoc parser hook
	'maps-mapsdoc-par-service' => 'The mapping service to display parameter documentation for.',
	'maps-mapsdoc-par-language' => 'The language in which to display the documentation. If no such translation is available, English will be used instead.',
	
	// Coordinates parser hook
	'maps-coordinates-par-location' => 'The coordinates you want to format.',
	'maps-coordinates-par-format' => 'The target format for the coordinates.',
	'maps-coordinates-par-directional' => 'Indicates if the coordinates should be outputted directional or not.',

	// Distance parser hook
	'maps-distance-par-distance' => "The distance to convert to its equivalent with a specified unit.",
	'maps-distance-par-decimals' => 'The maximum number of fractional digits to use in the resulting value.',
	'maps-distance-par-unit' => 'The unit to output the distance in.',

	// Finddestination paser hook
	'maps-finddestination-par-location' => 'The initial location.',
	'maps-finddestination-par-bearing' => 'The initial bearing.',
	'maps-finddestination-par-distance' => 'The distance to travel.',
	'maps-finddestination-par-format' => 'The format in which to output the destination.',
	'maps-finddestination-par-directional' => 'Indicates if the format of the destination should be directional or not.',
	'maps-finddestination-par-allowcoordinates' => 'Indicates if coordinates should be allowed. If set to no, only addresses will be accepted.',
	'maps-finddestination-par-geoservice' => "The geocoding service to use to geocode the value in case it is an address.",
	'maps-finddestination-par-mappingservice' => "Parameter to indicate the mapping service to use with this function.
This will allow maps to override the default value of the service parameter by the one that is optimal for the mapping service.
(Example: In case of Google Maps, the Google geocoder will be used.)",

	// Geocode parser hook
	'maps-geocode-par-location' => 'The address you want to geocode.',
	'maps-geocode-par-mappingservice' => 'The geocoding service you want to use. See the available geocoding services.',
	'maps-geocode-par-geoservice' => 'This parameter allows you to indicate you are using this geocoding request in combination with a specific mapping service.
Each mapping service can have overrides over the default value for the geocoding service.
This is for legal considerations, since you can not use the Google Geocoding service except together with Google Maps.
Setting this parameter and not the parameter for the service, will ensure you are not using an invalid combination.',
	'maps-geocode-par-allowcoordinates' => 'Allows disabling the support for coordinates in this function. Must be either yes or no.
When no, every value will be geocoded, even valid coordinates.',
	'maps-geocode-par-format' => 'The format for the resulting coordinates.',
	'maps-geocode-par-directional' => 'Indicates if the coordinates should be outputted directional or not.',

	// Geodistance parser hook
	'maps-geodistance-par-location1' => 'The first point in the set to calculate the distance between.',
	'maps-geodistance-par-location2' => 'The second point in the set to calculate the distance between.',
	'maps-geodistance-par-unit' => 'The unit to output the distance in.',
	'maps-geodistance-par-decimals' => 'The maximum number of fractional digits to use in the resulting value.',
	'maps-geodistance-par-mappingservice' => 'The geocoding service to use to geocode any addresses.',
	'maps-geodistance-par-geoservice' => 'The mapping service this is used together with.
This can affect the default geocoding service value.',

	// display_map parser hook
	'maps-displaymap-par-mappingservice' => 'Allows setting the mapping service that will be used to generate the map.',
	'maps-displaymap-par-coordinates' => 'The location the map will initially be centred on.',

	// display_points parser hook
	'maps-displaypoints-par-zoom' => 'Allows setting the zoom level of the map.
When not provided and multiple markers are present on the map, the best fitting zoom will be taken, not the configurable default.',
	'maps-displaypoints-par-mappingservice' => 'Allows setting the mapping service that will be used to generate the map.',
	'maps-displaypoints-par-coordinates' => 'One or more locations to display on the map. They will be indicated with a marker.',
	'maps-displaypoints-par-centre' => "Allows setting the coordinates of the map's centre for display_point(s).
Accepts both addresses and coordinates.
When this property is not provided, the map will centre itself on the provided marker, or between the provided markers.",
	'maps-displaypoints-par-title' => 'Allows setting text that will be displayed in the pop-ups of all markers that do not have a specific title.
When used together with label, the title will be bold and underlined.',
	'maps-displaypoints-par-label' => 'Allows setting text that will be displayed in the pop-ups of all markers that do not have a specific label.',
	'maps-displaypoints-par-icon' => 'Allows setting the icon used for all markers.',

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

	'maps-par-resizable' => 'Makes the map resizable by dragging at it\'s lower right corner.',
	'maps-par-geoservice' => 'The geocoding service to use to make translations between addresses and coordinates.',
	'maps-par-zoom' => 'The zoom level for the map. For maps with markers this will default to the most zoomed in level that still shows all markers.',
	'maps-par-width' => 'Allows setting the width of the map. By default pixels will be assumed as unit, but you can explicitly specify one of these units: px, ex, em, %.',
	'maps-par-height' => 'Allows setting the height of the map. By default pixels will be assumed as unit, but you can explicitly specify one of these units: px, ex, em, %.',
    
	// Google Maps v2
	'maps-googlemaps2-incompatbrowser' => 'Your browser is not compatible with Google Maps v2.',
	'maps_overlays' => 'Overlays',
	'maps_photos' => 'Photos',
	'maps_videos' => 'Videos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcams',
	'maps-googlemaps2-par-type' => 'The map type to initially show.',
	'maps-googlemaps2-par-types' => 'The map types that will be available via the type control.',
	'maps-googlemaps2-par-controls' => 'The controls to place on the map.',
	'maps-googlemaps2-par-autozoom' => 'Enable scrolling using the mousewheel.',
	'maps-googlemaps2-par-kml' => 'KML files to load onto the map.',
	'maps-googlemaps2-par-overlays' => 'Overlays the user can turn on.',

	// Google Maps v3
	'maps-googlemaps3-incompatbrowser' => 'Your browser is not compatible with Google Maps v3.',
	'maps-googlemaps3-par-type' => 'The map type to initially show.',
	'maps-googlemaps3-par-types' => 'The map types that will be available via the type control.',
	'maps-googlemaps3-par-layers' => 'Special layers to load onto the map.',
	'maps-googlemaps3-par-controls' => 'The controls to place on the map.',
	'maps-googlemaps3-par-zoomstyle' => 'The style of the zoom control.',
	'maps-googlemaps3-par-typestyle' => 'The style of the type control.',
	'maps-googlemaps3-par-autoinfowindows' => 'Automatically open all info windows after the page has loaded.',
	'maps-googlemaps3-par-kml' => 'KML files to load onto the map.',
	'maps-googlemaps3-par-gkml' => 'KML files hosted by Google to load onto the map.',
	'maps-googlemaps3-par-fusiontables' => 'IDs of Google Fusion Tables which should be loaded onto the map.',
	'maps-googlemaps3-par-tilt' => 'Tilt for the Map when using Google Maps.',
	'maps-googlemaps3-par-kmlrezoom' => 'Rezoom the map after the KML layers have been loaded.',

	// OpenLayers
	'maps-openlayers-par-controls' => 'The controls to place on the map.',
	'maps-openlayers-par-layers' => 'The layers that will be available in the layer selector. The first layer will be shown when the map loads.',

	// OSM
	'maps-osm-par-thumbs' => 'Show thumbs',
	'maps-osm-par-photos' => 'Show photos',

	// Yahoo! Maps
	'maps-yahoomaps-par-type' => 'The map type to initially show.',
	'maps-yahoomaps-par-types' => 'The map types that will be available via the type control.',
	'maps-yahoomaps-par-controls' => 'The controls to place on the map.',
	'maps-yahoomaps-par-autozoom' => 'Enable scrolling using the mousewheel.',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Kghbln
 * @author Purodha
 * @author Raymond
 * @author Umherirrender
 * @author Тест
 */
$messages['qqq'] = array(
	'maps-desc' => '{{desc}}',
	'right-geocode' => '{{doc-right|geocode}}',
	'maps_map' => '{{Identical|Map}}',
	'maps-others' => '{{Identical|Other}}',
	'maps-layer-property' => '{{Identical|Property}}',
	'maps-layer-value' => '{{Identical|Value}}',
	'maps-layer-errors' => '{{Identical|Error}}',
	'maps-latitude' => '{{Identical|Latitude}}',
	'maps-longitude' => '{{Identical|Longitude}}',
	'maps_geocoding_failed_for' => '* $1 is a list
* $2 is the number of list items for PLURAL use.',
	'maps_googlemaps2' => '{{optional}}',
	'maps_googlemaps3' => '{{optional}}',
	'maps_yahoomaps' => '{{optional}}',
	'maps_openlayers' => '{{optional}}',
	'maps_osm' => '{{optional}}',
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
	'maps-desc' => 'Ofron mundësinë për të shfaqur koordinimin e të dhënave në harta, dhe adresat geocode ([http://mapping.referata.com/wiki/Maps_examples demo]). Hartës shërbimet në dispozicion: $1',
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
 * @author Imksa
 * @author Meno25
 */
$messages['ar'] = array(
	'maps-desc' => 'يسمح بتضمين خرائط ديناميكية إلى صفحات الويكي، كود العناوين وعمليات جغرافية أخرى. ([http://mapping.referata.com/wiki/Examples تجارب])',
	'maps_map' => 'خريطة',
	'maps-loading-map' => 'تحميل الخريطة...',
	'maps-load-failed' => 'لا يمكن تحميل الخريطة!',
	'maps-markers' => 'علامات',
	'maps-others' => 'أخرون',
	'maps-ns-layer' => 'طبقة',
	'maps-layer-property' => 'خاصية',
	'maps-layer-value' => 'القيمة',
	'maps-layer-errors' => 'أخطاء',
	'maps-error-invalid-layerdef' => 'تعريف هذه الطبقة غير صالح.',
	'maps-error-invalid-layertype' => 'لا توجد طبقات من نوع " $1 ". فقط {{PLURAL:$3| هذا النوع هو | هذه الأنواع هي}} المدعومة : $2',
	'maps-error-no-layertype' => 'تحتاج إلى تحديد نوع طبقة. {{PLURAL:$2| هذا النوع فقط | هذه الأنواع هي}} المدعومة : $1',
	'validation-error-invalid-layer' => 'المعلمة $1 يجب أن تكون طبقة صالحة.',
	'validation-error-invalid-layers' => 'المعلمة $1 يجب أن تكون طبقة واحدة  أو أكثر صالحة.',
	'maps-layer-of-type' => 'طبقة من نوع $1',
	'maps-layer-type-supported-by' => 'نوع الطبقة هذا يمكن أن {{PLURAL:$2| يمكن استخدامها فقط مع $1 خدمة الخرائط | يمكن استخدامها مع خدمات الخرائط : $1 }}.',
	'maps-coordinates-description' => 'ربط محلل بإحداثيات الشكل ، من وإلى أي من الأشكال المدعومة.',
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
	'maps_unrecognized_coords' => '{{PLURAL:$2|الإحداثي التالي|الإحداثيات التالية}} لم يتم التعرف عليها: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|الإحداثي التالي|الإحداثيات التالية}} لم يتم التعرف عليها و {{PLURAL:$2|تمت|تمت}} إزالتها من الخريطة:
$1',
	'maps_map_cannot_be_displayed' => 'الخريطة لا يمكن عرضها.',
	'maps_googlemaps2' => 'خرائط جوجل v2',
	'maps_googlemaps3' => 'خرائط جوجل v3',
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
	'maps-abb-north' => 'شمال',
	'maps-abb-east' => 'شرق',
	'maps-abb-south' => 'جنوب',
	'maps-abb-west' => 'غرب',
	'maps-latitude' => 'دوائر العرض:',
	'maps-longitude' => 'خطوط الطول:',
	'maps_googlemaps2' => 'خرايط جوجل',
	'maps_yahoomaps' => 'خرايط ياهو',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'maps-desc' => 'Activa inxertar mapes dinámicos nes páxines wiki, xeocodificación de direiciones y otres operaciones xeográfiques. ([http://mapping.referata.com/wiki/Examples Demos])',
	'right-geocode' => 'Xeocódigu',
	'maps_map' => 'Mapa',
	'maps-loading-map' => "Cargando'l mapa...",
	'maps-load-failed' => '¡Nun se pudo cargar el mapa!',
	'maps-markers' => 'Marcadores',
	'maps-others' => 'otros',
	'maps-ns-layer' => 'Capa',
	'maps-ns-layer-talk' => 'Alderique de capa',
	'maps-layer-property' => 'Propiedá',
	'maps-layer-value' => 'Valor',
	'maps-layer-errors' => 'Errores',
	'maps-error-invalid-layerdef' => 'Esta definición de capa nun ye válida.',
	'maps-error-invalid-layertype' => 'Nun hai capes de tipu "$1". Sólo {{PLURAL:$3|tien sofitu esti tipu|tienen sofitu estos tipos}}: $2',
	'maps-error-no-layertype' => "Tienes d'especificar la triba de capa. {{PLURAL:$2|Sólo tien sofitu esta triba|Tienen sofitu estes tribes}}: $1",
	'validation-error-invalid-layer' => 'El parámetru $1 tien de ser una capa válida.',
	'validation-error-invalid-layers' => 'El parámetru $1 tien de ser una o más capes válides.',
	'maps-layer-of-type' => 'Capa de tipu $1',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'O',
	'maps-latitude' => 'Llatitú:',
	'maps-longitude' => 'Llonxitú:',
	'maps_overlays' => 'Superposiciones',
	'maps_photos' => 'Semeyes',
	'maps_videos' => 'Videos',
	'maps_wikipedia' => 'Uiquipedia',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'maps_map' => 'Xəritə',
	'maps-loading-map' => 'Xəritə yüklənir...',
	'maps-layer-errors' => 'Xətalar',
	'maps-abb-north' => 'Şm',
	'maps-abb-east' => 'C',
	'maps-abb-west' => 'Q',
	'maps_photos' => 'Şəkillər',
	'maps_videos' => 'Videolar',
	'maps_wikipedia' => 'Vikipediya',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'maps-loading-map' => 'Korten werd gloon ...',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'maps-desc' => 'Забясьпечвае магчымасьць убудаваньня дынамічных мапаў у вікі-старонкі, геаграфічнага кадаваньня адрасоў і іншыя геаграфічныя апэрацыі. ([http://mapping.referata.com/wiki/Examples Прыклады])',
	'right-geocode' => 'геаграфічнае кадаваньне',
	'maps_map' => 'Мапа',
	'maps-loading-map' => 'Загрузка мапы…',
	'maps-load-failed' => 'Немагчыма загрузіць мапу!',
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
	'maps-coordinates-description' => 'Перахопнік парсэру для фарматаваньня каардынатаў, з і ў любыя фарматы, якія падтрымліваюцца.',
	'maps-displaymap-description' => 'Паказвае геаграфічныя мапы без аніякіх вікі-пазнакаў на іх.',
	'maps-displaypoint-description' => 'Паказвае геаграфічныя мапы з адной ці болей вікі-пазнакамі на іх.',
	'maps-distance-description' => 'Канвэртуе адлегласьць выкарыстоўваючы адзінкі, якія падтрымліваюцца, ў іх эквівалент, выкарыстоўваючы іншыя адзінкі.',
	'maps-finddestination-description' => 'Знаходзіць пункт прызначэньня з пададзенага пачатковага пункту (можа быць у любым фармаце, якія падтрымліваюцца), пачатковага напрамку і адлегласьці.',
	'maps-geocode-description' => 'Уключае геаграфічную кадыроўку адрасу, іншымі словамі, пераўтварае чытальнае для чалавека знаходжаньне ў набор каардынатаў. Тут ёсьць падтрымка для некалькіх сэрвісаў геаграфічнай кадыроўкі, якія не павінны быць блытаныя з сэрвісамі мапаў.',
	'maps-geodistance-description' => 'Падлічвае геаграфічную адлегласьць паміж двума пунктамі, з і для любога з фарматаў, якія падтрымліваюцца.',
	'maps-mapsdoc-description' => 'Паказвае табліцу з парамэтрамі для пазначанага сэрвісу стварэньня мапаў разам з яго значэньнямі па змоўчваньні і апісаньнямі.',
	'maps-mapsdoc-par-service' => 'Сэрвіс стварэньня мапаў, для якога паказваць дакумэнтацыю пра парамэтры.',
	'maps-mapsdoc-par-language' => 'Мова, на якой паказваць дакумэнтацыю. Калі перакладу на такую мову няма, замест яе будзе выкарыстоўвацца ангельская.',
	'maps-coordinates-par-location' => 'Каардынаты, якія Вы жадаеце фарматаваць.',
	'maps-coordinates-par-format' => 'Мэтавы фармат для каардынатаў.',
	'maps-coordinates-par-directional' => 'Паказвае, ці павінны каардынаты быць выведзены непасрэдна ці не.',
	'maps-distance-par-distance' => 'Адлегласьць для канвэртаваньня ў яе эквівалент у пададзеных адзінках.',
	'maps-distance-par-decimals' => 'Максымальная колькасьць лічбаў пасьля дзесятковай коскі для выкарыстаньня ў выніковым значэньні.',
	'maps-distance-par-unit' => 'Адзінкі, у якіх будзе выведзеная адлегласьць.',
	'maps-finddestination-par-location' => 'Пачатковае месцазнаходжаньне.',
	'maps-finddestination-par-bearing' => 'Пачатковы накірунак.',
	'maps-finddestination-par-distance' => 'Адлегласьць для падарожжа.',
	'maps-finddestination-par-format' => 'Фармат, у якім выводзіць пункт прызначэньня.',
	'maps-finddestination-par-directional' => 'Паказвае, калі фармат пункту прызначэньня павінен быць накіраваны ці не.',
	'maps-finddestination-par-allowcoordinates' => 'Паказвае, калі павінны быць дазволеныя каардынаты. Калі ўстанавіць у «не», будуць прымацца толькі адрасы.',
	'maps-finddestination-par-geoservice' => 'Сэрвіс геаграфічнай кадыроўкі для геаграфічнага пераўтварэньня значэньня ў выпадку, калі яно зьяўляецца адрасам.',
	'maps-finddestination-par-mappingservice' => 'Парамэтар, які Вы можаце выкарыстоўваць для ўказаньня сэрвісу мапаў, з якім Вы выкарыстоўваеце гэтую функцыю.
Гэта дазволіць замяніць значэньня парамэтра сэрвісу па змоўчваньні на той, які больш адпавядае сэрвісу мапаў.
(Напрыклад, для Google Maps будзе выкарыстоўвацца Google geocoder.)',
	'maps-geocode-par-location' => 'Адрас, які Вы жадаеце геаграфічна кадыраваць.',
	'maps-geocode-par-mappingservice' => 'Сэрвіс геаграфічнай кадыроўкі, які Вы жадаеце выкарыстаць. Глядзіце даступныя сэрвісы геаграфічнай кадыроўкі.',
	'maps-geocode-par-geoservice' => 'Гэты парамэтар дазваляе Вам указваць, што Вы выкарыстоўваеце гэты запыт геаграфічнай кадыроўкі ў спалучэньні з адпаведным сэрвісам мапаў.
Кожны сэрвіс мапаў можа перавызначаць службу геаграфічнага кадаваньня па змоўчваньні.
Гэта робіцца зь юрыдычных меркаваньняў, паколькі службу геаграфічнага кадаваньня Google можна выкарыстоўваць толькі ў спалучэньні з мапамі Google.
Устаноўка гэтага парамэтра, а парамэтра для не сэрвісу, будзе гарантаваць, што Вы не выкарыстоўваеце недапушчальнае спалучэньне.',
	'maps-geocode-par-allowcoordinates' => 'Дазваляе выключэньня падтрымкі каардынатаў у гэтай функцыі. Павінна быць пазначана «так» ці «не».
Калі «не», то кожнае значэньне будзе геаграфічна кадыравацца, нават слушныя каардынаты.',
	'maps-geocode-par-format' => 'Фармат для выніковых каардынатаў.',
	'maps-geocode-par-directional' => 'Паказвае, ці павінны каардынаты быць выведзены непасрэдна ці не.',
	'maps-geodistance-par-location1' => 'Першы пункт для вылічэньня адлегласьці.',
	'maps-geodistance-par-location2' => 'Другі пункт для вылічэньня адлегласьці.',
	'maps-geodistance-par-unit' => 'Адзінкі, у якіх будзе выведзеная адлегласьць.',
	'maps-geodistance-par-decimals' => 'Максымальная колькасьць лічбаў пасьля дзесятковай коскі для выкарыстаньня ў выніковым значэньні.',
	'maps-geodistance-par-mappingservice' => 'Сэрвіс геаграфічнай кадыроўкі для выкарыстаньня ў геаграфічнай карыроўцы любых адрасоў.',
	'maps-geodistance-par-geoservice' => 'Сэрвіс мапаў, з якім выкарыстоўваецца.
Гэта ўплывае на значэньне сэрвісу геаграфічнай кадыроўкі па змоўчваньні.',
	'maps-displaymap-par-mappingservice' => 'Дазваляе ўстанаўліваць сэрвіс мапаў, які будзе выкарыстоўвацца для стварэньня мапы.',
	'maps-displaymap-par-coordinates' => 'Месцазнаходжаньне, на якім мапа будзе цэнтравацца.',
	'maps-displaypoints-par-zoom' => 'Дазваляе зьмяняць павелічэньне мапы.
Калі гэта немагчыма, ці на мапе ёсьць некалькі маркераў, замест пазначанага ў наладах будзе выбранае найбольш слушнае павелічэньне.',
	'maps-displaypoints-par-mappingservice' => 'Дазваляе ўстанаўліваць сэрвіс мапаў, які будзе выкарыстоўвацца для стварэньня мапы.',
	'maps-displaypoints-par-coordinates' => 'Адно ці болей месцазнаходжаньняў для паказу на мапе. Яны будуць паказаныя маркерамі.',
	'maps-displaypoints-par-centre' => 'Дазваляе ўстанаўліваць каардынаты цэнтру мапы для display_point(s).
Прымаюцца адрасы і каардынаты.
Калі гэтая ўласьцівасьць не пададзеная, мапа будзе цэнтравацца на пададзеным маркеры ці паміж пададзенымі маркерамі.',
	'maps-displaypoints-par-title' => 'Дазваляе ўстанаўліваць тэкст, які будзе паказаны ў разгортваемым тэксьце тых маркераў, якія ня маюць асобных назваў.
Калі выкарыстоўваецца з меткамі, назва будзе паказаная тлустым тэкстам і падкрэсьленая.',
	'maps-displaypoints-par-label' => 'Дазваляе ўстанаўліваць тэкст, які будзе паказаны ў разгортваемым тэксьце тых маркераў, якія ня маюць асобных метак.',
	'maps-displaypoints-par-icon' => 'Дазваляе ўстанаўліваць выявы для ўсіх маркераў.',
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
	'maps-par-resizable' => 'Дазваляе зьмяняць памеры мапы, перацягваючы яе ніжні правы кут.',
	'maps-par-geoservice' => 'Сэрвіс геаграфічнага кадаваньня для пераўтварэньня адрасоў і каардынаты.',
	'maps-par-zoom' => 'Маштаб мапы. Для мапаў з пазначэньнямі маштаб будзе такім, пры якім яшчэ будуць паказвацца ўсе пазначэньні.',
	'maps-par-width' => 'Дазваляе наладжваць шырыню мапы. Па змоўчваньні піксэлі выкарыстоўваюцца як адзінкі вымярэньня, але Вы можаце непасрэдна вызначыць адну з гэтых адзінак вымярэньня: px, ex, em, %.',
	'maps-par-height' => 'Дазваляе наладжваць вышыню мапы. Па змоўчваньні піксэлі выкарыстоўваюцца як адзінкі вымярэньня, але Вы можаце непасрэдна вызначыць адну з гэтых адзінак вымярэньня: px, ex, em, %.',
	'maps-googlemaps2-incompatbrowser' => 'Ваш браўзэр не сумяшчальны з Google Maps v2.',
	'maps_overlays' => 'Слаі',
	'maps_photos' => 'Фотаздымкі',
	'maps_videos' => 'Відэа',
	'maps_wikipedia' => 'Вікіпэдыя',
	'maps_webcams' => 'Ўэб-камэры',
	'maps-googlemaps2-par-type' => 'Тып мапы, які будзе паказвацца ў пачатку.',
	'maps-googlemaps2-par-types' => 'Тыпы мапаў, якія будуць даступныя праз элемэнт кіраваньня тыпамі.',
	'maps-googlemaps2-par-controls' => 'Элемэнты кіраваньня, якія будуць разьмешчаныя на мапе.',
	'maps-googlemaps2-par-autozoom' => 'Уключае пракрутку праз кола мышкі.',
	'maps-googlemaps2-par-kml' => 'KML-файлы для загрузкі ў мапу.',
	'maps-googlemaps2-par-overlays' => 'Слаі, якія ўдзельнік можа ўключыць.',
	'maps-googlemaps3-incompatbrowser' => 'Ваш браўзэр не сумяшчальны з Google Maps v3.',
	'maps-googlemaps3-par-type' => 'Тып мапы, які будзе паказвацца ў пачатку.',
	'maps-googlemaps3-par-types' => 'Тыпы мапаў, якія будуць даступныя праз элемэнт кіраваньня тыпамі.',
	'maps-googlemaps3-par-layers' => 'Спэцыяльныя слаі для загрузкі ў мапу.',
	'maps-googlemaps3-par-controls' => 'Элемэнты кіраваньня, якія будуць разьмешчаныя на мапе.',
	'maps-googlemaps3-par-zoomstyle' => 'Стыль элемэнта кіраваньня маштабам.',
	'maps-googlemaps3-par-typestyle' => 'Стыль элемэнта кіраваньня тыпамі.',
	'maps-googlemaps3-par-autoinfowindows' => 'Аўтаматычна адкрываць ўсе інфармацыйныя вокны, пасьля таго, як старонка была загружаная.',
	'maps-googlemaps3-par-kml' => 'KML-файлы для загрузкі ў мапу.',
	'maps-googlemaps3-par-gkml' => 'Файлы KML разьмешчаныя на Google для загрузкі на мапу.',
	'maps-googlemaps3-par-fusiontables' => 'Ідэнтыфікатары табліцаў Google Fusion, якія павінны быць загружаныя ў мапу.',
	'maps-googlemaps3-par-tilt' => 'Вугал нахілу мапы, падчас выкарыстаньня Google Maps.',
	'maps-googlemaps3-par-kmlrezoom' => 'Зьмяняць маштаб мапы пасьля загрузкі KML-слаёў.',
	'maps-openlayers-par-controls' => 'Элемэнты кіраваньня, якія будуць разьмешчаныя на мапе.',
	'maps-openlayers-par-layers' => 'Слаі, якія будуць даступныя падчас выбару слаёў. Першы слой будзе паказаны пасьля загрузкі мапы.',
	'maps-osm-par-thumbs' => 'Паказваць мініятуры',
	'maps-osm-par-photos' => 'Паказваць выявы',
	'maps-yahoomaps-par-type' => 'Тып мапы, які будзе паказвацца ў пачатку.',
	'maps-yahoomaps-par-types' => 'Тыпы мапаў, якія будуць даступныя праз элемэнт кіраваньня тыпамі.',
	'maps-yahoomaps-par-controls' => 'Элемэнты кіраваньня, якія будуць разьмешчаныя на мапе.',
	'maps-yahoomaps-par-autozoom' => 'Дазваляе пракрутку праз кола мышкі.',
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

/** Banjar (Bahasa Banjar)
 * @author Ezagren
 */
$messages['bjn'] = array(
	'maps-abb-north' => 'U',
	'maps-abb-east' => 'T',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'B',
	'maps_wikipedia' => 'Wikipidia',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'maps_map' => 'মানচিত্র',
	'maps-loading-map' => 'মানচিত্র লোড করা হচ্ছে...',
	'maps-load-failed' => 'মানচিত্র লোড করা সম্ভব হয়নি!',
	'maps-others' => 'অন্যান্য',
	'maps-ns-layer' => 'পর্ব',
	'maps-ns-layer-talk' => 'পর্ব আলোচনা',
	'maps-layer-property' => 'সম্পত্তি',
	'maps-layer-value' => 'মান',
	'maps-layer-errors' => 'ত্রুটি',
	'maps-error-invalid-layerdef' => 'পর্বের এই সংজ্ঞাটি গ্রহণযোগ্য নয়।',
	'maps-abb-north' => 'উ',
	'maps-abb-east' => 'পূ',
	'maps-abb-south' => 'দ',
	'maps-abb-west' => 'প',
	'maps-latitude' => 'অক্ষাংশ:',
	'maps-longitude' => 'দ্রাঘিমাংশ:',
	'maps_map_cannot_be_displayed' => 'এই মানচিত্রটি প্রদর্শন করা সম্ভব নয়।',
	'maps_click_to_activate' => 'মানচিত্র চালু করতে ক্লিক করুন',
	'maps_centred_on' => 'মানচিত্র $1, $2-এ কেন্দ্রীভূত।',
	'maps_photos' => 'ছবি',
	'maps_videos' => 'ভিডিও',
	'maps_wikipedia' => 'উইকিপিডিয়া',
	'maps_webcams' => 'ওয়েবক্যাম',
	'maps-osm-par-thumbs' => 'থাম্ব দেখাও',
	'maps-osm-par-photos' => 'ছবি দেখাও',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'maps-desc' => "Aotren a ra ensoc'hañ kartennoù dinamek er pajennoù wiki, geokodañ chomlec'hioù hag oberiadennoù douaroniel all. ([http://mapping.referata.com/wiki/Examples Diskouezadenn])",
	'right-geocode' => 'Geokod',
	'maps_map' => 'Kartenn',
	'maps-loading-map' => 'O kargañ ar gartenn...',
	'maps-load-failed' => "N'eus ket bet gallet kargañ ar gartenn !",
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
	'maps-geodistance-description' => 'Jediñ an hed douaroniel etre daou bik, adalek ha war-zu ne vern pe furmad skoret.',
	'maps-coordinates-par-location' => "An daveennoù a fell deoc'h furmadiñ.",
	'maps-finddestination-par-location' => "Al lec'hiadur orin.",
	'maps-finddestination-par-bearing' => "An durc'hadur orin.",
	'maps-finddestination-par-distance' => 'An hed da vont drezañ.',
	'maps-geocode-par-location' => "Ar chomlec'h da c'heokodiñ.",
	'maps-geocode-par-mappingservice' => "Ar servij geokodañ a fell deoc'h ober gantañ. Sellit ouzh ar servijoù geokodañ hegerz.",
	'maps-geocode-par-format' => 'Furmad an daveennoù savet da-heul.',
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
	'maps_yahoomaps' => 'Yahoo! Kartennoù',
	'maps_click_to_activate' => 'Klikañ evit gweredekaat  ar gartenn',
	'maps_centred_on' => 'Kartenn kreizet war $1, $2.',
	'maps-googlemaps2-incompatbrowser' => "N'eo ket kenglotus ho merdeer gant Google Maps v2.",
	'maps_overlays' => 'Dreistlakadennoù',
	'maps_photos' => "Luc'hskeudennoù",
	'maps_videos' => 'Videoioù',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Kameraoù web',
	'maps-googlemaps2-par-kml' => 'Restroù KML da gargañ war ar gartenn.',
	'maps-googlemaps3-incompatbrowser' => "N'eo ket kenglotus ho merdeer gant Google Maps v3.",
	'maps-googlemaps3-par-zoomstyle' => 'Stil kontroll ar zoum.',
	'maps-googlemaps3-par-typestyle' => 'Stil kontroll ar seurt.',
	'maps-googlemaps3-par-autoinfowindows' => 'Digeriñ an holl brenestroù diouzhtu goude bezañ karget ar bajenn.',
	'maps-googlemaps3-par-kml' => 'Restroù KML da gargañ war ar gartenn.',
	'maps-osm-par-thumbs' => 'Diskouez ar munudoù',
	'maps-osm-par-photos' => 'Diskouez ar skeudennoù',
	'maps-yahoomaps-par-autozoom' => 'Aotren an dibunañ war-bouez rodig al logodenn.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'maps-desc' => 'Daje umetanje dinamičkih mapa u wiki stranice, geokodiranje adresa i druge geografske operacije.  ([http://mapping.referata.com/wiki/Examples primeri])',
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
	'right-geocode' => 'Geokódování',
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

/** Danish (Dansk)
 * @author Peter Alberti
 */
$messages['da'] = array(
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'Ø',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'V',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author DaSch
 * @author Imre
 * @author Kghbln
 * @author Purodha
 * @author The Evil IP address
 */
$messages['de'] = array(
	'maps-desc' => 'Ermöglicht die Einbindung dynamischer Karten in Wikiseiten, die Georeferenzierung von Adressen und andere geographische Operationen ([http://mapping.referata.com/wiki/Maps_examples Demonstrationsseite])',
	'right-geocode' => 'Georeferenzieren',
	'maps_map' => 'Karte',
	'maps-loading-map' => 'Karte wird geladen …',
	'maps-load-failed' => 'Die Karte konnte nicht geladen werden.',
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
	'maps-coordinates-description' => 'Parserhook zur Koordinatenformatierung aus und in alle unterstützte Formate.',
	'maps-displaymap-description' => 'Anzeige geographischer Karten ohne dabei jegliche im Wiki definierte Markierungen anzuzeigen.',
	'maps-displaypoint-description' => 'Anzeige geographischer Karten zusammen mit einer oder mehrerer im Wiki definierter Markierungen.',
	'maps-distance-description' => 'Konvertiere die Entfernung unter Verwendung einer der unterstützten Einheiten in ihr Äquivalent einer anderen unterstützen Einheit.',
	'maps-finddestination-description' => 'Ein Ziel unter Angabe des Ausgangspunkts (kann in jedwedem unterstützten Format angegeben sein), der Peilung sowie der Entfernung ermitteln.',
	'maps-geocode-description' => 'Aktiviert das Georeferenzieren von Adressen, also deren Umwandlung in Koordinaten. Mehrere Georeferenzierungsdienste werden unterstützt, was allerdings nicht mit den Kartografiediensten zu verwechseln ist.',
	'maps-geodistance-description' => 'Berechne die Entfernung zwischen zwei Punkten von einer der unterstützten Einheiten in ihr Äquivalent einer anderen unterstützten Einheit.',
	'maps-mapsdoc-description' => 'Zeigt eine Übersicht aller Parameter mitsamt deren Standardwerten einschließlich ihrer Beschreibung, die im Zusammenhang mit dem angegebenen Kartografiedienst genutzt werden können.',
	'maps-mapsdoc-par-service' => 'Der Kartografiedienst zu dessen Parametern die Dokumentation angezeigt werden soll.',
	'maps-mapsdoc-par-language' => 'Die Sprache, in der die Dokumentation angezeigt werden soll. Sofern keine Übersetzung verfügbar ist, wird stattdessen Englisch verwendet werden.',
	'maps-coordinates-par-location' => 'Die zu formatierenden Koordinaten.',
	'maps-coordinates-par-format' => 'Das Zielformat der Koordinaten.',
	'maps-coordinates-par-directional' => 'Gibt an, ob die Koordinaten eine Richtungsangabe haben sollen oder nicht.',
	'maps-distance-par-distance' => 'Die Entfernung zum konvertieren dieser Einheit in ihr Äquivalent einer angegebenen Einheit.',
	'maps-distance-par-decimals' => 'Die bei der Ergebnisausgabe zu verwendende Höchstzahl an Nachkommastellen.',
	'maps-distance-par-unit' => 'Die Ausgabeeinheit für die Entfernung.',
	'maps-finddestination-par-location' => 'Der Ausgangspunkt.',
	'maps-finddestination-par-bearing' => 'Die Ausgangspeilung.',
	'maps-finddestination-par-distance' => 'Die Reiseentfernung.',
	'maps-finddestination-par-format' => 'Das Ausgabeformat für das Ziel.',
	'maps-finddestination-par-directional' => 'Gibt an, ob das Ausgabeformat des Ziels eine Richtungsangabe haben soll oder nicht.',
	'maps-finddestination-par-allowcoordinates' => 'Gibt an, ob die Angabe von Koordinaten zulässig ist. Sofern deaktiviert, ist lediglich die Angabe von Adressen möglich.',
	'maps-finddestination-par-geoservice' => 'Der Kartografiedienst der, für den Fall dass es sich um eine Adresse handelt, zum Georeferenzieren des Werts verwendet werden soll.',
	'maps-finddestination-par-mappingservice' => 'Parameter mit denen der Kartografiedienst angegeben werden kann, der zusammen mit dieser Funktion genutzt wird.
Dadurch können die Standardwerte der Funktion durch die für den Kartografiedienst optimalen überschrieben werden.
(Beispiel: Im Fall von Google Maps wird dann der Google Geocoder genutzt.)',
	'maps-geocode-par-location' => 'Die Adresse, die geokodiert werden soll.',
	'maps-geocode-par-mappingservice' => 'Der Kartografiedienst der genutzt werden soll.',
	'maps-geocode-par-geoservice' => 'Dieser Parameter ermöglicht es, einen bestimmten Kartografiedienst für Georeferenzierungsanfragen anzugeben.
Jeder Kartografiedienst kann über eigenständige Standardwerte für die Georeferenzierung verfügen.
Diese Einstellung hat rechtliche Gründe, da man bspw. den Google Georeferenzierungsdienst nur zusammen mit Google Maps nutzen kann.
Diesen Parameter anstatt dem zum Georeferenzierungsdienst einzustellen, verhindert eine unzulässige Kombination bei der Nutzung der Dienste.',
	'maps-geocode-par-allowcoordinates' => 'Ermöglicht die Deaktivierung der Unterstützung von Koordinaten. Entweder Ja oder Nein angeben.
Sofern Nein angegeben wurde, werden alle Werte geokodiert, sogar gültige Koordinaten.',
	'maps-geocode-par-format' => 'Das Ausgabeformat für die Koordinaten.',
	'maps-geocode-par-directional' => 'Gibt an, ob die Koordinaten eine Richtungsangabe haben sollen oder nicht.',
	'maps-geodistance-par-location1' => 'Der erste von zwei Punkten zwischen denen die Entfernung berechnet werden soll.',
	'maps-geodistance-par-location2' => 'Der zweite von zwei Punkten zwischen denen die Entfernung berechnet werden soll.',
	'maps-geodistance-par-unit' => 'Die Ausgabeeinheit für die Entfernung.',
	'maps-geodistance-par-decimals' => 'Die bei der Ergebnisausgabe zu verwendende Höchstzahl an Nachkommastellen.',
	'maps-geodistance-par-mappingservice' => 'Der Kartografiedienst der für alle Adressen genutzt werden soll.',
	'maps-geodistance-par-geoservice' => 'Der Kartografiedienst mit dem dies genutzt wird.
Dies kann Auswirkungen auf die Standardwerte des Georeferenzierungsdiensts haben.',
	'maps-displaymap-par-mappingservice' => 'Ermöglicht die Festlegung des Kartografiediensts, der zur Generierung der Karte genutzt werden soll.',
	'maps-displaymap-par-coordinates' => 'Die Postion auf welche die Karte zunächst zentriert werden soll.',
	'maps-displaypoints-par-zoom' => 'Ermöglicht die Angabe des Detaillierungsgrades (Zoom) der Karte.
Sofern keiner angegeben wurde und mehrerer Markierungen auf der Karte vorhanden sind, wird der für deren gemeinsame Darstellung passende Zoom verwendet und nicht der Standardwert des Kartografiediensts.',
	'maps-displaypoints-par-mappingservice' => 'Ermöglicht die Festlegung des Kartografiediensts, der zur Generierung der Karte genutzt werden soll.',
	'maps-displaypoints-par-coordinates' => 'Einer oder mehrere Standorte, die auf der Karte angezeigt werden sollen. Sie werden mit einer Markierung versehen sein.',
	'maps-displaypoints-par-centre' => 'Ermöglicht die Angabe der Koordinaten, die für die Zentrierung der Karte verwendet werden soll.
Sowohl die direkte Angabe von Koordinaten wie auch die indirekte Angabe einer Adresse ist möglich.
Sofern nichts angegeben wurde, wird sich die Karte um die darzustellende Markierung, bzw. zwischen den darzustellenden Markierungen zentrieren.',
	'maps-displaypoints-par-title' => 'Ermöglicht das Festlegen des Texts, der in den Pop-up-Fenstern der Markierungen angezeigt werden soll, die über keinen eigenständigen Titel verfügen. Sofern dieser zusammen mit einer Beschriftung genutzt wird, wird der Titel in Fettschrift und unterstrichen angezeigt.',
	'maps-displaypoints-par-label' => 'Ermöglicht das Festlegen des Texts, der in den Pop-up-Fenstern der Markierungen angezeigt werden soll, die über keine eigenständige Beschriftung verfügen.',
	'maps-displaypoints-par-icon' => 'Ermöglicht die Festlegung des Symbols, das für alle Markierungen genutzt werden soll.',
	'validation-error-invalid-location' => 'Parameter $1 muss einem gültigen Standort entsprechen.',
	'validation-error-invalid-locations' => 'Parameter $1 muss einem oder mehreren gültigen Standorten entsprechen.',
	'validation-error-invalid-width' => 'Parameter $1 muss einer gültigen Breite entsprechen.',
	'validation-error-invalid-height' => 'Parameter $1 muss einer gültigen Höhe entsprechen.',
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
	'maps_geocoding_failed_for' => 'Die {{PLURAL:$2|folgende Adresse konnte|folgenden Adressen konnten}} nicht georeferenziert werden und {{PLURAL:$2|wurde|wurden}} auf der Karte nicht berücksichtigt:
$1',
	'maps_unrecognized_coords' => 'Folgende {{PLURAL:$2|Koordinate wurde|Koordinaten wurden}} nicht erkannt: $1.',
	'maps_unrecognized_coords_for' => 'Die {{PLURAL:$2|folgende Koordinate wurde|folgenden Koordinaten wurden}} nicht erkannt und {{PLURAL:$2|wurde|wurden}} auf der Karte nicht berücksichtigt:
$1',
	'maps_map_cannot_be_displayed' => 'Diese Karte kann nicht angezeigt werden.',
	'maps-geocoder-not-available' => 'Die Funktion zum Georeferenzierung von Karten ist nicht verfügbar. Der Standort kann nicht georeferenziert werden.',
	'maps_click_to_activate' => 'Klicken, um die Karte zu aktivieren.',
	'maps_centred_on' => 'Karte ist auf $1, $2 zentriert.',
	'maps-par-resizable' => 'Macht die Karte durch Ziehen von der unteren rechten Ecke größenveränderbar.',
	'maps-par-geoservice' => 'Der für Umwandlung von Adressen in Koordinaten zu verwendende Georeferenzierungsdienst.',
	'maps-par-zoom' => 'Die Zoomstufe für die Karte. Karten mit Kennzeichnungen werden standardmäßig auf die Stufe gezoomt in der diese noch alle gemeinsam angezeigt werden können.',
	'maps-par-width' => 'Ermöglicht die Einstellung der Kartenbreite. Standardmäßig werden Pixel (px) als Einheit angenommen. Jedoch kann auch eine der folgenden Einheiten angegeben werden: px, ex, em und %.',
	'maps-par-height' => 'Ermöglicht die Einstellung der Kartenhöhe. Standardmäßig werden Pixel (px) als Einheit angenommen. Jedoch kann auch eine der folgenden Einheiten angegeben werden: px, ex, em und %.',
	'maps-googlemaps2-incompatbrowser' => 'Der Browser ist nicht mit Google Maps v2 kompatibel.',
	'maps_overlays' => 'Einblendungen',
	'maps_photos' => 'Fotos',
	'maps_videos' => 'Videos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcams',
	'maps-googlemaps2-par-type' => 'Die zunächst anzuzeigende Kartenart.',
	'maps-googlemaps2-par-types' => 'Die Kartenarten, die über die Steuerung zu den Kartenarten verfügbar gemacht werden sollen.',
	'maps-googlemaps2-par-controls' => 'Die auf der Karte anzuzeigenden Steuerelemente.',
	'maps-googlemaps2-par-autozoom' => 'Den Bildlauf mithilfe des Mausrads aktivieren.',
	'maps-googlemaps2-par-kml' => 'Die auf die Karte zu ladenden KML-Dateien.',
	'maps-googlemaps2-par-overlays' => 'Die Überlagerungen, die von den Benutzern aktiviert werden können.',
	'maps-googlemaps3-incompatbrowser' => 'Der Browser ist nicht mit Google Maps v3 kompatibel.',
	'maps-googlemaps3-par-type' => 'Die zunächst anzuzeigende Kartenart.',
	'maps-googlemaps3-par-types' => 'Die Kartenarten, die über die Steuerung zu den Kartenarten verfügbar gemacht werden sollen.',
	'maps-googlemaps3-par-layers' => 'Die auf die Karte zu ladenden Sonderebenen.',
	'maps-googlemaps3-par-controls' => 'Die auf der Karte anzuzeigenden Steuerelemente.',
	'maps-googlemaps3-par-zoomstyle' => 'Der Stil der Zoomsteuerung.',
	'maps-googlemaps3-par-typestyle' => 'Der Stil der Steuerung zu den Kartenarten.',
	'maps-googlemaps3-par-autoinfowindows' => 'Alle Informationsfenster nach dem Laden der Seite automatisch öffnen.',
	'maps-googlemaps3-par-kml' => 'Die auf die Karte zu ladenden KML-Dateien.',
	'maps-googlemaps3-par-gkml' => 'Von Google gehostete KML-Dateien die auf die Karte geladen werden sollen.',
	'maps-googlemaps3-par-fusiontables' => 'Die Kennungen von Google Fusion Tables, die auf die Karte geladen werden sollen.',
	'maps-googlemaps3-par-tilt' => 'Neigung der Karte bei der Verwendung von Google Maps.',
	'maps-googlemaps3-par-kmlrezoom' => 'Die Karte erneut zoomen, nachdem die KML-Ebenen geladen wurden.',
	'maps-openlayers-par-controls' => 'Die auf der Karte anzuzeigenden Steuerelemente.',
	'maps-openlayers-par-layers' => 'Die Ebenen, die über die Ebenenauswahl verfügbar sein sollen. Die erste Ebene wird während des Ladens der Karten angezeigt.',
	'maps-osm-par-thumbs' => 'Miniaturansichten anzeigen',
	'maps-osm-par-photos' => 'Fotografien anzeigen',
	'maps-yahoomaps-par-type' => 'Die zunächst anzuzeigende Kartenart.',
	'maps-yahoomaps-par-types' => 'Die Kartenarten, die über die Steuerung zu den Kartenarten verfügbar gemacht werden sollen.',
	'maps-yahoomaps-par-controls' => 'Die auf der Karte anzuzeigenden Steuerelemente.',
	'maps-yahoomaps-par-autozoom' => 'Den Bildlauf mithilfe des Mausrads aktivieren.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'maps-desc' => 'Zmóžnijo zasajźowanje dynamiskich kórtow do wikibokow, geokoděrowanje adresow a druge geografiske akcije. ([http://mapping.referata.com/wiki/Examples pśikłady])',
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
	'maps-coordinates-par-location' => 'Koordinaty, kótarež coš formatěrowaś.',
	'maps-coordinates-par-format' => 'Celowy format za koordinaty.',
	'maps-finddestination-par-location' => 'Wuchadnišćo.',
	'maps-finddestination-par-format' => 'Wudawański format za cel.',
	'maps-geocode-par-location' => 'Adresa, kótaruž coš geokoděrowaś.',
	'maps-geocode-par-format' => 'Wudawański format za koordinaty.',
	'maps-geodistance-par-mappingservice' => 'Geokoděrowańska słužba, kótaraž ma se za geokoděrowanje adresow wužywaś.',
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
	'maps-desc' => 'Provides the ability to display coordinate data in maps, and geocode addresses ([http://mapping.referata.com/wiki/Maps_examples demo]).
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
	'maps-desc' => 'Habilita inserción de mapas dinámicos en página wiki, geocodificación de direcciones y otras operaciones geográficas. ([http://mapping.referata.com/wiki/Examples demos])',
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

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'maps_map' => 'نقشه',
	'maps-abb-north' => 'شمال',
	'maps-abb-east' => 'شرق',
	'maps-abb-south' => 'جنوب',
	'maps-abb-west' => 'غرب',
	'maps-latitude' => 'عرض جغرافیایی:',
	'maps-longitude' => 'طول جغرافیایی:',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'maps-desc' => 'Mahdollistaa koordinaattitiedon esittämisen karttoina ja osoitteiden geokoodauksen ([http://mapping.referata.com/wiki/Maps_examples demo]).
Käytettävissä olevat karttapalvelut: $1',
	'maps_map' => 'Kartta',
	'maps-loading-map' => 'Ladataan karttaa...',
	'maps-distance-par-unit' => 'Etäisyyden näyttämiseen käytettävä yksikkö.',
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
 * @author Brunoperel
 * @author Crochet.david
 * @author Gomoko
 * @author Hashar
 * @author IAlex
 * @author Jean-Frédéric
 * @author McDutchie
 * @author Od1n
 * @author Peter17
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Verdy p
 */
$messages['fr'] = array(
	'maps-desc' => "Permet d’afficher des cartes dynamiques dans les pages du wiki, des adresses géocodées et d'autres opérations géographiques. ([http://mapping.referata.com/wiki/Examples démonstration])",
	'right-geocode' => 'Géocode',
	'maps_map' => 'Carte',
	'maps-loading-map' => 'Chargement de la carte...',
	'maps-load-failed' => 'Impossible de charger la carte !',
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
	'maps-coordinates-description' => "Crochet de l'analyseur pour formater les coordonnées, depuis et vers n'importe quel format supporté.",
	'maps-displaymap-description' => 'Affiche les cartes géographiques sans aucun marqueur wiki sur eux.',
	'maps-displaypoint-description' => 'Affiche les cartes géographiques avec un ou plusieurs marqueurs wiki sur eux.',
	'maps-distance-description' => "Convertit une distance d'une certaine unité prise en charge à son équivalent en utilisant une autre unité.",
	'maps-finddestination-description' => "Trouver une destination avec un point de départ donné (qui peuvent être dans n'importe lequel des formats supportés), une orientation initiale et une distance.",
	'maps-geocode-description' => "Permet le géocodage d'adresses, en d'autres termes, la transformation des positions humainement lisible en ensembles de coordonnées. Plusieurs services de géocodage sont pris en charge, qui ne doivent pas être confondu avec les services de cartographie.",
	'maps-geodistance-description' => "Calculer la distance géographique entre deux points, depuis et vers n'importe quel format pris en charge.",
	'maps-mapsdoc-description' => 'Affiche une table avec les paramètres pour un service de cartographie spécifié, avec leurs valeurs par défaut et leur description.',
	'maps-mapsdoc-par-service' => 'Le service de cartographie pour afficher la document concernant les paramètres.',
	'maps-mapsdoc-par-language' => "La langue dans laquelle afficher la documentation. Si aucune traduction n'est disponible, l'anglais sera utilisé à la place.",
	'maps-coordinates-par-location' => 'Les coordonnées que vous souhaitez formater.',
	'maps-coordinates-par-format' => 'Le format cible pour les coordonnées.',
	'maps-coordinates-par-directional' => 'Indique si les coordonnées doivent être imprimées directionnellement ou non.',
	'maps-distance-par-distance' => 'La distance à convertir dans son équivalent avec une unité spécifiée.',
	'maps-distance-par-decimals' => 'Le nombre maximal de chiffres après la virgule à utiliser dans le résultat.',
	'maps-distance-par-unit' => "L'unité à utiliser pour afficher la distance.",
	'maps-finddestination-par-location' => "L'emplacement initial.",
	'maps-finddestination-par-bearing' => 'La direction initiale.',
	'maps-finddestination-par-distance' => 'La distance à parcourir.',
	'maps-finddestination-par-format' => 'Le format dans lequel afficher la destination.',
	'maps-finddestination-par-directional' => 'Indique si le format de destination doit être directionnel ou non.',
	'maps-finddestination-par-allowcoordinates' => 'Indique si les coordonnées doivent être autorisés. Si non, seul les adresses seront acceptées.',
	'maps-finddestination-par-geoservice' => "Le service de géocodage à utiliser pour géocoder la valeur au cas où il s'agirait d'une adresse.",
	'maps-finddestination-par-mappingservice' => 'Paramètre indiquant le service de cartographie à utiliser avec cette fonction.
Cela permettra aux cartes de remplacer la valeur par défaut du paramètre de service par celui qui est optimal pour le service de cartographie.
(Exemple : Dans le cas de Google Maps, le géocodage Google sera utilisé.)',
	'maps-geocode-par-location' => "L'adresse que vous souhaitez géocoder.",
	'maps-geocode-par-mappingservice' => 'Le service de géocodage que vous souhaitez utiliser. Consultez les services de géocodage disponibles.',
	'maps-geocode-par-geoservice' => "Ce paramètre vous permet d'indiquer que vous utilisez cette demande de géocodage en combinaison avec un service de cartographie spécifique. 
Chaque service de cartographie peut écraser la valeur par défaut pour le service de géocodage.
Cette démarche est liée à des raisons juridiques, puisque vous ne pouvez pas utiliser le service de géocodage de Google, sauf avec Google Maps.
Indiquer ce paramètre et non le paramètre pour le service veillera à ce que vous n'utilisiez pas une combinaison non valide.",
	'maps-geocode-par-allowcoordinates' => "Permet de désactiver le support pour les coordonnées dans cette fonction. Doit être soit oui ou non.
Si cette valeur est « non », chacune des valeurs sera géocodée, même s'il s'agit de coordonnées valides.",
	'maps-geocode-par-format' => 'Le format des coordonnées qui en résultent.',
	'maps-geocode-par-directional' => 'Indique si les coordonnées doivent être imprimées directionnellement ou non.',
	'maps-geodistance-par-location1' => 'Le premier point dans le jeu pour à utiliser pour calculer la distance.',
	'maps-geodistance-par-location2' => 'Le deuxième point dans le jeu pour à utiliser pour calculer la distance.',
	'maps-geodistance-par-unit' => "L'unité à utiliser pour afficher la distance.",
	'maps-geodistance-par-decimals' => 'Le nombre maximal de chiffres après la virgule à utiliser dans le résultat.',
	'maps-geodistance-par-mappingservice' => "Le service de géocodage à utiliser pour géocoder n'importe quelle adresse.",
	'maps-geodistance-par-geoservice' => 'Le service de cartographie à utiliser conjointement.
Cela peut affecter la valeur par défaut du service de géocodage.',
	'maps-displaymap-par-mappingservice' => 'Permet de définir le service de cartographie qui sera utilisé pour générer la carte.',
	'maps-displaymap-par-coordinates' => "L'emplacement sur lequel la carte sera initialement centrée.",
	'maps-displaypoints-par-zoom' => "Permet de définir le niveau de zoom de la carte.
Lorsqu'il n'est pas fourni et que plusieurs marqueurs sont présents sur la carte, le meilleur zoom sera pris, et non pas la valeur par défaut configurable.",
	'maps-displaypoints-par-mappingservice' => 'Permet de définir le service de cartographie qui sera utilisé pour générer la carte.',
	'maps-displaypoints-par-coordinates' => 'Un ou plusieurs emplacements à afficher sur la carte. Ils seront indiqués avec un marqueur.',
	'maps-displaypoints-par-centre' => "Permet de définir les coordonnées du centre de la carte pour display_point(s).
Accepte les adresses et les coordonnées.!
Lorsque cette propriété n'est pas fournie, la carte se recentre sur le marqueur fourni, ou entre les marqueurs fournis.",
	'maps-displaypoints-par-title' => "Permet de définir le texte qui sera affiché dans les pop-ups de tous les marqueurs qui ne disposent pas d'un titre spécifique.
Lorsqu'il est utilisé avec le label, le titre sera en gras et souligné.",
	'maps-displaypoints-par-label' => "Permet de définir le texte qui sera affiché dans les fenêtres surgissantes de tous les marqueurs qui n'ont pas une étiquette spécifique.",
	'maps-displaypoints-par-icon' => "Permet de définir l'icône utilisée pour tous les marqueurs.",
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
	'maps-invalid-coordinates' => "La valeur $1 n'a pas été reconnue comme un ensemble de coordonnées valide.",
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
	'maps-par-resizable' => 'Rendre la carte redimensionnable en faisant glisser son coin inférieur droit.',
	'maps-par-geoservice' => 'Le service de géocodage à utiliser pour effectuer les traductions entre les adresses et les coordonnées.',
	'maps-par-zoom' => 'Le niveau de zoom de la carte. Pour les cartes avec des marqueurs la valeur par défaut le plus grand zoom qui montre encore tous les marqueurs.',
	'maps-par-width' => 'Permet de définir la largeur de la carte. Par défaut les pixels seront considérés comme unité, mais vous pouvez spécifier explicitement une de ces unités : px, ex, em, %.',
	'maps-par-height' => 'Permet de définir la hauteur de la carte. Par défaut les pixels seront considérés comme unité, mais vous pouvez spécifier explicitement une de ces unités : px, ex, em, %.',
	'maps-googlemaps2-incompatbrowser' => "Votre navigateur n'est pas compatible avec Google Maps v2.",
	'maps_overlays' => 'Superpositions',
	'maps_photos' => 'Photos',
	'maps_videos' => 'Vidéos',
	'maps_wikipedia' => 'Wikipédia',
	'maps_webcams' => 'Webcams',
	'maps-googlemaps2-par-type' => 'Le type de carte à afficher initialement.',
	'maps-googlemaps2-par-types' => 'Les types de carte qui seront disponibles via le contrôle de type.',
	'maps-googlemaps2-par-controls' => 'Les contrôles à placer sur la carte.',
	'maps-googlemaps2-par-autozoom' => "Activer le défilement à l'aide de la molette de la souris.",
	'maps-googlemaps2-par-kml' => 'Fichiers KML à charger sur la carte.',
	'maps-googlemaps2-par-overlays' => "Superpositions que l'utilisateur peut activer.",
	'maps-googlemaps3-incompatbrowser' => "Votre navigateur n'est pas compatible avec Google Maps v3.",
	'maps-googlemaps3-par-type' => 'Le type de carte à afficher initialement.',
	'maps-googlemaps3-par-types' => 'Les types de carte qui seront disponibles via le contrôle de type.',
	'maps-googlemaps3-par-layers' => 'Couches spéciales à charger sur la carte.',
	'maps-googlemaps3-par-controls' => 'Les contrôles à placer sur la carte.',
	'maps-googlemaps3-par-zoomstyle' => 'Style du contrôle de zoom.',
	'maps-googlemaps3-par-typestyle' => 'Style du contrôle de type.',
	'maps-googlemaps3-par-autoinfowindows' => "Ouvrir automatiquement toutes les fenêtres d'information après le chargement de la page.",
	'maps-googlemaps3-par-kml' => 'Fichiers KML à charger sur la carte.',
	'maps-googlemaps3-par-gkml' => 'Les fichiers KML hébergés par Google à charger sur la carte.',
	'maps-googlemaps3-par-fusiontables' => 'ID des tables de Google Fusion qui devrait être chargées sur la carte.',
	'maps-googlemaps3-par-tilt' => "Inclinaison de la carte lors de l'utilisation de Google Maps.",
	'maps-googlemaps3-par-kmlrezoom' => 'Zoomer de nouveau la carte une fois que les couches KML ont été chargées',
	'maps-openlayers-par-controls' => 'Les contrôles à placer sur la carte.',
	'maps-openlayers-par-layers' => 'Les couches qui seront disponibles dans le sélecteur de couche. La première couche sera affichée lors du chargement de la carte.',
	'maps-osm-par-thumbs' => 'Afficher des miniatures',
	'maps-osm-par-photos' => 'Afficher des photos',
	'maps-yahoomaps-par-type' => 'Le type de carte à afficher initialement.',
	'maps-yahoomaps-par-types' => 'Les types de carte qui seront disponibles via le contrôle de type.',
	'maps-yahoomaps-par-controls' => 'Les contrôles à placer sur la carte.',
	'maps-yahoomaps-par-autozoom' => "Activer le défilement à l'aide de la molette de la souris.",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'right-geocode' => 'G·eocode',
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'Chargement de la mapa...',
	'maps-load-failed' => 'Empossiblo de chargiér la mapa !',
	'maps-markers' => 'Marcors',
	'maps-others' => 'ôtros',
	'maps-ns-layer' => 'Cuche',
	'maps-ns-layer-talk' => 'Discussion cuche',
	'maps-layer-property' => 'Propriètât',
	'maps-layer-value' => 'Valor',
	'maps-layer-errors' => 'Èrrors',
	'validation-error-invalid-layer' => 'Lo paramètre $1 dêt étre una cuche valida.',
	'validation-error-invalid-layers' => 'Lo paramètre $1 dêt étre yona ou ben un mouél de cuches valides.',
	'maps-layer-of-type' => 'Cuche de tipo $1',
	'maps-finddestination-par-location' => 'Lo premiér emplacement.',
	'maps-finddestination-par-bearing' => 'La premiére dirèccion.',
	'maps-finddestination-par-distance' => 'La distance a parcorir.',
	'maps-abb-north' => 'B',
	'maps-abb-east' => 'L',
	'maps-abb-south' => 'M',
	'maps-abb-west' => 'P',
	'maps-latitude' => 'Latituda :',
	'maps-longitude' => 'Longituda :',
	'maps_click_to_activate' => 'Clicâd por activar la mapa',
	'maps_centred_on' => 'Mapa centrâ dessus $1, $2.',
	'maps_overlays' => 'Supèrposicions',
	'maps_photos' => 'Fotôs',
	'maps_videos' => 'Vidèôs',
	'maps_wikipedia' => 'Vouiquipèdia',
	'maps_webcams' => 'Camères vouèbe',
	'maps-osm-par-thumbs' => 'Fâre vêre des figures',
	'maps-osm-par-photos' => 'Fâre vêre des fotôs',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'maps-desc' => 'Al furnìs la possibilitât di mostrâ i dâts de coordinadis e lis direzions geocodificadis intune mape ([http://mapping.referata.com/wiki/Maps_examples demo]).
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
	'maps-desc' => 'Proporciona a capacidade de mostrar mapas dinámicos, enderezos xeocodificados e outras operacións xeográficas ([http://mapping.referata.com/wiki/Examples demostración])',
	'right-geocode' => 'Xeocodificar',
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'Cargando o mapa...',
	'maps-load-failed' => 'Non se puido cargar o mapa!',
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
	'maps-coordinates-description' => 'Asociador do analizador para dar formato ás coordenadas, desde e cara a calquera formato soportado.',
	'maps-displaymap-description' => 'Mostrar os mapas xeográficos sen marcadores wiki sobre eles.',
	'maps-displaypoint-description' => 'Mostrar os mapas xeográficos con, polo menos, un ou máis marcadores wiki sobre eles.',
	'maps-distance-description' => 'Converter unha distancia nunha certa unidade soportada na súa equivalente noutra unidade.',
	'maps-finddestination-description' => 'Atopar un destino a partir dun punto de partida (que pode ser en calquera dos formatos soportados), unha orientación inicial e unha distancia.',
	'maps-geocode-description' => 'Permite a xeocodificación de enderezos; noutras palabras, transformar as localizacións lexibles por humanos en conxuntos de coordenadas. Hai soporte para diversos servizos de xeocodificación, que non se deben confundir cos servizos de cartografía.',
	'maps-geodistance-description' => 'Calcular a distancia xeográfica entre dous puntos, desde e cara a calquera dos formatos soportados.',
	'maps-mapsdoc-description' => 'Mostar unha táboa cos parámetros para un servizo de mapas específico, cos seus valores por defecto e as súas descricións.',
	'maps-mapsdoc-par-service' => 'O servizo de cartografía do que mostrar a documentación do parámetro.',
	'maps-mapsdoc-par-language' => 'A lingua na que mostrar a documentación. Se non houbera tradución dispoñible, mostrarase a versión en inglés.',
	'maps-coordinates-par-location' => 'As coordenadas ás que quere dar formato.',
	'maps-coordinates-par-format' => 'O formato de destino para as coordenadas.',
	'maps-coordinates-par-directional' => 'Indica se as coordenadas deben producirse con formato direccional ou non.',
	'maps-distance-par-distance' => 'A distancia a converter na súa equivalente nunha unidade especificada.',
	'maps-distance-par-decimals' => 'O número máximo de díxitos fraccionarios a utilizar no valor resultante.',
	'maps-distance-par-unit' => 'A unidade na que mostrar a distancia.',
	'maps-finddestination-par-location' => 'A localización inicial.',
	'maps-finddestination-par-bearing' => 'A dirección inicial.',
	'maps-finddestination-par-distance' => 'A distancia a percorrer.',
	'maps-finddestination-par-format' => 'O formato no que mostrar o destino.',
	'maps-finddestination-par-directional' => 'Indica se o formato de destino debe producirse con formato direccional ou non.',
	'maps-finddestination-par-allowcoordinates' => 'Indica se se deben permitir as coordenadas. Se está definido como "non", soamente se aceptarán enderezos.',
	'maps-finddestination-par-geoservice' => 'O servizo de xeocodificación a usar para xeocodificar o valor no caso de que sexa un enderezo.',
	'maps-finddestination-par-mappingservice' => 'Parámetro para indicar o servizo de cartografía a usar con esta función.
Isto permite que os mapas substitúan o valor por defecto do parámetro de servizo por aquel que é óptimo para o servizo de cartografía.
(Exemplo: No caso do Google Maps empregarase o xeocodificador do Google.)',
	'maps-geocode-par-location' => 'O enderezo que quere xeocodificar.',
	'maps-geocode-par-mappingservice' => 'O servizo de xeocodificación que quere usar. Olle os servizos de xeocodificación dispoñibles.',
	'maps-geocode-par-geoservice' => 'Este parámetro permite indicar que está a usar esta petición de xeocodificación en combinación cun servizo de cartografía específico.
Para cada servizo de cartografía é posible substituír o valor por defecto para o servizo de xeocodificación.
Isto ten consideracións xurídicas xa que non pode utilizar o servizo de xeocodificación do Google máis ca co Google Maps.
Definir este parámetro e non o parámetro para o servizo garantirá que non estea a empregar unha combinación inválida.',
	'maps-geocode-par-allowcoordinates' => 'Permite desactivar o soporte para as coordenadas nesta función. Debe ser si ou non.
Cando sexa "non", todos os valores serán xeocodificados, mesmo se son coordenadas válidas.',
	'maps-geocode-par-format' => 'O formato das coordenadas resultantes.',
	'maps-geocode-par-directional' => 'Indica se as coordenadas deben producirse con formato direccional ou non.',
	'maps-geodistance-par-location1' => 'O primeiro punto do conxunto para calcular a distancia.',
	'maps-geodistance-par-location2' => 'O segundo punto do conxunto para calcular a distancia.',
	'maps-geodistance-par-unit' => 'A unidade na que mostrar a distancia.',
	'maps-geodistance-par-decimals' => 'O número máximo de díxitos fraccionarios a utilizar no valor resultante.',
	'maps-geodistance-par-mappingservice' => 'O servizo de xeocodificación a usar para xeocodificar todos os enderezos.',
	'maps-geodistance-par-geoservice' => 'O servizo de cartografía a usar en conxunto.
Isto pode afectar ao valor por defecto do servizo de xeocodificación.',
	'maps-displaymap-par-mappingservice' => 'Permite configurar o servizo de mapas que se empregará para xerar o mapa.',
	'maps-displaymap-par-coordinates' => 'A localización do mapa que aparecerá inicialmente.',
	'maps-displaypoints-par-zoom' => 'Permite configurar o nivel de zoom do mapa.
Se non se proporciona e hai presentes no mapa múltiples marcadores, tomarase o mellor axuste de zoom e non o valor configurado por defecto.',
	'maps-displaypoints-par-mappingservice' => 'Permite configurar o servizo de mapas que se empregará para xerar o mapa.',
	'maps-displaypoints-par-coordinates' => 'Unha ou máis localización a mostrar no mapa. Indicaranse cun marcador.',
	'maps-displaypoints-par-centre' => 'Permite configurar as coordenadas do centro do mapa para display_point(s).
Admite tanto enderezos como coordenadas.
Cando non se indica esa propiedade, o mapa centrarase no marcador proporcionado ou entre os marcadores proporcionados.',
	'maps-displaypoints-par-title' => 'Permite configurar o texto que aparecerá na ventás emerxentes de todos os marcadores que non teñen un título específico.
Ao empregalo conxuntamente coa etiqueta, o título aparecerá en negra e suliñado.',
	'maps-displaypoints-par-label' => 'Permite configurar o texto que aparecerá na ventás emerxentes de todos os marcadores que non teñen unha etiqueta específica.',
	'maps-displaypoints-par-icon' => 'Permite configurar a icona usada para todos os marcadores.',
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
	'maps-par-resizable' => 'Fai que se poidan alterar as dimensións do mapa, arrastrando o canto inferior dereito.',
	'maps-par-geoservice' => 'O servizo de xeocodificación a usar para facer traducións entre os enderezos e as coordenadas.',
	'maps-par-zoom' => 'O nivel de zoom no mapa. Para os mapas con marcadores o valor por defecto usará o nivel máximo de zoom que abranga todos os marcadores.',
	'maps-par-width' => 'Permite definir o largo do mapa. Por defecto, os píxeles asúmense como unidade, pero tamén pode especificar unha destas unidades: px, ex, em, %.',
	'maps-par-height' => 'Permite definir a altura do mapa. Por defecto, os píxeles asúmense como unidade, pero tamén pode especificar unha destas unidades: px, ex, em, %.',
	'maps-googlemaps2-incompatbrowser' => 'O seu navegador é compatible co Google Maps v2.',
	'maps_overlays' => 'Superposicións',
	'maps_photos' => 'Fotos',
	'maps_videos' => 'Vídeos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Cámaras web',
	'maps-googlemaps2-par-type' => 'O tipo de mapa que mostrar inicialmente.',
	'maps-googlemaps2-par-types' => 'Os tipos de mapas que estarán dispoñibles a través do control de tipos.',
	'maps-googlemaps2-par-controls' => 'Os controis que incluír no mapa.',
	'maps-googlemaps2-par-autozoom' => 'Activar o desprazamento coa axuda da roda do rato.',
	'maps-googlemaps2-par-kml' => 'Ficheiros KML que cargar no mapa.',
	'maps-googlemaps2-par-overlays' => 'As superposicións que o usuario pode activar.',
	'maps-googlemaps3-incompatbrowser' => 'O seu navegador é compatible co Google Maps v3.',
	'maps-googlemaps3-par-type' => 'O tipo de mapa que mostrar inicialmente.',
	'maps-googlemaps3-par-types' => 'Os tipos de mapas que estarán dispoñibles a través do control de tipos.',
	'maps-googlemaps3-par-layers' => 'As capas especiais que cargar no mapa.',
	'maps-googlemaps3-par-controls' => 'Os controis que incluír no mapa.',
	'maps-googlemaps3-par-zoomstyle' => 'O estilo do control do zoom.',
	'maps-googlemaps3-par-typestyle' => 'O estilo do control do tipo.',
	'maps-googlemaps3-par-autoinfowindows' => 'Abrir automaticamente todas as ventás de información tras a carga da páxina.',
	'maps-googlemaps3-par-kml' => 'Ficheiros KML que cargar no mapa.',
	'maps-googlemaps3-par-gkml' => 'Ficheiros KML aloxados polo Google que cargar no mapa.',
	'maps-googlemaps3-par-fusiontables' => 'Identificadores das táboas do Google Fusion que se deben cargar no mapa.',
	'maps-googlemaps3-par-tilt' => 'Inclinación do mapa ao empregar o Google Maps.',
	'maps-googlemaps3-par-kmlrezoom' => 'Axustar o nivel de zoom despois da carga das capas KML.',
	'maps-openlayers-par-controls' => 'Os controis que incluír no mapa.',
	'maps-openlayers-par-layers' => 'As capas que estarán dispoñibles no selector de capas. A primeira capa aparecerá cando o mapa acabe de cargar.',
	'maps-osm-par-thumbs' => 'Mostrar as miniaturas',
	'maps-osm-par-photos' => 'Mostrar as fotos',
	'maps-yahoomaps-par-type' => 'O tipo de mapa que mostrar inicialmente.',
	'maps-yahoomaps-par-types' => 'Os tipos de mapas que estarán dispoñibles a través do control de tipos.',
	'maps-yahoomaps-par-controls' => 'Os controis que incluír no mapa.',
	'maps-yahoomaps-par-autozoom' => 'Activar o desprazamento coa axuda da roda do rato.',
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
	'maps-desc' => 'Ergänzt d Megligkeit Koordinatedate in Charte un Geocodeadrässe aazzeige. Verfiegbari Chartedienscht: $1. [http://www.mediawiki.org/wiki/Extension:Maps Dokumäntation]. [http://mapping.referata.com/wiki/Maps_examples Demo]',
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
 * @author Amire80
 * @author Ex-Diktator
 * @author Rotemliss
 * @author YaronSh
 * @author Yonidebest
 */
$messages['he'] = array(
	'maps-desc' => 'הוספת האפשרות להטמעת מפות דינמיות אל תוך דפי ויקי, קידוד גאוגרפי של כתובות ופעולות גאוגרפיות אחרות.
([http://mapping.referata.com/wiki/Maps_examples הדגמות])',
	'right-geocode' => 'לעשות קידוד גאוגרפי',
	'maps_map' => 'מפה',
	'maps-loading-map' => 'המפה נטענת...',
	'maps-load-failed' => 'טעינת המפה לא הצליחה!',
	'maps-markers' => 'סמנים',
	'maps-others' => 'אחרים',
	'maps-ns-layer' => 'שכבה',
	'maps-ns-layer-talk' => 'שיחת שכבה',
	'maps-layer-property' => 'מאפיין',
	'maps-layer-value' => 'ערך',
	'maps-layer-errors' => 'שגיאות',
	'maps-error-invalid-layerdef' => 'הגדרת השכבה הזאת אינה תקינה.',
	'maps-error-invalid-layertype' => 'אין שכבות מסוג "$1". רק {{PLURAL:$3|הסוג הזה נתמך|הסוגים האלה נתמכים}}: $2.',
	'maps-error-no-layertype' => 'יש להקליד את סוג השכבה. {{PLURAL:$2|רק הסוג הזה נתמך|הסוגים הנתמכים}}: $1',
	'validation-error-invalid-layer' => 'הפרמטר $1 צריך להיות שכבה תקינה.',
	'validation-error-invalid-layers' => 'הפרמטר $1 צריך להיות שכבה תקינה אחת או יותר.',
	'maps-layer-of-type' => 'שכבה מסוג $1',
	'maps-layer-type-supported-by' => 'השכבה הזאת יכולה לעבוד רק עם {{PLURAL:$2|שירות המפות הבא|שירותי המפות הבאים}}: $1.',
	'maps-coordinates-description' => 'מילת הפעלה לעיצוב נקודות ציון, מכל תסדיר נתמך לכל תסדיר נתמך.',
	'maps-displaymap-description' => 'להציג מפות גאוגרפיות ללא שום סמנים מוגדרים בוויקי עליהן.',
	'maps-displaypoint-description' => 'להציג מפות גאוגרפיות עם סמן מוגדר בוויקי אחד או יותר עליהן.',
	'maps-distance-description' => 'להמיר את המרחק ביחידות נתמכות מסוימות לערך מתאים ביחידות אחרות.',
	'maps-finddestination-description' => 'למצוא את היעד בהינתן נקודת התחלה (שיכולה להיות בכל פורמט), הכיוון הראשוני והמרחק.',
	'maps-geocode-description' => 'מפעיל קידוד גאוגרפי של כתובות, במילים אחרות, הופך מיקומים עם שמות שאנשים יכולים לקרוא לערכות של נקודות ציון. יש תמיכה במספר שירותי קידוד גאוגרפי, ואין להתבלבל בינם לבין שירותי מיפוי.',
	'maps-geodistance-description' => 'לחשב את המרחק הגאוגרפי בין שתי נקודת, מכל תסדיר נתמך ולכל תסדיר נתמך.',
	'maps-mapsdoc-description' => 'להציג עם פרמטרים עבור שירות המיפוי שצוין יחד עם הערכים והתיאורים ההתחלתיים שלהם.',
	'maps-mapsdoc-par-service' => 'שירות המיפוי שעבורו יוצג תיעוד פרמטרים.',
	'maps-mapsdoc-par-language' => 'השפה שבה יוצג התיעוד. אם אין תרגום זמין, התיעוד יוצג באנגלית.',
	'maps-coordinates-par-location' => 'נקודות הציון שברצונך לעצב.',
	'maps-coordinates-par-format' => 'תסדיר היעד לנקודות הציון.',
	'maps-coordinates-par-directional' => 'מציין האם לפלוט את נקודות הציון באופן כיווני או לא.',
	'maps-distance-par-distance' => 'מרחק שיומר לערך המתאים ביחידות המבוקשות.',
	'maps-distance-par-decimals' => 'המספר המקסימלי של ספרות אחרי הנקודה בערך של התוצאה.',
	'maps-distance-par-unit' => 'באילו יחידות לפלוט את המרחק.',
	'maps-finddestination-par-location' => 'המיקום ההתחלתי.',
	'maps-finddestination-par-bearing' => 'הכיוון הראשוני.',
	'maps-finddestination-par-distance' => 'מרחק הנסיעה.',
	'maps-finddestination-par-format' => 'באיזה תסדיר לפלוט את היעד.',
	'maps-finddestination-par-directional' => 'האם תבנית היעד צריכה להיות כיוונית או לא.',
	'maps-finddestination-par-allowcoordinates' => 'האם לאפשר שימוש בנקודות ציון. אם לא, תתקבלנה רק כתובות.',
	'maps-finddestination-par-geoservice' => 'שירות קידוד גאוגרפי לקידוד הערך במקרה שזו כתובת.',
	'maps-finddestination-par-mappingservice' => 'פרמטר לציון שירות המפות שישמש עם הפונקציה הזאת.
זה יאפשר למפות לדרוס את הערך ההתחלתי של פרמטר השירות בערך הטוב ביותר לשירות המפות.
(דוגמה: במקרה של מפות גוגל, ישמש המקודד הגאוגרפי של גוגל.)',
	'maps-geocode-par-location' => 'הכתובת שאתם רוצים לעשות לה קידוד גאוגרפי.',
	'maps-geocode-par-mappingservice' => "שירות הקידוד הגאוגרפי שאתם רוצים להשתמש בו. ר' רשימת שירותי קידוד גאוגרפי.",
	'maps-geocode-par-geoservice' => 'הפרמטר הזה מאפשר לציין שאתם משתמשים בבקשת הקידוד הגאוגרפי הזאת בצירוף שירות מיפוי מסוים.
כל שירות מיפוי יכול לדרוס ערכי ברירת מחדל של שירות הקידוד הגאוגרפי.
זה קורה מסיבות משפטיות, מאחר וניתן להשתמש בשירות הקידוד הגאוגרפי של גוגל רק עם מפות גוגל.
הגדרה של הפרמטר הזה, אבל לא של מפרמט השירות, תבטיח שאתם לא משתמשים בצירוף לא תקין.',
	'maps-geocode-par-allowcoordinates' => 'מאפשר כיבוי של תמיכה בנקודות ציון בפונקציה הזאת. צריך להיות כן או לא.
אם הערך הוא לא, כל ערך צריך להיות מקודד גאוגרפית, גם נקודות ציון תקינות.',
	'maps-geocode-par-format' => 'תסדיר נקודות הציון הסופיות.',
	'maps-geocode-par-directional' => 'האם לפלוט את נקודות הציון באופן כיווני או לא.',
	'maps-geodistance-par-location1' => 'הנקודה הראשונה בקבוצה לחישוב מרחק.',
	'maps-geodistance-par-location2' => 'הנקודה השנייה בקבוצה לחישוב מרחק.',
	'maps-geodistance-par-unit' => 'באילו יחידות לפלוט את המרחק.',
	'maps-geodistance-par-decimals' => 'המספר המירבי של ספרות בשבר בתוצאה.',
	'maps-geodistance-par-mappingservice' => 'שירות הקידוד הגאוגרפי שיקודד כתובות כלשהן.',
	'maps-geodistance-par-geoservice' => 'שירות המיפוי שבו משתמשים בזה.
זה יכול להשפיע על ערך ברירת המחדל של שירות הקידוד הגאוגרפי.',
	'maps-displaymap-par-mappingservice' => 'לאפשר להגדיר שירות מיפוי שישמש ליצרת המפה.',
	'maps-displaymap-par-coordinates' => 'באיזה מיקום המפה תתמרכז בתחילה.',
	'maps-displaypoints-par-zoom' => 'מאפשר קביעת קמת התקריב של המפה.
כאשר נתון זה לא מסופק וסמנים שונים נמצאים על המפה, יילקח התקריב המתאים ביותר, לא ברירת המחדל הניתנת להגדרה.',
	'maps-displaypoints-par-mappingservice' => 'מאפשר קביעת שירות המיפוי שיחולל את המפה.',
	'maps-displaypoints-par-coordinates' => 'מיקום אחד או יותר להצגה על המפה. הם יסומנו על המפה בסמנים.',
	'maps-displaypoints-par-centre' => 'מאפשר קביעת נקודות ציון של מרכז המפה עבור מופעי display_point.
מקבל כתובות ונקודות ציון.
כאשר המאפיין הזה לא מצוין, המפה תמרכז את עצמה על הסמן שצוין או בין סמנים שצוינו.',
	'maps-displaypoints-par-title' => 'מאפשר קביעת טקסט שיוצג בחלונות קופצים על כל הסמנים שאין להם כותרת מוגדרת.
כאשר נעשה שימוש בזה יחד עם תווית, הכותרת תהיה בולטת ועם קו תחתי.',
	'maps-displaypoints-par-label' => 'מאפשר להציב מלל שיוצג בכל החלונות הקופצים של כל הסמנים שאין להם תווית מסוימת.',
	'maps-displaypoints-par-icon' => 'לאפשר להציב סמל לכל הסמנים.',
	'validation-error-invalid-location' => 'הערך $1 צריך להיות מיקום תקין.',
	'validation-error-invalid-locations' => 'הערך $1 צריך להיות מיקום תקין אחד או יותר.',
	'validation-error-invalid-width' => 'הערך $1 צריך להיות רוחב תקין.',
	'validation-error-invalid-height' => 'הערך $1 צריך להיות גובה תקין.',
	'validation-error-invalid-distance' => 'הערך $1 צריך להיות מרחק תקין.',
	'validation-error-invalid-distances' => 'הערך $1 צריך להיות מרחק תקין אחד או יותר.',
	'validation-error-invalid-image' => 'הערך $1 צריך להיות קובץ תמונה תקין.',
	'validation-error-invalid-images' => 'הערך $1 צריך להיות קובץ תמונה תקין אחד או יותר.',
	'validation-error-invalid-goverlay' => 'הערך $1 צריך להיות שכבת כיסוי תקינה.',
	'validation-error-invalid-goverlays' => 'הערך $1 צריך להיות שכבת כיסוי תקינה אחת או יותר.',
	'maps-abb-north' => 'צפ׳',
	'maps-abb-east' => 'מז׳',
	'maps-abb-south' => 'דר׳',
	'maps-abb-west' => 'מע׳',
	'maps-latitude' => 'קו רוחב:',
	'maps-longitude' => 'קו אורך:',
	'maps-invalid-coordinates' => 'הערך $1 לא זוהה כסדרת קואורדינטות תקינה.',
	'maps_coordinates_missing' => 'לא סופקו קואורדינטות למפה.',
	'maps_geocoding_failed' => 'לא ניתן לייצר geocode עבור {{PLURAL:$2|הכתובת הבאה|הכתובות הבאות}}: $1.
לא ניתן להציג את המפה.',
	'maps_geocoding_failed_for' => 'לא ניתן לייצר geocode עבור {{PLURAL:$2|הכתובת הבאה|הכתובות הבאות}}, ולכן {{PLURAL:$2|היא הושמטה|הן הושמטו}} מהמפה:
$1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|הקואורדינטה הבאה לא זוהתה|הקואורדינטות הבאות לא זוהו}}: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|נקודת הציון הבאה לא זוהתה והושמטה|נקודות הציון הבאות לא זוהו והושמטו}} מהמפה: $1',
	'maps_map_cannot_be_displayed' => 'לא ניתן להציג את המפה.',
	'maps-geocoder-not-available' => 'הקידוד הגאוגרפי של מפות אינו זמין. לא ניתן לקודד את המיקום שנבחר.',
	'maps_click_to_activate' => 'יש ללחוץ כדי להפעיל את המפה',
	'maps_centred_on' => 'המפה ממורכזת סביב $1,$2',
	'maps-par-resizable' => 'מאפשר שינוי גודל מפה באמצעות גרירת הפינה שלה.',
	'maps-par-geoservice' => 'באיזה שירות קידוד גאוגרפי להשתמש כדי לתרגם בין כתובות ונקודות ציון.',
	'maps-par-zoom' => 'רמת התקריב של המפה. למפות עם סמנים ברירת המחדל תהיה רמת תקריב גבוהה ביותר שמציגה את כל הסמנים.',
	'maps-par-width' => 'לאפשר הגדרת רוחב המפה. ברירת המחדל היא שהיחידה תהיה פיקסל, אבל אפשר להגדיר במפורש אחת מהיחידות הבאות: px, ex, em, %.',
	'maps-par-height' => 'לאפשר הגדרת גובה המפה. ברירת המחדל היא שהיחידה תהיה פיקסל, אבל אפשר להגדיר במפורש אחת מהיחידות הבאות: px, ex, em, %.',
	'maps-googlemaps2-incompatbrowser' => 'הדפדפן שלך לא תומך בגוגל מפות גרסה 2.',
	'maps_overlays' => 'שכבות כיסוי',
	'maps_photos' => 'תמונות',
	'maps_videos' => 'סרטוני וידאו',
	'maps_wikipedia' => 'ויקיפדיה',
	'maps_webcams' => 'מצלמות אינטרנט',
	'maps-googlemaps2-par-type' => 'איזה סוג מפה להציג תחילה.',
	'maps-googlemaps2-par-types' => 'סוגי המפות שיהיו זמינים דרך בקר הסוג.',
	'maps-googlemaps2-par-controls' => 'אילו בקרים להציב על המפה.',
	'maps-googlemaps2-par-autozoom' => 'להפעיל גלילה באמצעות גלגל העכבר.',
	'maps-googlemaps2-par-kml' => 'אילו קבצי KML לטעון אל המפה.',
	'maps-googlemaps2-par-overlays' => 'אילו שכבות כיסוי המשתמש יכול להפעיל.',
	'maps-googlemaps3-incompatbrowser' => 'הדפדפן שלך לא תומך בגוגל מפות גרסה 3.',
	'maps-googlemaps3-par-type' => 'סוג המפה שיוצג תחילה.',
	'maps-googlemaps3-par-types' => 'סוגי המפה שיהיו זמינים דרך בקר הסוג.',
	'maps-googlemaps3-par-layers' => 'שכבות מיוחדות שייטענו אל המפה.',
	'maps-googlemaps3-par-controls' => 'אילו בקרים להציב על המפה.',
	'maps-googlemaps3-par-zoomstyle' => 'סגנון בקר התקריב.',
	'maps-googlemaps3-par-typestyle' => 'סגנון בקר הסוג.',
	'maps-googlemaps3-par-autoinfowindows' => 'לפתוח את כל חלונות המידע אחרי שהדף נטען.',
	'maps-googlemaps3-par-kml' => 'קבצי KML שייטענו אל המפה.',
	'maps-googlemaps3-par-gkml' => 'קבצי KML שמתארחים בגוגל וייטענו אל המפה.',
	'maps-googlemaps3-par-fusiontables' => 'מזהים של Google Fusion Tables שייטענו אל המפה.',
	'maps-googlemaps3-par-tilt' => 'רכינה עבור המפה כאשר נעשה שימוש במפות גוגל.',
	'maps-googlemaps3-par-kmlrezoom' => 'לקרב מחדש את המפה אחרי ששכבות KML נטענו.',
	'maps-openlayers-par-controls' => 'אילו בקרים להציב על המפה.',
	'maps-openlayers-par-layers' => 'אילו שכבות יהיו זמינות בבוחר השכבות. השכבה הראשונה תוצג כאשר המפה נטענת.',
	'maps-osm-par-thumbs' => 'להציג תמונות ממוזערות.',
	'maps-osm-par-photos' => 'להציג צילומים',
	'maps-yahoomaps-par-type' => 'איזה סוג מפה להציג תחילה.',
	'maps-yahoomaps-par-types' => 'סוגי המפה שיהיו זמינים דרך בקר הסוג.',
	'maps-yahoomaps-par-controls' => 'אילו בקרים להציב על המפה.',
	'maps-yahoomaps-par-autozoom' => 'להפעיל גלילה באמצעות גלגל העכבר.',
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
	'maps-desc' => 'Pruža mogućnost prikaza podataka o koordinatama na kartama, te geokodiranih adresa ([http://mapping.referata.com/wiki/Maps_examples demo]). Dostupne usluge kartiranja: $1',
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
	'maps-desc' => 'Zmóžnja zasadźenje dynamiskich kartow do wikistronow, geokodowanje adresow a druhe geografiske podawki ([http://mapping.referata.com/wiki/Examples přikłady])',
	'maps_map' => 'Karta',
	'maps-loading-map' => 'Karta so začituje...',
	'maps-load-failed' => 'Karta njeda so začitać!',
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
	'maps-displaymap-description' => 'Geografiske karty bjez we wikiju definowanych markow na nich zwobraznić.',
	'maps-displaypoint-description' => 'Geografiske karty z jednym we wikiju definowanej marku abo wjace markow na nich zwobraznić.',
	'maps-coordinates-par-location' => 'Koordinaty, kotrež chceš formatować.',
	'maps-coordinates-par-format' => 'Cilowy format za koordinaty.',
	'maps-distance-par-distance' => 'Zdalenosć, kotraž ma so do jeje ekwiwalenta z podatej jednotku konwertować.',
	'maps-distance-par-unit' => 'Jednotka za wudawanje zdalenosće.',
	'maps-finddestination-par-location' => 'Wuchadźišćo.',
	'maps-finddestination-par-bearing' => 'Wuchadne nasměrjenje.',
	'maps-finddestination-par-distance' => 'Pućowanska zdalenosć.',
	'maps-finddestination-par-format' => 'Wudawanski format za cil.',
	'maps-finddestination-par-allowcoordinates' => 'Podawa, hač koordinaty su dowolene. Jeli nic, budu so jenož adresy akceptować.',
	'maps-finddestination-par-geoservice' => 'Geokodowanska słužba, kotraž ma so za geokodowanje hódnoty wužiwać, jeli hódnota je adresa.',
	'maps-geocode-par-location' => 'Adresa, kotruž chceš geokodować.',
	'maps-geocode-par-mappingservice' => 'Geokodowanska słužba, kotruž chceš wužiwać. Hlej k dispoziciji stejace geokodowanske słužby.',
	'maps-geocode-par-format' => 'Format za wudate koordinaty.',
	'maps-geodistance-par-location1' => 'Prěni dypk z dweju dypkow, mjez kotrymajž ma so zdalenosć wuličić.',
	'maps-geodistance-par-location2' => 'Druhi dypk z dweju dypkow, mjez kotrymajž ma so zdalenosć wuličić.',
	'maps-geodistance-par-unit' => 'Jednotka, w kotrejž so zdalenosć podawa.',
	'maps-geodistance-par-mappingservice' => 'Geokodowanska słužba, kotraž ma so za geokodowanje wšěch adresow wužiwać.',
	'maps-displaymap-par-mappingservice' => 'Zmóžnja nastajenje kartografiskeje słužby, kotraž ma so za generowanje karty wužiwać,',
	'maps-displaymap-par-coordinates' => 'Městno, na kotrež mapa ma so spočatnje centrować.',
	'maps-displaypoints-par-mappingservice' => 'Zmóžnja nastajenje kartografiskeje słužby, kotraž ma so za generowanje karty wužiwać,',
	'maps-displaypoints-par-coordinates' => 'Jedne městno abo wjace městnow, kotrež maja so na karće zwobraznić. Woznamjenjeja so z marku.',
	'maps-displaypoints-par-icon' => 'Zmóžnja postajenje symbola, kotryž ma so za wšě marki wužiwać.',
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
	'maps-googlemaps2-incompatbrowser' => 'Twój wobhladowak njeje kompatibelny z Google Maps v2.',
	'maps_overlays' => 'Naworštowanja',
	'maps_photos' => 'Fota',
	'maps_videos' => 'Wideja',
	'maps_wikipedia' => 'Wikipedija',
	'maps_webcams' => 'Webcamy',
	'maps-googlemaps3-incompatbrowser' => 'Twój wobhladowak njeje kompatibelny z Google Maps v3.',
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
	'maps-desc' => 'Lehetővé teszi koordinátaadatok és geokódolt címek megjelenítését térképeken ([http://mapping.referata.com/wiki/Maps_examples demó]). Elérhető térképszolgáltatások: $1',
	'maps_map' => 'Térkép',
	'maps-loading-map' => 'Térkép betöltése…',
	'maps-load-failed' => 'Nem sikerült betölteni a térképet!',
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
	'maps-googlemaps3-par-zoomstyle' => 'A nagyítás irányításának stílusa.',
	'maps-googlemaps3-par-kml' => 'Betöltendő KML fájlok.',
	'maps-osm-par-thumbs' => 'Bélyegképek megjelenítése',
	'maps-osm-par-photos' => 'Fényképek megjelenítése',
	'maps-yahoomaps-par-type' => 'A kezdetben megjelenítendő térképtípus.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'maps-desc' => 'Permitte le incorporation de cartas dynamic in paginas wiki, le geocodification de adresses e altere operationes geographic. ([http://mapping.referata.com/wiki/Maps_examples demonstrationes])',
	'right-geocode' => 'Geocodificar',
	'maps_map' => 'Carta',
	'maps-loading-map' => 'Cargamento del carta…',
	'maps-load-failed' => 'Non poteva cargar le carta!',
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
	'maps-coordinates-description' => 'Uncino analysator pro formatar coordinatas, ex e in tote le formatos supportate.',
	'maps-displaymap-description' => 'Monstra cartas geographic sin marcatores definite in wiki.',
	'maps-displaypoint-description' => 'Monstra cartas geographic con un o plus marcatores definite in wiki.',
	'maps-distance-description' => 'Converte un distantia in un del unitates supportate a su equivalente in un altere unitate.',
	'maps-finddestination-description' => 'Cercar un destination, date un puncto de initio (que pote esser in omne formato supportate), un direction initial e un distantia.',
	'maps-geocode-description' => 'Permitte le geocodification de adresses, in altere parolas, converte adresses conventional de locos in gruppos de coordinatas. Existe supporto pro plure servicios de geocodification, le quales non debe esser confundite con servicios cartographic.',
	'maps-geodistance-description' => 'Calcula le distantia geographic inter duo punctos, ex e in omne formato supportate.',
	'maps-mapsdoc-description' => 'Presenta un tabella con le parametros de un servicio cartographic specificate, insimul con lor valores predefinite e lor descriptiones.',
	'maps-mapsdoc-par-service' => 'Le servicio cartographic pro le qual presentar le documentation de parametros.',
	'maps-mapsdoc-par-language' => 'Le lingua in le qual presentar le documentation. Si tal traduction non es disponibile, anglese essera usate in su loco.',
	'maps-coordinates-par-location' => 'Le coordinatas que tu vole formatar.',
	'maps-coordinates-par-format' => 'Le formato in le qual presentar le coordinatas.',
	'maps-coordinates-par-directional' => 'Indica si le coordinatas debe esser presentate directional o non.',
	'maps-distance-par-distance' => 'Le distantia a converter a su equivalente in un unitate specificate.',
	'maps-distance-par-decimals' => 'Le numero maxime de digitos fractional a usar in le valor resultante.',
	'maps-distance-par-unit' => 'Le unitate in le qual presentar le distantia.',
	'maps-finddestination-par-location' => 'Le position initial.',
	'maps-finddestination-par-bearing' => 'Le direction initial.',
	'maps-finddestination-par-distance' => 'Le distantia a viagiar.',
	'maps-finddestination-par-format' => 'Le formato in le qual producer le destination.',
	'maps-finddestination-par-directional' => 'Indica si le formato del destination debe esser directional o non.',
	'maps-finddestination-par-allowcoordinates' => 'Indica si permitter coordinatas. Si non, solmente adresses essera acceptate.',
	'maps-finddestination-par-geoservice' => 'Le servicio de geocodification a usar pro geocodificar le valor si illo es un adresse.',
	'maps-finddestination-par-mappingservice' => 'Parametro que tu pote usar pro indicar le servicio cartographic con le qual tu usa iste function.
Isto permitte supplantar le valor predefinite del parametro de servicio per un que es optimal pro le servicio cartographic.
(Exemplo: In caso de Google Maps, le geocodificator de Google essera usate.)',
	'maps-geocode-par-location' => 'Le adresse que tu vole geocodificar.',
	'maps-geocode-par-mappingservice' => 'Le servicio de geocodification que tu vole usar. Vide le servicios de geocodification disponibile.',
	'maps-geocode-par-geoservice' => 'Iste parametro permitte indicar que tu usa iste requesta de geocodification in combination con un servicio cartographic specific.
Cata servicio cartographic pote haber parametros que supplanta le valor predefinite del servicio de geocodification.
Isto es pro considerationes legal, post que tu non pote usar le servicio Google Geocoding excepte insimul con Google Maps.
Definir iste parametro e non le parametro de servicio assecura que tu non usa un combination invalide.',
	'maps-geocode-par-allowcoordinates' => 'Permitte disactivar le supporto de coordinatas in iste function. Debe esser o "si" o "no".
Si es "no", cata valor essera geocodificate, mesmo le coordinatas valide.',
	'maps-geocode-par-format' => 'Le formato pro le coordinatas resultante.',
	'maps-geocode-par-directional' => 'Indica si le coordinatas debe esser presentate directional o non.',
	'maps-geodistance-par-location1' => 'Le prime puncto del gruppo inter le quales calcular le distantia.',
	'maps-geodistance-par-location2' => 'Le secunde puncto del gruppo inter le quales calcular le distantia.',
	'maps-geodistance-par-unit' => 'Le unitate in le qual presentar le distantia.',
	'maps-geodistance-par-decimals' => 'Le numero maxime de digitos fractional a usar in le valor resultante.',
	'maps-geodistance-par-mappingservice' => 'Le servicio de geocodification a usar pro geocodificar adresses.',
	'maps-geodistance-par-geoservice' => 'Le servicio cartographic con le qual isto es usate.
Isto pote influentiar le valor predefinite de servicio de geocodification.',
	'maps-displaymap-par-mappingservice' => 'Permitte definir le servicio cartographic a usar pro generar le carta.',
	'maps-displaymap-par-coordinates' => 'Le loco in le qual le carta essera initialmente centrate.',
	'maps-displaypoints-par-zoom' => 'Permitte definir le nivello de zoom del carta.
Si isto non es fornite, e multiple marcatores es presente in le cata, le zoom que los arrangia melio essera prendite, non le predefinition configurabile.',
	'maps-displaypoints-par-mappingservice' => 'Permitte definir le servicio cartographic a usar pro generar le carta.',
	'maps-displaypoints-par-coordinates' => 'Un o plus locos a monstrar in le carta. Illos essera indicate con un marcator.',
	'maps-displaypoints-par-centre' => 'Permitte definir le coordinatas del centro del carta pro display_point(s).
Accepta e adresses e coordinatas.
Si iste proprietate non es fornite, le carta se centrara in le marcator fornite, o inter le marcatores fornite.',
	'maps-displaypoints-par-title' => 'Permitte definir texto que essera monstrate in le pop-ups de tote le marcatores que non ha un titulo specific.
Si usate con un etiquetta, le titulo essera monstrate in litteras grasse e sublineate.',
	'maps-displaypoints-par-label' => 'Permitte definir texto que essera monstrate in le pop-ups de tote le marcatores que non ha un etiquetta specific.',
	'maps-displaypoints-par-icon' => 'Permitte definir le icone usate pro tote le marcatores.',
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
	'maps-par-resizable' => 'Rende le carta redimensionabile per traher lo per su angulo dextre inferior.',
	'maps-par-geoservice' => 'Le servicio de geocodification usate pro converter inter adresses e coordinatas.',
	'maps-par-zoom' => 'Le nivello de zoom pro le carta. Pro cartas con marcatores isto es predefinite como le nivello de zoom le plus alte que ancora monstra tote le marcatores.',
	'maps-par-width' => 'Permitte fixar le latitude del carta. Le unitate assumite es pixels, ma tu pote specificar un de iste unitates: px, ex, em, %.',
	'maps-par-height' => 'Permitte fixar le altitude del carta. Le unitate assumite es pixels, ma tu pote specificar un de iste unitates: px, ex, em, %.',
	'maps-googlemaps2-incompatbrowser' => 'Tu navigator del web non es compatibile con Google Maps version 2.',
	'maps_overlays' => 'Superpositiones',
	'maps_photos' => 'Photos',
	'maps_videos' => 'Videos',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Cameras web',
	'maps-googlemaps2-par-type' => 'Le typo de carta a monstrar initialmente.',
	'maps-googlemaps2-par-types' => 'Le typos de carta que essera disponibile via le controlo de typo.',
	'maps-googlemaps2-par-controls' => 'Le controlos a placiar super le carta.',
	'maps-googlemaps2-par-autozoom' => 'Permitte rolar usante le rota del mus.',
	'maps-googlemaps2-par-kml' => 'Files KML pro cargar in le carta.',
	'maps-googlemaps2-par-overlays' => 'Superpositiones que le usator pote activar.',
	'maps-googlemaps3-incompatbrowser' => 'Tu navigator de web non es compatibile con Google Maps version 3.',
	'maps-googlemaps3-par-type' => 'Le typo de carta a monstrar initialmente.',
	'maps-googlemaps3-par-types' => 'Le typos de carta que essera disponibile via le controlo de typo.',
	'maps-googlemaps3-par-layers' => 'Stratos special pro cargar in le carta.',
	'maps-googlemaps3-par-controls' => 'Le controlos a placiar super le carta.',
	'maps-googlemaps3-par-zoomstyle' => 'Le stilo del controlo de zoom.',
	'maps-googlemaps3-par-typestyle' => 'Le stilo del controlo de typo.',
	'maps-googlemaps3-par-autoinfowindows' => 'Aperir automaticamente tote le fenestras informative post le cargamento del pagina.',
	'maps-googlemaps3-par-kml' => 'Files KML pro cargar in le carta.',
	'maps-googlemaps3-par-gkml' => 'KML files albergate per Google a cargar sur le carta.',
	'maps-googlemaps3-par-fusiontables' => 'IDs de tabellas de Google Fusion que debe esser cargate in le carta.',
	'maps-googlemaps3-par-tilt' => 'Inclination del carta durante le uso de Google Maps.',
	'maps-googlemaps3-par-kmlrezoom' => 'Rezoomar le carta post le cargamento del stratos KML.',
	'maps-openlayers-par-controls' => 'Le controlos a placiar super le carta.',
	'maps-openlayers-par-layers' => 'Le stratos que essera disponibile in le selector de stratos. Le prime strato essera monstrate durante le cargamento del carta.',
	'maps-osm-par-thumbs' => 'Monstrar miniaturas',
	'maps-osm-par-photos' => 'Monstrar photos',
	'maps-yahoomaps-par-type' => 'Le typo de carta a monstrar initialmente.',
	'maps-yahoomaps-par-types' => 'Le typos de carta que essera disponibile via le controlo de typo.',
	'maps-yahoomaps-par-controls' => 'Le controlos a placiar super le carta.',
	'maps-yahoomaps-par-autozoom' => 'Permitte rolar usante le rota del mus.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 */
$messages['id'] = array(
	'maps-desc' => 'Mengaktifkan penyertaan peta dinamis dalam halaman wiki, pembuatan geokode alamat, dan operasi geografi lain.
([http://mapping.referata.com/wiki/Examples demo])',
	'maps_map' => 'Peta',
	'maps-loading-map' => 'Memuat peta...',
	'maps-load-failed' => 'Peta tidak dapat dimuat!',
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
	'maps-coordinates-description' => 'Pengait parser untuk memformat koordinat, dari dan ke salah satu format yang didukung.',
	'maps-displaymap-description' => 'Menampilkan peta geografis tanpa mencantumkan penanda wiki terdefinisi.',
	'maps-displaypoint-description' => 'Menampilkan peta geografis dengan satu atau lebih penanda wiki terdefinisi.',
	'maps-distance-description' => 'Mengubah jarak dengan menggunakan unit terdukung tertentu menjadi setaranya dengan menggunakan unit lain.',
	'maps-finddestination-description' => 'Menemukan tujuan dari suatu titik awal (dalam salah satu format yang didukung), arah, dan jarak.',
	'maps-geocode-description' => 'Memberikan geokode alamat, atau dengan kata lain, mengubah lokasi yang dapat dibaca manusia ke set koordinat. Tersedia dukungan untuk beberapa layanan geokode, yang berbeda dengan layanan pemetaan.',
	'maps-geodistance-description' => 'Menghitung jarak geografis antara dua titik, dari dan ke salah satu format yang didukung.',
	'maps-coordinates-par-location' => 'Koordinat yang ingin diformat.',
	'maps-coordinates-par-format' => 'Format sasaran untuk koordinat.',
	'maps-coordinates-par-directional' => 'Menunjukkan apakah keluaran koordinat perlu disertai arah atau tidak.',
	'maps-distance-par-distance' => 'Jarak yang ingin diubah ke setaranya dengan suatu unit tertentu.',
	'maps-distance-par-decimals' => 'Jumlah maksimum digit pecahan yang digunakan untuk nilai hasil.',
	'maps-distance-par-unit' => 'Unit keluaran jarak.',
	'maps-finddestination-par-location' => 'Lokasi awal.',
	'maps-finddestination-par-bearing' => 'Arah awal.',
	'maps-finddestination-par-distance' => 'Jarak yang ditempuh.',
	'maps-finddestination-par-format' => 'Format keluaran tujuan.',
	'maps-finddestination-par-directional' => 'Menunjukkan apakah format tujuan disertai arah atau tidak.',
	'maps-finddestination-par-allowcoordinates' => 'Menunjukkan apakah koordinat diizinkan. Jika disetel tidak, hanya alamat yang diterima.',
	'maps-finddestination-par-geoservice' => 'Layanan geokode yang digunakan untuk mengubah nilai dari suatu alamat.',
	'maps-finddestination-par-mappingservice' => 'Parameter yang dapat digunakan untuk menunjukkan layanan pemetaan yang digunakan bersama fungsi ini.
Parameter ini memungkinkan untuk menimpa nilai bawaan parameter layanan dengan yang optimal untuk layanan pemetaan.
(Contoh: dalam kasus dari Google Maps, geokode Google akan digunakan.)',
	'maps-geocode-par-location' => 'Alamat yang ingin diubah menjadi geokode.',
	'maps-geocode-par-mappingservice' => 'Layanan geokode yang ingin digunakan. Lihat layanan geokode yang didukung.',
	'maps-geocode-par-geoservice' => 'Parameter ini memungkinkan untuk menunjukkan bahwa permintaan geokode digunakan bersama dengan layanan pemetaan tertentu.
Setiap layanan pemetaan bisa menimpa nilai bawaan layanan geokode.
Hal ini demi pertimbangan hukum, karena Anda tidak dapat menggunakan layanan Google Geocoding kecuali bersama dengan Google Maps. Pengaturan parameter ini dan bukan parameter layanan akan memastikan Anda tidak menggunakan kombinasi yang tidak sah.',
	'maps-geocode-par-allowcoordinates' => 'Menonaktifkan dukungan untuk koordinat dalam fungsi ini. Pilih ya atau tidak.
Jika tidak, setiap nilai akan diubah menjadi geokode, bahkan koordinat yang sah.',
	'maps-geocode-par-format' => 'Format koordinat hasil.',
	'maps-geocode-par-directional' => 'Menunjukkan apakah keluaran koordinat perlu disertai arah atau tidak.',
	'maps-geodistance-par-location1' => 'Titik pertama dalam himpunan untuk menghitung jarak antara.',
	'maps-geodistance-par-location2' => 'Titik kedua dalam himpunan untuk menghitung jarak antara.',
	'maps-geodistance-par-unit' => 'Unit keluaran jarak.',
	'maps-geodistance-par-decimals' => 'Jumlah maksimum digit pecahan yang digunakan untuk nilai hasil.',
	'maps-geodistance-par-mappingservice' => 'Layanan yang digunakan untuk mengubah alamat menjadi geokode.',
	'maps-geodistance-par-geoservice' => 'Layanan pemetaan yang digunakan bersama dengan ini.
Ini dapat memengaruhi nilai bawaan layanan geokode.',
	'maps-displaymap-par-mappingservice' => 'Memungkinkan pengaturan layanan pemetaan yang akan digunakan untuk menghasilkan peta.',
	'maps-displaymap-par-coordinates' => 'Lokasi pusat awal dari peta.',
	'maps-displaypoints-par-zoom' => 'Memungkinkan pengaturan tingkat pembesaran peta.
Jika tidak diberikan dan beberapa penanda ada pada peta, akan dipilih pembesaran yang paling muat, bukan bawaan yang disetel.',
	'maps-displaypoints-par-mappingservice' => 'Memungkinkan pengaturan layanan pemetaan yang akan digunakan untuk menghasilkan peta.',
	'maps-displaypoints-par-coordinates' => 'Satu atau beberapa lokasi akan ditampilkan pada peta. Lokasi tersebut akan ditunjukkan dengan penanda.',
	'maps-displaypoints-par-centre' => 'Memungkinkan pengaturan koordinat pusat peta untuk display_point. 
Dapat menerima alamat maupun koordinat. 
Jika tidak diberikan, peta akan menentukan pusatnya pada penanda yang ada atau di antara penanda yang diberikan.',
	'maps-displaypoints-par-title' => 'Memungkinkan pengaturan teks yang akan ditampilkan pada munculan dari semua penanda yang tidak memiliki judul tertentu.
Jika digunakan bersama dengan label, judul akan ditebalkan dan memiliki garis bawah.',
	'maps-displaypoints-par-label' => 'Memungkinkan pengaturan teks yang akan ditampilkan pada munculan dari semua tanda yang tidak memiliki label tertentu.',
	'maps-displaypoints-par-icon' => 'Memungkinkan pengaturan ikon yang digunakan semua penanda.',
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
	'maps-par-resizable' => 'Membuat peta berubah ukuran dengan menyeret pojok kanan bawahnya.',
	'maps-par-geoservice' => 'Layanan geokode yang digunakan untuk membuat terjemahan antara alamat dan koordinat.',
	'maps-par-zoom' => 'Tingkat pembesaran peta. Secara bawaan, peta bertanda akan mengambil tingkat pembesaran yang masih menunjukkan semua tanda.',
	'maps-par-width' => 'Memungkinkan pengaturan lebar peta. Secara bawaan, piksel akan dianggap sebagai unit, tetapi Anda dapat menentukan secara eksplisit salah satu unit berikut: px, ex, em, %.',
	'maps-par-height' => 'Memungkinkan pengaturan tinggi peta. Secara bawaan, piksel akan dianggap sebagai unit, tetapi Anda dapat menentukan secara eksplisit salah satu unit berikut: px, ex, em, %.',
	'maps-googlemaps2-incompatbrowser' => 'Peramban Anda tidak kompatibel dengan Google Maps v2.',
	'maps_overlays' => 'Hamparan',
	'maps_photos' => 'Foto',
	'maps_videos' => 'Video',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Kamera web',
	'maps-googlemaps2-par-type' => 'Jenis peta yang ditampilkan saat awal.',
	'maps-googlemaps2-par-types' => 'Jenis peta yang akan tersedia melalui kontrol jenis.',
	'maps-googlemaps2-par-controls' => 'Kontrol yang akan ditempatkan pada peta.',
	'maps-googlemaps2-par-autozoom' => 'Mengaktifkan fitur gulir dengan menggunakan mousewheel.',
	'maps-googlemaps2-par-kml' => 'Berkas KML yang akan dimuat ke dalam peta.',
	'maps-googlemaps2-par-overlays' => 'Hamparan yang dapat diaktifkan pengguna.',
	'maps-googlemaps3-incompatbrowser' => 'Peramban Anda tidak kompatibel dengan Google Maps v3.',
	'maps-googlemaps3-par-type' => 'Jenis peta yang ditampilkan saat awal.',
	'maps-googlemaps3-par-types' => 'Jenis peta yang akan tersedia melalui kontrol jenis.',
	'maps-googlemaps3-par-layers' => 'Lapisan khusus yang akan dimuat ke dalam peta.',
	'maps-googlemaps3-par-controls' => 'Kontrol yang akan ditempatkan pada peta.',
	'maps-googlemaps3-par-zoomstyle' => 'Gaya kontrol pembesaran.',
	'maps-googlemaps3-par-typestyle' => 'Gaya jenis kontrol.',
	'maps-googlemaps3-par-autoinfowindows' => 'Otomatis membuka semua jendela info setelah halaman dimuat.',
	'maps-googlemaps3-par-kml' => 'Berkas KML yang akan dimuat ke dalam peta.',
	'maps-googlemaps3-par-fusiontables' => 'ID Google Fusion Tables yang harus dimuat ke dalam peta.',
	'maps-openlayers-par-controls' => 'Kontrol yang akan ditempatkan pada peta.',
	'maps-openlayers-par-layers' => 'Lapisan yang akan tersedia pada pemilih lapisan. Lapisan pertama akan ditampilkan ketika peta dimuat.',
	'maps-osm-par-thumbs' => 'Tampilkan gambar mini',
	'maps-osm-par-photos' => 'Tampilkan foto',
	'maps-yahoomaps-par-type' => 'Jenis peta yang ditampilkan saat awal.',
	'maps-yahoomaps-par-types' => 'Jenis peta yang akan tersedia melalui jenis kontrol.',
	'maps-yahoomaps-par-controls' => 'Kontrol yang akan ditempatkan pada peta.',
	'maps-yahoomaps-par-autozoom' => 'Mengaktifkan fitur gulir dengan menggunakan mousewheel.',
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
	'maps-desc' => "Fornisce la possibilità di visualizzare i dati di coordinate su mappe e la geocodifica di indirizzi ([http://wiki.bn2vs.com/wiki/Demo dell'estensione Maps]).
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
	'maps-desc' => 'ウィキページへの動的な地図の組み込み、住所の座標データへの変換などの地図関連操作を可能にする。([http://mapping.referata.com/wiki/Examples 実演])',
	'right-geocode' => 'ジオコーディング',
	'maps_map' => '地図',
	'maps-loading-map' => '地図を読み込み中…',
	'maps-load-failed' => '地図を読み込めませんでした。',
	'maps-markers' => 'マーカー',
	'maps-others' => 'その他',
	'maps-ns-layer' => 'レイヤー',
	'maps-ns-layer-talk' => 'レイヤー・トーク',
	'maps-layer-property' => '属性',
	'maps-layer-value' => '値',
	'maps-layer-errors' => 'エラー',
	'maps-error-invalid-layerdef' => 'このレイヤー定義は不正です。',
	'maps-error-invalid-layertype' => '種類「$1」のレイヤーが存在しません。{{PLURAL:$3|この|これら}}の種類のサポート：$2',
	'maps-error-no-layertype' => 'レイヤーの種類を指定する必要があります。{{PLURAL:$2|この種類のみ|これらの種類}}に対応しています: $1',
	'validation-error-invalid-layer' => '引数$1は有効なレイヤーでなければなりません。',
	'validation-error-invalid-layers' => '引数$1は1つ以上の有効なレイヤーでなければなりません。',
	'maps-layer-of-type' => '種類$1のレイヤー',
	'maps-layer-type-supported-by' => 'このレイヤー種は、{{PLURAL:$2|$1地図サービスでのみ利用可能です|以下の地図サービスで利用可能です：$1}}。',
	'validation-error-invalid-location' => '引数$1は有効な場所でなければなりません。',
	'validation-error-invalid-locations' => '引数$1は、1つそれ以上有効な場所でなければなりません。',
	'validation-error-invalid-width' => '引数$1は有効な幅でなければなりません。',
	'validation-error-invalid-height' => '引数$1は有効な高さでなければなりません。',
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
	'maps-googlemaps2-incompatbrowser' => 'あなたのブラウザーは Google Maps v2 と互換性がありません。',
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

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'maps-abb-north' => 'ជ',
	'maps-abb-east' => 'ក',
	'maps-abb-south' => 'ត្ប',
	'maps-abb-west' => 'ល',
	'maps-latitude' => 'រយៈទទឹង៖',
	'maps-longitude' => 'រយៈបណ្តោយ៖',
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
	'maps-desc' => 'Määt et müjjelesch, Koodinaate en Landkaate aanzezeije, un Addräße en Koodinaate op de Ääd ömzerääschne. (E [http://mapping.referata.com/wiki/Maps_examples paa Beispöll]). {{PLURAL:$2:|Unsere Deens fö de Kaate es $1|He di Deenste för Landkaate ham_mer ze beede: $1|Mer han ävver kein Deenste för Kaate em Momang.}}',
	'maps_map' => 'Kaat',
	'maps-loading-map' => 'Mer sen en Kaat aam laade&nbsp;…',
	'maps-markers' => 'Makeeronge',
	'maps-others' => 'sönß wää',
	'maps-layer-property' => 'Eijeschaff',
	'maps-layer-value' => 'Wäät',
	'maps-layer-errors' => 'Fähler',
	'maps-distance-par-unit' => 'De Einheit för der Afschtand dren ußzejävve.',
	'maps-displaymap-par-coordinates' => 'Dä Plaz, dä aanfänglesch en de Medde vun dä Kaat lijje sull.',
	'maps-displaypoints-par-icon' => 'Määd et müjjelesch, e Minni_Belldsche faßzelääje, waoh met all de Makeerunge jezeish wääde.',
	'validation-error-invalid-location' => 'Dä Parameeter $1 mos ene jölteje Plaz sin.',
	'validation-error-invalid-locations' => 'Dä Parameeter $1 moß eine jölteje Plaz udder an Aanzahl jöltijje Pläz sin.',
	'validation-error-invalid-width' => 'Dä Parameeter $1 mos en jölteje Breedt sin.',
	'validation-error-invalid-height' => 'Dä Parameeter $1 mos en jölteje Hühde sin.',
	'validation-error-invalid-distance' => 'Dä Parameeter $1 mos ene jölteje Affshtand sin.',
	'validation-error-invalid-distances' => 'Dä Parameeter $1 moß eine jölteje Affshtand udder an Aanzahl jöltijje Affshtänd sin.',
	'validation-error-invalid-image' => 'Dä Parameeter $1 mos e jöltesch Beld sin.',
	'validation-error-invalid-images' => 'Dä Parameeter $1 moß ei jöltesch Beld udder an Aanzahl jöltijje Belder sin.',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'O',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps-latitude' => 'Breedt om Jlobus:',
	'maps-longitude' => 'Längde om Jlobus:',
	'maps-invalid-coordinates' => 'Dä Wäät $1 künne mer nit als ene Saz vun Koodinahte vershtonn.',
	'maps_coordinates_missing' => 'Mer han kein Koodinaate för di Kaat.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Di Koodinaat|De Koodinaate|Kein Koodinaat}} om Jlobus för di {{PLURAL:$2|aanjejovve Adräß wohr|aanjejovve Adräße wohre|kein aanjejovve Adräß wohr}} Kappes: $1. Di Kaat künne mer su nit aanzeije.',
	'maps_geocoding_failed_for' => 'De Koodinaate om Jlobus för {{PLURAL:$2|ein|paa|kein}} vun dä aanjejovve Adräße {{PLURAL:$2|es|wohre|Fähler!}} Kappes. Di {{PLURAL:$2|es|sin|Fähler!}} dröm nit op dä Kaat. De fottjelohße {{PLURAL:$2|es|sin|Fähler!}}: $1',
	'maps_unrecognized_coords' => 'He di Koordinate kunnte mer nit verschtonn: $1.',
	'maps_unrecognized_coords_for' => 'He di {{PLURAL:$2|Koordinat kunnt|Koordinate kunnte}} mer nit verschtonn un dröm {{PLURAL:$2|es|sin}} se nit en de Kaat opjenumme woode:
$1',
	'maps_map_cannot_be_displayed' => 'Di Kaat künne mer nit aanzeije.',
	'maps_click_to_activate' => 'Donn klecke, öm op di Kaat ze jonn',
	'maps_centred_on' => 'De Kaat met $1, $2 en de Medde.',
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
	'maps-desc' => "Gëtt d'Méiglechkeet fir d'Date vun de Koordinaten op Kaarten a Geocode Adressen [http://mapping.referata.com/wiki/Examples Démo] ze weisen",
	'maps_map' => 'Kaart',
	'maps-loading-map' => "D'Kaart gëtt gelueden…",
	'maps-load-failed' => "D'Kaart konnt net geluede ginn!",
	'maps-markers' => 'Markéierungen',
	'maps-others' => 'anerer',
	'maps-layer-property' => 'Eegeschaft',
	'maps-layer-value' => 'Wäert',
	'maps-layer-errors' => 'Feeler',
	'maps-coordinates-par-location' => "D'Koordinaten déi Dir formatéiere wëllt.",
	'maps-coordinates-par-format' => "D'Zilformat vun de Koordinaten.",
	'maps-finddestination-par-location' => 'Déi initial Plaz.',
	'maps-finddestination-par-distance' => "D'Distanz vun der Rees.",
	'maps-geocode-par-location' => "D'Adress déi Dir geocodéiere wëllt.",
	'maps-geocode-par-format' => "De Format fir d'Koordinaten.",
	'maps-geodistance-par-unit' => "D'Eenheet fir d'Distanz.",
	'maps-geodistance-par-decimals' => 'Déi maximal Zuel vu Kommastellen déi am Resultat benotzt gi soll.',
	'maps-displaymap-par-coordinates' => "Déi Plaz op déi d'Kaart am Ufank zentréiert gëtt.",
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
	'maps-googlemaps2-incompatbrowser' => 'Äre Browser ass net mat Google Maps v2 kompatibel.',
	'maps_overlays' => 'Ablendungen',
	'maps_photos' => 'Fotoen',
	'maps_videos' => 'Videoen',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Web-Kameraen',
	'maps-googlemaps2-par-type' => 'Den Typ vu Kaart den am Ufank gewise gëtt.',
	'maps-googlemaps2-par-kml' => "KML-Fichieren déi op d'Kaart musse geluede ginn.",
	'maps-googlemaps3-incompatbrowser' => 'Äre Browser ass net mat Google Maps v3 kompatibel.',
	'maps-googlemaps3-par-type' => 'Den Typ vu Kaart den am Ufank gewise gëtt.',
	'maps-googlemaps3-par-kml' => "KML-Fichieren déi op d'Kaart musse geluede ginn.",
	'maps-osm-par-thumbs' => 'Miniaturbiller weisen',
	'maps-osm-par-photos' => 'Fotoe weisen',
	'maps-yahoomaps-par-type' => 'Den Typ vu Kaart den am Ufank gewise gëtt.',
);

/** Lithuanian (Lietuvių)
 * @author Hugo.arg
 */
$messages['lt'] = array(
	'maps-desc' => 'Suteikia galimybę atvaizduoti koordinačių duomenis žemėlapiuose ir geografinio kodavimo adresus ([http://mapping.referata.com/wiki/Maps_examples demo]).
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

/** Latvian (Latviešu)
 * @author GreenZeb
 */
$messages['lv'] = array(
	'maps-abb-north' => 'Z',
	'maps-abb-east' => 'A',
	'maps-abb-south' => 'D',
	'maps-abb-west' => 'R',
	'maps-latitude' => 'Platums:',
	'maps-longitude' => 'Garums:',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author McDutchie
 */
$messages['mk'] = array(
	'maps-desc' => 'Дава можност за вметнување на динамички карти во викистраници, геокодирање на адреси и други географски операции. ([http://mapping.referata.com/wiki/Maps_examples мостри])',
	'right-geocode' => 'Геокод',
	'maps_map' => 'Карта',
	'maps-loading-map' => 'Ја вчитувам картата...',
	'maps-load-failed' => 'Не можев да ја вчитам картата!',
	'maps-markers' => 'Обележувачи',
	'maps-others' => 'други',
	'maps-ns-layer' => 'Слој',
	'maps-ns-layer-talk' => 'Разговор за слој',
	'maps-layer-property' => 'Својство',
	'maps-layer-value' => 'Вредност',
	'maps-layer-errors' => 'Грешки',
	'maps-error-invalid-layerdef' => 'Ова определение за слојот е неважечко.',
	'maps-error-invalid-layertype' => 'Нема слоеви од типот „$1“. {{PLURAL:$3|Поддржан е само овој тип|Поддржани се само следниве типови}}: $2',
	'maps-error-no-layertype' => 'Ќе треба да наведете тип на слој. {{PLURAL:$2|Поддржан е само овој тип|Поддржани се само следниве типови}}: $1',
	'validation-error-invalid-layer' => 'Параметарот $1 мора да биде важечки слој.',
	'validation-error-invalid-layers' => 'Параметарот $1 мора да биде еден или повеќе важечки слоеви.',
	'maps-layer-of-type' => 'Слој од типот $1',
	'maps-layer-type-supported-by' => 'Овој тип на слој може да се користи {{PLURAL:$2|само со картографската служба $1|само со следниве картографски служби: $1}}.',
	'maps-coordinates-description' => 'Парсерска кука за форматирање на координати. Ги претвора сите поддржани формати.',
	'maps-displaymap-description' => 'Приказ на географски карти без никакви обележувачи на нив определени од викито.',
	'maps-displaypoint-description' => 'Приказ на географски карти со една или повеќе обележувачи на нив определени од викито.',
	'maps-distance-description' => 'Претворање на растојание од една во друга поддржана единица.',
	'maps-finddestination-description' => 'Пронаоѓање на одредница со зададена почетна точка (која може да биде во било кој поддржан формат), првична насока и растојание',
	'maps-geocode-description' => 'Овозможува геокодирање на адреси, што значи дека претвора места во координати. Има поддршка за неколку служби за геокодирање (не е исто што и картографски служби).',
	'maps-geodistance-description' => 'Пресметување на географското растојание помеѓу две точки (сите поддржани формати).',
	'maps-mapsdoc-description' => 'Приказ на табела со параметри за назначена карторафска служба заедно со нивните основни вредности и описи.',
	'maps-mapsdoc-par-service' => 'Картографската служба за која се прикажува параметарска документација.',
	'maps-mapsdoc-par-language' => 'На кој јазик да се прикаже документацијата. Ако го нема тој превод, ќе се прикаже англиската верзија.',
	'maps-coordinates-par-location' => 'Координатите што сакате да ги форматирате.',
	'maps-coordinates-par-format' => 'Целниот формат за координатите.',
	'maps-coordinates-par-directional' => 'Покажува дали координатите треба да се испишат со или без насока.',
	'maps-distance-par-distance' => 'Растојанието во кое претворате е истоветно со единицата што се укажува.',
	'maps-distance-par-decimals' => 'Максимален број на децимални места што ќе се користат во изводната вредност.',
	'maps-distance-par-unit' => 'Единица на испишаното растојание во изводот.',
	'maps-finddestination-par-location' => 'Првичната местоположба.',
	'maps-finddestination-par-bearing' => 'Првичната насока.',
	'maps-finddestination-par-distance' => 'Растојанието што треба да се помине.',
	'maps-finddestination-par-format' => 'Во кој формат да се испише одредницата.',
	'maps-finddestination-par-directional' => 'Покажува дали форматот на одредницата треба да има насока.',
	'maps-finddestination-par-allowcoordinates' => 'Покажува дали треба да се дозволени координати. Ако зададете „не“, тогаш ќе се прифаќаат само адреси.',
	'maps-finddestination-par-geoservice' => 'Службата за геокодирање на вредноста ако е адреса.',
	'maps-finddestination-par-mappingservice' => 'Параметар што може да се употреби за укажување на картографската служба со која ја користите оваа функција.
Ова им овозможува на картите да ја заменат стандардната вредност на параметарот за служба со онаква што е најсоодветна за таа служба.
(Пример: Ако станува збор за Google Maps, тогаш ќе се користи геокодерот на Google.)',
	'maps-geocode-par-location' => 'Адресата што сакате да ја геокодирате.',
	'maps-geocode-par-mappingservice' => 'Која служба за геокодирање сакате да ја користите. Погледајте кои служби се на располагање.',
	'maps-geocode-par-geoservice' => 'Овој параметар ви овозможува да назначите дека го користите ова барање за геокодирање заедно со конкретна картографска служба.
Секоја картографска служба ја заменува стандардната вредност за служба со сопствена.
Ова се прави од правни причини. бидејќи услугата геокодирање на Google може да се користи само заедно со Google Maps. За да сте сигурни дека не користите неважечка комбинација, поставете го овој параметар наместо оној за служба.',
	'maps-geocode-par-allowcoordinates' => 'Овозможува исклучување на поддршката за координати за оваа функција. Мора да биде „да“ или „не“.
Ако зададете „не“, тогаш ќе се геокодира секоја вредност, дури и важечки координати.',
	'maps-geocode-par-format' => 'Форматот на добиените координати.',
	'maps-geocode-par-directional' => 'Покажува дали координатите треба да се испишат со или без насока.',
	'maps-geodistance-par-location1' => 'Првата точка во пресметката на растојанието.',
	'maps-geodistance-par-location2' => 'Втората точка во пресметката на растојанието.',
	'maps-geodistance-par-unit' => 'Во која единица да се испише растојанието.',
	'maps-geodistance-par-decimals' => 'Максималниот број на децимални места за добиената вредност.',
	'maps-geodistance-par-mappingservice' => 'Службата за геокодирање што се користи за геокодирање на било која адреса.',
	'maps-geodistance-par-geoservice' => 'Со која картографска служба ќе го користите ова.
Ова може да влијае на основната вредност за служба за геокодирање.',
	'maps-displaymap-par-mappingservice' => 'Овозможува задавање на картографска служба што ќе се користи за создавање на картата.',
	'maps-displaymap-par-coordinates' => 'На кое место картата ќе биде првично сосредоточена.',
	'maps-displaypoints-par-zoom' => 'Овозможува задавање на приближеност на картата.
Ако ова не е зададено, а на картата има повеќе обележувачи, тогаш ќе ви се прикаже приближеноста што најмногу одговара на екранот, наместо прилагодливата стандардна приближеност.',
	'maps-displaypoints-par-mappingservice' => 'Овозможува назначување на картографска служба што ќе се користи за создавање на картата.',
	'maps-displaypoints-par-coordinates' => 'Едно или повеќе места за приказ на картата. Ќе бидат означени со обележувач.',
	'maps-displaypoints-par-centre' => 'Овозможува укажување на координати на средиштето на картата за display_point(s).
Се прифаќаат и адреси и координати.
Ако ова не е зададено, тогаш картата ќе се сосредоточи во дадениот обележувач, или помеѓу дадените обележувачи.',
	'maps-displaypoints-par-title' => 'Овозможува задавање на текст што ќе се прикажува во скокачките прозорчиња на сите обележувачи што немаат конкретен наслов.
Ако се користат заедно со ознака, насловот ќе биде задебелен и ќе има линија под него.',
	'maps-displaypoints-par-label' => 'Овозможува задавање на текст што ќе се прикажува во скокачките прозорчиња на сите обележувачи што немаат конкретна ознака.',
	'maps-displaypoints-par-icon' => 'Овозможува задавање на икона што ќе се користи за сите обележувачи.',
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
	'maps_googlemaps2' => 'Google Карти вер. 2',
	'maps_googlemaps3' => 'Google Карти вер. 2',
	'maps_yahoomaps' => 'Yahoo! Карти',
	'maps_click_to_activate' => 'Кликнете за активирање на картата',
	'maps_centred_on' => 'Средиште на картата во $1, $2.',
	'maps-par-resizable' => 'Дава можност за менување на големината на картите со влечење на долниот десен агол.',
	'maps-par-geoservice' => 'Службата за геокодирање што ќе се користи за преведување на адреси во координати.',
	'maps-par-zoom' => 'Степенот на приближеност на картата. Картите со обележувачи по основно се прикажуваат во најголем степен на приближеност што воедно ги прикажува сите обележувачи.',
	'maps-par-width' => 'Овозможува задавање на ширина на картата во пиксели по основно, но по желба можете да изберете една од следниве единици: px, ex, em, %.',
	'maps-par-height' => 'Овозможува задавање на висина на картата во пиксели по основно, но по желба можете да изберете една од следниве единици: px, ex, em, %.',
	'maps-googlemaps2-incompatbrowser' => 'Вашиот прелистувач не е погоден за Google Карти вер. 2.',
	'maps_overlays' => 'Слоеви',
	'maps_photos' => 'Фотографии',
	'maps_videos' => 'Видеа',
	'maps_wikipedia' => 'Википедија',
	'maps_webcams' => 'Мреж. камери',
	'maps-googlemaps2-par-type' => 'Типот на карта за првичниот приказ.',
	'maps-googlemaps2-par-types' => 'Типовите на карти што ќе бидат достапни преку контролата за тип.',
	'maps-googlemaps2-par-controls' => 'Контролите што сакате да стојат на картата.',
	'maps-googlemaps2-par-autozoom' => 'Овозможи лизгање со тркалцето на глушецот.',
	'maps-googlemaps2-par-kml' => 'KML-податотеки за вчитување во картата.',
	'maps-googlemaps2-par-overlays' => 'Облогите што може да ги вклучи корисникот.',
	'maps-googlemaps3-incompatbrowser' => 'Вашиот прелистувач не е погоден за Google Карти вер. 3.',
	'maps-googlemaps3-par-type' => 'Типот на карта за првичниот приказ.',
	'maps-googlemaps3-par-types' => 'Типовите на карти што ќе бидат достапни преку контролата за тип.',
	'maps-googlemaps3-par-layers' => 'Посебни слоеви за вчитување во картата.',
	'maps-googlemaps3-par-controls' => 'Контролите што сакате да стојат на картата.',
	'maps-googlemaps3-par-zoomstyle' => 'Стил на контролата за приближување.',
	'maps-googlemaps3-par-typestyle' => 'Стилот на контролата за тип.',
	'maps-googlemaps3-par-autoinfowindows' => 'Автоматски отворај ги сите инфопрозорци откако ќе се вчита страницата.',
	'maps-googlemaps3-par-kml' => 'KML-податотеки за вчитување во картата.',
	'maps-googlemaps3-par-gkml' => 'KML-податотеки вдомени од Google за вчитување на карта.',
	'maps-googlemaps3-par-fusiontables' => 'Назнаки (ID) на табели од Google Fusion Tables што треба да се вчитаат во картата.',
	'maps-googlemaps3-par-tilt' => 'Наклон на картата кога користите Google Карти.',
	'maps-googlemaps3-par-kmlrezoom' => 'Приближи ја картата повторно откако ќе се вчитаат KML-слоевите.',
	'maps-openlayers-par-controls' => 'Контролите што сакате да стојат на картата.',
	'maps-openlayers-par-layers' => 'Слоевите што ќе бидат достапни во бирачот на слоеви. Кога ќе се вчита картата ќе се прикаже првиот слој.',
	'maps-osm-par-thumbs' => 'Прикажи минијатури',
	'maps-osm-par-photos' => 'Прикажи слики',
	'maps-yahoomaps-par-type' => 'Типот на карта за првичниот приказ.',
	'maps-yahoomaps-par-types' => 'Типовите на карти што ќе бидат достапни преку контролата за тип.',
	'maps-yahoomaps-par-controls' => 'Контролите што сакате да стојат на картата.',
	'maps-yahoomaps-par-autozoom' => 'Овозможи лизгање со тркалцето на глушецот.',
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

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'maps-desc' => 'Membolehkan pembenaman petak dinamik pada laman wiki, pembuatan geokod alamat dan bermacam-macam lagi operasi geografi. ([http://mapping.referata.com/wiki/Examples tunjuk cara])',
	'right-geocode' => 'Geokod',
	'maps_map' => 'Peta',
	'maps-loading-map' => 'Peta sedang dimuatkan...',
	'maps-load-failed' => 'Peta tidak dapat dimuatkan!',
	'maps-markers' => 'Penanda',
	'maps-others' => 'lain-lain',
	'maps-ns-layer' => 'Lapisan',
	'maps-ns-layer-talk' => 'Perbincangan lapisan',
	'maps-layer-property' => 'Sifat',
	'maps-layer-value' => 'Nilai',
	'maps-layer-errors' => 'Ralat',
	'maps-error-invalid-layerdef' => 'Takrifan lapisan ini tidak sah.',
	'maps-error-invalid-layertype' => 'Tiada lapisan jenis "$1". {{PLURAL:$3|Jenis|Jenis-jenis}} ini sahaja yang disokong: $2',
	'maps-error-no-layertype' => 'Anda perlu menentukan jenis lapisan. {{PLURAL:$2|Jenis|Jenis-jenis}} ini sahaja yang disokong: $1',
	'validation-error-invalid-layer' => 'Parameter $1 mestilah lapisan yang sah.',
	'validation-error-invalid-layers' => 'Parameter $1 mestilah sekurang-kurangnya satu lapisan yang sah.',
	'maps-layer-of-type' => 'Lapisan jenis $1',
	'maps-layer-type-supported-by' => 'Jenis lapisan ini {{PLURAL:$2|hanya boleh digunakan dengan perkhidmatan pemetaan $1|boleh digunakan dengan perkhidmatan-perkhidmatan pemetaan yang berikut: $1}}.',
	'maps-coordinates-description' => 'Cangkuk penghurai untuk memformatkan koordinat daripada/kepada sebarang format yang disokong.',
	'maps-displaymap-description' => 'Memaparkan peta geografi tanpa sebarang penanda tentuan wiki padanya.',
	'maps-displaypoint-description' => 'Memaparkan peta geografi dengan sekurang-kurangnya satu penanda tentuan wiki padanya.',
	'maps-distance-description' => 'Menukar nilai jarak yang menggunakan unit disokong yang tertentu kepada setaraannya yang menggunakan unit yang lain.',
	'maps-finddestination-description' => 'Mencari tujuan dari satu titik permulaan (yang boleh dinyatakan dalam sebarang format yang disokong), bearing permulaan dan jarak.',
	'maps-geocode-description' => 'Membolehkan pembuatan geokod alamat, iaitu menukar lokasi yang boleh dibaca oleh manusia kepada peranggu koordinat. Wujudnya sokongan untuk beberapa perkhidmatan geokod yang tidak boleh disamakan dengan perkhidmatan pemetaan.',
	'maps-geodistance-description' => 'Menghitung jarak geografi antara dua titik, daripada/kepada sebarang format yang disokong.',
	'maps-mapsdoc-description' => 'Memaparkan jadual parameter untuk perkhidmatan pemetaan tertentu bersama nilai-nilai asali dan keterangannya.',
	'maps-mapsdoc-par-service' => 'Perkhidmatan pemetaan untuk memaparkan dokumentasi parameter.',
	'maps-mapsdoc-par-language' => 'Bahasa untuk memaparkan dokumentasi. Jika tiada terjemahannya, Bahasa Inggeris digunakan pula.',
	'maps-coordinates-par-location' => 'Koordinat yang ingin diformatkan.',
	'maps-coordinates-par-format' => 'Format sasaran untuk koordinat.',
	'maps-coordinates-par-directional' => 'Menunjukkan sama ada koordinat wajar ditunjukkan berarah atau tidak.',
	'maps-distance-par-distance' => 'Nilai jarak yang ingin ditukar kepada setaraannya dengan unit yang tertentu.',
	'maps-distance-par-decimals' => 'Bilangan maksimum angka pecahan untuk digunakan dalam nilai hasil.',
	'maps-distance-par-unit' => 'Unit paparan nilai jarak.',
	'maps-finddestination-par-location' => 'Lokasi permulaan.',
	'maps-finddestination-par-bearing' => 'Bearing permulaan.',
	'maps-finddestination-par-distance' => 'Jarak perjalanan.',
	'maps-finddestination-par-format' => 'Format untuk memaparkan destinasi.',
	'maps-finddestination-par-directional' => 'Menunjukkan sama ada format destinasi wajar berarah atau tidak.',
	'maps-finddestination-par-allowcoordinates' => 'Menunjukkan sama ada koordinat wajar dibenarkan. Jika ditetapkan tidak, hanya alamat yang diterima.',
	'maps-finddestination-par-geoservice' => 'Perkhidmatan geokod yang digunakan untuk membuat geokod untuk nilai sekiranya berupa alamat.',
	'maps-finddestination-par-mappingservice' => 'Parameter untuk menunjukkan perkhidmatan pemetaan untuk digunakan dengan fungsi ini.
Ini akan membolehkan peta untuk mengatasi nilai asali parameter perkhidmatan dengan nilai yang paling sesuai untuk perkhidmatan pemetaan berkenaan.
(Contoh: Untuk Google Maps, pembuat geokod Google akan digunakan.)',
	'maps-geocode-par-location' => 'Alamat yang ingin dibuatkan geokod.',
	'maps-geocode-par-mappingservice' => 'Perkhidmatan geokod yang ingin digunakan. Lihat semua perkhidmatan geokod yang sedia ada.',
	'maps-geocode-par-geoservice' => 'Parameter ini membolehkan anda untuk menunjukkan bahawa anda sedang menggunakan permohonan geokod ini bersama perkhidmatan pemetaan yang tertentu.
Setiap khidmat pemetaan boleh mengatasi nilai asali untuk perkhidmatan geokod.
Ini adalah untuk pertimbangan legal, memandangkan anda tidak boleh menggunakan khidmat Google Geocoding melainkan bersama Google Maps.
Penetapan parameter ini dan bukan parameter untuk perkhidmatan tersebut akan memastikan anda tidak menggunakan gabungan yang tidak sah.',
	'maps-geocode-par-allowcoordinates' => 'Membolehkan pematian sokongan untuk koordinat dalam fungsi ini. Mesti memilih ya atau tidak.
Jika tidak, semua nilai akan ditukar menjadi geokod, termasuk koordinat yang sah.',
	'maps-geocode-par-format' => 'Format koordinat yang terhasil.',
	'maps-geocode-par-directional' => 'Menunjukkan sama ada koordinat wajar ditunjukkan berarah atau tidak.',
	'maps-geodistance-par-location1' => 'Titik pertama dalam peranggu untuk mengira jarak antara.',
	'maps-geodistance-par-location2' => 'Titik kedua dalam peranggu untuk mengira jarak antara.',
	'maps-geodistance-par-unit' => 'Unit paparan nilai jarak.',
	'maps-geodistance-par-decimals' => 'Bilangan maksimum angka pecahan untuk digunakan dalam nilai hasil.',
	'maps-geodistance-par-mappingservice' => 'Perkhidmatan geokod yang digunakan untuk membuat geokod alamat.',
	'maps-geodistance-par-geoservice' => 'Perkhidmatan pemetaan yang digunakan bersama yang ini.
Ini boleh mempengaruhi nilai asali perkhidmatan geokod.',
	'maps-displaymap-par-mappingservice' => 'Membolehkan penetapan perkhidmatan pemetaan yang akan digunakan untuk menghasilkan peta.',
	'maps-displaymap-par-coordinates' => 'Lokasi yang akan dijadikan pusat peta pada mulanya.',
	'maps-displaypoints-par-zoom' => 'Membolehkan penetapan tahap zum peta.
Apabila tidak diberikan sementara wujudnya berbilang penanda pada peta, zom yang paling muat akan diambil, bukan nilai asali yang terkonfigurasi.',
	'maps-displaypoints-par-mappingservice' => 'Membolehkan penetapan perkhidmatan pemetaan yang akan digunakan untuk menghasilkan peta.',
	'maps-displaypoints-par-coordinates' => 'Sekurang-kurangnya satu lokasi untuk dipaparkan pada peta. Ini akan ditunjukkan dengan penanda.',
	'maps-displaypoints-par-centre' => 'Membolehkan penetapan koordinat pusat peta untuk display_point.
Menerima alamat dan koordinat sekali.
Apabila sifat ini tidak dinyatakan, peta akan menentukan pusatnya sendiri pada penanda yang diberikan, ataupun di antara penanda-penanda yang diberikan.',
	'maps-displaypoints-par-title' => 'Membolehkan penetapan teks yang akan dipaparkan dalam tetimbul semua penanda yang tiada tajuk tertentu.
Apabila digunakan bersama label, tajuknya akan berupa tebal dan bergaris bawah.',
	'maps-displaypoints-par-label' => 'Membolehkan penetapan teks yang akan dipaparkan dalam tetimbul semua penanda yang tiada label tertentu.',
	'maps-displaypoints-par-icon' => 'Membolehkan penetapan ikon yang digunakan untuk semua penanda.',
	'validation-error-invalid-location' => 'Parameter $1 mestilah lokasi yang sah.',
	'validation-error-invalid-locations' => 'Parameter $1 mestilah sekurang-kurangnya satu lokasi yang sah.',
	'validation-error-invalid-width' => 'Parameter $1 mestilah lebar yang sah.',
	'validation-error-invalid-height' => 'Parameter $1 mestilah tinggi yang sah.',
	'validation-error-invalid-distance' => 'Parameter $1 mestilah jarak yang sah.',
	'validation-error-invalid-distances' => 'Parameter $1 mestilah sekurang-kurangnya satu jarak yang sah.',
	'validation-error-invalid-image' => 'Parameter $1 mestilah imej yang sah.',
	'validation-error-invalid-images' => 'Parameter $1 mestilah sekurang-kurangnya satu imej yang sah.',
	'validation-error-invalid-goverlay' => 'Parameter $1 mestilah tindanan yang sah.',
	'validation-error-invalid-goverlays' => 'Parameter $1 mestilah sekurang-kurangnya satu tindanan yang sah.',
	'maps-abb-north' => 'U',
	'maps-abb-east' => 'T',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'B',
	'maps-latitude' => 'Garis lintang:',
	'maps-longitude' => 'Garis bujur:',
	'maps-invalid-coordinates' => 'Nilai $1 tidak dikenali sebagai peranggu koordinat yang sah.',
	'maps_coordinates_missing' => 'Tiada koordinat diberikan bagi peta.',
	'maps_geocoding_failed' => '{{PLURAL:$2|Alamat|Alamat-alamat}} yang berikut tidak dapat dijadikan geokod: $1.',
	'maps_geocoding_failed_for' => '{{PLURAL:$2|Alamat|Alamat-alamat}} yang berikut tidak dapat dijadikan geokod dan digugurkan dari peta:
$1',
	'maps_unrecognized_coords' => '{{PLURAL:$2|Koordinat|Koordinat-koordinat}} yang berikut tidak dikenali: $1.',
	'maps_unrecognized_coords_for' => '{{PLURAL:$2|Koordinat|Koordinat-koordinat}} yang berikut tidak dikenali dan digugurkan dari peta:
$1',
	'maps_map_cannot_be_displayed' => 'Peta tidak dapat dipaparkan.',
	'maps-geocoder-not-available' => 'Tiada ciri geokod Peta. Lokasi anda tidak boleh diberi geokod.',
	'maps_click_to_activate' => 'Klik untuk mengaktifkan peta',
	'maps_centred_on' => 'Peta berpusat di $1, $2.',
	'maps-par-resizable' => 'Membolehkan pelarasan saiz peta dengan menyeret sudut kanan bawahnya.',
	'maps-par-geoservice' => 'Perkhidmatan geokod yang digunakan untuk membuat terjemahan antara alamat dan koordinat.',
	'maps-par-zoom' => 'Tahap zum peta. Untuk peta yang ada penanda, ini akan berpangkal kepada tahap paling kerap dizumkan yang masih memaparkan semua penanda.',
	'maps-par-width' => 'Membolehkan penetapan lebar peta. Pada asali, piksel dianggap sebagai unit, tetapi anda boleh menetapkan mana-mana unit yang berikut: px, ex, em, %.',
	'maps-par-height' => 'Membolehkan penetapan tinggi peta. Pada asali, piksel dianggap sebagai unit, tetapi anda boleh menetapkan mana-mana unit yang berikut: px, ex, em, %.',
	'maps-googlemaps2-incompatbrowser' => 'Pelayar anda tidak serasi dengan Google Maps v2.',
	'maps_overlays' => 'Tindanan',
	'maps_photos' => 'Gambar',
	'maps_videos' => 'Video',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Kamera web',
	'maps-googlemaps2-par-type' => 'Jenis peta untuk dipaparkan pada mulanya.',
	'maps-googlemaps2-par-types' => 'Jenis-jenis peta yang tersedia melalui kawalan jenis.',
	'maps-googlemaps2-par-controls' => 'Alat kawalan untuk diletakkan pada peta.',
	'maps-googlemaps2-par-autozoom' => 'Membolehkan penatalan dengan roda tetikus.',
	'maps-googlemaps2-par-kml' => 'Fail-fail KML untuk dimuatkan kepada peta.',
	'maps-googlemaps2-par-overlays' => 'Tindanan yang boleh dipasang oleh pengguna.',
	'maps-googlemaps3-incompatbrowser' => 'Pelayar anda tidak serasi dengan Google Maps v3.',
	'maps-googlemaps3-par-type' => 'Jenis peta untuk dipaparkan pada mulanya.',
	'maps-googlemaps3-par-types' => 'Jenis-jenis peta yang tersedia melalui kawalan jenis.',
	'maps-googlemaps3-par-layers' => 'Lapisan khas untuk dimuatkan kepada peta.',
	'maps-googlemaps3-par-controls' => 'Alat kawalan untuk diletakkan pada peta.',
	'maps-googlemaps3-par-zoomstyle' => 'Gaya kawalan zum.',
	'maps-googlemaps3-par-typestyle' => 'Gaya kawalan jenis.',
	'maps-googlemaps3-par-autoinfowindows' => 'Membuka semua tetingkap maklumat secara automatik selepas laman dimuatkan.',
	'maps-googlemaps3-par-kml' => 'Fail-fail KML untuk dimuatkan kepada peta.',
	'maps-googlemaps3-par-gkml' => 'Fail-fail KML yang dihoskan oleh Google untuk dimuatkan pada peta.',
	'maps-googlemaps3-par-fusiontables' => 'ID Google Fusion Tables yang patut dimuatkan pada peta.',
	'maps-googlemaps3-par-tilt' => 'Ciri menyendengkan Peta ketika menggunakan Google Maps.',
	'maps-googlemaps3-par-kmlrezoom' => 'Zumkan semula peta selepas lapisan-lapisan KML dimuatkan.',
	'maps-openlayers-par-controls' => 'Alat kawalan untuk diletakkan pada peta.',
	'maps-openlayers-par-layers' => 'Lapisan-lapisan yang akan tersedia pada pemilih lapisan. Lapisan pertama akan dipaparkan apabila peta dimuatkan.',
	'maps-osm-par-thumbs' => 'Tunjukkan gambar kenit (thumbnail)',
	'maps-osm-par-photos' => 'Tunjukkan gambar',
	'maps-yahoomaps-par-type' => 'Jenis peta untuk dipaparkan pada mulanya.',
	'maps-yahoomaps-par-types' => 'Jenis-jenis peta yang tersedia melalui kawalan jenis.',
	'maps-yahoomaps-par-controls' => 'Alat kawalan untuk diletakkan pada peta.',
	'maps-yahoomaps-par-autozoom' => 'Membolehkan penatalan dengan roda tetikus.',
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
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'maps-desc' => 'Biedt de mogelijkheid om locatiegegevens weer te geven op kaarten en adressen om te zetten naar coördinaten ([http://wiki.bn2vs.com/wiki/Semantic_Maps demo])',
	'right-geocode' => 'Geocoderen',
	'maps_map' => 'Kaart',
	'maps-loading-map' => 'Bezig met het laden van de kaart...',
	'maps-load-failed' => 'De kaart kon niet geladen worden!',
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
	'maps-coordinates-description' => 'Parserhook om coördinaten op te maken, van en naar alle ondersteunde notaties.',
	'maps-displaymap-description' => 'Geografische kaarten weergeven zonder in de wiki gedefinieerde markeringen.',
	'maps-displaypoint-description' => 'Geografische kaarten weergeven met een of meer in de wiki gedefinieerde markeringen.',
	'maps-distance-description' => 'Converteren naar een afstand met behulp van een bepaalde ondersteunde eenheid naar een equivalent in een andere eenheid.',
	'maps-finddestination-description' => 'Een bestemming vinden via een gegeven beginpunt (in elke ondersteunde notatie), een richting en een afstand.',
	'maps-geocode-description' => 'Maakt het geocoderen van adressen mogelijk, dat wil zeggen dat leesbare locaties worden omgezet in verzamelingen coördinaten. Er is ondersteuning voor verschillende geocoderingsdiensten die niet verward moeten worden met kaartdiensten.',
	'maps-geodistance-description' => 'De geografische afstand tussen twee punten berekenen, van en naar alle ondersteunde notaties.',
	'maps-mapsdoc-description' => 'Een tabel met de parameters voor een bepaalde kaartdienst weergeven samen met hun standaardwaarde en beschrijving.',
	'maps-mapsdoc-par-service' => 'De kaartdienst waarvoor parameterdocumentatie weergegeven moet worden.',
	'maps-mapsdoc-par-language' => 'De taal waarin de documentatie wordt weergegeven. Indien er geen vertaling beschikbaar is, wordt Engels in de plaats gebruikt.',
	'maps-coordinates-par-location' => 'De op te maken coördinaten.',
	'maps-coordinates-par-format' => 'Gewenste notatie voor de coördinaten.',
	'maps-coordinates-par-directional' => 'Geeft aan of de coördinaten wel of niet directioneel uitgestuurd moeten worden.',
	'maps-distance-par-distance' => 'De afstand om te converteren naar haar equivalent in een aangegeven eenheid.',
	'maps-distance-par-decimals' => 'Het maximale aantal te gebruiken decimalen in de resultaatwaarde.',
	'maps-distance-par-unit' => 'De eenheid waarin de afstand weergegeven moet worden.',
	'maps-finddestination-par-location' => 'De initiële locatie.',
	'maps-finddestination-par-bearing' => 'De initiële richting.',
	'maps-finddestination-par-distance' => 'De te reizen afstand.',
	'maps-finddestination-par-format' => 'De notatie waarin de bestemming weergegeven moet worden.',
	'maps-finddestination-par-directional' => 'Geeft aan of de notatie van de bestemming directioneel moet zijn of niet.',
	'maps-finddestination-par-allowcoordinates' => 'Geeft aan of coördinaten gebruikt mogen worden. Als deze waarde op "nee" is ingesteld, zijn alleen adressen toegestaan.',
	'maps-finddestination-par-geoservice' => 'De te gebruiken geocoderingsdienst in het geval de waarde een adres is.',
	'maps-finddestination-par-mappingservice' => 'Parameter om aan te geven welke kaartdienst bij deze functie gebruikt moet worden.
Dit maakt het mogelijk de standaard waarde van de dienstparameter te overschrijven met een waarde die optimaal is voor de kaartdienst.
Voorbeeld: in het geval van Google Maps, wordt de geocoderingsdienst van Google gebruikt.',
	'maps-geocode-par-location' => 'Het te geocoderen adres.',
	'maps-geocode-par-mappingservice' => 'De te gebruiken geocoderingsdienst. Alleen beschikbare geocoderingsdiensten zijn te gebruiken.',
	'maps-geocode-par-geoservice' => 'Parameter om aan te geven welke kaartdienst bij een geocoderingsverzoek gebruikt moet worden.
Voor iedere kaartdienst kan de standaard waarde voor de geocoderingsdienst overschreven worden.
Hieraan liggen juridische argumenten ten grondslag omdat het niet mogelijk is gebruik te maken van Google Geocoding tenzij dit in combinatie met Google Maps wordt gedaan.
Als deze parameter wordt ingesteld, en niet die voor de dienst, dan is het zeker dat er geen ongeldige combinatie van diensten wordt gebruikt.',
	'maps-geocode-par-allowcoordinates' => 'Maakt het mogelijk de ondersteuning voor coördinaten in deze functie uit te schakelen. De waarde moet "ja" of "nee" zijn.
Als deze "nee" is, wordt iedere waarde gegeocodeerd, ook als deze geldige coördinaten zijn.',
	'maps-geocode-par-format' => 'De notatie voor de resulterende coördinaten.',
	'maps-geocode-par-directional' => 'Geeft aan of de coördinaten directioneel uitgevoerd moeten worden of niet.',
	'maps-geodistance-par-location1' => 'Het eerste punt in de verzameling om de afstand tussen te berekenen.',
	'maps-geodistance-par-location2' => 'Het tweede punt in de verzameling om de afstand tussen te berekenen.',
	'maps-geodistance-par-unit' => 'De eenheid om de afstand in weer te geven.',
	'maps-geodistance-par-decimals' => 'Het maximale aantal te gebruiken decimalen in de resulterende waarde.',
	'maps-geodistance-par-mappingservice' => 'De te gebruiken geocoderingsdienst voor adressen.',
	'maps-geodistance-par-geoservice' => 'De kaartdienst die hierbij wordt gebruikt.
Dit kan invloed hebben op de standaardwaarde voor de geocoderingsdienst.',
	'maps-displaymap-par-mappingservice' => 'Maakt het mogelijk om de kaartdienst in te stellen die wordt gebruikt om de kaart te maken.',
	'maps-displaymap-par-coordinates' => 'De locatie die zich bij de eerste keer laden in het centrum van de kaart bevindt.',
	'maps-displaypoints-par-zoom' => 'Maakt het mogelijk het schaalniveau van de kaart in te stellen.
Als deze waarde niet wordt ingesteld en er staan meerdere markers op de kaart, dan wordt het best passende schaalniveau gekozen, niet het instelbare standaardniveau.',
	'maps-displaypoints-par-mappingservice' => 'Maakt het mogelijk de kaartdienst in te stellen die de kaart levert.',
	'maps-displaypoints-par-coordinates' => 'Een of meer weer te geven locaties op de kaart. Deze worden met een marker aangegeven.',
	'maps-displaypoints-par-centre' => 'Maakt het mogelijk de coördinaten voor het midden van de kaart in te stellen voor display_point(s).
Kan ingesteld worden met adressen en coördinaten.
Als deze waarde niet wordt ingesteld, wordt de kaart gecentreerd op of tussen de opgegeven marker(s).',
	'maps-displaypoints-par-title' => 'Maakt het mogelijk om tekst in te stellen die wordt weergegeven in de pop-ups van alle markeringen zonder gespecificeerd label.
Als dit samen met een label wordt gebruikt, wordt de titel vetgedrukt en onderstreept weergegeven.',
	'maps-displaypoints-par-label' => 'Maakt het mogelijk om tekst in te stellen die wordt weergegeven in de pop-ups van alle markeringen zonder gespecificeerd label.',
	'maps-displaypoints-par-icon' => 'Maakt het mogelijk het icoon voor alle markers in te stellen.',
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
	'maps-par-resizable' => 'Maakt het mogelijk de afmetingen van de kaart te wijzigen door aan de rechter onderhoek te trekken.',
	'maps-par-geoservice' => 'De te gebruiken geocoderingsdienst om tussen adressen en coördinaten te wisselen.',
	'maps-par-zoom' => 'Het zoomniveau van de kaart. Voor kaarten met markers is dit standaard op de meest ingezoomde niveau waarop nog steeds alle markers zichtbaar zijn.',
	'maps-par-width' => 'Maakt het mogelijk om de breedte van de kaart in te stellen. Standaard worden pixels als eenheid gebruikt, maar u kunt expliciet een van deze eenheden aangeven: px, ex, em, %.',
	'maps-par-height' => 'Maakt het mogelijk om de hoogte van de kaart in te stellen. Standaard worden pixels als eenheid gebruikt, maar u kunt expliciet een van deze eenheden aangeven: px, ex, em, %.',
	'maps-googlemaps2-incompatbrowser' => 'Uw browser kan niet werken met Google Maps v2.',
	'maps_overlays' => "Overlay's",
	'maps_photos' => 'Afbeeldingen',
	'maps_videos' => "Video's",
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcams',
	'maps-googlemaps2-par-type' => 'Het initieel weer te geven kaarttype.',
	'maps-googlemaps2-par-types' => 'De kaarttypen die beschikbaar zijn in via het besturingselement type.',
	'maps-googlemaps2-par-controls' => 'De op de kaart te plaatsen besturingselementen.',
	'maps-googlemaps2-par-autozoom' => 'Scrollen via het muiswiel inschakelen.',
	'maps-googlemaps2-par-kml' => 'Op de kaart te laden KML-bestanden.',
	'maps-googlemaps2-par-overlays' => 'Door gebruiker in schakelen overlays.',
	'maps-googlemaps3-incompatbrowser' => 'Uw browser kan niet werken met Google Maps v3.',
	'maps-googlemaps3-par-type' => 'Het initieel weer te geven kaarttype.',
	'maps-googlemaps3-par-types' => 'De kaarttypen die beschikbaar zijn in via het besturingselement type.',
	'maps-googlemaps3-par-layers' => 'Op de kaart te laden speciale lagen.',
	'maps-googlemaps3-par-controls' => 'De op de kaart te plaatsen besturingselementen.',
	'maps-googlemaps3-par-zoomstyle' => 'De stijl van het besturingselement zoom.',
	'maps-googlemaps3-par-typestyle' => 'De stijl van het besturingselement type.',
	'maps-googlemaps3-par-autoinfowindows' => 'Automatisch alle informatievensters openen na het laden van een pagina.',
	'maps-googlemaps3-par-kml' => 'Op de kaart te laden KML-bestanden.',
	'maps-googlemaps3-par-gkml' => 'KML-bestanden die gehost worden door Google om op de kaart te laden.',
	'maps-googlemaps3-par-fusiontables' => "Op de kaart te laden ID's van Google Fusion Tables.",
	'maps-googlemaps3-par-tilt' => 'Hoek voor de kaart bij gebruik van Google Maps.',
	'maps-googlemaps3-par-kmlrezoom' => 'Het zoomniveau van de kaart opnieuw instellen als de KML-lagen geladen zijn.',
	'maps-openlayers-par-controls' => 'De op de kaart te plaatsen besturingselementen.',
	'maps-openlayers-par-layers' => 'De lagen die beschikbaar zijn in het selectievak. De eerste laag worden weergegeven als de kaart wordt geladen.',
	'maps-osm-par-thumbs' => 'Miniaturen weergeven',
	'maps-osm-par-photos' => 'Afbeeldingen weergeven',
	'maps-yahoomaps-par-type' => 'Het initieel weer te geven kaarttype.',
	'maps-yahoomaps-par-types' => 'De kaarttypen die beschikbaar zijn in via het besturingselement type.',
	'maps-yahoomaps-par-controls' => 'De op de kaart te plaatsen besturingselementen.',
	'maps-yahoomaps-par-autozoom' => 'Scrollen via het muiswiel inschakelen.',
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
 * @author Event
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'maps-desc' => 'Gir mulighet for å bygge inn dynamiske kart i wikisider, geokoding av adresser og andre geografiske operasjoner.
([http://mapping.referata.com/wiki/Examples demoer]).',
	'maps_map' => 'Kart',
	'maps-loading-map' => 'Laster kart...',
	'maps-load-failed' => 'Kunne ikke laste kartet.',
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
	'maps-coordinates-description' => 'Parser-hook for å formatere koordinater, fra og til vilkårlige av de støttede formatene.',
	'maps-displaymap-description' => 'Vis geografiske kart uten wiki-spesifiserte markører.',
	'maps-displaypoint-description' => 'Vis geografiske kart med en eller flere wiki-spesifiserte markører.',
	'maps-distance-description' => 'Gjør om en distanse basert på en viss støttet enhet til tilsvarende verdi i en annen enhet.',
	'maps-finddestination-description' => 'Finn et mål med gitt startpunkt (som kan være i ett av de støttede formatene), en initial retning og distanse.',
	'maps-geocode-description' => 'Gjør tilgjengelig geokoding av adresser, dvs. gjør menneskelesbare lokasjoner til koordinatsett. Det finnes støtte for flere geokodingstjenester, som ikke må forveksles med mappingtjenester.',
	'maps-geodistance-description' => 'Beregn den geografiske avstanden mellom to punkter, fra og til et vilkårlig av de støttede formatene.',
	'maps-mapsdoc-description' => 'Vis en tabell med parametrene for en spesifisert mappingstjeneste sammen med deres standardverdier og beskrivelser.',
	'maps-mapsdoc-par-service' => 'Mappingstjenesten for å vise parameterdokumentasjon.',
	'maps-mapsdoc-par-language' => 'Språket for å vise dokumentasjonen. Hvis ingen slik oversettelse er tilgjengelig, blir engelsk brukt.',
	'maps-coordinates-par-location' => 'Koordinatene du ønsker å formatere.',
	'maps-coordinates-par-format' => 'Målformatet for koordinatene.',
	'maps-coordinates-par-directional' => 'Angir om koordinatene burde vises med retning eller ikke.',
	'maps-distance-par-distance' => 'Avstanden som skal omregnes til en bestemt enhet.',
	'maps-distance-par-decimals' => 'Maksimalt antall desimalsifre som skal brukes for resulterende verdi.',
	'maps-distance-par-unit' => 'Enhet for visning av avstand.',
	'maps-finddestination-par-location' => 'Opprinnelig lokasjon.',
	'maps-finddestination-par-distance' => 'Reiseavstand',
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
	'maps-desc' => "Permet d'afichar de coordenadas dins de mapas, e mai d'adreça geocodadas
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

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 */
$messages['or'] = array(
	'maps-others' => 'ବାକିସବୁ',
	'maps-ns-layer' => 'ସ୍ତର',
	'maps-layer-value' => 'ମୂଲ୍ୟ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'O',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'W',
	'maps_wikipedia' => 'Wikipedia',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Yarl
 */
$messages['pl'] = array(
	'maps-desc' => 'Umożliwia zamieszczanie na stronach wiki dynamicznych map, geograficznie kodowanych adresów i innych danych geograficznych. ([http://mapping.referata.com/wiki/Examples demo])',
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
	'maps-desc' => "A abìlita l'anseriment ëd carte ant le pàgine ëd la wiki, dj'adrësse geocodificà e d'àutre operassion geogràfiche ([http://mapping.referata.com/wiki/Esempi dimostrassion]).",
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
	'maps-error-invalid-layertype' => 'A-i é pa gnun livej ëd sòrt "$1". A {{PLURAL:$3|l\'é mach mantùa costa|a son mach mantnùe coste}} sòrt: $2',
	'maps-error-no-layertype' => "A dev specifiché la sòrt ëd livel. Mach {{PLURAL:$2|sta sòrt a l'é mantnùa|ste sòrt a son mantnùe}}: $1",
	'validation-error-invalid-layer' => 'Ël paràmetr $1 a dev esse un livel bon.',
	'validation-error-invalid-layers' => 'Ël paràmetr $1 a dev esse un o pi livej bon.',
	'maps-layer-of-type' => 'Livel ëd sòrt $1',
	'maps-layer-type-supported-by' => 'Costa sòrt ëd livel a peul {{PLURAL:$2|mach esse dovrà con ël servissi ëd cartografìa $1|esse dovrà con sti servissi ëd cartografìa: $1}}.',
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
	'maps-layer-value' => 'ارزښت',
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
 * @author Alchimista
 * @author Giro720
 * @author GoEThe
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Waldir
 */
$messages['pt'] = array(
	'maps-desc' => 'Permite incorporar mapas dinâmicos nas páginas da wiki, converter endereços em geocódigos e outras operações geográficas ([http://mapping.referata.com/wiki/Examples demonstração])',
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'A carregar o mapa...',
	'maps-load-failed' => 'Não foi possível carregar o mapa!',
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
	'maps-coordinates-description' => 'Hook do analisador sintáctico para formatar coordenadas, a partir de qualquer um dos formatos suportados para qualquer outro formato suportado.',
	'maps-displaymap-description' => 'Apresentar os mapas sem qualquer marcador definido na wiki.',
	'maps-displaypoint-description' => 'Apresentar os mapas com um ou mais marcadores definidos na wiki.',
	'maps-distance-description' => 'Converter uma distância numa unidade suportada para a distância equivalente noutra unidade.',
	'maps-finddestination-description' => 'Encontrar um destino a partir de um ponto de partida (expresso em qualquer um dos formatos suportados), uma orientação inicial e uma distância.',
	'maps-geocode-description' => 'Permite a geocodificação de moradas; por outras palavras, transforma locais legíveis por seres humanos em conjuntos de coordenadas. Há apoio para vários serviços de geocodificação, que não devem ser confundidos com serviços de cartografia.',
	'maps-geodistance-description' => 'Calcula a distância geográfica entre dois pontos, a partir e para qualquer um dos formatos suportados.',
	'maps-mapsdoc-description' => 'Apresentar uma tabela com os parâmetros de um serviço de cartografia especificado, em conjunto com os respectivos valores por omissão e descrições.',
	'maps-mapsdoc-par-service' => 'O serviço de cartografia para o qual será apresentada a documentação dos parâmetros.',
	'maps-mapsdoc-par-language' => 'A língua de apresentação da documentação. Se essa tradução não estiver disponível, será usado o inglês.',
	'maps-coordinates-par-location' => 'As coordenadas que quer formatar.',
	'maps-coordinates-par-format' => 'O formato em que quer as coordenadas.',
	'maps-coordinates-par-directional' => 'Indica se as coordenadas devem ser produzidas com formato direccional ou não.',
	'maps-distance-par-distance' => 'A distância para converter para a equivalente numa unidade especificada.',
	'maps-distance-par-decimals' => 'O número máximo de casas decimais a usar no valor resultante.',
	'maps-distance-par-unit' => 'As unidades em que a distância será produzida.',
	'maps-finddestination-par-location' => 'A localização inicial.',
	'maps-finddestination-par-bearing' => 'A direcção inicial.',
	'maps-finddestination-par-distance' => 'A distância a percorrer.',
	'maps-finddestination-par-format' => 'O formato em que sairá o destino.',
	'maps-finddestination-par-directional' => 'Indica se o formato do destino deve ser direccional ou não.',
	'maps-finddestination-par-allowcoordinates' => 'Indica se devem ser permitidas coordenadas. Se marcado como não, apenas serão aceites moradas.',
	'maps-finddestination-par-geoservice' => 'O serviço de geocodificação a usar para geocodificar o valor em caso de ser uma morada.',
	'maps-finddestination-par-mappingservice' => 'Parâmetro para indicar o serviço de cartografia a usar com esta função.
Isto permite que os mapas substituam o valor padrão do parâmetro do serviço pelo valor óptimo para o serviço de cartografia.
(Exemplo: No caso do Google Maps, será usado o geocodificador do Google.)',
	'maps-geocode-par-location' => 'A morada que quer geocodificar.',
	'maps-geocode-par-mappingservice' => 'O serviço de geocodificação que deseja usar. Consulte os serviços de geocodificação disponíveis.',
	'maps-geocode-par-geoservice' => 'Este parâmetro permite-lhe indicar se está a usar este pedido de geocodificação em combinação com um serviço de cartografia específico.
Para cada serviço de cartografia é possível substituir o valor padrão do serviço de geocodificação.
Isto tem uma justificação legal, posto que o serviço de Geocodificação do Google só pode ser usado em conjunto com o Google Maps.
Definir este parâmetro e não o parâmetro para o serviço, garante que não se está a usar uma combinação inválida.',
	'maps-geocode-par-allowcoordinates' => 'Permite desactivar o suporte de coordenadas desta função. Tem de ser sim ou não.
Quando for não, todos os valores serão geocodificados, mesmo coordenadas válidas.',
	'maps-geocode-par-format' => 'O formato das coordenadas resultantes.',
	'maps-geocode-par-directional' => 'Indica se as coordenadas devem ser produzidas com formato direccional ou não.',
	'maps-geodistance-par-location1' => 'O primeiro ponto do conjunto para calcular a distância entre dois pontos.',
	'maps-geodistance-par-location2' => 'O segundo ponto do conjunto para calcular a distância entre dois pontos.',
	'maps-geodistance-par-unit' => 'As unidades em que a distância será produzida.',
	'maps-geodistance-par-decimals' => 'O número máximo de casas decimais a usar no valor resultante.',
	'maps-geodistance-par-mappingservice' => 'O serviço de geocodificação que será usado para geocodificar qualquer endereço.',
	'maps-geodistance-par-geoservice' => 'O serviço de cartografia a utilizar em conjunto.
Isto pode afectar o valor padrão do serviço de geocodificação.',
	'maps-displaymap-par-mappingservice' => 'Permite definir o serviço de cartografia que será usado para gerar o mapa.',
	'maps-displaymap-par-coordinates' => 'A localização na qual o mapa será inicialmente centrado.',
	'maps-displaypoints-par-zoom' => 'Permite definir o nível de aproximação do mapa.
Quando este não for fornecido e existirem vários marcadores no mapa, será usada a aproximação que resulte no melhor dimensionamento, não o valor padrão configurado.',
	'maps-displaypoints-par-mappingservice' => 'Permite definir o serviço de cartografia que será usado para gerar o mapa.',
	'maps-displaypoints-par-coordinates' => 'Uma ou mais localizações a mostrar no mapa. Estas serão indicadas com um marcador.',
	'maps-displaypoints-par-centre' => 'Permite definir as coordenadas do centro do mapa para display_point(s).
Aceita tanto endereços como coordenadas.
Quando esta propriedade não for fornecida, o mapa será centrado no marcador fornecido, ou entre os marcadores fornecidos.',
	'maps-displaypoints-par-title' => 'Permite a configuração do texto que será apresentado nos pop-ups de todos os marcadores que não têm um título específico.
Quando usado em conjunto com um rótulo, o título aparecerá a negrito e sublinhado.',
	'maps-displaypoints-par-label' => 'Permite a configuração do texto que será apresentado nos pop-ups de todos os marcadores que não têm um rótulo específico.',
	'maps-displaypoints-par-icon' => 'Permite configurar o ícone usado para todos os marcadores.',
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
	'maps-par-resizable' => 'Permite alterar as dimensões do mapa, arrastando o canto inferior direito.',
	'maps-par-geoservice' => 'O serviço de geocodificação que será usado para fazer a conversão entre endereços e coordenadas.',
	'maps-par-zoom' => 'O nível de aproximação do mapa. Nos mapas com marcadores será usada a maior aproximação que, mesmo assim, mostre todos os marcadores.',
	'maps-par-width' => 'Permite definir a largura do mapa. A unidade por omissão é o pixel, mas pode defini-la explicitamente como: px, ex, em, %.',
	'maps-par-height' => 'Permite definir a altura do mapa. A unidade por omissão é o pixel, mas pode defini-la explicitamente como: px, ex, em, %.',
	'maps-googlemaps2-incompatbrowser' => 'O seu browser não é compatível com o Google Maps v2.',
	'maps_overlays' => 'Sobreposições',
	'maps_photos' => 'Fotografias',
	'maps_videos' => 'Vídeos',
	'maps_wikipedia' => 'Wikipédia',
	'maps_webcams' => 'Câmaras Web',
	'maps-googlemaps2-par-type' => 'O tipo de mapa que será apresentado inicialmente.',
	'maps-googlemaps2-par-types' => 'Os tipos de mapas que estarão disponíveis através do controlo de tipos.',
	'maps-googlemaps2-par-controls' => 'Os controlos que serão colocados no mapa.',
	'maps-googlemaps2-par-autozoom' => 'Permitir deslizar usando a roda de deslizamento do rato.',
	'maps-googlemaps2-par-kml' => 'Ficheiros KML que serão carregados no mapa.',
	'maps-googlemaps2-par-overlays' => 'Sobreposições que o utilizador pode activar.',
	'maps-googlemaps3-incompatbrowser' => 'O seu browser não é compatível com o Google Maps v3.',
	'maps-googlemaps3-par-type' => 'O tipo de mapa que será apresentado inicialmente.',
	'maps-googlemaps3-par-types' => 'Os tipos de mapas que estarão disponíveis através do controlo de tipos.',
	'maps-googlemaps3-par-layers' => 'As camadas especiais que serão carregadas no mapa.',
	'maps-googlemaps3-par-controls' => 'Os controlos que serão colocados no mapa.',
	'maps-googlemaps3-par-zoomstyle' => 'O estilo do controlo da aproximação.',
	'maps-googlemaps3-par-typestyle' => 'O estilo do controlo de tipos.',
	'maps-googlemaps3-par-autoinfowindows' => 'Abrir automaticamente todas as janelas informativas depois de carregar a página.',
	'maps-googlemaps3-par-kml' => 'Ficheiros KML que serão carregados no mapa.',
	'maps-googlemaps3-par-gkml' => 'Ficheiros KML alojados pelo Google que serão carregados no mapa.',
	'maps-googlemaps3-par-fusiontables' => 'Identificação das Google Fusion Tables que deverão ser carregadas no mapa.',
	'maps-openlayers-par-controls' => 'Os controlos que serão colocados no mapa.',
	'maps-openlayers-par-layers' => 'As camadas que estarão disponíveis no selector de camadas. A primeira camada será apresentada quando o mapa for carregado.',
	'maps-osm-par-thumbs' => 'Mostrar miniaturas',
	'maps-osm-par-photos' => 'Mostrar fotografias',
	'maps-yahoomaps-par-type' => 'O tipo de mapa que será apresentado inicialmente.',
	'maps-yahoomaps-par-types' => 'Os tipos de mapas que estarão disponíveis através do controlo de tipos.',
	'maps-yahoomaps-par-controls' => 'Os controlos que serão colocados no mapa.',
	'maps-yahoomaps-par-autozoom' => 'Permitir deslizar usando a roda de deslizamento do rato.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'maps-desc' => 'Provê a possibilidade de exibir dados de coordenadas em mapas e endereços em geocódigo. ([http://mapping.referata.com/wiki/Maps_examples demonstração]).
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
	'maps-desc' => 'Permite încorporarea hărților dinamice în paginile wiki, precum și geocodificarea adreselor ori efectuarea altor operațiuni de ordin geografic ([http://mapping.referata.com/wiki/Examples demonstrație]).',
	'maps_map' => 'Hartă',
	'maps-loading-map' => 'Se încarcă harta...',
	'maps-markers' => 'Marcatori',
	'maps-others' => 'altele',
	'maps-ns-layer' => 'Strat',
	'maps-layer-value' => 'Valoare',
	'maps-layer-errors' => 'Erori',
	'maps-error-invalid-layerdef' => 'Definiția acestui strat este incorectă.',
	'maps-error-invalid-layertype' => 'Nu există straturi de tip „$1”. Se acceptă doar {{PLURAL:$3|acest tip|aceste tipuri}}: $2',
	'maps-error-no-layertype' => 'Trebuie să specificați tipul stratului. Se acceptă doar {{PLURAL:$2|acest tip|aceste tipuri}}: $1',
	'validation-error-invalid-layer' => 'Parametrul $1 trebuie să fie un strat valabil.',
	'validation-error-invalid-layers' => 'Parametrul $1 trebuie să fie una sau mai multe straturi valide.',
	'maps-layer-of-type' => 'Strat de tip $1',
	'validation-error-invalid-location' => 'Parametrul $1 trebuie să fie o locaţie validă.',
	'validation-error-invalid-locations' => 'Parametrul $1 trebuie să fie una sau mai multe locaţii valide.',
	'validation-error-invalid-distance' => 'Parametrul $1 trebuie să reprezinte o distanță validă.',
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
	'maps-desc' => "Dèje l'abbilità a sckaffà le mappe dinameche 'ngapsulate jndr'à le pàggene de Uicchi, geocodificate e indirizzate a otre operaziune sciugrafeche. ([http://mapping.referata.com/wiki/Maps_examples demo])",
	'maps_map' => 'Mappe',
	'maps-loading-map' => "Stoche a careche 'a mappe...",
	'maps-others' => 'otre',
	'maps-layer-value' => 'Valore',
	'maps-layer-errors' => 'Errore',
	'maps-abb-north' => 'N',
	'maps-abb-east' => 'E',
	'maps-abb-south' => 'S',
	'maps-abb-west' => 'O',
	'maps_photos' => 'Foto',
	'maps_videos' => 'Video',
	'maps_wikipedia' => 'Uicchipèdie',
);

/** Russian (Русский)
 * @author Adata80
 * @author Haffman
 * @author Lockal
 * @author MaxSem
 * @author McDutchie
 * @author Yuriy Apostol
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'maps-desc' => 'позволяет встраивать динамические карты в вики-страницы, геокодировать адреса, выполнять другие географические действия. ([http://mapping.referata.com/wiki/Examples Примеры исползования])',
	'maps_map' => 'Карта',
	'maps-loading-map' => 'Идёт загрузка карты…',
	'maps-load-failed' => 'Невозможно загрузить карту!',
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
	'maps-coordinates-description' => 'Перехватчик синтаксического анализатора для форматирования координат из любого и в любой поддерживаемый формат.',
	'maps-displaymap-description' => 'Отображение географических карт без каких-либо вики-маркеров на них.',
	'maps-displaypoint-description' => 'Отображение географических карт с одним или несколькими вики-маркерами на них.',
	'maps-distance-description' => 'Преобразование расстояния, выраженного в определенных поддерживаемых единицах, в его эквивалент в других единицах.',
	'maps-finddestination-description' => 'Найти место назначения от заданной начальной точки (может быть в любом формате из поддерживаемых), начальное направление и расстояние.',
	'maps-geocode-description' => 'Включает геокодирование адресов. Иными словами, преобразует понятные человеку названия мест в наборы координат. Поддерживается несколько сервисов геокодирования, которые не следует путать с картографическими сервисами.',
	'maps-geodistance-description' => 'Рассчитать географическое расстояние между двумя точками, из любого и в любой поддерживаемый формат.',
	'maps-coordinates-par-location' => 'Координаты, которые требуется отформатировать.',
	'maps-coordinates-par-format' => 'Целевой формат координат.',
	'maps-coordinates-par-directional' => 'Указывает, должны ли координаты выводиться непосредственно или нет.',
	'maps-distance-par-distance' => 'Расстояние для преобразования в эквивалентное в указанных единицах.',
	'maps-distance-par-decimals' => 'Максимальное количество цифр дробной части в результирующем значении.',
	'maps-distance-par-unit' => 'Единицы, в которых будет отображено расстояние.',
	'maps-finddestination-par-location' => 'Исходное положение.',
	'maps-finddestination-par-bearing' => 'Начальное направление.',
	'maps-finddestination-par-distance' => 'Протяжённость путешествия.',
	'maps-finddestination-par-format' => 'Формат, в котором отображается пункт назначения.',
	'maps-finddestination-par-directional' => 'Указывает, должен ли формат назначения быть направленным или нет.',
	'maps-finddestination-par-allowcoordinates' => 'Указывает, разрешены ли координаты. Если установлено значение «нет», будут приниматься только адреса.',
	'maps-finddestination-par-geoservice' => 'Сервис геокодирования для географического преобразования значения в случае, если оно является адресом.',
	'maps-finddestination-par-mappingservice' => 'Параметр для указания картографической службы для использования с этой функцией. 
Позволяет карте переопределить значение служебного параметра по умолчанию службы на оптимальное для картографической службы.
(Например, для карт Google, использовать геокодирование Google.)',
	'maps-geocode-par-location' => 'Адрес, который вы желаете геокодировать.',
	'maps-geocode-par-mappingservice' => 'Служба геокодирования, которую вы хотите использовать. См. список доступных служб геокодирования.',
	'maps-geocode-par-geoservice' => 'Этот параметр позволяет указать, что вы используете этот запрос геокодирования в сочетании с конкретной картографической службой. 
Каждая картографическая служба может иметь переопределение службы геокодирования по умолчанию.
Это делается из юридических соображений, так как вы можете использовать службу геокодирования Google только вместе с картами Google.
Установка этого параметра, а не параметра для службы, будет гарантировать, что вы не используете недопустимое сочетание.',
	'maps-geocode-par-allowcoordinates' => 'Позволяет отключить поддержку координат в этой функции. Должно быть указано «да» или «нет».
Если «нет», то каждое значение будет геокодировано, даже правильные координаты.',
	'maps-geocode-par-format' => 'Формат получаемых координат.',
	'maps-geocode-par-directional' => 'Указывает, должны ли координаты выводиться непосредственно или нет.',
	'maps-geodistance-par-location1' => 'Первая точка в наборе для расчёта расстояния.',
	'maps-geodistance-par-location2' => 'Вторая точка в наборе для расчёта расстояния.',
	'maps-geodistance-par-unit' => 'Единица измерения расстояния.',
	'maps-geodistance-par-decimals' => 'Наибольшее количество цифр в дробной части результата.',
	'maps-geodistance-par-mappingservice' => 'Служба геокодирования, используемая для кодирования любого адреса.',
	'maps-displaymap-par-mappingservice' => 'Позволяет выбрать сервис карт, который будет использоваться.',
	'maps-displaypoints-par-mappingservice' => 'Позволяет указывать сервис карт, который будет использоваться.',
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
	'maps-googlemaps2-incompatbrowser' => 'Ваш браузер несовместим с Google Maps v2.',
	'maps_overlays' => 'Слои',
	'maps_photos' => 'Фото',
	'maps_videos' => 'Видео',
	'maps_wikipedia' => 'Википедия',
	'maps_webcams' => 'Веб-камеры',
	'maps-googlemaps2-par-kml' => 'KML файлы для загрузки на карту.',
	'maps-googlemaps3-incompatbrowser' => 'Ваш браузер несовместим с Google Maps v3.',
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
	'maps-desc' => 'Poskytuje možnosť zobrazovať údaje súradníc na mapách a tvoriť geografické adresy lokalít ([http://wiki.bn2vs.com/wiki/Semantic_Maps demo]).
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

/** Slovenian (Slovenščina)
 * @author Dbc334
 * @author Lesko987
 */
$messages['sl'] = array(
	'maps-desc' => 'Omogoča vključevanje dinamičnih zemljevidov na wiki strani, geokodiranje naslovov in drugih geografskih operacij. ([http://mapping.referata.com/wiki/Examples Primeri])',
	'maps_map' => 'Zemljevid',
	'maps-loading-map' => 'Nakladanje zemljevida...',
	'maps-load-failed' => 'Zemljevid ni bilo mogoče naložiti.',
	'maps-abb-north' => 'S',
	'maps-abb-east' => 'V',
	'maps-abb-south' => 'J',
	'maps-abb-west' => 'Z',
	'maps-latitude' => 'Zemljepisna širina:',
	'maps-longitude' => 'Zemljepisna dolžina:',
	'maps_googlemaps2' => 'Google Maps v2',
	'maps_googlemaps3' => 'Google Maps v3',
	'maps_yahoomaps' => 'Yahoo! Maps',
	'maps_openlayers' => 'OpenLayers',
	'maps_osm' => 'OpenStreetMap',
	'maps_photos' => 'Fotografije',
	'maps_videos' => 'Videoposnetki',
	'maps_wikipedia' => 'Wikipedija',
	'maps_webcams' => 'Spletne kamere',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
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
	'maps_googlemaps2' => 'Гугл мапе, друго издање',
	'maps_googlemaps3' => 'Гугл мапе, треће издање',
	'maps_yahoomaps' => 'Јаху мапе',
	'maps_openlayers' => 'Опенлејерс',
	'maps_osm' => 'Опенстритмап',
	'maps_photos' => 'Фотографије',
	'maps_videos' => 'Видео снимци',
	'maps_webcams' => 'Веб-камере',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
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
 * @author Fader
 * @author Fluff
 * @author Per
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'maps-desc' => 'Ger möjlighet att bädda in dynamiska kartor i wiki-sidor, geokoding av adresser och andra geografiska åtgärder. ([http://mapping.referata.com/wiki/Maps_examples Demo]).',
	'right-geocode' => 'Geokod',
	'maps_map' => 'Karta',
	'maps-loading-map' => 'Laddar karta ...',
	'maps-load-failed' => 'Kunde inte läsa in karta!',
	'maps-markers' => 'Markörer',
	'maps-others' => 'andra',
	'maps-ns-layer' => 'Lager',
	'maps-ns-layer-talk' => 'Lagerdiskussion',
	'maps-layer-property' => 'Egenskap',
	'maps-layer-value' => 'Värde',
	'maps-layer-errors' => 'Fel',
	'maps-error-invalid-layerdef' => 'Denna lagerdefinition är inte giltigt.',
	'maps-error-invalid-layertype' => 'Det finns inga lager av typen "$1". Endast {{PLURAL:$3|denna typ|denna typer}} stöds: $2',
	'maps-error-no-layertype' => 'Du måste ange lagertypen. {{PLURAL:$2|Endast denna typ|Dessa typer}} stöds: $1',
	'validation-error-invalid-layer' => 'Parameter $1 måste vara ett giltig lager.',
	'validation-error-invalid-layers' => 'Parameter $1 måste vara ett eller flera giltiga lager.',
	'maps-layer-of-type' => 'Lagertyp $1',
	'maps-layer-type-supported-by' => 'Denna lagertyp kan endast användas med {{PLURAL:$2|kartläggningstjänsten $1|dessa kartläggningstjänster: $1}}.',
	'maps-mapsdoc-par-service' => 'Kartläggningstjänsten för att visa parameterdokumentation.',
	'maps-mapsdoc-par-language' => 'Språket som du vill visa dokumentationen i. Om det finns någon sådan översättning kommer engelska att användas istället.',
	'maps-finddestination-par-distance' => 'Reseavståndet.',
	'maps-geocode-par-location' => 'Adressen som du vill geokoda.',
	'maps-geocode-par-mappingservice' => 'Geokodningstjänsten du vill använda. Se de tillgängliga geokodningtjänsterna.',
	'validation-error-invalid-location' => 'Parameter $1 måste vara en giltig plats.',
	'validation-error-invalid-locations' => 'Parameter $1 måste vara en eller flera giltiga platser.',
	'validation-error-invalid-width' => 'Parameter $1 måste vara en giltig bredd.',
	'validation-error-invalid-height' => 'Parameter $1 måste vara en giltig höjd.',
	'validation-error-invalid-distance' => 'Parameter $1 måste vara ett giltigt avstånd.',
	'validation-error-invalid-distances' => 'Parameter $1 måste vara en eller flera giltiga avstånd.',
	'validation-error-invalid-image' => 'Parameter $1 måste vara en giltig bild.',
	'validation-error-invalid-images' => 'Parameter $1 måste vara en eller flera giltiga bilder.',
	'validation-error-invalid-goverlay' => 'Parameter $1 måste vara ett giltigt överlägg.',
	'validation-error-invalid-goverlays' => 'Parameter $1 måste vara en eller flera giltiga överlägg.',
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
	'maps_unrecognized_coords' => 'Följande {{PLURAL:$2|koordinat|koordinater}} kändes inte igen: $1.',
	'maps_unrecognized_coords_for' => 'Följande {{PLURAL:$2|koordinat|koordinater}} kändes inte igen och {{PLURAL:$2|har|har}} utelämnats från kartan:
$1',
	'maps_map_cannot_be_displayed' => 'Kartan kan inte visas.',
	'maps_click_to_activate' => 'Klicka för att aktivera karta',
	'maps_centred_on' => 'Karta centrerad på $1, $2.',
	'maps-googlemaps2-incompatbrowser' => 'Din webbläsare är inte kompatibel med Google Maps v2.',
	'maps_overlays' => 'Överlägg',
	'maps_photos' => 'Foton',
	'maps_videos' => 'Videoklipp',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webbkameror',
	'maps-googlemaps2-par-autozoom' => 'Aktivera rullning med mushjulet.',
	'maps-googlemaps2-par-overlays' => 'Överlägg användaren kan aktivera.',
	'maps-googlemaps3-incompatbrowser' => 'Din webbläsare är inte kompatibel med Google Maps v3.',
	'maps-osm-par-photos' => 'Visa foton',
	'maps-yahoomaps-par-autozoom' => 'Aktivera rullning med mushjulet.',
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
	'maps-desc' => 'ให้ความสามารถในการแสดงพิกัดในแผนที่ และที่อยู่ที่เป็นรหัสทางภูมิศาสตร์([http://mapping.referata.com/wiki/Maps_examples demo]).
<br />บริการแผนที่ที่มีอยู่: $1',
	'maps_coordinates_missing' => 'ไม่ได้กำหนดพิกัดของแผนที่มาให้',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'maps-desc' => 'Nagpapagana ng pagbabaon ng gumagalaw na mga mapa papaloob sa mga pahina ng wiki, pagkokodigong pangheograpiya ng mga tirahan at ibang mga gawaing pangheograpiya. ([http://mapping.referata.com/wiki/Examples mga pagpapatunghay])

kakayahang ipakita ang dato ng tugmaang-pampook sa loob ng mga mapa, at mga triahan ([http://mapping.referata.com/wiki/Maps_examples mga pagpapatunghay])',
	'maps_map' => 'Mapa',
	'maps-loading-map' => 'Ikinakarga ang mapa...',
	'maps-load-failed' => 'Hindi maikarga ang mapa!',
	'maps-markers' => 'Mga palatandaan',
	'maps-others' => 'iba pa',
	'maps-ns-layer' => 'Patong',
	'maps-ns-layer-talk' => 'Usapan sa patong',
	'maps-layer-property' => 'Ari-arian',
	'maps-layer-value' => 'Halaga',
	'maps-layer-errors' => 'Mga kamalian',
	'maps-error-invalid-layerdef' => 'Hindi tanggap ang kahulugan ng patong.',
	'maps-error-invalid-layertype' => 'Walang mga patong ng uring "$1".  Tanging {{PLURAL:$3|ganitong uri|ganitong mga uri}} lamang ang tinatangkilik: $2',
	'maps-error-no-layertype' => 'Kailangan mong tukuyin ang uri ng patong. {{PLURAL:$2|Ganitong uri lamang ang|Ganitong mga uri ang}} tinatangkilik: $1',
	'validation-error-invalid-layer' => 'Ang parametrong $1 ay dapat na isang tanggap na patong.',
	'validation-error-invalid-layers' => 'Ang parametrong $1 ay dapat na isa o mahigit pang katanggap-tanggap na mga patong.',
	'maps-layer-of-type' => 'Patong ng uring $1',
	'maps-layer-type-supported-by' => 'Ang ganitong uri ng patong ay {{PLURAL:$2|magagamit lamang sa $1 na palingkuran ng pagmamapa|magagamit lamang sa ganitong mga palingkuran ng pagmamapa: $1}}.',
	'maps-coordinates-description' => 'Kawint ng banghay upang maianyo ang mga tugmaang-pampook, magmula at papunta sa anuman sa tinatangkilik na mga anyo.',
	'maps-displaymap-description' => 'Ipakita ang mga mapang pangheograpiya na walang anumang tinukoy na pangwiking mga pananda sa ibabaw nila.',
	'maps-displaypoint-description' => 'Ipakita ang mga mapang pangheograpiya na may isa o higit pang tinukoy na pangwiking mga pananda sa ibabaw nila.',
	'maps-finddestination-description' => 'Maghanap ng isang patutunguhan na binigyan ng tuldok ng pagsisimula (na maaaring nasa loob ng anuman sa tinatangkilik na mga anyo), isang paunang kapupuntahan at isang layo.',
	'maps-geodistance-description' => 'Tuusin ang pangheograpiyang layo sa pagitan ng dalawang mga tuldok, magmula at papunta sa anumang tinatangkilik na mga anyo.',
	'maps-coordinates-par-location' => 'Ang mga tugmaang-pampook na nais mong iayos ang anyo.',
	'maps-coordinates-par-format' => 'Ang pinupukol na anyo para sa mga tugmaang-pampook.',
	'maps-coordinates-par-directional' => 'Nagpapahiwatig kung ang mga tugmaang-pampook ay dapat na ilabas bilang pangpatutunguhan o hindi.',
	'maps-distance-par-distance' => 'Ang layo na gagawing katumbas nito na may tinukoy na yunit.',
	'maps-distance-par-decimals' => 'Ang pinakamataas na bilang ng kakarampot na mga tambilang na gagamitin sa kalalabasang halaga.',
	'maps-distance-par-unit' => 'Ang yunit na kalalabasan ng layo.',
	'maps-finddestination-par-location' => 'Ang paunang kinalalagyan.',
	'maps-finddestination-par-bearing' => 'Ang paunang patutunguhan.',
	'maps-finddestination-par-distance' => 'Ang layo ng lalakbayin.',
	'maps-finddestination-par-format' => 'Ang anyo kung paano ilalabas ang patutunguhan.',
	'maps-geocode-par-location' => 'Ang tirahan na nais mong ikodigong pangheograpiya.',
	'maps-geocode-par-format' => 'Ang anyo para sa kinalalabasang mga tugmaang pampook.',
	'maps-geocode-par-directional' => 'Nagpapahiwatig kung ang mga tugmaang-pampook ay dapat na ilabas bilang pangpatutunguhan o hindi.',
	'maps-geodistance-par-location1' => 'Ang unang tuldok sa loob ng isang pangkat upang tuusin ang layo sa pagitan.',
	'maps-geodistance-par-location2' => 'Ang pangalawang tuldok sa loob ng isang pangkat upang tuusin ang layo sa pagitan.',
	'maps-geodistance-par-unit' => 'Ang yunit na kinapapalooban ng kinalalabasan ng layo.',
	'maps-geodistance-par-decimals' => 'Ang pinakamataas na bilang ng kakarampot na mga tambilang na gagamitin sa kalalabasang halaga.',
	'maps-geodistance-par-mappingservice' => 'Ang palingkuran ng pagkokodigong pangheograpiya na gagamitin upang maikodigong pangheograpiya ang anumang mga tirahan.',
	'maps-displaymap-par-mappingservice' => 'Nagpapahintulot na maitakda ang palingkuran ng pagmamapa na gagamitin upang likhain ang mapa.',
	'maps-displaymap-par-coordinates' => 'Ang kinalalagyan na paunang pagpapagitnaan ng mapa.',
	'maps-displaypoints-par-zoom' => 'Nagpapahintulot sa pagtatakda ng antas ng paglapit ng mapa.
Kapag hindi ibinigay at mayroong maramihang mga pananda sa ibabaw ng mapa, kukunin ang pinakaangkop na paglapit, hindi ang maiaayos na likas na katakdaan.',
	'maps-displaypoints-par-mappingservice' => 'Nagpapahintulot na maitakda ang palingkuran ng pagmamapa na gagamitin upang likhain ang mapa.',
	'maps-displaypoints-par-coordinates' => 'Isa o marami pang mga kinalalagyan na ipapakita sa mapa. Ipapahiwatig ang mga ito sa pamamagitan ng isang pananda.',
	'maps-displaypoints-par-centre' => 'Nagbibigay-daan sa pagtatakda ng mga tugmaang pampook ng gitna ng mapa para sa (mga) tuldok_na_ipapakita.
Tumatanggap kapwa ng mga tirahan o mga tugmaang pampook.
Kapag hindi ibinigay ang pag-aaring ito, igigitna ng mapa ang kanyang sarili sa ibinigay na pangmarka, o sa gitna ng ibinigay na mga pananda.',
	'maps-displaypoints-par-icon' => 'Nagpapahintulot sa pagtatakda ng ginagamit na kinatawang larawang para sa lahat ng mga pananda.',
	'validation-error-invalid-location' => 'Ang parametrong $1 ay dapat na isang tanggap na lokasyon.',
	'validation-error-invalid-locations' => 'Ang parametrong $1 ay dapat na isa o mahigit pang tanggap na mga lokasyon.',
	'validation-error-invalid-width' => 'Ang parametrong $1 ay dapat na isang tanggap na lapad.',
	'validation-error-invalid-height' => 'Ang parametrong $1 ay dapat na isang tanggap na taas.',
	'validation-error-invalid-distance' => 'Ang parametrong $1 ay dapat na isang tanggap na layo.',
	'validation-error-invalid-distances' => 'Ang parametrong $1 ay dapat na isa o mahigit pang tanggap na mga layo.',
	'validation-error-invalid-image' => 'Ang parametrong $1 ay dapat na isang katanggap-tanggap na larawan.',
	'validation-error-invalid-images' => 'Ang parametrong $1 ay dapat na isa o mahigit pang katanggap-tanggap na mga larawan.',
	'validation-error-invalid-goverlay' => 'Ang parametrong $1 ay dapat na isang tanggap na patong.',
	'validation-error-invalid-goverlays' => 'Ang parametrong $1 ay dapat na isa o mahigit pang katanggap-tanggap na mga patong.',
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
	'maps-par-resizable' => 'Nakagagawang mababago ang sukat ng mapa sa pamamagitan ng pagkaladkad doon sa pang-ibabang kanang sulok nito.',
	'maps-googlemaps2-incompatbrowser' => 'Ang pantingin-tingin mo ay hindi kalapat sa Mga Mapa ng Google v2.',
	'maps_overlays' => 'Mga patong',
	'maps_photos' => 'Mga larawan',
	'maps_videos' => 'Mga bidyo',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Mga webkam',
	'maps-googlemaps2-par-type' => 'Ang uri ng mapa na unang ipapakita.',
	'maps-googlemaps2-par-types' => 'Ang mga uri ng mapa na magiging makukuha sa pamamagitan ng pantaban ng uri.',
	'maps-googlemaps2-par-controls' => 'Ang mga pantaban na ilalagay sa ibabaw ng mapa.',
	'maps-googlemaps2-par-autozoom' => 'Paganahin ang pagpapagulong sa pamamagitan ng gulong ng daga-dagaan.',
	'maps-googlemaps2-par-kml' => 'Mga talaksan ng KML na ikakarga sa ibabaw ng mapa.',
	'maps-googlemaps2-par-overlays' => 'Mga patong na pang-ibabaw na mabubuhay ng tagagamit.',
	'maps-googlemaps3-incompatbrowser' => 'Ang pantingin-tingin mo ay hindi katambal ng Mga Mapa ng Google v3.',
	'maps-googlemaps3-par-type' => 'Ang uri ng mapa na unang ipapakita.',
	'maps-googlemaps3-par-types' => 'Ang mga uri ng mapa na magiging makukuha sa pamamagitan ng pantaban ng uri.',
	'maps-googlemaps3-par-layers' => 'Natatanging mga patong na ikakarga sa ibabaw ng mapa.',
	'maps-googlemaps3-par-controls' => 'Ang mga pantaban na ilalagay sa ibabaw ng mapa.',
	'maps-googlemaps3-par-zoomstyle' => 'Ang estilo ng pantaban ng paglapit.',
	'maps-googlemaps3-par-typestyle' => 'Ang estilo ng pantaban ng uri.',
	'maps-googlemaps3-par-autoinfowindows' => 'Kusang buksan ang lahat ng mga dungawan ng kabatiran pagkaraang maikarga ang pahina.',
	'maps-googlemaps3-par-kml' => 'Mga talaksan ng KML na ikakarga sa ibabaw ng mapa.',
	'maps-googlemaps3-par-fusiontables' => 'Mga ID ng mga Talahanayan ng Pagtutumbaga ng Google na dapat ikarga sa ibabaw ng mapa.',
	'maps-openlayers-par-controls' => 'Ang mga pantaban na ilalagay sa ibabaw ng mapa.',
	'maps-openlayers-par-layers' => 'Ang mga patong ay magiging makukuha sa loob ng pilian ng patong. Ang unang patong ay ipapakita kapag kumarga na ang mapa.',
	'maps-osm-par-thumbs' => 'Ipakita ang mga kagyat',
	'maps-osm-par-photos' => 'Ipakita ang mga larawan',
	'maps-yahoomaps-par-type' => 'Ang uri ng mapa na unang ipapakita.',
	'maps-yahoomaps-par-types' => 'Ang mga uri ng mapa na magiging makukuha sa pamamagitan ng pantaban ng uri.',
	'maps-yahoomaps-par-controls' => 'Ang mga pantaban na ilalagay sa ibabaw ng mapa.',
	'maps-yahoomaps-par-autozoom' => 'Paganahin ang pagbabalumbon na ginagamit ang gulong ng daga-dagaan.',
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

/** Tatar (Cyrillic script) (Татарча)
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
	'maps-desc' => 'Дає змогу вбудовування динамічних карт у сторінки вікі, геокодування адрес та інші географічні операції. ([http://mapping.referata.com/wiki/Examples demos]).',
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
	'maps-desc' => 'Cung cấp khả năng nhúng bản đồ vào trang wiki, mã hóa địa lý các địa chỉ, và thực hiện các tác vụ địa lý khác ([http://mapping.referata.com/wiki/Examples thử xem])',
	'right-geocode' => 'Mã hóa địa lý',
	'maps_map' => 'Bản đồ',
	'maps-loading-map' => 'Đang tải bản đồ…',
	'maps-load-failed' => 'Không thể tải bản đồ!',
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
	'maps-coordinates-par-location' => 'Tọa độ để định dạng hóa.',
	'maps-coordinates-par-format' => 'Định dạng cho ra tọa độ.',
	'maps-coordinates-par-directional' => 'Nên cho ra hướng với tọa độ hay không.',
	'maps-distance-par-decimals' => 'Đa số chữ số thập phân trong giá trị kết quả.',
	'maps-distance-par-unit' => 'Đơn vị của tầm xa được cho ra.',
	'maps-finddestination-par-location' => 'Vị trí ban đầu.',
	'maps-finddestination-par-bearing' => 'Hướng ban đầu.',
	'maps-finddestination-par-distance' => 'Tầm xa để chạy.',
	'maps-finddestination-par-format' => 'Định dạng cho ra nơi đến',
	'maps-geocode-par-location' => 'Địa chỉ để mã hóa địa lý.',
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
	'maps-googlemaps2-incompatbrowser' => 'Trình duyệt của bạn không tương tích với Google Bản đồ v2.',
	'maps_overlays' => 'Lấp',
	'maps_photos' => 'Hình ảnh',
	'maps_videos' => 'Video',
	'maps_wikipedia' => 'Wikipedia',
	'maps_webcams' => 'Webcam',
	'maps-openlayers-par-controls' => 'Các điều khiển đặt trên bản đồ.',
	'maps-openlayers-par-layers' => 'Các lớp sẽ có sẵn trong hộp chọn lớp. Lớp đầu tiên là lớp mặc định.',
	'maps-osm-par-thumbs' => 'Hiện hình thu nhỏ',
	'maps-osm-par-photos' => 'Hiện hình ảnh',
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

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'maps_map' => '地图',
	'maps-loading-map' => '载入地图中……',
	'maps-load-failed' => '无法加载地图！',
	'maps-markers' => '标记',
	'maps-others' => '其他',
	'maps-ns-layer' => '图层',
	'maps-ns-layer-talk' => '图层讨论',
	'maps-layer-property' => '属性',
	'maps-layer-value' => '价值',
	'maps-layer-errors' => '错误',
	'maps-error-invalid-layerdef' => '这一层定义不是有效的。',
	'maps-abb-north' => '北',
	'maps-abb-east' => '东',
	'maps-abb-south' => '南',
	'maps-abb-west' => '西',
	'maps-latitude' => '纬度：',
	'maps-longitude' => '经度：',
	'maps_overlays' => '叠加',
	'maps_photos' => '照片',
	'maps_videos' => '视频',
	'maps_wikipedia' => '维基百科',
	'maps_webcams' => '网络摄像机',
	'maps-osm-par-thumbs' => '显示大拇指',
	'maps-osm-par-photos' => '显示图片',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Horacewai2
 * @author Mark85296341
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'maps_map' => '地圖',
	'maps-loading-map' => '載入中...',
	'maps-markers' => '標記',
	'maps-others' => '其他',
	'maps-ns-layer' => '圖層',
	'maps-layer-property' => '屬性',
	'maps-layer-errors' => '錯誤',
	'maps-finddestination-par-location' => '初始位置。',
	'maps-finddestination-par-bearing' => '最初的影響。',
	'validation-error-invalid-location' => '參數 $1 必須是一個有效的位置。',
	'validation-error-invalid-locations' => '參數 $1 必須有一個或多個有效的位置。',
	'validation-error-invalid-width' => '參數 $1 必須是一個有效的寬度。',
	'validation-error-invalid-height' => '參數 $1 必須是一個有效的高度。',
	'validation-error-invalid-distance' => '參數 $1 必須是一個有效的距離。',
	'validation-error-invalid-distances' => '參數 $1 必須是一個或多個有效距離。',
	'validation-error-invalid-image' => '參數 $1 必須是一個有效的圖片。',
	'validation-error-invalid-images' => '參數 $1 必須是一個或多個有效的圖像。',
	'validation-error-invalid-goverlay' => '參數 $1 必須是一個有效的重疊。',
	'validation-error-invalid-goverlays' => '參數 $1 必須是一個或多個有效重疊。',
	'maps-abb-north' => '北',
	'maps-abb-east' => '東',
	'maps-abb-south' => '南',
	'maps-abb-west' => '西',
	'maps-latitude' => '緯度：',
	'maps-longitude' => '經度：',
	'maps_map_cannot_be_displayed' => '該地圖無法顯示。',
	'maps_overlays' => '重疊',
	'maps_photos' => '照片',
	'maps_videos' => '影片',
	'maps_wikipedia' => '維基百科',
	'maps_webcams' => '網路攝影機',
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

