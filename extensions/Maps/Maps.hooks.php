<?php

/**
 * Static class for hooks handled by the Maps extension.
 * 
 * @since 0.7
 * 
 * @file Maps.hooks.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
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
	
	    $maps_docu_label = wfMsg( 'adminlinks_documentation', wfMsg( 'maps_name' ) );
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
		//$files[] = $testDir . 'MapsCoordinateParserTest.php';
		return true;
	}
	
	/**
	 * Adds the map JS to the bottom of the page. This is a hack to get
	 * around the lack of inline script support in the MW 1.17 resource loader.
	 * 
	 * @since 0.7
	 */
	public static function addOnloadFunction( $skin, &$text ) {
		if ( method_exists( 'ParserOutput', 'addModules' ) ) {
			$text .= Html::inlineScript( 'if (window.runMapsOnloadHook) runMapsOnloadHook();' );
		}
		
		return true;
	}

	/**
	 * Register the resource modules for the resource loader.
	 * 
	 * @since 0.7
	 * 
	 * @param ResourceLoader $resourceLoader
	 * 
	 * @return true
	 */
	public static function registerResourceLoaderModules( ResourceLoader &$resourceLoader ) {
		global $egMapsScriptPath;
		/*
		$modules = array(
			'ext.maps.common' => array(
			
			),
		);
		
		foreach ( $modules as $name => $resources ) { 
			$resourceLoader->register( $name, new ResourceLoaderFileModule(
				$resources,
				dirname( __FILE__ ),
				$egMapsScriptPath'
			) ); 
		}
		*/
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
	
} 
