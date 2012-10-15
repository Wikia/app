<?php
/*
 * Copyright © Bryan Tong Minh, 2011
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
 *
 * @file
 */

/**
 * A Special page intended to test the VipsScaler.
 * @author Bryan Tong Minh
 */
class SpecialVipsTest extends SpecialPage {
	public function __construct() {
		parent::__construct( 'VipsTest', 'vipsscaler-test' );
	}

	/**
	 * Entry point
	 * @param $par Array TODO describe what is expected there
	 */
	public function execute( $par ) {
		$request = $this->getRequest();
		$this->setHeaders();

		if( !$this->userCanExecute( $this->getUser() ) ) {
			$this->displayRestrictionError();
			return;
		}

		if ( $request->getText( 'thumb' ) ) {
			$this->streamThumbnail();
		} else {
			$this->showForm();
		}
	}

	/**
	 */
	protected function showThumbnails() {
		$request = $this->getRequest();

		# Check if valid file was provided
		$title = Title::makeTitleSafe( NS_FILE, $request->getText( 'file' ) );
		if ( is_null( $title ) ) {
			$this->getOutput()->addWikiMsg( 'vipsscaler-invalid-file' );
			return;
		}
		$file = wfFindFile( $title );
		if ( !$file || !$file->exists() ) {
			$this->getOutput()->addWikiMsg( 'vipsscaler-invalid-file' );
			return;
		}

		# Create options
		$width = $request->getInt( 'width' );
		if ( !$width ) {
			$this->getOutput()->addWikiMsg( 'vipsscaler-invalid-width' );
			return;
		}
		$vipsUrlOptions = array( 'thumb' => $file->getName(), 'width' => $width );
		if ( $request->getVal( 'sharpen' ) ) {
			$vipsUrlOptions['sharpen'] = floatval( $request->getVal( 'sharpen' ) );
		}
		if ( $request->getCheck( 'bilinear' ) ) {
			$vipsUrlOptions['bilinear'] = 1;
		}

		# Generate normal thumbnail
		$params = array( 'width' => $width );
		$thumb = $file->transform( $params );
		if ( !$thumb || $thumb->isError() ) {
			$this->getOutput()->addWikiMsg( 'vipsscaler-thumb-error' );
			return;
		}

		# Check if we actually scaled the file
		$normalThumbUrl = $thumb->getUrl();
		if ( wfExpandUrl( $normalThumbUrl ) == $file->getFullUrl() ) {
			// TODO: message
		}

		# Make url to the vips thumbnail
		$vipsThumbUrl = $this->getTitle()->getLocalUrl( $vipsUrlOptions );

		# HTML for the thumbnails
		$thumbs = Html::rawElement( 'div', array( 'id' => 'mw-vipstest-thumbnails' ),
					Html::element( 'img', array(
							'src'   => $normalThumbUrl,
							'alt' => wfMessage( 'vipsscaler-default-thumb' ),
							) ) . ' ' .
					Html::element( 'img', array(
							'src' => $vipsThumbUrl,
							'alt' => wfMessage( 'vipsscaler-vips-thumb' ),
							) )
					);

		# Helper messages shown above the thumbnails rendering
		$help = wfMessage( 'vipsscaler-thumbs-help' )->parseAsBlock();

		# A checkbox to easily alternate between both views:
		$checkbox = Xml::checkLabel(
			wfMessage( 'vipsscaler-thumbs-switch-label' ),
			'mw-vipstest-thumbs-switch',
			'mw-vipstest-thumbs-switch'
		);

		# Wrap the three HTML snippets above in a fieldset:
		$html = Xml::fieldset(
			wfMessage( 'vipsscaler-thumbs-legend' ),
			$help . $checkbox . $thumbs
		);

		# Finally output all of the above
		$this->getOutput()->addHTML( $html );
		$this->getOutput()->addModules( array(
			'ext.vipsscaler',
			'jquery.ucompare',
		) );
	}

	/**
	 * TODO
	 */
	protected function showForm() {
		$form = new HTMLForm( $this->getFormFields(), $this->getContext() );
		$form->setWrapperLegend( wfMsg( 'vipsscaler-form-legend' ) );
		$form->setSubmitText( wfMsg( 'vipsscaler-form-submit' ) );
		$form->setSubmitCallback( array( __CLASS__, 'processForm' ) );
		$form->setMethod( 'get' );

		// Looks like HTMLForm does not actually show the form if submission
		// was correct. So we have to show it again.
		// See HTMLForm::show()
		$result = $form->show();
		if( $result === true || $result instanceof Status && $result->isGood() ) {
			$form->displayForm( $result );
			$this->showThumbnails();
		}
	}

