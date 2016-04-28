<?php

class GoogleMapsImgExporter extends GoogleMapsExporter {
    var $mApiKey;
    var $mPathCount;
    var $mLanguageCode;

    function __construct($pApiKey, $pLanguageCode) {
        $this->mApiKey = $pApiKey;
        $this->mPathCount = 0;
        $this->mLanguageCode = $pLanguageCode;
    }

    function addHeader($o) {
        $width  = $o['width']  > 512 ? 512 : $o['width'];
        $height = $o['height'] > 512 ? 512 : $o['height'];
        $this->mOutput .= '<img ';
        $this->mOutput .= "alt=\"Map\" ";
        $this->mOutput .= "height=\"{$height}\" width=\"{$width}\" ";
        $this->mOutput .= 'src="http://maps.google.com/staticmap';
        $this->mOutput .= "?center={$o['lat']}%2C{$o['lon']}";
        $this->mOutput .= "&zoom={$o['zoom']}";
        $this->mOutput .= "&size={$width}x{$height}";
        $this->mOutput .= "&key={$this->mApiKey}";
        $this->mOutput .= "&hl={$this->mLanguageCode}";
        $this->mOutput .= "&markers=";
    }

    function addMarker($pLat, $pLon, $pIcon, $pTitle, $pTitleLink, $pCaption, $pMaxContent, $pIsLine) 
    {
        if ($this->mPathCount == 0) {
            $label = '';
            if ($pIcon) {
                $label = strtolower(substr($pIcon, 0, 1));
            }
            $this->mOutput .= urlencode("{$pLat},{$pLon},red{$label}|");
        }
    }

    function addPolyline( $pPolyline, $pLineColor, $pLineOpacity, $pStroke, $pFillColor, $pFillOpacity )
    {
        if ($this->mPathCount == 0) { # limit 1
            $this->mPathCount++;
            $this->mOutput .= "&path=";
            $this->mOutput .= urlencode("rgba:0x{$pLineColor}{$pLineOpacity},weight:{$pStroke}");
            foreach ($pPolyline as $p) {
                $this->mOutput .= urlencode("|{$p['lat']},{$p['lon']}");
            }
        }
    }

    function addTrailer() {
        $this->mOutput .= "\" />";
    }
}
