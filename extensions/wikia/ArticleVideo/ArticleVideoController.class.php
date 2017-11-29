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

	private function getIsoTime( $colonDelimitedTime ) {
		$segments = explode( ':', $colonDelimitedTime );
		$isoTime = '';

		if ( count( $segments ) > 2 ) {
			$isoTime = 'H' . $segments[0] . 'M' . $segments[1] . 'S' . $segments[2];
		} else if ( count( $segments ) > 1 ) {
			$isoTime = 'M' . $segments[0] . 'S' . $segments[1];
		} else if ( count( $segments ) > 0 ) {
			$isoTime = 'S' . $segments[0];
		}

		return $isoTime;
	}

	private function getVideoContentUrl( $sources ) {
		return $sources[count( $sources ) - 1]['file'];
	}

	private function getVideoMetaData( $videoDetails ) {
		$playlistItem = $videoDetails['playlist'][0];

		return [
			'name' => $videoDetails['title'],
			'thumbnailUrl' => $playlistItem['image'],
			'uploadDate' => date( 'c', $playlistItem['pubdate'] ),
			'duration' => $this->getIsoTime( $videoDetails['duration'] ),
			'description' => $videoDetails['description'],
			'contentUrl' => self::getVideoContentUrl( $playlistItem['sources'] )
		];
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
			$this->setVal( 'videoMetaData', $this->getVideoMetaData( $featuredVideoData ) );

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
