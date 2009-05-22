<?php

if (!defined('MEDIAWIKI')) {
	// Eclipse helper - will be ignored in production
	require_once ("ApiQueryBase.php");
}

/**
 * A query module to generate pageviews .
 *
 */
class WikiaApiQueryPageinfo extends ApiQueryGeneratorBase {

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'pi');
	}

	public function execute() {
		$this->run();
	}

	public function executeGenerator($resultPageSet) {
		$this->run($resultPageSet);
	}

	private function run($resultPageSet = null) {

		if ($this->getPageSet()->getGoodTitleCount() == 0)
			return;	// nothing to do

		$params = $this->extractRequestParams();
		$prop = array_flip($params['prop']);
		#--- columns
		$this->addFields( array( 'article_id', 'count as page_counter' ) );
		#--- table
		$this->addTables('page_visited');
		#--- where
		$this->addWhereFld('article_id', array_keys($this->getPageSet()->getGoodTitles()));
		if (!is_null($params['continue'])) {
			$cont = explode('|', $params['continue']);
			if ( count($cont) != 1 )
				$this->dieUsage("Invalid continue param. You should pass the " .
					"original value returned by the previous query", "_badcontinue");
			$pagefrom = intval($cont[0]);
			$this->addWhere("article_id >= '$pagefrom'");
		}
		#--- order 
		if ( count($this->getPageSet()->getGoodTitles()) > 1 ) {
			$order = $params['order'];
			if (!is_null($order)) {
				switch ($order) {
					case 'page':
						$this->addOption('ORDER BY', 'article_id');
						break;
					case 'views':
						$this->addOption('ORDER BY', 'count desc');
						break;
					default :
						ApiBase :: dieDebug(__METHOD__, "Unknown prop=$p");
				}
			}
		}

		$db = $this->getDB();
		$res = $this->select(__METHOD__);

		$count = 0;
		if (is_null($resultPageSet)) {
			$data = array();
			$lastId = 0;	// database has no ID 0
			while ($row = $db->fetchObject($res)) {
				if (++$count > $params['limit']) {
					// We've reached the one extra which shows that
					// there are additional pages to be had. Stop here...
					$this->setContinueEnumParameter('continue', $row->artilce_id . '|' . $row->page_counter );
					break;
				}
				$record = array (
					'id' => $row->article_id
				);
				$oTitle = Title :: newFromId($row->article_id);
				if ($oTitle instanceof Title) {
					$record['views'] = $row->page_counter;

					if ( isset($prop['revcount']) ) {
						$record['revcount'] = Revision::countByPageId($db, $row->article_id);
					}
				}
				$data[$row->article_id] = $record;
				$this->addPageSubItems($row->article_id, $record);

				
			}
		} else {
			$titles = array();
			while ($row = $db->fetchObject($res)) {
				if (++$count > $params['limit']) {
					// We've reached the one extra which shows that
					// there are additional pages to be had. Stop here...
					$this->setContinueEnumParameter('continue', $row->artilce_id . '|' . $row->page_counter );
					break;
				}

				$oTitle = Title :: newFromId($row->article_id);
				$titles[] = $oTitle;
			}
			$resultPageSet->populateFromTitles($titles);
		}

		$db->freeResult($res);
	}

	public function getAllowedParams() {
		return array ( 
			'order' => array(
				ApiBase :: PARAM_ISMULTI => true,
				ApiBase :: PARAM_TYPE => array(
					'page',
					'views',
				)
			),
			'limit' => array(
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),
			'prop' => array (
				ApiBase :: PARAM_ISMULTI => true,
				ApiBase :: PARAM_DFLT => 'views',
				ApiBase :: PARAM_TYPE => array (
					'views',
					'revcount',
				)
			),
			'continue' => null
		);
	}

	public function getParamDescription() {
		return array ( 
			'order' 	=> 'How to order results (by page id orac # views)',
			'limit' 	=> 'How many articles return',
			'prop' 		=> 'What image information to get.',
			'continue' 	=> 'When more results are available, use this to continue',
		);
	}

	public function getDescription() {
		return 'Pageviews of page';
	}

	protected function getExamples() {
		return array (
			"Get a pageviews of [[Main Page]] ",
			"  api.php?action=query&prop=pageviews&titles=Main%20Page&piprop=views|revcount"
		);
	}

	public function getVersion() { 
		return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $'; 
	}
}
