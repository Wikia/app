<?php

class WikiaLabsProject {

	protected $id = 0;
	protected $app = null;
	protected $name;
	protected $data;
	protected $releaseDate;
	protected $isActive = false;
	protected $isGraduated = false;

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

	public function loadFromDb($id) {
		$project = $this->getDb()->selectRow(
			array( 'wikia_labs_project' ),
			array( 'wlpr_name', 'wlpr_data', 'wlpr_release_date', 'wlpr_is_active', 'wlpr_is_graduated' ),
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
		}
	}

	public function update() {
		$db = $this->getDb( DB_MASTER );

		$fields = array(
			'wlpr_name' => $this->getName(),
			'wlpr_data' => serialize( $this->getData() ),
			'wlpr_release_date' => $this->getReleaseDate(),
			'wlpr_is_active' => $this->isActive() ? 'y' : 'n',
			'wlpr_is_graduated' => $this->isGraduated() ? 'y' : 'n'
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

}