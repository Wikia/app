<?php

class EpisodesNavController extends WikiaController {

	public function index() {
		$title = $this->getContext()->getTitle();
		$articleService = new ArticleService( $title );

		$type = $articleService->getArticleType();

		if ( $type === 'tv_episode' ) {
			$proccess = new InfoboxEpisodes(
				PortableInfoboxDataService::newFromTitle( $title )->getData()
			);
			$next = $proccess->getNextEpisode();
			if ( !empty( $next ) ) {
				$nextTitle = Title::newFromText( $next );
				$this->setVal( 'nextTitle', $nextTitle->getText() );
				$nextImage = $this->getImageForArticle( $nextTitle->getArticleID() );
				$this->setVal( 'nextImage', $nextImage );
				$this->setVal( 'nextLink', $nextTitle->getLocalURL() );
			}
			$previous = $proccess->getPreviousEpisode();
			if ( !empty( $previous ) ) {
				$prevTitle = Title::newFromText( $previous );
				$this->setVal( 'prevTitle', $prevTitle->getText() );
				$prevImage = $this->getImageForArticle( $prevTitle->getArticleID() );
				$this->setVal( 'prevImage', $prevImage );
				$this->setVal( 'prevLink', $prevTitle->getLocalURL() );
			}
		} else {
			$this->skipRendering();
		}
	}

	public function similar() {
		$title = $this->getContext()->getTitle();
		if ( !empty( PortableInfoboxDataService::newFromTitle( $title )->getData() ) && $title->inNamespace( NS_MAIN ) ) {

			$templates = $title->getTemplateLinksFrom();

			/** @var Title $template */
			$infoboxes = array_filter( $templates, function ( $template ) {
				return !empty( PortableInfoboxDataService::newFromTitle( $template )->getData() );
			} );

			/** @var Title $infoboxTitle */
			$infoboxTitle = reset( $infoboxes );
			$usedIn = array_filter( $infoboxTitle->getTemplateLinksTo(), function ( $title ) {
				return $title->inNamespace( NS_MAIN );
			} );

			$data = array_map( function ( $title ) {
				return [
					'title' => $title->getText(),
					'link' => $title->getLocalURL(),
					'image' => $this->getImageForArticle( $title->getArticleID() )
				];
			}, $usedIn );

			$data = array_filter( $data, function ( $item ) {
				return !empty( $item['image'] );
			} );

			if ( count( $data ) > 1 ) {
				$this->setVal( 'articles', $data );
			} else {
				$this->skipRendering();
			}
		} else {
			$this->skipRendering();
		}
	}

	private function getImageForArticle( $id ) {
		$image = ( new ImageServing( [ $id ], 150, 250 ) )->getImages( 1 );
		if ( isset( $image[$id] ) ) {
			return $image[$id][0]['url'];
		}
		return '';
	}
}
