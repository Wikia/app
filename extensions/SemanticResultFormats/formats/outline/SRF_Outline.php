<?php

/**
 * A class to print query results in an outline format, along with some
 * helper classes to handle the aggregation
 */

/**
 * Represents a single item, or page, in the outline - contains both the
 * SMWResultArray and an array of some of its values, for easier aggregation
 */
class SRFOutlineItem {
	var $mRow;
	var $mVals;

	function __construct( $row ) {
		$this->mRow = $row;
		$this->mVals = array();
	}

	function addFieldValue( $field_name, $field_val ) {
		if ( array_key_exists( $field_name, $this->mVals ) ) {
			$this->mVals[$field_name][] = $field_val;
		} else {
			$this->mVals[$field_name] = array( $field_val );
		}
	}

	function getFieldValues( $field_name ) {
		if ( array_key_exists( $field_name, $this->mVals ) )
			return $this->mVals[$field_name];
		else {
			return array( wfMessage( 'srf_outline_novalue' )->text() );
		}
	}
}

/**
 * A tree structure for holding the outline data
 */
class SRFOutlineTree {
	var $mTree;
	var $mUnsortedItems;

	function __construct( $items = array() ) {
		$this->mTree = array();
		$this->mUnsortedItems = $items;
	}

	function addItem( $item ) {
		$this->mUnsortedItems[] = $item;
	}

	function categorizeItem( $vals, $item ) {
		foreach ( $vals as $val ) {
			if ( array_key_exists( $val, $this->mTree ) ) {
				$this->mTree[$val]->mUnsortedItems[] = $item;
			} else {
				$this->mTree[$val] = new SRFOutlineTree( array( $item ) );
			}
		}
	}

	function addProperty( $property ) {
		if ( count( $this->mUnsortedItems ) > 0 ) {
			foreach ( $this->mUnsortedItems as $item ) {
				$cur_vals = $item->getFieldValues( $property );
				$this->categorizeItem( $cur_vals, $item );
			}
			$this->mUnsortedItems = null;
		} else {
			foreach ( $this->mTree as $i => $node ) {
				$this->mTree[$i]->addProperty( $property );
			}
		}
	}
}

class SRFOutline extends SMWResultPrinter {
	protected $mOutlineProperties = array();
	protected $mInnerFormat = '';

	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
		$this->mOutlineProperties = $params['outlineproperties'];
	}

	public function getName() {
		return wfMessage( 'srf_printername_outline' )->text();
	}

	/**
	 * Code mostly copied from SMW's SMWListResultPrinter::getResultText()
	 */
	function printItem( $item ) {
		$first_col = true;
		$found_values = false; // has anything but the first column been printed?
		$result = "";
		foreach ( $item->mRow as $orig_ra ) {
			// handling is somewhat simpler for SMW 1.5+
			$realFunction = array( 'SMWQueryResult', 'getResults' );
			if ( is_callable( $realFunction ) ) {
				// make a new copy of this, so that the call to
				// getNextText() will work again
				$ra = clone ( $orig_ra );
			} else {
				// make a new copy of this, so that the call to
				// getNextText() will work again
				$ra = new SMWResultArray( $orig_ra->getContent(), $orig_ra->getPrintRequest() );
			}
			$val = $ra->getPrintRequest()->getText( SMW_OUTPUT_WIKI, null );
			if ( in_array( $val, $this->mOutlineProperties ) ) {
				continue;
			}
			$first_value = true;
			while ( ( $text = $ra->getNextText( SMW_OUTPUT_WIKI, $this->mLinker ) ) !== false ) {
				if ( !$first_col && !$found_values ) { // first values after first column
					$result .= ' (';
					$found_values = true;
				} elseif ( $found_values || !$first_value ) {
				// any value after '(' or non-first values on first column
					$result .= ', ';
				}
				if ( $first_value ) { // first value in any column, print header
					$first_value = false;
					if ( $this->mShowHeaders && ( '' != $ra->getPrintRequest()->getLabel() ) ) {
						$result .= $ra->getPrintRequest()->getText( SMW_OUTPUT_WIKI, $this->mLinker ) . ' ';
					}
				}
				$result .= $text; // actual output value
			}
			$first_col = false;
		}
		if ( $found_values ) $result .= ')';
		return $result;
	}

	function printTree( $outline_tree, $level = 0 ) {
		$text = "";
		if ( ! is_null( $outline_tree->mUnsortedItems ) ) {
			$text .= "<ul>\n";
			foreach ( $outline_tree->mUnsortedItems as $item ) {
				$text .= "<li>{$this->printItem($item)}</li>\n";
			}
			$text .= "</ul>\n";
		}
		if ( $level > 0 ) $text .= "<ul>\n";
		$num_levels = count( $this->mOutlineProperties );
		// set font size and weight depending on level we're at
		$font_level = $level;
		if ( $num_levels < 4 ) {
			$font_level += ( 4 - $num_levels );
		}
		if ( $font_level == 0 )
			$font_size = 'x-large';
		elseif ( $font_level == 1 )
			$font_size = 'large';
		elseif ( $font_level == 2 )
			$font_size = 'medium';
		else
			$font_size = 'small';
		if ( $font_level == 3 )
			$font_weight = 'bold';
		else
			$font_weight = 'regular';
		foreach ( $outline_tree->mTree as $key => $node ) {
			$text .= "<p style=\"font-size: $font_size; font-weight: $font_weight;\">$key</p>\n";
			$text .= $this->printTree( $node, $level + 1 );
		}
		if ( $level > 0 ) $text .= "</ul>\n";
		return $text;
	}

	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		$print_fields = array();
		foreach ( $res->getPrintRequests() as $pr ) {
			$field_name = $pr->getText( $outputmode, $this->mLinker );
			// only print it if it's not already part of the
			// outline
			if ( ! in_array( $field_name, $this->mOutlineProperties ) ) {
				$print_fields[] = $field_name;
			}
		}

		// for each result row, create an array of the row itself
		// and all its sorted-on fields, and add it to the initial
		// 'tree'
		$outline_tree = new SRFOutlineTree();
		while ( $row = $res->getNext() ) {
			$item = new SRFOutlineItem( $row );
			foreach ( $row as $field ) {
				$first = true;
				$field_name = $field->getPrintRequest()->getText( SMW_OUTPUT_HTML );
				if ( in_array( $field_name, $this->mOutlineProperties ) ) {
					while ( ( $object = $field->getNextDataValue() ) !== false ) {
						$field_val = $object->getLongWikiText( $this->mLinker );
						$item->addFieldValue( $field_name, $field_val );
					}
				}
			}
			$outline_tree->addItem( $item );
		}

		// now, cycle through the outline properties, creating the
		// tree
		foreach ( $this->mOutlineProperties as $outline_prop ) {
			$outline_tree->addProperty( $outline_prop );
		}
		$result = $this->printTree( $outline_tree );

		// print further results footer
		if ( $this->linkFurtherResults( $res ) ) {
			$link = $res->getQueryLink();
			if ( $this->getSearchLabel( $outputmode ) ) {
				$link->setCaption( $this->getSearchLabel( $outputmode ) );
			}
			$link->setParameter( 'outline', 'format' );
			if ( array_key_exists( 'outlineproperties', $this->m_params ) ) {
				$link->setParameter( $this->m_params['outlineproperties'], 'outlineproperties' );
			}
			$result .= $link->getText( $outputmode, $this->mLinker ) . "\n";
		}
		return $result;
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

		$params['outlineproperties'] = array(
			'islist' => true,
			'default' => array(),
			'message' => 'srf_paramdesc_outlineproperties',
		);

		return $params;
	}

}
