<?php

/**
 * File holding the SRFTree class.
 * 
 * @file
 * @ingroup SemanticResultFormats
 * @author Stephan Gambke
 * 
 */

/**
 * Result printer that prints query results as a tree (nested html lists).
 * 
 * The available formats are 'tree', 'ultree', 'oltree'. 'tree' is an alias of
 * 'ultree'. In an #ask query the parameter 'parent' must be set to contain the
 * name of the property, that gives the parent page of the subject page.
 * 
 */
class SRFTree extends SMWListResultPrinter {
	protected $mTreeProp = null;

	/**
	 * (non-PHPdoc)
	 * @see SMWResultPrinter::getName()
	 */
	public function getName() {
		return wfMessage( 'srf_printername_' . $this->mFormat )->text();
	}

	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );

		//// Set in SMWResultPrinter:
		// $this->mIntro = $params['intro'];
		// $this->mOutro = $params['outro'];
		// $this->mSearchlabel = $params['searchlabel'] === false ? null : $params['searchlabel'];
		// $this->mLinkFirst = true | false;
		// $this->mLinkOthers = true | false;
		// $this->mDefault = str_replace( '_', ' ', $params['default'] );
		// $this->mShowHeaders = SMW_HEADERS_HIDE | SMW_HEADERS_PLAIN | SMW_HEADERS_SHOW;
		//// Set in SMWListResultPrinter:
		// $this->mSep = $this->isPlainlist() ? $params['sep'] : '';
		// $this->mTemplate = trim( $params['template'] );
		// $this->mNamedArgs = $params['named args'];
		// $this->mUserParam = trim( $params['userparam'] );
		// $this->mColumns = !$this->isPlainlist() ? $params['columns'] : 1;
		// $this->mIntroTemplate = $params['introtemplate'];
		// $this->mOutroTemplate = $params['outrotemplate'];
		// Don't support pagination in trees
		$this->mSearchlabel = null;

		// Trees are always ul or ol, never plainlists
		$this->mSep = '';

		// Trees support only one column
		$this->mColumns = 1;

		if ( array_key_exists( 'parent', $params ) ) {
			$this->mTreeProp = $params['parent'];
		}
	}

	/**
	 * Return serialised results in specified format.
	 */
	protected function getResultText( SMWQueryResult $res, $outputmode ) {

		if ( $this->mTreeProp === null || $this->mTreeProp === '' ) {
			$res->addErrors( array( wfMessage( 'srf-noparentprop' )->inContentLanguage()->text() ) );
			return '';
		}

		$store = $res->getStore();
			

		// first put everything in a list
		// elements appearing more than once will be inserted more than once,
		// but only one instance will be inserted with the hash
		// only this instance will be considered as a parent element in the tree
		$list = array( );

		while ( $row = $res->getNext() ) {

			$hash = $row[0]->getResultSubject()->getSerialization();

			if ( array_key_exists( $hash, $list ) ) {
				$list[] = new SRFTreeElement( $row );
			} else {
				$list[$hash] = new SRFTreeElement( $row );
			}
		}

		// transfer the listelements into the tree
		// elements with more than one parent will be cloned for each parent
		$tree = array( );

		foreach ( $list as $hash => $listElem ) {

			$parents = $store->getPropertyValues(
				$listElem->mRow[0]->getResultSubject(),
				SMWDIProperty::newFromUserLabel($this->mTreeProp)
				);

			// transfer element from list to tree
			foreach ( $parents as $parent ) {
				$parentPageHash = $parent->getSerialization();

				if ( $hash !== null ) {

					if ( array_key_exists( $parentPageHash, $list ) ) {
						$listElem->mParent = $parentPageHash;
					}

					$tree[$hash] = $listElem;
					$hash = null;
				} else {
					$treeElem = clone $listElem;

					if ( array_key_exists( $parentPageHash, $list ) ) {
						$treeElem->mParent = $parentPageHash;
					} else {
						$treeElem->mParent = null;
					}

					$tree[] = $treeElem;
				}
			}
		}

			
			foreach ( $tree as $hash => $value ) {

			}
		// build pointers from parants to children
		foreach ( $tree as $hash => $treeElem ) {

			if ( $treeElem->mParent != null ) {
				$tree[$treeElem->mParent]->mChildren[] = $treeElem;
			}
		}

		// remove children from toplevel
		foreach ( $tree as $hash => $treeElem ) {

			if ( $treeElem->mParent != null ) {
				unset ($tree[$hash]);
			}
		}
		
		$result = '';
		$rownum = 0;

		foreach ( $tree as $hash => $treeElem ) {

			$this->printElement( $result, $treeElem, $row );
		}

		return $result;
	}

	protected function printElement( &$result, SRFTreeElement &$element, &$rownum, $level = 1 ) {
		
		$rownum++;
		
		$result .= str_pad( '', $level, ($this->mFormat == 'oltree')?'#':'*'  );
			
		if ( $this->mTemplate !== '' ) { // build template code
			$this->hasTemplates = true;
			$wikitext = ( $this->mUserParam ) ? "|userparam=$this->mUserParam" : '';
			
			foreach ( $element->mRow as $i => $field ) {
				$wikitext .= '|' . ( $this->mNamedArgs ? '?' . $field->getPrintRequest()->getLabel() : $i + 1 ) . '=';
				$first_value = true;
				
				while ( ( $text = $field->getNextText( SMW_OUTPUT_WIKI,
				$this->getLinker( $i == 0 ) ) ) !== false ) {
					
					if ( $first_value ) {
						$first_value = false;
					} else {
						$wikitext .= ', ';
					}
					$wikitext .= $text;
				}
			}
			
			$wikitext .= "|#=$rownum";
			$result .= '{{' . $this->mTemplate . $wikitext . '}}';
			// str_replace('|', '&#x007C;', // encode '|' for use in templates (templates fail otherwise) -- this is not the place for doing this, since even DV-Wikitexts contain proper "|"!
		} else {  // build simple list
			$first_col = true;
			$found_values = false; // has anything but the first column been printed?
			
			foreach ( $element->mRow as $field ) {
				$first_value = true;
				
				$field->reset();
				
				while ( ( $text = $field->getNextText( SMW_OUTPUT_WIKI, $this->getLinker( $first_col ) ) ) !== false ) {
					
					if ( !$first_col && !$found_values ) { // first values after first column
						$result .= ' (';
						$found_values = true;
					}
					
					if ( $first_value ) { // first value in any column, print header
						$first_value = false;
						
						if ( ( $this->mShowHeaders != SMW_HEADERS_HIDE ) && 
							( $field->getPrintRequest()->getLabel() !== '' ) ) {
							$result .= $field->getPrintRequest()->getText( SMW_OUTPUT_WIKI, ( $this->mShowHeaders == SMW_HEADERS_PLAIN ? null:$this->mLinker ) ) . ' ';
						}
					}
					
					$result .= $text; // actual output value
					
				}
				
				$first_col = false;
			}
			
			if ( $found_values ) $result .= ')';
		}
		
		$result .= "\n";
				
		foreach ( $element->mChildren as $hash => $treeElem ) {

			$this->printElement($result, $treeElem, $rownum, $level + 1);
		}
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

		$params['parent'] = array(
			'default' => '',
			'message' => 'srf-paramdesc-parent',
		);

		return $params;
	}

}

class SRFTreeElement {

	var $mChildren = array( );
	var $mParent = null;
	var $mRow = null;

	public function __construct( &$row ) {
		$this->mRow = $row;
	}

}

