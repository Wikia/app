<?php

class TemplateDraftHooksHelper {

	public function addRailModuleList( Array &$railModuleList ) {
		$title = $this->getGlobalTitle();
		$helper = $this->getTemplateDraftHelper();

		if ( $title->userCan( 'templatedraft' )
			&& $title->getNamespace() === NS_TEMPLATE
			&& $title->exists()
			&& !$helper->isTitleDraft( $title )
			&& $helper->isMarkedAsInfobox( $title )
		) {
			$helper = new TemplateDraftHelper();
			if ( $helper->isTitleDraft( $title ) ) {
				/* Rail module for draft approval */
				$railModuleList[1502] = [ 'TemplateDraftModule', 'Approve', null ];
			} else {
				/* Rail module for draft creation */
				$railModuleList[1502] = [ 'TemplateDraftModule', 'Create', null ];
			}
		}
	}

	protected function getGlobalTitle() {
		global $wgTitle;
		return $wgTitle;
	}

	protected function getTemplateDraftHelper() {
		return new TemplateDraftHelper();
	}
}
