<?php

class SpecialCreateFromTemplate extends RecipesTemplate {

	function __construct() {
		global $wgRequest, $wgTitle;

		parent::__construct('CreateFromTemplate', '' /* no restriction */, true /* listed */);

		$bits = explode( '/', $wgTitle->getDBkey(), 2 );
		if ( !empty( $bits[1] ) ) {
			$this->mType = $bits[1];
		} else {
			$this->mType = $wgRequest->getText( 'type' );
		}

		// setup list of fields for recipe form
		$key = "recipes-template-{$this->mType}-fields";
		$fieldsRaw = wfMsgForContent( $key );
//		if ( wfMsgEmpty( $key, $fieldsRaw ) ) {
//			return null;
//		}
		
		$this->mFields = array();
		$parent = '';
		$fieldsRaw = explode( "\n", $fieldsRaw );
		foreach ( $fieldsRaw as $row ) {
			if ( strpos( $row, '* ' ) === 0 ) {
				$row = trim( $row, '* ' );
				$this->mFields[$row] = array();
				$parent = $row;
			} elseif ( strpos( $row, '** ' ) === 0 ) {
				$row = trim( $row, '** ' );
				$row = explode( '|', $row );
				$row[1] = ( $row[1] === 'true' ) ? true : $row[1];
				$row[1] = ( $row[1] === 'false' ) ? false : $row[1];
				$this->mFields[$parent][$row[0]] = $row[1];

			}
			// other cases are ignored
		}
	}

	/**
	 * Get wikitext for create form
	 */
	public function getWikitext() {
		return wfMsg("recipes-template-{$this->mType}-wikitext");
	}

	/**
	 * Format given title to follow specs of create form
	 */
	public function formatPageTitle($title) {
		return $title;
	}

	/**
	 * Get edit summary of given create form
	 */
	protected function getEditSummary() {
		return wfMsg("recipes-template-{$this->mType}-edit-summary");
	}
}
