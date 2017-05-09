<?php
/**
 * Copyright © 2007 Martin Seidel (Xarax) <jodeldi@gmx.de>
 *
 * Inspired by djvuhandler from Tim Starling
 * Modified and written by Xarax
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

class PdfHandler extends ImageHandler {

	function isEnabled() {
		global $wgPdfProcessor, $wgPdfPostProcessor, $wgPdfInfo;

		if ( !isset( $wgPdfProcessor ) || !isset( $wgPdfPostProcessor ) || !isset( $wgPdfInfo ) ) {
			wfDebug( "PdfHandler is disabled, please set the following\n" );
			wfDebug( "variables in LocalSettings.php:\n" );
			wfDebug( "\$wgPdfProcessor, \$wgPdfPostProcessor, \$wgPdfInfo\n" );
			return false;
		}
		return true;
	}

	function mustRender( $file ) {
		return true;
	}

	function isMultiPage( $file ) {
		return true;
	}

	function validateParam( $name, $value ) {
		if ( in_array( $name, array( 'width', 'height', 'page' ) ) ) {
			return ( $value <= 0 ) ? false : true;
		} else {
			return false;
		}
	}

	function makeParamString( $params ) {
		$page = isset( $params['page'] ) ? $params['page'] : 1;
		if ( !isset( $params['width'] ) ) {
			return false;
		}
		return "page{$page}-{$params['width']}px";
	}

	function parseParamString( $str ) {
		$m = false;

		if ( preg_match( '/^page(\d+)-(\d+)px$/', $str, $m ) ) {
			return array( 'width' => $m[2], 'page' => $m[1] );
		}

		return false;
	}

	function getScriptParams( $params ) {
		return array(
			'width' => $params['width'],
			'page' => $params['page'],
		);
	}

	function getParamMap() {
		return array(
			'img_width' => 'width',
			'img_page' => 'page',
		);
	}

	protected function doThumbError( $width, $height, $msg ) {
		return new MediaTransformError( 'thumbnail_error',
			$width, $height, wfMsgForContent( $msg ) );
	}

	function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ) {
		global $wgPdfProcessor, $wgPdfPostProcessor, $wgPdfHandlerDpi;

		$metadata = $image->getMetadata();

		if ( !$metadata ) {
			return $this->doThumbError( @$params['width'], @$params['height'], 'pdf_no_metadata' );
		}

		if ( !$this->normaliseParams( $image, $params ) ) {
			return new TransformParameterError( $params );
		}

		$width = (int)$params['width'];
		$height = (int)$params['height'];
		$page = (int)$params['page'];

		if ( $page > $this->pageCount( $image ) ) {
			return $this->doThumbError( $width, $height, 'pdf_page_error' );
		}

		if ( $flags & self::TRANSFORM_LATER ) {
			return new ThumbnailImage( $image, $dstUrl, $width, $height, false, $page );
		}

		if ( !wfMkdirParents( dirname( $dstPath ), null, __METHOD__ ) ) {
			return $this->doThumbError( $width, $height, 'thumbnail_dest_directory' );
		}

		$srcPath = $image->getLocalRefPath();

		$cmd = '(' . wfEscapeShellArg(
			$wgPdfProcessor,
			"-sDEVICE=jpeg",
			"-sOutputFile=-",
			"-dFirstPage={$page}",
			"-dLastPage={$page}",
			"-dSAFER",
			"-r{$wgPdfHandlerDpi}",
			"-dBATCH",
			"-dNOPAUSE",
			"-q",
			$srcPath
		);
		$cmd .= " | " . wfEscapeShellArg(
			$wgPdfPostProcessor,
			"-depth",
			"8",
			"-resize",
			$width,
			"-",
			$dstPath
		);
		$cmd .= ") 2>&1";

		wfProfileIn( 'PdfHandler' );
		wfDebug( __METHOD__ . ": $cmd\n" );
		$retval = '';
		$err = wfShellExec( $cmd, $retval );
		wfProfileOut( 'PdfHandler' );

		$removed = $this->removeBadFile( $dstPath, $retval );

		if ( $retval != 0 || $removed ) {
			wfDebugLog( 'thumbnail',
				sprintf( 'thumbnail failed on %s: error %d "%s" from "%s"',
				wfHostname(), $retval, trim( $err ), $cmd ) );
			return new MediaTransformError( 'thumbnail_error', $width, $height, $err );
		} else {
			return new ThumbnailImage( $image, $dstUrl, $width, $height, $dstPath, $page );
		}
	}

	function getPdfImage( $image, $path ) {
		if ( !$image ) {
			$pdfimg = new PdfImage( $path );
		} elseif ( !isset( $image->pdfImage ) ) {
			$pdfimg = $image->pdfImage = new PdfImage( $path );
		} else {
			$pdfimg = $image->pdfImage;
		}

		return $pdfimg;
	}

	function getMetaArray( $image ) {
		if ( isset( $image->pdfMetaArray ) ) {
			return $image->pdfMetaArray;
		}

		$metadata = $image->getMetadata();

		if ( !$this->isMetadataValid( $image, $metadata ) ) {
			wfDebug( "Pdf metadata is invalid or missing, should have been fixed in upgradeRow\n" );
			return false;
		}

		wfProfileIn( __METHOD__ );
		wfSuppressWarnings();
		$image->pdfMetaArray = unserialize( $metadata );
		wfRestoreWarnings();
		wfProfileOut( __METHOD__ );

		return $image->pdfMetaArray;
	}

	function getImageSize( $image, $path ) {
		return $this->getPdfImage( $image, $path )->getImageSize();
	}

	function getThumbType( $ext, $mime, $params = null ) {
		global $wgPdfOutputExtension;
		static $mime;

		if ( !isset( $mime ) ) {
			$magic = MimeMagic::singleton();
			$mime = $magic->guessTypesForExtension( $wgPdfOutputExtension );
		}
		return array( $wgPdfOutputExtension, $mime );
	}

	function getMetadata( $image, $path ) {
		return serialize( $this->getPdfImage( $image, $path )->retrieveMetaData() );
	}

	function isMetadataValid( $image, $metadata ) {
		return !empty( $metadata ) && $metadata != serialize( array() );
	}

	function pageCount( $image ) {
		$data = $this->getMetaArray( $image );
		if ( !$data ) {
			return false;
		}
		return intval( $data['Pages'] );
	}

	function getPageDimensions( $image, $page ) {
		$data = $this->getMetaArray( $image );
		return PdfImage::getPageSize( $data, $page );
	}

	function getPageText( $image, $page ) {
		$data = $this->getMetaArray( $image, true );
		if ( !$data ) {
			return false;
		}
		if( !isset( $data['text'] ) ) {
			return false;
		}
		if( !isset( $data['text'][$page - 1] ) ) {
			return false;
		}
		return $data['text'][$page - 1];
	}

}
