<?php 
/**
 * @author Andrzej 'nAndy' Lukaszewski
 */
class WikiaLabsWikisListPager extends AlphabeticPager {
	private $projectId = null;
	private $projects = null;
	private $mProjectDb = null;
	
	/**
	 * @brief Constructor
	 * 
	 * @details Sets three new properties: $projects, $projectId, $mProjectDb
	 * 
	 * @param WikiaLabsProject $projects data access object
	 * @param int $projectId id of project for which a list of wikis will be shown
	 */
	public function __construct(WikiaLabsProject $projects, $projectId) {
		parent::__construct();
		
		$this->projects = $projects;
		$this->projectId = $projectId;
		
		$this->mProjectDb = $this->projects->getDb();
	}
	
	/**
	 * @brief overwritten AlphabeticPager method
	 * @details sets database query
	 */
	public function getQueryInfo() {
		return array(
			'tables' => 'city_list',
			'fields' => 'city_id, city_title, city_url',
			'conds' => array('city_id' => $this->getWikisIds()),
			'options' => array('order by' => 'city_title')
		);
	}
	
	/**
	 * @brief overwritten AlphabeticPager method
	 * @details return index field -- the filed which sorts pager body data
	 * 
	 * @return String
	 */
	public function getIndexField() {
		return 'city_title';
	}
	
	/**
	 * @brief overwritten AlphabeticPager method
	 * @details fires WikiaLabsSpecial::renderPagerRow() method with $row variable
	 */
	public function formatRow($row) {
		return F::app()->getView('WikiaLabsSpecial', 'renderPagerRow', array('row' => $row))->render();
	}
	
	/**
	 * @brief Gets wikis' ids which are connected to given project id
	 * 
	 * @return array
	 */
	private function getWikisIds() {
		$res = $this->mProjectDb->select(
			array( 'wikia_labs_project_wiki_link' ),
			array( 'wlpwli_wiki_id' ),
			array( 'wlpwli_wlpr_id' => $this->projectId )
		);
		
		$ids = array();
		while( $row = $this->mDb->fetchObject($res) ) {
			$ids[] = $row->wlpwli_wiki_id;
		}
		
		return $ids;
	}
}