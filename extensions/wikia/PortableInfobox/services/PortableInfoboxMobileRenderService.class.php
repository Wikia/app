<?php

use Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper;

class PortableInfoboxMobileRenderService extends PortableInfoboxRenderService {
	const MEDIA_CONTEXT_INFOBOX_HERO_IMAGE = 'infobox-hero-image';
	const MEDIA_CONTEXT_INFOBOX = 'infobox';

	protected $imagesWidth = PortableInfoboxRenderServiceHelper::MOBILE_THUMBNAIL_WIDTH;

	/**
	 * renders infobox
	 *
	 * @param array $infoboxdata
	 *
	 * @param $theme
	 * @param $layout
	 * @param $accentColor
	 * @param $accentColorText
	 * @return string - infobox HTML
	 */
	public function renderInfobox( array $infoboxdata, $theme, $layout, $accentColor, $accentColorText ) {
		wfProfileIn( __METHOD__ );

		$helper = new PortableInfoboxRenderServiceHelper();
		$infoboxHtmlContent = '';
		$heroData = [ ];

		foreach ( $infoboxdata as $item ) {
			$data = $item[ 'data' ];
			$type = $item[ 'type' ];

			if ( $helper->isValidHeroDataItem( $item, $heroData ) ) {
				$heroData[ $type ] = $data;
				continue;
			} elseif ( $this->templateEngine->isSupportedType( $type ) ) {
				$infoboxHtmlContent .= $this->renderItem( $type, $data );
			}
		}

		if ( !empty( $heroData ) ) {
			$infoboxHtmlContent = $this->renderInfoboxHero( $heroData ) . $infoboxHtmlContent;
		}

		if ( !empty( $infoboxHtmlContent ) ) {
			$output = $this->renderItem( 'wrapper', [ 'content' => $infoboxHtmlContent ] );
		} else {
			$output = '';
		}

		\Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag::getInstance()->setFirstInfoboxAlredyRendered( true );

		wfProfileOut( __METHOD__ );

		return $output;
	}

	protected function renderImage( $data ) {
		$images = [ ];
		$helper = new PortableInfoboxRenderServiceHelper();

		for ( $i = 0; $i < count( $data ); $i++ ) {
			$data[ $i ][ 'context' ] = self::MEDIA_CONTEXT_INFOBOX;
			$data[ $i ] = $helper->extendImageData( $data[ $i ], $this->imagesWidth );

			if ( !!$data[ $i ] ) {
				$images[] = $data[ $i ];
			}
		}

		if ( count( $images ) === 0 ) {
			return '';
		}

		// use different template for wikiamobile
		if ( !$helper->isMercury() ) {
			// always display only the first image on WikiaMobile
			$data = $images[ 0 ];
			$templateName = 'image-mobile-wikiamobile';
		} else {
			if ( count( $images ) === 1 ) {
				$data = $images[ 0 ];
				$templateName = 'image-mobile';
			} else {
				// more than one image means image collection
				$data = $helper->extendImageCollectionData( $images );
				$templateName = 'image-collection-mobile';
			}
		}

		$data = SanitizerBuilder::createFromType( 'image' )->sanitize( $data );
		return parent::render( $templateName, $data );
	}

	protected function render( $type, array $data ) {
		$data = SanitizerBuilder::createFromType( $type )->sanitize( $data );

		return parent::render( $type, $data );
	}

	/**
	 * renders infobox hero component
	 *
	 * @param array $data - infobox hero component data
	 *
	 * @return string
	 */
	private function renderInfoboxHero( $data ) {
		$helper = new PortableInfoboxRenderServiceHelper();

		// In Mercury SPA content of the first infobox's hero module has been moved to the article header.
		$firstInfoboxAlredyRendered = \Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag::getInstance()
			->isFirstInfoboxAlredyRendered();

		if ( array_key_exists( 'image', $data ) ) {
			$image = $data[ 'image' ][ 0 ];
			$image[ 'context' ] = self::MEDIA_CONTEXT_INFOBOX_HERO_IMAGE;
			$image = $helper->extendImageData( $image, PortableInfoboxRenderServiceHelper::MOBILE_THUMBNAIL_WIDTH );
			$data[ 'image' ] = $image;

			if ( !$helper->isMercury() ) {
				return $this->renderItem( 'hero-mobile-wikiamobile', $data );
			} elseif ( $firstInfoboxAlredyRendered ) {
				return $this->renderItem( 'hero-mobile', $data );
			}
		} elseif ( !$helper->isMercury() || $firstInfoboxAlredyRendered ) {
			return $this->renderItem( 'title', $data[ 'title' ] );
		}

		return '';
	}
}
