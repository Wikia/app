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

$wgAutoloadClasses['SRF_Filtered_Filter'] = $formatDir . 'filters/SRF_Filtered_Filter.php';
$wgAutoloadClasses['SRF_FF_Value'] = $formatDir . 'filters/SRF_FF_Value.php';


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
	);

	/**
	 * The available filter types
	 * @var array of Strings
	 */
	private $mFilterTypes = array(
		'value' => 'SRF_FF_Value',
	);

	private $mViews;
	private $mParams;

	public function hasTemplates ( $hasTemplates = null ) {
		$ret = $this->hasTemplates;
		if ( is_bool( $hasTemplates ) ) {
			$this->hasTemplates = $hasTemplates;
		}
		return $ret;
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
		$this->mViews = array_map( 'trim', explode( ',', $params['views'] ) );

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

				$filtersForPrintout = explode( ',', $filter );
				$filtersForPrintout = array_map( 'trim', $filtersForPrintout );

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
		$viewHandlers = array();
		$viewElements = array();

		foreach ( $this->mViews as $viewName ) {
			if ( array_key_exists( $viewName, $this->mViewTypes ) ) {

				// generate unique id
				$viewid = uniqid();

				$view = new $this->mViewTypes[$viewName]( $viewid, $result, $this->mParams, $this );

				$resourceModules = $view->getResourceModules();

				if ( is_array( $resourceModules ) ) {
					array_walk( $resourceModules, 'SMWOutputs::requireResource' );
				} elseif ( is_string( $resourceModules ) ) {
					SMWOutputs::requireResource( $resourceModules );
				}

				$viewHtml .= Html::rawElement( 'div', array( 'class' => "filtered-$viewName $viewid" ), $view->getResultText() );

				$viewHandlers[$viewName] = null;
				$viewElements[$viewName][] = $viewid;
			}
		}

		// wrap views in a div
		$viewHtml = Html::rawElement( 'div', array( 'class' => 'filtered-views' ), $viewHtml );

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
				', "filterhandlers" : ' . json_encode( $filterHandlers ) .
				', "filterdata" : ' . json_encode( $filterData ) .
				'}};'
			)
		);

		SMWOutputs::requireResource( 'ext.srf.filtered' );

		// wrap all in a div
		$html = Html::rawElement( 'div', array( 'class' => 'filtered ' . $id ), $filterHtml . $viewHtml );

		return $html;
	}


	public function getParameters() {
		$params = array_merge( parent::getParameters(),
			parent::textDisplayParameters() );

		$params['views'] = new Parameter( 'views' );
		$params['views']->setMessage( 'srf-paramdesc-views' );
		$params['views']->setDefault( '' );

		foreach ( $this->mViewTypes as $viewType ) {
			$params = array_merge( $params, call_user_func( array( $viewType, 'getParameters' ) ) );
		}

		return $params;
	}

	public function getLinker( $firstcol = false, $force = false ) {
		return ( $force ) ? $this->mLinker : parent::getLinker( $firstcol );
	}

}
