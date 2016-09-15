<?php

class CrosslinkTagController extends WikiaController {

	/**
	 * Crosslink Tag
	 * @responseParam array articles - list of articles
	 * @responseParam string readMore
	 */
	public function index() {
		$urls = $this->request->getVal( 'urls', [] );

		$helper = new CrosslinkTagHelper();

		$articles = [];
		foreach ( $urls as $url ) {
			$urlParts = parse_url( $url );
			if ( !empty( $urlParts['host'] ) && strtolower( $urlParts['host'] ) == CrosslinkTagHelper::VALID_HOST ) {
				$urlParts = parse_url( $url );
				$slug = preg_replace( '/^\/(articles|videos)?\//', '', $urlParts['path'] );
				$item = $helper->getArticleData( $slug );
				if ( !empty( $item ) ) {
					$articles[] = $item;
				}
			}
		}

		$this->response->addAsset( 'crosslink_tag_scss' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->articles = $articles;
		$this->readMore = wfMessage('crosslink-tag-read-more')->escaped();
	}

}
