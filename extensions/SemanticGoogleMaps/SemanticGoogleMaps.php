<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An extension to that allows users to add Google Maps to wiki pages based
 * on structured data
 *
 * @addtogroup Extensions
 *
 * @author Robert Buzink
 * @author Yaron Koren
 * @copyright Copyright © 2008, Robert Buzink
 * @copyright Copyright © 2008, Yaron Koren
 */

# Define a setup function
$wgExtensionFunctions[] = 'sgmSetup';

# Add a hook to initialise the magic word
$wgHooks['LanguageGetMagic'][] = 'sgmFunctionMagic';

$wgExtensionMessagesFiles['SemanticGoogleMaps'] = dirname(__FILE__) . '/SemanticGoogleMaps.i18n.php';

function sgmSetup() {
	global $wgParser, $wgExtensionCredits;

	// credits
	$wgExtensionCredits['parserhook'][] = array(
		'name'            => 'Semantic Google Maps',
		'version'         => '0.3.1',
		'author'          => array( 'Robert Buzink', 'Yaron Koren' ),
		'url'             => 'http://www.mediawiki.org/wiki/Extension:Semantic_Google_Maps',
		'description'     => 'Allows users to add Google Maps to wiki pages based on structured data',
		'descriptionmsg'  => 'semanticgooglemaps-desc',
	);

	// A hook to enable the '#semantic_google_map' parser function
	$wgParser->setFunctionHook( 'semantic_google_map', 'sgmFunctionRender' );
	global $sfgFormPrinter;
	if ($sfgFormPrinter) {
		$sfgFormPrinter->setInputTypeHook('googlemap', 'sgmInputHTML', array());
		// for backwards compatibility
		$sfgFormPrinter->setInputTypeHook('coordinatesmap', 'sgmInputHTML', array());
	}

	include_once('SGM_QueryPrinter.php');
	SMWQueryProcessor::$formats['googlemap'] = 'SGMResultPrinter';
}

function sgmFunctionMagic( &$magicWords, $langCode ) {
	# Add the magic word
	# The first array element is case sensitive, in this case it is not case sensitive
	# All remaining elements are synonyms for our parser function
	$magicWords['semantic_google_map'] = array( 0, 'semantic_google_map' );
	// for backwards compatibility
	$magicWords['insert_map'] = array( 0, 'semantic_google_map' );
	# unless we return true, other parser functions extensions won't get loaded.
	return true;
}

function sgmFunctionRender( &$parser, $coordinates = '1,1', $zoom = '14', $type = 'G_NORMAL_MAP', $controls = 'GSmallMapControl', $class = 'pmap', $width = '200', $height = '200', $style = '' ) {
	# The parser function itself
	# The input parameters are wikitext with templates expanded
	# The output is not parsed as wikitext
	global $wgJsMimeType, $wgGoogleMapsKey, $wgGoogleMapsOnThisPage;

	if (!$wgGoogleMapsOnThisPage) {$wgGoogleMapsOnThisPage = 0;}
	$wgGoogleMapsOnThisPage++;

	$lat = sm_returnlatlon('lat',$coordinates);
	$lon = sm_returnlatlon('lon',$coordinates);

	$output =<<<END
<script src="http://maps.google.com/maps?file=api&v=2&key=$wgGoogleMapsKey" type="$wgJsMimeType"></script>
<script type="text/javascript"> function createMarker(point, label) {  var marker = new GMarker(point);  GEvent.addListener(marker, 'click', function() { marker.openInfoWindowHtml(label, GInfoWindoOptions.maxWidth=100); });  return marker;  }  function addLoadEvent(func) {  var oldonload = window.onload;  if (typeof oldonload == 'function') {  window.onload = function() {  oldonload();  func();  };  } else {  window.onload = func;  }  }  window.unload = GUnload;</script>
<div id="map$wgGoogleMapsOnThisPage" class="$class" style="$style" ></div>
<script type="text/javascript"> function makeMap{$wgGoogleMapsOnThisPage}() { if (GBrowserIsCompatible()) {var map = new GMap2(document.getElementById("map{$wgGoogleMapsOnThisPage}"), {size: new GSize('$width', '$height')}); map.addControl(new {$controls}()); map.addControl(new GMapTypeControl()); map.setCenter(new GLatLng({$lat}, {$lon}), {$zoom}, {$type}); var point = new GLatLng({$lat}, {$lon}); var marker = new GMarker(point); map.addOverlay(marker); } else { document.write('should show map'); } } addLoadEvent(makeMap{$wgGoogleMapsOnThisPage});</script>

END;

	return array( $output, 'noparse' => true, 'isHTML' => true );

}

