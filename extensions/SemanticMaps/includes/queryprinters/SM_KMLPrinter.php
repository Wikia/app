<?php

/**
 * SMWResultPrinter class for printing a query result as KML.
 *
 * @since 0.7.3
 *
 * @file SM_KMLPrinter.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SMKMLPrinter extends SMWExportPrinter {

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
			return $this->getKMLLink( $res, $outputmode );
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
		$this->params = $params;
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

		$params['pagelinktext'] = new Parameter( 'pagelinktext', Parameter::TYPE_STRING, wfMessage( 'semanticmaps-default-kml-pagelink' )->text() );
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
		$queryHandler = new SMQueryHandler( $res, $outputmode, $this->params['linkabsolute'], $this->params['pagelinktext'], false );
		$queryHandler->setText( $this->params['text'] );
		$queryHandler->setTitle( $this->params['title'] );
		$queryHandler->setSubjectSeparator( '' );

		$formatter = new MapsKMLFormatter( $this->params );
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
	protected function getKMLLink( SMWQueryResult $res, $outputmode ) {
		$searchLabel = $this->getSearchLabel( $outputmode );
		$link = $res->getQueryLink( $searchLabel ? $searchLabel : wfMessage( 'semanticmaps-kml-link' )->inContentLanguage()->text() );
		$link->setParameter( 'kml', 'format' );
		$link->setParameter( $this->params['linkabsolute'] ? 'yes' : 'no', 'linkabsolute' );
		$link->setParameter( $this->params['pagelinktext'], 'pagelinktext' );

		if ( $this->params['title'] !== '' ) {
			$link->setParameter( $this->params['title'], 'title' );
		}

		if ( $this->params['text'] !== '' ) {
			$link->setParameter( $this->params['text'], 'text' );
		}

		if ( array_key_exists( 'limit', $this->params ) ) {
			$link->setParameter( $this->params['limit'], 'limit' );
		} else { // Use a reasonable default limit.
			$link->setParameter( 20, 'limit' );
		}

		$this->isHTML = ( $outputmode == SMW_OUTPUT_HTML );

		return $link->getText( $outputmode, $this->mLinker );
	}

	/**
	 * @see SMWIExportPrinter::getMimeType
	 *
	 * @since 2.0
	 *
	 * @param SMWQueryResult $queryResult
	 *
	 * @return string
	 */
	public function getMimeType( SMWQueryResult $queryResult ) {
		return 'application/vnd.google-earth.kml+xml';
	}

	/**
	 * @see SMWIExportPrinter::getFileName
	 *
	 * @since 2.0
	 *
	 * @param SMWQueryResult $queryResult
	 *
	 * @return string|boolean
	 */
	public function getFileName( SMWQueryResult $queryResult ) {
		return 'kml.kml';
	}

	/**
	 * @see SMWResultPrinter::getName()
	 */
	public final function getName() {
		return wfMessage( 'semanticmaps-kml' )->text();
	}
}
