<?php
/**
 * Replacement task for the core RefreshLinksJob.
 */

namespace Wikia\Tasks\Tasks;

class RefreshLinksForTitleTask extends BaseTask {

	public function refresh() {
		if ( is_null( $this->title ) ) {
			return false;
		}

		$revision = $this->getRevisionFromTitle();
		if ( !$revision ) {
			return false;
		}

		$this->parseRevisionAndUpdateLinks( $revision );
		return true;
	}

	protected function getRevisionFromTitle() {
		return Revision::newFromTitle( $this->title );
	}

	public function setTitle( \Title $title ) {
		$this->title = $title;
		return $this;
	}

	public function parseRevisionAndUpdateLinks( \Revision $revision ) {
		$parserOutput = $this->parseRevisionText( $revision );
		$this->updateLinks( $parserOutput );
	}

	public function updateLinks( $parserOutput ) {
		$update = new \LinksUpdate( $this->title, $parserOutput, false );
		$update->doUpdate();
	}

	protected function parseRevisionText( \Revision $revision ) {
		$options = $this->getParserOptions();
		return $this->getParser()->parse( $revision->getText(), $this->title, $options, true, true, $revision->getId() );
	}

	protected function getParserOptions() {
		return ParserOptions::newFromUserAndLang( new \User, $this->getLanguage() );
	}

	protected function getParser() {
		global $wgParser;
		return $wgParser;
	}

	protected function getLanguage() {
		global $wgContLang;
		return $wgContLang;
	}
}
