<?php

/**
 * WikiaApiQueryPopularPages - get list of most frequently accessed pages for selected namespace
 *
 * @author Piotr Molski (moli) <moli@wikia.com>
 *
 * @todo
 *
 */

class WikiaApiQueryMostVisitedPages extends WikiaApiQuery {
    /**
     * constructor
     */

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName);
	}

    /**
     * main function
     */
	public function execute() {
		global $wgUser;

		switch ($this->getActionName()) {
			case parent::INSERT :
								{
									// to do - is it needed?
									break;
								}
			case parent::UPDATE :
								{
									// to do - is it needed?
									break;
								}
			case parent::DELETE :
								{
									// to do - is it needed?
									break;
								}
			default: // query
								{
									$this->getMostVisitedPages();
									break;
								}
		}
	}

	#---
	private function getMostVisitedPages() {
		global $wgDBname;

        #--- blank variables
        $nspace = $user = null;

        #--- initial parameters (dbname, limit, offset ...)
		extract($this->getInitialParams());

        #--- request parameters ()
		extract($this->extractRequestParams());

		$this->initCacheKey($lcache_key, __METHOD__);

		try {
			#--- database instance
			if ( is_null($pagename) ) {
				throw new WikiaApiQueryError(1);
			}

			$this->setCacheKey ($lcache_key, 'P', $pagename);

			#---
			if ( !empty($ctime) ) {
				if ( !$this->isInt($ctime) ) {
					throw new WikiaApiQueryError(1);
				}
			}

			#--- limit
			if ( !empty($limit)  ) { //WikiaApiQuery::DEF_LIMIT
				if ( !$this->isInt($limit) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->setCacheKey ($lcache_key, 'L', $limit);
			}

			#--- offset
			if ( !empty($offset)  ) { //WikiaApiQuery::DEF_LIMIT_COUNT
				if ( !$this->isInt($offset) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->setCacheKey ($lcache_key, 'LO', $limit);
			}

			$data = array();
			// check data from cache ...
			$cached = $this->getDataFromCache($lcache_key);
			if (!is_array($cached))
			{
				#check to take data from article
				$templateTitle = Title::newFromText ($pagename, NS_MEDIAWIKI);
				if( $templateTitle->exists() )
				{
					$templateArticle = new Article ($templateTitle);
					$templateContent = $templateArticle->getContent();
					$lines = explode( "\n\n", $templateContent );
					foreach( $lines as $line )
					{
						$title = Title::NewFromText( $line );

						if( is_object( $title) )
						{
							#---
							$article['url'] = $title->getLocalUrl();
							$article['text'] = $title->getPrefixedText();

							$results[] = $article;
						}
					}

					if (!empty($results))
					{
						$results = array_slice( $results, $offset, $limit );
					}

					$data = array();
					if (!empty($results))
					{
						foreach ($results as $id => $result)
						{
							$data[$id] = $result;
							ApiResult :: setContent( $data[$id], $result['text'] );
						}
					}
					$this->saveCacheData($lcache_key, $data, $ctime);
				}
			} else {
				// ... cached
				$data = $cached;
			}
		} catch (WikiaApiQueryError $e) {
			// getText();
		} catch (DBQueryError $e) {
			$e = new WikiaApiQueryError(0, 'Query error: '.$e->getText());
		} catch (DBConnectionError $e) {
			$e = new WikiaApiQueryError(0, 'DB connection error: '.$e->getText());
		} catch (DBError $e) {
			$e = new WikiaApiQueryError(0, 'Error in database: '.$e->getLogMessage());
		}

		// is exception
		if ( isset($e) ) {
			$data = $e->getText();
			$this->getResult()->setIndexedTagName($data, 'fault');
		}
		else
		{
			$this->getResult()->setIndexedTagName($data, 'item');
		}
		$this->getResult()->addValue('query', $this->getModuleName(), $data);
	}

	/*
	 *
	 * Description's functions
	 *
	 */
	#---
	protected function getQueryDescription() {
		return 'Get most visited pages';
	}

	/*
	 *
	 * Description's parameters
	 *
	 */
	#---
	protected function getParamQueryDescription() {
		return 	array (
			'pagename' => 'Name of page with "most visited articles"'
		);
	}

	/*
	 *
	 * Allowed parameters
	 *
	 */

	#---
	protected function getAllowedQueryParams() {
		return array (
			"pagename" => array (
				ApiBase :: PARAM_TYPE => 'string'
			),
		);
	}

	/*
	 *
	 * Examples
	 *
	 */
	#---
	protected function getQueryExamples() {
		return array (
			'api.php?action=query&list=wkmostvisit&wkpagename=Most_popular_articles',
			'api.php?action=query&list=wkmostvisit&wkpagename=Most_popular_articles&wklimit=10',
		);
	}

	/*
	 *
	 * Version
	 *
	 */
	#---
	public function getVersion() {
		return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $';
	}
};

?>
