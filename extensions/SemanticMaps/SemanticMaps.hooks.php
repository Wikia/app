<?php

/**
 * Static class for hooks handled by the Semantic Maps extension.
 * 
 * @since 0.7
 * 
 * @file SemanticMaps.hooks.php
 * @ingroup SemanticMaps
 * 
 * @author Jeroen De Dauw
 */
final class SemanticMapsHooks {

	/**
	 * Adds a link to Admin Links page.
	 * 
	 * @since 0.7
	 * 
	 * @return true
	 */
	public static function addToAdminLinks( &$admin_links_tree ) {	
	    $displaying_data_section = $admin_links_tree->getSection( wfMsg( 'smw_adminlinks_displayingdata' ) );
	
	    // Escape if SMW hasn't added links.
	    if ( is_null( $displaying_data_section ) ) return true;
	
	    $smw_docu_row = $displaying_data_section->getRow( 'smw' );
	
	    $sm_docu_label = wfMsg( 'adminlinks_documentation', 'Semantic Maps' );
	    $smw_docu_row->addItem( AlItem::newFromExternalLink( 'http://mapping.referata.com/wiki/Semantic_Maps', $sm_docu_label ) );
	
	    return true;		
	}
	
}