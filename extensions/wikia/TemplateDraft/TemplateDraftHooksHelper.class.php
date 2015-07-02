<?php

class TemplateDraftHooksHelper {

	/**
	 * Attaches a new module to right rail which is an entry point to convert a given template.
	 * Contains logic to decide whether display a module and what kind of module
	 * @param array $railModuleList
	 */
	public function addRailModuleList( Array &$railModuleList ) {
		$title = $this->getGlobalTitle();
		$helper = $this->getTemplateDraftHelper();
		if ( $helper->allowedForTitle( $title ) ) {
			if ( $helper->isTitleDraft( $title ) ) {
				/*
				 * $title is draft page
				 * Add rail module for draft approval
				 */
				$this->addRailModule( $railModuleList, 'Approve' );
			} else {
				/*
				 * $title is parent page
				 * Add rail module for draft creation
				 */
				$this->addRailModule( $railModuleList, 'Create' );
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
