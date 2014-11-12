<?php

class ArticleNavigationController extends WikiaController {

	public function index() {
		Wikia::addAssetsToOutput( 'article_navigation_scss' );
		Wikia::addAssetsToOutput( 'article_navigation_js' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->editActionsDropdown = $this->renderEditActions();
	}

	private function renderEditActions() {
		return \MustacheService::getInstance()->render(
			'resources/wikia/ui_components/dropdown_navigation/templates/dropdown_navigation.mustache',
			$this->editActionsData()
		);
	}

	private function editActionsData() {
		$contentActions = $this->app->getSkinTemplateObj()->data['content_actions'];

		$editActions = [];

		if ( isset( $contentActions['edit'] ) ) {
			array_push( $editActions, 'edit' );
		}
		else if ( isset( $contentActions['viewsource'] ) ) {
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
			'history', 'move', 'protect', 'unprotect', 'delete', 'undelete', 'replace-file'
		] );

		$actions = [];

		foreach ( $allowedActions as $action ) {
			if ( isset( $contentActions[$action] ) ) {
				$contentAction = $contentActions[$action];

				$data = [
					'href' => $contentAction['href'],
					'title' => $contentAction['text'],
					'referenceId' => $contentAction['id'],
				];

				if ( isset( $contentAction['rel'] ) ) {
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
}
