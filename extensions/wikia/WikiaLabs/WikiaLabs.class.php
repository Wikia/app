<?php

class WikiaLabs {
	const FOGBUGZ_PROJECT_ID = 24;
	const FOGBUGZ_CASE_TITLE = 'WikiaLabs Feedback - Project: ';
	const FOGBUGZ_CASE_TAG = 'WikiaLabsFeedback';
	const TEMPLATE_NAME_ADDPROJECT = 'wikialabs-addproject';
	const STATUS_OK = 'ok';
	const STATUS_ERROR = 'error';
	
	/**
	 * @var array with feedback categories and its title and priority
	 */
	private $feedbackCategories = array(
		0 => array('title' => null, 'priority' => null, 'msg' => 'wikialabs-category-choose-one'),
		7 => array('title' => 'Love', 'priority' => 7, 'msg' => 'wikialabs-love-this-project'),
		6 => array('title' => 'Hate', 'priority' => 6, 'msg' => 'wikialabs-hate-this-project'),
		4 => array('title' => 'Problem', 'priority' => 4, 'msg' => 'wikialabs-problem-with-project'),
		5 => array('title' => 'Idea', 'priority' => 5, 'msg' => 'wikialabs-an-idea-for-project'),
	);
	
	/**
	 * @var integer TTL of memcached row 
	 */
	const FEEDBACK_FREQUENCY = 60;

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
		global $wgExtensionsPath;

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
			'areas' => $this->getFogbugzAreas(),
			'wgExtensionsPath' => $wgExtensionsPath,
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

	public function saveFeedback( $projectId, User $user, $rating, $category, $message ) {
		if( !$user->isAllowed( 'wikialabsuser' ) && !$user->isAllowed( 'wikialabsview' ) ) {
			return array( 
				'status' => self::STATUS_ERROR, 
				'errors' => array(wfMsg('wikialabs-feedback-validator-user-not-allowed')) 
			);
		}

		$project = WF::build( 'WikiaLabsProject', array( 'id' => (int) $projectId ) );

		$mulitvalidator = new WikiaValidatorsSet();

		$mulitvalidator->addValidator( 'message', new WikiaValidatorString(
					array('min' => 10, 'max' => 1000),
					array('too_short' => 'wikialabs-feedback-validator-message-too-short',
						  'too_long' => 'wikialabs-feedback-validator-message-too-long'
		)));

		$mulitvalidator->addValidator( 'projectId', new WikiaValidatorInteger(array('min' => 1)) );

		$mulitvalidator->addValidator( 'rating', new WikiaValidatorInteger(array('min' => 1, 'max' => 5),
					array(
						'too_small' => 'wikialabs-feedback-validator-rating'
				)) );
		
		$feedbackCategoryValidator = new WikiaValidatorCompareEmptyIF(array(
			'value' => true,
			'condition' => 'not_empty',
			'validator'  =>  new WikiaValidatorInteger(
				array(
					'min' => 4, 
					'max' => 7,
					'required' => true,
				),
				array(
					'not_int' => 'wikilabs-feedback-validator-category',
					'too_small' => 'wikilabs-feedback-validator-category',
					'too_big' => 'wikilabs-feedback-validator-category'
				)
			)
		));
		
		$mulitvalidator->addValidator('feedbackcategory', $feedbackCategoryValidator, array('message', 'feedbackcategory'));
		
		$in = array(
			'message' => $message,
			'projectId' => $projectId,
			'rating' => $rating,
			'feedbackcategory' => $category
		);

		$out = array();
		$out['status'] = self::STATUS_OK;
		if( !$mulitvalidator->isValid( $in ) ) {
			$errors = $mulitvalidator->getErrorsFlat();
			foreach($errors as  $val) {
				$out['errors'][] = $val->getMsg();
			}
			$out['in'] = $in;
			$out['status'] = self::STATUS_ERROR;
			return $out;
		}
		
		if( true !== ($result = $this->checkSpam($user->getName(), $project, $projectId)) ) {
			return $result;
		}
		
		$project->updateRating( $user->getId(), $rating );
		if( !empty($message) ) {
			$this->saveFeedbackInFogbugz( $project, $message, $user->getEmail(), $user->getName(), $category );
		}
		
		return $out;
	}
	
