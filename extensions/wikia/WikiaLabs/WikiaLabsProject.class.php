<?php

class WikiaLabsProject {
	const CACHE_TTL = 10800;
	const EXTERNAL_DATA_URL = 'http://messaging.wikia.com';
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
	protected $status = 0;

	public function __construct( WikiaApp $app, $id = 0) {
		$this->setApp( $app );
		if( !empty($id) ) {
			$this->load( $id );
		}
	}

	/**
	 * get db handler
	 * @return DatabaseBase
	 */
	public function getDb( $type = DB_SLAVE ) {
		return $this->app->runFunction( 'wfGetDB', $type, array(), $this->app->getGlobal( 'wgExternalDatawareDB' ) );
	}

	/**
	 * get cache handler
	 */
	public function getCache() {
		return $this->app->getGlobal( 'wgMemc' );
	}

	protected function getCacheKey() {
		return $this->app->runFunction( 'wfSharedMemcKey', __CLASS__, $this->getId() );
	}

	protected function getDataFromCache() {
		return $this->getCache()->get( $this->getCacheKey() );
	}

	protected function setDataToCache( $data ) {
		$data['id'] = $this->getId();
		$this->getCache()->set( $this->getCacheKey(), $data, self::CACHE_TTL );
	}

	protected function deleteDataFromCache() {
		$this->getCache()->delete( $this->getCacheKey() );
		$this->getCache()->delete( $this->getCachedRatingKey() );
		$this->getCache()->delete( $this->getCachedEnablesKey() );
	}

	public function getId() {
		return $this->id;
	}

