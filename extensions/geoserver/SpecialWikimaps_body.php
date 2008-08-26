<?php

class Wikimaps extends SpecialPage {

	function Wikimaps() {
		SpecialPage::SpecialPage( 'Wikimaps', 'wikimaps' );
	}

	function execute() {
		global $wgOut, $wgOpenLayersScript, $wgWikiMapsJS, $wgArticlePath;
		$wgOut->disable();
		echo '


<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <style type="text/css">
        #map {
            width: 100%;
            height: 100%;
            border: 1px solid black;
        }
        #popup_contentDiv {
	    width:80%;
	    height:80%;
	    border: 1px solid blue;
	    position: fixed;
	    background: papayawhip;
	    
	}
	small.popup {
		margin-top: 0em;
	}
	ul.popup {
		margin-top: 0em;
	}
	div.displaytitle { 
		border-bottom: solid 1px silver; 
		margin-bottom:6px;
	}
    </style>

    <script src="' . $wgOpenLayersScript . '"></script>
    <script src="' . $wgWikiMapsJS . '"></script>
    <script type="text/javascript">
	var wgFullscreen = true;
	var wgServer="' . $wgServer . '";
	var wgArticlePath="' . $wgArticlePath .'";
	' . exportWikiMapsGlobals() . '
    </script>
  </head>
  <body onload="WikiMapsInit();">
    <div id="map"></div>
    <div id="selectbox" style="display:none;position: absolute; top:10em; left:10em; width:16em;background:#02048C;color: white;">
      <div id="close" style="float:right; background:grey; color:black;font-size:small;margin:1px;padding-left:3px; padding-right:3px;pointer:hand;">X</div>
      <span style="margin-left:3px;">Result</span>
      <div id="selectboxbody" style="background:white; margin:1px; padding:3px; color:black;"></div>
    </div>
  </body>
</html>

';

	}
}

