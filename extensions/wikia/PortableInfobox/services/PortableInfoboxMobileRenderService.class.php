<?php

use Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper;

class PortableInfoboxMobileRenderService extends PortableInfoboxRenderService {
	const MEDIA_CONTEXT_INFOBOX_HERO_IMAGE = 'infobox-hero-image';
	const MEDIA_CONTEXT_INFOBOX = 'infobox';
	const MOBILE_THUMBNAIL_WIDTH = 360;

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
		$helper = $this->getRenderHelper();
		$infoboxHtmlContent = '';
		$heroData = [ ];

		foreach ( $infoboxdata as $item ) {
			$data = $item['data'];
			$type = $item['type'];

			if ( $helper->isValidHeroDataItem( $item, $heroData ) ) {
				$heroData[$type] = $data;
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

		return $output;
	}

	protected function renderImage( $data ) {
		$images = [ ];
		$count = count( $data );
		$helper = $this->getRenderHelper();

		for ( $i = 0; $i < $count; $i++ ) {
			$data[$i]['context'] = self::MEDIA_CONTEXT_INFOBOX;
			$data[$i] = $helper->extendImageData( $data[$i], self::MOBILE_THUMBNAIL_WIDTH );

			if ( !!$data[$i] ) {
				$images[] = $data[$i];
			}
		}

		if ( count( $images ) === 0 ) {
			return '';
		}

		// use different template for wikiamobile
		if ( !$helper->isMercury() ) {
			// always display only the first image on WikiaMobile
			$data = $images[0];
			$templateName = 'image-mobile-wikiamobile';
		} else {
			if ( count( $images ) === 1 ) {
				$data = $images[0];
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

	protected function renderTitle( $data ) {
		return $this->render( 'title', $data );
	}

	protected function renderHeader( $data ) {
		return $this->render( 'header', $data );
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
		$helper = $this->getRenderHelper();
		$template = '';

		// In Mercury SPA content of the first infobox's hero module has been moved to the article header.
		$firstInfoboxAlredyRendered = \Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag::getInstance()
			->isFirstInfoboxAlredyRendered();

		if ( isset( $data['image'] ) ) {
			$image = $data['image'][0];
			$image['context'] = self::MEDIA_CONTEXT_INFOBOX_HERO_IMAGE;
			$image = $helper->extendImageData( $image, self::MOBILE_THUMBNAIL_WIDTH );
			$data['image'] = $image;

			if ( !$helper->isMercury() ) {
				return $this->renderItem( 'hero-mobile-wikiamobile', $data );
			} elseif ( $firstInfoboxAlredyRendered ) {
				return $this->renderItem( 'hero-mobile', $data );
			}
		} elseif ( !$helper->isMercury() || $firstInfoboxAlredyRendered ) {
			return $this->renderItem( 'title', $data['title'] );
		}

		return !empty( $template ) ? $this->renderItem( $template, $data['title'] ) : '';
	}
}
