<?php

class PortableInfoboxRenderService extends WikiaService {
	const LOGGER_LABEL = 'portable-infobox-render-not-supported-type';
	const DESKTOP_THUMBNAIL_WIDTH = 270;
	const MOBILE_THUMBNAIL_WIDTH = 360;
	const MINIMAL_HERO_IMG_WIDTH = 300;
	const MOBILE_TEMPLATE_POSTFIX = '-mobile';

	private $templates = [
		'wrapper' => 'PortableInfoboxWrapper.mustache',
		'title' => 'PortableInfoboxItemTitle.mustache',
		'header' => 'PortableInfoboxItemHeader.mustache',
		'image' => 'PortableInfoboxItemImage.mustache',
		'image-mobile' => 'PortableInfoboxItemImageMobile.mustache',
		'data' => 'PortableInfoboxItemData.mustache',
		'group' => 'PortableInfoboxItemGroup.mustache',
		'navigation' => 'PortableInfoboxItemNavigation.mustache',
		'hero-mobile' => 'PortableInfoboxItemHeroMobile.mustache'
	];
	private $templateEngine;

	function __construct() {
		$this->templateEngine = ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/../templates' );
	}

	/**
	 * renders infobox
	 *
	 * @param array $infoboxdata
	 *
	 * @return string - infobox HTML
	 */
	public function renderInfobox( array $infoboxdata, $theme, $layout ) {
		wfProfileIn( __METHOD__ );
		$infoboxHtmlContent = '';
		$heroData = [ ];

		foreach ( $infoboxdata as $item ) {
			$data = $item[ 'data' ];
			$type = $item[ 'type' ];

			switch ( $type ) {
				case 'group':
					$infoboxHtmlContent .= $this->renderGroup( $data );
					break;
				case 'navigation':
					$infoboxHtmlContent .= $this->renderItem( 'navigation', $data );
					break;
				default:
					if ( $this->isInfoboxHeroEnabled() && $this->isValidHeroDataItem( $item, $heroData ) ) {
						$heroData[ $type ] = $data;
						continue;
					}

					if ( $this->validateType( $type ) ) {
						$infoboxHtmlContent .= $this->renderItem( $type, $data );
					};
			}
		}

		if ( !empty( $heroData ) ) {
			$infoboxHtmlContent = $this->renderInfoboxHero( $heroData ) . $infoboxHtmlContent;
		}

		if ( !empty( $infoboxHtmlContent ) ) {
			$output = $this->renderItem( 'wrapper', [ 'content' => $infoboxHtmlContent, 'theme' => $theme, 'layout' => $layout ] );
		} else {
			$output = '';
		}

		wfProfileOut( __METHOD__ );

		return $output;
	}

	/**
	 * renders group infobox component
	 *
	 * @param array $groupData
	 *
	 * @return string - group HTML markup
	 */
	private function renderGroup( $groupData ) {
		$groupHTMLContent = '';
		$dataItems = $groupData[ 'value' ];
		$layout = $groupData[ 'layout' ];

		foreach ( $dataItems as $item ) {
			$type = $item[ 'type' ];

			if ( $this->validateType( $type ) ) {
				$groupHTMLContent .= $this->renderItem( $type, $item[ 'data' ] );
			}
		}

		return $this->renderItem( 'group', [ 'content' => $groupHTMLContent, 'layout' => $layout ] );
	}

	/**
	 * renders part of infobox
	 * If image element has invalid thumbnail, doesn't render this element at all.
	 *
	 * @param string $type
	 * @param array $data
	 * @return bool|string - HTML
	 */
	private function renderItem( $type, array $data ) {
		//TODO: with validated the performance of render Service and in the next phase we want to refactor it (make
		// it modular) While doing this we also need to move this logic to appropriate image render class
		if ( $type === 'image' ) {
			$data = $this->extendImageData( $data );

			if ( !$data ) {
				return false;
			}

			if ( $this->isWikiaMobile() ) {
				$type = $type . self::MOBILE_TEMPLATE_POSTFIX;
			}
		}

		if ( $this->isWikiaMobile() ) {
			$data = $this->sanitizeInfoboxTitle( $type, $data );
		}

		return $this->templateEngine->clearData()
			->setData( $data )
			->render( $this->templates[ $type ] );
	}

