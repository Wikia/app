<?php

/**
 * Class ArticleSummaryController
 */
class ArticleSummaryController extends WikiaController {

	/**
	 * Returns information to summarize an article with a snippet of text and a picture if applicable.
	 */
	public function blurb() {
		wfProfileIn( __METHOD__ );

		$idStr = $this->request->getVal( 'ids' );
		$ids = explode( ',', $idStr );

		$summary = array();

		# Iterate through each title per wiki ID
		foreach ( $ids as $id ) {
			$title = Title::newFromID( $id );
			if ( empty( $title ) ) {
				$summary[$this->wg->CityId]['error'][] = "Unable to find title for ID $id";
				break;
			}

			$service = new ArticleService( $id );
			$snippet = $service->getTextSnippet();

			$imageServing = new ImageServing( array( $id ), 200, array( 'w' => 2, 'h' => 1 ) );
			$images = $imageServing->getImages( 1 ); // get just one image per article

			$imageURL = '';
			if ( isset( $images[$id] ) ) {
				$imageURL = $images[$id][0]['url'];
			}

			$summary[$id] = array(
				'wiki'       => $this->wg->Sitename,
				'wikiUrl'    => $this->wg->Server,
				'titleDBkey' => $title->getPrefixedDBkey(),
				'titleText'  => $title->getFullText(),
				'articleId'  => $title->getArticleID(),
				'imageUrl'   => $imageURL,
				'url'        => $title->getFullURL(),
				'snippet'    => $snippet,
			);
		}

		wfProfileOut( __METHOD__ );

		$this->summary = $summary;
	}
}