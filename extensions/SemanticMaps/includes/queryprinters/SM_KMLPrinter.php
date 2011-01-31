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
	 * Handler of the print request.
	 *
	 * @since 0.7.3
	 *
	 * @param SMWQueryResult $res
	 * @param $outputmode
	 * 
	 * @return array
	 */
	public function getResultText( /* SMWQueryResult */ $res, $outputmode ) {
		$validator = new Validator( $this->getName(), false );

		$validator->setParameters( $this->m_params, $this->getParameterInfo() );
		
		$validator->validateParameters();
		
		$fatalError  = $validator->hasFatalError();		
		
		if ( $fatalError !== false ) {
			return '<span class="errorbox">' .
				htmlspecialchars( wfMsgExt( 'validator-fatal-error', 'parsemag', $fatalError->getMessage() ) ) . 
				'</span>';
		}
		
		$params = $validator->getParameterValues();

		if ( $outputmode == SMW_OUTPUT_FILE ) {
			return $this->getKML( $res, $outputmode, $params );
		}
		else {
			return $this->getLink( $res, $outputmode, $params );
		}
	}
	
	/**
	 * Returns a list of parameter definitions.
	 * 
	 * @since 0.7.4
	 * 
	 * @return array
	 */
	protected function getParameterInfo() {
		$params = array();
		
		$params[] = new Parameter( 'linkpage', Parameter::TYPE_BOOLEAN, true );
		
		$params[] = new Parameter( 'linkpropnames', Parameter::TYPE_BOOLEAN, false );
		$params[] = new Parameter( 'linkpropvalues', Parameter::TYPE_BOOLEAN, false );
		
		$params[] = new Parameter( 'linkabsolute', Parameter::TYPE_BOOLEAN, true );
		
		$params['pagelinktext'] = new Parameter( 'pagelinktext', Parameter::TYPE_STRING, wfMsg( 'semanticmaps-default-kml-pagelink' ) );

		return $params;
	}
	
	/**
	 * Returns the KML for the query result.
	 * 
	 * @since 0.7.3
	 * 
	 * @param SMWQueryResult $res
	 * @param integer $outputmode
	 * @param array $params
	 * 
	 * @return string
	 */
	protected function getKML( SMWQueryResult $res, $outputmode, array $params ) {
		$queryHandler = new SMQueryHandler( $res, $outputmode, $params );
		$locations = $queryHandler->getLocations();
		
		$formatter = new MapsKMLFormatter( $params );
		$formatter->addPlacemarks( $locations );
		
		return $formatter->getKML();
	}
	
	/**
	 * Returns a link (HTML) pointing to a query that returns the actual KML file.
	 * 
	 * @since 0.7.3
	 * 
	 * @param SMWQueryResult $res
	 * @param integer $outputmode
	 * @param array $params
	 * 
	 * @return string
	 */	
	protected function getLink( SMWQueryResult $res, $outputmode, array $params ) {
		$searchLabel = $this->getSearchLabel( $outputmode );
		$link = $res->getQueryLink( $searchLabel ? $searchLabel : wfMsgForContent( 'semanticmaps-kml-link' ) );
		$link->setParameter( 'kml', 'format' );
		
		$link->setParameter( $params['linkpage'] ? 'yes' : 'no', 'linkpage' );
		$link->setParameter( $params['linkpropnames'] ? 'yes' : 'no', 'linkpropnames' );
		$link->setParameter( $params['linkpropvalues'] ? 'yes' : 'no', 'linkpropvalues' );
		$link->setParameter( $params['linkabsolute'] ? 'yes' : 'no', 'linkabsolute' );
		
		$link->setParameter( $params['pagelinktext'], 'pagelinktext' );
		
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
		// TODO
		return 'kml.kml';
	}
	
	/**
	 * @see SMWResultPrinter::getName()
	 */
	public final function getName() {
		return wfMsg( 'semanticmaps-kml' );
	}
	
}
