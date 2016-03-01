<?php

class InsightsController extends WikiaSpecialPageController {

	const
		FLOW_STATUS_INPROGRESS = 'inprogress',
		FLOW_STATUS_ALLDONE = 'alldone',
		FLOW_STATUS_FIXED = 'fixed',
		FLOW_STATUS_NOTFIXED = 'notfixed';

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
		$this->subpage = $this->getPar();
		$this->themeClass = SassUtil::isThemeDark() ? 'insights-dark' : 'insights-light';

		/**
		 * Check if a user requested a subpage. If the requested subpage
		 * is unknown redirect them to the landing page.
		 */
		if ( InsightsHelper::isInsightPage( $this->subpage ) ) {
			$this->renderSubpage();
		} elseif ( !empty( $this->subpage ) ) {
			$this->response->redirect( $this->getSpecialInsightsUrl() );
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

		$this->model = $helper->getInsightModel( $this->subpage );
		/**
		 * A model for insights should implement at least 3 methods:
		 * - getContent() - returning all the visible data
		 * - getData() - returning all the helping data
		 * - getTemplate() - returning an overriding template
		 */
		if ( $this->model instanceof InsightsPageModel ) {
			$params = $this->request->getParams();
			$this->model->initModel( $params );
			$this->setVal( 'content', $this->model->getContent( $params ) );
			$this->preparePagination();
			$this->prepareSortingData();
			$this->renderFlagsFiltering();
			$this->setVal( 'data', $this->model->getViewData() );
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
			$flagTypeId = $this->request->getVal( 'flagTypeId' );

			$params = [ 'flag_targeting' => \Flags\Models\FlagType::FLAG_TARGETING_CONTRIBUTORS ];
			$flagTypes = $this->app->sendRequest( 'FlagsApiController', 'getFlagTypes', $params )->getData()['data'];
			
			$this->setVal( 'selectedFlagTypeId', $flagTypeId );
			$this->setVal( 'flagTypes', $flagTypes );
		}
	}

	/**
	 * Setup method for Insights_loopNotification.mustache template
	 */
	public function loopNotification() {

		$subpage = $this->request->getVal( 'insight', null );
		if ( InsightsHelper::isInsightPage( $subpage ) ) {
			$model = InsightsHelper::getInsightModel( $subpage );
			if ( $model instanceof InsightsQueryPageModel ) {
				$params = [];
				$type = '';
				$isFixed = false;
				$articleName = $this->getVal( 'article', null );
				$title = Title::newFromText( $articleName );
				$next = $model->getNextItem( $model->getInsightType(), $articleName );

				$isEdit = $this->request->getBool( 'isEdit', false );

				if( !$isEdit ) {
					$isFixed = $model->isItemFixed( $title );
					if ( $isFixed ) {
						$model->updateInsightsCache( $title->getArticleId() );
					}
				}

				if ( $isEdit ) {
					$params = $this->getInProgressNotificationParams( $subpage, $model );
					$type = self::FLOW_STATUS_INPROGRESS;
				} elseif ( !$isFixed ) {
					$params = $this->getNotFixedNotificationParams( $subpage, $title, $model );
					$type = self::FLOW_STATUS_NOTFIXED;
				} elseif ( $isFixed && empty( $next ) ) {
					$params = $this->getCongratulationsNotificationParams( $subpage );
					$type = self::FLOW_STATUS_ALLDONE;
				} elseif ( $isFixed ) {
					$params = $this->getInsightFixedNotificationParams( $subpage, $next );
					$type = self::FLOW_STATUS_FIXED;
				}

				$this->setMustacheParams( $params, $isFixed, $type );

			} elseif ( $model instanceof InsightsPageModel ) {
				$isFixed = false;
				$isEdit = $this->request->getBool( 'isEdit', false );
				/* Show in progress notification when in view mode of article */
				if ( !$isEdit ) {
					$params = $model->getInProgressNotificationParams();
					if ( is_array( $params ) ) {
						$type = self::FLOW_STATUS_NOTFIXED;
						$this->setMustacheParams( $params, $isFixed, $type );
					}
				}

			}
		}
	}

	/**
	 *  Set mustache template
	 * @param Array $params
	 * @param bool $isFixed
	 * @param String $type
	 */
	private function setMustacheParams( $params, $isFixed, $type ) {
		$html = MustacheService::getInstance()->render(
			'extensions/wikia/Insights/templates/Insights_loopNotification.mustache',
			$params
		);

		$this->response->setData([
			'html' => $html,
			'isFixed' => $isFixed,
			'notificationType' => $type
		]);
	}


	/**
	 * Get params for notification template shown in edit mode
	 *
	 * @param string $subpage Insights subpage
	 * @param InsightsQueryPageModel $model
	 * @return array
	 */
	private function getInProgressNotificationParams( $subpage, InsightsQueryPageModel $model ) {
		$params = $this->getInsightListLinkParams( $subpage );
		$params['notificationMessage'] = wfMessage( InsightsHelper::INSIGHT_INPROGRESS_MSG_PREFIX . $subpage )->plain();

		if ( $model->getLoopNotificationConfig( 'displayFixItMessage' ) ) {
			$params['fixItMessage'] = wfMessage( 'insights-notification-message-fixit' )->plain();
		}

		return $params;
	}

