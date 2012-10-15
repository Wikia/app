<?php

class GoogleMapsImgExporter extends GoogleMapsExporter {
	var $mApiKey;
	var $mLanguageCode;

	function __construct($pApiKey, $pLanguageCode) {
		$this->mApiKey = $pApiKey;
		$this->mLanguageCode = $pLanguageCode;
	}

	function addHeader($o) {
		$width  = $o['width']  > 640 ? 640 : $o['width'];
		$height = $o['height'] > 640 ? 640 : $o['height'];
		$this->mOutput .= '<img ';
		$this->mOutput .= "alt=\"Map\" ";
		$this->mOutput .= "height=\"{$height}\" width=\"{$width}\" ";
		$this->mOutput .= 'src="http://maps.google.com/maps/api/staticmap';
		$this->mOutput .= "?center={$o['lat']}%2C{$o['lon']}";
		$this->mOutput .= "&zoom={$o['zoom']}";
		$this->mOutput .= "&size={$width}x{$height}";
		$this->mOutput .= "&key={$this->mApiKey}";
		$this->mOutput .= "&language={$this->mLanguageCode}";
		$this->mOutput .= "&sensor=false";
		if ($o['type'] == 'terrain' || $o['type'] == 'satellite' || $o['type'] == 'hybrid') {
			$this->mOutput .= "&maptype={$o['type']}";
		}
	}

	function addMarker($pLat, $pLon, $pIcon, $pTitle, $pTitleLink, $pCaption, $pMaxContent, $pIsLine)
	{
		$this->mOutput .= "&markers=".urlencode("size:mid|color:red");
		if ($pIcon) {
			$this->mOutput .= urlencode("|label:" . strtoupper(substr($pIcon, 0, 1)));
		}
		$this->mOutput .= urlencode("|{$pLat},{$pLon}");
	}

	function addPolyline( $pPolyline, $pLineColor, $pLineOpacity, $pStroke, $pFillColor, $pFillOpacity )
	{
		$this->mOutput .= "&path=".urlencode("color:0x{$pLineColor}{$pLineOpacity}|weight:{$pStroke}");
		if ( isset( $pFillColor ) ) {
			$this->mOutput .= urlencode("|fillcolor:0x{$pFillColor}{$pFillOpacity}");
		}
		foreach ($pPolyline as $p) {
			$this->mOutput .= urlencode("|{$p['lat']},{$p['lon']}");
		}
	}

	function addTrailer() {
		$this->mOutput .= "\" />";
	}
}
