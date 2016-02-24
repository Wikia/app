<?php

/**
 * File holding the SRFFiltered class.
 *
 * @file
 * @ingroup SemanticResultFormats
 * @author Stephan Gambke
 *
 */

$formatDir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['SRF_Filtered_Item'] = $formatDir . 'SRF_Filtered_Item.php';

$wgAutoloadClasses['SRF_Filtered_View'] = $formatDir . 'views/SRF_Filtered_View.php';
$wgAutoloadClasses['SRF_FV_List'] = $formatDir . 'views/SRF_FV_List.php';
$wgAutoloadClasses['SRF_FV_Calendar'] = $formatDir . 'views/SRF_FV_Calendar.php';

$wgAutoloadClasses['SRF_Filtered_Filter'] = $formatDir . 'filters/SRF_Filtered_Filter.php';
$wgAutoloadClasses['SRF_FF_Value'] = $formatDir . 'filters/SRF_FF_Value.php';
$wgAutoloadClasses['SRF_FF_Distance'] = $formatDir . 'filters/SRF_FF_Distance.php';


/**
 * Result printer that displays results in switchable views and offers
 * client-side (JavaScript based) filtering.
 *
 * This result printer is ultimately planned to replace exhibit. Currently only
 * a list view is available. It is not yet possible to switch between views.
 * There is also only the 'value' filter available yet.
 *
 * Syntax of the #ask call:
 * (This is only a syntax example. For currently available features see the
 * documentation of the various classes.)
 *
 * {{#ask:[[SomeCondition]]
 * |? SomePrintout |+filter=value, someFutureFilter |+value filter switches=and or, disable, all, none |+someFutureFilter filter option=someOptionValue
 * |? SomeOtherPrintout |+filter=value, someOtherFutureFilter |+someOtherFutureFilter filter option=someOptionValue
 *
 * |format=filtered
 * |views=list, someFutureView, someOtherFutureView
 *
 * |list view type=list
 * |list view template=ListItem
 *
 * |someFutureView view option=someOptionValue
 *
 * |someOtherFutureView view option=someOptionValue
 *
 * }}
 *
 * All format specific parameters are optional, although leaving the 'views'
 * parameter empty probably does not make much sense.
 *
 */
class SRFFiltered extends SMWResultPrinter {

	/**
	 * The available view types
	 * @var array of Strings
	 */
	private $mViewTypes = array(
		'list' => 'SRF_FV_List',
		'calendar' => 'SRF_FV_Calendar',
	);

	/**
	 * The available filter types
	 * @var array of Strings
	 */
	private $mFilterTypes = array(
		'value' => 'SRF_FF_Value',
		'distance' => 'SRF_FF_Distance',
	);

	private $mViews;
	private $mParams;
	private $mFiltersOnTop;

	public function hasTemplates ( $hasTemplates = null ) {
		$ret = $this->hasTemplates;
		if ( is_bool( $hasTemplates ) ) {
			$this->hasTemplates = $hasTemplates;
		}
		return $ret;
	}