	/**
	 * @desc create a thumb of the image from file title
	 * @param $title
	 * @return bool|MediaTransformOutput
	 */
	protected function getThumbnail( $title ) {
		$file = \WikiaFileHelper::getFileFromTitle( $title );

		if ( $file ) {
			$width = $this->isWikiaMobile() ?
				self::MOBILE_THUMBNAIL_WIDTH :
				self::DESKTOP_THUMBNAIL_WIDTH;
			$thumb = $file->transform( [ 'width' => $width ] );

			if ( !is_null( $thumb ) && !$thumb->isError() ) {
				return $thumb;
			}
		}
		return false;
	}

	/**
	 * required for testing mobile template rendering
	 * @return bool
	 */
	protected function isWikiaMobile() {
		return F::app()->checkSkin( 'wikiamobile' );
	}

	/**
	 * return real width of the image.
	 * @param $title
	 * @return number
	 */
	protected function getFileWidth( $title ) {
		$file = \WikiaFileHelper::getFileFromTitle( $title );

		if ( $file ) {
			return $file->getWidth();
		}
	}

	/**
	 * check if item type is supported and logs unsupported types
	 *
	 * @param string $type - template type
	 *
	 * @return bool
	 */
	private function validateType( $type ) {
		$isValid = true;

		if ( !isset( $this->templates[ $type ] ) ) {
			Wikia\Logger\WikiaLogger::instance()->info( self::LOGGER_LABEL, [
				'type' => $type
			] );

			$isValid = false;
		}

		return $isValid;
	}

	/**
	 * returns true if infobox hero component should be rendered
	 *
	 * @return bool
	 */
	private function isInfoboxHeroEnabled() {
		return $this->isWikiaMobile();
	}

	/**
	 * checks if infobox data item is valid hero component data.
	 * If image is smaller than MINIMAL_HERO_IMG_WIDTH const, doesn't render the hero module.
	 *
	 * @param array $item - infobox data item
	 * @param array $heroData - hero component data
	 *
	 * @return bool
	 */
	private function isValidHeroDataItem( $item, $heroData ) {
		$type = $item[ 'type' ];

		if ( $type === 'title' && !array_key_exists( 'title', $heroData ) ) {
			return true;
		}

		if ( $type === 'image' && !array_key_exists( 'image', $heroData ) ) {
			$imageWidth = $this->getFileWidth( $item[ 'data' ][ 'name' ] );

			if ( $imageWidth > self::MINIMAL_HERO_IMG_WIDTH ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * renders infobox hero component
	 *
	 * @param array $data - infobox hero component data
	 *
	 * @return string
	 */
	private function renderInfoboxHero( $data ) {
		if ( array_key_exists( 'image', $data ) ) {
			$data[ 'image' ] = $this->extendImageData( $data[ 'image' ] );
			$markup = $this->renderItem( 'hero-mobile', $data );
		} else {
			$markup = $this->renderItem( 'title', $data[ 'title' ] );
		}

		return $markup;
	}

	/**
	 * extends image data
	 *
	 * @param array $data
	 *
	 * @return bool|array
	 */
	private function extendImageData( $data ) {
		$thumbnail = $this->getThumbnail( $data[ 'name' ] );

		if (!$thumbnail) {
			return false;
		}

		// TODO: the min() function will be redundant when https://wikia-inc.atlassian.net/browse/PLATFORM-1359
		// will hit the production
		$data[ 'height' ] = min( $thumbnail->getHeight(), $thumbnail->file->getHeight() );
		$data[ 'width' ] = min( $thumbnail->getWidth(), $thumbnail->file->getWidth() );
		$data[ 'thumbnail' ] = $thumbnail->getUrl();
		$data[ 'key' ] = urlencode( $data[ 'key' ] );
		$data[ 'media-type' ] = $data[ 'isVideo' ] ? 'video' : 'image';

		return $data;
	}

	/**
	 * checks if infobox item is the title or title inside the hero module
	 * and if so, removes from it all HTML tags.
	 *
	 * @param $type type of infobox item
	 * @param $data infobox item data
	 * @return infobox $data with sanitized title param if needed
	 */
	public function sanitizeInfoboxTitle( $type, $data ) {
		if ( $type === 'title' && !empty( $data[ 'value' ] ) ) {
			$data[ 'value' ] = trim( strip_tags( $data[ 'value' ] ) );
			return $data;
		}
		if ( $type === 'hero-mobile' && !empty( $data[ 'title' ][ 'value' ] ) ) {
			$data[ 'title' ][ 'value' ] = trim( strip_tags( $data[ 'title' ][ 'value' ] ) );
			return $data;
		}

		return $data;
	}
}
