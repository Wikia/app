<?php
/*
 * MV_Special Page
 */
class SpecialWikiAtHome extends SpecialPage {
	public function __construct() {
		parent::__construct( 'SpecialWikiAtHome' );

		if ( method_exists( 'SpecialPage', 'setGroup' ) ) {
			parent::setGroup( 'SpecialWikiAtHome', 'media' );
		}
	}
	function execute( $par ) {
		global $wgOut;
		$wgOut->addScriptClass('WikiAtHome');		
		//for now just render out wiki@home header
		$html = '<h1 class="firstHeading" id="firstHeading">'.wfMsg('specialwikiathome').'</h1>';
		$html.='<div id="bodyContent">';
		$html.= wfMsg('wah-user-desc');
		$html.='<br /><br />';
		$html.= '<div id="wah_container" style="height:500px;">'.
					wfMsg('wah-javascript-off') .
				'</div>';
		$html.='<script type="text/javascript">' .
					'document.getElementById(\'wah_container\').innerHTML = "'.
						wfMsg('wah-loading') . '";</script>';
		$html.='</div>';
		$wgOut->addHTML( $html );
	}
}

?>