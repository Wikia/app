<?php

require_once("includes/SpecialPage.php");

// TODO: Captions here
// Bugs in main renderer (oops)
// Output specific maps
// Easy links to KML files

class GoogleMapsKML extends SpecialPage {
	function __construct() {
		parent::__construct('GoogleMapsKML', '', false /* listed */);
	}

	function execute( $params ) {
		global $wgRequest, $wgOut, $wgTitle, $wgUser;
		global $wgContLang, $wgProxyKey, $wgParser;
		$article = $wgRequest->getText( 'article', $params );
		$map     = $wgRequest->getText( 'map', $params );

		$wgOut->disable();
		header("Cache-Control: no-cache, must-revalidate");
		header("Content-type: application/vnd.google-earth.kml+xml");
		header('Content-Disposition: attachment; filename="'.$article.'.kml"');

		$title = Title::newFromText($article);
		/* Wikia change begin - @author: Sebastian Marzjan */
		/* fogbugz BugID #18043 */
		if ($title instanceof Title) {
		/* Wikia change end */
			$revision = Revision::newFromTitle($title);

			/* Wikia change begin - @author: Sebastian Marzjan */
			/* fogbugz BugID #18043 */
			if(!($revision instanceof Revision)) {
				$errorMessage = 'SpecialGoogleMapsKML.php ' . __LINE__ . ' - no revision for ' . $article . ' / ' . $title->getArticleID();
				Wikia::log(__METHOD__,false, $errorMessage);
				echo "No article revisions found by the name of $article";
				return false;
			}
			/* Wikia change end */

			$mapOptions = GoogleMaps::getMapSettings($title,			
			array('icons' => 'http://maps.google.com/mapfiles/kml/pal4/{label}.png',
			'icon' => 'icon57'));

			$exporter = new GoogleMapsKmlExporter($wgContLang,
			str_replace('{label}', $mapOptions['icon'], $mapOptions['icons']));

			$wgParser->mOptions = ParserOptions::newFromUser( $wgUser );
			$wgParser->mOptions->setEditSection( false );
			$wgParser->mTitle = $wgTitle;
                        $wgParser->clearState();

                        $localParser = new Parser();
                        $localParser->mTitle = $title;
                        $localParser->mOptions = $wgParser->mOptions;

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
