<?php

class WikiaLabs {
	const FOGBUGZ_PROJECT_ID = 13;
	const FOGBUGZ_CASE_PRIORITY = 5;
	const FOGBUGZ_CASE_TITLE = 'WikiaLabs Feedback - Project: ';
	const FOGBUGZ_CASE_TAG = 'WikiaLabsFeedback';

	protected $app = null;
	protected $request = null;
	protected $fogbugzAPIConfig = null;
	protected $fogbugzService = null;

	public function __construct() {
		$this->app = WF::build( 'App' );
		$this->request = $this->app->getGlobal('wgRequest');
		$this->user = $this->app->getGlobal( 'wgUser' );
		$this->fogbugzAPIConfig = $this->app->getGlobal( 'wgFogbugzAPIConfig' );
	}

	function onGetRailModuleSpecialPageList(&$railModuleList) {
		if($this->app->getGlobal('wgTitle')->isSpecial('WikiaLabs')) {
			$railModuleList['1500'] = array('Search', 'Index', null);
			$railModuleList['1400'] = array('WikiaLabs', 'Staff', null);
			$railModuleList['1450'] = array('WikiaLabs', 'Graduates', null);
		}

		return true;
	}

	// TODO: refactore this //
	function getProjectModal() {
		global $wgRequest;
		$id = $wgRequest->getVal('id');
		$wl = WF::build( 'WikiaLabs');
		$response =  WF::build( 'AjaxResponse' );
		$result = $wl->getProjectModalInternal((int) $wgRequest->getVal('id', 0));
		$response->addText($result);
		return $response;
	}

	function getProjectModalInternal($id) {
		$oTmpl = WF::build( 'EasyTemplate', array( dirname( __FILE__ ) . "/templates/" ) );
		$wikiaLabsProject = WF::build( 'WikiaLabsProject' );

		if( $id > 0) {
			$wlp = WF::build( 'WikiaLabsProject', array( 'id' => $id ) );
		} else {
			$wlp = WF::build( 'WikiaLabsProject', array() );
		}

		$oTmpl->set_vars( array(
			'project' => $wlp,
			'projectdata' => $wlp->getData(),
			'status' => $wikiaLabsProject->getStatusDict(),
			'extensions' => $wikiaLabsProject->getExtensionsDict(),
			'areas' => $this->getFogbugzAreas()
		));

		return $oTmpl->render("wikialabs-addproject");
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

	private function getFogbugzAreas() {
		return $this->getFogbugzService()->logon()->getAreas( self::FOGBUGZ_PROJECT_ID );
	}

	public static function saveFeedback() {
		$app = WF::build( 'App' );
		$request = $app->getGlobal( 'wgRequest' );
		$userId = $app->getGlobal( 'wgUser' )->getId();
		$wikiaLabs = WF::build( 'WikiaLabs' );

		$response = new AjaxResponse();
		$result =  $wikiaLabs->saveFeedbackInternal( $request->getVal('projectId', 0), $userId, $request->getVal('rating', 0), $request->getVal('feedbacktext') );

		$response->addText( json_encode( $result ) );
		return $response;
	}

	public function saveFeedbackInternal( $projectId, $userId, $rating, $message ) {
		$project = WF::build( 'WikiaLabsProject', array( 'id' => (int) $projectId ) );
		$projectId = $project->getId();

		$project->updateRating( $userId, $rating );

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
		$out['status'] = "ok";
		if( !$mulitvalidator->isValid( $in ) ) {
			$errors = $mulitvalidator->getErrors();
			foreach($errors as  $val1) {
				foreach($val1 as $val2) {
					$out['errors'][] = $val2;
				}
			}
			$out['in'] = $in;
			$out['status'] = "error";
			return $out;
		}

		$this->saveFeedbackInFogbugz( $project, $message );
		return $out;
	}

	private function saveFeedbackInFogbugz( WikiaLabsProject $project, $message ) {
		$areaId = $project->getFogbugzProject();
		$title = self::FOGBUGZ_CASE_TITLE . $project->getName();

		$this->getFogbugzService()->logon()->createCase( $areaId, $title, self::FOGBUGZ_CASE_PRIORITY, $message, array( self::FOGBUGZ_CASE_TAG ) );
	}

	// TODO: refactor this //
	function saveProject() {
		global $wgRequest;
		$response = new AjaxResponse();

		$wl = WF::build( 'WikiaLabs');
		$out = $wl->saveProjectInternal($wgRequest->getArray('project'));
		$response->addText(json_encode($out));
		return $response;
	}

	function saveProjectInternal($project) {
		$out = array();

		$project['enablewarning'] = isset($project['enablewarning']);
		$project['graduates'] = isset($project['graduates']);

		$validateResult = self::validateProjectForm($project);
		if( !$validateResult->isValid($project) ) {
			$out['status'] = "error";
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
			if( $project['id'] > 0 ) {
				$wlp = WF::build( 'WikiaLabsProject', array( 'id' => $project['id'] ) );
			} else {
				$wlp = WF::build( 'WikiaLabsProject', array() );
			}

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

			$out['status'] = 'ok';
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

	// TODO: refactore this //
	public function switchProject() {
		global $wgRequest, $wgCityId;
		$id = $wgRequest->getVal('id');
		$onoff  = $wgRequest->getVal('onoff');
		$wl = WF::build( 'WikiaLabs');
		$result = $wl->switchProjectInternal($wgCityId ,$id, $onoff) ? "ok":"error";
		$response = new AjaxResponse();
		$response->addText(json_encode(array("status" => $result)));
		return $response;
	}

	public function switchProjectInternal($city_id, $id, $onoff = true) {
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

	// TODO: refactore this //
	public function getImageUrlForEdit() {
		global $wgRequest;
		$name = $wgRequest->getVal("name", "");

		$wl = WF::build( 'WikiaLabs');
		$response = new AjaxResponse();
		$response->addText(json_encode($wl->getImageUrlForEditInternal($name)));

		return $response;
	}

	public function getImageUrlForEditInternal($name) {
		return array( "status" => "ok", "url" => $this->getImageUrl($name) );
	}

	public function onGetDefaultTools(&$list) {
		if($this->user->isAllowed( 'wikialabsuser' )) {
			$list[] = array(
				'text' => wfMsg( 'wikialabs-mytools' ),
				'name' => 'wikialabsuser',
				'href' => Title::newFromText( "WikiaLabs", NS_SPECIAL )->getFullUrl()
			);
		}

		return true;
	}
}
