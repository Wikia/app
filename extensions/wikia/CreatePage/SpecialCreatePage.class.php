<?php

/**
 * A special page to create a new article, using wysiwig editor
 */

class SpecialCreatePage extends SpecialCustomEditPage {

	public function __construct() {
		parent::__construct('CreatePage');
	}

	public function renderHeader($par) {
		$this->setPageTitle(wfMsg('createpage-sp-title'));
		$this->forceUserToProvideTitle('createpage_title_caption');

		// TODO: user needs to have "edit" right
	}

	/**
	 * Perform additional checks when saving an article
	 */
	protected function processSubmit() {
		// check for empty content
		if ( $this->contentStatus == EditPage::AS_BLANK_ARTICLE ) {
			$this->addEditNotice(wfMsg('createpage_empty_article_body_error'));
		}

		// check existance of selected article
		if ( $this->titleStatus == self::STATUS_ALREADY_EXISTS || $this->titleStatus == self::STATUS_INVALID ) {
			$this->addEditNotice(wfMsg('createpage_article_already_exists'));
		}

		if ( $this->titleStatus == self::STATUS_EMPTY ) {
			$this->addEditNotice(wfMsg('createpage_empty_title_error'));
		}
	}
}
