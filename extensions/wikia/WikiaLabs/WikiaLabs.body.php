<?php

class WikiaLabsSpecial extends SpecialPage {

	//private $mpa = null;
	protected $app = null;

	function __construct() {
		$this->app = WF::build( 'App' );
		parent::__construct( 'WikiaLabs', 'WikiaLabs' );
	}

	function execute($article_id = null, $limit = "", $offset = "", $show = true) {
		
		$this->app->getGlobal('wgOut')->addStyle( $this->app->runFunction( 'wfGetSassUrl' , 'extensions/wikia/WikiaLabs/css/wikialabs.scss' ) );


		$oTmpl = WF::build( 'EasyTemplate', array( dirname( __FILE__ ) . "/templates/" ) );
		$oTmpl->set_vars( array() );

		$this->app->getGlobal('wgOut')->addHTML( $oTmpl->render("wikialabs-main") );		
		$this->app->getGlobal('wgOut')->addScriptFile( $this->app->getGlobal('wgScriptPath')."/extensions/wikia/WikiaLabs/js/main.js" );
		
		
		return ;
	}
}