	public function setApp(WikiaApp $app) {
		$this->app = $app;
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

	public function getReleaseDateMW() {
		return $this->app->runFunction( 'wfTimestamp', TS_MW, strtotime( $this->releaseDate ) );
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

	public function getActivationsNumFormated() {
		$wgLang = $this->app->getGlobal('wgLang');

		return $wgLang->formatNum($this->activationsNum);
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

	public function getStatus() {
		return $this->status;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	protected function getCachedEnables() {
		return $this->getCache()->get( $this->getCachedEnablesKey() );
	}

	protected function setCachedEnables( $enables ) {
		$this->getCache()->set( $this->getCachedEnablesKey(), $enables, self::CACHE_TTL );
	}

	protected function getCachedEnablesKey() {
		return $this->app->runFunction( 'wfSharedMemcKey', __CLASS__, 'getCachedEnables' , $this->getId() );
	}

	protected function updateCachedEnables( $wikiId, $status ) {
		$enables = $this->getCachedEnables();
		if( empty( $enables ) ) {
			$enables = array();
		}

		$enables[ $wikiId ] = $status;
		$this->setCachedEnables( $enables );
	}

	public function isEnabled( $wikiId ) {
		$cachedEnables = $this->getCachedEnables();
		if( !empty( $cachedEnables[$wikiId] ) ) {
			return $cachedEnables[$wikiId];
		}

		$enable = $this->getDb()->selectRow( 'wikia_labs_project_wiki_link', array( 'wlpwli_id' ), array(  'wlpwli_wlpr_id' => $this->getId(), 'wlpwli_wiki_id' => $wikiId ), __METHOD__ );
		$status = is_object($enable) ? true : false;

		$this->updateCachedEnables( $wikiId, $status );
		return $status;
	}

	public function setEnabled( $wikiId ) {
		$this->incrActivationsNum();
		$this->getDb( DB_MASTER )->insert( 'wikia_labs_project_wiki_link', array( 'wlpwli_wlpr_id' => $this->getId(), 'wlpwli_wiki_id' => $wikiId ), __METHOD__ );
		$this->updateCachedEnables( $wikiId, true );
		$this->update();
	}

	public function setDisabled( $wikiId ) {
		$this->decrActivationsNum();
		$this->getDb( DB_MASTER )->delete( 'wikia_labs_project_wiki_link', array( 'wlpwli_wlpr_id' => $this->getId(), 'wlpwli_wiki_id' => $wikiId ), __METHOD__ );
		$this->updateCachedEnables( $wikiId, false );
		$this->update();
	}

	public function load($id) {
		$this->id = $id;
		$cachedData = $this->getDataFromCache();
		if( !empty( $cachedData ) ) {
			$this->loadFromCache( $cachedData );
		}
		else {
			$this->loadFromDb();
		}
	}

	protected function loadFromCache( $cachedData ) {
		$this->id = $cachedData['id'];
		$this->name = $cachedData['wlpr_name'];
		$this->data = unserialize( $cachedData['wlpr_data'] );
		$this->releaseDate = $cachedData['wlpr_release_date'];
		$this->isActive = ( $cachedData['wlpr_is_active'] == 'y' ) ? true : false;
		$this->isGraduated = ( $cachedData['wlpr_is_graduated'] == 'y' ) ? true : false;
		$this->activationsNum = $cachedData['wlpr_activations_num'];
		$this->rating = $cachedData['wlpr_rating'];
		$this->pmEmail = $cachedData['wlpr_pm_email'];
		$this->techEmail = $cachedData['wlpr_tech_email'];
		$this->fogbugzProject = $cachedData['wlpr_fogbugz_project'];
		$this->extension = $cachedData['wlpr_extension'];
		$this->status = $cachedData['wlpr_status'];
	}

	protected function loadFromDb() {
		$project = $this->getDb()->selectRow(
			array( 'wikia_labs_project' ),
			array( 'wlpr_name', 'wlpr_status', 'wlpr_data', 'wlpr_release_date', 'wlpr_is_active', 'wlpr_is_graduated', 'wlpr_activations_num', 'wlpr_rating', 'wlpr_pm_email', 'wlpr_tech_email', 'wlpr_fogbugz_project', 'wlpr_extension' ),
			array( "wlpr_id" => $this->id ),
			__METHOD__
		);

		if(!empty($project)) {
			$this->name = $project->wlpr_name;
			$this->data = unserialize( $project->wlpr_data );
			$this->releaseDate = $project->wlpr_release_date;
			$this->isActive = ( $project->wlpr_is_active == 'y' ) ? true : false;
			$this->isGraduated = ( $project->wlpr_is_graduated == 'y' ) ? true : false;
			$this->activationsNum = $project->wlpr_activations_num;
			$this->rating = $project->wlpr_rating;
			$this->pmEmail = $project->wlpr_pm_email;
			$this->techEmail = $project->wlpr_tech_email;
			$this->fogbugzProject = $project->wlpr_fogbugz_project;
			$this->extension = $project->wlpr_extension;
			$this->status = $project->wlpr_status;
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
			'wlpr_extension' => $this->getExtension(),
			'wlpr_status' => $this->status,
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

		$users = $this->app->getGlobal('wgWikiaBotUsers');
		$api = F::build('WikiAPIClient');


		$url = self::EXTERNAL_DATA_URL;
		// devbox override
		$wgDevelEnvironment = $this->app->getGlobal('wgDevelEnvironment');

		if (!empty($wgDevelEnvironment)) {
			$url = str_replace('wikia.com', $this->app->getGlobal('wgDevelEnvironmentName').'.wikia-dev.com',$url);
		}

		$api->setExternalDataUrl($url);

		$api->login($users['staff']['username'], $users['staff']['password']);


		$data = $this->getData();

		$api->edit('MediaWiki:'.'wikialabs-projects-name-'.$this->getId(), $this->getName());
		empty($data['description']) or $api->edit('MediaWiki:'.'wikialabs-projects-description-'.$this->getId(), $data['description']);
		empty($data['warning']) or $api->edit('MediaWiki:'.'wikialabs-projects-warning-'.$this->getId(), $data['warning']);

		$db->commit();
		$this->setDataToCache( $fields );
	}

	public function delete() {
		if($this->getId()) {
			$this->getDb( DB_MASTER )->delete( 'wikia_labs_project', array( "wlpr_id" => $this->getId() ) );
			$this->deleteDataFromCache();
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
			__METHOD__,
			array( 'ORDER BY' => 'wlpr_id DESC' )
		);

		$projects = array();
		while( $row = $this->getDb()->fetchObject( $res ) ) {
			$projects[] = WF::build( 'WikiaLabsProject', array( 'id' => $row->wlpr_id ) );
		}

		return $projects;
	}

	public function getExtensionsDict() {
		return $this->app->getGlobal( 'wgWikiaLabsAllowed');
	}

	public function getStatusDict() {
		$status = array(
			'0' => wfMsg('wikialabs-add-project-status-inactive'),
			'1' => wfMsg('wikialabs-add-project-status-active'),
	//		'2' => wfMsg('wikialabs-add-project-status-hide-alow-to-inactive')
		);
		return $status;
	}

	protected function getCachedRatings() {
		return $this->getCache()->get( $this->getCachedRatingKey() );
	}

	protected function setCachedRatings( $ratings ) {
		$this->getCache()->set( $this->getCachedRatingKey(), $ratings, self::CACHE_TTL );
	}

	protected function getCachedRatingKey() {
		return $this->app->runFunction( 'wfSharedMemcKey', __CLASS__, 'getCachedRatings' );
	}

	protected function updateCachedRating( $userId, $rating ) {
		$ratings = $this->getCachedRatings();
		if( empty( $ratings ) ) {
			$ratings = array();
		}

		if( empty( $ratings[$this->getId()] ) ) {
			$ratings[$this->getId()] = array();
		}

		$ratings[$this->getId()][$userId] = $rating;

		$this->setCachedRatings( $ratings );
	}

	public function updateRating( $userId, $rating ) {
		if( $this->getId() ) {
			$row = $this->getDb()->selectRow( 'wikia_labs_project_rating', array( 'wlpra_id' ), array( 'wlpra_wlpr_id' => $this->getId(), 'wlpra_user_id' => $userId ), __METHOD__ );
			$fields = array( 'wlpra_wlpr_id' => $this->getId(), 'wlpra_user_id' => $userId, 'wlpra_value' => $rating );
			if( !empty( $row->wlpra_id ) ) {
				$this->getDb( DB_MASTER )->update( 'wikia_labs_project_rating', $fields, array( 'wlpra_id' => $row->wlpra_id ), __METHOD__ );
			}
			else {
				$this->getDb( DB_MASTER )->insert( 'wikia_labs_project_rating', $fields, __METHOD__ );
			}
			$this->updateCachedRating( $userId, $rating );

			//FB: #1945
			//$row = $this->getDb( DB_MASTER )->selectRow( 'wikia_labs_project_rating', array( 'SUM(wlpra_value)/COUNT(*) AS rating' ), array( 'wlpra_wlpr_id' => $this->getId() ) );
			$row = $this->getDb( DB_MASTER )->selectRow( 'wikia_labs_project_rating', array( 'COUNT(*) AS rating' ), array( 'wlpra_wlpr_id' => $this->getId() ), __METHOD__ );

			$this->setRating( $row->rating );
			$this->update();
		}
	}


	public function getTextFor($msg) {
		$data = $this->getData();
		$data['name'] = $this->getName();
		$msgFull = 'wikialabs-projects-' . $msg . '-'. $this->getId();

		if( wfEmptyMsg($msgFull,wfMsg($msgFull)) || $this->app->wg->Lang->getCode() == 'en' ) {
			return $data[$msg];

		} else {
			return wfMsg($msgFull);
		}
	}

	protected function getCachedRatingByUser( $userId ) {
		$ratings = $this->getCachedRatings();
		return ( !empty($ratings[$this->getId()][$userId]) ? $ratings[$this->getId()][$userId] : false );
	}

	public function getRatingByUser( $userId, $dbType = DB_SLAVE ) {
		$rating = 0;
		if( $this->getId() ) {
			$cachedRating = $this->getCachedRatingByUser( $userId );
			if( !empty( $cachedRating ) ) {
				return $cachedRating;
			}

			$row = $this->getDb( $dbType )->selectRow( 'wikia_labs_project_rating', array( 'wlpra_value' ), array( 'wlpra_wlpr_id' => $this->getId(), 'wlpra_user_id' => $userId ), __METHOD__ );
			if( !empty( $row->wlpra_value ) ) {
				$rating = $row->wlpra_value;
			}

			$this->updateCachedRating( $userId, $rating );
		}
		return $rating;
	}

}
