<?php

/**
 * Static class for hooks handled by the Maps extension.
 *
 * @since 0.7
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Werner
 */
final class MapsHooks {
	/**
	 * Helper flag indicating whether the page has been purged.
	 * @var bool
	 *
	 * TODO: Figure out a better way to do this, not requiring this flag and make sure it works with
	 *       later MW versions (purging mechanism got changed somewhat around 1.18).
	 */
	static $purgedBeforeStore = false;

	/**
	 * Adds a link to Admin Links page.
	 *
	 * @since 0.7
	 *
	 * @param ALTree $admin_links_tree
	 *
	 * @return boolean
	 */
	public static function addToAdminLinks( ALTree &$admin_links_tree ) {
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
	 * Intercept pages in the Layer namespace to handle them correctly.
	 *
	 * @param $title: Title
	 * @param $article: Article or null
	 *
	 * @return boolean
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
	 * @since 0.7
	 *
	 * @param array $list
	 *
	 * @return boolean
	 */
	public static function onCanonicalNamespaces( array &$list ) {
		$list[Maps_NS_LAYER] = 'Layer';
		$list[Maps_NS_LAYER_TALK] = 'Layer_talk';
		return true;
	}

	/**
	 * This will setup database tables for layer functionality.
	 *
	 * @since 3.0
	 *
	 * @param DatabaseUpdater $updater
	 *
	 * @return true
	 */
	public static function onLoadExtensionSchemaUpdates( DatabaseUpdater $updater ) {
		switch( $GLOBALS['wgDBtype'] ) {
			case 'mysql':
			case 'sqlite':
				$updater->addExtensionTable( 'maps_layers', __DIR__ . '/schema/MapsLayers.sql' );
				break;
			case 'postgres':
				$updater->addExtensionTable( 'maps_layers', __DIR__ . '/schema/MapsLayers-postgres.sql' );
				break;
		}

		return true;
	}

	/**
	 * Make sure layer data will be stored into database when purging the page
	 *
	 * @since 3.0
	 *
	 * @param $article WikiPage|Article (depending on MW version, WikiPage in 1.18+)
	 * @return type
	 */
	public static function onArticlePurge( &$article ) {
		self::$purgedBeforeStore = true;
		return true;
	}

	/**
	 * At the end of article parsing, in case of layer page, save layers to database
	 *
	 * @since 3.0
	 *
	 * @param Parser &$parser
	 * @param string &$text
	 *
	 * @return true
	 */
	public static function onParserAfterTidy( Parser &$parser, &$text ) {

		$title = $parser->getTitle();

		if( $title === null
			|| self::$purgedBeforeStore !== true
		) {
			// just preprocessing some stuff or no purge
			return true;
		}

		self::processLayersStoreCandidate( $parser->getOutput(), $title );

		// Set helper to false immediately so we won't run into job-processing weirdness:
		self::$purgedBeforeStore = false;

		return true;
	}

	/**
	 * After article was edited and parsed, in case of layer page, save layers to database
	 *
	 * @since 3.0
	 *
	 * @param LinksUpdate &$linksUpdate
	 *
	 * @return true
	 */
	public static function onLinksUpdateConstructed( LinksUpdate &$linksUpdate ) {
		$title = $linksUpdate->getTitle();

		self::processLayersStoreCandidate( $linksUpdate->mParserOutput, $title );

		return true;
	}

	/**
	 * Checks whether the parser output has some layer data which should be stored of the
	 * given title and performs the task.
	 *
	 * @since 3.0
	 *
	 * @param ParserOutput $parserOutput
	 * @param Title $title
	 */
	protected static function processLayersStoreCandidate( ParserOutput $parserOutput, Title $title ) {

		// if site which is being parsed is in maps namespace:
		if( $title->getNamespace() === Maps_NS_LAYER ) {

			if( ! isset( $parserOutput->mExtMapsLayers ) ) {
				$parserOutput->mExtMapsLayers = new MapsLayerGroup();
			}

			// get MapsLayerGroup object with layers to be stored:
			$mapsForStore = $parserOutput->mExtMapsLayers;

			// store layers in database (also deletes previous definitions still in db):
			MapsLayers::storeLayers( $mapsForStore, $title );
		}
	}

	/**
	 * If a new parser process is getting started, clear collected layer data of the
	 * previous one.
	 *
	 * @since 3.0
	 *
	 * @param Parser $parser
	 *
	 * @return true
	 */
	public static function onParserClearState( Parser &$parser ) {
		$parser->getOutput()->mExtMapsLayers = null;
		return true;
	}
}

