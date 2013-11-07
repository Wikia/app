<?php

class WikiaMobileEditorController extends WikiaController{

	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * @brief Returns true
	 * @details Adds assets needed on Edit page on WikiaMobile skin
	 *
	 * @return true
	 */
	public static function onWikiaMobileAssetsPackages( &$head, &$body, &$scss ){

        $action = F::app()->wg->Request->getVal( 'action' );

		if ( $action == 'edit' || $action == 'submit') {
			$body[] = 'wikiamobile_editor_js';
			$scss[] = 'wikiamobile_editor_scss';
		}

		return true;
	}

	/**
	 * @brief Returns true
	 * @details This function doesn't actually do anything - handler for MediaWiki hook
	 *
	 * @param OutputPage &$out MediaWiki OutputPage passed by reference
	 * @param string &$text The article contents passed by reference
	 *
	 * @return true
	 */
	public static function onEditPageInitial( EditPage $editPage ) {
		$app = F::app();

		if ( $app->checkSkin( 'wikiamobile' ) ) { $editPage->editFormTextBottom .= F::app()->renderView( __CLASS__, 'editPage' );
		}

		return true;
	}

	public function editPage(){
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );
	}

	public function tagList(){
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );
	}
}