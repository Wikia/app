<?php

/**
 * File holding the SRF_FV_List class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

/**
 * The SRF_FV_List class defines the List view.
 *
 * Available parameters for this view:
 *   list view type: list|ul|ol; default: list
 *   list view template: a template rendering a list item
 *   list view introtemplate: a template prepended to the list
 *   list view outrotemplate: a template appended to the list
 *   list view named args: use named args for templates
 *
 * @ingroup SemanticResultFormats
 */
class SRF_FV_List extends SRF_Filtered_View {

	private $mFormat, $mTemplate, $mIntroTemplate, $mOutroTemplate, $mNamedArgs, $mShowHeaders;

	/**
	 * Transfers the parameters applicable to this view into internal variables.
	 */
	protected function handleParameters() {

		$params = $this->getActualParameters();

		$this->mFormat = $params['list view type'];
		$this->mTemplate = $params['list view template'];
		$this->mIntroTemplate = $params['list view introtemplate'];
		$this->mOutroTemplate = $params['list view outrotemplate'];
		$this->mNamedArgs = $params['list view named args'];

		if ( $params['headers'] == 'hide' ) {
			$this->mShowHeaders = SMW_HEADERS_HIDE;
		} elseif ( $params['headers'] == 'plain' ) {
			$this->mShowHeaders = SMW_HEADERS_PLAIN;
		} else {
			$this->mShowHeaders = SMW_HEADERS_SHOW;
		}
	}

	/**
	 * Returns the wiki text that is to be included for this view.
	 *
	 * @return string
	 */
	public function getResultText() {

		$this->handleParameters();

		// Determine mark-up strings used around list items:
		if ( ( $this->mFormat == 'ul' ) || ( $this->mFormat == 'ol' ) ) {
			$header = "<" . $this->mFormat . ">\n";
			$footer = "</" . $this->mFormat . ">\n";
			$rowstart = "\t<li class='filtered-list-item ";
			$rowend = "</li>\n";
			$listsep = ', ';
		} else { // "list" format
			$header = '';
			$footer = '';
			$rowstart = "\t<div class='filtered-list-item ";
			$rowend = "</div>\n";
			$listsep = ', ';
		}

		// Initialise more values
		$result = '';

		if ( $header !== '' ) {
			$result .= $header;
		}

		if ( $this->mIntroTemplate !== '' ) {
			$result .= "{{" . $this->mIntroTemplate . "}}";
		}

		// Now print each row
		$rownum = -1;

		foreach ( $this->getQueryResults() as $id => $value ) {
			$row = $value->getValue();

			$this->printRow( $row, $rownum, $rowstart  . $id . "' id='$id' >", $rowend, $result, $listsep );
		}

		if ( $this->mOutroTemplate !== '' ) {
			$result .= "{{" . $this->mOutroTemplate . "}}";
		}

		// Print footer
		if ( $footer !== '' ) {
			$result .= $footer;
		}

		return $result;
	}

	/**
	 * Prints one row of a list view.
	 */
	protected function printRow( $row, &$rownum, $rowstart, $rowend, &$result, $listsep ) {

		$rownum++;

		$result .= $rowstart;

		if ( $this->mTemplate !== '' ) { // build template code
			$this->getQueryPrinter()->hasTemplates( true );

			// $wikitext = ( $this->mUserParam ) ? "|userparam=$this->mUserParam" : '';
			$wikitext = '';

			foreach ( $row as $i => $field ) {

				$printrequest = $field->getPrintRequest();

				// only print value if not hidden
				if ( $printrequest->getParameter( 'hide' ) === false ) {
					$wikitext .= '|' . ( $this->mNamedArgs ? '?' . $printrequest->getLabel() : $i + 1 ) . '=';
					$first_value = true;

					$field->reset();
					while ( ( $text = $field->getNextText( SMW_OUTPUT_WIKI, $this->getQueryPrinter()->getLinker( $i == 0 ) ) ) !== false ) {
						if ( $first_value )
							$first_value = false; else
							$wikitext .= ', ';
						$wikitext .= $text;
					}
				}
			}

			$wikitext .= "|#=$rownum";
			$result .= '{{' . $this->mTemplate . $wikitext . '}}';

		} else {  // build simple list
			$first_col = true;
			$found_values = false; // has anything but the first column been printed?

			foreach ( $row as $field ) {
				$first_value = true;

				$printrequest = $field->getPrintRequest();

					$field->reset();
					while ( ( $text = $field->getNextText( SMW_OUTPUT_WIKI, $this->getQueryPrinter()->getLinker( $first_col ) ) ) !== false ) {

				// only print value if not hidden
				if ( $printrequest->getParameter( 'hide' ) === false ) {

						if ( !$first_col && !$found_values ) { // first values after first column
							$result .= ' (';
							$found_values = true;
						} elseif ( $found_values || !$first_value ) {
							// any value after '(' or non-first values on first column
							$result .= "$listsep ";
						}

						if ( $first_value ) { // first value in any column, print header
							$first_value = false;

							if ( ( $this->mShowHeaders != SMW_HEADERS_HIDE ) && ( $field->getPrintRequest()->getLabel() !== '' ) ) {
								$result .= $field->getPrintRequest()->getText( SMW_OUTPUT_WIKI, ( $this->mShowHeaders == SMW_HEADERS_PLAIN ? null:$this->getQueryPrinter()->getLinker( true, true ) ) ) . ' ';
							}
						}

						$result .= $text; // actual output value
				}
					}

					$first_col = false;
			}

			if ( $found_values ) $result .= ')';
		}

		$result .= $rowend;
	}

	/**
	 * A function to describe the allowed parameters of a query for this view.
	 *
	 * @return array of Parameter
	 */
	public static function getParameters() {
		$params = parent::getParameters();

		$params[] = array(
			// 'type' => 'string',
			'name' => 'list view type',
			'message' => 'srf-paramdesc-filtered-list-type',
			'default' => 'list',
			// 'islist' => false,
		);

		$params[] = array(
			// 'type' => 'string',
			'name' => 'list view template',
			'message' => 'srf-paramdesc-filtered-list-template',
			'default' => '',
			// 'islist' => false,
		);

		$params[] = array(
			'type' => 'boolean',
			'name' => 'list view named args',
			'message' => 'srf-paramdesc-filtered-list-named-args',
			'default' => false,
			// 'islist' => false,
		);

		$params[] = array(
			//'type' => 'string',
			'name' => 'list view introtemplate',
			'message' => 'srf-paramdesc-filtered-list-introtemplate',
			'default' => '',
			// 'islist' => false,
		);

		$params[] = array(
			//'type' => 'string',
			'name' => 'list view outrotemplate',
			'message' => 'srf-paramdesc-filtered-list-outrotemplate',
			'default' => '',
			// 'islist' => false,
		);

		return $params;
	}

	/**
	 * Returns the name of the resource module to load for this view.
	 *
	 * @return string|array
	 */
	public function getResourceModules() {
		return 'ext.srf.filtered.list-view';
	}

	/**
	 * Returns the label of the selector for this view.
	 * @return String the selector label
	 */
	public function getSelectorLabel() {
		return wfMsg('srf-filtered-selectorlabel-list');
	}

}
