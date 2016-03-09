<?php

namespace Wikia\TemplateClassification\UnusedTemplates;

class Handler {
	/**
	 * Reflects a `propname` in the `page_wikia_props` table.
	 */
	const PROPERTY_NAME = 11000;
	const USED = 1;
	const UNUSED = 0;

	/**
	 * Checks if a template is used and needs to be classified because of that.
	 * Returns true if a property is NOT FOUND for a given pageId
	 * or if the property's value indicates that it is used.
	 *
	 * @param int $pageId
	 * @return bool
	 */
	public function isUsed( $pageId ) {
		$db = $this->getDatabaseForRead();

		$row = $db->selectRow(
			'page_wikia_props',
			[ 'props' ],
			[
				'page_id' => (int)$pageId,
				'propname' => self::PROPERTY_NAME,
			]
		);

		if ( is_object( $row ) ) {
			return (int)$row->props === self::USED;
		}

		return true;
	}

	/**
	 * Uses `title` fields of the rows to mark given templates as unused.
	 * It resets the data first using the markAllAsUsed method.
	 *
	 * @param \ResultWrapper $results
	 * @param \DatabaseBase $db
	 * @return bool
	 * @throws \DBQueryError
	 */
	public function markAsUnusedFromResults( \ResultWrapper $results, \DatabaseBase $db = null ) {
		if ( $db === null ) {
			$db = $this->getDatabaseForWrite();
		}

		$this->markAllAsUsed( $db );

		$insertRows = $this->getInsertRowsFromResults( $results );
		if ( empty( $insertRows ) ) {
			return false;
		}

		$db->upsert(
			'page_wikia_props',
			$insertRows,
			[ 'page_id', 'propname' ],
			[ 'props' => self::UNUSED ]
		);

		return true;
	}

	/**
	 * Marks all templates on a given wikia as used.
	 * It only updates the `page_wikia_props` table since we assume
	 * that if a template is not there - it is used.
	 *
	 * @param \DatabaseBase $db
	 * @return true
	 * @throws \MWException
	 */
	public function markAllAsUsed( \DatabaseBase $db = null ) {
		if ( $db === null ) {
			$db = $this->getDatabaseForWrite();
		}

		$db->update(
			'page_wikia_props',
			[ 'props' => self::USED ],
			[ 'propname' => self::PROPERTY_NAME ],
			__METHOD__
		);

		return true;
	}

	/**
	 * Converts results with a `title` property to an array of IDs of pages.
	 *
	 * @param \ResultWrapper $results
	 * @return array
	 */
	protected function getInsertRowsFromResults( \ResultWrapper $results ) {
		$insertRows = [];

		while ( $row = $results->fetchObject() ) {
			if ( !isset( $row->title ) ) {
				continue;
			}

			$title = \Title::newFromText( $row->title, NS_TEMPLATE );
			if ( $title === null ) {
				continue;
			}

			$pageId = $title->getArticleID();
			if ( $pageId !== 0 ) {
				$insertRows[] = [
					'page_id' => $pageId,
					'propname' => self::PROPERTY_NAME,
					'props' => self::UNUSED,
				];
			}
		}

		return $insertRows;
	}

	/**
	 * @return \DatabaseMysqli
	 */
	protected function getDatabaseForRead() {
		return wfGetDB( DB_SLAVE );
	}

	/**
	 * @return \DatabaseMysqli
	 */
	protected function getDatabaseForWrite() {
		return wfGetDB( DB_MASTER );
	}
}
