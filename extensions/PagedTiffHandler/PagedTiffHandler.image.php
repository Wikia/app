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

/**
 * inspired by djvuimage from Brion Vibber
 * modified and written by xarax
 * adapted to tiff by Hallo Welt! - Medienwerkstatt GmbH
 */

class PagedTiffImage {
	protected $_meta = null;
	protected $mFilename;

	function __construct( $filename ) {
		$this->mFilename = $filename;
	}

	/**
	 * Called by MimeMagick functions.
	 */
	public function isValid() {
		return count( $this->retrieveMetaData() );
	}

	/**
	 * Returns an array that corresponds to the native PHP function getimagesize().
	 */
	public function getImageSize() {
		$data = $this->retrieveMetaData();
		$size = $this->getPageSize( $data, 1 );

		if ( $size ) {
			$width = $size['width'];
			$height = $size['height'];
			return array( $width, $height, 'Tiff',
			"width=\"$width\" height=\"$height\"" );
		}
		return false;
	}

	/**
	 * Returns an array with width and height of the tiff page.
	 */
	public static function getPageSize( $data, $page ) {
		if ( isset( $data['page_data'][$page] ) ) {
			return array(
				'width'  => intval( $data['page_data'][$page]['width'] ),
				'height' => intval( $data['page_data'][$page]['height'] )
			);
		}
		return false;
	}

	public function resetMetaData() {
		$this->_meta = null;
	}

