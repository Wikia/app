<?php

class WikiaLabs extends SpecialPage {

	private $mpa = null;

	function __construct() {
		parent::__construct( 'WikiaLabs', 'WikiaLabs' );
	}

	function execute($article_id = null, $limit = "", $offset = "", $show = true) {
		global $wgRequest, $wgOut, $wgTitle, $wgUser;
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/WikiaLabs/css/wikialabs.scss' )  );


		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
		));

		$wgOut->addHTML( $oTmpl->render("wikialabs-main") );

		return ;
	}
}

