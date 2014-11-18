<?php

class ArticleNavigationController extends WikiaController {

	/**
	 * @var ArticleNavigationHelper
	 */
	private $helper;

	public function __construct() {
		parent::__construct();
		$this->helper = new ArticleNavigationHelper();
	}

	/**
	 * render index
	 */
	public function index() {
		$app = F::app();

		Wikia::addAssetsToOutput( 'article_navigation_scss' );
		Wikia::addAssetsToOutput( 'article_navigation_js' );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->setVal( 'edit_actions_dropdown', $this->renderEditActions() );
		$this->setVal( 'share', $app->renderView( 'ArticleNavigationController', 'share' ) );
		$this->setVal( 'user_tools', json_encode( $this->helper->extractDropdownData( $this->generateUserTools() ) ) );
	}

	/**
	 * Render Dropdown for Edit Actions
	 * @return string
	 * @throws Exception
	 */
	private function renderEditActions() {
		return \MustacheService::getInstance()->render(
			'resources/wikia/ui_components/dropdown_navigation/templates/dropdown.mustache',
			$this->editActionsData()
		);
	}

	/**
	 * Prepare data for edit actions
	 * @return array
	 */
	private function editActionsData()
	{
		$contentActions = $this->app->getSkinTemplateObj()->data['content_actions'];
		$editActions = [];

		if (isset($contentActions['edit'])) {
			array_push($editActions, 'edit');
		} else if (isset($contentActions['viewsource'])) {
			array_push($editActions, 'viewsource');
		}

		if (isset($contentActions['ve-edit'])) {
			if ($contentActions['ve-edit']['main']) {
				array_unshift($editActions, 've-edit');
			} else {
				array_push($editActions, 've-edit');
			}
		}

		$allowedActions = array_merge($editActions, [
			'history', 'move', 'protect', 'unprotect', 'delete', 'undelete', 'replace-file'
		]);

		$actions = [];

		foreach ($allowedActions as $action) {
			if (isset($contentActions[$action])) {
				$contentAction = $contentActions[$action];

				$data = [
					'href' => $contentAction['href'],
					'title' => $contentAction['text'],
					'trackingId' => $contentAction['id'],
				];

				if (isset($contentAction['rel'])) {
					$data['rel'] = str_replace('ca-', '', $contentAction['rel']);
				}

				$actions[] = $data;
			}
		}

		return [
			'id' => 'editActionsDropdown',
			'sections' => $actions,
		];
	}

	/**
	 * render share
	 */
	public function share() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->setVal('services', $this->prepareShareServicesData());
		$this->setVal('dropdown', $this->renderShareActions());
	}

	/**
	 * Prepare and normalize data from $wgArticleNavigationShareServices
	 *
	 * @return Array
	 */
	private function prepareShareServicesData() {
		global $wgArticleNavigationShareServices;

		$protocol = ( !empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) ? 'https://' : 'http://';
		$location = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$services = [];

		foreach ($wgArticleNavigationShareServices as $service ) {
			if ( array_key_exists( 'url', $service ) && array_key_exists( 'name', $service ) ) {
				$service['full_url'] = str_replace( '$1', urlencode( $location ), $service['url'] );
				$service['name_cased'] = ucfirst( $service['name'] );

				if ( !array_key_exists('title', $service ) ) {
					$service['title'] = $service['name_cased'];
				}

				$services[] = $service;
			}
		}

		return $services;
	}

	/**
	 * Render Share dropdown
	 * @return string
	 * @throws Exception
	 */
	private function renderShareActions() {
		return \MustacheService::getInstance()->render(
			'resources/wikia/ui_components/dropdown_navigation/templates/dropdown.mustache',
			$this->shareActionsData()
		);
	}

	/**
	 * Prepare data for share dropdown
	 * @return array
	 */
	private function shareActionsData()
	{
		$actions = [];

		foreach ($this->prepareShareServicesData() as $service) {
			$data = [
				'href' => $service['full_url'],
				'title' => $service['title'],
				'class' => 'share-link',
				'data' => [
					'share-name' => $service['name']
				]
			];

			$actions[] = $data;
		}

		return [
			'id' => 'shareActionsDropdown',
			'sections' => $actions,
		];
	}

	public function getUserTools() {
		$this->response->setVal(
			'data', $this->helper->extractDropdownData($this->generateUserTools())
		);
	}

	private function generateUserTools() {
		global $wgUser;

		$anonListItems = [
			'SpecialPage:Mostpopularcategories',
			'SpecialPage:WikiActivity',
			'SpecialPage:NewFiles'
		];

		$service = new SharedToolbarService();

		$data = [];

		if ( $wgUser->isAnon() ) {
			foreach ( $anonListItems as $listItem ) {
				$data[] = $service->buildListItem( $listItem );
			}
		} else {
			$data = $service->getVisibleList();
		}

		$renderedData = $service->instanceToRenderData( $service->listToInstance( $data ) );

		if ($wgUser->isAllowed('admindashboard')) {
			$renderedData[] = [
				'tracker-name' => 'admin',
				'caption' => 'Admin',
				'href' => SpecialPage::getTitleFor('AdminDashboard')->getLocalURL(),
				'type' => 'link'
			];
		}
		return $renderedData;
	}
}
