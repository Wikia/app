<?php

class MediaGalleryController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const MAX_ITEMS = 8;

	public function gallery() {
		$items = $this->getVal( 'items' );
		$media = [];

		foreach ( $items as $idx => $item ) {
			$file = wfFindFile( $item['title'] );

			if ( !$file instanceof File ) {
				continue; // todo: possible add error state
			}
			$thumb = $file->transform( ['width'=>500, 'height'=>500] );

			$src = wfReplaceImageServer( $thumb->getUrl(), $file->getTimestamp() );
			$dataSrc = false;
			$classes = '';
			if ( $idx >= self::MAX_ITEMS ) {
				$dataSrc = $src;
				$src = F::app()->wg->BlankImgUrl;
				$classes = 'hidden';
			}
			$media[] = [
				'src' => $src,
				'dataSrc' => $dataSrc,
				'classes' => $classes,
			];
		}

		$count = count( $media );
		$showMore = false;
		$showLess = false;
		if ( $count > self::MAX_ITEMS ) {
			$count = 'many';
			$showMore = wfMessage( 'mediagallery-show-more' );
			$showLess = wfMessage( 'mediagallery-show-less' );
		}

		$this->media = $media;
		$this->count = $count;
		$this->showMore = $showMore;
		$this->showLess = $showLess;
	}

}