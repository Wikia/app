<?php
/**
 * See docs/deferred.txt
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @todo document (e.g. one-sentence top-level class description).
 */

use Wikia\Tasks\Tasks\BatchRefreshLinksForTemplate;

class LinksUpdate {

	/**@{{
	 * @private
	 */
	var $mId,            //!< Page ID of the article linked from
		$mTitle,         //!< Title object of the article linked from
		$mParserOutput,  //!< Parser output
		$mLinks,         //!< Map of title strings to IDs for the links in the document
		$mImages,        //!< DB keys of the images used, in the array key only
		$mTemplates,     //!< Map of title strings to IDs for the template references, including broken ones
		$mExternals,     //!< URLs of external links, array key only
		$mCategories,    //!< Map of category names to sort keys
		$mInterlangs,    //!< Map of language codes to titles
		$mProperties,    //!< Map of arbitrary name to value
		/* Wikia change */
		$mInvalidationQueue = [], //!< Array - Queue if pages ids to be invalidated
		$mInvalidationTimestamp, //!< Timestamp for page_touched condition to avoid double updates
		/* Wikia change end */
		$mDb,            //!< Database connection reference
		$mOptions,       //!< SELECT options to be used (array)
		$mRecursive;     //!< Whether to queue jobs for recursive updates
	/**@}}*/

	/**
	 * slave DB connection handle
	 * @var DatabaseBase $dbForReads
	 */
	private $dbForReads;

	/**
	 * Constructor
	 *
	 * @param $title Title of the page we're updating
	 * @param $parserOutput ParserOutput: output from a full parse of this page
	 * @param $recursive Boolean: queue jobs for recursive updates?
	 */
	function __construct( $title, $parserOutput, $recursive = true ) {
		global $wgAntiLockFlags;

		if ( $wgAntiLockFlags & ALF_NO_LINK_LOCK ) {
			$this->mOptions = array();
		} else {
			$this->mOptions = array( 'FOR UPDATE' );
		}
		$this->mDb = wfGetDB( DB_MASTER );

		if ( !is_object( $title ) ) {
			throw new MWException( "The calling convention to LinksUpdate::LinksUpdate() has changed. " .
				"Please see Article::editUpdates() for an invocation example.\n" );
		}
		$this->mTitle = $title;
		$this->mId = $title->getArticleID();

		$this->mParserOutput = $parserOutput;
		$this->mLinks = $parserOutput->getLinks();
		$this->mImages = $parserOutput->getImages();
		$this->mTemplates = $parserOutput->getTemplates();
		$this->mExternals = $parserOutput->getExternalLinks();
		$this->mCategories = $parserOutput->getCategories();
		$this->mProperties = $parserOutput->getProperties();
		$this->mInterwikis = $parserOutput->getInterwikiLinks();

		# Convert the format of the interlanguage links
		# I didn't want to change it in the ParserOutput, because that array is passed all
		# the way back to the skin, so either a skin API break would be required, or an
		# inefficient back-conversion.
		$ill = $parserOutput->getLanguageLinks();
		$this->mInterlangs = array();
		foreach ( $ill as $link ) {
			list( $key, $title ) = explode( ':', $link, 2 );
			$this->mInterlangs[$key] = $title;
		}

		foreach ( $this->mCategories as &$sortkey ) {
			# If the sortkey is longer then 255 bytes,
			# it truncated by DB, and then doesn't get
			# matched when comparing existing vs current
			# categories, causing bug 25254.
			# Also. substr behaves weird when given "".
			if ( $sortkey !== '' ) {
				$sortkey = substr( $sortkey, 0, 255 );
			}
		}

		$this->mRecursive = $recursive;

		// SRE-109
		$this->dbForReads = wfGetDB( DB_SLAVE );

		Hooks::run( 'LinksUpdateConstructed', [ $this ] );
	}

	/**
	 * Update link tables with outgoing links from an updated article
	 */
	public function doUpdate() {
		global $wgUseDumbLinkUpdate;

		Hooks::run( 'LinksUpdate', [ $this ] );
		if ( $wgUseDumbLinkUpdate ) {
			$this->doDumbUpdate();
		} else {
			$this->doIncrementalUpdate();
		}
		Hooks::run( 'LinksUpdateComplete', [ $this ] );
	}