function sm_returnlatlon($param1 = '', $param2 = '' ) {
	$coordinates = preg_split("/,/", $param2);

	if (count($coordinates) == 2) {
		switch ($param1) {
			case 'lat':
			return sm_convert_coord($coordinates[0]);
			case 'lon':
			return sm_convert_coord($coordinates[1]);
		}
	}
	return "";
}

function sm_degree2decimal($deg_coord="") {
	$dpos=strpos($deg_coord,'°');
	$mpos=strpos($deg_coord,'.');
	$spos=strpos($deg_coord,'"');
	$mlen=(($mpos-$dpos)-1);
	$slen=(($spos-$mpos)-1);
	$direction=substr(strrev($deg_coord),0,1);
	$degrees=substr($deg_coord,0,$dpos);
	$minutes=substr($deg_coord,$dpos+1,$mlen);
	$seconds=substr($deg_coord,$mpos+1,$slen);
	$seconds=($seconds/60);
	$minutes=($minutes+$seconds);
	$minutes=($minutes/60);
	$decimal=($degrees+$minutes);
	//South latitudes and West longitudes need to return a negative result
	if (($direction=="S") or ($direction=="W")) {
		$decimal=$decimal*(-1);
	}
	return $decimal;
}

function sm_decdegree2decimal($deg_coord="") {
	$direction=substr(strrev($deg_coord),0,1);
	$decimal=floatval($deg_coord);
	if (($direction=="S") or ($direction=="W")) {
		$decimal=$decimal*(-1);
	}
	return $decimal;
}

function sm_convert_coord ($deg_coord="") {
	if (preg_match('/°/', $deg_coord)) {
		if (preg_match('/"/', $deg_coord)) {
			$deg_coord = sm_degree2decimal($deg_coord);
		} else {
			$deg_coord = sm_decdegree2decimal($deg_coord);
		}
	}
	return $deg_coord;
}

function sgmLatDecimal2Degree($decimal) {
	if ($decimal < 0) {
		return abs($decimal) . "° S";
		} else {
		return $decimal . "° N";
		}
	}

function sgmLonDecimal2Degree($decimal) {
	if ($decimal < 0) {
    return abs($decimal) . "° W";
		} else {
    return $decimal . "° E";
		}
	}

