<?php

/**
 * Internal API endpoint used by the article-video service.
 */
class ArticleVideoInternalController extends \WikiaController {

	public function init() {
		if ( !$this->request->isInternal() ) {
			throw new \ForbiddenException();
		}
	}

	/**
	 * Given a title string, return the ID of the current wiki and the ID of the corresponding article, if it exists.
	 *
	 * @throws \BadRequestException if the given title string is not valid
	 * @throws \NotFoundException if the given title does not exist
	 */
	public function getArticleId() {
		global $wgCityId;

		$this->response->setFormat( \WikiaResponse::FORMAT_JSON );

		$titleString = $this->request->getVal( 'title' );
		$title = \Title::newFromText( $titleString );

		if ( !$title ) {
			throw new \BadRequestException( 'Invalid title.' );
		}

		if ( !$title->exists() ) {
			throw new \NotFoundException( 'Title does not exist.' );
		}

		$this->response->setValues( [
			'cityId' => $wgCityId,
			'pageId' => $title->getArticleID(),
		] );
	}

	/**
	 * Purge video mappings cache, media details cache and CDN cache for the given article.
	 */
	public function purgeVideoInfo() {
		global $wgCityId;

		$this->response->setFormat( \WikiaResponse::FORMAT_JSON );

		ArticleVideoService::purgeVideoMemCache( $wgCityId );

		$pageId = $this->request->getInt( 'pageId' );
		$title = \Title::newFromID( $pageId );

		if ( $title ) {
			$title->purgeSquid();
		}
	}
}
