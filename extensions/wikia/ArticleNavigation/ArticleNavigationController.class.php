<?php

class ArticleNavigationController extends WikiaController {

	public function index() {
		$app = F::app();

		Wikia::addAssetsToOutput( 'article_navigation_scss' );
		Wikia::addAssetsToOutput( 'article_navigation_js' );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->editActionsDropdown = $this->renderEditActions();

		$this->setVal('share_type', 'multiple');
		$this->setVal('share', $app->renderView('ArticleNavigationController', 'share'));
	}

	private function renderEditActions() {
		return \MustacheService::getInstance()->render(
			'resources/wikia/ui_components/dropdown_navigation/templates/dropdown_navigation.mustache',
			$this->editActionsData()
		);
	}

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
					'referenceId' => $contentAction['id'],
				];

				if (isset($contentAction['rel'])) {
					$data['rel'] = $contentAction['rel'];
				}

				$actions[] = $data;
			}
		}
		return [
			'id' => 'editActionsDropdown',
			'data' => $actions,
		];
	}

	public function share() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->services = $this->prepareShareServicesData();
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
}
