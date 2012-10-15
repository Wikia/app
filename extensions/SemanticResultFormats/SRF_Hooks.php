<?php

/**
 * Static class for hooks handled by the Semantic Result Formats
 * @since 1.7
 * 
 * @file SRF_Hooks.php
 * @ingroup SemanticResultFormats
 * 
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SRFHooks {
	
	/**
	 * Adds a link to Admin Links page.
	 */
	public static function addToAdminLinks( &$admin_links_tree ) {
		$displaying_data_section = $admin_links_tree->getSection( wfMsg( 'smw_adminlinks_displayingdata' ) );
		
		// Escape is SMW hasn't added links.
		if ( is_null( $displaying_data_section ) ) {
			return true;
		}
			
		$smw_docu_row = $displaying_data_section->getRow( 'smw' );
		$srf_docu_label = wfMsg( 'adminlinks_documentation', wfMsg( 'srf-name' ) );
		$smw_docu_row->addItem( AlItem::newFromExternalLink( 'https://www.mediawiki.org/wiki/Extension:Semantic_Result_Formats', $srf_docu_label ) );
		
		return true;
	}
	
}