	/**
	 * Reads metadata of the tiff file via shell command and returns an associative array.
	 * layout:
	 * meta['page_count'] = number of pages
	 * meta['first_page'] = number of first page
	 * meta['last_page'] = number of last page
	 * meta['page_data'] = metadata per page
	 * meta['exif']  = Exif, XMP and IPTC
	 * meta['errors'] = identify-errors
	 * meta['warnings'] = identify-warnings
	 */
	public function retrieveMetaData() {
		global $wgImageMagickIdentifyCommand, $wgExiv2Command, $wgTiffUseExiv;
		global $wgTiffUseTiffinfo, $wgTiffTiffinfoCommand;
		global $wgShowEXIF;

		if ( $this->_meta === null ) {
			wfProfileIn( 'PagedTiffImage::retrieveMetaData' );

			//fetch base info: number of pages, size and alpha for each page.
			//run hooks first, then optionally tiffinfo or, per default, ImageMagic's identify command
			if ( !wfRunHooks( 'PagedTiffHandlerTiffData', array( $this->mFilename, &$this->_meta ) ) ) {
				wfDebug( __METHOD__ . ": hook PagedTiffHandlerTiffData overrides TIFF data extraction\n" );
			} elseif ( $wgTiffUseTiffinfo ) {
				// read TIFF directories using libtiff's tiffinfo, see
				// http://www.libtiff.org/man/tiffinfo.1.html
				$cmd = wfEscapeShellArg( $wgTiffTiffinfoCommand ) .
					' ' . wfEscapeShellArg( $this->mFilename ) . ' 2>&1';

				wfProfileIn( 'tiffinfo' );
				wfDebug( __METHOD__ . ": $cmd\n" );
				$retval = '';
				$dump = wfShellExec( $cmd, $retval );
				wfProfileOut( 'tiffinfo' );

				if ( $retval ) {
					$data['errors'][] = "tiffinfo command failed: $cmd";
					wfDebug( __METHOD__ . ": tiffinfo command failed: $cmd\n" );
					return $data; // fail. we *need* that info
				}

				$this->_meta = $this->parseTiffinfoOutput( $dump );
			} else {
				$cmd = wfEscapeShellArg( $wgImageMagickIdentifyCommand ) .
					' -format "[BEGIN]page=%p\nalpha=%A\nalpha2=%r\nheight=%h\nwidth=%w\ndepth=%z[END]" ' .
					wfEscapeShellArg( $this->mFilename ) . ' 2>&1';

				wfProfileIn( 'identify' );
				wfDebug( __METHOD__ . ": $cmd\n" );
				$retval = '';
				$dump = wfShellExec( $cmd, $retval );
				wfProfileOut( 'identify' );

				if ( $retval ) {
					$data['errors'][] = "identify command failed: $cmd";
					wfDebug( __METHOD__ . ": identify command failed: $cmd\n" );
					return $data; // fail. we *need* that info
				}

				$this->_meta = $this->parseIdentifyOutput( $dump );
			}

			$this->_meta['exif'] = array();

			//fetch extended info: EXIF/IPTC/XMP
			//run hooks first, then optionally Exiv2 or, per default, the internal EXIF class
			if ( !empty( $this->_meta['errors'] ) ) {
				wfDebug( __METHOD__ . ": found errors, skipping EXIF extraction\n" );
			} elseif ( !wfRunHooks( 'PagedTiffHandlerExifData', array( $this->mFilename, &$this->_meta['exif'] ) ) ) {
				wfDebug( __METHOD__ . ": hook PagedTiffHandlerExifData overrides EXIF extraction\n" );
			} elseif ( $wgTiffUseExiv ) {
				// read EXIF, XMP, IPTC as name-tag => interpreted data
				// -ignore unknown fields
				// see exiv2-doc @link http://www.exiv2.org/sample.html
				// NOTE: the linux version of exiv2 has a bug: it can only
				// read one type of meta-data at a time, not all at once.
				$cmd = wfEscapeShellArg( $wgExiv2Command ) .
					' -u -psix -Pnt ' . wfEscapeShellArg( $this->mFilename ) . ' 2>&1';

				wfProfileIn( 'exiv2' );
				wfDebug( __METHOD__ . ": $cmd\n" );
				$retval = '';
				$dump = wfShellExec( $cmd, $retval );
				wfProfileOut( 'exiv2' );

				if ( $retval ) {
					$data['errors'][] = "exiv command failed: $cmd";
					wfDebug( __METHOD__ . ": exiv command failed: $cmd\n" );
					// don't fail - we are missing info, just report
				}

				$data = $this->parseExiv2Output( $dump );

				$this->_meta['exif'] = $data;
			} elseif ( $wgShowEXIF ) {
				wfDebug( __METHOD__ . ": using internal Exif( {$this->mFilename} )\n" );
				if ( method_exists( 'BitmapMetadataHandler', 'Tiff' ) ) {
					$data = BitmapMetadataHandler::Tiff( $this->mFilename );
				} else {
					// old method for back compat.
					$exif = new Exif( $this->mFilename );
					$data = $exif->getFilteredData();
				}

				if ( $data ) {
					$data['MEDIAWIKI_EXIF_VERSION'] = Exif::version();
					$this->_meta['exif'] = $data;
				}
			}

			unset( $this->_meta['exif']['Image'] );
			unset( $this->_meta['exif']['filename'] );
			unset( $this->_meta['exif']['Base filename'] );
			unset( $this->_meta['exif']['XMLPacket'] );
			unset( $this->_meta['exif']['ImageResources'] );

			$this->_meta['TIFF_METADATA_VERSION'] = TIFF_METADATA_VERSION;

			wfProfileOut( 'PagedTiffImage::retrieveMetaData' );
		}

		return $this->_meta;
	}

