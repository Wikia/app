<?php

/**
 * Result printer that outputs query results as a image gallery.
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
 * @ingroup SemanticResultFormats
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author mwjames
 * @author Rowan Rodrik van der Molen
 */

/**
 * Result printer that outputs query results as a image gallery.
 * @ingroup SemanticResultFormats
 *
 */
class SRFGallery extends SMWResultPrinter {

	/**
	 * @see SMWResultPrinter::getName
	 *
	 * @return string
	 */
	public function getName() {
		return wfMessage( 'srf_printername_gallery' )->text();
	}

	/**
	 * @see SMWResultPrinter::buildResult
	 *
	 * @since 1.8
	 *
	 * @param SMWQueryResult $results
	 *
	 * @return string
	 */
	protected function buildResult( SMWQueryResult $results ) {

		// Intro/outro are not planned to work with the widget option
		if ( $this->params['intro'] !== '' && $this->params['widget'] !== '' ){
			return $results->addErrors( array(
				wfMessage( 'srf-error-option-mix', 'intro/widget' )->inContentLanguage()->text() 
			) );
		} elseif( $this->params['outro'] !== '' && $this->params['widget'] !== '' ){
			return $results->addErrors(
				array( wfMessage( 'srf-error-option-mix', 'outro/widget' )->inContentLanguage()->text() 
			) );
		};

		return $this->getResultText( $results, $this->outputMode );
	}

	/**
	 * @see SMWResultPrinter::getResultText
	 *
	 * @param $results SMWQueryResult
	 * @param $fullParams array
	 * @param $outputmode integer
	 *
	 * @return string
	 */
	public function getResultText( SMWQueryResult $results, $outputmode ) {

		$ig = new ImageGallery();
		$ig->setShowBytes( false );
		$ig->setShowFilename( false );
		$ig->setCaption( $this->mIntro ); // set caption to IQ header

		// No need for a special page to use the parser but for the "normal" page
		// view we have to ensure caption text is parsed correctly through the parser
		if ( !$this->isSpecialPage() ) {
			$ig->setParser( $GLOBALS['wgParser'] );
		}

		// Initialize
		static $statNr = 0;
		$html          = '';
		$processing    = '';

		if ( $this->params['widget'] == 'carousel' ) {
			// Carousel widget
			$ig->setAttributes( $this->getCarouselWidget() );
		} elseif ( $this->params['widget'] == 'slideshow' ) {
			// Slideshow widget
			$ig->setAttributes( $this->getSlideshowWidget() );
		} else {

			// Standard gallery attributes
			$attribs = array(
				'id' => uniqid(),
				'class' => $this->getImageOverlay(),
			);

			$ig->setAttributes( $attribs );
		}

		// Only use redirects where the overlay option is not used and redirect
		// thumb images towards a different target
		if ( $this->params['redirects'] !== '' && !$this->params['overlay'] ){
			SMWOutputs::requireResource( 'ext.srf.gallery.redirect' );
		}

		// For the carousel widget, the perrow option should not be set
		if ( $this->params['perrow'] !== '' && $this->params['widget'] !== 'carousel' ) {
			$ig->setPerRow( $this->params['perrow'] );
		}

		if ( $this->params['widths'] !== '' ) {
			$ig->setWidths( $this->params['widths'] );
		}

		if ( $this->params['heights'] !== '' ) {
			$ig->setHeights( $this->params['heights'] );
		}

		$printReqLabels = array();
		$redirectType = '';

		/**
		 * @var SMWPrintRequest $printReq
		 */
		foreach ( $results->getPrintRequests() as $printReq ) {
			$printReqLabels[] = $printReq->getLabel();

			// Get redirect type
			if ( $this->params['redirects'] === $printReq->getLabel() ){
			 $redirectType = $printReq->getTypeID();
			}
		}

		if ( $this->params['imageproperty'] !== '' && in_array( $this->params['imageproperty'], $printReqLabels ) ||
			$this->params['redirects'] !== '' && in_array( $this->params['redirects'], $printReqLabels ) ) {

			$this->addImageProperties(
				$results,
				$ig,
				$this->params['imageproperty'],
				$this->params['captionproperty'],
				$this->params['redirects'],
				$outputmode
			);
		} else {
			$this->addImagePages( $results, $ig );
		}

		// SRF Global settings
		SRFUtils::addGlobalJSVariables();

		// Display a processing image as long as the DOM is no ready
		if ( $this->params['widget'] !== '' ) {
			$processing = SRFUtils::htmlProcessingElement();
		}

		// Beautify the class selector
		$class = $this->params['widget'] ?  '-' . $this->params['widget'] . ' ' : '';
		$class = $this->params['redirects'] !== '' && $this->params['overlay'] === false ? $class . ' srf-redirect' . ' ': $class;
		$class = $this->params['class'] ? $class . ' ' . $this->params['class'] : $class ;

		// Separate content from result output
		if ( !$ig->isEmpty() ) {
			$attribs = array (
				'class'  => 'srf-gallery' . $class,
				'align'  => 'justify',
				'data-redirect-type' => $redirectType
			);

			$html = Html::rawElement( 'div', $attribs, $processing . $ig->toHTML() );
		}

		// If available, create a link that points to further results
		if ( $this->linkFurtherResults( $results ) ) {
			$html .= $this->getLink( $results, SMW_OUTPUT_HTML )->getText( SMW_OUTPUT_HTML, $this->mLinker );
		}

		return array( $html, 'nowiki' => true, 'isHTML' => true );
	}

