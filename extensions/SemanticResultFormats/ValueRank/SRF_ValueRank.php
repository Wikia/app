<?php

/**
 * Result printer that prints query results as a valuerank.
 * In other words, it prints a list of all occuring values, with duplicates removed,
 * together with their occurance count.
 * 
 * For example, this result set: foo bar baz foo bar bar ohi 
 * Will be turned into
 * * bar (3)
 * * foo (2)
 * * baz (1)
 * * ohi (1)
 * 
 * @since 1.7
 * 
 * @file SRF_ValueRank.php
 * @ingroup SemanticResultFormats
 * 
 * @licence GNU GPL v3
 * @author DaSch < dasch@daschmedia.de >
 * build out of Tag Cloud Format by Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SRFValueRank extends SMWResultPrinter {

	protected $includeName;
	protected $minCount;
	protected $maxTags;
	
	protected $tagsHtml = array();
	
	public function getName() {
		return wfMsg( 'srf_printername_valuerank' );
	}
	
	/**
	 * @see SMWResultPrinter::handleParameters
	 * 
	 * @since 1.7
	 * 
	 * @param array $params
	 * @param $outputmode
	 */
	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
		
		$this->includeName = $params['includesubject'];
		$this->minCount = $params['mincount'];
		$this->maxTags = $params['maxtags'];
	}

	public function getResultText( SMWQueryResult $results, $outputmode ) {
		$this->isHTML = $outputmode == SMW_OUTPUT_HTML;
		return $this->getVRValueRank( $this->getVRRank( $this->getVRValues( $results, $outputmode ) ) );
	}
	
	/**
	 * Returns an array with the tags (keys) and the number of times they occur (values).
	 * 
	 * @since 1.7
	 * 
	 * @param SMWQueryResult $results
	 * @param $outputmode
	 * 
	 * @return array
	 */
	protected function getVRValues( SMWQueryResult $results, $outputmode ) {
		$tags = array();
		
		while ( /* array of SMWResultArray */ $row = $results->getNext() ) { // Objects (pages)
			for ( $i = 0, $n = count( $row ); $i < $n; $i++ ) { // SMWResultArray for a sinlge property 
				while ( ( /* SMWDataValue */ $dataValue = $row[$i]->getNextDataValue() ) !== false ) { // Data values
					
					$isSubject = $row[$i]->getPrintRequest()->getMode() == SMWPrintRequest::PRINT_THIS;
					
					// If the main object should not be included, skip it.
					if ( $i == 0 && !$this->includeName && $isSubject ) {
						continue;
					}
					
					// Get the HTML for the tag content. Pages are linked, other stuff is just plaintext.
					if ( $dataValue->getTypeID() == '_wpg' ) {
						$value = $dataValue->getTitle()->getText();
						$html = $dataValue->getLongText( $outputmode, $this->getLinker( $isSubject ) );
					}
					else {
						$html = $dataValue->getShortText( $outputmode, $this->getLinker( false ) );
						$value = $html;
					}

					if ( !array_key_exists( $value, $tags ) ) {
						$tags[$value] = 0;
						$this->tagsHtml[$value] = $html; // Store the HTML separetely, so sorting can be done easily.
					}
					
					$tags[$value]++;
				}
			}
		}
		
		foreach ( $tags as $name => $count ) {
			if ( $count < $this->minCount ) {
				unset( $tags[$name] );
			}
		}
		return $tags;
	}
	
	/**
	 * Determines the sizes of tags.
	 * This method is based on code from the FolkTagCloud extension by Katharina Wäschle.
	 * 
	 * @since 1.7
	 * 
	 * @param array $tags
	 * 
	 * @return array
	 */	
	protected function getVRRank( array $tags ) {
		if ( count( $tags ) == 0 ) {
			return $tags;
		}
		
		arsort( $tags, SORT_NUMERIC );
		
		if ( count( $tags ) > $this->maxTags ) {
			$tags = array_slice( $tags, 0, $this->maxTags, true );
		}
		
		return $tags;
	}
	
	/**
	 * Returns the HTML for the tag cloud.
	 * 
	 * @since 1.7
	 * 
	 * @param array $tags
	 * 
	 * @return string
	 */
	protected function getVRValueRank( array $tags ) {
		$htmlTags = array();

		foreach ( $tags as $name => $size ) {
			$htmlTags[] = Html::rawElement(
				'li',
				array( 'style' => "font-size:$size" ),
				$this->tagsHtml[$name] . '&nbsp;(' . $size . ')'
			);
		}
		
		return Html::rawElement(
			'ol',
			array( 'align' => 'left' ),
			implode( ' ', $htmlTags )
		);
	}
	
	/**
	 * @see SMWResultPrinter::getParameters
	 * 
	 * @since 1.7
	 * 
	 * @return array
	 */	
	public function getParameters() {
		$params = parent::getParameters();
		
		$params['includesubject'] = new Parameter( 'includesubject', Parameter::TYPE_BOOLEAN );
		$params['includesubject']->setMessage( 'srf_paramdesc_includesubject' );
		$params['includesubject']->setDefault( false );
		
		$params['mincount'] = new Parameter( 'mincount', Parameter::TYPE_INTEGER );
		$params['mincount']->setMessage( 'srf_paramdesc_mincount' );
		$params['mincount']->setDefault( 1 );
		
		$params['maxtags'] = new Parameter( 'maxtags', Parameter::TYPE_INTEGER );
		$params['maxtags']->setMessage( 'srf_paramdesc_maxtags' );
		$params['maxtags']->setDefault( 1000 );
		
		return $params;
	}
	
}
