<?php

/**
 * Static class for hooks handled by the Maps extension.
 * 
 * @since 0.7
 * 
 * @file Maps.hooks.php
 * @ingroup Maps
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class MapsHooks {
	
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
	
	    $maps_docu_label = wfMsg( 'adminlinks_documentation', 'Maps' );
	    $smw_docu_row->addItem( AlItem::newFromExternalLink( 'http://mapping.referata.com/wiki/Maps', $maps_docu_label ) );
	
	    return true;
	}
	
	/**
	 * Hook to add PHPUnit test cases.
	 * 
	 * @since 0.7
	 * 
	 * @param array $files
	 */
	public static function registerUnitTests( array &$files ) {
		$testDir = dirname( __FILE__ ) . '/test/';
		
		$files[] = $testDir . 'MapsCoordinateParserTest.php';
		$files[] = $testDir . 'MapsDistanceParserTest.php';
		
		return true;
	}
	
	/**
	 * Intercept pages in the Layer namespace to handle them correctly.
	 *
	 * @param $title: Title
	 * @param $article: Article or null
	 *
	 * @return true
	 */
	public static function onArticleFromTitle( Title &$title, /* Article */ &$article ) {
		if ( $title->getNamespace() == Maps_NS_LAYER ) {
			$article = new MapsLayerPage( $title );
		}
		
		return true;
	}
	
	/**
	 * Adds global JavaScript variables.
	 *
	 * @since 1.0
	 *
	 * @param array &$vars
	 *
	 * @return true
	 */
	public static function onMakeGlobalVariablesScript( array &$vars ) {
		global $egMapsGlobalJSVars;
		
		$vars['egMapsDebugJS'] = $GLOBALS['egMapsDebugJS'];
		
		$vars += $egMapsGlobalJSVars;
		
		return true;
	}
	

	public static function onCanonicalNamespaces( &$list ) {
		$list[Maps_NS_LAYER] = 'Layer';
		$list[Maps_NS_LAYER_TALK] = 'Layer_talk';
		return true;
	}
} 
