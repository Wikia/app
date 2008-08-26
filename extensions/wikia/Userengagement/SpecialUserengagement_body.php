<?php
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/wikia/Userengagement/SpecialUserengagement.php" );
EOT;
        exit( 1 );
}

class Userengagement extends SpecialPage {
	/**
	 * Constructor
	 */
	function Userengagement() {
		SpecialPage::SpecialPage( 'Userengagement','',false );
		wfLoadExtensionMessages( "Userengagement" );
		$this->includable( true );
	}

	/**
	 * main()
	 */
	function execute( $par = null ) {
		global $wgRequest, $wgOut;

		//this is action controller

		$wgOut->setPageTitle( wfMsg('userengagement') );
        $wgOut->setRobotpolicy( 'noindex,nofollow' );
		//INLINE
		$wgOut->addHTML ("
			<style type=\"text/css\">
				.userengagement {
					background-color: #c0fec0;
					border: solid 1px #006400;
				}
			</style>
		");

	    $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );


		switch ($_REQUEST['action']){

		 default:
		    $out = array( 'err' => '' );

		    $out['preview'] = $this->getPreviews();

			//errors encountered
			$out['err'] = $this->err ;

			$oTmpl->set_vars( array(
	               "data" => $out
	            ));

	         $wgOut->addHTML( $oTmpl->execute("preview") );
			 break;

		}
	}

	function getPreviews(){
		global $ue_events;
		return $ue_events;
	}
}//class end
