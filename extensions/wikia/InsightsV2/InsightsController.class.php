<?php

use Wikia\Logger\Loggable;

class InsightsController extends WikiaSpecialPageController {
	use Loggable;

	public function __construct() {
		parent::__construct( 'Insights', 'insights', true );
	}

	/**
	 * The main, initializing function
	 * @throws MWException
	 */
	public function index() {
		wfProfileIn( __METHOD__ );
		$this->getContext()->getOutput()->setPageTitle( wfMessage( 'insights' )->plain() );
		$this->addAssets();

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
			$this->response->redirect( SpecialPage::getTitleFor( 'Insights' ) );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Collects all necessary data used for rendering a subpage
	 * @throws MWException
	 */
	private function renderSubpage() {
		$helper = new InsightsHelper();

		$model = $helper->getInsightModel( $this->type, $this->subtype );
		$params = $this->filterParams( $this->request->getParams() );

		$this->overrideTemplate( $model->getTemplate() );
		$this->setTemplateValues( $model, $params );
	}

	public function insightsList() {
		$helper = new InsightsHelper();
		$this->setVal( 'type', $this->getVal( 'type', null ) );
		$this->setVal( 'insightsList', $helper->prepareInsightsList() );
	}

	/**
	 * Prepare data needed to sort list
	 */
	public function pageViews() {
		$dropdown = [];

		$sort = $this->request->getVal( 'sort', InsightsSorting::getDefaultSorting() );

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

		$this->setVal( 'current', $sort );
		$this->setVal( 'dropdown', $dropdown );
	}

	private function setTemplateValues( InsightsModel $model, $params ) {
		$insightsContext = new InsightsContext( $model, $params );
		$content = $insightsContext->getContent();

		if ( empty( $content ) ) {
			$this->setEmptyTemplate( $model );
		} else {
			$sort = $this->request->getVal( 'sort', InsightsSorting::getDefaultSorting() );
			$sortingTypes = InsightsSorting::$sorting;

			$metadata = isset( $sortingTypes[$sort]['metadata'] ) ? $sortingTypes[$sort]['metadata'] : $sort;

			try {
				$this->response->setData( [
					'content' => $content,
					'pagination' => $insightsContext->getPagination(),
					'subtypes' => $model->getConfig()->getSubtypes(),
					'showPageViews' => $model->getConfig()->showPageViews(),
					'hasActions' => $model->getConfig()->hasAction(),
					'usage' => $model->getConfig()->getInsightUsage(),
					'type' => $this->type,
					'subtype' => $this->subtype,
					'themeClass' => $this->themeClass,
					'sort' => $sort,
					'metadata' => $metadata
				] );
			} catch ( WikiaHttpException $e ) {
				$this->setErrorTemplate( $e->getDetails(), $e );
			} catch ( Exception $e ) {
				$this->setErrorTemplate( $e->getMessage(), $e );
			}
		}
	}

	private function addAssets() {
		$this->response->addAsset( '/extensions/wikia/InsightsV2/styles/insights-lists.scss' );
		$this->response->addAsset( '/extensions/wikia/InsightsV2/scripts/InsightsPage.js' );
	}

	private function filterParams( $params ) {
		unset( $params['title'] );
		unset( $params['controller'] );
		unset( $params['method'] );
		unset( $params['par'] );

		return $params;
	}

	private function setErrorTemplate( $message, $exception ) {
		$this->setVal( 'errorDetails', $message );
		$this->overrideTemplate( 'error' );

		$this->error( 'Insights Exception', [ 'exception' => $exception, 'type' => $this->type ] );
	}

	private function setEmptyTemplate( InsightsModel $model ) {
		$message = $model->getConfig()->getInsightUsage() === InsightsModel::INSIGHTS_USAGE_ACTIONABLE
			? wfMessage( 'insights-list-no-items' )->escaped()
			: wfMessage( 'insights-list-no-items-informative' )->escaped();

		$this->setVal( 'emptyMessage', $message );
		$this->overrideTemplate( 'empty' );
	}
}
