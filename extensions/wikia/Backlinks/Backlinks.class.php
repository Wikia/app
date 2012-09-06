<?php
/**
 * Backlinks class, responsible for maintaining the backlinks table.
 * @author Robert Elwell <robert@wikia-inc.com>
 *
 */

class Backlinks
{
	const TABLE_NAME = 'wikia_page_backlinks';

	// allows us to store multiple links
	static $backlinkRows = array();

	// allows us to keep track of multiple articles
	static $sourceArticleIds = array();

	static function storeBackLinkText( $skin, Title $target, array $options, &$text, array &$attribs, &$ret )
	{
		wfProfileIn(__METHOD__);
		global $wgArticle;

		$targetArticleId = $target->getArticleId();
		if ((! is_int($targetArticleId)) || ($wgArticle === null) || $targetArticleId === 0) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$sourceArticleId = $wgArticle->getId();

		self::$sourceArticleIds = array_unique( self::$sourceArticleIds + array($sourceArticleId) );

		$backlinkRowSignature = sprintf( "(%s,%s,'%s',", $sourceArticleId, 
														 $targetArticleId, 
														 mysql_real_escape_string(substr($text, 0, 255))
										);

		self::$backlinkRows[$backlinkRowSignature] = isset( self::$backlinkRows[$backlinkRowSignature] ) 
												   ? self::$backlinkRows[$backlinkRowSignature] + 1 
												   : 1;

		wfProfileOut(__METHOD__);
		return true;

	}
	
	static function clearRows()
	{
		self::$backlinkRows = array();
		self::$sourceArticleIds = array();
	}

	static function getForArticle( Article $article )
	{
		$targetPageId = $article->getId();

		if (! $targetPageId) {
			return array();
		}

		try {
			$dbr = wfGetDb( DB_SLAVE );
			$res = $dbr->select( self::TABLE_NAME, 
								 array('backlink_text', 'SUM(count)'),
								 array('target_page_id' => $targetPageId),
								 __METHOD__,
								 array('GROUP BY' => array('target_page_id', 'backlink_text'))
							   );

			$resultArray = array();

			while ( $row = $res->fetchRow() ) {
				$resultArray[$row['backlink_text']] = $row['SUM(count)'];
			}

			return $resultArray;

		} catch (Exception $e) {
			// should probably log this
			return array();
		}

	}

	static function updateBacklinkText()
	{
		wfProfileIn(__METHOD__);

		$dbr = wfGetDb( DB_MASTER );

		if (! $dbr->tableExists(self::TABLE_NAME) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$rowCount = count( self::$backlinkRows );
		if ($rowCount == 0) { 
			wfProfileOut(__METHOD__);
			return true;
		}

		$dbr->begin();
		$deleteSql = 'DELETE FROM `'.self::TABLE_NAME.'` WHERE source_page_id IN ('.implode(', ', self::$sourceArticleIds).');';
		$insertSql = "INSERT IGNORE INTO `".self::TABLE_NAME."` (`source_page_id`, `target_page_id`, `backlink_text`, `count` ) VALUES ";

		$rowCounter = 0;
		foreach ( self::$backlinkRows as $signature => $count )
		{
			// $signature is incomplete sql value set "(1234,1234,'foo', "
			$insertSql .= $signature . "{$count})";
			$insertSql .= ++$rowCounter == $rowCount ? ';' : ', ';
		}


		$dbr->query( $deleteSql );
		$dbr->query( $insertSql );

		try {
			$dbr->commit();
		} catch (Exception $e) {
			// should probably log this
		}

		wfProfileOut(__METHOD__);
		return true;

	}

	/**
	 * Called by maintenance script.
	 */
	static function initTable()
	{
		wfProfileIn(__METHOD__);

		// create db handler
		$dbr = wfGetDb( DB_MASTER );

		if (! $dbr->tableExists(self::TABLE_NAME) ) {
			try {
				$dbr->query(self::tableCreateSql());
			} catch (Exception $e) {
				wfProfileOut(__METHOD__);
				return $e;
			}
			wfProfileOut(__METHOD__);
			return "Table ".self::TABLE_NAME." created.";
		}
		
		wfProfileOut(__METHOD__);
		return "Table ".self::TABLE_NAME." already exists."; 
	}

	static function tableCreateSql()
	{
		$tableName = self::TABLE_NAME;
		return <<<ENDTABLE
CREATE TABLE `{$tableName}` (
	`source_page_id` INT NOT NULL,
	`target_page_id` INT NOT NULL,
	`backlink_text` VARCHAR(255),
	`count` INT,
	PRIMARY KEY (`source_page_id`, `target_page_id`, `backlink_text`),
	KEY `wikia_page_backlinks_source_page_id` (`source_page_id`),
	KEY `wikia_page_backlinks_target_page_id` (`target_page_id`)
) ENGINE = InnoDB 
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;
ENDTABLE;

	}
}