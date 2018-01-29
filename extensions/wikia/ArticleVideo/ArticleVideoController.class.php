<?php

class ArticleVideoController extends WikiaController {

	private function fallbackLanguage( $lang ) {
		switch ( $lang ) {
			case 'zh-hans':
				return 'zh';
			case 'zh-tw':
				return 'zh-hant';
			case 'pt-br':
				return 'pt';
			default:
				return $lang;
		}
	}

	public function featured() {
		$requestContext = $this->getContext();
		$pageId = $requestContext->getTitle()->getArticleID();
		$lang = $requestContext->getLanguage()->getCode();

		$featuredVideoData = ArticleVideoContext::getFeaturedVideoData( $pageId );

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

	public function purgeVideo() {
		global $wgCityId;

		$request = RequestContext::getMain()->getRequest();
		$articleId = $request->getVal( 'articleId', null );
		$internalRequest = $request->getHeader( 'X-Wikia-Internal-Request' );

		if ( empty( $articleId ) || !$request->wasPosted() ) {
			throw new BadRequestException();
		}

		if ( empty( $internalRequest ) ) {
			throw new ForbiddenException();
		}

		ArticleVideoService::purgeVideoMemCache( $wgCityId );
		Title::newFromID($articleId)->purgeSquid();
	}
}