	protected function doIncrementalUpdate() {
		// Wikia change - start (BAC-597)
		if ($this->mId === 0) {
			Wikia::logBacktrace(__CLASS__ . '::mIdIsZero - update skipped');
			return;
		}
		// Wikia change - end

		wfProfileIn( __METHOD__ );

		# Page links
		$existing = $this->getExistingLinks();
		$this->incrTableUpdate( 'pagelinks', 'pl', $this->getLinkDeletions( $existing ),
			$this->getLinkInsertions( $existing ) );

		# Image links
		$existing = $this->getExistingImages();

		$imageDeletes = $this->getImageDeletions( $existing );
		/* Wikia change begin - @author: mech */
		$imageInserts = $this->getImageInsertions( $existing );
		Wikia::setVar('imageDeletes', $imageDeletes);	// images are in array keys!
		Wikia::setVar('imageInserts', $imageInserts);
		$this->incrTableUpdate( 'imagelinks', 'il', $imageDeletes, $imageInserts);
		/* Wikia change end */

		# Invalidate all image description pages which had links added or removed
		$imageUpdates = $imageDeletes + array_diff_key( $this->mImages, $existing );
		/* Wikia change CE-677 @author Kamil Koterba kamil@wikia-inc.com */
		$this->queueImageDescriptionsInvalidation( $imageUpdates );
		/* Wikia change end */

		# External links
		$existing = $this->getExistingExternals();
		$this->incrTableUpdate( 'externallinks', 'el', $this->getExternalDeletions( $existing ),
			$this->getExternalInsertions( $existing ) );

		# Language links
		$existing = $this->getExistingInterlangs();
		$this->incrTableUpdate( 'langlinks', 'll', $this->getInterlangDeletions( $existing ),
			$this->getInterlangInsertions( $existing ) );

		# Inline interwiki links
		$existing = $this->getExistingInterwikis();
		$this->incrTableUpdate( 'iwlinks', 'iwl', $this->getInterwikiDeletions( $existing ),
			$this->getInterwikiInsertions( $existing ) );

		# Template links
		$existing = $this->getExistingTemplates();
		$this->incrTableUpdate( 'templatelinks', 'tl', $this->getTemplateDeletions( $existing ),
			$this->getTemplateInsertions( $existing ) );

		# Category links
		$existing = $this->getExistingCategories();

		$categoryDeletes = $this->getCategoryDeletions( $existing );

		$this->incrTableUpdate( 'categorylinks', 'cl', $categoryDeletes,
			$this->getCategoryInsertions( $existing ) );

		# Invalidate all categories which were added, deleted or changed (set symmetric difference)
		$categoryInserts = array_diff_assoc( $this->mCategories, $existing );
		$categoryUpdates = $categoryInserts + $categoryDeletes;
		/* Wikia change CE-677 @author Kamil Koterba kamil@wikia-inc.com */
		$this->queueCategoriesInvalidation( $categoryUpdates );
		# do the actual invalidation in all pages queued so far
		$this->invalidatePages();
		/* Wikia change end */
		$this->updateCategoryCounts( $categoryInserts, $categoryDeletes );

		Hooks::run( 'AfterCategoriesUpdate', array( $categoryInserts, $categoryDeletes, $this->mTitle ) );

		Wikia::setVar('categoryInserts', $categoryInserts);

		# Page properties
		$existing = $this->getExistingProperties();

		$propertiesDeletes = $this->getPropertyDeletions( $existing );

		$this->incrTableUpdate( 'page_props', 'pp', $propertiesDeletes,
			$this->getPropertyInsertions( $existing ) );

		# Invalidate the necessary pages
		$changed = $propertiesDeletes + array_diff_assoc( $this->mProperties, $existing );
		$this->invalidateProperties( $changed );

		# Refresh links of all pages including this page
		# This will be in a separate transaction
		if ( $this->mRecursive ) {
			$this->queueRecursiveJobs();
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Link update which clears the previous entries and inserts new ones
	 * May be slower or faster depending on level of lock contention and write speed of DB
	 * Also useful where link table corruption needs to be repaired, e.g. in refreshLinks.php
	 */
	protected function doDumbUpdate() {
		wfProfileIn( __METHOD__ );

		# Refresh category pages and image description pages
		$existing = $this->getExistingCategories();
		$categoryInserts = array_diff_assoc( $this->mCategories, $existing );
		$categoryDeletes = array_diff_assoc( $existing, $this->mCategories );
		$categoryUpdates = $categoryInserts + $categoryDeletes;
		$existing = $this->getExistingImages();
		$imageUpdates = array_diff_key( $existing, $this->mImages ) + array_diff_key( $this->mImages, $existing );

		$this->dumbTableUpdate( 'pagelinks',     $this->getLinkInsertions(),     'pl_from' );
		$this->dumbTableUpdate( 'imagelinks',    $this->getImageInsertions(),    'il_from' );
		$this->dumbTableUpdate( 'categorylinks', $this->getCategoryInsertions(), 'cl_from' );
		$this->dumbTableUpdate( 'templatelinks', $this->getTemplateInsertions(), 'tl_from' );
		$this->dumbTableUpdate( 'externallinks', $this->getExternalInsertions(), 'el_from' );
		$this->dumbTableUpdate( 'langlinks',     $this->getInterlangInsertions(),'ll_from' );
		$this->dumbTableUpdate( 'iwlinks',       $this->getInterwikiInsertions(),'iwl_from' );
		$this->dumbTableUpdate( 'page_props',    $this->getPropertyInsertions(), 'pp_page' );

		# Update the cache of all the category pages and image description
		# pages which were changed, and fix the category table count
		/* Wikia change CE-677 @author Kamil Koterba kamil@wikia-inc.com */
		$this->queueImageDescriptionsInvalidation( $imageUpdates );
		$this->queueCategoriesInvalidation( $categoryUpdates );
		# do the actual invalidation in all pages queued so far
		$this->invalidatePages();
		/* Wikia change end */
		$this->updateCategoryCounts( $categoryInserts, $categoryDeletes );

		# Refresh links of all pages including this page
		# This will be in a separate transaction
		if ( $this->mRecursive ) {
			$this->queueRecursiveJobs();
		}

		wfProfileOut( __METHOD__ );
	}

	function queueRecursiveJobs() {
		$cache = $this->mTitle->getBacklinkCache();
		$batches = $cache->partition( 'templatelinks', BatchRefreshLinksForTemplate::TITLES_PER_TASK );
		if ( !$batches ) {
			return;
		}

		$this->queueRefreshTasks( $batches );
	}

	/**
	 * Queue a BatchRefreshLinksForTemplate task for each batch in the given set of backlinks
	 * @param array $batches
	 */
	private function queueRefreshTasks( array $batches ): void {
		global $wgCityId;

		$tasks = [];

		$triggeringRevisionId = $this->mTitle->getLatestRevID();

		foreach ( $batches as $batch ) {
			list( $start, $end ) = $batch;
			$task = new BatchRefreshLinksForTemplate();
			$task->title( $this->mTitle );
			$task->wikiId( $wgCityId );
			$task->call( 'refreshTemplateLinks', $start, $end, wfTimestampNow(), $triggeringRevisionId );

			$tasks[] = $task;

			Wikia\Logger\WikiaLogger::instance()->info( 'LinksUpdate::queueRefreshTasks', [
				'title' => $this->mTitle->getPrefixedDBkey(),
				'start' => $start,
				'end' => $end,
			] );
		}

		BatchRefreshLinksForTemplate::batch( $tasks );
	}


	/**
	 * Queue pages id's of single namespace for later cache invalidation
	 *
	 * method added by Wikia CE-677
	 * @author Kamil Koterba kamil@wikia-inc.com
	 *
	 * @param Integer $namespace
	 * @param Array $dbkeys array of strings containing pages titles
	 */
	function queuePagesInvalidation( $namespace, $dbkeys ) {
		wfProfileIn( __METHOD__ );
		if ( !count( $dbkeys ) ) {
			wfProfileOut( __METHOD__ );
			return;
		}
		/**
		 * Determine which pages need to be updated
		 * This is necessary to prevent the job queue from smashing the DB with
		 * large numbers of concurrent invalidations of the same page
		 */
		if ( !isset( $this->mInvalidationTimestamp ) ) {
			$this->mInvalidationTimestamp = $this->mDb->timestamp();
		}
		$ids = array();

		$res = $this->dbForReads->select( 'page', array( 'page_id' ),
			array(
				'page_namespace' => $namespace,
				'page_title IN (' . $this->dbForReads->makeList( $dbkeys ) . ')',
				'page_touched < ' . $this->dbForReads->addQuotes( $this->mInvalidationTimestamp )
			), __METHOD__
		);
		foreach ( $res as $row ) {
			$ids[] = $row->page_id;
		}
		if ( !count( $ids ) ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		$this->mInvalidationQueue = array_merge( $this->mInvalidationQueue, $ids );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Invalidate the cache of a list of pages
	 *
	 * Wikia change CE-677 - part of functionality moved to queuePagesInvalidation method
	 * @author Kamil Koterba kamil@wikia-inc.com
	 */
	function invalidatePages() {

		if ( !count( $this->mInvalidationQueue ) ) {
			return;
		}

		/**
		 * Do the update
		 * We still need the page_touched condition, in case the row has changed since
		 * the non-locking select above.
		 */
		$this->mDb->update( 'page', array( 'page_touched' => $this->mInvalidationTimestamp ),
			array(
				'page_id IN (' . $this->mDb->makeList( $this->mInvalidationQueue ) . ')',
				'page_touched < ' . $this->mDb->addQuotes( $this->mInvalidationTimestamp )
			), __METHOD__
		);
	}

	/**
	 * Queues categories pages for update
	 *
	 * method changed by Wikia CE-677
	 * @author Kamil Koterba kamil@wikia-inc.com
	 *
	 * @param Array $cats array of strings - categories names
	 */
	function queueCategoriesInvalidation( $cats ) {
		$this->queuePagesInvalidation( NS_CATEGORY, array_keys( $cats ) );
	}

	/**
	 * Update all the appropriate counts in the category table.
	 * @param $added array associative array of category name => sort key
	 * @param $deleted array associative array of category name => sort key
	 */
	function updateCategoryCounts( $added, $deleted ) {
		$a = WikiPage::factory( $this->mTitle );
		$a->updateCategoryCounts(
			array_keys( $added ), array_keys( $deleted )
		);
	}

	/**
	 * Queues flies pages for update
	 *
	 * method changed by Wikia CE-677
	 * @author Kamil Koterba kamil@wikia-inc.com
	 *
	 * @param Array $images array of strings - files names
	 */
	function queueImageDescriptionsInvalidation( $images ) {
		$this->queuePagesInvalidation( NS_FILE, array_keys( $images ) );
	}

	/**
	 * @param $table
	 * @param $insertions
	 * @param $fromField
	 */
	private function dumbTableUpdate( $table, $insertions, $fromField ) {
		$this->mDb->delete( $table, array( $fromField => $this->mId ), __METHOD__ );
		if ( count( $insertions ) ) {
			# The link array was constructed without FOR UPDATE, so there may
			# be collisions.  This may cause minor link table inconsistencies,
			# which is better than crippling the site with lock contention.
			$this->mDb->insert( $table, $insertions, __METHOD__, array( 'IGNORE' ) );
		}
	}

	/**
	 * Update a table by doing a delete query then an insert query
	 * @param $table
	 * @param $prefix
	 * @param $deletions
	 * @param $insertions
	 */
	function incrTableUpdate( $table, $prefix, $deletions, $insertions ) {
		global $wgUpdateRowsPerQuery;

		if ( $table == 'page_props' ) {
			$fromField = 'pp_page';
		} else {
			$fromField = "{$prefix}_from";
		}
		$deleteWheres = [];
		if ( $table == 'pagelinks' || $table == 'templatelinks' || $table == 'iwlinks' ) {
			if ( $table == 'iwlinks' ) {
				$baseKey = 'iwl_prefix';
			} else {
				$baseKey = "{$prefix}_namespace";
			}

			$curBatchSize = 0;
			$curDeletionBatch = [];
			$deletionBatches = [];
			foreach ( $deletions as $ns => $dbKeys ) {
				foreach ( $dbKeys as $dbKey => $unused ) {
					$curDeletionBatch[$ns][$dbKey] = 1;
					if ( ++$curBatchSize >= $wgUpdateRowsPerQuery ) {
						$deletionBatches[] = $curDeletionBatch;
						$curDeletionBatch = [];
						$curBatchSize = 0;
					}
				}
			}
			if ( $curDeletionBatch ) {
				$deletionBatches[] = $curDeletionBatch;
			}

			foreach ( $deletionBatches as $deletionBatch ) {
				$deleteWheres[] = [
					$fromField => $this->mId,
					$this->mDb->makeWhereFrom2d( $deletionBatch, $baseKey, "{$prefix}_title" )
				];
			}
		} else {
			if ( $table == 'langlinks' ) {
				$toField = 'll_lang';
			} elseif ( $table == 'page_props' ) {
				$toField = 'pp_propname';
			} else {
				$toField = $prefix . '_to';
			}
			$deletionBatches = array_chunk( array_keys( $deletions ), $wgUpdateRowsPerQuery );
			foreach ( $deletionBatches as $deletionBatch ) {
				$deleteWheres[] = [ $fromField => $this->mId, $toField => $deletionBatch ];
			}
		}

		// If this is a background task running in autocommit mode, wait for replication after each batch update
		// to reduce the load on replica DBs when processing a large amount of updates from concurrent links refreshes.
		// Do not wait for replication if DBO_TRX is set, as it's likely to be a user-facing web request wrapped in
		// a transaction - in this scenario, prefer to skip the wait to preserve transactional integrity rather than
		// prematurely committing the main transaction round.
		$waitForReplication = !$this->mDb->getFlag( DBO_TRX );
		$lb = wfGetLB();

		foreach ( $deleteWheres as $deleteWhere ) {
			$this->mDb->delete( $table, $deleteWhere, __METHOD__ );

			if ( $waitForReplication ) {
				$pos = $this->mDb->getMasterPos();

				$lb->waitForAll($pos, false);
			}
		}

		$insertBatches = array_chunk( $insertions, $wgUpdateRowsPerQuery );
		foreach ( $insertBatches as $insertBatch ) {
			$this->mDb->insert( $table, $insertBatch, __METHOD__, 'IGNORE' );;

			if ( $waitForReplication ) {
				$pos = $this->mDb->getMasterPos();

				$lb->waitForAll($pos, false);
			}
		}
	}

	/**
	 * Get an array of pagelinks insertions for passing to the DB
	 * Skips the titles specified by the 2-D array $existing
	 * @param $existing array
	 * @return array
	 */
	private function getLinkInsertions( $existing = array() ) {
		$arr = array();
		foreach( $this->mLinks as $ns => $dbkeys ) {
			$diffs = isset( $existing[$ns] )
				? array_diff_key( $dbkeys, $existing[$ns] )
				: $dbkeys;
			foreach ( $diffs as $dbk => $id ) {
				$arr[] = array(
					'pl_from'      => $this->mId,
					'pl_namespace' => $ns,
					'pl_title'     => $dbk
				);
			}
		}

		return $arr;
	}

	/**
	 * Get an array of template insertions. Like getLinkInsertions()
	 * @param $existing array
	 * @return array
	 */
	private function getTemplateInsertions( $existing = array() ) {
		$arr = array();
		foreach( $this->mTemplates as $ns => $dbkeys ) {
			$diffs = isset( $existing[$ns] ) ? array_diff_key( $dbkeys, $existing[$ns] ) : $dbkeys;
			foreach ( $diffs as $dbk => $id ) {
				$arr[] = array(
					'tl_from'      => $this->mId,
					'tl_namespace' => $ns,
					'tl_title'     => $dbk
				);
			}

		}

		Hooks::run( 'LinksUpdateInsertTemplates', [ $this->mId, $arr ] );

		return $arr;
	}

	/**
	 * Get an array of image insertions
	 * Skips the names specified in $existing
	 * @param $existing array
	 * @return array
	 */
	private function getImageInsertions( $existing = array() ) {
		$arr = array();
		$diffs = array_diff_key( $this->mImages, $existing );
		foreach( $diffs as $iname => $dummy ) {
			$arr[] = array(
				'il_from' => $this->mId,
				'il_to'   => $iname
			);
		}
		return $arr;
	}

	/**
	 * Get an array of externallinks insertions. Skips the names specified in $existing
	 * @param $existing array
	 * @return array
	 */
	private function getExternalInsertions( $existing = array() ) {
		$arr = array();
		$diffs = array_diff_key( $this->mExternals, $existing );
		foreach( $diffs as $url => $dummy ) {
			foreach( wfMakeUrlIndexes( $url ) as $index ) {
				$arr[] = array(
					'el_from'   => $this->mId,
					'el_to'     => $url,
					'el_index'  => $index,
				);
			}
		}
		return $arr;
	}

	/**
	 * Get an array of category insertions
	 *
	 * @param $existing array mapping existing category names to sort keys. If both
	 * match a link in $this, the link will be omitted from the output
	 *
	 * @return array
	 */
	private function getCategoryInsertions( $existing = array() ) {
		global $wgContLang, $wgCategoryCollation;
		$diffs = array_diff_assoc( $this->mCategories, $existing );
		$arr = array();
		foreach ( $diffs as $name => $prefix ) {
			$nt = Title::makeTitleSafe( NS_CATEGORY, $name );
			$wgContLang->findVariantLink( $name, $nt, true );

			if ( $this->mTitle->getNamespace() == NS_CATEGORY ) {
				$type = 'subcat';
			} elseif ( $this->mTitle->getNamespace() == NS_FILE ) {
				$type = 'file';
			} else {
				$type = 'page';
			}

			# Treat custom sortkeys as a prefix, so that if multiple
			# things are forced to sort as '*' or something, they'll
			# sort properly in the category rather than in page_id
			# order or such.
			$sortkey = Collation::singleton()->getSortKey(
				$this->mTitle->getCategorySortkey( $prefix ) );

			$arr[] = array(
				'cl_from'    => $this->mId,
				'cl_to'      => $name,
				'cl_sortkey' => $sortkey,
				'cl_timestamp' => $this->mDb->timestamp(),
				'cl_sortkey_prefix' => $prefix,
				'cl_collation' => $wgCategoryCollation,
				'cl_type' => $type,
			);
		}
		return $arr;
	}

	/**
	 * Get an array of interlanguage link insertions
	 *
	 * @param $existing Array mapping existing language codes to titles
	 *
	 * @return array
	 */
	private function getInterlangInsertions( $existing = array() ) {
		$diffs = array_diff_assoc( $this->mInterlangs, $existing );
		$arr = array();
		foreach( $diffs as $lang => $title ) {
			$arr[] = array(
				'll_from'  => $this->mId,
				'll_lang'  => $lang,
				'll_title' => $title
			);
		}
		return $arr;
	}

	/**
	 * Get an array of page property insertions
	 * @param $existing array
	 * @return array
	 */
	function getPropertyInsertions( $existing = array() ) {
		$diffs = array_diff_assoc( $this->mProperties, $existing );
		$arr = array();
		foreach ( $diffs as $name => $value ) {
			$arr[] = array(
				'pp_page'      => $this->mId,
				'pp_propname'  => $name,
				'pp_value'     => $value,
			);
		}
		return $arr;
	}

	/**
	 * Get an array of interwiki insertions for passing to the DB
	 * Skips the titles specified by the 2-D array $existing
	 * @param $existing array
	 * @return array
	 */
	private function getInterwikiInsertions( $existing = array() ) {
		$arr = array();
		foreach( $this->mInterwikis as $prefix => $dbkeys ) {
			$diffs = isset( $existing[$prefix] ) ? array_diff_key( $dbkeys, $existing[$prefix] ) : $dbkeys;
			foreach ( $diffs as $dbk => $id ) {
				$arr[] = array(
					'iwl_from'   => $this->mId,
					'iwl_prefix' => $prefix,
					'iwl_title'  => $dbk
				);
			}
		}
		return $arr;
	}

	/**
	 * Given an array of existing links, returns those links which are not in $this
	 * and thus should be deleted.
	 * @param $existing array
	 * @return array
	 */
	private function getLinkDeletions( $existing ) {
		$del = array();
		foreach ( $existing as $ns => $dbkeys ) {
			if ( isset( $this->mLinks[$ns] ) ) {
				$del[$ns] = array_diff_key( $existing[$ns], $this->mLinks[$ns] );
			} else {
				$del[$ns] = $existing[$ns];
			}
		}
		return $del;
	}

	/**
	 * Given an array of existing templates, returns those templates which are not in $this
	 * and thus should be deleted.
	 * @param $existing array
	 * @return array
	 */
	private function getTemplateDeletions( $existing ) {
		$del = array();
		foreach ( $existing as $ns => $dbkeys ) {
			if ( isset( $this->mTemplates[$ns] ) ) {
				$del[$ns] = array_diff_key( $existing[$ns], $this->mTemplates[$ns] );
			} else {
				$del[$ns] = $existing[$ns];
			}
		}
		return $del;
	}

	/**
	 * Given an array of existing images, returns those images which are not in $this
	 * and thus should be deleted.
	 * @param $existing array
	 * @return array
	 */
	private function getImageDeletions( $existing ) {
		return array_diff_key( $existing, $this->mImages );
	}

	/**
	 * Given an array of existing external links, returns those links which are not
	 * in $this and thus should be deleted.
	 * @param $existing array
	 * @return array
	 */
	private function getExternalDeletions( $existing ) {
		return array_diff_key( $existing, $this->mExternals );
	}

	/**
	 * Given an array of existing categories, returns those categories which are not in $this
	 * and thus should be deleted.
	 * @param $existing array
	 * @return array
	 */
	private function getCategoryDeletions( $existing ) {
		return array_diff_assoc( $existing, $this->mCategories );
	}

	/**
	 * Given an array of existing interlanguage links, returns those links which are not
	 * in $this and thus should be deleted.
	 * @param $existing array
	 * @return array
	 */
	private function getInterlangDeletions( $existing ) {
		return array_diff_assoc( $existing, $this->mInterlangs );
	}

	/**
	 * Get array of properties which should be deleted.
	 * @param $existing array
	 * @return array
	 */
	function getPropertyDeletions( $existing ) {
		return array_diff_assoc( $existing, $this->mProperties );
	}

	/**
	 * Given an array of existing interwiki links, returns those links which are not in $this
	 * and thus should be deleted.
	 * @param $existing array
	 * @return array
	 */
	private function getInterwikiDeletions( $existing ) {
		$del = array();
		foreach ( $existing as $prefix => $dbkeys ) {
			if ( isset( $this->mInterwikis[$prefix] ) ) {
				$del[$prefix] = array_diff_key( $existing[$prefix], $this->mInterwikis[$prefix] );
			} else {
				$del[$prefix] = $existing[$prefix];
			}
		}
		return $del;
	}

	/**
	 * Get an array of existing links, as a 2-D array
	 *
	 * @return array
	 */
	private function getExistingLinks() {
		$res = $this->dbForReads->select( 'pagelinks', array( 'pl_namespace', 'pl_title' ),
			array( 'pl_from' => $this->mId ), __METHOD__, $this->mOptions );
		$arr = array();
		foreach ( $res as $row ) {
			if ( !isset( $arr[$row->pl_namespace] ) ) {
				$arr[$row->pl_namespace] = array();
			}
			$arr[$row->pl_namespace][$row->pl_title] = 1;
		}
		return $arr;
	}

	/**
	 * Get an array of existing templates, as a 2-D array
	 *
	 * @return array
	 */
	private function getExistingTemplates() {
		$res = $this->dbForReads->select( 'templatelinks', array( 'tl_namespace', 'tl_title' ),
			array( 'tl_from' => $this->mId ), __METHOD__, $this->mOptions );
		$arr = array();
		foreach ( $res as $row ) {
			if ( !isset( $arr[$row->tl_namespace] ) ) {
				$arr[$row->tl_namespace] = array();
			}
			$arr[$row->tl_namespace][$row->tl_title] = 1;
		}
		return $arr;
	}

	/**
	 * Get an array of existing images, image names in the keys
	 *
	 * @return array
	 */
	private function getExistingImages() {
		$res = $this->dbForReads->select( 'imagelinks', array( 'il_to' ),
			array( 'il_from' => $this->mId ), __METHOD__, $this->mOptions );
		$arr = array();
		foreach ( $res as $row ) {
			$arr[$row->il_to] = 1;
		}
		return $arr;
	}

	/**
	 * Get an array of existing external links, URLs in the keys
	 *
	 * @return array
	 */
	private function getExistingExternals() {
		$res = $this->dbForReads->select( 'externallinks', array( 'el_to' ),
			array( 'el_from' => $this->mId ), __METHOD__, $this->mOptions );
		$arr = array();
		foreach ( $res as $row ) {
			$arr[$row->el_to] = 1;
		}
		return $arr;
	}

	/**
	 * Get an array of existing categories, with the name in the key and sort key in the value.
	 *
	 * @return array
	 */
	private function getExistingCategories() {
		$res = $this->dbForReads->select( 'categorylinks', array( 'cl_to', 'cl_sortkey_prefix' ),
			array( 'cl_from' => $this->mId ), __METHOD__, $this->mOptions );
		$arr = array();
		foreach ( $res as $row ) {
			$arr[$row->cl_to] = $row->cl_sortkey_prefix;
		}
		return $arr;
	}

	/**
	 * Get an array of existing interlanguage links, with the language code in the key and the
	 * title in the value.
	 *
	 * @return array
	 */
	private function getExistingInterlangs() {
		$res = $this->dbForReads->select( 'langlinks', array( 'll_lang', 'll_title' ),
			array( 'll_from' => $this->mId ), __METHOD__, $this->mOptions );
		$arr = array();
		foreach ( $res as $row ) {
			$arr[$row->ll_lang] = $row->ll_title;
		}
		return $arr;
	}

	/**
	 * Get an array of existing inline interwiki links, as a 2-D array
	 * @return array (prefix => array(dbkey => 1))
	 */
	protected function getExistingInterwikis() {
		$res = $this->dbForReads->select( 'iwlinks', array( 'iwl_prefix', 'iwl_title' ),
			array( 'iwl_from' => $this->mId ), __METHOD__, $this->mOptions );
		$arr = array();
		foreach ( $res as $row ) {
			if ( !isset( $arr[$row->iwl_prefix] ) ) {
				$arr[$row->iwl_prefix] = array();
			}
			$arr[$row->iwl_prefix][$row->iwl_title] = 1;
		}
		return $arr;
	}

	/**
	 * Get an array of existing categories, with the name in the key and sort key in the value.
	 *
	 * @return array
	 */
	private function getExistingProperties() {
		$res = $this->dbForReads->select( 'page_props', array( 'pp_propname', 'pp_value' ),
			array( 'pp_page' => $this->mId ), __METHOD__, $this->mOptions );
		$arr = array();
		foreach ( $res as $row ) {
			$arr[$row->pp_propname] = $row->pp_value;
		}
		return $arr;
	}

	/**
	 * Return the title object of the page being updated
	 * @return Title
	 */
	public function getTitle() {
		return $this->mTitle;
	}

	/**
	 * Returns parser output
	 * @since 1.19
	 * @return ParserOutput
	 */
	public function getParserOutput() {
		return $this->mParserOutput;
	}

	/**
	 * Return the list of images used as generated by the parser
	 * @return array
	 */
	public function getImages() {
		return $this->mImages;
	}

	/**
	 * Invalidate any necessary link lists related to page property changes
	 * @param $changed
	 */
	private function invalidateProperties( $changed ) {
		global $wgPagePropLinkInvalidations, $wgCityId;

		foreach ( $changed as $name => $value ) {
			if ( isset( $wgPagePropLinkInvalidations[$name] ) ) {
				// Wikia change begin @author Scott Rabin (srabin@wikia-inc.com)
				$task = ( new \Wikia\Tasks\Tasks\HTMLCacheUpdateTask() )
					->wikiId( $wgCityId )
					->title( $this->mTitle );
				$task->call( 'purge', $wgPagePropLinkInvalidations[$name] );
				$task->queue();
				// Wikia change end
			}
		}
	}
}
