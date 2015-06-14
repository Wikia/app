<?php

/**
 * Result printer that prints query results as a tag cloud
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
 * @since 1.5.3
 *
 * @file SRF_TagCloud.php
 * @ingroup SemanticResultFormats
 *
 * @licence GNU GPL v2 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author mwjames
 */
class SRFTagCloud extends SMWResultPrinter {

	protected $tagsHtml = array();

	/**
	 * Get a human readable label for this printer.
	 *
	 * @return string
	 */
	public function getName() {
		return wfMessage( 'srf_printername_tagcloud' )->text();
	}

	/**
	 * Return serialised results in specified format
	 *
	 * @param SMWQueryResult $results
	 * @param $outputmode
	 *
	 * @return string
	 */
	public function getResultText( SMWQueryResult $results, $outputmode ) {

		// Check output conditions
		if ( ( $this->params['widget'] == 'sphere' ) &&
			( $this->params['link'] !== 'all' ) &&
			( $this->params['template'] === '' ) ) {
			return $results->addErrors( array( wfMessage( 'srf-error-option-link-all', 'sphere' )->inContentLanguage()->text() ) );
		}

		// Template support
		$this->hasTemplates = $this->params['template'] !== '';

		// Prioritize HTML setting
		$this->isHTML = $this->params['widget'] !== '';
		$this->isHTML = $this->params['template'] === '';

		$outputmode = SMW_OUTPUT_HTML;

		// Sphere widget
		if ( $this->params['widget'] === 'sphere' ){
			SMWOutputs::requireResource( 'ext.srf.tagcloud.sphere' );
		}

		// Wordcloud widget
		if ( $this->params['widget'] === 'wordcloud' ){
			SMWOutputs::requireResource( 'ext.srf.tagcloud.wordcloud' );
		}

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
		$tags        = array();
		$excludetags = explode( ';', $this->params['excludetags'] );

		while ( /* array of SMWResultArray */ $row = $results->getNext() ) { // Objects (pages)
			for ( $i = 0, $n = count( $row ); $i < $n; $i++ ) { // SMWResultArray for a sinlge property

				/**
				 * @var SMWDataValue $dataValue
				 */
				while ( ( $dataValue = $row[$i]->getNextDataValue() ) !== false ) { // Data values

					$isSubject = $row[$i]->getPrintRequest()->getMode() == SMWPrintRequest::PRINT_THIS;

					// If the main object should not be included, skip it.
					if ( $i == 0 && !$this->params['includesubject'] && $isSubject ) {
						continue;
					}

					// Get the HTML for the tag content. Pages are linked, other stuff is just plaintext.
					if ( $dataValue->getTypeID() == '_wpg' ) {
						$value = $dataValue->getTitle()->getText();
						$html = $dataValue->getLongText( $outputmode, $this->getLinker( $isSubject ) );
					} else {
						$html = $dataValue->getShortText( $outputmode, $this->getLinker( false ) );
						$value = $html;
					}

					// Exclude tags from result set
					if ( in_array( $value, $excludetags ) ) {
						continue;
					}

					// Replace content with template inclusion
					$html = $this->params['template'] !== '' ? $this->addTemplateOutput ( $value , $rownum ) : $html;

					if ( !array_key_exists( $value, $tags ) ) {
						$tags[$value] = 0;
						$this->tagsHtml[$value] = $html; // Store the HTML separetely, so sorting can be done easily.
					}

					$tags[$value]++;
				}
			}
		}

		foreach ( $tags as $name => $count ) {
			if ( $count < $this->params['mincount'] ) {
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
		if ( $this->params['tagorder'] == 'unchanged' ) {
			$unchangedTags = array_keys( $tags );
		}

		arsort( $tags, SORT_NUMERIC );

		if ( count( $tags ) > $this->params['maxtags'] ) {
			$tags = array_slice( $tags, 0, $this->params['maxtags'], true );
		}

		$min = end( $tags ) or $min = 0;
		$max = reset( $tags ) or $max = 1;
		$maxSizeIncrease = $this->params['maxsize'] - $this->params['minsize'];

		// Loop over the tags, and replace their count by a size.
		foreach ( $tags as &$tag ) {
			switch ( $this->params['increase'] ) {
				case 'linear':
					$divisor = ($max == $min) ? 1 : $max - $min;
					$tag = $this->params['minsize'] + $maxSizeIncrease * ( $tag - $min ) / $divisor;
					break;
				case 'log' : default :
					$divisor = ($max == $min) ? 1 : log( $max ) - log( $min );
					$tag = $this->params['minsize'] + $maxSizeIncrease * ( log( $tag ) - log( $min ) ) / $divisor ;
					break;
			}
		}

		switch ( $this->params['tagorder'] ) {
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

		// Initialize
		static $statNr = 0;
		$htmlTags      = array();
		$processing    = '';
		$htmlSTags     = '';
		$htmlCTags     = '';

		// Count actual output and store div identifier
		$tagID = $this->params['widget'] . '-' . ++$statNr;

		// Determine HTML element marker
		$element = $this->params['widget'] !== '' ? 'li' : 'span';

		// Add size information
		foreach ( $tags as $name => $size ) {
			$htmlTags[] = Html::rawElement( $element, array (
				'style' => "font-size:$size%" ),
				$this->tagsHtml[$name]
			);
		}

		// Stringify
		$htmlSTags = implode( ' ', $htmlTags );

		// Handle sphere/canvas output objects
		if ( in_array( $this->params['widget'], array( 'sphere', 'wordcloud' ) ) ) {

			// Wrap LI/UL elements
			$htmlCTags = Html::rawElement( 'ul', array (
				'style' => 'display:none;'
				), $htmlSTags
			);

			// Wrap tags
			$htmlCTags = Html::rawElement( 'div', array (
				'id' => $tagID . '-tags'
				), $htmlCTags
			);

			// Wrap everything in a container object
			$htmlSTags = Html::rawElement( 'div', array (
				'id'     => $tagID . '-container',
				'class'  => 'container',
				'data-width'  => $this->params['width'],
				'data-height' => $this->params['height'],
				'data-font'   => $this->params['font']
				), $htmlCTags
			);

			// Processing placeholder
			$processing = SRFUtils::htmlProcessingElement( $this->isHTML );
		}

		// Beautify class selector
		$class = $this->params['widget'] ?  '-' . $this->params['widget'] . ' ' : '';
		$class = $this->params['class'] ? $class . ' ' . $this->params['class'] : $class ;

		// General placeholder
		$attribs = array (
			'class'  => 'srf-tagcloud' . $class,
			'align'  => 'justify'
		);

		return Html::rawElement( 'div', $attribs, $processing . $htmlSTags );
	}

	/**
	 * Create a template output
	 *
	 * @since 1.8
	 *
	 * @param $value
	 * @param $rownum
	 *
	 * @return string
	 */
	protected function addTemplateOutput( $value, &$rownum ) {
		$rownum++;
		$wikitext  = $this->params['userparam'] ? "|userparam=" . $this->params['userparam'] : '';
		$wikitext .= "|" . $value;
		$wikitext .= "|#=$rownum";
		return '{{' . trim ( $this->params['template'] ) . $wikitext . '}}';
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

		$params['template'] = array(
			'message' => 'srf-paramdesc-template',
			'default' => '',
		);

		$params['userparam'] = array(
			'message' => 'srf-paramdesc-userparam',
			'default' => '',
		);

		$params['excludetags'] = array(
			'message' => 'srf-paramdesc-excludetags',
			'default' => '',
		);

		$params['includesubject'] = array(
			'type' => 'boolean',
			'message' => 'srf-paramdesc-includesubject',
			'default' => false,
		);

		$params['tagorder'] = array(
			'message' => 'srf_paramdesc_tagorder',
			'default' => 'alphabetical',
			'values' => array( 'alphabetical', 'asc', 'desc', 'random', 'unchanged' ),
		);

		$params['increase'] = array(
			'message' => 'srf_paramdesc_increase',
			'default' => 'log',
			'values' => array( 'linear', 'log' ),
		);

		$params['widget'] = array(
			'message' => 'srf-paramdesc-widget',
			'default' => '',
			'values' => array( 'sphere', 'wordcloud' ),
		);

		$params['class'] = array(
			'message' => 'srf-paramdesc-class',
			'default' => '',
		);

		$params['font'] = array(
			'message' => 'srf-paramdesc-font',
			'default' => 'impact',
		);

		$params['height'] = array(
			'type' => 'integer',
			'message' => 'srf-paramdesc-height',
			'default' => 400,
			'lowerbound' => 1,
		);

		$params['width'] = array(
			'type' => 'integer',
			'message' => 'srf-paramdesc-width',
			'default' => 400,
			'lowerbound' => 1,
		);

		$params['mincount'] = array(
			'type' => 'integer',
			'message' => 'srf_paramdesc_mincount',
			'default' => 1,
			'manipulatedefault' => false,
		);

		$params['minsize'] = array(
			'type' => 'integer',
			'message' => 'srf_paramdesc_minsize',
			'default' => 77,
			'manipulatedefault' => false,
		);

		$params['maxsize'] = array(
			'type' => 'integer',
			'message' => 'srf_paramdesc_maxsize',
			'default' => 242,
			'manipulatedefault' => false,
		);

		$params['maxtags'] = array(
			'type' => 'integer',
			'message' => 'srf_paramdesc_maxtags',
			'default' => 1000,
			'lowerbound' => 1,
		);

		return $params;
	}
}