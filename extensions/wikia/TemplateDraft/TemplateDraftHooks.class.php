<?php

class TemplateDraftHooks {

	/**
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return bool
	 */
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		// TODO check and add only when one of template draft modules are loaded
		Wikia::addAssetsToOutput( 'templatedraft_js' );
		return true;
	}

	/**
	 * Attaches a new module to right rail which is an entry point to convert a given template.
	 *
	 * @param array $railModuleList
	 * @return bool
	 */
	public static function onGetRailModuleList( Array &$railModuleList ) {
		global $wgTitle;

		if ( $wgTitle->getNamespace() === NS_TEMPLATE
			&& $wgTitle->exists()
			&& Wikia::getProps( $wgTitle->getArticleID(), TemplateDraftController::TEMPLATE_INFOBOX_PROP ) !== 0
		) {
			$railModuleList[1502] = [ 'TemplateDraftModule', 'Index', null ];
		}

		return true;
	}

	/**
	 * Triggered if a user edits a Draft subpage of a template.
	 * It pre-fills the content of the Draft with a converted markup.
	 *
	 * @param $text
	 * @param Title $title
	 * @return bool
	 */
	public static function onEditFormPreloadText( &$text, Title $title ) {
		$helper = new TemplateDraftHelper();
		if ( $helper->isTitleDraft( $title ) ) {
			$parentTitleId = $helper->getParentTitle( $title )->getArticleID();

			if ( $parentTitleId > 0 ) {
				$parentContent = WikiPage::newFromID( $parentTitleId )->getText();

				/**
				 * TODO: Introduce a parameter to modify conversion flags
				 * If you want to perform different conversions, not only the infobox one,
				 * you can introduce a URL parameter to control the binary sum of flags.
				 */
				$controller = new TemplateDraftController();
				$text = $controller->createDraftContent(
					$title, // @TODO this is currently taking the *edited* title (with subpage), not the *converted* title  
					$parentContent,
					[ $controller::TEMPLATE_INFOBOX ]
				);
			}
		}
		return true;
	}

	/**
	 * Triggered if a user edits a Draft subpage of a template.
	 * It adds an editintro message with help and links.
	 *
	 * @param String $msgName
	 * @param Array $msgParams 
	 * @param Title $title
	 * @return bool
	 */
	public static function onEditPageLayoutShowIntro( &$msgName, &$msgParams, Title $title ) {
		$helper = new TemplateDraftHelper();

		if ( $helper->isTitleDraft( $title ) 
			&& class_exists( 'TemplateConverter' )
			&& TemplateConverter::isConversion() ) {
			$msgName = 'templatedraft-editintro';

			$base = Title::newFromText( $title->getBaseText(), NS_TEMPLATE );
			$msgParams = [ $base->getFullUrl( ['action' => 'edit'] ) ];
		}

		return true;
	}
}
