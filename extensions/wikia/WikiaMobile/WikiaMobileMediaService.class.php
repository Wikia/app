<?php
/**
 * WikiaMobile Media rendering
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
class WikiaMobileMediaService extends WikiaService {
	const CLASS_LAZYLOAD = 'lazy';
	const CLASS_MEDIA = 'media';
	const THUMB_WIDTH = 480;
	const SINGLE = 1;
	const GROUP = 2;
	const RIBBON_SIZE = 50;

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

	static public function showRibbon( $width, $height ) {
		if( $width < self::RIBBON_SIZE || $height < self::RIBBON_SIZE ) {
			return false;
		}

		return true;
	}

	public function renderMedia() {
		$this->wf->profileIn( __METHOD__ );

		$attribs = $this->request->getVal( 'attributes', array() );
		$params = $this->request->getVal( 'parameters', array() );
		$linkAttribs = $this->request->getVal( 'anchorAttributes', array() );
		$linked = $this->request->getBool( 'linked' );
		$noscript = $this->request->getVal( 'noscript' );
		$class = $this->request->getVal( 'class', null );
		$caption = $this->request->getVal( 'caption', null );
		$this->response->setBody( $this->render( self::SINGLE, $attribs, $params, $linkAttribs, $linked, $noscript, $class, $caption ) );

		$this->wf->profileOut( __METHOD__ );
	}

	public function renderMediaGroup() {
		$this->wf->profileIn( __METHOD__ );

		$items = $this->request->getVal( 'items', array() );
		$first = null;
		$wikiText = '';
		$result = '';
		$params = array();

		//separate linked items from normal ones and select the first one
		//which will be rendered in the page
		foreach ( $items as $item ) {
			/**
			 * @var $file File
			 */
			$file = $this->wf->FindFile( $item['title'] );

			if ( $file instanceof File ) {
				if ( !empty( $item['link'] ) ) {
					//build wikitext for linked images to render separately
					$wikiText .= "[[" . $item['title']->getPrefixedDBkey() . "|link=" . $item['link'];

					if ( !empty( $item['caption'] ) ) {
						$wikiText .= "|{$item['caption']}";
					}

					$wikiText .= "]]\n";
				} else {
					if ( empty( $first ) ) {
						$first = array( 'data' => $item, 'file' => $file );
					}

					//prepare data for media collection
					$info = array(
						'name' => $item['title']->getText(),
						'full' => $this->wf->ReplaceImageServer( $file->getFullUrl(), $file->getTimestamp() )
					);

					if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {
						$info['type'] = 'video';
					}

					if ( !empty( $item['caption'] ) ) {
						$info['capt'] = $item['caption'];
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
					'src' => $this->wf->ReplaceImageServer( $thumb->getUrl(), $file->getTimestamp() ),
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
					null,
					$this->wf->MsgForContent( 'wikiamobile-media-group-footer', count( $params ) )
				);
			}
		}

		//if there's any raw wikitext left to parse
		//then do it now
		if ( !empty( $wikiText ) ) {
			$origVal = $this->wg->WikiaMobileDisableMediaGrouping;

			//avoid wikitext recursion
			$this->wg->WikiaMobileDisableMediaGrouping = true;

			$result .= $this->wg->Parser->recursiveTagParse( $wikiText );

			//restoring to previous value
			$this->wg->WikiaMobileDisableMediaGrouping = $origVal;
		}

		$this->response->setBody( $result );
		$this->wf->profileOut( __METHOD__ );
	}

	//WARNING: any change to the template of this method should be reflected in WikiaMobileHooks::onParserAfterTidy
	public function renderImageTag() {
		$this->wf->profileIn( __METHOD__ );

		$attribs = $this->request->getVal( 'attributes', array() );
		$params = $this->request->getVal( 'parameters', null );
		$linkAttribs = $this->request->getVal( 'anchorAttributes', array() );
		$noscript = $this->request->getVal( 'noscript', null );
		$linked = $this->request->getBool( 'linked', false );
		$content = $this->request->getVal( 'content' );

		$attribs['data-src'] = $attribs['src'];
		$attribs['src'] = $this->wf->BlankImgUrl();
		$attribs['class'] = ( ( !empty( $attribs['class'] ) ) ? "{$attribs['class']} " : '' ) . self::CLASS_LAZYLOAD . ( !$linked  ? ' ' . self::CLASS_MEDIA : '' );

		if ( !empty( $params ) ) {
			$attribs['data-params'] = htmlentities( json_encode( $params ) , ENT_QUOTES );
		}

		$this->response->setVal( 'attributes', $attribs );
		$this->response->setVal( 'anchorAttributes', $linkAttribs );
		$this->response->setVal( 'noscript', $noscript );
		$this->response->setVal( 'content', $content );

		$this->wf->profileOut( __METHOD__ );
	}

	//WARNING: any change to the template of this method should be reflected in WikiaMobileHooks::onParserAfterTidy
	public function renderFigureTag() {
		$this->wf->profileIn( __METHOD__ );

		$class = $this->request->getVal( 'class', null );
		$content = $this->request->getVal( 'content', null );
		$caption = $this->request->getVal( 'caption', null );
		$showRibbon = $this->request->getVal( 'showRibbon', false );

		if ( is_array( $class ) ) {
			$class = implode( ' ', $class );
		}

		$this->response->setVal( 'showRibbon', $showRibbon );
		$this->response->setVal( 'class', $class );
		$this->response->setVal( 'content', $content );
		$this->response->setVal( 'caption', $caption );

		$this->wf->profileOut( __METHOD__ );
	}

	private function render( $type, Array $attribs = array(), Array $params = array(), Array $linkAttribs = array(), $link = false, $noscript = null, $class = null, $caption = null ) {
		$this->wf->profileIn( __METHOD__ );

		if ( is_array( $class ) ) {
			$class = implode( ' ', $class );
		}

		if ( !empty( $class ) ) {
			$class = " {$class}";
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

		$content = $this->sendSelfRequest(
			'renderImageTag',
			array(
				'attributes' => $attribs,
				'parameters' => $params,
				'anchorAttributes' => $linkAttribs,
				'linked' => !empty( $link ),
				'noscript' => $noscript
			)
		)->toString();

		$result = $this->sendSelfRequest(
			'renderFigureTag',
			array(
				'class' => ( ( !empty( $link ) ) ? 'link' : 'thumb' ) . $class,
				'content' => $content,
				'caption' => $caption,
				'showRibbon' => self::showRibbon( $attribs['width'], $attribs['height'] )
			)
		)->toString();

		$this->wf->profileOut( __METHOD__ );
		return $result;
	}
}