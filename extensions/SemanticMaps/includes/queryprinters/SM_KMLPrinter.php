<?php

/**
 * SMWResultPrinter class for printing a query result as KML.
 *
 * @since 0.7.3
 *
 * @file SM_KMLPrinter.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw
 */
class SMKMLPrinter extends SMWResultPrinter {
	/**
	 * Constructor.
	 *
	 * @param $format String
	 * @param $inline
	 */
	public function __construct( $format, $inline ) {
		parent::__construct( $format, $inline );
		$this->useValidator = true;
	}

	/**
	 * Handler of the print request.
	 *
	 * @since 0.7.3
	 *
	 * @param SMWQueryResult $res
	 * @param $outputmode
	 *
	 * @return array
	 */
	public function getResultText( SMWQueryResult $res, $outputmode ) {
		if ( $outputmode == SMW_OUTPUT_FILE ) {
			return $this->getKML( $res, $outputmode );
		}
		else {
			return $this->getLink( $res, $outputmode );
		}
	}

	/**
	 * @see SMWResultPrinter::handleParameters
	 *
	 * @since 1.0
	 *
	 * @param array $params
	 * @param $outputmode
	 */
	protected function handleParameters( array $params, $outputmode ) {
		$this->m_params = $params;
	}

	/**
	 * Returns a list of parameter definitions.
	 *
	 * @since 0.7.4
	 *
	 * @return array
	 */
	public function getParameters() {
		global $egMapsDefaultLabel, $egMapsDefaultTitle;

		$params = array_merge( parent::getParameters(), $this->exportFormatParameters() );

		$params['text'] = new Parameter( 'text', Parameter::TYPE_STRING, $egMapsDefaultLabel );
		$params['text']->setMessage( 'semanticmaps-kml-text' );

		$params['title'] = new Parameter( 'title', Parameter::TYPE_STRING, $egMapsDefaultTitle );
		$params['title']->setMessage( 'semanticmaps-kml-title' );

		$params['linkabsolute'] = new Parameter( 'linkabsolute', Parameter::TYPE_BOOLEAN, true );
		$params['linkabsolute']->setMessage( 'semanticmaps-kml-linkabsolute' );

		$params['pagelinktext'] = new Parameter( 'pagelinktext', Parameter::TYPE_STRING, wfMsg( 'semanticmaps-default-kml-pagelink' ) );
		$params['pagelinktext']->setMessage( 'semanticmaps-kml-pagelinktext' );
		
		return $params;
	}

	/**
	 * Returns the KML for the query result.
	 *
	 * @since 0.7.3
	 *
	 * @param SMWQueryResult $res
	 * @param integer $outputmode
	 *
	 * @return string
	 */
	protected function getKML( SMWQueryResult $res, $outputmode ) {
		$queryHandler = new SMQueryHandler( $res, $outputmode, $this->m_params['linkabsolute'], $this->m_params['pagelinktext'], false );
		$queryHandler->setText( $this->m_params['text'] );
		$queryHandler->setTitle( $this->m_params['title'] );
		$queryHandler->setSubjectSeparator( '' );

		$formatter = new MapsKMLFormatter( $this->m_params );
		$formatter->addPlacemarks( $queryHandler->getLocations() );

		return $formatter->getKML();
	}

	/**
	 * Returns a link (HTML) pointing to a query that returns the actual KML file.
	 *
	 * @since 0.7.3
	 *
	 * @param SMWQueryResult $res
	 * @param integer $outputmode
	 *
	 * @return string
	 */
	protected function getLink( SMWQueryResult $res, $outputmode ) {
		$searchLabel = $this->getSearchLabel( $outputmode );
		$link = $res->getQueryLink( $searchLabel ? $searchLabel : wfMsgForContent( 'semanticmaps-kml-link' ) );
		$link->setParameter( 'kml', 'format' );
		$link->setParameter( $this->m_params['linkabsolute'] ? 'yes' : 'no', 'linkabsolute' );
		$link->setParameter( $this->m_params['pagelinktext'], 'pagelinktext' );
		
		if ( $this->m_params['title'] !== '' ) {
			$link->setParameter( $this->m_params['title'], 'title' );
		}
		
		if ( $this->m_params['text'] !== '' ) {
			$link->setParameter( $this->m_params['text'], 'text' );
		}

		if ( array_key_exists( 'limit', $this->m_params ) ) {
			$link->setParameter( $this->m_params['limit'], 'limit' );
		} else { // Use a reasonable default limit.
			$link->setParameter( 20, 'limit' );
		}

		$this->isHTML = ( $outputmode == SMW_OUTPUT_HTML );

		return $link->getText( $outputmode, $this->mLinker );
	}

	/**
	 * @see SMWResultPrinter::getMimeType()
	 */
	public function getMimeType( $res ) {
		return 'application/vnd.google-earth.kml+xml';
	}

	/**
	 * @see SMWResultPrinter::getFileName()
	 */
	public function getFileName( $res ) {
		// @TODO FIXME
		return 'kml.kml';
	}

	/**
	 * @see SMWResultPrinter::getName()
	 */
	public final function getName() {
		return wfMsg( 'semanticmaps-kml' );
	}
}
