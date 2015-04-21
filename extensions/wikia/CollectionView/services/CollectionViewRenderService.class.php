<?php

class CollectionViewRenderService extends WikiaService {
	const LOGGER_LABEL = 'collection-view-render-not-supported-type';

	private $templates = [
		'wrapper' => 'CollectionViewWrapper.mustache',
		'header' => 'CollectionViewHeader.mustache',
		'item' => 'CollectionViewItem.mustache'
	];
	private $templateEngine;

	function __construct() {
		$this->templateEngine = ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/../templates' );
	}

	/**
	 * renders collection view
	 *
	 * @param array $collectionViewData
	 * @param int $collectionViewIndex
	 * @return string - HTML
	 */
	public function renderCollectionView( array $collectionViewData, $collectionViewIndex ) {
		global $wgArticleAsJson;
		$out = '';

		if ( $wgArticleAsJson ) {
			return '<div class="collection-view" data-ref="' . $collectionViewIndex . '"></div>';
		}

		foreach ( $collectionViewData as $item ) {
			$data = $item[ 'data' ];
			$type = $item[ 'type' ];
			if ( !$item[ 'isEmpty' ] ) {
				// skip rendering for not supported type and log it
				if ( !isset( $this->templates[ $type ] ) ) {
					Wikia\Logger\WikiaLogger::instance()->info( self::LOGGER_LABEL, [
						'type' => $type
					] );
					continue;
				}
				$out .= $this->renderItem( $type, $data );
			}
		}

		return $this->renderItem( 'wrapper', [ 'content' => $out ] );
	}

	/**
	 * renders part of collection view
	 *
	 * @param string $type
	 * @param array $data
	 * @return string - HTML
	 */
	private function renderItem( $type, array $data ) {
		return $this->templateEngine->clearData()
			->setData( $data )
			->render( $this->templates[ $type ] );
	}
}
