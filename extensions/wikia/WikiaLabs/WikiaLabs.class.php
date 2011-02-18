<?php

class WikiaLabs {
	const FOGBUGZ_PROJECT_ID = 13;
	const FOGBUGZ_CASE_PRIORITY = 5;
	const FOGBUGZ_CASE_TITLE = 'WikiaLabs Feedback - Project: ';
	const FOGBUGZ_CASE_TAG = 'WikiaLabsFeedback';
	const TEMPLATE_NAME_ADDPROJECT = 'wikialabs-addproject';
	const STATUS_OK = 'ok';
	const STATUS_ERROR = 'error';

	protected $app = null;
	protected $user = null;
	protected $fogbugzAPIConfig = null;
	protected $fogbugzService = null;

	public function __construct() {
		$this->app = WF::build( 'App' );
		$this->setUser( $this->app->getGlobal( 'wgUser' ) );
		$this->fogbugzAPIConfig = $this->app->getGlobal( 'wgFogbugzAPIConfig' );
	}

	public function onGetRailModuleSpecialPageList(&$railModuleList) {
		if($this->app->getGlobal('wgTitle')->isSpecial('WikiaLabs')) {
			$railModuleList['1500'] = array('Search', 'Index', null);
			$railModuleList['1400'] = array('WikiaLabs', 'Staff', null);
			$railModuleList['1450'] = array('WikiaLabs', 'Graduates', null);
		}

		return true;
	}

	public function getUser() {
		return $this->user;
	}

	public function setUser($user) {
		$this->user = $user;
	}

	public function getProjectModal( $projectId = 0 ) {
		if(!$this->getUser()->isAllowed( 'wikialabsuser' )) {
			return array();
		}

		$oTmpl = WF::build( 'EasyTemplate', array( dirname( __FILE__ ) . "/templates/" ) );
		$project = WF::build( 'WikiaLabsProject', array( 'id' => $projectId ) );

		$oTmpl->set_vars( array(
			'project' => $project,
			'projectdata' => $project->getData(),
			'status' => $project->getStatusDict(),
			'extensions' => $project->getExtensionsDict(),
			'areas' => $this->getFogbugzAreas()
		));

		return $oTmpl->render( self::TEMPLATE_NAME_ADDPROJECT );
	}

	/**
	 * get fogbugz service object
	 * @return FogbugzService
	 */
	private function getFogbugzService() {
		if( $this->fogbugzService == null ) {
			$this->fogbugzService = WF::build( 'FogbugzService', array( 'url' => $this->fogbugzAPIConfig['apiUrl'] ) );
			$this->fogbugzService->setLogin( $this->fogbugzAPIConfig['username'] );
			$this->fogbugzService->setPasswd( $this->fogbugzAPIConfig['password'] );
			$this->fogbugzService->setHTTPProxy( $this->app->getGlobal( 'wgHTTPProxy' ) );
		}
		return $this->fogbugzService;
	}

	public function getFogbugzAreas() {
		return $this->getFogbugzService()->logon()->getAreas( self::FOGBUGZ_PROJECT_ID );
	}

	public function saveFeedback( $projectId, User $user, $rating, $message ) {
		
		if ( $this->user->getId() == 0 ) {
			return array();
		}

		$project = WF::build( 'WikiaLabsProject', array( 'id' => (int) $projectId ) );

		$mulitvalidator = new WikiaValidatorArray(array(
			'validators'  => array(
				'message' => new WikiaValidatorString(array("min" => 1, "max" => 255),
					array('too_short' => wfMsg('wikialabs-feedback-validator-message-too-short'),
						  'too_long' => wfMsg('wikialabs-feedback-validator-message-too-long'),
				)),
				'projectId' => new WikiaValidatorInteger(array("min" => 1)),
				'rating' => new WikiaValidatorInteger(array("min" => 1, "max" => 5),
					array(
						'too_small' => wfMsg('wikialabs-feedback-validator-rating')
				)),
		)));

		$in = array(
			'message' => $message,
			'projectId' => $projectId,
			'rating' => $rating
		);

		$out = array();
		$out['status'] = self::STATUS_OK;
		if( !$mulitvalidator->isValid( $in ) ) {
			$errors = $mulitvalidator->getErrors();
			foreach($errors as  $val1) {
				foreach($val1 as $val2) {
					$out['errors'][] = $val2;
				}
			}
			$out['in'] = $in;
			$out['status'] = self::STATUS_ERROR;
			return $out;
		}

		$project->updateRating( $user->getId(), $rating );
		$this->saveFeedbackInFogbugz( $project, $message, $user->getEmail() );
		return $out;
	}

	protected function saveFeedbackInFogbugz( WikiaLabsProject $project, $message, $userEmail ) {
		$areaId = $project->getFogbugzProject();
		$title = self::FOGBUGZ_CASE_TITLE . $project->getName();

		$this->getFogbugzService()->logon()->createCase( $areaId, $title, self::FOGBUGZ_CASE_PRIORITY, $message, array( self::FOGBUGZ_CASE_TAG ), $userEmail );
	}

