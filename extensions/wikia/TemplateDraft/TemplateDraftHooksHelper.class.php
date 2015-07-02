<?php

class TemplateDraftHooksHelper {

	/**
	 * Attaches a new module to right rail which is an entry point to convert a given template.
	 * Contains logic to decide whether display a module and what kind of module
	 * @param array $railModuleList
	 */
	public function addRailModuleList( Array &$railModuleList ) {
		$title = $this->getGlobalTitle();
		if ( $title->exists() && $title->getNamespace() === NS_TEMPLATE ) {
			$helper = $this->getTemplateDraftHelper();
			if ( $helper->isTitleDraft( $title ) ) {
				// $title is draft page
				$parentTitle = $helper->getParentTitle( $title );
				if (  $helper->isParentValid( $parentTitle )  ) {
					/* Rail module for draft approval */
					$this->addRailModule( $railModuleList, 'Approve' );
				}
			} else {
				// $title is parent page
				if ( $helper->isParentValid( $title ) ) {
					/* Rail module for draft creation */
					$this->addRailModule( $railModuleList, 'Create' );
				}
			}
		}
	}

	/**
	 * @return Title|null
	 */
	protected function getGlobalTitle() {
		global $wgTitle;
		return $wgTitle;
	}

	/**
	 * @return TemplateDraftHelper
	 */
	protected function getTemplateDraftHelper() {
		return new TemplateDraftHelper();
	}

	/**
	 * Add TemplateDraftModule to $railModuleList of provided name
	 * Modules are defined in TemplateDraftModuleController class
	 * @param array $railModuleList
	 * @param $moduleName
	 */
	private function addRailModule( Array &$railModuleList, $moduleName ) {
		$railModuleList[1502] = [ 'TemplateDraftModule', $moduleName, null ];
	}

}
