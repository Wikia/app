<?php

class WikiaLabsSpecial extends SpecialPage {

	//private $mpa = null;
	protected $app = null;

	function __construct() {
		$this->app = WF::build( 'App' );
		$this->out = $this->app->getGlobal('wgOut');
		$this->user = $this->app->getGlobal('wgUser');
		parent::__construct( 'WikiaLabs', 'wikialabsuser' );
	}
	
	function execute( $par ) {
		if ( !$this->userCanExecute( $this->user ) ) {
			$this->displayRestrictionError($this->user);
			return ;
		}
		
		$oTmpl = WF::build( 'EasyTemplate', array( dirname( __FILE__ ) . "/templates/" ) );
		$projects = WF::build( 'WikiaLabsProject')->getList(array("graduated" => false, "active" => true  )  );
		$userId = $this->user->getId();
	
		$cityId = $this->app->getGlobal( 'wgCityId' );
		/*sync with WF*/
		foreach($projects as $value) {
			if((!$value->isEnabled($cityId)) && $this->app->runFunction( 'WikiFactory::getVarByName',  $value->getExtension(), $cityId) ){
				$value->setEnabled($cityId);
				$value->update();
			} 
		}
		
		$oTmpl->set_vars( array(
			'projects' => $projects,
			'cityId' => $this->app->getGlobal( 'wgCityId' ),
			'userId' => $userId,
			'contLang' => $this->app->getGlobal( 'wgContLang' ),
		) );
		
		$this->out->addStyle( $this->app->runFunction( 'wfGetSassUrl' , 'extensions/wikia/WikiaLabs/css/wikialabs.scss' ) );
		$this->out->addHTML( $oTmpl->render("wikialabs-main") );		
		$this->out->addScriptFile( $this->app->getGlobal('wgScriptPath')."/extensions/wikia/WikiaLabs/js/main.js" );
		$this->out->setPageTitle( $this->app->runFunction('wfMsg', 'wikialabs-list-project-title') );
		return ;
	}
}
