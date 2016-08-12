<?php

namespace Wikia\Tasks\Tasks;

// TODO jobqueue: On removing the old task, clean up app/maintenance/updateSpecialPages.php
class UpdateSpecialPagesTask extends BaseTask {

	/** @see BaseTask::getAdminExecuteableMethods */
	public function getAdminExecuteableMethods() {
		return ['enqueue'];
	}

	/**
	 * Enqueue a task to rebuild the special pages localization cache
	 *
	 * @param string $wikiaDomain The domain name of the wikia in need of a cache rebuild
	 * @return string Generated task ID for the rebuild task
	 * @throws \InvalidArgumentException
	 */
	public function enqueue( $wikiaDomain ) {
		$wikiaDomain = \Wikia::fixDomainName( $wikiaDomain );

		$wikiId = \WikiFactory::DomainToID( $wikiaDomain );

		if ( !$wikiId ) {
			// TODO localize?
			throw new \InvalidArgumentException( "No wikia exists for domain {$wikiaDomain}" );
		}

		$localizationTask = new UpdateSpecialPagesTask();
		$localizationTask->wikiId( $wikiId );
		$localizationTask->call( 'rebuildLocalizationCache' );
		return $localizationTask->queue();
	}

	/**
	 * Update the special pages localization cache
	 */
	public function rebuildLocalizationCache() {
		global $IP, $wgSpecialPageCacheUpdates, $wgQueryPages, $wgQueryCacheLimit, $wgDisableQueryPageUpdate;

		$dbw = wfGetDB( DB_MASTER );

		foreach ( $wgSpecialPageCacheUpdates as $special => $call ) {
			if ( !is_callable( $call ) ) {
				throw new \InvalidArgumentException( "Uncallable function '{$call}' for special page {$special}" );
			}
			$start = wfTime();
			call_user_func( $call, $dbw );
			$end = wfTime();
			$this->info( sprintf("%-30s completed in %.2fs", $special, $end - $start) );

			// Wait for the slave to catch up
			wfWaitForSlaves();
		}

		// This is needed to initialise $wgQueryPages
		require_once( "$IP/includes/QueryPage.php" );

		$disabledPages = ( $wgDisableQueryPageUpdate ? array_flip($wgDisableQueryPageUpdate) : [] );
		foreach ( $wgQueryPages as $page ) {
			list( $class, $special ) = $page;

			$limit = ( isset($page[2]) ? $page[2] : $wgQueryCacheLimit );

			$queryPage = $this->getQueryPage( $special, $class );

			if ( array_key_exists($special, $disabledPages) ) {
				// skip disabled pages
				$this->info( sprintf("%-30s disabled", $special) );
				continue;
			}
			if ( !$queryPage->isExpensive() ) {
				// don't bother with cheap pages
				$this->info( sprintf("%-30s skipped", $special) );
				continue;
			}

			$start = wfTime();
			$num = $queryPage->recache( $limit );
			$end = wfTime();
			if ( $num === false ) {
				throw new \DBError( $dbw, "database error" );
			}
			$this->info( sprintf("%-30s updated %d rows in %.2fs", $special, $num, $end - $start) );

			if ( wfGetLB()->pingAll() ) {
				// commit the changes if all connections are still open
				$dbw->commit();
			} else {
				// Reopen any connections that have closed
				$count = 6;
				do {
					sleep( 10 );
				} while ( ($count-- > 0) && !wfGetLB()->pingAll() );
			}

			// Wait for the slave to catch up
			wfWaitForSlaves();

			// SUS-832: Run post-transaction hook once the DB transactions are finished
			\Hooks::run( 'AfterUpdateSpecialPages', [ $queryPage ] );
		}
	}

	/**
	 * Get the query page associated with a special page
	 *
	 * @param string $special
	 * @param string $class
	 * @return \QueryPage
	 * @throws \InvalidArgumentException if no special page with the given name exists
	 */
	protected function getQueryPage( $special, $class ) {
		$queryPage = \SpecialPageFactory::getPage( $special );

		if ( !$queryPage ) {
			throw new \InvalidArgumentException( "No such special page: {$special}" );
		}

		if ( !($queryPage instanceof \QueryPage) ) {
			if ( !class_exists($class) ) {
				require_once( $queryPage->getFile() );
			}
			$queryPage = new $class();
		}

		return $queryPage;
	}
}
