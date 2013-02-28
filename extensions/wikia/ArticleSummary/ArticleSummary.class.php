<?php

class ArticleSummary {

	static public function blurb ($idList) {
		$app = F::App();

		# Iterate through each title per wiki ID
		foreach ($idList as $id) {
			$title = Title::newFromID($id);
			if (empty($title)) {
				$summary[$app->wg->CityId][$id] = array('error' => "Unable to find title for ID $id");
				break;
			}

			$dbName = WikiFactory::IDtoDB($app->wg->CityId);
			$wikiUrl = WikiFactory::DBtoUrl($dbName);

			$service = new ArticleService( $id );
			$snippet = $service->getTextSnippet();

			$imageServing = new ImageServing( array($id), 200, array( 'w' => 2, 'h' => 1 ) );
			$images = $imageServing->getImages(1); // get just one image per article

			$imageURL = '';
			if ( isset( $images[$id] ) ) {
				$imageURL = $images[$id][0]['url'];
			}

			$summary[$dbName][$id] = array(
				'wiki'       => $app->wg->Sitename,
				'wikiUrl'    => $wikiUrl,
				'titleDBkey' => $title->getPrefixedDBkey(),
				'titleText'  => $title->getFullText(),
				'articleId'  => $title->getArticleID(),
				'imageUrl'   => $imageURL,
				'url'        => $title->getFullURL(),
				'snippet'    => $snippet,
			);
		}

		return $summary;
	}
}
