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
		Wikia::addAssetsToOutput( 'article_js' );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->setVal( 'editActionsDropdown', $this->renderEditActions() );
		$this->setVal( 'share', $app->renderView( 'ArticleNavigationController', 'share' ) );
		$this->setVal( 'userTools', json_encode( $this->helper->extractDropdownData( $this->generateUserTools() ) ) );
	}

	/**
	 * Render Dropdown for Edit Actions
	 * @return string
	 * @throws Exception
	 */
	private function renderEditActions() {
		/**
		 * Use Mustache render and not renderView because template is outside of extension's
		 * directory and we want to show that explicitly; it's also a bit faster than doing
		 * callback just for render small Mustache template anyway.
		 */
		return \MustacheService::getInstance()->render( 
			'resources/wikia/ui_components/dropdown_navigation/templates/dropdown.mustache',
			$this->editActionsData()
		);
	}

	/**
	 * Prepare data for edit actions
	 * @return array
	 */
	private function editActionsData() {
		global $wgUser, $wgTitle;

		$contentActions = $this->app->getSkinTemplateObj()->data['content_actions'];
		$editActions = [];

		if ( isset( $contentActions['edit'] ) ) {
			array_push( $editActions, 'edit' );
		} else if ( isset( $contentActions['viewsource'] ) ) {
			array_push( $editActions, 'viewsource' );
		}

		if ( isset( $contentActions['ve-edit'] ) ) {
			if ( $contentActions['ve-edit']['main'] ) {
				array_unshift( $editActions, 've-edit' );
			} else {
				array_push( $editActions, 've-edit' );
			}
		}

		$allowedActions = array_merge( $editActions, [
			'history', 'move', 'protect', 'unprotect', 'delete', 'undelete', 'replace-file', 'talk'
		] );

		$actions = [];

		foreach ( $allowedActions as $action ) {
			if ( isset( $contentActions[$action] ) ) {
				$contentAction = $contentActions[$action];

				$data = [
					'href' => $contentAction['href'],
					'title' => $contentAction['text'],
					'id' => $contentAction['id'],
					'accesskey' => $contentAction['accesskey']
				];

				if ( $wgUser->isAnon() &&
					!$wgUser->isBlocked() &&
					!$wgTitle->userCan( 'edit' ) &&
					$this->isEdit($contentAction)
				) {
					$data[ 'class' ] = 'force-user-login';
				}

				//Add custom values if talk item found
				if ( $contentAction['id'] == 'ca-talk' ) {
					$service = new PageStatsService($wgTitle->getArticleId());
					$count = $service->getCommentsCount();
					$commentsTalk = $this->sendRequest('CommentsLikes', 'getData', ['count' => $count])->getVal('data');
					$data['title'] = $commentsTalk['title'] . " <span class='comments-talk-counter'>" . $commentsTalk['formattedCount'] . "</span>";
					$data['href'] = $commentsTalk['href'];
					$data['tooltip'] = $commentsTalk['title'];
				}

				if ( isset( $contentAction['rel'] ) ) {
					$data['rel'] = str_replace( 'ca-', '', $contentAction['rel'] );
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

		$this->setVal( 'services', $this->prepareShareServicesData() );
		$this->setVal( 'dropdown', $this->renderShareActions() );
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
		$lang = $this->helper->getUserLanguageCode( $this->request );

		foreach ( $wgArticleNavigationShareServices as $service ) {
			if ( $this->helper->isValidShareService( $service, $lang ) ) {
				$service['href'] = str_replace( '$1', urlencode( $location ), $service['url'] );
				$service['nameCased'] = ucfirst( $service['name'] );

				if ( !array_key_exists( 'title', $service ) ) {
					$service['title'] = $service['nameCased'];
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
		/**
		 * Use Mustache render and not renderView because template is outside of extension's
		 * directory and we want to show that explicitly; it's also a bit faster than doing
		 * callback just for render small Mustache template anyway.
		 */
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

		foreach ( $this->prepareShareServicesData() as $service ) {
			$data = [
				'href' => $service['href'],
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
			'data', $this->helper->extractDropdownData( $this->generateUserTools() )
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

		if (!WikiaPageType::isWikiaHubMain()) {
			$renderedData[] = $this->sendRequest(
				'ArticleNavigationContributeMenu',
				'getContributeActionsForDropdown'
			)->getVal('data');
		}

		$dataInArr = $service->instanceToRenderData( $service->listToInstance( $data ) );
		foreach ($dataInArr as $item) {
			$renderedData[] = $item;
		}

		if ( $wgUser->isAllowed( 'admindashboard' ) ) {
			$renderedData[] = [
				'tracker-name' => 'admin',
				'caption' => 'Admin',
				'href' => SpecialPage::getTitleFor( 'AdminDashboard' )->getLocalURL(),
				'type' => 'link'
			];
		}

		return $renderedData;
	}

	private function isEdit($data) {
		return !empty($data['id']) && ($data['id'] == 'ca-viewsource');
	}
}
