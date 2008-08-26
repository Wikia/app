<?php

if ( !defined( 'MEDIAWIKI' ) ) {
        echo "Geoserver extension\n";
        exit( 1 ) ;
}

$wgExtensionCredits['parserhook']['geoserver'] = array(
        'name' => 'geoserver',
        'author' => 'Jens Frank',
        'url' => 'http://www.mediawiki.org/wiki/Extension:geoserver',
        'description' => 'Allows geotagging using the <nowiki><geo></nowiki> tag. Saves geodata in a WFS-T server, e.g. geoserver.',
);


$wgExtensionFunctions[] = "wfGeoserverExtension";

/**
 *  Installer
 */
function wfGeoServerExtension () {
        global $wgParser, $wgHooks ;
        $wgParser->setTransparentTagHook ( 'geo' , 'parseGeo' ) ;
#        $wgHooks['ArticleSaveComplete'][] = 'articleDeleteGeo';
        $wgHooks['ArticleDelete'][] = 'articleDeleteGeo';
        $wgHooks['ArticleEditUpdatesDeleteFromRecentchanges'][] = 'articleSaveGeo';
}

global $wgAutoloadClasses;
$wgAutoloadClasses['WFS'] = dirname(__FILE__) . '/WFS.php';

require_once( dirname(__FILE__) . '/SpecialWikimaps.php' );
/**
 *  Called whenever a <geo> needs to be parsed
 *
 *  Return markup, but also a pointer to Map sources
 */
function parseGeo ( $text, $params, &$parser ) {
	global $wgTitle, $action, $GeoserverParameters, $wgWikiMapsJS;
	$latpat= '(-?[0-9.]*) *(([0-9.]+) *([0-9.]+)?)? *([NS])';
	$lonpat= '(-?[0-9.]*) *(([0-9.]+) *([0-9.]+)?)? *([EW])';
	$featcodepat = '(([AHLPRSTUV])\.([A-Z.]*))?';
	$populationpat = '([0-9]*)?';
	$showmappat = '(showmap)?';
        preg_match( "/\\s*$latpat\\s*$lonpat\\s*$featcodepat\\s*$populationpat\\s*$showmappat/", $text, $matches );

        $GeoserverParameters["lat"] = ($matches[5]=='S'? -1: 1)  * ( $matches[1]+ $matches[3]/60.0 + $matches[4] / 3600 );
        $GeoserverParameters["lon"] = ($matches[10]=='W'? -1: 1) * ( $matches[6]+ $matches[8]/60.0 + $matches[9] / 3600 );
        $GeoserverParameters["type_major"] = $matches[12];
        $GeoserverParameters["type_minor"] = $matches[13];
        $GeoserverParameters["population"] = $matches[14];

	$r = '';

	if ( $matches[15] ) { // that's the "showmap" flag
		global $wgOut, $wgOpenLayersScript, $wgWikiMapsIcon;
		$defaultZoom = 10;
		$majorMinor = $GeoserverParameters["type_major"].$GeoserverParameters["type_minor"];
		if ( $majorMinor == 'PPPL' ) { // populated place
			$defaultZoom=8;
		} elseif ( $majorMinor == 'PPPLC' ) { // capital city
			$defaultZoom=6;
		}
		$r = '<script src="' . $wgOpenLayersScript . '"></script>
		       <script src="'. $wgWikiMapsJS .'"></script>
		       <script type="text/javascript">
			  addOnloadHook(WikiMapsInit);
	  		  var WikiMapsLon = '.$GeoserverParameters["lon"].'; var WikiMapsLat = '.$GeoserverParameters["lat"].';
	  		  var WikiMapsMajor = "'.$GeoserverParameters["type_major"] .'";
	  		  var WikiMapsMinor = "'.$GeoserverParameters["type_minor"].'";
	  		  var WikiMapsZoom = '.$defaultZoom.';
			' . exportWikiMapsGlobals() . '
		       </script>
		<div id="wikimaps"><div class="wikimapslabel" >Map</div><div class="wikimapslabel" id="wikimapsfullscreen">Fullscreen</div><br /><div id="map" style="width:300px; height:300px;"></div><div id="selectbox" style="display:none;XXposition: absolute; XXtop:10em; XXleft:10em; width:300px;background:#02048C;color: white; padding-bottom:1px;"><div id="close" style="float:right; background:grey; color:black;font-size:small;margin:1px;padding-left:3px; padding-right:3px;pointer:hand;">X</div><span style="margin-left:3px;">Result</span><div id="selectboxbody" style="background:white; margin:1px; padding:3px; color:black;"></div></div></div>';
	}
	
	return  $r;
}