	/**
	 * Handles queries where the images (and optionally their captions) are specified as properties.
	 *
	 * @since 1.5.3
	 *
	 * @param SMWQueryResult $results
	 * @param ImageGallery $ig
	 * @param string $imageProperty
	 * @param string $captionProperty
	 * @param string $redirectProperty
	 * @param $outputMode
	 */
	protected function addImageProperties( SMWQueryResult $results, ImageGallery &$ig, $imageProperty, $captionProperty, $redirectProperty, $outputMode ) {
		while ( /* array of SMWResultArray */ $rows = $results->getNext() ) { // Objects (pages)
			$images = array();
			$captions = array();
			$redirects = array();

			for ( $i = 0, $n = count( $rows ); $i < $n; $i++ ) { // Properties
				/**
				 * @var SMWResultArray $resultArray
				 * @var SMWDataValue $dataValue
				 */
				$resultArray = $rows[$i];

				$label = $resultArray->getPrintRequest()->getMode() == SMWPrintRequest::PRINT_THIS
					? '-' : $resultArray->getPrintRequest()->getLabel();

				// Make sure always use real label here otherwise it results in an empty array
				if ( $resultArray->getPrintRequest()->getLabel() == $imageProperty ) {
					while ( ( $dataValue = $resultArray->getNextDataValue() ) !== false ) { // Property values
						if ( $dataValue->getTypeID() == '_wpg' ) {
							$images[] = $dataValue->getTitle();
						}
					}
				} elseif ( $label == $captionProperty ) {
					while ( ( $dataValue = $resultArray->getNextDataValue() ) !== false ) { // Property values
						$captions[] = $dataValue->getShortText( $outputMode, $this->getLinker( true ) );
					}
				} elseif ( $label == $redirectProperty ) {
					while ( ( $dataValue = $resultArray->getNextDataValue() ) !== false ) { // Property values
						if ( $dataValue->getDataItem()->getDIType() == SMWDataItem::TYPE_WIKIPAGE ) {
							$redirects[] = $dataValue->getTitle();
						} elseif ( $dataValue->getDataItem()->getDIType() == SMWDataItem::TYPE_URI  ) {
						  $redirects[] = $dataValue->getURL();
						}
					}
				}
			}

			// Check available matches against captions
			$amountMatches = count( $captions ) == count( $images );
			$hasCaption = $amountMatches || count( $captions ) > 0;

			// Check available matches against redirects
			$amountRedirects = count( $redirects ) == count( $images );
			$hasRedirect = $amountRedirects || count( $redirects ) > 0;

			/**
			 * @var Title $imgTitle
			 */
			foreach ( $images as $imgTitle ) {
				if ( $imgTitle->exists() ) {
					$imgCaption = $hasCaption ? ( $amountMatches ? array_shift( $captions ) : $captions[0] ) : '';
					$imgRedirect = $hasRedirect ? ( $amountRedirects ? array_shift( $redirects ) : $redirects[0] ) : '';
					$this->addImageToGallery( $ig, $imgTitle, $imgCaption, $imgRedirect );
				}
			}
		}
	}

