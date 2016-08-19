<?php
/**
 * Replacement task for the core RefreshLinksJob.
 */

namespace Wikia\Tasks\Tasks;

class RefreshLinksForTitleTask extends BaseTask {

	public function refresh() {
		$this->info( "refreshing links" );

		$revision = $this->getRevisionFromTitle();
		if ( !$revision ) {
			$this->error( "invalid RefreshLinksJob; no article/revision" );
			return false;
		}

		$this->parseRevisionAndUpdateLinks( $revision );
		return true;
	}

	protected function getRevisionFromTitle() {
		return \Revision::newFromTitle( $this->title );
	}

	public function parseRevisionAndUpdateLinks( \Revision $revision ) {
		$this->info( sprintf( "parsing revision and updating links for revision %d", $revision->getId() ) );
		$parserOutput = $this->parseRevisionText( $revision );

		wfRunHooks( 'BeforeRefreshLinksForTitleUpdate', [ $parserOutput, $revision ] );

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
		return \ParserOptions::newFromUserAndLang( new \User, $this->getLanguage() );
	}

	/**
	 * @return \Parser
	 */
	protected function getParser() {
		global $wgParser;
		return $wgParser;
	}

	protected function getLanguage() {
		global $wgContLang;
		return $wgContLang;
	}

	protected function getLoggerContext() {
		return [
			'task' => __CLASS__,
			'title' => $this->title->getPrefixedDBkey(),
		];
	}
}
