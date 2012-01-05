<?
/**
 * Media transform output for video thumbnails
 *
 * @ingroup Media
 */

class ThumbnailVideo extends ThumbnailImage {


	function ThumbnailVideo( $file, $url, $width, $height, $path = false, $page = false ){
		parent::__construct( $file, $url, $width, $height, $path, $page );
	}

	function toHtml( $options = array() ) {
		if ( count( func_get_args() ) == 2 ) {
			throw new MWException( __METHOD__ .' called in the old style' );
		}

		$alt = empty( $options['alt'] ) ? '' : $options['alt'];

		/**
		 * Note: if title is empty and alt is not, make the title empty, don't
		 * use alt; only use alt if title is not set
		 * wikia change, Inez
		 */
		$title = !isset( $options['title'] ) ? $alt : $options['title'];

		$query = empty( $options['desc-query'] )  ? '' : $options['desc-query'];

		if ( !empty( $options['custom-url-link'] ) ) {
			$linkAttribs = array( 'href' => $options['custom-url-link'] );
			if ( !empty( $options['title'] ) ) {
				$linkAttribs['title'] = $options['title'];
			}
		} elseif ( !empty( $options['custom-title-link'] ) ) {
			$title = $options['custom-title-link'];
			$linkAttribs = array(
				'href' => $title->getLinkUrl(),
				'title' => empty( $options['title'] ) ? $title->getFullText() : $options['title']
			);
		} elseif ( !empty( $options['desc-link'] ) ) {
			$linkAttribs = $this->getDescLinkAttribs( empty( $options['title'] ) ? null : $options['title'], $query );
			if (Wikia::isOasis() || Wikia::isWikiaMobile()) {
				$linkAttribs['data-image-name'] = $this->file->getTitle()->getText();
				$linkAttribs['href'] = $this->file->getFullUrl();
				if ( !empty( $options['id'] ) ) $linkAttribs['id'] = $options['id'];
			}
		} elseif ( !empty( $options['file-link'] ) ) {
			$linkAttribs = array( 'href' => wfReplaceImageServer( $this->file->getURL(), $this->file->getTimestamp() ) );
		} else {
			$linkAttribs = false;
		}

		$attribs = array(
			'alt' => $alt,
			'src' => $this->url,
			'width' => $this->width,
			'height' => $this->height,
			'data-video' => $this->file->getTitle()->getText()
		);
		if ( !empty( $options['valign'] ) ) {
			$attribs['style'] = "vertical-align: {$options['valign']}";
		}
		if ( !empty( $options['img-class'] ) ) {
			$attribs['class'] = $options['img-class'];
		}

		return $this->linkWrap( $linkAttribs, Xml::element( 'img', $attribs ) );
	}
}

?>