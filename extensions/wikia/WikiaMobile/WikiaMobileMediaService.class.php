<?php
/**
 * WikiaMobile Media rendering
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
class WikiaMobileMediaService extends WikiaService {
	const CLASS_LAZYLOAD = 'lazy';
	const CLASS_MEDIA = 'media';
	const CLASS_SMALL = 'small';
	const THUMB_WIDTH = 480;
	const SINGLE = 1;
	const GROUP = 2;
	const SMALL_IMAGE_SIZE = 64;

	static public function calculateMediaSize( $width, $height ) {
		if ( $width > self::THUMB_WIDTH ) {
			$ratio = $width / self::THUMB_WIDTH;
			$targetWidth = self::THUMB_WIDTH;
			$targetHeight = (int) ($height / ( ( $ratio > 0 ) ? $ratio : 1 ));
		} else {
			$targetWidth = $width;
			$targetHeight = $height;
		}

		return array( 'width' => $targetWidth, 'height' => $targetHeight );
	}

	static public function isSmallImage( $width, $height ) {
		return (
			((int) $width < self::SMALL_IMAGE_SIZE) ||
			((int) $height < self::SMALL_IMAGE_SIZE)
		);
	}

	public function renderMedia() {
		wfProfileIn( __METHOD__ );

		$attribs = $this->request->getVal( 'attributes', [] );
		$params = $this->request->getVal( 'parameters', [] );
		$linkAttribs = $this->request->getVal( 'anchorAttributes', [] );
		$linked = $this->request->getBool( 'linked', false );
		$noscript = $this->request->getVal( 'noscript' );
		$class = $this->request->getVal( 'class', null );
		$caption = $this->request->getVal( 'caption', null );

		$this->response->setBody( $this->render( self::SINGLE, $attribs, $params, $linkAttribs, $linked, $noscript, $class, $caption ) );

		wfProfileOut( __METHOD__ );
	}

	public function renderMediaGroup() {
		wfProfileIn( __METHOD__ );

		$items = $this->request->getVal( 'items', [] );
		/**
		 * This is a parser from ImageGallery
		 * @var $parser Parser
		*/
		$parser = $this->request->getVal( 'parser' );

		//ImageGallery has parser as false by default
		//and getVal returns default value when there is no value for a parameter
		//false is not useful here but is a value nevertheless
		//that is why default value is set after getVal
		if ( !($parser instanceof Parser) ) {
			$parser = $this->wg->Parser;
		}

		$first = null;
		$wikiText = '';
		$result = '';
		$params = [];

		//separate linked items from normal ones and select the first one
		//which will be rendered in the page
		foreach ( $items as $item ) {
			/**
			 * @var $file File
			 */
			$file = wfFindFile( $item['title'] );

			if ( $file instanceof File ) {
				if ( !empty( $item['link'] ) || self::isSmallImage( $file->getWidth(), $file->getHeight() ) ) {
					$wikiText .= self::renderOutsideGallery( $item );
				} else {
					if ( empty( $first ) ) {
						$first = [ 'data' => $item, 'file' => $file ];
					}

					//prepare data for media collection
					$info = [
						'name' => htmlspecialchars( urlencode( $item['title']->getDBKey() ) ),
						'full' => wfReplaceImageServer( $file->getFullUrl(), $file->getTimestamp() )
					];

					if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {
						$info['type'] = 'video';
						$info['provider'] = $file->getProviderName();;
					}

					if ( !empty( $item['caption'] ) ) {
						$capt = $parser->internalParse( $item['caption'] );
						$parser->replaceLinkHolders( $capt );

						$info['capt'] = $capt;
					}

					$params[] = $info;
				}
			}
		}

		if ( !empty( $first ) && !empty( $params ) ) {
			$file = $first['file'];
			$origWidth = $file->getWidth();
			$origHeight = $file->getHeight();

			//only one non-linked media left
			if ( count( $params ) == 1 ) {
				$item = $first['data'];

				//build wikitext for a normal thumb
				$groupWikiText = '[[' . $item['title']->getPrefixedDBkey() . '|thumb|' . min( $origWidth, self::THUMB_WIDTH ) . 'px';

				if ( $item['caption'] ) {
					$groupWikiText .= "|{$item['caption']}";
				}

				$groupWikiText .= "]]\n";

				$wikiText = "{$groupWikiText}{$wikiText}";
			} else {
				//many left, proceed preparing and rendering the media group

				$size = self::calculateMediaSize( $origWidth, $origHeight );
				$thumb = $file->transform( $size );
				$attribs = array(
					'src' => wfReplaceImageServer( $thumb->getUrl(), $file->getTimestamp() ),
					'width' => $size['width'],
					'height' => $size['height']
				);

				$result = $this->render(
					self::GROUP,
					$attribs,
					$params,
					array(),
					false,
					Xml::element( 'img', $attribs, '', true ),
					[],
					wfMessage( 'wikiamobile-media-group-footer', count( $params ) )->inContentLanguage()->plain()
				);
			}
		}

		//if there's any raw wikitext left to parse
		//then do it now
		if ( !empty( $wikiText ) ) {
			$origVal = $this->wg->WikiaMobileDisableMediaGrouping;

			//avoid wikitext recursion
			$this->wg->WikiaMobileDisableMediaGrouping = true;

			//This wikiText is created locally here so we are safe with links also being normally replaced
			$result .= ParserPool::parse( $wikiText, $this->wg->Title, new ParserOptions() )->getText();;

			//restoring to previous value
			$this->wg->WikiaMobileDisableMediaGrouping = $origVal;
		}

		$this->response->setBody( $result );
		wfProfileOut( __METHOD__ );
	}

	//WARNING: any change to the template of this method should be reflected in WikiaMobileHooks::onParserAfterTidy
	public function renderImageTag() {
		wfProfileIn( __METHOD__ );

		$attribs = $this->request->getVal( 'attributes', [] );
		$params = $this->request->getVal( 'parameters', null );
		$linkAttribs = $this->request->getVal( 'anchorAttributes', [] );
		$noscript = $this->request->getVal( 'noscript', null );
		$linked = $this->request->getBool( 'linked', false );
		$content = $this->request->getVal( 'content' );
		$isSmall = $this->request->getVal( 'isSmall', false );

		// Don't include small or linked images in the mobile modal
		$includeInModal = !$linked && !$isSmall;
		$notClickable = !$linked && $isSmall;

		$attribs['data-src'] = $attribs['src'];
		$attribs['src'] = wfBlankImgUrl();
		$attribs['class'] = ( ( !empty( $attribs['class'] ) ) ? "{$attribs['class']} " : '' ) . self::CLASS_LAZYLOAD . ' ' . ( $includeInModal  ? ' ' . self::CLASS_MEDIA : '' ) . ( $notClickable  ? ' ' . self::CLASS_SMALL : '' );

		if ( !empty( $params ) ) {
			$attribs['data-params'] = htmlentities( json_encode( $params ) , ENT_QUOTES );
		}

		$this->response->setVal( 'attributes', $attribs );
		$this->response->setVal( 'anchorAttributes', $linkAttribs );
		$this->response->setVal( 'noscript', $noscript );
		$this->response->setVal( 'content', $content );

		wfProfileOut( __METHOD__ );
	}

	//WARNING: any change to the template of this method should be reflected in WikiaMobileHooks::onParserAfterTidy
	public function renderFigureTag() {
		wfProfileIn( __METHOD__ );

		$class = $this->request->getVal( 'class', [] );
		$content = $this->request->getVal( 'content', null );
		$caption = $this->request->getVal( 'caption', null );
		$isSmall = $this->request->getVal( 'isSmall', false );

		if ( $isSmall ) {
			$class[] = self::CLASS_SMALL;
		}

		if ( !empty( $class ) ) {
			$class = implode( ' ', $class );
		}

		$this->response->setVal( 'isSmall', $isSmall );
		$this->response->setVal( 'class', $class );
		$this->response->setVal( 'content', $content );
		$this->response->setVal( 'caption', $caption );

		wfProfileOut( __METHOD__ );
	}

	private function render( $type, Array $attribs = [], Array $params = [], Array $linkAttribs = [], $link = false, $noscript = null, $class = null, $caption = null ) {
		wfProfileIn( __METHOD__ );

		if ( !is_array( $class ) ) {
			$class = [];
		}

		if ( !empty( $params ) ) {
			if ( $type == self::SINGLE ) {
				//this needs to happen before any manipulation of the $caption variable happens
				if ( !empty( $caption ) ) {
					$params['capt'] = true;
				}

				//JS always expects data for a media group to simplify the code hence wrap the data in an array
				$params = array( $params );
			} else {
				//force sequential array to avoid being encoded as an object in JSON
				$params = array_values( $params );
			}
		} else {
			$params = null;
		}

		//ensure caption box if link is set
		if ( $caption === null && !empty( $link ) ) {
			$caption = '';
		}

		$isSmall = self::isSmallImage( $attribs['width'], $attribs['height'] );

		$image = $this->sendSelfRequest(
			'renderImageTag',
			array(
				'attributes' => $attribs,
				'parameters' => $params,
				'anchorAttributes' => $linkAttribs,
				'linked' => !empty( $link ),
				'noscript' => $noscript,
				'isSmall' => $isSmall
			)
		);

		$result = $this->sendSelfRequest(
			'renderFigureTag',
			array(
				'class' => array_merge([( ( !empty( $link ) ) ? 'link' : 'thumb' )], $class),
				'content' => $image->toString(),
				'caption' => $caption,
				'isSmall' => $isSmall,
			)
		)->toString();

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Build wikitext for images to render separately
	 * @param $item
	 * @return string
	 */
	private function renderOutsideGallery( $item ) {
		$wikiText = "[[" . $item['title']->getPrefixedDBkey();

		if ( !empty( $item['link'] ) ) {
			$wikiText .= "|link=" . $item['link'];
		}

		if ( !empty( $item['caption'] ) ) {
			$wikiText .= "|" . $item['caption'];
		}

		$wikiText .= "]]\n";

		return $wikiText;
	}
}