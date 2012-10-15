<?php

/**
 * Result printer that prints query results as a tag cloud.
 * 
 * @since 1.5.3
 * 
 * @file SRF_TagCloud.php
 * @ingroup SemanticResultFormats
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SRFTagCloud extends SMWResultPrinter {

	protected $includeName;
	protected $sizeMode;
	protected $tagOrder;
	protected $minCount;
	protected $maxSize;
	protected $maxTags;
	protected $minTagSize;	
	
	protected $tagsHtml = array();
	
	public function getName() {
		return wfMsg( 'srf_printername_tagcloud' );
	}
	
	/**
	 * @see SMWResultPrinter::handleParameters
	 * 
	 * @since 1.6
	 * 
	 * @param array $params
	 * @param $outputmode
	 */
	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
		
		$this->includeName = $params['includesubject'];
		$this->sizeMode = $params['increase'];
		$this->tagOrder = $params['tagorder'];
		$this->minCount = $params['mincount'];
		$this->maxTags = $params['maxtags'];
		$this->minTagSize = $params['minsize'];
		$this->maxSize = $params['maxsize'];
	}

	public function getResultText( SMWQueryResult $results, $outputmode ) {
		$this->isHTML = $outputmode == SMW_OUTPUT_HTML;
		return $this->getTagCloud( $this->getTagSizes( $this->getTags( $results, $outputmode ) ) );
	}
	
	/**
	 * Returns an array with the tags (keys) and the number of times they occur (values).
	 * 
	 * @since 1.5.3
	 * 
	 * @param SMWQueryResult $results
	 * @param $outputmode
	 * 
	 * @return array
	 */
	protected function getTags( SMWQueryResult $results, $outputmode ) {
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
	 * @since 1.5.3
	 * 
	 * @param array $tags
	 * 
	 * @return array
	 */	
	protected function getTagSizes( array $tags ) {
		if ( count( $tags ) == 0 ) {
			return $tags;
		}		
		
		// If the original order needs to be kept, we need a copy of the current order.
		if ( $this->tagOrder == 'unchanged' ) {
			$unchangedTags = array_keys( $tags );
		}
		
		arsort( $tags, SORT_NUMERIC );
		
		if ( count( $tags ) > $this->maxTags ) {
			$tags = array_slice( $tags, 0, $this->maxTags, true );
		}
	
		$min = end( $tags ) or $min = 0;
		$max = reset( $tags ) or $max = 1;
		$maxSizeIncrease = $this->maxSize - $this->minTagSize;
		
		// Loop over the tags, and replace their count by a size.
		foreach ( $tags as &$tag ) {
			switch ( $this->sizeMode ) {
				case 'linear':
					$divisor = ($max == $min) ? 1 : $max - $min;
					$tag = $this->minTagSize + $maxSizeIncrease * ( $tag -$min ) / $divisor;
					break;
				case 'log' : default :
					$divisor = ($max == $min) ? 1 : log( $max ) - log( $min );
					$tag = $this->minTagSize + $maxSizeIncrease * ( log( $tag ) - log( $min ) ) / $divisor ;
					break;
			}
		}

		switch ( $this->tagOrder ) {
			case 'desc' :
				// Tags are already sorted desc
				break;
			case 'asc' :
				asort( $tags );
				break;
			case 'alphabetical' :
				$tagNames = array_keys( $tags );
				natcasesort( $tagNames );
				$newTags = array();
				
				foreach ( $tagNames as $name ) {
					$newTags[$name] = $tags[$name];
				}
				
				$tags = $newTags;
				break;
			case 'random' :
				$tagSizes = $tags;
				shuffle( $tagSizes );
				$newTags = array();
				
				foreach ( $tagSizes as $size ) {
					foreach ( $tags as $tagName => $tagSize ) {
						if ( $tagSize == $size ) {
							$newTags[$tagName] =  $tags[$tagName];
							break;
						}
					}
				}
				
				$tags = $newTags;
				break;	
			case 'unchanged' : default : // Restore the original order.
				$changedTags = $tags;
				$tags = array();
				
				foreach ( $unchangedTags as $name ) {
					// Original tags might have been left out at this point, so only add remaining ones.
					if ( array_key_exists( $name, $changedTags ) ) {
						$tags[$name] = $changedTags[$name];
					}
				}			
				break;
		}		
		
		return $tags;
	}	
	
	/**
	 * Returns the HTML for the tag cloud.
	 * 
	 * @since 1.5.3
	 * 
	 * @param array $tags
	 * 
	 * @return string
	 */
	protected function getTagCloud( array $tags ) {
		$htmlTags = array();

		foreach ( $tags as $name => $size ) {
			$htmlTags[] = Html::rawElement(
				'span',
				array( 'style' => "font-size:$size%" ),
				$this->tagsHtml[$name]
			);
		}
		
		return Html::rawElement(
			'div',
			array( 'align' => 'justify' ),
			implode( ' ', $htmlTags )
		);
	}
	
	/**
	 * @see SMWResultPrinter::getParameters
	 * 
	 * @since 1.5.3
	 * 
	 * @return array
	 */	
	public function getParameters() {
		$params = parent::getParameters();
		
		$params['includesubject'] = new Parameter( 'includesubject', Parameter::TYPE_BOOLEAN );
		$params['includesubject']->setMessage( 'srf_paramdesc_includesubject' );
		$params['includesubject']->setDefault( false );
		
		$params['increase'] = new Parameter( 'increase' );
		$params['increase']->setMessage( 'srf_paramdesc_increase' );
		$params['increase']->addCriteria( new CriterionInArray( 'linear', 'log' ) );
		$params['increase']->setDefault( 'log' );
		
		$params['tagorder'] = new Parameter( 'tagorder' );
		$params['tagorder']->setMessage( 'srf_paramdesc_tagorder' );
		$params['tagorder']->addCriteria( new CriterionInArray( 'alphabetical', 'asc', 'desc', 'random', 'unchanged' ) );
		$params['tagorder']->setDefault( 'alphabetical' );
		
		$params['mincount'] = new Parameter( 'mincount', Parameter::TYPE_INTEGER );
		$params['mincount']->setMessage( 'srf_paramdesc_mincount' );
		$params['mincount']->setDefault( 1 );
		
		$params['maxtags'] = new Parameter( 'maxtags', Parameter::TYPE_INTEGER );
		$params['maxtags']->setMessage( 'srf_paramdesc_maxtags' );
		$params['maxtags']->setDefault( 1000 );

		$params['minsize'] = new Parameter( 'minsize', Parameter::TYPE_INTEGER );
		$params['minsize']->setMessage( 'srf_paramdesc_minsize' );
		$params['minsize']->setDefault( 77 );

		$params['maxsize'] = new Parameter( 'maxsize', Parameter::TYPE_INTEGER );
		$params['maxsize']->setMessage( 'srf_paramdesc_maxsize' );
		$params['maxsize']->setDefault( 242 );
		
		return $params;
	}	
	
}