	/**
	 * Handles queries where the result objects are image pages.
	 *
	 * @since 1.5.3
	 *
	 * @param SMWQueryResult $results
	 * @param ImageGallery $ig
	 */
	protected function addImagePages( SMWQueryResult $results, ImageGallery &$ig ) {
		while ( $row = $results->getNext() ) {
			/**
			 * @var SMWResultArray $firstField
			 */
			$firstField = $row[0];
			$nextObject = $firstField->getNextDataValue();

			if ( $nextObject !== false ) {
				$imgTitle = $nextObject->getTitle();

				// Ensure the title belongs to the image namespace
				if ( $imgTitle instanceof Title && $imgTitle->getNamespace() === NS_FILE ) {
					$imgCaption = '';

					// Is there a property queried for display with ?property
					if ( isset( $row[1] ) ) {
						$imgCaption = $row[1]->getNextDataValue();
						if ( is_object( $imgCaption ) ) {
							$imgCaption = $imgCaption->getShortText( SMW_OUTPUT_HTML, $this->getLinker( true ) );
						}
					}

					$this->addImageToGallery( $ig, $imgTitle, $imgCaption );
				}
			}
		}
	}

	/**
	 * Adds a single image to the gallery.
	 * Takes care of automatically adding a caption when none is provided and parsing it's wikitext.
	 *
	 * @since 1.5.3
	 *
	 * @param ImageGallery $ig The gallery to add the image to
	 * @param Title $imgTitle The title object of the page of the image
	 * @param string $imgCaption An optional caption for the image
	 */
	protected function addImageToGallery( ImageGallery &$ig, Title $imgTitle, $imgCaption, $imgRedirect = '' ) {

		if ( empty( $imgCaption ) ) {
			if ( $this->m_params['autocaptions'] ) {
				$imgCaption = $imgTitle->getBaseText();

				if ( !$this->m_params['fileextensions'] ) {
					$imgCaption = preg_replace( '#\.[^.]+$#', '', $imgCaption );
				}
			} else {
				$imgCaption = '';
			}
		} else {
			if ( $imgTitle instanceof Title && $imgTitle->getNamespace() == NS_FILE && !$this->isSpecialPage() ) {
				$imgCaption = $GLOBALS['wgParser']->recursiveTagParse( $imgCaption );
			}
		}
		// Use image alt as helper for either text
		$imgAlt =  $this->params['redirects'] === '' ? $imgCaption : $imgRedirect !== '' ? $imgRedirect : '' ;
		$ig->add( $imgTitle, $imgCaption, $imgAlt );
	}

	/**
	 * Checks if a page is a SpecialPage
	 *
	 * @since 1.8
	 *
	 * @return boolean
	 */
	private function isSpecialPage() {
		// @todo global: use getContext->getTitle()->->isSpecialPage() instead
		return $GLOBALS['wgTitle']->isSpecialPage();
	}

	/**
	 * Returns the overlay setting
	 *
	 * @since 1.8
	 *
	 * @return string
	 */
	private function getImageOverlay() {
		if ( array_key_exists( 'overlay', $this->params ) && $this->params['overlay'] == true ) {
			SMWOutputs::requireResource( 'ext.srf.gallery.overlay' );
			return ' srf-overlay';
		} else {
			return '';
		}
	}