	/**
	 * @brief checks if this is not a spam attempt
	 * 
	 * @param string $userName name retrived from user object
	 * @param WikiaLabsProject $project data access object for wikia labs' project
	 * @param int $projectId id of wikia labs' project
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski 
	 * 
	 * @return true | Array array when an error occurs
	 */
	protected function checkSpam($userName, WikiaLabsProject $project, $projectId) {
		$cache = $project->getCache();
		//it didn't work without urlencode($userName) maybe because of multibyte signs
		$memcSpamKey = $this->app->runFunction( 'wfSharedMemcKey', __CLASS__, urlencode($userName), $projectId, 'spamCheckTime' );
		$memcSpamVal = $cache->get($memcSpamKey);
		
		if( empty($memcSpamVal) ) {
			$cache->set($memcSpamKey, true, self::FEEDBACK_FREQUENCY);
		} else {
			return array( 
				'status' => self::STATUS_ERROR, 
				'errors' => array(wfMsg('wikialabs-feedback-validator-spam-attempt')) 
			);
		}
		
		return true;
	}
	
	/**
	 * Saves feedback in fogbugz
	 * 
	 * @param WikiaLabsProject $project data access object
	 * @param string $message feedback message
	 * @param string $userEmail user's e-mail address
	 * @param string $userName user's name
	 * @param integer $feedbackCat feedback category which is defined above in $feedbackCategories property (equals piority in FogBugz: 4-7)
	 */
	protected function saveFeedbackInFogbugz( WikiaLabsProject $project, $message, $userEmail, $userName, $feedbackCat ) {
		$areaId = $project->getFogbugzProject();
		$title = self::FOGBUGZ_CASE_TITLE . $project->getName() .' - '.$this->feedbackCategories[$feedbackCat]['title'];
		
		$message = <<<MSG
User name: $userName
Wiki name: {$this->app->getGlobal('wgSitename')}
Wiki address: {$this->app->getGlobal('wgServer')}


$message
MSG;
		
		$this->getFogbugzService()->logon()->createCase( $areaId, $title, $feedbackCat, $message, array( self::FOGBUGZ_CASE_TAG ), $userEmail, self::FOGBUGZ_PROJECT_ID );
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
					$out['errors'][] = $val2->getMsg();
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

		$mulitvalidator = new WikiaValidatorsSet();

		$mulitvalidator->addValidator( 'name', new WikiaValidatorString(array( "required" => true, "min" => 1 ),
					array('too_short' => 'wikialabs-add-project-validator-name' )) );

		$mulitvalidator->addValidator( 'description', new WikiaValidatorString(array( "required" => true, "min" => 1 ),
					array('too_short' => 'wikialabs-add-project-validator-description' )) );

		$mulitvalidator->addValidator( 'link', new WikiaValidatorString(array("max" => 1024)) );

		$mulitvalidator->addValidator( 'prjscreen',  new WikiaValidatorString(array( "required" => true, "min" => 5 ),
					array('too_short' => 'wikialabs-add-project-validator-prjscreen' )) );

		$mulitvalidator->addValidator( 'warning', new WikiaValidatorString(array( "required" => true, "min" => 0) ) );

		$mulitvalidator->addValidator( 'status',  new WikiaValidatorSelect(array( "required" => true, "allowed" => $status)) );

		$mulitvalidator->addValidator( 'area',  new WikiaValidatorSelect(array( "required" => true, "allowed" => $areas)) );

		$mulitvalidator->addValidator( 'extension', new WikiaValidatorSelect(array( "required" => true, "allowed" => $projects)) );

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
                $logMsg = ( $onoff )
                    ? F::app()->wf->msgForContent( 'wikialabs-log-enabled-extension', $wikiaLabsProject->getName() )
                    : F::app()->wf->msgForContent( 'wikialabs-log-disabled-extension', $wikiaLabsProject->getName() );
                $log->addEntry( 'wikialabs', SpecialPage::getTitleFor( 'WikiaLabs'), $logMsg, array() );
                
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
	
	/**
	 * Simple getter for array with feedback categories
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getFeedbackCategories() {
		return $this->feedbackCategories;
	}
}
