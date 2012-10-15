<?php

// TODO: Captions here
// Bugs in main renderer (oops)
// Output specific maps
// Easy links to KML files

class GoogleMapsKML extends SpecialPage {
		function __construct() {
			parent::__construct('GoogleMapsKML', '', false /* listed */);
		}
	function execute( $params ) {
		global $wgRequest, $wgOut, $wgUser;
		global $wgContLang, $wgProxyKey, $wgParser;
		$article = $wgRequest->getText( 'article', $params );
		$map     = $wgRequest->getText( 'map', $params );

		$wgOut->disable();
		header("Cache-Control: no-cache, must-revalidate");
		header("Content-type: application/vnd.google-earth.kml+xml");
		header('Content-Disposition: attachment; filename="'.$article.'.kml"');

		$title = Title::newFromText($article);
		if ($title) {
			$revision = Revision::newFromTitle($title);

			$mapOptions = GoogleMaps::getMapSettings($title,
			array('icons' => 'http://maps.google.com/mapfiles/kml/pal4/{label}.png',
			'icon' => 'icon57'));

			$exporter = new GoogleMapsKmlExporter($wgContLang,
			str_replace('{label}', $mapOptions['icon'], $mapOptions['icons']));

			$popts = ParserOptions::newFromUser( $wgUser );
			$popts->setEditSection( false );

			$wgParser->startExternalParse( $this->getTitle(), $popts, OT_WIKI, true );

			$localParser = new Parser();
			$localParser->startExternalParse( $this->getTitle(), $popts, OT_WIKI, true );

			if (preg_match_all("/<googlemap( .*?|)>(.*?)<\/googlemap>/s", $revision->getText(), $matches)) {
				$exporter->addFileHeader();
				for($i=0;$i<count($matches[2]);$i++) {
									$attrs = Sanitizer::decodeTagAttributes($matches[1][$i]);
									$mapOptions['version'] = isset($attrs['version']) ? $attrs['version'] : "0";
									$exporter->addHeader(isset($attrs['title']) ? $attrs['title'] : "Map #".($i+1));
									GoogleMaps::renderContent($matches[2][$i], $wgParser, $localParser, $exporter, $mapOptions);
									$exporter->addTrailer();
								}
				$exporter->addFileTrailer();
				echo $exporter->render();
			} else {
				echo "No maps in $article!";
			}
		} else {
			echo "No article found by the name of $article";
		}
	}
}
