<?php

class ThumbnailController extends WikiaController {

	/**
	 * Thumbnail Template
	 * @requestParam File file
	 * @requestParam string url - img src
	 * @requestParam string width
	 * @requestParam string height
	 * @requestParam array options
	 *	Keys:
	 *		id - id for link,
	 *		linkAttribs - link attributes [ array( 'class' => 'video' ) ]
	 *		noLightbox - not show image or video in lightbox,
	 *		hidePlayButton - hide play button
	 *		src - source for image
	 *		imgClass - string of space separated classes for image
	 *		alt - alt for image
	 *		usePreloading - for lazy loading
	 *		valign - valign for image
	 *		imgExtraStyle - extra style for image
	 *		disableRDF - disable RDF metadata
	 *		fluid - image will take the width of it's container
	 *		forceSize - 'xsmall' | 'small' | 'medium' | 'large' | 'xlarge'
	 * @responseParam string width
	 * @responseParam string height
	 * @responseParam string linkHref
	 * @responseParam array linkClasses
	 * @responseParam array linkAttrs
	 *	Keys:
	 *		id - id attribute for link,
	 *		class - class of link attributes
	 *		data-timestamp - timestamp of the file
	 *		itemprop - for RDF metadata
	 *		itemscope - for RDF metadata
	 *		itemtype - for RDF metadata
	 * @responseParam string size [ xsmall, small, medium, large, xlarge ]
	 * @responseParam string imgSrc
	 * @responseParam string videoKey
	 * @responseParam string videoName
	 * @responseParam array imgClass
	 * @responseParam array imgAttrs
	 *	Keys:
	 *		alt - alt for image
	 *		style - style for image
	 *		itemprop - for RDF metadata
	 * @responseParam string dataSrc - data-src attribute for image lazy loading
	 * @responseParam string duration (HH:MM:SS)
	 * @responseParam array durationAttrs
	 *	Keys:
	 *		itemprop - for RDF metadata
	 * @responseParam array metaAttrs - for RDF metadata [ array( array( 'itemprop' => '', 'content' => '' ) ) ]
	 */
	public function video() {
		wfProfileIn( __METHOD__ );

		$file = $this->getVal( 'file' );
		$imgSrc = $this->getVal( 'url', '' );
		$width = $this->getVal( 'width', 0 );
		$height = $this->getVal( 'height', 0 );
		$options = $this->getVal( 'options', array() );

		// use mustache for template
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->response->getView()->setTemplatePath( dirname(__FILE__) . '/templates/mustache/thumbnailVideo.mustache' );

		// default value
		$linkAttribs = [];

		// get id for a tag
		if ( !empty( $options['id'] ) ) {
			$linkAttribs['id'] = $options['id'];
		}

		// let extension override any link attributes
		if ( isset( $options['linkAttribs'] ) && is_array( $options['linkAttribs'] ) ) {
			$linkAttribs = array_merge( $linkAttribs, $options['linkAttribs'] );
		}

		// get class for a tag
		$linkClasses = ['video'];
		if ( empty( $options['noLightbox'] ) ) {
			$linkClasses[] = 'image';
			$linkClasses[] = 'lightbox';
		}

		if ( !empty( $linkAttribs['class'] ) ) {
			if ( !is_array( $linkAttribs['class'] ) ) {
				$linkAttribs['class'] = explode( ' ', $linkAttribs['class'] );
			}

			$linkClasses = array_merge( $linkClasses, $linkAttribs['class'] );
			unset( $linkAttribs['class'] );
		}

		// hide play button
		if ( !empty( $options['hidePlayButton'] ) ) {
			$linkClasses[] = 'hide-play';
		}

		/** @var Title $title */
		$title = $file->getTitle();

		// get href for a tag
		$linkHref = $title->getFullURL();

		// this is used for video thumbnails on file page history tables to insure you see the older version of a file when thumbnail is clicked.
		if ( $file instanceof OldLocalFile ) {
			$archive_name = $file->getArchiveName();
			if ( !empty( $archive_name ) ) {
				$linkHref .= '?t='.$file->getTimestamp();
				$linkAttribs['data-timestamp'] = $file->getTimestamp();
			}
		}

		// update src for img tag
		if ( !empty( $options['src'] ) ) {
			$imgSrc = $options['src'];
		}

		// get alt for img tag
		$imgAttribs['alt'] = empty( $options['alt'] ) ? '' : $options['alt'];

		// set valign for img tag
		$imgAttribs['style'] = '';
		if ( !empty( $options['valign'] ) ) {
			$imgAttribs['style'] .= "vertical-align: {$options['valign']}";
		}

		// get extra style for img tag
		if ( !empty( $options['imgExtraStyle'] ) ) {
			$imgAttribs['style'] .= $options['imgExtraStyle'];
		}

		// remove style from $imgAttribs if it is empty
		if ( $imgAttribs['style'] == '' ) {
			unset( $imgAttribs['style'] );
		}

		// set data-params for img tag
		if ( !empty( $options['dataParams'] ) ) {
			$imgAttribs['data-params'] = ThumbnailHelper::getDataParams( $file, $imgSrc, $options );
		}

		// set duration
		$duration = $file->getMetadataDuration();
		$durationAttribs = [];

		$metaAttribs = [];

		// disable RDF metadata in video thumbnails
		if ( empty( $options['disableRDF'] ) ) { // bugId: #46621
			// link
			$linkAttribs['itemprop'] = 'video';
			$linkAttribs['itemscope'] = '';
			$linkAttribs['itemtype'] = 'http://schema.org/VideoObject';

			// image
			$imgAttribs['itemprop'] = 'thumbnail';

			//duration
			if ( !empty( $duration ) ) {
				$durationAttribs['itemprop'] = 'duration';
				$metaAttribs[] = [
					'itemprop' => 'duration',
					'content' => WikiaFileHelper::formatDurationISO8601( $duration ),
				];
			}
		}

		// data-src attribute in case of lazy loading
		if ( !empty( $options['usePreloading'] ) ) {
			$this->dataSrc = $imgSrc;
		}

		// check fluid
		if ( empty( $options[ 'fluid' ] ) ) {
			$this->imgWidth = $width;
			$this->imgHeight = $height;
		} else {
			$linkClasses[] = 'fluid';
		}

		// set link attributes
		$this->linkHref = $linkHref;
		$this->linkClasses = array_unique( $linkClasses );
		$this->linkAttrs = ThumbnailHelper::getAttribs( $linkAttribs );

		if ( !empty( $options['forceSize'] ) ) {
			$this->size = $options['forceSize'];
		} else {
			$this->size = WikiaFileHelper::getThumbnailSize( $width );
		}

		// set image attributes
		$this->imgSrc = $imgSrc;
		$this->videoKey = htmlspecialchars( $title->getDBKey() );
		$this->videoName = htmlspecialchars( $title->getText() );
		$this->imgClass = empty( $options['imgClass'] ) ? '' : $options['imgClass'];
		$this->imgAttrs = ThumbnailHelper::getAttribs( $imgAttribs );

		// set duration
		$this->duration = WikiaFileHelper::formatDuration( $duration );
		$this->durationAttrs = ThumbnailHelper::getAttribs( $durationAttribs );

		// set meta
		$this->metaAttrs = $metaAttribs;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @todo Implement image controller
	 */
	public function image() {}

	/**
	 * Article figure tags with thumbnails inside
	 */
	public function articleThumbnail() {
		wfProfileIn( __METHOD__ );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->response->getView()->setTemplatePath( dirname(__FILE__) . '/templates/mustache/atricleThumbnail.mustache' );

		$file = $this->getVal( 'file' );
		$width = $this->getVal( 'outerWidth' );
		$url = $this->getVal( 'url' );
		$align = $this->getVal( 'align' );
		$thumbnail = $this->getVal( 'html' );
		$caption = $this->getVal( 'caption' );

		// align classes are prefixed by "t"
		$alignClass = "t" . $align;

		// only show titles for videos
		$title = '';
		if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {
			$title = $file->getTitle()->getText();
		}

		$addedBy = '';
		$attributeTo = $file->getUser();
		$showPictureAttribution = (
			$this->app->checkSkin( 'oasis' ) &&
			!empty( $this->wg->EnableOasisPictureAttribution ) &&
			// Remove picture attribution for thumbnails less than 100px
			$width > 99
		);

		if ( !empty( $showPictureAttribution ) && !empty( $attributeTo ) ) {
			// get link to user page
			$link = AvatarService::renderLink( $attributeTo );

			// TODO: change this to "By $user $time days ago"
			$addedBy = wfMessage('oasis-content-picture-added-by', $link, $attributeTo )->inContentLanguage()->text();
		}

		$this->thumbnail = $thumbnail;
		$this->title = $title;
		$this->figureClass = $alignClass;
		$this->url = $url;
		$this->thumbnailMore = wfMessage( 'thumbnail-more' )->escaped();
		$this->caption = $caption;
		$this->addedBy = $addedBy;
		$this->width = $width;

		wfProfileOut( __METHOD__ );
	}

}