	/**
	 * [[Special:VipsTest]] form structure for HTMLForm
	 * @return Array A form structure using the HTMLForm system
	 */
	protected function getFormFields() {
		$fields = array(
			'File' => array(
				'name'          => 'file',
				'class'         => 'HTMLTextField',
				'required'      => true,
				'size' 			=> '80',
				'label-message' => 'vipsscaler-form-file',
				'validation-callback' => array( __CLASS__, 'validateFileInput' ),
			),
			'Width' => array(
				'name'          => 'width',
				'class'         => 'HTMLIntField',
				'default'       => '640',
				'size'          => '5',
				'required'      => true,
				'label-message' => 'vipsscaler-form-width',
				'validation-callback' => array( __CLASS__, 'validateWidth' ),
			),
			'SharpenRadius' => array(
				'name'          => 'sharpen',
				'class'         => 'HTMLFloatField',
				'default'		=> '0.0',
				'size'			=> '5',
				'label-message' => 'vipsscaler-form-sharpen-radius',
				'validation-callback' => array( __CLASS__, 'validateSharpen' ),
			),
			'Bilinear' => array(
				'name' 			=> 'bilinear',
				'class' 		=> 'HTMLCheckField',
				'label-message'	=> 'vipsscaler-form-bilinear',
			),
		);

		/**
		 * Match ImageMagick by default
		 */
		global $wgSharpenParameter;
		if ( preg_match( '/^[0-9.]+x([0-9.]+)$/', $wgSharpenParameter, $m ) ) {
			$fields['SharpenRadius']['default'] = $m[1];
		}
		return $fields;
	}

	/**
	 * @param $input
	 * @param $alldata
	 * @return bool|String
	 */
	public static function validateFileInput( $input, $alldata ) {
		if ( !trim( $input ) ) {
			# Don't show an error if the file is not yet specified,
			# because it is annoying
			return true;
		}

		$title = Title::makeTitleSafe( NS_FILE, $input );
		if( is_null( $title ) ) {
			return wfMsg( 'vipsscaler-invalid-file' );
		}
		$file = wfFindFile( $title );  # TODO what does it do?
		if ( !$file || !$file->exists() ) {
			return wfMsg( 'vipsscaler-invalid-file' );
		}

		// Looks sane enough.
		return true;
	}

	/**
	 * @param $input
	 * @param $allData
	 * @return bool|String
	 */
	public static function validateWidth( $input, $allData ) {
		if ( self::validateFileInput( $allData['File'], $allData ) !== true
				|| !trim( $allData['File'] ) ) {
			# Invalid file, error will already be shown at file field
			return true;
		}
		$title = Title::makeTitleSafe( NS_FILE, $allData['File'] );
		$file = wfFindFile( $title );
		if ( $input <= 0 || $input >= $file->getWidth() ) {
			return wfMsg( 'vipsscaler-invalid-width' );
		}
		return true;
	}

	/**
	 * @param $input
	 * @param $allData
	 * @return bool|String
	 */
	public static function validateSharpen( $input, $allData ) {
		if ( $input >= 5.0 || $input < 0.0 ) {
			return wfMsg( 'vipsscaler-invalid-sharpen' );
		}
		return true;
	}

	/**
	 * Process data submitted by the form.
	 * @param $data array
	 * @return Status
	 */
	public static function processForm( array $data ) {
		return Status::newGood();
	}

