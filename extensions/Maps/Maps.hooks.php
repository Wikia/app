<?php

/**
 * Static class for hooks handled by the Maps extension.
 *
 * @since 0.7
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class MapsHooks {

	/**
	 * Adds a link to Admin Links page.
	 *
	 * @since 0.7
	 *
	 * @param ALTree $admin_links_tree
	 *
	 * @return boolean
	 */
	public static function addToAdminLinks( ALTree $admin_links_tree ) {
		$displaying_data_section = $admin_links_tree->getSection( wfMessage( 'smw_adminlinks_displayingdata' )->text() );

		// Escape if SMW hasn't added links.
		if ( is_null( $displaying_data_section ) ) {
			return true;
		}

		$smw_docu_row = $displaying_data_section->getRow( 'smw' );

		$maps_docu_label = wfMessage( 'adminlinks_documentation', 'Maps' )->text();
		$smw_docu_row->addItem( AlItem::newFromExternalLink( 'https://semantic-mediawiki.org/wiki/Maps', $maps_docu_label ) );

		return true;
	}

	/**
	 * Adds global JavaScript variables.
	 *
	 * @since 1.0
	 * @see http://www.mediawiki.org/wiki/Manual:Hooks/MakeGlobalVariablesScript
	 * @param array &$vars Variables to be added into the output
	 * @param OutputPage $outputPage OutputPage instance calling the hook
	 * @return boolean true in all cases
	 */
	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $outputPage ) {
		global $egMapsGlobalJSVars;

		$vars['egMapsDebugJS'] = $GLOBALS['egMapsDebugJS'];
                $vars[ 'egMapsAvailableServices' ] = $GLOBALS['egMapsAvailableServices'];

		$vars += $egMapsGlobalJSVars;

		return true;
	}

	/**
	 * Wikia change
	 * Load library dependencies of display_map in the <body> after article wikitext
	 * Registering them as head items will cause Oasis logic to put them after RL <script> in body
	 * which would break all dependent modules.
	 *
	 * @param OutputPage $out
	 * @param ParserOutput $parserOutput
	 * @return bool
	 */
	public static function onOutputPageParserOutput( OutputPage $out, ParserOutput $parserOutput ) {
		if ( !isset( $parserOutput->mapsMappingServices ) ) {
			return true;
		}

		/** @var MapsMappingService $mapsMappingService */
		foreach ( $parserOutput->mapsMappingServices as $mapsMappingService ) {
			$html = $mapsMappingService->getDependencyHtml();

			$out->addHTML( $html );
		}

		return true;
	}
}
