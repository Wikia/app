<?php
/**
 * WikiaApiQueryCategoryIntersection - get list of articles which belong to ALL of the provided categories
 *
 * @author Sean Colombo <sean@wikia.com>
 *
 * This extension was initially written for LyricWiki, but should be able to work on other wikis.
 *
 * TODO: Document whether this will need SMW or not.
 */

$wgAPIListModules[ "categoryintersection" ] = "WikiaApiQueryCategoryIntersection";

class WikiaApiQueryCategoryIntersection extends WikiaApiQuery {
    /**
     * constructor
     */
	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName);
	}

    /**
     * dispatcher
     */
	public function execute() {
		global $wgUser;

		switch ($this->getActionName()) {
			case parent::INSERT:
				// to do - is it needed?
				break;
			case parent::UPDATE:
				// to do - is it needed?
				break;
			case parent::DELETE:
				// to do - is it needed?
				break;
			case parent::QUERY:
			default:
				$this->getCategoryIntersection();
				break;
		}
	} // end execute()

	/**
	 * TODO: DOCUMENT
	 */
	private function getCategoryIntersection() {
		wfProfileIn( __METHOD__ );

		// Structure of result was chosen to be similar to 'categorymembers': http://www.mediawiki.org/wiki/API:Categorymembers
		$articles = array(
			array(
				'pageid' => '123',
				'ns' => NS_MAIN,
				'title' => 'First Article (This Is Test Data)'
			),
			array(
				'pageid' => '456',
				'ns' => NS_MAIN,
				'title' => 'Second Article (Also Faked For Testing)'
			),
		);

		$this->getResult()->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'article' );
		foreach($articles as $article){
			$this->getResult()->addValue(
									array('query', $this->getModuleName()),
									null,
									array(
										'pageid' => $article['pageid'],
										'ns' => $article['ns'],
										'title' => $article['title']
									)
								);
		}

		wfProfileOut( __METHOD__ );
	} // end getCategoryIntersection()

	/**
	 * Description for automatic documentation
	 */
	protected function getQueryDescription() {
		return 'Get articles which are in the intersection of multiple categories (ie: they belong to ALL of the provided categories).';
	}

	/**
	 * Parameters
	 */
	protected function getParamQueryDescription() {
		return 	array (
			'categories' => 'A pipe delimited list of '
		);
	}
	public function getParamDescription() {
		$desc = array (
			'categories' => 'A pipe delimited list of categories.  The returned articles will only be articles which are in ALL of the provided categories. Must include Category: prefix'
			/*
			'title' => 'Which category to enumerate (required). Must include Category: prefix',
			'prop' => 'What pieces of information to include',
			'namespace' => 'Only include pages in these namespaces',
			'sort' => 'Property to sort by',
			'dir' => 'In which direction to sort',
			'start' => 'Timestamp to start listing from. Can only be used with cmsort=timestamp',
			'end' => 'Timestamp to end listing at. Can only be used with cmsort=timestamp',
			'startsortkey' => 'Sortkey to start listing from. Can only be used with cmsort=sortkey',
			'endsortkey' => 'Sortkey to end listing at. Can only be used with cmsort=sortkey',
			'continue' => 'For large categories, give the value retured from previous query',
			'limit' => 'The maximum number of pages to return.',
			*/
		);
		return $desc;
	}

	/**
	 * Allowed parameters
	 */
	protected function getAllowedQueryParams() {
	
		// TODO: Add the extra parameters like in /includes/api/ApiQueryCategoryMembers.php and implement them above.
	
		return array (
			"categories" => array (
				ApiBase :: PARAM_ISMULTI => true,
				ApiBase :: PARAM_TYPE => 'string'
			),
		);
	}

	/**
	 * Examples
	 */
	protected function getQueryExamples() {
		return array (
			'api.php?action=query&list=categoryintersection&categories=Category:Artist_C|Category:Hometown/United_States/Pennsylvania',
			'api.php?action=query&list=categoryintersection&categories=Category:Artist_T|Category:Hometown/United_States|Category:Genre/Progressive_Rock',
		);
	}

	/**
	 * Version
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $';
	}
};
