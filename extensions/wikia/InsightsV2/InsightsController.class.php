<?php

class InsightsController extends WikiaSpecialPageController {
	private $model;

	public function __construct() {
		parent::__construct( 'Insights', 'insights', true );
	}

	/**
	 * The main, initializing function
	 * @throws MWException
	 */
	public function index() {
		wfProfileIn( __METHOD__ );
		$this->wg->Out->setPageTitle( wfMessage( 'insights' )->escaped() );
		$this->addAssets();

		/**
		 * @var A slug of a subpage
		 */
		$this->type = $this->getPar();
		$this->subtype = $this->request->getVal( 'subtype', null );
		$this->themeClass = SassUtil::isThemeDark() ? 'insights-dark' : 'insights-light';

		/**
		 * Check if a user requested a subpage. If the requested subpage
		 * is unknown redirect them to the landing page.
		 */
		if ( InsightsHelper::isInsightPage( $this->type ) ) {
			$this->renderSubpage();
		} elseif ( !empty( $this->type ) ) {
			$this->response->redirect( InsightsHelper::getSubpageLocalUrl() );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Entry point for rendering UI for filtering flags
	 */
	public function flagsFiltering() {
		$selectedFlagTypeId = $this->request->getVal( 'selectedFlagTypeId' );
		$flagTypes = $this->request->getVal( 'flagTypes' );
		$this->setVal( 'flagTypes', $flagTypes );
		$this->setVal( 'selectedFlagTypeId', $selectedFlagTypeId );
	}

	/**
	 * Collects all necessary data used for rendering a subpage
	 * @throws MWException
	 */
	private function renderSubpage() {
		$helper = new InsightsHelper();

		$this->model = $helper->getInsightModel( $this->type, $this->subtype );
		/**
		 * A model for insights should implement at least 3 methods:
		 * - getContent() - returning all the visible data
		 * - getData() - returning all the helping data
		 * - getTemplate() - returning an overriding template
		 */
		if ( $this->model instanceof InsightsPageModel ) {
			$params = $this->filterParams( $this->request->getParams() );

			$paginator = new InsightsPaginator( $this->type, $params );
			$this->paginatorBar = $paginator->getPagination();
			$content = $this->model->getContent( $params, $paginator->getOffset(), $paginator->getLimit() );
			$this->setVal( 'content', $content );

			$this->prepareSortingData();
			$this->renderFlagsFiltering();
			$this->setVal( 'showPageViews', $this->model->getConfig()->showPageViews() );
			$this->setVal( 'hasActions', $this->model->getConfig()->hasActions() );
			$this->setVal( 'insightsList', $helper->prepareInsightsList() );
			$this->overrideTemplate( $this->model->getTemplate() );
		} else {
			throw new MWException( 'An Insights subpage should implement the InsightsQueryPageModel interface.' );
		}
	}

	/**
	 * Add flags filter to layout
	 */
	private function renderFlagsFiltering() {
		global $wgEnableFlagsExt;
		if ( !$wgEnableFlagsExt ) {
			return;
		}
		if ( $this->model instanceof InsightsFlagsModel ) {
			$flagTypeId = $this->request->getVal( InsightsConfig::SUBTYPE );

			$params = [ 'flag_targeting' => \Flags\Models\FlagType::FLAG_TARGETING_CONTRIBUTORS ];
			$flagTypes = $this->app->sendRequest( 'FlagsApiController', 'getFlagTypes', $params )->getData()['data'];
			
			$this->setVal( 'selectedFlagTypeId', $flagTypeId );
			$this->setVal( 'flagTypes', $flagTypes );
		}
	}

	/**
	 * Prepare data needed to sort list
	 */
	private function prepareSortingData() {
		$dropdown = [];

		if( $this->model->getConfig()->showPageViews() ) {
			$sort = $this->request->getVal( 'sort', ( new InsightsSorting( $this->model->getConfig() ) )->getDefaultSorting() );

			$sortingTypes = InsightsSorting::$sorting;

			/**
			 * Used to create the following messages:
			 *
			 * 'insights-list-pv7',
			 * 'insights-list-pv28',
			 * 'insights-list-pvDiff',
			 * 'insights-list-title'
			 */
			foreach ( $sortingTypes as $key => $sorting ) {
				$dropdown[ $key ] = wfMessage( 'insights-sort-' . $key )->escaped();
			}

			$this->current = $sort;
			$this->metadata = isset( $sortingTypes[ $sort ]['metadata'] )
				? $sortingTypes[ $sort ]['metadata']
				: $sort;
		}

		$this->dropdown = $dropdown;
	}

	private function addAssets() {
		$this->response->addAsset( '/extensions/wikia/InsightsV2/styles/insights-lists.scss' );
		$this->response->addAsset( '/extensions/wikia/InsightsV2/scripts/InsightsPage.js' );
	}


	/** new methods **/
	private function filterParams( $params ) {
		unset( $params['title'] );
		unset( $params['controller'] );
		unset( $params['method'] );
		unset( $params['par'] );

		return $params;
	}
}
