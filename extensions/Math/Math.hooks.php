<?php
/**
 * MediaWiki math extension
 *
 * (c) 2002-2012 various MediaWiki contributors
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
	 * @param $content (the LaTeX input)
	 * @param $attributes
	 * @param $parser Parser
	 * @return string
	 */
	static function mathTagHook( $content, $attributes, $parser ) {
		global $wgContLang, $wgUseMathJax;
		if ( trim( $content )  === "" ) { // bug 8372
			return "";
		}
		$mode = $parser->getOptions()->getMath();
		$renderer = MathRenderer::getRenderer(
			$content, $attributes, $mode
		);
		$renderedMath = $renderer->render();
		if ( $wgUseMathJax && $mode == MW_MATH_MATHJAX ) {
			$parser->getOutput()->addModules( array( 'ext.math.mathjax.enabler' ) );
		}
		$renderer->writeCache();
		return $wgContLang->armourMath( $renderedMath );
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
			'options' => array_flip( self::getMathNames() ),
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
		global $wgUseMathJax;
		$names = array(
			MW_MATH_PNG => wfMessage( 'mw_math_png' )->escaped(),
			MW_MATH_SOURCE => wfMessage( 'mw_math_source' )->escaped(),
		);
		if ( $wgUseMathJax ) {
			$names[MW_MATH_MATHJAX] = wfMessage( 'mw_math_mathjax' )->escaped();
		}

		return $names;
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
		$wgUser->setOption( 'math', MW_MATH_SOURCE );
		return true;
	}

	/**
	 * LoadExtensionSchemaUpdates handler; set up math table on install/upgrade.
	 *
	 * @param $updater DatabaseUpdater
	 * @throws MWException
	 * @return bool
	 */
	static function onLoadExtensionSchemaUpdates( $updater = null ) {
		if ( is_null( $updater ) ) {
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

	/**
	 * Links to the unit test files for the test cases.
	 *
	 * @param string $files
	 * @return boolean (true)
	 */
	static function onRegisterUnitTests( &$files ) {
		$testDir = __DIR__ . '/tests/';
		$files = array_merge( $files, glob( "$testDir/*Test.php" ) );
		return true;
	}
}