	/**
	 * Init carousel widget
	 *
	 * @since 1.8
	 *
	 * @return string
	 */
	private function getCarouselWidget() {

		// Set attributes for jcarousel
		$dataAttribs = array(
			'wrap' => 'both', // Whether to wrap at the first/last item (or both) and jump back to the start/end.
			'vertical' => 'false', // Orientation: vertical = false means horizontal
			'rtl' => 'false', // Directionality: rtl = false means ltr
		);

		// Use the perrow parameter to determine the scroll sequence.
		if ( empty( $this->params['perrow'] ) ) {
			$dataAttribs['scroll'] = 1;  // default 1
		} else {
			$dataAttribs['scroll'] = $this->params['perrow'];
			$dataAttribs['visible'] = $this->params['perrow'];
		}

		$attribs = array(
			'id' => uniqid(),
			'class' => 'jcarousel jcarousel-skin-smw' . $this->getImageOverlay(),
			'style' => 'display:none;',
		);

		foreach ( $dataAttribs as $name => $value ) {
			$attribs['data-' . $name] = $value;
		}

		SMWOutputs::requireResource( 'ext.srf.gallery.carousel' );

		return $attribs;
	}


	/**
	 * Init slideshow widget
	 *
	 * @since 1.8
	 *
	 * @return string
	 */
	private function getSlideshowWidget() {

		$attribs = array(
			'id'    => uniqid(),
			'class' => $this->getImageOverlay(),
			'style' => 'display:none;',
			'data-nav-control' => $this->params['navigation']
		);

		SMWOutputs::requireResource( 'ext.srf.gallery.slideshow' );

		return $attribs;
	}

	/**
	 * @see SMWResultPrinter::getParamDefinitions
	 *
	 * @since 1.8
	 *
	 * @param $definitions array of IParamDefinition
	 *
	 * @return array of IParamDefinition|array
	 */
	public function getParamDefinitions( array $definitions ) {
		$params = parent::getParamDefinitions( $definitions );

		$params['class'] = array(
			'type' => 'string',
			'message' => 'srf-paramdesc-class',
			'default' => ''
		);

		$params['widget'] = array(
			'type' => 'string',
			'default' => '',
			'message' => 'srf-paramdesc-widget',
			'values' => array( 'carousel', 'slideshow', '' )
		);

		$params['navigation'] = array(
			'type' => 'string',
			'default' => 'nav',
			'message' => 'srf-paramdesc-navigation',
			'values' => array( 'nav', 'pager', 'auto' )
		);

		$params['overlay'] = array(
			'type' => 'boolean',
			'default' => false,
			'message' => 'srf-paramdesc-overlay'
		);

		$params['perrow'] = array(
			'type' => 'integer',
			'default' => '',
			'message' => 'srf_paramdesc_perrow'
		);

		$params['widths'] = array(
			'type' => 'integer',
			'default' => '',
			'message' => 'srf_paramdesc_widths'
		);

		$params['heights'] = array(
			'type' => 'integer',
			'default' => '',
			'message' => 'srf_paramdesc_heights'
		);

		$params['autocaptions'] = array(
			'type' => 'boolean',
			'default' => true,
			'message' => 'srf_paramdesc_autocaptions'
		);

		$params['fileextensions'] = array(
			'type' => 'boolean',
			'default' => false,
			'message' => 'srf_paramdesc_fileextensions'
		);

		$params['captionproperty'] = array(
			'type' => 'string',
			'default' => '',
			'message' => 'srf_paramdesc_captionproperty'
		);

		$params['imageproperty'] = array(
			'type' => 'string',
			'default' => '',
			'message' => 'srf_paramdesc_imageproperty'
		);

		$params['redirects'] = array(
			'type' => 'string',
			'default' => '',
			'message' => 'srf-paramdesc-redirects'
		);

		return $params;
	}
}
