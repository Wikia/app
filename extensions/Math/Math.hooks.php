<?php
/**
 * MediaWiki math extension
 *
 * (c) 2002-2011 various MediaWiki contributors
 * GPLv2 license; info in main package.
 */

class MathHooks {
	/**
	 * Set up $wgMathPath and $wgMathDirectory globals if they're not already
	 * set.
	 */
	static function setup() {
		global $wgMathPath, $wgMathDirectory;
		global $wgUploadPath, $wgUploadDirectory;
		if ( $wgMathPath === false ) {
			$wgMathPath = "{$wgUploadPath}/math";
		}
		if ( $wgMathDirectory === false ) {
			$wgMathDirectory = "{$wgUploadDirectory}/math";
		}
	}

	/**
	 * Register the <math> tag with the Parser.
	 *
	 * @param $parser Parser instance of Parser
	 * @return Boolean: true
	 */
	static function onParserFirstCallInit( $parser ) {
		$parser->setHook( 'math', array( 'MathHooks', 'mathTagHook' ) );
		return true;
	}

	/**
	 * Callback function for the <math> parser hook.
	 *
	 * @param $content
	 * @param $attributes
	 * @param $parser Parser
	 * @return
	 */
	static function mathTagHook( $content, $attributes, $parser ) {
		global $wgContLang, $wgUseMathJax;

		// Wikia change - begin - @author: TK-999
		// VOLDEV-59: Fix Math colorization issues across skins
		global $wgTexvcBackgroundColor;
		$skin = RequestContext::getMain()->getSkin();
		if ( SassUtil::isThemeDark() ) {
			$wgTexvcBackgroundColor = 'Transparent'; // set bg to alpha transparency

			// Set fallback text color for non-oasis skins
			if ( $skin->getSkinName() != 'oasis' ) {
				$color = '\definecolor{text}{RGB}{0,0,0}';
				$content = $color . '{\color{text}' . $content . '}';
			}
		}
		// Wikia change - end

		$renderedMath = MathRenderer::renderMath(
			$content, $attributes, $parser->getOptions()
		);
		
		if ( $wgUseMathJax ) {
			self::addMathJax( $parser );
		}
		$output = $renderedMath;

		return $wgContLang->armourMath( $output );
	}

	/**
	 * Add the new math rendering options to Special:Preferences.
	 *
	 * @param $user Object: current User object
	 * @param $defaultPreferences Object: Preferences object
	 * @return Boolean: true
	 */
	static function onGetPreferences( $user, &$defaultPreferences ) {
		$defaultPreferences['math'] = array(
			'type' => 'radio',
			'options' => array_flip( array_map( 'wfMsgHtml', self::getMathNames() ) ),
			'label' => '&#160;',
			'section' => 'rendering/math',
		);
		return true;
	}

	/**
	 * List of message keys for the various math output settings.
	 *
	 * @return array of strings
	 */
	private static function getMathNames() {
		return array(
			MW_MATH_PNG => 'mw_math_png',
			MW_MATH_SOURCE => 'mw_math_source'
		);
	}

	/**
	 * MaintenanceRefreshLinksInit handler; optimize settings for refreshLinks batch job.
	 *
	 * @param Maintenance $maint
	 * @return boolean hook return code
	 */
	static function onMaintenanceRefreshLinksInit( $maint ) {
		global $wgUser;

		# Don't generate TeX PNGs (lack of a sensible current directory causes errors anyway)
		$wgUser->setGlobalPreference( 'math', MW_MATH_SOURCE );

		return true;
	}

	/**
	 * LoadExtensionSchemaUpdates handler; set up math table on install/upgrade.
	 *
	 * @param $updater DatabaseUpdater
	 * @return bool
	 */
	static function onLoadExtensionSchemaUpdates( $updater = null ) {
		if( is_null( $updater ) ) {
			throw new MWException( "Math extension is only necessary in 1.18 or above" );
		}
		$map = array(
			'mysql' => 'math.sql',
			'sqlite' => 'math.sql',
			'postgres' => 'math.pg.sql',
			'oracle' => 'math.oracle.sql',
			'mssql' => 'math.mssql.sql',
			'db2' => 'math.db2.sql',
		);
		$type = $updater->getDB()->getType();
		if ( isset( $map[$type] ) ) {
			$sql = dirname( __FILE__ ) . '/db/' . $map[$type];
			$updater->addExtensionTable( 'math', $sql );
		} else {
			throw new MWException( "Math extension does not currently support $type database." );
		}
		return true;
	}

	/**
	 * Add 'math' table to the list of tables that need to be copied to
	 * temporary tables for parser tests to run.
	 *
	 * @param array $tables
	 * @return bool
	 */
	static function onParserTestTables( &$tables ) {
		$tables[] = 'math';
		return true;
	}

	/**
	 * Hack to fake a default $wgMathPath value so parser test output
	 * that renders to images doesn't vary by who runs it.
	 *
	 * @global string $wgMathPath
	 * @param Parser $parser
	 * @return bool
	 */
	static function onParserTestParser( &$parser ) {
		global $wgMathPath;
		$wgMathPath = '/images/math';
		return true;
	}

	static function addMathJax( $parser ) {
		global $wgMathJaxUrl;
		//$script = Html::element( 'script', array( 'type' => 'text/x-mathjax-config' ), $config );
		$html = Html::element( 'script', array( 'src' => $wgMathJaxUrl ) );

		//$parser->getOutput()->addHeadItem( $html, 'mathjax' );
		$parser->getOutput()->addModules( array( 'ext.math.mathjax.enabler' ) );
	}

	/**
	 * Wikia change
	 * Hook: ThemeDesignerUpdateSettings
	 * Empty cached images if Oasis theme changes to avoid mismatched colors
	 * @author TK-999
	 * @param ThemeSettings $themeSettings
	 * @param array $newSettings
	 * @param int $cityId
	 * @return bool true because it's a hook
	 */
	public static function onUpdateThemeSettings( ThemeSettings $themeSettings, array &$newSettings, $cityId ) {
		global $wgEnableSwiftFileBackend;
		wfProfileIn( __METHOD__ );
		$oldSettings = $themeSettings->getSettings();

		// empty cached images only on dark/light changes
		if ( SassUtil::isThemeDark( $oldSettings ) != SassUtil::isThemeDark( $newSettings ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$fileHashes = $dbr->select( 'math', 'math_outputhash', [], __METHOD__ );

			if ( !$fileHashes ) {
				return true;
			}

			$dummyRenderer = new MathRenderer( '' ); // for file paths
			// try Swift backend
			if ( !empty( $wgEnableSwiftFileBackend ) ) {
				$swift = \Wikia\SwiftStorage::newFromWiki( $cityId );
				foreach ( $fileHashes as $row ) {
					$xhash = unpack( 'H32md5', $dbr->decodeBlob( $row->math_outputhash ) . "                " );
					$dummyRenderer->hash = $xhash[ 'md5' ];
					$remotePath = $dummyRenderer->getSwiftPath();
					$swift->remove( $remotePath );
				}
				wfProfileOut( __METHOD__ );
				return true;
			}

			// NFS fallback if Swift is not available
			wfSuppressWarnings();
			foreach ( $fileHashes as $row ) {
				$xhash = unpack( 'H32md5', $dbr->decodeBlob( $row->math_outputhash ) . "                " );
				$dummyRenderer->hash = $xhash[ 'md5' ];
				$filename = $dummyRenderer->_getHashPath() . "/{$dummyRenderer->hash}.png";

				if ( file_exists( $filename ) ) {
					unlink( $filename );
				}
			}
			wfRestoreWarnings();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}
