<?php
/**
 * Clean up empty categories in the category table.
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
 * @file
 * @ingroup Maintenance
 */

require_once __DIR__ . '/Maintenance.php';

/**
 * Maintenance script to clean up empty categories in the category table.
 *
 * @ingroup Maintenance
 * @since 1.28
 */
class CleanupEmptyCategories extends LoggedUpdateMaintenance {

	public function __construct() {
		parent::__construct();
		$this->addDescription(
			<<<TEXT
	  This script will clean up the category table by removing entries for empty
categories without a description page and adding entries for empty categories
with a description page. It will print out progress indicators every batch. The
script is perfectly safe to run on large, live wikis, and running it multiple
times is harmless. You may want to use the throttling options if it's causing
too much load; they will not affect correctness.

If the script is stopped and later resumed, you can use the --mode and --begin
options with the last printed progress indicator to pick up where you left off.

When the script has finished, it will make a note of this in the database, and
will not run again without the --force option.
TEXT
		);

		$this->addOption(
			'mode',
			'"add" empty categories with description pages, "remove" empty categories '
			. 'without description pages, or "both"',
			false,
			true
		);
		$this->addOption(
			'begin',
			'Only do categories whose names are alphabetically after the provided name',
			false,
			true
		);
		$this->addOption(
			'throttle',
			'Wait this many milliseconds after each batch. Default: 0',
			false,
			true
		);
		$this->addOption( 'dry-run', 'Only list affected categories, don\'t make changes', false, false );
	}

	protected function getUpdateKey() {
		return 'cleanup empty categories';
	}

	protected function doDBUpdates() {
		$isDryRun = $this->hasOption( 'dry-run' );
		$mode = $this->getOption( 'mode', 'both' );
		$begin = $this->getOption( 'begin', '' );
		$throttle = $this->getOption( 'throttle', 0 );

		if ( !in_array( $mode, [ 'add', 'remove', 'both' ] ) ) {
			$this->output( "--mode must be 'add', 'remove', or 'both'.\n" );
			return false;
		}

		$dbw = $this->getDB( DB_MASTER );

		$throttle = intval( $throttle );

		if ( $mode === 'add' || $mode === 'both' ) {
			if ( $begin !== '' ) {
				$where = [ 'page_title > ' . $dbw->addQuotes( $begin ) ];
			} else {
				$where = [];
			}

			if ( !$isDryRun ) {
				$this->output( "Adding empty categories with description pages...\n" );
			}
			$existingCategoryCount = 0;
			while ( true ) {
				# Find which category to update
				$rows = $dbw->select(
					[ 'page', 'category' ],
					'page_title',
					array_merge( $where, [
						'page_namespace' => NS_CATEGORY,
						'cat_title' => null,
					] ),
					__METHOD__,
					[
						'ORDER BY' => 'page_title',
						'LIMIT' => $this->mBatchSize,
					],
					[
						'category' => [ 'LEFT JOIN', 'page_title = cat_title' ],
					]
				);

				$rowCount = $rows ? $rows->numRows() : 0;
				if ( $rowCount <= 0 ) {
					# Done, hopefully.
					break;
				}

				$titles = [];
				foreach ( $rows as $row ) {
					$name = $row->page_title;
					$where = [ 'page_title > ' . $dbw->addQuotes( $name ) ];
					$titles[] = $name;
				}

				if ( !$isDryRun ) {
					// SUS-1782: call refresh task directly and wrap it in a transaction
					$dbw->begin( __METHOD__ );

					$task = new \Wikia\Tasks\Tasks\RefreshCategoryCountsTask();
					$task->refreshCounts( $titles );

					$dbw->commit( __METHOD__ );

					$this->output( "--mode=$mode --begin=$name\n" );

					wfWaitForSlaves();
					usleep( $throttle * 1000 );
				}

				$existingCategoryCount += $rowCount;
			}

			$this->output( "Found $existingCategoryCount empty categories with description pages.\n" );

			$begin = '';
		}

		if ( $mode === 'remove' || $mode === 'both' ) {
			if ( $begin !== '' ) {
				$where = [ 'cat_title > ' . $dbw->addQuotes( $begin ) ];
			} else {
				$where = [];
			}

			if ( !$isDryRun ) {
				$this->output( "Removing empty categories without description pages...\n" );
			}
			$emptyCategoryCount = 0;
			while ( true ) {
				# Find which category to update
				$rows = $dbw->select(
					[ 'category', 'page' ],
					'cat_title',
					array_merge( $where, [
						'page_title' => null,
						'cat_pages' => 0,
					] ),
					__METHOD__,
					[
						'ORDER BY' => 'cat_title',
						'LIMIT' => $this->mBatchSize,
					],
					[
						'page' => [ 'LEFT JOIN', [
							'page_namespace' => NS_CATEGORY, 'page_title = cat_title'
						] ],
					]
				);

				$rowCount = $rows ? $rows->numRows() : 0;
				if ( $rowCount <= 0 ) {
					# Done, hopefully.
					break;
				}

				$titles = [];
				foreach ( $rows as $row ) {
					$name = $row->cat_title;
					$where = [ 'cat_title > ' . $dbw->addQuotes( $name ) ];
					$titles[] = $name;
				}

				if ( !$isDryRun ) {
					// SUS-1782: call refresh task directly and wrap it in a transaction
					$dbw->begin( __METHOD__ );

					$task = new \Wikia\Tasks\Tasks\RefreshCategoryCountsTask();
					$task->refreshCounts( $titles );

					$dbw->commit( __METHOD__ );

					$this->output( "--mode=remove --begin=$name\n" );

					wfWaitForSlaves();
					usleep( $throttle * 1000 );
				}

				$emptyCategoryCount += $rowCount;
			}

			$this->output( "Found $emptyCategoryCount empty categories without description pages.\n" );
		}

		if ( !$isDryRun ) {
			$this->output( "Category cleanup complete.\n" );
		}

		return true;
	}
}

$maintClass = CleanupEmptyCategories::class;
require_once RUN_MAINTENANCE_IF_MAIN;
