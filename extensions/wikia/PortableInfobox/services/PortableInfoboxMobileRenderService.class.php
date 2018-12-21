<?php

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
	public function renderInfobox( array $infoboxdata, $theme, $layout, $accentColor, $accentColorText, $type, $name ) {
		$items = $this->splitOfHeroData( $infoboxdata, [ 'hero' => [ ], 'infobox' => [ ] ] );

		if ( !empty( $items['hero'] ) ) {
			$infoboxHtmlContent = $this->renderInfoboxHero( $items['hero'] ) . $this->renderChildren( $items['infobox'] );
		} else {
			$infoboxHtmlContent = $this->renderChildren( $infoboxdata );
		}

		if ( !empty( $infoboxHtmlContent ) ) {
			$output = $this->renderItem( 'wrapper', [ 'content' => $infoboxHtmlContent, 'isMercury' => $this->isMercury() ] );
		} else {
			$output = '';
		}

		// Since portable infoboxes are rendered within ParserAfterTidy Hook, we can not be sure if this method will be
		// invoked before or after infobox is rendered. If this method does not process PI html, markers related to
		// template type parsing may be included in the result html and this may break our mobile application.
		// See XW-4827
		TemplateTypesParser::onParserAfterTidy( null, $output );

		\Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag::getInstance()->setFirstInfoboxAlredyRendered( true );

		return $output;
	}

	private function splitOfHeroData( $items, $result ) {
		foreach ( $items as $item ) {
			$data = $item['data'];
			$type = $item['type'];

			if ( $this->isValidHeroDataItem( $item, $result['hero'] ) ) {
				$result['hero'][$type] = $data;
			} elseif ( $type === 'group' ) {
				// go deeper to find nested hero data items
				$groupResult = $this->splitOfHeroData( $data['value'], [ 'hero' => $result['hero'], 'infobox' => [ ] ] );
				// make sure other elements structure stays the same
				$result['hero'] = $groupResult['hero'];
				$item['data']['value'] = $groupResult['infobox'];
				$result['infobox'][] = $item;
			} else {
				$result['infobox'][] = $item;
			}
		}

		return $result;
	}

	protected function renderImage( $data ) {
		$images = [ ];
		$count = count( $data );
		$helper = $this->getImageHelper();

		if ( $count > 1 ) {
			for ( $i = 0; $i < $count; $i++ ) {
				$data[$i]['context'] = self::MEDIA_CONTEXT_INFOBOX;
				$data[$i] = $helper->extendMobileImageData( $data[$i], self::MOBILE_THUMBNAIL_WIDTH, self::MOBILE_THUMBNAIL_WIDTH );

				if ( !!$data[$i] ) {
					$images[] = $data[$i];
				}
			}
		} elseif ($count === 1) {
			$data[0]['context'] = self::MEDIA_CONTEXT_INFOBOX;
			$data[0] = $helper->extendMobileImageDataScaleToWidth( $data[0], self::MOBILE_THUMBNAIL_WIDTH );

			if ( !!$data[0] ) {
				$images[] = $data[0];
			}
		}

		if ( count( $images ) === 0 ) {
			return '';
		}

		// use different template for wikiamobile
		if ( !$this->isMercury() ) {
			// always display only the first image on WikiaMobile
			$data = $images[0];
			$templateName = 'image-mobile-wikiamobile';
		} else {
			if ( count( $images ) === 1 ) {
				$data = $images[0];
				$templateName = 'image-mobile';
			} else {
				// more than one image means image collection
				$data = $helper->extendMobileImageCollectionData( $images );
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
        return $this->render( 'header-mobile', $data );
	}

	protected function renderPanel( $data, $type='panel-mobile' ) {
		return parent::renderPanel($data, $type);
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
		$helper = $this->getImageHelper();
		$template = '';

		// In mobile-wiki SPA content of the first infobox's hero module has been moved to the article header.
		$firstInfoboxAlredyRendered = \Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag::getInstance()
			->isFirstInfoboxAlredyRendered();

		if ( isset( $data['image'] ) ) {
			$image = $data['image'][0];
			$image['context'] = self::MEDIA_CONTEXT_INFOBOX_HERO_IMAGE;
			$image = $helper->extendMobileImageData( $image, self::MOBILE_THUMBNAIL_WIDTH, self::MOBILE_THUMBNAIL_WIDTH );

			$data['image'] = $image;

			if ( !$this->isMercury() ) {
				return $this->renderItem( 'hero-mobile-wikiamobile', $data );
			} elseif ( $firstInfoboxAlredyRendered ) {
				return $this->renderItem( 'hero-mobile', $data );
			}
		} elseif ( !$this->isMercury() || $firstInfoboxAlredyRendered ) {
			return $this->renderItem( 'title', $data['title'] );
		}

		return !empty( $template ) ? $this->renderItem( $template, $data['title'] ) : '';
	}

	protected function renderHorizontalGroupContent( $groupContent ) {
		return $this->renderItem(
			'horizontal-group-content-mobile',
			$this->createHorizontalGroupData( $groupContent )
		);
	}

	/**
	 * checks if infobox data item is valid hero component data.
	 *
	 * @param array $item - infobox data item
	 * @param array $heroData - hero component data
	 *
	 * @return bool
	 */
	private function isValidHeroDataItem( $item, $heroData ) {
		$type = $item['type'];

		return ( $type === 'title' && !isset( $heroData['title'] ) ) ||
		       ( $type === 'image' && !isset( $heroData['image'] ) &&
		         count( $item['data'] ) === 1 );
	}

	private function isMercury() {
		global $wgArticleAsJson;

		return !empty( $wgArticleAsJson );
	}
}
