<?php

class TemplateDraftHooksHelper {

	public function addRailModuleList( Array &$railModuleList ) {
		$title = $this->getGlobalTitle();
		if ( $title->exists() && $title->getNamespace() === NS_TEMPLATE ) {
			$helper = $this->getTemplateDraftHelper();
			if ( $helper->isTitleDraft( $title ) ) {
				$parentTitle = $helper->getParentTitle( $title );
				if ( $parentTitle->userCan( 'templatedraft' ) && $helper->isMarkedAsInfobox( $parentTitle ) ) {
					/* Rail module for draft approval */
					$railModuleList[1502] = [ 'TemplateDraftModule', 'Approve', null ];
				}
			} else {
				if ( $title->userCan( 'templatedraft' ) && $helper->isMarkedAsInfobox( $title ) ) {
					/* Rail module for draft creation */
					$railModuleList[1502] = [ 'TemplateDraftModule', 'Create', null ];
				}
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
