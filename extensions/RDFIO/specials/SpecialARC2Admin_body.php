<?php
/**
 * SpecialARC2Admin is a Special page for setting up the database tables for an ARC2 RDF Store
 * @author samuel.lampa@gmail.com
 * @package SMWRDFConnector
 */
class ARC2Admin extends SpecialPage {

	protected $m_issysop;

	function __construct() {
		global $wgUser;

		$usergroups = $wgUser->getGroups();
		if ( in_array( 'sysop', $usergroups ) ) {
			$this->m_issysop = true;
		} else {
			$this->m_issysop = false;
		}

		parent::__construct( 'SpecialARC2Admin' );
    }

    function execute( $par ) {
		global $wgRequest, $wgOut, $smwgARC2StoreConfig,
			$wgServer, $wgScriptPath, $wgUser;

		$this->setHeaders();
		$output = "";

		# Get request data from, e.g.
		$rdfio_action = $wgRequest->getText( 'rdfio_action' );

		# instantiation
		$store = ARC2::getStore( $smwgARC2StoreConfig );

		$output .= "\n===RDF Store Setup===\n'''Status:'''\n\n";

		if ( !$store->isSetUp() ) {
			$output .= "* Store is '''not''' set up\n";
			if ( $rdfio_action == "setup" ) {
				if ( !$wgUser->matchEditToken( $wgRequest->getText( 'token' ) ) ) {
					die( 'Cross-site request forgery detected!' );
				} else {
					if ( $this->m_issysop ) {
						$output .= "* Setting up now ...\n";
						$store->setUp();
						$output .= "* Done!\n";
					} else {
						$errormessage = "Only sysops can perform this operation!";
						$wgOut->addHTML( RDFIOUtils::formatErrorHTML( "Permission Error", $errormessage ) );
					}
				}
			}
		} else {
			$output .= "* Store is already set up.\n";
		}

		$wgOut->addWikiText( $output );

		$htmlOutput = '<form method="get" action="' . $wgServer . $wgScriptPath . '/index.php/Special:ARC2Admin"
			name="createEditQuery">
			<input type="submit" name="rdfio_action" value="setup">' .
			Html::Hidden( 'token', $wgUser->editToken() ) . '
			</form>';

		$wgOut->addHTML( $htmlOutput );

	}
}