	/**
	 * helper function of retrieveMetaData().
	 * parses shell return from tiffinfo-command into an array.
	 */
	protected function parseTiffinfoOutput( $dump ) {
		global $wgTiffTiffinfoRejectMessages, $wgTiffTiffinfoBypassMessages;

		$dump = preg_replace( '/ Image Length:/', "\n  Image Length:", $dump ); #HACK: width and length are given on a single line...
		$rows = preg_split('/[\r\n]+\s*/', $dump);

		$state = new PagedTiffInfoParserState();

		$ignoreIFDs = array();
		$ignore = false;

		foreach ( $rows as $row ) {
			$row = trim( $row );

			# ignore XML rows
			if ( preg_match('/^<|^$/', $row) ) {
				continue;
			}

			$error = false;

			# handle fatal errors
			foreach ( $wgTiffTiffinfoRejectMessages as $pattern ) {
				if ( preg_match( $pattern, trim( $row ) ) ) {
					$state->addError( $row );
					$error = true;
					break;
				}
			}

			if ( $error ) continue;

			$m = array();

			if ( preg_match('/^TIFF Directory at offset 0x[a-f0-9]+ \((\d+)\)/', $row, $m) ) {
				# new IFD starting, flush previous page

				if ( $ignore ) {
					$state->resetPage();
				} else {
					$ok = $state->finishPage();

					if ( !$ok ) {
						$error = true;
						continue;
					}
				}

				# check if the next IFD is to be ignored
				$offset = (int)$m[1];
				$ignore = !empty( $ignoreIFDs[ $offset ] );
			} elseif ( preg_match('#^(TIFF.*?Directory): (.*?/.*?): (.*)#i', $row, $m) ) {
				# handle warnings

				$bypass = false;
				$msg = $m[3];

				foreach ( $wgTiffTiffinfoBypassMessages as $pattern ) {
					if ( preg_match( $pattern, trim( $row ) ) ) {
						$bypass = true;
						break;
					}
				}

				if ( !$bypass ) {
					$state->addWarning( $msg );
				}
			} elseif ( preg_match('/^\s*(.*?)\s*:\s*(.*?)\s*$/', $row, $m) ) {
				# handle key/value pair

				$key = $m[1];
				$value = $m[2];

				if ( $key == 'Page Number' && preg_match('/(\d+)-(\d+)/', $value, $m) ) {
					$state->setPageProperty('page', (int)$m[1] +1);
				} elseif ( $key == 'Samples/Pixel' ) {
					if ($value == '4') $state->setPageProperty('alpha', 'true');
				} elseif ( $key == 'Extra samples' ) {
					if (preg_match('.*alpha.*', $value)) $state->setPageProperty('alpha', 'true');
				} elseif ( $key == 'Image Width' || $key == 'PixelXDimension' ) {
					$state->setPageProperty('width', (int)$value);
				} elseif ( $key == 'Image Length' || $key == 'PixelYDimension' ) {
					$state->setPageProperty('height', (int)$value);
				} elseif ( preg_match('/.*IFDOffset/', $key) ) {
					# ignore extra IFDs, see <http://www.awaresystems.be/imaging/tiff/tifftags/exififd.html>
					# Note: we assume that we will always see the reference before the actual IFD, so we know which IFDs to ignore
					$offset = (int)$value;
					$ignoreIFDs[$offset] = true;
				}
			} else {
				// strange line
			}

		}

		$state->finish( !$ignore );

		$data = $state->getMetadata();
		return $data;
	}

	/**
	 * helper function of retrieveMetaData().
	 * parses shell return from exiv2-command into an array.
	 */
	protected function parseExiv2Output( $dump ) {
		$result = array();
		preg_match_all( '/^(\w+)\s+(.+)$/m', $dump, $result, PREG_SET_ORDER );

		$data = array();

		foreach ( $result as $row ) {
			$data[$row[1]] = $row[2];
		}

		return $data;
	}

