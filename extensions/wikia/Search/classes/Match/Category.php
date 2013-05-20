<?php
/**
 * Class definition for Wikia\Search\Match\Category
 */
namespace Wikia\Search\Match;
use \Wikia\Search\Result as Result;
/**
 * This class correlates a page ID to a MediaWiki category (via interface), and creates a result based on it.
 * @author Aniuska
 * @package Search
 * @subpackage Match
 */
class Category extends AbstractMatch
{
	/**
	 * Creates a result instance.
	 * @see \Wikia\Search\Match\AbstractMatch::createResult()
	 * @return Result
	 */
	public function createResult() {
		
		$pageId = $this->service->getCanonicalPageIdFromPageId( $this->id );
                
		$fields = array(

				'id'        => $pageId,
                                'title'         => $this->service->getTitleStringFromPageId( $this->id ),
                                'ns'            => $this->service->getNamespaceFromPageId( $this->id ),
				'isCategoryMatch'=> true
				
			);
		$result = new Result( $fields);

		
		return $result;
	}
	
	
}


