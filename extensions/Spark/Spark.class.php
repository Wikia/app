<?php

/**
 * Class to render spark tags.
 *
 * @since 0.1
 *
 * @file Spark.class.php
 * @ingroup Spark
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SparkTag {

	/**
	 * List of spark parameters.
	 *
	 * @since 0.1
	 *
	 * @var array
	 */
	protected $parameters;

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 *
	 * @var string or null
	 */
	protected $contents;

	public function __construct( array $args, $contents ) {
		$this->parameters = $this->getSparkParameters( $args );
		$this->contents = $contents;
	}

	/**
	 * Renrder the spark div.
	 *
	 * @since 0.1
	 *
	 * @param Parser $parser
	 *
	 * @return string
	 */
	public function render( Parser $parser, $frame  ) {
		global $wgVersion;
		global $wgOut;
		global $egSparkScriptPath;
		global $wgResourceModules;

		// What is loaded already?
		static $loadedJsses = array();

		wfDebugLog( 'myextension', 'Parameters alright? ' . print_r($this->parameters, true) );
		if ( array_key_exists( egSparkQuery, $this->parameters ) ) {
			$query = htmlspecialchars( $this->parameters[egSparkQuery] );

			// Before that, shall we allow internal parse, at least for the query?
			// We replace variables, templates etc.
			$query = $parser->replaceVariables($query, $frame);
			//$query = $parser->recursiveTagParse( $query );

			// Replace special characters
			$query = str_replace( array( '&lt;', '&gt;' ), array( '<', '>' ), $query );

			unset( $this->parameters[egSparkQuery] );

			// Depending on the format, we possibly need to add modules
			if ( array_key_exists( egSparkFormat, $this->parameters ) ) {
				$format = htmlspecialchars( $this->parameters[egSparkFormat] );
				// Remove everything before "spark.XXX"
				$format = substr($format , strpos($format, "spark."));
				// Remove .js at the end
				$format = str_replace( array( '.js' ), array( '' ), $format );
				$module = 'ext.'.$format;

				// for older versions of MW, different
				if ( version_compare( $wgVersion, '1.17', '<' ) ) {
					if (isset($wgResourceModules) && array_key_exists($module, $wgResourceModules)) {
						// only if not already loaded
						if (!isset($loadedJsses[$module])) {
							// scripts
							foreach ($wgResourceModules[$module]['scripts'] as $script) {
								$wgOut->addScript('<script src="'.$egSparkScriptPath."/".$script.'" type="text/javascript"></script>');
								wfDebugLog( 'spark', "AddScript:".' <script src="'.$egSparkScriptPath."/".$script.'" type="text/javascript"></script>' );
							}

							// css
							foreach ($wgResourceModules[$module]['styles'] as $style) {
								$wgOut->addScript('<link rel="stylesheet" href="'.$egSparkScriptPath."/".$style.'" type="text/css" />');
								wfDebugLog( 'spark', "AddLink:".' <link rel="stylesheet" href="'.$egSparkScriptPath."/".$style.'" type="text/css" />' );
							}
							$loadedJsses[$module] = true;
						} 
					}
				} else {
					// $wgResourceModules might not exist
					if (isset($wgResourceModules) && array_key_exists($module, $wgResourceModules)) {
						// TODO: Do we need to check, whether module has been added already?
						$parser->getOutput()->addModules( $module );
					}
				}
			}

			$html = '<div class="spark" data-spark-query="' . $query . '" ' . Html::expandAttributes( $this->parameters ) . ' >' .
			( is_null( $this->contents ) ? '' : htmlspecialchars( $this->contents ) ) .
					'</div>';

			// In MW 1.17 there seems to be the problem that ? after an empty space is replaced by a non-breaking space (&#160;) Therefore we remove all spaces before ? which should still make the SPARQL query work
			$html = preg_replace( '/[ \t]+(\?)/', '$1', $html );

			// for older versions of MW, different
			if ( version_compare( $wgVersion, '1.17', '<' ) ) {
				$parser->disableCache();
				return $html;
			} else {
				return array( $parser->insertStripItem( $html, $parser->mStripState ), 'noparse' => true, 'isHTML' => true );
			}
		}
		else {
			return Html::element( 'i', array(), wfMsg( 'spark-missing-query' ) );
		}
	}

	/**
	 * Get the spark parameters from a list of key value pairs.
	 *
	 * @since 0.1
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	protected function getSparkParameters( array $args ) {
		$parameters = array();

		// For lower versions of MW, special chars were not allowed in tags, therefore, we simply add them, then.
		foreach ( $args as $name => $value ) {
			if ( strpos( $name, 'data-spark-' ) === 0 ) {
				$parameters[$name] = $value;
			} else {
				$parameters['data-spark-'.$name] = $value;
			}
		}

		return $parameters;
	}

}