	/**
	 *
	 */
	protected function streamThumbnail() {
		global $wgVipsThumbnailerHost, $wgVipsTestExpiry;

		$request = $this->getRequest();

		# Validate title and file existance
		$title = Title::makeTitleSafe( NS_FILE, $request->getText( 'thumb' ) );
		if ( is_null( $title ) ) {
			$this->streamError( 404, "VipsScaler: invalid title\n" );
			return;
		}
		$file = wfFindFile( $title );
		if ( !$file || !$file->exists() ) {
			$this->streamError( 404, "VipsScaler: file not found\n" );
			return;
		}

		# Check if vips can handle this file
		if ( VipsScaler::getVipsHandler( $file ) === false ) {
			$this->streamError( 500, "VipsScaler: VIPS cannot handle this file type\n" );
			return;
		}

		# Validate param string
		$handler = $file->getHandler();
		$params = array( 'width' => $request->getInt( 'width' ) );
		if ( !$handler->normaliseParams( $file, $params ) ) {
			$this->streamError( 500, "VipsScaler: invalid parameters\n" );
			return;
		}

		# Get the thumbnail
		if ( is_null( $wgVipsThumbnailerHost ) || $request->getBool( 'noproxy' ) ) {
			# No remote scaler, need to do it ourselves.
			# Emulate the BitmapHandlerTransform hook

			$dstPath = VipsCommand::makeTemp( $file->getExtension() );
			$dstUrl = '';
			wfDebug( __METHOD__ . ": Creating vips thumbnail at $dstPath\n" );

			$scalerParams = array(
				# The size to which the image will be resized
				'physicalWidth' => $params['physicalWidth'],
				'physicalHeight' => $params['physicalHeight'],
				'physicalDimensions' => "{$params['physicalWidth']}x{$params['physicalHeight']}",
				# The size of the image on the page
				'clientWidth' => $params['width'],
				'clientHeight' => $params['height'],
				# Comment as will be added to the EXIF of the thumbnail
				'comment' => isset( $params['descriptionUrl'] ) ?
					"File source: {$params['descriptionUrl']}" : '',
				# Properties of the original image
				'srcWidth' => $file->getWidth(),
				'srcHeight' => $file->getHeight(),
				'mimeType' => $file->getMimeType(),
				'srcPath' => $file->getPath(),
				'dstPath' => $dstPath,
				'dstUrl' => $dstUrl,
			);

			$options = array();
			if ( $request->getBool( 'bilinear' ) ) {
				$options['bilinear'] = true;
				wfDebug( __METHOD__ . ": using bilinear scaling\n" );
			}
			if ( $request->getVal( 'sharpen' ) && $request->getVal( 'sharpen' ) < 5 ) {
				# Limit sharpen sigma to 5, otherwise we have to write huge convolution matrices
				$options['sharpen'] = array( 'sigma' => floatval( $request->getVal( 'sharpen' ) ) );
				wfDebug( __METHOD__ . ": sharpening with radius {$options['sharpen']}\n" );
			}

			# Call the hook
			$mto = null;
			VipsScaler::doTransform( $handler, $file, $scalerParams, $options, $mto );
			if ( $mto && !$mto->isError() ) {
				wfDebug( __METHOD__ . ": streaming thumbnail...\n" );
				$this->getOutput()->disable();
				StreamFile::stream( $dstPath, array(
					"Cache-Control: public, max-age=$wgVipsTestExpiry, s-maxage=$wgVipsTestExpiry",
					'Expires: ' . gmdate( 'r ', time() + $wgVipsTestExpiry )
				) );
			} else {
				$this->streamError( 500, $mto->getHtmlMsg() );
			}

			# Cleanup the temporary file
			wfSuppressWarnings();
			unlink( $dstPath );
			wfRestoreWarnings();

		} else {
			# Request the thumbnail at a remote scaler
			$url = wfExpandUrl( $request->getRequestURL(), PROTO_INTERNAL );
			$url = wfAppendQuery( $url, array( 'noproxy' => '1' ) );
			wfDebug( __METHOD__ . ": Getting vips thumb from remote url $url\n" );

			$bits = IP::splitHostAndPort( $wgVipsThumbnailerHost );
			if ( !$bits ) {
				throw new MWException( __METHOD__.': $wgVipsThumbnailerHost is not set to a valid host' );
			}
			list( $host, $port ) = $bits;
			if ( $port === false ) {
				$port = 80;
			}
			$proxy = IP::combineHostAndPort( $host, $port );

			$options = array(
				'method' => 'GET',
				'proxy' => $proxy,
			);

			$req = MWHttpRequest::factory( $url, $options );
			$status = $req->execute();
			if ( $status->isOk() ) {
				# Disable output and stream the file
				$this->getOutput()->disable();
				wfResetOutputBuffers();
				header( 'Content-Type: ' . $file->getMimeType() );
				header( 'Content-Length: ' . strlen( $req->getContent() ) );
				header( "Cache-Control: public, max-age=$wgVipsTestExpiry, s-maxage=$wgVipsTestExpiry" );
				header( 'Expires: ' . gmdate( 'r ', time() + $wgVipsTestExpiry ) );
				print $req->getContent();
			} elseif ( $status->hasMessage( 'http-bad-status' ) ) {
				$this->streamError( 500, $req->getContent() );
				return;
			} else {
				global $wgOut;
				$this->streamError( 500, $wgOut->parse( $status->getWikiText() ) );
				return;
			}
		}
	}

	/**
	 * Generates a blank page with given HTTP error code
	 *
	 * @param $code Integer HTTP error either 404 or 500
	 * @param $error string
	 */
	protected function streamError( $code, $error = '' ) {
		$output = $this->getOutput();
		$output->setStatusCode( $code );
		$output->setArticleBodyOnly( true );
		$output->addHTML( $error );
	}
}
