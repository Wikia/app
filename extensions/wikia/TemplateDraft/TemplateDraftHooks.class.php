<?php

class TemplateDraftHooks {

	/**
	 * Attaches a new module to right rail which is an entry point to convert a given template.
	 *
	 * @param array $railModuleList
	 * @return bool
	 */
	public static function onGetRailModuleList( Array &$railModuleList ) {
		global $wgTitle;

		/* Logic for determining whether template is infobox */
		$titleNeedle = 'infobox';
		if ( $wgTitle->getNamespace() === NS_TEMPLATE
			&& $wgTitle->exists()
			&& strripos( $wgTitle->getText(), $titleNeedle ) !== false
			&& Wikia::getProps( $wgTitle->getArticleID(), TemplateDraftController::TEMPLATE_INFOBOX_PROP ) !== 0
		) {
			$helper = new TemplateDraftHelper();
			if ( $helper->isTitleDraft( $wgTitle ) ) {
				/* Rail module for draft approval */
				$railModuleList[1502] = [ 'TemplateDraftModule', 'Approve', null ];
			} else {
				/* Rail module for draft creation */
				$railModuleList[1502] = [ 'TemplateDraftModule', 'Create', null ];
			}
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
					$parentContent,
					[ $controller::TEMPLATE_INFOBOX ]
				);
			}
		}
		return true;
	}
}
