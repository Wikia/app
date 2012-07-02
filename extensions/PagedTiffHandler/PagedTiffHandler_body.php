<?php
/**
 * Copyright © Wikimedia Deutschland, 2009
 * Authors Hallo Welt! Medienwerkstatt GmbH
 * Authors Sebastian Ulbricht, Daniel Lynge, Marc Reymann, Markus Glaser
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

class PagedTiffHandler extends ImageHandler {
	function isEnabled() {
		return true;
	}

	function mustRender( $img ) {
		return true;
	}

	/**
	 * Does the file format support multi-page documents?
	 */
	function isMultiPage( $img ) {
		return true;
	}

	/**
	 * Various checks against the uploaded file
	 * - maximum upload size
	 * - maximum number of embedded files
	 * - maximum size of metadata
	 * - identify-errors
	 * - identify-warnings
	 * - check for running-identify-service
	 */
	function verifyUpload( $fileName ) {
		global $wgTiffUseTiffReader, $wgTiffReaderCheckEofForJS;

		$status = Status::newGood();
		if ( $wgTiffUseTiffReader ) {
			$tr = new TiffReader( $fileName );
			$tr->check();
			if ( !$tr->isValidTiff() ) {
				wfDebug( __METHOD__ . ": bad file\n" );
				$status->fatal( 'tiff_bad_file' );
			} else {
				if ( $tr->checkScriptAtEnd( $wgTiffReaderCheckEofForJS ) ) {
					wfDebug( __METHOD__ . ": script detected\n" );
					$status->fatal( 'tiff_script_detected' );
				}
				if ( !$tr->checkSize() ) {
					wfDebug( __METHOD__ . ": size error\n" );
					$status->fatal( 'tiff_size_error' );
				}
			}
		}
		$meta = self::getTiffImage( false, $fileName )->retrieveMetaData();
		if ( !$meta ) {
			wfDebug( __METHOD__ . ": unable to retreive metadata\n" );
			$status->fatal( 'tiff_out_of_service' );
		} else {
			$error = false;
			$ok = self::verifyMetaData( $meta, $error );

			if ( !$ok ) {
				call_user_func_array( array( $status, 'fatal' ), $error );
			}
		}

		return $status;
	}

	static function verifyMetaData( $meta, &$error ) {
		global $wgTiffMaxEmbedFiles, $wgTiffMaxMetaSize;

		$errors = PagedTiffHandler::getMetadataErrors( $meta );
		if ( $errors ) {
			$error = array( 'tiff_bad_file', PagedTiffHandler::joinMessages( $errors ) );

			wfDebug( __METHOD__ . ": {$error[0]} " . PagedTiffHandler::joinMessages( $errors, false ) . "\n" );
			return false;
		}

		if ( $meta['page_count'] <= 0 || empty( $meta['page_data'] ) ) {
			$error = array( 'tiff_page_error', $meta['page_count'] );
			wfDebug( __METHOD__ . ": {$error[0]}\n" );
			return false;
		}
		if ( $wgTiffMaxEmbedFiles && $meta['page_count'] > $wgTiffMaxEmbedFiles ) {
			$error = array( 'tiff_too_much_embed_files', $meta['page_count'], $wgTiffMaxEmbedFiles );
			wfDebug( __METHOD__ . ": {$error[0]}\n" );
			return false;
		}
		$len = strlen( serialize( $meta ) );
		if ( ( $len + 1 ) > $wgTiffMaxMetaSize ) {
			$error = array( 'tiff_too_much_meta', $len, $wgTiffMaxMetaSize );
			wfDebug( __METHOD__ . ": {$error[0]}\n" );
			return false;
		}

		wfDebug( __METHOD__ . ": metadata is ok\n" );
		return true;
	}

	/**
	 * Maps MagicWord-IDs to parameters.
	 * In this case, width, page, and lossy.
	 */
	function getParamMap() {
		return array(
			'img_width' => 'width',
			'img_page' => 'page',
			'img_lossy' => 'lossy',
		);
	}


	/**
	 * Checks whether parameters are valid and have valid values.
	 * Check for lossy was added.
	 */
	function validateParam( $name, $value ) {
		if ( in_array( $name, array( 'width', 'height', 'page', 'lossy' ) ) ) {
			if ( $name == 'lossy' ) {
				# NOTE: make sure to use === for comparison. in PHP, '' == 0 and 'foo' == 1.

				if ( $value === 1 || $value === 0 || $value === '1' || $value === '0' ) {
					return true;
				}

				if ( $value === 'true' || $value === 'false' || $value === 'lossy' || $value === 'lossless' ) {
					return true;
				}

				return false;
			} elseif ( $value <= 0 || $value > 65535 ) { // ImageMagick overflows for values > 65536
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	/**
	 * Creates parameter string for file name.
	 * Page number was added.
	 */
	function makeParamString( $params ) {
		if ( !isset( $params['width'] ) || !isset( $params['lossy'] ) || !isset( $params['page'] )) {
			return false;
		}

		return "{$params['lossy']}-page{$params['page']}-{$params['width']}px";
	}

	/**
	 * Parses parameter string into an array.
	 */
	function parseParamString( $str ) {
		$m = false;
		if ( preg_match( '/^(\w+)-page(\d+)-(\d+)px$/', $str, $m ) ) {
			return array( 'width' => $m[3], 'page' => $m[2], 'lossy' => $m[1] );
		} else {
			return false;
		}
	}

	/**
	* The function is used to specify which parameters to File::transform() should be
	* passed through to thumb.php, in the case where the configuration specifies
	* thumb.php is to be used (e.g. $wgThumbnailScriptPath !== false). You should
	* pass through the same parameters as in makeParamString().
	*/
	function getScriptParams( $params ) {
		return array(
			'width' => $params['width'],
			'page' => $params['page'],
			'lossy' => $params['lossy'],
		);
	}

	/**
	 * Prepares param array and sets standard values.
	 * Adds normalisation for parameter "lossy".
	 */
	function normaliseParams( $image, &$params ) {
		if ( !parent::normaliseParams( $image, $params ) ) {
			return false;
		}

		$data = $this->getMetaArray( $image );
		if ( !$data ) {
			return false;
		}

		if ( isset( $params['lossy'] ) ) {
			if ( in_array( $params['lossy'], array( 1, '1', 'true', 'lossy' ) ) ) {
				$params['lossy'] = 'lossy';
			} else {
				$params['lossy'] = 'lossless';
			}
		} else {
			$page = $this->adjustPage( $image, $params['page'] );

			if ( ( strtolower( $data['page_data'][$page]['alpha'] ) == 'true' ) ) {
				$params['lossy'] = 'lossless';
			} else {
				$params['lossy'] = 'lossy';
			}
		}

		return true;
	}

	static function getMetadataErrors( $metadata ) {
		if ( is_string( $metadata ) ) {
			$metadata = unserialize( $metadata );
		}

		if ( !$metadata ) {
			return true;
		} elseif ( isset( $metadata[ 'errors' ] ) ) {
			return $metadata[ 'errors' ];
		} else {
			return false;
		}
	}

	static function joinMessages( $errors_raw, $to_html = true ) {
		if ( is_array( $errors_raw ) ) {
			if ( !$errors_raw ) {
				return false;
			}

			$errors = array();
			foreach ( $errors_raw as $error ) {
				if ( $error === false || $error === null || $error === 0 || $error === '' )
					continue;

				$error = trim( $error );

				if ( $error === '' )
					continue;

				if ( $to_html )
					$error = htmlspecialchars( $error );

				$errors[] = $error;
			}

			if ( $to_html ) {
				return trim( join( '<br />', $errors ) );
			} else {
				return trim( join( ";\n", $errors ) );
			}
		}

		return $errors_raw;
	}

	/**
	 * Checks whether a thumbnail with the requested file type and resolution exists,
	 * creates it if necessary, unless self::TRANSFORM_LATER is set in $flags.
	 * Supports extra parameters for multipage files and thumbnail type (lossless vs. lossy)
	 */
	function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ) {
		global $wgImageMagickConvertCommand, $wgMaxImageAreaForVips,
			$wgTiffUseVips, $wgTiffVipsCommand, $wgMaxImageArea;

		$meta = $this->getMetaArray( $image );
		$errors = PagedTiffHandler::getMetadataErrors( $meta );

		if ( $errors ) {
			$errors = PagedTiffHandler::joinMessages( $errors );
			if ( is_string( $errors ) ) {
				// TODO: original error as param // TESTME
				return $this->doThumbError( $params, 'tiff_bad_file' );
			} else {
				return $this->doThumbError( $params, 'tiff_no_metadata' );
			}
		}

		if ( !$this->normaliseParams( $image, $params ) )
			return new TransformParameterError( $params );

		// Get params and force width, height and page to be integers
		$width = intval( $params['width'] );
		$height = intval( $params['height'] );
		$srcPath = $image->getPath();
		$page = intval( $params['page'] );
		$page = $this->adjustPage( $image, $page );

		if ( $flags & self::TRANSFORM_LATER ) {
			// pretend the thumbnail exists, let it be created by a 404-handler
			return new ThumbnailImage( $image, $dstUrl, $width, $height, $dstPath, $page );
		}

		if ( !self::verifyMetaData( $meta, $error, $dstPath ) ) {
			return $this->doThumbError( $params, $error );
		}

		if ( is_file( $dstPath ) ) {
			return new ThumbnailImage( $image, $dstUrl, $width,
				$height, $dstPath, $page );
		}

		if ( !wfMkdirParents( dirname( $dstPath ), null, __METHOD__ ) )
			return $this->doThumbError( $params, 'thumbnail_dest_directory' );

		if ( $wgTiffUseVips ) {
			$pagesize = PagedTiffImage::getPageSize($meta, $page);
			if ( !$pagesize ) {
				return $this->doThumbError( $params, 'tiff_no_metadata' );
			}
			if ( isset( $meta['page_data'][$page]['pixels'] )
					&& $meta['page_data'][$page]['pixels'] > $wgMaxImageAreaForVips )
				return $this->doThumbError( $params, 'tiff_sourcefile_too_large' );

			if ( ( $width * $height ) > $wgMaxImageAreaForVips )
				return $this->doThumbError( $params, 'tiff_targetfile_too_large' );

			// Shrink factors must be > 1.
			if ( ( $pagesize['width'] > $width ) && ( $pagesize['height'] > $height ) ) {
				$xfac = $pagesize['width'] / $width;
				$yfac = $pagesize['height'] / $height;
				$cmd = wfEscapeShellArg( $wgTiffVipsCommand );
				$cmd .= ' im_shrink ' . wfEscapeShellArg( $srcPath . ':' . ( $page - 1 ) ) . ' ';
				$cmd .= wfEscapeShellArg( $dstPath );
				$cmd .= " {$xfac} {$yfac} 2>&1";
			} else {
				$cmd = wfEscapeShellArg( $wgTiffVipsCommand );
				$cmd .= ' im_resize_linear ' . wfEscapeShellArg( $srcPath . ':' . 
					( $page - 1 ) ) . ' ';
				$cmd .= wfEscapeShellArg( $dstPath );
				$cmd .= " {$width} {$height} 2>&1";
			}
		} else {
			if ( ( $width * $height ) > $wgMaxImageArea )
				return $this->doThumbError( $params, 'tiff_targetfile_too_large' );
			if ( isset( $meta['page_data'][$page]['pixels'] )
					&& $meta['page_data'][$page]['pixels'] > $wgMaxImageArea )
				return $this->doThumbError( $params, 'tiff_sourcefile_too_large' );
			$cmd = wfEscapeShellArg( $wgImageMagickConvertCommand );
			$cmd .= " " . wfEscapeShellArg( $srcPath . "[" . ( $page - 1 ) . "]" );
			$cmd .= " -depth 8 -resize {$width} ";
			$cmd .= wfEscapeShellArg( $dstPath );
		}

		wfRunHooks( 'PagedTiffHandlerRenderCommand', array( &$cmd, $srcPath, $dstPath, $page, $width, $height ) );

		wfProfileIn( 'PagedTiffHandler' );
		wfDebug( __METHOD__ . ": $cmd\n" );
		$retval = null;
		$err = wfShellExec( $cmd, $retval );
		wfProfileOut( 'PagedTiffHandler' );

		$removed = $this->removeBadFile( $dstPath, $retval );

		if ( $retval != 0 || $removed ) {
			wfDebugLog( 'thumbnail', "thumbnail failed on " . wfHostname() .
				"; error $retval \"$err\" from \"$cmd\"" );
			return new MediaTransformError( 'thumbnail_error', $width, $height, $err );
		} else {
			return new ThumbnailImage( $image, $dstUrl, $width, $height, $dstPath, $page );
		}
	}

	/**
	 * Get the thumbnail extension and MIME type for a given source MIME type
	 * @return array thumbnail extension and MIME type
	 */
	function getThumbType( $ext, $mime, $params=null ) {
		// Make sure the file is actually a tiff image
		$tiffImageThumbType = parent::getThumbType( $ext, $mime, $params );
		if ( $tiffImageThumbType[1] !== 'image/tiff' ) {
			// We have some other file pretending to be a tiff image.
			return $tiffImageThumbType;
		}

		if ( $params[ 'lossy' ] == 'lossy' ) {
			return array( 'jpg', 'image/jpeg' );
		} else {
			return array( 'png', 'image/png' );
		}
	}

	/**
	 * Returns the number of available pages/embedded files
	 */
	function pageCount( $image ) {
		$data = $this->getMetaArray( $image );
		if ( !$data ) {
			return false;
		}
		return intval( $data['page_count'] );
	}

	/**
	 * Returns the number of the first page in the file
	 */
	function firstPage( $image ) {
		$data = $this->getMetaArray( $image );
		if ( !$data ) {
			return false;
		}
		return intval( $data['first_page'] );
	}

	/**
	 * Returns the number of the last page in the file
	 */
	function lastPage( $image ) {
		$data = $this->getMetaArray( $image );
		if ( !$data ) {
			return false;
		}
		return intval( $data['last_page'] );
	}

	/**
	 * Returns a page number within range.
	 */
	function adjustPage( $image, $page ) {
		$page = intval( $page );

		if ( !$page || $page < $this->firstPage( $image ) ) {
			$page = $this->firstPage( $image );
		}

		if ( $page > $this->lastPage( $image ) ) {
			$page = $this->lastPage( $image );
		}

		return $page;
	}

	/**
	 * Returns a new error message.
	 */
	protected function doThumbError( $params, $msg ) {
		global $wgUser, $wgThumbLimits;

		if ( empty( $params['width'] ) ) {
			// no usable width/height in the parameter array
			// only happens if we don't have image meta-data, and no
			// size was specified by the user.
			// we need to pick *some* size, and the preferred
			// thumbnail size seems sane.
			$sz = $wgUser->getOption( 'thumbsize' );
			$width = $wgThumbLimits[ $sz ];
			$height = $width; // we don't have a height or aspect ratio. make it square.
		} else {
			$width = intval( $params['width'] );

			if ( !empty( $params['height'] ) ) {
				$height = intval( $params['height'] );
			} else {
				$height = $width; // we don't have a height or aspect ratio. make it square.
			}
		}


		return new MediaTransformError( 'thumbnail_error',
			$width, $height, wfMsg( $msg ) );
	}

	/**
	 * Get handler-specific metadata which will be saved in the img_metadata field.
	 *
	 * @param $image Image: the image object, or false if there isn't one
	 * @param $path String: path to the image?
	 * @return string
	 */
	function getMetadata( $image, $path ) {
		if ( !$image ) {
			return serialize( $this->getTiffImage( $image, $path )->retrieveMetaData() );
		} else {
			if ( !isset( $image->tiffMetaArray ) ) {
				$image->tiffMetaArray = $this->getTiffImage( $image, $path )->retrieveMetaData();
			}

			return serialize( $image->tiffMetaArray );
		}
	}

	/**
	 * Creates detail information that is being displayed on image page.
	 */
	function getLongDesc( $image ) {
		global $wgLang, $wgRequest;
		$page = $wgRequest->getText( 'page', 1 );
		$page = $this->adjustPage( $image, $page );

		$metadata = $this->getMetaArray( $image );
		if ( $metadata ) {

			return wfMsgExt(
				'tiff-file-info-size',
				'parseinline',
				$wgLang->formatNum( $metadata['page_data'][$page]['width'] ),
				$wgLang->formatNum( $metadata['page_data'][$page]['height'] ),
				$wgLang->formatSize( $image->getSize() ),
				$image->getMimeType(),
				$wgLang->formatNum( $metadata['page_count'] )
			);
		}
		return true;
	}

	/**
	 * Check if the metadata string is valid for this handler.
	 * If it returns false, Image will reload the metadata from the file and update the database
	 */
	function isMetadataValid( $image, $metadata ) {
		if ( is_string( $metadata ) ) {
			$metadata = unserialize( $metadata );
		}

		if ( !isset( $metadata['TIFF_METADATA_VERSION'] ) ) {
			return false;
		}

		if ( $metadata['TIFF_METADATA_VERSION'] != TIFF_METADATA_VERSION ) {
			return false;
		}

		return true;
	}

	/**
	 * Get a list of EXIF metadata items which should be displayed when
	 * the metadata table is collapsed.
	 *
	 * @return array of strings
	 * @access private
	 */
	function visibleMetadataFields() {
		$fields = array();
		$lines = explode( "\n", wfMsg( 'metadata-fields' ) );
		foreach ( $lines as $line ) {
			$matches = array();
			if ( preg_match( '/^\\*\s*(.*?)\s*$/', $line, $matches ) ) {
				$fields[] = $matches[1];
			}
		}
		$fields = array_map( 'strtolower', $fields );
		return $fields;
	}

	/**
	 * Get an array structure that looks like this:
	 *
	 * array(
	 *	'visible' => array(
	 *	   'Human-readable name' => 'Human readable value',
	 *	   ...
	 *	),
	 *	'collapsed' => array(
	 *	   'Human-readable name' => 'Human readable value',
	 *	   ...
	 *	)
	 * )
	 * The UI will format this into a table where the visible fields are always
	 * visible, and the collapsed fields are optionally visible.
	 *
	 * The function should return false if there is no metadata to display.
	 */

	function formatMetadata( $image ) {
		$result = array(
			'visible' => array(),
			'collapsed' => array()
		);
		$metadata = $image->getMetadata();
		if ( !$metadata ) {
			return false;
		}
		$exif = unserialize( $metadata );
		$exif = $exif['exif'];
		if ( !$exif ) {
			return false;
		}
		unset( $exif['MEDIAWIKI_EXIF_VERSION'] );
		if ( class_exists( 'FormatMetadata' ) ) {
			// 1.18+
			$formatted = FormatMetadata::getFormattedData( $exif );
		} else {
			// 1.17 and earlier.
			$format = new FormatExif( $exif );

			$formatted = $format->getFormattedData();
		}
		// Sort fields into visible and collapsed
		$visibleFields = $this->visibleMetadataFields();
		foreach ( $formatted as $name => $value ) {
			$tag = strtolower( $name );
			self::addMeta( $result,
				in_array( $tag, $visibleFields ) ? 'visible' : 'collapsed',
				'exif',
				$tag,
				$value
			);
		}
		$meta = unserialize( $metadata );
		$errors_raw = PagedTiffHandler::getMetadataErrors( $meta );
		if ( $errors_raw ) {
			$errors = PagedTiffHandler::joinMessages( $errors_raw );
			self::addMeta( $result,
				'collapsed',
				'metadata',
				'error',
				$errors
			);
			// XXX: need translation for <metadata-error>
		}
		if ( !empty( $meta['warnings'] ) ) {
			$warnings = PagedTiffHandler::joinMessages( $meta['warnings'] );
			self::addMeta( $result,
				'collapsed',
				'metadata',
				'warning',
				$warnings
			);
			// XXX: need translation for <metadata-warning>
		}
		return $result;
	}

	/**
	 * Returns a PagedTiffImage or creates a new one if it doesn't exist.
	 * @param $image Image: The image object, or false if there isn't one
	 * @param $path String: path to the image?
	 */
	static function getTiffImage( $image, $path ) {
		// If no Image object is passed, a TiffImage is created based on $path .
		// If there is an Image object, we check whether there's already a TiffImage
		// instance in there; if not, a new instance is created and stored in the Image object
		if ( !$image ) {
			$tiffimg = new PagedTiffImage( $path );
		} elseif ( !isset( $image->tiffImage ) ) {
			$tiffimg = $image->tiffImage = new PagedTiffImage( $path );
		} else {
			$tiffimg = $image->tiffImage;
		}

		return $tiffimg;
	}

	/**
	 * Returns an Array with the Image metadata.
	 */
	function getMetaArray( $image ) {
		if ( isset( $image->tiffMetaArray ) ) {
			return $image->tiffMetaArray;
		}

		$metadata = $image->getMetadata();

		if ( !$this->isMetadataValid( $image, $metadata ) ) {
			wfDebug( "Tiff metadata is invalid or missing, should have been fixed in upgradeRow\n" );
			return false;
		}

		wfProfileIn( __METHOD__ );
		wfSuppressWarnings();
		$image->tiffMetaArray = unserialize( $metadata );
		wfRestoreWarnings();
		wfProfileOut( __METHOD__ );

		return $image->tiffMetaArray;
	}

	/**
	 * Get an associative array of page dimensions
	 * Currently "width" and "height" are understood, but this might be
	 * expanded in the future.
	 * Returns false if unknown or if the document is not multi-page.
	 */
	function getPageDimensions( $image, $page ) {
		// makeImageLink2 (Linker.php) sets $page to false if no page parameter
		// is set in wiki code
		$page = $this->adjustPage( $image, $page );
		$data = $this->getMetaArray( $image );
		return PagedTiffImage::getPageSize( $data, $page );
	}

	/**
	 * Handler for the ExtractThumbParameters hook
	 * 
	 * @param $thumbname string URL-decoded basename of URI
	 * @param &$params Array Currently parsed thumbnail params
	 */
	public static function onExtractThumbParameters( $thumbname, array &$params ) {
		if ( !preg_match( '/\.(?:tiff|tif)$/i', $params['f'] ) ) {
			return true; // not an tiff file
		}
		// Check if the parameters can be extracted from the thumbnail name...
		if ( preg_match( '!^(lossy|lossless)-page(\d+)-(\d+)px-[^/]*$!', $thumbname, $m ) ) {
			list( /* all */, $lossy, $pagenum, $size ) = $matches;
			$params['lossy'] = $lossy;
			$params['width'] = $size;
			$params['page'] = $pagenum;
			return false; // valid thumbnail URL
		}
		return true; // pass through to next handler
	}
}
