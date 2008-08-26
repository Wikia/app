<?php

// Class definition for Extension:InterwikiList

// Suppress fatal error about SpecialPage class not found if called as entry point
if ( !defined('MEDIAWIKI') ) {
        die( '' );
}
 
class InterwikiList extends SpecialPage {
	
	/**
	* Constructor
	*/
	public function InterwikiList() {
		SpecialPage::SpecialPage("InterwikiList");
		wfLoadExtensionMessages('InterwikiList');
	}
	
	/**
	 * Execute
	 */
	public function execute( $par ) {
		global $wgOut;
		$wgOut->setPagetitle( wfMsg( 'interwikilist' ) );
		$selfTitle = Title::makeTitle( NS_SPECIAL, 'InterwikiList' );
		$wgOut->addHTML( $this->getInterwikis() );
	}
	
	/** 
	* Get all Interwiki Links - the heart of the function
	*/
	private function getInterwikis() {
		$dbr = wfGetDB( DB_SLAVE );
		
		$results = $dbr->select( 'interwiki', array( 'iw_prefix', 'iw_url' ) );
		
		$text = Xml::openElement( 'table', array( 'id' => 'sv-software' ) ) . "<tr>
							<th>" . wfMsg( 'interwikilist-linkname' ) . "</th>
							<th>" . wfMsg( 'interwikilist-target' ) . "</th>
						</tr>\n";
		
		while ( $row = $dbr->fetchObject( $results ) ) {                      
				$text .= "						<tr>
							<td>" . htmlspecialchars( $row->iw_prefix ) . "</td>
							<td>" . htmlspecialchars( $row->iw_url ) . "</td>
						</tr>\n";
		}
		$text .= "</table>\n";
		$dbr->freeResult( $results );
		
		return $text;
	}
}