	/**
	 * Get a human readable label for this printer.
	 *
	 * @return string
	 */
	public function getName() {
		return wfMessage( 'srf-printername-filtered' )->text();
	}

	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );

		// // Set in SMWResultPrinter:
		// $this->mIntro = $params['intro'];
		// $this->mOutro = $params['outro'];
		// $this->mSearchlabel = $params['searchlabel'] === false ? null : $params['searchlabel'];
		// $this->mLinkFirst = true | false;
		// $this->mLinkOthers = true | false;
		// $this->mDefault = str_replace( '_', ' ', $params['default'] );
		// $this->mShowHeaders = SMW_HEADERS_HIDE | SMW_HEADERS_PLAIN | SMW_HEADERS_SHOW;

		$this->mSearchlabel = null;

		$this->mParams = $params;
		$this->mViews = explode( ',', $params['views'] );
		$this->mFiltersOnTop = $params['filter position'] === 'top';

	}

	/**
	 * Return serialised results in specified format.
	 */
	protected function getResultText( SMWQueryResult $res, $outputmode ) {

		// collect the query results in an array
		$result = array();
		while ( $row = $res->getNext() ) {
			$result[uniqid()] = new SRF_Filtered_Item( $row, $this );
		}

		$resourceModules = array();

		// prepare filter data for inclusion in HTML and  JS
		$filterHtml = '';
		$filterHandlers = array();
		$filterData = array();

		foreach ( $res->getPrintRequests() as $printRequest ) {
			$filter = $printRequest->getParameter( 'filter' );
			if ( $filter ) {

				$filtersForPrintout = array_map( 'trim', explode( ',', $filter ) );

				foreach ( $filtersForPrintout as $filterName ) {
					if ( array_key_exists( $filterName, $this->mFilterTypes ) ) {

						$filter = new $this->mFilterTypes[$filterName]( $result, $printRequest, $this );

						$resourceModules = $filter->getResourceModules();

						if ( is_array( $resourceModules ) ) {
							array_walk( $resourceModules, 'SMWOutputs::requireResource' );
						} elseif ( is_string( $resourceModules ) ) {
							SMWOutputs::requireResource( $resourceModules );
						}

						$printRequestHash = md5( $printRequest->getHash() );
						$filterHtml .= Html::rawElement( 'div', array( 'class' => "filtered-$filterName $printRequestHash" ), $filter->getResultText() );

						$filterHandlers[$filterName] = null;
						$filterData[$filterName][$printRequestHash] = $filter->getJsData();

					}
				}
			}
		}

		// wrap filters in a div
		$filterHtml = Html::rawElement( 'div', array( 'class' => 'filtered-filters' ), $filterHtml );

		// prepare view data for inclusion in HTML and  JS
		$viewHtml = '';
		$viewSelectorsHtml = '';
		$viewHandlers = array();
		$viewElements = array(); // will contain the id of the html element to be used by the view
		$viewData = array();

		foreach ( $this->mViews as $viewName ) {

			// cut off the selector label (if one was specified) from the actual view name
			$viewnameComponents = explode('=', $viewName, 2 );

			$viewName = trim( $viewnameComponents[0] );

			if ( array_key_exists( $viewName, $this->mViewTypes ) ) {

				// generate unique id
				$viewid = uniqid();

				$view = new $this->mViewTypes[$viewName]( $viewid, $result, $this->mParams, $this );

				if ( count( $viewnameComponents ) > 1 ) {
					// a selector label was specified in the wiki text
					$viewSelectorLabel = trim( $viewnameComponents[1] );
				} else {
					// use the default selector label
					$viewSelectorLabel = $view->getSelectorLabel();
				}

				$resourceModules = $view->getResourceModules();

				if ( is_array( $resourceModules ) ) {
					array_walk( $resourceModules, 'SMWOutputs::requireResource' );
				} elseif ( is_string( $resourceModules ) ) {
					SMWOutputs::requireResource( $resourceModules );
				}

				$viewHtml .= Html::rawElement( 'div', array( 'class' => "filtered-view filtered-$viewName filtered-view-id$viewid" ), $view->getResultText() );
				$viewSelectorsHtml .= Html::rawElement( 'div', array( 'class' => "filtered-view-selector filtered-$viewName filtered-view-id$viewid" ), $viewSelectorLabel );

				$viewHandlers[$viewName] = null;
				$viewElements[$viewName][] = $viewid;
				$viewData[$viewName] = $view->getJsData();
			}
		}

		// more than one view?
		if ( count( $viewData ) > 1 ) {
			// wrap views in a div
			$viewHtml = Html::rawElement( 'div', array('class' => 'filtered-views', 'style' => 'display:none'),
				Html::rawElement( 'div', array('class' => 'filtered-views-selectors-container'), $viewSelectorsHtml ) .
				Html::rawElement( 'div', array('class' => 'filtered-views-container'), $viewHtml )
			);
		} else {
			// wrap views in a div
			$viewHtml = Html::rawElement( 'div', array('class' => 'filtered-views', 'style' => 'display:none'),
				Html::rawElement( 'div', array('class' => 'filtered-views-container'), $viewHtml )
			);
		}

		// Define the srf_filtered_values array
		SMWOutputs::requireScript( 'srf_filtered_values', Html::inlineScript(
				'srf_filtered_values = {};'
			)
		);

		$resultAsArray = array();
		foreach ( $result as $id => $value ) {
			$resultAsArray[$id] = $value->getArrayRepresentation();
		}

		$id = uniqid();
		SMWOutputs::requireScript( 'srf_filtered_values' . $id,
			Html::inlineScript(
				'srf_filtered_values["' . $id .  '"] = { "values":' . json_encode( $resultAsArray ) .
				', "data": {' .
				' "viewhandlers" : ' . json_encode( $viewHandlers ) .
				', "viewelements" : ' . json_encode( $viewElements ) .
				', "viewdata" : ' . json_encode( $viewData ) .
				', "filterhandlers" : ' . json_encode( $filterHandlers ) .
				', "filterdata" : ' . json_encode( $filterData ) .
				', "sorthandlers" : ' . json_encode( array() ) .
				', "sorterdata" : ' . json_encode( array() ) .
//				', "sorterhandlers" : ' . json_encode( $sorterHandlers ) .
//				', "sorterdata" : ' . json_encode( $sorterData ) .
				'}};'
			)
		);

		SMWOutputs::requireResource( 'ext.srf.filtered' );

		// wrap all in a div
		if ( $this->mFiltersOnTop ) {
			$html = Html::rawElement( 'div', array( 'class' => 'filtered ' . $id ), $filterHtml . $viewHtml );
		} else {
			$html = Html::rawElement( 'div', array( 'class' => 'filtered ' . $id ), $viewHtml. $filterHtml );
		}

		return $html;
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

		$params[] = array(
			// 'type' => 'string',
			'name' => 'views',
			'message' => 'srf-paramdesc-views',
			'default' => '',
			// 'islist' => false,
		);

		$params[] = array(
			// 'type' => 'string',
			'name' => 'filter position',
			'message' => 'srf-paramdesc-filtered-filter-position',
			'default' => 'top',
			// 'islist' => false,
		);

		foreach ( $this->mViewTypes as $viewType ) {
			$params = array_merge( $params, call_user_func( array( $viewType, 'getParameters' ) ) );
		}

		return $params;
	}

	public function getLinker( $firstcol = false, $force = false ) {
		return ( $force ) ? $this->mLinker : parent::getLinker( $firstcol );
	}

}