	public function saveProject( $project ) {
		if(!$this->getUser()->isAllowed( 'wikialabsadmin' )) {
			return array();
		}

		$out = array();

		$project['enablewarning'] = isset($project['enablewarning']);
		$project['graduates'] = isset($project['graduates']);

		$validateResult = $this->validateProjectForm($project);
		if( !$validateResult->isValid($project) ) {
			$out['status'] = self::STATUS_ERROR;
			$out['errors'] = array();
			$errors = $validateResult->getErrors();
			foreach($errors as  $val1) {
				foreach($val1 as $val2) {
					$out['errors'][] = $val2;
				}
			}
			return $out;
		} else {
			$project['id'] = (int) $project['id'];

			$wlp = WF::build( 'WikiaLabsProject', array( 'id' => $project['id'] ) );
			$wlp->setName($project['name']);
			$wlp->setFogbugzProject($project['area']);

			$data = array(
				'description' => $project['description'],
				'link' => $project['link'],
				'prjscreen' => $project['prjscreen'],
				'prjscreenurl' => $this->getImageUrl($project['prjscreen']),
				'warning' =>  $project['warning'],
				'enablewarning' => $project['enablewarning']
			);

			$wlp->setData($data);
			$wlp->setGraduated( $project['graduates'] );
			$wlp->setActive($project['status'] == 1);
			$wlp->setStatus($project['status']);
			$wlp->setExtension($project['extension']);
			$wlp->update();

			$out['status'] = self::STATUS_OK;
			return $out;
		}
	}

	public function validateProjectForm($values = array()) {
		$wikiaLabsProject = WF::build( 'WikiaLabsProject' );

		$areas = array();
		$areasData = $this->getFogbugzAreas();

		foreach( $areasData as $value ) {
			$areas[] = $value['id'];
		}

		$status = array_keys($wikiaLabsProject->getStatusDict());
		$projects = $wikiaLabsProject->getExtensionsDict();

		$mulitvalidator = new WikiaValidatorArray(array(
			'validators'  => array(
				'description' => new WikiaValidatorString(array("min" => 1),
					array('too_short' => wfMsg('wikialabs-add-project-validator-description') ) ),
				'name' => new WikiaValidatorString(array("min" => 1),
					array('too_short' => wfMsg('wikialabs-add-project-validator-name') )),
				'link' => new WikiaValidatorString(array("min" => 0)),
				'prjscreen' => new WikiaValidatorString(array("min" => 3),
					array('too_short' => wfMsg('wikialabs-add-project-validator-prjscreen') )),
				'warning' => new WikiaValidatorString(array("min" => 0) ),
				'status' => new WikiaValidatorInArray(array("allowed" => $status)),
				'area' =>  new WikiaValidatorInArray(array("allowed" => $areas)),
				'extension' => new WikiaValidatorInArray(array("allowed" => $projects)),
		)));

		return $mulitvalidator;
	}

	public function switchProject($city_id, $id, $onoff = true) {
		if(!$this->getUser()->isAllowed( 'wikialabsuser' )) {
			return array();
		}

		$wikiaLabsProject = WF::build( 'WikiaLabsProject', array( "id" => $id));
		if($wikiaLabsProject->getId() == 0) {
			return false;
		}

		if(!empty($onoff)) {
			$wikiaLabsProject->setEnabled($city_id);
		} else {
			$wikiaLabsProject->setDisabled($city_id);
		}

		$wikiaLabsProject->update();

		$log = WF::build( 'LogPage', array( 'wikialabs' ) );
		$log->addEntry( 'wikialabs', SpecialPage::getTitleFor( 'WikiaLabs'), ($onoff ? "ON":"OFF") . " - " . $wikiaLabsProject->getExtension(),  array() );

		$this->app->runFunction( 'wfRunHooks', 'WikiFactoryChanged', array( $wikiaLabsProject->getExtension() , $city_id, !empty($onoff) ) );
		return $this->app->runFunction( 'WikiFactory::setVarByName',  $wikiaLabsProject->getExtension(), $city_id, !empty($onoff), "WikiaLabs" );
	}

	protected function getImageUrl($name) {
		if(empty($name)){
			return "";
		}

		$file_title = Title::newFromText( $name, NS_FILE );
		$img = wfFindFile( $file_title  );

		return wfReplaceImageServer( $img->getThumbUrl( $img->thumbName( array( 'width' => 150 ) ) ) );
	}

	public function getImageUrlForEdit( $name ) {
		return array( "status" => "ok", "url" => $this->getImageUrl($name) );
	}

	public function onGetDefaultTools(&$list) {
		if($this->getUser()->isAllowed( 'wikialabsuser' )) {
			$list[] = array(
				'text' => wfMsg( 'wikialabs' ),
				'name' => 'wikialabsuser',
				'href' => Title::newFromText( "WikiaLabs", NS_SPECIAL )->getFullUrl()
			);
		}

		return true;
	}
}