function articleDeleteGeo ( $article ) {
	$wfs = new WFS( "" );
	$wfs->delete( $article->getTitle()->getDBkey() );
	return true;
}

function articleSaveGeo ( $article ) {
	global $GeoserverParameters, $wgTitle;
	$wfs = new WFS( "" );

	if ( $wgTitle->getNamespace() == NS_MAIN ) {
		$result = $wfs->update( $wgTitle->getDBkey(), $wgTitle->getText(), 
					$GeoserverParameters["type_major"], $GeoserverParameters["type_minor"],
					$GeoserverParameters["lat"], $GeoserverParameters["lon"],
					$GeoserverParameters["population"] );
	}
	return true;
}

function exportWikiMapsGlobals() {
	global $wgWikiMapsIcon;
	return '
	  var wgWikiMapsIcon = "' . $wgWikiMapsIcon .'";
	  if ( wgFullscreen == undefined ) { var wgFullscreen = false; }' . generateWikiMapsLayersJS();
} 

function generateWikiMapsLayersJS() {
	global $wgWikiMapsLayers;
	$WMSLayer = 'if ( WikiMapsLayers == undefined ) { var WikiMapsLayers = new Array(); }
	 WikiMapsLayers = WikiMapsLayers.concat( new Array( ';

	$first = true;
	foreach ( $wgWikiMapsLayers as $layer ) {
		if ( isset( $layer["levels"] ) ) {
			// this is an OpenLayers.Layer.WMS.MultiUntiled layer
		} else {
			// this is a normal OpenLayers.Layer.WMS layer
			if ( $first ) { $first = false; } else { $WMSLayer .= ', ';}
			$WMSLayer .= "{ name: '{$layer['name']}', url: '{$layer['url']}', options: {$layer['options']} }";
		}
	}
	$WMSLayer .= "
	) );

	WikiMapsInitLayersOld = WikiMapsInitLayers;
	var WikiMapsInitLayers = function( map ) {
    		for ( i in WikiMapsLayers ) {
        		layer = new OpenLayers.Layer.WMS( WikiMapsLayers[i].name, WikiMapsLayers[i].url, WikiMapsLayers[i].options );
        		map.addLayer( layer );
    		}
    		wms = new OpenLayers.Layer.WMS.MultiUntiled( 'Wikipedia',
            	'http://172.16.200.128:8080/geoserver/wms?VERSION=1.1.1&SERVICE=WMS',
            	{layers: 'topp:border,topp:wikicapitals', transparent: 'true', format: 'image/png'} );
    		wms.addOptions({isBaseLayer: false});
    		wms.setLayerForLevel( 'topp:border,topp:wikipedia', 6 );
    		wms.setLayerForLevel( 'topp:border,topp:wikipedia', 7 );
    		wms.setLayerForLevel( 'topp:border,topp:wikipedia', 8 );
    		wms.setLayerForLevel( 'topp:border,topp:wikipedia', 9 );
    		wms.setLayerForLevel( 'topp:border,topp:wikipedia', 10 );
    		wms.setLayerForLevel( 'topp:border,topp:wikipedia', 11 );
    		wms.setLayerForLevel( 'topp:border,topp:wikipedia', 12 );
    		wms.setLayerForLevel( 'topp:border,topp:wikipedia', 13 );
    		wms.setLayerForLevel( 'topp:border,topp:wikipedia', 14 );
    		wms.setLayerForLevel( 'topp:border,topp:wikipedia', 15 );
    		map.addLayer(wms);
    		if ( WikiMapsInitLayersOld != undefined ) {
        		WikiMapsInitLayersOld( map );
    		}
	} ";
	return $WMSLayer;
}
			
	


?>