	/**
	 * helper function of retrieveMetaData().
	 * parses shell return from identify-command into an array.
	 */
	protected function parseIdentifyOutput( $dump ) {
		global $wgTiffIdentifyRejectMessages, $wgTiffIdentifyBypassMessages;

		$state = new PagedTiffInfoParserState();

		if ( strval( $dump ) == '' ) {
			$state->addError( "no metadata" );
			return $state->getMetadata();
		}

		$infos = null;
		preg_match_all( '/\[BEGIN\](.+?)\[END\]/si', $dump, $infos, PREG_SET_ORDER );
		foreach ( $infos as $info ) {
			$state->resetPage();
			$lines = explode( "\n", $info[1] );
			foreach ( $lines as $line ) {
				if ( trim( $line ) == '' ) {
					continue;
				}
				$parts = explode( '=', $line );
				if ( trim( $parts[0] ) == 'alpha' && trim( $parts[1] ) == '%A' ) {
					continue;
				}
				if ( trim( $parts[0] ) == 'alpha2' && !$state->hasPageProperty( 'alpha' ) ) {
					switch( trim( $parts[1] ) ) {
						case 'DirectClassRGBMatte':
						case 'DirectClassRGBA':
							$state->setPageProperty('alpha', 'true');
							break;
						default:
							$state->setPageProperty('alpha', 'false');
							break;
					}
					continue;
				}
				$state->setPageProperty( trim( $parts[0] ), trim( $parts[1] ) );
			}
			$state->finishPage();
		}


		$dump = preg_replace( '/\[BEGIN\](.+?)\[END\]/si', '', $dump );
		if ( strlen( $dump ) ) {
			$errors = explode( "\n", $dump );
			foreach ( $errors as $error ) {
				$error = trim( $error );
				if ( $error === '' )
					continue;

				$knownError = false;
				foreach ( $wgTiffIdentifyRejectMessages as $msg ) {
					if ( preg_match( $msg, trim( $error ) ) ) {
						$state->addError( $error );
						$knownError = true;
						break;
					}
				}
				if ( !$knownError ) {
					// ignore messages that match $wgTiffIdentifyBypassMessages
					foreach ( $wgTiffIdentifyBypassMessages as $msg ) {
						if ( preg_match( $msg, trim( $error ) ) ) {
							$knownError = true;
							break;
						}
					}
				}
				if ( !$knownError ) {
					$state->addWarning( $error );
				}
			}
		}

		$state->finish();

		$data = $state->getMetadata();
		return $data;
	}
}

class PagedTiffInfoParserState {
	var $metadata; # all data
	var $page; # current page
	var $prevPage;

	function __construct() {
	    $this->metadata = array();
	    $this->page = array();
	    $this->prevPage = 0;

	    $this->metadata['page_data'] = array();
	}

	function finish( $finishPage = true ) {
		if ( $finishPage ) {
			$this->finishPage( );
		}

		if ( ! $this->metadata['page_data'] ) {
			$this->metadata['errors'][] = 'no page data found in tiff directory!';
			return;
		}

		if ( !isset( $this->metadata['page_count'] ) ) {
			$this->metadata['page_count'] = count( $this->metadata['page_data'] );
		}

		if ( !isset( $this->metadata['first_page'] ) ) {
			$this->metadata['first_page'] = min( array_keys( $this->metadata['page_data'] ) );
		}

		if ( !isset( $this->metadata['last_page'] ) ) {
			$this->metadata['last_page'] = max( array_keys( $this->metadata['page_data'] ) );
		}
	}

	function resetPage( ) {
		$this->page = array();
	}

	function finishPage( ) {
		if ( !isset( $this->page['page'] ) ) {
			$this->page['page'] = $this->prevPage +1;
		} else {
			if ( $this->prevPage >= $this->page['page'] ) {
				$this->metadata['errors'][] = "inconsistent page numbering in TIFF directory";
				return false;
			}
		}

		if ( isset( $this->page['width'] ) && isset( $this->page['height'] ) ) {
			$this->prevPage = max($this->prevPage, $this->page['page']);

			if ( !isset( $this->page['alpha'] ) ) {
				$this->page['alpha'] = 'false';
			}

			$this->page['pixels'] = $this->page['height'] * $this->page['width'];
			$this->metadata['page_data'][$this->page['page']] = $this->page;
		}

		$this->page = array();
		return true;
	}

	function setPageProperty( $key, $value ) {
		$this->page[$key] = $value;
	}

	function hasPageProperty( $key ) {
		return isset( $this->page[$key] ) && ! is_null( $this->page[$key] );
	}

	function setFileProperty( $key, $value ) {
		$this->metadata[$key] = $value;
	}

	function hasFileProperty( $key, $value ) {
		return isset( $this->metadata[$key] ) && ! is_null( $this->metadata[$key] );
	}

	function addError( $message ) {
		$this->metadata['errors'][] = $message;
	}

	function addWarning( $message ) {
		$this->metadata['warnings'][] = $message;
	}

	function getMetadata( ) {
		return $this->metadata;
	}

	function hasErrors() {
		return !empty( $this->metadata['errors'] );
	}
}
