<?php
class MarketingToolboxWikiaspicksModel extends WikiaModel {
	protected $allowedTags = array('<a>', '<strong>');

	/**
	 * @desc Returns HTML tags which are allowed in the module's text field
	 * 
	 * @return String
	 */
	public function getAllowedTags() {
		return implode('', $this->allowedTags);
	}
	
}