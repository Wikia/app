<?php
/**
 * Replacement task for the core RefreshLinksJob.
 *
 * This job is created by \LinksUpdate::queueRefreshTasks
 */

namespace Wikia\Tasks\Tasks;

use LinkBatch;
use LinksUpdate;
use ParserCache;
use ParserOutput;
use Revision;
use WikiPage;

class BatchRefreshLinksForTemplate extends BaseTask {

	/**
	 * The maximum number of titles to refresh in a single task execution.
	 */
	public const TITLES_PER_TASK = 50;

	/**
	 * Delay (in seconds) to apply when considering if a cache, edit etc. timestamp is up to date relative to the time this task was scheduled,
	 * to account for clock skew and replication lag.
	 */
	private const CLOCK_SKEW_DELAY_SECONDS = 10;

	/**
	 * Perform links updates for pages in the current batch.
	 * This will be a no-op if the page that triggered this recursive update has been edited since.
	 *
	 * @param int $start start offset ID of this batch in the templatelinks table
	 * @param int $end end offset ID of this batch in the templatelinks table
	 * @param string $taskScheduledTime time this task was published
	 * @param int $triggeringRevisionId ID of the revision that was created in the edit that triggered this update
	 * @throws \MWException
	 */
	public function refreshTemplateLinks(
		int $start,
		int $end,
		string $taskScheduledTime,
		int $triggeringRevisionId
	): void {
		// If the page whose change triggered this recursive RefreshLinks task has been edited since this task was scheduled,
		// the new edit will have enqueued its own set of RefreshLinks tasks so nothing needs to be done here.
		if ( $this->title->getLatestRevID() !== $triggeringRevisionId ) {
			return;
		}

		$titles = $this->title->getLinksFromBacklinkCache( 'templatelinks', $start, $end );

		$linkBatch = new LinkBatch();

		foreach ( $titles as $title ) {
			$linkBatch->addObj( $title );
		}

		if ( $linkBatch->isEmpty() ) {
			return; // sanity
		}

		$dbr = wfGetDB( DB_REPLICA );
		$res = $dbr->select(
			[ 'page', 'revision' ],
			array_merge( Revision::selectFields(), WikiPage::selectFields() ),
			$linkBatch->constructSet( 'page', $dbr ),
			__METHOD__,
			[],
			[ 'revision' => [ 'INNER JOIN', 'page_latest = rev_id' ] ]
		);

		// Adjust task scheduled time to account for replication lag / clock skew in freshness checks
		$skewedTaskScheduledTime = wfTimestamp(
			TS_MW, wfTimestamp( TS_UNIX, $taskScheduledTime ) + self::CLOCK_SKEW_DELAY_SECONDS
		);

		foreach ( $res as $row ) {
			$this->process( $row, $skewedTaskScheduledTime );
		}

		return;
	}

	/**
	 * Perform the links update on a given page in the current batch.
	 * If the page has been edited recently enough, this will be a no-op.
	 *
	 * @param object $row DB result row containing WikiPage and Revision required fields
	 * @param string $skewedTaskScheduledTime the time this task was scheduled, adjusted for clock skew/replication lag
	 * @throws \MWException
	 */
	private function process( object $row, string $skewedTaskScheduledTime ): void {
		$wikiPage = WikiPage::newFromRow( $row );
		$revision = Revision::newFromRow( $row );

		// If the page to be refreshed has been edited since the change that triggered this recursive RefreshLinks task,
		// the edit will have already refreshed links tables and we have nothing to do.
		if ( $revision->getTimestamp() >= $skewedTaskScheduledTime ) {
			return;
		}

		$parserOutput = $this->getParserOutput( $wikiPage, $revision, $skewedTaskScheduledTime );

		$linksUpdate = new LinksUpdate( $wikiPage->getTitle(), $parserOutput, false /* recursive */ );
		$linksUpdate->doUpdate();
	}

	/**
	 * Get the rendered parser output for the given revision.
	 * The parser output will be fetched from cache if the page was updated recently enough.
	 * If the page is too stale or no up-to-date cached parser output is found, a fresh re-parse occurs.
	 *
	 * @param WikiPage $wikiPage
	 * @param Revision $revision
	 * @param string $skewedTaskScheduledTime
	 * @return ParserOutput
	 */
	private function getParserOutput(
		WikiPage $wikiPage,
		Revision $revision,
		string $skewedTaskScheduledTime
	): ParserOutput {
		global $wgParser;

		$title = $wikiPage->getTitle();
		$parserOptions = $wikiPage->makeParserOptions( 'canonical' );
		$parserCache = ParserCache::singleton();

		// Page is too stale; re-parse it now.
		if ( $wikiPage->getTouched() < $skewedTaskScheduledTime ) {
			return $wgParser->parse( $revision->getText(), $title, $parserOptions, true, true, $revision->getId() );
		}

		$parserOutput = $parserCache->getDirty( $wikiPage, $parserOptions );

		// If a sufficiently recent parser output exists in the cache, we can re-use it and avoid an uncached parse.
		if (
			$parserOutput &&
			$parserOutput->getTimestamp() === $revision->getTimestamp() &&
			$parserOutput->getCacheTime() >= $skewedTaskScheduledTime
		) {
			return $parserOutput;
		}

		// no cached parser output found or it is too stale; re-parse the text now
		return $wgParser->parse( $revision->getText(), $title, $parserOptions, true, true, $revision->getId() );
	}
}
