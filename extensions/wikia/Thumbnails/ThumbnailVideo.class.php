<?
/**
 * Media transform output for video thumbnails
 *
 * @ingroup Media
 */

use \Wikia\Logger\WikiaLogger;

class ThumbnailVideo extends ThumbnailImage {

	function getFile( ) {
		return $this->file;
	}

	function getUrl( ) {
		return $this->url;
	}

	function getPath( ) {
		return $this->path;
	}

	function getPage( ) {
		return $this->page;
	}

	function getWidth( ) {
		return $this->width;
	}

	function getHeight( ) {
		return $this->height;
	}

	/*
	 * Render video thumbnail as image thumbnail
	 */
	function renderAsThumbnailImage( $options ) {

		$thumb = new ThumbnailImage(
				$this->getFile(),
				$this->getUrl(),
				$this->getWidth(),
				$this->getHeight(),
				$this->getPath(),
				$this->getPage()
		);

		// make sure to replace 'image' css class whith 'video' css class
		// in order to make thumbnail be handled correctly by RTE
		if ( isset( $options['img-class'] ) ) {

			$imgClasses = explode( ' ', $options['img-class'] );
			$changeIndex = array_search( 'image', $imgClasses );

			if ( $changeIndex !== false ) {
				$imgClasses[$changeIndex] = "video";
			} else {
				$imgClasses[] = "video";
			}

			$options['img-class'] = implode( ' ', $imgClasses );
		} else {

			$options['img-class'] = "video";
		}
		return $thumb->toHtml( array( 'img-class' => $options['img-class'] ) );
	}

	function mediaType() {
		return 'video';
	}

	/**
	 * @param array $options
	 * @return mixed|string
	 * @throws MWException
	 */
	function toHtml( $options = array() ) {
		$app = F::app();

		if ( count( func_get_args() ) == 2 ) {
			throw new MWException( __METHOD__ .' called in the old style' );
		}

		// Check if the editor is requesting, if so, render image thumbnail instead
		if ( !empty( $app->wg->RTEParserEnabled ) ) {
			return $this->renderAsThumbnailImage( $options );
		}

		wfProfileIn( __METHOD__ );

		// All non-WikiaMobile skins use Nirvana to render HTML now. WikiaMobile is slowly migrating with 'useTemplate'
		if ( !F::app()->checkSkin( 'wikiamobile' ) || !empty( $options['useTemplate'] ) ) {
			$html = $this->renderView( $options );

			wfProfileOut( __METHOD__ );

			return $html;
		}

		// Only WikiaMobile beyond this point

		WikiaLogger::instance()->debug('Media method '.__METHOD__.' called',
			array_merge( $options, [
				'url'       => $this->url,
				'method'    => __METHOD__,
				'page_int'  => (int) $this->page, # int|false $page Page number, for multi-page files
				'mediaType' => $this->mediaType(),
				'fileType'  => get_class( $this->file )
			] ) );

		$alt = empty( $options['alt'] ) ? '' : $options['alt'];
		$videoTitle = $this->file->getTitle();
		$useRDFData = ( !empty( $options['disableRDF'] ) && $options['disableRDF'] == true ) ? false : true;
		$linkAttribs = array(
			'href' => $videoTitle->getLocalURL(),
		);

		if ( !empty( $options['id'] ) ) {
			$linkAttribs['id'] = $options['id'];
		}

		if ( $useRDFData ) { // bugId: #46621
			$linkAttribs['itemprop'] = 'video';
			$linkAttribs['itemscope'] = '';
			$linkAttribs['itemtype'] = 'http://schema.org/VideoObject';
		}

		// let extension override any link attributes
		if ( isset( $options['linkAttribs'] ) && is_array( $options['linkAttribs'] ) ) {
			$linkAttribs = array_merge( $linkAttribs, $options['linkAttribs'] );
		}

		$extraClasses = 'video';
		if ( empty( $options['noLightbox'] ) ) {
			$extraClasses .= ' image lightbox';
		}
		$linkAttribs['class'] = empty( $linkAttribs['class'] ) ? $extraClasses : $linkAttribs['class'] . ' ' . $extraClasses;

		if ( !empty( $options['fixedHeight'] ) ) {
			$this->height = $options['fixedHeight'];
		}

		$attribs = array(
			'alt' => $alt,
			'src' => empty( $options['src'] ) ? $this->url : $options['src'] ,
			'width' => $this->width,
			'height' => $this->height,
			'data-video-name' => htmlspecialchars( $videoTitle->getText() ),
			'data-video-key' => htmlspecialchars( urlencode( $videoTitle->getDBKey() ) ),
		);

		if ( $useRDFData ) {
			$attribs['itemprop'] = 'thumbnail';
		}

		// lazy loading
		if ( !empty( $options['usePreloading'] ) ) {
			$attribs['data-src'] = $this->url;
		}

		// this is used for video thumbnails on file page history tables to insure you see the older version of a file when thumbnail is clicked.
		if ( $this->file instanceof OldLocalFile ) {
			$archive_name = $this->file->getArchiveName();
			if ( !empty( $archive_name ) ) {
				$linkAttribs['href'] .= '?t='.$this->file->getTimestamp();
				$linkAttribs['data-timestamp'] = $this->file->getTimestamp();
			}
		}

		if ( !empty( $options['valign'] ) ) {
			$attribs['style'] = "vertical-align: {$options['valign']}";
		}
		$attribs['class'] = 'Wikia-video-thumb';
		if ( !empty( $options['img-class'] ) ) {
			$attribs['class'] .= ' ' . $options['img-class'];
		}

		if ( isset( $options['imgExtraStyle'] ) ) {
			if ( !isset( $attribs['style'] ) ) {
				$attribs['style'] = '';
			}
			$attribs['style'] .= $options['imgExtraStyle'];
		}

		if ( isset( $options['duration'] ) && $options['duration'] == true ) {
			$duration = WikiaFileHelper::formatDuration( $this->file->getMetadataDuration() );
		}

		if ( !empty( $duration ) ) {
			$timerProp = array( 'class'=>'timer' );
			if ( $useRDFData ) {
				$timerProp['itemprop'] = 'duration';
			}
		}

		// WikiaMobile completely reconstructs the html
		$html = '';

		//give extensions a chance to modify the markup
		Hooks::run( 'ThumbnailVideoHTML', array( $options, $linkAttribs, $attribs, $this->file,  &$html ) );

		wfProfileOut( __METHOD__ );

		return $html;
	}
}
