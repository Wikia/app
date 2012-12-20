<?php
/**
 * Backlinks class, responsible for maintaining the backlinks table.
 * @author Robert Elwell <robert@wikia-inc.com>
 *
 */

class Backlinks extends WikiaObject
{
	const TABLE_NAME = 'wikia_page_backlinks';

	/**
	 * Stores backlinks for each target article, listing the backlink text, and which source articles link to them
	 * @var unknown_type
	 */
	static $backlinkRows = array();

	/**
	 * Uses MediaWiki LinkEnd hook to store backlinks
	 * @param unknown_type $skin
	 * @param Title $target
	 * @param array $options
	 * @param unknown_type $text
	 * @param array $attribs
	 * @param unknown_type $ret
	 * @return boolean
	 */
	public function onLinkEnd( $skin, Title $target, array $options, &$text, array &$attribs, &$ret )
	{
		wfProfileIn(__METHOD__);

		$targetArticleId = $target->getArticleId();
		if ( (! is_int($targetArticleId) ) || ( $this->wg->Article === null ) || $targetArticleId === 0 ) {
			wfProfileOut(__METHOD__);
			return true;
		}
		
		$targetId = $this->wg->CityID . '_' . $targetArticleId;
		$sourceId = $this->wg->CityID . '_' . $this->wg->Article->getId();

		if (! isset( self::$backlinkRows[$targetId] ) ) {
			self::$backlinkRows[$targetId] = array( $text => array( $sourceId => 1 ) );
		} else if (! isset( self::$backlinkRows[$targetId][$text] ) ) {
			self::$backlinkRows[$targetId][$text] = array( $sourceId => 1 );
		} else if (! isset( self::$backlinkRows[$targetId][$text][$sourceId] ) ) {
			self::$backlinkRows[$targetId][$text][$sourceId] = 1;
		} else {
			self::$backlinkRows[$targetId][$text][$sourceId]++;
		}

		wfProfileOut(__METHOD__);
		return true;

	}

	/**
	 * Queues up a job to handle the backlinks aggregated during this request
	 * @return boolean
	 */
	public function onOutputPageParserOutput()
	{
		wfProfileIn(__METHOD__);
		Job::batchInsert( array( new UpdateBacklinksJob( $this->wg->Title, self::$backlinkRows ) ) );
		self::$backlinkRows = array(); // prevent duplicate jobs
		wfProfileOut(__METHOD__);
		return true;

	}

	/**
	 * Called by maintenance script.
	 * @todo remove this method once we've ran it against all wikis
	 */
	static function dropTable() {
		wfProfileIn(__METHOD__);

		// create db handler
		$dbr = wfGetDb( DB_MASTER );

		if ( $dbr->tableExists(self::TABLE_NAME) ) {
			try {
				$dbr->query( 'DROP TABLE '.self::TABLE_NAME );
			}
			catch (Exception $e) {
				wfProfileOut(__METHOD__);
				return $e;
			}
			wfProfileOut(__METHOD__);
			return "Dropped table ".self::TABLE_NAME;
		}

		wfProfileOut(__METHOD__);
		return "Table ".self::TABLE_NAME." doesn't exists.";
	}
}
