<?php
/**
 * Class definition for \Wikia\Search\ResultSet\CombinedMediaResultSet
 */
namespace Wikia\Search\ResultSet;
use Wikia\Search\Result;

/**
 * Result Set for CombinedMedia Select Service
 * @package Search
 * @subpackage ResultSet
 */
class CombinedMediaResultSet extends Base
{
	private $titleSet = [];

	/**
	 * Override to filter out videos with the same title.
	 * @param Result $result
	 * @return $this
	 */
	protected function addResult(Result $result) {
		if( ( sizeof( $this->titleSet ) >= $this->searchConfig->getLimit() ) ||
			isset($this->titleSet[$result->getTitle()]) ) {
			return $this;
		} else {
			$this->titleSet[$result->getTitle()] = true;
			return parent::addResult($result);
		}
	}

}
