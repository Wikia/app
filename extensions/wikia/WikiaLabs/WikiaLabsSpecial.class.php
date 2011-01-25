<?php

class WikiaLabsSpecial extends SpecialPage {

	//private $mpa = null;
	protected $app = null;

	function __construct() {
		$this->app = WF::build( 'App' );
		$this->out = $this->app->getGlobal('wgOut'); 
		parent::__construct( 'WikiaLabs', 'wikialabsuser' );
	}

	function execute($article_id = null, $limit = "", $offset = "", $show = true) {
		$oTmpl = WF::build( 'EasyTemplate', array( dirname( __FILE__ ) . "/templates/" ) );

		$out = WF::build( 'WikiaLabsProject')->getList(array("graduated" => false, "active" => true  )  );
	
		$oTmpl->set_vars( array(
			'projects' => $out,
			'cityId' => $this->app->getGlobal('wgCityId'),
			'contLang' => $this->app->getGlobal('wgContLang')
		));
		
		$this->out->addStyle( $this->app->runFunction( 'wfGetSassUrl' , 'extensions/wikia/WikiaLabs/css/wikialabs.scss' ) );
		$this->out->addHTML( $oTmpl->render("wikialabs-main") );		
		$this->out->addScriptFile( $this->app->getGlobal('wgScriptPath')."/extensions/wikia/WikiaLabs/js/main.js" );
		$this->out->setPageTitle( $this->app->runFunction('wfMsg', 'wikialabs-list-project-title') );
		return ;
	}
}
