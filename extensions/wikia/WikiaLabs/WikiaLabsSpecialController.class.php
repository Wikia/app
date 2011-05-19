<?php

/**
 * @author nAndy
 */
class WikiaLabsSpecialController extends WikiaSpecialPageController {
	private $title = null;
	private $user = null;
	private $extensionsPath = null;
	private $projects = null;
	
	public function __construct() {
		// standard SpecialPage constructor call
		parent::__construct( 'WikiaLabs' );
	}
	
	public function init() {
		$this->title = $this->app->getGlobal('wgTitle');
		$this->user = $this->app->getGlobal('wgUser');
		$this->extensionsPath = $this->app->getGlobal('wgExtensionsPath');
		
		$this->projects = WF::build( 'WikiaLabsProject')->getList(array("graduated" => false, "active" => true ) );
	} 
	
	/**
	 * @brief main page of WikiaLabs
	 * 
	 * @requestParam int feedbackAdded if equals 1 will show notification at the top of the page
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function index() {
		$this->wf->profileIn( __METHOD__ );
		
		if ( $this->user->isAnon() ) {
			$this->displayRestrictionError($this->user);
			$this->skipRendering();
			return;
		}
		
		if( 1 === intval( $this->getVal('feedbackAdded') ) ) {
			NotificationsModule::addConfirmation($this->app->runFunction('wfMsg', 'wikialabs-feedback-validator-notification-ok'));
		}
		
		$userId = $this->user->getId();
		$cityId = $this->app->getGlobal( 'wgCityId' );
		
		/*sync with WF */
		foreach($this->projects as $value) {
			$val = $this->app->runFunction( 'WikiFactory::getVarValueByName',  $value->getExtension(), $cityId);
			if( $value->isEnabled($cityId) != $val  ){
				if($val) {
					$value->setEnabled($cityId);
				} else {
					$value->setDisabled($cityId);
				}
				$value->update();
			}
		}
		
		$this->isAdmin = false;
		if( $this->user->isAllowed( 'wikialabsuser' ) ) {
			$this->isAdmin = true;
		}
		
		$this->setVal('projects', $this->projects);
		$this->setVal('user', $this->user);
		$this->setVal('cityId', $cityId);
		$this->setVal('userId', $userId);
		$this->setVal('contLang', $this->app->getGlobal( 'wgContLang' ));
		$this->setVal('wikilistUrl', $this->title->getFullUrl('method=wikislist'));
		$this->setVal('wgExtensionsPath', $this->extensionsPath);
		$this->setVal('isAdmin', $this->isAdmin);
		
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaLabs/css/wikialabs.scss'));
		$this->wg->Out->addScriptFile($this->extensionsPath.'/wikia/WikiaLabs/js/main.js');
		$this->wg->Out->setPageTitle($this->app->runFunction('wfMsg', 'wikialabs-list-project-title'));
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	/**
	 * @brief page with wikis that use the project
	 * 
	 * @requestParam int $project_id id of wikia labs project
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function wikislist() {
		$this->wf->profileIn( __METHOD__ );
		
		$this->wg->Out->setPageTitle($this->wf->msg('wikialabs-list-wikias-list-title'));
		
		if( !$this->user->isAllowed('wikialabsadmin') ) {
			$this->displayRestrictionError($this->user);
			$this->skipRendering();
			return;
		}
		
		$projectId = intval($this->getVal('project_id'));
		if( 0 >= $projectId ) {
			$this->redirect('WikiaLabsSpecial', 'onWrongProjectId');
			return true;
		}
		
		$pager = new WikiaLabsWikisListPager( WF::build( 'WikiaLabsProject'), $projectId );
		$this->setVal('pagerBody', $pager->getBody());
		$this->setVal('navigationBar', $pager->getNavigationBar());
		
		$this->setVal('wikialabUrl', $this->title->getFullUrl('method=index'));
		
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaLabs/css/wikialabs.scss'));
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	/**
	 * @brief Fired after passing wrong projectId in WikiaLabsSpecialController::wikislist()
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onWrongProjectId() {
		$this->wf->profileIn( __METHOD__ );
		
		$this->setVal('wikialabUrl', $this->title->getFullUrl('method=index'));
		
		$this->wg->Out->setPageTitle($this->wf->msg('wikialabs-list-wikias-list-title'));
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaLabs/css/wikialabs.scss'));
		
		$this->wf->profileOut( __METHOD__ );
	}
	
}
