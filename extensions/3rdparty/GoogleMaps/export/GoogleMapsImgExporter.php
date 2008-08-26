<?php

class GoogleMapsImgExporter extends GoogleMapsExporter {
    var $mApiKey;

    function GoogleMapsImgExporter($pApiKey) {
        $this->mApiKey = $pApiKey;
    }

    function addHeader($o) {
        $width  = $o['width']  > 512 ? 512 : $o['width'];
        $height = $o['height'] > 512 ? 512 : $o['height'];
        $this->mOutput .= '<img ';
        $this->mOutput .= "height=\"{$height}\" width=\"{$width}\" ";
        $this->mOutput .= 'src="http://maps.google.com/staticmap';
        $this->mOutput .= "?center={$o['lat']},{$o['lon']}";
        $this->mOutput .= "&zoom={$o['zoom']}";
        $this->mOutput .= "&size={$width}x{$height}";
        $this->mOutput .= "&key={$this->mApiKey}";
        $this->mOutput .= "&markers=";
    }

    function addMarker($pLat, $pLon, $pIcon, $pTitle, $pTitleLink, $pCaption, $pMaxContent, $pIsLine) {
        $label = '';
        if ($pIcon) {
            $label = urlencode(strtolower(substr($pIcon, 0, 1)));
        }
        $this->mOutput .= "{$pLat},{$pLon},red{$label}%7C";
    }

    function addTrailer() {
        $this->mOutput .= "\" />";
    }
}
