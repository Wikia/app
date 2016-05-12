<?php

class GoogleMapsKmlExporter extends GoogleMapsExporter {
	var $mIcons;
	var $mIcon;
	var $mMarkerCount;

	function __construct(&$pLanguage, $pIcon) {
		$this->mOutput = '';
		$this->mIcons = array();
		$this->mIcon = $pIcon;
		$this->mMarkerCount = 0;
		$this->mLanguage =& $pLanguage;
	}

	function addXmlSource($url)
	{
		$this->mOutput .= "<NetworkLink><Link><href>$url</href></Link></NetworkLink>";
	}

	function addPolyline ( $pPolyline, $pLineColor, $pLineOpacity, $pStroke, $pFillColor, $pFillOpacity )
	{
		if ($pFillColor) {
			return $this->addPolygon($pPolyline, $pLineColor, $pLineOpacity, $pStroke, $pFillColor, $pFillOpacity);
		}
		$this->mOutput .= "<Placemark>\n<name>Polyline</name>\n<Style>";
		$this->addLineStyle($pLineColor, $pLineOpacity, $pStroke);
		$this->mOutput .= "</Style>";
		$this->mOutput .= "<LineString><tessellate>1</tessellate>".
		"<altitudeMode>clampToGround</altitudeMode>\n"; //Might want to change this later on.
		$this->addCoordinates($pPolyline);
		$this->mOutput .= "</LineString>\n</Placemark>\n";
	}

	function addPolygon( $pPolyline, $pLineColor, $pLineOpacity, $pStroke, $pFillColor, $pFillOpacity ) {
		$this->mOutput .= "<Placemark>\n<name>Polygon</name>\n<Style>";
		$this->addPolyStyle($pFillColor, $pFillOpacity);
		$this->addLineStyle($pLineColor, $pLineOpacity, $pStroke);
		$this->mOutput .= "</Style>";
		$this->mOutput .= "<Polygon><tessellate>1</tessellate>".
		"<altitudeMode>clampToGround</altitudeMode>\n";
		$this->mOutput .= "<outerBoundaryIs><LinearRing>";
		$pPolyline[] = $pPolyline[0];
		$this->addCoordinates($pPolyline);
		$this->mOutput .= "</LinearRing></outerBoundaryIs></Polygon>\n";
		$this->mOutput .= "</Placemark>\n";
	}

	function addPolyStyle($pFillColor, $pFillOpacity) {
		list($r, $g, $b) = str_split($pFillColor, 2);
		$this->mOutput .= "<PolyStyle>";
		$this->mOutput .= "<color>{$pFillOpacity}{$b}{$g}{$r}</color>";
		$this->mOutput .= "<fill>1</fill>";
		$this->mOutput .= "<outline>1</outline>";
		$this->mOutput .= "</PolyStyle>";
	}

	function addLineStyle($pLineColor, $pLineOpacity, $pStroke) {
		list($r, $g, $b) = str_split($pLineColor, 2);
		$this->mOutput .= "<LineStyle>";
		$this->mOutput .= "<color>{$pLineOpacity}{$b}{$g}{$r}</color>";
		$this->mOutput .= "<width>{$pStroke}</width>";
		$this->mOutput .= "</LineStyle>";
	}

	function addCoordinates($pPolyline) {
		$this->mOutput .= "<coordinates>\n";
		foreach ($pPolyline as $p) {
			$this->mOutput .= "{$p['lon']}, {$p['lat']}\n";
		}
		$this->mOutput .= "</coordinates>\n";
	}

	function addMarker ( $pLat, $pLon, $pIcon, $pTitle, $pTitleLink, $pCaption, $pMaxContent, $pIsLine ) {
		$this->mMarkerCount++;
		$this->mOutput .= "<Placemark>\n<name>";
		$this->mOutput .= $pTitle ? $pTitle : "point {$this->mMarkerCount}";
		$this->mOutput .= "</name>";
		$this->mOutput .= "<Style><Icon><href>";
		$this->mOutput .= $pIcon ? $this->mIcons[$pIcon] : $this->mIcon;
		$this->mOutput .= "</href></Icon></Style>\n";
		$this->mOutput .= "<Point><coordinates>$pLon, $pLat, 0</coordinates></Point>\n";
		if (is_string($pCaption) && $pCaption) {
			$this->mOutput .= '<description><![CDATA['.
			GoogleMaps::fixBlockDirection(GoogleMaps::fixTidy($pCaption), $this->mLanguage->isRTL()).
			']]></description>';
                } else if (is_array($pCaption)) { // TODO tabs and max content
		}
		$this->mOutput .= "</Placemark>\n";
	}

	function addIcon($icon, $template) {
		$this->mIcons[$icon] = str_replace("{label}", $icon, $template);
	}

	function addFileHeader() {
		$this->mOutput .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$this->mOutput .= "<kml xmlns=\"http://earth.google.com/kml/2.1\">\n";
		$this->mOutput .= "<Document>\n<open>1</open>\n";
	}

	function addFileTrailer() {
		$this->mOutput .= "</Document>\n";
		$this->mOutput .= "</kml>";
	}

	function addHeader($name) {
		$name = htmlentities($name);
		$this->mOutput .= "<Folder><name>{$name}</name><open>1</open>";
	}

	function addTrailer() {
		$this->mOutput .= "</Folder>";
	}
}
