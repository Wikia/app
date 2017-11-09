<?php

class ArticleVideoController extends WikiaController {
	public function featured() {
		global $wgLang;

		$requestContext = $this->getContext();
		$title = $requestContext->getTitle()->getPrefixedDBkey();

		$featuredVideoData = ArticleVideoContext::getFeaturedVideoData( $title );

		if ( !empty( $featuredVideoData ) ) {
			$requestContext->getOutput()->addModules( 'ext.ArticleVideo' );

			$featuredVideoData['lang'] = $wgLang->getCode();

			$this->setVal( 'videoDetails', $featuredVideoData );

			$jwPlayerScript =
				$requestContext->getOutput()->getResourceLoader()->getModule( 'ext.ArticleVideo.jw' )->getScript(
					new \ResourceLoaderContext( new \ResourceLoader(), $requestContext->getRequest() )
				);

			$this->setVal(
				'jwPlayerScript',
				\JavaScriptMinifier::minify( $jwPlayerScript )
			);
		} else {
			$this->skipRendering();
		}
	}
}
