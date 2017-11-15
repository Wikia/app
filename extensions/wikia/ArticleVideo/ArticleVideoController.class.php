<?php

class ArticleVideoController extends WikiaController {

	private function fallbackLanguage( $lang ) {
		switch ( $lang ) {
			case 'zh-hant':
			case 'zh-tw':
				return 'zh';
			case 'pt-br':
				return 'pt';
			default:
				return $lang;
		}
	}

	public function featured() {
		$requestContext = $this->getContext();
		$title = $requestContext->getTitle()->getPrefixedDBkey();
		$lang = $requestContext->getLanguage()->getCode();

		$featuredVideoData = ArticleVideoContext::getFeaturedVideoData( $title );

		if ( !empty( $featuredVideoData ) ) {
			$requestContext->getOutput()->addModules( 'ext.ArticleVideo' );

			$featuredVideoData['lang'] = $this->fallbackLanguage( $lang );

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