	/**
	 * Get params for notification template shownwhen user dont fix an issue
	 *
	 * @param string $subpage Insights subpage
	 * @param Title $title
	 * @param InsightsQueryPageModel $model
	 * @return array
	 */
	private function getNotFixedNotificationParams( $subpage, Title $title, InsightsQueryPageModel $model ) {
		$params = $this->getInsightListLinkParams( $subpage );

		if ( $model->getLoopNotificationConfig( 'displayFixItMessage' ) ) {
			$params = array_merge( $params, $this->getInsightFixItParams( $title, $model ) );
		}

		$params['notificationMessage'] = wfMessage( InsightsHelper::INSIGHT_INPROGRESS_MSG_PREFIX . $subpage )->plain();

		return $params;
	}

	/**
	 * Get params for notification template shown when user fix all issues in given insight type
	 */
	private function getCongratulationsNotificationParams() {
		$params = $this->getInsightLinkParams();
		$params['notificationMessage'] = wfMessage( 'insights-notification-message-alldone' )->plain();

		return $params;
	}

	/**
	 * Get params for notification template shown when user fix one issue from the insights list
	 *
	 * @param string $subpage Insights subpage
	 * @param array $next An array with a url and text for a link to the next item
	 * @return array
	 */
	private function getInsightFixedNotificationParams( $subpage, $next ) {
		$params = $this->getInsightNextLinkParams( $subpage, $next );
		$params = array_merge( $params, $this->getInsightListLinkParams( $subpage ));
		$params['notificationMessage'] = wfMessage( InsightsHelper::INSIGHT_FIXED_MSG_PREFIX . $subpage )->plain();

		return $params;
	}

	/**
	 * Get params to generate next item link in notification template
	 *
	 * @param String $subpage Insights subpage
	 * @param array $next An array with a url and text for a link to the next item
	 * @return array
	 */
	private function getInsightNextLinkParams( $subpage, $next ) {
		return [
			'nextArticleText' => wfMessage( 'insights-notification-next-item-' . $subpage )->plain(),
			'nextArticleTitle' => $next['link']['text'],
			'nextArticleLink' => $next['link']['url']
		];
	}

	/**
	 * Get params to generate link back to edit mode
	 *
	 * @param Title $title
	 * @param InsightsQueryPageModel $model
	 * @return array
	 */
	private function getInsightFixItParams( Title $title, InsightsQueryPageModel $model ) {
		$link = InsightsHelper::getTitleLink( $title, $model->getUrlParams() );

		return [
			'editPageText' => wfMessage( 'insights-notification-message-fixit' )->plain(),
			'editPageLink' => $link['url']
		];
	}

	/**
	 * Get params to generate link to insight list in notification template
	 *
	 * @param String $subpage Insights subpage
	 * @return array
	 */
	public function getInsightListLinkParams( $subpage ) {
		return [
			'insightsPageText' => wfMessage( 'insights-notification-list-button' )->plain(),
			'insightsPageLink' => $this->getSpecialInsightsUrl( $subpage )
		];
	}

	/**
	 * Get params to generate link to insight main page in notification template
	 */
	private function getInsightLinkParams() {
		return [
			'insightsPageText' => wfMessage( 'insights-notification-see-more' )->plain(),
			'insightsPageLink' => $this->getSpecialInsightsUrl()
		];
	}

	/**
	 * Prepare pagination
	 */
	private function preparePagination() {
		$total = $this->model->getTotalResultsNum();
		$itemsPerPage = $this->model->getLimitResultsNum();
		$params = array_merge( $this->model->getPaginationUrlParams(), [ 'page' => '%s' ] );

		$sorting = $this->request->getVal( 'sort', null );
		if ( $sorting ) {
			$params['sort'] = $sorting;
		}

		if( $total > $itemsPerPage ) {
			$paginator = Paginator::newFromArray( array_fill( 0, $total, '' ), $itemsPerPage, 3, false, '',  InsightsPageModel::INSIGHTS_LIST_MAX_LIMIT );
			$paginator->setActivePage( $this->model->getPage() );
			$url = urldecode( $this->getSpecialInsightsUrl( $this->subpage, $params ) );
			$this->paginatorBar = $paginator->getBarHTML( $url );
		}
	}

	/**
	 * Prepare data needed to sort list
	 */
	private function prepareSortingData() {
		$dropdown = [];

		if( $this->model->arePageViewsRequired() ) {
			$sort = $this->request->getVal( 'sort', $this->model->getDefaultSorting() );

			/**
			 * Used to create the following messages:
			 *
			 * 'insights-list-pv7',
			 * 'insights-list-pv28',
			 * 'insights-list-pvDiff',
			 * 'insights-list-title'
			 */
			foreach ( $this->model->sorting as $key => $sorting ) {
				$dropdown[ $key ] = wfMessage( 'insights-sort-' . $key )->escaped();
			}

			$this->current = $sort;
			$this->metadata = isset( $this->model->sorting[ $sort ]['metadata'] )
				? $this->model->sorting[ $sort ]['metadata']
				: $sort;
		}

		$this->dropdown = $dropdown;
	}

	private function addAssets() {
		$this->response->addAsset( '/extensions/wikia/Insights/styles/insights-lists.scss' );
		$this->response->addAsset( '/extensions/wikia/Insights/scripts/InsightsPage.js' );
	}

	/**
	 * Get Special:Insights full url
	 *
	 * @return string
	 */
	private function getSpecialInsightsUrl( $subpage = false, $params = [] ) {
		return $this->specialPage->getTitle( $subpage )->getFullURL( $params );
	}
}
