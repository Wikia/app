<?php

class ArticleVideoController extends WikiaController {
	public function featured() {
		$requestContext = $this->getContext();
		$title = $requestContext->getTitle()->getPrefixedDBkey();

		$featuredVideoData = ArticleVideoContext::getFeaturedVideoData( $title );

		if ( !empty( $featuredVideoData ) ) {
			$requestContext->getOutput()->addModules( 'ext.ArticleVideo' );

			$this->setVal( 'videoDetails', $featuredVideoData );

			if ( ArticleVideoContext::isJWPlayer( $featuredVideoData ) ) {
				$jwPlayerScript = $requestContext->getOutput()->getResourceLoader()->getModule( 'ext.ArticleVideo.jw' )->getScript(
					new \ResourceLoaderContext( new \ResourceLoader(), $requestContext->getRequest())
				);

				$this->setVal(
					'jwPlayerScript',
					\JavaScriptMinifier::minify($jwPlayerScript)
				);

				$this->response->getView()->setTemplatePath( __DIR__ .
				                                             '/templates/ArticleVideo_jwfeatured.php' );
			} else {
				// TODO: replace it with DS icon when it's ready (XW-2824)
				$this->setVal( 'closeIconUrl', $this->getApp()->wg->extensionsPath . '/wikia/ArticleVideo/images/close.svg' );
			}
		} else {
			$this->skipRendering();
		}
	}

	public function related() {
		$title = RequestContext::getMain()->getTitle()->getPrefixedDBkey();

		$relatedVideo = ArticleVideoContext::getRelatedVideoData( $title );

		if ( !empty( $relatedVideo ) ) {
			$this->setVal( 'relatedVideo', $relatedVideo );
		} else {
			$this->skipRendering();
		}
	}

	public function labels() {
		$videoId = $this->getVal( 'videoId', null );

		if ( empty( $videoId ) ) {
			throw new MissingParameterApiException( 'videoId' );
		}

		$api = OoyalaBacklotApiService::getInstance();
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setVal( 'labels', $api->getLabels( $videoId ) );
	}
}
