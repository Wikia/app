<?php
namespace Wikia\Tasks\Tasks;

/**
 * Class RefreshCategoryCountsTask updates content count for categories, removes dead categories from category table
 * and creates entries for new categories that do not yet have one.
 * @package Wikia\Tasks\Tasks
 */
class RefreshCategoryCountsTask extends BaseTask {

	private $db;

	public function __construct() {
		$this->db = wfGetDB( DB_MASTER );
	}

	/**
	 * This task needs to be run a local wiki (i.e. where it was queued)
	 */
	public function queue() {
		global $wgCityId;
		$this->wikiId($wgCityId);

		parent::queue();
	}

	/**
	 * @param string[]|string $data title of category or array of category titles
	 */
	public function refreshCounts( $data ) {
		if ( !is_array( $data ) ) {
			$data = [ $data ];
		}

		$categoryTableEntries = $this->getCategoryTableEntries( $data );
		$emptyCategories = [];

		foreach ( $data as $catName ) {
			$hasCategoryTableEntry = in_array( $catName, $categoryTableEntries );
			$contentCounts = $this->getContentCounts( $catName );

			// If it's a non-empty category, update the counts
			// If it does not yet have a category table entry, create it
			if ( $contentCounts->pages > 0 ) {
				if ( $hasCategoryTableEntry ) {
					$this->db->update(
						'category',
						[
							'cat_pages' => $contentCounts->pages,
							'cat_subcats'=> $contentCounts->subcats,
							'cat_files' => $contentCounts->files,
						],
						[ 'cat_title' => $catName ],
						__METHOD__
					);
				} else {
					// No category table entry - create it.
					// Use UPSERT to prevent races.
					$this->db->upsert(
						'category',
						[
							'cat_title' => $catName,
							'cat_pages' => $contentCounts->pages,
							'cat_subcats'=> $contentCounts->subcats,
							'cat_files' => $contentCounts->files,
						],
						[ 'cat_title' ],
						[
							'cat_pages' => $contentCounts->pages,
							'cat_subcats'=> $contentCounts->subcats,
							'cat_files' => $contentCounts->files,
						],
						__METHOD__
					);
				}
			} else {
				// The category seems to be empty
				$emptyCategories[$catName] = [
					'cat_pages' => $contentCounts->pages,
					'cat_subcats'=> $contentCounts->subcats,
					'cat_files' => $contentCounts->files,
				];
			}
		}

		// Batch load titles for empty categories for performance
		$categoryTitles = [];
		if ( !empty( $emptyCategories ) ) {
			$categoryTitles = $this->getCategoryTitles( array_keys( $emptyCategories ) );
		}

		$entriesToDelete = [];

		foreach ( $emptyCategories as $catName => $row ) {
			$hasExistingTitle = in_array( $catName, $categoryTitles );
			$hasCategoryTableEntry = in_array( $catName, $categoryTableEntries );

			// The category is empty, but the corresponding title exists, so the page exists.
			// In this case, keep the entry and update the counts, or create an entry if there is none.
			if ( $hasCategoryTableEntry ) {
				if ( $hasExistingTitle ) {
					$this->db->update( 'category', $row, [ 'cat_title' => $catName ], __METHOD__ );
				} else {
					// The category is empty, and the page does not exist - delete the entry from category table
					$entriesToDelete[] = $catName;
				}
			} elseif ( $hasExistingTitle ) {
				// The category title exists but it does not have an entry in category table - create it
				$createRow = [ 'cat_title' => $catName ] + $row;
				$this->db->upsert( 'category', $createRow, [ 'cat_title' ], $row, __METHOD__ );
			}
		}

		if ( !empty( $entriesToDelete ) ) {
			$this->db->delete( 'category', [ 'cat_title' => $entriesToDelete ], __METHOD__ );
		}
	}

	/**
	 * Given an array of category names, returns those names that have a category table entry
	 *
	 * @param array $catNames
	 * @return array|bool
	 */
	private function getCategoryTableEntries( array $catNames ) {
		return $this->db->selectFieldValues( 'category', 'cat_title', [ 'cat_title' => $catNames ], __METHOD__ );
	}

	/**
	 * Given an array of category names, returns those names that have a page table entry (title exists)
	 *
	 * @param array $catNames
	 * @return array
	 */
	private function getCategoryTitles( array $catNames ): array {
		return $this->db->selectFieldValues(
			'page',
			'page_title',
			[
				'page_namespace' => NS_CATEGORY,
				'page_title' => $catNames
			],
			__METHOD__
		);
	}

	/**
	 * Given a category name, recalculates the count of pages, subcats and media it contains and returns the data
	 *
	 * @param string $catName
	 * @return array|object
	 */
	private function getContentCounts( string $catName ) {
		$cond1 = $this->db->conditional( 'page_namespace=' . NS_CATEGORY, 1, 'NULL' );
		$cond2 = $this->db->conditional( 'page_namespace=' . NS_FILE, 1, 'NULL' );

		return $this->db->selectRow(
			[ 'categorylinks', 'page' ],
			[ 'COUNT(*) AS pages',
				"COUNT($cond1) AS subcats",
				"COUNT($cond2) AS files"
			],
			[ 'cl_to' => $catName, 'page_id = cl_from' ],
			__METHOD__,
			'LOCK IN SHARE MODE'
		);
	}
}
