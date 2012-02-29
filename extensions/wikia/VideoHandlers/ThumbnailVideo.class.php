<?
/**
 * Media transform output for video thumbnails
 *
 * @ingroup Media
 */

class ThumbnailVideo extends ThumbnailImage {


	function ThumbnailVideo( $file, $url, $width, $height, $path = false, $page = false ){
		
		$this->file = $file;

		/*
		 * Do some math to recalculate valid position for cropped thumbnails
		 */
		$iCroppedAspectRatio = $width / $height;
		$H = (float)$file->getWidth() / $iCroppedAspectRatio;
		$hDelta = ( ( $file->getHeight() - $H ) / 2 );

		$oImageServing = new ImageServing( null, $width, $height );
		if ( $height < $file->getHeight() ) {

			$oImageServing->setDeltaY(
				$hDelta / $file->getHeight()
			);
		}

		/*
		 * Get thumbnail url
		 */
		$this->url = $oImageServing->getUrl( $file, $file->getWidth(), $file->getHeight() );

		# These should be integers when they get here.
		# If not, there's a bug somewhere.  But let's at
		# least produce valid HTML code regardless.
		$this->width = round( $width );
		$this->height = round( $height );
		$this->path = $path;
		$this->page = $page;
	}

	function getFile() {
		return $this->file;
	}
	
	function getUrl() {
		return $this->url;
	}
	
	function getPath() {
		return $this->path;
	}
	
	function getPage() {
		return $this->page;
	}
	
	function getWidth() {
		return $this->width;
	}
	
	function getHeight() {
		return $this->height;
	}
	
	function toHtml( $options = array() ) {
		if ( count( func_get_args() ) == 2 ) {
			throw new MWException( __METHOD__ .' called in the old style' );
		}
		
		$alt = empty( $options['alt'] ) ? '' : $options['alt'];

		$useThmbnailInfoBar = false;
		
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
				$linkAttribs['data-video-name'] = $this->file->getTitle()->getText();
				$linkAttribs['href'] = $this->file->getTitle()->getLocalURL();
				if ( !empty( $options['id'] ) ){
					$linkAttribs['id'] = $options['id'];
				}
			}
		} elseif ( !empty( $options['file-link'] ) ) {
			$linkAttribs = array( 'href' => $this->file->getTitle()->getLocalURL() );
		} else {
			$linkAttribs = false;
		}
		
		$linkAttribs['style'] = "display:inline-block;";
		
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
		$attribs['class'] = 'Wikia-video-thumb';
		if ( !empty( $options['img-class'] ) ) {
			$attribs['class'] .= ' ' . $options['img-class'];
		}

		
		$html = Xml::openElement( 'a', $linkAttribs );
			$html .= WikiaVideoService::videoPlayButtonOverlay( $this->width, $this->height );
			$html .= Xml::element( 'img', $attribs, '', true );
		$html .= Xml::closeElement( 'a' ); 
		
		if ( $useThmbnailInfoBar ) {

			$titleBar = array(
				"class"		=> "Wikia-video-title-bar",
				"style"		=> "width: {$this->width}px; margin-left: -{$this->width}px;"
			);
			
			$videoTitle = $attribs['data-video'];
			
			$infoVars = array();
			$userName = $this->file->getUser();
			if (!is_null($userName)) {
				$link = AvatarService::renderLink($userName);
				$infoVars["author"] = wfMsgExt('oasis-content-picture-added-by', array( 'parsemag' ), $link, $userName );
			} else {
				$infoVars["author"] = "";
			}

			$duration = $this->file->getHandler()->getFormattedDuration();
			if (!empty($duration)) {
				$infoVars["duration"] = '('.$duration.')';
			} else {
				$infoVars["duration"] = '';
			}

			if ( !isset($options['img-class']) ) {
				$options['img-class'] = "";
			}

			if ( $options['img-class'] != "thumbimage" ) {
				$html .= Xml::openElement( 'span', $titleBar );
					$html .= Xml::element( 'span', array('class'=>'title'), $videoTitle );
					$html .= Xml::element( 'span', array('class'=>'info'),  '{author} {duration}' );
				$html .= Xml::closeElement( 'span' );
			}

			foreach ( $infoVars as $key => $value ) {
				$html = str_replace('{'.$key.'}', $value, $html);
			}

		}
		
		//	$html .= F::build('JSSnippets')->addToStack(
		//		array('/extensions/wikia/VideoHandlers/js/VideoHandlers.js')
		//	);
    
		return $html;
	}
}

?>