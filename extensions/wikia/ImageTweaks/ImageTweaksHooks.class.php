<?php

class ImageTweaksHooks extends WikiaObject {

	static private $isWikiaMobile = null;
	static private $isOasis = null;

	function __construct(){
		parent::__construct();

		if ( self::$isOasis === null )
			self::$isOasis = $this->app->checkSkin( 'oasis' );

		if ( self::$isWikiaMobile === null )
			self::$isWikiaMobile = ( !empty( $isOasis ) ) ? false : $this->app->checkSkin( 'wikiamobile' );
	}

	public function onThumbnailAfterProduceHTML( $title, $file, $frameParams, $handlerParams, $outerWidth, $thumb, $thumbParams, $zoomIcon, $url,  $time, $origHTML, &$html ){
		$this->wf->profileIn( __METHOD__ );

		if ( self::$isWikiaMobile ) {
			$linked = !empty( $frameParams['link-url'] ) || !empty( $frameParams['link-title'] );
			$caption = ( !empty( $frameParams['caption'] ) ) ? $frameParams['caption'] : null;

			$html = $this->app->sendRequest(
				'WikiaMobileMediaService',
				'renderFigureTag',
				array(
					'class' => ( $linked ) ? 'link' : 'thumb',
					'content' => $origHTML,
					//force the caption wrapper to exist if it's a linked image without caption
					'caption' => ( $linked && empty( $caption ) ) ? '' :  $caption,
					'showRibbon' => ( is_object( $thumb ) ) ?
						WikiaMobileMediaService::showRibbon( $thumb->getWidth(), $thumb->getHeight() ) :
						false
				),
				true
			)->toString();
		} elseif ( self::$isOasis ) {
			/**
			 * Change img src from magnify-clip.png to blank.gif. Image is set via CSS Background
			 * @author: Christian, Marooned
			 */
			$zoomIcon =  Html::rawElement(
				'a',
				array(
					'href' => $url,
					'class' => "internal sprite details magnify",
					'title' => $this->wf->Msg( 'thumbnail-more' )
				),
				''
			);

			$html = $this->getTag(
				$origHTML,
				$frameParams['align'],
				$outerWidth,
				( !empty( $frameParams['caption'] ) || self::$isOasis ),
				$frameParams['caption'],
				$zoomIcon,
				(
					self::$isOasis &&
						!empty( $this->wg->EnableOasisPictureAttribution ) &&
						!empty( $file ) &&
						//BugId: 3734 Remove picture attribution for thumbnails 99px wide and under
						$outerWidth >= 102
				),
				( !empty( $file ) ) ? $file->getUser() : null
			);
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	public function onImageAfterProduceHTML( $title, $file, $frameParams, $handlerParams, $thumb, $params, $time, $origHTML, &$html ){
		/**
		 * WikiaMobile - non-framed non-thumb images should have the same markup as thumbed/framed images/thumbnails
		 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
		 */
		if ( self::$isWikiaMobile ) {
			$this->wf->profileIn( __METHOD__ );

			$linked = !empty( $frameParams['link-url'] ) || !empty( $frameParams['link-title'] );
			$caption = ( !empty( $frameParams['caption'] ) ) ? $frameParams['caption'] : null;

			$html = $this->app->sendRequest(
				'WikiaMobileMediaService',
				'renderFigureTag',
				array(
					'class' => ( $linked ) ? 'link' : 'thumb',
					'content' => $origHTML,
					//force the caption wrapper to exist if it's a linked image without caption
					'caption' => ( $linked && empty( $caption ) ) ? '' : $caption,
					'showRibbon' => ( is_object( $thumb ) ) ?
						WikiaMobileMediaService::showRibbon( $thumb->getWidth(), $thumb->getHeight() ) :
						false
				),
				true
			)->toString();

			$this->wf->profileOut( __METHOD__ );
		}

		return true;
	}

	public function onThumbnailImageHTML( $options, $linkAttribs, $imageAttribs, File $file, &$html ){
		$this->wf->profileIn( __METHOD__ );


		if (
			/**
			* Images SEO project
			* @author: Marooned
			*/
			(
				empty( $options['custom-url-link'] ) &&
				empty( $options['custom-title-link'] ) &&
				!empty( $options['desc-link'] ) &&
				self::$isOasis
			) ||
			/**
			 * in the WikiaMobile skin we need all the images to be treated the same
			 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
			 */
			self::$isWikiaMobile
		) {
			$fullImageUrl = false;
			$link = null;

			if ( is_array( $linkAttribs ) ) {
				if ( !empty( $file ) ) {
					$title = $file->getTitle();

					if ( $title instanceof Title ) {
						$linkAttribs['data-image-name'] = $title->getText();
					}

					$linkAttribs['href'] = $this->wf->ReplaceImageServer( $file->getUrl(), $file->getTimestamp() );
					$fullImageUrl = $linkAttribs['href'];
				}

				if ( !empty ( $options['custom-url-link'] ) ) {
					$link = $options['custom-url-link'];
				} elseif (
					!empty( $options['custom-title-link'] ) &&
					$options['custom-title-link'] instanceof Title
				) {
					$title = $options['custom-title-link'];
					$linkAttribs['title'] = $title->getFullText();
					$link = $title->getLinkUrl();
				} elseif ( !empty( $options['file-link'] ) && empty( $options['desc-link'] ) ) {
					$linkAttribs['href'] = $this->wf->ReplaceImageServer( $file->getUrl(), $file->getTimestamp() );
				}

				//override any previous value if title is passed as an option
				if ( !empty( $options['title'] ) ) {
					$linkAttribs['title'] = $options['title'];
				}
			}

			//remove the empty alt attribute which we print pretty everywhere (meh)
			if ( empty( $imageAttribs['alt'] ) ) {
				unset( $imageAttribs['alt'] );
			}

			$contents = Xml::element( 'img', $imageAttribs );

			if ( self::$isWikiaMobile ) {
				$imageParams = array();

				if ( !empty( $link ) ) {
					$linkAttribs['href'] = $link;
				}

				if ( empty( $linkAttribs['class'] ) ) {
					$linkAttribs['class'] = 'image';
				}

				if ( !empty( $linkAttribs['data-image-name'] ) ) {
					$imageParams['name'] = $linkAttribs['data-image-name'];
				}

				if ( !empty( $fullImageUrl ) ) {
					$imageParams['full'] = $fullImageUrl;
				} else {
					$imageParams['full'] = $imageAttribs['src'];
				}

				if ( !empty( $options['caption'] ) ) {
					$imageParams['capt'] = true;
				}

				//images set to be less than 64px are probably
				//being used as icons in templates
				//do not resize them
				if (
					( (!empty( $imageAttribs['width'] ) && $imageAttribs['width'] > 64 ) || empty( $imageAttribs['width'] ) )
					&& $file instanceof File
				) {
					$size = WikiaMobileMediaService::calculateMediaSize( $file->getWidth(), $file->getHeight() );
					$thumb = $file->transform( $size );
					$imageAttribs['src'] = wfReplaceImageServer( $thumb->getUrl(), $file->getTimestamp() );
					$imageAttribs['width'] = $size['width'];
					$imageAttribs['height'] = $size['height'];
				}

				/**
				 *WikiaMobile: lazy loading images in a SEO-friendly manner
				 *@author Federico "Lox" Lucignano <federico@wikia-inc.com
				 */
				$html = $this->app->sendRequest(
					'WikiaMobileMediaService',
					'renderImageTag',
					array(
						'attributes' => $imageAttribs,
						'parameters' => array( $imageParams ),
						'anchorAttributes' => $linkAttribs,
						'linked' => !empty( $link ),
						'noscript' => $contents
					),
					true
				)->toString();
			} else {
				$html = ( $linkAttribs ) ? Xml::tags( 'a', $linkAttribs, $contents ) : $contents;
			}
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	public function onThumbnailVideoHTML( $options, $linkAttribs, $imageAttribs, File $file, &$html ){
		$this->wf->profileIn( __METHOD__ );

		if ( self::$isWikiaMobile ) {
			/**
			 * WikiaMobile: lazy loading images in a SEO-friendly manner
			 * @author Federico "Lox" Lucignano <federico@wikia-inc.com
			 * @author Artur Klajnerok <arturk@wikia-inc.com>
			 */
			$origImg = Xml::element( 'img', $imageAttribs, '', true );

			if ( empty( $imageAttribs['alt'] ) ) {
				unset( $imageAttribs['alt'] );
			}

			$imageParams = array(
				'type' => 'video',
				'full' => $imageAttribs['src']
			);

			if ( !empty($linkAttribs['data-video-name'] ) ) {
				$imageParams['name'] = $linkAttribs['data-video-name'];
			}

			if ( !empty( $options['caption'] ) ) {
				$imageParams['capt'] = true;
			}

			if ( $file instanceof File ) {
				$size = WikiaMobileMediaService::calculateMediaSize( $file->getWidth(), $file->getHeight() );
				$thumb = $file->transform( $size );
				$imageAttribs['src'] = wfReplaceImageServer( $thumb->getUrl(), $file->getTimestamp() );
				$imageAttribs['width'] = $size['width'];
				$imageAttribs['height'] = $size['height'];
			}

			$data = array(
				'attributes' => $imageAttribs,
				'parameters' => array( $imageParams ),
				'anchorAttributes' => $linkAttribs,
				'noscript' => $origImg
			);

			if ( $file instanceof File ) {
				$title = $file->getTitle()->getDBKey();
				$titleText = $file->getTitle()->getText();

				$data['content'] = Xml::element(
					'span',
					array( 'class' => 'videoInfo' ),
					"{$titleText} (" . $file->getHandler()->getFormattedDuration() .
						", " . $this->wf->MsgForContent( 'wikiamobile-video-views-counter', DataMartService::getVideoViewsByTitleTotal( $title ) ) .
						')'
				);
			}

			$html = $this->app->sendRequest(
				'WikiaMobileMediaService',
				'renderImageTag',
				$data,
				true
			)->toString();
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	private function getTag( $imageHTML, $align, $width, $showCaption = false, $caption = '',  $zoomIcon = '', $showPictureAttribution = false, $attributeTo = null ){
		/**
		 * Images SEO
		 * @author: Marooned, Federico
		 */
		$this->wf->profileIn( __METHOD__ );

		$html = "<figure class=\"thumb" .
			( ( !empty( $align ) ) ? " t{$align}" : '' ) .
			" thumbinner\" style=\"width:{$width}px;\">{$imageHTML}{$zoomIcon}";

		if ( !empty( $showCaption ) ) {
			$html .= "<figcaption class=\"thumbcaption\">{$caption}";
		}

		//picture attribution
		if ( !empty( $showPictureAttribution ) && !empty( $attributeTo ) ) {
			$this->wf->profileIn( __METHOD__ . '::PictureAttribution' );

			// render avatar and link to user page
			$avatar = AvatarService::renderAvatar( $attributeTo, 16 );
			$link = AvatarService::renderLink( $attributeTo );

			$html .= Xml::openElement( 'div', array( 'class' => 'picture-attribution' ) ) .
				$avatar .
				$this->wf->MsgExt('oasis-content-picture-added-by', array( 'parsemag' ), $link, $attributeTo ) .
				Xml::closeElement( 'div' );

			$this->wf->profileOut( __METHOD__ . '::PictureAttribution' );
		}

		if ( !empty( $showCaption ) ) {
			$html .= '</figcaption>';
		}

		$html .= '</figure>';

		$this->wf->profileOut( __METHOD__ );
		return $html;
	}
}
