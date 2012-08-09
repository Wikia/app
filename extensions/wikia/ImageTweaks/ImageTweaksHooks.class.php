<?php

class ImageTweaksHooks extends WikiaObject {
	const WIKIAMOBILE_IMAGE_CLASSES = 'imgPlcHld lazy';

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
		/**
		 * Images SEO
		 * @author: Marooned, Federico
		 */
		if ( self::$isOasis || self::$isWikiaMobile ) {
			$this->wf->profileIn( __METHOD__ );
			$exists = ( $file && $file->exists() );
			$showCaption = ( !empty( $frameParams['caption'] ) || self::$isOasis );

			if( !self::$isWikiaMobile ) {
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
			}

			$html = $this->getTag(
				$origHTML,
				$frameParams['align'],
				$outerWidth,
				$showCaption,
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

			$this->wf->profileOut( __METHOD__ );
		}

		return true;
	}

	public function onImageAfterProduceHTML( $title, $file, $frameParams, $handlerParams, $thumb, $params, $time, $origHTML, &$html ){
		/**
		 * WikiaMobile - non-framed non-thumb images should have the same markup as thumbed/framed images/thumbnails
		 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
		 */
		if ( self::$isWikiaMobile ) {
			$this->wf->profileIn( __METHOD__ );


			$showCaption = !empty( $frameParams['caption'] );
			$html = $this->getTag(
				$origHTML,
				$frameParams['align'],
				$handlerParams['width'],
				!empty( $frameParams['caption'] ),
				$frameParams['caption']
			);

			$this->wf->profileOut( __METHOD__ );
		}

		return true;
	}

	public function onThumbnailImageHTML( $options, $linkAttribs, $imageAttribs, $file, &$html ){
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
			$link = null;

			if ( is_array( $linkAttribs ) ) {
				if ( !empty( $file ) ) {
					$title = $file->getTitle();

					if ( $title instanceof Title ) {
						$linkAttribs['data-image-name'] = $title->getText();
					}

					$linkAttribs['href'] = $this->wf->ReplaceImageServer($file->getFullUrl());
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
					$linkAttribs['href'] = $this->wf->ReplaceImageServer( $file->getURL(), $file->getTimestamp() );
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
				if ( !empty( $link ) ) {
					$linkAttribs['href'] = $link;
				}

				if ( empty( $linkAttribs['class'] ) ) {
					$linkAttribs['class'] = 'image';
				}

				/**
				 *WikiaMobile: lazy loading images in a SEO-friendly manner
				 *@author Federico "Lox" Lucignano <federico@wikia-inc.com
				 *
				 */
				$lazyImageAttribs = $imageAttribs;
				$lazyImageAttribs['data-src'] = $lazyImageAttribs['src'];
				$lazyImageAttribs['src'] = $this->wg->BlankImgUrl;
				$lazyImageAttribs['class'] = ( ( !empty( $lazyImageAttribs['class'] ) ) ? "{$lazyImageAttribs['class']} " : '' ) . self::WIKIAMOBILE_IMAGE_CLASSES;

				$contents = Xml::element( 'img', $lazyImageAttribs ) . "<noscript>{$contents}</noscript>";
			}

			$html = ( $linkAttribs ) ? Xml::tags( 'a', $linkAttribs, $contents ) : $contents;
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	public function onThumbnailVideoHTML( $options, $linkAttribs, $imageAttribs, $file, &$html ){
		$this->wf->profileIn( __METHOD__ );

		if ( self::$isWikiaMobile ) {
			/**
			 *WikiaMobile: lazy loading images in a SEO-friendly manner
			 *@author Federico "Lox" Lucignano <federico@wikia-inc.com
			 */
			$origImg = Xml::element( 'img', $imageAttribs, '', true );
			$lazyImageAttribs = $imageAttribs;
			$lazyImageAttribs['data-src'] = $lazyImageAttribs['src'];
			$lazyImageAttribs['src'] = $this->wf->BlankImgUrl();
			$lazyImageAttribs['class'] = ( ( !empty( $lazyImageAttribs['class'] ) ) ? "{$lazyImageAttribs['class']} " : '' ) . self::WIKIAMOBILE_IMAGE_CLASSES;

			$html = str_replace( $origImg, Xml::element( 'img', $lazyImageAttribs ) . "<noscript>{$origImg}</noscript>", $html );
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	private function getTag( $imageHTML, $align, $width, $showCaption = false, $caption = '',  $zoomIcon = '', $showPictureAttribution = false, $attributeTo = null ){
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