// the function that outputs the custom form html
function sgmInputHTML($coordinates, $input_name, $is_mandatory, $is_disabled, $field_args) {

	global $gTabIndex, $gDisabledText, $wgJsMimeType, $wgGoogleMapsKey, $wgGoogleMapsOnThisPage;

	// default values
	$flat = 0;
	$flon = 0;

	if ($coordinates) {
		// can show up here either as an array or a string, depending on
		// whether it came from user input or a wiki page
		if (is_array($coordinates)) {
			// todo if relevant
		} else {
			$flat = sm_returnlatlon('lat',$coordinates);
			$flon = sm_returnlatlon('lon',$coordinates);
		}
		$zoom = '14';
	} else {
		$zoom = '0';
	}
	if (!$wgGoogleMapsOnThisPage) {$wgGoogleMapsOnThisPage = 0;}
	$wgGoogleMapsOnThisPage++;
	$width = '200';
	$height = '200';
	$class = 'sm_map';
	$type = 'G_NORMAL_MAP';
	$controls = 'GSmallMapControl';
	if ($flat == 0) { $lat = '50';} else {$lat = $flat;}
	if ($flon == 0) { $lon = '5';} else {$lon = $flon;}

	// input field
	$coords = "";
	if ($flat != 0 && $flat != 0) {
		$deg_lat = sgmLatDecimal2Degree($flat);
		$deg_lon = sgmLonDecimal2Degree($flon);
		$coords = "$deg_lat, $deg_lon";
	}
	$info_id = "info_$gTabIndex";
	$text =<<<END
	<input tabindex="$gTabIndex" id="input_$gTabIndex" name="$input_name" type="text" value="$coords" size="40" $gDisabledText>
	<span id="$info_id" class="error_message"></span>

END;

	// map div
	$text .= '<div id="sm_map'.$wgGoogleMapsOnThisPage.'" class="'.$class.'"></div>';

	//geocoder html
	wfLoadExtensionMessages( 'SemanticGoogleMaps' );
	$lookup_coordinates_text = wfMsg('semanticgooglemaps_lookupcoordinates');
	$text .= <<<END
	<p>
		<input size="60" id= "geocode" name="geocode" value="" type="text">
		<a href="#" onClick="showAddress(document.forms[0].geocode.value); return false">$lookup_coordinates_text</a>
	</p>
	<br />

END;

	// map javascript

	$text .= <<<END
<script src="http://maps.google.com/maps?file=api&v=2&key=$wgGoogleMapsKey" type="$wgJsMimeType"></script>
<script type="text/javascript">
function showAddress(address) {
	makeMap{$wgGoogleMapsOnThisPage}();
	if (geocoder) {
		geocoder.getLatLng(address,
			function(point) {
				if (!point) {
					alert(address + " not found");
				} else {
					map.clearOverlays()
					map.setCenter(point, 14);
					var marker = new GMarker(point);
					map.addOverlay(marker);
					document.getElementById("input_$gTabIndex").value = convertLatToDMS(point.y)+', '+convertLngToDMS(point.x);
				}
			}
		);
	}
}

function convertLatToDMS (val) {
	if (val < 0) {
		return Math.abs(val) + "° " + "S";
	} else {
		return Math.abs(val) + "° " + "N";
	}
}

function convertLngToDMS (val) {
	if (val < 0) {
		return Math.abs(val) + "° " + "W";
	} else {
		return Math.abs(val) + "° " + "E";
	}
}

function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof oldonload == 'function') {
		window.onload = function() {
			oldonload();
			func();
		};
	} else {
		window.onload = func;
	}
}

window.unload = GUnload;
</script>

END;
	$javascript_text = <<<END
<script type="text/javascript">
function makeMap{$wgGoogleMapsOnThisPage}() {
	if (GBrowserIsCompatible()) {
		window.map = new GMap2(document.getElementById("sm_map{$wgGoogleMapsOnThisPage}"), {size: new GSize('$width', '$height')});
		geocoder = new GClientGeocoder();
		map.addControl(new {$controls}());
		map.addControl(new GMapTypeControl());
		map.setCenter(new GLatLng({$lat}, {$lon}), {$zoom}, {$type});
		var point = new GLatLng({$lat}, {$lon});
		var marker = new GMarker(point);
		map.addOverlay(marker);
		GEvent.addListener(map, "click",
			function(overlay, point) {
				place = null;
				if (overlay) {
					map.removeOverlay (overlay);
				} else {
					var marker = new GMarker (point);
					map.clearOverlays();
					document.getElementById("input_$gTabIndex").value = convertLatToDMS(point.y)+', '+convertLngToDMS(point.x);
					map.addOverlay(marker);
					map.panTo(point);
				}
			}
		);
	}
}
addLoadEvent(makeMap{$wgGoogleMapsOnThisPage});
</script>

END;
	// remove all newlines, to avoid wiki parsing inserting unwanted
	// <p> tags within the Javascript
	$javascript_text = preg_replace('/\s+/m', ' ', $javascript_text);
	$text .= $javascript_text;

	$output = array($text,'');
	return $output;
}
