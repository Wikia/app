<?php

class WikiaLabsProject {

	protected $id = 0;
	protected $app = null;
	protected $name;
	protected $data;
	protected $releaseDate = null;
	protected $isActive = false;
	protected $isGraduated = false;
	protected $activationsNum = 0;
	protected $rating = 0;
	protected $pmEmail;
	protected $techEmail;
	protected $fogbugzProject;
	protected $extension;

	public function __construct( WikiaApp $app, $id = 0) {
		$this->app = $app;
		if( !empty($id) ) {
			$this->loadFromDb($id);
		}
	}

	/**
	 * get db handler
	 * @return DatabaseBase
	 */
	protected function getDb( $type = DB_SLAVE ) {
		return $this->app->runFunction( 'wfGetDB', $type, array(), $this->app->getGlobal( 'wgExternalDatawareDB' ) );
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($value) {
		$this->name = $value;
	}

	public function getData() {
		return $this->data;
	}

	public function setData(Array $value) {
		$this->data = $value;
	}

	public function getReleaseDate() {
		return strtotime( $this->releaseDate );
	}

	public function setReleaseDate( $timestamp = null ) {
		$timestamp = is_null($timestamp) ? time() : $timestamp;
		$this->releaseDate = date( 'Y-m-d', $timestamp );
	}

	public function isActive() {
		return $this->isActive;
	}

	public function setActive($value) {
		$this->isActive = $value;
	}

	public function isGraduated() {
		return $this->isGraduated;
	}

	public function setGraduated($value) {
		$this->isGraduated = $value;
	}

	public function getActivationsNum() {
		return $this->activationsNum;
	}

	public function setActivationsNum($value) {
		$this->activationsNum = $value;
	}

	public function incrActivationsNum() {
		$this->activationsNum++;
	}

	public function decrActivationsNum() {
		$this->activationsNum--;
	}

	public function getRating() {
		return $this->rating;
	}

	public function setRating($value) {
		$this->rating = $value;
	}

	public function getPMEmail() {
		return $this->pmEmail;
	}

	public function setPMEmail($value) {
		$this->pmEmail = $value;
	}

	public function getTechEmail() {
		return $this->techEmail;
	}

	public function setTechEmail($value) {
		$this->techEmail = $value;
	}

	public function getFogbugzProject() {
		return $this->fogbugzProject;
	}

	public function setFogbugzProject($value) {
		$this->fogbugzProject = $value;
	}

	public function getExtension() {
		return $this->extension;
	}

	public function setExtension($value) {
		$this->extension = $value;
	}

	public function isEnabled( $wikiId ) {
		$enable = $this->getDb()->selectRow( 'wikia_labs_project_wiki_link', array( 'wlpwli_id' ), array( 'wlpwli_wiki_id' => $wikiId ), __METHOD__ );
		return is_object($enable) ? true : false;
	}

	public function setEnabled( $wikiId ) {
		$this->incrActivationsNum();
		$this->getDb( DB_MASTER )->insert( 'wikia_labs_project_wiki_link', array( 'wlpwli_wlpr_id' => $this->getId(), 'wlpwli_wiki_id' => $wikiId ), __METHOD__ );
		$this->update();
	}

	public function setDisabled( $wikiId ) {
		$this->decrActivationsNum();
		$this->getDb( DB_MASTER )->delete( 'wikia_labs_project_wiki_link', array( 'wlpwli_wlpr_id' => $this->getId(), 'wlpwli_wiki_id' => $wikiId ), __METHOD__ );
	}

	public function loadFromDb($id) {
		$project = $this->getDb()->selectRow(
			array( 'wikia_labs_project' ),
			array( 'wlpr_name', 'wlpr_data', 'wlpr_release_date', 'wlpr_is_active', 'wlpr_is_graduated', 'wlpr_activations_num', 'wlpr_rating', 'wlpr_pm_email', 'wlpr_tech_email', 'wlpr_fogbugz_project', 'wlpr_extension' ),
			array( "wlpr_id" => $id ),
			__METHOD__
		);

		if(!empty($project)) {
			$this->id = $id;
			$this->name = $project->wlpr_name;
			$this->data = $project->wlpr_data;
			$this->releaseDate = $project->wlpr_release_date;
			$this->isActive = ( $project->wlpr_is_active == 'y' ) ? true : false;
			$this->isGraduated = ( $project->wlpr_is_graduated == 'y' ) ? true : false;
			$this->activationsNum = $project->wlpr_activations_num;
			$this->rating = $project->wlpr_rating;
			$this->pmEmail = $project->wlpr_pm_email;
			$this->techEmail = $project->wlpr_tech_email;
			$this->fogbugzProject = $project->wlpr_fogbugz_project;
			$this->extension = $project->wlpr_extension;
		}
	}

	public function update() {
		$db = $this->getDb( DB_MASTER );

		$fields = array(
			'wlpr_name' => $this->getName(),
			'wlpr_data' => serialize( $this->getData() ),
			'wlpr_release_date' => date( 'Y-m-d', $this->getReleaseDate()),
			'wlpr_is_active' => $this->isActive() ? 'y' : 'n',
			'wlpr_is_graduated' => $this->isGraduated() ? 'y' : 'n',
			'wlpr_activations_num' => $this->getActivationsNum(),
			'wlpr_rating' => $this->getRating(),
			'wlpr_pm_email' => $this->getPMEmail(),
			'wlpr_tech_email' => $this->getTechEmail(),
			'wlpr_fogbugz_project' => $this->getFogbugzProject(),
			'wlpr_extension' => $this->getExtension()
		);

		if($this->getId()) {
			$db->update(
				'wikia_labs_project',
				$fields,
				array( "wlpr_id" => $this->getId() ),
				__METHOD__
			);
		}
		else {
			if( $this->releaseDate == null ) {
				// set current date as release date
				$this->setReleaseDate();
				$fields['wlpr_release_date'] = date( 'Y-m-d', $this->getReleaseDate());
			}
			$db->insert(
				'wikia_labs_project',
				$fields,
				__METHOD__
			);
			$this->id = $db->insertId();
		}
	}

	public function delete() {
		if($this->getId()) {
			$this->getDb( DB_MASTER )->delete( 'wikia_labs_project', array( "wlpr_id" => $this->getId() ) );
		}
	}

	public function getList(Array $refinements = array()) {
		$whereClause = array();

		if(isset($refinements['active'])) {
			$whereClause['wlpr_is_active'] = ( $refinements['active'] ? 'y' : 'n' );
		}

		if(isset($refinements['graduated'])) {
			$whereClause['wlpr_is_graduated'] = ( $refinements['graduated'] ? 'y' : 'n' );
		}

		if(!empty($refinements['name'])) {
			$whereClause['wlpr_name'] = $refinements['name'];
		}

		$res = $this->getDb()->select(
			array( 'wikia_labs_project' ),
			array( 'wlpr_id' ),
			$whereClause,
			__METHOD__
		);

		$projects = array();
		while( $row = $res->fetchObject( $res ) ) {
			$projects[] = WF::build( 'WikiaLabsProject', array( 'id' => $row->wlpr_id ) );
		}

		return $projects;
	}

}