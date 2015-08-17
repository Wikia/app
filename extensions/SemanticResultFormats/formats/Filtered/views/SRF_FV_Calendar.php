<?php

/**
 * File holding the SRF_FV_Calendar class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

/**
 * The SRF_FV_Calendar class defines the List view.
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
class SRF_FV_Calendar extends SRF_Filtered_View {

	/**
	 * Constructor for the view.
	 *
	 * @param $id the view id
	 * @param $results array of SRF_Filtered_Item containing the query results
	 * @param type $params array of parameter values given as key-value-pairs
	 */
	public function __construct( $id, &$results, &$params, SRFFiltered &$queryPrinter ) {

		global $wgParser;

		parent::__construct($id, $results, $params, $queryPrinter);

		// find the hash for the printout containing the start date
		if ( $params[ 'calendar view start' ] !== '' ) {
			$start = trim( $wgParser->recursiveTagParse( $params['calendar view start'] ) );
		} else {
			$start = null;
		}

		// find the hash for the printout containing the start date
		if ( $params[ 'calendar view end' ] !== '' ) {
			$end = trim( $wgParser->recursiveTagParse( $params['calendar view end'] ) );
		} else {
			$end = null;
		}

		// find the hash for the printout containing the title of the element
		if ( $params[ 'calendar view title' ] !== '' ) {
			$title = trim( $wgParser->recursiveTagParse( $params['calendar view title'] ) );
		} else {
			$title = null;
		}

		// find the hash for the printout containing the title of the element
		if ( $params[ 'calendar view title template' ] !== '' ) {
			$titleTemplate = trim( $wgParser->recursiveTagParse( $params['calendar view title template'] ) );
		} else {
			$titleTemplate = null;
		}

		foreach ( $results as $rownum => $result ) {

			$value = $result->getValue();
			$data = array();
			$wikitext = '';
			$firstField = true;

			foreach ( $value as $i => $field ) {

				$printRequest = $field->getPrintRequest();

				if ( $printRequest->getLabel() === $start && $printRequest->getTypeID() === '_dat' ) {
					// found specified column for start date
					$field->reset();
					$datavalue = $field->getNextDatavalue();
					if ( $datavalue !== false ) {
						$data['start'] = $datavalue->getISO8601Date();
					}
				} else if ( $printRequest->getLabel() === $end && $printRequest->getTypeID() === '_dat' ) {
					// found specified column for end date
					$field->reset();
					$datavalue = $field->getNextDatavalue();
					if ( $datavalue !== false ) {
						$data['end'] = $datavalue->getISO8601Date();
					}
				} else if ( $printRequest->getLabel() === $title && $printRequest->getTypeID() === '_wpg' && $titleTemplate === null ) {
					// found specified column for title
					$field->reset();
					$datavalue = $field->getNextDatavalue();
					if ( $datavalue !== false ) {
						$data['url'] = $datavalue->getTitle()->getLocalURL();
					}
				} else if ( $start === null && !array_key_exists( 'start', $data ) && $printRequest->getTypeID() === '_dat' ) {
					// no column for start date specified, take first available date value
					$field->reset();
					$datavalue = $field->getNextDatavalue();
					if ( $datavalue !== false ) {
						$data['start'] = $datavalue->getISO8601Date();
					}
				} else if (
					$firstField === true &&
					$params['mainlabel'] !== '-' &&
					$title === null &&
					$titleTemplate === null &&
					$printRequest->getTypeID() === '_wpg'
					) {
					// found specified column for title
					$field->reset();
					$datavalue = $field->getNextDatavalue();
					if ( $datavalue !== false ) {
						$data['url'] = $datavalue->getTitle()->getLocalURL();
					}
				}

				$firstField === false;

				// only add to title template if requested and if not hidden
				if ( $titleTemplate !== null && $printRequest->getParameter( 'hide' ) === false ) {
					$wikitext .= '|' . ( $i + 1 ) . '=';
					$first_value = true;

					$field->reset();
					while ( ( $text = $field->getNextText( SMW_OUTPUT_WIKI, $this->getQueryPrinter()->getLinker( $i == 0 ) ) ) !== false ) {
						if ( $first_value ) {
							$first_value = false;
						} else {
							$wikitext .= ', ';
						}
						$wikitext .= $text;
					}
				}

			}

			// only add to title template if requested and if not hidden
			if ( $titleTemplate !== null ) {
				$wikitext .= "|#=$rownum";
				$data['title'] = trim( $wgParser->recursiveTagParse( '{{' . $titleTemplate . $wikitext . '}}' ) );
				$wgParser->replaceLinkHolders( $data['title'] );
			}

			$result->setData( 'calendar-view', $data );

		}

	}

	/**
	 * Transfers the parameters applicable to this view into internal variables.
	 */
	protected function handleParameters() {

		$params = $this->getActualParameters();

		$this->mStart = $params['calendar view start'];

//		$this->mTemplate = $params['list view template'];
//		$this->mIntroTemplate = $params['list view introtemplate'];
//		$this->mOutroTemplate = $params['list view outrotemplate'];
//		$this->mNamedArgs = $params['list view named args'];
//
//		if ( $params['headers'] == 'hide' ) {
//			$this->mShowHeaders = SMW_HEADERS_HIDE;
//		} elseif ( $params['headers'] == 'plain' ) {
//			$this->mShowHeaders = SMW_HEADERS_PLAIN;
//		} else {
//			$this->mShowHeaders = SMW_HEADERS_SHOW;
//		}
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
			'name' => 'calendar view start',
			'message' => 'srf-paramdesc-filtered-calendar-start',
			'default' => '',
			// 'islist' => false,
		);

		$params[] = array(
			// 'type' => 'string',
			'name' => 'calendar view end',
			'message' => 'srf-paramdesc-filtered-calendar-end',
			'default' => '',
			// 'islist' => false,
		);

		$params[] = array(
			// 'type' => 'string',
			'name' => 'calendar view title',
			'message' => 'srf-paramdesc-filtered-calendar-title',
			'default' => '',
			// 'islist' => false,
		);

		$params[] = array(
			// 'type' => 'string',
			'name' => 'calendar view title template',
			'message' => 'srf-paramdesc-filtered-calendar-title-template',
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
		return 'ext.srf.filtered.calendar-view';
	}

	/**
	 * Returns an array of config data for this filter to be stored in the JS
	 * @return null
	 */
	public function getJsData() {
		global $wgAmericanDates;

		return
			$this->getParamHashes( $this->getQueryResults(), $this->getActualParameters()) +
			array(
				'firstDay' => ($wgAmericanDates?'0':wfMsg( 'srf-filtered-firstdayofweek' )),
				'isRTL' => wfGetLangObj( true )->isRTL(),
			);
	}

	private function getParamHashes( $results, $params ) {

		global $wgParser;

		$ret = array();

		if ( $results !== null && count ( $results ) >= 1 ) {

			// find the hash for the printout containing the title of the element
			if ( $params['calendar view title'] !== '' ) {
				$title = trim( $wgParser->recursiveTagParse( $params['calendar view title'] ) );
			} else {
				$title = null;
			}

			foreach ( $results as $resultObject ) {
				$result = $resultObject->getArrayRepresentation();
				$firstField = true;

				foreach ( $result['printouts'] as $printoutId => $printout ) {

					if ( $printout['label'] === $title ||
						$title === null && $firstField === true && $params['mainlabel'] !== '-' ) {
						$ret['title'] = $printoutId;
						break 2;
					}
					$firstField = false;

				}
			}
		}

		return $ret;
	}

	/**
	 * Returns the label of the selector for this view.
	 * @return String the selector label
	 */
	public function getSelectorLabel() {
		return wfMsg('srf-filtered-selectorlabel-calendar');
	}

}
